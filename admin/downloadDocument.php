<?
ini_set('max_execution_time', '86400');
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once(PATH_LIB."/lib.zip.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$fileList = DB::query("SELECT * FROM tmPreorderNote7 as a LEFT JOIN tmFileStorage as b ON a.fsKey = b.fsKey WHERE a.pnState = 0");
$zip = new DirectZip();
$zip->open($cfg['time_ymdhis'].' 가입신청서 업로드파일 모음.zip');

//print_r($fileList);
foreach ($fileList as $val) {
	$zip->addFile('/home/www/traumplanet-storage/'.iconv("utf-8","CP949", $val['fsFileName']), $val['fsFileName']);
	DB::update('tmPreorderNote7', array('pnState' => 1), 'mbEmail = %s', $val['mbEmail']);
}

$zip->close();