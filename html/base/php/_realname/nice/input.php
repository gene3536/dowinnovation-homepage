<?php

	require_once( "nice.nuguya.oivs.php" );

	list($hour, $min, $sec, $day, $month, $year) = explode(" ",date("H i s d m Y")); 
	$pSeqid = mktime($hour, $min, $sec, $month, $day, $year); 

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

	$NiceId = "Ni815"; // 회원사 아이디
//$NiceId = "N01090006395"; // 회원사 아이디
	//========================================================================================
	//=====	▣ 반환 결과를 수신할 URL을 설정하십시오. (단, 페이지는 그대로 사용하십시오)
	//=====	   한신정 서비스에 전달되어 사용되므로 반드시 절대 URL 경로를 설정하셔야 합니다.
	//========================================================================================

	//EX) http://귀사의도메인/NiceCheckPopup.php
	$ReturnURL = "http://".$_SERVER["HTTP_HOST"]."/_prog/_realname/nice/output.php";

?>
<script type="text/javascript" src="http://secure.nuguya.com/nuguya/nice.nuguya.oivs.crypto.js"></script>
<script type="text/javascript" src="http://secure.nuguya.com/nuguya/nice.nuguya.oivs.msg.js"></script>
<script type="text/javascript" src="http://secure.nuguya.com/nuguya/nice.nuguya.oivs.util.js"></script>

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

	function openCBAWindow()
	{
		if ( validate() == true )
		{
			var strNiceId 	= document.getElementById( "NiceId" ).value;
			var strPingInfo	= document.getElementById( "PingInfo" ).value;
			var strOrderNo	= document.getElementById( "OrderNo" ).value;
			var strInqRsn	= document.getElementById( "InqRsn" ).value;
			var strReturnUrl	= document.getElementById( "ReturnURL" ).value;
			
			//if ( strOrderNo == "" ) strOrderNo = getOrderNo( 20 );

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
<!-- 2010.05.27 김재은 수정 -->
	<BODY onLoad="javascript:loadAction();" >
		<FORM id="reqForm" name="reqForm" method="POST" action="?">
			<input class="small" type="hidden" id="SendInfo" name="SendInfo" >
			<input class="small" type="hidden" id="ProcessType" name="ProcessType" >
		</FORM>
		<FORM id="pageForm" name="pageForm" method="POST" action="?">
	  		<INPUT type="TEXT" id="NiceId" name="NiceId" value="<?=$NiceId?>">
			<INPUT type="TEXT" id="PingInfo" name="PingInfo" value="<? echo getPingInfo(); ?>">
	  		<INPUT type="TEXT" id="ReturnURL" name="ReturnURL" value="<?=$ReturnURL?>" >
			<input type="TEXT" id="InqRsn" name="InqRsn" value="40">
			<input type="TEXT" id="OrderNo" name="OrderNo" value="6066175<?=$pSeqid?>">			
		</form>
	</BODY>

</html>