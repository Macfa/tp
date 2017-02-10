<?
define( KAKAO_OAUTH_URL, "https://kauth.kakao.com/oauth/authorize");
define( KAKAO_TOKEN_URL, "https://kauth.kakao.com/oauth/token");
define( KAKAO_SESSION_NAME, "KAKAO_SESSION" );
define( KAKAO_PROFILE_URL, "https://kapi.kakao.com/v1/user/me");
define( KAKAO_LOGOUT_URL, "https://kapi.kakao.com/v1/user/logout");
@session_start();


class Kakao{

	private $tokenDatas	=	array();

	private $access_token			= '';			// oauth 엑세스 토큰
	private $refresh_token			= '';			// oauth 갱신 토큰
	private $access_token_type		= '';			// oauth 토큰 타입
	private $access_token_expire	= '';			// oauth 토큰 만료


	private $client_id		= 'df2c4884d412d325a741558d23ec1ce6';			// 네이버에서 발급받은 클라이언트 아이디
	private $client_secret	= 'c032737f8753f55348c39bcfd28b2a93';			// 네이버에서 발급받은 클라이언트 시크릿키

	private $returnURL		= 'http://mo.startgd.com/user/login.php';			// 콜백 받을 URL ( 네이버에 등록된 콜백 URI가 우선됨)
	private $state			= '';			// 네이버 명세에 필요한 검증 키 (현재 버전 라이브러리에서 미검증)


	private $loginMode		= 'request';	// 라이브러리 작동 상태

	private $returnCode		= '';			// 네이버에서 리턴 받은 승인 코드
	private $returnState	 = '';			// 네이버에서 리턴 받은 검증 코드

	private $KakaoConnectState	= false;


	// action options
	private $autoClose		= true;
	private $showLogout		= true;

	private $curl = NULL;
	private $refreshCount = 1;  // 토큰 만료시 갱신시도 횟수

	private $drawOptions = array( "type" => "normal", "width" => "200" );

	function __construct($argv = array()) {

		if  ( ! in_array  ('curl', get_loaded_extensions())) {
			echo 'curl required';
			return false;
		}


		if($argv['CLIENT_ID']){
			$this->client_id = trim($argv['CLIENT_ID']);
		}

		if($argv['CLIENT_SECRET']){
			$this->client_secret = trim($argv['CLIENT_SECRET']);
		}

		if($argv['RETURN_URL']){
			$this->returnURL = trim(urlencode($argv['RETURN_URL']));
		}

		if($argv['AUTO_CLOSE'] == false){
			$this->autoClose = false;
		}

		if($argv['SHOW_LOGOUT'] == false){
			$this->showLogout = false;
		}

		$this->loadSession();
		if(isset($_GET['KakaoMode']) && $_GET['KakaoMode'] != ''){
			$this->loginMode = 'logout';
			$this->logout();
		}

		if($this->getConnectState() == false){
			$this->generate_state();

			if($_GET['state'] && $_GET['code']){
				$this->loginMode = 'request_token';
				$this->returnCode = $_GET['code'];
				$this->returnState = $_GET['state'];

				$this->_getAccessToken();

			}
		}
	}



	function login($options = array()){


		if(isset($options['type'])){
			$this->drawOptions['type'] = $options['type'];
		}

		if(isset($options['width'])){
			$this->drawOptions['width'] = $options['width'];
		}



		if($this->loginMode == 'request' && (!$this->getConnectState()) || !$this->showLogout){

		}else if($this->getConnectState()){
			if($this->showLogout){
				echo '<a href="http://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'?KakaoMode=logout"><img src="https://www.eventmaker.kr/open/idn/kakao_logout.png" width="'.$this->drawOptions['width'].'" alt="네이버 아이디 로그아웃"/></a>';
			}
		}


		if($this->loginMode == 'request_token'){
			$this->_getAccessToken();
		}
	}

	function logout(){
		$this->refreshCount = 1;
		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_URL, KAKAO_LOGOUT_URL);
		curl_setopt($this->curl, CURLOPT_POST, true);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($this->curl, CURLOPT_SSLVERSION, 1); // TLS
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer '.$this->access_token
		));
		$retVar = curl_exec($this->curl);
		curl_close($this->curl);

		$this->deleteSession();


		//echo "<script>window.location.href = 'http://".$_SERVER["HTTP_HOST"] . $_SERVER['PHP_SELF']."';</script>";
	}


	function getUserProfile($retType = "JSON"){
		if($this->getConnectState()){
			$data = array();
			$data['Authorization'] = $this->access_token_type.' '.$this->access_token;

			$this->curl = curl_init();
			curl_setopt($this->curl, CURLOPT_URL, KAKAO_PROFILE_URL);
			curl_setopt($this->curl, CURLOPT_POST, 1);
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
				'Authorization: '.$data['Authorization']
			));

			curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,true);
			$retVar = curl_exec($this->curl);
			curl_close($this->curl);

			return $retVar;

		}else{
			return false;
		}
	}



	/**
	*	Get AccessToken
	*	발급된 엑세스 토큰을 반환합니다. 엑세스 토큰 발급은 로그인 후 자동으로 이루어집니다.
	*/
	function getAccess_token(){
		if($this->access_token){
			return $this->access_token;
		}
	}

	/**
	*	 네이버 연결상태를 반환합니다.
	*    엑세스 토큰 발급/저장이 이루어진 후 connected 상태가 됩니다.
	*/
	function getConnectState(){
		return $this->KakaoConnectState;
	}



	private function updateConnectState($strState = ''){
		$this->KakaoConnectState = $strState;
	}


	/**
	*	토근을 세션에 기록합니다.
	*/
	private function saveSession(){

		if(isset($_SESSION) && is_array($_SESSION)){
			$_saveSession = array();
			$_saveSession['access_token']		=	$this->access_token;
			$_saveSession['access_token_type']	=	$this->access_token_type;
			$_saveSession['refresh_token']		=	$this->refresh_token;
			$_saveSession['access_token_expire']	=	$this->access_token_expire;

			$this->tokenDatas = $_saveSession;

			foreach($_saveSession as $k=>$v){
				$_SESSION[KAKAO_SESSION_NAME][$k] = $v;
			}
		}
	}


	private function deleteSession(){
		if(isset($_SESSION) && is_array($_SESSION) && $_SESSION[KAKAO_SESSION_NAME]){
			$_loadSession = array();
			$this->tokenDatas = $_loadSession;

			unset($_SESSION[KAKAO_SESSION_NAME]);

			$this->access_token			= '';
			$this->access_token_type	= '';
			$this->refresh_token		= '';
			$this->access_token_expire	= '';
			$this->updateConnectState(false);
		}
	}


	/**
	*	저장된 토큰을 복원합니다.
	*/
	private function loadSession(){

		if(isset($_SESSION) && is_array($_SESSION) && $_SESSION[KAKAO_SESSION_NAME]){
			$_loadSession = array();
			$_loadSession['access_token']		=	$_SESSION[KAKAO_SESSION_NAME]['access_token'] ? $_SESSION[KAKAO_SESSION_NAME]['access_token'] : '';
			$_loadSession['access_token_type']	=	$_SESSION[KAKAO_SESSION_NAME]['access_token_type'] ? $_SESSION[KAKAO_SESSION_NAME]['access_token_type'] : '';
			$_loadSession['refresh_token']		=	$_SESSION[KAKAO_SESSION_NAME]['refresh_token'] ? $_SESSION[KAKAO_SESSION_NAME]['refresh_token'] : '';
			$_loadSession['access_token_expire']	=	$_SESSION[KAKAO_SESSION_NAME]['access_token_expire'] ? $_SESSION[KAKAO_SESSION_NAME]['access_token_expire']:'';

			$this->tokenDatas = $_loadSession;

			$this->access_token			= $this->tokenDatas['access_token'];
			$this->access_token_type	= $this->tokenDatas['access_token_type'];
			$this->refresh_token		= $this->tokenDatas['refresh_token'];
			$this->access_token_expire	= $this->tokenDatas['access_token_expire'];

			$this->updateConnectState(true);

			$this->saveSession();
		}
	}


	private function _getAccessToken(){
		$this->curl = curl_init();

		curl_setopt($this->curl, CURLOPT_URL, KAKAO_TOKEN_URL);
		curl_setopt($this->curl, CURLOPT_POST, true);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($this->curl, CURLOPT_SSLVERSION, 1); // TLS
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, 'grant_type=authorization_code&client_id='.$this->client_id.'&redirect_uri='.$this->returnURL.'&code='.$this->returnCode.'&state='.$this->returnState);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,true);
		$retVar = curl_exec($this->curl);
		curl_close($this->curl);
		$KAKAOreturns = json_decode($retVar);

		if(isset($KAKAOreturns->access_token)){

			$this->access_token			= $KAKAOreturns->access_token;
			$this->access_token_type	= $KAKAOreturns->token_type;
			$this->refresh_token		= $KAKAOreturns->refresh_token;
			$this->access_token_expire	= $KAKAOreturns->expires_in;

			$this->updateConnectState(true);

			$this->saveSession();

			if($this->autoClose){
				echo "<script>window.close();</script>";
			}
		}
	}


	private function _refreshAccessToken(){
		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_URL, KAKAO_TOKEN_URL);
		curl_setopt($this->curl, CURLOPT_POST, true);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($this->curl, CURLOPT_SSLVERSION, 1); // TLS
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, 'grant_type=refresh_token&client_id='.$this->client_id.'&refresh_token='.$this->refresh_token);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,true);
		$retVar = curl_exec($this->curl);
		curl_close($this->curl);
		$KAKAOreturns = json_decode($retVar);

		if(isset($KAKAOreturns->access_token)){


			$this->access_token			= $KAKAOreturns->access_token;
			$this->access_token_type	= $KAKAOreturns->token_type;
			$this->refresh_token	=	$KAKAOreturns->refresh_token;
			$this->access_token_expire	= $KAKAOreturns->expires_in;

			$this->updateConnectState(true);

			$this->saveSession();

		}
	}



	private function generate_state() {
    $mt = microtime();
		$rand = mt_rand();
		$this->state = md5( $mt . $rand );
  }

  function getLoginScript() {
  	$url = KAKAO_OAUTH_URL.'?client_id='.$this->client_id.'&response_type=code&redirect_uri='.$this->returnURL.'&state='.$this->state;
	  echo '<script>
			$(".js-kakaoLogin").click(function(){
				var win = window.open("'.$url.'", "카카오_아이디로_로그인","width=320", "height=480", "toolbar=no", "location=no");

				var timer = setInterval(function() {
					if(win.closed) {
						window.location.reload();
						clearInterval(timer);
					}
				}, 500);
			});
			</script>';
	}

	function getLoginScriptForApply() {
		$url = KAKAO_OAUTH_URL.'?client_id='.$this->client_id.'&response_type=code&redirect_uri='.$this->returnURL.'&state='.$this->state;
	  echo '<script>
			$(".js-kakaoLogin").click(function(){
				var win = window.open("'.$url.'", "카카오_아이디로_로그인","width=320", "height=480", "toolbar=no", "location=no");
				return false;
			});
			</script>';
	}

	 function getLoginURL() {
		return KAKAO_OAUTH_URL.'?client_id='.$this->client_id.'&response_type=code&redirect_uri='.$this->returnURL.'&state='.$this->state;
	}
	function setReturnURL($input){
		$this->returnURL = trim(urlencode($input));
	}
}
