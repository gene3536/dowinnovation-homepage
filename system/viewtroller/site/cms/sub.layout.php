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
	<link rel="stylesheet" type="text/css" href="/base/css/cms/board.css" />
	<link rel="stylesheet" type="text/css" href="/base/css/jquery/jquery-ui-1.10.3.custom.css" />
	
	<script type="text/javascript" src="/base/js/jquery/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="/base/js/jquery/jquery-migrate-1.2.1.js"></script>
	<script type="text/javascript" src="/base/js/jquery/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" src="/base/js/jquery/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/base/js/jquery/jquery.placeholder.js"></script>
	
	<script type="text/javascript" src="/base/js/cms/common.js"></script>    
	<script type="text/javascript" src="/base/js/chart/highcharts.js"></script>    
	<script type="text/javascript" src="/base/js/chart/exporting.js"></script>

	<script type="text/javascript" src="/base/editor/SE2/js/HuskyEZCreator.js"></script>
	<script type="text/javascript" src="/base/editor/ckeditor/ckeditor.js"></script>

</head>

<body class="subBody">
	<div id="accessibility">
	    <ul>
	        <li><a href="#content">콘텐츠로 바로가기</a></li>
	        <li><a href="#lnb">대메뉴로 바로가기</a></li>
	    </ul>
	</div>

	<div id="subWrapper">
	    <div class="headerWrap">
	        <div id="header">
	            <?php require_once("inc/common.header.php"); ?>
	            <?php require_once("inc/common.menu.php"); ?>
			</div>
	    </div>
	
	    <div class="contentWrap">
	        <div id="content" class="clearfix">
	            <div class="leftColumn">
	                <?php require_once("inc/sub.menu.php"); ?>
	            </div>
	
	            <div class="centerColumn">
	                <div class="location">
	                	<ul class="clearfix">
							<li><a href="index.php"><img src="imgs/header/ico_home.gif" alt="홈으로 이동" /></a></li>
							<?php echo site_menu_location?>
						</ul>
	                </div>
	                <div id="contentBody">
			        	<?php require_once(dir_site."/_common/sub.content.php"); ?>
	                </div>
	            </div>
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