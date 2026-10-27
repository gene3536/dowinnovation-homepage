<?php
	include_once("../../../../../../system/config/config_lite.php"); 

	header('Content-Type: text/html; charset=euc-kr');
	/**************************************************************************
		파일명 : hs_cnfrm_popup3.php
		
		본인확인서비스 결과 화면(return url)
	**************************************************************************/	
	
	/* 공통 리턴 항목 */
	$rqstSiteNm	=	$_POST["rqst_site_nm"];			// 접속도메인	
	$rqstCausCd	=	$_POST["hs_cert_rqst_caus_cd"];	// 인증요청사유코드 2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타)

	/**************************************************************************
	 * 모듈 호출	; 본인확인서비스 결과 데이터를 복호화한다.
	 **************************************************************************/

	// 인증결과 암호화 데이터
	$encInfo = $_POST["encInfo"];
	//KCB서버 공개키
	$WEBPUBKEY = trim($_POST["WEBPUBKEY"]);
	//KCB서버 서명값
	$WEBSIGNATURE = trim($_POST["WEBSIGNATURE"]);

	/**************************************************************************
	 * 파라미터에 대한 유효성여부를 검증한다.
	 **************************************************************************/
	if(preg_match('~[^0-9a-zA-Z+/=]~', $encInfo, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
	if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBPUBKEY, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
	if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBSIGNATURE, $match)) {echo "입력 값 확인이 필요합니다"; exit;}

	// ########################################################################
	// # KCB로부터 부여받은 회원사코드(아이디) 설정 (12자리)
	// ########################################################################
	//$memId = "P00000000000";										// 회원사코드(아이디)
	$memId = "V34330000000";										// 회원사코드(아이디)

	// ########################################################################
	// # 운영전환시 변경 필요
	// ########################################################################
	//$endPointUrl = "http://tsafe.ok-name.co.kr:29080/KcbWebService/OkNameService";//EndPointURL, 테스트 서버
	$endPointUrl = "http://safe.ok-name.co.kr/KcbWebService/OkNameService";// 운영 서버
		  
	// ########################################################################
	// # 암호화키 파일 설정 (절대경로) - 파일은 주어진 파일명으로 자동 생성되며 생성되지 않으면 S211오류가 발생됨
	// # 파일은 매월초에 갱신되며 만일 파일이 갱신되지 않으면 복화화데이터가 깨지는 현상이 발생됨.
	// ########################################################################
	//$keyPath = "/okname/safecert_".$memId."_test.key";	// 테스트  키파일
	//$keyPath = "/web/home/cbwoman/tmp/key/safecert_".$memId."_test.key";	// 테스트  키파일
	$keyPath = "/web/home/cbwoman/tmp/key/safecert_".$memId.".key";	// 운영  키파일

	// ########################################################################
	// # 로그 경로 지정 및 권한 부여 (hs_cnfrm_popup2.asp에서 설정된 값과 동일하게 설정)
	// ########################################################################
	//$logPath = "/okname/log";
	$logPath = "/web/home/cbwoman/tmp/logs/okname";

	// ########################################################################
	// # 옵션값에 'D','L'을 추가하는 경우 로그(logPath변수에 설정된)가 생성됨.
	// # 시스템(환경변수 LANG설정)이 UTF-8인 경우 'U'옵션 추가 ex)$option='SLU'
	// ########################################################################
	$options = "S";	// S:인증결과복호화
		
	// 명령어
	$cmd = array($keyPath, $memId, $endPointUrl, $WEBPUBKEY, $WEBSIGNATURE, $encInfo, $logPath, $options);
//	echo "$cmd<br/>";
	
	/**************************************************************************
	okname 실행
	**************************************************************************/
	$output = NULL;
	// 실행
	$ret = okname($cmd, $output);
    //echo "ret=$ret<br/>";
    
	$retcode = "";

	if($ret == 0) {
		$result = explode("\n", $output);
		$retcode = $result[0];
	}
	else {
		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);
	}


	if($ret == 0) {
		//인증결과 복호화 성공
		// 인증결과를 확인하여 페이지분기등의 처리를 수행해야한다.
	 	if ($retcode == "B000") {
			//echo ("<script>alert('본인인증성공'); fncOpenerSubmit();</script>");

			$_SESSION["memberLogin"]	    = true;
			$_SESSION["memberLevel"]	    = 9;
			$_SESSION["memberId"]			= $result[4];
			$_SESSION["memberCi"]			= $result[5];
			$_SESSION["memberAuthkey"]		= $result[4];
			$_SESSION["memberName"]			= iconv("euc-kr","utf-8",$result[7]);
			$_SESSION["memberAuthtype"]		= 1;	
			$_SESSION["memberScode"]		= "00000002";
						
			// 로그인정보 등록
			$item		= "mb_log_scode, mb_log_uid, mb_log_uname, mb_log_browser, mb_log_regip, mb_log_regdate";
			$value		= "'".site_config_code."', '".$_SESSION["memberId"]."', '".$_SESSION["memberName"]."', '".site_client_browser."', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_member_login, $item, $value);	
			$coreClass -> commit();

			$return_url	= base64_decode($_SESSION["return_url"]);
			
			if(!$return_url) $return_url	= "/";
				
			echo "<script type='text/javascript'>
			
				//alert('본인인증이 정상적으로 처리 되었습니다.');
				//opener.location.href='".$return_url."';
				//self.close();
						
				window.opener.location.href='".$return_url."';
				self.close();;				
						
			</script>";


			exit;

		}
		else {

			echo "<script type='text/javascript'>
			
				alert('본인인증에 실패하였습니다.');
				self.close();
				
			</script>";
			
			exit;

		}
	} else {
		//인증결과 복호화 실패
		echo ("<script>alert('인증결과복호화를 실패하였습니다. : ".$ret."'); self.close(); </script>");
	}
?>

