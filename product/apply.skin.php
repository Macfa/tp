<div class="wrap apply-wrap center">
	<h1 class="tit center"><?echo $applyTitle ?> 신청서 작성</h1>

	<?php if($isLogged == false) :?>
	<section class="section txt-left js-loginSection">
		<h2 class="tit-sub">남은 별 적립</h2>
		<h3>사은품 선택 후 남은 포인트를 모아<br/><span class="txt-highlight">다른 사은품을 살 수 있습니다.</span></h3>
		<a href="<?php echo $cfg['url']?>/user/login.php?returnURL=<?php echo urlencode($cfg['current_url'])?>" class="btn-filled-sub">로그인/회원가입	</a>
	</section>
	<?php endif?>

	<form action="/product/applyAction.php" method="post" id="apply-form" name="order_info">
		<input type="hidden" name="dvKey" value="<?php echo $_GET['dvKey']?>">
		<?php if (isExist($_GET['capacity'])) :?>
		<input type="hidden" name="capacity" value="<?php echo $_GET['capacity']?>">
		<?php endif?>
		<input type="hidden" name="discountType" value="<?php echo $_GET['discountType']?>">
		<input type="hidden" name="applyType" value="<?php echo $_GET['applyType']?>">
		<input type="hidden" name="carrier" value="<?php echo $_GET['carrier']?>">
		<input type="hidden" name="plan" value="<?php echo $_GET['plan']?>">

		<section class="section txt-left">
			<h2 class="tit-sub">신청정보</h2>

			<ul class="inlinelist">
				<li> 
					<span class="label"><i class="ico-person-small"></i> 신청자명</span><span class="cont"><?php echo $mb['mbName']?></span>	
				</li><li>
					<span class="label"><i class="ico-carrier-small"></i> 신청통신사</span><span class="cont"><?php echo $deviceInfo->getCarrierName($_GET['carrier'])?></span>				
				</li><li>
					<span class="label"><i class="ico-change-device-small"></i> 가입유형</span><span class="cont"><?php echo $deviceInfo->getApplyTypeName($_GET['applyType'])?></span>		
				</li><li>
					<span class="label"><i class="ico-person-small"></i> 할인유형</span><span class="cont"><?php echo $deviceInfo->getDiscountTypeName($_GET['discountType'])?></span>	
				</li><?php if (isExist($_GET['capacity'])) :?><li>
					<span class="label"><i class="ico-person-small"></i> 용량</span><span class="cont"><?php echo $_GET['capacity']?></span>	
				</li><?php endif?><li>
					<span class="label"><i class="ico-person-small"></i> 요금제</span><span class="cont"><?php echo $deviceInfo->getPlanName($_GET['plan'])?></span></span>		
				</li><li>
					<span class="label"><i class="ico-person-small"></i> 지급포인트</span><span class="cont"><?php echo number_format($totalPoint) ?></span></span>		
				</li>
			</ul>
		</section>

		<section class="section txt-left">
			<h2 class="tit-sub">추가정보입력</h2>
			<label class="inp-wrap">
				<i class="ico-tel-small"></i>
				<input type="text" class="inp-txt" name="apPhone" value="<?php echo ($validPhone)?$validPhone:''; ?>" />
				<div class="inp-label">전화번호</div>
			</label>
			<br>
			<label class="inp-wrap">
				<i class="ico-calendar-small"></i> 
				<input type="text" class="inp-txt" name="apBirth" value="<?php echo str_replace('-','',$preorder['pvBirth']); ?>" />
				<div class="inp-label">생년월일</div>
				<span class="inp-hint">19701015 형식으로 입력</span>
			</label>
			<br>
			<label class="inp-wrap">
				<i class="ico-color-small"></i> 
				<input type="text" class="inp-txt" name="apColor" value="" />
				<div class="inp-label">색상</div>
			</label>
			<fieldset class="inp-group">
				<i class="ico-carrier-small"></i> 현재 이용중인 통신사 <br/>
				<label class="inp-chk">
					<input type="radio" name="apCurrentCarrier" value="sk"/>
					<div class="inp-chk-box"></div>
					SKT
				</label>
				<label class="inp-chk">
					<input type="radio" name="apCurrentCarrier" value="kt"/>
					<div class="inp-chk-box"></div>
					KT olleh
				</label>
				<label class="inp-chk">
					<input type="radio" name="apCurrentCarrier" value="lg"/>
					<div class="inp-chk-box"></div>
					LG U+
				</label>
				<label class="inp-chk">
					<input type="radio" name="apCurrentCarrier" value="etc"/>
					<div class="inp-chk-box"></div>
					알뜰폰
				</label>
			</fieldset>
			<!--label class="inp-wrap">
				<i class="ico-talk-small"></i>
				<textarea name="pvEtc" class="inp-txtarea" ></textarea>
				<div class="inp-label">기타사항 & 요구사항</div>
			</label-->
		</section>
		<section class="apply-cart-empty section">
			<div class="vert-wrap">
				<div class="vert-align">				
					<span class="tit-sub">가입신청후 포인트몰에서 사은품을 구매해주세요.</span>
					<br><br>
					<a href="/gifts" target="_blank" class="btn-filled-sub-dense">사은품보기</a>								
				</div>
			</div>
		</section>				
		<input type="submit" class="btn-filled" value="가입 신청""/>	
	</form>
</div>


<?php $naver->getLoginScriptForApply();?>
<?php $kakao->getLoginScriptForApply();?>