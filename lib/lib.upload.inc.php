<?php 

class Upload {
	
	protected $filepath = "";
	protected $maxsize = null;
	protected $filename = null;
	protected $filetype = null;


	static function setFile($destination) {
		$this->filename = basename($destination);
		$this->filepath = dirname($destination);
		return new Upload($destination);
	}	

	public function setMaxsize($maxsize) {
		if ( $maxsize >= 0 && $maxsize <= 1024000) {
			$this->maxsize = $maxsize;	
		} else {
			return false;		
		}
	} 

	public function checkMaxsize() {
		$allpath = $this->destination.$this->filename;
		$filesize = filesize($allpath) / 1024;
		if ( $filesize <= $this->maxsize ) {
			$this->filesize = $filesize;
			return true;
		} else {
			return flase;
		}
	}

	public function upload (){
		if($this->validate() === false) return false;
		
		if (move_uploaded_file($this->filename, $this->filepath)) {
			echo $this->filename." file upload complete !";
		} else {
			echo "upload failed Check dump".var_dump($this->upload());
		}

	}

	public function setExtention($array) {
		if ( $this->filename !== null ) {
			$this->filetype = isValidExt($this->filename, implode(',', $array));
		}
	}  

	private function validate(){
		if (isExist($this->filename)) echo 'asdsad'; return false;
		if (isExist($this->filedir)) echo 'asdsad'; return false;
		if (isExist($this->$maxsize) === true && $this->checkMaxsize() === false) echo 'asdsad'; return false;
		if (isExist($this->filetype) === false) echo 'asdasd'; return false;
		//mime
	}






}
?>