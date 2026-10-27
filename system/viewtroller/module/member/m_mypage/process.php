<?php

    switch ($act) {
		case "modify" :
			$pwquery = "";
			if(!empty($info3) || !empty($info4)) {
				if($info3 == $info4) {
					$pwquery = "mb_pass = '".$info3."',";
				} else {
					$coreClass -> msg_back("비밀번호가 일치하지 않습니다.");
				}
			}
			
			$where	= "WHERE mb_uid = '".S_mb_id."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
				
			$set		= "SET ".$pwquery." mb_tel = '".$mb_tel."', mb_email = '".$mb_email."', mb_modip = '".site_client_ip."', mb_moddate	='".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			$item		= "mb_act_uid, mb_act_event, mb_act_regid, mb_act_regtype, mb_act_regip, mb_act_regdate";
			$value		= "'".S_mb_id."', '수정', '".S_mb_id."', '1', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_member_action, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey);
			break;

		case "logout" :
			$memberClass->memberLogout($memberReferer);

			break;

		default		:
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>

