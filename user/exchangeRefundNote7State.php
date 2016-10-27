<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/mypageList.css" type="text/css">';

$arrExchangeRefundList = DB::queryFirstRow("SELECT * FROM tmExchangeRefundNote7 WHERE mbEmail = %s", $mb['mbEmail']);



try{
 	if(count($arrExchangeRefundList) === 0)
		throw new Exception('신청후 확인 부탁드립니다.', 3);

}catch (Exception $e) {	
	if ($e->getCode() === 2)	
		alert($e->getMessage(), $cfg['path']);

	else if ($e->getCode() === 3)	
		alert($e->getMessage(), $cfg['path']."/page/exchangeRefundNote7.php");
}

if($arrExchangeRefundList['enWay'] === 'delivery' && $arrExchangeRefundList['enApplyType'] === 'exchange'){  // 택배교환
	$state = array(
		0 => '신청서작성',
		1 => '신청확인',
		2 => '교환기기배정<br/>(유선연락)',
		3 => '노트7 반품<br/>(유선연락)',
		4 => '노트7 반품확인',
		5 => '배송후 즉시사용<br/>(완료)'
	);
}
if($arrExchangeRefundList['enWay'] === 'offline' && $arrExchangeRefundList['enApplyType'] === 'exchange'){  // 내방교환
	$state = array(
		0 => '신청서작성',
		1 => '신청확인',
		2 => '교환기기배정<br/>(유선연락)',
		3 => '내방날짜예약<br/>(유선진행)',
		4 => '내방즉시교환<br/>(완료)'
	);
}

if($arrExchangeRefundList['enWay'] === 'delivery' && $arrExchangeRefundList['enApplyType'] === 'refund'){  // 택배환불
	$state = array(
		0 => '신청서작성',
		1 => '신청확인',
		2 => '사은품 비용입금',
		3 => '입금확인',
		4 => '노트7 반품',
		5 => '노트7 반품확인',
		6 => '노트7 개통취소',
		7 => '환불진행완료'
	);
	if($arrExchangeRefundList['enReceivedGift'] === '0'){
		unset($state[2]);
		unset($state[3]);
	}
}



if($arrExchangeRefundList['enWay'] === 'offline' && $arrExchangeRefundList['enApplyType'] === 'refund'){  // 내방환불
	$state = array(
		0 => '신청서작성',
		1 => '신청확인',
		2 => '사은품 비용입금',
		3 => '내방날짜예약<br/>(유선진행)',
		4 => '취소진행완료'
	);
	if($arrExchangeRefundList['enReceivedGift'] === '0'){
		unset($state[2]);
	}
}



$currentState[$arrExchangeRefundList['enProcess']] = 'active';

$gift = array(
	0 => '미수령',
	1 => '수령'
);

$way = array(
	'delivery' => '택배로 진행',
	'offline' => '방문하여 진행'
);

$type = array(
	'exchange' => '교환',
	'refund' => '환불'
);

$device = array(
	'galaxys7' => '갤럭시 S7',
	'galaxys7edge' => '갤럭시 S7 엣지',
	'galaxynote5' => '갤럭시 노트5',
	'v20' => 'LG V20',
	'iphone7' => '아이폰7',
	'iphone7Plus' => '아이폰7 플러스'
	
);

$color = array(
	'jetBlack' => '제트블랙',
	'black' => '블랙',
	'silver' => '실버',
	'gold' => '골드',
	'roseGold' => '로즈골드',
	'pink' => '핑크',
	'white' => '화이트',
	'pinkgold' => '핑크골드'
);




require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)


require_once("exchangeRefundNote7State.skin.php");		

require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)
