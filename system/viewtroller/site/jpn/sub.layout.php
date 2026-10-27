<!DOCTYPE html>
<html lang="jp">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
	<meta name="format-detection" content="telephone=no, address=no, email=no" />
	<meta name="description" content="DOWIZ">
	<meta name="keyword" content="DOWIZ">
	<meta name="theme-color" content="#8ec54a">

	<!-- Open Graph -->
	<meta property="og:url" content="http://www.dowbeam.com/">
	<meta property="og:type" content="website">
	<meta property="og:image" content="images/dowbeam.png">
	<meta property="og:title" content="DOWIZ">
	<meta property="og:description" content="DOWIZ">

	<!-- Favicon 설정 -->
	<link rel="shortcut icon" href="images/favicon/favicon.ico">
	<link rel="shortcut icon" href="images/favicon/favicon.png">
	<link rel="apple-touch-icon-precomposed" href="images/favicon/favicon-152.png">
	<meta name="msapplication-TileColor" content="#fffff">
	<meta name="msapplication-TileImage" content="images/favicon/favicon-144.png">


	<title>DOWIZ</title>

	<!--  css -->
	<link rel="stylesheet" type="text/css" href="css/reset.css" />
	<link rel="stylesheet" type="text/css" href="css/common.css" />
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/board2021.css" />
	<link rel="stylesheet" type="text/css" href="css/contents.css" />


	<link rel="stylesheet" type="text/css" href="css/libs/jquery-ui.min.css" />
	<link rel="stylesheet" type="text/css" href="css/libs/animate.css" />
	<link rel="stylesheet" type="text/css" href="css/libs/aos.css" />
	<link rel="stylesheet" type="text/css" href="css/libs/slick.css" />
	<link rel="stylesheet" type="text/css" href="css/libs/lightbox.min.css" />


	<!-- 공통js -->
	<script type="text/javascript" src="js/libs/lightbox-plus-jquery.min.js"></script>
	<script type="text/javascript" src="js/libs/jquery.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/board.js"></script>
	<script type="text/javascript" src="js/libs/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/libs/slick.min.js"></script>
	<script type="text/javascript" src="js/libs/jquery.matchHeight-min.js"></script>
	<script type="text/javascript" src="js/libs/aos.js"></script>

	<script type="text/javascript" src="/base/js/jquery/jquery.validate.min.js"></script>
	<script type="text/javascript" src="/base/editor/SE2/js/HuskyEZCreator.js"></script>
	<script type="text/javascript" src="/base/editor/ckeditor/ckeditor.js"></script>	
	<script type="text/javascript" src="/base/js/cms/util.js"></script> 
	

</head>

<body class="body-sub">
	<!-- skip : S //-->
	<div class="skip">
		<a href="#gnb">메뉴 바로가기</a>
		<a href="#container">본문 바로가기</a>
	</div>
	<!-- //skip : E -->



	<!-- wrap : S //-->
	<div class="wrap">
		<!-- header : S //-->
		<?php require_once("default/cmn.lnb.php"); ?>
		<!--// header : E-->

		<!-- container : S //-->
		<div id="container">


			<!-- Visual Contents : S //-->
			<div class="visual__contents">
				<div class="visual__contents-inner">

					<!-- sub Visual : S //-->
					<?
					$menuinfo = $menuClass->getMenu($menukey);
					$ntn_class = 'nth-'.$menuinfo['MENU_ROOT'];
					$subtitle = $menuClass->get_subtitle2($menukey);
					
				?>
					<div class="sub_visual <?=$ntn_class?>">
						<div class="sub_visual-inner">
							<div class="sub_title">
								<h2 data-aos="fade-down"><?= $menuClass->submenuArr[1][0]['MENU_TITLE'] ?></h2>
								<p data-aos="fade-up" data-aos-delay="400">DOW Innovation Corporation</p>
							</div>
						</div>
					</div>
					<!--// sub Visual : E -->
					<!-- LNB : S //-->
						<?php require_once("default/sub.leftmenu.php"); ?>
					<!--// LNB : E -->
					</div>
				</div>
				<!--// Visual Contents : E -->


				<!-- Sub Contents : S //-->
				<div class="subContents">

					<!-- Sub Title //-->
					<div class="contents__title" data-aos="fade-up" data-aos-delay="300">
						<div class="inner">
							<h3 data-aos="fade-up" data-aos-delay="600" data-aos-easing="ease-out-back"><span><?php echo $subtitle?></span></h3>
						</div>
					</div>
					<!--// Sub Title -->

					<!-- 컨텐츠 영역 : S //-->
					<div class="contents">

						
						<!-- 컨텐츠 start //-->
						<?php require_once(dir_site."/_common/sub.content.php"); ?>
						<!--// 컨텐츠 end -->
					</div>
					<!-- // 컨텐츠 영역 :E -->


				</div>
				<!--// Sub Contents : E-->

			</div>
			<!--// container : E -->


		<!-- FOOTER 시작 -->
		<?php require_once("default/cmn.footer.php"); ?>
		<!-- //FOOTER 끝// -->
	
</div>
<!--// wrap : E -->

<!-- Animation of Scroll : s //-->
<script>
$(document).ready(function() {
	setTimeout(function() {
		AOS.init({
		easing: 'ease-out-back',
		duration: 500
	});
	}, 500);

});
</script>
<!--// Animation of Scroll : e -->
</body>
</html>