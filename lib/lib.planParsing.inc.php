<?php
function calcPlanPrice($facPrice, $support, $addSupport, $vendor='S', $i=0) {
	global $cfg;
	$output['buyPrice'] = $facPrice - $support - $addSupport;
	$output['devicePricePerMon'] = round($output['buyPrice'] / 24);
	$output['basicPrice'] = $cfg['basicPrice'][$vendor][$i] + ($cfg['basicPrice'][$vendor][$i] * VAT);
	$output['pricePerMon'] = $output['devicePricePerMon'] + $output['basicPrice'];
	return $output;
}

class parseSupportPrice{
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

	private $rexTable = '/<div class="board_list2 tbl_pa">([\s\S]*?)<\/table>[\s\S]*?<\/div>/';
	private $rexTitle = '/<thead>([\s\S]*?)<\/thead>/i';
	private $rexCapacity = '/(16g|32g|64g|128g)/';

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

	public function __construct(){
		$this->arrManuf['sk']['samsung'] = iconv("UTF-8", "EUC-KR", '삼성전자(주)');
		$this->arrManuf['sk']['lg'] = iconv("UTF-8", "EUC-KR", 'LG전자(주)');
		$this->deviceInfo = new deviceInfo();
	}

	public function setCarrier($input) {
		$this->carrier = $input;
		$this->isHTMLChanged = false;
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
				$this->arrCarrierPostSubmitVal['kt']['prodNm'] = 'mobile';
				$this->arrCarrierPostSubmitVal['kt']['prodType'] =  15;
				break;
			case 'pocketfi': 
			case 'kids':
				//sk
				$this->arrCarrierPostSubmitVal['sk']['MODEL_NW_TYPE'] = 'ETC';
				$this->arrCarrierPostSubmitVal['sk']['CHG_PROD_ID'] =  'ETC';
				//kt
				$this->arrCarrierPostSubmitVal['kt']['prodNm'] = 'mobile';
				$this->arrCarrierPostSubmitVal['kt']['prodType'] =  15;
				break;
		}
		return $this;
	}
	
	public function setManuf($manuf){
		$this->manuf = $manuf;
		$this->arrCarrierPostSubmitVal['sk']['COMPANY_NM'] = $this->arrManuf[$this->carrier][$manuf];
		return $this;
	}
	
	public function getArrPlan(){
		return $this->deviceInfo->setCarrier($this->carrier)->setMode($this->mode)->getArrPlan();
	}

	public function setPlan($input){
		$this->plan = $input;
		$this->arrCarrierPostSubmitVal[$this->carrier]['PROD_ID'] = $this->deviceInfo->arrPlan[$this->carrier][$this->mode][$input]['value'];
		return $this;
	}

	public function getPage() {
		$targetDomain = parse_url($this->arrTargetCarrierURL[$this->carrier]);
		$data = new snoopy;
		$data->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
		$data->referer = $targetDomain['host'];
		$data->fetch($this->arrTargetCarrierURL[$this->carrier].'?'.http_build_query($this->arrCarrierPostSubmitVal[$this->carrier]));
		if($this->carrier === 'sk')
			$this->page = iconv("EUC-KR", "UTF-8", removeTabLinebreak($data->results));
		else if($this->carrier === 'kt')
			$this->page = json_decode($data->results);

		return $this;
	}

	private function getTable() {
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
			$this->getContSK();
		} else if($this->carrier === 'kt') {
			
		}
		return $this;
	}

	private function getContSK(){
		$this->page = explode('<tbody>', $this->page);
		//echo clean_html($this->page[0]);
		$this->getTitle($this->page[0]);
		$rows = preg_split('#</tr>#i', $this->page[1]);
		foreach ($rows as $key => $row) {
			$row = strtolower($row);
			$tmpRow = $this->stripTags(preg_split('#</td>#i', $row)); //td태그를 기준으로 배열로

			if(isNotExist($tmpRow[0]))
				continue;

			$tmpRow['deviceName'] = $tmpRow[$this->arrParsingIndex[$this->carrier]['device']];			
			$tmpRow['capacity'] = $this->getCapacity($tmpRow['deviceName']);

			if($tmpRow['capacity'] !== false)
				$deviceRow[$key]['capacity'] = $tmpRow['capacity'];

			$deviceRow[$key]['dvTit'] = strtoupper($this->convert2name($tmpRow['deviceName']));
			$deviceRow[$key]['dvId'] = $this->convert2id($tmpRow['deviceName']);
			$deviceRow[$key]['deviceName'] = $tmpRow['deviceName'];
			$deviceRow[$key]['icon'] = $this->getIconClass($tmpRow['deviceName']);
			$deviceRow[$key]['dvRetailPrice'] = getNumOnly(
																		$tmpRow[$this->arrParsingIndex[$this->carrier]['retailPrice']]
																	); 
			$deviceRow[$key]['spSupport'] =  getNumOnly(
																		$tmpRow[$this->arrParsingIndex[$this->carrier]['support']]
																	);
			$deviceRow[$key]['spAddSupport'] =  getNumOnly(
																			$tmpRow[$this->arrParsingIndex[$this->carrier]['addSupport']]
																		);

			$deviceRow[$key]['spDate'] = $tmpRow[$this->arrParsingIndex[$this->carrier]['date']];
			
			if ($this->mode == 'pocketfi'){
				if(isContain('pocketfi', $deviceRow[$key]['deviceName']) === false)
					unset($tmpRow[$key]);
			}
		}
		$this->arrData = $deviceRow;
		echo '<pre>';
		print_r($deviceRow);
		echo '</pre>';
	}

	private function getContKT(){
		$this->page = explode('<tbody>', $this->page);
		//echo clean_html($this->page[0]);
		$this->getTitle($this->page[0]);
		$rows = preg_split('#</tr>#i', $this->page[1]);
		foreach ($rows as $key => $row) {
			$row = strtolower($row);
			$tmpRow = $this->stripTags(preg_split('#</td>#i', $row)); //td태그를 기준으로 배열로

			if(isNotExist($tmpRow[0]))
				continue;

			$tmpRow['deviceName'] = $tmpRow[$this->arrParsingIndex[$this->carrier]['device']];			
			$tmpRow['capacity'] = $this->getCapacity($tmpRow['deviceName']);

			if($tmpRow['capacity'] !== false)
				$deviceRow[$key]['capacity'] = $tmpRow['capacity'];

			$deviceRow[$key]['dvTit'] = strtoupper($this->convert2name($tmpRow['deviceName']));
			$deviceRow[$key]['dvId'] = $this->convert2id($tmpRow['deviceName']);
			$deviceRow[$key]['deviceName'] = $tmpRow['deviceName'];
			$deviceRow[$key]['icon'] = $this->getIconClass($tmpRow['deviceName']);
			$deviceRow[$key]['dvRetailPrice'] = getNumOnly(
																		$tmpRow[$this->arrParsingIndex[$this->carrier]['retailPrice']]
																	); 
			$deviceRow[$key]['spSupport'] =  getNumOnly(
																		$tmpRow[$this->arrParsingIndex[$this->carrier]['support']]
																	);
			$deviceRow[$key]['spAddSupport'] =  getNumOnly(
																			$tmpRow[$this->arrParsingIndex[$this->carrier]['addSupport']]
																		);

			$deviceRow[$key]['spDate'] = $tmpRow[$this->arrParsingIndex[$this->carrier]['date']];
			
			if ($this->mode == 'pocketfi'){
				if(isContain('pocketfi', $deviceRow[$key]['deviceName']) === false)
					unset($tmpRow[$key]);
			}
		}
		$this->arrData = $deviceRow;
		echo '<pre>';
		print_r($deviceRow);
		echo '</pre>';
	}

	public function getDataAndInsert(){
		//$this->getPage();
		if($this->isHTMLChanged === true)
			return $this;

		$arrPlan = $this->getArrPlan();
		foreach($arrPlan as $key => $val){
			$this->setPlan($val)->getPage()->getTable()->getCont()->checkHTMLChanged();//->insertUpdate();
		}
		return $this;
	}

	public function insertUpdate() {
		$deviceIndex = $this->arrParsingIndex[$this->carrier]['device'];

		if($this->isHTMLChanged === true)
			return false;
		
		foreach($this->arrData as $row) {
			if (!$row[$deviceIndex]) continue;
			$fullDeviceName = $row['dvId'].$row['capacity'];
			$parentKey = 0;

			//
			if ($fullDeviceName !== $row['dvId']) $isNotParent = true;

			//하위 16g 32g 같은 용량 분류가 있을때
			if ($isNotParent) {//parent 아닐때
				$isExistParentDevice = DB::queryFirstField("SELECT COUNT(*) FROM tmDevice WHERE dvId=%s", $row['dvId']);
				if ($isExistParentDevice == 0) {
					DB::insert('tmDevice', array(
						'dvId' => $row['dvId'],
						'dvParent' => 0,
						'dvTit' => $row['dvTit'],
						'dvManuf' => $this->manuf,
						'dvRetailPrice' => $row['dvRetailPrice'],
						'dvIcon' => $row['icon'],
						'dvDisplay' => 0
					));
				}
				$parentKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId=%s", $row['dvId']);
				$row['dvTit'] = strtoupper($row['capacity']);
			}
			
			$isExistDevice = DB::queryFirstField("SELECT COUNT(*) FROM tmDevice WHERE dvId=%s", $fullDeviceName);
			if ($isExistDevice == 0) {
				DB::insert('tmDevice', array(
					'dvId'				=> $fullDeviceName,
					'dvParent'			=> $parentKey,
					'dvTit'				=> $row['dvTit'],
					'dvThumb'			=> 'device-big-iphone6.png',
					'dvManuf'			=> $this->manuf,
					'dvIcon'			=> $row['icon'],
					'dvRetailPrice'	=> $row['dvRetailPrice'],
					'dvDisplay'		=> 0
				));
			}
			
			$dvKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId=%s", $fullDeviceName);
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
					'spCarrier' => 'sk',
					'spSupport' => $row['spSupport'],
					'spAddSupport' => $row['spAddSupport'],
					'spDate' => $row['spDate'],
				));
			}
		}
	}


	private function getTitle($page) {
		$page = getRexMatch($page, $this->arrRexColumn[$this->carrier]);
		$rows = explode('|||', $this->stripTags(str_replace('</th>', '|||', $page)));
		$this->arrTitle = $rows;
		//var_dump($rows);
		return $this;
	}

	private function checkHTMLChanged(){
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
		if (strpos($input, '(') !== false) {
			$input = explode('(', $input);
			$input = str_replace(')', '', $input[1]);
		}
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
		if (strpos($input, '(') !== false) {
			$input = explode('(', $input);
			$input = str_replace(')', '', $input[1]);
		}
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
		if (preg_match($this->rexCapacity, $output[1])) 
			return $output[1];			
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