<?php
$a1 = '154000'; // 출고가
$a2 = '115000'; // 공시지원금
$a3 = '17200'; // 유통망지원금
$a4 = $a1-$a2-$a3 ; // 단말기할부금
$basic = '16500'; // 기본료(실청구액)

$s1 = '132000';
$s2 = '115000';
$s3 = '17000';
$s4 = $s1-$s2-$s3 ;
?>

	
<div class="list-banner-egg">
	<span class="list-banner-inner-kt">
	<h1 class="egg-tit center">KT 에그 드디어 상륙!</h1>
	<h2 class="sub center">휴대용 와이파이계의 원조<Br/>KT Egg가 드디어 티플 런칭!</h2>
	</span>
</div>
<div class="wrap">
	<section class="plan-calc-wrap">
		<section class="plan-calc-arg">
		<h1 class="center">LTE egg + A</h1>			

			<img src="<?=PATH_IMG?>/egg_a.png"/>
		</section>
		<section class="plan-calc-result">
			<div class="row">
				<div class="col-txt txt-bold">
					LTE egg+ A 신규가입
				</div>
			</div><div class="row">
				<div class="col-tit">
				</div><div class="col-cont-wrap">
					<div class="col-txt-2">
						총 액
					</div><div class="col-txt-2">
						24개월
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					출고가
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 js-retailPrice">
						<?php echo number_format($a1) ?>
					</div><div class="col-txt-2 js-retailPricePerMonth">
						<?php echo number_format(floor($a1/24))?>
					</div>
				</div>
			</div>
			<div class="row-responsive js-supportRow active">
				<div class="col-tit">
					공시지원금
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 minus js-support">
					<?php echo number_format($a2) ?>
					</div><div class="col-txt-2 minus js-supportPerMonth">
					<?php echo number_format(floor($a2/24))?>
						
					</div>
				</div>
			</div>
			<div class="last-row row-responsive js-supportRow active">
				<div class="col-tit">
					유통망 지원금
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 minus js-addSupport">
					<?php echo number_format($a3) ?>						
					</div><div class="col-txt-2 minus js-addSupportPerMonth">
					<?php echo number_format(floor($a3/24))?>	
					</div>
				</div>
			</div>
			<div class="row row-divide">
				<div class="col-tit">
					단말기할부
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 js-retailPriceOriginInstallation">
						<?php echo number_format($a4)?>
					</div><div class="col-txt-2 js-retailPriceInstallation">
						<?php echo number_format(floor(960))?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					요금제기본료
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2">
					</div><div class="col-txt-2 js-planFee">
						<?php echo number_format($basic)?>
					</div>
				</div>
			</div>			
			<div class="row row-divide">
				<div class="col-tit">
					월청구액
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2">
					</div><div class="col-txt-2 js-planResult">
						<?php echo number_format($basic + 960)?>
					</div>
				</div>
			</div>
			<div class="center">
				<a class="btn" href="http://online.olleh.com/index.jsp?prdcID=3EE62685-4539-4915-94E4-11408B6CC5F4"target="_blank">
				<span>가입 신청</span>
				</a>
			</div>
		</section>
	</section>
	
	<section class="plan-calc-wrap">
		<section class="plan-calc-arg">
		<h1 class="center">LTE egg + S</h1>
			<img src="<?=PATH_IMG?>/egg_s.png"/>
		</section>
		<section class="plan-calc-result">
			<div class="row">
				<div class="col-txt txt-bold">
					LTE egg+ S 신규가입
				</div>
			</div><div class="row">
				<div class="col-tit">
				</div><div class="col-cont-wrap">
					<div class="col-txt-2">
						총 액
					</div><div class="col-txt-2">
						24개월
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					출고가
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 js-retailPrice">
						<?php echo number_format($s1) ?>
					</div><div class="col-txt-2 js-retailPricePerMonth">
						<?php echo number_format(floor($s1/24))?>
					</div>
				</div>
			</div>
			<div class="row-responsive js-supportRow active">
				<div class="col-tit">
					공시지원금
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 minus js-support">
					<?php echo number_format($s2) ?>
					</div><div class="col-txt-2 minus js-supportPerMonth">
					<?php echo number_format(floor($s2/24))?>
						
					</div>
				</div>
			</div>
			<div class="last-row row-responsive js-supportRow active">
				<div class="col-tit">
					유통망 지원금
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 minus js-addSupport">
					<?php echo number_format($s3) ?>						
					</div><div class="col-txt-2 minus js-addSupportPerMonth">
					<?php echo number_format(floor($s3/24))?>	
					</div>
				</div>
			</div>
			<div class="row row-divide">
				<div class="col-tit">
					단말기할부
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2 js-retailPriceOriginInstallation">
						<?php echo number_format($s4)?>
					</div><div class="col-txt-2 js-retailPriceInstallation">
						<?php echo number_format(floor($s4/24))?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-tit">
					요금제기본료
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2">
					</div><div class="col-txt-2 js-planFee">
						<?php echo number_format($basic)?>
					</div>
				</div>
			</div>			
			<div class="row row-divide">
				<div class="col-tit">
					월청구액
				</div><div class="col-cont-wrap int">
					<div class="col-txt-2">
					</div><div class="col-txt-2 js-planResult">
						<?php echo number_format($basic + floor($s4/24))?>
					</div>
				</div>
			</div>
			<div class="center">
				<a class="btn" href="http://online.olleh.com/index.jsp?prdcID=C18DAEAD-70B5-49EF-BDDC-D44CE89DCE62"target="_blank">
				<span>가입 신청</span>
				</a>
			</div>
		</section>
	</section>


	<?php
	include('./detail-pocketfi.skin.php');
	?>
	</div>
	<div class="wrap">
		<section class="gift-notice">
			<div class="gift-notice-wrap">
				<i class="ico-gift-notice"></i>
				<span class="gift-notice-txt">사은품은 해피콜 시 말씀해주세요!</span>
			</div>
		</section>
	</div>
	<div class="wrap">
	<section class="way">
		<h2 class="tit center">
			구매방법
		</h2>
		<ul class="detail-progress-wrap">
			<li class="detail-progress-item-wrap">
				<div class="detail-progress-item">
					<span>1.</span>
					<i class="detail-progress-ico-search"></i>
					<div class="detail-progress-cont">
						원하시는 상품을 선택 후, 가입형태를 선택합니다.(신규, 기변, 번호이동)
					</div>
				</div>
			</li>
			
			<li class="detail-progress-item-wrap">
				<div class="detail-progress-item">
					<span>2.</span>
					<i class="detail-progress-ico-apply"></i>
					<div class="detail-progress-cont">
						원하시는 요금제를 선택해 신청서를 작성합니다.
					</div>
				</div>
			</li>
			<li class="detail-progress-item-wrap">
				<div class="detail-progress-item">
					<span>3.</span>
					<i class="detail-progress-ico-tel"></i>
					<div class="detail-progress-cont">
						개통 실시 이전, 해피콜을 통해 가입정보 확인을 합니다.
					</div>
				</div>
			</li>
			<li class="detail-progress-item-wrap">
				<div class="detail-progress-item">
					<span>4.</span>
					<i class="detail-progress-ico-delivery"></i>
					<div class="detail-progress-cont">
						개통 후, 기기와 사은품을 함께 배송해드립니다.(당일 퀵/택배 발송)
					</div>
				</div>
			</li>
		</ul>
	</section>	
	<?php
	if($device['dvCate'] == 'pocketfi')
	require("./reviewpocketfi.php");	
	?>

	<?php
	$detailNone = 'none';
	include('./detailCaution.skin.php');	
	?>

