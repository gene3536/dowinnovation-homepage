<?php

	$tbl1 = tbl_cms_stat_session;	
	$dir1 = dir_system."/viewtroller/module/stat/m_session/";
	switch ($mod) {
		case "list"			: require_once $dir1.'list.php';		break;
		case "process"	: require_once $dir1.'process.php';	break;
		default			: require_once $dir1.'list.php';		break;		
	}
?>