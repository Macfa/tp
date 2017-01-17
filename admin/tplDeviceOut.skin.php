<div class="wrap">
	<h1>티플 단말기 현황 - 출고등록</h1>

	<a href="tplDeviceIn.php" class="btn-filled-primary-dense"><h2>입고등록</h2></a>
	<a href="tplDeviceOut.php" class="btn-filled-primary-dense"><h2>출고등록</h2></a>

	<div class="wrap_list_input">
		<form action="tplDeviceOutAction.php" method="post">
			<ul>
				<li>출고일 : <input type="text" name="outDate" value="<?php echo $cfg['time_ymd']?>"><span><i class="ico-caution-small"></i>기입방법) xxxx-xx-xx</span></li>		<!-- blocked 시킬 것 -->

<!-- 				<li class="js-goodReceipt">출고처<select name="goodReceipt" id="js-goodReceipt-add">	blocked 시킬 것
		<option value="미래">미래</option>
		<option value="PSN마케팅">PSN마케팅</option>
		<option value="Ktis">Ktis</option>
		<option value="엔트솔">엔트솔</option>
</select><button type="button" class="js-goodReceipt-btn">추가</button></li>
 -->
				<li>
					<table class="buttonList">
						<tr>일련번호 : </tr>
						<td class=buttonList_td>
							<input type="text" class="js-SerialNumber-buttonList" name="serialNumber[]">
							<label class="inp-chk-dense">
								<input type="checkbox" class="js-category js-SerialNumber-box" name="checkbox" disabled>
								<div class="inp-chk-box"></div>
							</label>
							<input type="text" class="test" name="delivery[]" disabled><span><i class="ico-caution-small"></i>키워드 존재 시 해제</span></td> <!-- 클래스 네임 변경 요망  -->
					</table>
					<br>
					<button type="button" class="js-SerialNumber btn-filled-sub-dense">추가</button>
				</li>
			</ul>
			<input type="submit" value="출고등록" class="btn-filled-primary-dense">
		</form>
	</div>
</div>
