<?php

	$tbl1				= site_cms_stat_browser;
	$code1			= empty($code1) ? 1 : $code1;
	
	$thisYear			= isset($_POST['year']) ? trim($_POST['year']) : (int) site_year;
	$thisMonth		= isset($_POST['month']) ? trim($_POST['month']) : (int) site_month;
	$thisDay			= isset($_POST['day']) ? trim($_POST['day']) : (int) site_day;
	
	$startYear			= 2013;
	$endYear			= date("Y");
	$endDay			= date("t", mktime(0, 0, 0, $thisMonth, 1, $thisYear));	
	require_once 'list.php';	
?>