<?php

	$tbl1				= tbl_cms_stat_count;
	$tbl2				= tbl_cms_info;
	$code1			= empty($code1) ? 1 : $code1;
	
	$thisYear			= isset($_POST['year']) ? trim($_POST['year']) : (int) site_year;
	$thisMonth		= isset($_POST['month']) ? trim($_POST['month']) : (int) site_month;
	$thisDay			= isset($_POST['day']) ? trim($_POST['day']) : (int) site_day;
	
	$startYear			= 2018;
	$endYear			= date("Y");
	$endDay			= date("t", mktime(0, 0, 0, $thisMonth, 1, $thisYear));

	$totalCount 		= $statClass -> getStatCountSum($scode, 1, "", "", "", "", "", "");
	$yearCount		= $statClass -> getStatCountSum($scode, 4, $thisYear, "", "", "", "", "");
	$monthCount	= $statClass -> getStatCountSum($scode, 3, $thisYear, $thisMonth, "", "", "", "");
    $dayCount		= $statClass -> getStatCountSum($scode, 2, $thisYear, $thisMonth, $thisDay, "", "", "");	
	
    switch ($mod) {
    	case "list"			: require_once 'list.php';break;
    	case "report"		: require_once 'report.php';break;
    	case "pagelog"	: require_once 'pagelog.php';break;
    	default			: require_once 'list.php';break;
    }
?>