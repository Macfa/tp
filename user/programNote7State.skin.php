<div class="mypage-wrap center ">
	<h1 class="tit center"></h1>
	<h3 class="txt intro-top">참다 참다 못 해 티플이 만든,</h3>
	<h1 class="tit-b w">삼성 Galaxy Note7</br>고객을 살려줘!!</h1>
	<!--
	<h2 class="tit-sub">노트7 티플 구제 프로그램</h2>
	
	<div class="tit-sub">진행단계</div>
	<ul class="preorder-process-wrap">
		<?php $stateIndex = 1?>
		<?php foreach($state as $key => $val) :?>
		<li class="<?php echo $currentState[$key]?>">
			<div class="number"><?php echo $stateIndex?></div>
			<div class="name"><?php echo $val?></div>
			<?php $stateIndex++?>
		</li>
		<?php endforeach?>
	</ul>
	-->
	<section class="section-no-padding">
		<Br/>
		<div class="tit-sub"><?echo "노트7 티플 구제 프로그램 신청정보" ?></div>
			<ul class="inlinelist">
				<li> 
					<span class="label"><i class="ico-person-small"></i> 신청자명</span><span class="cont"><?php echo $programNote7Member['mbName'] ?></span>	
				</li><li>
					<span class="label"><i class="ico-tel-small"></i> 전화번호</span><span class="cont"><?php echo $programNote7Member['mbPhone'] ?></span>			
				</li><li>
					<span class="label"><i class="ico-email-small"></i> 이메일 </span><span class="cont"><?php echo $programNote7Member['tnEmail'] ?></span>					
				</li><li>
					<span class="label"> 티플에서 구매여부 </span><span class="cont"><?php echo $buy[$programNote7Member['isBuyTplanitNote7']] ?></span>							
				</li><li>
					<span class="label"><i class="ico-carrier-small"></i> 현재 통신사</span><span class="cont"><?php echo $programNote7Member['tnCurrentCarrier'] ?></span>		
				</li><li>
					<span class="label"><i class="ico-apply-type-small"></i> 가입유형 </span><span class="cont"><?php echo $type[$programNote7Member['tnApplyType']]?></span>	
				</li>			
				<Br/>
			</ul>			
	</section>
	<br/>
	<span class="label"></span><span class="cont"><a href=<? echo $applyLinkUrl ?> target="_blank" class="btn-filled-primary-dense js-applyBtn">비와이폰 가입신청</a></span>	
</div>
