<h1 id="logo"><a href="main.php"><?php echo site_config_title?></a></h1>
<div id="version">
	<ul class="clearfix">
		<li class="first"><?php echo site_client_ip?></li>
		<li><?php echo site_client_browser_type?></li>
		<li><span class="name"><?php echo S_mb_name?>님</span></li>
		<li>최근접속 : <?php echo $mbLog["MB_LOG_REGDATE"]?> (<?php echo $mbLog["MB_LOG_REGIP"]?>)</li>
		<li>Today : <strong><?php echo number_format(site_count_today)?></strong></li>
		<li>Total : <?php echo number_format(site_count_total)?></li>
	</ul>
</div>
<!--<div class="contanct"><?php echo date("Y년 m월 d일")?> <strong><?php echo S_mb_name?> 접속중</strong></div>-->
<ul id="gnb">
	<li class="logout"><a href="control.php?menuId=logout">로그아웃</a></li>
	<li class="homepage"><a href="/home/main.php" target="_self" title="홈페이지이동">홈페이지바로가기</a></li>
</ul>