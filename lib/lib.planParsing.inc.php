<?php
include_once(PATH_LIB.'/lib.snoopy.inc.php');
include_once(PATH_LIB.'/lib.htmlDOM.inc.php');
include_once(PATH_LIB.'/lib.parsing.inc.php');

function calcPlanPrice($facPrice, $support, $addSupport, $vendor='S', $i=0) {
	global $cfg;
	$output['buyPrice'] = $facPrice - $support - $addSupport;
	$output['devicePricePerMon'] = round($output['buyPrice'] / 24);
	$output['basicPrice'] = $cfg['basicPrice'][$vendor][$i] + ($cfg['basicPrice'][$vendor][$i] * VAT);
	$output['pricePerMon'] = $output['devicePricePerMon'] + $output['basicPrice'];
	return $output;
}

class planParsing{
	private $manuf = '';
	private $mode = '';
	private $page = '';
	private $plan = '';
	private $carrier = '';
	private $arrData = array();
	private $arrTitle = array();
	private $isHTMLChanged = FALSE;

	private $deviceInfo = NULL;

	//테이블 구조가 바뀌었는지 확인 하기 위함
	private $arrColumnName = array(
											'sk' => array(
												1 => '단말기',
												2 => '모델명',
												4 => '출고가',
												5 => '지원금',
												6 => '추가지원금'
											),
											'kt' => array(
												1 => '단말기',
												2 => '모델명',
												3 => '출고가',
												4 => '공시지원금',
												5 => '추가지원금'
											)
										);
	private $arrParsingIndex = array(
													'sk'=>array(
														'device' => 1,
														'model' => 2,
														'retailPrice' => 4,
														'support' => 5,
														'addSupport' => 6,
														'date' => 9
													),
													'kt'=>array(
														'device' => 1,
														'device' => 2,
														'retailPrice' => 3,
														'support' => 4,
														'addSupport' => 5,
														'date' => 7
													),
													'lg'=>array()
												);


	//private $arrVendor = array('S'=>'SKT', 'K'=>'KT', 'L'=>'LG U+', 'C'=>'CJ');
	private $arrManuf = array(
										'sk' => array(
											'samsung'=>'', 
											'lg'=>'', 
											'apple'=>'Apple'
										),
										'kt' => array(
											'samsung'=>13, 
											'lg'=>07, 
											'apple'=>15,
											'etc'=>99
										)
									);

	private $targetURL = '';
	private $arrTargetCarrierURL = array('sk'=>'http://shop.tworld.co.kr/handler/Dantong-SKT',
															'kt'=>'http://shop.olleh.com/smart/supportAmtList.json',
															'lguplus'=>'https://www.uplus.co.kr/sqr/prdt/post/RetriveProdDiscountPostList.hpi'
														);
	private $urlETCListForKT = 'http://shop.olleh.com/smart/supportAmtList.do';
	private $urlETCForKT = 'http://shop.olleh.com/smart/supportWearableAmt.json';

	private $rexTable = '/<div class="board_list2 tbl_pa">([\s\S]*?)<\/table>[\s\S]*?<\/div>/';
	private $rexTitle = '/<thead>([\s\S]*?)<\/thead>/i';
	private $rexCapacity = '/(16g|32g|64g|128g|256g)b?/i';
	private $rexTemplateETCListForKT = '/<tr prodtype="ETC" trpplcd="(.*)" hndsetmodelid="(.*)" spnsrtypecd="(.*)".*>[\s\S]*?<td class="name">(.*)<\/td>[\s\S]*?<\/tr>/';

	private $arrRexTable = array(
											'sk'=>'/<table border="1" style="display:none"[\s\S]*?>([\s\S]*?)<\/table>/i',
											'lguplus'=>'/<div class="section table_molaw">([\s\S]*?)<\/table>[\s\S]*?<\/div>/'
										);
	private $arrRexColumn = array(
											'sk'=>'/<thead>[\s\S]*?<tr>([\s\S]*?)<tr>[\s\S]*?<\/thead>/i',
											'lguplus'=>'/<div class="section table_molaw">([\s\S]*?)<\/table>[\s\S]*?<\/div>/'
										);
	private $arrCarrierPostSubmitVal = array(
																'sk'=>array(
																	'ORDER_FIELD'			=> 'ORDER_SEQ',
																	'ORDER_TYPE'			=>'ASC',
																	'MODEL_NW_TYPE'	=>'',
																	'LIST_COUNT'			=>100,
																	'TAB_PROD_ID'			=>'',
																	'CHG_PROD_ID'		=>'',
																	'PROD_ID'					=>'NA00004776',
																	'PROD_TYPE'				=>'BASIC',
																	'COMPANY_NM'			=>'',
																	'PROD_GRP_ID'		=>''
																),
																'kt'=>array(
																	'prodNm'		=>'',
																	'prdcCd'		=>'',
																	'prodType'	=>'',
																	'makrCd'		=>'',
																	'sortProd'		=>'HOT',
																	'searchNm'	=>'',
																	'pageNo'		=>1
																),
																'lguplus'=>array()
															);
	private $arrPhonePlanName = array();
	private $arrKidsPlanName = array();
	private $arrWatchPlanName = array();
	private $arrPocketfiPlanName = array();
	private $arrPlan = array();

	public static function setCarrier($carrier) {
		return new planParsing($carrier);
	}

	public function __construct($carrier){
		$this->carrier = $carrier;
		$this->isHTMLChanged = false;

		$this->arrManuf['sk']['samsung'] = iconv("UTF-8", "EUC-KR", '삼성전자(주)');
		$this->arrManuf['sk']['lg'] = iconv("UTF-8", "EUC-KR", 'LG전자(주)');
		$this->arrCarrierPostSubmitVal['sk']['COMPANY_NM'] = '';
		$this->arrCarrierPostSubmitVal['kt']['makrCd'] = '';
		$this->deviceInfo = new deviceInfo();
		return $this;
	}

	public function setMode($mode) {
		$this->mode = $mode;
		switch($mode) {
			case 'phone':
				//sk
				$this->arrCarrierPostSubmitVal['sk']['MODEL_NW_TYPE'] = 'LTE';
				$this->arrCarrierPostSubmitVal['sk']['CHG_PROD_ID'] =  'LTE';
				//kt
				$this->arrCarrierPostSubmitVal['kt']['prodNm'] = 'mobile';
				$this->arrCarrierPostSubmitVal['kt']['prodType'] =  15;
				break;
			case 'watch':
				//sk
				$this->arrCarrierPostSubmitVal['sk']['MODEL_NW_TYPE'] = '3G';
				$this->arrCarrierPostSubmitVal['sk']['CHG_PROD_ID'] =  '3G';
				//kt
				$this->arrCarrierPostSubmitVal['kt']['prodNm'] = '';
				$this->arrCarrierPostSubmitVal['kt']['prodType'] = 'ETC';
				break;
			case 'kids':
				//sk
				$this->arrCarrierPostSubmitVal['sk']['MODEL_NW_TYPE'] = 'ETC';
				$this->arrCarrierPostSubmitVal['sk']['CHG_PROD_ID'] =  'ETC';
				//kt
				$this->arrCarrierPostSubmitVal['kt']['prodNm'] = '';
				$this->arrCarrierPostSubmitVal['kt']['prodType'] = 'ETC';
				break;
			case 'portableWifi': 
			case 'pocketfi': 
				//sk
				$this->arrCarrierPostSubmitVal['sk']['MODEL_NW_TYPE'] = 'ETC';
				$this->arrCarrierPostSubmitVal['sk']['CHG_PROD_ID'] =  'ETC';
				//kt
				$this->arrCarrierPostSubmitVal['kt']['prodNm'] = 'egg';
				$this->arrCarrierPostSubmitVal['kt']['prodType'] = 19;
				break;
		}
		return $this;
	}
	
	public function setManuf($manuf){
		$this->manuf = $manuf;
		$manufValue = $this->arrManuf[$this->carrier][$manuf];
		$this->arrCarrierPostSubmitVal['sk']['COMPANY_NM'] = $manufValue;
		$this->arrCarrierPostSubmitVal['kt']['makrCd'] = $manufValue;
		return $this;
	}
	
	public function getArrPlan(){
		return $this->deviceInfo->setCarrier($this->carrier)->setMode($this->mode)->getArrPlanBasedCategory();
	}

	public function setPlan($input){
		$this->plan = $input;
		$planValue = $this->deviceInfo->arrPlan[$this->carrier][$this->mode][$input]['value'];
		$this->arrCarrierPostSubmitVal['sk']['PROD_ID'] = $planValue;
		$this->arrCarrierPostSubmitVal['kt']['prdcCd'] = $planValue;
		return $this;
	}

	public function getPage() {
		$targetURL = $this->arrTargetCarrierURL[$this->carrier];
		if($this->carrier === 'kt' && $this->arrCarrierPostSubmitVal['kt']['prodType'] === 'ETC')
			$targetURL = $this->urlETCListForKT;
		$targetDomain = parse_url($targetURL);
		
		$data = new snoopy;
		$data->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
		$data->referer = $targetDomain['host'];
		$data->fetch($targetURL.'?'.http_build_query($this->arrCarrierPostSubmitVal[$this->carrier]));
		if($this->carrier === 'sk') {
			$this->page = iconv("EUC-KR", "UTF-8", removeTabLinebreak($data->results));
		}else if($this->arrCarrierPostSubmitVal['kt']['prodType'] !== 'ETC' && $this->carrier === 'kt') { 
			// 기타단말기가 아닐때
			$result = jsonToArray($data->results);
			$max = $result['pageInfoBean']['totalPageCount'];
			$this->page = $result['LIST_DATA'];
			for($i=2;$i<=$max;$i++){
				$this->arrCarrierPostSubmitVal['kt']['pageNo'] = $i;
				$data->fetch($targetURL.'?'.http_build_query($this->arrCarrierPostSubmitVal[$this->carrier]));
				$result = jsonToArray($data->results);
				$this->page = array_merge($this->page, $result['LIST_DATA']);
			}
		}else if($this->arrCarrierPostSubmitVal['kt']['prodType'] === 'ETC' && $this->carrier === 'kt'){	
			//기타 단말기 일때
			$this->page = $this->getETCSupportForKT($data->results);
		}
		return $this;
	}

	private function getTable() {
		//KT이고 기타단말기일때 패스
		if($this->carrier === 'kt') return $this;

		$result = getRexMatch($this->page, $this->arrRexTable[$this->carrier]); 
		//var_dump(clean_html($result));
		if (is_array($result))
			$this->page = $result[0];
		else
			$this->page = $result;

		return $this;
	}

	private function getCont() {
		if($this->carrier === 'sk') {
			//tbody 부분을 얻기위해 tbody 태그 기준으로 explode
			$this->page = explode('<tbody>', $this->page);
			$this->getTitle($this->page[0]);
			//각 기기의 정보를 얻기위해 tr태그 기준으로 explode
			$rows = preg_split('#</tr>#i', $this->page[1]);
		} else if($this->carrier === 'kt')
			$rows = $this->page;

		foreach ($rows as $key => $row) {
			if($this->carrier === 'sk') {
				$row = strtolower($row);
				$row = $this->stripTags(preg_split('#</td>#i', $row)); //td태그를 기준으로 배열로
				if(isNotExist($row[0])) continue;

				$row['deviceName'] = $row[$this->arrParsingIndex[$this->carrier]['device']];			

				$dvTit 				= trim($this->convert2name($row['deviceName']));
				$capacity 			= $this->getCapacity($row['deviceName']);
				$dvCommonId 				= $this->convert2id($row['deviceName']);
				if($this->manuf === 'apple'){
					$commonModel 	= $dvCommonId;
				} else {
					$commonModel 	= $row[$this->arrParsingIndex[$this->carrier]['model']];
					$commonModel 	= $this->getModelCode(preg_replace('/_(16g|32g|64g|128g|256g).?/i', '', $commonModel));
				}
				if($capacity !== false)
					$model			= $commonModel.'_'.$capacity;
				else
					$model			= $commonModel;

				$deviceName 		= $row['deviceName'];
				$icon 				= $this->getIconClass($row['deviceName']);
				$dvRetailPrice 		= getNumOnly($row[$this->arrParsingIndex[$this->carrier]['retailPrice']]); 
				$spSupport 			= getNumOnly($row[$this->arrParsingIndex[$this->carrier]['support']]);
				$spAddSupport 		= getNumOnly($row[$this->arrParsingIndex[$this->carrier]['addSupport']]);
				$spDate 			= $row[$this->arrParsingIndex[$this->carrier]['date']];

			} else	if($this->carrier === 'kt') {
				if(isNotExist($row['storSuprtAmt'])) continue;

				$prodNm 			= $row['prodNm'];
				$dvTit 				= $this->convert2name($row['prodNm']);
				$dvCommonId 		= $this->convert2id($row['prodNm']);
				$capacity 			= $this->getCapacity($row['prodNm']);
				if($this->manuf === 'apple'){
					$commonModel 	= preg_replace('/\(.*?\)/', '', $dvCommonId);
				} else {
					$commonModel 	= $this->getModelCode($row['hndsetModelNm']);
				}
				if($capacity !== false && $this->manuf !== 'apple') {
					if(isNotExist($parentModel[$dvCommonId]))
						$parentModel[$dvCommonId] = $commonModel;

					//모델명이 더 길이가 짧으면 해당 기기의 모델명은 용량/색 상관없이 해당 모델명으로 통일
					if(mb_strlen($parentModel[$dvCommonId]) > mb_strlen($commonModel)) 
						$parentModel[$dvCommonId] = $commonModel;
				}
				if($capacity !== false)
					$model			= $commonModel.'_'.$capacity;
				else
					$model			= $commonModel;

				$deviceName 		= $row['prodNm'];
				$icon 				= $this->getIconClass($row['prodNm']);
				$dvRetailPrice 		= $row['ofwAmt']; 
				$spSupport 			= $row['mobilCmpnSuprtAmt'];
				if(($dvRetailPrice - $spSupport - $row['storSuprtAmt']) <= 0)
					$spAddSupport 	= $row['storSuprtAmt'] + ($dvRetailPrice - $spSupport - $row['storSuprtAmt']);
				else
					$spAddSupport 	= $row['storSuprtAmt'];
				$spDate 			= convertDateFormat('Y-m-d', getNumOnly($row['spnsrPunoDate']));
			}

			if(isContain('re_iphone', $deviceName) || isContain('_demo', $deviceName) || $dvCommonId === 't로그인')	continue;
			$deviceRow[$key]['prodNm']			= strtoupper($prodNm);
			$deviceRow[$key]['dvTit'] 			= strtoupper($dvTit);
			$deviceRow[$key]['capacity']		= strtoupper($capacity);
			$deviceRow[$key]['commonModel']		= strtoupper($commonModel);
			$deviceRow[$key]['model']			= strtoupper($model);
			$deviceRow[$key]['dvCommonId'] 		= $dvCommonId;
			$deviceRow[$key]['dvId'] 			= $dvCommonId.strtolower($capacity);
			$deviceRow[$key]['deviceName'] 		= $deviceName;
			$deviceRow[$key]['icon'] 			= $icon;
			$deviceRow[$key]['dvRetailPrice'] 	= $dvRetailPrice; 
			$deviceRow[$key]['spSupport'] 		= $spSupport;
			$deviceRow[$key]['spAddSupport'] 	= $spAddSupport;
			$deviceRow[$key]['spDate'] 			= $spDate;
			
			if ($this->mode == 'pocketfi'){
				if(isContain('pocketfi', $deviceRow[$key]['deviceName']) === false)
					unset($row[$key]);
			}
		}

		//동일 기종은 동일한 모델명 같게 
		foreach($deviceRow as $key => $val) {

			if(isExist($parentModel[$val['dvCommonId']]) === TRUE) {
				$deviceRow[$key]['commonModel'] = $parentModel[$val['dvCommonId']];//.'_'.$val['capacity'];
				$deviceRow[$key]['model'] 		= $deviceRow[$key]['commonModel'].'_'.strtolower($val['capacity']);
			}
			/*
			if ($this->carrier === 'sk' && isExist($val['capacity']) === TRUE)
				$deviceRow[$key]['model'] = $val['model'].'_'.$val['capacity'];
			*/
		}
		$this->arrData = $deviceRow;
		echo '<pre>';
		var_dump($deviceRow);
		echo '</pre>';
		return $this;
	}

	public function getDataAndInsert(){
		//$this->getPage();
		if($this->isHTMLChanged === true)
			return $this;

		$arrPlan = $this->getArrPlan();
		foreach($arrPlan as $key => $val){
			$this->setPlan($val)->getPage()->getTable()->getCont()->checkHTMLChanged()->insertUpdate();
		}
		return $this;
	}

	public function insertUpdate() {
		//html구조가 바뀌었으면 업데이트 중지
		if($this->isHTMLChanged === true)
			return false;
		
		//파싱해온 정보가 담긴 배열
		foreach($this->arrData as $row) {
			/*
			$deviceIndex = $this->arrParsingIndex[$this->carrier]['device'];
			if (!$row[$deviceIndex]) continue;
			$fullDeviceName = $row['dvId'].$row['capacity'];
			*/
			$parentKey = 0;
			$currentCarrierField = 'dv'.strtoupper($this->carrier);

			//해당열이 용량이 존재하여 부모가 필요한 기기인지 확인
			if (isExist($row['capacity'])) $isRequireParent = true;

			//하위 16g 32g 같은 용량 분류가 있을때
			if ($isRequireParent === true) {
				$parentKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvModelCode = %s AND dvParent = 0", $row['commonModel']);
				if (isNotExist($parentKey) === true) {
					DB::insert('tmDevice', array(
						'dvId' => $row['dvCommonId'],
						'dvParent' => 0,
						'dvTit' => $row['dvTit'],
						'dvModelCode' => $row['commonModel'],
						'dvManuf' => $this->manuf,
						'dvRetailPrice' => $row['dvRetailPrice'],
						'dvIcon' => $row['icon'],
						'dvDisplay' => 0,
						$currentCarrierField => 1
					));
					//var_dump($row['dvTit'].$row['capacity'].'왜실행되냐'.$parentKey);
					$parentKey = DB::insertId();
				}

				$row['dvTit'] = $row['capacity'];
			}
			
			$dvKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvModelCode = %s", $row['model']);
			if (isNotExist($dvKey) === true) {
				DB::insert('tmDevice', array(
					'dvId'				=> $row['dvId'],
					'dvParent'			=> $parentKey,
					'dvTit'				=> $row['dvTit'],
					'dvModelCode'		=> $row['model'],
					'dvManuf'			=> $this->manuf,
					'dvIcon'			=> $row['icon'],
					'dvRetailPrice'		=> $row['dvRetailPrice'],
					'dvDisplay'			=> 0,
					$currentCarrierField=> 1
				));
				$dvKey = DB::insertId();
			}

			DB::update('tmDevice',
				array(
					'dvRetailPrice'			=> $row['dvRetailPrice'],
					$currentCarrierField 	=> 1
				), 'dvModelCode = %s', $row['model']
			);

			DB::update('tmDevice',
				array($currentCarrierField=>1), 
				'dvModelCode = %s', $row['commonModel']
			);
			
			$isNotUpdated = DB::queryFirstField("SELECT COUNT(*) FROM tmSupport WHERE spCarrier = %s_spCarrier and spPlan = %i_spPlan and dvKey=%i_dvKey and spDate = %t_spDate", 
				array(
					'spPlan' => $this->plan, 
					'spCarrier' => $this->carrier,
					'dvKey' => $dvKey, 
					'spDate' => $row['spDate']
				)
			);
			if($isNotUpdated == 0) {
				DB::insert('tmSupport', array(
					'dvKey' => $dvKey,
					'spPlan' => $this->plan,
					'spCarrier' => $this->carrier,
					'spSupport' => $row['spSupport'],
					'spAddSupport' => $row['spAddSupport'],
					'spDate' => $row['spDate'],
				));
			}
		}
	}

	//기타기기 (스마트워치, 키즈폰 등) 필요한 정보를 파싱후 json을 또 파싱함
	private function getETCSupportForKT($input) {
		$data = new snoopy;
		$data->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
		$data->referer = $this->urlETCForKT;

		$html = str_get_html($input);
		foreach($html->find('div#hiddenProd tr[trpplcd='.$this->arrCarrierPostSubmitVal['kt']['prdcCd'].']') as $element) {
			$this->arrCarrierPostSubmitVal['kt']['hndsetModelId'] = $element->hndsetmodelid;
			$this->arrCarrierPostSubmitVal['kt']['spnsrTypeCd'] = $element->spnsrtypecd;
			$data->fetch($this->urlETCForKT.'?'.http_build_query($this->arrCarrierPostSubmitVal['kt']));
			$listData = jsonToArray($data->results);
			if(isNotExist($listData['wearableAmt']))
				continue;
			$listData['wearableAmt']['prodNm'] = $this->stripTags($element->find('td.name',0)->outertext);
			$listData['wearableAmt']['hndsetModelNm'] = $this->stripTags($element->find('td.name',0)->next_sibling()->outertext);
			$output[] = $listData['wearableAmt'];
		}
		return $output;
	}

	private function getTitle($page) {
		$page = getRexMatch($page, $this->arrRexColumn[$this->carrier]);
		$rows = explode('|||', $this->stripTags(str_replace('</th>', '|||', $page)));
		$this->arrTitle = $rows;
		//var_dump($rows);
		return $this;
	}

	private function getModelCode($input) {
		//모델명에 <br/>가 포함된건 배열로 나눠서 가장 길이가 짧은걸 가져옴
		if(isContain('<br\/>', $input) === true) {
			$tmp = explode('<br/>', $input);
			$min = $tmp[getFirstArrayKey($tmp)];
			foreach($tmp as $val) {
				if(mb_strlen($min) > mb_strlen($val))
					$min = $val;
			}
			$input = $min;
		}

		//모델명 끝에있는 통신사 알파벳을 삭제함
		switch($this->carrier) {
			case 'sk':
				$carrierPrefix = 'S';
				break;
			case 'kt':
				$carrierPrefix = 'K';
				break;
			case 'lg':
				$carrierPrefix = 'L';
				break;
		}
		return preg_replace('/'.$carrierPrefix.'$/i', '', $input);
		//return $input;
		//모델명에서 용량제거
		//$output = preg_replace('/_(16G|32G|64G|128G)[A-Z]?$/i','',$input);
	}

	private function checkHTMLChanged(){
		if($this->carrier === 'kt') return $this;

		foreach($this->arrColumnName[$this->carrier] as $key => $val) {
			if(isContain($val, $this->arrTitle[$key]) === false) {
				$this->isHTMLChanged = true;
				return $this;
			}
		}
		$this->isHTMLChanged = false;
		return $this;
	}

	private function getIconClass($input) {
		if (isContain('galaxy', $input)) 
			$output = 'galaxy';
		if (isContain('iphone', $input)) 
			$output = 'iphone';
		if (isContain('iphonese', $input)) 
			$output = 'iphone-se';
		if (isContain('iphone', $input) && isContain('plus', $input)) 
			$output = 'iphone-plus';
		if (isContain('note', $input)) 
			$output = 'note';
		if (isContain('gear', $input)) 
			$output = 'gear';
		if (isContain('pocketfi', $input)) 
			$output = 'portable-wifi';
		if (isContain('lg', $input)) 
			$output = 'lg';
		if ($output == false)
			$output = 'galaxy';

		return $output;
	}
	private function convert2name($input) {
		$input = str_replace('watch','워치',$input);
		$input = str_replace('gear','기어',$input);
		$input = str_replace('retina','레티나',$input);
		$input = str_replace('ipad','아이패드',$input);
		$input = str_replace('iphone','아이폰',$input);
		$input = str_replace('edge','엣지',$input);
		$input = str_replace('galaxy','갤럭시',$input);
		$input = str_replace('note','노트',$input);
		$input = str_replace('folder','폴더',$input);
		$input = str_replace('grand','그랜드',$input);
		$input = str_replace('max','맥스',$input);
		$input = str_replace('plus','플러스',$input);
		$input = str_replace('+','플러스',$input);
		$input = preg_replace($this->rexCapacity, '', $input);
		$input = preg_replace('/(_)/',' ',$input);
		return $input;
	}

	private function convert2id($input) {
		$input = strtolower($input);
		$input = str_replace('어베인','urbane',$input);
		$input = str_replace('와치','watch',$input);
		$input = str_replace('클래식','classic',$input);
		$input = str_replace('기어','gear',$input);
		$input = str_replace('아이패드','ipad',$input);
		$input = str_replace('포켓파이','pocketfi',$input);
		$input = str_replace('아이폰','iphone',$input);
		$input = str_replace('엣지','edge',$input);
		$input = str_replace('갤럭시','galaxy',$input);
		$input = str_replace('노트','note',$input);
		$input = str_replace('폴더','folder',$input);
		$input = str_replace('그랜드','grand',$input);
		$input = str_replace('맥스','max',$input);
		$input = str_replace('플러스','plus',$input);
		$input = str_replace('와이드','wide',$input);
		$input = str_replace('+','plus',$input);
		$input = preg_replace($this->rexCapacity, '', $input);
		$input = preg_replace('/(디스플레이|-| |_)/','',$input);
		return $input;
	}
	private function getCapacity($input) {
		$output = getRexMatch($input, $this->rexCapacity);
		if($output === false)
			return false;
		if (preg_match($this->rexCapacity, $output)) 
			return $output;			
		return false;
		
	}
	/*
	private function chkTitleIndex($page) {
		foreach($this->arrTitle as $key => $value) {
			if (isContain('출고가', $value)) {
				if ($key == !retailPriceIndex
			}
		}
		return $this;
	}
	*/

	public function stripTags($arr) {
		if(is_array($arr)){
			$i=0;
			foreach ($arr as $key => $val) {
				if(!isNullVal($val)) {
					$tmp[$key] = trim(preg_replace("(\<(/?[^\>]+)\>)", "", $val));
				}
				if(!isNullVal($tmp[$key])) {
					$output[$i] = $tmp[$key];

					$i++;
				}
			}
		} else
			$output = preg_replace("(\<(/?[^\>]+)\>)", "", $arr);

		return $output;
	}
}