<?php
	
	$tbl1			= tbl_member;
	$tbl2			= tbl_member_login;
	$tbl3			= tbl_board_data;
	
	$info3			= $coreClass -> dataModel(1, "info3", NULL);
	if(!empty($info3)) $info3 = $coreClass -> crypt_sha256($info3);
	$info4			= $coreClass -> dataModel(1, "info4", NULL);
	if(!empty($info4)) $info4 = $coreClass -> crypt_sha256($info4);
	
	$mb_tel		= $coreClass -> dataModel(1, "mb_tel", NULL);
	if(!empty($mb_tel)) $mb_tel = $coreClass -> crypt_md5($mb_tel, site_config_mbkey);
	$mb_email	= $coreClass -> dataModel(1, "mb_email", NULL);
	if(!empty($mb_email)) $mb_email = $coreClass -> crypt_md5($mb_email, site_config_mbkey);
	
	switch ($mod) {
		case "modify"	: require_once 'modify.php';	break;
		case "process"	: require_once 'process.php'; break;	
	}
?>