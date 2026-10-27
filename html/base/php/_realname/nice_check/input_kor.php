<?
include_once $_SERVER["DOCUMENT_ROOT"]."/_config/config.php";
/***
echo "aaa".$HTTP_REFERER = $_SERVER["HTTP_REFERER"];


if(in_array($HTTP_REFERER,$HTTP_REFERER_DOMAIN_ARR) && !$HTTP_REFERER) {
	echo "bb";
}else{
	echo $HTTP_REFERER;
	warning("외부주소에서 호출불가능 합니다.");

}
**/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta http-equiv='X-UA-Compatible' content='IE=EmulateIE7' />
<title>안심 실명확인 서비스</title>
<link rel="stylesheet" href="/_prog/_realname/nice_check/css/certnc.css" type="text/css" media="all" />
<meta name="author" content="독립기념관" />
<meta name="description" content="독립기념관에 오신것을 환영합니다." />
<script src="/js/jquery.js" type="text/javascript" ></script>
<script src="/js/kr/content.js" type="text/javascript" ></script>
<script src="/js/javascript.js" type="text/javascript" ></script>
<script src="/js/font_zoom.js" type="text/javascript" ></script>
<script src="/js/flash.js" type="text/javascript"></script>

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

	function lengthCheck( checkTag )
	{
		if ( checkTag.name == "userNo1" )
		{
			if ( checkTag.value.length >= 6 )
			{
				checkTag.blur();
				document.all.userNo2.focus();
			}
		}
	}

	function loadAction()
	{
		document.pageForm.userNm.focus();
	}

	function validate()
	{
		var userNm = document.pageForm.userNm;
		var userNo1 = document.pageForm.userNo1;
		var userNo2 = document.pageForm.userNo2;
		var foreigner = document.pageForm.foreigner;
		var userNo = userNo1.value + userNo2.value;

		if ( userNm.value == "" )
		{
			//alert( getCheckMessage( "S23" ) );
			userNm.focus();
			return false;
		}

		if ( userNo1.value == "" )
		{
			if ( foreigner.value == "2" )
				alert( getCheckMessage( "S27" ) );
			else
				alert( getCheckMessage( "S21" ) );
			userNo1.value = "";
			userNo1.focus();
			return false;
		}

		if ( userNo2.value == "" )
		{
			if ( foreigner.value == "2" )
				alert( getCheckMessage( "S27" ) );
			else
				alert( getCheckMessage( "S21" ) );
			userNo2.value = "";
			userNo2.focus();
			return false;
		}

		if ( foreigner.value == "2" )
		{
			if ( checkForeignNm( userNm.value ) == false )
			{
				alert( getCheckMessage( "S28" ) );
				document.all.userNm.focus();
				return false;
			}

			if ( checkForeignNo( userNo ) == false )
			{
				alert( getCheckMessage( "S26" ) );
				document.all.userNo2.focus();
				return false;
			}
		}
		else
		{
			if ( checkString( userNm.value ) == false )
			{
				alert( getCheckMessage( "S24" ) );
				userNm.focus();
				return false;
			}

			if ( checkNumeric( userNo ) == false )
			{
				alert( getCheckMessage( "S25" ) );
				userNo1.focus();
				return false;
			}
		}

		return true;
	}

	function goIDCheck()
	{
		if ( validate() == true )
		{
			var strNm = document.pageForm.userNm.value;
			var strNo = document.pageForm.userNo1.value + document.pageForm.userNo2.value;
			var strRsn = document.pageForm.inqRsn.value;
			var strForeigner = document.pageForm.foreigner.value;
			document.inputForm.SendInfo.value = makeSendInfo( strNm, strNo, strRsn, strForeigner );

			var form = document.inputForm;
			form.submit();
		}

		return;
	}

	function numbersonly(e, decimal) {
		var key;
		var keychar;

		if (window.event) {
			key = window.event.keyCode;
		} else if (e) {
			key = e.which;
		} else {
			return true;
		}
		keychar = String.fromCharCode(key);

		if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13)
				|| (key == 27)) {
			return true;
		} else if ((("0123456789").indexOf(keychar) > -1)) {
			return true;
		} else if (decimal && (keychar == ".")) {
			return true;
		} else
			return false;
	}


</script>
<script type="text/javascript">jQuery(document).ready(function() {jQuery('a[rel*=facebox]').facebox();imgOperation();})</script>
<!--script language="javascript">

document.oncontextmenu=new Function('return false');   // 우클릭 방지
document.ondragstart=new Function('return false');     // 드래그 방지
document.onselectstart=new Function('return false');   // 선택방지

</script-->
</head>
	<body onload="javascript:loadAction();" >
		<FORM name="inputForm" method="POST" action="/_prog/_realname/nice_check/output.php">
			<input type="hidden" id="SendInfo" name="SendInfo"></input>
		</FORM>


	<div class="Pop_Wrapper">
		<div class="Pop_Head"><img src="/_prog/_realname/nice_check/img/top_name_tit.gif" width="201" height="36" border="0" alt="(업체명) 실명확인서비스 National Research Foundation of Korea"></div>
		<div class="Pop_Body">

			<ul id="tab">
			<li><a href="?gbn=kor" target="_self"><img src="/_prog/_realname/nice_check/img/tab01_ov.gif" width="94" height="26" border="0" alt="실명확인"></a></li>
			<li><a href="?gbn=for" target="_self"><img src="/_prog/_realname/nice_check/img/tab03.gif" width="146" height="26" border="0" alt="Name verification for foreigners"></a>

			<div class="Pop_Content">
			<h4 class="top_mar_10">실명확인</h4>
			<ul class="h5_ul blgr bott_mar_10">
				<li>귀하가 입력하시는 주민등록번호는 실명확인 목적으로 사용됩니다.</li>
			</ul>
			<div class="clear"></div>
	<form name="pageForm" method="POST">
	<!--	내/외국인 구분을 설정하십시오. ( '1'-내국인, '2'-외국인 )	-->
	<input type="hidden" id="foreigner" name="foreigner" value="1"></input>
	<!--	조회사유를 설정하십시오. ( '10'-회원가입, '20'-기존회원 확인, '30'-성인인증, '40'-비회원 확인, '90'-기타 사유 )	-->
	<input type="hidden" id="inqRsn" name="inqRsn" value="10"></input>

			<div class="findBox top_mar_5">
			 <fieldset class="member_find">
			  <legend>아이디/패스워드 찾기</legend>
			  <dl>
			   <dt><label for="email">성명</label></dt><dd><input name="userNm" id="userNm" type="text" size="21" title="성명"/></dd>
			   <dt><label for="hname">주민등록번호</label></dt><dd><input name="userNo1" id="userNo1" type="text" size="9" maxlength='6' onKeyUp="javascript:lengthCheck( this );" style="ime-mode:disabled;"  onKeyPress="return numbersonly(event, false)" title="주민등록번호 앞자리"/>&nbsp;-&nbsp;<input name="userNo2" id="userNo2" type="password" size="9" maxlength='7' onKeyUp="javascript:lengthCheck( this );" style="ime-mode:disabled;"  onKeyPress="return numbersonly(event, false)" title="주민등록번호 뒷자리"/></dd>
			  </dl>
			  <p class="no_mar no_padd ft_right commfing"><input name="Confirm" type="button" id="Confirm" value="실명 확인" onclick="goIDCheck();"></p>
			 </fieldset>
			</div>
	</form>

			<div class="box_gray01 top_mar_10"></div>
			<ul class="h52_ul gray boxGray">
				<li>귀하의 주민등록번호는 지식경제부로부터 허가 받은 신용정보 회사인 한국신용정보를 통해 실명과의 일치 여부 확인에 사용합니다.</li>
				<li>2006년 9월 24일부터 개정된 주민등록법에 의해 타인의 주민번호를 도용하여 온라인 회원가입을 하는 등 다른 사람의 주민등록번호를 부정사용자는 3년 이하의 징역 또는 1천만원 이하의 벌금이 부과될 수 있습니다.</li>
				<li>귀하가 입력하신 정보는 128 bit SSL 암호화 방식을 통해 채널/데이터 암호화 방식으로 안전하게 송수신 됩니다. </li>
			</ul>
			<div class="box_gray02 bott_mar_10"></div>

			<p class="center no_mar no_padd"><a href="http://www.idcheck.co.kr/idcheck/namereg/namereg02.do" target="_blank" title="클릭시 새창으로 이동합니다."><img src="/_prog/_realname/nice_check/img/btn_center.gif" width="360" height="26" border="0" alt="실명등록센터 바로 가기(실명확인에 문제가 있으시면 클릭해 주세요!)"></a></p>
			</div>

			</li>
		</ul>
		</div>

			<div class="Pop_Foot"><img src="/_prog/_realname/nice_check/img/foot_logo.gif" border="0" alt="한국신용정보`"></div>
	</div>


	</body>
</html>
