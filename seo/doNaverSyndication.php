<?php
$ping_auth_header = "Authorization: Bearer AAAAO7bOtsjXB1dVIcEstcE8fsvH4Hj4mitTQdFxxXdvpot2ofLsLe6AwBQ2crGfBG4Dm/xm9D+vR5vwF4Eu9zoBBXA="; /* Bearer 타입의 인증키 정보 */
$ping_url = urlencode('http://tplanit.co.kr/seo/naver-syndication.xml'); /* 신디케이션 문서를 담고 있는 핑 URL */
$ping_client_opt = array(
CURLOPT_URL => "https://apis.naver.com/crawl/nsyndi/v2", /* 네이버 신디케이션 서버 호출주소 */
CURLOPT_POST => true, /* POST 방식 */
CURLOPT_POSTFIELDS => "ping_url=" . $ping_url, /* 파라미터로 핑 URL 전달 */
CURLOPT_RETURNTRANSFER => true,
CURLOPT_CONNECTTIMEOUT => 10,
CURLOPT_TIMEOUT => 10,
CURLOPT_HTTPHEADER =>
     array("Host: apis.naver.com", "Pragma: no-cache", "Accept: */*", $ping_auth_header) /* 헤더에 인증키 정보 추가 */
);
$ping = curl_init();
curl_setopt_array($ping, $ping_client_opt);
curl_exec($ping);
curl_close($ping);
?>