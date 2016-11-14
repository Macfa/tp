<?
function getPlanInfo($data){
	global $cfg;
	$snoopy=new snoopy;
	$snoopy->httpmethod = "POST";
	$data['authentication'] = $cfg['authentication'];
	$snoopy->submit($cfg['url'].'/product/detailGetPlan.php', $data);
	$page=$snoopy->results;
	if ($page == FALSE) return false;
	return json_decode($page, true);
}


class deviceInfo {	

	private $addTax = 1.1;
	private $carrier = '';
	private $installationMonth = '';
	private $devicePrice = '';
	private $plan = '';
	private $mode = '';
	private $arrApplyType = array();
	private $arrDiscountType = array();
	private $arrDeviceType = array();
	private $arrSupport = array();

	private $repaymentPerMonth = '';

	private $arrDefaultDeviceType = array('3G');
	private $arrDefaultApplyType = array('01'=>'신규개통','02'=>'번호이동','06'=>'기기변경');
	private $arrDefaultCarrierType = array('sk'=>'SK', 'kt'=>'KT', 'lguplus'=>'LG U+');
	private $arrDefaultDiscountType = array('support'=>'공시지원금할인','selectPlan'=>'선택약정할인');

	// 반드시 요금제에 부여된 번호대로대로 되어야함
	public $arrPlan = array(
									'sk'=>array(
										'phone'=>array(
											0 => array(
												'name' => 'T시그니쳐 Master',
												'description' => '데이터 35G+무제한/통화문자무한',	
												'fee' => 100000,
												'selectPlanDiscount' => 20000,
												'value' => 'NA00004777'
											),
											1 => array(
												'name' => 'T시그니쳐 Classic',
												'description' => '데이터 20G+무제한/통화문자무한',
												'fee' => 80000,
												'selectPlanDiscount' => 16000,
												'value' => 'NA00004776'
											),
											2 => array(
												'name' => 'band 데이터 퍼펙트S',
												'description' => '데이터 16G+무제한/통화문자무한',
												'fee' => 69000,
												'selectPlanDiscount' => 13800,
												'value' => 'NA00005134'
											),
											3 => array(
												'name' => 'band 데이터 퍼펙트',
												'description' => '데이터 11G+무제한/통화문자무한',
												'fee' => 59900,
												'selectPlanDiscount' => 12000,
												'value' => 'NA00004775'
											),
											4 => array(
												'name' => 'band 데이터 6.5G',
												'description' => '데이터 6.5G/통화문자무한',
												'fee' => 51000,
												'selectPlanDiscount' => 10200,
												'value' => 'NA00004773'
											),
											5 => array(
												'name' => 'band 데이터 3.5G',
												'description' => '데이터 3.5G/통화문자무한',
												'fee' => 47000,
												'selectPlanDiscount' => 9400,
												'value' => 'NA00004772'
											),
											6 => array(
												'name' => 'band 데이터 2.2G',
												'description' => '데이터 2.2G/통화문자무한',
												'fee' => 42000,
												'selectPlanDiscount' => 8400,
												'value' => 'NA00004771'
											),
											7 => array(
												'name' => 'band 데이터 1.2G',
												'description' => '데이터 1.2G/통화문자무한',
												'fee' => 36000,
												'selectPlanDiscount' => 7200,
												'value' => 'NA00004770'
											),
											8 => array(
												'name' => 'band 데이터 세이브',
												'description' => '데이터 300M/통화문자무한',
												'fee' => 29900,
												'selectPlanDiscount' => 6000,
												'value' => 'NA00004769'
											),
										),
										'kids'=>array(
											9 => array(
												'name' => 'band 데이터 세이브',
												'description' => '데이터 300M/통화문자무한',
												'fee' => 29900,
												'selectPlanDiscount' => 6000,
												'value' => 'NA00004407'
											)
										),
										'watch'=>array(
											11 => array(
												'name' => '',
												'description' => 'SK만 가능/데이터무한/통화50분',
												'fee' => 10000,
												'selectPlanDiscount' => 0,
												'value' => 'NA00004461'
											),
											12 => array(
												'name' => '',
												'description' => '데이터무한/통화50분',
												'fee' => 10000,
												'selectPlanDiscount' => 0,
												'value' => 'NA00004540'
											)
										),
										'pocketfi'=>array(
											13 => array(
												'name' => 'T포켓파이10',
												'description' => '데이터 10G',
												'fee' => 15000,
												'selectPlanDiscount' => 0,
												'value' => 'NA00004836'
											),
											14 => array(
												'name' => 'T포켓파이 20',
												'description' => '데이터 20G',
												'fee' => 22500,
												'selectPlanDiscount' => 0,
												'value' => 'NA00004837'
											)
										)
									),
									'kt'=>array(
										'phone'=>array(
											15 => array(
												'name' => 'LTE 데이터 선택 109',
												'description' => '데이터 30GB+무제한/음성 무제한/영상&부가200분 추가제공',
												'fee' => 99900,
												'selectPlanDiscount' => 20000,
												'value' => 'KJPLTE089'
											),
											16 => array(
												'name' => 'LTE 데이터 선택 76.8',
												'description' => '데이터 15GB+무제한/음성 무제한/영상&부가200분 추가제공',
												'fee' => 69900,
												'selectPlanDiscount' => 14000,
												'value' => 'KJPLTE069'
											),
											17 => array(
												'name' => 'LTE 데이터 선택 65.8',
												'description' => '데이터 10GB+무제한/음성 무제한/영상&부가200분 추가제공',
												'fee' => 59900,
												'selectPlanDiscount' => 12000,
												'value' => 'KJPLTE059'
											),
											18 => array(
												'name' => 'LTE 데이터 선택 54.8',
												'description' => '데이터 6GB/음성 무제한/영상&부가30분 추가제공',
												'fee' => 49900,
												'selectPlanDiscount' => 10000,
												'value' => 'KJPLTE049'
											),
											19 => array(
												'name' => 'LTE 데이터 선택 49.3',
												'description' => '데이터 3GB/음성 무제한/영상&부가30분 추가제공',
												'fee' => 44900,
												'selectPlanDiscount' => 9000,
												'value' => 'KJPLTE044'
											),
											20 => array(
												'name' => 'LTE 데이터 선택 43.8',
												'description' => '데이터 2GB/음성 무제한/영상&부가30분 추가제공',
												'fee' => 39900,
												'selectPlanDiscount' => 8000,
												'value' => 'KJPLTE039'
											),
											23 => array(
												'name' => 'LTE 데이터 선택 38.3',
												'description' => '데이터 1GB/음성 무제한/영상&부가30분 추가제공',
												'fee' => 34900,
												'selectPlanDiscount' => 7000,
												'value' => 'KJPLTE034'
											),
											24 => array(
												'name' => 'LTE 데이터 선택 32.8',
												'description' => '데이터 300MB/음성 무제한/영상&부가30분 추가제공',
												'fee' => 29900,
												
												'selectPlanDiscount' => 6000,
												'value' => 'KJPLTE029'
											)
										),
										'pocketfi'=>array(
											21 => array(
												'name' => 'LTE egg+ 11',
												'description' => '데이터 11GB',
												'fee' => 15000,
												'selectPlanDiscount' => 0,
												'value' => 'LTEEGG11G' 
											),
											22 => array(
												'name' => 'LTE egg+ 22',
												'description' => '데이터 22GB',
												'fee' => 22000,
												'selectPlanDiscount' => 0,
												'value' => 'LTEEGG22G'
											)
										),
										'watch'=>array(
											25 => array(
												'name' => 'Wearable LTE',
												'description' => '',
												'fee' => 10000,
												'selectPlanDiscount' => 0,
												'value' => 'KTFWEAR4G'
											),
											26 => array(
												'name' => 'Wearable 3G',
												'description' => '',
												'fee' => 10000,
												'selectPlanDiscount' => 0,
												'value' => 'KTFWEAR3G'
											)
										),
										'kids'=>array(
											27 => array(
												'name' => '키즈80 차단형',
												'description' => '데이터100MB/망내지정1회선 음성&문자무제한(소진시차단,충전가능)/문자250건',
												'fee' => 8000,
												'selectPlanDiscount' => 0,
												'value' => 'KTFWEARLM'
											),
											28 => array(
												'name' => '키즈80 일반형',
												'description' => '데이터100MB/망내지정1회선 음성&문자무제한/문자250건',
												'fee' => 8000,
												'selectPlanDiscount' => 0,
												'value' => 'KTFWEARAS'
											)
										)
									),
									'lguplus'=>array(
										'phone'=>array()
									)
								);	
	private $arrPlanName =	array(
												9 => 'T 키즈안심(판매안함)',
												10 => 'T 키즈전용',
												11 => 'T 아웃도어(공유)',
												12 => '',
												13 => 'T 포켓파이 10',
												14 => 'T 포켓파이 20',
												15 => 'LTE 데이터 599',
												16 => 'LTE 데이터 499',
												17 => 'LTE 데이터 449',
												18 => 'LTE 데이터 399',
												19 => 'LTE 데이터 349',
												20 => 'LTE 데이터 299'
											);

	private $arrCarrierInterest = array('sk' => 5.9, 'kt' => 0.27, 'lg' => 5.9);

	public function setCarrier($input) {
		$this->carrier = $input;
		return $this;
	}

	public function setMonth($input) {
		$this->installationMonth = $input;
		return $this;
	}

	public function setSupport($arr){
		$this->arrSupport = $arr;
		return $this;
	}

	public function setMode($input) {
		$this->mode = $input;
		$this->arrDiscountType = $this->arrDefaultDiscountType;
		switch ($input) {
			case 'watch'://아웃도어
				$this->arrDeviceType = $this->arrDefaultDeviceType;
			case 'kids': //키즈
			case 'pocketfi'://포켓파이
				unset($this->arrDiscountType['selectPlan']);
				$this->arrApplyType = array_slice($this->arrDefaultApplyType, 0, 1);
				break;
			default: //폰
				$this->arrApplyType = array_slice($this->arrDefaultApplyType, 1);
				break;
		}
		return $this;
	}

	public function setPlan($input) {
		$this->plan = $input;
		return $this;
	}

	public function setDevicePrice($input) {
		$this->devicePrice = $input;
		return $this;
	}

	public function getArrPlanValue(){
		return $this->arrPlanValue;
	}

	public function getArrPlan(){
		//var_dump($this->arrPlan[$this->carrier][$this->mode]);
		return array_keys($this->arrPlan[$this->carrier][$this->mode]);
	}

	public function getFirstPlan(){
		list($firstKey) = array_keys($this->arrPlan[$this->carrier][$this->mode]);
		return $firstKey;
	}

	public function getArrPhonePlanName(){
		return $this->arrPhonePlanName;
	}

	public function getArrKidsPlanName(){
		return $this->arrKidsPlanName;
	}

	public function getArrWatchPlanName(){
		return $this->arrWatchPlanName;
	}

	public function getPlanValue($input){
		return $this->arrPlan[$this->carrier][$this->mode][$input]['value'];
	}

	public function getArrPocketfiPlanName(){
		return $this->arrPocketfiPlanName;
	}

	public function getPlanInfo($input) {
		return $this->arrPlan[$this->carrier][$this->mode][$input]['description'];
	}

	public function getArrApplyType() {
		return $this->arrApplyType;
	}

	public function getArrDiscountType() {
		return $this->arrDiscountType;
	}

	public function getArrDeviceType() {
		return $this->arrDeviceType;
	}

	public function getArrCarrierType($dvKey) {
		list($isSK, $isKT, $isLG) = DB::queryFirstList("SELECT dvSK, dvKT, dvLG FROM tmDevice WHERE dvKey = %i", $dvKey);
		$isSK = ($isSK==1)?true:false;
		$isKT = ($isKT==1)?true:false;
		$isLG = ($isLG==1)?true:false;

		$output = $this->arrDefaultCarrierType;
		if ($isSK === false) unset($output['sk']);
		if ($isKT === false) unset($output['kt']);
		if ($isLG === false) unset($output['lguplus']);

		return $output;
	}

	public function getApplyURL($input, $type) {
		return 'https://tgate.sktelecom.com/applform/main.do?prod_seq='.$input.'&scrb_cl='.$type.'&mall_code=00001';
	}

	public function getPlanName($input) {
		return $this->arrPlan[$this->carrier][$this->mode][$input]['name'];
	}

	public function calcInterest($resultDevicePrice) { //할부이자계산
		$this->repaymentPerMonth = floor(($resultDevicePrice * (($this->arrCarrierInterest[$this->carrier]/12) / 100) / ( 1 - pow( 1 + (($this->arrCarrierInterest[$this->carrier]/12) / 100), - $this->installationMonth))));
		return $this;
	}
	public function getContainVatInterest() { //할부이자계산
		return $this->repaymentPerMonth + ($this->getPlanFee() * $this->addTax);
	}

	public function test() { //테스트
		return ($this->devicePrice-$this->arrSupport['spSupport']-$this->arrSupport['spAddSupport']);
	}

	public function getRepayment() {
		return $this->repaymentPerMonth;
	}

	public function getPlanFee() {
		return $this->arrPlan[$this->carrier][$this->mode][$this->plan]['fee'];
	}

	public function getArrPlanFee() {
		return $this->arrPlan[$this->carrier][$this->mode][$this->plan]['fee'];
	}

	public function getSelectPlanDiscount() {
		return $this->arrPlan[$this->carrier][$this->mode][$this->plan]['selectPlanDiscount'];
	}

	public function getFeeAddTax() { 
		return $this->getPlanFee() * $this->addTax;
	}
	
}
