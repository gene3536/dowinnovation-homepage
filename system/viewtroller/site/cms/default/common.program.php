<?php
	// 보안서버 체크
	if($info['CMS_INFO_SSL'] == "Y") {
		if(site_client_port <> 443) $coreClass -> go(site_ssl_https."/cmsctrl/index.php");				
	}

	// IP접근제어 체크
	if($info['CMS_INFO_ACCESS'] == "Y") {
		$cmsClass -> getAccessCheck(site_client_ip);
	}

	// 관리자여부 체크
	$memberClass -> LoginCheck(1);

	define("site_count_yesterday",	$statClass -> getStatCountSum(site_config_code, 2, date("Y", mktime(0,0,0, date("m"), date("d")-1, date("Y"))), date("m", mktime(0,0,0, date("m"), date("d")-1, date("Y"))), date("d", mktime(0,0,0, date("m"), date("d")-1, date("Y"))), "", "", ""));
	define("site_count_month",	$statClass -> getStatCountSum(site_config_code, 3, site_year, site_month, "", "", "", ""));
?>