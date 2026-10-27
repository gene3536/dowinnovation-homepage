<?
	//session_start();
	/************************************************************************************/
	/* - 결과값 복호화를 위해 IV 값을 Random하게 생성함.(반드시 필요함!!)			    */
	/* - input박스 reqNum의 value값을  echo $CurTime.$RandNo  형태로 지정				*/
 	/************************************************************************************/
    $CurTime = date(YmdHis);  //현재 시각 구하기
	//6자리 랜덤값 생성
	$RandNo = rand(100000, 999999);

	/*
	$id = $_REQUEST['id'];
	$srvNo = $_REQUEST['srvNo'];
	$reqNum = $_REQUEST['reqNum'];
	$certDate = $_REQUEST['certDate'];
	$certGb = $_REQUEST['certGb'];
	$addVar = $_REQUEST['addVar'];
	$retUrl = $_REQUEST['retUrl'];
	*/

	$id = "SQPF001";				//아이디
	$srvNo = "002001";			//서비스요청번호
	$reqNum = $CurTime.$RandNo; //복호화 키
	$certGb = "H";				//인증구분 - 휴대폰
	$certDate = $CurTime;
	$retUrl = "32http://bi.hanbat.ac.kr/_prog/_realname/seoul2/popup.php";
	$addVar = $_SESSION['sess_return_url'];

	
	/************************************************************************************/
	/* reqNum 값은 최종 결과값 복호화를 위한 SecuKey로 활용 되므로 중요합니다.			*/
	/* reqNum 은 본인 확인 요청시 항상 새로운 값으로 중복 되지 않게 생성 해야 합니다.	*/
	/* 쿠키 또는 Session및 기타 방법을 사용해서 reqNum 값을								*/
	/* vname_result_seed.php에서 가져 올 수 있도록 해야 함.								*/
	/* 샘플을 위해서 쿠키를 사용한 것이므로 참고 하시길 바랍니다.						*/
 	/************************************************************************************/
	//01. reqNum 쿠키 생성
	setcookie("REQNUM", $reqNum, time()+600);

	$_SESSION["REQNUM"]="";
	$_SESSION["REQNUM"] = $reqNum;
	//echo $_SESSION["REQNUM"];
	$exVar       = "0000000000000000";        // 확장임시 필드입니다. 수정하지 마세요..

	


	//02. 암호화 파라미터 생성
	$reqInfo = $id . "^" . $srvNo . "^" . $reqNum . "^" . $certDate . "^" . $certGb . "^" . $addVar . "^" . $exVar;

	//echo "\$reqInfo : ".$reqInfo;

	$fp_arr = fopen("/home/htdocs/public_hanbat_bi/LOG/SCI/sci_errorlog.txt","a+");
		
	$_str = "[".$func->GetUserIP()."]".$_SERVER['HTTP_USER_AGENT']."\nreqInfo=>".$reqInfo."\n\n";
		
	fwrite($fp_arr,$_str);
	fclose($fp_arr);

	//위 변조 및, 불법 시도 차단을 위하여 아래 패턴에 해당하는 문자열만 허용
	if(preg_match('~[^0-9a-zA-Z+/=^]~', $reqInfo, $matches)){
		echo "입력 값 확인이 필요합니다.(req)"; exit;
	}


	$iv = "";

	$module = "SciSecuX_PCC";
	$function = "SciSecuX_PCC";


	if(extension_loaded($module)) {
		$enc_reqInfo = $function("SEED", 1, 1, "", $reqInfo);
	} else {
		$enc_reqInfo = "Module SciSecuX_PCC is not compiled into PHP";
	}

	//04. 요청정보 위변조검증값 생성

	if (extension_loaded($module)) {
		$hmac_str = $function("HMAC", 1, 1, "", $enc_reqInfo);    // 요청정보 위변조검증값 생성
	} else {
		$hmac_str = "Module SciSecuX_PCC is not compiled into PHP";
	}

	//05. 요청정보 2차암호화
	//데이터 생성 규칙 : "요청정보 1차 암호화^위변조검증값^암복화 확장 변수"
	$enc_reqInfo = $enc_reqInfo. "^" .$hmac_str. "^" ."0000000000000000";
	if (extension_loaded($module)) {
		$enc_reqInfo = $function("SEED", 1, 1, "", $enc_reqInfo);
	} else {
		$enc_reqInfo = "Module SciSecuX_PCC is not compiled into PHP";
	}

	$enc_reqInfo = iconv("utf-8", "euc-kr", $enc_reqInfo);
	$retUrl = iconv("utf-8", "euc-kr", $retUrl);

?>

<script language=javascript>
<!--
    var CBA_window2;
	//openPCCWindow
    function openPCCWindow(){

        var CBA_window2 = window.open('', 'PCCWindow', 'width=430, height=560, resizable=1, scrollbars=no, status=0, titlebar=0, toolbar=0, left=300, top=200' );

        if(CBA_window2 == null){
			 alert(" ※ 윈도우 XP SP2 또는 인터넷 익스플로러 7 사용자일 경우에는 \n    화면 상단에 있는 팝업 차단 알림줄을 클릭하여 팝업을 허용해 주시기 바랍니다. \n\n※ MSN,야후,구글 팝업 차단 툴바가 설치된 경우 팝업허용을 해주시기 바랍니다.");
        }

        document.reqCBAForm2.action = 'https://pcc.siren24.com/pcc_V3/jsp/pcc_V3_j10.jsp';
        document.reqCBAForm2.target = 'PCCWindow';
		document.reqCBAForm2.submit();
		//return true;
    }

//-->
</script>
<!-- 본인확인서비스 요청 form --------------------------->
<form name="reqCBAForm2" method="post" action = "" onsubmit="return openPCCWindow()">
    <input type="hidden" name="reqInfo"     value = "<?=$enc_reqInfo?>">
    <input type="hidden" name="retUrl"      value = "<?=$retUrl?>">
    <!--input type="submit" value="본인확인서비스 요청" -->
</form>

