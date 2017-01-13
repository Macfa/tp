<div class="wrap">
	<h1>티플 단말기 현황 - 입고등록</h1>

	<a href="tplDeviceIn.php" class="btn-filled-primary-dense"><h2>입고등록</h2></a>
	<a href="tplDeviceOut.php" class="btn-filled-primary-dense"><h2>출고등록</h2></a>

	<div class="wrap_list_input">
		<form action="tplDeviceInAction.php" method="post">
			<ul>
				<li>입고일<input type="text" name="inDate"></li>

				<li>통신사		<!-- tplDeviceView 에서 대분류로 구분 짓기 위함 -->
				<input type="radio" class="js-radio js-category" name="carrier" value="skt">SKT
				<input type="radio" class="js-radio js-category" name="carrier" value="kt">KT
				<input type="radio" class="js-radio js-category" name="carrier" value="lg">LGU+
				</li>

<!-- 				<li class="js-">제조사<select name="manuf" id="js-manuf-add">
						<option value="애플">애플</option>
						<option value="삼성">삼성</option>
						<option value="화웨이">화웨이</option>
				</select><button type="button" class="js-manuf-btn">추가</button></li>
 -->
				<li class="js-goodReceipt">입고처<select name="goodReceipt" id="js-goodReceipt-add">
						<option value="미래대리점">미래</option>
						<option value="PSN마케팅">PSN마케팅</option>
						<option value="Ktis">Ktis</option>
						<option value="엔트솔">엔트솔</option>
						<option value="KT본사">KT본사</option>
				</select>
				<label class="inp-chk-dense">
					<input type="checkbox" class="js-category checkbox_return" value="media" name="checkbox_return">
					<div class="inp-chk-box"></div>
					반품자
				</label>
	

				<li>기기종류 / 용량<select name="modelCode" id="modelCode">	<!-- tmInventory 에서 값을 가져옴 (모델명)-->
					<?php foreach($modelList as $value) :?>
					<option data-name=<?php echo strtolower($value) ?>><?php echo $value?></option>
				<?php endforeach ?>
				<input type="text" id="searchContent">
				</select>
				</li>

				<li>색상<select name="color" id="color">
				</select></li>

				<li>
					<table class="buttonList">
						<tr>일련번호</tr>
						<td class=buttonList_td><input type="text" class="js-SerialNumber-buttonList" name="serialNumber[]">
						<label class="inp-chk-dense">
							<input type="checkbox" class="js-category js-SerialNumber-box" name="checkbox">
							<div class="inp-chk-box"></div>
						</label>
						<input type="text" class="test" disabled></td>
					</table>
					<br>
					<button type="button" class="js-SerialNumber btn-filled-primary-dense">추가</button>
				</li>
			</ul>
			<input type="submit" value="입고등록" class="btn-filled-primary-dense">
		</form>
	</div>
</div>
