<?php 
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename=업로드목록.xls');
// header('Cache-Control: max-age=0');
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB.'/lib.PHPExcel.inc.php');
include_once(PATH_LIB.'/PHPExcel/IOFactory.php');


class Upload {
	
	protected $filepath = "";
	protected $maxsize = "";
	protected $filename = "";
	protected $filetype = "";
	protected $target_file = "";

	static function setFile($destination) {
		$this->filename = basename($destination);
		$this->filepath = dirname($destination);
		$this->target_file = $destination;
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

	public function checkExtention() {
		if ( $this->filename !== null ) {
			if (in_array($ext, $arrWhitelist))
				return true; 
			return false;
		}
	}  

	private function validate(){
		if (isExist($this->filename)) echo 'Check File Name'; return false;
		if (isExist($this->filedir)) echo 'Check File Directory'; return false;
		if (isExist($this->$maxsize) === true && $this->checkMaxsize() === false) echo 'Check File Size'; return false;
		if (isExist($this->filetype) === true && $this->checkExtention() === false) echo 'Check File Type'; return false;
		if (file_exists($target_file))
			echo "Sorry, File";
		//mime
	}
}

/*if(isExist($_FILES['selectfile']['tmp_name'])){
	$inputFileName = $_FILES['selectfile']['tmp_name'];
	$objReader =  $objReader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
	$objPHPExcel = $objReader->load($inputFileName);
	$objPHPExcel->setActiveSheetIndex(0);
	$i=7;
	var_dump($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue());

}*/

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form name="formName" method="post" enctype="multipart/form-data">
<input type="file" name="selectfile">
<input type="submit" value="Submit">
</body>
</html>
