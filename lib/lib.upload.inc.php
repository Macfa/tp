<?php 
//upload::setFile($_FILE['NAME'])->setMaxsize(12312312)->upload();
//upload::setFile($_FILE['NAME'])->upload();
class Upload {
	
	protected $maxsize = null;
	protected $extension = null;
	public $arrfile = '';
	public $randomString ='';
	public $fsId = '';
	public $directory ='';


	static function setFile($destination) {
		return new Upload($destination);
	}	

	public function __construct($destination){
		$this->arrfile = $destination;

		$this->checkError();

		return $this;
	}
	public function checkError(){
		if($this->arrfile['error'] > 0){

			try{
				switch ($this->arrfile['error']) {					
					case '1': throw new Exception('업로드한 파일크기가 설정된 값보다 큽니다. 티플에 문의해주세요. ', 1);
						break;
					case '2': throw new Exception('업로드한 파일크기가 HTML 폼에 명시한 값보다 큽니다. 티플에 문의해주세요 ', 2);
						break;
					case '3': throw new Exception('파일의 일부분만 업로드 되었습니다. 티플에 문의해주세요 ', 3);
						break;
					case '4': throw new Exception('파일이 업로드되지 않았습니다. 티플에 문의해주세요', 4);
						break;
					case '6': throw new Exception('임시 디렉터리가 지정되지 않았습니다. 티플에 문의해주세요', 5);
						break;
					case '7': throw new Exception('디스크에 파일을 쓰지 못했습니다. 티플에 문의해주세요 ', 6);
						break;
				}

			}catch (Exception $e) {

				alert($e->getMessage()."errorCode : ".$e->getCode());			
			}
		}
	}

	public function setMaxsize($maxsize) {
		if ( $maxsize >= 0 && $maxsize <= 1024000) {
			$this->maxsize = $maxsize / 1024;	
		} else {
			return false;		
		}
		return $this;
	} 	

	public function checkMaxsize() {

		$checkFilesize = $this->arrfile['size'] / 1024;
		if ( $checkFilesize <= $this->maxsize ) {
			$this->arrfile['size'] = $checkFilesize;			
			return true;
		} else {
			return false;
		}	
	}
	
	public function setAllowedExtension($extension) {		
		$this->extension = $extension;
		return $this;
	}

	public function checkAllowedExtension(){
		
		return isValidExt($this->arrfile,$this->extension);	
	
	}

	public function setDirectory($dir) {		
		$this->directory = $dir;
		return $this;
	}

	public function upload (){	

		if($this->validate() === false){

			return false;

		}else{
			$this->randomString = encrypt(getRandomString(30).time());	
			$this->fsId = getRandomString(15).time();
			

			if (move_uploaded_file($this->arrfile['tmp_name'], $this->directory.$this->randomString)) {		

				$this->insertData();
			
			}

			
		}
		return $this;
	}

	public function insertData(){
		
		global $cfg;

		$originalFileName = $this->arrfile['name'];			

		DB::insert('tmFileStorage', 
			array(
				'fsId' => $this->fsId,
				'fsFileName' => $this->randomString,
				'fsOriginalName' => $originalFileName, 
				'fsDatetime' => $cfg['time_ymdhis']
			)
		);
		return $this;
	}

	private function validate(){
		if(isExist($this->arrfile) === false) return false;
		if(isExist($this->maxsize) === true && $this->checkMaxsize() === false) return false;
		if(isExist($this->extension) === true && $this->checkAllowedExtension() === false) return false;
	}

}

?>