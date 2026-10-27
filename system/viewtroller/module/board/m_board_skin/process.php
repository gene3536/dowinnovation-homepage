<?php
	switch ($act) {
		// 삭제 
		case "delete":		
			$where	= "WHERE brdskin_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			
			// 게시판 정보 삭제
			$coreClass -> deleteQuery($tbl1, $where);
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&scode=".$scode);
			break;
		
		// 등록
		case "insert":
			if(empty($brdskin_id)) {
				$coreClass -> msg_back("입력된 아이디가 없습니다.");
			}
			$where	= "WHERE brdskin_id = '".$brdskin_id."'";
			$rsCnt		= $coreClass -> selectQueryCount($tbl1, $where);
			if($rsCnt > 0) {
				$coreClass -> msg_back("등록된 아이디 입니다.");
			}
			
			$maxNo	= $coreClass -> selectQueryMax($tbl1, "brdskin_no");
			$maxNo++;
						
			$item		= "brdskin_no, brdskin_id, brdskin_name, brdskin_regip, brdskin_modip, brdskin_moddate, brdskin_regdate";
			$value		= "'".$maxNo."', '".$brdskin_id."', '".$brdskin_name."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list");
			break;

		// 수정 
		case "modify":
			$where	= "WHERE brdskin_no='".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);			
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

			$set = "SET
					brdskin_name			= '".$brdskin_name."', 
					brdskin_modip			= '".site_client_ip."',
					brdskin_moddate		= '".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&scode=".$scode);
			break;
			
		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>
