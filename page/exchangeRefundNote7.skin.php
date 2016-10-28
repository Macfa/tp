<div class="wrap-dense">
	<h1 class="tit">갤럭시노트7 교환/환불신청</h1>
	<?php if($isLogged == false) :?>
	<section class="section">
		<h3 class="tit-sub center">로그인 후 교환/환불신청이 가능합니다.</h3>
		<a href="<?php echo $cfg['login_url']?>" class="btn-filled-sub">로그인/회원가입</a>
	</section>
	<?php endif?>

	<form action="exchangeRefundNote7Action.php" method="post">
		<input type="hidden" name="enKey" value="">
		<section class="section txt-left">
			<fieldset class="inp-group">
				노트7 기기를 받으셨나요? <br/>
				<label class="inp-chk">
					<input type="radio" name="isReceivedNote7" value="1"/>
					<div class="inp-chk-box"></div>
					네
				</label>
				<label class="inp-chk">
					<input type="radio" name="isReceivedNote7" value="0"/>
					<div class="inp-chk-box"></div>
					아니오
				</label>
			</fieldset>
			<fieldset class="inp-group">
				<i class="ico-gift-small"></i> 사은품을 받으셨나요? <br/>
				<label class="inp-chk">
					<input type="radio" name="enReceivedGift" value="1"/>
					<div class="inp-chk-box"></div>
					네
				</label>
				<label class="inp-chk">
					<input type="radio" name="enReceivedGift" value="0"/>
					<div class="inp-chk-box"></div>
					아니오
				</label>
			</fieldset>
			<fieldset class="inp-group">
				<label class="inp-wrap">
					<i class="ico-person-small"></i>
					<input type="text" class="inp-txt" value="<?php echo $mb['mbName']?>" />
					<div class="inp-label">성함</div>
				</label>
				<br/>
				<label class="inp-wrap">
					<i class="ico-tel-small"></i>
					<input type="text" class="inp-txt" name="enPhone" value="<?php echo ($validPhone)?$validPhone:''; ?>" />
					<div class="inp-label">연락처</div>
				</label>
			</fieldset>
			<fieldset class="inp-group">
				<i class="ico-carrier-small"></i> 신청하신 통신사 <br/>
				<label class="inp-chk">
					<input type="radio" name="enApplyCarrier" value="sk"/>
					<div class="inp-chk-box"></div>
					SK
				</label>
				<label class="inp-chk">
					<input type="radio" name="enApplyCarrier" value="kt"/>
					<div class="inp-chk-box"></div>
					KT
				</label>
			</fieldset>
			<fieldset class="inp-group">
				<i class="ico-change-device-small"></i> 진행 방법 <br/>
				<label class="inp-chk">
					<input type="radio" name="enWay" value="delivery"/>
					<div class="inp-chk-box"></div>
					택배로 진행
				</label>
				<label class="inp-chk">
					<input type="radio" name="enWay" value="offline"/>
					<div class="inp-chk-box"></div>
					방문하여 진행
				</label>
			</fieldset>
			<fieldset class="inp-group">
				<i class="ico-change-device-small"></i> 무엇을 하고 싶으신가요? <br/>
				<label class="inp-chk">
					<input type="radio" name="enApplyType" value="exchange"/>
					<div class="inp-chk-box"></div>
					다른 최신 기기로 교환
				</label>
				<label class="inp-chk">
					<input type="radio" name="enApplyType" value="refund"/>
					<div class="inp-chk-box"></div>
					환불
				</label>
				<Br/>
				<img src="<?php echo PATH_IMG?>/benefit-exchange.jpg" class="benefit-img"/> &nbsp;
				<img src="<?php echo PATH_IMG?>/benefit-refund.jpg" class="benefit-img"/>
				<!--ul class="list-inside">
				<li><i class="ico-gift-small"></i>교환 시 : S7, S7엣지, 노트5로 교환 시 다음달 <span class="txt-highlight">통신비 7만원 지원</span></li>
				<li><i class="ico-gift-small"></i>환불 시 : 환불 후 티플에서 번호이동 재개통 시 <span class="txt-highlight">사은품 환불 불필요 & 포인트 50,000별 지급</span></li>
				</ul-->
			</fieldset>
			<div class="js-changeDeviceWrap"  style="display:none">
				<fieldset class="inp-group">
					<i class="ico-change-device-small"></i> 교환하고 싶은 기기<br/>
					<label class="inp-chk">
						<input type="radio" name="enTargetDevice" value="galaxys7"/>
						<div class="inp-chk-box"></div>
						갤럭시S7
					</label>
					<label class="inp-chk">
						<input type="radio" name="enTargetDevice" value="galaxys7edge"/>
						<div class="inp-chk-box"></div>
						갤럭시S7엣지
					</label>
					<label class="inp-chk">
						<input type="radio" name="enTargetDevice" value="galaxynote5"/>
						<div class="inp-chk-box"></div>
						노트5
					</label>
					<label class="inp-chk">
						<input type="radio" name="enTargetDevice" value="v20"/>
						<div class="inp-chk-box"></div>
						V20
					</label>
					<label class="inp-chk">
						<input type="radio" name="enTargetDevice" value="iphone7"/>
						<div class="inp-chk-box"></div>
						아이폰7
					</label>
					<label class="inp-chk">
						<input type="radio" name="enTargetDevice" value="iphone7Plus"/>
						<div class="inp-chk-box"></div>
						아이폰7 플러스
					</label>
					<label class="inp-chk">
						<input type="radio" name="enTargetDevice" value="etc"/>
						<div class="inp-chk-box"></div>
						기타
					</label>
					<Br class="js-targetDeviceEtcWrap" style="display:none"/>
					<label class="inp-wrap js-targetDeviceEtcWrap" style="display:none">
						<input type="text" class="inp-txt" name="enTargetDeviceEtc" value="" />
						<div class="inp-label">원하시는 기기</div>
					</label>
					<Br/>
					<img src="<?php echo PATH_IMG?>/benefit-exchange.jpg" class="benefit-img"/>
					<ul class="list-inside">
					<li><i class="ico-caution-small"></i>갤럭시노트5는 물량이 부족하여 기기수령이 늦어질 수 있습니다.</li>
					</ul>
				</fieldset>
				<fieldset class="inp-group js-iphone7Color js-colorWrap" style="display:none">
					<i class="ico-color-small"></i> 색상 <br/>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="jetBlack"/>
						<div class="inp-chk-box"></div>
						제트블랙
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="black"/>
						<div class="inp-chk-box"></div>
						블랙
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="silver"/>
						<div class="inp-chk-box"></div>
						실버
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="gold"/>
						<div class="inp-chk-box"></div>
						골드
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="roseGold"/>
						<div class="inp-chk-box"></div>
						로즈골드
					</label>
					<Br/>
					<i class="ico-caution-small"></i> 블랙과 제트블랙은 수요과잉으로 <span class="txt-highlight">기기수령이 늦어질 수 있습니다.</span>
				</fieldset>
				<fieldset class="inp-group js-v20Color js-colorWrap" style="display:none">
					<i class="ico-color-small"></i> 색상 <br/>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="black"/>
						<div class="inp-chk-box"></div>
						블랙
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="silver"/>
						<div class="inp-chk-box"></div>
						실버
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="pink"/>
						<div class="inp-chk-box"></div>
						핑크
					</label>
				</fieldset>
				<fieldset class="inp-group js-galaxys7Color js-colorWrap" style="display:none">
					<i class="ico-color-small"></i> 색상 <br/> 
					<!--<label class="inp-chk">
						<input type="radio" name="enColorType" value="black"/>
						<div class="inp-chk-box"></div>
						블랙
					</label>
					-->
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="silver"/>
						<div class="inp-chk-box"></div>
						실버
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="gold"/>
						<div class="inp-chk-box"></div>
						골드
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="white"/>
						<div class="inp-chk-box"></div>
						화이트
					</label>
				</fieldset>
				<fieldset class="inp-group js-galaxynote5Color js-colorWrap" style="display:none">
					<i class="ico-color-small"></i> 색상 <br/>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="black"/>
						<div class="inp-chk-box"></div>
						블랙
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="silver"/>
						<div class="inp-chk-box"></div>
						실버
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="gold"/>
						<div class="inp-chk-box"></div>
						골드
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="white"/>
						<div class="inp-chk-box"></div>
						화이트
					</label>
					<label class="inp-chk">
						<input type="radio" name="enColorType" value="pinkgold"/>
						<div class="inp-chk-box"></div>
						핑크골드
					</label>
				</fieldset>
				<fieldset class="inp-group js-capacityWrap" style="display:none">
					용량 <br/>
					<label class="inp-chk js-capacity32">
						<input type="radio" name="enDeviceCapacity" value="32G"/>
						<div class="inp-chk-box"></div>
						32G
					</label>
					<label class="inp-chk js-capacity64">
						<input type="radio" name="enDeviceCapacity" value="64G"/>
						<div class="inp-chk-box"></div>
						64G
					</label>
					<label class="inp-chk js-capacity128">
						<input type="radio" name="enDeviceCapacity" value="128G"/>
						<div class="inp-chk-box"></div>
						128G
					</label>
					<label class="inp-chk js-capacity256">
						<input type="radio" name="enDeviceCapacity" value="256G"/>
						<div class="inp-chk-box"></div>
						256G
					</label>
				</fieldset>
			</div>
			<!--label class="inp-wrap">
				<i class="ico-talk-small"></i>
				<textarea name="paEtc" class="inp-txtarea" ></textarea>
				<div class="inp-label">기타사항 & 요구사항</div>
			</label-->
		</section>
		
		<ul class="exchangeRefundNote7-process js-processWrap">
		</ul>

		<section class="section-no-padding txt-left js-addressWrap js-showContactBtn" style="display:none;">
			<section class="js-addressDetail address-detail active">
				<h2 class="tit-sub">주소</h2>
				<input type="hidden" class="js-arKey" name="arKey" value="<?php echo $defAddress['arKey']?>" />
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-tit" name="arTit" value="<?php echo $defAddress['arTit']?>" />
					<div class="inp-label">주소지 명</div>
				</label>
				<br/>
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-tel" name="enSubPhone" value="<?php echo $defAddress['arTel']?>" data-parsley-required/>
					<div class="inp-label">비상 연락처 <span class="inp-required">필수</span></div>
				</label>
				<br/>
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-postcode" name="enPostCode" value="<?php echo $defAddress['arPostcode']?>" data-parsley-required/>
					<div class="inp-label">우편번호 <span class="inp-required">필수</span></div>
				</label>
				<br/>
				<label class="inp-wrap-full">
					<input type="text" class="inp-txt js-address" name="enAddress" value="<?php echo $defAddress['arAddress']?>" data-parsley-required/>
					<div class="inp-label">주소 <span class="inp-required">필수</span></div>
				</label>
				<label class="inp-wrap-full">
					<input type="text" class="inp-txt js-subAddress" name="enSubAddress" value="<?php echo $defAddress['arSubAddress']?>" data-parsley-required/>
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
		<input type="submit" value="신청하기" class="btn-filled-primary-dense">	
	</form>

	
</div>
<script id="js-processItemTemplate" type="text/x-template">
	<li class="{active}">
		<div class="number">{num}</div>
		<div class="name">{name}</div>			
	</li>
</script>

<script>
var $stateDeliveryExchange = ['신청서작성', '신청확인', '교환기기배정<br/>(유선연락)', '반품<br/>(유선연락)', '반품확인', '배송후 즉시사용<br/>(완료)'];
var $stateOfflineExchange = ['신청서작성', '신청확인', '교환기기배정<br/>(유선연락)', '내방날짜예약<br/>(유선진행)', '내방즉시교환<br/>(완료)'];
var $stateDeliveryRefund = ['신청서작성', '신청확인', '사은품 비용입금', '입금확인', '반품', '반품확인', '개통취소', '환불진행완료'];
var $stateOfflineRefund = ['신청서작성','신청확인','사은품 비용입금','내방날짜예약<br/>(유선진행)', '취소진행완료'];

$(function(){
	$('[name=enTargetDevice], [name=enWay], [name=enApplyType]').trigger('change');
});

$('[name=enTargetDevice]').change(function(){

	if($('[name=enApplyType]:checked').val() != 'exchange') 
		return false;

	var $val = $('[name=enTargetDevice]:checked').val();

	if($val == 'etc') {
		$('.js-capacityWrap').hide().find('input').attr('disabled', 'disabled').prop('checked', false);
		$('.js-targetDeviceEtcWrap').show().find('input').removeAttr('disabled');
	}else {
		$('.js-capacityWrap').show().find('input').attr('disabled', 'disabled').prop('checked', false);
		if($val){
			$('.js-targetDeviceEtcWrap').hide().find('input').removeAttr('disabled');
		}
	}

	$('.js-capacity32, .js-capacity64, .js-capacity128, .js-capacity256').siblings('label').hide().find('input').attr('disabled', 'disabled').prop('checked', false);
	$('.js-colorWrap').hide().find('input').attr('disabled', 'disabled').prop('checked', false);

	if($val == 'galaxynote5')
		$('.js-galaxynote5Color').show().find('input').removeAttr('disabled');

	if($val == 'galaxys7' || $val == 'galaxys7edge')
		$('.js-galaxys7Color').show().find('input').removeAttr('disabled');
		
	if($val == 'galaxynote5') {
		$('.js-capacity32, .js-capacity64').show().find('input').removeAttr('disabled');
	}else if($val == 'galaxys7' || $val == 'galaxys7edge') {
		$('.js-capacity32').show().find('input').removeAttr('disabled');
	}else if($val == 'v20') {
		$('.js-capacity64').show().find('input').removeAttr('disabled');
		$('.js-v20Color').show().find('input').removeAttr('disabled');
	}else if($val == 'iphone7' || $val == 'iphone7Plus') {
		$('.js-capacity32, .js-capacity128, .js-capacity256').show().find('input').removeAttr('disabled');
		$('.js-iphone7Color').show().find('input').removeAttr('disabled');
	}
});


$('[name=enApplyType]').change(function(){
	var $val = $('[name=enApplyType]:checked').val();
	if($val == 'exchange'){
		$('.js-changeDeviceWrap').show().find('input').removeAttr('disabled');
	} else if($val == 'refund') {
		$('.js-changeDeviceWrap').hide().find('input').attr('disabled', 'disabled');
	}
});

$('[name=enWay]').change(function(){
	var $val = $('[name=enWay]:checked').val();
	if($val == 'delivery'){
		$('.js-addressWrap').show().find('input').removeAttr('disabled');
	} else if($val == 'offline') {
		$('.js-addressWrap').hide().find('input').attr('disabled', 'disabled');
	}
});

$('[name=enWay], [name=enApplyType], [name=enReceivedGift]').change(function(){
	var $enWayValue = $('[name=enWay]:checked').val();
	var $enApplyTypeValue = $('[name=enApplyType]:checked').val();
	var $enReceivedGift = $('[name=enReceivedGift]:checked').val();
	var $arrState = [];

	if($enWayValue && $enApplyTypeValue && $enReceivedGift) {
		if($enWayValue == 'delivery' && $enApplyTypeValue == 'exchange') $arrState = $stateDeliveryExchange;
		if($enWayValue == 'delivery' && $enApplyTypeValue == 'refund') {
			$arrState = $stateDeliveryRefund;
		}
		if($enWayValue == 'offline' && $enApplyTypeValue == 'exchange') $arrState = $stateOfflineExchange;
		if($enWayValue == 'offline' && $enApplyTypeValue == 'refund') {
			$arrState = $stateOfflineRefund;
		}
		
		var $i = 1;
		var $data = [];
		console.log($stateDeliveryRefund);
		$('.js-processWrap').html('');
		$('.js-processWrap').append('<div class="tit-sub center">진행절차</div>');
		$.each($arrState, function(index, value) {
			if(!value) return true;
			if($enReceivedGift == '0' && (index == 3 || index == 4) && ($enWayValue == 'delivery' && $enApplyTypeValue == 'refund')) {
				return true;
			}
			if($enReceivedGift == '0' && index == 3 && ($enWayValue == 'offline' && $enApplyTypeValue == 'refund')) {
				return true;
			}
			$data['num'] = $i;
			$data['name'] = value;
			$item = getResultTemplate($('#js-processItemTemplate').html(),$data);
			$('.js-processWrap').append($item);
			$i++;
		});
		$('.js-processWrap').append('<br/><br/>');
	}
});
</script>