<?

	include_once("../../../../../system/config/config_lite.php"); 
	
	$CurTime = date(YmdHis);  //현재 시각 구하기
	//6자리 랜덤값 생성
	$RandNo = rand(100000, 999999);
	
	//$id = "SQPF001";
	//$srvNo = "002001";

	$id = "SYDN001";
	//$srvNo = "015003";
	$srvNo = "010002";
	
	$reqNum	= $CurTime.$RandNo;
	$certDate	= $CurTime;
	$certGb		= "H";
	$addVar		= "";
	
	$return_url = isset($_REQUEST['return_url'])? $_REQUEST['return_url'] : "/home/main.php" ;
	$return_url = base64_encode($return_url);
	
	$retUrl	= "32http://".$_SERVER['HTTP_HOST']."/base/php/_realname/seoul/output.php?return_url=".$return_url;
	
	/************************************************************************************/
	/* reqNum 값은 최종 결과값 복호화를 위한 SecuKey로 활용 되므로 중요합니다.			*/
	/* reqNum 은 본인 확인 요청시 항상 새로운 값으로 중복 되지 않게 생성 해야 합니다.	*/
	/* 쿠키 또는 Session및 기타 방법을 사용해서 reqNum 값을								*/
	/* vname_result_seed.php에서 가져 올 수 있도록 해야 함.								*/
	/* 샘플을 위해서 쿠키를 사용한 것이므로 참고 하시길 바랍니다.						*/
 	/************************************************************************************/
	//01. reqNum 쿠키 생성
	//setcookie("REQNUM", $reqNum, time()+600);
	$_SESSION["REQNUM"]="";
	$_SESSION["REQNUM"] = $reqNum; 

	$exVar       = "0000000000000000";        // 확장임시 필드입니다. 수정하지 마세요..

	//02. 암호화 파라미터 생성
	$reqInfo = $id . "^" . $srvNo . "^" . $reqNum . "^" . $certDate . "^" . $certGb . "^" . $addVar . "^" . $exVar;

	$fp_arr = fopen("/data/ydgugak/tmp/logs/sci_errorlog.txt","a+");
		
	$_str = "".$_SERVER['HTTP_USER_AGENT']."\nreqInfo=>".$reqInfo."\n\n";
		
	fwrite($fp_arr,$_str);
	fclose($fp_arr);
	
	//03. 본인확인 요청정보 1차암호화
	$iv = "";
	//2014.02.07 KISA 권고사항
	//위 변조 및, 불법 시도 차단을 위하여 아래 패턴에 해당하는 문자열만 허용	
	if(preg_match('~[^0-9a-zA-Z+/=^]~', $reqInfo, $matches)){
		echo "입력 값 확인이 필요합니다.(req)"; exit;
	}
	$enc_reqInfo = exec($_SERVER['DOCUMENT_ROOT']."/base/php/_realname/seoul/SciSecuX SEED 1 1 $reqInfo ");//암호화모듈 설치시 생성된 SciSecuX 파일이 있는 리눅스 경로를 설정해주세요.

	//04. 요청정보 위변조검증값 생성
	$hmac_str = exec($_SERVER['DOCUMENT_ROOT']."/base/php/_realname/seoul/SciSecuX HMAC 1 1 $enc_reqInfo ");

	//05. 요청정보 2차암호화
	//데이터 생성 규칙 : "요청정보 1차 암호화^위변조검증값^암복화 확장 변수"
	$enc_reqInfo = $enc_reqInfo. "^" .$hmac_str. "^" ."0000000000000000";
	$enc_reqInfo = exec($_SERVER['DOCUMENT_ROOT']."/base/php/_realname/seoul/SciSecuX SEED 1 1 $enc_reqInfo ");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title>본인확인서비스 서비스 요청 화면</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<!--
<style>

   body,p,ol,ul,td
   {
	 font-family: 굴림;
	 font-size: 12px;   
   } 
   
   a:link { size:9px;color:#000000;text-decoration: none; line-height: 12px}
   a:visited { size:9px;color:#555555;text-decoration: none; line-height: 12px}
   a:hover { color:#ff9900;text-decoration: none; line-height: 12px}

   .style1 {
		color: #6b902a;
		font-weight: bold;
	}
	.style2 {
	    color: #666666
	}
	.style3 {
		color: #3b5d00;
		font-weight: bold;
	}

</style>
-->
<script language=javascript>  
<!--
    var CBA_window; 

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
</head>
<body>

<!-- 본인확인서비스 요청 form --------------------------->
<form name="reqCBAForm" method="post" action = "" onsubmit="">
    <input type="hidden" name="reqInfo"     value = "<? echo "$enc_reqInfo" ?>" />
    <input type="hidden" name="retUrl"      value = "<? echo "$retUrl" ?>" />
</form>
</body>
</html>