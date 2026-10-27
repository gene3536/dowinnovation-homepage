<?php
	include_once("../../../../../../system/config/config_lite.php"); 

	header('Content-Type: text/html; charset=euc-kr');

	//아이핀팝업에서 조회한 PERSONALINFO
	@$encPsnlInfo = $_POST["encPsnlInfo"];
	//KCB서버 공개키
	@$WEBPUBKEY = trim($_POST["WEBPUBKEY"]);
	//KCB서버 서명값
	@$WEBSIGNATURE = trim($_POST["WEBSIGNATURE"]);

	//파라미터에 대한 유효성여부를 검증한다.
	if(preg_match('~[^0-9a-zA-Z+/=]~', $encPsnlInfo, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
	if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBPUBKEY, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
	if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBSIGNATURE, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
  
	/*
	echo "$encPsnlInfo<br>";
	echo "$WEBPUBKEY<br>";
	echo "$WEBSIGNATURE<br>";
	*/
  
	//아이핀 서버와 통신을 위한 키파일 생성
	// 파라미터 정의
    // 암호화키 파일 설정 (ipin1.php에서 설정된 값과 동일)
	//$keyPath = "/okname/okname_test.key";	// 테스트 키파일
	//$keyPath = "/web/home/cbwoman/tmp/key/okname.key";	// 테스트 키파일
	$keyPath = "/web/home/cbwoman/tmp/key/okname.key";		// 운영 키파일

	$cpCode    = "V34330000000";			// 회원사코드 (테스트인 경우 'P00000000000'를 사용하며 운영시 발급받은 회원사코드를 설정)
	//$cpCode    = "P00000000000";			// 회원사코드 (테스트인 경우 'P00000000000'를 사용하며 운영시 발급받은 회원사코드를 설정)
	//$endPointUrl = "http://twww.ok-name.co.kr:8888/KcbWebService/OkNameService";// 테스트 서버
	$endPointURL = "http://www.ok-name.co.kr/KcbWebService/OkNameService";// 운영 서버

    // 로그 경로 지정 및 권한 부여 (ipin1.php에서 설정된 값과 동일)
	$logPath = "/web/home/cbwoman/tmp/logs/okname";
	$options = "SL";
		
	// 명령어
	$cmd = array($keyPath, $cpCode, $endPointUrl, $WEBPUBKEY, $WEBSIGNATURE, $encPsnlInfo, $logPath, $options);
	//echo "$cmd<br>";
	
	/**************************************************************************
	 * okname 실행
	 **************************************************************************/
	$output = NULL;
	// 실행
	$ret = okname($cmd, $output);
    //echo "ret=$ret<br/>";
    
	$retcode = "";

	if($ret == 0) {
		$result = explode("\n", $output);
		$retcode=sprintf("B%03d", $ret);
	}
	else {
		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);
	}

	if($ret == 0) {

		$_SESSION["memberLogin"]	    = true;
		$_SESSION["memberLevel"]	    = 9;
		$_SESSION["memberId"]			= $result[0];		
		$_SESSION["memberCi"]			= $result[1];
		$_SESSION["memberAuthkey"]		= $result[0];
		$_SESSION["memberName"]			= iconv("euc-kr","utf-8",$result[6]);
		$_SESSION["memberAuthtype"]		= 2;	
		$_SESSION["memberScode"]		= "00000002";
					
		// 로그인정보 등록
		$item		= "mb_log_scode, mb_log_uid, mb_log_uname, mb_log_browser, mb_log_regip, mb_log_regdate";
		$value		= "'".site_config_code."', '".$_SESSION["memberId"]."', '".$_SESSION["memberName"]."', '".site_client_browser."', '".site_client_ip."', '".site_regdate."'";
		$coreClass -> insertQuery(tbl_member_login, $item, $value);	
		$coreClass -> commit();

		$return_url	= base64_decode($_SESSION["return_url"]);

		if(!$return_url) $return_url = "/";
			
		echo "<script type='text/javascript'>
		
			//alert('본인인증이 정상적으로 처리 되었습니다.');
			//opener.location.href='".$return_url."';
			//self.close();
					
			window.opener.location.href='".$return_url."';
			self.close();;				
					
		</script>";


		exit;

	} else {
		//인증결과 복호화 실패
		//echo("<script>alert('인증결과복호화 실패 : ".$ret."'); self.close(); </script>");

		echo "<script type='text/javascript'>
		
			alert('본인인증에 실패하였습니다.');
			self.close();
			
		</script>";
		
		exit;

	}
?>
