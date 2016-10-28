<table class="table">
	<thead>
		<tr>
			<td class="chk-wrap">
				<label class="inp-chk">
					<input type="checkbox" class="js-tableAllChk" value="<?php echo $val['gfKey']?>"/>
					<div class="inp-chk-box">
					</div>
				</label>
			</td>
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
	<?php foreach($arrCart as $val) :?>
	<tr class="js-cartRow<?php echo $val['caKey']?>">
		<td class="chk-wrap">
			<label class="inp-chk">
				<input type="checkbox" class="js-tableChk" value="<?php echo $val['caKey']?>" name="chk[]" data-result="<?php echo $val['caQuantity']*$val['gfPoint']?>"/>
				<div class="inp-chk-box">
				</div>
			</label>
		</td>
		<td class="table-item-str gift-tit"><a href="" class="btn-flat-primary-dense js-giftViewToggle" data-key="<?php echo $val['gfKey']?>"><?php echo $val['gfTit']?></a></td>
		<td class="no-padding">
			<input type="number" class="inp-num-dense js-cartQuantity" value="<?php echo $val['caQuantity']?>" name="caQuantity<?php echo $val['caKey']?>" data-point="<?php echo $val['gfPoint']?>" data-key="<?php echo $val['caKey']?>"/>
		</td>
		<td class="table-separator">x</td>
		<td><?php echo number_format($val['gfPoint'])?></td>
		<td class="table-separator">=</td>
		<td class="js-cartRowResult js-cartRowResult<?php echo $val['caKey']?> table-value" ><?php echo number_format($val['caQuantity']*$val['gfPoint'])?></td>
		<td class="action-wrap">
			<label class="inp-label">
				<button class="btn-delete js-cartDelete" data-key="<?php echo $val['caKey']?>"><i></i></button>
			</label>
		</td>
	</tr>
	<?php endforeach?>
	</tbody>
	</table>

	<table class="table cart-additial-wrap">
	<tbody>
	<tr>
		<td class="chk-wrap">
		</td>
		<td class="table-item-str">배송비</td>
		<td class="no-padding">
		</td>
		<td class="table-separator"></td>
		<td></td>
		<td class="table-separator">+</td>
		<td class="js-cartShipping table-value">2,500</td>
		<td class="action-wrap">
		</td>
	</tr>
	</tbody>
</table>

<h2 class="cart-total-tit">총 결제 별 / 현재 소유 별</h2>
<div class="cart-total">
	<span class="js-totalResult txt-highlight">0</span> / <?php echo number_format($mb['mbPoint'])?>
</div>
<input type="hidden" class="js-totalResultInp" value="0" 
data-parsley-min="1" data-parsley-max="<?php echo $mb['mbPoint']?>"
data-parsley-min-message="주문할 사은품을 선택해주세요."
data-parsley-max-message="현재 보유중인 %s 별보다 주문 별이 많습니다. "/>