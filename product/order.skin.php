<div class="wrap order-wrap">
	<form method="post" action="/product/orderAction.php" id="order-form" name="order_info">
			<!-- <form method="post" action="/Test/tt.php" id="order-form" name="order_info"> -->
			<!-- <form method="post" action="/Test/tt.php" id="order-form"> -->
		<h1 class="center tit">주문하기</h1>
		<section class="section-no-padding txt-left js-addressWrap">
			<section class="js-addressDetail address-detail active">
				<h2 class="tit-sub">배송지 주소</h2>
				<input type="hidden" class="js-arKey" name="arKey" value="<?php echo $defAddress['arKey']?>" />
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-tit" name="arTit" value="<?php echo $defAddress['arTit']?>" />
					<div class="inp-label">주소지 명</div>
					<span class="inp-hint">집, 회사, 아들집 등</span>
				</label>
				<br/>
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-name" name="arName" value="<?php echo $defAddress['arName']?>" />
					<div class="inp-label">주문자 명<span class="inp-required">필수</span></div>
				</label>
				<br/>
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-phone" name="arPhone" value="<?php echo $defAddress['arPhone']?>" />
					<div class="inp-label">연락처<span class="inp-required">필수</span></div>
				</label>
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-tel" name="arTel" value="<?php echo $defAddress['arTel']?>" />
					<div class="inp-label">추가 연락처</div>
				</label>
				<br/>
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-postcode" name="arPostcode" value="<?php echo $defAddress['arPostcode']?>" />
					<div class="inp-label">우편번호<span class="inp-required">필수</span></div>
				</label>
				<br/>
				<label class="inp-wrap-full">
					<input type="text" class="inp-txt js-address" name="arAddress" value="<?php echo $defAddress['arAddress']?>" />
					<div class="inp-label">주소<span class="inp-required">필수</span></div>
				</label>
				<label class="inp-wrap-full">
					<input type="text" class="inp-txt js-subAddress" name="arSubAddress" value="<?php echo $defAddress['arSubAddress']?>" />
					<div class="inp-label">상세주소<span class="inp-required">필수</span></div>
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
					<!--td class="action-wrap">
						<label class="inp-label">
							<button class="btn-edit" data-key="<?php echo $val['caKey']?>" formnovalidate><i></i></button>
						</label>
										<td class="action-wrap">
						<button class="btn-filled-white-dense">¼±ÅÃ</button>
					</td>
					</td-->
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

		<section class="section-no-padding">
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
			<tbody>
			<?php foreach($arrOrder as $val) :?>
			<tr class="js-orderRow<?php echo $val['caKey']?>">
				<td class="table-item-str gift-tit"><a href="" class="btn-flat-primary-dense js-giftViewToggle" data-key="<?php echo $val['gfKey']?>"><?php echo $val['gfTit']?></a></td>
				<td class="no-padding">
					<input type="hidden" value="<?php echo $val['gfTit']?>" name="good_name[]"/>		<!-- made by hy , use to Arname-->
					<input type="hidden" value="<?php echo $val['gfKey']?>" name="gfKey[]"/>
					<input type="number" class="inp-num-dense js-orderQuantity" value="<?php echo $val['caQuantity']?>" name="oiQuantity[]" data-point="<?php echo $val['gfPoint']?>" data-key="<?php echo $val['caKey']?>"/>
				</td>
				<td class="table-separator">x</td>
				<td><?php echo number_format($val['gfPoint'])?></td>
				<td class="table-separator">=</td>
				<td class="js-orderRowResult js-orderRowResult<?php echo $val['caKey']?> table-value" data-result="<?php echo $val['caQuantity']*$val['gfPoint']?>"><?php echo number_format($val['caQuantity']*$val['gfPoint'])?></td>
				<td class="action-wrap">
					<label class="inp-label">
						<button class="btn-delete js-orderDelete" data-key="<?php echo $val['caKey']?>" formnovalidate><i></i></button>
					</label>
				</td>
			</tr>
			<?php endforeach?>
			</tbody>
			</table>
			<table class="table cart-additial-wrap">
			<tbody>
			<tr>
				<td class="table-item-str">착불 배송비</td>
				<td class="no-padding">
				</td>
				<td class="table-separator"></td>
				<td>착불</td>
				<td class="table-separator">=</td>
				<td class="js-cartShipping table-value"><?php echo($isShippingFree)?'1회 무료':'2,500';?></td>
				<td class="action-wrap">
				</td>
			</tbody>
			</table>
		</section>
		<!-- 					echo number_format($mb['mbPoint']);	// º¸À¯
					echo "<br/>";
					echo number_format($value['gfPoint']);	// °ª
 -->
		<section class="section cash">
			<h2 class="tit-sub">결제방법</h2>

	       	 <label class="inp-wrap-full">
	       	 	<select class="inp-txt js-subAddress" name="pay_method">
	            	<option value="111000000000" selected="selected">선택해주세요</option>
	                <option value="100000000000">신용카드</option>
	                <option value="010000000000">계좌이체</option>
	                <option value="001000000000">가상계좌</option>
	                <option value="000100000000">포인트</option>
	                <option value="000010000000">휴대폰</option>
	                <option value="000000001000">상품권</option>
	                <option value="000000000010">ARS</option>
	                </select>
	            <div class="inp-label">결제방법<span class="inp-required">필수</span></div>
	        </label>
	    
		    <fieldset class="inp-group">		
				<label class="inp-chk">
					<input type="radio" name="onlyPay" value="pointOnlyPay"/>
					<div class="inp-chk-box"></div>
					별포인트로 결제
				</label>
				<label class="inp-chk">
					<input type="radio" name="onlyPay" value="cashOnlyPay"/>
					<div class="inp-chk-box"></div>
					현금으로만 결제
				</label>
			</fieldset>
			<br/>
	    	<label class="inp-wrap">
	    		<input type="number" value="<?php echo ($totalPoint<$mb['mbPoint'])?$totalPoint:$mb['mbPoint'] ?>" class="js-totalResultPoint inp-txt" name="resultPoint">
	    		<div class="inp-label">사용할 포인트<span class="inp-required">필수</span></div>
	    	</label>
	    	<label class="totalPoint">
	    		<span> / </span>	    		
	    		<span class="totalPoint-txt"><?php echo number_format($mb['mbPoint'])?> (보유한 포인트)</span>	    		
	    	</label>	    	
	    	<br/>

	    	<label class="inp-wrap">
				<input type="number" value="<?php echo ($totalPoint<$mb['mbPoint'])?0:$totalPoint-$mb['mbPoint'] ?>" class="js-totalResultCash inp-txt" name="resultCash">
				<div class="inp-label">결제할 현금<span class="inp-required">필수</span></div>
			</label>
			
		<br/>
		</section>	
		<h2 class="cart-total-tit center">사은품 총 결제 금액</h2>
		<div class="cart-total">
			<span class="js-totalResult txt-highlight"><?php echo number_format($totalPoint) ?></span> 
		</div>
		<div class="center">
			<input type="hidden" class="js-totalResultInp" value="<?php echo $totalPoint ?>" />
			<input type="hidden" class="js-mbPoint" value="<?php echo $mb['mbPoint'] ?>">
			<input type="submit" class="btn-filled" value="결제하기" onclick="return jsf__pay(this.form);"/>
			<Br/><Br/>
		<?php require_once(PATH_PRD.'/order.kcp.inc.php');?>
		</div>

	</form>
</div>

