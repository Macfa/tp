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
	private $isChangedHTML = FALSE;

	private $deviceInfo = NULL;

	private $retailPriceIndex = '3';
	private $supportIndex = '4';
	private $addSupportIndex = '5';

	//private $arrVendor = array('S'=>'SKT', 'K'=>'KT', 'L'=>'LG U+', 'C'=>'CJ');
	private $arrManuf = array('samsung'=>'', 'lg'=>'', 'apple'=>'Apple');

	private $targetURL = '';
	private $arrTargetCarrierURL = array('sk'=>'http://www.tworlddirect.com/handler/Dantong-TWD',
												'kt'=>'',
												'lguplus'=>'https://www.uplus.co.kr/sqr/prdt/post/RetriveProdDiscountPostList.hpi'
									);

	private $rexTable = '/<div class="board_list2 tbl_pa">([\s\S]*?)<\/table>[\s\S]*?<\/div>/';
	private $rexTitle = '/<thead>([\s\S]*?)<\/thead>/i';
	private $rexCapacity = '/(16g|32g|64g|128g)/';
	private $arrRexTable = array(
											'sk'=>'/<div class="board_list2 tbl_pa">([\s\S]*?)<\/table>[\s\S]*?<\/div>/',
											'lguplus'=>'/<div class="section table_molaw">([\s\S]*?)<\/table>[\s\S]*?<\/div>/'
										);

	private $arrPostSubmitVal = array();
	private $arrCarrierPostSubmitVal = array(
																'sk'=>array('ORDER_FIELD' => 'ORDER_SEQ',
																				'ORDER_TYPE'			=>'ASC',
																				'MODEL_NW_TYPE'	=>'',
																				'LIST_COUNT'			=>100,
																				'TAB_PROD_ID'			=>'',
																				'CHG_PROD_ID'		=>'',
																				'PROD_ID'					=>'NA00004776',
																				'PROD_TYPE'				=>'BASIC',
																				'COMPANY_NM'			=>'',
																				'PROD_GRP_ID'		=>'',
																),
																'lguplus'=>array(),
															);
	private $arrPhonePlanName =	array();
	private $arrKidsPlanName = array();
	private $arrWatchPlanName =	 array();
	private $arrPocketfiPlanName = array();
	private $arrPlan = array();

	public function __construct(){
		$this->arrManuf['samsung'] = iconv("UTF-8", "EUC-KR", '삼성전자(주)');
		$this->arrManuf['lg'] = iconv("UTF-8", "EUC-KR", 'LG전자(주)');
		$this->deviceInfo = new deviceInfo();
	}

	public function setCarrier($input) {
		$this->carrier = $input;
		$this->targetURL = $this->arrTargetCarrierURL[$this->carrier];
		$this->arrPostSubmitVal = $this->arrCarrierPostSubmitVal[$this->carrier];
		return $this;
	}

	public function setMode($mode) {
		$this->mode = $mode;
		if ($mode == 'phone') {
			$this->arrPostSubmitVal['MODEL_NW_TYPE'] = 'LTE';
			$this->arrPostSubmitVal['CHG_PROD_ID'] =  'LTE';
		} else if ($mode == 'watch') {
			$this->arrPostSubmitVal['MODEL_NW_TYPE'] = '3G';
			$this->arrPostSubmitVal['CHG_PROD_ID'] =  '3G';
		} else if ($mode == 'pocketfi' || $mode == 'kids') {
			$this->arrPostSubmitVal['MODEL_NW_TYPE'] = 'ETC';
			$this->arrPostSubmitVal['CHG_PROD_ID'] =  'ETC';
		}
		return $this;
	}
	
	public function setManuf($manuf){
		$this->manuf = $manuf;
		$this->arrPostSubmitVal['COMPANY_NM'] = $this->arrManuf[$manuf];
		return $this;
	}

	public function getPage() {
		$data = new snoopy;
		$data->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
		$data->referer = "http://www.tworlddirect.com/handler/Dantong-TWD";
		$data->fetch($this->targetURL.'?'.http_build_query($this->arrPostSubmitVal));
		$this->page = $data->results;
		return $this;
	}

	public function getDataAndInsert(){
		//$this->getPage();
		$arrPlan = $this->getArrPlan();
		foreach($arrPlan as $key => $val){
			$this->setPlan($val)->getPage()->getTable()->getCont()->insertUpdate();
		}
		return $this;
	}

	public function getArrPlan(){
		return $this->deviceInfo->setCarrier($this->carrier)->setMode($this->mode)->getArrPlan();
	}

	public function setPlan($input){
		$this->plan = $input;
		$this->arrPostSubmitVal['PROD_ID'] = $this->deviceInfo->arrPlanValue[$input];
		return $this;
	}

	private function getTable() {
		$result = getRexMatch($this->page, $this->rexTable); 
		if (is_array($result))
			$this->page = $result[0];
		else
			$this->page = $result;
		return $this;
	}

	private function getCont() {
		$this->page = explode('<tbody>', $this->page);
		$this->getTitle($this->page[0]);
		$rows = preg_split('#</tr>#i', $this->page[1]);
		foreach ($rows as $key => $row) {
			$row = strtolower(iconv("EUC-KR", "UTF-8", $row));
			$deviceRow[$key] = $this->stripTags(preg_split('#</td>#i', $row)); //td태그를 기분으로 배열로
			$deviceRow[$key][9] = $this->getIconClass($deviceRow[$key][0]);
			$deviceRow[$key][10] = $this->getCapacity($deviceRow[$key][0]);
			$deviceRow[$key][11] = strtoupper($this->convert2name($deviceRow[$key][0]));
			$deviceRow[$key][0] = $this->convert2id($deviceRow[$key][0]);
			if ($deviceRow[$key][0] == false || isContain('\*\*\*', $deviceRow[$key][4])) {
				unset($deviceRow[$key]);
				continue;
			}
			if ($this->mode == 'pocketfi'){
				if(isContain('pocketfi', $deviceRow[$key][0]) === false)
					unset($deviceRow[$key]);
			}
		}
		$this->arrData = $deviceRow;
		//print_r($deviceRow);
		//								dvId										x							제조사			출고가				공시지원금			추가지원금					x					공시날짜
		//Array ( [0] => iphone6splus16g [1] => IPHONE6S+_16G [2] => Apple [3] => 999,900 [4] => 122,000 [5] => 18,300 [6] => 859,600 [7] => 2015-10-23 [8] => 64g  [9] => 아이콘 )
		//$this->page = getRexMatch($this->page, $this->rexTable); 
		return $this;
	}

	public function insertUpdate() {
		
		foreach($this->arrData as $row) {
			if (!$row[0]) continue;
			$dvTit = $row[11];
			$fullDeviceName = $row[0].$row[10];
			$parentDeviceName = $row[0];
			$retailPrice = $row[3];
			$parentKey = 0;
			if ($fullDeviceName !== $parentDeviceName) $isNotParent = true;

			//하위 16g 32g 같은 용량 분류가 있을때
			if ($isNotParent) {//parent 아닐때
				$isExistParentDevice = DB::queryFirstField("SELECT COUNT(*) FROM tmDevice WHERE dvId=%s", $parentDeviceName);
				if ($isExistParentDevice == 0){
					DB::insert('tmDevice', array(
						'dvId' => $parentDeviceName,
						'dvParent' => 0,
						'dvTit' => $dvTit,
						'dvManuf' => $this->manuf,
						'dvRetailPrice' => str_replace(',', '',$retailPrice),
						'dvIcon' => $row[9],
						'dvDisplay' => 0
					));
				}
				$parentKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId=%s", $parentDeviceName);
				$dvTit = strtoupper($row[10]);
			}
			
			$isExistDevice = DB::queryFirstField("SELECT COUNT(*) FROM tmDevice WHERE dvId=%s", $fullDeviceName);
			if ($isExistDevice == 0) {
				DB::insert('tmDevice', array(
					'dvId'				=> $fullDeviceName,
					'dvParent'			=> $parentKey,
					'dvTit'				=> $dvTit,
					'dvThumb'			=> 'device-big-iphone6.png',
					'dvManuf'			=> $this->manuf,
					'dvIcon'			=> $row[9],
					'dvRetailPrice'	=> str_replace(',', '',$retailPrice),
					'dvDisplay'		=> 0
				));
			}
			
			$dvKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId=%s", $fullDeviceName);
			$isNotUpdated = DB::queryFirstField("SELECT COUNT(*) FROM tmSupport WHERE spCarrier = 'sk' and spPlan = %s and dvKey=%s and spDate = %t", $this->plan, $dvKey, $row[7]);
			if($isNotUpdated == 0) {
				DB::insert('tmSupport', array(
					'dvKey' => $dvKey,
					'spPlan' => $this->plan,
					'spCarrier' => 'sk',
					'spSupport' => str_replace(',', '',$row[4]),
					'spAddSupport' => str_replace(',', '',$row[5]),
					'spDate' => $row[7],
				));
			}
		}
	}


	private function getTitle($page) {
		$page = getRexMatch($page, $this->rexTitle);
		$rows = preg_split('#</th>#i', $page);
		$this->arrTitle = array_splice($rows, 0, 6);
		//print_r($this->arrTitle);
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