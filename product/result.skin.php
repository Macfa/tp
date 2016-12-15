<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>*** NHN KCP [AX-HUB Version] ***</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>
    <script type="text/javascript">
        /* 신용카드 영수증 */ 
        /* 실결제시 : "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" */
        /* 테스트시 : "https://testadmin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" */
         function receiptView( tno, ordr_idxx, amount )
        {
            receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=";
            receiptWin += tno + "&";
            receiptWin += "order_no=" + ordr_idxx + "&"; 
            receiptWin += "trade_mony=" + amount ;

            window.open(receiptWin, "", "width=455, height=815"); 
        }
         
        /* 현금 영수증 */ 
        /* 실결제시 : "https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp" */ 
        /* 테스트시 : "https://testadmin8.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp" */
        function receiptView2( site_cd, order_id, bill_yn, auth_no )
        {
            receiptWin2 = "https://testadmin8.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp";
            receiptWin2 += "?"; 
            receiptWin2 += "term_id=PGNW" + site_cd + "&";
            receiptWin2 += "orderid=" + order_id + "&";
            receiptWin2 += "bill_yn=" + bill_yn + "&";
            receiptWin2 += "authno=" + auth_no ;

            window.open(receiptWin2, "", "width=370, height=625");
        }
        /* 가상 계좌 모의입금 페이지 호출 */
        /* 테스트시에만 사용가능 */
        /* 실결제시 해당 스크립트 주석처리 */
        function receiptView3()
        {
            receiptWin3 = "http://devadmin.kcp.co.kr/Modules/Noti/TEST_Vcnt_Noti.jsp";
            window.open(receiptWin3, "", "width=520, height=300");
        }
    </script>
</head>

<body>    
<div class="wrap-dense">
    <section class="section">
    <form name="cancel" method="post">        
           
              <?if( !$res_msg_bsucc == "") :?>
                <h3>결과 상세 메세지 : <?=$res_msg_bsucc?></h3>
              <?endif?>
            
            <!--
            <h1>[결과출력]<span> 결제 정보 출력페이지입니다.</span></h1>
            <div class="sample">
            <p>요청 결과를 출력하는 페이지 입니다.<br />
            요청이 정상적으로 처리된 경우 결과코드(res_cd)값이 0000으로 표시됩니다.</p>
            -->

<?
    /* ============================================================================== */
    /* =   결제 결과 코드 및 메시지 출력(결과페이지에 반드시 출력해주시기 바랍니다.)= */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제 정상 : res_cd값이 0000으로 설정됩니다.                              = */
    /* =   결제 실패 : res_cd값이 0000이외의 값으로 설정됩니다.                     = */
    /* = -------------------------------------------------------------------------- = */
?><!--
            <h2 class="tit-sub  center">처리 결과</h2>
                <ul class="inlinelist">                                        
                    <li>
                        <span class="label">결과 코드</span><span class="cont"><?=$res_cd?></span> 
                    </li><li>
                        <span class="label">결과 메세지</span><span class="cont"><?=$res_msg?></span>              
                    </li>              
<?
    // 처리 페이지(pp_cli_hub.php)에서 가맹점 DB처리 작업이 실패한 경우 상세메시지를 출력합니다.
            if( !$res_msg_bsucc == "")
            {
?>
                    <li> 
                        <span class="label">결과 상세 메세지</span><span class="cont"><?=$res_msg_bsucc?></span>              
                    </li>
<?
            }
?>
            </ul>
            -->

<?
    /* = -------------------------------------------------------------------------- = */
    /* =   결제 결과 코드 및 메시지 출력 끝                                         = */
    /* ============================================================================== */

    /* ============================================================================== */
    /* =  01. 결제 결과 출력                                                        = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )                           // 거래 구분 : 승인
    {
        /* ============================================================================== */
        /* =  01-1. 업체 DB 처리 정상 (bSucc값이 false가 아닌 경우)                     = */
        /* = -------------------------------------------------------------------------- = */
        if ( $bSucc != "false" )                      // 업체 DB 처리 정상
        {
            /* ============================================================================== */
            /* =  01-1-1. 정상 결제시 결제 결과 출력 (res_cd값이 0000인 경우)               = */
            /* = -------------------------------------------------------------------------- = */
            if ( $res_cd == "0000" )                  // 정상 승인
            {
?>
                <h2 class="tit-sub center">주문 정보</h2>
                    <ul class="inlinelist">                                        
                        <li> <!-- 주문번호 -->
                            <span class="label">주문 번호</span><span class="cont"><?=$ordr_idxx ?></span> 
                        </li><li> <!-- KCP 거래번호 -->
                            <span class="label">KCP 거래번호</span><span class="cont"><?=$tno ?></span>              
                        </li><li><!-- 결제금액 -->
                            <span class="label">결제 금액</span><span class="cont"><?=$good_mny ?>원</span>      
                        </li><li><!-- 상품명(good_name) -->
                            <span class="label">상 품 명</span><span class="cont"><?=$good_name ?></span>   
                        </li><li> <!-- 주문자명 -->
                            <span class="label">주문자명</span><span class="cont"><?=$buyr_name ?></span>   
                        </li><li><!-- 주문자 전화번호 -->
                            <span class="label">주문자 전화번호</span><span class="cont"><?=$buyr_tel1 ?></span>   
                        </li><li><!-- 주문자 휴대폰번호 -->
                            <span class="label">주문자 휴대폰번호</span><span class="cont"><?=$buyr_tel2 ?></span>   
                        </li><li><!-- 주문자 E-mail -->
                            <span class="label">주문자 E-mail</span><span class="cont"><?=$buyr_mail ?></span>   
                        </li>
                    </ul>   
        </form>                                       
        </section>
        <section class="section">
<?
                /* ============================================================================== */
                /* =  신용카드 결제결과 출력                                                    = */
                /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "100000000000" )       // 신용카드
                {
?>
                    <h2 class="tit-sub center">신용카드 정보</h2>
                    <ul class="inlinelist">    
                        <!-- 결제수단 : 신용카드 -->
                        <li><span class="label">결제 수단</span><span class="cont">신용 카드</span></li>
                        <!-- 결제 카드 -->
                        <li><span class="label">결제 카드</span><span class="cont"><?=$card_cd ?> / <?=$card_name ?></span></li>
                        <!-- 승인시간 -->
                        <li><span class="label">승인 시간</span><span class="cont"><?=$app_time ?></span></li>
                        <!-- 승인번호 -->
                        <li><span class="label">승인 번호</span><span class="cont"><?=$app_no ?></span></li>
                        <!-- 할부개월 -->
                        <li><span class="label">할부 개월</span><span class="cont"><?=$quota ?></span></li>
                        <!-- 무이자 여부 -->
                        <li><span class="label">무이자 여부</span><span class="cont"><?=$noinf ?></span></li>
<?
                    /* ============================================================================== */
                    /* =  복합결제 (포인트 + 신용카드) 승인 결과 처리                                 = */
                    /* = -------------------------------------------------------------------------- = */
                     if ( $pnt_issue == "SCSK" || $pnt_issue == "SCWB" )
                    {
?>
                   
                    <h2 class="tit-sub center"> 포인트 정보</h2>  
                    <!-- 포인트사 -->
                        <li><span class="label">포인트사</span><span class="cont"><?=$pnt_issue ?></span></li>
                    <!-- 포인트 승인 시간 -->
                        <li><span class="label">포인트 승인시간</span><span class="cont"><?=$pnt_app_time ?></span></li>
                    <!-- 포인트 승인번호 -->
                        <li><span class="label">포인트 승인번호</span><span class="cont"><?=$pnt_app_no ?></span></li>
                    <!-- 적립금액 or 사용금액 -->
                        <li><span class="label">적립금액 or 사용금액</span><span class="cont"><?=$pnt_amount ?></span></li>
                    <!-- 발생 포인트 -->
                        <li><span class="label">발생 포인트</span><span class="cont"><?=$add_pnt ?></span></li>
                    <!-- 사용가능 포인트 -->
                        <li><span class="label">사용가능 포인트</span><span class="cont"><?=$use_pnt ?></span></li>
                    <!-- 총 누적 포인트 -->
                        <li><span class="label">총 누적 포인트</span><span class="cont"><?=$rsv_pnt ?></span></li>

<?
                    }
                    /* ============================================================================== */
                    /* =  신용카드 영수증 출력                                                      = */
                    /* = -------------------------------------------------------------------------- = */
                    /*    실제 거래건에 대해서 영수증을 출력 할 수 있습니다.                        = */
                    /* = -------------------------------------------------------------------------- = */?>
                                   
                </ul>
<?
                }
                /* ============================================================================== */
                /* =   계좌이체 결제 결과 출력                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "010000000000" )       // 계좌이체
                {
?>
                    <h2 class="tit-sub center"> 계좌이체 정보</h2>
                    <ul class="inlinelist"> 
                    <!-- 결제수단 : 계좌이체 -->
                        <li><span class="label">결제 수단</span><span class="cont">계좌이체</span></li>
                    <!-- 이체 은행 -->
                        <li><span class="label">이체 은행</span><span class="cont"><?=$bank_name ?></span></li>
                    <!-- 이체 은행 코드 -->
                        <li><span class="label">이체 은행코드</span><span class="cont"><?=$bank_code ?></span></li>                        
                    <!-- 승인시간 -->
                        <li><span class="label">승인 시간</span><span class="cont"><?=$app_time ?></span></li>
                   </ul>
<?
                }
                /* ============================================================================== */
                /* =   가상계좌 결제 결과 출력                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "001000000000" )       // 가상계좌
                {
?>
                    <h2 class="tit-sub center"> 가상계좌 정보</h2>
                    <ul class="inlinelist"> 
                    <!-- 결제수단 : 가상계좌 -->
                        <li><span class="label">결제 수단</span><span class="cont">가상계좌</span></li>
                    <!-- 입금은행 -->
                        <li><span class="label">입금 은행</span><span class="cont"><?=$bankname ?></span></li>
                    <!-- 입금계좌 예금주 -->
                        <li><span class="label">입금할 계좌 예금주</span><span class="cont"><?=$depositor ?></span></li>
                    <!-- 입금계좌 번호 -->
                        <li><span class="label">입금할 계좌 번호</span><span class="cont"><?=$account ?></span></li>
                    <!-- 가상계좌 입금마감시간 -->
                        <li><span class="label">가상계좌 입금마감시간</span><span class="cont"><?=$va_date ?></span></li>
                    <!-- 가상계좌 모의입금(테스트시) -->
                                              
                    </ul>
<?
                }
                /* ============================================================================== */
                /* =   포인트 결제 결과 출력                                                    = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "000100000000" )         // 포인트
                {
?>
                    <h2 class="tit-sub center"> 포인트 정보</h2>
                    <ul class="inlinelist"> 
                    <!-- 결제수단 : 포인트 -->
                        <li><span class="label">결제수단</span><span class="cont">포 인 트</span></li>                         
                    <!-- 포인트사 -->
                        <li><span class="label">포인트사</span><span class="cont"><?=$pnt_issue ?></span></li>
                    <!-- 포인트 승인시간 -->
                        <li><span class="label">포인트 승인시간</span><span class="cont"><?=$pnt_app_time ?></span></li>
                    <!-- 포인트 승인번호 -->
                        <li><span class="label">포인트 승인번호</span><span class="cont"><?=$pnt_app_no ?></span></li>
                    <!-- 적립금액 or 사용금액 -->
                        <li><span class="label">적립금액 or 사용금액</span><span class="cont"><?=$pnt_amount ?></span></li>
                    <!-- 발생 포인트 -->
                        <li><span class="label">발생 포인트</span><span class="cont"><?=$add_pnt ?></span></li>
                    <!-- 사용가능 포인트 -->
                        <li><span class="label">사용가능 포인트</span><span class="cont"><?=$use_pnt ?></span></li>
                    <!-- 총 누적 포인트 -->
                        <li><span class="label">총 누적 포인트</span><span class="cont"><?=$rsv_pnt ?></span></li>
                    </ul>
<?
                }
                /* ============================================================================== */
                /* =   휴대폰 결제 결과 출력                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "000010000000" )       // 휴대폰
                {
?>
                    <h2 class="tit-sub center"> 휴대폰 정보</h2>
                    <ul class="inlinelist">
                    <!-- 결제수단 : 휴대폰 -->
                        <li><span class="label">결제 수단</span><span class="cont">휴 대 폰</span></li>
                    <!-- 승인시간 -->
                        <li><span class="label">승인 시간</span><span class="cont"><?=$app_time ?></span></li>
                    <!-- 통신사코드 -->
                        <li><span class="label">통신사 코드</span><span class="cont"><?=$commid ?></span></li>
                    <!-- 승인시간 -->
                        <li><span class="label">휴대폰 번호</span><span class="cont"><?=$mobile_no ?></span></li>
                    </ul>
<?
                }
                /* ============================================================================== */
                /* =   상품권 결제 결과 출력                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "000000001000" )       // 상품권
                {
?>
                    <h2 class="tit-sub center"> 상품권 정보</h2>
                    <ul class="inlinelist"> 
                    <!-- 결제수단 : 상품권 -->
                        <li><span class="label">결제 수단</span><span class="cont">상 품 권</span></li>
                    <!-- 발급사 코드 -->
                        <li><span class="label">발급사 코드</span><span class="cont"><?=$tk_van_code ?></span></li>
                    <!-- 승인시간 -->
                        <li><span class="label">승인 시간</span><span class="cont"><?=$app_time ?></span></li>
                    <!-- 승인번호 -->
                        <li><span class="label">승인 번호</span><span class="cont"><?=$tk_app_no ?></span></li>
                    </ul>
<?
                }
                /* ============================================================================== */
                /* =  현금영수증 정보 출력                                                      = */
                /* = -------------------------------------------------------------------------- = */
                if ( $cash_yn != "" )
                {

?>
                <!-- 현금영수증 정보 출력-->
                    <h2 class="tit-sub center"> 현금영수증 정보</h2>
                    <ul class="inlinelist"> 
                        <li><span class="label">현금영수증 등록여부</span><span class="cont"><?=$cash_yn ?></span></li>
<?
                    // 현금영수증이 등록된 경우 승인번호 값이 존재
                        if ($cash_authno != "")
                        {
?>
                        <li><span class="label">현금영수증 승인번호</span><span class="cont"><?=$cash_authno ?></span></li>
                        
                  <?

                        }
?>
                    </ul>
<?
                    }
                }
            }
            /* = -------------------------------------------------------------------------- = */
            /* =   01-1-1. 정상 결제시 결제 결과 출력 END                                   = */
            /* ============================================================================== */
        }
        /* = -------------------------------------------------------------------------- = */
        /* =   01-1. 업체 DB 처리 정상 END                                              = */
        /* ============================================================================== */
    /* = -------------------------------------------------------------------------- = */
    /* =   01. 결제 결과 출력 END                                                   = */
    /* ============================================================================== */
?>
                    <!-- 매입 요청/처음으로 이미지 버튼 -->
               

            
     
    </section>
    <div class="center">
        <?if ( $use_pay_method == "100000000000" ):?>
        <a class="btn-filled-sub-dense" href="javascript:receiptView('<?=$tno?>','<?=$ordr_idxx?>','<?=$amount?>')">영수증 확인</a>

        <? elseif  ( $use_pay_method == "001000000000" ) : ?>
        <a class="btn-filled-sub-dense" href="javascript:receiptView3()">모의입금 페이지로 이동</a>

        <?elseif ($cash_authno != ""):?>
        <a class="btn-filled-sub-dense" href="javascript:receiptView2('<?=$site_cd?>','<?=$ordr_idxx?>', '<?=$cash_yn?>', '<?=$cash_authno?>')">현금영수증 확인</a>

        <?endif?>

        <a href="/user/orderList.php" class="btn-filled-primary-dense">구매목록으로</a>
    </div>
</div>

    

</body>
</html>
