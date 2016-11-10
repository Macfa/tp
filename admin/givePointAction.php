<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

class givePoint{
	private $givePoint = '';
	private $member = '';
	private $cont ='';

	public function setPoint($input) {
		$this->givePoint = $input;
		return $this;
	}
	public function setMember($input) {
		$this->member = $input;
		return $this;
	}
	public function setCont($input) {
		$this->cont = $input;
		return $this;
	}
	public function give(){
		global $cfg;
		$currentPoint = DB::queryFirstField("SELECT mbPoint FROM tmMember WHERE mbEmail=%s", $this->member);
		($_POST['gpCont'])?$this->cont = ' '.$_POST['gpCont']:$this->cont = ' 포인트 지급';
		DB::update('tmMember', 
			array(
				'mbPoint' => DB::sqleval($currentPoint+$this->givePoint)
			),	'mbEmail = %s', $this->member
		);		

		DB::insert('tmPointHistory', array(
			'mbEmail' => $this->member,
			'phCont' => $cfg['time_ymd'].$this->cont,
			'phAmount' => $this->givePoint,
			'phResult' => $currentPoint+$this->givePoint,
			'phDate' => $cfg['time_ymdhis']
		));
	}
}

$isExist =  DB::queryFirstField("SELECT count(mbEmail) FROM tmMember WHERE mbEmail=%s", $_POST['gpEmail']);


try{
	if(isNullVal($_POST['gpEmail']))
		throw new Exception('아이디를 입력해주세요', 3);

	if(isNullVal($_POST['gpPoint']))
		throw new Exception('포인트를 입력해주세요', 3);

	if($isExist === '0')
		throw new Exception('존재하지 않는 회원입니다', 3);

	
} catch (Exception $e) {	

	alert($e->getMessage());
}

$givePoint = new givePoint();
$givePoint->setPoint($_POST['gpPoint'])->setMember($_POST['gpEmail'])->setCont($_POST['gpCont'])->give();

alert('지급완료되었습니다.', "/admin/memberList.php?search=".$_POST['gpEmail']);

?>