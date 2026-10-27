<?php
	/**
	 * CMS 컨트롤러
	 */
	// 기본설정
	require_once($_SERVER["DOCUMENT_ROOT"]."/../system/config/info.php"); 
	require_once("constant.php");
	require_once("database-mysql.php"); 
	require_once(dir_system."/class/module.class.php");	 

	// 공통클래스모듈 설정
	$coreClass = new coreClass();	
	$cmsClass = new cmsClass(); 
	
	define("site_config_host", $_SERVER['HTTP_HOST']);
	define("site_config_dir", str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])));	
	$cmsClass -> getSiteInfo(site_config_host, site_config_dir);
	die;
?>