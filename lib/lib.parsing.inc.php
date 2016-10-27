<?

/////////////////////////////////////////////////////////////////////
//																					//
//			모든사이트에 기본적으로 들어가는 php 함수			//
//																					//
/////////////////////////////////////////////////////////////////////



// 삭제됫는지 여부
function is_deleted($url, $type) {
	if ($type == "0") {
		$url = explode('http://', $url);
		$url = "http://m.".$url[1];
		$rex = '/<p class="nt4">(게시물이 존재하지 않거나 삭제되었습니다\.)<\/p>/i';
	}
	$output = parsingMatch($url, $rex);
	if ($output) return true;
}

// 스크랩수 파싱
function get_scrap($url, $type) {
}


//기본 파싱 함수
function getParsing($url) {
	$snoopy=new snoopy;
	$snoopy->referer = $url;
	$snoopy->fetch($url);
	$page=$snoopy->results;
	if ($page == FALSE) return false;
	return $page;
}

//테스트 테스트 테스트 테스트 테스트 기본 파싱 함수
function getParsing_test($url, $rex) {
	$snoopy=new snoopy;
	$snoopy->referer = $url;
	$snoopy->fetch($url);
	echo $page=$snoopy->results;
	if ($page == false) return false;
	return parsingMatch($page, $rex);
}

function parsingMatch($url, $rex) {
	$target = getParsing($url);
	if (is_array($target)) {
		foreach($target as $val) {
			if (preg_match($rex, $val)) {
				return $output = parsingMatch($val, $rex);
			}
		}
	}else{
		preg_match_all($rex, $target, $output);
		$output = $output[1];
		if (count($output) > 1)	
			return $output;
		else	
			return $output[0];
	}
	
}


function getRexNum($target) {
	return $output = preg_replace("/[^0-9]*/s", "", $target);
}

function getRexMatch($target, $rex) {
	preg_match_all($rex, $target, $output);
	if (count($output) <= 1)	
		return $output[0][0];
	else {	
		if (count($output[1]) <= 1)
			return $output[1][0];
		else
			return $output[1];
	}
}

//보안으로 인한 allow_open_fopen = off 때문에 만든 url로 부터 내용을 얻어오는 함수
function get_contents($url) {
	$snoopy=new snoopy;
	$snoopy->referer = $url;
	$snoopy->fetch($url);
	return $page=$snoopy->results;
}

//노출순위 파싱
function get_search_rank($viral, $text, $kc_type) {
	if ($kc_type == '0') {
		$target = 'cafearticle';
		$display = '20';
	} else if ($kc_type == '2') {
		$target = 'blog';
		$display = '20';
	}
	$xml = get_contents('http://openapi.naver.com/search?key=baf13486e98a90a901296cf48605051e&query='.urlencode(trim($text)).'&display='.$display.'&start=1&target='.$target.'&sort=sim');
	$search = object2array(simplexml_load_string($xml));
	$search = $search['channel']['item'];
	//$rex = '/<p class="url".*id="url_.*">[\s\S]<img id="copyBtn.*title="(.*)".*>/';
	foreach($search as $key => $val) {
		$result[$key] = get_final_url($val['link']);
		if ($target == 'blog') {
			$result[$key] = explode('&logNo=', $result[$key]);
			$result[$key] = $val['bloggerlink'].'/'.$result[$key][1];
		}
		for ($i=0,$max=count($viral);$i<$max;$i++) {
			if ($viral[$i]['vi_url'] == $result[$key]) {
				$output[$key] = $viral[$i];
				$output[$key]['rank'] = $key+1;
				$output[$key]['query'] = $text;
			}
		}
	}
	return $output;
}

function convert_full_blogurl($viral) {
	$viral['id'] = explode('@',$viral['me_id']);
	$viral['id'] = $temp['id'][0];

	$viral['post_no'] = explode('/', $viral['vi_url']);
	$viral['post_no'] = $viral['post_no'][count($viral['post_no'])-1];

	$viral['post_url'] = 'http://blog.naver.com/'.$viral['id'].'/'.$viral['post_no'];
	
	return $output = $viral;
}

//게시판 정렬링크에 쓰이는 함수
function get_order_link($field, $anchor="") {
	global $pss;

	if ($_GET['of'] == $field) {
		if ($_GET['or'] == "desc") $order = "asc";
		else $order = "desc";
	} else 
		$order = "asc";

	$_SERVER['QUERY_STRING'] = str_replace("&or=".$_GET['or'], "", $_SERVER['QUERY_STRING']);
	$_SERVER['QUERY_STRING'] = str_replace("&of=".$_GET['of'], "", $_SERVER['QUERY_STRING']);
	$_SERVER['QUERY_STRING'] = str_replace("&or=", "", $_SERVER['QUERY_STRING']);
	$_SERVER['QUERY_STRING'] = str_replace("&of=", "", $_SERVER['QUERY_STRING']);

	return $output = $pss['full_url']."?".$_SERVER['QUERY_STRING']."&or=".$order."&of=".$field;

}

