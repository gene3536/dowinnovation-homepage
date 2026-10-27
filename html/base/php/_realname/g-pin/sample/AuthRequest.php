<?php
header("Content-Type: text/html; charset=UTF-8");
session_start();

	$return_url = $_GET[return_url];	//g-pin 처리후 이동 페이지

	//요청 메시지를 만들어 G-PIN센터로 전송하는 페이지를 만듭니다.

	include("gpin_func.php");

	//응답을 처리할 페이지를 지정합니다.
	$_SESSION["gpinAuthRetPage"] = "AuthResponse.php?return_url=".$return_url;
	

	// 인증요청페이지 생성( makeAuthRequest() )
	// Attr : 요청 사용자정보 ( or 연산을 통해 조합 )
	// 0 or null 사용자 기본정보(개인식별번호/사용자이름/중복가입확인정보)
	// 1 주민등록번호
	// 2 성별
	// 4 생년월일
	
	if ($_REQUEST["Attr"] != null)
	{
		$ret = makeAuthRequest((int)$_REQUEST["Attr"]);
	}
	else
		$ret = makeAuthRequest(0);

	// 에러인 경우 메세지표시 후 종료함.		
	GPIN_ERROR_CHECK(TRUE);

	//인증요청페이지 출력
	echo $ret;

?>