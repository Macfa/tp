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
	private $arrPlan = array(
									'sk'=>array(
										'phone'=>array(0,1,2,3,4,5,6,7,8),
										'kids'=>array(10),
										'watch'=>array(11,12),
										'pocketfi'=>array(13,14)
									),
									'kt'=>array(
										'phone'=>array(15,16,17,18,19,20),
										'pocketfi'=>array(21,22)
									),
									'lguplus'=>array(
										'phone'=>array(23,24,25,26,27,28)
									)
								);
	private $arrPlanInfo = array(
											0=>'데이터 35G+무제한/통화문자무한',//100
											1=>	'데이터 20G+무제한/통화문자무한',
											2=>	'데이터 16G+무제한/통화문자무한',
											3=>	'데이터 11G+무제한/통화문자무한',
											4=>	'데이터 6.5G/통화문자무한',
											5=>	'데이터 3.5G/통화문자무한',
											6=>	'데이터 2.2G/통화문자무한',
											7=>	'데이터 1.2G/통화문자무한',
											8=>	'데이터 300M/통화문자무한',//29
											9=> '판매안함',//t키즈안심
											10=>'데이터 100M/통화30분',//t키즈전용
											11=>'SK만 가능/데이터무한/통화50분',//t아웃도어공유
											12=>'데이터무한/통화50분',//t아웃도어단독
											13=>'데이터10G',//포켓파이10
											14=>'데이터20G',//포켓파이20
										);

	// 반드시 요금제에 부여된 번호대로대로 되어야함
	private $arrPlanFee = array(
											0=>	'100000',//100
											1=>	'80000',
											2=>	'69000',
											3=>	'59900',
											4=>	'51000',
											5=>	'47000',
											6=>	'42000',
											7=>	'36000',
											8=>	'29900',//29
											9=>	'0',//t키즈안심
											10=>'8000',//t키즈전용
											11=>'10000',//t아웃도어공유
											12=>'10000',//t아웃도어단독
											13=>'15000',//포켓파이10
											14=>'22500'//포켓파이20
										);

	private $arrSelectDiscount= array(
													0=>'20000',//100
													1=>	'16000',
													2=>	'13800',
													3=>	'12000',
													4=>	'10200',
													5=>	'9400',
													6=>	'8400',
													7=>	'7200',
													8=>	'6000'//29
												);

	private $arrPlanName =	array(
												0 => 'T시그니쳐 Master',
												1 => 'T시그니쳐 Classic', 
												2 => 'band 데이터 퍼펙트S',
												3 => 'band 데이터 퍼펙트',
												4 => 'band 데이터 6.5G',
												5 => 'band 데이터 3.5G', 
												6 => 'band 데이터 2.2G', 
												7 => 'band 데이터 1.2G', 
												8 => 'band 데이터 세이브',
												9 => 'T 키즈안심(판매안함)',
												10 => 'T 키즈전용',
												11 => 'T 아웃도어(공유)',
												12 => 'T 아웃도어(단독)',
												13 => 'T 포켓파이 10',
												14 => 'T 포켓파이 20',
												15 => 'LTE 데이터 599',
												16 => 'LTE 데이터 499',
												17 => 'LTE 데이터 449',
												18 => 'LTE 데이터 399',
												19 => 'LTE 데이터 349',
												20 => 'LTE 데이터 299'
											);

	public $arrPlanValue =	array(0=>'NA00004777',
												1=>'NA00004776',
												2=>'NA00005134',
												3=>'NA00004775',
												4=>'NA00004773',
												5=>'NA00004772',
												6=>'NA00004771',
												7=>'NA00004770',
												8=>'NA00004769',
												9=>'NA00004407',
												10=>'NA00004484',
												11=>'NA00004461',
												12=>'NA00004540',
												13=>'NA00004836',
												14=>'NA00004837'
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
		return $this->arrPlan[$this->carrier][$this->mode];
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
		return $this->arrPlanValue[$input];
	}

	public function getArrPocketfiPlanName(){
		return $this->arrPocketfiPlanName;
	}

	public function getPlanInfo($input) {
		return $this->arrPlanInfo[$input];
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
		return $this->arrPlanName[$input];
	}

	public function calcInterest($resultDevicePrice) { //할부이자계산
		$this->repaymentPerMonth = floor(($resultDevicePrice * (($this->arrCarrierInterest[$this->carrier]/12) / 100) / ( 1 - pow( 1 + (($this->arrCarrierInterest[$this->carrier]/12) / 100), - $this->installationMonth))));
		return $this;
	}
	public function getContainVatInterest() { //할부이자계산
		return $this->repaymentPerMonth + ($this->arrPlanFee[$this->plan] * $this->addTax);
	}

	public function test() { //테스트
		return ($this->devicePrice-$this->arrSupport['spSupport']-$this->arrSupport['spAddSupport']);
	}

	public function getRepayment() {
		return $this->repaymentPerMonth;
	}

	public function getPlanFee() {
		return $this->arrPlanFee[$this->plan];
	}

	public function getArrPlanFee() {
		return $this->arrPlanFee;
	}

	public function getSelectPlanDiscount() {
		return $this->arrSelectDiscount[$this->plan];
	}

	public function getFeeAddTax() { 
		return $this->arrPlanFee[$this->plan] * $this->addTax;
	}
	
}
