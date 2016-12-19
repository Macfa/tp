<?
require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)


try
{
	//배송지 값 검사
	if (isNullVal($_POST['arKey']) == false) {
		$isExistArKey = true;
		if (isNum($_POST['arKey']) == false) 
			throw new Exception('매개변수가 비정상적입니다.', 3);

		$isValidAddress = DB::queryFirstField('SELECT COUNT(*) FROM tmAddress WHERE arKey = %i and mbEmail = %s', $_POST['arKey'], $mb['mbEmail']);
		$isValidAddress = ($isValidAddress>0)?TRUE:FALSE;
		if ($isValidAddress == false) 
			throw new Exception('존재하지 않는 주소록 입니다.', 3);
	}

	if (isNullVal($_POST['arTit']) === false && is_contain_special($_POST['arTit']))
		throw new Exception('주소지 명은 한글,영어,숫자만 가능합니다.', 3);

	if (isNullVal($_POST['arName']))
		throw new Exception('수취인 명을 입력해주세요.', 3);

	if (isKorEng($_POST['arName']) === false)
		throw new Exception('수취인 명은 한글,영어만 가능합니다.', 3);

	if (isNullVal($_POST['arPhone']))
		throw new Exception('연락처를 입력해주세요.', 3);

	$_POST['arPhone'] = parsingNum($_POST['arPhone']);
	if (isPhoneNum($_POST['arPhone']) == false && isTelNum($_POST['arPhone']) == false)
		throw new Exception('연락처는 번호만 입력이 가능합니다.', 3);

	if (isNullVal($_POST['arTel']) === false) {
		$_POST['arTel'] = parsingNum($_POST['arTel']);
		if (isPhoneNum($_POST['arTel']) == false && isTelNum($_POST['arTel']) == false)
			throw new Exception('추가연락처는 번호만 입력이 가능합니다.', 3);
	}

	if (isNullVal($_POST['arPostcode'])) 
		throw new Exception('우편번호를 입력해주세요', 3);

	if (isEqualLength($_POST['arPostcode'], 5) === false)
		throw new Exception('우편번호는 5글자이어야 가능합니다.', 3);

	if (isNum($_POST['arPostcode']) == false)
		throw new Exception('우편번호는 숫자만 입력이 가능합니다.', 3);
	
	if (isNullVal($_POST['arAddress'])) 
		throw new Exception('주소를 입력해주세요', 3);

	if (isNullVal($_POST['arSubAddress'])) 
		throw new Exception('상세주소를 입력해주세요', 3);

	if (isNullVal($_POST['pay_method'])) 
		throw new Exception('결제방법을 선택해주세요', 3);

	//주문 값 검사
	if (count($_POST['gfKey']) != count($_POST['oiQuantity']))
		throw new Exception('사은품 매개변수가 쌍이 맞지 않습니다.', 3);

	foreach($_POST['oiQuantity'] as $val) {
		if(isNum($val) == false)
			throw new Exception('사은품 갯수가 숫자가 아닙니다.', 3);
	}

	foreach($_POST['gfKey'] as $key => $val) {
		if(isNum($val) == false)
			throw new Exception('사은품 키가 숫자가 아닙니다.', 3);

		list($isValidGift,$arrGfPoint[$key], $gfName[]) = DB::queryFirstList('SELECT COUNT(*), gfPoint, gfTit FROM tmGift WHERE gfKey = %i', $val);
		$isValidGift = ($isValidGift>0)?TRUE:FALSE;
		if($isValidGift == false)
			throw new Exception('사은품이 존재하지 않습니다.', 3);

		$totalPoint += $_POST['oiQuantity'][$key]*$arrGfPoint[$key];
	}
	$gifts .= implode(',', $gfName);
	$cashAmount = $totalPoint - $_POST['resultPoint'];
	$pointAmount = $totalPoint-$cashAmount;

	if ($totalPoint < 0)
		throw new Exception('총 결제 별이 0보다 작을 수 없습니다.', 3);	

	if ($pointAmount > $mb['mbPoint'])
		throw new Exception('사용 할 별이 현재 보유 중인 별보다 많습니다.', 3);

	if ($pointAmount < 0)
		throw new Exception('사용 할 별이 0보다 작을 수 없습니다.', 3);	

	//==============================================================================

	if ((int)$_POST['good_mny'] > 0) {
		require_once("./pp_cli_hub.php");  	// 결재 결과를 처리하는 과정 
		if($res_cd != "0000") 
			throw new Exception('결제가 실패했습니다. 오류코드 : '.$res_cd, 3);	
	}

}
catch(Exception $e)
{
    alert($e->getMessage());
}


$countOrder = DB::queryFirstField("SELECT count(*) FROM tmOrder WHERE mbEmail = %s", $mb['mbEmail']);
$isShippingFree = ($countOrder>0)?FALSE:TRUE;
$shipping = ($isShippingFree===true)?0:2500;

DB::insert('tmOrder', array(
	'mbEmail' => $mb['mbEmail'],
	'orOrderNumber' => $_POST['ordr_idxx'],
	'orName' => $_POST['arName'],
	'orPhone' => $_POST['arPhone'],
	'orTel' => $_POST['arTel'],
	'orPostcode' => $_POST['arPostcode'],
	'orAddress' => $_POST['arAddress'],
	'orSubAddress' => $_POST['arSubAddress'],
	'orPoint' => $totalPoint,
	'orCash' => $_POST['good_mny'],
	'orShipping' => $shipping,
	'orDate' => $cfg['time_ymdhis']
));

$orKey = DB::insertId();

foreach($_POST['gfKey'] as $key => $val) {
	DB::insert('tmOrderItem', array(
		'mbEmail' => $mb['mbEmail'],
		'orKey' => $orKey,
		'orOrderNumber' => $_POST['ordr_idxx'],
		'gfKey' => $val,
		'oiPoint' => $_POST['oiQuantity'][$key]*$arrGfPoint[$key]-$_POST['good_mny'],
		'oiQuantity' => $_POST['oiQuantity'][$key]
	));

	DB::delete('tmCart', 'gfKey = %i and mbEmail = %s', $val, $mb['mbEmail']);
}

$isSetDefAddr = (isExist($_POST['setDefaultAddress']))?TRUE:FALSE;
if($isSetDefAddr) {
	$isAlreadyDef = DB::queryFirstField("SELECT count(*) FROM tmAddress WHERE arKey = %i and arIsDefault = 1", $_POST['arKey']);
	$isAlreadyDef = ($isAlreadyDef>0)?TRUE:FALSE;
}
$sqlSetAddr = array('arTit' => $_POST['arTit'],
		'arName' => $_POST['arName'],
		'arPhone' => $_POST['arPhone'],
		'arTel' => $_POST['arTel'],
		'arPostcode' => $_POST['arPostcode'],
		'arAddress' => $_POST['arAddress'],
		'arSubAddress' => $_POST['arSubAddress']);
if ($isSetDefAddr) {
	$sqlSetAddr['arIsDefault'] = 1;
}

$isEditAddr = (isExist($_POST['arKey']) && isExist($_POST['saveAddress']))?TRUE:FALSE;
$isNewAddr = (isExist($_POST['arKey']) === false && isExist($_POST['saveAddress']))?TRUE:FALSE;

$_POST['arTit'] = (isExist($_POST['arTit']))?$_POST['arTit']:$_POST['arPhone'];

if ($isAlreadyDef === false) {
	DB::update('tmAddress', array(
		'arIsDefault' => 0
	),'mbEmail = %s', $mb['mbEmail']);

	if ($isEditAddr) {
		DB::update('tmAddress', array(
			'arIsDefault' => 1
		),'arKey = %i and mbEmail = %s', $_POST['arKey'], $mb['mbEmail']);
	}
}

if ($isEditAddr) {
	DB::update('tmAddress', $sqlSetAddr, 'arKey = %i and mbEmail = %s', $_POST['arKey'], $mb['mbEmail']);
}

if ($isNewAddr) {
	$sqlSetAddr['mbEmail'] = $mb['mbEmail'];
	DB::insert('tmAddress', $sqlSetAddr);
}

if((int)$_POST['resultPoint'] > 0) {
	DB::insert('tmPointHistory', array(
		'mbEmail' => $mb['mbEmail'],
		'phCont' => $cfg['time_ymdhis'].' 사은품 결제',
		'phAmount' => $totalPoint*-1,
		'phResult' => $mb['mbPoint']-$totalPoint,
		'phDate' => $cfg['time_ymdhis']
	));

	DB::update('tmMember', array(
		'mbPoint' => $mb['mbPoint']-$totalPoint
	),'mbEmail = %s', $mb['mbEmail']);
}

if((int)$_POST['resultPoint'] > 0 && (int)$_POST['resultCash'] === 0){
	$req_tx = 'pay';
	$bSucc = true;
	$res_cd = "0000";
}

?>
    <html>
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>티플 사은품 결제 중입니다.</title>
        <script type="text/javascript">
            function goResult()
            {
                //var openwin = window.open( 'proc_win.html', 'proc_win', '' )
                document.pay_info.submit();
                // openwin.close();
            }

            // °áÁ¦ Áß »õ·Î°íÄ§ ¹æÁö »ùÇÃ ½ºÅ©¸³Æ® (Áßº¹°áÁ¦ ¹æÁö)
            function noRefresh()
            {
                /* CTRL + NÅ° ¸·À½. */
                if ((event.keyCode == 78) && (event.ctrlKey == true))
                {
                    event.keyCode = 0;
                    return false;
                }
                /* F5 ¹øÅ° ¸·À½. */
                if(event.keyCode == 116)
                {
                    event.keyCode = 0;
                    return false;
                }
            }
            document.onkeydown = noRefresh ;
        </script>
    </head>

    <body onload="goResult()">
    <form name="pay_info" method="post" action="./result.php">
        <input type="hidden" name="site_cd"           value="<?=$g_conf_site_cd ?>">    <!-- »çÀÌÆ®ÄÚµå -->
        <input type="hidden" name="req_tx"            value="<?=$req_tx         ?>">    <!-- ¿äÃ» ±¸ºÐ -->
        <input type="hidden" name="use_pay_method"    value="<?=$use_pay_method ?>">    <!-- »ç¿ëÇÑ °áÁ¦ ¼ö´Ü -->
        <input type="hidden" name="bSucc"             value="<?=$bSucc          ?>">    <!-- ¼îÇÎ¸ô DB Ã³¸® ¼º°ø ¿©ºÎ -->

        <input type="hidden" name="amount"            value="<?=$amount         ?>">    <!-- ±Ý¾× -->
        <input type="hidden" name="res_cd"            value="<?=$res_cd         ?>">    <!-- °á°ú ÄÚµå -->
        <input type="hidden" name="res_msg"           value="<?=$res_msg        ?>">    <!-- °á°ú ¸Þ¼¼Áö -->
        <input type="hidden" name="res_en_msg"        value="<?=$res_en_msg     ?>">    <!-- °á°ú ¿µ¹® ¸Þ¼¼Áö -->
        <input type="hidden" name="ordr_idxx"         value="<?=$ordr_idxx      ?>">    <!-- ÁÖ¹®¹øÈ£ -->
        <input type="hidden" name="tno"               value="<?=$tno            ?>">    <!-- KCP °Å·¡¹øÈ£ -->
        <input type="hidden" name="good_mny"          value="<?=$good_mny       ?>">    <!-- °áÁ¦±Ý¾× -->
        <input type="hidden" name="usePoint"		value="<?=$_POST['resultPoint']?>">
        <input type="hidden" name="good_name"         value="<?=$good_name      ?>">    <!-- »óÇ°¸í -->
        <input type="hidden" name="buyr_name"         value="<?=$buyr_name?>">    <!-- ÁÖ¹®ÀÚ¸í -->
        <input type="hidden" name="buyr_tel1"         value="<?=$buyr_tel1?>">    <!-- ÁÖ¹®ÀÚ ÀüÈ­¹øÈ£ -->
        <input type="hidden" name="buyr_tel2"         value="<?=$buyr_tel2 ?>">    <!-- ÁÖ¹®ÀÚ ÈÞ´ëÆù¹øÈ£ -->
        <input type="hidden" name="buyr_mail"         value="<?=$buyr_mail      ?>">    <!-- ÁÖ¹®ÀÚ E-mail -->

        <input type="hidden" name="card_cd"           value="<?=$card_cd        ?>">    <!-- Ä«µåÄÚµå -->
        <input type="hidden" name="card_name"         value="<?=$card_name      ?>">    <!-- Ä«µå¸í -->
        <input type="hidden" name="app_time"          value="<?=$app_time       ?>">    <!-- ½ÂÀÎ½Ã°£ -->
        <input type="hidden" name="app_no"            value="<?=$app_no         ?>">    <!-- ½ÂÀÎ¹øÈ£ -->
        <input type="hidden" name="quota"             value="<?=$quota          ?>">    <!-- ÇÒºÎ°³¿ù -->
        <input type="hidden" name="noinf"             value="<?=$noinf          ?>">    <!-- ¹«ÀÌÀÚ¿©ºÎ -->
        <input type="hidden" name="partcanc_yn"       value="<?=$partcanc_yn    ?>">    <!-- ºÎºÐÃë¼Ò°¡´ÉÀ¯¹« -->
        <input type="hidden" name="card_bin_type_01"  value="<?=$card_bin_type_01 ?>">  <!-- Ä«µå±¸ºÐ1 -->
        <input type="hidden" name="card_bin_type_02"  value="<?=$card_bin_type_02 ?>">  <!-- Ä«µå±¸ºÐ2 -->

        <input type="hidden" name="bank_name"         value="<?=$bank_name      ?>">    <!-- ÀºÇà¸í -->
        <input type="hidden" name="bank_code"         value="<?=$bank_code      ?>">    <!-- ÀºÇàÄÚµå -->

        <input type="hidden" name="bankname"          value="<?=$bankname       ?>">    <!-- ÀÔ±ÝÇÒ ÀºÇà -->
        <input type="hidden" name="depositor"         value="<?=$depositor      ?>">    <!-- ÀÔ±ÝÇÒ °èÁÂ ¿¹±ÝÁÖ -->
        <input type="hidden" name="account"           value="<?=$account        ?>">    <!-- ÀÔ±ÝÇÒ °èÁÂ ¹øÈ£ -->
        <input type="hidden" name="va_date"           value="<?=$va_date        ?>">    <!-- °¡»ó°èÁÂ ÀÔ±Ý¸¶°¨½Ã°£ -->

        <input type="hidden" name="pnt_issue"         value="<?=$pnt_issue      ?>">    <!-- Æ÷ÀÎÆ® ¼­ºñ½º»ç -->
        <input type="hidden" name="pnt_app_time"      value="<?=$pnt_app_time   ?>">    <!-- ½ÂÀÎ½Ã°£ -->
        <input type="hidden" name="pnt_app_no"        value="<?=$pnt_app_no     ?>">    <!-- ½ÂÀÎ¹øÈ£ -->
        <input type="hidden" name="pnt_amount"        value="<?=$pnt_amount     ?>">    <!-- Àû¸³±Ý¾× or »ç¿ë±Ý¾× -->
        <input type="hidden" name="add_pnt"           value="<?=$add_pnt        ?>">    <!-- ¹ß»ý Æ÷ÀÎÆ® -->
        <input type="hidden" name="use_pnt"           value="<?=$use_pnt        ?>">    <!-- »ç¿ë°¡´É Æ÷ÀÎÆ® -->
        <input type="hidden" name="rsv_pnt"           value="<?=$rsv_pnt        ?>">    <!-- Àû¸³ Æ÷ÀÎÆ® -->

        <input type="hidden" name="commid"            value="<?=$commid         ?>">    <!-- Åë½Å»ç ÄÚµå -->
        <input type="hidden" name="mobile_no"         value="<?=$mobile_no      ?>">    <!-- ÈÞ´ëÆù ¹øÈ£ -->

        <input type="hidden" name="tk_van_code"       value="<?=$tk_van_code    ?>">    <!-- ¹ß±Þ»ç ÄÚµå -->
        <input type="hidden" name="tk_app_time"       value="<?=$tk_app_time    ?>">    <!-- ½ÂÀÎ ½Ã°£ -->
        <input type="hidden" name="tk_app_no"         value="<?=$tk_app_no      ?>">    <!-- ½ÂÀÎ ¹øÈ£ -->

        <input type="hidden" name="cash_yn"           value="<?=$cash_yn        ?>">    <!-- Çö±Ý¿µ¼öÁõ µî·Ï ¿©ºÎ -->
        <input type="hidden" name="cash_authno"       value="<?=$cash_authno    ?>">    <!-- Çö±Ý ¿µ¼öÁõ ½ÂÀÎ ¹øÈ£ -->
        <input type="hidden" name="cash_tr_code"      value="<?=$cash_tr_code   ?>">    <!-- Çö±Ý ¿µ¼öÁõ ¹ßÇà ±¸ºÐ -->
        <input type="hidden" name="cash_id_info"      value="<?=$cash_id_info   ?>">    <!-- Çö±Ý ¿µ¼öÁõ µî·Ï ¹øÈ£ -->
    </form>
    </body>
    </html>