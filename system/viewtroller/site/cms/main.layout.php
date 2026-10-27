<?php require_once("default/common.program.php"); ?>
<!doctype html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?php echo site_config_title?></title>

	<link rel="stylesheet" type="text/css" href="/base/css/cms/basic.css" />
	<link rel="stylesheet" type="text/css" href="/base/css/cms/layout.css" />
	<link rel="stylesheet" type="text/css" href="/base/css/cms/lib.css" />
	<link rel="stylesheet" type="text/css" href="/base/css/cms/ui.css" />
</head>

<body class="mainBody">
	<div id="accessibility">
	    <ul>
	        <li><a href="#content">콘텐츠로 바로가기</a></li>
	        <li><a href="#lnb">대메뉴로 바로가기</a></li>
	    </ul>
	</div>

	<div id="mainWrapper">
	    <div class="headerWrap">
	        <div id="header">
				<?php require_once("inc/common.header.php"); ?>
				<?php require_once("inc/common.menu.php"); ?>
			</div>
	    </div>    
	
	    <div class="contentWrap">
	        <div id="content">
				<?php require_once("inc/main.content1.php"); ?>
				<?php require_once("inc/main.content2.php"); ?>
				<?php require_once("inc/main.content3.php"); ?>
	        </div>
	    </div>
	    
	    <div class="footerWrap">
	        <div id="footer">
	        	<?php require_once("inc/common.footer.php"); ?>
	        </div>
	    </div>
	</div>
</body>
</html>