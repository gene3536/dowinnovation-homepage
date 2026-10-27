<?php

	switch ($act) {
		
		case "organ1ins" : // 부서생성
			$maxNo			= $coreClass -> selectQueryMax($tbl1, "organ_no");
			$maxNo++;
			$organ_id		= str_pad($maxNo, 8, "0", STR_PAD_LEFT);
			$organ_name	= "부서명";			
			$organ_root		= $coreClass -> selectQueryMax($tbl1, "organ_root");
			$organ_root++;
			
			$item				= "organ_no, organ_id, organ_uid, organ_name, organ_content, organ_root, organ_ref, organ_depth, organ_step, organ_visible, organ_regip, organ_modip, organ_regdate, organ_moddate";
			$value				= "'".$maxNo."', '".$organ_id."', '".$organ_uid."', '".$organ_name."', '', '".$organ_root."', '".$organ_id."', '1', '".$organ_root."', 'Y', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
			break;
			
		case "organ2ins" : // 담당생성
			$where			= "WHERE organ_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);		
			$organRow		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			$organ_root		= $organRow['ORGAN_ROOT'];
			$organ_ref		= $organRow['ORGAN_ID'];
			
			$where			= "WHERE organ_depth = '2' AND organ_ref = '".$organ_ref."'";
			$organ_step		= $coreClass -> selectQueryCountDistinct($tbl1, $where, "organ_step");
			$organ_step++;

			$maxNo			= $coreClass -> selectQueryMax($tbl1, "organ_no");
			$maxNo++;
			$organ_id		= str_pad($maxNo, 8, "0", STR_PAD_LEFT);
			$organ_name	= "소속부서명";			

			$item				= "organ_no, organ_id, organ_name, organ_content, organ_root, organ_ref, organ_depth, organ_step, organ_visible, organ_regip, organ_modip, organ_regdate, organ_moddate";
			$value				= "'".$maxNo."', '".$organ_id."', '".$organ_name."', '', '".$organ_root."', '".$organ_ref."', '2', '".$organ_step."', 'Y', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
			break;
			
		case "organ3ins" : // 담당자생성
			$where			= "WHERE organ_no = '".$no."'";
			$organRow		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			$organ_mb_pid	= $organRow['ORGAN_ID'];
			
			$where			= "WHERE organ_mb_pid = '".$organ_mb_pid."'";
			$organ_mb_step	= $coreClass -> selectQueryCountDistinct($tbl2, $where, "organ_mb_step");
			$organ_mb_step++;

			$maxNo			= $coreClass -> selectQueryMax($tbl2, "organ_mb_no");
			$maxNo++;
			$organ_mb_id	= str_pad($maxNo, 8, "0", STR_PAD_LEFT);

			$item				= "organ_mb_no, organ_mb_name, organ_mb_id, organ_mb_pid, organ_mb_step, organ_mb_regip, organ_mb_modip, organ_mb_regdate, organ_mb_moddate";
			$value				= "'".$maxNo."', '이름없음', '".$organ_mb_id."', '".$organ_mb_pid."', '".$organ_mb_step."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl2, $item, $value);
			
			$coreClass -> commit();

			$where			= "WHERE organ_mb_id = '".$organ_mb_id."'";
			$organMbRow	= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
			
			$coreClass ->	go("sub.php?menukey=".$menukey."&mod=update&no=".$organMbRow['ORGAN_MB_NO']."&code1=".$code1."&code2=".$code2);
			break;	
		
		/**
		 * 담당자 수정
		 */
		case "update" :
			$where	= "WHERE organ_mb_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl2, $where);
			
			$set		= "SET 
				organ_mb_name = '".$organ_mb_name."', 
				organ_mb_position = '".$organ_mb_position."', 
				organ_mb_tel ='".$organ_mb_tel."',
				organ_mb_fax ='".$organ_mb_fax."',
				organ_mb_email ='".$organ_mb_email."', 
				organ_mb_content = '".$organ_mb_content."',
				organ_mb_modip = '".site_client_ip."', 
				organ_mb_moddate = '".site_regdate."', 
				organ_mb_extension = '".$organ_mb_extension."'";
			$coreClass -> updateQuery($tbl2, $set, $where);
			
			$coreClass ->commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
			break;
		
		/**
		 * 담당자 삭제
		 */	
		case "organ3del" :
			$where			= "WHERE organ_mb_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl2, $where);
			$organMbRow	= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
			$organ_mb_id	= $organMbRow['ORGAN_MB_ID'];
			$organ_mb_pid	= $organMbRow['ORGAN_MB_PID'];
			$organ_mb_step	= $organMbRow['ORGAN_MB_STEP'];
			
			$where			= "WHERE organ_mb_id = '".$organ_mb_id."'";
			$coreClass -> selectQueryCountChk($tbl2, $where);		
			$coreClass -> deleteQuery($tbl2, $where);
				
			$set				= "SET organ_mb_step = organ_mb_step - 1";
			$where			= "WHERE organ_mb_step > '".$organ_mb_step."' AND organ_mb_pid = '".$organ_mb_pid."'";
			$coreClass -> updateQuery($tbl2, $set, $where);
				
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
			break;					
		
		/**
		 * 부서 삭제
		 */	
		case "delete" :
			$where		= "WHERE organ_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			$organRow	= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			
			if($organRow['ORGAN_DEPTH'] == 1) {
				$where		= "WHERE organ_root = '".$organRow['ORGAN_ROOT']."'";
				$coreClass -> selectQueryCountChk($tbl1, $where);		
				$coreClass -> deleteQuery($tbl1, $where);

				$set			= "SET organ_root = organ_root - 1";
				$where		= "WHERE organ_root > '".$organRow['ORGAN_ROOT']."'";
				$coreClass -> updateQuery($tbl1, $set, $where);

				$set			= "SET organ_step = organ_step - 1";
				$where		= "WHERE organ_step > '".$organRow['ORGAN_STEP']."'";
				$coreClass -> updateQuery($tbl1, $set, $where);
							
				$coreClass ->commit();
			} else if($organRow['ORGAN_DEPTH'] == 2) {
				$where		= "WHERE organ_depth = '2' AND organ_id = '".$organRow['ORGAN_ID']."'";
				$coreClass -> selectQueryCountChk($tbl1, $where);		
				$coreClass -> deleteQuery($tbl1, $where);

				$set			= "SET organ_step = organ_step - 1";
				$where		= "WHERE organ_step > '".$organRow['ORGAN_STEP']."' AND organ_root = '".$organRow['ORGAN_ROOT']."' AND organ_depth = '2'";
				$coreClass -> updateQuery($tbl1, $set, $where);

				$where		= "WHERE organ_mb_pid = '".$organRow['ORGAN_ID']."'";
				$coreClass -> deleteQuery($tbl2, $where);				
				
				$coreClass ->commit();
			}
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
			break;					
			
		/**
		 * 부서 수정
		 */			
		case "modify" :
			$where		= "WHERE organ_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);			
			$organRow	= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			
			// step이 0일때
			if(empty($organ_step)) $coreClass -> msg_back("선택한 부서의 순서값이 잘못되었습니다.");
			
			// step이 기존보다 작아졌을 때
			if(($organ_step < $organRow['ORGAN_STEP'])) {
				if($organRow['ORGAN_DEPTH'] == 1) {
					$set	= "SET organ_root = organ_root + 1";
					$where	= "WHERE organ_root >= ".$organ_step." AND organ_root < ".$organRow['ORGAN_ROOT'];
					$coreClass -> updateQuery($tbl1, $set, $where);
						
					$set	= "SET organ_step = organ_step + 1";
					$where	= "WHERE organ_step >= ".$organ_step." AND organ_step < ".$organRow['ORGAN_STEP']." AND organ_depth = '1'";
					$coreClass -> updateQuery($tbl1, $set, $where);

					$set		= "SET organ_root = '".$organ_step."'";
					$where	= "WHERE organ_ref = ".$organRow['ORGAN_ID'];
					$coreClass -> updateQuery($tbl1, $set, $where);
				} else {
					$set		= "SET organ_step = organ_step + 1";
					$where	= "WHERE organ_step >= ".$organ_step." AND organ_step < ".$organRow['ORGAN_STEP']." AND organ_ref = '".$organRow['ORGAN_REF']."' AND organ_depth = '".$organRow['ORGAN_DEPTH']."' AND organ_root = '".$organRow['ORGAN_ROOT']."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
				}
			}
			
			// step이 기존보다 커졌을 때
			if(($organ_step > $organRow['ORGAN_STEP'])) {
				if($organRow['ORGAN_DEPTH'] == 1) {
					$set		= "SET organ_root = organ_root - 1";
					$where	= "WHERE organ_root <= ".$organ_step." AND organ_root > ".$organRow['ORGAN_ROOT'];
					$coreClass -> updateQuery($tbl1, $set, $where);
						
					$set	= "SET organ_step = organ_step - 1";
					$where	= "WHERE organ_step <= ".$organ_step." AND organ_step > ".$organRow['ORGAN_STEP']." AND organ_depth = '1'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$set		= "SET organ_root = '".$organ_step."'";
					$where	= "WHERE organ_ref = ".$organRow['ORGAN_ID'];
					$coreClass -> updateQuery($tbl1, $set, $where);
				} else {
					$set	= "SET organ_step = organ_step - 1";
					$where	= "WHERE organ_step <= ".$organ_step." AND organ_step > ".$organRow['ORGAN_STEP']." AND organ_ref = '".$organRow['ORGAN_REF']."' AND organ_depth = '".$organRow['ORGAN_DEPTH']."' AND organ_root = '".$organRow['ORGAN_ROOT']."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
				}
			}
			
			$where	= "WHERE organ_no = '".$no."'";
			$set		= "SET organ_uid = '".$organ_uid."', organ_name = '".$organ_name."', organ_root='".$organ_step."', organ_step='".$organ_step."', organ_visible='".$organ_visible."', organ_content = '".$organ_content."', organ_modip = '".site_client_ip."', organ_moddate = '".site_regdate."', organ_extension = '".$organ_extension."'";
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
			break;			
			
		/**
		 * 부서 위로이동
		 */			
		case "up" :
			$where			= "WHERE organ_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);		
			$organRow		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			$organ_root		= $organRow['ORGAN_ROOT'];
			$organ_id		= $organRow['ORGAN_ID'];
			$organ_ref		= $organRow['ORGAN_ID'];
			$organ_depth	= $organRow['ORGAN_DEPTH'];
			$organ_step		= $organRow['ORGAN_STEP'];
			
			if($organ_depth == 1) {
				if($organ_root < 2) {
					$coreClass -> msg_back("선택한 부서는 더이상 위로 이동할 수 없습니다.");
				} else {
					$set		= "SET organ_root = organ_root + 1, organ_step = organ_step + 1";
					$where	= "WHERE organ_root = ".$organ_root." - 1";
					$coreClass -> updateQuery($tbl1, $set, $where);

					$set		= "SET organ_root = organ_root - 1, organ_step = organ_step - 1";
					$where	= "WHERE organ_root = '".$organ_root."' AND organ_id = '".$organ_id."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$coreClass -> commit();
					$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
					break;
				}				
			} else {
				if($organ_step < 2) {
					$coreClass -> msg_back("선택한 부서는 더이상 위로 이동할 수 없습니다.");
				} else {
					$set		= "SET organ_step = organ_step + 1";
					$where	= "WHERE organ_step = ".$organ_step." - 1 AND organ_ref = '".$organRow['ORGAN_REF']."' AND organ_depth = '".$organ_depth."' AND organ_root = '".$organ_root."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$set		= "SET organ_step = organ_step - 1";
					$where	= "WHERE organ_id = '".$organ_id."'";
					$coreClass -> updateQuery($tbl1, $set, $where);

					$coreClass -> commit();
					$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
					break;					
				}
			}

		/**
		 * 부서 아래로이동
		 */			
		case "down" :
			$where			= "WHERE organ_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);		
			$organRow		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			$organ_root		= $organRow['ORGAN_ROOT'];
			$organ_id		= $organRow['ORGAN_ID'];
			$organ_ref		= $organRow['ORGAN_ID'];
			$organ_depth	= $organRow['ORGAN_DEPTH'];
			$organ_step		= $organRow['ORGAN_STEP'];
			
			$where			= "WHERE organ_root = '".$organ_root."' AND organ_depth = '".$organ_depth."'";
			$organ_cnt		= $coreClass -> selectQueryCount($tbl1, $where);
			$organ_root_cnt	= $coreClass -> selectQueryCountDistinct($tbl1, "", "organ_root");		
			
			if($organ_depth == 1) {
				if($organ_root > $organ_root_cnt - 1) {
					$coreClass -> msg_back("선택한 부서는 더이상 아래로 이동할 수 없습니다.");
				} else {
					$set		= "SET organ_root = organ_root - 1, organ_step = organ_step - 1";
					$where	= "WHERE organ_root = ".$organ_root." + 1";
					$coreClass -> updateQuery($tbl1, $set, $where);

					$set		= "SET organ_root = organ_root + 1, organ_step = organ_step + 1";
					$where	= "WHERE organ_root = '".$organ_root."' AND organ_id = '".$organ_id."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$coreClass -> commit();
					$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
					break;
				}
			} else {
				if($organ_step > $organ_cnt - 1) {
					$coreClass -> msg_back("선택한 부서는 더이상 아래로 이동할 수 없습니다.");
				} else {
					$set		= "SET organ_step = organ_step - 1";
					$where	= "WHERE organ_step = ".$organ_step." + 1 AND organ_ref = '".$organRow['ORGAN_REF']."' AND organ_depth = '".$organ_depth."' AND organ_root = '".$organ_root."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$set		= "SET organ_step = organ_step + 1";
					$where	= "WHERE organ_no = '".$no."'";
					$coreClass -> updateQuery($tbl1, $set, $where);

					$coreClass -> commit();
					$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
					break;					
				}				
			}

		/**
		 * 담당자 위로이동
		 */
		case "up2" :
			$where			= "WHERE organ_mb_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl2, $where);		
			$organRow		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
			$organ_mb_id	= $organRow['ORGAN_MB_ID'];
			$organ_mb_pid	= $organRow['ORGAN_MB_PID'];
			$organ_mb_step	= $organRow['ORGAN_MB_STEP'];
			
			if($organ_mb_step < 2) {
				$coreClass -> msg_back("선택한 담당자는 더이상 위로 이동할 수 없습니다.");
			} else {
				$set		= "SET organ_mb_step = organ_mb_step + 1";
				$where		= "WHERE organ_mb_pid = '".$organ_mb_pid."' AND organ_mb_step = ".$organ_mb_step." - 1";
				$coreClass -> updateQuery($tbl2, $set, $where);
				
				$set		= "SET organ_mb_step = organ_mb_step - 1";
				$where		= "WHERE organ_mb_pid = '".$organ_mb_pid."' AND organ_mb_id = ".$organ_mb_id;
				$coreClass -> updateQuery($tbl2, $set, $where);
					
				$coreClass -> commit();
				$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
				break;
			}

		/**
		 * 담당자 아래로이동
		 */
		case "down2" :
			$where			= "WHERE organ_mb_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl2, $where);		
			$organRow		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
			$organ_mb_id	= $organRow['ORGAN_MB_ID'];
			$organ_mb_pid	= $organRow['ORGAN_MB_PID'];
			$organ_mb_step	= $organRow['ORGAN_MB_STEP'];
			
			$where			= "WHERE organ_mb_pid = '".$organ_mb_pid."'";
			$organ_mb_cnt	= $coreClass -> selectQueryCount($tbl2, $where);
			
			if($organ_mb_step > $organ_mb_cnt - 1) {
				$coreClass -> msg_back("선택한 담당자는 더이상 아래로 이동할 수 없습니다.");
			} else {
				$set		= "SET organ_mb_step = organ_mb_step - 1";
				$where	= "WHERE organ_mb_pid = '".$organ_mb_pid."' AND organ_mb_step = ".$organ_mb_step." + 1";
				$coreClass -> updateQuery($tbl2, $set, $where);

				$set		= "SET organ_mb_step = organ_mb_step + 1";
				$where	= "WHERE organ_mb_pid = '".$organ_mb_pid."' AND organ_mb_id = ".$organ_mb_id;
				$coreClass -> updateQuery($tbl2, $set, $where);
					
				$coreClass -> commit();
				$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&code1=".$code1."&code2=".$code2);
				break;
			}			
		
		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;			
	}
?>