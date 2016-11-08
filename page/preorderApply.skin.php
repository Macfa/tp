
<section style="background:white">
	<img src="../img/<?echo $preorderTitle['poEngName']?>.jpg">
</section>
<br/>

<div class="preorder-wrap">
	<?php if($isLogged == false) :?>
	<section class="section">
		<h3 class="tit-sub center">로그인후 구매신청이 가능합니다.</h3>
		<a href="<?php echo $cfg['login_url']?>" class="btn-filled-sub">로그인/회원가입</a>
	</section>
	<?php endif?>
	<form action="preorderApplyAction.php" method="post">
		<input type="hidden" name="poKey" value="<?php echo $preorderTitle['poKey']?>">
		<input type="hidden" name="paKey" value="<?php echo $preorder['paKey']?>">
		<input type="hidden" name="mbEmail" value="<?php echo $_GET['mbEmail']?>"> <!-- // 어드민 회원수정시 -->
		<input type="hidden" name="isEditKey" value="<?php echo $_GET['v']?>">
		<section class="section txt-left">
			<h2 class="tit-sub"><? echo $preorderTitle['poDeviceName']; ?> <?echo (isExist($_GET['mbEmail']) === true && $isAdmin === TRUE)?"수정하기":"신청하기"?></h2>
			<i class="ico-person-small"></i>예약자명 <Br/> <span><?php echo $vailName?></span><br/><br/>
			<label class="inp-wrap">
				<i class="ico-email-small"></i>
				<input type="text" class="inp-txt" name="paEmail" value="<?php echo ($validEmail)?$validEmail:''; ?>" />
				<div class="inp-label">이메일</div>
			</label>
			<br>
			<label class="inp-wrap">
				<i class="ico-tel-small"></i>
				<input type="text" class="inp-txt" name="paPhone" value="<?php echo ($validPhone)?$validPhone:''; ?>" />
				<div class="inp-label">전화번호</div>
			</label>
			<br>
			<label class="inp-wrap">
				<i class="ico-calendar-small"></i> 
				<input type="text" class="inp-txt" name="paBirth" value="<?php echo $validBirth; ?>" />
				<div class="inp-label">생년월일</div>
				<span class="inp-hint">19701015 형식으로 입력</span>
			</label>
			<fieldset class="inp-group" data-default=<?echo $editMember['paSexType']?>>
				성별 <br/>
				<label class="inp-chk">
					<input type="radio" name="paSexType" value="0"/>
					<div class="inp-chk-box"></div>
					남자
				</label>
				<label class="inp-chk">
					<input type="radio" name="paSexType" value="1"/>
					<div class="inp-chk-box"></div>
					여자
				</label>
			</fieldset>
			<fieldset class="inp-group" data-default=<?echo $deviceKey?>>
				모델명 <br/>
				<?php foreach($deviceName as $key => $val) : ?>
					<label class="inp-chk">
						<input type="radio" name="paDevice" value="<?echo $key ?>"/>
						<div class="inp-chk-box"></div>
						<?echo $val ?>
					</label>				
				<?php endforeach ?>
			</fieldset>
			<fieldset class="inp-group">
				<i class="ico-color-small"></i> 색상 <br/>
				<?php if($preorderTitle ['poKey'] == 3 ) :?>
					<label class="inp-chk <?php echo $isDisableJetBlack ?>">
						<input type="radio" name="paColorType" value="jetBlack" <?php echo $isDisableJetBlack ?>/>
						<div class="inp-chk-box"></div>
						제트블랙
					</label>
					<label class="inp-chk <?php echo $isDisableBlack ?>">
						<input type="radio" name="paColorType" value="black" <?php echo $isDisableBlack ?>/>
						<div class="inp-chk-box"></div>
						블랙
					</label>
				<?php endif ?>
				<?php foreach($paColorType as $key => $val) : ?>
					<label class="inp-chk">
						<input type="radio" name="paColorType" value="<?echo $key ?>"/>
						<div class="inp-chk-box"></div>
						<?echo $val ?>
					</label>
				<?php endforeach ?>
				<?php if($preorderTitle ['poKey'] == 3 ) :?>
					<Br/>
					<i class="ico-caution-small"></i> 블랙/제트블랙 100대 선착순 신청시<span class="txt-highlight"> 즉시 수령! </span>
				<?php endif ?>
			</fieldset>
			<!--<fieldset class="inp-group js-secondColor" data-default=<?echo $editMember['pa2ndColor']?>>
				<i class="ico-color-small"></i> 2지망 색상 <span class="txt-advice">(색상이 없을시 대신 받을 색상)</span><br/>
				<label class="inp-chk">
					<input type="radio" name="pa2ndColor" value="jetBlack"/>
					<div class="inp-chk-box"></div>
					제트블랙
				</label>
				<label class="inp-chk">
					<input type="radio" name="pa2ndColor" value="black"/>
					<div class="inp-chk-box"></div>
					블랙
				</label>
				<label class="inp-chk">
					<input type="radio" name="pa2ndColor" value="silver"/>
					<div class="inp-chk-box"></div>
					실버
				</label>
				<label class="inp-chk">
					<input type="radio" name="pa2ndColor" value="gold"/>
					<div class="inp-chk-box"></div>
					골드
				</label>
				<label class="inp-chk">
					<input type="radio" name="pa2ndColor" value="roseGold"/>
					<div class="inp-chk-box"></div>
					로즈골드
				</label>
			</fieldset>
			-->
			<fieldset class="inp-group" data-default=<?echo $deviceRamKey?>> 
				용량 <br/>
				<?php if($preorderTitle ['poKey'] == 3 ) :?>
					<label class="inp-chk js-capacity32">
						<input type="radio" name="paDeviceRam" value="32G"/>
						<div class="inp-chk-box"></div>
						32G
					</label>
				<?php endif ?>
				<?php foreach($paDeviceRam as $key => $val) : ?>
					<label class="inp-chk">
						<input type="radio" name="paDeviceRam" value="<?echo $key ?>"/>
						<div class="inp-chk-box"></div>
						<?echo $val ?>
					</label>
				<?php endforeach ?>
			</fieldset>
			<fieldset class="inp-group" data-default=<?echo $editMember['paCurrentCarrier']?>>
				<i class="ico-carrier-small"></i> 현재 이용중인 통신사 <br/>
				<label class="inp-chk">
					<input type="radio" name="paCurrentCarrier" value="sk"/>
					<div class="inp-chk-box"></div>
					SKT
				</label>
				<label class="inp-chk">
					<input type="radio" name="paCurrentCarrier" value="kt"/>
					<div class="inp-chk-box"></div>
					KT olleh
				</label>
				<label class="inp-chk">
					<input type="radio" name="paCurrentCarrier" value="lg"/>
					<div class="inp-chk-box"></div>
					LG U+
				</label>
				<label class="inp-chk">
					<input type="radio" name="paCurrentCarrier" value="etc"/>
					<div class="inp-chk-box"></div>
					알뜰폰
				</label>
			</fieldset>
			<fieldset class="inp-group" data-default=<?echo $editMember['paApplyType']?>>
				<i class="ico-apply-type-small"></i> 가입유형 <br/>
				<label class="inp-chk">
					<input type="radio" name="paApplyType" value="02"/>
					<div class="inp-chk-box"></div>
					번호이동
				</label>
				<label class="inp-chk">
					<input type="radio" name="paApplyType" value="06"/>
					<div class="inp-chk-box"></div>
					기기변경
				</label>
			</fieldset>

			<fieldset class="inp-group" data-default=<?echo $editMember['paChangeCarrier']?>>
				<i class="ico-carrier-small"></i> 변경 통신사 <br/>
				<?php if($preorderTitle ['poKey'] == 3 ) :?>
				<label class="inp-chk">
					<input type="radio" name="paChangeCarrier" value="sk"/>
					<div class="inp-chk-box"></div>
					SKT
				</label>				
				<?endif?>
				<label class="inp-chk">
					<input type="radio" name="paChangeCarrier" value="kt"/>
					<div class="inp-chk-box"></div>
					KT olleh
				</label>
			</fieldset>	
			<?php if($preorderTitle ['poKey'] == 3 ) :?>		
				<fieldset class="inp-group" data-default="<?echo $editMember['paEtc2']?>">
					<i class="ico-carrier-small"></i> 에그도 같이 신청<br/>
					<label class="inp-chk">
						<input type="checkbox" name="paEtc2" value="egg"/>
						<div class="inp-chk-box"></div>
						신청하고 사은품 업그레이드 하겠습니다.
					</label>
				</fieldset>	
			<? endif ?>
			<div class="inp-tit"><i class="ico-plan-small"></i> 요금제선택 : <?echo $plan[$editMember['paPlan']]?></div>
			<br/>
			<select class="js-planselect inp-select" style="height:60px;border:solid 1px rgba(0,0,0,0.15)"  name="paPlan" data-default=<?echo $editMember['paPlan']?>>
				<option value="" class="js-planLabel">--통신사를 선택해주세요--</option>
				<option value="etc">기타 요금제</option>
			</select>
			<label class="inp-wrap js-etcPlan" style="display:none">
				<input type="text" class="inp-txt" name="etcPlan" value="" />
				<div class="inp-label">원하시는 요금제</div>
			</label>
			<Br/>
			<!--label class="inp-wrap">
				<i class="ico-talk-small"></i>
				<textarea name="paEtc" class="inp-txtarea" ></textarea>
				<div class="inp-label">기타사항 & 요구사항</div>
			</label-->
		</section>
		<input type="submit" value="신청하기" class="btn-filled-primary-dense">	
	</form>

	
</div>

<script>
var $old = undefined;
var $new = '';

$(document).on('change', '.js-gift[type=checkbox]', function(){
	if($(this).prop('checked') == true){
		if($old != undefined) {
			$('.js-gift[value='+$old+']').prop('checked', false);
		}
		if($old != $new) {
			$old = $new;
			$new = $(this).val();
		}
	} else if($(this).prop('checked') == false){
		$old = undefined;
		$new = $('.js-gift:checked').val();
	}

});



$('[name=paChangeCarrier]').change(function(){
	syncCurrentAndTargetCarrier();
});

$('.js-planselect').change(function(){
	var $val = $(this).val();
	if ($val == 'etc'){
		$('.js-etcPlan').show();
	}else{
		$('.js-etcPlan').hide();
	}
});

$('[name=paCurrentCarrier]').change(function(){
	syncCurrentAndTargetCarrier();
});


$('[name=paApplyType]').change(function(){
	syncCurrentAndTargetCarrier();
});


$('[name=paColorType]').change(function(){

	var $value = $('[name=paColorType]:checked').val();
	
	if($value == 'jetBlack') {
		$('.js-capacity32').hide();
	}else $('.js-capacity32').show();
});

function updatePlan(){
	var $carrier = $('[name=paChangeCarrier]:checked').val();
	$('.option-kt').remove();
	$('.option-sk').remove();
	$('.js-giftWrap').show();
	if($carrier == 'sk') {
		if($('[name=paApplyType]:checked').val() == '06') {
			$('.js-giftWrap').hide();
			$('.js-gift').prop('checked', false);
		}else if($('[name=paApplyType]:checked').val() == '02') {
			$('.js-gift').attr('type', 'radio')
			if($('.js-gift').parents('[data-default]').size == 0)
				$('.js-gift').prop('checked', false);
			$('.js-selectCount').text('1개 선택해주세요');
		}
		$('.js-planLabel').after('<option value="0" class="option-sk" >T시그니쳐 Master | 데이터 35G+무제한/통화문자무한</option><option value="1" class="option-sk" >T시그니쳐 Classic | 데이터 20G+무제한/통화문자무한</option><option value="2" class="option-sk" >band 데이터 퍼펙트S | 데이터 16G+무제한/통화문자무한</option><option value="3" class="option-sk" >band 데이터 퍼펙트 | 데이터 11G+무제한/통화문자무한</option><option value="4" class="option-sk" >band 데이터 6.5G | 데이터 6.5G/통화문자무한</option><option value="5" class="option-sk" >band 데이터 3.5G | 데이터 3.5G/통화문자무한</option><option value="6" class="option-sk" >band 데이터 2.2G | 데이터 2.2G/통화문자무한</option><option value="7" class="option-sk" >band 데이터 1.2G | 데이터 1.2G/통화문자무한</option><option value="8" class="option-sk" >band 데이터 세이브 | 데이터 300M/통화문자무한</option>');
	}else if ($carrier == 'kt'){
		if($('[name=paApplyType]:checked').val() == '06') {
			$('.js-gift').attr('type', 'radio')
			if($('.js-gift').parents('[data-default]').size == 0)
				$('.js-gift').prop('checked', false);
			$('.js-selectCount').text('1개 선택해주세요');
		}else if($('[name=paApplyType]:checked').val() == '02') {
			$('.js-gift').attr('type', 'checkbox');
			if($('.js-gift').parents('[data-default]').size == 0)
				$('.js-gift').prop('checked', false);
			$('.js-selectCount').text('2개 선택해주세요');
		}
		$('.js-planLabel').after('<option value="15" class="option-kt" >LTE 데이터 선택 109 | 데이터 30GB+무제한/음성 무제한/영상&amp;부가200분 추가제공</option><option value="16" class="option-kt" >LTE 데이터 선택 76.8 | 데이터 15GB+무제한/음성 무제한/영상&amp;부가200분 추가제공</option><option value="17" class="option-kt" >LTE 데이터 선택 65.8 | 데이터 10GB+무제한/음성 무제한/영상&amp;부가200분 추가제공</option><option value="18" class="option-kt" >LTE 데이터 선택 54.8 | 데이터 6GB/음성 무제한/영상&amp;부가30분 추가제공</option><option value="19" class="option-kt" >LTE 데이터 선택 49.3 | 데이터 3GB/음성 무제한/영상&amp;부가30분 추가제공</option><option value="20" class="option-kt" >LTE 데이터 선택 43.8 | 데이터 2GB/음성 무제한/영상&amp;부가30분 추가제공</option><option value="23" class="option-kt" >LTE 데이터 선택 38.3 | 데이터 1GB/음성 무제한/영상&amp;부가30분 추가제공</option><option value="24" class="option-kt" >LTE 데이터 선택 32.8 | 데이터 300MB/음성 무제한/영상&amp;부가30분 추가제공</option>');
	}else{
		return true;
	}
	$('.js-planLabel').text('--요금제를 선택해주세요--');
	if($('.js-planselect[data-default]').size == 0)
		$('.js-planselect').val('');
}

function syncCurrentAndTargetCarrier() {
	var $paApplyType = $('[name=paApplyType]:checked').val();
	var $paCurrentCarrier = $('[name=paCurrentCarrier]:checked').val();
	var $targetCarrier = $('[name=paChangeCarrier]:checked').val();
	var $paDevice = $('[name=paDevice]:checked').val();
	

	if(!$paCurrentCarrier)
		return true;

	if($paDevice == 'bey'){
		
		$('[name=paApplyType]').parent('.inp-chk').show();

		if($paCurrentCarrier == 'kt'){
			$('[name=paApplyType][value=02]').prop('checked',false);
			$('[name=paApplyType][value=02]').parent('.inp-chk').hide();
			return true;
		}
	}
	if($('[name=paChangeCarrier][value='+$paCurrentCarrier+']').length < 1) {
		if($paApplyType == '06') {
			$('[name=paApplyType]').prop('checked',false);
			$('[name=paApplyType][value=02]').prop('checked',true);
			$paApplyType = '02';
		}

		$('[name=paApplyType][value=06]').parent('.inp-chk').hide();
	}

	if($paApplyType == '06') {
		$('[name=paChangeCarrier][value='+$paCurrentCarrier+']').prop('checked',true);
		$('[name=paChangeCarrier]').parent('.inp-chk').hide();
		$('[name=paChangeCarrier][value='+$paCurrentCarrier+']').parent('.inp-chk').show();
	} else if($paApplyType == '02') {
		if($paCurrentCarrier == $targetCarrier)	$('[name=paChangeCarrier]').prop('checked',false);
		$('[name=paChangeCarrier]').parent('.inp-chk').show();
		$('[name=paChangeCarrier][value='+$paCurrentCarrier+']').parent('.inp-chk').hide();		
	}

	updatePlan();
}


$(function() {
	$('[data-default]').each(function(){		
		//console.log($(this).attr('data-default'));
		console.log($(this));
		syncCurrentAndTargetCarrier();
		if($(this)[0].nodeName == 'SELECT'){
			console.log('afd');
			$(this).find('option[value='+$(this).attr('data-default')+']').attr('selected', 'selected');
			
		}else if($(this).find('input[type=checkbox]').size() > 0  || $(this).find('input[type=radio]').size() > 0){
			var $mutipleValue = $(this).attr('data-default').split(',');
			var $target = $(this);
			$.each($mutipleValue, function(index, value){
				console.log();
				$target.find('[value='+value+']').prop('checked', true);			
				if($target.hasClass('js-giftWrap') == true){
					$old = $new;
					$new = value;
					console.log('1');
					console.log($new);
				}
			});
		} else 
			$(this).val($(this).attr('data-default'));

		
		
		//$('.js-giftWrap').find('[value='+$(this).attr('data-default')+']').prop('checked', true);
		
	});
	
});


</script>