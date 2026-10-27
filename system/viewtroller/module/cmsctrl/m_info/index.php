<?php

	$dir1				= dir_system."/viewtroller/module/cmsctrl/m_info/";

	$tbl1				= tbl_cms_info;
	$info_type			= $coreClass -> dataModel(1, "siteType", null);
	$info_title			= $coreClass -> dataModel(1, "siteTitle", null);
	$info_code			= $coreClass -> dataModel(1, "siteCode", null);
	$info_url1			= $coreClass -> dataModel(1, "siteUrl1", null);
	$info_url2			= $coreClass -> dataModel(1, "siteUrl2", null);
	$info_path			= $coreClass -> dataModel(1, "sitePath", null);
	$info_copyright		= $coreClass -> dataModelNoXss(1, "siteCopyright", null);
	$info_level			= $coreClass -> dataModel(1, "siteLevel", null);
	$info_slevel		= $coreClass -> dataModel(1, "siteSLevel", null);
	$info_alevel		= $coreClass -> dataModel(1, "siteALevel", null);
	$info_glevel		= $coreClass -> dataModel(1, "siteGLevel", null);
	$info_access		= $coreClass -> dataModel(1, "siteAccess", null);
	$info_ssl			= $coreClass -> dataModel(1, "siteSSL", null);
	$info_maptype		= $coreClass -> dataModel(1, "siteMapType", null);
	$info_map			= $coreClass -> dataModel(1, "siteMap", null);
	$info_menudb		= $coreClass -> dataModel(1, "siteMenudb", null);
	$info_mouse			= $coreClass -> dataModel(1, "siteMouse", null);
	$info_mourl			= $coreClass -> dataModel(1, "siteMourl", null);
	$info_pagelog		= $coreClass -> dataModel(1, "sitePagelog", null);
	$info_editor		= $coreClass -> dataModel(1, "siteEditor", null);
	
	$info_uname			= $coreClass -> dataModel(1, "siteUname", null);
	$info_tel			= $coreClass -> dataModel(1, "siteTel", null);
	$info_summary		= $coreClass -> dataModel(1, "siteSummary", null);
	$info_inquiry		= $coreClass -> dataModelNoXss(1, "inquiryHeader", null);

	switch ($mod) {
		case "list"		: require_once $dir1.'list.php';break;
		case "insert"	: require_once $dir1.'insert.php';break;
		case "modify"	: require_once $dir1.'modify.php';break;
		case "process"	: require_once $dir1.'process.php';break;
		default			: require_once $dir1.'list.php';break;
	}
?>