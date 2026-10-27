<?php 
	define("dir_common", "/var/www/html/dwinno");
	define("dir_public", $_SERVER["DOCUMENT_ROOT"]);
	define("dir_system", dir_common."/system");
	define("dir_site", dir_common."/system/viewtroller/site");
	define("dir_module", dir_common."/system/viewtroller/module");
	define("dir_module2", dir_common."/system/module");
	
	define("dir_backup", dir_common."/tmp/backup");
	define("dir_session", dir_common."/tmp/session");
	define("dir_logs", dir_common."/tmp/logs");
	
	// toggle this to change the setting
	define('DEBUG', true); 
	// you want all errors to be triggered
	error_reporting(E_ALL);
	if(DEBUG == true)
	{
		// you're developing, so you want all errors to be shown
		ini_set('display_errors', 'On');      
		// logging is usually overkill during dev
		ini_set('log_errors', 'Off');
	}
	else
	{
		// you don't want to display errors on a prod environment
		ini_set('display_errors', 'Off');
		// you definitely wanna log any occurring
		ini_set('log_errors', 'On');
	}

	@ini_set("session.save_path", dir_session);
	@ini_set("error_reporting", E_ALL ^ E_NOTICE);
	//@ini_set("error_reporting", E_ALL);
	//error_reporting(E_ALL);
	//@ini_set("session.cookie_domain", ".{$_SERVER[HTTP_HOST]}");

	session_start(); 
	header("Content-Type: text/html; charset=utf-8");
	date_default_timezone_set('Asia/Seoul');
?>
