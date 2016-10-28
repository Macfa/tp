<?
ini_set('max_execution_time', '0');
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once(PATH_LIB."/lib.zip.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$fileList = DB::query("SELECT * FROM tmFileStorage as a LEFT JOIN tmPreorderNote7 as b ON a.fsKey = b.fsKey WHERE b.pnState = 0");
$zip = new DirectZip();
$zip->open($cfg['time_ymdhis'].' 가입신청서 업로드파일 모음.zip');

foreach ($fileList as $val) {
	if (isNullVal($val['fsFileName'])) continue;
	//echo '<pre>';
	//print_r($val);
	//echo '</pre><br/>';
	if (file_exists('/home/www/traumplanet-storage/'.$entry))
		$zip->addFile('/home/www/traumplanet-storage/'.$val['fsFileName'], $val['fsKey'].'_'.$val['fsFileName']);
	DB::update('tmPreorderNote7', array('pnState' => 1), 'mbEmail = %s', $val['mbEmail']);
}

$zip->close();
