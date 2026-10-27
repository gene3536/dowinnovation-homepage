<?
include $_SERVER["DOCUMENT_ROOT"]."/acego/session_info.inc";

print("<pre>");
print_r($_SESSION);
echo base64_decode($_SESSION['SESS_RETURN_URL']);
print("</pre>");

	require_once( "nice.nuguya.oivs.php" );


	$oivsObject = new OivsObject();

	$strRecvData 	= $_POST[ "SendInfo" ];
	$blRcv 		= $oivsObject->resolveClientData( $strRecvData );


if($oivsObject->retCd == 1) 
{
	$_SESSION["sess_realname"][0] = $oivsObject->paKey;
	$_SESSION["sess_realname"][1] = $oivsObject->niceNm;
	
	// 그룹 코드 셋팅 
	if($_SESSION["sess_member_info"][10]) $_SESSION["sess_member_info"][10] = $_SESSION["sess_member_info"][10].";100" ;	// 그룹 코드 실명인증만 한경우 100을 셋팅한다.
	else  $_SESSION["sess_member_info"][10] = 100 ;
  
	echo "<script>			
			opener.location.href='".base64_decode($_SESSION['SESS_RETURN_URL'])."';
			window.close();
		</script>
			";
	exit;
	
}else{
	
	echo "
	   <SCRIPT LANGUAGE=\"JavaScript\">
	   <!--
		   alert ('실명인증 오류입니다 다시한번 확인해주십시요');
		   self.close();
	   //-->
	   </SCRIPT>";				   
	   exit;
	
}

exit;
?>

<LINK href="./nice.nuguya.oivs.css" type=text/css rel=stylesheet>

<table width="100%" cellpadding="3" cellspacing="1" bgcolor="#999900">
	<tr><td class="td_left">회원사 아이디</td>
		<td class="td_content"><? echo $oivsObject->niceId; ?></td>
	</tr>
	<tr><td class="td_left">주문번호</td>
		<td class="td_content"><? echo $oivsObject->ordNo . "(". $ssOrderNo .")"; ?></td>
	</tr>
	<tr><td class="td_left">인증번호</td>
		<td class="td_content"><? echo $oivsObject->trNo; ?></td>
	</tr>
	<tr><td class="td_left">응답코드</td>
		<td class="td_content"><? echo $oivsObject->retCd; ?></td>
	</tr>
	<tr><td class="td_left">응답상세코드</td>
		<td class="td_content"><? echo $oivsObject->retDtlCd; ?></td>
	</tr>
	<tr><td class="td_left">응답메시지</td>
		<td class="td_content"><? echo $oivsObject->message; ?></td>
	</tr>
	<tr><td class="td_left">아이핀번호</td>
		<td class="td_content"><? echo $oivsObject->paKey; ?></td>
	</tr>
	<tr><td class="td_left">한국신용정보 등록성명</td>
		<td class="td_content"><? echo $oivsObject->niceNm; ?></td>
	</tr>
	<tr><td class="td_left">생년월일</td>
		<td class="td_content"><? echo $oivsObject->birthday; ?></td>
	</tr>
	<tr><td class="td_left">성별</td>
		<td class="td_content"><? echo $oivsObject->sex; ?>(1: 남, 2: 여)</td>
	</tr>
	<tr><td class="td_left" colspan="2">중복가입확인정보</td></tr>
	<tr>
		<td class="td_content" colspan="2"><font style="font-size:10px"><? echo $oivsObject->dupeInfo; ?></font> <BR>※ 아이핀번호는 동일인에게 여러 개 부여될 수 있으니 회원정보의 PK는 중복가입확인정보를 이용하여 주시기 바랍니다.</td>
	</tr>
</table>