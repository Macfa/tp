<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/admin.css" type="text/css">';
require_once($cfg['path']."/headSimple.inc.php");			// 헤더 부분 (스킨포함)
?>

<div class="tit-sub center">
엑셀에서<br/>
<span style="color:red;">A열</span>은 <span style="color:red;">이름</span><br/>
<span style="color:blue;">B열</span>은 <span style="color:blue;">휴대폰번호</span><br/>
<span style="color:green;">C열</span>은 <span style="color:green;">송장번호</span>를 넣어<br/>
입력칸에 복붙해주세요!<br/>
</div>
<br/>
<img src="<?php echo PATH_IMG?>/ex2.jpg"/>
<br/><form class="trackingNum" action="insertTrackingNumAction.php" method="post" style="padding:auto; text-align:center;" >
	<h2 class="trackingNum-tit" style="font-size:2.5em; font-weight:bold; ">반드시 엑셀파일에서 <span class="trackingNum-bold" style="color:red;">복사&붙여넣기</span>해주세요!</h2>
	<textarea name="input" style="width:600px; height:500px; background-color:white; font-size:0.8em; padding:auto; overflow:scroll; "></textarea><br/>
<input type="submit" value="전송" class="btn-filled-primary">
</form>

	<!--이름 <input type="text" name="mbName"/><Br/>
	휴대폰번호(반드시 폰번) <input type="text" name="mbPhone"/><Br/>
	송장번호 <input type="text" name="pnDeviceTracking"/><Br/>
<input type="submit" value="전송" style="background-color:#febf33; font-weight:bold;"-->


<?
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
?>