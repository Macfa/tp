<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>티플 사은품 결제 완료</title>
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
    <section class="section-no-padding">
    <Br/><Br/>
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
                            <span class="label">결제한 금액</span><span class="cont"><?=$good_mny ?> 원</span>      
                        </li><li><!-- 결제금액 -->
                            <span class="label">사용한 별포인트</span><span class="cont"><?=($_POST['usePoint'])?$_POST['usePoint']:0 ?> 별</span>      
                        </li><li><!-- 상품명(good_name) -->
                            <span class="label">상품명</span><span class="cont"><?=$good_name ?></span>   
                        </li><li> <!-- 주문자명 -->
                            <span class="label">주문자명</span><span class="cont"><?=$buyr_name ?></span>   
                        </li><li><!-- 주문자 전화번호 -->
                            <span class="label">연락처</span><span class="cont"><?=$buyr_tel1 ?></span>   
                        </li><li><!-- 주문자 휴대폰번호 -->
                            <span class="label">추가 연락처</span><span class="cont"><?=$buyr_tel2 ?></span>   
                        </li><li><!-- 주문자 E-mail -->
                            <span class="label">이메일</span><span class="cont"><?=$buyr_mail ?></span>   
                        </li>
                    </ul>   
        </form>                                       
        </section>
<?
            }
            /* = -------------------------------------------------------------------------- = */
            /* =   01-1-1. 정상 결제시 결제 결과 출력 END                                   = */
            /* ============================================================================== */
        }
        /* = -------------------------------------------------------------------------- = */
        /* =   01-1. 업체 DB 처리 정상 END                                              = */
        /* ============================================================================== */
    }
    /* = -------------------------------------------------------------------------- = */
    /* =   01. 결제 결과 출력 END                                                   = */
    /* ============================================================================== */
?>
                    <!-- 매입 요청/처음으로 이미지 버튼 -->
    <div class="center">
        <?if ( $use_pay_method == "100000000000" ):?>
        <a class="btn-filled-sub-dense" href="javascript:receiptView('<?=$tno?>','<?=$ordr_idxx?>','<?=$amount?>')">영수증 확인</a>

        <? elseif  ( $use_pay_method == "001000000000" ) : ?>
        <a class="btn-filled-sub-dense" href="javascript:receiptView3()">모의입금 페이지로 이동</a>

        <? elseif ($cash_authno != ""):?>
        <a class="btn-filled-sub-dense" href="javascript:receiptView2('<?=$site_cd?>','<?=$ordr_idxx?>', '<?=$cash_yn?>', '<?=$cash_authno?>')">현금영수증 확인</a>

        <?endif?>

        <a href="/user/orderList.php" class="btn-filled-primary-dense">구매목록으로</a>
    </div>
</div>

    

</body>
</html>
