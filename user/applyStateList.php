<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$import->addCSS('mypageList.css');


//일반구매 리스트 & 디바이스 정보
$applyExist = DB::query("SELECT * FROM tmApplyTmp AS apply LEFT JOIN tmDevice AS device ON apply.dvKey = device.dvKey WHERE apply.mbEmail=%s", $mb['mbEmail']);
rsort($applyExist);

foreach ($applyExist as $key => $value) {
	if((int)$value['dvParent'] === 0){
		$dvTitle[] = $value['dvTit'];
		$arrdvId[] = $value['dvId'];
	}else{ // 용량이 따로 있는 기기		
		$applyCapacity = $value['dvTit'];
		list($dvId, $dvTit) = DB::queryFirstList("SELECT dvId, dvTit FROM tmDevice WHERE dvKey = %i", $value['dvParent']);
		$dvTitle[] = $dvTit." ".$applyCapacity;			
		$arrdvId[] = $dvId;
	}	
}

$changeState = array(
	
	0 => '신청완료',
	1 => '연락두절',
	2 => '연락필요',
	3 => '신청수단없음',
	4 => '실가입확인',
	5 => '개통완료',
	6 => '이슈발생',
	7 => '신청중'	

);

$cancel = array(
	0 => '-',
	1 => '취소'
	);

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
require_once("applyStateList.skin.php");		
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)