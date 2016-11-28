<?

/////////////////////////////////////////////////////////////////////
//																					//
//			 기본적인 변수/상수 설정										//
//																					//
/////////////////////////////////////////////////////////////////////


if (function_exists("date_default_timezone_set"))
    date_default_timezone_set("Asia/Seoul");

$mysql['host'] = 'localhost';
$mysql['user'] = 'mktptraumplanet';
$mysql['password'] = 'tptm95250319';
$mysql['db'] = 'traummobile';

////////////////////////////////////////////////////////// 기본설정

$cfg['charset'] = "utf-8";
//if ($_DEV) $cfg['url'] = "http://127.0.0.1";

$cfg['current_url'] = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
// 개발환경인지 아닌지 확인
$cfg['subURL'] = $_SERVER["HTTP_HOST"];
$cfg['url'] = "http://".$cfg['subURL'];
$cfg['full_url'] = $cfg['url'].$_SERVER['PHP_SELF'];
$cfg['ip'] = $_SERVER['REMOTE_ADDR'];
$cfg['login_url'] = $cfg['url']."/user/login.php?returnURL=".urlencode($cfg['full_url']);


//테이블 명 설정


//시간 설정
$cfg['server_time'] = time();
$cfg['time_ymd']    = date("Y-m-d", $cfg['server_time']);
$cfg['time_his']    = date("H:i:s", $cfg['server_time']);
$cfg['time_ymdhis'] = date("Y-m-d H:i:s", $cfg['server_time']);
$cfg['time_ym']    = date("Y-m", $cfg['server_time']);
$cfg['time_y']    = date("Y", $cfg['server_time']);
$cfg['time_nextday'] = date("Y-m-d", $cfg['server_time']+86400);
$cfg['authentication'] = 'Vj7Xzhs4H5UtLdvxE9rKEnB84cqhbWnCLBepSKTZezjthAcpWph6QLjPxB6kJLa6wfdQfpNVTUBvTAQmvtM3f8ghqHkeLzYEDZ4s';

//디렉토리 설정
$cfg['prd_dir'] = "product";
$cfg['img_dir'] = "img";
$cfg['common_dir'] = "common";
$cfg['lib_dir'] = "lib";
$cfg['js_dir'] = "js";
$cfg['css_dir'] = "css";
$cfg['user_dir'] = "user";
$cfg['personalTest'] = "personalTest";

//경로 설정
$cfg['prd_path'] = $cfg['path']."/".$cfg['prd_dir'];
$cfg['user_path'] = $cfg['path']."/".$cfg['user_dir'];
$cfg['img_path'] = $cfg['url']."/".$cfg['img_dir'];
$cfg['common_path'] = $cfg['path']."/".$cfg['common_dir'];
$cfg['lib_path'] = $cfg['path']."/".$cfg['lib_dir'];
$cfg['js_path'] =	$cfg['path']."/".$cfg['js_dir'];
$cfg['css_path'] =	$cfg['path']."/".$cfg['css_dir']."/compiled";
$cfg['img_storage'] =	"/home/www/tplanit/img-storage/";


define("META_CHARSET", "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">");
define("PATH_PRD", $cfg['prd_path']);
define("PATH_USER", $cfg['user_path']);
define("PATH_IMG", $cfg['img_path']);
define("PATH_STELLA_IMG", $cfg['img_path'].'/stella');
define("PATH_COMMON", $cfg['common_path']);
define("PATH_LIB", $cfg['lib_path']);
define("PATH_JS", $cfg['js_path']);
define("PATH_JS_LIB", $cfg['js_path']."/lib");
define("PATH_CSS", $cfg['css_path']);
define("PATH", $cfg['path']);
define("URL", $cfg['url']);
define("ABSOLUTE_PATH", $_SERVER['DOCUMENT_ROOT']);
define("PATH_IMG_STORAGE", $cfg['img_storage']);







