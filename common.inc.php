<?
error_reporting(E_ALL ^ E_NOTICE);
ini_set( 'display_errors', true );


	
////////////////////////////////// 세션설정


ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
ini_set("session.cookie_lifetime", 0); 
ini_set("session.cache_expire", 86400); 
ini_set("session.gc_maxlifetime", 86400);
ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)
session_start();
//session_save_path("{$cfg['path']}/data/session");

////////////////////////////////// 기본설정

$cfg = array();

// url 의 쿼리스트링 부분 중 빈값인 것 정리
substr(preg_replace('/(&[^&]+=[^&]+)|./','$1','&'.$_SERVER['QUERY_STRING']),1);

$cfg['path'] = $cfg_path;
unset($cfg_path);
if(!$cfg['path']) $cfg['path'] = '.';

require_once("{$cfg['path']}/lib/config.inc.php"); // 기본 설정 라이브러리
require_once("{$cfg['path']}/lib/lib.inc.php"); // 공통 라이브러리

//html fixer
$htmlFixer = new HtmlFixer();

//날짜 설정
$tmp_today = get_today();
$cfg = array_merge($cfg, $tmp_today);

////////////////////////////////// 보안설정

$_POST = filtering($_POST);
$_GET = filtering($_GET);
$_SERVER = filtering($_SERVER);
$_SESSION = filtering($_SESSION);
$_COOKIE = filtering($_COOKIE);
$isNaverLogin = FALSE;
$isKakaoLogin = FALSE;
$isSnsLogin = false;
$isAdmin = FALSE;
$isLogged = false;

////////////////////////////////// DB 설정

$naver = new Naver(array(
	"CLIENT_ID" => "KM7wCts84UGl2si0850V",        // (*필수)클라이언트 ID  
	"CLIENT_SECRET" => "mp9JViDXkA",    // (*필수)클라이언트 시크릿
	"RETURN_URL" => $cfg['url']."/user/snsLogin.php",      // (*필수)콜백 URL
	"AUTO_CLOSE" => false,              // 인증 완료후 팝업 자동으로 닫힘 여부 설정 (추가 정보 기재등 추가행동 필요시 false 설정 후 추가)
	"SHOW_LOGOUT" => false              // 인증 후에 네이버 로그아웃 버튼 표시/ 또는 표시안함
	)
);
$kakao = new Kakao(array(
	"CLIENT_ID" => "df2c4884d412d325a741558d23ec1ce6",        // (*필수)클라이언트 ID  
	"CLIENT_SECRET" => "c032737f8753f55348c39bcfd28b2a93",    // (*필수)클라이언트 시크릿
	"RETURN_URL" => $cfg['url']."/user/snsLogin.php",      // (*필수)콜백 URL
	"AUTO_CLOSE" => false,              // 인증 완료후 팝업 자동으로 닫힘 여부 설정 (추가 정보 기재등 추가행동 필요시 false 설정 후 추가)
	"SHOW_LOGOUT" => false              // 인증 후에 네이버 로그아웃 버튼 표시/ 또는 표시안함
	)
);

if ($naver->getConnectState()){
	$isNaverLogin = TRUE;
	$isSnsLogin = TRUE;
}
if ($kakao->getConnectState()){
	$isKakaoLogin = TRUE;
	$isSnsLogin = TRUE;
}
DB::$usenull = false;
if (getSession('tmLoggedId')){
	$isLogged = TRUE;
	$mb = DB::queryFirstRow("SELECT * FROM tmMember WHERE mbEmail=%s", getSession('tmLoggedId'));
	if ($mb['mbAdmin'] == 1) {
		$isAdmin = TRUE;
	}
}

$userAgent = new parseUserAgent();
