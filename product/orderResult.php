<?
    /* ============================================================================== */
    /* =   PAGE : 결과 처리 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   pp_cli_hub.php 파일에서 처리된 결과값을 출력하는 페이지입니다.           = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://kcp.co.kr/technique.requestcode.do                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2016  NHN KCP Inc.   All Rights Reserverd.                = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   지불 결과                                                                = */
    /* = -------------------------------------------------------------------------- = */
    $site_cd          = $_POST[ "site_cd"        ];      // 사이트코드
    $req_tx           = $_POST[ "req_tx"         ];      // 요청 구분(승인/취소)
    $use_pay_method   = $_POST[ "use_pay_method" ];      // 사용 결제 수단
    $bSucc            = $_POST[ "bSucc"          ];      // 업체 DB 정상처리 완료 여부
    /* = -------------------------------------------------------------------------- = */
    $res_cd           = $_POST[ "res_cd"         ];      // 결과코드
    $res_msg          = $_POST[ "res_msg"        ];      // 결과메시지
    $res_msg_bsucc    = "";
    /* = -------------------------------------------------------------------------- = */
    $amount           = $_POST[ "amount"         ];      // 금액
    $ordr_idxx        = $_POST[ "ordr_idxx"      ];      // 주문번호
    $tno              = $_POST[ "tno"            ];      // KCP 거래번호
    $good_mny         = $_POST[ "good_mny"       ];      // 결제금액
    $good_name        = $_POST[ "good_name"      ];      // 상품명
    $good_name        = implode(',', $good_name);
    $buyr_name        = $_POST[ "arName"      ];      // 구매자명
    $buyr_tel1        = $_POST[ "arTel"      ];      // 구매자 전화번호
    $buyr_tel2        = $_POST[ "arPhone"      ];      // 구매자 휴대폰번호
    $buyr_mail        = $_POST[ "buyr_mail"      ];      // 구매자 E-Mail
    /* = -------------------------------------------------------------------------- = */
    // 공통
    $pnt_issue        = $_POST[ "pnt_issue"      ];      // 포인트 서비스사
    $app_time         = $_POST[ "app_time"       ];      // 승인시간 (공통)
    /* = -------------------------------------------------------------------------- = */
    // 신용카드
    $card_cd          = $_POST[ "card_cd"        ];      // 카드코드
    $card_name        = $_POST[ "card_name"      ];      // 카드명
    $noinf            = $_POST[ "noinf"          ];      // 무이자 여부
    $quota            = $_POST[ "quota"          ];      // 할부개월
    $app_no           = $_POST[ "app_no"         ];      // 승인번호
    /* = -------------------------------------------------------------------------- = */
    // 계좌이체
    $bank_name        = $_POST[ "bank_name"      ];      // 은행명
    $bank_code        = $_POST[ "bank_code"      ];      // 은행코드
    /* = -------------------------------------------------------------------------- = */
    // 가상계좌
    $bankname         = $_POST[ "bankname"       ];      // 입금할 은행
    $depositor        = $_POST[ "depositor"      ];      // 입금할 계좌 예금주
    $account          = $_POST[ "account"        ];      // 입금할 계좌 번호
    $va_date          = $_POST[ "va_date"        ];      // 가상계좌 입금마감시간
    /* = -------------------------------------------------------------------------- = */
    // 포인트
    $add_pnt          = $_POST[ "add_pnt"        ];      // 발생 포인트
    $use_pnt          = $_POST[ "use_pnt"        ];      // 사용가능 포인트
    $rsv_pnt          = $_POST[ "rsv_pnt"        ];      // 총 누적 포인트
    $pnt_app_time     = $_POST[ "pnt_app_time"   ];      // 승인시간
    $pnt_app_no       = $_POST[ "pnt_app_no"     ];      // 승인번호
    $pnt_amount       = $_POST[ "pnt_amount"     ];      // 적립금액 or 사용금액
    /* = -------------------------------------------------------------------------- = */
    //상품권
    $tk_van_code      = $_POST[ "tk_van_code"    ];      // 발급사 코드
    $tk_app_no        = $_POST[ "tk_app_no"      ];      // 승인 번호
    /* = -------------------------------------------------------------------------- = */
    //휴대폰
    $commid           = $_POST[ "commid"         ];      // 통신사 코드
    $mobile_no        = $_POST[ "mobile_no"      ];      // 휴대폰 번호
    /* = -------------------------------------------------------------------------- = */
    // 현금영수증
    $cash_yn          = $_POST[ "cash_yn"        ];      //현금영수증 등록 여부
    $cash_authno      = $_POST[ "cash_authno"    ];      //현금영수증 승인 번호
    $cash_tr_code     = $_POST[ "cash_tr_code"   ];      //현금영수증 발행 구분
    $cash_id_info     = $_POST[ "cash_id_info"   ];      //현금영수증 등록 번호
    /* = -------------------------------------------------------------------------- = */

    $req_tx_name = "";

    if( $req_tx == "pay" )
    {
        $req_tx_name = "지불";
    }
    else if( $req_tx == "mod" )
    {
        $req_tx_name = "매입/취소";
    }

    /* ============================================================================== */
    /* =   가맹점 측 DB 처리 실패시 상세 결과 메시지 설정                           = */
    /* = -------------------------------------------------------------------------- = */


    /* = -------------------------------------------------------------------------- = */
    /* =   가맹점 측 DB 처리 실패시 상세 결과 메시지 설정 끝                        = */
    /* ============================================================================== */
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>*** NHN KCP [AX-HUB Version] ***</title>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <link href="/Test_sample/css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>
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
    <form name="cancel" method="post">
    <div id="sample_wrap">
        <h1>[결과출력]<span> 상세 페이지</span></h1>
    <div class="sample">
        <p>
          요청 결과를 출력하는 페이지 입니다.<br />
          요청이 정상적으로 처리된 경우 결과코드(res_cd)값이 0000으로 표시됩니다.
        </p>

<?
    /* ============================================================================== */
    /* =   결제 결과 코드 및 메시지 출력(결과페이지에 반드시 출력해주시기 바랍니다.)= */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제 정상 : res_cd값이 0000으로 설정됩니다.                              = */
    /* =   결제 실패 : res_cd값이 0000이외의 값으로 설정됩니다.                     = */
    /* = -------------------------------------------------------------------------- = */
?>
                    <h2>&sdot; 처리 결과</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                        <!-- 결과 코드 -->
                        <tr>
                          <th>결과 코드</th>
                          <td><?php if ($res_cd === "") {
                              $res_cd = 0000;
                          }?></td>
                        </tr>

                              <!-- 결과 메시지 -->
                        <tr>
                          <th>결과 메세지</th>
                          <td><?=$res_msg?></td>
                        </tr>
<?
    // 처리 페이지(pp_cli_hub.php)에서 가맹점 DB처리 작업이 실패한 경우 상세메시지를 출력합니다.
    if( !$res_msg_bsucc == "")
    {
?>
                         <tr>
                           <th>결과 상세 메세지</th>
                           <td><?=$res_msg_bsucc?></td>
                         </tr>
<?
    }
?>
                    </table>

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
            /* =  01-1-1. 정상 결제시 결제 결과 출력 (res_cd값이 0000인 경우)               = */
            /* = -------------------------------------------------------------------------- = */
            if ( $resultPoint !== 0 )                  // 정상 승인
            {
?>
                    <h2>&sdot; 주문 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                        <!-- 주문번호 -->
                        <tr>
                          <th>주문 번호</th>
                          <td><?=$ordr_idxx ?></td>
                        </tr>
                        <!-- KCP 거래번호 -->
                        <tr>
                          <th>KCP 거래번호</th>
                          <td><?=$tno ?></td>
                        </tr>
                        <!-- 결제금액 -->
                        <tr>
                          <th>결제 금액</th>
                          <td><?=$good_mny ?>원</td>
                          <!-- <td><?=$good_mny ?>원</td> --> 
                        <!-- 결제포인트 -->
                        <tr>
                          <th>결제 포인트</th>
                          <td><?=$resultPoint ?>원</td>
                          <!-- <td><?=$good_mny ?>원</td> --> 
                        </tr>
                        <!-- 상품명(good_name) -->
                        <tr>
                          <th>상 품 명</th>
                           <td><?=$good_name ?></td>
                         </tr>
                        <!-- 주문자명 -->
                        <tr>
                          <th>주문자명</th>
                          <td><?=$buyr_name ?></td>
                        </tr>
                        <!-- 주문자 전화번호 -->
                        <tr>
                          <th>주문자 전화번호</th>
                          <td><?=$buyr_tel1 ?></td>
                        </tr>
                        <!-- 주문자 휴대폰번호 -->
                        <tr>
                          <th>주문자 휴대폰번호</th>
                          <td><?=$buyr_tel2 ?></td>
                        </tr>
                        <!-- 주문자 E-mail -->
                        <tr>
                          <th>주문자 E-mail</th>
                          <td><?=$buyr_mail ?></td>
                        </tr>
                    </table>
<?
                /* ============================================================================== */
                /* =   포인트 결제 결과 출력                                                    = */
                /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "000100000000" )         // 포인트
                {
?>
                    <h2>&sdot; 포인트 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 결제수단 : 포인트 -->
                        <tr>
                          <th>결제수단</th>
                          <td>포 인 트</td>
                        </tr>
                    <!-- 포인트사 -->
                        <tr>
                          <th>포인트사</th>
                          <td><?=$pnt_issue ?></td>
                        </tr>
                    <!-- 포인트 승인시간 -->
                        <tr>
                          <th>포인트 승인시간</th>
                          <td><?=$pnt_app_time ?></td>
                        </tr>
                    <!-- 포인트 승인번호 -->
                        <tr>
                          <th>포인트 승인번호</th>
                          <td><?=$pnt_app_no ?></td>
                        </tr>
                    <!-- 적립금액 or 사용금액 -->
                        <tr>
                          <th>적립금액 or 사용금액</th>
                          <td><?=$pnt_amount ?></td>
                        </tr>
                    <!-- 발생 포인트 -->
                        <tr>
                          <th>발생 포인트</th>
                          <td><?=$add_pnt ?></td>
                        </tr>
                    <!-- 사용가능 포인트 -->
                        <tr>
                          <th>사용가능 포인트</th>
                          <td><?=$use_pnt ?></td>
                        </tr>
                    <!-- 총 누적 포인트 -->
                        <tr>
                          <th>총 누적 포인트</th>
                          <td><?=$rsv_pnt ?></td>
                        </tr>
                </table>
<?

                        }
?>
<?
                    }
                }
            
            /* = -------------------------------------------------------------------------- = */
            /* =   01-1-1. 정상 결제시 결제 결과 출력 END                                   = */
            /* ============================================================================== */
    /* = -------------------------------------------------------------------------- = */
    /* =   01. 결제 결과 출력 END                                                   = */
    /* ============================================================================== */
?>
                    <!-- 매입 요청/처음으로 이미지 버튼 -->
                <tr>

                <div class="btnset">
                <a href="/user/orderList.php" class="home">주문리스트</a>
                </div>
                </tr>
              </tr>
            </div>
        <div class="footer">
                Copyright (c) NHN KCP INC. All Rights reserved.
        </div>
    </div>
  </body>
</html>
