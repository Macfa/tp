<?

/////////////////////////////////////////////////////////////////////
//																					//
//			모든사이트에 기본적으로 들어가는 php 함수			//
//																					//
/////////////////////////////////////////////////////////////////////




////////////////////////////////////////////sql 함수

// DB 연결
function sql_connect($host, $user, $pass)
{
    global $tg;

    return @mysql_connect($host, $user, $pass);
}


// DB 선택
function sql_select_db($db, $connect)
{
    global $tg;

    if (strtolower($tg['charset']) == 'utf-8') @mysql_query(" set names utf8 ");
    else if (strtolower($tg['charset']) == 'euc-kr') @mysql_query(" set names euckr ");
    return @mysql_select_db($db, $connect);
}


// mysql_query 와 mysql_error 를 한꺼번에 처리
function sql_query($sql, $error=TRUE){
	global $_DEV;
    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    // union의 사용을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*[^\'\"]union[^\'\"].*#i", "select 1", $sql);
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*[^\'\"]`?information_schema`?[^\'\"].*#i", "select 1", $sql);

    if ($error) {
		//if ($_DEV)
			$result = @mysql_query($sql) or die("<p>$sql" . mysql_errno() . " : " .  mysql_error() . "error file : $_SERVER[PHP_SELF]</p>");
		//else{
			//$error_no = getRandomString(5).$tg['time_ymd'];
			//error_log( "<p>".$error_no."</p>".$result."<br/><p>$sql<p>" .mysql_errno(). " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]", 1, //"noreply@hiveband.com");
			//$result = @mysql_query($sql) or die("오류번호:" .$error_no. "<br/>이 문구를 보시면 관리자에게 오류번호를 말씀해주세요");
		//}
	} else
        $result = @mysql_query($sql);
    return $result;
}

// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result) {
    $row = @mysql_fetch_assoc($result);
    return $row;
}

// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error=TRUE) {
    $result = sql_query($sql, $error);
    //$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
    $row = sql_fetch_array($result);
    return $row;
}

// php 오류추적
function sql_backtrace() { 
    $stack_ = array( ); 
    $stack_ = debug_backtrace( ); 

    if( !isset($stack_[0])) return null; 

    $stack = array( ); 
    $trace = $stack_; 

    while (strstr($trace[0]['function'], 'sql')){ 
        array_shift($trace); 
    } 
    foreach($trace as $t){ 
        $str_    = ''; 
        if(isset($t['args'][0])) { 
            if(is_array($t['args'][0])) 
                $str_    = 'array=' . implode("','", $t['args'][0]); 
            else 
                $str_    = implode("','", $t['args']); 
        } 
        $path_parts    = ''; 
        $path_parts    = pathinfo($t['file']); 
        $stack[] = $path_parts['basename'] . ':' . $t['line'] . ':' . $t['function'] . '(\'' . $str_ . '\')'; 
    } 

    $stack[] = $_SERVER['PHP_SELF']; 
    $stack = array_reverse($stack); 

    return implode(' > ', $stack); 
} 


// sql select 함수
function sql_select($field, $table, $where='', $order='', $limit='', $debug='') {
	global $is_admin;

	$sql = "select ".$field.
				" from ".$table;
	if ($where) $sql .= " where ".set_where($where);
	if ($order) $sql .= " order by ".$order;
	if ($limit) $sql .= " limit ".$limit;

	if ($debug) echo $sql."<br/>";
	
	return sql_fetch($sql);
}

// sql select 함수
function sql_list($field, $table, $where='', $order='', $limit='', $debug='') {
	global $is_admin,$n_member,$member;

	$sql = "select ".$field.
				" from ".$table;
	if ($where) $sql .= " where ".set_where($where);
	if ($order) $sql .= " order by ".$order;
	if ($limit) $sql .= " limit ".$limit;

	if ($debug) echo $sql."<br/>";
	
	return sql_query($sql);
}

// sql update 함수
function sql_update($table, $set, $where='') {
	
	$sql = "update ".$table.
				" set ".set_set($set);
	if ($where) $sql .= " where ".set_where($where);

	return sql_query($sql);
}

// 값이 있을때 sql문에 추가
function addSetVal($target, $field, $val='') {
	if (!$val)
		$val = $_POST[$field];
	if ($val) 
		return $target .= ", {$field} = '{$val}'";
	else 
		return $target;
}



// sql insert함수
function sql_insert($table, $set, $additial='') {
	$sql = "insert into ".$table.
				" set ".set_set($set);
	if ($additial) $sql .= ' '.$additial;

	return sql_query($sql);
}

// sql delete함수
function sql_delete($table, $where) {
	$sql = "delete from ".$table;
	if ($where) $sql .= " where ".set_where($where);

	return sql_query($sql);
}

//sql 비밀번호
function sql_pw($input)
{
	global $tg;
    // mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
    // mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
    $row = sql_select("password('{$input}') as pass", $tg['member_table']);
    return $row[pass];
}

function update_point_table($point, $comment, $id, $name, $vi_no="") {
	global $tg;

	$set = "me_id = '{$id}', 
				me_name = '{$name}', 
				po_point = '{$point}', 
				po_comment = '{$comment}', 
				po_datetime = '{$tg['time_ymdhis']}'";

	if ($vi_no) $set .= ", vi_no = '{$vi_no}'";

	sql_insert($tg['point_table'], $set);
}

function give_point($point, $comment, $id, $name, $vi_no="") {
	global $tg;

	$set = "me_point = me_point + {$point}";
	$where = "me_id = '{$id}'";

	update_point_table($point, $comment, $id, $name, $vi_no);
	sql_update($tg['member_table'], $set, $where);
}

// 배열로 된 where을 and로 묶어줌
function set_where($input) {
	if (!is_array($input)) return $input;
	foreach ($input as $key => $val) {
		$sql_where .= $and.$val;
		$and = " and ";
	}
	return $sql_where;
}

// 배열로 된 set을 , 로 묶어줌
function set_set($input) {
	if (!is_array($input)) return $input;
	foreach ($input as $key => $val) {
		$sql_set .= $comma.$val;
		$comma = ", ";
	}
	return $sql_set;
}

	