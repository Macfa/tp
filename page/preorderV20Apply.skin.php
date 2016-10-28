
<section style="background:white">
	<img src="../img/lg_v20.jpg">
</section>
<br/>
<div class="preorder-wrap">
	<?php if($isLogged == false) :?>
	<section class="section">
		<h3 class="tit-sub center">로그인후 구매신청이 가능합니다.</h3>
		<a href="<?php echo $cfg['login_url']?>" class="btn-filled-sub">로그인/회원가입</a>
	</section>
	<?php endif?>
	<form action="preorderV20ApplyAction.php" method="post">
		<input type="hidden" name="pvKey" value="<?php echo $preorder['pvKey']?>">
		<section class="section txt-left">
			<h2 class="tit-sub">V20 신청하기</h2>
			<i class="ico-person-small"></i>예약자명 <Br/> <span><?php echo $mb['mbName']?></span><br/><br/>
			<label class="inp-wrap">
				<i class="ico-email-small"></i>
				<input type="text" class="inp-txt" name="V20Email" value="<?php echo ($validEmail)?$validEmail:''; ?>" />
				<div class="inp-label">이메일</div>
			</label>
			<br>
			<label class="inp-wrap">
				<i class="ico-tel-small"></i>
				<input type="text" class="inp-txt" name="V20Phone" value="<?php echo ($validPhone)?$validPhone:''; ?>" />
				<div class="inp-label">전화번호</div>
			</label>
			<br>
			<label class="inp-wrap">
				<i class="ico-calendar-small"></i> 
				<input type="text" class="inp-txt" name="V20Birth" value="<?php echo str_replace('-','',$preorder['pvBirth']); ?>" />
				<div class="inp-label">생년월일</div>
				<span class="inp-hint">19701015 형식으로 입력</span>
			</label>
			<fieldset class="inp-group">
				성별 <br/>
				<label class="inp-chk">
					<input type="radio" name="sexType" value="0"/>
					<div class="inp-chk-box"></div>
					남자
				</label>
				<label class="inp-chk">
					<input type="radio" name="sexType" value="1"/>
					<div class="inp-chk-box"></div>
					여자
				</label>
			</fieldset>
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
			<fieldset class="inp-group">
				<i class="ico-apply-type-small"></i> 가입유형 <br/>
				<label class="inp-chk">
					<input type="radio" name="applyType" value="02"/>
					<div class="inp-chk-box"></div>
					번호이동
				</label>
				<label class="inp-chk">
					<input type="radio" name="applyType" value="06"/>
					<div class="inp-chk-box"></div>
					기기변경
				</label>
			</fieldset>

			<fieldset class="inp-group">
				<i class="ico-carrier-small"></i> 변경 통신사 <br/>
				<label class="inp-chk">
					<input type="radio" name="pvChangeCarrier" value="sk"/>
					<div class="inp-chk-box"></div>
					SKT
				</label>
				<label class="inp-chk">
					<input type="radio" name="pvChangeCarrier" value="kt"/>
					<div class="inp-chk-box"></div>
					KT olleh
				</label>
			</fieldset>

			<fieldset class="inp-group">
				<i class="ico-color-small"></i> 색상 <br/>
				<label class="inp-chk">
					<input type="radio" name="colorType" value="black"/>
					<div class="inp-chk-box"></div>
					블랙
				</label>
				<label class="inp-chk">
					<input type="radio" name="colorType" value="silver"/>
					<div class="inp-chk-box"></div>
					실버
				</label>
				<label class="inp-chk">
					<input type="radio" name="colorType" value="pink"/>
					<div class="inp-chk-box"></div>
					핑크
				</label>
			</fieldset>
			
			<div class="inp-tit"><i class="ico-plan-small"></i> 요금제선택 </div>
			<br/>
			<select class="js-planselect inp-select" style="height:60px;border:solid 1px rgba(0,0,0,0.15)"  name="plan">
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
				<textarea name="pvEtc" class="inp-txtarea" ></textarea>
				<div class="inp-label">기타사항 & 요구사항</div>
			</label-->
		</section>
		<input type="submit" value="신청하기" class="btn-filled-primary-dense">	
	</form>

	
</div>

<script>

$(function(){
	syncCurrentAndTargetCarrier();
});

$('[name=pvChangeCarrier]').change(function(){
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

$('[name=current]').change(function(){
	syncCurrentAndTargetCarrier();
});

$('[name=applyType]').change(function(){
	syncCurrentAndTargetCarrier();

});

function updatePlan(){
	var $carrier = $('[name=pvChangeCarrier]:checked').val();
	$('.option-kt').remove();
	$('.option-sk').remove();
	if($carrier == 'sk') {
		$('.js-planLabel').after('<option value="0" class="option-sk" >T시그니쳐 Master | 데이터 35G+무제한/통화문자무한</option><option value="1" class="option-sk" >T시그니쳐 Classic | 데이터 20G+무제한/통화문자무한</option><option value="2" class="option-sk" >band 데이터 퍼펙트S | 데이터 16G+무제한/통화문자무한</option><option value="3" class="option-sk" >band 데이터 퍼펙트 | 데이터 11G+무제한/통화문자무한</option><option value="4" class="option-sk" >band 데이터 6.5G | 데이터 6.5G/통화문자무한</option><option value="5" class="option-sk" >band 데이터 3.5G | 데이터 3.5G/통화문자무한</option><option value="6" class="option-sk" >band 데이터 2.2G | 데이터 2.2G/통화문자무한</option><option value="7" class="option-sk" >band 데이터 1.2G | 데이터 1.2G/통화문자무한</option><option value="8" class="option-sk" >band 데이터 세이브 | 데이터 300M/통화문자무한</option>');
	}else if ($carrier == 'kt'){
		$('.js-planLabel').after('<option value="15" class="option-kt" >LTE 데이터 선택 109 | 데이터 30GB+무제한/음성 무제한/영상&amp;부가200분 추가제공</option><option value="16" class="option-kt" >LTE 데이터 선택 76.8 | 데이터 15GB+무제한/음성 무제한/영상&amp;부가200분 추가제공</option><option value="17" class="option-kt" >LTE 데이터 선택 65.8 | 데이터 10GB+무제한/음성 무제한/영상&amp;부가200분 추가제공</option><option value="18" class="option-kt" >LTE 데이터 선택 54.8 | 데이터 6GB/음성 무제한/영상&amp;부가30분 추가제공</option><option value="19" class="option-kt" >LTE 데이터 선택 49.3 | 데이터 3GB/음성 무제한/영상&amp;부가30분 추가제공</option><option value="20" class="option-kt" >LTE 데이터 선택 43.8 | 데이터 2GB/음성 무제한/영상&amp;부가30분 추가제공</option><option value="23" class="option-kt" >LTE 데이터 선택 38.3 | 데이터 1GB/음성 무제한/영상&amp;부가30분 추가제공</option><option value="24" class="option-kt" >LTE 데이터 선택 32.8 | 데이터 300MB/음성 무제한/영상&amp;부가30분 추가제공</option>');
	}else{
		return true;
	}
	$('.js-planLabel').text('--요금제를 선택해주세요--');
	$('.js-planselect').val('');
}

function syncCurrentAndTargetCarrier() {
	var $applyType = $('[name=applyType]:checked').val();
	var $currentCarrier = $('[name=current]:checked').val();
	var $targetCarrier = $('[name=pvChangeCarrier]:checked').val();

	if(!$currentCarrier)
		return true;

	if($('[name=pvChangeCarrier][value='+$currentCarrier+']').length < 1) {
		if($applyType == '06') {
			$('[name=applyType]').prop('checked',false);
			$('[name=applyType][value=02]').prop('checked',true);
			$applyType = '02';
		}
		$('[name=applyType][value=06]').parent('.inp-chk').hide();
	}else{
		$('[name=applyType]').parent('.inp-chk').show();
	}

	if($applyType == '06') {
		$('[name=pvChangeCarrier][value='+$currentCarrier+']').prop('checked',true);
		$('[name=pvChangeCarrier]').parent('.inp-chk').hide();
		$('[name=pvChangeCarrier][value='+$currentCarrier+']').parent('.inp-chk').show();
	} else if($applyType == '02') {
		if($currentCarrier == $targetCarrier)	$('[name=pvChangeCarrier]').prop('checked',false);
		$('[name=pvChangeCarrier]').parent('.inp-chk').show();
		$('[name=pvChangeCarrier][value='+$currentCarrier+']').parent('.inp-chk').hide();		
	}

	updatePlan();
}

</script>