<div id="logo"><h1><a href="main.php"><img src="imgs/header/logo.gif" alt="KFIA 한국식품산업협회" /></a></h1></div>
<div class="gnb">
	<ul>
		<li class="first"><a href="main.php">Home</a></li>
		<li><a href="sub.php?menukey=285">Sitemap</a></li>
		<li><a href="sub.php?menukey=265">English</a></li>
		<!-- <li><a href="#" onclick="return false;"><b><?php echo S_mb_name?></b> 접속중</a></li> -->
		<?php if(S_mb_login) { ?>
			<li><a href="/member/member.php?memberkey=9&amp;mod=process&amp;act=memberLogout&token=<?php echo site_config_token?>">로그아웃</a></li>
		<?php } else { ?>
			<li><a href="/member/member.php?memberkey=1&amp;refcode=1">로그인</a></li>
		<?php } ?>
	</ul>
</div>