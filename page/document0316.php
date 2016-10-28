<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/admin.css" type="text/css">';
require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)

$count = DB::queryFirstField("SELECT COUNT(*) FROM tmPreorderNote7 WHERE pnState = 0 and fsKey != 0");
?>
<center>
	<span  class="tit-sub">새로 업로드 & 재업로드 한사람</span><Br/><span class="tit"><?php echo $count ?>명</span><Br/>
	<br/>
	<a href="downloadDocumentmktk.php" onclick="if(confirm('다운로드하시겠습니까?'))return true;else return false;" class="btn-filled-primary">가입신청서 다운로드</a>
</center>

<?
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>