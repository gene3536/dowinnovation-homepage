<?php

	switch($act) {
		// 삭제
		case "delete" :
			$where	= "WHERE icm_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);	
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			
			$coreClass -> deleteQuery($tbl1, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 등록
		case "insert" :
			$maxNo	= $coreClass -> selectQueryMax($tbl1, "icm_no");
			$maxNo++;
			$id			= str_pad($maxNo, 8, "0", STR_PAD_LEFT);			

			$item			= "icm_id, icm_pid, icm_title, icm_visible, icm_skins, icm_regip, icm_modip, icm_regdate, icm_moddate";
			$value			= "'".$id."', '".$id."', '".$icm_title."', '".$icm_visible."', '".$icm_skins."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
	
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 수정 
		case "modify" :
			echo $where		= "WHERE icm_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);

			$set = "SET 
				icm_pid = '".$icm_pid."', 
				icm_title = '".$icm_title."', 
				icm_visible = '".$icm_visible."', 
				icm_skins = '".$icm_skins."',
				icm_modip = '".site_client_ip."', 
				icm_moddate = '".site_regdate."'";
			$where		= "WHERE icm_no = '".$no."'";
			$coreClass -> updateQuery($tbl1, $set, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 활성여부
		case "visible" :
			$where		= "WHERE icm_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			$row			= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			
			if($row['ICM_VISIBLE'] == 'Y') {
				$icm_visible = 'N';
			} else {
				$icm_visible = 'Y';
			}
						
			$set			= "SET icm_visible = '".$icm_visible."', icm_modip = '".site_client_ip."', icm_moddate = '".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
						
		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>