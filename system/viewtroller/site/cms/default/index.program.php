<?php
	// 보안서버 체크
	if($info['CMS_INFO_SSL'] == "Y") {
		if(site_client_port <> 443) $coreClass -> go("https://".$_SERVER['HTTP_HOST']."/cmsctrl/index.php");
	}

	// IP접근제어 체크
	if($info['CMS_INFO_ACCESS'] == "Y") {
		$cmsClass -> getAccessCheck(site_client_ip);
	}
	
	// 관리자여부 체크
	$coreClass -> LoaderClass("member");
	$memberClass = new memberClass();
	$memberClass -> LoginCheck(2);
?>