<div class="wrap apply-wrap center">
	<h1 class="tit center">신청서 작성</h1>

	<?php if($isLogged == false) :?>
	<section class="section txt-left js-loginSection">
		<h2 class="tit-sub">남은 별 적립</h2>
		<h3>사은품 선택 후 남은 포인트를 모아<br/><span class="txt-highlight">다른 사은품을 살 수 있습니다.</span></h3>
		<a href="<?php echo $cfg['url']?>/user/login.php?returnURL=<?php echo $cfg['current_url']?>" class="btn-filled-sub">로그인/회원가입	</a>
	</section>
	<?php endif?>

	<form action="/product/applyAction.php" method="post" id="apply-form">
	<input type="hidden" name="dvKey" value="<?php echo $_POST['dvKey']?>">
	<?php if (isExist($_POST['capacity'])) :?>
	<input type="hidden" name="capacity" value="<?php echo $_POST['capacity']?>">
	<?php endif?>
	<input type="hidden" name="discountType" value="<?php echo $_POST['discountType']?>">
	<input type="hidden" name="applyType" value="<?php echo $_POST['applyType']?>">
	<input type="hidden" name="carrier" value="<?php echo $_POST['carrier']?>">
	<input type="hidden" name="plan" value="<?php echo $_POST['plan']?>">

	<section class="section txt-left">
		<h2 class="tit-sub">신청정보</h2>
		<i class="ico-person-small"></i> 신청자명 <Br/> <span><?php echo $mb['mbName']?></span><br/><br/>

		<i class="ico-carrier-small"></i> 신청할 통신사
		<Br/><br/>
		<span><?php echo $deviceInfo->getCarrierName($_POST['carrier'])?></span><br/><br/>

		<i class="ico-change-device-small"></i> 가입유형
		<Br/><br/>
		<span><?php echo $deviceInfo->getApplyTypeName($_POST['applyType'])?></span><br/><br/>

		<i class="ico-person-small"></i> 할인유형
		<Br/><br/>
		<span><?php echo $deviceInfo->getDiscountTypeName($_POST['discountType'])?></span><br/><br/>

		<?php if (isExist($_POST['capacity'])) :?>
		<i class="ico-person-small"></i> 용량
		<Br/><br/>
		<span><?php echo $_POST['capacity']?></span><br/><br/>
		<?php endif?>

		<i class="ico-person-small"></i> 요금제
		<Br/><br/>
		<span><?php echo $deviceInfo->getPlanName($_POST['plan'])?></span><br/><br/>
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
			<input type="text" class="inp-txt" name="color" value="" />
			<div class="inp-label">색상</div>
		</label>
		<fieldset class="inp-group">
			<i class="ico-carrier-small"></i> 현재 이용중인 통신사 <br/>
			<label class="inp-chk">
				<input type="radio" name="current" value="sk"/>
				<div class="inp-chk-box"></div>
				SKT
			</label>
			<label class="inp-chk">
				<input type="radio" name="current" value="kt"/>
				<div class="inp-chk-box"></div>
				KT olleh
			</label>
			<label class="inp-chk">
				<input type="radio" name="current" value="lg"/>
				<div class="inp-chk-box"></div>
				LG U+
			</label>
			<label class="inp-chk">
				<input type="radio" name="current" value="etc"/>
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
		<section class="js-addressDetail address-detail active">
			<h2 class="tit-sub">사은품 받을 주소</h2>
			<input type="hidden" class="js-arKey" name="arKey" value="<?php echo $defAddress['arKey']?>" />
			<label class="inp-wrap">
				<input type="text" class="inp-txt js-tit" name="arTit" value="<?php echo $defAddress['arTit']?>" />
				<div class="inp-label">주소지 명</div>
			</label>
			<br/>
			<label class="inp-wrap">
				<input type="text" class="inp-txt js-name" name="arName" value="<?php echo $defAddress['arName']?>" data-parsley-required/>
				<div class="inp-label">주문자 명 <span class="inp-required">필수</span></div>
			</label>
			<br/>
			<label class="inp-wrap">
				<input type="text" class="inp-txt js-phone" name="arPhone" value="<?php echo $defAddress['arPhone']?>" data-parsley-required/>
				<div class="inp-label">연락처 <span class="inp-required">필수</span></div>
			</label>
			<label class="inp-wrap">
				<input type="text" class="inp-txt js-tel" name="arTel" value="<?php echo $defAddress['arTel']?>" />
				<div class="inp-label">추가 연락처</div>
			</label>
			<br/>
			<label class="inp-wrap">
				<input type="text" class="inp-txt js-postcode" name="arPostcode" value="<?php echo $defAddress['arPostcode']?>" data-parsley-required/>
				<div class="inp-label">우편번호 <span class="inp-required">필수</span></div>
			</label>
			<br/>
			<label class="inp-wrap-full">
				<input type="text" class="inp-txt js-address" name="arAddress" value="<?php echo $defAddress['arAddress']?>" data-parsley-required/>
				<div class="inp-label">주소 <span class="inp-required">필수</span></div>
			</label>
			<label class="inp-wrap-full">
				<input type="text" class="inp-txt js-subAddress" name="arSubAddress" value="<?php echo $defAddress['arSubAddress']?>" data-parsley-required/>
				<div class="inp-label">상세주소 <span class="inp-required">필수</span></div>
			</label>
			<div class="js-postcodeSearchWrap" id="postcode-search-wrap"></div>
		</section>
		<section class="js-addresslist address-list">
			<table class="table-clickable no-border">
			<caption>주소선택</caption>
			<thead>
			<tr class="table-item-str">
				<td>주소지 명</td>
				<td>수령자 명</td>
				<td>연락처</td>
				<td>추가 연락처</td>
				<td></td>
			</tr>
			</thead>
			<tbody>
			<?php foreach($arrAddress as $val) :?>
			<tr class="table-item-str address js-addressRow js-addressRow<?php echo $val['arKey']?>" data-key="<?php echo $val['arKey']?>">
				<td>
					<?php echo $val['arTit']?>
					<div class="address-list-addr">[<?php echo $val['arPostcode']?>] <?php echo $val['arAddress'].' '.$val['arSubAddress']?></div>
					<span class="address-default"><?php echo ($val['arIsDefault'])?'기본':'';?></span>
				</td>
				<td><?php echo $val['arName']?></td>
				<td><?php echo $val['arPhone']?></td>
				<td><?php echo $val['arTel']?></td>
				<td class="action-wrap">
					<label class="inp-label">
						<button class="btn-delete js-addressDelete" data-key="<?php echo $val['arKey']?>" formnovalidate><i></i></button>
					</label>
				</td>
			</tr>
			<?php endforeach?>
			</tbody>
			</table>
		</section>
		<div class="address-action">
			<label class="inp-chk-dense js-addressDetailAction active">
				<input type="checkbox" class="js-defaultAddress" value="1" name="setDefaultAddress"/>
				<div class="inp-chk-box"></div>
				<div>기본 주소 설정</div>
			</label>
			<label class="inp-chk-dense js-addressDetailAction active">
				<input type="checkbox" class="js-saveAddress" value="1" name="saveAddress" />
				<div class="inp-chk-box"></div>
				저장
			</label>
			<button class="btn-filled-sub-dense js-addressDetailAction js-otherAddress active">다른 주소</button>
			<button class="btn-filled-sub-dense js-addressListAction js-newAddress">새 주소</button>
		</div>
	</section>

	<section class="js-showContactBtn apply-cart-list js-applyCartList">
		<table class="table no-border">
		<caption>주문 할 사은품</caption>
		<thead>
			<tr>
				<td class="table-item-str">사은품 명</td>
				<td>
					수량
					<div class="table-hint">클릭하여 수량 수정 가능</div>
				</td>
				<td></td>
				<td>개당 별</td>
				<td></td>
				<td>구매 별</td>
				<td></td>
			</tr>
		</thead>
		<tbody class="js-applyCartWrap"></tbody>
		</table>
		<section class="apply-cart-empty">
			<div class="vert-wrap">
				<div class="vert-align">
					<span class="tit-sub">선택된 사은품이 없습니다.</span>
					<br/><br/>
					<a href="#select-gift" class="btn-filled-sub js-goGiftSelect">사은품 선택하기</a>
				</div>
			</div>
		</section>
	</section>

	<h2 class="cart-total-tit">총 사용 할 별 / 보유 중인 별</h2>
	<div class="apply-total">
		<span class="js-totalResult txt-highlight"><?php echo number_format($totalPoint) ?></span> / <span class="js-availablePoint"><?php echo number_format($defaultRewardPoint+$mb['mbPoint'])?></span>
	</div>
	<div class="cart-total-tit">(보유 중인 별 <?php echo number_format($mb['mbPoint'])?> 포함)</div>
	<input type="hidden" class="js-totalResultInp" value="<?php echo number_format($defaultRewardPoint 
	+ $totalPoint) ?>" data-mb-point="<?php echo $mb['mbPoint'] ?>" 
	data-parsley-errors-container=".parsley-errors-apply"
	data-parsley-min="1" data-parsley-max="<?php echo $defaultRewardPoint + $mb['mbPoint']?>"
	data-parsley-min-message="주문할 사은품을 선택해주세요."
	data-parsley-max-message="현재 보유중인 %s 별보다 주문 별이 많습니다. "/>

	<ul class="parsley-errors-apply"></ul>
	
	<input type="submit" class="apply-submit btn-filled js-trackLink" target="_blank" id="link-detail-plan-apply" value="가입 신청"/>

	</form>
	<br/><br/>
</div>
<div class="wrap center">
	<h2 class="tit-sub" id="select-gift">사은품 선택</h2>
	<?php 	require_once(PATH_PRD."/gifts.inc.php");	?>
</div>

<script id="js-applyCartRowTemplate" type="text/x-template">
	<tr class="js-applyCartRow js-applyCartRow{gfKey}">
		<td class="table-item-str gift-tit"><a href="" class="btn-flat-primary-dense js-giftViewToggle" data-key="{gfKey}">{gfTit}</a></td>
		<td class="no-padding">
			<input type="hidden" value="{gfKey}" name="gfKey[]"/>
			<input type="number" class="inp-num-dense js-applyCartQuantity" value="{quantity}" name="oiQuantity[]" data-point="{gfPoint}" data-key="{gfKey}"/>
		</td>
		<td class="table-separator">x</td>
		<td>{gfPoint}</td>
		<td class="table-separator">=</td>
		<td class="js-applyCartRowResult js-applyCartRowResult{gfKey} table-value" data-result="{resultPoint}">{resultPointNumFormat}</td>
		<td class="action-wrap">
			<label class="inp-label">
				<button class="btn-delete js-applyCartDelete" data-key="{gfKey}" formnovalidate><i></i></button>
			</label>
		</td>
	</tr>
</script>

<?php $naver->getLoginScriptForApply();?>
<?php $kakao->getLoginScriptForApply();?>