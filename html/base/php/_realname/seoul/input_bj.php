<?
/**
	//고유식별번호생성
	//list($hour, $min, $sec, $day, $month, $year) = explode(" ",date("H i s d m Y")); 
	//$sci_num = mktime($hour, $min, $sec, $month, $day, $year); 

	$CurTime = date(YmdHis);  //현재 시각 구하기

	//6자리 랜덤값 생성
	$RandNo = rand(100000, 999999);

	 $sci_num = $CurTime.$RandNo;
	
	//setcookie("REQNUM", $sci_num, time()+600);
	$_SESSION["sess_iv"][0] = $sci_num;
**/
	$CurTime = date(YmdHis);  //현재 시각 구하기
	$RandNo = rand(100000, 999999);
	$reqNum = $CurTime.$RandNo;


	/************************************************************************************/
	/* reqNum 값은 최종 결과값 복호화를 위한 SecuKey로 활용 되므로 중요합니다.			*/
	/* reqNum 은 본인 확인 요청시 항상 새로운 값으로 중복 되지 않게 생성 해야 합니다.	*/
	/* 쿠키 또는 Session및 기타 방법을 사용해서 reqNum 값을								*/
	/* vname_result_seed.php에서 가져 올 수 있도록 해야 함.								*/
	/* 샘플을 위해서 쿠키를 사용한 것이므로 참고 하시길 바랍니다.						*/
 	/************************************************************************************/
	//01. reqNum 쿠키 생성
	setcookie("REQNUM", $reqNum, time()+6000);
	$_SESSION["REQNUM"] = $reqNum;
	$id = "SQPF001";
	$exVar       = "0000000000000000";        // 확장임시 필드입니다. 수정하지 마세요..

	$certDate = $CurTime;
	$srvNo = "002001";
	$certGb = "H";
	
	//02. 암호화 파라미터 생성
	$reqInfo = $id . "^" . $srvNo . "^" . $reqNum . "^" . $certDate . "^" . $certGb . "^" . $addVar . "^" . $exVar;
	

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
		

/**	
	//03. 본인확인 요청정보 1차암호화
	$iv = "";
	//2014.02.07 KISA 권고사항
	//위 변조 및, 불법 시도 차단을 위하여 아래 패턴에 해당하는 문자열만 허용	
	if(preg_match('~[^0-9a-zA-Z+/=^]~', $reqInfo, $matches)){
		echo "입력 값 확인이 필요합니다.(req)"; exit;
	}
	$enc_reqInfo = exec(DOC_DIR."/_prog/_realname/seoul/SciSecuX SEED 1 1 $reqInfo ");//암호화모듈 설치시 생성된 SciSecuX 파일이 있는 리눅스 경로를 설정해주세요.

	//04. 요청정보 위변조검증값 생성
	$hmac_str = exec(DOC_DIR."/_prog/_realname/seoul/SciSecuX HMAC 1 1 $enc_reqInfo ");

	//05. 요청정보 2차암호화
	//데이터 생성 규칙 : "요청정보 1차 암호화^위변조검증값^암복화 확장 변수"
	$enc_reqInfo = $enc_reqInfo. "^" .$hmac_str. "^" ."0000000000000000";
	$enc_reqInfo = exec(DOC_DIR."/_prog/_realname/seoul/SciSecuX SEED 1 1 $enc_reqInfo ");
**/

?>
<script type='text/javascript'>  
<!--
    var CBA_window; 

    function openCBAWindow()
    { 
        CBA_window = window.open('', 'CbaWindow', 'width=410, height=450, resizable=0, scrollbars=no, status=0, titlebar=0, toolbar=0, left=300, top=200' );

        if(CBA_window == null){ 
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf ( "MSIE" );
            var msxp = ua.indexOf ( "Windows NT 5.1" );
            var msxpsp2 = ua.indexOf ( " SV1" );

            if(msie >0 && msxp >0 && msxpsp2 >0){
                alert("※ MSN,야후,구글 팝업 차단 툴바가 설치된 경우 팝업허용을 해주셔야만 가상식별검증이 가능합니다. \n\n※ 윈도우 XP SP2 사용자일 경우에는 화면 상단에 있는 팝업 차단 알림줄을 클릭하여 팝업을 \n    허용해 주시기 바랍니다.");
            }else{
                alert("※ MSN,야후,구글 팝업 차단 툴바가 설치된 경우 팝업허용을 해주셔야만 가상식별검증이 가능합니다."); 
            } 
        }

        //document.reqCBAForm.action = 'https://name.siren24.com/vname/jsp/vname_j10.jsp';
        document.reqCBAForm.action = 'https://pcc.siren24.com/pcc_V3/jsp/pcc_V3_j10.jsp';
        document.reqCBAForm.target = 'CbaWindow';
        document.reqCBAForm.submit();
    }
    
    
    function openPCCWindow(){ 
        var CBA_window = window.open('', 'PCCWindow', 'width=430, height=560, resizable=1, scrollbars=no, status=0, titlebar=0, toolbar=0, left=300, top=200' );

        if(CBA_window == null){ 
			 alert(" ※ 윈도우 XP SP2 또는 인터넷 익스플로러 7 사용자일 경우에는 \n    화면 상단에 있는 팝업 차단 알림줄을 클릭하여 팝업을 허용해 주시기 바랍니다. \n\n※ MSN,야후,구글 팝업 차단 툴바가 설치된 경우 팝업허용을 해주시기 바랍니다.");
        }

        document.reqCBAForm.action = 'https://pcc.siren24.com/pcc_V3/jsp/pcc_V3_j10.jsp';
        document.reqCBAForm.target = 'PCCWindow';
        document.reqCBAForm.submit();

		return true;
    }	

//-->
</script>
<form name="reqCBAForm" method="post" action="">  
    <input type="hidden" name="reqInfo"  value = "<?=$enc_reqInfo?>">                                  <!-- 실명확인 요청번호      -->
    <input type="hidden" name="retUrl"  value = "32http://<?=$_SERVER['HTTP_HOST']?>/_prog/_realname/seoul2/output.php?return_url=<?=$return_url?>">            <!-- 실명확인 결과수신 URL  -->
</form>

<?
/**
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";
$_SESSION['SESS_RETURN_URL'] = "";
**/
?>