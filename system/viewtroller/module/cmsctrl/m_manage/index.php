<?php

	$dir1						= dir_system."/viewtroller/module/cmsctrl/m_manage/";
	$tbl1						= tbl_cms_manage;
	$tbl2						= tbl_cms_info;
	$tbl3						= tbl_member;
	
	$cms_manage_uid		= $coreClass -> dataModel(1, "cms_manage_uid", NULL);
	$cms_manage_scode	= $coreClass -> dataModel(1, "scodevar", NULL);
	
	switch ($mod) {
		case "list"			: require_once $dir1.'list.php';		break;
		case "insert"		: require_once $dir1.'insert.php';	break;
		case "modify"	: require_once $dir1.'modify.php';	break;
		case "process"	: require_once $dir1.'process.php';	break;
		default			: require_once $dir1.'list.php';		break;		
	}
?>