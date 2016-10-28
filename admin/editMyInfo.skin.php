<div class="wrap mypageList-wrap center">
	<h1 class="center tit">내 정보 수정</h1>	
	<section class="section txt-left">
		<label class="inp-wrap">
			<input type="password" class="inp-txt" name="mbPw"/>
			<div class="inp-label">새 비밀번호</div>
			<span class="inp-hint"></span>
		</label>
		<br/>
		<label class="inp-wrap">
			<input type="password" class="inp-txt" name="mbPwCheck"/>
			<div class="inp-label">새 비밀번호 확인</div>
			<span class="inp-hint"></span>
		</label>
		<Br/>
		<label class="inp-wrap">
			<input type="text" class="inp-txt" name="mbName" value="<?php echo $mb['mbName']?>"/>
			<div class="inp-label">성함</div>
		</label>
		<br/>
		<label class="inp-wrap">
			<input type="text" class="inp-txt" name="mbPhone" value="<?php echo $mb['mbPhone']?>"/>
			<div class="inp-label">휴대폰 번호</div>
			<span class="inp-hint"></span>
		</label>
	</section>

	<section class="section-no-padding txt-left js-addressWrap js-showContactBtn">
		<section class="js-addressDetail address-detail active">
			<h2 class="tit-sub">주소 수정</h2>
			<input type="hidden" class="js-arKey" name="arKey" value="<?php echo $defAddress['arKey']?>" />
			<label class="inp-wrap">
				<input type="text" class="inp-txt js-tit" name="arTit" value="<?php echo $defAddress['arTit']?>" />
				<div class="inp-label">주소지 명</div>
			</label>
			<br/>
			<label class="inp-wrap">
				<input type="text" class="inp-txt js-name" name="arName" value="<?php echo $defAddress['arName']?>" />
				<div class="inp-label">주문자 명 <span class="inp-required">필수</span></div>
			</label>
			<br/>
			<label class="inp-wrap">
				<input type="text" class="inp-txt js-phone" name="arPhone" value="<?php echo $defAddress['arPhone']?>" />
				<div class="inp-label">연락처 <span class="inp-required">필수</span></div>
			</label>
			<label class="inp-wrap">
				<input type="text" class="inp-txt js-tel" name="arTel" value="<?php echo $defAddress['arTel']?>" />
				<div class="inp-label">추가 연락처</div>
			</label>
			<br/>
			<label class="inp-wrap">
				<input type="text" class="inp-txt js-postcode" name="arPostcode" value="<?php echo $defAddress['arPostcode']?>" />
				<div class="inp-label">우편번호 <span class="inp-required">필수</span></div>
			</label>
			<br/>
			<label class="inp-wrap-full">
				<input type="text" class="inp-txt js-address" name="arAddress" value="<?php echo $defAddress['arAddress']?>" />
				<div class="inp-label">주소 <span class="inp-required">필수</span></div>
			</label>
			<label class="inp-wrap-full">
				<input type="text" class="inp-txt js-subAddress" name="arSubAddress" value="<?php echo $defAddress['arSubAddress']?>" />
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

	<input type="submit" class="apply-submit btn-filled js-trackLink" target="_blank" id="link-detail-plan-apply" value="수정 완료"/>
</div>


