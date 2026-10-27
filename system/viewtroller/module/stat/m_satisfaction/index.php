<?php
	
	$tbl1					= tbl_menu;
	$tbl2					= tbl_cms_stat_satisfaction;
	$dir					= dir_system."/viewtroller/module/stat/m_satisfaction/";
	$scode				= $pageInfo['MENU_TBL'];

	$act					= $coreClass -> dataModel(2, "act", "");
	$mkey					= $coreClass -> dataModel(2, "mkey", "");
	$code2				= $coreClass -> dataModel(2, "code2", "");
	
	switch ($mod) {
		case "list"		: require_once $dir.'list.php';break;
		case "view"		: require_once $dir.'view.php';break;
		default			: require_once $dir.'list.php';break;		
	}
?>