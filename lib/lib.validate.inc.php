<?

/////////////////////////////////////////////////////////////////////
//																					//
//			모든사이트에 기본적으로 들어가는 php 함수			//
//																					//
/////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////유효성 검사

function isNullVal($input) {
	if ($input === NULL || $input === '' || $input === ' ' || !isset($input))
		return true;
	return false;
}

function isNotExist($input) {
	if ($input === NULL || $input === '' || $input === ' ' || !isset($input))
		return true;
	return false;
}

function isExist($input) {
	if ($input === NULL || $input === '' || $input === ' ' || !isset($input))
		return false;
	return true;
}


//숫자인지
function isNum($input) {
	if (preg_match("/\d+/",$input)) return true;
	return false;
}

//영어인지
function isEng($input) {
	if (preg_match("/[a-zA-Z]+/",$input)) return true;
	return false;
}

//한글인지
function isKor($input) {
	if (preg_match("/[\xa1-\xfe]+/",$input)) return true;
	return false;
}

//특수문자포함여부
function is_contain_special($input) {
	if (preg_match('/[!#$%^&*()+=\-\[\]\';.\/{}|":<>?~\\\\]/',$input)) return true;
	return false;
}

//숫자,영어만
function isNumEng($input) {
	if (preg_match("/[a-z A-Z \d]+/",$input)) return true;
	return false;
}

//영어 혹은 한글만
function isKorEng($input) {
	if (preg_match("/[a-zA-Z \xa1-\xfe]+/",$input)) return true;
	return false;
}


//숫자,영어 혹은 특수문자만
function isPw($input) {
	if (preg_match("/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9!.*#$%^&*()+=\-\[\]\';.\/{}|\":<>?~\\\\]*$/",$input)) return true;
	return false;
}

//이메일 정규식
function isEmail($input) {
	if (preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $input)) return true;
	return false;
}

//폰번 정규식
function isPhoneNum($input) {
	if (preg_match("/^01(0|1|6)-?\d{3,4}-?\d{4}$/", $input)) return true;
	return false;
}

//전번 정규식
function isTelNum($input) {
	if (preg_match("/^0(70|2|31|32|33|41|42|43|51|52|53|54|55|61|62|63|64)-?\d{3,4}-?\d{4}$/", $input)) return true;
	return false;
}

//url 정규식
function isURL($input) {
	if (preg_match("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w_\.-]*)*\/?(\?.*)?$/", $input)) return true;
	return false;
}

//날짜 정규식
function isDate($input) {
	if (preg_match("/^((19|20)?[0-9]{2})[\/-]?(0[1-9]{1}|1[012])[\/-]?(0[1-9]{1}|1[0-9]{1}|2[0-9]{1}|3[01])$/", $input)) return true;
	return false;
}

//실제로 존재하는날짜인지
function isValidDate($date, $format = 'Ymd'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function isEqualLength($str,$int){
	if (mb_strlen($str) === $int)
		return true;
	return false;
}


//계좌번호,전화번호 정규식
function isAccount($input) {
	if (preg_match("/[0-9 -._]+/", $input)) return true;
	return false;
}

function isContain($child, $parent) {
	if (preg_match("/".$child."/", $parent)) return true;
	return false;
}

//★★★★★★★★★★★★★★★
//★★★ 보안성 절대 없음 ★★★★
//★★★★★★★★★★★★★★★
function isValidExt($file, $whitelist='zip,rar,7z,alz,egg,tar,gz') {
	$arrWhitelist = explode(',', $whitelist);
	$temp = explode('.', $file["name"]);
	$ext = $temp[count($temp)-1];
	if (in_array($ext, $arrWhitelist))
		return true; 
	return false;
}

//봇인지
function isBot($USER_AGENT) {
	$interestingCrawlers = array( 'googlebot', 'msnbot', 'yeti', 'naverbot', 'daumoa', 'zumbot', 'bingbot', 'baiduspider', 'ia_archiver', 'Slurp'); // 봇걸러내기
	$pattern = '/(' . implode('|', $interestingCrawlers) .')/i';
	$matches = array();
	$numMatches = preg_match($pattern, strtolower($USER_AGENT), $matches);
	if($numMatches > 0) // Found a match
		return true;
	else
		return false;
}
