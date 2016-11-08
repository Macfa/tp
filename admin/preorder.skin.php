<div class="wrap applyList-wrap">
	<h1 class="center tit"><?echo $preorderTitle?> 사전예약 리스트 </h1>	
	<h2 class="center sub">조회된 사전예약자 : <?echo $count?> 명 </h2>	
	<div class="center">
		<form method="get">
			<select name="searchDevice" data-default="<?echo $_GET['searchDevice']?>">
				<option value="">선택기기</option>
				<? foreach ($preorder as $val) :?>		
					<option value="<? echo $val['poKey'] ?>"><? echo $val['poDeviceName'] ?></option>
				<? endforeach?>
			</select>&nbsp;&nbsp;<input type="text" name="search" value=<? echo $search ?>>
				<input type="submit" value="검색" ><label class="inp-chk" >
				<input type="checkbox" class="js-tableChk" value="canceled" name="chked">
				<div class="inp-chk-box" ></div>취소한 예약자
			</label>	
		</form>			
	</div>
	<br/>
	<form method="post">
		<div class="center">
			
				선택된 행을
				<select name="changeProcess" class="js-stateSelect">
					<? foreach ($changeState as $key => $val) : ?>				
						<option value="<?echo $key?>"><?echo $val?></option>
					<?endforeach?>
				</select>
				상태로 
				<br/>	
					<input type="hidden" value="<?echo $searchDevice?>" name="hidden">
					<input type="submit" class="btn-filled" data-action="preorderAction.php" value="적용"/>
					<input type="submit" class="btn-filled" data-action="preorderDelete.php" value="취소"/>
					<input type="submit" class="btn-filled" data-action="preorderDeleteRestore.php" value="취소복구"/>
				<!--<br/>
				<input type="submit" class="btn-filled" data-action="preorderTrackingNum.php" value="송장번호입력"/>-->
				<br/><br/>
				
				<?if (isExist($downloadFullUrl)):?>
					<button class="btn-filled-sub-dense" data-action="<?echo $downloadFullUrl ?>">조회된 사전예약자 엑셀 다운로드</button>
				<?endif?>
				<button class="btn-filled-sub-dense" data-action="preorderApplyListDownload.php">체크된 사전예약자 엑셀다운로드</button>
			
		</div>
		<br/>
		<table class="table">
			<thead>
				<tr class="">
					<td class="chk-wrap">
						<label class="inp-chk">
							<input type="checkbox" class="js-tableAllChk" value="<?php echo $row['paKey']?>"/>
							<div class="inp-chk-box">
							</div>
						</label>
					</td>					
					<td class="table-item-str">진행상황</td>
					<td class="table-item-str">예약자명</td>										
					<td class="table-item-str">이메일</td>
					<!--<td class="table-item-str">송장번호</td>-->
					<td class="table-item-str">전화번호</td>
					<td class="table-item-str">생년월일</td>					
					<td class="table-item-str table-dense">현재통신사</td>
					<td class="table-item-str">가입유형</td>
					<td class="table-item-str">신청한 통신사</td>
					<td class="table-item-str">순 번</td>
					<td class="table-item-str">신청기기</td>
					<td class="table-item-str">색 상</td>
					<!--<td class="table-item-str">2지망 색상</td>-->
					<td class="table-item-str">선택요금제</td>
					<td class="table-item-str">선택사은품</td>				
					<td class="table-item-str">성별</td>					
					<td class="table-item-str">취소상태</td>
					<td class="table-item-str">KT가능시간</td>
					<td class="table-item-str preorder">타임스탬프</td>
				</tr>
			</thead>	
			<tbody>
				<? foreach($existList as $key => $row) : ?>
					<tr class="js-cartRow<?php echo $row['paKey']?>" <?php echo $row['cancelClass']?>>					
						<td class="chk-wrap">
							<label class="inp-chk">
								<input type="checkbox" class="js-tableChk" value="<?php echo $row['paKey']?>" name="chk[]" ?>
								<div class="inp-chk-box"></div>
							</label>
						</td>							
						<td class="table-item-str"><?php echo $state[$row['paProcess']] ?></td>
						<td class="table-item-str"><a href="/page/preorderApply.php?device=<?echo $preorderTitle?>&mbEmail=<?echo $row['paEmail']?>"><?php echo $row['paName'] ?></a></td>			
						<td class="table-item-str"><?php echo $row['paEmail'] ?></td>
						<!--<td class="table-item-str"><input type="text" value="<?php echo (isExist($row['paTrackingNum']))?$row['paTrackingNum']:"" ?>" name="paTrackingNum[]" class="trackinNum js-trackingNum"></td>-->
						<td class="table-item-str"><?php echo $row['paPhone'] ?></td>
						<td class="table-item-str"><?php echo $row['paBirth'] ?></td>						
						<td class="table-item-str"><?php echo $row['paCurrentCarrier'] ?></td>
						<td class="table-item-str"><?php echo $type[$row['paApplyType']] ?></td>
						<td class="table-item-str"><?php echo $row['paChangeCarrier'] ?></td>
						<td class="table-item-str"><?php echo $preorderOrderNumString[$key] ?></td>
						<td class="table-item-str"><?php echo $deviceKey[$row['dvKey']] ?></td>
						<td class="table-item-str"><?php echo $color[$row['paColorType']] ?></td>
						<!--<td class="table-item-str"><?php echo $color[$row['pa2ndColor']] ?></td>-->
						<td class="table-item-str"><?php echo (isExist($plan[$row['paPlan']]))?$plan[$row['paPlan']]:$row['paPlan'] ?></td>
						<td class="table-item-str"><?php foreach($row['paGift'] as $giftList){echo $gift[$giftList]."<Br/>";} ?></td>						
						<td class="table-item-str"><?php echo $sex [$row['paSexType']] ?></td>					
						<td class="table-item-str"><?php echo $cancel[$row['paCancel']] ?></td>
						<td class="table-item-str"><?php echo $row['paContactTime'] ?></td>
						<td class="table-item-str"><?php echo $row['paDatetime'] ?></td>
						
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
		<br/><br/>
		<div class="center">
			<? if( $count > 15)  :?>
				선택된 행을
				<select name="changeProcess" class="js-stateSelect">
					<? foreach ($changeState as $key => $val) : ?>				
						<option value="<?echo $key?>"><?echo $val?></option>
					<?endforeach?>
				</select>
				상태로 
				<br/>		
					<input type="hidden" value="<?echo $searchDevice?>" name="hidden">
					<input type="submit" class="btn-filled" data-action="preorderAction.php" value="적용"/>
					<input type="submit" class="btn-filled" data-action="preorderDelete.php" value="취소"/>
					<input type="submit" class="btn-filled" data-action="preorderDeleteRestore.php" value="취소복구"/>
				<br/><br/>	
				<?if (isExist($downloadFullUrl)):?>
					<button class="btn-filled-sub-dense" data-action="<?echo $downloadFullUrl ?>">조회된 사전예약자 엑셀 다운로드</button>
				<?endif?>
				<button class="btn-filled-sub-dense" data-action="preorderApplyListDownload.php">체크된 사전예약자 엑셀다운로드</button>
			<?endif?>	
		</div>
	</form>
<script>
$('.js-tableChk').change(function(){
	if (this.checked == true)
		$(this).parents('tr').addClass('active');
	else
		$(this).parents('tr').removeClass('active');

});

$('.js-tableAllChk').change(function(){
	$('.js-tableChk').prop("checked", this.checked);
	$('.js-tableChk').trigger('change');
	if (this.checked == true)
		$('.js-tableChk').parents('tr').addClass('active');
	else
		$('.js-tableChk').parents('tr').removeClass('active');

});

$('.js-stateSelect').change(function(){
	$('.js-stateSelect').val($(this).val());

});

$(function() {
	$('[data-default]').each(function(){		
		if($(this).find('input[type=checkbox]').size()>0){
			$(this).find('[value='+$(this).attr('data-default')+']').prop('checked', true);
		} else
			$(this).val($(this).attr('data-default'));
	});
});

$('.js-trackingNum').change(function(){
	$(this).parents('tr').find('.js-tableChk').prop('checked', true);
	$('.js-trackingNum').each(function(){
		var checkedParent = $('.js-tableChk:checked').parents('tr');
			checkedParent	.addClass('active');		
	});

   });
</script>