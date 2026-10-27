<?php	
	$tbl1						= tbl_menu;
	$tbl2						= tbl_menu_manage;
	$tbl3						= tbl_member;
	$tbl4						= tbl_member_level;
	$tbl5						= tbl_menu_grade;
	$dir1						= dir_system."/viewtroller/module/cmsctrl/m_menu/";
	
	$scode					= $scode ? $scode : "00000001";
	$code1					= $code1 ? $code1 : "";
	$mkey					= $coreClass -> dataModel(2, "mkey", NULL);
	
	$menu_title				= $coreClass -> dataModel(1, "menu_title", NULL);
	$menu_type				= $coreClass -> dataModel(1, "menu_type", NULL);
	$menu_width				= $coreClass -> dataModel(1, "menu_width", NULL);
	$menu_visible			= $coreClass -> dataModel(1, "menu_visible", NULL);
	$menu_access			= $coreClass -> dataModel(1, "menu_access", NULL);
	$menu_level				= $coreClass -> dataModel(1, "menu_level", NULL);
	
	$menu_tbl				= $coreClass -> dataModel(1, "menu_tbl", NULL);
	$menu_url				= $coreClass -> dataModel(1, "menu_url", NULL);
	$menu_surl				= $coreClass -> dataModel(1, "menu_surl", NULL);
	$menu_urlmod			= $coreClass -> dataModel(1, "menu_urlmod", NULL);
	$menu_urlmod2			= $coreClass -> dataModel(1, "menu_urlmod2", NULL);
	$menu_content			= $coreClass -> dataModel(1, "menu_content", NULL);
	$menu_board				= $coreClass -> dataModel(1, "menu_board", NULL);
	$menu_dep				= $coreClass -> dataModel(1, "menu_dep", NULL);
	$menu_depsub			= $coreClass -> dataModel(1, "menu_depsub", NULL);
	$menu_depuser			= $coreClass -> dataModel(1, "menu_depuser", NULL);
	$menu_skins				= $coreClass -> dataModel(1, "menu_skins", NULL);
	$menu_var1				= $coreClass -> dataModel(1, "menu_var1", NULL);
	$menu_var2				= $coreClass -> dataModel(1, "menu_var2", NULL);
	$menu_var3				= $coreClass -> dataModel(1, "menu_var3", NULL);
	$menu_var4				= $coreClass -> dataModel(1, "menu_var4", NULL);
	$menu_var5				= $coreClass -> dataModel(1, "menu_var5", NULL);
	$menu_var6				= $coreClass -> dataModel(1, "menu_var6", NULL);
	$menu_var7				= $coreClass -> dataModel(1, "menu_var7", NULL);
	$menu_var8				= $coreClass -> dataModel(1, "menu_var8", NULL);
	$menu_var9				= $coreClass -> dataModel(1, "menu_var9", NULL);
	$menu_var10				= $coreClass -> dataModel(1, "menu_var10", NULL);
	
	$menu_manage_no		= $coreClass -> dataModel(2, "menu_manage_no", NULL);
	$menu_manage_uid	= $coreClass -> dataModel(2, "menu_manage_uid", NULL);

	$menu_urlmod        = $menu_type == 5 ? $menu_urlmod2 : $menu_urlmod;

	switch ($mod) {
		case "list"				: require_once $dir1.'list.php';break;
		case "modify"		: require_once $dir1.'modify.php';break;
		case "process"		: require_once $dir1.'process.php'; break;
		case "gradeview"	: require_once $dir1.'gradeview.php';break;
		default				: require_once $dir1.'list.php';break;		
	}
?>