<?php
	require_once("../../../system/config/config_lite.php");
	$memberClass -> LoginCheck(1);
			
	header("Content-Type: text/xml");
	$type	= $coreClass -> dataModel(2, "type", NULL);
	$code	= $coreClass -> dataModel(2, "code", NULL);
	
	if($type == 1) {
		$where	= "WHERE organ_depth = 1";
		$rs			= $coreClass -> selectQuery(tbl_organization, $where, "", "", "");
	} else if($type == 2) {
		$where	= "WHERE organ_depth = 2 AND organ_ref = '".$code."'";
		$rs			= $coreClass -> selectQuery(tbl_organization, $where, "", "", "");
	} else if($type == 3) {
		$where	= "WHERE organ_mb_pid = '".$code."'";
		$order	= "ORDER BY organ_mb_step ASC";
		$rs			= $coreClass -> selectQuery(tbl_organization_member, $where, $order, "", "");
	} else {
		$where	= "WHERE organ_root = 1";
		$rs			= $coreClass -> selectQuery(tbl_organization, $where, "", "", "");
	}
	
	$contents		= "<?xml version=\"1.0\"?><models>";
	while($row = $coreClass -> selectFetchArray($rs)) {
		$contents .= "<model>";
		if($type == 3) {
			$contents .= "<organ_id><![CDATA[".$row['ORGAN_MB_ID']."]]></organ_id>";
			$contents .= "<organ_name><![CDATA[".$row['ORGAN_MB_NAME']."]]></organ_name>";
		} else {
			$contents .= "<organ_id><![CDATA[".$row['ORGAN_ID']."]]></organ_id>";
			$contents .= "<organ_name><![CDATA[".$row['ORGAN_NAME']."]]></organ_name>";
		}
		$contents .= "</model>";
	}
	$contents .= "</models>";
	
	echo $contents;
?>