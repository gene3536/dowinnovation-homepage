<?php
   

    switch ($act) {
    	// 정지
		case "withdraw" :
			$where	= "WHERE mb_no = '".$no."' AND mb_del = 'N'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			
			// 회원처리내역 등록
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			$item		= "mb_act_uid, mb_act_event, mb_act_regid, mb_act_regtype, mb_act_regip, mb_act_regdate";
			$value		= "'".$row['MB_UID']."', '정지', '".S_mb_id."', '1', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_member_action, $item, $value);				
			
			$set		= "SET mb_del='Y', mb_delip='".site_client_ip."', mb_deldate='".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 삭제
		case "delete" :
			$where	= "WHERE mb_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where, "", "");
			
			// 회원처리내역 등록
			$set		= "SET mb_del = 'Y', mb_delip='".."', mb_deldate = '".."'";
			$where	= "WHERE mb_no = '".$no."' AND mb_del = 'Y'";
			$coreClass -> updateQuery($tbl1, $set, $where);

			$coreClass -> updateQuery($tbl1, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 삭제
		case "rdelete" :
			$where	= "WHERE mb_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where, "", "");
			
			// 회원처리내역 등록
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			$item		= "mb_act_uid, mb_act_event, mb_act_regid, mb_act_regtype, mb_act_regip, mb_act_regdate";
			$value		= "'".$row['MB_UID']."', '삭제', '".S_mb_id."', '1', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_member_action, $item, $value);

			$coreClass -> deleteQuery($tbl1, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 복구
		case "restore" :
			$where	= "WHERE mb_no = '".$no."' AND mb_del = 'Y'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			
			// 회원처리내역 등록
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			$item		= "mb_act_uid, mb_act_event, mb_act_regid, mb_act_regtype, mb_act_regip, mb_act_regdate";
			$value		= "'".$row['MB_UID']."', '복구', '".S_mb_id."', '1', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_member_action, $item, $value);
	
			$set		= "SET mb_del = 'N', mb_delip='', mb_deldate = ''";
			$where	= "WHERE mb_no = '".$no."' AND mb_del = 'Y'";
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 등록
		case "insert" :
			if(!eregi("^[\\xA1-\\xFEa-z0-9!@#$%^&*()_+=<>?,.-]{6,12}$", $info2)) $coreClass -> msg_back("입력하신 아이디가 올바르지 않습니다.");
			if($info3 != $info4) $coreClass -> msg_back("비밀번호가 일치하지 않습니다.");			
			
			$where	= "WHERE mb_uid = '".$info2."'";
			$rs			= $coreClass -> selectQueryCount($tbl1, $where);
			if($rs > 0) {
				$coreClass -> msg_back("등록된 아이디 입니다.");
			} else {
				$maxNo	= $coreClass -> selectQueryMax($tbl1, "mb_no");
				$maxNo++;
							
				$item		= "mb_no, mb_uid, mb_pass, mb_name, mb_level, mb_org, mb_tel, mb_email, mb_regip, mb_modip, mb_regdate, mb_moddate, mb_del, mb_epki, mb_scode";
				$value		= "'".$maxNo."', '".$info2."', '".$info3."', '".$info1."', '".$mb_level."', '".$mb_org."', '".$mb_tel."', '".$mb_email."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."', 'N', '".$mb_epki."', '".$mb_scode."'";
				$coreClass -> insertQuery($tbl1, $item, $value);
				
				// 회원처리내역 등록
				$item		= "mb_act_uid, mb_act_event, mb_act_regid, mb_act_regtype, mb_act_regip, mb_act_regdate";
				$value		= "'".$info2."', '등록', '".S_mb_id."', '1', '".site_client_ip."', '".site_regdate."'";
				$coreClass -> insertQuery(tbl_member_action, $item, $value);
				
				$coreClass -> commit();
			}

			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
		
		// 수정
		case "modify" :
			$pwquery = "";
			if($info3 && $info4) {
				if($info3 == $info4) {
					$pwquery = "mb_pass = '".$info3."',";
				} else {
					$coreClass -> msg_back("비밀번호가 일치하지 않습니다.");
				}
			}
			
			$where = "WHERE mb_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
				
			$set = "SET ".$pwquery."
					mb_scode	='".$mb_scode."',
					mb_level		='".$mb_level."',
					mb_org		='".$mb_org."',
					mb_tel			='".$mb_tel."',
					mb_email		='".$mb_email."',
					mb_modip	='".site_client_ip."',
					mb_moddate	='".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			// 회원처리내역 등록
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			$item		= "mb_act_uid, mb_act_event, mb_act_regid, mb_act_regtype, mb_act_regip, mb_act_regdate";
			$value		= "'".$row['MB_UID']."', '수정', '".S_mb_id."', '1', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_member_action, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		case "login" :
			
			$memberClass->memberLogin($userId, $userEmail, $memberReferer);
			break;

		default		:
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>

