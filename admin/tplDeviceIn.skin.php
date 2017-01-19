<div class="wrap">
	<h1>티플 단말기 현황 - 입고등록</h1>

	<a href="tplDeviceIn.php" class="btn-filled-primary-dense"><h2>입고등록</h2></a>
	<a href="tplDeviceOut.php" class="btn-filled-primary-dense"><h2>출고등록</h2></a>

	<div class="wrap_list_input">
		<form action="tplDeviceInAction.php" method="post">
			<ul>
				<li>입고일 : <input type="text" name="inDate" value="<?php echo $cfg['time_ymd']?>"><span><i class="ico-caution-small"></i>기입방법) xxxx-xx-xx</span></li>

				<li>통신사 : 		<!-- tplDeviceView 에서 대분류로 구분 짓기 위함 -->
				<input type="radio" class="js-radio js-category" name="carrier" value="sk" checked>SKT
				<input type="radio" class="js-radio js-category" name="carrier" value="kt">KT
				<input type="radio" class="js-radio js-category" name="carrier" value="lg">LGU+
				</li>

<!-- 				<li class="js-">제조사<select name="manuf" id="js-manuf-add">
						<option value="애플">애플</option>
						<option value="삼성">삼성</option>
						<option value="화웨이">화웨이</option>
				</select><button type="button" class="js-manuf-btn">추가</button></li>
 -->
				<li class="js-goodReceipt">입고처 : <select name="goodReceipt" id="js-goodReceipt-add">
				<?php foreach ($chName as $key => $value): ?>
					<option value=<?php echo $value['chName'] ?>><?php echo $value['chName']."(".$value['chCarrier'].")" ?></option>
				<?php endforeach ?>
				</select>
				<label class="inp-chk-dense">
					<input type="checkbox" class="js-category checkbox_return" value="media" name="checkbox_return">
					<div class="inp-chk-box"></div>
					반품자 : 
					<span><i class="ico-caution-small"></i>반품 시 체크</span>
				</label>
	

				<li>기기종류 / 용량 : <select name="modelCode" id="modelCode">	<!-- tmInventory 에서 값을 가져옴 (모델명)-->
					<?php foreach($modelList as $value) :?>
					<option data-name=<?php echo strtolower($value) ?>><?php echo $value?></option>
				<?php endforeach ?>
				<input type="text" id="searchContent">
				<span><i class="ico-caution-small"></i>모델명 검색(sm, iphone)</span>
				</select>
				</li>

				<li>색상 : <select name="color" id="color">
				</select>
				<span><i class="ico-caution-small"></i>모델명의 색상정보 없을 시 빈칸</span>
				</li>

				<li>
					<table class="buttonList">
						<tr>일련번호 : </tr>
						<td class=buttonList_td><input type="text" class="js-SerialNumber-buttonList" name="serialNumber[]">
						<label class="inp-chk-dense">
							<input type="checkbox" class="js-category js-SerialNumber-box" name="checkbox" disabled>
							<div class="inp-chk-box"></div>
						</label>
						<input type="text" class="test" disabled><span><i class="ico-caution-small"></i>출고 전용 기능</span>
						</td>
					</table>
					<br>
					<button type="button" class="js-SerialNumber btn-filled-sub-dense">추가</button>
				</li>
			</ul>
			<input type="submit" value="입고등록" class="btn-filled-primary-dense ">
		</form>
	</div>
</div>
