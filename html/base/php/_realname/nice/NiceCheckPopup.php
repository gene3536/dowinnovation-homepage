<?php

	require_once( "nice.nuguya.oivs.php" );


	$oivsObject = new OivsObject();

	$strRecvData 	= $_POST[ "SendInfo" ];
	$blRcv 		= $oivsObject->resolveClientData( $strRecvData );

?>

<LINK href="./nice.nuguya.oivs.css" type=text/css rel=stylesheet>

<table width="100%" cellpadding="3" cellspacing="1" bgcolor="#999900">
	<tr><td class="td_left">회원사 아이디</td>
		<td class="td_content"><? echo $oivsObject->niceId; ?></td>
	</tr>
	<tr><td class="td_left">주문번호</td>
		<td class="td_content"><? echo $oivsObject->ordNo; ?></td>
	</tr>
	<tr><td class="td_left">거래번호</td>
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
	<tr><td class="td_left">실명인증키번호</td>
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
		<td class="td_content" colspan="2"><font style="font-size:10px"><? echo $oivsObject->dupeInfo; ?></font> <BR>※ 한국신용정보에서 제공하는 다른 서비스(나이스 아이핀, 개인실명확인)를 이용하는 경우 하나의 주민번호에 고유값이 발급됩니다.</td>
	</tr>
</table>