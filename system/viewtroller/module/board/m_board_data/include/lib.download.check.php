<?php
	// 게시글 정보 쿼리
	if(S_mb_level <= bbs_config_level) {
		$where	= "WHERE brdata_bid = '".$bid."' AND BRDATA_ID = '".$did."'";
	} else {
		$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND BRDATA_ID = '".$did."'";
	}

	// 1:1 글보기 옵션
	if(S_mb_level > bbs_config_level && $board_data['BOARD_OTO'] == 'Y') {
		$where .= " AND brdata_uid = '".S_mb_id."'";
	}	

	$coreClass -> selectQueryCountChk(tbl_board_data, $where);
	$row_data = $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", "");


	if(S_mb_level > $board_data['BOARD_LV_VIEW'] && $brdmngCnt < 1 && S_mb_id != $row_data['BRDATA_UID']) $coreClass -> msg_go("보기 권한이 없습니다.","/member/member.php?memberkey=1&refcode=1");


	// 비밀글 사용시 접근권한
	if($row_data['BRDATA_PRIVACY'] == "Y" and $board_data['BOARD_TYPE'] == "board_qna" and (S_mb_id != $row_data['BRDATA_UID'] and S_mb_level >= site_config_alevel)) { //질문답변 게시판 일반회원일때 본인 비밀글만보기 // 
		//
		if(S_mb_level > bbs_config_level && (S_mb_id != $row_data['BRDATA_UID'] || S_mb_level == site_config_glevel)) {
			// 답글일때에는 원글의 비밀번호 가져와 비교.. 현재글의 비밀번호도 같이 비교..
			if($row_data['BRDATA_SEQ_NO'] > 0 && $row_data['BRDATA_PRIVACY'] == "Y"){
				$where2	= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$row_data['BRDATA_GRP_NO']."' and brdata_level_no = '0'";
				$row_data2		= $coreClass -> selectQueryArray(tbl_board_data, $where2, "", "","");
				if(S_mb_id != $row_data['BRDATA_UID'] && S_mb_id != $row_data2['BRDATA_UID']){
					$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");					
				}
			} else if($row_data['BRDATA_UID'] != "guest" and (S_mb_id != $row_data['BRDATA_UID'] and S_mb_level >= site_config_alevel)){
				$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");	
			}else {
				if($brdata_wd != "" &&  $brdata_wd != $row_data['BRDATA_PASS'] && $brdata_wd2 != $row_data['BRDATA_PASS']) {
					//$coreClass -> msg_go("비밀번호가 틀렸습니다.", "sub.php?menukey=".$menukey."&amp;mod=passchk&amp;rtnmod=".$rtnmod."&amp;rtnact=".$rtnact."&amp;no=".$did.$listVar);
					$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");	
				}				
				//$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");
			}
		}

	}else if($board_data['BOARD_TYPE'] == "board_qna" and S_mb_id != $row_data['BRDATA_UID'] and S_mb_level > bbs_config_level and S_mb_level > site_config_level ){ //질답 보인이나 관리자 아닐때 부서체크

		 if(S_mb_id != $row_data['BRDATA_UID'] and S_mb_level > 5 ){
			//$coreClass -> msg_go("접근 권한이 없습니다.", "sub.php?menukey=".$menukey."&amp;mod=list");	
			$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");	
		}else if(site_config_code == "00000001" and (S_mb_level <= site_config_slevel and S_mb_scode != "00000001" and S_mb_level > 1)) {// 질문답변 당부서 관리자가 아닐때 못보게 처리 

			$where_info	= "WHERE CMS_INFO_CODE = '".S_mb_scode."'";
			$row_ifno2	= $coreClass -> selectQueryArray(tbl_cms_info, $where_info, "", "", "");
			if($row_ifno2['CMS_INFO_QNACATE'] != $row_data['BRDATA_CATEGORY']){
				//$coreClass -> msg_go("접근 권한이 없습니다.", "sub.php?menukey=".$menukey."&amp;mod=list");			
				$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");	
			}

		}

	}else if($row_data['BRDATA_PRIVACY'] == "Y") {
		if(S_mb_level > bbs_config_level &&  S_mb_level > bbs_config_level && (S_mb_id != $row_data['BRDATA_UID'] || S_mb_level == site_config_glevel)) {
			// 답글일때에는 원글의 비밀번호 가져와 비교.. 현재글의 비밀번호도 같이 비교..
			if($row_data['BRDATA_SEQ_NO'] > 0 && $row_data['BRDATA_PRIVACY'] == "Y"){
				$where2	= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$row_data['BRDATA_GRP_NO']."' and brdata_level_no = '0'";
				$row_data2		= $coreClass -> selectQueryArray(tbl_board_data, $where2, "", "","");
				if(S_mb_id != $row_data['BRDATA_UID'] && S_mb_id != $row_data2['BRDATA_UID']){
					$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");					
				}
			} else if($row_data['BRDATA_SEQ_NO'] == 0 && $row_data['BRDATA_PRIVACY'] == "Y" and S_mb_id != $row_data['BRDATA_UID']){
				$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");	
			}else {
				if($brdata_wd != $row_data['BRDATA_PASS'] && $brdata_wd2 != $row_data['BRDATA_PASS']) {
					//$coreClass -> msg_go("비밀번호가 틀렸습니다.", "sub.php?menukey=".$menukey."&amp;mod=passchk&amp;rtnmod=".$rtnmod."&amp;rtnact=".$rtnact."&amp;no=".$did.$listVar);
					$coreClass -> msg_back($brdata_wd."//".$brdata_wd2."접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");	
				}				
				//$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");
			}
		}
	}
?>