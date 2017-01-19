<div class="wrap apply-wrap center <?echo $editClass?>">
	<h1 class="tit center"><?echo $applyTitle?> 신청서 작성</h1>

	<?php if($isLogged == false) :?>
	<section class="section txt-left js-loginSection">
		<h2 class="tit-sub">남은 별 적립</h2>
		<h3>사은품 선택 후 남은 포인트를 모아<br/><span class="txt-highlight">다른 사은품을 살 수 있습니다.</span></h3>
		<a href="<?php echo $cfg['url']?>/user/login.php?returnURL=<?php echo urlencode($cfg['current_url'])?>" class="btn-filled-sub">로그인/회원가입	</a>
	</section>
	<?php endif?>

	<form action="/product/applyAction.php" method="post" id="apply-form" name="order_info">
		
		<input type="hidden" name="applyTitle" value="<?php echo $applyTitle?>">			
		<? if($_GET['v'] === 'edit') :?>
			<input type="hidden" name="modifyEmail" value="<?php echo $_GET['mbEmail']?>">		
			<input type="hidden" name="v" value="edit">
			<?php echo $planCalculator->create();?>				
			<input type="hidden" name="modifyApkey" value="<?php echo $_GET['apKey']?>">	
			<?if(isExist($isRecommedId) === true) :?>
				<input type="hidden" class="inp-txt" name="recommedID" value="<?php echo $recommedMbEmail?>" />
			<?endif?>
			<br><br>			
		<? else : ?>
		<input type="hidden" name="dvKey" value="<?php echo $_GET['dvKey']?>">
		<?php if (isExist($_GET['capacity'])) :?>
			<input type="hidden" name="capacity" value="<?php echo $_GET['capacity']?>">
		<?php endif?>
		<input type="hidden" name="discountType" value="<?php echo $_GET['discountType']?>">
		<input type="hidden" name="applyType" value="<?php echo $_GET['applyType']?>">
		<input type="hidden" name="carrier" value="<?php echo $_GET['carrier']?>">				
		<input type="hidden" name="dvId" value="<?php echo $_GET['dvId']?>">
		<input type="hidden" name="plan" value="<?php echo $_GET['plan']?>">
		<section class="section-no-padding txt-left">			
			<br>
			<h2 class="tit-sub">&nbsp;&nbsp;&nbsp;신청정보</h2>
			<ul class="inlinelist">
				<li> 
					<span class="label"><i class="ico-person-small"></i> 신청자명</span><span class="cont"><?php echo $mb['mbName']?></span>	
				</li><li>
					<span class="label"><i class="ico-carrier-small"></i> 신청할 통신사</span><span class="cont"><?php echo $deviceInfo->getCarrierName($_GET['carrier'])?></span>				
				</li><li>
					<span class="label"><i class="ico-change-device-small"></i> 가입유형</span><span class="cont"><?php echo $deviceInfo->getApplyTypeName($_GET['applyType'])?></span>		
				</li><li>
					<span class="label"><i class="ico-sale-small"></i> 할인유형</span><span class="cont"><?php echo $deviceInfo->getDiscountTypeName($_GET['discountType'])?></span>	
				</li><?php if (isExist($_GET['capacity'])) :?><li>
					<span class="label"><i class="ico-capacity-small"></i> 용량</span><span class="cont"><?php echo $_GET['capacity']?></span>	
				</li><?php endif?><li>
					<span class="label"><i class="ico-plan-small"></i> 요금제</span><span class="cont"><?php echo $deviceInfo->getPlanName($_GET['plan'])?></span>		
				</li><li>
					<span class="label"><i class="ico-plan-small"></i> 지급포인트</span><span class="cont"><?php echo $totalPoint ?></span>		
				</li>
			</ul>
		</section>
		<?endif?>

		<section class="section txt-left">
			<h2 class="tit-sub">추가정보입력</h2>
			<label class="inp-wrap">
				<i class="ico-tel-small"></i>
				<input type="text" class="inp-txt" name="apPhone" value="<?php echo ($validPhone)?$validPhone:''; ?>" />
				<div class="inp-label">전화번호 <span class="inp-required">필수</span></div>
			</label>
			<br>
			<label class="inp-wrap">
				<i class="ico-calendar-small"></i> 
				<input type="text" class="inp-txt" name="apBirth" value="<?php echo str_replace('-','',$modifyApply['apBirth']); ?>" />
				<div class="inp-label">생년월일 <span class="inp-required">필수</span></div>
				<span class="inp-hint">19701015 형식으로 입력</span>			
			</label>
			<br>
			<label class="inp-wrap">
				<i class="ico-color-small"></i> 
				<input type="text" class="inp-txt" name="apColor" value="<?php echo $modifyApply['apColor'] ?>" />
				<div class="inp-label">색상 <span class="inp-required">필수</span></div>
			</label>

			<!-- 	V20 Event 	 -->
			<?php if($_GET['dvId'] == 'v20'): ?>
			<fieldset class="inp-group" data-default="<?echo $modifyApply['apCurrentCarrier']?>">
				<i class="ico-carrier-small"></i> 혜택 선택 <span class="inp-required">필수</span><br/>
				<label class="inp-chk">
					<input type="radio" name="apBenefits" value="gifts"/>
					<div class="inp-chk-box"></div>
					사은품
				</label>
				<label class="inp-chk">
					<input type="radio" name="apBenefits" value="point"/>
					<div class="inp-chk-box"></div>
					포인트
				</label>
			</fieldset>

			<fieldset class="inp-group" data-default="<?echo $modifyApply['apCurrentCarrier']?>">
				<i class="ico-carrier-small"></i> 구매 방법 <span class="inp-required">필수 / 내방 시 추가 사은품 증정</span><br/>
				<label class="inp-chk">
					<input type="radio" name="apBuyway" value="delivery"/>
					<div class="inp-chk-box"></div>
					내방
				</label>
				<label class="inp-chk">
					<input type="radio" name="apBuyway" value="guest"/>
					<div class="inp-chk-box"></div>
					택배
				</label>
			</fieldset>
		<?php endif ?>
			<!-- 	V20 Event 	 -->

			<?php if($isNeedReferrerChannel === true) :?>
			<fieldset class="inp-group">
				<i class="ico-question-small"></i> 티플에 어디를 통해 들어오셨나요? <span class="inp-required">필수</span><br/>
				<select name="apReferrerChannel" data-default="<?php echo $modifyApply['apReferrerChannel']?>">
					<option value="">유입경로를 선택해주세요.</option>
					<?php foreach($arrReferrerChannel as $channel) :?>
					<option><?php echo $channel?></option>
					<?php endforeach?>
				</select>
				<br/><br/>
			</fieldset>
			<?php endif?>

			<fieldset class="inp-group" data-default="<?echo $modifyApply['apCurrentCarrier']?>">
				<i class="ico-carrier-small"></i> 현재 이용중인 통신사 <span class="inp-required">필수</span><br/>
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
					<input type="radio" name="apCurrentCarrier" value="lguplus"/>
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

		<section class="section-no-padding txt-left js-addressWrap js-showContactBtn">	
				<?php if(isExist($defaultRewardPoint) === true) :?>
				<section class="section">
					<h2 class="tit-sub">추천인 아이디 입력</h2>	
					티플에서 핸드폰 구매 시 추천인 또한 본인이 받는 포인트의 10%를 받습니다.<br>			
					<label class="inp-wrap">	
						<?php if(isExist($isRecommedId) === false) :?>		 
							<input type="text" class="inp-txt" name="recommedID" value="" />
							<div class="inp-label">추천인ID</div>	
						<?else : ?>
							추천인 ID : <span class="txt-highlight"><?php echo $recommedMbEmail?></span>
							<input type="hidden" class="inp-txt" name="recommedID" value="<?php echo $recommedMbEmail?>" />
						<?php endif?>								
					</label>			
					<br>	
					<i class="ico-caution-small"></i>친구 개통 시 본인 또한 그 고객 포인트의 10%를 받습니다.<br>
					<i class="ico-caution-small"></i>그 친구가 친구를 데려오면 그 친구의 포인트 5%를 받습니다.<br>		
					<i class="ico-caution-small"></i>추천인 아이디는 단1회 적용 가능 하오니 신중히 결정해주시기 바랍니다.<br>
					<i class="ico-caution-small"></i>기타문의는 고객센터를 통해 해주시기 바랍니다.<br><br>
				</section>
			<? endif ?>
		</section>
		
		<section class="section apply-cart-empty">
			<div class="vert-wrap">
				<div class="vert-align">					
					<span class="tit-sub">
						<div class="txt-highlight">가입 신청 확인 후 포인트가 지급됩니다.</div>
						포인트몰에서 사은품을 구매해주세요.
					</span>
					<br/><br/>
					<a href="/gifts" target="_blank" class="btn-filled-sub">사은품 보기</a>					
				</div>
			</div>
		</section>	
		<?php if($_GET['v'] === 'edit') :?>
			<input type="submit" class="btn-filled js-trackLink" target="_blank" id="link-detail-plan-apply" value="수정하기"/>
		<?else :?>
		<input type="submit" class="btn-filled js-trackLink" target="_blank" id="link-detail-plan-apply" value="가입 신청"/>
		<?endif?>
		<br/><Br/>
		<section class="section-no-padding txt-left">
			<?php
			include('./detailCaution.skin.php');
			?>
		</section>
	</form>
	<br/><br/>
</div>


<?php $naver->getLoginScriptForApply();?>
<?php $kakao->getLoginScriptForApply();?>