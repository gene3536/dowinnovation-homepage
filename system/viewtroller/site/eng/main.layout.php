<!DOCTYPE html>
<html lang="en">
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
	<link rel="stylesheet" type="text/css" href="css/board_new.css" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />


	<link rel="stylesheet" type="text/css" href="css/libs/jquery-ui.min.css" />
	<link rel="stylesheet" type="text/css" href="css/libs/animate.css" />
	<link rel="stylesheet" type="text/css" href="css/libs/aos.css" />
	<link rel="stylesheet" type="text/css" href="css/libs/slick.css" />
	<link rel="stylesheet" type="text/css" href="css/libs/lightbox.min.css" />


	<!-- 공통js -->
	<script type="text/javascript" src="js/libs/lightbox-plus-jquery.min.js"></script>
	<script type="text/javascript" src="js/libs/jquery.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/libs/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/libs/slick.min.js"></script>
	<script type="text/javascript" src="js/libs/jquery.dotdotdot.min.js"></script>
	<script type="text/javascript" src="js/libs/jquery.matchHeight-min.js"></script>
	<script type="text/javascript" src="js/libs/aos.js"></script>
	

</head>
<body class="main">
	<?php require(dir_site."/_common/cmn.popup.php"); ?>
	<!-- skip : S //-->
	<div class="skip">
		<a href="#gnb">메뉴 바로가기</a>
		<a href="#container">본문 바로가기</a>
	</div>
	<!-- wrap : S //-->
	<div class="wrap">
		<!-- header : S //-->
			<?php require_once("default/cmn.lnb.php"); ?>
		<!--// header : E-->

		<!-- container : S //-->
		<div id="container" class="main-container">

			<!-- Section01 Visual : S //-->
			<section class="main__visual" id="section01">
				<div class="main__visual-copy">
					<h2 data-animation="fadeInDown"><em>DOW </em>Innovation Corporation</h2>
					<h6 data-animation="fadeInUp" data-delay="0.2s">Key Partners for Innovation</h6>
					<p class="main__visual-txt" data-animation="fadeInUp" data-delay="0.5s">We will able to keep our company as one of the leading manufacture in the world.</p>
					<div class="main__visual-control">
						<p class="main__visual-dots"></p>
					</div>
				</div>
				<div class="main__visual-wrap">

					<div class="main__visual-item nth-1">
						<div class="bg"><p class="main__visual-img"></p></div>
					</div>

					<div class="main__visual-item nth-2">
						<div class="bg"><p class="main__visual-img"></p></div>
					</div>

					<div class="main__visual-item nth-3">
						<div class="bg"><p class="main__visual-img"></p></div>
					</div>

				</div>
				
				<div class="inner">
					<p class="main__visual-scroll">
						<a href="#section02" class="scroll-btn">
							<img src="images/main/main_scroll.png" alt="Scroll Down" class="scroll-icon" />
							<span>SCROLL</span>
						</a>
					</p>
				</div>
				<!-- Quick : S //-->
				<div class="quick">
					<ul class="quick-list" data-aos="fade-left" >
						<li class="quick-item nth-1">
							<a href="/eng/sub.php?menukey=295"><span><em>Online</em><br />Inquiry</span></a>
						</li>
					</ul>
				</div>
				<!--// Quick : E -->
				
			</section>
			<!--// Section01 Visual : E -->


			<!-- Section02 Product : S //-->
			<section class="main__product" id="section02">
				<div class="main-title inner" data-aos="fade-up">
					<h2>Product Introduction</h2>
					<p>DWI leads to the low wrapping situation as the result of Si-Ingot slicing Process</p>
				</div>
				<div class="main__product-wrap inner">
					<div class="main__product-list">
						<div class="main__product-item" data-aos="fade-up">
							<a href="/eng/sub.php?menukey=312" class="main__product-link">
								<p class="thumb"><img src="images/main/img_product01.png" alt="사물인터넷 집진시스템" /></p>
								<p class="desc">
									<span class="title">BEAM</span>
									<span class="text">It is available by BAND SAW & WIRE SAW machine for ingot slicing</span>
									<span class="zoom"></span>
								</p>
							</a>
						</div>
						<div class="main__product-item" data-aos="fade-up" data-aos-delay="100">
							<a href="/eng/sub.php?menukey=330" class="main__product-link">
								<p class="thumb"><img src="images/main/img_product02.png" alt="대기오염방지시설" /></p>
								<p class="desc">
									<span class="title">BOND</span>
									<span class="text">Epoxy Bond for Ingot Slicing Process for Semiconductor, Solar, Sapphire(LED), Quartz</span>
									<span class="zoom"></span>
								</p>
							</a>
						</div>
						<!-- <div class="main__product-item" data-aos="fade-up" data-aos-delay="300">
							<a href="/eng/sub.php?menukey=362" class="main__product-link">
								<p class="thumb"><img src="images/main/img_product04.png" alt="네일 흡진기" /></p>
								<p class="desc">
									<span class="title">MABOR</span>
									<span class="text">Epoxy Bond for Ingot Slicing Process for Semiconductor, Solar, Sapphire(LED), Quartz</span>
									<span class="zoom"></span>
								</p>
							</a>
						</div> -->


					</div>
					
				</div>
			</section>
			<!--// Section02 Product : E -->


			<!-- Section03 solution : S //-->
			<section class="main__solution" id="section03">
				<div class="main__solution-wrap inner">
					<div class="main__solution-title" data-aos="fade-up">
						<h2><span>Total Solution</span> OF Slicing Work</h2>
						<h3>DWI will find a good performance items and support to customers</h3>
					</div>
					<div class="main__smart-desc">
						<p class="text" data-aos="fade-up">DWIZ Cropping Beam</p>
						<p class="text" data-aos="fade-up" data-aos-delay="100">DWIZ Slicing Beam</p>
						<p class="text" data-aos="fade-up" data-aos-delay="200">DWIZ Epoxy Glue</p>
						<a href="/eng/sub.php?menukey=364" class="link"><span>MORE</span></a>
					</div>
				</div>
			</section>
			<!--// Section03 solution : E -->


			<!-- Section04 story : S //-->
			<section class="main__story" id="section04">
				<div class="main-title inner" data-aos="fade-up">
					<h2>DWI Story</h2>
					<p>Key Partners for Innovation, Dow Innovation Corporation</p>
				</div>
				<div class="main__story-wrap inner">
					<div class="main__story-inner">
						<div class="main__vod-box" data-aos="fade-up">
							<div class="main__vod-vod">
								<!-- 홍보동영상 : s //-->
								<iframe src="https://www.youtube.com/embed/9chEcUtswKE" allowfullscreen></iframe>
								<!--// 홍보동영상 : e -->
							</div>
						</div>
						<div class="main__vod-box">
							<div class="main__news" data-aos="fade-left" data-aos-delay="100">
								<div class="main__news-title">
									<h2>News</h2>
									<a href="/home/sub.php?menukey=125" class="link"></a>
								</div>
								<div class="main__news-item">
									<?php echo $boardClass->getNotice_one('00000002','132','eng') ;?>
								</div>
							</div>
							<div class="main__customer-box">
								<ul class="main__customer">
									<li class="nth-1" data-aos="fade-up" data-aos-delay="100"><a href="/eng/sub.php?menukey=309"><span>Certificates</span></a></li>
									<li class="nth-2" data-aos="fade-up" data-aos-delay="200"><a href="/eng/sub.php?menukey=365"><span>Network</span></a></li>
									<li class="nth-3" data-aos="fade-up" data-aos-delay="300"><a href="/eng/sub.php?menukey=295"><span>Online<br />Inquiry</span></a></li>
								</ul>
							</div>
						</div>
						
					</div>
				</div>
			</section>
			<!--// Section04 Vod : E -->



		</div>
		<!--// container : E -->

		<!-- footer //-->
		<?php require_once("default/cmn.footer.php"); ?>
		<!--// footer-->
			

		</div>
		<!--// wrap : E -->

		<!-- Animation of Scroll : s //-->
		<script>
		$(document).ready(function() {
			setTimeout(function() {
				AOS.init({
				easing: 'ease-out-back',
				duration: 800,
				offset : 100
			});
			}, 500);

		});
		</script>
		<!--// Animation of Scroll : e -->
	</body>
</html>