<?php
	
	$tbl1			= tbl_cms_icm;
	$dir1			= dir_module."/cmsctrl/m_icm/";
	$icm_pid		= $coreClass -> dataModel(1, "icm_pid", null);	
	$icm_title		= $coreClass -> dataModel(1, "icm_title", null);
	$icm_skins	= $coreClass -> dataModel(1, "icm_skins", null);
	$icm_visible	= $coreClass -> dataModel(1, "icm_visible", null);
	
	switch ($mod) {
		case "list"			: require_once $dir1.'list.php';break;
		case "insert"		: require_once $dir1.'insert.php';break;
		case "modify"	: require_once $dir1.'modify.php';break;
		case "process"	: require_once $dir1.'process.php';break;
		default			: require_once $dir1.'list.php';break;		
	}
?>