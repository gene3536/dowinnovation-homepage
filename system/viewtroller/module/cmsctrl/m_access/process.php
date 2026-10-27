<?php
	switch($act) {
		// 삭제
		case "delete" :
			$where = "WHERE acs_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);						
			$coreClass -> deleteQuery($tbl1, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 등록
		case "insert" :
			$item		= "acs_title, acs_ip, acs_visible, acs_regip, acs_modip, acs_regdate, acs_moddate";
			$value		= "'".$acs_title."', '".$acs_ip."', 'Y', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";			
			$coreClass -> insertQuery($tbl1, $item, $value);
	
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 수정
		case "modify" :
			$where	= "WHERE acs_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where, "", "");

			$set		= "SET acs_title = '".$acs_title."', acs_ip = '".$acs_ip."', acs_visible = '".$acs_visible."', acs_modip = '".site_client_ip."', acs_moddate = '".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 활성여부
		case "visible" :
			$where	= "WHERE acs_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where, "", "");
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "");
			
			if($row['ACS_VISIBLE'] == 'Y') {
				$visible = 'N';
			} else {
				$visible = 'Y';
			}
						
			$set = "SET acs_visible = '".$acs_visible."', acs_modip = '".site_client_ip."', acs_moddate = '".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
						
		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>
