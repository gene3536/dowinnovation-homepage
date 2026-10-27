<?php
	require_once("../../../system/config/config_lite.php");

	$coreClass -> LoaderClass("member");
	$memberClass = new memberClass();	
	$memberClass -> LoginCheck(1);
			
	header("Content-Type: text/xml");
	$scode	= $coreClass -> dataModel(2, "scode", NULL);
	$type		= $coreClass -> dataModel(2, "type", NULL);
	$kwd		= $coreClass -> dataModel(2, "kwd", NULL);
	
	if($type == 1) {
		$rs				= $coreClass -> selectQuery(tbl_cms_info, "", "", "", "");
		$contents		= "<?xml version=\"1.0\"?><models>";
		while($row = $coreClass -> selectFetchArray($rs)) {
			$contents .= "<model>";
			$contents .= "<title><![CDATA[".$row['CMS_INFO_TITLE']."]]></title>";
			$contents .= "<menukey><![CDATA[".$row['CMS_INFO_CODE']."]]></menukey>";
			$contents .= "</model>";
		}
		$contents .= "</models>";
	} else {
		$where	= "WHERE cms_info_code = '".$scode."'";
		$row		= $coreClass -> selectQueryArray(tbl_cms_info, $where, "", "", "");
		
		if($type == 2) {
			$where	= "WHERE menu_depth = 1 AND menu_scode = '".$scode."'";
		} else if($type == 3) {
			$where	= "WHERE menu_depth = 2 AND menu_ref = '".$kwd."' AND menu_scode = '".$scode."'";
		} else if($type == 4) {
			$where	= "WHERE menu_depth = 3 AND menu_ref = '".$kwd."' AND menu_scode = '".$scode."'";
		} else if($type == 5) {
			$where	= "WHERE menu_depth = 4 AND menu_ref = '".$kwd."' AND menu_scode = '".$scode."'";
		} else if($type == 6) {
			$where	= "WHERE menu_depth = 5 AND menu_ref = '".$kwd."' AND menu_scode = '".$scode."'";
		}
		
		$rs				= $coreClass -> selectQuery(tbl_menu, $where, "ORDER BY menu_scode", "", "");
		$contents		= "<?xml version=\"1.0\"?><models>";
		while($row = $coreClass -> selectFetchArray($rs)) {
			$contents .= "<model>";
			$contents .= "<title><![CDATA[".$row['MENU_TITLE']."]]></title>";
			$contents .= "<menukey><![CDATA[".$row['MENU_MENUKEY']."]]></menukey>";
			$contents .= "</model>";
		}
		$contents .= "</models>";
	}
	
	echo $contents;
?>