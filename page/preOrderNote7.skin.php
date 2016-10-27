<main class="preorder-main" style="margin:0;">
<div class="count-top" >
	<h3 class="count-tit" style="color:white; font-size:1.3em; letter-spacing:-0.03em;margin:0;margin-bottom:5px; ">현재 호갱탈출 신청자</h3>
	<div class="count-box" >
		<h1 class="count-much" style=" font-size:3em;margin:0;">2000<span class="count-how" style=" font-size:.5em;">명</span></h1>
	</div>
</div>
</main>
<!--div class="stopcalling" style="text-align:center; background-color:black; margin:0; padding:20px;padding-bottom:40px;">
	<h1 style="font-weight:bold; color:#febd32;">노트7 배송 관계로 전화상담을 조기마감합니다.<br/>양해부탁드립니다.</h1>
	<h3 style="color:#febd32;">*서류미비자 분들만 개별상담 진행합니다.</h3>
	<form><input class="faqmove" type="button"  value="FAQ 바로보기" style="padding:10px 20px; background-color:#febd32; font-weight:bold; border-radius:5px; border-color:black;"/></form>
</div-->

<script>
$('.faqmove').click(function(){
var target_id='.qnascroll';
$('body, html').css('scrollTop', $(target_id).offset().top);
$('body, html').animate({ scrollTop: $(target_id).offset().top }, 1400); 
window.scrollTo(0, $(target_id).offset().top);
});
</script>

<div class="preorder-wrap">
<a target="_blank" href="http://blog.naver.com/traumplanit" class="btn-filled-primary">공지사항 확인</a>
<Br/><Br/>
	<!--section class="section-calltime" style="margin:30px; ">
		<img class="calltime-png" src="<?=PATH_IMG?>/preordernote7-time.png" style="display:inline-block;margin-bottom:-5px; "/><span class="calltime-tit" style="font-size:2em; letter-spacing:0.05em; color:#febd32; "> 상담시간</span>
		<h1 class="calltime-tit" style="font-size:2em; padding-bottom:15px;">AM 9:30 - PM 7:00 (점심시간 : 12시~1시30분)</h1>
	</section-->
	<section class="section-no-padding">
		<h2 class="preorder-tit-inside">
			노트7 신청 진행순서
		</h2>
		<!--<i class="ico-caution-small"></i> 진행순서는 상시 변경될 수 있습니다.!-->
		<div class="preorder-select-carrier">
			<h3 class="tit-sub">신청하실 통신사 선택</h3>
			<label class="inp-chk-dense">
				<input type="radio" class="js-processCarrierSK" name="processCarrier" value="SK"/>
				<div class="inp-chk-box"></div>
				SK
			</label>
			<label class="inp-chk-dense">
				<input type="radio" class="js-processCarrierKT" name="processCarrier" value="KT"/>
				<div class="inp-chk-box"></div>
				KT
			</label>
<!--			<label class="inp-chk-dense">
				<input type="radio" class="js-processCarrierLG" name="processCarrier" value="LG"/>
				<div class="inp-chk-box"></div>
				LG
			</label>
-->
		</div>
		<div class="tit-sub js-pleaseSelectCarrier"><br/><br/>통신사를 먼저 선택해주세요.<br/><br/><br/><br/></div>
		<ul class="preorder-process js-processKT">
			<!--
			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-tplanit"></i>
					01 티플에서 사전예약신청
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						매일 저녁 6시 사전예약자 일괄 안내문자 발송
					</li>
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						신청하신 통신사에서 사전예약 확인문자 발송
					</li>
				</ul>
			</li>
			-->
			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-apply"></i>
					01 온라인 가입신청
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						개통되는 것이 아닌 가입신청 하는 것입니다.
					</li>
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						KT의 경우, 가입신청서 없이 온라인으로만 신청하실 수 있습니다.
					</li>
				</ul>
				<div class="process-content">
					기기변경&nbsp; 
					<a href="" target="_blank" class="btn-filled-primary-dense js-changeDeviceSelectPlan">가입신청</a> 
					<br/><br/>
					번호이동&nbsp; 
					<a href=""  target="_blank" class="btn-filled-primary-dense js-changeCarrierSelectPlan">가입신청</a>
				</div>
			</li>

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-note7send"></i>
					02 노트7 기기 선발송
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						순차발송
					</li>
					<li class="process-content-item">
						<i class="ico-process-truck"></i>
						신뢰도 100% 안전한 우체국 택배로 배송됩니다.
					</li>
					<li class="process-content-item">
						<i class="ico-process-person"></i>
						가입신청하신 고객 대상
					</li>
				</ul>
			</li>

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-device-check"></i>
					03 기기 도착 확인
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						기기도착시 아래 버튼을 눌러 도착 확인을 해주세요.
					</li>
				</ul>
			</li>

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-note7-done"></i>
					04 노트7 개통
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-person"></i>
						기기도착 확인하신 고객 대상
					</li>
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						순차개통
					</li>
				</ul>
			</li>

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-gift-send"></i>
					05 티플 사은품 발송
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						순차발송
					</li>
				</ul>
			</li>
	<!--
			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-samsung-sms"></i>
					06 삼성 사전예약 문자
				</h3>
			</li>
	-->
		</ul>

		<ul class="preorder-process js-processSK js-processLG">
	<!--		<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-tplanit"></i>
					01 티플에서 사전예약신청
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						매일 저녁 6시 사전예약자 일괄 안내문자 발송
					</li>
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						신청하신 통신사에서 사전예약 확인문자 발송
					</li>
				</ul>
			</li>
	-->

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-doc"></i>
					01 온라인 가입신청
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						요금제 변경을 원하시는 분은 메모장에 원하신 요금제로 써주시면<br/> 개통 직전에 바꿔드립니다
					</li>
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						온라인 가입은 신용카드 혹은 범용공인인증서(유료)가 반드시 필요합니다
					</li>
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						서류 가입을 완료해주신 분은 따로 가입안하셔도 됩니다.
					</li>
				</ul>
				<div class="process-content">
					<select class="js-planselect inp-select" style="height:60px;border:solid 1px rgba(0,0,0,0.15)">
						<option value="">--요금제를 선택해주세요--</option>
						<option value="100">Band 데이터 100</option>
						<option value="80">Band 데이터 80</option>
						<option value="69">Band 데이터 69</option>
						<option value="59">Band 데이터 59</option>
						<option value="51">Band 데이터 51</option>
						<option value="47">Band 데이터 47</option>
						<option value="42">Band 데이터 42</option>
						<option value="36">Band 데이터 36</option>
						<option value="29">Band 데이터 29</option>
					</select>
					<br/><br/><br/>
					<!--div class="tit-inside">가입유형 선택</div>
					<label class="inp-chk-dense">
						<input type="radio" name="processApplyType" checked value="02"/>
						<div class="inp-chk-box"></div>
						<span class="js-processCarrierStr"></span>로 번호이동
					</label>
					<label class="inp-chk-dense">
						<input type="radio" name="processApplyType" value="06"/>
						<div class="inp-chk-box"></div>
						<span class="js-processCarrierStr"></span> 기기변경
					</label-->
					번호이동 &nbsp;&nbsp;
				<!--
				<a href="" target="common-action" class="btn-filled-primary-dense js-changeCarrierDownload">다운로드</a> 
					&nbsp; 
					<a href=""  target="common-action" class="btn-filled-sub-dense js-changeCarrierGuide">작성가이드</a>
					&nbsp; 
					-->
					<a href="" onclick="alert('신청하실 요금제를 선택해주세요.');return false;" target="_blank" class="btn-filled-primary-dense js-skChangeCarrierApply">가입신청</a>
					<br/><br/>
					기기변경 &nbsp;&nbsp;
					<!--
					<a href=""  target="common-action" class="btn-filled-primary-dense js-changeDeviceDownload">다운로드</a>
					&nbsp; 
					<a href=""  target="common-action" class="btn-filled-sub-dense js-changeDeviceGuide">작성가이드</a>
					&nbsp; 
					-->
					<a href="" onclick="alert('신청하실 요금제를 선택해주세요.');return false;"  target="_blank" class="btn-filled-primary-dense js-skChangeDeviceApply">가입신청<?php echo $affixSKapply?></a>
				</div>
			</li>

			<!--li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-idcard"></i>
					03 신분증&가입신청서 스캔
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						신분증은 반드시 앞면이 명확하게 보여야 합니다
					</li>
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						가입신청서도 내용이 명확하게 보여야 합니다
					</li>
				</ul>
			</li-->

			<!--li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-send"></i>
					04 가입신청서&신분증을 압축 후 업로드
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						원래 진행하려고 했던 등기는 진행하지 않습니다. 불편을 드려 죄송합니다.
					</li>
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						가입신청서&신분증 스캔 본을 압축해주세요.
					</li>
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						가입신청서에 수정이 필요하면 따로 연락드리니 기다려주세요.
					</li>
				</ul>
				<div class="process-content">
					<form  name="fileSend" target="common-action" action="/page/preOrderNote7Upload.php" method="POST" enctype="multipart/form-data">
					<div class="inp-file-wrap js-uploadRequiredLogin">
							<div class="inp-txt js-fileName"><?php echo $fileName?></div>
							<div class="inp-label">파일명 <span class="js-uploadDone" style="color:red;display:none;<?php echo $isUploadedClass?>">업로드 됨</span></div>
							<label class="inp-file-btn-label" for="file">
								<input type="button" style="cursor:pointer" class="btn-filled-sub-dense" value="파일선택" />
							</label>
							<input type="file" id="file" name="preorderDocument" class="inp-file-btn js-fileInput" data-allowed='zip,rar,7z,alz'/>
						&nbsp;
						<input type="submit" class="btn-filled-primary-dense btn-upload js-fileUpload" value="업로드"/>
					</div>
					</form>
					<?php if ($isLogged) :?>
					<?php else :?>
					<button onclick="alert('오늘 오후 6시 부터 가능합니다');return false;"  class="btn-filled-primary-dense">업로드</button>
					<?php endif ?>
				</div>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						업로드가 되지 않으시면 mobile@traum.asia 메일로 첨부해서 보내주시기 바랍니다..
					</li>
				</ul>
			</li-->

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-note7send"></i>
					02 노트7 기기 선발송
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-person"></i>
						가입신청하신 고객 대상
					</li>
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						배송추적번호는 문자로 통보해드립니다.
					</li>
				</ul>
				<!--div class="process-content">
					<a style="cursor:pointer" <?php echo $deviceTrackingAction?> class="btn-filled-primary-dense js-trackingNum"/>배송추적</a>
				</div-->
			</li>

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-device-check"></i>
					03 기기 도착 확인
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						기기도착시 아래 버튼을 눌러 도착 확인을 해주세요.
					</li>
				</ul>
				<div class="process-content">
					<input type="button" style="cursor:pointer" onclick="alert('기기 발송 후 가능합니다!');return false;" class="btn-filled-primary-dense" value="도착확인" />
				</div>
			</li>

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-note7-done"></i>
					04 노트7 개통
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-person"></i>
						기기도착 확인하신 고객 대상
					</li>
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						순차개통
					</li>
				</ul>
			</li>

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-gift-send"></i>
					05 티플 사은품 발송
				</h3>
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-caution"></i>
						순차발송
					</li>
				</ul>
				<div class="process-content">
					<input type="button" style="cursor:pointer" onclick="alert('사은품 발송 후 가능합니다!');return false;" class="btn-filled-primary-dense" value="배송추적" />
				</div>
			</li>
	<!--
			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-process-samsung-sms"></i>
					07 삼성 사전예약 문자
				</h3>
			</li>
	-->
		</ul>
	</section>
</div>
<div class="preorder-divide">
</div>
<div class="preorder-wrap">
	<h2 class="tit">
		요금제 계산
	</h2>

	<a href="https://docs.google.com/spreadsheets/d/1Y3vce-N53P-RnzD8bI0hTF8ccs8UJp0xUR9E8GWhK4Q/edit?pref=2&pli=1#gid=0" class="btn-filled-primary-dense" target="_blank">요금제 계산하기</a>
	<BR/><bR/><bR/><bR/><bR/>
	<section class="section-no-padding txt-left">
		<h2 class="tit center">
			<img class="qnascroll"src="<?=PATH_IMG?>/ico-qna.png"/>
			많이 묻는 질문
		</h2>

		<ul class="preorder-qna">
			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-question"></i>
					사은품 정말 주는 건가요?
				</h3> 
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						네, 맞습니다. 고객님.  원칙은 같이 보내드리는게 원칙이나 이번 노트7은 신청자가 많아 순차 발송으로 진행될 예정입니다.
					</li>
				</ul>
			</li>
	
			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-question"></i>
					삼성에서 주는 사전예약 사은품도 받을 수 있나요?
				</h3> 
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						네, 맞습니다. 사전예약 기간 개통하신 분은 모두 받으실 수 있습니다.
					</li>
				</ul>
			</li>
	<!--
			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-question"></i>
					삼성카드 적용은 어떻게 되나요?
				</h3> 
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						SK, LG 고객님은 다운받으신 서류에 삼성카드 정보를 넣어주시고,
					</li>
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						KT 고객님은 카카오톡 / 유선 으로 알려주세요.
					</li>
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						개통 후 일괄 공지를 통해 적용이 됩니다
					</li>
				</ul>
			</li>
	
			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-question"></i>
					사전예약 신청했는데 색상변경이 가능한가요?
				</h3> 
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						사전예약 완료 전이면 가능하지만 완료 후는 불가능합니다.
					</li>
				</ul>
			</li>
	
			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-question"></i>
					사은품 받지 않고 별포인트로 받을 수 있나요?
				</h3> 
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						가능합니다. 지급될 별 포인트는 추후에 결정됩니다.
					</li>
				</ul>
			</li>
	-->
			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-question"></i>
					T 가족포인트 적용 가능한가요?
				</h3> 
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						네, 가능합니다. 개통 후 위임동의서, 구성원 정보를 알려주시면적용해드립니다. <BR/> (차후 진행)
					</li>
				</ul>
			</li>

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-question"></i>
					클럽 T 적용은 되나요?
				</h3> 
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						저희는 클럽 T 뿐만 아니라 핸드폰 반납하는 것은 모두 적용이 안되십니다.
					</li>
				</ul>
			</li>

			<li class="preorder-process-item">
				<h3 class="process-item-tit">
					<i class="ico-question"></i>
					공시지원금과 선택약정의 차이가 뭔가요?
				</h3> 
				<ul class="process-content">
					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						공시지원금은 기계값을 할인 받는 것이고, 선택약정을 요금을 할인받는겁니다.
					</li>

					<li class="process-content-item">
						<i class="ico-process-sms"></i>
						자세한 것은 티플 블로그를 참고해주세요. (<a href="http://blog.naver.com/traumplanit/220737213683" target="_blank">http://blog.naver.com/traumplanit/220737213683</a>)
					</li>
				</ul>
			</li>
		</ul>
	</section>
</div>
<div class="js-alert" style=" width:250px; height:200px; background-color:white; text-align:center;position:fixed;top:40%;left:44%; display:none; border:3px solid #ffdb94; ">
	<h3 class="js-alert-loading-tit" style=" font-size:1.5em; color:#21242d; letter-spacing:0.03em; ">업로드중</h3>
	<img src="<?=PATH_IMG?>/preOrdernote7_loading.gif"/>
</div>
<script>

$(function(){
	<?php if ($_SESSION["preorder"]["downType"]) :?>
	$('[name=common-action]').attr('src', '/page/preOrderDonwload.php?carrier=<?php echo $_SESSION["preorder"]["downCarrier"]?>&type=<?php echo $_SESSION["preorder"]["downType"]?>');
	
	$('.js-processCarrier<?php echo $_SESSION["preorder"]["downCarrier"]?>').prop('checked','checked');
	<?php endif?>
	setProcessCarrier();
});


<?php if ($_GET['carrier']) :?>
$(function(){
	$('.js-processCarrier<?php echo $_GET['carrier']?>').prop('checked','checked');
	setProcessCarrier();
});
<?php endif?>

$('[name=processCarrier]').on('change click', function(){
	setProcessCarrier();
});

function setProcessCarrier(){
	
	var $carrier = $('[name=processCarrier]:checked').val();
	var $baseSrc = '<?php echo $cfg['url']?>/page/preOrderDonwload.php?carrier='+$carrier+'&type=';

	if ($carrier == 'SK' || $carrier == 'LG' || $carrier == 'KT') {
		$('.js-changeDeviceDownload').attr('href', $baseSrc + 'cd').attr('onclick','');
		$('.js-changeCarrierDownload').attr('href', $baseSrc + 'cc').attr('onclick','');
		$('.js-changeDeviceGuide').attr('href', $baseSrc + 'cd&mode=guide').attr('onclick','');
		$('.js-changeCarrierGuide').attr('href', $baseSrc + 'cc&mode=guide').attr('onclick','');
		if ($carrier == 'KT') {
			$('.js-changeDeviceSelectPlan').attr('href', $baseSrc + 'cd&mode=selectPlan');
			$('.js-changeCarrierSelectPlan').attr('href', $baseSrc + 'cc&mode=selectPlan');
		}
	}

	$('.js-pleaseSelectCarrier').hide();
	$('.js-processSK, .js-processLGU+, .js-processKT').removeClass('active');
	$('.js-process'+$carrier).addClass('active');
}

$('.js-fileUpload').click(function(){
	$('.js-alert').show();
});

$('.js-planselect').change(function(){
	var $skURLprefix = 'https://tgate.sktelecom.com/applform/main.do?prod_seq=';
	var $skChangeCarrierURLAffix = '&scrb_cl=02&mall_code=00001';
	var $skChangeDeviceURLAffix = '&scrb_cl=06&mall_code=00001';
	var $arrChangeCarrierURL = {100:'000000009264994',80:'000000009265006',69:'000000009265008',59:'000000009265010',51:'000000009265012',47:'000000009265014',42:'000000009265016',36:'000000009265018',29:'000000009265020'};
	var $arrChangeDeviceURL = {100:'000000009264995',80:'000000009265007',69:'000000009265009',59:'000000009265011',51:'000000009265013',47:'000000009265015',42:'000000009265017',36:'000000009265019',29:'000000009265021'};
	var $skChangeCarrierURL = $arrChangeCarrierURL[$(this).val()];
	var $skChangeDeviceURL = $arrChangeDeviceURL[$(this).val()];

	$('.js-skChangeCarrierApply').attr('onclick', '');
	$('.js-skChangeCarrierApply').attr('href', $skURLprefix+$skChangeCarrierURL+$skChangeCarrierURLAffix);

	<?php if ($cfg['time_ymdhis'] >= $cutline) :?>
	$('.js-skChangeDeviceApply').attr('onclick', '');
	$('.js-skChangeDeviceApply').attr('href', $skURLprefix+$skChangeDeviceURL+$skChangeDeviceURLAffix);
	<?php else :?>
	$('.js-skChangeDeviceApply').attr('onclick', 'alert("<?php echo getRelativeDate('2016-08-28')?> 점심 12시 부터 신청이 가능합니다.");return false;');
	<?php endif ?>
});

<?php if (!$isLogged) :?>
$('.js-uploadRequiredLogin, .js-trackingNum').click(function(){
	alert('로그인 후 가능합니다!');

	if ($('[name=processCarrier]:checked').val())
		var $carrier = $('[name=processCarrier]:checked').val();
	else
		var $carrier = '<?php echo $_GET['carrier']?>';
	location.href = '<?php echo $cfg['url']?>/user/login.php?returnURL=<?php echo urlencode('/page/preOrderNote7.php?carrier=')?>'+$carrier;
	return false;
});
<?php endif?>
</script>