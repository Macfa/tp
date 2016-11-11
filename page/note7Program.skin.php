<div class="wrap-dense">
	<h1 class="tit">갤럭시노트7 프로그램</h1>
	<?php if($isLogged == false) :?>
	<section class="section">
		<h3 class="tit-sub center">로그인 후 신청이 가능합니다.</h3>
		<a href="<?php echo $cfg['login_url']?>" class="btn-filled-sub">로그인/회원가입</a>
	</section>
	<?php endif?>

	<form action="note7ProgramAction.php" method="post">
		<input type="hidden" name="enKey" value="">
		<section class="section txt-left">
			<fieldset class="inp-group">
				<label class="inp-wrap">
					<i class="ico-person-small"></i>
					<input type="text" class="inp-txt" value="<?php echo $mb['mbName']?>" />
					<div class="inp-label">성함</div>
				</label>
				<br/>
				<label class="inp-wrap">
					<i class="ico-tel-small"></i>
					<input type="text" class="inp-txt" name="tnPhone" value="<?php echo ($validPhone)?$validPhone:''; ?>" />
					<div class="inp-label">연락처</div>
				</label>
			</fieldset>
			<fieldset class="inp-group">
				티플에서 구매하셨나요? <br/>
				<label class="inp-chk">
					<input type="radio" name="isBuyTplanitNote7" value="1"/>
					<div class="inp-chk-box"></div>
					네
				</label>
				<label class="inp-chk">
					<input type="radio" name="isBuyTplanitNote7" value="0"/>
					<div class="inp-chk-box"></div>
					아니오
				</label>
			</fieldset>
			<fieldset class="inp-group">
				<i class="ico-carrier-small"></i> 현재 통신사 <br/>
				<label class="inp-chk">
					<input type="radio" name="tnCurrentCarrier" value="sk"/>
					<div class="inp-chk-box"></div>
					SK
				</label>
				<label class="inp-chk">
					<input type="radio" name="tnCurrentCarrier" value="kt"/>
					<div class="inp-chk-box"></div>
					KT
				</label>
				<label class="inp-chk">
					<input type="radio" name="tnCurrentCarrier" value="lg"/>
					<div class="inp-chk-box"></div>
					LG
				</label>
			</fieldset>
			
			<!--
			
				<fieldset class="inp-group">
					<i class="ico-change-device-small"></i> 가입유형 <br/>
					<label class="inp-chk">
						<input type="radio" name="tnApplyType" value="02"/>
						<div class="inp-chk-box"></div>
						번호이동
					</label>
					<label class="inp-chk">
						<input type="radio" name="tnApplyType" value="06"/>
						<div class="inp-chk-box"></div>
						기기변경
					</label>
				</fieldset>
		
				
			

			<script type="text/javascript">

			$('[name=tnCurrentCarrier][value=lg]').parent('.inp-chk').hide();
				$('[name=isBuyTplanitNote7]').change(function(){
					var $buyVal = $('[name=isBuyTplanitNote7]:checked').val();
					var $currentCarrierVal = $('[name=tnCurrentCarrier]:checked').val();


					$('[name=tnCurrentCarrier][value=lg]').parent('.inp-chk').hide();
					if($buyVal == '1'){
						if($currentCarrierVal =='sk'){
							$('.js-tnApplyTypeWrap').show().find('input').removeAttr('disabled');
						}


					}
						else if($buyVal == '0'){
								$('[name=tnCurrentCarrier][value=lg]').prop('checked',false);
								$('[name=tnCurrentCarrier][value=lg]').parent('.inp-chk').show();


						} 
				});

				$('.js-capacityWrap').hide().find('input').attr('disabled', 'disabled').prop('checked', false);
		
			</script>

-->


			
			<!--label class="inp-wrap">
				<i class="ico-talk-small"></i>
				<textarea name="paEtc" class="inp-txtarea" ></textarea>
				<div class="inp-label">기타사항 & 요구사항</div>
			</label-->
		</section>
	

		<input type="submit" class="btn-filled" data-action="note7ProgramAction.php" value="번이신청하기"/>
		<input type="submit" class="btn-filled" data-action="note7ProgramActionaa.php" value="기변신청하기"/>	
	</form>

	
</div>