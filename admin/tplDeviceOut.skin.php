<div class="wrap">
	<h1>티플 단말기 현황 - 출고등록</h1>

	<button type="button"><a href=""><h2>입고등록</h2></a></button>
	<button type="button"><a href=""><h2>출고등록</h2></a></button>

	<div class="wrap_list_input">
		<form action="tplDeviceOutAction.php" method="post">
			<ul>
				<li>출고일<input type="text" name="outDate"></li>		<!-- blocked 시킬 것 -->

				<li>통신사		<!-- blocked 시킬 것 -->
				<input type="radio" class="js-radio" name="carrier" value="skt">SKT
				<input type="radio" class="js-radio" name="carrier" value="kt">KT
				<input type="radio" class="js-radio" name="carrier" value="lg">LGU+
				</li>

<!-- 				<li class="js-goodReceipt">출고처<select name="goodReceipt" id="js-goodReceipt-add">	blocked 시킬 것
		<option value="미래">미래</option>
		<option value="PSN마케팅">PSN마케팅</option>
		<option value="Ktis">Ktis</option>
		<option value="엔트솔">엔트솔</option>
</select><button type="button" class="js-goodReceipt-btn">추가</button></li>
 -->
				<li>기기종류 / 용량<select name="modelCode" id="modelCode">	<!-- tmInventory 에서 값을 가져옴 (모델명)-->
					<?php foreach($modelList as $key => $value) :?>
					<option data-name=<?php echo strtolower($value) ?>><?php echo $value?></option>
				<?php endforeach ?>
				<input type="text" id="searchContent">
				</select>
				</li>

				<li>색상<select name="color" id="color">
					<?php foreach($modelColor as $color) :?>
						<option data-name=<?php echo $value ?>><?php echo $color ?></option>
					<?php endforeach ?>
				</select></li>

				<li>
					<table class="buttonList">
						<tr>일련번호</tr>
						<td class=buttonList_td>
							<input type="text" class="js-SerialNumber-buttonList" name="serialNumber[]">
							<input type="checkbox" class="js-SerialNumber-box" name="checkbox">
							<input type="text" class="test" name="delivery[]" disabled></td> <!-- 클래스 네임 변경 요망  -->
					</table>
					<button type="button" class="js-SerialNumber">추가</button>
				</li>
			</ul>
			<input type="submit" value="출고등록">
		</form>
	</div>
</div>