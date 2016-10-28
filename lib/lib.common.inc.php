<?

/////////////////////////////////////////////////////////////////////
//																					//
//			모든사이트에 기본적으로 들어가는 php 함수			//
//																					//
/////////////////////////////////////////////////////////////////////


//2014-12-18



////////////////////////////////////////////기본 함수

//페이지 이동함수
function goURL($url='', $msg='') {
	
	if ($msg)
		echo "<p><a href=' ".$url." ' onclick='location.replace('".$url."');'>".$msg."</a></p>";
	if (!$url) 
		echo "<script type='text/javascript'>history.go(-1); </script>";
	else
		echo "<script type='text/javascript'> location.replace('".$url."'); </script>";
	
    exit;
}

function addTelHyphen($num){
  return preg_replace("/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/", "$1-$2-$3", $num);
}
function korStrReplace( $search, $to, $str ) { 
	return $str = preg_replace('/'.$search.'/',$to,$str);
} 

function consoleLog($input){
	echo "<script type='text/javascript'> console.log('".$input."'); </script>";
}

//경고창 함수
function alert($msg, $url='') {
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
	echo "<script type='text/javascript'>alert('$msg');</script>";
	goURL($url, $msg);
	exit;
}

function getFirstArrKey($arr){
	list($output) = array_keys($arr);
	return $output;
}

//시간을 년/월/일 로

function get_today() {
	
	if(!$today)
		$today = getdate();
	else
		$today = getdate($today);

	$weekse = Array("일","월","화","수","목","금","토"); 
	$today['yo_kr'] = $weekse[$today['wday']];
	$today['yoil_kr'] = $weekse[$today['wday']]."요일";

	$today['y_kr'] = $today['year']."년";
	$today['m_kr'] = $today['mon']."월";
	$today['d_kr'] = $today['mday']."일";

	$today['ymd_kr'] = $today['y_kr']." ".$today['m_kr']." ".$today['d_kr'];
	$today['ymdy_kr'] = $today['ymd_kr']." ".$today['yo_kr'];
	$today['ymdyoil_kr'] = $today['ymd_kr']." ".$today['yoil_kr'];

	return $today;
}

//파싱후 숫자만 남김
function parsingNum($input) {
	$output = preg_replace("/[^0-9]*/s", "", $input);
	if (!isNum(trim($output)))
		$output = false;
	return $output;
}


//http 없으면 붙이기 
function set_http($url)
{
    if (!trim($url)) return;

    if (!preg_match("/^(http|https|ftp|telnet|news|mms)\:\/\//i", $url))
        $url = "http://" . $url;

    return $url;
}

function object2array($object) {
	return @json_decode(@json_encode($object),1);
}

// url 파라미터 생성
function set_url_param($allow='') { 
	$link_arr = array();
    $temp_arr = $_GET; 
	// 허용되지 않은 변수는 통과시키지 않음
    foreach($temp_arr as $key=>$value ) {
		if (!$allow || strpos($allow, $key) !== false)
			if($value) $link_arr[] = "$key=$value";
	}
    return implode("&",$link_arr); 
}

class QueryStr 
{ 
  var $_query; 
  var $_ary = array(); 

  function QueryStr($Que){ 
      $this->_query = $Que; 
    parse_str($Que , $this->_ary ); 
  } 

  function VarDel($vname){ 
        unset(  $this->_ary[$vname]  ); 
  } 

  function VarAdd($vname,$vvalue){ 
        unset($this->_ary[$vname]); 
        $this->_ary[$vname] = $vvalue; 
  } 
  
  function Rst($skip=true){ 
      return  implode_assoc("=","&",$this->_ary,$skip); 
  } 

 function implode_assoc($inner_glue,$outer_glue,$array,$skip_empty=false){ 
    $output=array(); 
    foreach($array as $key=>$item) 
          if(!$skip_empty || isset($item)  ){$output[]=$key.$inner_glue.$item;} 
        return implode($outer_glue,$output); 
 } 
}; 


function remove_param($query_string, $param) {
	$param = explode(",", $param);
	for ($i=0;$i<count($param);$i++) {
		$query_string = preg_replace("/".$param[$i]."=".$_GET[$param[$i]]."+/", "", $query_string);
	}
	return $query_string = str_replace("&&", "&", $query_string);
}

//랜덤 난수 생성 (보안성X)
function getRandomString($length){  
	$c= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";  
	srand((double)microtime()*1000000);  
	for($i=0; $i<$length; $i++) {  
		$rand.= $c[rand()%strlen($c)];  
	}  
	return $rand;  
} 

//바이럴코드용 난수생성
function getViralCode() {
	global $member, $tg;

	$str = getRandomString(20);
	
	//DB에 존재하는 난수인지 검사
	$inMember = sql_select("count(*) as cnt", $tg['member_table'], "me_code = '{$str}'");
	$inViral = sql_select("count(*) as cnt", $tg['viral_table'], "vi_code = '{$str}'");

	if (($inMember['cnt'] == 0) && ($inViral['cnt'] == 0))
		return $str;
	else
		getViralCode();
}

function set_search_check($array, $id, $class, $get) {
	$output = "";
	$i = 0;
	foreach ($array as $key => $val){
		if ($get == "ty") $key = $val;
		$is_cheked = is_contain($_GET[$get], $key) ? "checked" : "";
		$output .= "<li class='dropdown-list'><label for='{$id}{$i}'>";
		$output .= "<input type='checkbox' id='{$id}{$i}' class='{$class}' value='{$key}' title='{$val}' {$is_cheked}/> ";
		$output .= $val;
		$output .= "</label></li>";
		$i++;
	}
	return $output;
}

// 쿠키변수 생성
function set_cookie($cookie_name, $value, $expire) {
    global $tg;
	if (headers_sent()) {
        $cookie = $cookie_name.'='.urlencode($value).';';
        if ($expire) $cookie .= ' expires='.gmdate('D, d M Y H:i:s', $expire).' GMT';
        echo '<script language="javascript">document.cookie="'.$cookie.'";</script>';
    } else 
		setcookie(md5($cookie_name), base64_encode($value), $tg['server_time'] + $expire, '/');
}

// 쿠키변수값 얻음
function get_cookie($cookie_name) {
    return base64_decode($_COOKIE[md5($cookie_name)]);
}


/**
 * get_redirect_url()
 * Gets the address that the provided URL redirects to,
 * or FALSE if there's no redirect. 
 *
 * @param string $url
 * @return string
 */
function get_redirect_url($url){
    $redirect_url = null; 

    $url_parts = @parse_url($url);
    if (!$url_parts) return false;
    if (!isset($url_parts['host'])) return false; //can't process relative URLs
    if (!isset($url_parts['path'])) $url_parts['path'] = '/';

    $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
    if (!$sock) return false;

    $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n"; 
    $request .= 'Host: ' . $url_parts['host'] . "\r\n"; 
    $request .= "Connection: Close\r\n\r\n"; 
    fwrite($sock, $request);
    $response = '';
    while(!feof($sock)) $response .= fread($sock, 8192);
    fclose($sock);

    if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
        if ( substr($matches[1], 0, 1) == "/" )
            return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
        else
            return trim($matches[1]);

    } else {
        return false;
    }

}

/**
 * get_all_redirects()
 * Follows and collects all redirects, in order, for the given URL. 
 *
 * @param string $url
 * @return array
 */
function get_all_redirects($url){
    $redirects = array();
    while ($newurl = get_redirect_url($url)){
        if (in_array($newurl, $redirects)){
            break;
        }
        $redirects[] = $newurl;
        $url = $newurl;
    }
    return $redirects;
}

/**
 * get_final_url()
 * Gets the address that the URL ultimately leads to. 
 * Returns $url itself if it isn't a redirect.
 *
 * @param string $url
 * @return string
 */
function get_final_url($url){
    $redirects = get_all_redirects($url);
    if (count($redirects)>0){
        return array_pop($redirects);
    } else {
        return $url;
    }
}

function cut_str($str, $len, $suffix="…") {
	$htmlFixer = new HtmlFixer();
	$c = substr(str_pad(decbin(ord($str{$len})),8,'0',STR_PAD_LEFT),0,2); 
	if ($c == '10') 
		for (;$c != '11' && $c{0} == 1;$c = substr(str_pad(decbin(ord($str{--$len})),8,'0',STR_PAD_LEFT),0,2)); 
	return $htmlFixer->getFixedHtml(substr($str,0,$len)) . (strlen($str)-strlen($suffix) >= $len ? $suffix : ''); 
}

function get_date_selectbox($name="", $date="", $format="ymd") {
    global $tg;

    $s = "";
    if (!$date) $date = $tg['time_ymd'];
	$current = $tg['time_ymdhis'];
    $m = explode('-', $date);
	$current = explode('-', $current);
	$maxYear = ($current[0]+3);

    // 년
	/*
    $y .= "<input type='text' class='inp-num' name='{$name}_y' id='{$name}-y' placeholder='4자리' value='{$m[0]}' data-parsley-range='[{$current[0]},{$maxYear}]' data-parsley-errors-container='#{$name}-wrap' data-parsley-group='{$name}' data-parsley-range-message='{$current[0]}~{$maxYear} 년만 입력이 가능합니다.' data-parsley-type='number' data-parsley-required/>";
	$y .= "<label>년</label>";
	
	*/
	$y .= "<select name='{$name}_y' class='inp-short text-right' id='{$name}-y' data-parsley-type='number'  data-parsley-required>";
    for ($i=$m[0]-3; $i<=$m[0]+3; $i++) {
        $y .= "<option value='$i'";
        if ($i == $m[0]) {
            $y .= " selected";
        }
        $y .= ">".$i."년</option>";
    }
    $y .= "</select>\n";

	if (strpos($format, "y") !== false)
		$s .= $y;

    // 월
    $mon = "<select name='{$name}_m' class='inp-short text-right' id='{$name}-m' data-parsley-range='[1,12]' data-parsley-type='number'  data-parsley-required>";
    for ($i=1; $i<=12; $i++) {
		if ($i < 10) $val = '0'.$i;
		else $val = $i;

        $mon .= "<option value='$val'";
        if ($i == $m[1]) {
            $mon .= " selected";
        }
        $mon .= ">$i 월</option>";
    }
    $mon .= "</select>\n";

	if (strpos($format, "m") !== false)
		$s .= $mon;

    // 일
	$d .= "<input type='text' class='inp-short' name='{$name}_d' id='{$name}-d' placeholder='0' value='{$m[2]}' data-parsley-min='1' data-parsley-errors-container='#{$name}-wrap' data-parsley-type='number' data-parsley-required/>";
	$d .= "<label>일</label>";
	/*
    for ($i=1; $i<=31; $i++) {
        $s .= "<option value='$i'";
        if ($i == $m[3]) {
            $s .= " selected";
        }
        $s .= ">$i 일</option>";
    }
    $s .= "</select>\n";
	*/
	if (strpos($format, "d") !== false)
		$s .= $d;

    return $s;
}

function convert_mobile_url($url, $kc_type) {
	if ($kc_type == '카페') {
		$url = explode('http://', $url);
		return $url = "http://m.".$url[1];
	}
}

// 전화번호에 하이픈 추가
function add_hp_hyphen($num){
  return preg_replace("/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/", "$1-$2-$3", $num);
}

/////////////////// 날짜 함수

// 기간내 날짜를 배열로 반환
function getDaysInRange($start, $end, $mode='d') {
	$max = getDateDiff($start, $end, $mode);
	for ($i=0;$i<=$max;$i++) {
		$output[$i] = calcDate($i, $start, $mode);		
	}
	return $output;
}

function calcDate($int, $date='', $mode='d') {
	$date = toArrYmd($date);
	if ($mode == "d")
		return date("Y-m-d", mktime(0,0,0,$date['m'], $date['d']+$int, $date['y']));
	else if ($mode == "m") 
		return date("Y-m", mktime(0,0,0,$date['m']+$int, $date['d'], $date['y']))."-01";
}

function convert_datetime($datetime, $mode) {
	if ($mode == 'Ymd') {
		return $datetime = substr($datetime,0,10);
	}else if ($mode == 'ymd') {
		return $datetime = substr($datetime,2,9);
	}
}

function getDateDiff($start, $end, $format='d') {
	if ($format == 'd')
		return floor(( strtotime($end) - strtotime($start) )/86400);
	else if ($format == 'm'){
		$start = explode('-', $start);
		$end = explode('-', $end);
		return ($end[0] - $start[0])*12 + ($end[1] - $start[1]); //(end년 - start년)*12 + (end달 - start달)
	}
}

function getStartNEndWeek($ymd) {
    $time = strtotime($ymd);
 
    $last['start'] = strtotime("this week", $time);
    $last['end'] = strtotime("Sunday this week", $time);
 
    $last['start'] = date("Y-m-d", $last['start']);
    $last['end'] = date("Y-m-d", $last['end']);
 
    return $last;
}

function toArrYmd($date='') {
	global $tg;
	if (!$date) $date = $tg['time_ymd'];
	$date = explode('-', $date);
	$output['y'] = $date['0'];
	$output['m'] = $date['1'];
	if ($date['2'])
		$output['d'] = $date['2'];
	else 
		$output['d'] = "01";
	return $output;
}

function getNum($input) {
	return $ouput = preg_replace("/[^0-9]*/s", "", $input);
}

function getIndexInArr($arr, $find, $mode = 'value') { 
	$num = 0 ; 
	$lSeeked = false; 
	foreach($arr as $key => $val) { 
		$num++; 
		if ($mode =='value' && $val == $find) { 
			$lSeeked = true; 
			break; 
		}
		if ($mode =='key' && $key == $find) { 
			$lSeeked = true; 
			break; 
		}
	}
	if ($lSeeked) 
		return $num; 
	else          
		return false; 
} 

function getRelativeDate($time) {
	global $cfg;
	$today = strtotime($cfg['time_ymd']);
	$time = strtotime($time);
	$reldays = ($time - $today)/86400;
	if ($reldays >= 0 && $reldays < 1) {
		return '오늘';
	} else if ($reldays >= 1 && $reldays < 2) {
		return '내일';
	} else if ($reldays >= -1 && $reldays < 0) {
		return '어제';
	}
	if (abs($reldays) < 7) {
		if ($reldays > 0) {
			$reldays = floor($reldays);
			return $reldays . ' 일' . ($reldays != 1 ? 's' : '') . ' 후';
		} else {
			$reldays = abs(floor($reldays));
			return $reldays . ' 일' . ($reldays != 1 ? 's' : '') . ' 전';
		}
	}
	if (abs($reldays) < 182) {
		return date('l, j F',$time ? $time : time());
	} else {
		return date('l, j F, Y',$time ? $time : time());
	}
}

function array2json( $array ){ 

    if( !is_array( $array ) ){ 
        return false; 
    } 

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) )); 
    if( $associative ){ 

        $construct = array(); 
        foreach( $array as $key => $value ){ 

            // We first copy each key/value pair into a staging array, 
            // formatting each key and value properly as we go. 

            // Format the key: 
            if( is_numeric($key) ){ 
                $key = "key_$key"; 
            } 
            $key = '"'.addslashes($key).'"'; 

            // Format the value: 
            if( is_array( $value )){ 
                $value = array2json( $value ); 
            } else if( !is_numeric( $value ) || is_string( $value ) ){ 
                $value = '"'.addslashes($value).'"'; 
            } 

            // Add to staging array: 
            $construct[] = "$key: $value"; 
        } 

        // Then we collapse the staging array into the JSON form: 
        $result = "{ " . implode( ", ", $construct ) . " }"; 

    } else { // If the array is a vector (not associative): 

        $construct = array(); 
        foreach( $array as $value ){ 

            // Format the value: 
            if( is_array( $value )){ 
                $value = array2json( $value ); 
            } else if( !is_numeric( $value ) || is_string( $value ) ){ 
                $value = '"'.addslashes($value).'"'; 
            } 

            // Add to staging array: 
            $construct[] = $value; 
        } 

        // Then we collapse the staging array into the JSON form: 
        $result = "[ " . implode( ", ", $construct ) . " ]"; 
    } 

    return $result; 
} 

function removeBlank($input) {
	return $output = preg_replace("/\s+/", "", $input);
}

function getResultTemplate($data, $template, $isEmptyValueRemove = false){
	$result = $template;
	foreach ($data as $key => $val) {
		$result = str_replace('{'.$key.'}', $val, $result);
	}
	if($isEmptyValueRemove === true) {
		$result = preg_replace('/\{.*?\}/', '', $result);
	}
	return $result;
}

function getArrayPart($array, $start, $end) {
	return array_slice($array,($start-1),($end-$start));
}

function convertEncoding($str, $toEncoding) {
	$fromEncoding = mb_detect_encoding($str);
	if (isNullVal($fromEncoding)) return iconv('euc-kr', $toEncoding, $str);
	if (strtolower($fromEncoding) === strtolower($toEncoding)) return $str;
    return iconv($fromEncoding, $toEncoding, $str);
}

function seachKeyArray($arr, $key){
	return 1;
}