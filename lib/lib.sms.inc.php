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
		switch ($input) {
			case 'SMS':
				$input = 0;
				break;
			case 'MMS':
				$input = 1;
				break;
		}
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



?>