<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
require_once(PATH_LIB."/lib.upload.inc.php");
?>
<script type="text/javascript" src="<?=PATH_JS_LIB?>/jquery.js"></script>
<?

if (!$isLogged) {
	$returnURL = urlencode('/page/preOrderNote7.php');
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\"><script>alert('로그인 후 업로드 해주세요');parent.location.href = '".$cfg['url']."/user/login.php?returnURL=".$returnURL."';</script>";
	exit;
}

try
{
	if($_FILES['preorderDocument']['error'] > 0) {
		throw new Exception(getUploadErrorMessage($_FILES['preorderDocument']['error']));
	}

	if(isValidExt($_FILES['preorderDocument'], 'zip,rar,7z,alz') === FALSE) {
		throw new Exception('zip,rar,7z,alz 확장자만 업로드 가능합니다.');
	}

	$allowedMime = array('application/x-zip-compressed', 'application/zip', 'application/x-compressed', 'application/x-rar-compressed', 'application/x-7z-compressed', 'application/octet-stream');
	if(in_array($_FILES['preorderDocument']['type'], $allowedMime) === FALSE) {
		throw new Exception('잘못된 압축파일입니다.');
	}
}
catch(Exception $e)
{
	echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
	echo "<script>alert('".$e->getMessage()."');</script>";
	echo "<script>parent.$('.js-alert').hide();</script>";
	exit;
}

$originalFileName = $_FILES['preorderDocument']['name'];
$extension = explode('.', $_FILES['preorderDocument']['name']);
$extension = $extension[count($extension)-1];
$uft8FileName = $mb['mbEmail'].'_'.$mb['mbName'].'_'.$mb['mbPhone'].'_'.pwEncrypt($mb['mbName'].time()).'.'.$extension;
$_FILES['preorderDocument']['name'] = $uft8FileName;

$upload = Upload::factory('/home/www/traumplanet-storage');
$upload->file($_FILES['preorderDocument']);
$upload->upload();


if ($upload->get_status() === true) {

	DB::insert('tmFileStorage', 
		array(
			'fsFileName' => $uft8FileName,
			'fsOriginalName' => $originalFileName, 
			'fsDatetime' => $cfg['time_ymdhis']
		)
	);
	$fsKey = DB::insertId();

	DB::insertUpdate('tmPreorderNote7', 
		array(
			'mbEmail' => $mb['mbEmail'], 
			'fsKey' => $fsKey,
			'pnDatetime' => $cfg['time_ymdhis']
		),
		array(
			'fsKey' => $fsKey,
			'pnDatetime' => $cfg['time_ymdhis'],
			'pnState' => 0
		)
	);
	echo "<script>alert('성공적으로 업로드되었습니다!');parent.$('.js-uploadDone').show();</script>";
	echo "<script>parent.$('.js-alert').hide();</script>";
}
