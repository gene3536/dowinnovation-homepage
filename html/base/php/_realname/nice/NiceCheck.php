<?php

	require_once( "nice.nuguya.oivs.php" );

	//#######################################################################################
	//#####
	//#####	실명인증키(대체인증키) 서비스 샘플 페이지 소스				한국신용정보(주)
	//#####
	//#####	================================================================================
	//#####
	//#####	* 본 페이지는 귀사의 화면에 맞게 수정하십시오.
	//#####	  단, Head 영역에 설정된 Javascript를 수정하거나 변경하시면 사용할 수 없습니다.
	//#####
	//#######################################################################################


	//========================================================================================
	//=====	▣ 회원사 ID 설정 : 계약시에 발급된 회원사 ID를 설정하십시오. ▣
	//========================================================================================

	$NiceId = "Nkongju4"; // 회원사 아이디

	//========================================================================================
	//=====	▣ 반환 결과를 수신할 URL을 설정하십시오. (단, 페이지는 그대로 사용하십시오)
	//=====	   한신정 서비스에 전달되어 사용되므로 반드시 절대 URL 경로를 설정하셔야 합니다.
	//========================================================================================

	//EX) http://귀사의도메인/NiceCheckPopup.php
	$ReturnURL = "http://www.gongju.go.kr/_prog/realname/NiceCheckPopup.php" ;

?>


<html>
	<head>
		<title>한국신용정보주식회사 개인인증키(대체인증키) 서비스 샘플 페이지</Title>
		<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

		<!--	==========================================================	-->
		<!--	한국신용정보주식회사 처리 모듈 (수정 및 변경하지 마십시오)	-->
		<!--	==========================================================	-->
		<script type="text/javascript" src="http://secure.nuguya.com/nuguya/nice.nuguya.oivs.crypto.js"></script>
		<script type="text/javascript" src="http://secure.nuguya.com/nuguya/nice.nuguya.oivs.msg.js"></script>
		<script type="text/javascript" src="http://secure.nuguya.com/nuguya/nice.nuguya.oivs.util.js"></script>

		<LINK href="./nice.nuguya.oivs.css" type=text/css rel=stylesheet>
	</head>

	<script language="javascript">

		document.onkeydown = onKeyDown;

		function onKeyDown( event )
		{
			var e = event;
			if ( event == null ) e = window.event;

			if ( e.keyCode == 13 ) goIDCheck();
		}

		function loadAction()
		{
			if ( document.all.PingInfo.value == "" )
			{
				alert( "한국신용정보(주)의 개인인증키 서비스가 점검중입니다.\n잠시후 다시 시도하시기 바랍니다.\n\n상태가 계속되면 사이트관리자에게 문의하십시오" );
				return;
			}
		}

		function validate()
		{
			var NiceId		= document.getElementById( "NiceId" );
			var PingInfo	= document.getElementById( "PingInfo" );
			var ReturnURL	= document.getElementById( "ReturnURL" );

			if ( NiceId.value == "" )
			{
				alert( getCheckMessage( "S60" ) );
				NiceId.focus();
				return false;
			}

			if ( PingInfo.value == "" )
			{
				alert( getCheckMessage( "S61" ) );
				return false;
			}

			if ( ReturnURL.value == "" )
			{
				alert( getCheckMessage( "S64" ) );
				ReturnURL.focus();
				return false;
			}

			return true;
		}

		function goIDCheck()
		{
			if ( validate() == true )
			{
				var strNiceId 	= document.getElementById( "NiceId" ).value;
				var strPingInfo	= document.getElementById( "PingInfo" ).value;
				var strOrderNo	= document.getElementById( "OrderNo" ).value;
				var strInqRsn	= document.getElementById( "InqRsn" ).value;
				var strReturnUrl	= document.getElementById( "ReturnURL" ).value;

				//	거래일련번호가 없는 경우는 새로 생성한다.
				if ( strOrderNo == "" ) strOrderNo = getOrderNo( 20 );

				document.reqForm.SendInfo.value = makeCertKeyInfo( strNiceId, strPingInfo, strOrderNo, strInqRsn, strReturnUrl );
				document.reqForm.ProcessType.value = strRealNameCertKey;

				var popupWindow = window.open( "", "popupCertKey", "top=100, left=200, status=0, width=417, height=490" );
				document.reqForm.target = "popupCertKey";
				document.reqForm.action = strCertKeyServiceUrl;
				document.reqForm.submit();
				popupWindow.focus();
			}

			return;
		}

	</script>

	<BODY onLoad="javascript:loadAction();" >
		<FORM id="reqForm" name="reqForm" method="POST" action="">
			<input class="small" type="hidden" id="SendInfo" name="SendInfo" >
			<input class="small" type="hidden" id="ProcessType" name="ProcessType" >
		</FORM>
		<FORM id="pageForm" name="pageForm" method="POST" action="">
	  		<INPUT type="hidden" id="NiceId" name="NiceId" value="<? echo $NiceId ; ?>">
			<INPUT type="hidden" id="PingInfo" name="PingInfo" value="<? echo getPingInfo(); ?>">
	  		<INPUT type="hidden" id="ReturnURL" name="ReturnURL" value="<? echo $ReturnURL ; ?>" >
			<!--	조회사유를 설정하십시오 ( '10'-회원가입, '20'-기존회원 확인, '30'-성인인증, '40'-비회원 확인, '50'-기타 사유 )	-->
			<input type="hidden" id="InqRsn" name="InqRsn" value="10">
			<!--	거래일련번호를 설정하십시오. (최소 14자리, 20자리미만)	-->
			<input type="hidden" id="OrderNo" name="OrderNo" value="">

			<INPUT name="Confirm" type="button" id="Confirm" value="실명인증키 인증" style="width:150px;" onclick="javascript:goIDCheck();">
		</form>
	</BODY>

</html>
