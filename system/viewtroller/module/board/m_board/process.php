<?php
	switch ($act) {
		// 삭제
		case "delete":		
			// 게시판 정보 체크
			$where	= "WHERE board_no = '".$no."'";
			$coreClass -> selectQueryCountChk(tbl_board, $where);
			
			// 게시판 정보 삭제
			$coreClass -> deleteQuery($tbl1, $where);
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

			// 게시판 카테고리 삭제
			$where	= "WHERE brdcat_bid = '".$row['BOARD_ID']."'";
			$rs			= $coreClass -> selectQueryCount(tbl_board_category, $where, "", "", "");
			if($rs > 0) $coreClass -> deleteQuery(tbl_board_category, $where);
		
			// 게시판 게시글 삭제		
			$where	= "WHERE brdata_bid = '".$row['BOARD_ID']."'";
			$rs			= $coreClass -> selectQueryCount(tbl_board_data, $where, "", "", "");
			if($rs > 0) $coreClass -> deleteQuery(tbl_board_data, $where);
				
			// 게시판 댓글 삭제		
			$where	= "WHERE brdcmnt_bid = '".$row['BOARD_ID']."'";
			$rs			= $coreClass -> selectQueryCount(tbl_board_comment, $where, "", "", "");
			if($rs > 0) $coreClass -> deleteQuery(tbl_board_comment, $where);
		
			// 게시판 파일 삭제		
			$where	= "WHERE brdfile_bid = '".$row['BOARD_ID']."'";
			$rs			= $coreClass -> selectQueryCount(tbl_board_file, $where, "", "", "");
			if($rs > 0) $coreClass -> deleteQuery(tbl_board_file, $where);
		
			// 파일업로드 디렉토리 삭제
			//if(!empty($row['BOARD_ID'])) @exec("rm -rf ".dir_public."/upload/bbs/".$row['BOARD_ID']);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&scode=".$scode);
			break;

		case "insert":
			$coreClass -> begin();
			
			$maxNo		= $coreClass -> selectQueryMax(tbl_board, "board_no");
			$maxNo++;
			$id				= str_pad($maxNo, 8, "0", STR_PAD_LEFT);

			$board_order = $board_order1." ".$board_order2;
						
			$item			= "board_no, board_id, board_scode, board_name, board_type, board_category, board_privacy, board_comment, board_editor, board_extend, board_thumnail, board_thum_wid, board_thum_hei, board_oto, board_lv_notice, board_lv_access, board_lv_manage, board_lv_view, board_lv_insert, board_lv_reply, board_lv_comment, board_lv_download, board_lv_exposure, board_sms, board_header, board_footer, board_record, board_new, board_hot, board_uploadcount, board_uploadsize, board_order, board_subject_len, board_regid, board_regip, board_modip, board_moddate, board_regdate";
			$value			= "'".$maxNo."', '".$id."', '".$scodevar."', '".$board_name."', '".$board_type."', '".$board_category."', '".$board_privacy."', '".$board_comment."', '".$board_editor."', '".$board_extend."', '".$board_thumnail."', ".$board_thumwid.", ".$board_thumhei.", '".$board_oto."', '".$board_lv_notice."', '".$board_lv_access."', '".$board_lv_manage."', '".$board_lv_view."', '".$board_lv_insert."', '".$board_lv_reply."', '".$board_lv_comment."', '".$board_lv_download."', ".$board_lv_exposure.", '".$board_sms."', '".$board_header."', '".$board_footer."', '".$board_record."', '".$board_new."', '".$board_hot."', '".$board_uploadcount."', '".$board_uploadsize."', '".$board_order."', ".$board_subject_len.", '".S_mb_id."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
			
			@mkdir(dir_public."/upload/bbs/".$id, 0707);
	
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&scode=".$scode);
			break;

		case "modify":
			$coreClass -> begin();
			
			$board_order = $board_order1." ".$board_order2;

			$where	= "WHERE board_no='".$no."'";
			$coreClass -> selectQueryCountChk(tbl_board, $where);			
			
			$row		= $coreClass -> selectQueryArray(tbl_board, $where, "", "", "");

			
			if($row['BOARD_TYPE'] != $board_type) {
				
				$bset	= "SET brdata_type = '".$board_type."'";
				
				$bwhere = "WHERE brdata_bid = '".$row['BOARD_ID']."'";
				
				$coreClass -> updateQuery(tbl_board_data, $bset, $bwhere);
			
			}
	
			$set = "SET
					board_scode			= '".$scodevar."', 
					board_name			= '".$board_name."', 
					board_category		= '".$board_category."', 
					board_privacy		= '".$board_privacy."', 
					board_comment		= '".$board_comment."',
					board_editor			= '".$board_editor."',
					board_extend			= '".$board_extend."',
					board_thumnail			= '".$board_thumnail."',
					board_thum_wid			= ".$board_thumwid.",
					board_thum_hei			= ".$board_thumhei.",
					board_oto			= '".$board_oto."',
					board_record		= '".$board_record."',
					board_new			= '".$board_new."',
					board_hot			= '".$board_hot."',
					board_uploadcount	= '".$board_uploadcount."',
					board_uploadsize	= '".$board_uploadsize."', 
					board_lv_notice		= '".$board_lv_notice."', 
					board_lv_access		= '".$board_lv_access."',
					board_lv_manage	= '".$board_lv_manage."', 
					board_lv_view		= '".$board_lv_view."', 
					board_lv_insert		= '".$board_lv_insert."',
					board_lv_reply		= '".$board_lv_reply."',
					board_lv_download	= '".$board_lv_download."',
					board_lv_exposure	= ".$board_lv_exposure.",					
					board_sms	= '".$board_sms."',					
					board_lv_comment	= '".$board_lv_comment."',
					board_type			= '".$board_type."', 
					board_header		= '".$board_header."',
					board_footer			= '".$board_footer."',
					board_order			= '".$board_order."',
					board_subject_len			= ".$board_subject_len.",
					board_modid			= '".S_mb_id."',
					board_moddate		= '".site_regdate."'";


			
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list&scode=".$scode);
			break;

		// 분류 삭제
		case "cdelete":
			$where	= "WHERE brdcat_bid = '".$brdcat_bid."' AND brdcat_no = '".$brdcat_no."'";
			$rs			= $coreClass -> selectQueryCountChk(tbl_board_category, $where);
			$row		= $coreClass -> selectQueryArray(tbl_board_category, $where, "", "", "");
			
			$coreClass -> deleteQuery(tbl_board_category, $where);
			
			$set		= "SET brdata_category = '0'";
			$where	= "WHERE brdata_bid = '".$row['BRDCAT_BID']."' AND brdata_category = '".$row['BRDCAT_ID']."'";
			$coreClass -> updateQuery(tbl_board_data, $set, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=category_list&brdcat_bid=".$brdcat_bid."&scode=".$scode);
			break;

		// 분류 등록
		case "cinsert":
			$maxNo	= $coreClass -> selectQueryMax(tbl_board_category, "brdcat_no");
			$maxNo++;
			$id			= str_pad($maxNo, 8, "0", STR_PAD_LEFT);

			

			$item		= "brdcat_no, brdcat_id, brdcat_bid, brdcat_name, brdcat_visible, brdcat_seq, brdcat_regip, brdcat_regdate";
			$value		= "'".$maxNo."', '".$id."', '".$brdcat_bid."', '".$brdcat_name."', 'Y', '1', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_board_category, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=category_list&brdcat_bid=".$brdcat_bid."&scode=".$scode);
			break;

		// 분류 수정
		case "cmodify":
			$where	= "WHERE brdcat_bid = '".$brdcat_bid."' AND brdcat_no = '".$brdcat_no."'";
			$rs			= $coreClass -> selectQueryCountChk(tbl_board_category, $where);	
			$set		= " SET brdcat_name='".$brdcat_name."', brdcat_seq = '".$brdcat_seq."'";
			$coreClass -> updateQuery(tbl_board_category, $set, $where);
	
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=category_list&brdcat_bid=".$brdcat_bid."&scode=".$scode);
			break;
					
		
				
		case "manageupdate" :
			$maxNo	= $coreClass -> selectQueryMax(tbl_board_manage, "BRDMNG_NO");
			$maxNo++;

			$where		= "WHERE board_id = '".$brdmng_bid."'";
			$coreClass -> selectQueryCountChk(tbl_board, $where);
			$item		= "brdmng_no, brdmng_uid, brdmng_bid, brdmng_regdate, brdmng_regip";
			$value		= "'".$maxNo."', '".$brdmng_uid."', '".$brdmng_bid."', '".site_regdate."', '".site_client_ip."'";

			$coreClass -> insertQuery(tbl_board_manage, $item, $value);
	
			$coreClass -> commit();
			$coreClass -> back();
			break;


		// 관리자 삭제
		case "managedelete" :
			
			$where	= "WHERE board_id = '".$brdmng_bid."'";
			
			$coreClass -> selectQueryCountChk(tbl_board, $where);
			
			$where	= "WHERE brdmng_no = '".$brdmng_no."' AND brdmng_bid = '".$brdmng_bid."'";
			
				$coreClass -> selectQueryCountChk(tbl_board_manage, $where);
			
				$coreClass -> deleteQuery(tbl_board_manage, $where);
	
			
				$coreClass -> commit();
			
				$coreClass -> back();
			
				break;
			
		// sms발송자
		case "managesmsupdate" :
			$coreClass -> begin();
			$maxNo	= $coreClass -> selectQueryMax(tbl_board_manage_sms, "BRDMNGS_NO");
			$maxNo++;

			$where		= "WHERE board_id = '".$brdmngs_bid."'";
			$coreClass -> selectQueryCountChk(tbl_board, $where);

			if($brdmngs_uid != ""){
			$where	= "where MB_UID = '".$brdmngs_uid."'";
			$rs			= $coreClass -> selectQuery(tbl_member, $where, "", "", "");
			$rowm = $coreClass -> selectFetchArray($rs);
			$brdmngs_name = $rowm['MB_NAME'];
			$brdmngs_hp2 = $coreClass -> decrypt_md5($rowm['MB_TEL'], site_config_mbkey);
			//$brdmngs_hp		= $coreClass -> crypt_md5($brdmngs_hp2, site_config_mbkey);
			$brdmngs_hp		= "";
			}else{
			$brdmngs_hp		= $coreClass -> crypt_md5($brdmngs_hp, site_config_mbkey);
			}


			$item		= "brdmngs_no, brdmngs_uid, brdmngs_name, brdmngs_hp, brdmngs_bid, brdmngs_regdate, brdmngs_regip";
			$value		= "'".$maxNo."', '".$brdmngs_uid."', '".$brdmngs_name."', '".$brdmngs_hp."', '".$brdmngs_bid."', '".site_regdate."', '".site_client_ip."'";

			$coreClass -> insertQuery(tbl_board_manage_sms, $item, $value);
	
			$coreClass -> commit();
			$coreClass -> back();
			break;


		// sms발송자
		case "managesmsdelete" :
			
			$where	= "WHERE board_id = '".$brdmngs_bid."'";
			
			$coreClass -> selectQueryCountChk(tbl_board, $where);
			
			$where	= "WHERE brdmngs_no = '".$brdmngs_no."' AND brdmngs_bid = '".$brdmngs_bid."'";
			
				$coreClass -> selectQueryCountChk(tbl_board_manage_sms, $where);
			
				$coreClass -> deleteQuery(tbl_board_manage_sms, $where);
	
			
				$coreClass -> commit();
			
				$coreClass -> back();
			
				break;

		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>
