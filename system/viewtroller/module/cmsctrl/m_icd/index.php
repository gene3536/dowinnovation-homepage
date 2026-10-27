<?php	
	$mrow			= $cmsClass -> getContentInfo($pageInfo['MENU_CONTENT']); 
	$id				= $mrow["ICM_ID"];
	$pid			= $mrow["ICM_PID"];
	$skins			= $mrow["ICM_SKINS"];
	$tbl			= $mrow["ICM_TBL"];
	$imgPath		= "/upload/icd/".$pid."/";
	$save_path		= dir_public.$imgPath;
	
	$tbl1			= tbl_cms_icd;
	$tbl2			= tbl_cms_icd_log;
	$tbl3			= tbl_cms_icd_file;
	$tbl4			= tbl_cms_icd_stat; 
	$thisDate		= $coreClass -> dataModel(2, "thisDate", date("Y-m-d")); 
	$rtMod			= $coreClass -> dataModel(1, "rtMod", "list"); 
	$rtMsg			= $coreClass -> dataModel(1, "rtMsg", "");
	$rtMsg			= !empty($rtMsg)? base64_decode($rtMsg) : $rtMsg;

	$chkKey				= $coreClass -> dataModel(1, "chkKey", null);
	$spamKey			= $coreClass -> dataModel(1, "spamKey", null);	
	$sendMail			= $coreClass -> dataModel(1, "sendMail", null);	
	
	$dir1			= dir_system."/viewtroller/module/cmsctrl/m_icd/skins/".$skins."/";
	$dir2			= dir_system."/viewtroller/module/cmsctrl/m_icd/inc/";
	$dir3			= dir_system."/viewtroller/module/cmsctrl/m_icd/";

	$icd_scode			= $coreClass -> dataModel(1, "scodevar", "00000000");
	$icd_title				= $coreClass -> dataModel(1, "icd_title", "제목없음");
	$icd_visible			= $coreClass -> dataModel(1, "icd_visible", "Y");
	$icd_type				= $coreClass -> dataModel(1, "icd_type", null);
	$icd_name			= $coreClass -> dataModel(1, "icd_name", S_mb_name);
	
	
	$icd_alt				= $coreClass -> dataModel(1, "icd_alt", null);
	$icd_url				= $coreClass -> dataModel(1, "icd_url", null);
	$icd_target			= $coreClass -> dataModel(1, "icd_target", null);
	$icd_width			= $coreClass -> dataModel(1, "icd_width", null);
	$icd_height			= $coreClass -> dataModel(1, "icd_height", null);
	$icd_fld1				= $coreClass -> dataModel(1, "icd_fld1", null);
	$icd_fld2				= $coreClass -> dataModel(1, "icd_fld2", null);
	$icd_fld3				= $coreClass -> dataModel(1, "icd_fld3", null);
	$icd_fld4				= $coreClass -> dataModel(1, "icd_fld4", null);
	$icd_fld5				= $coreClass -> dataModel(1, "icd_fld5", null);
	$icd_fld6				= $coreClass -> dataModel(1, "icd_fld6", null);
	$icd_fld7				= $coreClass -> dataModel(1, "icd_fld7", null);
	$icd_fld8				= $coreClass -> dataModel(1, "icd_fld8", null);
	$icd_fld9				= $coreClass -> dataModel(1, "icd_fld9", null);
	$icd_fld10				= $coreClass -> dataModel(1, "icd_fld10", null);
	
	$icd_txt1				= $coreClass -> dataModel(1, "icd_txt1", null);
	$icd_txt2				= $coreClass -> dataModel(1, "icd_txt2", null);
	$icd_txt3				= $coreClass -> dataModel(1, "icd_txt3", null);	
	
	$icd_sdate			= $coreClass -> dataModel(1, "icd_sdate", site_date_c1);
	$icd_edate			= $coreClass -> dataModel(1, "icd_edate", site_date_c2);
	$icd_shour			= $coreClass -> dataModel(1, "icd_shour", "00");
	$icd_ehour			= $coreClass -> dataModel(1, "icd_ehour", "23");
	$icd_sminute			= $coreClass -> dataModel(1, "icd_sminute", "00");
	$icd_eminute		= $coreClass -> dataModel(1, "icd_eminute", "59");


	if(!empty($_POST['_filter']) && $icd_fld5 == "N"){ //xss 제거 사용 안함 
		$icd_content			= $coreClass -> dataModelNoXss2(1, "icd_content", null);
	}else{
		$icd_content			= $coreClass -> dataModelNoXss(1, "icd_content", null);
	}
	

	if(!empty($_FILES['thumbFile'])) {	
		$thumbFile			= $_FILES['thumbFile']['tmp_name'];
		$thumbFile_name	= $_FILES['thumbFile']['name'];
		$thumbFile_size		= $_FILES['thumbFile']['size'];
	}
	
	// 첨부파일 체크
	for($i = 1; $i <= 2; $i++) {
		if(isset($_FILES["uploadFile".$i])) {
			${"uploadFile".$i}				= $_FILES["uploadFile".$i]['tmp_name'];
			${"uploadFile".$i."_name"}	= $_FILES["uploadFile".$i]['name'];
			${"uploadFile".$i."_size"}	= $_FILES["uploadFile".$i]['size'];
		}
	}
	
	$addSkin = "";
	$addSkin = site_menu_skins != null? site_menu_skins."/" : ""; 
	
	switch ($mod) {
		case "list"			: require_once 'skins/'.$skins.'/'.$addSkin.'/list.php';break;
		case "insert"		: require_once 'skins/'.$skins.'/'.$addSkin.'/insert.php';break;
		case "modify"	: require_once 'skins/'.$skins.'/'.$addSkin.'/modify.php';break;
		case "view"		: require_once 'skins/'.$skins.'/'.$addSkin.'/view.php';break;
		case "logview"	: require_once 'skins/'.$skins.'/'.$addSkin.'/logview.php';break;
		case "process"	: require_once $dir3.'process.php';break;
		default			: require_once 'skins/'.$skins.'/'.$addSkin.'/list.php';break;
	}
?>