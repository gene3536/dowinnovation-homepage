<?php
	require_once("../../../system/config/config_lite.php");
	
	$uid = $coreClass -> dataModel(2, "uid", NULL);
	if($uid && preg_match("/^[\\xA1-\\xFEa-z0-9!@#$%^&*()_+=<>?,.-]{6,12}$/", $uid)) {
		$where	= "WHERE mb_uid='".$uid."'";
        $rs     = $coreClass -> selectQueryCount(tbl_member, $where) ;
                
		if(!empty($rs)) {
			echo "false";
        } else {
			echo "true";
        }
    } else {
		echo "error";
	}
?>