<div class="wrap-dense">
	<h1 class="tit">갤럭시노트7 프로그램</h1>
	<?php if($isLogged == false) :?>
	<section class="section">
		<h3 class="tit-sub center">로그인 후 신청이 가능합니다.</h3>
		<a href="<?php echo $cfg['login_url']?>" class="btn-filled-sub">로그인/회원가입</a>
	</section>
	<?php endif?>

	<form action="programNote7ApplyAction.php" method="post">
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
				<br/>
				<label class="inp-wrap">
					<i class="ico-email-small"></i>
					<input type="text" class="inp-txt" name="tnEmail" value="<?php echo ($validEmail)?$validEmail:''; ?>" />
					<div class="inp-label">이메일</div>
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
			
			<div class="js-applyTypeWrap" style="display:none">
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
			</div>
			
		
				
			

			<script type="text/javascript">

			$('[name=tnCurrentCarrier][value=lg]').parent('.inp-chk').hide();
				$('[name=isBuyTplanitNote7]').change(function(){
					var $buyVal = $('[name=isBuyTplanitNote7]:checked').val();	
					$('.js-applyTypeWrap').hide().find('input').attr('disabled', 'disabled').prop('checked', false);				

					$('[name=tnCurrentCarrier][value=lg]').parent('.inp-chk').hide();
					$('.js-submit').show();	

					if($buyVal == '0'){						
						$('[name=tnCurrentCarrier][value=lg]').prop('checked',false);
						$('[name=tnCurrentCarrier][value=lg]').parent('.inp-chk').show();
						$('[name=tnCurrentCarrier]').prop('checked',false);						
							
						$('.js-notice').hide();		
					} 
					
					


				}); // 티플구매 여부에 대한 LG 통신사 

				$('[name=tnCurrentCarrier]').change(function(){
					var $buyVal = $('[name=isBuyTplanitNote7]:checked').val();	
					var $currentCarrier = $('[name=tnCurrentCarrier]:checked').val();	

					$('.js-applyTypeWrap').hide().find('input').attr('disabled', 'disabled').prop('checked', false);	

					$('.js-notice').hide();	
					if($buyVal == '1' && $currentCarrier == 'sk'){						
						$('.js-applyTypeWrap').show().find('input').attr('disabled', 'disabled').prop('checked', true);
						$('[name=tnApplyType]').prop('checked',false);						
						$('[name=tnApplyType]').removeAttr('disabled');
						$('[name=tnApplyType][value=06]').parent('.inp-chk').hide();
						$('.js-submit').show();		
					}else if($buyVal == '1' && $currentCarrier == 'kt'){	
						$('.js-notice').show();			
						$('.js-submit').hide();		
					}else if($buyVal == '0' ){	
						$('.js-applyTypeWrap').show().find('input').attr('disabled', 'disabled').prop('checked', true);
						$('[name=tnApplyType]').prop('checked',false);						
						$('[name=tnApplyType]').removeAttr('disabled');
						$('.js-submit').show();	
						if($currentCarrier == 'kt')	{
							$('[name=tnApplyType][value=02]').parent('.inp-chk').hide();
							$('[name=tnApplyType][value=06]').parent('.inp-chk').show();
						}else {
							$('[name=tnApplyType][value=02]').parent('.inp-chk').show();
							$('[name=tnApplyType][value=06]').parent('.inp-chk').hide();

						}
					}
				}); 		
			</script>

		</section>	

		<div class="js-submit" style="display:none">			
			<input type="submit" class="btn-filled" value="신청하기"/>	
		</div>
		<div class="js-notice" style="display:none">		
			<span class="sub"><i class="ico-caution-small"></i> 신청이 불가능합니다. 유선상으로 상담바랍니다.</span>			
		</div>

	</form>

	
</div>