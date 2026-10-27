<?php
    switch ($act) {
		// 삭제 
    	case "delete" :
			$where	= "WHERE mb_logx_uid = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl4, $where, "", "");
			$coreClass -> deleteQuery($tbl4, $where);

			$coreClass -> commit();
			$coreClass -> back();
			break;
		
		default		:
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>

