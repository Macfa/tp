<?//


// require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)

    /* ============================================================================== */
    /* =   PAGE : 결제 요청 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   이 페이지는 Payplus Plug-in을 통해서 결제자가 결제 요청을 하는 페이지    = */
    /* =   입니다. 아래의 ※ 필수, ※ 옵션 부분과 매뉴얼을 참조하셔서 연동을        = */
    /* =   진행하여 주시기 바랍니다.                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://kcp.co.kr/technique.requestcode.do                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2016  NHN KCP Inc.   All Rights Reserverd.                = */
    /* ============================================================================== */
?>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<?
    /* ============================================================================== */
    /* =   환경 설정 파일 Include                                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수                                                                  = */
    /* =   테스트 및 실결제 연동시 site_conf_inc.php파일을 수정하시기 바랍니다.     = */
    /* = -------------------------------------------------------------------------- = */

    include "/home/www/tplanit/kcp/cfg/site_conf_inc.php";

    /* = -------------------------------------------------------------------------- = */
    /* =   환경 설정 파일 Include END                                               = */
    /* ============================================================================== */
?>


<link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>



<?
    /* ============================================================================== */
    /* =   Javascript source Include                                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수                                                                  = */
    /* =   테스트 및 실결제 연동시 site_conf_inc.php파일을 수정하시기 바랍니다.     = */
    /* = -------------------------------------------------------------------------- = */
?>



<script type="text/javascript">

 /****************************************************************/

 /* EXE 전환 절차                                                */

 /* 1. m_Completepayment 함수 적용                               */

 /* 2. 플러그인 체크 함수 변경  kcpTx_install();                 */

 /* 3. submit 방식 변경                                          */

 /****************************************************************/

 /* 1. m_Completepayment  설명                                      */

 /****************************************************************/

 /* 인증완료시 재귀 함수                                         */

 /* 해당 함수명은 절대 변경하면 안됩니다.                        */

 /* 해당 함수의 위치는 payplus.js 보다먼저 선언되어여 합니다.    */

 /* Web 방식의 경우 리턴 값이 form 으로 넘어옴                   */

 /* EXE 방식의 경우 리턴 값이 json 으로 넘어옴                   */

 /****************************************************************/

 function m_Completepayment( FormOrJson, closeEvent )

 {

     var frm = document.forderform;

   

     /********************************************************************/

     /* FormOrJson은 가맹점 임의 활용 금지                               */

     /* frm 값에 FormOrJson 값이 설정 됨 frm 값으로 활용 하셔야 됩니다.  */

     /* FormOrJson 값을 활용 하시려면 기술지원팀으로 문의바랍니다.       */

     /********************************************************************/

     GetField( frm, FormOrJson ); // 위에서 만든 폼데이터에 결제창의 인증데이터 담기.



     if( frm.res_cd.value == "0000" )

     {


             // 가맹점 리턴값 처리 영역

         // alert(frm.res_cd.value);
         document.getElementById("display_pay_button").style.display = "none" ;

         document.getElementById("display_pay_process").style.display = "" ;

             
         frm.submit();

     }
     else
     {

         alert( "[" + frm.res_cd.value + "] " + frm.res_msg.value );

         closeEvent();

     }
 }


</script>
    <script type="text/javascript" src='<?=$g_conf_js_url?>'></script>
    <!--script type="text/javascript" src='<?=$g_conf_js_url?>'></script-->
<?
    /* = -------------------------------------------------------------------------- = */
    /* =   Javascript source Include END                                            = */
    /* ============================================================================== */
?>
    <script type="text/javascript">
        /* 플러그인 설치(확인) */
        StartSmartUpdate();

        /* Payplus Plug-in 실행 */
        function  jsf__pay( form )
        {
        	if($('.js-goodMny').val() == 0 && $('.js-totalResultPoint').val() == 0) {
        		alert('금액을 다시 설정해주세요 !');
        		return false;
        	}

        	if( $('.js-goodMny').val() == 0 ) {
				form.submit();
				return false;
        	}

            var RetVal = false;
            /* Payplus Plugin 실행 */
            if ( MakePayMessage( form ) == true )
            {
			    alert("결제 승인 요청 전,\n\n반드시 결제창에서 고객님이 결제 인증 완료 후\n\n리턴 받은 ordr_chk 와 업체 측 주문정보를\n\n다시 한번 검증 후 결제 승인 요청하시기 바랍니다."); //업체 연동 시 필수 확인 사항.

                openwin = window.open( "proc_win.html", "proc_win", "width=449, height=209, top=300, left=300" );
                RetVal = true ;
            }
            
            else
            {
                /*  res_cd와 res_msg변수에 해당 오류코드와 오류메시지가 설정됩니다.
                    ex) 고객이 Payplus Plugin에서 취소 버튼 클릭시 res_cd=3001, res_msg=사용자 취소
                    값이 설정됩니다.
                */
                res_cd  = document.order_info.res_cd.value ;
                res_msg = document.order_info.res_msg.value ;

            }

            return RetVal ;
        }

        // Payplus Plug-in 설치 안내 
        function init_pay_button()
        {
            if ((navigator.userAgent.indexOf('MSIE') > 0) || (navigator.userAgent.indexOf('Trident/7.0') > 0))
            {
                try
                {
                    if( document.Payplus.object == null )
                    {
                        document.getElementById("display_setup_message").style.display = "block" ;
                    }
                    else{
                        document.getElementById("display_pay_button").style.display = "block" ;
                    }
                }
                catch (e)
                {
                    document.getElementById("display_setup_message").style.display = "block" ;
                }
            }
            else
            {
                try
                {
                    if( Payplus == null )
                    {
                        document.getElementById("display_setup_message").style.display = "block" ;
                    }
                    else{
                        document.getElementById("display_pay_button").style.display = "block" ;
                    }
                }
                catch (e)
                {
                    document.getElementById("display_setup_message").style.display = "block" ;
                }
            }
        }

        /* 주문번호 생성 예제 */
        function init_orderid()
        {
            var today = new Date();
            var year  = today.getFullYear();
            var month = today.getMonth() + 1;
            var date  = today.getDate();
            var time  = today.getTime();

            if(parseInt(month) < 10) {
                month = "0" + month;
            }

            if(parseInt(date) < 10) {
                date = "0" + date;
            }

            var order_idxx = "TEST" + year + "" + month + "" + date + "" + time;

            document.order_info.ordr_idxx.value = order_idxx;

            /*
             * 인터넷 익스플로러와 파이어폭스(사파리, 크롬.. 등등)는 javascript 파싱법이 틀리기 때문에 object 가 인식 전에 실행 되는 문제
             * 기존에는 onload 부분에 추가를 했지만 setTimeout 부분에 추가
             * setTimeout 300의 의미는 플러그인 인식속도에 따른 여유시간 설정
             * - 20101018 -
             */
            setTimeout("init_pay_button();",300);
        }

        /* onLoad 이벤트 시 Payplus Plug-in이 실행되도록 구성하시려면 다음의 구문을 onLoad 이벤트에 넣어주시기 바랍니다. */
        function onload_pay()
        {
             if( jsf__pay(document.order_info) )
                document.order_info.submit();
        }

         $(document).ready(function(){
            init_orderid();
        });

    </script>



<div class="wrap order-wrap center">
	<form method="post" action="/product/orderAction.php" id="order-form" name="order_info">
			<!-- <form method="post" action="/Test/tt.php" id="order-form" name="order_info"> -->
			<!-- <form method="post" action="/Test/tt.php" id="order-form"> -->
		<h1 class="center tit">주문하기</h1>

		<section class="section-no-padding txt-left js-addressWrap">
			<section class="js-addressDetail address-detail active">
				<h2 class="tit-sub">배송지 주소</h2>
				<input type="hidden" class="js-arKey" name="arKey" value="<?php echo $defAddress['arKey']?>" />
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-tit" name="arTit" value="<?php echo $defAddress['arTit']?>" />
					<div class="inp-label">주소지 명</div>
					<span class="inp-hint">집, 회사, 아들집 등</span>
				</label>
				<br/>
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-name" name="arName" value="<?php echo $defAddress['arName']?>" />
					<div class="inp-label">주문자 명<span class="inp-required">필수</span></div>
				</label>
				<br/>
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-phone" name="arPhone" value="<?php echo $defAddress['arPhone']?>" />
					<div class="inp-label">연락처<span class="inp-required">필수</span></div>
				</label>
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-tel" name="arTel" value="<?php echo $defAddress['arTel']?>" />
					<div class="inp-label">추가 연락처</div>
				</label>
				<br/>
				<label class="inp-wrap">
					<input type="text" class="inp-txt js-postcode" name="arPostcode" value="<?php echo $defAddress['arPostcode']?>" />
					<div class="inp-label">우편번호<span class="inp-required">필수</span></div>
				</label>
				<br/>
				<label class="inp-wrap-full">
					<input type="text" class="inp-txt js-address" name="arAddress" value="<?php echo $defAddress['arAddress']?>" />
					<div class="inp-label">주소<span class="inp-required">필수</span></div>
				</label>
				<label class="inp-wrap-full">
					<input type="text" class="inp-txt js-subAddress" name="arSubAddress" value="<?php echo $defAddress['arSubAddress']?>" />
					<div class="inp-label">상세주소<span class="inp-required">필수</span></div>
				</label>
				<label class="inp-wrap-full">
					<select class="inp-txt js-subAddress" name="pay_method">
	                    <option value="111000000000" selected="selected">신용카드/계좌이체/가상계좌</option>
		                <option value="100000000000">신용카드</option>
		                <option value="010000000000">계좌이체</option>
		                <option value="001000000000">가상계좌</option>
		                <option value="000100000000">포인트</option>
		                <option value="000010000000">휴대폰</option>
		                <option value="000000001000">상품권</option>
		                <option value="000000000010">ARS</option>
	                    </select>
					<div class="inp-label">결제방법<span class="inp-required">필수</span></div>
				</label>

				<div class="js-postcodeSearchWrap" id="postcode-search-wrap"></div>
			</section>
			<section class="js-addresslist address-list">
				<table class="table-clickable no-border">
				<caption>주소선택</caption>
				<thead>
				<tr class="table-item-str">
					<td>주소지 명</td>
					<td>수령자 명</td>
					<td>연락처</td>
					<td>추가 연락처</td>
					<td></td>
				</tr>
				</thead>
				<tbody>
				<?php foreach($arrAddress as $val) :?>
				<tr class="table-item-str address js-addressRow js-addressRow<?php echo $val['arKey']?>" data-key="<?php echo $val['arKey']?>">
					<td>
						<?php echo $val['arTit']?>
						<div class="address-list-addr">[<?php echo $val['arPostcode']?>] <?php echo $val['arAddress'].' '.$val['arSubAddress']?></div>
						<span class="address-default"><?php echo ($val['arIsDefault'])?'기본':'';?></span>
					</td>
					<td><?php echo $val['arName']?></td>
					<td><?php echo $val['arPhone']?></td>
					<td><?php echo $val['arTel']?></td>
					<td class="action-wrap">
						<label class="inp-label">
							<button class="btn-delete js-addressDelete" data-key="<?php echo $val['arKey']?>" formnovalidate><i></i></button>
						</label>
					</td>
					<!--td class="action-wrap">
						<label class="inp-label">
							<button class="btn-edit" data-key="<?php echo $val['caKey']?>" formnovalidate><i></i></button>
						</label>
										<td class="action-wrap">
						<button class="btn-filled-white-dense">¼±ÅÃ</button>
					</td>
					</td-->
				</tr>
				<?php endforeach?>
				</tbody>
				</table>
			</section>
			<div class="address-action">
				<label class="inp-chk-dense js-addressDetailAction active">
					<input type="checkbox" class="js-defaultAddress" value="1" name="setDefaultAddress"/>
					<div class="inp-chk-box"></div>
					<div>기본 주소 설정</div>
				</label>
				<label class="inp-chk-dense js-addressDetailAction active">
					<input type="checkbox" class="js-saveAddress" value="1" name="saveAddress" />
					<div class="inp-chk-box"></div>
					저장
				</label>
				<button class="btn-filled-sub-dense js-addressDetailAction js-otherAddress active">다른 주소</button>
				<button class="btn-filled-sub-dense js-addressListAction js-newAddress">새 주소</button>
			</div>
		</section>

		<section class="section-no-padding">
			<table class="table no-border">
			<caption>주문 할 사은품</caption>
			<thead>
				<tr>
					<td class="table-item-str">사은품 명</td>
					<td>
						수량
						<div class="table-hint">클릭하여 수량 수정 가능</div>
					</td>
					<td></td>
					<td>개당 별</td>
					<td></td>
					<td>구매 별</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
			<?php foreach($arrOrder as $val) :?>
			<tr class="js-orderRow<?php echo $val['caKey']?>">
				<td class="table-item-str gift-tit"><a href="" class="btn-flat-primary-dense js-giftViewToggle" data-key="<?php echo $val['gfKey']?>"><?php echo $val['gfTit']?></a></td>
				<td class="no-padding">
					<input type="hidden" value="<?php echo $val['gfTit']?>" name="good_name[]"/>		<!-- made by hy , use to Arname-->
					<input type="hidden" value="<?php echo $val['gfKey']?>" name="gfKey[]"/>
					<input type="number" class="inp-num-dense js-orderQuantity" value="<?php echo $val['caQuantity']?>" name="oiQuantity[]" data-point="<?php echo $val['gfPoint']?>" data-key="<?php echo $val['caKey']?>"/>
				</td>
				<td class="table-separator">x</td>
				<td><?php echo number_format($val['gfPoint'])?></td>
				<td class="table-separator">=</td>
				<td class="js-orderRowResult js-orderRowResult<?php echo $val['caKey']?> table-value" data-result="<?php echo $val['caQuantity']*$val['gfPoint']?>"><?php echo number_format($val['caQuantity']*$val['gfPoint'])?></td>
				<td class="action-wrap">
					<label class="inp-label">
						<button class="btn-delete js-orderDelete" data-key="<?php echo $val['caKey']?>" formnovalidate><i></i></button>
					</label>
				</td>
			</tr>
			<?php endforeach?>
			</tbody>
			</table>
		</section>

		<table class="table cart-additial-wrap">
		<tbody>
		<tr>
			<td class="table-item-str">착불 배송비</td>
			<td class="no-padding">
			</td>
			<td class="table-separator"></td>
			<td>착불</td>
			<td class="table-separator">=</td>
			<td class="js-cartShipping table-value"><?php echo($isShippingFree)?'1회 무료':'2,500';?></td>
			<td class="action-wrap">
			</td>
		</tbody>
		</table>
		<!-- 					echo number_format($mb['mbPoint']);	// º¸À¯
					echo "<br/>";
					echo number_format($value['gfPoint']);	// °ª
 -->
		<?php foreach($arrOrder as $value) :?>
		
			<section class="section cash">
				<label class="inp-wrap">
					<input type="number" value="<?php echo ($totalPoint<$mb['mbPoint'])?$totalPoint:$mb['mbPoint'] ?>" class="js-totalResultPoint inp-txt" name="resultPoint">
					<input type="number" value="<?php echo ($totalPoint<$mb['mbPoint'])?0:$totalPoint-$mb['mbPoint'] ?>" class="js-totalResultCash inp-txt" name="resultCash">
					<div class="inp-label">Point / Cash<span class="inp-required">필수</span></div>
				</label>
				<br/>
			</section>
	
		<?php endforeach ?>

		<h2 class="cart-total-tit">총 사용 할 별 / 보유 중인 별</h2>
		<div class="cart-total">

			<span class="js-totalResult txt-highlight"><?php echo number_format($totalPoint) ?></span> / <?php echo number_format($mb['mbPoint'])?>
		</div>
		<input type="hidden" class="js-totalResultInp" value="<?php echo $totalPoint ?>" />
		<input type="hidden" class="js-mbPoint" value="<?php echo $mb['mbPoint'] ?>">
		<input type="submit" class="btn-filled" value="결제하기" onclick="return jsf__pay(this.form);"/>

	    <!-- Payplus Plug-in 설치 안내 -->
	    <section>
		    <div id="display_setup_message" style="display:none "> 
		       <p class="txt">
		       결제를 계속 하시려면 상단의 노란색 표시줄을 클릭 하시거나 <a href="https://pay.kcp.co.kr/plugin_new/file/KCPPayUXSetup.exe"><span>[수동설치]</span></a>를 눌러
		       Payplus Plug-in을 설치하시기 바랍니다.
		       [수동설치]를 눌러 설치하신 경우 새로고침(F5)키를 눌러 진행하시기 바랍니다.
		       </p>
		       Copyright (c) NHN KCP INC. All Rights reserved.
		     </div>
	     </section>
	   </div>

	  




	<?
	    /* = -------------------------------------------------------------------------- = */
	    /* =   1. 주문 정보 입력 END                                                    = */
	    /* ============================================================================== */
	?>

	<?
	    /* ============================================================================== */
	    /* =   2. 가맹점 필수 정보 설정                                                 = */
	    /* = -------------------------------------------------------------------------- = */
	    /* =   ※ 필수 - 결제에 반드시 필요한 정보입니다.                               = */
	    /* =   site_conf_inc.php 파일을 참고하셔서 수정하시기 바랍니다.                 = */
	    /* = -------------------------------------------------------------------------- = */
	    // 요청종류 : 승인(pay)/취소,매입(mod) 요청시 사용
	?>
	    <input type="hidden" name="req_tx"          value="pay" />
	    <input type="hidden" name="site_cd"         value="<?=$g_conf_site_cd	?>" />
	    <input type="hidden" name="site_name"       value="<?=$g_conf_site_name ?>" />

	<?
	    /*
	    할부옵션 : Payplus Plug-in에서 카드결제시 최대로 표시할 할부개월 수를 설정합니다.(0 ~ 18 까지 설정 가능)
	    ※ 주의  - 할부 선택은 결제금액이 50,000원 이상일 경우에만 가능, 50000원 미만의 금액은 일시불로만 표기됩니다
	               예) value 값을 "5" 로 설정했을 경우 => 카드결제시 결제창에 일시불부터 5개월까지 선택가능
	    */
	?>
	    <input type="hidden" name="quotaopt"        value="12"/>
	    
		<!-- 필수 항목 : 결제 금액/화폐단위 -->
	    <input type="hidden" name="currency"        value="WON"/>
	<?
	    /* = -------------------------------------------------------------------------- = */
	    /* =   2. 가맹점 필수 정보 설정 END                                             = */
	    /* ============================================================================== */
	?>

	<?
	    /* ============================================================================== */
	    /* =   3. Payplus Plugin 필수 정보(변경 불가)                                   = */
	    /* = -------------------------------------------------------------------------- = */
	    /* =   결제에 필요한 주문 정보를 입력 및 설정합니다.                            = */
	    /* = -------------------------------------------------------------------------- = */
	?>
	    <!-- PLUGIN 설정 정보입니다(변경 불가) -->
	    <input type="hidden" name="module_type"     value="<?=$module_type ?>"/>
	    <input type="hidden" name="ordr_idxx" class="w200" value="" maxlength="40"/>

		<input type="hidden" name="good_mny" class="w100 js-goodMny" value="0" maxlength="9"/>


	<!--
	      ※ 필 수
	          필수 항목 : Payplus Plugin에서 값을 설정하는 부분으로 반드시 포함되어야 합니다
	          값을 설정하지 마십시오
	-->
	    <input type="hidden" name="res_cd"          value=""/>
	    <input type="hidden" name="res_msg"         value=""/>
	    <input type="hidden" name="enc_info"        value=""/>
	    <input type="hidden" name="enc_data"        value=""/>
	    <input type="hidden" name="ret_pay_method"  value=""/>
	    <input type="hidden" name="tran_cd"         value=""/>
	    <input type="hidden" name="use_pay_method"  value=""/>
		
		<!-- 주문정보 검증 관련 정보 : Payplus Plugin 에서 설정하는 정보입니다 -->
		<input type="hidden" name="ordr_chk"        value=""/>

	    <!--  현금영수증 관련 정보 : Payplus Plugin 에서 설정하는 정보입니다 -->
	    <input type="hidden" name="cash_yn"         value=""/>
	    <input type="hidden" name="cash_tr_code"    value=""/>
	    <input type="hidden" name="cash_id_info"    value=""/>

		<!-- 2012년 8월 18일 전자상거래법 개정 관련 설정 부분 -->
		<!-- 제공 기간 설정 0:일회성 1:기간설정(ex 1:2012010120120131)  -->
		<input type="hidden" name="good_expr" value="0">


	</form>
</div>