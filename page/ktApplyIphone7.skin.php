
<section style="background:white">
	<img src="../img/iphone7_kt.jpg">
</section>
<br/>
<div class="preorder-wrap">
	<?php if($isLogged == false) :?>
	<section class="section">
		<h3 class="tit-sub center">로그인후 가입신청이 가능합니다.</h3>
		<a href="<?php echo $cfg['login_url']?>" class="btn-filled-sub">로그인/회원가입</a>
	</section>
	<?php endif?>
	<form action="ktApplyIphone7Action.php" method="post">
		<input type="hidden" name="poKey" value="<?php echo $preorderTitle['poKey']?>">
		<input type="hidden" name="paKey" value="<?php echo $preorder['paKey']?>">
		<section class="section txt-left">
			<h2 class="tit-sub center">아이폰7 / 아이폰7플러스 KT 가입 신청하기</h2>
			<div class="txt-highlight center"><i class="ico-caution-small"></i> KT신청은 유선으로 실가입이 진행됩니다</div>
			<ul class="inlinelist applyKT">
				<li> 
					<span class="label"><i class="ico-person-small"></i> 예약자명</span><span class="cont"><?php echo $preorder['paName'] ?></span>	
				</li><li>
					<span class="label"><i class="ico-apply-type-small"></i> 신청 기기 </span><span class="cont"><?php echo $device[$preorder['dvKey']] ?></span>								
				</li><li>
					<span class="label"><i class="ico-apply-type-small"></i> 가입유형</span><span class="cont"><?php echo $type[$preorder['paApplyType']] ?></span>
				</li><li>
					<span class="label"><i class="ico-plan-small"></i> 요금제</span><span class="cont"><?php echo (isExist($plan[$preorder['paPlan']]))?$plan[$preorder['paPlan']]:$preorder['paPlan']; ?></span>
				</li><li>
					<span class="label"><i class="ico-tel-small"></i> 전화번호</span><span class="cont"><?php echo $preorder['paPhone'] ?></span>	
				</li><li class="center">
					<span class="label"><i class="ico-apply-type-small"></i> 연락가능한 시간</span>								
				</li><li class="center">
					<select style="width:30%;height:30px;border:solid 1px rgba(0,0,0,0.15);"  name="paFromTime">
						<option value="" class="js-planLabel">-시간를 선택해주세요-</option>
						<? for($i=10; $i<20; $i++) : ?>
						<option value="<?echo $i ?>"><?echo $i ?>:00</option>
						<?endfor?>
					</select> 에서
					<select style="width:30%;height:30px;border:solid 1px rgba(0,0,0,0.15);"  name="paToTime">
						<option value="" class="js-planLabel">-시간를 선택해주세요-</option>
						<? for($i=10; $i<20; $i++) : ?>
						<option value="<?echo $i ?>"><?echo $i ?>:00</option>
						<?endfor?>
					</select> 까지 가능합니다
				</li>
			</ul>		
			<br/><br/>
		</section>
		<input type="submit" value="신청하기" class="btn-filled-primary-dense">	
	</form>	
</div>
