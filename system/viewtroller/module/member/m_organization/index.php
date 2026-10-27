<?php

	$tbl1						= tbl_organization;
	$tbl2						= tbl_organization_member;
	$tbl3						= tbl_member;
	$dir1						= 
	$dir1						= dir_module."/member/m_organization/";
	
	$code1					= empty($code1) ? "1" : $code1;
	$code2					= empty($code2) ? "999" : $code2;

	$organ_step				= $coreClass -> dataModel(1, "organ_step", null);
	$organ_uid				= $coreClass -> dataModel(1, "organ_uid", null);
	$organ_name			= $coreClass -> dataModel(1, "organ_name", null);
	$organ_visible			= $coreClass -> dataModel(1, "organ_visible", null);
	$organ_extension		= $coreClass -> dataModel(1, "organ_extension", null);
	$organ_content			= $coreClass -> dataModel(1, "organ_content", null);

	$organ_mb_type			= $coreClass -> dataModel(1, "organ_mb_type", null);	
	$organ_mb_name		= $coreClass -> dataModel(1, "organ_mb_name", null);
	$organ_mb_uid			= $coreClass -> dataModel(1, "organ_mb_uid", null);
	$organ_mb_tel			= $coreClass -> dataModel(1, "organ_mb_tel", null);
	$organ_mb_fax			= $coreClass -> dataModel(1, "organ_mb_fax", null);
	$organ_mb_email		= $coreClass -> dataModel(1, "organ_mb_email", null);
	$organ_mb_position	= $coreClass -> dataModel(1, "organ_mb_position", null);
	$organ_mb_extension	= $coreClass -> dataModel(1, "organ_mb_extension", null);
	$organ_mb_content		= $coreClass -> dataModel(1, "organ_mb_content", null);
	$organ_mb_content		= $coreClass -> dataModelNoXss(1, "organ_mb_content", null);

	switch ($mod) {
		case "list"			: require_once $dir1.'list.php';			break;
		case "modify"	: require_once $dir1.'modify.php';	break;
		case "update"	: require_once $dir1.'update.php';	break;
		case "process"	: require_once $dir1.'process.php';	break;
		default			: require_once $dir1.'list.php';			break;		
	}
?>