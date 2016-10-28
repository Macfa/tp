<div class="wrap apply-wrap center">
	<h1 class="tit center">신청서 작성</h1>
	<form action="/product/applyAction.php" method="post" id="apply-form">
	<input type="hidden" class="js-id" name="dvId" value="<?php echo $_GET['id']?>"/>
	<input type="hidden" class="js-token" value="<?php echo createToken()?>"/>
	<section class="calc-wrap js-hideContactBtn">
		<div class="calc-result-wrap">
			<table class="calc-result-table">
				<colgroup>
					<col style="width:auto;" />
					<col style="width:20%" />
					<col style="width:20%" />
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>총 액</th>
						<th>24개월</th>
					</tr>
				</thead>
				<tbody>
					<tr class="calc-value-row">
						<td class="calc-value-label">출고가</td>
						<td class="js-retailPrice"><?php echo number_format($calcDefaultValue['dvRetailPrice'])?></td>
						<td class="js-retailPricePerMonth"><?php echo number_format($calcDefaultValue['dvRetailPricePerMonth'])?></td>
					</tr>
					<tr class="calc-value-row calc-support-discount <?php echo $isSupportDiscountRowActive?>">
						<td class="calc-value-label">- 공시 지원금</td>
						<td class="js-support"><?php echo number_format($calcDefaultValue['spSupport'])?></td>
						<td class="js-supportPerMonth"><?php echo number_format($calcDefaultValue['spSupportPerMonth'])?></td>
					</tr>
					<tr class="calc-value-row calc-support-discount <?php echo $isSupportDiscountRowActive?>">
						<td class="calc-value-label">- 티플 지원금</td>
						<td class="js-addSupport"><?php echo number_format($calcDefaultValue['spAddSupport'])?></td>
						<td class="js-addSupportPerMonth"><?php echo number_format($calcDefaultValue['spAddSupportPerMonth'])?></td>
					</tr>
					<tr class="calc-value-row">
						<td class="calc-value-label">+ 요금제기본료</td>
						<td></td>
						<td class="js-planFeePerMonth"><?php echo number_format($calcDefaultValue['planFee'])?></td>
					</tr>
					<tr class="calc-value-row calc-select-plan">
						<td class="calc-value-label">- 선택약정할인</td>
						<td class="js-selectPlanDiscount">30,000</td>
						<td class="js-selectPlanDiscountPerMonth">30,000</td>
					</tr>
					<tr class="calc-result-row">
						<td class="calc-result-label">= 월 청구액</td>
						<td class="calc-result-price js-result" colspan="2"><?php echo number_format($calcDefaultValue['result'])?></td>
					</tr>
					<tr class="calc-value-row js-availablePointRow" style="display:none">
						<td class="calc-value-label">가용 포인트</td>
						<td></td>
						<td class="js-availablePointCalc"><?php echo number_format($defaultRewardPoint)?></td>
					</tr>
				</tbody>
			</table>

		</div><div class="calc-pad-wrap js-calcPad">
			<?php if ($is3G) :?>
			<div class="calc-row-lock-<?php echo $lockedPropertyCount?>">
				<div class="calc-row-label">기기종류</div>
				<label class="calc-btn">
					<input type="radio" checked/>
					<div class="calc-label">
						<i class='ico-lock'></i>3G모델
					</div>
				</label>
			</div>
			<?php endif?>
			<div class="calc-row-<?php echo $applyTypeRowAffix?> js-calcRow">
				<div class="calc-row-label">가입유형</div>
				<?php foreach($arrApplyType as $key => $val) :?>
				<label class="calc-btn">
					<input type="radio" value="<?php echo $key?>" name="applyType" <?php echo $applyTypeChecked[$key]['isChecked']?>/>
					<div class="calc-label">
						<?php echo $applyTypeLockIcon?><?php echo $val?>
					</div>
				</label>
				<?php endforeach?>
			</div>
			<?php if ($isCanChildSelect) :?>
			<div class="calc-row-<?php echo $capacityRowAffix?>">
				<div class="calc-row-label">기기용량</div>
				<?php foreach($child as $row) :?>
				<label class="calc-btn">
					<input type="radio" value="<?php echo $row['dvTit']?>" name="capacity" <?php echo $row['isChecked']?>/>
					<div class="calc-label"><?php echo $capacityTypeLockIcon?> <?php echo $row['dvTit']?></div>
				</label>
				<?php endforeach?>
			</div>
			<?php endif?>
			<div class="calc-row-<?php echo $discountTypeRowAffix?>">
				<div class="calc-row-label">할인방식</div>
				<label class="calc-btn">
					<input type="radio" value="support" name="discountType" <?php echo $isSupportDiscountChecked?>/>
					<div class="calc-label"><?php echo $discountTypeLockIcon?>공시지원금</div>
				</label>
				<?php if ($onlySupportDiscount == false) :?>
				<label class="calc-btn">
					<input type="radio" value="selectPlan" name="discountType" />
					<div class="calc-label">선택약정할인</div>
				</label>
				<?php endif?>
			</div>
			<div class="calc-row-2">
				<div class="calc-row-label">부가세 할부이자</div>
				<label class="calc-btn">
					<input type="radio" value="1" name="containVat"/>
					<div class="calc-label">포함(실청구액)</div>
				</label>
				<label class="calc-btn">
					<input type="radio" value="0" name="containVat" />
					<div class="calc-label">포함안된 요금</div>
				</label>
			</div>
			<div class="calc-row">
				<div class="calc-row-label">요금제</div>
				<select class="inp-select js-planCalcArg" name="plan">
					<?php foreach($arrSelectPlan as $val) :?>
					<option value="<?php echo $val?>" <?php echo $isPlanSelected[$val]['isChecked']?>><?php echo $deviceInfo->getPlanName($val)?> : <?php echo $deviceInfo->getPlanInfo($val)?></option>
					<?php endforeach?>
				</select>
			</div>
		</div>
		<div class="spacer" style="clear: both;"></div>
	</section>

	<?php if($isLogged == false) :?>
	<section class="section txt-left js-loginSection">
		<h2 class="tit-sub">남은 별 적립</h2>
		<h3>사은품 선택 후 남은 포인트를 모아<br/><span class="txt-highlight">다른 사은품을 살 수 있습니다.</span></h3>
		<a href="<?php echo $cfg['url']?>/user/login.php?returnURL=<?php echo $cfg['current_url']?>" class="btn-filled-sub">로그인/회원가입	</a>
	</section>
	<?php endif?>

	<!--section class="section-no-padding txt-left js-addressWrap js-showContactBtn">
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
	</section-->

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