<?php require_once("default/index.program.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>관리자페이지 로그인</title>
	
	<link rel="stylesheet" type="text/css" href="/base/css/cms/basic.css" />
	<link rel="stylesheet" type="text/css" href="/base/css/cms/layout.css" />
	
	<script type="text/javascript" src="/base/js/jquery/jquery-1.10.2.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#usr").focus();
		});
	</script>
</head>

<body class="loginWrapperBack">
	<div id="loginWrapper">
	<form id="login" name="login" method="post" action="control.php?menuId=login">
		<div id="crmLoginBox">
			<div class="crmLoginTit">
				<p class="tit"><span>Administrator</span> Mode</p>
				<p>관리자 로그인을 원하시면 아이디와 비밀번호를 입력해주세요.</p>
			</div>
			<div class="companyName"><span><?php echo site_config_title?></span></div>	
			<div class="loginBox" class="clearfix">
				<span class="item">
					<label class="i_label" for="usr">아이디</label>
					<input type="text" id="usr" name="usr" tabindex="1" />
				</span>
				<span class="item">
					<label class="i_label" for="usrwd">비밀번호</label>
					<input type="password" name="usrwd" id="usrwd" tabindex="2" />
				</span>
				<input type="submit" class="loginBtn" value="LOGIN" title="LOGIN" />
			</div>	
			<p class="loginText">회원님의 정보보호를 위하여 <span class="point">로그인 후 약 30분간 화면 이동이 없는 경우 로그인을 종료</span>합니다.</p>	       
	    </div>
		<div class="copyright"><?php echo site_config_copyright?></div>
	</form>
	</div>
</body>
</html>