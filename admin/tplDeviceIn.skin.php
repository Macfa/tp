<div class="wrap-dense">
	<h1>티플 단말기 현황 - 입고등록</h1>

	<a href="tplDeviceIn.php" class="btn-filled-primary-dense">입고등록</a>
	<a href="tplDeviceOut.php" class="btn-filled-primary-dense">출고등록</a>
	<br/><br/>
	<div class="wrap_list_input">
		<form class="js-erpForm" action="tplDeviceInAction.php" method="post">
			<section class="section txt-left">			
				<label class="inp-wrap">
					<i class="ico-calendar-small"></i>
					<input type="text" class="inp-txt" name="inDate" value="<?php echo $cfg['time_ymd']?>" />
					<div class="inp-label">
						입고일 <span class="inp-required">필수</span>
					</div>
					<span class="inp-hint">19921015식으로 입력</span>
				</label>
				<Br/>
				<fieldset class="inp-group">
					<i class="ico-question-small"></i> 입고유형 <span class="inp-required">필수</span><br/>
					<label class="inp-chk-dense">
						<input type="radio" class="js-category checkbox_return" value="" name="checkbox_return" checked>
						<div class="inp-chk-box"></div>
						새입고
					</label>
					<label class="inp-chk-dense">
						<input type="radio" class="js-category checkbox_return" value="media" name="checkbox_return">
						<div class="inp-chk-box"></div>
						반품
					</label>
					<br/>
					<label class="inp-wrap js-returnName" style="display:none">
						<i class="ico-person-small"></i>
						<input type="text" class="inp-txt" name="returnName" />
						<div class="inp-label">
							반품자 <span class="inp-required">필수</span>
						</div>
					</label>
				</fieldset>
				<div class="js-newInWrap">
					<fieldset class="inp-group">
						<i class="ico-question-small"></i> 입고처 <span class="inp-required">필수</span><br/>
						<select name="goodReceipt">
							<option value="">입고처를 선택해주세요.</option>
							<?php foreach ($chName as $key => $value): ?>
							<option value="<?php echo $value['chKey'] ?>"><?php echo $value['chName']."(".$value['chCarrier'].")" ?></option>
							<?php endforeach ?>
						</select>
						<br/><br/>
					</fieldset>
					<fieldset class="inp-group">
						<i class="ico-carrier-small"></i> 통신사 <span class="inp-required">필수</span><br/>
						<label class="inp-chk">
							<input type="radio" name="carrier" value="sk"/>
							<div class="inp-chk-box"></div>
							SKT
						</label>
						<label class="inp-chk">
							<input type="radio" name="carrier" value="kt"/>
							<div class="inp-chk-box"></div>
							KT olleh
						</label>
						<label class="inp-chk">
							<input type="radio" name="carrier" value="lguplus"/>
							<div class="inp-chk-box"></div>
							LG U+
						</label>
					</fieldset>
					<fieldset class="inp-group">
						<i class="ico-phone-small"></i> 기종 <span class="inp-required">필수</span><br/>
						<label class="inp-wrap">
							<input type="text" class="inp-txt" id="searchContent"/>
							<div class="inp-label">기종 검색</div>
						</label>
						<br/>
						<select name="modelCode" id="modelCode">
							<option value="">기종을 선택해주세요.</option>
							<?php foreach($modelList as $value) :?>
								<option data-name=<?php echo strtolower($value) ?>><?php echo $value?></option>
							<?php endforeach ?>
						</select>
						<br/><br/>
					</fieldset>
					<fieldset class="inp-group">
						<i class="ico-color-small"></i> 색상 <span class="inp-required">필수</span><br/>
						<select name="color" id="color">
							<option value="">색상을 선택해주세요.</option>
						</select>
						<br/><br/>
					</fieldset>		
				</div>		
				<h2 class="tit-sub">입고될 일련번호</h2>		
				<div class="js-serialListWrap">
				</div>
				<Br/>
				<button type="button" class="js-SerialNumber btn-filled-sub-dense">추가</button>
			</section>
			<span><i class="ico-caution-small"></i> 등록시 오류가 나면 다른 정상적인 일련번호도 등록되지 않습니다.</span>
			<Br/>
			<input type="submit" value="입고등록" class="btn-filled-primary-dense ">
		</form>
	</div>
</div>

<script id="js-serialWrapTemplate" type="text/x-template">
	<div class="js-serialWrap">
		<input type="text" class="js-SerialNumber-buttonList" name="serialNumber[]" style="height:40px;width:300px" placeholder="일련번호">
		<button type="button" tabindex="-1" class="btn-delete js-deleteSerialInput" style="vertical-align: middle;"><i></i></button>
	</div>
</script>