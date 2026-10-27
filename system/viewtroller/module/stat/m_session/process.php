<?php
	switch ($act) {
		case "delete"	:		
			$where	= "WHERE cms_stat_session_id = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			$coreClass -> deleteQuery($tbl1, $where);
			@unlink(dir_session."/sess_".$row['CMS_STAT_SESSION_ID']);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey.$listVar);
			break;
		
		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>
