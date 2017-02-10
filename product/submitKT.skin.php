<!DOCTYPE>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=7">
<title>olleh mobile 가입신청서</title>

<script src="https://online.olleh.com:8090/common/js/common.js" type="text/javascript" ></script>
<script language="JavaScript" src="https://online.olleh.com:8090//common/js/gJavaFunc.js" ></script>
<script language="JavaScript" src="https://online.olleh.com:8090//common/js/jquery-core/jquery-1.7.1.min.js"></script>




<!-- //SSL js -->
<script language='javascript' src="https://online.olleh.com:8090/common/js/SSLlib.js"></script>
<!-- 소스보기, 오른쪽마우스, Ctrl+N, F5등을 막음 : 개발서버 주석처리  -->

<link href="https://online.olleh.com:8090/common/css/common.css" type="text/css" rel="stylesheet">
<link href="https://online.olleh.com:8090/common/css/default.css" type="text/css" rel="stylesheet">



	<script language="javascript">

		function fnOnload(){
			var f = document.infoForm;

			//[DR-2012-02263]	온라인서식지 권한생성/회수 기능 개선
			var basicFrmType 		= "<?php echo $KTInfo['basicFrmType']?>";
			var cutOffAgencyAuth 	= "";
			if(cutOffAgencyAuth == "NE"){
				if(basicFrmType == "G005" ||  basicFrmType == "G011"){
					alert('본 서식지는 더 이상 사용할 수 없습니다.');
					document.location.href='http://www.olleh.com/index.asp?code=G0000';
				}
			}else if(cutOffAgencyAuth == "AL"){
				alert('본 서식지는 더 이상 사용할 수 없습니다.');
				document.location.href='http://www.olleh.com/index.asp?code=G0000';
			}

			var div_intro = document.getElementById("div_intro");
			if(f.isOverlap.value == 'true'){
		  		document.getElementById("div_intro").style.display = 'none';
		  		document.getElementById("div_intro2").style.display = 'none';
		  		document.getElementById("div_intro3").style.display = 'none';
		  		document.getElementById("div_intro4").style.display = 'none';
		  		document.getElementById("div_intro5").style.display = 'none';
		  		//document.getElementById("div_intro6").style.display = '';
		  		document.getElementById("div_intro7").style.display = 'none';
			}

			//법인정보 기본값 세팅
	    	f.bizrName.value = f.bizrNM.value ;		//법인명
	    	f.crprNo1.value = f.crprNo.value.substring(0,6);
	    	f.crprNo2.value = f.crprNo.value.substring(6,13);
	    	f.bizrRegno2_1.value = f.bizrRegno.value.substring(0,3);
	    	f.bizrRegno2_2.value = f.bizrRegno.value.substring(3,5);
	    	f.bizrRegno2_3.value = f.bizrRegno.value.substring(5,10);

	    	/*// Olleh Shop에서 호출된 경우 Name 변경 불가
	    	if(  ( f.clientRefer.value.indexOf("shop.olleh.com") > -1 || f.clientRefer.value.indexOf("preorder.olleh.com")  > -1 ) && $.trim(f.BaseNM.value).length > 0){
	    		$("input[name=BaseNM]").attr("readonly", "readonly").bind("focus", function(){ $("input[name=BaseRegno1]").focus(); });
	    	} */

	    	//DR-2013-52336 비회원 인증 시 생년월일 주문페이지 고정입력
	    	if(f.BaseNM.value.length > 0 && f.BaseRegno1.value.length > 0){
	    		document.getElementById("BaseRegno1").readOnly = true;
	    	}else if(f.BaseNM.value.length > 0){
		    	document.getElementById("BaseNM").readOnly = true;
		    	//document.getElementById("teenNM").readOnly = true;
		    }

		    //DR-2011-20371 [방통위]휴대전화 부정사용 방지대책 수립_온라인서식지 휴대폰인증 제한
		    var basicFrmType = f.basicFrmType.value;
			if(basicFrmType == "G009" || basicFrmType == "G010" || basicFrmType == "G011" || basicFrmType == "G012"){
				document.getElementById("div_BizformType").style.display = "";
			}else{
				document.getElementById("div_BizformType").style.display = "none";
			}
		}

		function alertMsg(thisObj){
			var f = document.infoForm;
			if(f.isOverlap.value == 'true'){
	  			alert('이미 신청한 정보가 있습니다. 확인 하시기 바랍니다.\n\r 고객님의 핸드폰 신청내역을 조회하실 수 있습니다.');
		  		document.getElementById("div_intro").style.display = 'none';
		  		document.getElementById("div_intro2").style.display = 'none';
		  		document.getElementById("div_intro3").style.display = 'none';
		  		document.getElementById("div_intro4").style.display = 'none';
		  		document.getElementById("div_intro5").style.display = 'none';
		  		//document.getElementById("div_intro6").style.display = '';
		  		document.getElementById("div_intro7").style.display = 'none';
	  		}else{
		  		document.getElementById("div_intro").style.display = 'none';
		  		document.getElementById("div_intro2").style.display = 'none';
		  		document.getElementById("div_intro3").style.display = 'none';
		  		document.getElementById("div_intro4").style.display = 'none';
		  		document.getElementById("div_intro5").style.display = 'none';
		  		//document.getElementById("div_intro6").style.display = 'none';
		  		document.getElementById("div_intro7").style.display = 'none';
	  			//document.all[thisObj].style.display = '';
	  			document.getElementById(thisObj).style.display = '';

	  			if(thisObj == 'div_intro'){
	  				f.BaseNM.focus();
	  			}else if(thisObj == 'div_intro2'){
					f.teenNM.focus();
	  			}else if(thisObj == 'div_intro3'){
					f.bizrName.focus();
	  			}else if(thisObj == 'div_intro4'){
					f.foreignBaseNM_1.focus();
	  			}else if(thisObj == 'div_intro5'){
					f.custName.focus();
	  			}else if(thisObj == 'div_intro7'){
					f.foreignBaseNM_kor.focus();
	  			}
	  		}
		}


		// 일반/개인 실명인증
	    function goNext() {
	    	var f = document.infoForm;
	    	var basicFrmType = f.basicFrmType.value;

			if(f.CertIng.value == 'ING'){
				alert("실명인증이 진행중에 있습니다.");
				return;
			}

	    	if(f.BaseNM.value == ""){
				alert("고객명을 입력해주세요.");
				f.BaseNM.focus();
				return ;
			}

	    	if(basicFrmType == "G007" || basicFrmType == "G012"){
				if(f.BaseRegno1.value == "" || f.BaseRegno1.value.length != 8){
					alert("생년월일(8자리)을 입력해 주세요. ");
					f.BaseRegno1.focus();
					return ;
				}

		    	if(f.BaseSexInfo.value == ""){
					alert("성별을 선택해주세요. ");
					f.BaseSexInfo.focus();
					return ;
				}

		    	f.BaseRegno2.value = "";

		    	f.JobFlag.value  = "";
		    	f.CertIng.value  = "ING";
		    	f.isLayer.value = '0';
		    	f.action = "https://online.olleh.com/CU/BZCheckAge.jsp";
		    	f.target = "ifrmhidden";
		    	SSLsubmit(f);
	    	}else{
				if(f.BaseRegno1.value == ""){
					alert("주민등록번호를 입력해 주세요. ");
					f.BaseRegno1.focus();
					return ;
				}

				if(f.BaseRegno2.value == ""){
					alert("주민등록번호를 입력해 주세요. ");
					f.BaseRegno2.focus();
					return ;
				}

				// [SR-2016-미등록]  실명인증 캡챠 추가 (온라인/와이브로)
				if( f.captchaValue.value == null || f.captchaValue.value == "" ) {
					alert("보안문자를 입력하세요.");
					f.captchaValue.focus();
					return;
				}

		     	if (!f.AgreeBaseRegno.checked) {
					alert("(필수)주민번호 수집.이용에 관한 동의를 읽고 [동의]해주시기 바랍니다.");
					f.AgreeBaseRegno.focus();
					return;
				}

		    	if (chkJumin(f.BaseRegno1.value,f.BaseRegno2.value) ) {
		    		alert ("유효하지 않은 주민등록번호입니다. ");
		    		f.BaseRegno1.value = '';
		    		f.BaseRegno2.value = '';
		    		f.BaseRegno1.focus();
		    		return;
		    	} else {
			    	f.JobFlag.value  = "";
			    	f.CertIng.value  = "ING";
			    	f.isLayer.value = '0';
			    	f.action = "https://online.olleh.com:8090/CU/BZCheckAge.jsp";
			    	f.target = "ifrmhidden";
			    	SSLsubmit(f);
			    }
	    	}

	  	}

	  	// 미성년자 실명인증
	    function goNext2() {
	    	var f = document.infoForm;
	    	var basicFrmType = f.basicFrmType.value;

			if(f.CertIng.value == 'ING'){
				alert("실명인증이 진행중에 있습니다.");
				return;
			}

	    	if(f.teenNM.value == ""){
				alert("미성년자 고객명을  입력해주세요. ");
				f.teenNM.focus();
				return ;
			}

	    	if(basicFrmType == "G007" || basicFrmType == "G012"){
		    	if(f.teenBaseRegno1.value == "" || f.teenBaseRegno1.value.length != 8){
					alert("미성년자 고객 생년월일(8자리)을 입력해 주세요. ");
					f.teenBaseRegno1.focus();
					return ;
				}

		    	if(f.teenBaseSexInfo.value == ""){
					alert("성별을 선택해주세요. ");
					f.teenBaseSexInfo.focus();
					return ;
				}
	    	}else{
		    	if(f.teenBaseRegno1.value == ""){
					alert("미성년자 고객 주민등록번호를 입력해 주세요. ");
					f.teenBaseRegno1.focus();
					return ;
				}

		    	if(f.teenBaseRegno2.value == ""){
					alert("미성년자 고객 주민등록번호를 입력해 주세요. ");
					f.teenBaseRegno2.focus();
					return ;
				}

		    	if (chkJumin(f.teenBaseRegno1.value,f.teenBaseRegno2.value) ) {
		    		alert ("유효하지 않은 주민등록번호입니다. ");
		    		f.teenBaseRegno1.value = '';
		    		f.teenBaseRegno2.value = '';
		    		f.teenBaseRegno1.focus();
		    		return;
		    	}
		    }

	    	if(f.agentName.value == ""){
				alert("법정대리인 고객명을  입력해주세요. ");
				f.agentName.focus();
				return ;
			}

			if(f.agentRegno1_1.value == ""){
				alert("법정대리인 주민등록번호를   입력해주세요. ");
				f.agentRegno1_1.focus();
				return ;
			}
			if(f.agentRegno1_2.value == ""){
				alert("법정대리인 주민등록번호를   입력해주세요. ");
				f.agentRegno1_2.focus();
				return ;
			}


			// [SR-2016-미등록]  실명인증 캡챠 추가 (온라인/와이브로)
			if( f.captchaValue_p1.value == null || f.captchaValue_p1.value == "" ) {
				alert("보안문자를 입력하세요.");
				f.captchaValue_p1.focus();
				return;
			}

	    	//if (chkJumin(f.agentRegno1_1.value,f.agentRegno1_2.value) ) {
            if (!ssnCheck.allCheck(f.agentRegno1_1.value + f.agentRegno1_2.value) ) {
	    		alert ("유효하지 않은 주민등록번호입니다.");
	    		f.agentRegno1_1.value = '';
	    		f.agentRegno1_2.value = '';
	    		f.agentRegno1_1.focus();
	    		return;
	    	}

	    	if (!f.AgreeBaseRegno2.checked) {
				alert("(필수)주민번호 수집.이용에 관한 동의를 읽고 [동의]해주시기 바랍니다.");
				f.AgreeBaseRegno2.focus();
				return;
			}

		    f.BaseNM.value 			= f.agentName.value ;	 // 법정대리인 명
		    f.BaseRegno1.value 	= f.agentRegno1_1.value; // 법정대리인 주민등록번호1
		    f.BaseRegno2.value 	= f.agentRegno1_2.value; // 법정대리인 주민등록번호2
		    f.isLayer.value 	= '1';
		    f.CertIng.value  = "ING";

		    f.action = "https://online.olleh.com:8090/CU/BZCheckAge.jsp";
		    f.target = "ifrmhidden";
		    SSLsubmit(f);
	  	}

	  	// 법인사업자 실명인증
	    function goNext3() {
	    	var f = document.infoForm;

			if(f.CertIng.value == 'ING'){
				alert("실명인증이 진행중에 있습니다.");
				return;
			}

	    	if(f.bizrName.value == ""){
				alert("법인명을  입력해주세요. ");
				f.bizrName.focus();
				return ;
			}

	    	if(f.crprNo1.value == ""){
				alert("법인번호를 입력해주세요. ");
				f.crprNo1.focus();
				return ;
			}

	    	if(f.crprNo2.value == ""){
				alert("법인번호를 입력해주세요. ");
				f.crprNo2.focus();
				return ;
			}

	    	if(f.bizrRegno2_1.value == ""){
				alert("사업자번호를 입력해주세요. ");
				f.bizrRegno2_1.focus();
				return ;
			}

	    	if(f.bizrRegno2_2.value == ""){
				alert("사업자번호를 입력해주세요. ");
				f.bizrRegno2_2.focus();
				return ;
			}

	    	if(f.bizrRegno2_3.value == ""){
				alert("사업자번호를 입력해주세요. ");
				f.bizrRegno2_3.focus();
				return ;
			}

	    	if(f.bizrRegno2_1.value.length != 3 || f.bizrRegno2_2.value.length != 2 || f.bizrRegno2_3.value.length != 5){
				alert("사업자번호는 10자리 입니다. 다시 확인해주세요.");
				f.bizrRegno2_1.value = '';
				f.bizrRegno2_2.value = '';
				f.bizrRegno2_3.value = '';
				f.bizrRegno2_1.focus();
				return ;
			}

	    	if(f.bizrBaseNM.value == ""){
				alert("대리인 고객명을  입력해주세요. ");
				f.bizrBaseNM.focus();
				return ;
			}

	    	if(f.bizrBaseRegno1.value == "" || f.bizrBaseRegno1.value.length != 8){
				alert("대리인 생년월일(8자리)을 입력해주세요. ");
				f.bizrBaseRegno1.focus();
				return ;
			}

	    	if(f.bizrBaseSexInfo.value == ""){
				alert("대리인 성별을 선택해주세요. ");
				f.bizrBaseSexInfo.focus();
				return ;
			}

	    	/*if(f.bizrBaseRegno2.value == ""){
				alert("대리인 주민등록번호를 입력해주세요. ");
				f.bizrBaseRegno2.focus();
				return ;
			}

	    	if (chkJumin(f.bizrBaseRegno1.value,f.bizrBaseRegno2.value) ) {
	    		alert ("유효하지 않은 주민등록번호입니다. ");
	    		f.bizrBaseRegno1.value = '';
	    		f.bizrBaseRegno2.value = '';
	    		f.bizrBaseRegno1.focus();
	    		return;
	    	}

	    	if (!f.AgreeBaseRegno3.checked) {
				alert("(필수)주민번호 수집.이용에 관한 동의를 읽고 [동의]해주시기 바랍니다.");
				f.AgreeBaseRegno3.focus();
				return;
			}*/

	    	// 법정대리인 인증방식에 따라서 처리하는 방식이 달라짐
		    f.BaseNM.value 			= f.bizrBaseNM.value ;	 	// 가입자 명
		    f.BaseRegno1.value 	= f.bizrBaseRegno1.value; 	// 가입자 주민등록번호1
		    f.BaseRegno2.value 	= f.bizrBaseRegno2.value; 	// 가입자 주민등록번호2
		    f.isLayer.value = '3';
			f.CertIng.value  = "ING";

			f.action = "https://online.olleh.com:8090/CU/BZCheckAge.jsp";
			f.target = "ifrmhidden";
		    SSLsubmit(f);
	  	}

	  	// 외국인 실명인증
	    function goNext4() {
	    	var f = document.infoForm;

			if(f.CertIng.value == 'ING'){
				alert("실명인증이 진행중에 있습니다. \n(We are currently processing your request.  Please wait a moment.)");
				return;
			}

			// 외국인등록번호 실명인증
	    	if(f.foreignBaseNM_1.value == ""){
				alert("You must fill in the customer name field.");
				f.foreignBaseNM_1.focus();
				return ;
			}

	    	if(f.foreignBaseRegno1.value == ""){
				alert("You must fill in your alien registration number.");
				f.foreignBaseRegno1.focus();
				return ;
			}

	    	if(f.foreignBaseRegno2.value == ""){
				alert("You must fill in your alien registration number.");
				f.foreignBaseRegno2.focus();
				return ;
			}

	    	if(f.National_1.value == ""){
				alert("You must select your nationality.");
				f.National_1.focus();
				return ;
			}

	    	//if (!f.AgreeBaseRegno4.checked) {
				//alert("동의 하시기 바랍니다.");
				//f.AgreeBaseRegno4.focus();
				//return;
			//}

		    f.BaseNM.value 		= f.foreignBaseNM_1.value ;	 	// 외국인 이름
		    f.BaseRegno1.value 	= f.foreignBaseRegno1.value; 	// 외국인 번호1
		    f.BaseRegno2.value 	= f.foreignBaseRegno2.value;	// 외국인 번호1
		    f.National.value 	= f.National_1.value; 			// 국적
		    f.isLayer.value	= '4';
		    f.CertIng.value  = "ING";

			f.action = "https://online.olleh.com:8090/CU/Foreigner/BZCheckAge.jsp";
		    f.target = "ifrmhidden";
	    	SSLsubmit(f);
		}

	  	// 임시저장한 신청서 보기
	  	function goNext5() {
	    	var f = document.infoForm;
	    	var custSexInfo = getRadioValue(f.custSexInfo) ;

			if(f.CertIng.value == 'ING'){
				alert("실명인증이 진행중에 있습니다.");
				return;
			}

	    	if(f.custName.value == ""){
				alert("고객명을  입력해주세요. ");
				f.custName.focus();
				return ;
			}

			if(f.BaseRegno1_2.value == ""){
				alert("생년월일/외국인등록번호 앞6자리를  입력해 주세요. ");
				f.BaseRegno1_2.focus();
				return ;
			}

			if (custSexInfo == null || custSexInfo == "") {
				alert("성별을 선택해 주세요");
				f.custSexInfo[0].focus();
				return;
			}



			if(f.formPwd.value == ""){
				alert("비밀번호를  입력해주세요. ");
				f.formPwd.focus();
				return ;
			}

			//if(chkNumeric(f.formPwd)){
				//return ;
			//}

		   	//임시저정 패치 와
		   	//미성년자 서식지 상호 호환을 위해 설정
		    f.BaseNM.value = f.custName.value ;
		    f.BaseRegno1.value = f.BaseRegno1_2.value;
		    isChecked(f.custSexInfo);
		    //f.BaseRegno2.value = f.BaseRegno2_2.value;
		    f.custRegno1.value = f.BaseRegno1_2.value;
		    f.JobFlag.value  = "TMPVeiw";
		    f.CertIng.value  = "ING";

		    f.action = "https://online.olleh.com:8090/BizFormApply_TMPVeiw.action";
		    f.target = "ifrmhidden";
	     	SSLsubmit(f);
	  	}

	  	// 외국인한글 실명인증
	    function goNext7() {
	    	var f = document.infoForm;

			if(f.CertIng.value == 'ING'){
				alert("실명인증이 진행중에 있습니다. \n(We are currently processing your request.  Please wait a moment.)");
				return;
			}

			// 외국인등록번호 실명인증
	    	if(f.foreignBaseNM_kor.value == ""){
				alert("고객명을  입력해주세요.");
				f.foreignBaseNM_kor.focus();
				return ;
			}

	    	if(f.foreignBaseRegno_kor1.value == ""){
				alert("주민등록번호를  입력해주세요.");
				f.foreignBaseRegno_kor1.focus();
				return ;
			}

	    	if(f.foreignBaseRegno_kor2.value == ""){
				alert("주민등록번호를  입력해주세요.");
				f.foreignBaseRegno_kor2.focus();
				return ;
			}

	    	if(f.National_kor.value == ""){
				alert("국적을 선택해주세요.");
				f.National_kor.focus();
				return ;
			}

			// [SR-2016-미등록]  실명인증 캡챠 추가 (온라인/와이브로)
			if( f.captchaValue_p2.value == null || f.captchaValue_p2.value == "" ) {
				alert("보안문자를 입력하세요.");
				f.captchaValue_p2.focus();
				return;
			}

	    	if (!f.AgreeBaseRegno7.checked) {
				alert("(필수)주민번호 수집.이용에 관한 동의를 읽고 [동의]해주시기 바랍니다.");
				f.AgreeBaseRegno7.focus();
				return;
			}

		    f.BaseNM.value 		= f.foreignBaseNM_kor.value ;	 	// 외국인 이름
		    f.BaseRegno1.value 	= f.foreignBaseRegno_kor1.value; 	// 외국인 번호1
		    f.BaseRegno2.value 	= f.foreignBaseRegno_kor2.value;	// 외국인 번호1
		    f.National.value 	= f.National_kor.value; 			// 국적
		    f.isLayer.value	= '4';
		    f.CertIng.value  = "ING";

			f.action = "https://online.olleh.com:8090/CU/BZCheckAge.jsp";
		    f.target = "ifrmhidden";
	    	SSLsubmit(f);
	  	}

	  	// 일반/개인 Open Layer
	  	function fnOpenLayer() {
	  		if( !fnPreCheckType() ) return; //가입유형 먼저 체크

	  		//DR-2014-11286 [영업정지] kt 영업정지에 따른 온라인서식지 신규가입 차단
			if( fnBusinessDay() ) return;

	  		var f = document.infoForm;
	  		var basicFrmType = f.basicFrmType.value;

	  		/* // Olleh Shop에서 호출된 경우 이름 변경 불가
	  		if(f.clientRefer.value.indexOf("shop.olleh.com") > -1 && $.trim(f.BaseNM.value).length > 0){
	    		$("input[name=BaseNM]").attr("readonly", "readonly").bind("focus", function(){ $("input[name=BaseRegno1]").focus(); });
	    	} */

	    	//DR-2013-52336 비회원 인증 시 생년월일 주문페이지 고정입력
			if(f.BaseNM.value.length > 0){
		    		document.getElementById("BaseNM").readOnly = true;
		    }else if(f.BaseNM.value.length > 0 && f.BaseRegno1.value.length > 0){
		    		document.getElementById("BaseRegno1").readOnly = true;
		    }

	    	if(basicFrmType != "G007"){
	  			chg();
	  			// [SR-2016-미등록]  실명인증 캡챠 추가 (온라인/와이브로)
				if( navigator.userAgent.indexOf("MSIE") != -1 || window.ActiveXobject){
					document.getElementById("forHtml5").style.display = "none";
					document.getElementById("forOldIE").style.display = "inline";
				}else{
					document.getElementById("forHtml5").style.display = "inline";
					document.getElementById("forOldIE").style.display = "none";
				}
	    	}

	  		if (document.getElementById("div_intro").style.display == '') {
	  			goNext() ;
	  		} else {
				return alertMsg('div_intro');

		  		document.getElementById("div_intro").style.display = '';
		  		document.getElementById("div_intro2").style.display = 'none';
		  		document.getElementById("div_intro3").style.display = 'none';
	  			document.getElementById("div_intro4").style.display = 'none';
	  			document.getElementById("div_intro5").style.display = 'none';
	  			document.getElementById("div_intro7").style.display = 'none';
		  		f.BaseNM.focus();
		  	}



	  	}

	  	// 일반/개인 Close Layer
	  	function fnCloseLayer() {
	  		document.getElementById("div_intro").style.display = 'none';
	  	}

	  	// 미성년자 Open Layer
	  	function fnOpenLayer2() {
	  		if( !fnPreCheckType() ) return; //가입유형 먼저 체크

	  		//DR-2014-11286 [영업정지] kt 영업정지에 따른 온라인서식지 신규가입 차단
			if( fnBusinessDay() ) return;

		  		// [SR-2016-미등록]  실명인증 캡챠 추가 (온라인/와이브로)
		  		chg_p('p1');
				if( navigator.userAgent.indexOf("MSIE") != -1 || window.ActiveXobject){
			  		document.getElementById("forHtml5_p1").style.display = "none";
					document.getElementById("forOldIE_p1").style.display = "inline";
				}else{
					document.getElementById("forHtml5_p1").style.display = "inline";
					document.getElementById("forOldIE_p1").style.display = "none";
				}
	  		var f = document.infoForm;
	  		if (document.getElementById("div_intro2").style.display == '') {
	  			goNext2() ;
	  		} else {
		  		return alertMsg('div_intro2');
	  			document.getElementById("div_intro").style.display = 'none';
		  		document.getElementById("div_intro2").style.display = '';
		  		document.getElementById("div_intro3").style.display = 'none';
		  		document.getElementById("div_intro4").style.display = 'none';
		  		document.getElementById("div_intro5").style.display = 'none';
	  			document.getElementById("div_intro7").style.display = 'none';
		  		f.teenNM.focus();
		  	}

	  	}

	  	// 미성년자 Close Layer
	  	function fnCloseLayer2() {
	  		document.getElementById("div_intro2").style.display = 'none';
	  	}

	  	// 법인사업자 Open Layer
	  	function fnOpenLayer3() {
	  		var f = document.infoForm;

	  		var shpmlCD = f.shpmlCD.value;
	  		if(shpmlCD=="M601"){
	  			alert("신청서는 매장에서 작성 바랍니다.");
	  			return;
	  		}

	  		if( !fnPreCheckType() ) return; //가입유형 먼저 체크

	  		//DR-2014-11286 [영업정지] kt 영업정지에 따른 온라인서식지 신규가입 차단
			if( fnBusinessDay() ) return;

	  		var agencyFrmCd = "|" + f.agencyFrmCd.value + "|";

	  	 	if( "|1060151|1060152|1060153|1060154|".indexOf(agencyFrmCd) > -1   ){
	  			alert("갤럭시S2 예약가입은 개인/미성년자/외국인만 가능 합니다.");
	  		} else {

		  		if (document.getElementById("div_intro3").style.display == '') {
		  			goNext3() ;
		  		} else {
			  		return alertMsg('div_intro3');

			  		document.getElementById("div_intro").style.display = 'none';
			  		document.getElementById("div_intro2").style.display = 'none';
			  		document.getElementById("div_intro3").style.display = '';
			  		document.getElementById("div_intro4").style.display = 'none';
			  		document.getElementById("div_intro5").style.display = 'none';
		  			document.getElementById("div_intro7").style.display = 'none';
			  		f.bizrName.focus();
			  	}
			}
	  	}

	  	// 법인사업자 Close Layer
	  	function fnCloseLayer3() {
	  		document.getElementById("div_intro3").style.display = 'none';
	  	}

	  	// 외국인 Open Layer
	  	function fnOpenLayer4() {
	  		var f = document.infoForm;
	  		var shpmlCD = f.shpmlCD.value;

	  		//외국인 영문버전 작성 제한 2015/11/27
	  		alert("현재 외국인신청서는 한글버전만 사용이 가능합니다.");
	  		return;


	  		if(shpmlCD=="M601"){
	  			alert("외국인 한글 신청서로 작성 바랍니다.");
	  			return;
	  		}

	  		if( !fnPreCheckType() ) return; //가입유형 먼저 체크

	  		//DR-2014-11286 [영업정지] kt 영업정지에 따른 온라인서식지 신규가입 차단
			if( fnBusinessDay() ) return;

	  		var hpCd = f.hpCd.value;
	  		var agencyCd = f.agencyCd.value;

	  		if (document.getElementById("div_intro4").style.display == '') {
	  			goNext4();
	  		} else {
		  		// 1. 외국인이 접근 가능한 대리점
		  		// 2. 대리점코드 YO20003(올래샵) && 단말기코드 : 아이폰4(5813.5814)
				if(f.foreignCnt.value > 0 || (  agencyCd == "YO20003" && "|5813|5814|".indexOf(hpCd) > -1  ) ){
					return alertMsg('div_intro4');
				}else{
					alert('한국어로만 상담이 가능한 대리점입니다. 한국어 서식지로 작성해 주십시오.\n영어 상담이 가능한 대리점을 찾으신다면 외국인 전용 블로그(http://expatblog.kt.com)를 방문해 주시기 바랍니다. \n \nWe’re sorry, but this retailer does not offer English support for mobile subscriptions,\nand is unable to accept the English version of the online subscription application.  \nTo find a store that provides consultations in English, please visit the KT Expat Blog at: http://expatblog.kt.com.');
					return;
				}

		  		document.getElementById("div_intro").style.display = 'none';
		  		document.getElementById("div_intro2").style.display = 'none';
		  		document.getElementById("div_intro3").style.display = 'none';
		  		document.getElementById("div_intro5").style.display = 'none';
	  			document.getElementById("div_intro7").style.display = 'none';
		  	}
	  	}

	  	// 외국인 Close Layer
	  	function fnCloseLayer4() {
	  		document.getElementById("div_intro4").style.display = 'none';
	  	}

	  	// 임시저장 Open Layer
	  	function fnOpenLayer5() {
	  		fnSetBizformClose(); //가입유형 닫기

	  		//DR-2014-11286 [영업정지] kt 영업정지에 따른 온라인서식지 신규가입 차단
			if( fnBusinessDay() ) return;

	  		var f = document.infoForm;
	  		if (document.getElementById("div_intro5").style.display == '') {
	  			goNext5() ;
	  		} else {
		  		return alertMsg('div_intro5');

		  		document.getElementById("div_intro").style.display = 'none';
		  		document.getElementById("div_intro2").style.display = 'none';
		  		document.getElementById("div_intro3").style.display = 'none';
		  		document.getElementById("div_intro4").style.display = 'none';
		  		document.getElementById("div_intro5").style.display = '';
	  			document.getElementById("div_intro7").style.display = 'none';
		  		f.custName.focus();
		  	}
	  	}

	  	// 임시저장 Close Layer
	  	function fnCloseLayer5() {
	  		document.getElementById("div_intro5").style.display = 'none';
	  	}

	  	// 임시저장 Close Layer
	  	function fnCloseLayer6() {
	  		//document.getElementById("div_intro6").style.display = 'none';
	  	}

	  	// 외국인한글 Open Layer
	  	function fnOpenLayer7() {
	  		if( !fnPreCheckType() ) return; //가입유형 먼저 체크

	  		//DR-2014-11286 [영업정지] kt 영업정지에 따른 온라인서식지 신규가입 차단
			if( fnBusinessDay() ) return;

	  		var f = document.infoForm;
	  		var hpCd = f.hpCd.value;
	  		var agencyCd = f.agencyCd.value;

	  		// [SR-2016-미등록]  실명인증 캡챠 추가 (온라인/와이브로)
	  		chg_p('p2');
			if( navigator.userAgent.indexOf("MSIE") != -1 || window.ActiveXobject){
		  		document.getElementById("forHtml5_p2").style.display = "none";
				document.getElementById("forOldIE_p2").style.display = "inline";
			}else{
		  		document.getElementById("forHtml5_p2").style.display = "inline";
				document.getElementById("forOldIE_p2").style.display = "none";
			}

	  		if (div_intro7.style.display == '') {
	  			goNext7();
	  		} else {
		  		// 1. 외국인이 접근 가능한 대리점
		  		// 2. 대리점코드 YO20003(올래샵) && 단말기코드 : 아이폰4(5813.5814)
				//if(f.foreignCnt.value > 0 || (  agencyCd == "YO20003" && "|5813|5814|".indexOf(hpCd) > -1  ) ){
				//	return alertMsg('div_intro7');
				//}else{
				//	alert('외국인 고객님은 대리점으로 별도 문의해 주세요.\n(This reseller is not able to accepp applications for foreign customers at this time. Please contact the reseller directly.)');
				//	return;
				//}

				alertMsg('div_intro7');

	  		document.getElementById("div_intro").style.display = 'none';
	  		document.getElementById("div_intro2").style.display = 'none';
	  		document.getElementById("div_intro3").style.display = 'none';
	  		document.getElementById("div_intro4").style.display = 'none';
	  		document.getElementById("div_intro5").style.display = 'none';
	  		document.getElementById("div_intro7").style.display = '';

		  	}
	  	}

	  	// 외국인한글 Close Layer
	  	function fnCloseLayer7() {
	  		document.getElementById("div_intro7").style.display = 'none';
	  	}

	  	// 폰스토어(접점코드) && 동일한 대리점코드 && 동일한주문자명 && 쇼핑몰 주문번호 동일할 경우
	  	function goFormList(){
	  		var f = document.infoForm;

		    if( f.userNm.value == "" ) {
		        alert("이름을 입력해 주세요.");
		        f.userNm.focus();
		        return;
		    }

		    if( f.userSsn1.value == "" || f.userSsn2.value == "" ) {
		        alert("주민등록번호를 입력해 주세요.");
		        if( f.userSsn1.value == "" ) {
		            f.userSsn1.focus();
		        } else {
		            f.userSsn2.focus();
		        }
		        return;
		    }

		    if( f.userPwd.value == "" ) {
		        alert("비밀번호를 입력해 주세요.");
		        f.userPwd.focus();
		        return;
		    }

		    if( f.userPwd.value.length == 4) {
		        alert("비밀번호를 4자리로 입력해 주세요.");
		        f.userPwd.value = '';
		        f.userPwd.focus();
		        return;
		    }

		    f.action = "https://online.olleh.com:8090/BizFormApplyList.action";
		    f.target = "_self";
		    SSLsubmit(f);
		}

		function fnFAQList(){
			settings = 'toolbar=no, scrollbars=no, width=950, height=650, top=0, left=0';

			window.open(SSL("https://online.olleh.com:8090/FAQSearch.action?enc=false"), "", settings );
		}

		function fnBFLogin(){
			window.open(SSL("https://online.olleh.com:8090/CU/BizFormLogin.jsp"), "_self", "" );
		}

		function fnSample(){
			LeftPosition = (screen.width) ? (screen.width-900)/2 : 0;
			TopPosition = (screen.height) ? (screen.height-662)/2 : 0;
			// settings = 'height='+662+',width='+900+',top='+TopPosition+',left='+LeftPosition+',scrollbars='no',resizable';
			settings = 'toolbar=no, scrollbars=no, width=950, height=700, top=0, left=0';

			window.open(SSL("https://online.olleh.com:8090/CU/BizFormApplySample.jsp"), "", settings );
		}

		//DR-2011-20371 [방통위]휴대전화 부정사용 방지대책 수립_온라인서식지 휴대폰인증 제한
		function fnPreCheckType(){
			var f = document.infoForm;
			var basicFrmType = f.basicFrmType.value;

			if(basicFrmType == "G009" || basicFrmType == "G010" || basicFrmType == "G011" || basicFrmType == "G012") {
				alert("먼저 가입유형을 선택해주세요.");
				if (document.getElementById("div_BizformType").style.display == 'none') {
					document.getElementById("div_BizformType").style.display = '';
				}
				return false;
			} else {
				return true;
			}
		}

		function fnCheckType(){
			var f = document.infoForm;
			var Seltbizform = f.Seltbizform.value;

			if(Seltbizform == null || Seltbizform == ""){
				alert("가입유형을 선택해주세요.");
				return;
			}

			f.basicFrmType.value = f.Seltbizform.value;

			fnSetBizformClose();
		}

	  	 function fnSetBizformClose() {
	  		document.getElementById("div_BizformType").style.display = 'none';
	   	 }


	  	function fnBusinessDay(){
		  	//DR-2014-11286 [영업정지] kt 영업정지에 따른 온라인서식지 신규가입 차단

			var isDay = "false";
			var basicFrmType = "<?php echo $KTInfo['basicFrmType']?>";
			if(isDay == 'true'){
				if(basicFrmType == "G005" ||  basicFrmType == "G006" ||  basicFrmType == "G008" || basicFrmType == "G011"  || basicFrmType == "G012"){
					 alert("3.13(목)~4.26(토)까지 신규/번호이동 및 24개월미만\n핸드폰 이용고객의 기기변경 신청업무가 불가능합니다.\n\n제한된 서비스 제공에 대해 양해해주시기 바랍니다.");
					return true;
				}else if(basicFrmType == "G007"){
					alert("3.13(목) ~ 4.26(토)까지 24개월 미만 핸드폰 이용고객의 기기변경\n 신청업무가 불가능합니다.\n제한된 서비스 제공에 대해 양해해주시기 바랍니다.");
					return false;
				}else{
					return false;
				}
			}
	  	}

		function chg(){
			document.getElementById('captchaImg').src='https://online.olleh.com:8090/common/getCaptcha.action?id='+Math.random();
			//document.getElementById('captchaValue').focus();
		}

		function chg_p(tag){
			document.getElementById('captchaImg_'+tag).src='https://online.olleh.com:8090/common/getCaptcha.action?id='+Math.random();
			//document.getElementById('captchaValue_'+tag).focus();
		}

	    function loadAudio() {
	        document.getElementById("audioCaptcha").src = "https://online.olleh.com:8090/getAudioCaptcha.action?bogus=" + new Date().getTime();
	        document.getElementById("audioCaptcha").style.width = 0;
	        document.getElementById("audioCaptcha").style.height = 0;
	        document.getElementById("audioCaptcha").play();
	        document.getElementById('captchaValue').focus();
	    }

		function playSound() {
			var htmlString = "<object type='audio/x-wav' data='https://online.olleh.com:8090/getAudioCaptcha.action?bogus=" + new Date().getTime() + "' width='0' height='0'><param name='src' value='https://online.olleh.com:8090/getAudioCaptcha.action?bogus=" + new Date().getTime() +"'/><param name='autostart' value='true' /><param name='controller' value='false' /></object>";
			replace_html("soundPlayer", htmlString);
			document.getElementById('captchaValue').focus();
		}

		function replace_html(el, html) {
			if( el ) {
				var oldEl = (typeof el === "string" ? document.getElementById(el) : el);
				var newEl = document.createElement(oldEl.nodeName);

				// Preserve any properties we care about (id and class in this example)
				newEl.id = oldEl.id;
				newEl.className = oldEl.className;

				//set the new HTML and insert back into the DOM
				newEl.innerHTML = html;
				if(oldEl.parentNode)
					oldEl.parentNode.replaceChild(newEl, oldEl);
				else
					oldEl.innerHTML = html;

				//return a reference to the new element in case we need it
				return newEl;
			}
		}
	</script>

	<style type=text/css >
	 .tit_no {border-right:none;border-left:none;background:none;}
	 .inp {border:1px solid #bfbfbf; height:16px !importent; _height:16px !importent; padding:2px 2px 2px 2px;}
	 .inp4 {border:1px solid #d9d9d9; background:#e7e7e7; height:16px; _height:16px; padding:2px 2px 2px 2px; color:#000;}
	 .ninp {border:2px solid #E12525; height:16px; _height:16px; padding:2px 2px 2px 2px;}
	 .lpu_explan .inp {height:16px !importent;}
	</style>

</head>

<body onLoad="fnOnload();">
	<form name="infoForm" method="post" autocomplete="off" onsubmit="return false;" accept-charset="EUC-KR">
	<input type="hidden" name="agencyFrmCd" 	value="<?php echo $KTInfo['agencyFrmCd']?>"/>
	<input type="hidden" name="OrderNo" 		value="" />
	<input type="hidden" name="ConsultTxt" 		value="" />
	<input type="hidden" name="payType" 		value="" />
	<input type="hidden" name="TransCD" 		value="<?php echo $KTInfo['TransCD']?>" />
	<input type="hidden" name="custNm" 			value="" />
	<input type="hidden" name="custphone" 		value="" />
	<input type="hidden" name="mobile" 			value="" />
	<input type="hidden" name="deliCustNm" 		value="" />
	<input type="hidden" name="deliPhone" 		value="" />
	<input type="hidden" name="deliZipCd" 		value="" />
	<input type="hidden" name="deliAddr1" 		value="" />
	<input type="hidden" name="deliAddr2" 		value="" />
	<input type="hidden" name="deliMemo" 		value="" />
	<input type="hidden" name="memPhone" 		value="" />
	<input type="hidden" name="memMobile1" 		value="" />
	<input type="hidden" name="clrInfo" 		value="" />
	<input type="hidden" name="presentInfo" 	value="" />
	<input type="hidden" name="adviceID" 		value="" />
	<input type="hidden" name="adviceNM" 		value="" />
	<input type="hidden" name="adviceCtn" 		value="" />
	<input type="hidden" name="adviceApp" 		value="" />
	<input type="hidden" name="initPriceSoc" 	value="" />
	<input type="hidden" name="cust_id" 		value="" />
	<input type="hidden" name="shpmlNm" 		value="<?php echo $KTInfo['shpmlNm']?>" />
	<input type="hidden" name="foreignCnt"		value="<?php echo $KTInfo['foreignCnt']?>" />
	<input type="hidden" name="isOverlap"		value="<?php echo $KTInfo['isOverlap']?>" />
	<input type="hidden" name="MNSWebFlag"		value="<?php echo $KTInfo['MNSWebFlag']?>" />
	<input type="hidden" name="hpCd"			value="<?php echo $KTInfo['hpCd']?>" />
	<input type="hidden" name="agencyCd"		value="<?php echo $KTInfo['agencyCd']?>" />
	<input type="hidden" name="JobFlag" />
	<input type="hidden" name="CertIng" />
	<input type="hidden" name="custRegno1" />
	<input type="hidden" name="National" />
	<input type="hidden" name="isLayer" /> 		<!-- 미성년자구분 (0:일반 , 1:미성년자 , 2:법인사업자 , 3:외국인 , 4:개인사업자  -->
	<input type="hidden" name="isUsimPay" value=""> <!-- USIM구매구분 -->
	<input type="hidden" name="VasSocValv" value=""> <!-- 부가 서비스 정보 -->
	<input type="hidden" name="formNoti" value=""> <!-- 대리점 공지사항 -->
	<input type="hidden" name="basicFrmType" value="<?php echo $KTInfo['basicFrmType']?>"> <!-- 가입유형 -->
	<input type="hidden" name="shpmlCD" value="">
	<!-- 법인정보 기본값 세팅 -->
	<input type="hidden" name="bizrNM"		value="" />
	<input type="hidden" name="crprNo"		value="" />
	<input type="hidden" name="bizrRegno"	value="" />
	<input type="hidden" name="agntRltn"	value="" />
	<input type="hidden" name="rgstDt"		value="" />

	<!-- DR-2011-33400	올레샵 올레클럽 별 자동적립 전산 개발 요청 -->
	<input type="hidden" name="starPoint" value="">
	<input type="hidden" name="O_ENC_KEY" value="">

	<!-- DR-2012-01085 올레샵 내 할부원금 값 온라인 서식지로 연동 요청		-->
	<!-- DR-2012-01012	온라인 서식지/M&S마케팅웹 가격 연동 개발	-->
	<input type="hidden" name="monthlyOrigAmt" value="">

	<!-- 갤럭시S3 예판 올레투게더 & 온라인서식지 연동 -->
	<input type="hidden" name="resCode" value="">

	<!-- [DR-2014-15508] 샵2 슈퍼스타 고객 구매 시 별도 접점코드로 서식지 연동 -->
	<input type="hidden" name="ollehshopVip" value="">

	<!-- [DR-2014-24658]	올레샵에서 배송방법 스마트픽업 시 온라인신청서 배송주소 숨김처리 -->
	<input type="hidden" name="ollehshopSmartPickUp" value="">

	<!-- [DR-2012-19514] 올레샵 심플 주문시 온라인 서식지 반영항목 추가 요청 -->
	<input type="hidden" name="smplDscnEngg" value="">
	<input type="hidden" name="smplUsimType" value="">
	<input type="hidden" name="smplUsimOpt" value="">
	<input type="hidden" name="priceCd" value="">

	<!-- [DR-2012-40729] Shop-서식지간 SIMple 충전 데이터플러스 부가서비스 선택 연동 -->
	<input type="hidden" name="smplRchrVas" value="" />

	<!-- DR-2011-34485	온라인서식지_N-STEP개통 시 접점변경 불가조치, 서식지유입 URL정보 접수리스트 및 통계적용 -->
	<input type="hidden" name="clientRefer"	value="<?php echo $KTInfo['clientRefer']?>" />

	<!-- GB-서식지 권유자정보 추가연동 -->
	<input type="hidden" name="supportID" value="">
	<input type="hidden" name="supportNM" value="">
	<input type="hidden" name="priceNm" value="">
	<input type="hidden" name="agencyCd" value="<?php echo $KTInfo['agencyCd']?>">
	<input type="hidden" name="agencyName" value="<?php echo $KTInfo['agencyName']?>">
	<input type="hidden" name="dealerCntplc" value="">
	<input type="hidden" name="faxNO" value="">

	<!-- DR-2014-27922 온라인신청서에 스펀지플랜 숨김처리 요청 -->
	<input type="hidden" name="ollehshopSpongeYn" value="">

	<!-- DR-2014-33799 올레샵(오픈샵 포함) 가입비 설정 기능 요청 -->
	<input type="hidden" name="reqAddFee" value="">
	<input type="hidden" name="slsCntpntCd" value="">

	<!--[DR-2014-35091] 단통유통구조개선법 관련 개발 통합  -->
	<input type="hidden" name="storSupotAmnt" value="">
	<input type="hidden" name="dscnOptnCd" value="">

	<!--DR-2014-59395 제휴포인트(포인트파크) 적용 오류 조치  -->
	<input type="hidden" name="pointParkDispYN" value="">

	<!-- [DR-2014-53616] 요금할인(지원금) 온라인신청 -->
	<input type="hidden" name="cntpntAgtID" value="">
	<input type="hidden" name="opHpCd" value="">
	<input type="hidden" name="opHpModel" value="">
	<input type="hidden" name="opHpSn" value="">

	
	<input type="hidden" name="olhdiscnt" value="">

    
    <input type="hidden" name="baseShopCode" value="">

	
	<input type="hidden" name="mnsToken" value="">

	<div id="intro">
		<h1 class="mgt80 mgb10"><img src="https://online.olleh.com:8090/images/intro/intro_logo.gif" alt="가입신청서"/></h1>
			<div>
			
			<h2><?echo $typeText?></h2>
		</div>
		<div class="mgb30"><img src="https://online.olleh.com:8090/images/intro/intro_img_t2.gif" alt="간략설명"/></div>

		<!--메뉴영역-->
		<ul id="int_menu">
			<li class="rbg"><a href="javascript:fnOpenLayer();"><img src="https://online.olleh.com:8090/images/icon/intro_icon01.gif" alt="개인일반"/></a></li>
			<li class="rbg"><a href="javascript:fnOpenLayer2();"><img src="https://online.olleh.com:8090/images/icon/intro_icon02.gif" alt="미성년자"/></a></li>
			<li class="rbg"><a href="javascript:fnOpenLayer3();"><img src="https://online.olleh.com:8090/images/icon/intro_icon03.gif" alt="법인"/></a></li>
			<li class="rbg"><img src="https://online.olleh.com:8090/images/icon/intro_icon04_01.gif" alt="외국인" usemap="#Foreigner"/></li>
		</ul>
		<map name="Foreigner">
			<area shape="rect" coords="3,199,55,218" href="javascript:fnOpenLayer4();" />
			<area shape="rect" coords="67,199,124,218" href="javascript:fnOpenLayer7();" />
		</map>

		<!--임시저장한신청서보기-->
		<div class="cent">
			<a href="javascript:fnOpenLayer5();"><img src="https://online.olleh.com:8090/images/btn/intro_btn_temporder.gif" alt="임시저장한 신청서 보기"/></a>
			<a href="javascript:fnBFLogin();"><img src="https://online.olleh.com:8090/images/btn/btn_ApplyInfoSearch.gif" alt="신청내역조회"/></a>
			<a href="javascript:fnFAQList();"><img src="https://online.olleh.com:8090/images/btn/intro_btn_faq.gif" alt="FAQ"/></a>
			<a href="javascript:fnSample();"><img src="https://online.olleh.com:8090/images/btn/intro_btn_sample.gif" alt="샘플보기"/></a>
		</div>

		<div id="int_text">
			kt 공식 온라인 대리점 <span class="p01">트라움(AA01322)</span>에 오신것을 환영합니다.
			<br/>
			고객님은 <span class="p01">트라움</span> 에서 kt 본사가 보증하는 공식 대리점을 통해 핸드폰 구입 및 olleh mobile 서비스에 가입됩니다.
		</div>
	</div>

<!-- ////////////////////레이어팝업////////////////////// -->

<!-- 레이어팝업 개인/일반 -->
<div id="div_intro" class="alpa_bg"  style="display:none; margin-left:-250px; width:1000px top:110px !important">

	<div class="lpu_box" style="width:100%">
		<!--LPU타이틀-->
		<div class="lpu_tit">
			<h4><img src="https://online.olleh.com:8090/images/title/lpu_tit_01.gif" alt="개인일반실명인증"/></h4>
			<a href="javascript:fnCloseLayer();" class="lpu_close"><img src="https://online.olleh.com:8090/images/btn/lpu_btn_close.gif" alt="닫기"/></a>
		</div>

		<!--내용-->
		
			<div class="lpu_explan" >
				<table class="sty_01" style="width:100%">
					<tr>
						<td class="tit" style="width:30%;">성명</td>
						<td class="cont">
							<input type="text" class="inp" style="width:230px;" name="BaseNM" id="BaseNM" value="" onKeyPress="return specialKey(event, false)" style='ime-mode:active' maxlength="15"/>
						</td>
					</tr>
					<tr><td class="line" colspan="2"></td></tr>
					<tr>
						<td class="tit">주민등록번호</td>
						<td class="cont">
							<input type="text"  class="inp" style="width:105px;" name="BaseRegno1" id="BaseRegno1" value=""onkeydown="return keyEventCtrl('no',event,this);" onkeyup="javascript:fnNext(event,6,this,BaseRegno2);" maxlength="6" />
							-
							<input type="password" class="inp" style="width:105px;" name="BaseRegno2"  onkeydown="return keyEventCtrl('no',event,this);" onkeyup="javascript:fnNext(event,7,this,captchaValue);" maxlength="7"/>
						</td>
					</tr>
					<tr><td class="line" colspan="2"></td></tr>
					<tr style="display:;">
						<td class="tit">보안문자</td>
						<td class="cont" colspan="3">
							<p style="border:1px #e1e1e1 solid; float:left; margin-right:10px;"><img id="captchaImg" src="https://online.olleh.com:8090/common/getCaptcha.action" /></p>
							<span id="forHtml5" style="display:none;margin-bottom:2px;">
								 <a href="javascript:loadAudio();"><img src="https://online.olleh.com:8090/images/btn/btn_voice.gif" alt="음성듣기"/></a>
								  <audio controls=controls id="audioCaptcha" style="width:0;height:0"></audio>
								  <a href="javascript:chg();"><img src="https://online.olleh.com:8090/images/btn/btn_replace.gif" alt="새로고침"/></a>
							</span>
							<span id="forOldIE" style="display:none;margin-bottom:2px;">
									
									<a href="https://online.olleh.com:8090/_Lib/openWin/playSound.jsp" target="ifrmhidden"><img src="https://online.olleh.com:8090/images/btn/btn_voice.gif" alt="음성듣기"/></a>
									<!-- <a href="javascript:playSound();"><img src="https://online.olleh.com:8090/images/btn/btn_voice.gif" alt="음성듣기"/></a>
									<span id="soundPlayer" style="width:0;height:0"></span>-->
									<a href="javascript:chg();"><img src="https://online.olleh.com:8090/images/btn/btn_replace.gif" alt="새로고침"/></a>
							</span>
							<br><br>
							<input type="text"  class="inp" style="width:106px;" id="captchaValue" name="captchaValue" maxlength="5" autocomplete="off"  style="ime-mode:disabled; text-transform:uppercase;">
							</td>
						</tr>
				</table>

				<p class="ex1">
					개정 "주민등록법"에 의해 타인의 주민등록번호를 도용하는 경우 3년 이하의 징역 또는 1천만원 이하의 벌금이 부과될 수 있습니다.<br/>
					<span class="p02">관련법률 : 주민등록법 제 37조(벌칙) 제 9조(시행일 2006.09.24)</span>
				</p>
				<div class="mgb5">
					<p class="p01"style="float:left;">(필수)주민번호 수집,이용에 관한 동의</p>
					<p style="float:right;"><label><input type="checkbox" name="AgreeBaseRegno" align="right"/>동의합니다</label></p>
				</div>
				<div class="agree_content" style="clear:both;">
				<p class="ex1" style="width:100%">ㆍ수집ㆍ 이용 목적<br/>
				가. 온라인신청서 작성을 위한 본인확인/본인인증<br/>
				나. 서비스 가입/변경/해지 처리,AS, 청구서 발송, 물품(단말기/ 경품등)배송,<br/>
					 &nbsp;&nbsp;&nbsp;본인확인,개인식별, 가입의사 확인, 고지사항전달, 서비스제공관련 안내,<br/>
					 &nbsp;&nbsp;&nbsp;명의도용 방지를 위한 등록된 이동 전화로 가입사실 통보,<br/>
					 &nbsp;&nbsp;&nbsp;이용요금 상담, 할인, 청구(개별/통합/합산),고지,결제 및 추심,<br/>
					 &nbsp;&nbsp;&nbsp;이용관련 문의,불만 처리, 멤버십 서비스 제공<br/>
				다.	기타 개인정보취급방침(www.kt.com)에 고지된 수탁자에게 서비스 제공 등<br/>
					 &nbsp;&nbsp;&nbsp;계약의 이행에 필요한  업무의 위탁<br/>
				라. 이동전화서비스의 가입고객을 대상으로 한 본인확인서비스 제공<br/><br/>

				ㆍ 보유기간<br/>
				서비스 가입기간(가입일~해지일)또는 분쟁기간 동안 이용하고 지체 없이<br/>
				파기하며, 요금 정산/요금 과오납 등 분쟁 대비를 위해 해지 후<br/>
				6개월 까지, 요금의 미/과납이 있을 경우와 요금관련 분쟁이<br/>
				계속될 경우에는 해결 시까지 보유<br/>
				(단, 법령에 특별한 규정이 있을 경우 관련 법령에 따라 보관)
				</p>
				</div>

				<p style="width:100%">가입 시 고객님의 주민번호는 필수 수집대상이며, 미동의 시 온라인을 통한 가입신청이 불가함을 양해하여 주시기 바랍니다.</p>
			</div>
		

		<!--하단버튼-->
		<div class="lpu_bottom"><a href="javascript:goNext();" id="aNext"><img src="https://online.olleh.com:8090/images/btn/lpu_btn_nameok.gif" alt="실명인증"/></a></div>
	</div>
	<!--[if lte IE 6.5]><iframe></iframe><![endif]-->
</div>
<!-- //레이어팝업 개인/일반 -->

<!-- 레이어팝업 미성년자 -->
<div id="div_intro2" class="alpa_bg"  style="display:none; margin-left:-250px; width:1000px top:110px !important">

	<div class="lpu_box" style="width:100%">
		<!--LPU타이틀-->
		<div class="lpu_tit">
			<h4><img src="https://online.olleh.com:8090/images/title/lpu_tit_02.gif" alt="미성년자실명인증"/></h4>
			<a href="javascript:fnCloseLayer2();" class="lpu_close"><img src="https://online.olleh.com:8090/images/btn/lpu_btn_close.gif" alt="닫기"/></a>
		</div>

		<!--내용-->
		<div class="lpu_explan" >

			
				<p class="p01 mgb5">미성년자</p>
				<table class="sty_01" style="width:100%;">
					<tr>
						<td class="tit" style="width:30%;">성명</td>
						<td class="cont">
							<input type="text" class="inp" style="width:230px;" name="teenNM" value="" onKeyPress="return specialKey(event, false)" style='ime-mode:active' maxlength="15"/>
						</td>
					</tr>
					<tr><td class="line" colspan="2"></td></tr>
					<tr>
						<td class="tit">주민등록번호</td>
						<td class="cont">
							<input type="tel"  class="inp" style="width:105px;" name="teenBaseRegno1" onKeyUp="javascript:fnNext(event,6,this,teenBaseRegno2);" maxlength="6"/>
							-
							<input type="password" class="inp" style="width:105px;" name="teenBaseRegno2" onKeyUp="javascript:fnNext(event,7,this,agentName);" maxlength="7"/>
						</td>
					</tr>
				</table>

				<p class="ex1">
					개정 "주민등록법"에 의해 타인의 주민등록번호를 도용하는 경우 3년 이하의 징역 또는 1천만원 이하의 벌금이 부과될 수 있습니다.<br/>
					<span class="p02">관련법률 : 주민등록법 제 37조(벌칙) 제 9조(시행일 2006.09.24)</span>
				</p>
			

			<p class="p01 mgt10">법정대리인</p>
			<table class="sty_01" style="width:100%;">
				<tr>
					<td class="tit" style="width:30%;">성명</td>
					<td class="cont">
						<input type="text" class="inp" style="width:230px;" name="agentName" onKeyPress="return specialKey(event, false)" style='ime-mode:active' maxlength="15"/>
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
					<td class="tit">주민등록번호</td>
					<td class="cont">
						<input type="tel"  class="inp" style="width:105px;" name="agentRegno1_1" onKeyUp="javascript:fnNext(event,6,this,agentRegno1_2);" maxlength="6"/>
						-
						<input type="password" class="inp" style="width:105px;" name="agentRegno1_2" onKeyUp="javascript:fnNext(event,7,this,captchaValue_p1);" maxlength="7"/>
					</td>
				</tr>
					<tr><td class="line" colspan="2"></td></tr>
					<tr style="display:;">
						<td class="tit">보안문자</td>
						<td class="cont" colspan="3">
							<p style="border:1px #e1e1e1 solid; float:left; margin-right:10px;"><img id="captchaImg_p1" src="https://online.olleh.com:8090/common/getCaptcha.action" /></p>
							<span id="forHtml5_p1" style="display:none;margin-bottom:2px;">
								 <a href="javascript:loadAudio();"><img src="https://online.olleh.com:8090/images/btn/btn_voice.gif" alt="음성듣기"/></a>
								  <audio controls=controls id="audioCaptcha" style="width:0;height:0"></audio>
								  <a href="javascript:chg_p('p1');"><img src="https://online.olleh.com:8090/images/btn/btn_replace.gif" alt="새로고침"/></a>
							</span>
							<span id="forOldIE_p1" style="display:none;margin-bottom:2px;">
									
									<a href="http://online.olleh.com/_Lib/openWin/playSound.jsp" target="ifrmhidden"><img src="https://online.olleh.com:8090/images/btn/btn_voice.gif" alt="음성듣기"/></a>
									<!-- <a href="javascript:playSound();"><img src="https://online.olleh.com:8090/images/btn/btn_voice.gif" alt="음성듣기"/></a>
									<span id="soundPlayer" style="width:0;height:0"></span>-->
									<a href="javascript:chg_p('p1');"><img src="https://online.olleh.com:8090/images/btn/btn_replace.gif" alt="새로고침"/></a>
							</span>
							<br><br>
							<input type="text"  class="inp" style="width:106px;" id="captchaValue_p1" name="captchaValue_p1" maxlength="5" autocomplete="off"  style="ime-mode:disabled; text-transform:uppercase;">
							</td>
						</tr>
			</table>

			<p class="ex1">
				법정대리인 정보는<span class="p02"> 부,모, 후견인(기본증명서에 등재) 정보를 </span>입력해주시면 됩니다.
			</p>
			<div class="mgb5">
				<p class="p01"style="float:left;">(필수)주민번호 수집,이용에 관한 동의</p>
				<p style="float:right;"><label><input type="checkbox" name="AgreeBaseRegno2" align="right">동의합니다</label></p>
			</div>
			<div class="agree_content" style="clear:both;">
			<p class="ex1" style="width:100%">ㆍ수집ㆍ 이용 목적<br/>
				가. 온라인신청서 작성을 위한 본인확인/본인인증<br/>
				나. 서비스 가입/변경/해지 처리,AS, 청구서 발송, 물품(단말기/ 경품등)배송,<br/>
					 &nbsp;&nbsp;&nbsp;본인확인,개인식별, 가입의사 확인, 고지사항전달, 서비스제공관련 안내,<br/>
					 &nbsp;&nbsp;&nbsp;명의도용 방지를 위한 등록된 이동 전화로 가입사실 통보,<br/>
					 &nbsp;&nbsp;&nbsp;이용요금 상담, 할인, 청구(개별/통합/합산),고지,결제 및 추심,<br/>
					 &nbsp;&nbsp;&nbsp;이용관련 문의,불만 처리, 멤버십 서비스 제공<br/>
				다.	기타 개인정보취급방침(www.kt.com)에 고지된 수탁자에게 서비스 제공 등<br/>
					 &nbsp;&nbsp;&nbsp;계약의 이행에 필요한  업무의 위탁<br/>
				라. 이동전화서비스의 가입고객을 대상으로 한 본인확인서비스 제공<br/><br/>

				ㆍ 보유기간<br/>
				서비스 가입기간(가입일~해지일)또는 분쟁기간 동안 이용하고 지체 없이<br/>
				파기하며, 요금 정산/요금 과오납 등 분쟁 대비를 위해 해지 후<br/>
				6개월 까지, 요금의 미/과납이 있을 경우와 요금관련 분쟁이<br/>
				계속될 경우에는 해결 시까지 보유<br/>
				(단, 법령에 특별한 규정이 있을 경우 관련 법령에 따라 보관)
				</p>
			</div>
			<p style="width:100%">가입 시 고객님의 주민번호는 필수 수집대상이며, 미동의 시 온라인을 통한 가입신청이 불가함을 양해하여 주시기 바랍니다.</p>
		</div>

		<!--하단버튼-->
		<div class="lpu_bottom"><a href="javascript:goNext2();" id="aNext2"><img src="https://online.olleh.com:8090/images/btn/lpu_btn_nameok.gif" alt="실명인증"/></a></div>
	</div>
	<!--[if lte IE 6.5]><iframe></iframe><![endif]-->
</div>
<!-- //레이어팝업 미성년자 -->



<!-- 레이어팝업 법인([DR-2014-36637] 개인정보활용동의서 주민번호 수집/이용 제한) -->
<div id="div_intro3" class="alpa_bg" style="display:none; margin-left:-250px; width:1000px top:110px !important">

	<div class="lpu_box" style="width:100%">
		<!--LPU타이틀-->
		<div class="lpu_tit">
			<h4><img src="https://online.olleh.com:8090/images/title/lpu_tit_03.gif" alt="법인 실명인증"/></h4>
			<a href="javascript:fnCloseLayer3();" class="lpu_close"><img src="https://online.olleh.com:8090/images/btn/lpu_btn_close.gif" alt="닫기"/></a>
		</div>

		<!--내용-->
		<div class="lpu_explan" >

			<p class="p01 mgb5">법인 </p>
			<table class="sty_01" style="width:100%">
				<tr>
					<td class="tit" style="width:30%;">법인명</td>
					<td class="cont">
						<input type="text" class="inp" style="width:230px;" name="bizrName" onKeyPress="return specialKey(event, false)" style='ime-mode:active' maxlength="30" />
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
					<td class="tit">법인번호</td>
					<td class="cont">
						<input type="tel"  class="inp" style="width:105px;" name="crprNo1" onKeyUp="javascript:fnNext(event,6,this,crprNo2);" maxlength="6" />
						-
						<input type="password" class="inp" style="width:105px;" name="crprNo2" onKeyUp="javascript:fnNext(event,7,this,bizrRegno2_1);" maxlength="7" />
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
					<td class="tit">사업자번호</td>
					<td class="cont">
						<input type="tel"  class="inp" style="width:50px;" name="bizrRegno2_1" onKeyUp="javascript:fnNext(event,3,this,bizrRegno2_2);" maxlength="3"/>
						-
						<input type="tel"  class="inp" style="width:50px;" name="bizrRegno2_2" onKeyUp="javascript:fnNext(event,2,this,bizrRegno2_3);" maxlength="2"/>
						-
						<input type="tel"  class="inp" style="width:90px;" name="bizrRegno2_3" onKeyUp="javascript:fnNext(event,5,this,bizrBaseNM);" maxlength="5"/>
					</td>
				</tr>
			</table>

			<p class="p01 mgt20">대리인</p>
			<table class="sty_01" style="width:100%">
				<tr>
					<td class="tit" style="width:30%;">성명</td>
					<td class="cont">
						<input type="text" class="inp" style="width:230px;" name="bizrBaseNM"  type="text" onKeyPress="return specialKey(event, false)" style='ime-mode:active' maxlength="15"/>
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
					<td class="tit">생년월일(8자리)</td>
					<td class="cont">
						<input type="tel"  class="inp" style="width:105px;" name="bizrBaseRegno1" onKeyUp="javascript:fnNext(event,8,this,bizrBaseSexInfo);" maxlength="8"  />
						<input type="hidden" name="bizrBaseRegno2">
						<select id="bizrBaseSexInfo" name="bizrBaseSexInfo">
							<option value="">성별</option>
							<option value="M">남</option>
							<option value="F">여</option>
						</select>
					</td>
				</tr>
			</table>

		</div>

		<!--하단버튼-->
		<div class="lpu_bottom"><a href="javascript:goNext3();" id="aNext3"><img src="https://online.olleh.com:8090/images/btn/lpu_btn_nameok.gif" alt="실명인증"/></a></div>
	</div>
	<!--[if lte IE 6.5]><iframe></iframe><![endif]-->
</div>
<!-- //레이어팝업 법인 -->





<!-- 레이어팝업 외국인 -->
<div id="div_intro4" class="alpa_bg" style="display:none; margin-left:-250px; width:1000px top:110px !important">
	<div class="lpu_box" style="width:100%">
		<!--LPU타이틀-->
		<div class="lpu_tit">
			<h4><img src="https://online.olleh.com:8090/images/foreigner/title/lpu_tit_04.gif" alt="Alien Registration Check"/></h4>
			<a href="javascript:fnCloseLayer4();" class="lpu_close"><img src="https://online.olleh.com:8090/images/foreigner/btn/lpu_btn_close.gif" alt="Close"/></a>
		</div>

		<!--내용-->
		<div class="lpu_explan" >

			<table class="sty_01" style="width:440px">
				<tr>
					<td class="tit" style="width:120px;">Name<br/><span class="wn" style="letter-spacing:-1;">(Korean/English, in caps)</span></td>
					<td class="cont">
						<input type="text" class="inp" style="width:230px;" name="foreignBaseNM_1"  onKeyPress="return specialKey(event, false)" style='ime-mode:active' maxlength="40"  />
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
					<td class="tit">Alien Registration<br>Number</td>
					<td class="cont">
						<input type="tel"  class="inp" style="width:105px;" name="foreignBaseRegno1" onKeyUp="javascript:fnNext(event,6,this,foreignBaseRegno2);" maxlength="6" />
						-
						<input type="password" class="inp" style="width:105px;" name="foreignBaseRegno2" onKeyUp="javascript:fnNext(event,7,this,National_1);" maxlength="7" />
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
					<td class="tit">Nationality</td>
					<td class="cont">
						<select name="National_1" style="width:100%;">
							<option value="J001">아루바 - Aruba</option>
							<option value="J002">아프가니스탄 - Afghanistan</option>
							<option value="J003">앙골라 - Angola</option>
							<option value="J004">앵귈라 - Anguilla</option>
							<option value="J005">올란드 제도 - Aland Islands</option>
							<option value="J006">알바니아 - Albania</option>
							<option value="J007">안도라 - Andorra</option>
							<option value="J008">아랍에미리트 연합 - United Arab Emirates</option>
							<option value="J009">아르헨티나 - Argentina</option>
							<option value="J010">아르메니아 - Armenia</option>
							<option value="J011">아메리칸 사모아 - American Samoa</option>
							<option value="J012">남극 - Antarctica</option>
							<option value="J013">프랑스령 남부지역 - French Southern Territories</option>
							<option value="J014">안티구아 바부다 - Antigua and Barbuda</option>
							<option value="J015">오스트레일리아 - Australia</option>
							<option value="J016">오스트리아 - Austria</option>
							<option value="J017">아제르바이잔 - Azerbaijan</option>
							<option value="J018">부룬디 - Burundi</option>
							<option value="J019">벨기에 - Belgium</option>
							<option value="J020">베냉 - Benin</option>
							<option value="J021">부르키나 파소 - Burkina Faso</option>
							<option value="J022">방글라데시 - Bangladesh</option>
							<option value="J023">불가리아 - Bulgaria</option>
							<option value="J024">바레인 - Bahrain</option>
							<option value="J025">바하마 - Bahamas</option>
							<option value="J026">보스니아 헤르체고비나 - Bosnia and Herzegovina</option>
							<option value="J027">벨라루스 - Belarus</option>
							<option value="J028">벨리즈 - Belize</option>
							<option value="J029">버뮤다 - Bermuda</option>
							<option value="J030">볼리비아 - Bolivia, Plurinational State of</option>
							<option value="J031">브라질 - Brazil</option>
							<option value="J032">바베이도스 - Barbados</option>
							<option value="J033">브루나이 - Brunei Darussalam</option>
							<option value="J034">부탄 - Bhutan</option>
							<option value="J035">부베 제도 - Bouvet Island</option>
							<option value="J036">보츠와나 - Botswana</option>
							<option value="J037">중앙 아프리카 공화국 - Central African Republic</option>
							<option value="J038">캐나다 - Canada</option>
							<option value="J039">코코스 제도 - Cocos (Keeling) Islands</option>
							<option value="J040">스위스 - Switzerland</option>
							<option value="J041">칠레 - Chile</option>
							<option value="J042">중국 - China</option>
							<option value="J043">코트디 부아르 - Ivory Coast</option>
							<option value="J044">카메룬 - Cameroon</option>
							<option value="J045">콩고 민주 공화국 - Congo, Democratic Republic of the</option>
							<option value="J046">콩고 - Congo, Republic of the</option>
							<option value="J047">쿡 제도 - Cook Islands</option>
							<option value="J048">콜롬비아 - Colombia</option>
							<option value="J049">코모로 - Comoros</option>
							<option value="J050">카보 베르데 - Cape Verde</option>
							<option value="J051">코스타 리카 - Costa Rica</option>
							<option value="J052">쿠바 - Cuba</option>
							<option value="J053">크리스마스 섬 - Christmas Island</option>
							<option value="J054">케이맨 제도 - Cayman Islands</option>
							<option value="J055">키프로스 - Cyprus</option>
							<option value="J056">체코 - Czech Republic</option>
							<option value="J057">독일 - Germany</option>
							<option value="J058">지부티 - Djibouti</option>
							<option value="J059">도미니카 - Dominica</option>
							<option value="J060">덴마크 - Denmark</option>
							<option value="J061">도미니카 공화국 - Dominican Republic</option>
							<option value="J062">알제리 - Algeria</option>
							<option value="J063">에콰도르 - Ecuador</option>
							<option value="J064">이집트 - Egypt</option>
							<option value="J065">에리트레아 - Eritrea</option>
							<option value="J066">웨스턴 사하라 - Western Sahara</option>
							<option value="J067">스페인 - Spain</option>
							<option value="J068">에스토니아 - Estonia</option>
							<option value="J069">에티오피아 - Ethiopia</option>
							<option value="J070">핀란드 - Finland</option>
							<option value="J071">피지 - Fiji</option>
							<option value="J072">포클랜드 제도 - Falkland Islands</option>
							<option value="J073">프랑스 - France</option>
							<option value="J074">페로 제도 - Faroe Islands</option>
							<option value="J075">미크로네시아 연방 - Micronesia, Federated States of</option>
							<option value="J076">가봉 - Gabon</option>
							<option value="J077">영국 - United Kingdom</option>
							<option value="J078">조지아 - Georgia</option>
							<option value="J079">건지 섬 - Guernsey</option>
							<option value="J080">가나 - Ghana</option>
							<option value="J081">지브롤터 - Gibraltar</option>
							<option value="J082">기니 - Guinea</option>
							<option value="J083">과들루프 - Guadeloupe</option>
							<option value="J084">감비아 - Gambia</option>
							<option value="J085">기니 비사우 - Guinea-Bissau</option>
							<option value="J086">적도 기니 - Equatorial Guinea</option>
							<option value="J087">그리스 - Greece</option>
							<option value="J088">그레나다 - Grenada</option>
							<option value="J089">그린란드 - Greenland</option>
							<option value="J090">과테말라 - Guatemala</option>
							<option value="J091">프랑스령 기아나 - French Guiana</option>
							<option value="J092">괌 - Guam</option>
							<option value="J093">가이아나 - Guyana</option>
							<option value="J094">홍콩 - Hong Kong</option>
							<option value="J095">허드 맥도널드 제도 - Heard Island and McDonald Islands</option>
							<option value="J096">온두라스 - Honduras</option>
							<option value="J097">크로아티아 - Croatia</option>
							<option value="J098">아이티 - Haiti</option>
							<option value="J099">헝가리 - Hungary</option>
							<option value="J100">인도네시아 - Indonesia</option>
							<option value="J101">맨 섬 - Isle of Man</option>
							<option value="J102">인도 - India</option>
							<option value="J103">영국령 인도양 지역 - British Indian Ocean Territory</option>
							<option value="J104">아일랜드 - Ireland</option>
							<option value="J105">이란 - Iran, Islamic Republic of</option>
							<option value="J106">이라크 - Iraq</option>
							<option value="J107">아이슬란드 - Iceland</option>
							<option value="J108">이스라엘 - Israel</option>
							<option value="J109">이탈리아 - Italy</option>
							<option value="J110">자메이카 - Jamaica</option>
							<option value="J111">저지 섬 - Jersey</option>
							<option value="J112">요르단 - Jordan</option>
							<option value="J113">일본 - Japan</option>
							<option value="J114">카자흐스탄 - Kazakhstan</option>
							<option value="J115">케냐 - Kenya</option>
							<option value="J116">키르기스스탄 - Kyrgyzstan</option>
							<option value="J117">캄보디아 - Cambodia</option>
							<option value="J118">키리바시 - Kiribati</option>
							<option value="J119">세인트 키츠 네비스 - Saint Kitts and Nevis</option>
							<option value="J121">쿠웨이트 - Kuwait</option>
							<option value="J122">라오스 - Lao People's Democratic Republic</option>
							<option value="J123">레바논 - Lebanon</option>
							<option value="J124">라이베리아 - Liberia</option>
							<option value="J125">리비아 - Libyan Arab Jamahiriya</option>
							<option value="J126">세인트 루시아 - Saint Lucia</option>
							<option value="J127">리히텐슈타인 - Liechtenstein</option>
							<option value="J128">스리랑카 - Sri Lanka</option>
							<option value="J129">레소토 - Lesotho</option>
							<option value="J130">리투아니아 - Lithuania</option>
							<option value="J131">룩셈부르크 - Luxembourg</option>
							<option value="J132">라트비아 - Latvia</option>
							<option value="J133">마카오 - Macao</option>
							<option value="J134">모로코 - Morocco</option>
							<option value="J135">모나코 - Monaco</option>
							<option value="J136">몰도바 - Moldova, Republic of</option>
							<option value="J137">마다가스카르 - Madagascar</option>
							<option value="J138">몰디브 - Maldives</option>
							<option value="J139">멕시코 - Mexico</option>
							<option value="J140">마셜 제도 - Marshall Islands</option>
							<option value="J141">마케도니아 공화국 - Macedonia, Republic of</option>
							<option value="J142">말리 - Mali</option>
							<option value="J143">몰타 - Malta</option>
							<option value="J144">미얀마 - Myanmar</option>
							<option value="J145">몬테네그로 - Montenegro</option>
							<option value="J146">몽골 - Mongolia</option>
							<option value="J147">북 마리아나 제도 - Northern Mariana Islands</option>
							<option value="J148">모잠비크 - Mozambique</option>
							<option value="J149">모리타니 - Mauritania</option>
							<option value="J150">몬트세랫 - Montserrat</option>
							<option value="J151">마르티니크 - Martinique</option>
							<option value="J152">모리셔스 - Mauritius</option>
							<option value="J153">말라위 - Malawi</option>
							<option value="J154">말레이시아 - Malaysia</option>
							<option value="J155">마요트 - Mayotte</option>
							<option value="J156">나미비아 - Namibia</option>
							<option value="J157">뉴 벨칼레도니아 - New Caledonia</option>
							<option value="J158">니제르 - Niger</option>
							<option value="J159">노퍽 섬 - Norfolk Island</option>
							<option value="J160">나이지리아 - Nigeria</option>
							<option value="J161">니카라과 - Nicaragua</option>
							<option value="J162">니우에 - Niue</option>
							<option value="J163">네덜란드 - Netherlands</option>
							<option value="J164">노르웨이 - Norway</option>
							<option value="J165">네팔 - Nepal</option>
							<option value="J166">나우루 - Nauru</option>
							<option value="J167">뉴질랜드 - New Zealand</option>
							<option value="J168">오만 - Oman</option>
							<option value="J169">파키스탄 - Pakistan</option>
							<option value="J170">파나마 - Panama</option>
							<option value="J171">핏케언 제도 - Pitcairn Islands</option>
							<option value="J172">페루 - Peru</option>
							<option value="J173">필리핀 - Philippines</option>
							<option value="J174">팔라우 - Palau</option>
							<option value="J175">파푸아 뉴기니 - Papua New Guinea</option>
							<option value="J176">폴란드 - Poland</option>
							<option value="J177">푸에르토리코 - Puerto Rico</option>
							<option value="J178">조선민주주의인민공화국 - Korea, Democratic People's Republic of</option>
							<option value="J179">포르투갈 - Portugal</option>
							<option value="J180">파라과이 - Paraguay</option>
							<option value="J181">팔레스타인 - Palestine</option>
							<option value="J182">프랑스령 폴리네시아 - French Polynesia</option>
							<option value="J183">카타르 - Qatar</option>
							<option value="J184">레위니옹 - Reunion</option>
							<option value="J185">루마니아 - Romania</option>
							<option value="J186">러시아 - Russia</option>
							<option value="J187">르완다 - Rwanda</option>
							<option value="J188">사우디아라비아 - Saudi Arabia</option>
							<option value="J189">수단 - Sudan</option>
							<option value="J190">세네갈 - Senegal</option>
							<option value="J191">싱가포르 - Singapore</option>
							<option value="J192">사우스조지아 사우스샌드위치 제도 - South Georgia and the South Sandwich Islands</option>
							<option value="J193">세인트헬레나 - Saint Helena, Ascension and Tristan da Cunha</option>
							<option value="J194">스발바르 얀마옌 - Svalbard and Jan Mayen</option>
							<option value="J195">솔로몬 제도 - Solomon Islands</option>
							<option value="J196">시에라리온 - Sierra Leone</option>
							<option value="J197">엘살바도르 - El Salvador</option>
							<option value="J198">산마리노 - San Marino</option>
							<option value="J199">소말리아 - Somalia</option>
							<option value="J200">생피에르 미클롱 - Saint Pierre and Miquelon</option>
							<option value="J201">세르비아 - Serbia</option>
							<option value="J202">상투메 프린시페 - Sao Tome and Principe</option>
							<option value="J203">수리남 - Suriname</option>
							<option value="J204">슬로바키아 - Slovakia</option>
							<option value="J205">슬로베니아 - Slovenia</option>
							<option value="J206">스웨덴 - Sweden</option>
							<option value="J207">스와질란드 - Swaziland</option>
							<option value="J208">세이셸 - Seychelles</option>
							<option value="J209">시리아 - Syria</option>
							<option value="J210">터크스 케이커스 제도 - Turks and Caicos Islands</option>
							<option value="J211">차드 - Chad</option>
							<option value="J212">토고 - Togo</option>
							<option value="J213">타이 - Thailand</option>
							<option value="J214">타지키스탄 - Tajikistan</option>
							<option value="J215">토켈라우 제도 - Tokelau</option>
							<option value="J216">투르크메니스탄 - Turkmenistan</option>
							<option value="J217">동티모르 - Timor-Leste</option>
							<option value="J218">통가 - Tonga</option>
							<option value="J219">트리니다드 토바고 - Trinidad and Tobago</option>
							<option value="J220">튀니지 - Tunisia</option>
							<option value="J221">터키 - Turkey</option>
							<option value="J222">투발루 - Tuvalu</option>
							<option value="J223">타이완 - Taiwan</option>
							<option value="J224">탄자니아 - Tanzania, United Republic of</option>
							<option value="J225">우간다 - Uganda</option>
							<option value="J226">우크라이나 - Ukraine</option>
							<option value="J227">미국령 군소 제도 - United States Minor Outlying Islands</option>
							<option value="J228">우루과이 - Uruguay</option>
							<option value="J229">미국 - United States of America</option>
							<option value="J230">우즈베키스탄 - Uzbekistan</option>
							<option value="J231">바티칸 시국 - Holy See (Vatican City State)</option>
							<option value="J232">세인트빈센트 그레나딘 - Saint Vincent and the Grenadines</option>
							<option value="J233">베네수엘라 - Venezuela</option>
							<option value="J234">영국령 버진아일랜드 - Virgin Islands, British</option>
							<option value="J235">미국령 버진아일랜드 - Virgin Islands, U.S.</option>
							<option value="J236">베트남 - Vietnam</option>
							<option value="J237">바누아투 - Vanuatu</option>
							<option value="J238">왈리스 퓌튀나 - Wallis and Futuna</option>
							<option value="J239">사모아 - Samoa</option>
							<option value="J240">예멘 - Yemen</option>
							<option value="J241">남아프리카 공화국 - South Africa</option>
							<option value="J242">잠비아 - Zambia</option>
							<option value="J243">짐바브웨 - Zimbabwe</option>
							<option value="J244">세인트 마틴 섬 - Saint Martin</option>
							<option value="J245">퀴라소 - Curacao</option>
							<option value="J246">세인트 유스타티우스 섬 - Bonaire, Saint Eustatius and Saba</option>
							<option value="J248">네덜란드령 안틸레스 - Netherlands Antilles</option>
							<option value="J249">생바르텔레미 - Saint Barthelemy</option>
							<option value="J250">생마르탱 - Saint Martin</option>
							<option value="J247">무국적 - Stateless</option>
							<option value="J251">기타 - Etc</option>
						</select>
					</td>
				</tr>
			</table>
			<p class="ex1" style="letter-spacing:-0.05em;">
				<span class="p02">You must be at least 20 years of age in order to sign up for service from kt.</span>
			</p>


			<!--  <div style="width:100%">
			<p class="p01 mgb5">■(필수) 주민번호 수집  이용에  관한 동의</p>
			<p class="ex1">본인은 다음의 내용을 읽어보았으며, 이를 이해하여 동의합니다. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="AgreeBaseRegno4"/>동의</p>

			<p class="sty_01" style="width:100%">ㆍ수집ㆍ 이용 목적<br/>
			가. 온라인신청서 작성을 위한 본인확인/본인인증<br/>
			나. 서비스 가입/변경/해지 처리,AS, 청구서 발송, 물품(단말기/ 경품등)배송, 본인<br/>
				 &nbsp;&nbsp;&nbsp;확인,개인식별, 가입의사 확인, 고지사항전달,서비스제공관련 안내, 명의도용 방지를<br/>
				 &nbsp;&nbsp;&nbsp;위한 등록된 이동 전화로 가입사실 통보, 이용요금 상담, 할인, 청구(개별/통합/합산),<br/>
				 &nbsp;&nbsp;&nbsp;고지,결제 및 추심,이용관련 문의,불만 처리, 멤버십 서비스 제공<br/>
			다.	기타 개인정보취급방침(www.kt.com)에 고지된 수탁자에게 서비스 제공 등 계약의<br/>
				 &nbsp;&nbsp;&nbsp;이행에 필요한  업무의 위탁<br/>
			라. 이동전화서비스의 가입고객을 대상으로 한 	본인확인서비스 제공<br/><br/>

			ㆍ 보유기간<br/>
			서비스 가입기간(가입일~해지일)또는 분쟁기간 동안 이용하고 지체 없이 파기하며, 요금<br/>
			정산/요금 과오납 등 분쟁 대비를 위해 해지 후 6개월 까지, 요금의 미/과납이 있을 경우 <br/>
			와 요금관련 분쟁이 계속될 경우에는 해결 시까지 보유<br/>
			(단, 법령에 특별한 규정이 있을 경우 관련 법령에 따라 보관)
			</p>
			<p style="width:100%">가입 시 고객님의 주민번호는 필수 수집대상이며, 미동의 시 온라인을 통한 가입신청이 불가함을 양해하여 주시기 바랍니다.</p>

			</div>
			-->
		</div>

		<!--하단버튼-->
		<div class="lpu_bottom"><a href="javascript:goNext4();"><img src="https://online.olleh.com:8090/images/foreigner/btn/lpu_btn_nameok.gif" alt="Verify"/></a></div>
	</div>
	<!--[if lte IE 6.5]><iframe></iframe><![endif]-->
</div>
<!-- //레이어팝업 외국인-->

<!-- 레이어팝업 외국인한글 -->
<div id="div_intro7" class="alpa_bg" style="display:none; margin-left:-250px; width:1000px top:110px !important">
	<div class="lpu_box" style="width:100%">
		<!--LPU타이틀-->
		<div class="lpu_tit" style="width:100%">
			<h4><img src="https://online.olleh.com:8090/images/title/kor_tit_01.gif" alt="외국인 실명인증"/></h4>
			<a href="javascript:fnCloseLayer7();" class="lpu_close"><img src="https://online.olleh.com:8090/images/btn/lpu_btn_close.gif" alt="Close"/></a>
		</div>

		<!--내용-->
		<div class="lpu_explan" >

			<table class="sty_01" style="width:440px">
				<tr>
					<td class="tit" style="width:120px;">성명<br/><span class="wn" style="letter-spacing:-1;">(한글 또는 영문 대문자)</span></td>
					<td class="cont">
						<input type="text" class="inp" style="width:230px;" name="foreignBaseNM_kor"  onKeyPress="return specialKey(event, false)" style='ime-mode:active' maxlength="40"  />
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
					<td class="tit">외국인등록번호</td>
					<td class="cont">
						<input type="tel"  class="inp" style="width:105px;" name="foreignBaseRegno_kor1" onKeyUp="javascript:fnNext(event,6,this,foreignBaseRegno_kor2);" maxlength="6" />
						-
						<input type="password" class="inp" style="width:105px;" name="foreignBaseRegno_kor2" onKeyUp="javascript:fnNext(event,7,this,National_kor);" maxlength="7" />
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
					<td class="tit">국적</td>
					<td class="cont">
						<select name="National_kor" style="width:100%;">
							<option value="J001">아루바 - Aruba</option>
							<option value="J002">아프가니스탄 - Afghanistan</option>
							<option value="J003">앙골라 - Angola</option>
							<option value="J004">앵귈라 - Anguilla</option>
							<option value="J005">올란드 제도 - Aland Islands</option>
							<option value="J006">알바니아 - Albania</option>
							<option value="J007">안도라 - Andorra</option>
							<option value="J008">아랍에미리트 연합 - United Arab Emirates</option>
							<option value="J009">아르헨티나 - Argentina</option>
							<option value="J010">아르메니아 - Armenia</option>
							<option value="J011">아메리칸 사모아 - American Samoa</option>
							<option value="J012">남극 - Antarctica</option>
							<option value="J013">프랑스령 남부지역 - <br>French Southern Territories</option>
							<option value="J014">안티구아 바부다 - Antigua and Barbuda</option>
							<option value="J015">오스트레일리아 - Australia</option>
							<option value="J016">오스트리아 - Austria</option>
							<option value="J017">아제르바이잔 - Azerbaijan</option>
							<option value="J018">부룬디 - Burundi</option>
							<option value="J019">벨기에 - Belgium</option>
							<option value="J020">베냉 - Benin</option>
							<option value="J021">부르키나 파소 - Burkina Faso</option>
							<option value="J022">방글라데시 - Bangladesh</option>
							<option value="J023">불가리아 - Bulgaria</option>
							<option value="J024">바레인 - Bahrain</option>
							<option value="J025">바하마 - Bahamas</option>
							<option value="J026">보스니아 헤르체고비나 - Bosnia and Herzegovina</option>
							<option value="J027">벨라루스 - Belarus</option>
							<option value="J028">벨리즈 - Belize</option>
							<option value="J029">버뮤다 - Bermuda</option>
							<option value="J030">볼리비아 - Bolivia, Plurinational State of</option>
							<option value="J031">브라질 - Brazil</option>
							<option value="J032">바베이도스 - Barbados</option>
							<option value="J033">브루나이 - Brunei Darussalam</option>
							<option value="J034">부탄 - Bhutan</option>
							<option value="J035">부베 제도 - Bouvet Island</option>
							<option value="J036">보츠와나 - Botswana</option>
							<option value="J037">중앙 아프리카 공화국 - Central African Republic</option>
							<option value="J038">캐나다 - Canada</option>
							<option value="J039">코코스 제도 - Cocos (Keeling) Islands</option>
							<option value="J040">스위스 - Switzerland</option>
							<option value="J041">칠레 - Chile</option>
							<option value="J042">중국 - China</option>
							<option value="J043">코트디 부아르 - Ivory Coast</option>
							<option value="J044">카메룬 - Cameroon</option>
							<option value="J045">콩고 민주 공화국 - Congo, Democratic Republic of the</option>
							<option value="J046">콩고 - Congo, Republic of the</option>
							<option value="J047">쿡 제도 - Cook Islands</option>
							<option value="J048">콜롬비아 - Colombia</option>
							<option value="J049">코모로 - Comoros</option>
							<option value="J050">카보 베르데 - Cape Verde</option>
							<option value="J051">코스타 리카 - Costa Rica</option>
							<option value="J052">쿠바 - Cuba</option>
							<option value="J053">크리스마스 섬 - Christmas Island</option>
							<option value="J054">케이맨 제도 - Cayman Islands</option>
							<option value="J055">키프로스 - Cyprus</option>
							<option value="J056">체코 - Czech Republic</option>
							<option value="J057">독일 - Germany</option>
							<option value="J058">지부티 - Djibouti</option>
							<option value="J059">도미니카 - Dominica</option>
							<option value="J060">덴마크 - Denmark</option>
							<option value="J061">도미니카 공화국 - Dominican Republic</option>
							<option value="J062">알제리 - Algeria</option>
							<option value="J063">에콰도르 - Ecuador</option>
							<option value="J064">이집트 - Egypt</option>
							<option value="J065">에리트레아 - Eritrea</option>
							<option value="J066">웨스턴 사하라 - Western Sahara</option>
							<option value="J067">스페인 - Spain</option>
							<option value="J068">에스토니아 - Estonia</option>
							<option value="J069">에티오피아 - Ethiopia</option>
							<option value="J070">핀란드 - Finland</option>
							<option value="J071">피지 - Fiji</option>
							<option value="J072">포클랜드 제도 - Falkland Islands</option>
							<option value="J073">프랑스 - France</option>
							<option value="J074">페로 제도 - Faroe Islands</option>
							<option value="J075">미크로네시아 연방 - Micronesia, Federated States of</option>
							<option value="J076">가봉 - Gabon</option>
							<option value="J077">영국 - United Kingdom</option>
							<option value="J078">조지아 - Georgia</option>
							<option value="J079">건지 섬 - Guernsey</option>
							<option value="J080">가나 - Ghana</option>
							<option value="J081">지브롤터 - Gibraltar</option>
							<option value="J082">기니 - Guinea</option>
							<option value="J083">과들루프 - Guadeloupe</option>
							<option value="J084">감비아 - Gambia</option>
							<option value="J085">기니 비사우 - Guinea-Bissau</option>
							<option value="J086">적도 기니 - Equatorial Guinea</option>
							<option value="J087">그리스 - Greece</option>
							<option value="J088">그레나다 - Grenada</option>
							<option value="J089">그린란드 - Greenland</option>
							<option value="J090">과테말라 - Guatemala</option>
							<option value="J091">프랑스령 기아나 - French Guiana</option>
							<option value="J092">괌 - Guam</option>
							<option value="J093">가이아나 - Guyana</option>
							<option value="J094">홍콩 - Hong Kong</option>
							<option value="J095">허드 맥도널드 제도 - Heard Island and McDonald Islands</option>
							<option value="J096">온두라스 - Honduras</option>
							<option value="J097">크로아티아 - Croatia</option>
							<option value="J098">아이티 - Haiti</option>
							<option value="J099">헝가리 - Hungary</option>
							<option value="J100">인도네시아 - Indonesia</option>
							<option value="J101">맨 섬 - Isle of Man</option>
							<option value="J102">인도 - India</option>
							<option value="J103">영국령 인도양 지역 - British Indian Ocean Territory</option>
							<option value="J104">아일랜드 - Ireland</option>
							<option value="J105">이란 - Iran, Islamic Republic of</option>
							<option value="J106">이라크 - Iraq</option>
							<option value="J107">아이슬란드 - Iceland</option>
							<option value="J108">이스라엘 - Israel</option>
							<option value="J109">이탈리아 - Italy</option>
							<option value="J110">자메이카 - Jamaica</option>
							<option value="J111">저지 섬 - Jersey</option>
							<option value="J112">요르단 - Jordan</option>
							<option value="J113">일본 - Japan</option>
							<option value="J114">카자흐스탄 - Kazakhstan</option>
							<option value="J115">케냐 - Kenya</option>
							<option value="J116">키르기스스탄 - Kyrgyzstan</option>
							<option value="J117">캄보디아 - Cambodia</option>
							<option value="J118">키리바시 - Kiribati</option>
							<option value="J119">세인트 키츠 네비스 - Saint Kitts and Nevis</option>
							<option value="J121">쿠웨이트 - Kuwait</option>
							<option value="J122">라오스 - Lao People's Democratic Republic</option>
							<option value="J123">레바논 - Lebanon</option>
							<option value="J124">라이베리아 - Liberia</option>
							<option value="J125">리비아 - Libyan Arab Jamahiriya</option>
							<option value="J126">세인트 루시아 - Saint Lucia</option>
							<option value="J127">리히텐슈타인 - Liechtenstein</option>
							<option value="J128">스리랑카 - Sri Lanka</option>
							<option value="J129">레소토 - Lesotho</option>
							<option value="J130">리투아니아 - Lithuania</option>
							<option value="J131">룩셈부르크 - Luxembourg</option>
							<option value="J132">라트비아 - Latvia</option>
							<option value="J133">마카오 - Macao</option>
							<option value="J134">모로코 - Morocco</option>
							<option value="J135">모나코 - Monaco</option>
							<option value="J136">몰도바 - Moldova, Republic of</option>
							<option value="J137">마다가스카르 - Madagascar</option>
							<option value="J138">몰디브 - Maldives</option>
							<option value="J139">멕시코 - Mexico</option>
							<option value="J140">마셜 제도 - Marshall Islands</option>
							<option value="J141">마케도니아 공화국 - Macedonia, Republic of</option>
							<option value="J142">말리 - Mali</option>
							<option value="J143">몰타 - Malta</option>
							<option value="J144">미얀마 - Myanmar</option>
							<option value="J145">몬테네그로 - Montenegro</option>
							<option value="J146">몽골 - Mongolia</option>
							<option value="J147">북 마리아나 제도 - Northern Mariana Islands</option>
							<option value="J148">모잠비크 - Mozambique</option>
							<option value="J149">모리타니 - Mauritania</option>
							<option value="J150">몬트세랫 - Montserrat</option>
							<option value="J151">마르티니크 - Martinique</option>
							<option value="J152">모리셔스 - Mauritius</option>
							<option value="J153">말라위 - Malawi</option>
							<option value="J154">말레이시아 - Malaysia</option>
							<option value="J155">마요트 - Mayotte</option>
							<option value="J156">나미비아 - Namibia</option>
							<option value="J157">뉴 벨칼레도니아 - New Caledonia</option>
							<option value="J158">니제르 - Niger</option>
							<option value="J159">노퍽 섬 - Norfolk Island</option>
							<option value="J160">나이지리아 - Nigeria</option>
							<option value="J161">니카라과 - Nicaragua</option>
							<option value="J162">니우에 - Niue</option>
							<option value="J163">네덜란드 - Netherlands</option>
							<option value="J164">노르웨이 - Norway</option>
							<option value="J165">네팔 - Nepal</option>
							<option value="J166">나우루 - Nauru</option>
							<option value="J167">뉴질랜드 - New Zealand</option>
							<option value="J168">오만 - Oman</option>
							<option value="J169">파키스탄 - Pakistan</option>
							<option value="J170">파나마 - Panama</option>
							<option value="J171">핏케언 제도 - Pitcairn Islands</option>
							<option value="J172">페루 - Peru</option>
							<option value="J173">필리핀 - Philippines</option>
							<option value="J174">팔라우 - Palau</option>
							<option value="J175">파푸아 뉴기니 - Papua New Guinea</option>
							<option value="J176">폴란드 - Poland</option>
							<option value="J177">푸에르토리코 - Puerto Rico</option>
							<option value="J178">조선민주주의인민공화국 - Korea, Democratic People's Republic of</option>
							<option value="J179">포르투갈 - Portugal</option>
							<option value="J180">파라과이 - Paraguay</option>
							<option value="J181">팔레스타인 - Palestine</option>
							<option value="J182">프랑스령 폴리네시아 - French Polynesia</option>
							<option value="J183">카타르 - Qatar</option>
							<option value="J184">레위니옹 - Reunion</option>
							<option value="J185">루마니아 - Romania</option>
							<option value="J186">러시아 - Russia</option>
							<option value="J187">르완다 - Rwanda</option>
							<option value="J188">사우디아라비아 - Saudi Arabia</option>
							<option value="J189">수단 - Sudan</option>
							<option value="J190">세네갈 - Senegal</option>
							<option value="J191">싱가포르 - Singapore</option>
							<option value="J192">사우스조지아 사우스샌드위치 제도 - South Georgia and the South Sandwich Islands</option>
							<option value="J193">세인트헬레나 - Saint Helena, Ascension and Tristan da Cunha</option>
							<option value="J194">스발바르 얀마옌 - Svalbard and Jan Mayen</option>
							<option value="J195">솔로몬 제도 - Solomon Islands</option>
							<option value="J196">시에라리온 - Sierra Leone</option>
							<option value="J197">엘살바도르 - El Salvador</option>
							<option value="J198">산마리노 - San Marino</option>
							<option value="J199">소말리아 - Somalia</option>
							<option value="J200">생피에르 미클롱 - Saint Pierre and Miquelon</option>
							<option value="J201">세르비아 - Serbia</option>
							<option value="J202">상투메 프린시페 - Sao Tome and Principe</option>
							<option value="J203">수리남 - Suriname</option>
							<option value="J204">슬로바키아 - Slovakia</option>
							<option value="J205">슬로베니아 - Slovenia</option>
							<option value="J206">스웨덴 - Sweden</option>
							<option value="J207">스와질란드 - Swaziland</option>
							<option value="J208">세이셸 - Seychelles</option>
							<option value="J209">시리아 - Syria</option>
							<option value="J210">터크스 케이커스 제도 - Turks and Caicos Islands</option>
							<option value="J211">차드 - Chad</option>
							<option value="J212">토고 - Togo</option>
							<option value="J213">타이 - Thailand</option>
							<option value="J214">타지키스탄 - Tajikistan</option>
							<option value="J215">토켈라우 제도 - Tokelau</option>
							<option value="J216">투르크메니스탄 - Turkmenistan</option>
							<option value="J217">동티모르 - Timor-Leste</option>
							<option value="J218">통가 - Tonga</option>
							<option value="J219">트리니다드 토바고 - Trinidad and Tobago</option>
							<option value="J220">튀니지 - Tunisia</option>
							<option value="J221">터키 - Turkey</option>
							<option value="J222">투발루 - Tuvalu</option>
							<option value="J223">타이완 - Taiwan</option>
							<option value="J224">탄자니아 - Tanzania, United Republic of</option>
							<option value="J225">우간다 - Uganda</option>
							<option value="J226">우크라이나 - Ukraine</option>
							<option value="J227">미국령 군소 제도 - United States Minor Outlying Islands</option>
							<option value="J228">우루과이 - Uruguay</option>
							<option value="J229">미국 - United States of America</option>
							<option value="J230">우즈베키스탄 - Uzbekistan</option>
							<option value="J231">바티칸 시국 - Holy See (Vatican City State)</option>
							<option value="J232">세인트빈센트 그레나딘 - Saint Vincent and the Grenadines</option>
							<option value="J233">베네수엘라 - Venezuela</option>
							<option value="J234">영국령 버진아일랜드 - Virgin Islands, British</option>
							<option value="J235">미국령 버진아일랜드 - Virgin Islands, U.S.</option>
							<option value="J236">베트남 - Vietnam</option>
							<option value="J237">바누아투 - Vanuatu</option>
							<option value="J238">왈리스 퓌튀나 - Wallis and Futuna</option>
							<option value="J239">사모아 - Samoa</option>
							<option value="J240">예멘 - Yemen</option>
							<option value="J241">남아프리카 공화국 - South Africa</option>
							<option value="J242">잠비아 - Zambia</option>
							<option value="J243">짐바브웨 - Zimbabwe</option>
							<option value="J244">세인트 마틴 섬 - Saint Martin</option>
							<option value="J245">퀴라소 - Curacao</option>
							<option value="J246">세인트 유스타티우스 섬 - Bonaire, Saint Eustatius and Saba</option>
							<option value="J248">네덜란드령 안틸레스 - Netherlands Antilles</option>
							<option value="J249">생바르텔레미 - Saint Barthelemy</option>
							<option value="J250">생마르탱 - Saint Martin</option>
							<option value="J247">무국적 - Stateless</option>
							<option value="J251">기타 - Etc</option>
						</select>
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr style="display:;">
					<td class="tit">보안문자</td>
					<td class="cont" colspan="3">
						<p style="border:1px #e1e1e1 solid; float:left; margin-right:10px;"><img id="captchaImg_p2" src="https://online.olleh.com:8090/common/getCaptcha.action" /></p>
						<span id="forHtml5_p2" style="display:none;margin-bottom:2px;">
								<a href="javascript:loadAudio();"><img src="https://online.olleh.com:8090/images/btn/btn_voice.gif" alt="음성듣기"/></a>
								 <audio controls=controls id="audioCaptcha" style="width:0;height:0"></audio>
								 <a href="javascript:chg_p('p2');"><img src="https://online.olleh.com:8090/images/btn/btn_replace.gif" alt="새로고침"/></a>
						</span>
						<span id="forOldIE_p2" style="display:none;margin-bottom:2px;">
									
									<a href="http://online.olleh.com/_Lib/openWin/playSound.jsp" target="ifrmhidden"><img src="https://online.olleh.com:8090/images/btn/btn_voice.gif" alt="음성듣기"/></a>
									<!-- <a href="javascript:playSound();"><img src="https://online.olleh.com:8090/images/btn/btn_voice.gif" alt="음성듣기"/></a>
									<span id="soundPlayer" style="width:0;height:0"></span>-->
									<a href="javascript:chg_p('p2');"><img src="https://online.olleh.com:8090/images/btn/btn_replace.gif" alt="새로고침"/></a>
						</span>
						<br><br>
						<input type="text"  class="inp" style="width:106px;" id="captchaValue_p2" name="captchaValue_p2" maxlength="5" autocomplete="off"  style="ime-mode:disabled; text-transform:uppercase;">
					</td>
				</tr>
			</table>
			<p class="ex1" style="letter-spacing:-0.05em;">
				<span class="p02">미성년자는 온라인으로 가입할 수 없습니다.</span>
			</p>
			<div class="mgb5">
				<p class="p01"style="float:left;">(필수)주민번호 수집,이용에 관한 동의</p>
				<p style="float:right;"><label><input type="checkbox" name="AgreeBaseRegno7" align="right"/>동의합니다</label></p>
			</div>
			<div class="agree_content" style="clear:both;">
			<p class="ex1" style="width:100%">ㆍ수집ㆍ 이용 목적<br/>
				가. 온라인신청서 작성을 위한 본인확인/본인인증<br/>
				나. 서비스 가입/변경/해지 처리,AS, 청구서 발송, 물품(단말기/ 경품등)배송,<br/>
					 &nbsp;&nbsp;&nbsp;본인확인,개인식별, 가입의사 확인, 고지사항전달, 서비스제공관련 안내,<br/>
					 &nbsp;&nbsp;&nbsp;명의도용 방지를 위한 등록된 이동 전화로 가입사실 통보,<br/>
					 &nbsp;&nbsp;&nbsp;이용요금 상담, 할인, 청구(개별/통합/합산),고지,결제 및 추심,<br/>
					 &nbsp;&nbsp;&nbsp;이용관련 문의,불만 처리, 멤버십 서비스 제공<br/>
				다.	기타 개인정보취급방침(www.kt.com)에 고지된 수탁자에게 서비스 제공 등<br/>
					 &nbsp;&nbsp;&nbsp;계약의 이행에 필요한  업무의 위탁<br/>
				라. 이동전화서비스의 가입고객을 대상으로 한 본인확인서비스 제공<br/><br/>

				ㆍ 보유기간<br/>
				서비스 가입기간(가입일~해지일)또는 분쟁기간 동안 이용하고 지체 없이<br/>
				파기하며, 요금 정산/요금 과오납 등 분쟁 대비를 위해 해지 후<br/>
				6개월 까지, 요금의 미/과납이 있을 경우와 요금관련 분쟁이<br/>
				계속될 경우에는 해결 시까지 보유<br/>
				(단, 법령에 특별한 규정이 있을 경우 관련 법령에 따라 보관)
				</p>
			</div>
			<p style="width:100%">가입 시 고객님의 주민번호는 필수 수집대상이며, 미동의 시 온라인을 통한 가입신청이 불가함을 양해하여 주시기 바랍니다.</p>
		</div>

		<!--하단버튼-->
		<div class="lpu_bottom"><a href="javascript:goNext7();"><img src="https://online.olleh.com:8090/images/btn/lpu_btn_nameok.gif" alt="Verify"/></a></div>
	</div>
	<!--[if lte IE 6.5]><iframe></iframe><![endif]-->
</div>
<!-- //레이어팝업 외국인한글-->

<!-- 레이어팝업 임시저장한 신청서 보기 -->
<div id="div_intro5" class="alpa_bg" width="500px" style="display:none;">
	<div class="lpu_box" style="width:100%">
		<!--LPU타이틀-->
		<div class="lpu_tit">
			<h4><img src="https://online.olleh.com:8090/images/title/lpu_tit_06.gif" alt="임시저장한 신청서 보기"/></h4>
			<a href="javascript:fnCloseLayer5();" class="lpu_close"><img src="https://online.olleh.com:8090/images/btn/lpu_btn_close.gif" alt="닫기"/></a>
		</div>

		<!--내용-->
		<div class="lpu_explan" style="width:100%">
			<table class="sty_01" style="width:100%">
				<tr>
					<td class="tit" style="width:30%;">성명</td>
					<td class="cont">
						<input type="text" class="inp" style="width:230px;" name="custName" value="" onKeyPress="return specialKey(event, false)" style='ime-mode:active' maxlength="40"/>
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
					<td class="tit">생년월일(8자리)</td>
					<td class="cont">
						<input type="tel"  class="inp" style="width:105px;"name="BaseRegno1_2"  maxlength="8" />
					</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
				<td class="tit">성별</td>
					<td class="cont">
				<label>남<input type="radio"  name="custSexInfo" value="M"/></label>&nbsp;&nbsp;&nbsp;
				<label>여<input type="radio"  name="custSexInfo" value="F"/></label>
				</td>
				</tr>
				<tr><td class="line" colspan="2"></td></tr>
				<tr>
					<td class="tit">비밀번호</td>
					<td class="cont">
						<input type="password" class="inp" style="width:230px;" name="formPwd" maxlength="16"/>
					</td>
				</tr>
			</table>
			<p class="ex1">
				개정 "주민등록법"에 의해 타인의 주민등록번호를 도용하는 경우 3년 이하의 징역 또는 1천만원 이하의 벌금이 부과될 수 있습니다.<br/>
				<span class="p02">관련법률 : 주민등록법 제 37조(벌칙) 제 9조(시행일 2006.09.24)</span>
			</p>
		</div>

		<!--하단버튼-->
		<div class="lpu_bottom"><a href="javascript:goNext5();" id="aNext5"><img src="https://online.olleh.com:8090/images/list/list_btn_ok.gif" alt="실명인증"/></a></div>
	</div>
	<!--[if lte IE 6.5]><iframe></iframe><![endif]-->
</div>
<!-- //레이어팝업 임시저장한 신청서 보기 -->

<!--  가입유형 선택 (G009,G010,G011,G012) -->
<div id="div_BizformType" class="alpa_bg" width="500px" style="display:none;">
	<div class="lpu_box" style="width:100%">
		<!--가입유형 정보입력-->
		<div class="lpu_tit">
			<h4><img src="https://online.olleh.com:8090/images/title/lpu_tit_10.gif" alt="가입유형정보"/></h4>
		</div>

		<div class="lpu_explan" style="width:100%">
			<table class="sty_01" style="width:100%">
				<tr>
					<td class="tit rno">가입유형</td>
					<td class="cont">
						<select style="width:200px;" name="Seltbizform">
							<option value="">가입유형을 선택하세요.</option>
						
						</select>
					</td>
				</tr>
			</table>
			
			<p class="ex1 f1">
           		<span class="p01">※ 가입유형을 선택하셔야만 신청서 작성이 가능합니다.</span>
           	</p>
           </div>
		<div class="lpu_bottom"><a href="javascript:fnCheckType();" id="btnSubmit2"><img src="https://online.olleh.com:8090/images/btn/sub_btn_enter.gif" alt="확인"/></a></div>
	</div>
</div>
</form>

</body>
</html>
<iframe src="about:blank" width=100% height=0 frameborder=0 name=ifrmhidden ></iframe>