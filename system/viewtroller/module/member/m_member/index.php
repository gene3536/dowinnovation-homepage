<?php
	/** 140624 */
	$tbl1			= tbl_member;
	$tbl2			= tbl_member_login;
	$tbl3			= tbl_member_org;
	$tbl4			= tbl_member_level; 
	$dir1			= dir_module."/member/m_member".site_config_path."/"; 
	$dir2			= dir_module."/member/m_member".site_config_path."/".site_menu_skins."/"; 

	$code1			= empty($code1) ? 1 : $code1;
	$info1			= $coreClass -> dataModel(1, "info1", null);
	$info2			= $coreClass -> dataModel(1, "info2", null);
	
	// 비밀번호 암호화
	$info3			= $coreClass -> dataModel(1, "info3", null);
	if(!empty($info3)) $info3 = $coreClass -> crypt_sha256($info3, site_config_mbkey);
	$info4			= $coreClass -> dataModel(1, "info4", null);
	if(!empty($info4)) $info4 = $coreClass -> crypt_sha256($info4, site_config_mbkey);
	
	$mb_name	= $coreClass -> dataModel(1, "mb_name", null); 
	$mb_pass	= $mb_pass_ori	= $coreClass -> dataModel(1, "mb_pass", null); 
	$mb_pass	= $coreClass -> crypt_sha256($mb_pass, site_config_mbkey);
	$mb_pass1	= $mb_pass_ori2	= $coreClass -> dataModel(1, "mb_pass1", null); 
	$mb_pass1	= $coreClass -> crypt_sha256($mb_pass1, site_config_mbkey);
	$mb_pass2	= $coreClass -> dataModel(1, "mb_pass2", null); 
	$mb_pass2	= $coreClass -> crypt_sha256($mb_pass2, site_config_mbkey);
	$mb_level	= $coreClass -> dataModel(1, "mb_level", null);
	$mb_org		= $coreClass -> dataModel(1, "mb_org", null);
	$mb_tel		= $coreClass -> dataModel(1, "mb_tel", null);
	$mb_uid		= $coreClass -> dataModel(1, "mb_uid", null);
	$mb_tel		= $coreClass -> crypt_md5($mb_tel, site_config_mbkey);
	$mb_email	= $mb_email_ori	= $coreClass -> dataModel(1, "mb_email", null);
	$mb_email	= $coreClass -> crypt_md5($mb_email, site_config_mbkey);
	$mb_scode	= $coreClass -> dataModel(1, "mb_scode", null);
	$mb_scode	= $mb_scode == null ? $coreClass -> dataModel(1, "scodevar", null) : $mb_scode;

	$mb_name1	= $coreClass -> dataModel(1, "mb_name1", null); 
	$mb_name2	= $coreClass -> dataModel(1, "mb_name2", null); 
	$mb_email1	= $coreClass -> dataModel(1, "mb_email1", null);
	$mb_email1	= $coreClass -> crypt_md5($mb_email1, site_config_mbkey);
	$mb_email2	= $coreClass -> dataModel(1, "mb_email2", null);
	$mb_email2	= $coreClass -> crypt_md5($mb_email2, site_config_mbkey);

	$mb_level_title		= $coreClass -> dataModel(1, "mb_level_title", null);
	$mb_level_visible	= $coreClass -> dataModel(1, "mb_level_visible", null);

	$agreeVar1	= $coreClass -> dataModel(1, "agreeVar1", null);
	$agreeVar2	= $coreClass -> dataModel(1, "agreeVar2", null);

	$return_url	= urldecode($coreClass -> dataModel(2, "return_url", null)); 
	
	switch ($mod) {		
		case "auth"			: require_once $dir1.'auth.php';		break;
		case "list"			: require_once $dir1.'list.php';		break;
		case "view"			: require_once $dir1.'view.php';		break;
		case "insert"		: require_once $dir1.'insert.php';		break;
		case "modify"		: require_once $dir1.'modify.php';		break;
		case "login"		: require_once $dir1.'login.php';		break;
		case "logout"		: require_once $dir1.'logout.php';		break;
		case "levelList"	: require_once $dir1.'levelList.php';	break;
		case "levelInsert"	: require_once $dir1.'levelInsert.php';	break;
		case "levelModify"	: require_once $dir1.'levelModify.php';	break;
		case "levelDelete"	: require_once $dir1.'levelDelete.php';	break;
		case "process"		: require_once $dir1.'process.php';		break;
		
		case "agree"		: require_once $dir1.'agree.php';		break;
		case "join"			: require_once $dir1.'join.php';		break;
		case "find"			: require_once $dir1.'find.php';		break;	
		case "leave1"		: require_once $dir1.'leave1.php';		break;	
		case "leave2"		: require_once $dir1.'leave2.php';		break;
		case "leave3"		: require_once $dir1.'leave3.php';		break;
		default				: require_once $dir1.'auth.php';		break;	
	}
?>