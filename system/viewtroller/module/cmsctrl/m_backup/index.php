<?php
		
	$tbl1			= tbl_cms_backup;
	$dir1			= dir_system."/viewtroller/module/cmsctrl/m_backup/";
	$save_path	= dir_backup;
		
	switch ($mod) {
		case "list"			: require_once $dir1.'list.php';break;
		case "process"	: require_once $dir1.'process.php';break;
		default			: require_once $dir1.'list.php';break;		
	}
?>