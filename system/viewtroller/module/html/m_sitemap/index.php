<?php
	/** 사이트맵 - 140625 */
	
	$tbl1			= tbl_menu;
	$dir1			= dir_module."/html/m_sitemap".site_config_path."/"; 
	switch ($mod) {
		case "list"		: require_once $dir1.'list.php';break;
		default			: require_once $dir1.'list.php';break;		
	}
?>