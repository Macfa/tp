<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
//include_once(PATH_LIB."/lib.macAddress.inc.php");



$neHit = DB::queryFirstField("SELECT neHit FROM tmNews WHERE neKey=%i", $_POST['neKey']);
list($isExistDailyHit, $ndHit) = DB::queryFirstList("SELECT count(*), ndHit FROM tmNewsHitsDaily WHERE neKey=%i AND ndDay =%s", $_POST['neKey'], $cfg['time_ymd']);

$beforeDay = date("Y-m-d H:i:s", strtotime($cfg['time_ymdhis']." -1 day"));
$isTodayHit = DB::queryFirstField("SELECT count(*) FROM tmNewsHit WHERE nhDatetime >= %s AND nhDatetime <= %s AND neKey=%i AND nhIp = %s", $beforeDay, $cfg['time_ymdhis'], $_POST['neKey'], $cfg['ip']);


if((int)$isTodayHit === 0) { 

	DB::insert('tmNewsHit', array(
	  'neKey' => $_POST['neKey'],
	  'nhIp' => $cfg['ip'],
	  'nhDatetime' => $cfg['time_ymdhis']
	));

	DB::update('tmNews', array(
		'neHit' => $neHit+1
		), "neKey=%i", $_POST['neKey']);


	if((int)$isExistDailyHit === 0 ){

		DB::insert('tmNewsHitsDaily', array(
			'neKey' => $_POST['neKey'],
			'ndDay' => $cfg['time_ymd'],			
			'ndHit' => $ndHit+1	  
		));

	}else{
		DB::update('tmNewsHitsDaily', array(
			'ndHit' => $ndHit+1
			), "neKey=%i AND ndDay=%s", $_POST['neKey'],$cfg['time_ymd']);
	}
}

?>