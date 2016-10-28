<?
$cfg_path = '..';
require_once($cfg_path."/common.inc.php");

if($isLogged === false)
	alert('잘못된접근입니다', '/user/login.php?returnURL='.urlencode($cfg['current_url']));
else if($isAdmin === FALSE)
	alert('잘못된접근입니다');

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mk.css" type="text/css">';