<?php

	$code1 = $code1? $code1: 1;
	$code2 = $code2? $code2: 1;
	$code3 = $code3? $code3: 1;
	if(isset($code4) && !empty($code4)){
		${"code".$code4} = $page;
	}

	$dir1			= dir_module."/html/search".site_config_path."/"; 

	switch($mod){
		case "kor" :
			require_once $dir1."list.php"; 
			break;
		case "eng" :
			require_once "list.eng.php";
			break;
		default :
			require_once $dir1."list.php"; 
			break;
	}

?>