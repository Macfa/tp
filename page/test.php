<?

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
include_once(PATH_LIB."/lib.snoopy.inc.php");
include_once(PATH_LIB."/lib.parsing.inc.php");
//include_once(PATH_LIB."/lib.calculator.inc.php");

$preorderTitle = DB::queryFirstRow("SELECT poKey, poDeviceName FROM tmPreorder WHERE poDeviceName=%s",$_GET['device']);




//$calculator = new calculator('v20');
//$calculator->setCarrierSelect()->setDeviceTypeSelect()->setCapacitySelect()->setApplyTypeSelect()->setDiscountTypeSelect()->setVatContainSelect()->setPlanSelect();


$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/preOrderNote7.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/preorderNote7.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/calculator.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/validate.js"></script>';
$cfg['title'] = $preorderTitle['poDeviceName'].' 구매안내';

$validEmail = '';
$validPhone = '';
if (isEmail($mb['mbEmail']) === true && $isLogged === TRUE)
	$validEmail = $mb['mbEmail'];

if  (isPhoneNum($mb['mbPhone']) == true || isTelNum($mb['mbPhone']) == true && $isLogged === TRUE){
	$validPhone = $mb['mbPhone'];
}


/*
$phone = new deviceInfo();
$arrPlan = $phone->setCarrier('sk')->setMode('phone')->getArrPlan();
foreach($arrPlan as $plan){
	$select .= '<option value="'.$plan.'" class="option-sk">'.$phone->getPlanName($plan).' | '.$phone->getPlanInfo($plan).'</option>';
}
$arrPlan = $phone->setCarrier('kt')->setMode('phone')->getArrPlan();
foreach($arrPlan as $plan){
	$select .= '<option value="'.$plan.'" class="option-kt">'.$phone->getPlanName($plan).' | '.$phone->getPlanInfo($plan).'</option>';
}
*/

require_once($cfg['path']."/head.inc.php");	
?>
<section style="background:white">
	<img src="../img/iphone7.jpg">
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
		<section class="section txt-left">
			<h2 class="tit-sub"><?echo $preorderTitle['poDeviceName']." 신청하기"?></h2>
			<i class="ico-person-small"></i>예약자명 <Br/> <span><?php echo $mb['mbName']?></span><br/><br/>
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
				<input type="text" class="inp-txt" name="paBirth" value="<?php echo str_replace('-','',$preorder['paBirth']); ?>" />
				<div class="inp-label">생년월일</div>
				<span class="inp-hint">19701015 형식으로 입력</span>
			</label>
			<fieldset class="inp-group">
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
			<fieldset class="inp-group">
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
			<fieldset class="inp-group">
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

			<fieldset class="inp-group">
				<i class="ico-carrier-small"></i> 변경 통신사 <br/>
				<label class="inp-chk">
					<input type="radio" name="paChangeCarrier" value="sk"/>
					<div class="inp-chk-box"></div>
					SKT
				</label>
				<label class="inp-chk">
					<input type="radio" name="paChangeCarrier" value="kt"/>
					<div class="inp-chk-box"></div>
					KT olleh
				</label>
			</fieldset>

			<fieldset class="inp-group">
				<i class="ico-color-small"></i> 색상 <br/>
				<label class="inp-chk">
					<input type="checkbox" name="paColorType" value="jetBlack"/>
					<div class="inp-chk-box"></div>
					제트블랙
				</label>
				<label class="inp-chk">
					<input type="checkbox" name="paColorType" value="black"/>
					<div class="inp-chk-box"></div>
					블랙
				</label>
				<label class="inp-chk">
					<input type="checkbox" name="paColorType" value="silver"/>
					<div class="inp-chk-box"></div>
					실버
				</label>
				<label class="inp-chk">
					<input type="checkbox" name="paColorType" value="gold"/>
					<div class="inp-chk-box"></div>
					골드
				</label>
				<label class="inp-chk">
					<input type="checkbox" name="paColorType" value="roseGold"/>
					<div class="inp-chk-box"></div>
					로즈골드
				</label>
			</fieldset>
			
			<div class="inp-tit"><i class="ico-plan-small"></i> 요금제선택 </div>
			<br/>
			<select class="js-planselect inp-select" style="height:60px;border:solid 1px rgba(0,0,0,0.15)"  name="paPlan">
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
$("input:checkbox[name=paColorType]:checked").each(function(i,elements){
    //해당 index(순서)값을 가져옵니다.
    index = $(elements).index("input:checkbox[name=paColorType]");              

    //해당 index에 해당하는 체크박스의 값을 가져옵니다.        
    alert($("input:checkbox[name=paColorType]").eq(index),val());
});



$(function(){
	syncCurrentAndTargetCarrier();
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

$('[name=pacurrentCarrier]').change(function(){
	syncCurrentAndTargetCarrier();
});

$('[name=paApplyType]').change(function(){
	syncCurrentAndTargetCarrier();

});

function updatePlan(){
	var $carrier = $('[name=paChangeCarrier]:checked').val();
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
	var $paApplyType = $('[name=paApplyType]:checked').val();
	var $paCurrentCarrier = $('[name=paCurrentCarrier]:checked').val();
	var $targetCarrier = $('[name=paChangeCarrier]:checked').val();

	if(!$paCurrentCarrier)
		return true;

	if($('[name=paChangeCarrier][value='+$paCurrentCarrier+']').length < 1) {
		if($paApplyType == '06') {
			$('[name=paApplyType]').prop('checked',false);
			$('[name=paApplyType][value=02]').prop('checked',true);
			$paApplyType = '02';
		}
		$('[name=paApplyType][value=06]').parent('.inp-chk').hide();
	}else{
		$('[name=paApplyType]').parent('.inp-chk').show();
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

</script>