<?php

    switch ($act) {		
		case "insert" :
			if(!$mb_uid) $coreClass -> msg_back("입력하신 아이디가 올바르지 않습니다.");
			if(!$memberClass->validMb('id', $mb_uid)) $coreClass->msg_back("입력하신 아이디가 유효하지 않습니다.(영문 소문자, 숫자 조합 8자 이상 20자 이하)");
			if(!$mb_name) $coreClass -> msg_back("입력하신 이름이 올바르지 않습니다.");
			if($mb_pass != $mb_pass2) $coreClass -> msg_back("비밀번호가 일치하지 않습니다.");		
			if(!$memberClass->validMb('pass', $mb_pass_ori)) $coreClass->msg_back("입력하신 비밀번호가 유효하지 않습니다.(영문 소문자, 숫자, 특수문자 조합 8자 이상 20자 이하)");
			if(!$mb_email) $coreClass -> msg_back("입력하신 이메일 형식이 올바르지 않습니다.");	
			if(!$memberClass->validMb('email', $mb_email_ori)) $coreClass -> msg_back("입력하신 이메일 형식이 올바르지 않습니다.");	

			if($memberClass->isDelID($mb_uid)) $coreClass -> msg_back("사용할 수 없는 아이디 입니다.");
			
			$where	= "WHERE mb_uid = '".$mb_uid."' ";
			$rs			= $coreClass -> selectQueryCount($tbl1, $where);
			if($rs > 0) {
				$coreClass -> msg_back("등록된 아이디 입니다.");
			} else {

				$maxNo	= $coreClass -> selectQueryMax($tbl1, "mb_no");
				$maxNo++;
							
				$item		= "mb_no, mb_uid, mb_pass, mb_name, mb_level, mb_org, mb_tel, mb_email, mb_regip, mb_modip, mb_regdate, mb_moddate, mb_del, mb_scode";
				$value		= "'".$maxNo."', '".$mb_uid."', '".$mb_pass."', '".$mb_name."', '9', '".$mb_org."', '".$mb_tel."', '".$mb_email."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."', 'N', '".$mb_scode."'";
				$coreClass -> insertQuery($tbl1, $item, $value);
				
				// 2013.11.11 - 회원처리내역 등록
				$item		= "mb_act_uid, mb_act_event, mb_act_regid, mb_act_regtype, mb_act_regip, mb_act_regdate";
				$value		= "'".$mb_uid."', '등록', '".S_mb_id."', '1', '".site_client_ip."', '".site_regdate."'";
				$coreClass -> insertQuery(tbl_member_action, $item, $value);
				
				$coreClass -> commit();
			}

			//$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			$memberClass->memberLogin($mb_uid, $mb_pass, $mb_scode);
			break;
		
		// 수정
		case "modify" :			
			$where = "WHERE mb_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			$row = $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

			if($mb_pass != $row['MB_PASS']) $coreClass -> msg_back("비밀번호가 일치하지 않습니다.2");	

			if(!$mb_name) $coreClass -> msg_back("입력하신 이름이 올바르지 않습니다.");
			if(!empty($mb_pass1) && !empty($mb_pass2) && ($mb_pass1 != $mb_pass2)) $coreClass -> msg_back("비밀번호가 일치하지 않습니다.");			
			if(!empty($mb_pass1) && !empty($mb_pass2) && !$memberClass->validMb('pass', $mb_pass_ori2)) $coreClass->msg_back("입력하신 비밀번호가 유효하지 않습니다.(영문 소문자, 숫자, 특수문자 조합 8자 이상 20자 이하)");
			if(!$mb_email) $coreClass -> msg_back("입력하신 이메일 형식이 올바르지 않습니다.");	
			if(!$memberClass->validMb('email', $mb_email_ori)) $coreClass -> msg_back("입력하신 이메일 형식이 올바르지 않습니다.");	

			if(!empty($mb_pass1) && !empty($mb_pass2)){
				$mb_pass = $mb_pass1;
			}
				
			$set = "SET ".$pwquery."
					mb_name			='".$mb_name."',
					mb_pass			='".$mb_pass1."',
					mb_email		='".$mb_email."',
					mb_modip		='".site_client_ip."',
					mb_moddate		='".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			// 회원처리내역 등록 - 140624
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			$item		= "mb_act_uid, mb_act_event, mb_act_regid, mb_act_regtype, mb_act_regip, mb_act_regdate";
			$value		= "'".$row['MB_UID']."', '수정', '".S_mb_id."', '1', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_member_action, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=modify");
			break;

		case "login" :
			
			$memberClass->memberLogin($mb_uid, $mb_pass, $mb_scode);
			break;

		case "findPW" :
			$mb_uid2   = trim($mb_uid2);
			$mb_name2  = trim($mb_name2);
			$mb_email2 = trim($mb_email2);

			if(!$mb_uid2) $coreClass -> msg_back("아이디가 정확하지 않습니다.");
			if(!$mb_name2) $coreClass -> msg_back("이름이 정확하지 않습니다.");
			if(!$mb_email2) $coreClass -> msg_back("이메일이 정확하지 않습니다.");	
			
			$where = "WHERE mb_name = '".$mb_name2."' AND mb_uid='".$mb_uid2."' AND mb_email = '".$mb_email2."' AND mb_scode='".$mb_scode."'";
			$exists = $coreClass -> selectQueryCount($tbl1, $where);

			if($exists == 0) $coreClass -> msg_back("등록된 회원이 아닙니다.");
			else{
				
				srand(time());
				$time = substr(time(),4,5);
				for($i=0;$i<4;$i++)
				{
				   $asc=rand()%26+65;
				   $c.=chr($asc);
				}
				$pw = $pw2 = $c.$time;
				$pw = $coreClass->crypt_md5($pw, site_config_mbkey);

				$set = "SET mb_pass	='".$pw."' ";
				$coreClass -> updateQuery($tbl1, $set, $where);

				
				// 회원처리내역 등록 
				$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
				$item		= "mb_act_uid, mb_act_event, mb_act_regid, mb_act_regtype, mb_act_regip, mb_act_regdate";
				$value		= "'".$row['MB_UID']."', '비밀번호 초기화', '".S_mb_id."', '1', '".site_client_ip."', '".site_regdate."'";
				$coreClass -> insertQuery(tbl_member_action, $item, $value);

				echo ('
					<div class="board_w">

						<h3 class="icon_h3 pb_20">아이디 찾기 결과</h3> 

							<div class="sb_form">
								<p>회원님의 비밀번호가 [ '.$pw2.' ]로 임시 변경 되었습니다.</p>
								<p>로그인 후 비밀번호를 재설정 바랍니다.</p>
							</div>

							<div class="sb_btn_w">	
								<div class="sb_btn">
									<button title="로그인" class="b_btn_on"><span>로그인</span></button>
								</div>
							</div>

					</div>
				'); 

			}

			break;

		case "leave" :

			if(empty($mb_pass)) $coreClass -> msg_back("비밀번호를 입력하세요.");
			
			$where = "WHERE mb_uid='".$mb_uid."' AND mb_del='N' AND mb_scode='".$mb_scode."'";
			$res   = $coreClass -> selectQuery($tbl1, $where);
			if($coreClass -> selectQueryCount($tbl1, $where) == 0) $coreClass -> msg_back("등록된 회원이 아닙니다.");
			$row   = $coreClass -> selectFetchArray($res);
			if($mb_pass != $row['MB_PASS']) $coreClass -> msg_back("비밀번호가 일치하지 않습니다.");

			$set		= "SET mb_del='Y', mb_delip='".site_client_ip."', mb_deldate='".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			// 회원처리내역 등록
			$item		= "mb_act_uid, mb_act_event, mb_act_regid, mb_act_regtype, mb_act_regip, mb_act_regdate";
			$value		= "'".$row['MB_UID']."', '회원탈퇴', '".S_mb_id."', '1', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_member_action, $item, $value);

			//탈퇴 아이디 등록 
			$item		= "mb_delid_uid, mb_delid_regip, mb_delid_regdate";
			$value		= "'".$row['MB_UID']."', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_member_delid, $item, $value);

			$memberClass->memberLogout("sub.php?menukey=557&mod=leave3");

			break;

		default		:
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	

?>