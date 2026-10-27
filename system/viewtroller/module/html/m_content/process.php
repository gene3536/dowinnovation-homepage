<?php
	switch($act) {
		// 삭제 - 140612
		case "modify" :
			$where		= "WHERE icd_id = '".$pageInfo['MENU_CONTENT']."'";
			$coreClass -> selectQueryCountChk(tbl_cms_icd, $where);
			$row			= $coreClass -> selectQueryArray(tbl_cms_icd, $where, "", "", "");
            $icd_title		= $coreClass -> dataEscape($row['ICD_TITLE']);
				
			// 콘텐츠 로그기록
			$item			= "icd_id, icd_scode, icd_pid, icd_title, icd_content, icd_regip, icd_modip, icd_logip, icd_regdate, icd_moddate, icd_logdate";
			$value			= "'".$row['ICD_ID']."', '".$row['ICD_SCODE']."', '".$row['ICD_PID']."', '".$icd_title."', '".$icd_content."', '".$row['ICD_REGIP']."', '".site_client_ip."', '".site_client_ip."', '".$row['ICD_REGDATE']."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_cms_icd_log, $item, $value);
					
			// 콘텐츠 수정
			$set			= "SET icd_title='".$icd_title."', icd_content='".$icd_content."', icd_modip='".site_client_ip."', icd_moddate='".site_regdate."'";
			$where		= "WHERE icd_id = '".$pageInfo['MENU_CONTENT']."'";						
			$coreClass -> updateQuery(tbl_cms_icd, $set, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey);
			break;
						
		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>