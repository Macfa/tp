<?php

class SMS{
	private $arrSet = array(
				'MSG_TYPE' => '',
				'REQUEST_TIME' => '',
				'SEND_TIME' => '',
				'DEST_PHONE' => '',
				'DEST_NAME' => '',
				'SEND_PHONE' => '0263570313',
				'SEND_NAME' =>'티플',
				'MSG_BODY' => ''
			);

	public function sendMode($input) {
		$this->arrSet['MSG_TYPE']  = $input;
		return $this;
	}
	public function sendMemberPhone($input) {
		$this->arrSet['DEST_PHONE'] = $input;
		return $this;
	}
	public function sendMemberName($input) {
		$this->arrSet['DEST_NAME'] = $input;
		return $this;
	}
	public function sendCont($input) {
		$this->arrSet['MSG_BODY'] = $input;
		return $this;
	}

	public function sendSubject($input) {
		$this->arrSet['sendSubject'] = $input;
		return $this;
	}
	public function attachFile($input) {
		$this->arrSet['file']  = $input;
		return $this;
	}

	public function reSendMode($input) {
		$this->arrSet['RE_TYPE'] = $input;
		return $this;
	}

	public function reSendCont($input) {
		$this->arrSet['RE_BODY'] = $input;
		return $this;
	}
	public function nationCode($input) {
		$this->arrSet['NATION_CODE'] = $input;
		return $this;
	}
	

	public function send(){
		global $cfg;
		$this->arrSet['REQUEST_TIME'] = $cfg['time_ymdhis'];
		$this->arrSet['SEND_TIME'] = $cfg['time_ymdhis'];
		$this->arrSet['CMID'] = microtime().$this->getRandomStr();

		DB::insert('biz_msg', $this->arrSet);
	}

	private function getRandomStr(){
		$c= "0123456789abcdefghijklmnopqrstuxyzABCDEFGHIJKLMNOPQRSTUXYZ";  
		srand((double)microtime()*1000000);  
		for($i=0; $i<5; $i++) {  
			$rand.= $c[rand()%strlen($c)];  
		}  
		return $rand;  
	}
}


switch($changeProcess) {	
	case '0' :
		$sendCont = "[티플 아이폰7] 사전예약 신청이 접수되었습니다. 감사합니다.";
		break;
	case '1' :
		$sendCont = "[티플 아이폰7] 신청이 확인되었습니다. 감사합니다.";
		break;
	case '2' :
		$sendCont =  "[티플 아이폰7] 로그인 후 마이페이지에서 실가입을 신청해주세요.";
		break;
	case '3' :
		$sendCont =  "[티플 아이폰7] 실가입신청이 확인 되었습니다.";
		break;
	case '4' :
		$sendCont =  "[티플 아이폰7] 신청하신 기기가 발송되었습니다.";
		break;
	case '5' :
		$sendCont =  "[티플 아이폰7] 기기도착이 확인 되었습니다.";
		break;
	case '6' :
		$sendCont =  "[티플 아이폰7] 개통대기 상태로 변경되었습니다.";
		break;	
	case '7' :
		$sendCont =  "[티플 아이폰7] 기기 개통이 완료되었습니다.";
		break;
	case '8' :
		$sendCont =  "[티플 아이폰7] 사은품 발송대기 상태로 변경되었습니다.";
		break;
	case '9' :
		$sendCont =  "[티플 아이폰7] 사은품이 발송 되었습니다 감사합니다";
		break;
	case '10' :
		$sendCont =  "[티플 아이폰7] 티플에서 신청해주셔서 감사합니다";
		break;
}

?>