<?php
		
	$tbl1			= tbl_cms_access;
	$dir1			= dir_system."/viewtroller/module/cmsctrl/m_access/";
	$acs_title		= $coreClass -> dataModel(2, "acs_title", null);
	$acs_ip		= $coreClass -> dataModel(2, "acs_ip", null);
	$acs_visible	= $coreClass -> dataModel(2, "acs_visible", null);
		
	switch ($mod) {
		case "list"			: require_once $dir1.'list.php';break;
		case "insert"		: require_once $dir1.'insert.php';break;
		case "modify"	: require_once $dir1.'modify.php';break;
		case "process"	: require_once $dir1.'process.php';break;
		default			: require_once $dir1.'list.php';break;		
	}
?>