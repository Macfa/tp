<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB.'/lib.snoopy.inc.php');
include_once(PATH_LIB.'/lib.htmlDOM.inc.php');
include_once(PATH_LIB.'/lib.parsing.inc.php');

try
{
	if(isExist($_POST) === false) // 버튼눌러서 들어온게 아니라 그냥 페이지 링크연결시
		throw new Exception('마이페이지에서 실가입버튼을 눌러주세요');

}
catch(Exception $e)
{
    alert($e->getMessage());
}


$applyUrl = $_POST['applyUrl'];
$rexURL = '/http:\/\/online\.olleh\.com\/index\.jsp\?prdcID=(.*)$/';	
preg_match($rexURL, $applyUrl, $code);				
$urlCode = preg_replace("/\s+/","",$code[1]);

$parsing = getParsing('https://online.olleh.com:8090/BizFormPrdcInfo.action?prdcID='.$urlCode);

$html = str_get_html($parsing);
	foreach($html->find('input[type=hidden]') as $element) {
		$name = $element->name;
		$value = $element->value;
		$input[$name] = $value;
	}

$snoopy = new snoopy;

$snoopy->httpmethod = "POST"; 
$snoopy->submit("https://online.olleh.com:8090/BizFormIntro.action",$input); 

$actionParsing = $snoopy->results;

$actionHtml = str_get_html($actionParsing);
	foreach($actionHtml->find('input[type=hidden]') as $e) {
		$name = $e->name;
		$value = $e->value;
		$KTInfo[$name] = $value;
	}

$applyType = $KTInfo['basicFrmType'];

switch ($applyType) {
	case 'G005':
		$typeText = '신규가입';
		break;
	case 'G006':
		$typeText = '번호이동';
		break;
	case 'G007':
		$typeText = '보상기변';
		break;
	
}

require_once($cfg['path']."/headBlank.inc.php");
if($applyType === 'G007'){
	require_once("submitKT06.skin.php"); 
}elseif($applyType === 'G005'|| $applyType === 'G006'){
	require_once("submitKT.skin.php"); 
}else{
	goURL('https://online.olleh.com:8090/BizFormPrdcInfo.action?prdcID='.$urlCode);
}

require_once($cfg['path']."/footBlank.inc.php"); 

?>