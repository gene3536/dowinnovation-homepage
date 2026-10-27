<?php 
	$dep		= "";
	$depsub	= "";
	$depuser	= "";
	$deptel	= "";
	
	if(!empty($pageInfo['MENU_DEP'])) {
		$where		= "WHERE organ_id = '".$pageInfo['MENU_DEP']."'";
		$deps			= $coreClass -> selectQueryArray(tbl_organization, $where, "", "", "");
		$dep			= $deps['ORGAN_NAME'];
	
		$where		= "WHERE organ_id = '".$pageInfo['MENU_DEPSUB']."'";
		$depsubs		= $coreClass -> selectQueryArray(tbl_organization, $where, "", "", "");
		$depsub		= $depsubs['ORGAN_NAME'];
	
		$where		= "WHERE organ_mb_id = '".$pageInfo['MENU_DEPUSER']."'";
		$depusers	= $coreClass -> selectQueryArray(tbl_organization_member, $where, "", "", "");
		$depuser		= $depusers['ORGAN_MB_NAME'];
		$deptel		= $depusers['ORGAN_MB_TEL'];
		$depemail	= $depusers['ORGAN_MB_EMAIL'];
	}
?>