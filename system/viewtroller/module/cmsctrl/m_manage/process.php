<?php

    switch ($act) {
		// 삭제
		case "delete" :
			$where	= "WHERE cms_manage_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where, "", "");
			$coreClass -> deleteQuery($tbl1, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 등록
		case "insert" :
			$maxNo	= $coreClass -> selectQueryMax($tbl1, "cms_manage_no");

			$maxNo++;

			$item		= "cms_manage_no, cms_manage_uid, cms_manage_scode, cms_manage_regip, cms_manage_regdate";
			$value		= "'".$maxNo."', '".$cms_manage_uid."', '".$cms_manage_scode."', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 수정
		case "modify" :
			$where = "WHERE cms_manage_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
				
			$set = "SET cms_manage_uid = '".$cms_manage_uid."', cms_manage_scode = '".$cms_manage_scode."'";
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		default		:
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>

