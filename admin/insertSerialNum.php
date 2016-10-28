<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/admin.css" type="text/css">';
require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)
?>
<div class="tit-sub center">
엑셀에서<br/>
<span style="color:red;">A열에만</span> <span style="color:red;">일련번호</span>를 넣어<br/>
입력칸에 복붙해주세요!<br/>
</div>
<br/>
<img src="<?php echo PATH_IMG?>/ex.jpg"/>
<br/><form class="trackingNum" action="insertSerialNumUpdate.php" method="post" style="padding:auto; text-align:center;" >
	<h2 class="trackingNum-tit" style="font-size:2.5em; font-weight:bold; ">반드시 엑셀파일에서 <span class="trackingNum-bold" style="color:red;">복사&붙여넣기</span>해주세요!</h2>
	<textarea name="input" style="width:600px; height:500px; background-color:white; font-size:0.8em; padding:auto; overflow:scroll; "></textarea><br/>
<input type="submit" value="전송" class="btn-filled-primary">
</form>

<?
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>