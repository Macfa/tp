<?php 
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$js_file .= '<script type="text/javascript" src="'.PATH_JS.'/input.js"></script>';
require_once($cfg['path']."/adminhead.php");			// 헤더 부분 (스킨포함)

$date3daysago = date('Y-m-d', strtotime("-3 day", strtotime($cfg['time_ymd'])));
$list = DB::query("SELECT * FROM tmApplyTmp WHERE apProcess=%i AND apDonetype=%i AND apDonetime <= %s AND apDonetime != '0000-00-00 00:00:00'", 5, 0, $date3daysago);


// echo "<pre>";
// var_dump($time);
// echo "</pre>";

	foreach ($list as $key => $val) {
		// echo $val['apDonetime'];
		// // $day = date_add(now(), interval -1 day);
		// echo $day;
		// echo "<pre>";
		// echo $val['apDonetime'];
		// echo "</pre>";

		$list_model[] = DB::queryOneField('dvModelCode', "SELECT * FROM tmDevice WHERE dvKey=%s", $val['dvKey']);
		$list_member[] = DB::query("SELECT mbName, mbPhone FROM tmMember WHERE mbEmail=%s", $val['mbEmail']);
		
	}

if($list != null ) {
	foreach($list_member as $idx => $arr_idx) {
		foreach($arr_idx as $idx2 => $arr_val) {
			foreach ($arr_val as $type => $val) {
				if($type == 'mbName')
					$list_name[$idx]['mbName'] = $val;
				else
					$list_phone[$idx]['mbPhone'] = $val;
			}
		}
	}
}


// tmMember 챙길 것
// Server 에서 작업 챙길것 ( 크론 )

 ?>

<div class="wrap applyList-wrap">
	<h1 class="center tit">CRM 리스트 </h1>
		<table class="table-grid-dense" style="font-size:.85em">
			<thead>
				<tr class="">
					<td class="table-item-str">이름</td>
					<td class="table-item-str">전화번호</td>
					<td class="table-item-str">이메일</td>
					<td class="table-item-str">기기</td>
					<td class="table-item-str">현재통신사</td>
					<td class="table-item-str">신청통신사</td>
					<td class="table-item-str">색상</td>
					<td class="table-item-str">개통날짜</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<? foreach($list as $key => $row) : ?>
					<tr>
						<td class="table-item-str"><?php echo $list_name[$key]['mbName'] ?></td>
						<td class="table-item-str"><?php echo $list_phone[$key]['mbPhone'] ?></td>
						<td class="table-item-str"><?php echo $row['mbEmail'] ?></td>							
						<td class="table-item-str"><?php echo $list_model[$key] ?></td>
						<td class="table-item-str"><?php echo $row['apCurrentCarrier'] ?></td>
						<td class="table-item-str"><?php echo $row['apChangeCarrier'] ?></td>
						<td class="table-item-str"><?php echo $row['apColor'] ?></td>	
						<td class="table-item-str"><?php echo $row['apDonetime'] ?></td>
						<td class="table-item-str"><a href="crmUpdate.php?apKey=<?php echo $row['apKey'] ?>" class="btn-filled-sub-dense">통화완료</a></td>
					</tr>
				<?php endforeach?>
			</tbody>
		</table>
</div>
