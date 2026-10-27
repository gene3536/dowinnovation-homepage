<?php

	if(!empty($brdata_bid)){
		$board_data	= $coreClass -> selectQueryArray(tbl_board, "WHERE board_id='".$brdata_bid."'", "", "", "");	
		$scode = $board_data['BOARD_SCODE'];
	}

	switch ($act) {
		// 삭제 
		case "delete" :
			$coreClass -> begin();
			
			$where		= "WHERE brdata_no='".$no."'";
			$coreClass -> selectQueryCountChk(tbl_board_data, $where);
			$row			= $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", "");
						
			$set			= "SET brdata_deleted = 'Y', brdata_deltype = '2'";
			$where		= "WHERE brdata_no = '".$no."'";
			$coreClass -> updateQuery(tbl_board_data, $set, $where);

			// 게시글 로그생성
			$type			= "삭제";
			$bid			= $row['BRDATA_BID'];
			$did			= $row['BRDATA_ID'];
			$bsubject		= $row['BRDATA_SUBJECT'];
			require_once $dir3."board_process_log.php";
				
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 완전삭제
		case "adelete" :

			if(!is_array($Nseq)){
				$Nseq[] = $no;
			}

			for($i=0; $i<count($Nseq); $i++){

				if($Nseq[$i]){

					$coreClass -> begin();
					
					$where		= "WHERE brdata_no='".$no."'";
					$coreClass -> selectQueryCountChk(tbl_board_data, $where);
					$row			= $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", "");
					$bid			= $row['BRDATA_BID'];
					
					$where		= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$row['BRDATA_GRP_NO']."' AND brdata_seq_no > '".$row['BRDATA_SEQ_NO']."' AND brdata_level_no > '".$row['BRDATA_LEVEL_NO']."'";
					$rs				= $coreClass -> selectQueryCount(tbl_board_data, $where);
					
					if($rs > 0) {
						$coreClass -> msg_back("답변글이 있을 경우 완전삭제 하실 수 없습니다.");
					} else {
						// 첨부파일 삭제
						$where	= "WHERE brdfile_bid = '".$bid."' AND brdfile_did = '".$row['BRDATA_ID']."'";
						$rsFilechk	= $coreClass -> selectQueryCount(tbl_board_file, $where, "", "", "");					
						if($rsFilechk > 0){
							$where	= "WHERE brdfile_bid = '".$bid."' AND brdfile_did = '".$row['BRDATA_ID']."'";
							$rsFile		= $coreClass -> selectQuery(tbl_board_file, $where, "", "", "");
								
							while($fileRow = $coreClass -> selectFetchArray($rsFile)) {
								if(is_file(dir_public."/upload/bbs/".$bid."/".$fileRow['BRDFILE_SNAME'])){
									@unlink(dir_public."/upload/bbs/".$bid."/".$fileRow['BRDFILE_SNAME']);
								}
								if(is_file(dir_public."/upload/bbs/".$bid."/thumbnail/thumbnail_".$fileRow['BRDFILE_SNAME'])) {
									@unlink(dir_public."/upload/bbs/".$bid."/thumbnail/thumbnail_".$fileRow['BRDFILE_SNAME']);	
								}						
							}
							$coreClass -> deleteQuery(tbl_board_file, $where);
						}
			
						// 썸네일 이미지 삭제
						if(!empty($row['BRDATA_THUMBNAIL'])) {
							if(is_file(dir_public."/upload/bbs/".$bid."/thumbnail/".$row['BRDATA_THUMBNAIL'])) {
							@unlink(dir_public."/upload/bbs/".$bid."/thumbnail/".$row['BRDATA_THUMBNAIL']);
							}
						}

						// 민원글 삭제
						if($btype == "board_minwon") {
							$where	= "WHERE brdrep_bid = '".$row['BRDATA_BID']."' AND brdrep_did='".$row['BRDATA_ID']."'";
							$coreClass -> deleteQuery($tbl5, $where);
						}
			
						// 게시글 삭제
						$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no='".$no."'";
						$coreClass -> deleteQuery(tbl_board_data, $where);


						//확장필드 삭제
						/*$whereex	= "WHERE brdata_bid = '".$bid."' AND brdata_id='".$row['BRDATA_ID']."'";
						$coreClass -> deleteQuery(tbl_board_data_extend, $whereex);*/

					}
					
					// 게시글 로그생성
					$type			= "완전삭제";
					$bid			= $row['BRDATA_BID'];
					$did			= $row['BRDATA_ID'];
					$bsubject		= $row['BRDATA_SUBJECT'];
					require_once $dir3."board_process_log.php";
				
					$coreClass -> commit();

				}

			}

			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 복구 		
		case "restore" :
			$coreClass -> begin();
	
			$where		= "WHERE brdata_no='".$no."' AND brdata_deleted = 'Y'";
			$coreClass -> selectQueryCountChk(tbl_board_data, $where);
			$row			= $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", "");
			
			$set			= "SET brdata_deleted = 'N', brdata_deltype = '1'";
			$where		= "WHERE brdata_no='".$no."' AND brdata_deleted = 'Y'";
			$coreClass -> updateQuery(tbl_board_data, $set, $where);
			
			// 게시글 로그생성
			$type			= "복구";
			$bid			= $row['BRDATA_BID'];
			$did			= $row['BRDATA_ID'];
			$bsubject		= $row['BRDATA_SUBJECT'];
			require_once $dir3."board_process_log.php";
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 등록	
		case "insert" :
			$coreClass -> begin();
			
			if(empty($brdata_bid)) $coreClass -> msg_back("등록권한이 없습니다.");
			$bid		= $brdata_bid;
			$where	= "WHERE board_id = '".$bid."'";
			$brow		= $coreClass -> selectQueryArray(tbl_board, $where, "", "", "");
			
			$grp_no	= $coreClass -> selectQueryMax(tbl_board_data, "brdata_grp_no");
			$grp_no	= isset($grp_no) ? $grp_no + 1 : 1;
			
			$maxNo	= $coreClass -> selectQueryMax(tbl_board_data, "brdata_no");
			$maxNo++;
			$id			= str_pad($maxNo, 8, "0", STR_PAD_LEFT);
		
			$brdata_subject	= !empty($brdata_subject) ? $brdata_subject : "제목없음";
			$brdata_name	= !empty($brdata_name) ? $brdata_name : S_mb_name;
			$brdata_pass		= !empty($brdata_pass) ? $brdata_pass : $coreClass -> getId2Pass(S_mb_id);

			$brdata_category = isset($brdata_category) ? $brdata_category : "0";
			if($brdata_notice  != "Y") $brdata_notice  = "N";
			if($brdata_privacy != "Y") $brdata_privacy = "N";
			
			// 썸네일파일 업로드
			if(!empty($thumbFile)) {
				$thumbPath	= dir_public."/upload/bbs/".$bid."/";
				$thumbFile	= $coreClass -> uploadFile($thumbFile, $thumbFile_name, $thumbFile_size, $thumbPath, 3, 10, "180", "120");
			} else {
				$thumbFile	= "";
			}
			
			$con_data = $brdata_content;

			// 게시글 등록
			$item	= "brdata_grp_no, brdata_seq_no, brdata_level_no, brdata_category, brdata_scode, brdata_id, brdata_bid, brdata_uid, brdata_type, brdata_name, brdata_dep, brdata_depsub, brdata_depuser, brdata_pass, brdata_email, brdata_hp, brdata_subject, brdata_content, brdata_notice, brdata_privacy, brdata_deleted, brdata_deltype,  brdata_sdate, brdata_edate, brdata_sexposure, brdata_eexposure, brdata_thumbnail, brdata_authtype, brdata_authkey, brdata_regip, brdata_modip, brdata_regdate, brdata_moddate";
			$value	= "'".$grp_no."', 0, 0, '".$brdata_category."', '".$scode."', '".$id."', '".$bid."', '".S_mb_id."', '".$brow['BOARD_TYPE']."', '".$brdata_name."', '".$brdata_dep."', '".$brdata_depsub."', '".$brdata_depuser."', '".$brdata_pass."', '".$brdata_email."', '".$brdata_hp."', '".$brdata_subject."',  '".$brdata_content."', '".$brdata_notice."', '".$brdata_privacy."', 'N', '1', '".$brdata_sdate."', '".$brdata_edate."', '".$brdata_sexposure."', '".$brdata_eexposure."', '".$thumbFile."', '".S_mb_authtype."', '".S_mb_authkey."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);

			// 첨부파일 업로드
			require_once $dir3."board_process_upload.php";
			
			// 확장필드 등록
			if($brow['BOARD_EXTEND'] == "Y"){
				$maxNoe	= $coreClass -> selectQueryMax(tbl_board_data_extend, "EXTEND_NO");
				$maxNoe++;
				$item			= "EXTEND_NO, BRDATA_ID, BRDATA_BID, BRDATA_EXT_01, BRDATA_EXT_02, BRDATA_EXT_03, BRDATA_EXT_04, BRDATA_EXT_05, BRDATA_EXT_06, BRDATA_EXT_07, BRDATA_EXT_08, BRDATA_EXT_09, BRDATA_EXT_10, BRDATA_EXT_11, BRDATA_EXT_12, BRDATA_EXT_13, BRDATA_EXT_14, BRDATA_EXT_15, BRDATA_EXT_16, BRDATA_EXT_17, BRDATA_EXT_18, BRDATA_EXT_19, BRDATA_EXT_20 ";
				$value			= "'".$maxNoe."', '".$id."', '".$bid."', '".$brdata_ext1."', '".$brdata_ext2."', '".$brdata_ext3."', '".$brdata_ext4."', '".$brdata_ext5."', '".$brdata_ext6."', '".$brdata_ext7."', '".$brdata_ext8."', '".$brdata_ext9."', '".$brdata_ext10."', '".$brdata_ext11."', '".$brdata_ext12."', '".$brdata_ext13."', '".$brdata_ext14."', '".$brdata_ext15."', '".$brdata_ext16."', '".$brdata_ext17."', '".$brdata_ext18."', '".$brdata_ext19."', '".$brdata_ext20."'";
				$coreClass -> insertQuery(tbl_board_data_extend, $item, $value);
			}

			// 게시글 로그생성
			$type			= "등록";
			$bid			= $bid;
			$did			= $id;
			$bsubject		= $brdata_subject;			
			require_once $dir3."board_process_log.php";

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 답변 		
		case "reply" :
			$coreClass -> begin();
			
			$where	= "WHERE brdata_no = '".$no."'";
			$coreClass -> selectQueryCountChk(tbl_board_data, $where);
			$row		= $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", "");
			$bid		= $row['BRDATA_BID'];

			$bwhere	= "WHERE board_id = '".$bid."'";
			$coreClass -> selectQueryCountChk(tbl_board, $bwhere);
			$brow		= $coreClass -> selectQueryArray(tbl_board, $bwhere, "", "", "");
	
			// seq_no의 부여방식
			// 다른 게시판과는 틀리게 답변이라도 최근글일수록 위로 올라가는 방식을 취했습니다.
			// 곰곰히 생각해보면 답변에 직접적인 영향을 주는 것은 level_no이지 seq_no가 아님을
			// 알 수 있습니다. 과연 3가지 경우를 생각해서 seq_no 결정을 위해 시스템에 그렇게 많은
			// 부하를 줄 필요성이 있는지를 먼저 생각해 봐야겠죠.
			$brdata_grp_no		= $row['BRDATA_GRP_NO'];
			$brdata_seq_no		= $row['BRDATA_SEQ_NO'] + 1;
			$brdata_level_no	= $row['BRDATA_LEVEL_NO'] + 1;
			
			$set				= "SET brdata_seq_no = brdata_seq_no+1";
			$where			= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$brdata_grp_no."' AND brdata_seq_no >= '".$brdata_seq_no."'";
			$coreClass -> updateQuery(tbl_board_data, $set, $where);
		
			$maxNo			= $coreClass -> selectQueryMax(tbl_board_data, "brdata_no");
			$maxNo++;
			$id					= str_pad($maxNo, 8, "0", STR_PAD_LEFT);
			
			$brdata_subject	= !empty($brdata_subject) ? $brdata_subject : "제목없음";
			$brdata_name	= !empty($brdata_name) ? $brdata_name : S_mb_name;
			$brdata_pass		= !empty($brdata_pass) ? $brdata_pass : $coreClass -> getId2Pass(S_mb_id);

			$brdata_category = isset($brdata_category) ? $brdata_category : "0";
			if($brdata_notice  != "Y") $brdata_notice  = "N";
			if($brdata_privacy != "Y") $brdata_privacy = "N";
			
			$con_data = $brdata_content;

			// 게시글 등록
			$item	= "brdata_no, brdata_grp_no, brdata_seq_no, brdata_level_no, brdata_category, brdata_scode, brdata_id, brdata_bid, brdata_uid, brdata_type, brdata_name, brdata_dep, brdata_depsub, brdata_depuser, brdata_pass, brdata_email, brdata_hp, brdata_subject, brdata_content, brdata_notice, brdata_privacy, brdata_deleted, brdata_deltype,  brdata_sdate, brdata_edate,  brdata_sexposure, brdata_eexposure, brdata_thumbnail, brdata_authtype, brdata_authkey, brdata_regip, brdata_modip, brdata_regdate, brdata_moddate";
			$value	= "'".$maxNo."', '".$brdata_grp_no."', '".$brdata_seq_no."', '".$brdata_level_no."', '".$brdata_category."', '".$scode."', '".$id."', '".$bid."', '".S_mb_id."', '".$row['BRDATA_TYPE']."', '".$brdata_name."', '".$brdata_dep."', '".$brdata_depsub."', '".$brdata_depuser."', '".$brdata_pass."', '".$brdata_email."', '".$brdata_hp."', '".$brdata_subject."',  EMPTY_CLOB(), '".$brdata_notice."', '".$brdata_privacy."', 'N', '1', '".$brdata_sdate."', '".$brdata_edate."', '".$brdata_sexposure."', '".$brdata_eexposure."', '".$thumbFile."', '".S_mb_authtype."', '".S_mb_authkey."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			//$coreClass -> insertQuery($tbl1, $item, $value);

			$clob		= "brdata_content";
			$coreClass -> insertQueryClob(tbl_board_data, $item, $value, $clob, $con_data);


			// 첨부파일 업로드
			require_once $dir3."board_process_upload.php";
			
			// 게시글 로그생성
			$type			= "답변";
			$bid			= $row['BRDATA_BID'];
			$did			= $id;
			$bsubject		= $brdata_subject;			
			
			require_once $dir3."board_process_log.php";
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 수정		
		case "modify" :
			$coreClass -> begin();
			
			$where	= "WHERE brdata_no = '".$no."'";
			$coreClass -> selectQueryCountChk(tbl_board_data, $where);
			$row		= $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", "");			
			$bid		= $row['BRDATA_BID'];
	
			$bwhere	= "WHERE board_id = '".$bid."'";
			$coreClass -> selectQueryCountChk(tbl_board, $bwhere);
			$brow		= $coreClass -> selectQueryArray(tbl_board, $bwhere, "", "", "");
	
			// 최상위글이 아닌 경우 카테고리 불변
			if($brow['BOARD_CATEGORY'] == "Y"){
				// 최상위글이 아닌 경우 카테고리 불변
				if($row['BRDATA_SEQ_NO'] != 0) $category = $row['BRDATA_CATEGORY'];
				// 최상위글이면서 카테고리가 변했을 경우 그룹전체의 카테고리 변화
				if($row['BRDATA_SEQ_NO'] == 0 && $row['BRDATA_CATEGORY'] != $brdata_category){
					$set	= "SET brdata_category = '".$brdata_category."'";
					$where	= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$row['BRDATA_GRP_NO']."'";
					$coreClass -> updateQuery(tbl_board_data, $set, $where);
				}
			}
			
			$brdata_subject	= !empty($brdata_subject) ? $brdata_subject : "제목없음";
			$brdata_name	= !empty($brdata_name) ? $brdata_name : S_mb_name;
			$passQuery		= "";
			if(!empty($brdata_passchg))	$passQuery = ", brdata_pass = '".$brdata_passchg."'";
			if($brdata_notice  != "Y")	$brdata_notice  = "N";
			if($brdata_privacy != "Y")	$brdata_privacy = "N";
			
			// 썸네일파일 업로드
			$thumbQuery = "";
			if(!empty($thumFile)) {
				$thumPath	= dir_public."/upload/bbs/".$bid."/";
				$thumFile	= $coreClass -> uploadFile($thumFile, $thumFile_name, $thumFile_size, $thumPath, 3, "180", "120");				
				if(is_file(dir_public."/upload/bbs/".$bid."/".$row['BRDATA_THUMB'])){
					@unlink(dir_public."/upload/bbs/".$bid."/".$row['BRDATA_THUMB']);
				}
				if(is_file(dir_public."/upload/bbs/".$bid."/thumbnail/thumbnail_".$row['BRDATA_THUMB'])){
					@unlink(dir_public."/upload/bbs/".$bid."/thumbnail/thumbnail_".$row['BRDATA_THUMB']);
				}

				$thumbQuery	= ", brdata_thumb = '".$thumFile."'";				
			} else {
				$thumFile	= "";
			}
			
			// 내용 수정
			$set = "SET
						brdata_email		= '".$brdata_email."', 
						brdata_hp		= '".$brdata_hp."', 
						brdata_subject	= '".$brdata_subject."',
						brdata_name		= '".$brdata_name."', 
						brdata_dep		= '".$brdata_dep."',
						brdata_depsub	= '".$brdata_depsub."',
						brdata_depuser	= '".$brdata_depuser."',
						brdata_notice	= '".$brdata_notice."', 
						brdata_privacy	= '".$brdata_privacy."', 
						brdata_content	= '".$brdata_content."',
						brdata_moddate	= '".site_regdate."',
						brdata_modip	= '".site_client_ip."', 
						brdata_sdate		= '".$brdata_sdate."', 
						brdata_edate		= '".$brdata_edate."', 
						brdata_sexposure		= '".$brdata_sexposure."', 
						brdata_eexposure		= '".$brdata_eexposure."'" 
						.$passQuery.$thumbQuery;
			$where = "WHERE brdata_no = '".$no."'";
			$coreClass -> updateQuery(tbl_board_data, $set, $where);

			// 첨부파일 업로드
			$id = $row['BRDATA_ID'];
			require_once $dir3."board_process_upload.php";
			
			// 확장필드 수정
			if($brow['BOARD_EXTEND'] == "Y"){
				
				$where = "where BRDATA_ID ='".$row['BRDATA_ID']."' and BRDATA_BID = '".$row['BRDATA_BID']."'";
				$excnt = $coreClass -> selectQueryCount(tbl_board_data_extend, $where);
				if($excnt > 0){

					$setex = "SET
								BRDATA_EXT_01		= '".$brdata_ext1."', 
								BRDATA_EXT_02		= '".$brdata_ext2."', 
								BRDATA_EXT_03	= '".$brdata_ext3."',
								BRDATA_EXT_04		= '".$brdata_ext4."', 
								BRDATA_EXT_05	= '".$brdata_ext5."', 
								BRDATA_EXT_06	= '".$brdata_ext6."', 
								BRDATA_EXT_07	= '".$brdata_ext7."',
								BRDATA_EXT_08	= '".$brdata_ext8."',
								BRDATA_EXT_09	= '".$brdata_ext9."', 
								BRDATA_EXT_10		= '".$brdata_ext10."', 
								BRDATA_EXT_11		= '".$brdata_ext11."', 
								BRDATA_EXT_12		= '".$brdata_ext12."', 
								BRDATA_EXT_13		= '".$brdata_ext13."', 
								BRDATA_EXT_14		= '".$brdata_ext14."', 
								BRDATA_EXT_15		= '".$brdata_ext15."', 
								BRDATA_EXT_16		= '".$brdata_ext16."', 
								BRDATA_EXT_17		= '".$brdata_ext17."', 
								BRDATA_EXT_18		= '".$brdata_ext18."', 
								BRDATA_EXT_19		= '".$brdata_ext19."', 
								BRDATA_EXT_20		= '".$brdata_ext20."'";
					$coreClass -> updateQuery(tbl_board_data_extend, $setex, $where);

				}else{
					
					$maxNoe	= $coreClass -> selectQueryMax(tbl_board_data_extend, "EXTEND_NO");
					$maxNoe++;
					$item			= "EXTEND_NO, BRDATA_ID, BRDATA_BID, BRDATA_EXT_01, BRDATA_EXT_02, BRDATA_EXT_03, BRDATA_EXT_04, BRDATA_EXT_05, BRDATA_EXT_06, BRDATA_EXT_07, BRDATA_EXT_08, BRDATA_EXT_09, BRDATA_EXT_10, BRDATA_EXT_11, BRDATA_EXT_12, BRDATA_EXT_13, BRDATA_EXT_14, BRDATA_EXT_15, BRDATA_EXT_16, BRDATA_EXT_17, BRDATA_EXT_18, BRDATA_EXT_19, BRDATA_EXT_20 ";
					$value			= "'".$maxNoe."', '".$row['BRDATA_ID']."', '".$row['BRDATA_BID']."', '".$brdata_ext1."', '".$brdata_ext2."', '".$brdata_ext3."', '".$brdata_ext4."', '".$brdata_ext5."', '".$brdata_ext6."', '".$brdata_ext7."', '".$brdata_ext8."', '".$brdata_ext9."', '".$brdata_ext10."', '".$brdata_ext11."', '".$brdata_ext12."', '".$brdata_ext13."', '".$brdata_ext14."', '".$brdata_ext15."', '".$brdata_ext16."', '".$brdata_ext17."', '".$brdata_ext18."', '".$brdata_ext19."', '".$brdata_ext20."'";
					$coreClass -> insertQuery(tbl_board_data_extend, $item, $value);
					
				}

			}

			// 게시글 로그생성
			$type			= "수정";
			$bid			= $row['BRDATA_BID'];
			$did			= $row['BRDATA_ID'];
			$bsubject		= $brdata_subject;
			require_once $dir3."board_process_log.php";
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 파일삭제	 		
		case "fdelete" :
			$coreClass -> begin();
			
			$no		= $coreClass -> dataModelNoXss(2, "no", NULL);
			$no		= $coreClass -> decrypt_md5(urlencode($no), site_config_filekey);
			$bid		= $coreClass -> dataModelNoXss(2, "bid", NULL);
			$bid		= $coreClass -> decrypt_md5(urlencode($bid), site_config_filekey);
			$did		= $coreClass -> dataModelNoXss(2, "did", NULL);
			$did		= $coreClass -> decrypt_md5(urlencode($did), site_config_filekey);			
			
			if($no && $bid && $did) {
				$fileClass -> fileDeleteType4($no, $bid, $did);
				$coreClass -> back();
			} else {
				$coreClass -> msg_back($no.">".$bid.">".$did."/삭제할 파일이 없습니다.");
			}						
			break;


		case "bbsmove" : //******************** 게시글 선택정상 ****************************************//
			if(S_mb_level > site_config_level) $coreClass -> msg_back("글을 정상처리할 권한이 없습니다.");
			$coreClass -> begin();
			$chkno = $_POST['datasSid'];

	
			//for($i = 0; $i < sizeof($chk)-1; $i++) {


				$where	= "WHERE BRDATA_NO = '".$chkno."'";
				if($copyReply == "Y"){
					$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "","");
					$where .= " or (brdata_grp_no = '".$row['BRDATA_GRP_NO']."' and brdata_bid ='".$row['BRDATA_BID']."')";
				}
				$orderby = "ORDER BY brdata_grp_no desc, brdata_seq_no asc, brdata_regdate asc";

				$rst		= $coreClass -> selectQuery($tbl1, $where, $orderby, "","");
				while($row=$coreClass -> selectFetchArray($rst)){


				$where1     = " where BRDATA_NO = '".$row['BRDATA_NO']."'";
				$set		= "SET BRDATA_BID = '".$fld."'";
				$rs			= $coreClass -> updateQuery($tbl1, $set, $where1);
				if(!$rs) $coreClass -> msg_back("오류(2)가 발생하였습니다.");


				///복사 후 게시판 정보
				$where2 = " where board_id = '".$fld."'";
				$rs4		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
				$rown=$coreClass -> selectFetchArray($rs4);


				// 첨부파일 여부
				$save_path	= dir_public."/upload/bbs/".$fld."/".date("Y")."/";
				$fileUpload	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/";

				$fWhere		= "WHERE BRDFILE_DID = '".$row['BRDATA_ID']."'";// AND file_tno = '".$board_data['no']."'
				$rsFile			= $coreClass -> selectQueryCount(tbl_board_file, $fWhere);

				if($rsFile > 0) {
					$rs6 = $coreClass -> selectQuery(tbl_board_file, $fWhere, "", "", "");
					while($fileRow=$coreClass -> selectFetchArray($rs6)) {

						//파일 복사로직추가
						// 폴더 체크
						if(!file_exists($save_path)) @mkdir($save_path, 0707);	
						if(!file_exists($save_path."thumnail/")) @mkdir($save_path."thumnail/", 0707);	
						if(!copy($fileUpload."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'], $save_path."/".$fileRow['BRDFILE_SNAME'])) {
							$coreClass -> rollback();
							$coreClass -> msg_back("파일을 지정한 디렉토리에 복사하는데 실패했습니다.");
						}else{
							@copy($fileUpload."/".$fileRow['BRDFILE_YEAR']."/thumnail/".$fileRow['BRDFILE_SNAME'], $save_path."/thumnail/".$fileRow['BRDFILE_SNAME']);
						}

						$set		= "SET brdfile_bid = '".$rown['BOARD_ID']."'";
						$rs			= $coreClass -> updateQuery(tbl_board_file, $set, $fWhere);
						if(!$rs) $coreClass -> msg_back("오류(3)가 발생하였습니다.");

					}
				}
				////확장 필드 저장
				/*$fWhere		= "WHERE BRDATA_ID = '".$row['BRDATA_BID']."'";// AND file_tno = '".$board_data['no']."'
				$rsFile2			= $coreClass -> selectQueryCount(tbl_board_data_extend, $fWhere);

				if($rsFile2 > 0) {
					$rs5 = $coreClass -> selectQuery(tbl_board_data_extend, $fWhere, "", "", "");
					while($rowf = mysql_fetch_array($rs5)) {
						//$fWhere		= "WHERE no = '".$rowf['no']."'";// AND file_tno = '".$board_data['no']."'
						$set		= "SET BRDATA_BID = '".$rown['BOARD_ID']."'";
						$rs			= $coreClass -> updateQuery(tbl_board_data_extend, $set, $fWhere);
						if(!$rs) $coreClass -> msg_back("오류(3)가 발생하였습니다.");
					}
				}*/



				///이동전 게시물 정보
				//$where2 = " where board_id = '".$row['BRDATA_BID']."'";
				//$rs3		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
				//$rowm=mysql_fetch_array($rs3);

				/////////////
				$type			= "이동";
				$bid			= $row['BRDATA_BID'];
				$did			= $row['BRDATA_ID'];
				$bsubject		= $row['BRDATA_SUBJECT'];			
				require_once $dir3."board_process_log.php";
				///////////////////////////////////////////////////////////////

			//}
				}

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey.$listVar);
			break;





		case "bbsmovechk" : //******************** 게시글 선택정상 ****************************************//
			if(S_mb_level > site_config_level) $coreClass -> msg_back("글을 정상처리할 권한이 없습니다.");
			$coreClass -> begin();
			//echo count($chk);
			$chk = explode(":",$_POST['datasSid']);
			//echo $act;
			//echo $_POST[datasSid];

			for($i = 0; $i < sizeof($chk)-1; $i++) {
				$where	= "WHERE BRDATA_NO = '".$chk[$i]."'";

				$rs			= $coreClass -> selectQueryCount($tbl1, $where);
				if(!$rs) $coreClass -> msg_back("오류(1)가 발생하였습니다");
			}

	
			for($i = 0; $i < sizeof($chk)-1; $i++) {
				$where	= "WHERE BRDATA_NO = '".$chk[$i]."'";
				$row	= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

				$set		= "SET BRDATA_BID = '".$fld."'";
				$rs			= $coreClass -> updateQuery($tbl1, $set, $where);
				if(!$rs) $coreClass -> msg_back("오류(2)가 발생하였습니다.");
				

				///복사 후 게시판 정보
				$where2 = " where board_id = '".$fld."'";
				$rs4		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
				$rown=mysql_fetch_array($rs4);


				// 첨부파일 여부
				$save_path	= dir_public."/upload/bbs/".$fld."/".date("Y")."/";
				$fileUpload	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/";

				$fWhere		= "WHERE BRDFILE_DID = '".$row['BRDATA_ID']."'";// AND file_tno = '".$board_data['no']."'
				$rsFile			= $coreClass -> selectQueryCount(tbl_board_file, $fWhere);

				if($rsFile > 0) {
					$rs6 = $coreClass -> selectQuery(tbl_board_file, $fWhere, "", "", "");
					while($fileRow = mysql_fetch_array($rs6)) {

						//파일 복사로직추가
						// 폴더 체크
						if(!file_exists($save_path)) @mkdir($save_path, 0707);	
						if(!file_exists($save_path."thumnail/")) @mkdir($save_path."thumnail/", 0707);	
						if(!copy($fileUpload."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'], $save_path."/".$fileRow['BRDFILE_SNAME'])) {
							$coreClass -> rollback();
							$coreClass -> msg_back("파일을 지정한 디렉토리에 복사하는데 실패했습니다.");
						}else{
							@copy($fileUpload."/".$fileRow['BRDFILE_YEAR']."/thumnail/".$fileRow['BRDFILE_SNAME'], $save_path."/thumnail/".$fileRow['BRDFILE_SNAME']);
						}

						$set		= "SET BRDATA_BID = '".$rown['BOARD_ID']."'";
						$rs			= $coreClass -> updateQuery(tbl_board_file, $set, $fWhere);
						if(!$rs) $coreClass -> msg_back("오류(3)가 발생하였습니다.");

					}
				}
				////확장 필드 저장
				/*$fWhere		= "WHERE BRDATA_ID = '".$row['BRDATA_BID']."'";// AND file_tno = '".$board_data['no']."'
				$rsFile2			= $coreClass -> selectQueryCount(tbl_board_data_extend, $fWhere);

				if($rsFile2 > 0) {
					$rs5 = $coreClass -> selectQuery(tbl_board_data_extend, $fWhere, "", "", "");
					while($rowf = mysql_fetch_array($rs5)) {
						//$fWhere		= "WHERE no = '".$rowf['no']."'";// AND file_tno = '".$board_data['no']."'
						$set		= "SET BRDATA_BID = '".$rown['BOARD_ID']."'";
						$rs			= $coreClass -> updateQuery(tbl_board_data_extend, $set, $fWhere);
						if(!$rs) $coreClass -> msg_back("오류(3)가 발생하였습니다.");
					}
				}*/



				///이동전 게시물 정보
				//$where2 = " where board_id = '".$row['BRDATA_BID']."'";
				//$rs3		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
				//$rowm=mysql_fetch_array($rs3);

				/////////////
				$type			= "이동";
				$bid			= $row['BRDATA_BID'];
				$did			= $row['BRDATA_ID'];
				$bsubject		= $row['BRDATA_SUBJECT'];			
				require_once $dir3."board_process_log.php";
				///////////////////////////////////////////////////////////////

			}

			//$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey.$listVar);
			break;



		case "bbscopy" : //******************** 게시글 선택정상 ****************************************//
			if(S_mb_level > site_config_level) $coreClass -> msg_back("글을 복사처리할 권한이 없습니다.");
			$coreClass -> begin();			
			//echo count($chk);
			$chkno = $_POST['datasSid'];
			//echo $act;


			//for($i = 0; $i < sizeof($chk)-1; $i++) {
				
				$where	= "WHERE BRDATA_NO = '".$chkno."'";
				if($copyReply == "Y"){
					$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "","");
					$where .= " or (brdata_grp_no = '".$row['BRDATA_GRP_NO']."' and brdata_bid ='".$row['BRDATA_BID']."')";
				}
				$orderby = "ORDER BY brdata_grp_no desc, brdata_seq_no asc, brdata_regdate asc";

				$rst		= $coreClass -> selectQuery($tbl1, $where, $orderby, "","");
				while($row=$coreClass -> selectFetchArray($rst)){
				
					if($row['BRDATA_SEQ_NO'] == 0){
						$grp_no = $coreClass -> selectQueryMax($tbl1, "brdata_grp_no");
						$grp_no = !$grp_no ? 1 : $grp_no + 1;
					}else{
						$grp_no = $grp_no;
					}

					if($copyReply == "Y"){
						$seq_no = $row['BRDATA_SEQ_NO'];
						$level_no = $row['BRDATA_LEVEL_NO'];
					}else{
						$seq_no = 0;
						$level_no = 0;
					}

					$maxNo	= $coreClass -> selectQueryMax(tbl_board_data, "brdata_no");
					$maxNo++;
					$id			= str_pad($maxNo, 8, "0", STR_PAD_LEFT);


					if($row['BRDATA_CONTENT'] != ""){
						$con_data =  $row['BRDATA_CONTENT'] -> load();	
					}else{
						$con_data =  "";
					}

					// 게시글 등록
					$item	= "brdata_no, brdata_grp_no, brdata_seq_no, brdata_level_no, brdata_category, brdata_id, brdata_bid, brdata_uid, brdata_type, brdata_name, brdata_dep, brdata_depsub, brdata_depuser, brdata_pass, brdata_email, brdata_hp, brdata_subject, brdata_content, brdata_notice, brdata_privacy, brdata_deleted, brdata_deltype,  brdata_sdate, brdata_edate, brdata_sexposure, brdata_eexposure, brdata_thumbnail, brdata_authtype, brdata_authkey, brdata_regip, brdata_modip, brdata_regdate, brdata_moddate";
					$value	= "'".$maxNo."', '".$grp_no."', ".$seq_no.", ".$level_no.", '".$row['BRDATA_CATEGORY']."', '".$id."', '".$fld."', '".$row['BRDATA_UID']."', '".$row['BRDATA_TYPE']."', '".$row['BRDATA_NAME']."', '".$row['BRDATA_DEP']."', '".$row['BRDATA_DEPSUB']."', '".$row['BRDATA_DEPUSER']."', '".$row['BRDATA_PASS']."', '".$row['BRDATA_EMAIL']."', '".$row['BRDATA_HP']."', '".$row['BRDATA_SUBJECT']."',  EMPTY_CLOB(), '".$row['BRDATA_NOTICE']."', '".$row['BRDATA_PRIVACY']."', 'N', '1', '".$row['BRDATA_SDATE']."', '".$row['BRDATA_EDATE']."', '".$row['BRDATA_SEXPOSURE']."', '".$row['BRDATA_EEXPOSURE']."', '".$row['BRDATA_THUMBNAIL']."', '".$row['BRDATA_AUTHTYPE']."', '".$row['BRDATA_AUTHKEY']."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
					//$row[coreClass -> insertQuery($tbl1, $item, $value);

					$clob		= "brdata_content";
					$coreClass -> insertQueryClob(tbl_board_data, $item, $value, $clob, $con_data);
			


					///복사 전 게시판 정보
					$where2 = " where board_id = '".$row['BRDATA_BID']."'";
					$rs3		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
					$rowp=$coreClass -> selectFetchArray($rs3);

					///복사 후 게시판 정보
					$where2 = " where board_id = '".$fld."'";
					$rs4		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
					$rown=$coreClass -> selectFetchArray($rs4);


					$where		= "WHERE brdata_bid = '".$fld."' AND brdata_grp_no = '".$grp_no."'";
					$brd_no		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

					// 첨부파일 여부
					$save_path	= dir_public."/upload/bbs/".$fld."/".date("Y")."/";
					$fileUpload	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/";

					$fWhere		= "WHERE BRDFILE_DID = '".$row['BRDATA_ID']."'";// AND file_tno = '".$board_data['no']."'
					$rsFile			= $coreClass -> selectQueryCount(tbl_board_file, $fWhere);

					if($rsFile > 0) {
						$rs6 = $coreClass -> selectQuery(tbl_board_file, $fWhere, "", "", "");
						while($fileRow = $coreClass -> selectFetchArray($rs6)) {

							// 저장파일명
							// 파일이름을 배열로
							$file_arr = explode(".", $fileRow['BRDFILE_SNAME']);
							$num = count($file_arr);
							
							//파일 확장자 분리
							$ext = strtolower($file_arr[$num-1]);
							$time = time();
							$new_file_name = $time.$row['BRDATA_NO'].".".$ext;

							//파일 복사로직추가
							// 폴더 체크
							if(!file_exists($save_path)) @mkdir($save_path, 0707);	
							if(!file_exists($save_path."thumnail/")) @mkdir($save_path."thumnail/", 0707);	
							if(!copy($fileUpload."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'], $save_path."/".$new_file_name)) {
								$coreClass -> rollback();
								$coreClass -> msg_back("파일을 지정한 디렉토리에 복사하는데 실패했습니다.");
							}else{
								@copy($fileUpload."/".$fileRow['BRDFILE_YEAR']."/thumnail/".$fileRow['BRDFILE_SNAME'], $save_path."/thumnail/".$new_file_name);
							}


							$maxNo	= $coreClass -> selectQueryMax(tbl_board_file, "brdfile_no");
							$maxNo++;

							$item		= "brdfile_no, brdfile_did, brdfile_bid, brdfile_sname, brdfile_name, brdfile_size, brdfile_year, brdfile_hit, brdfile_regip, brdfile_regdate";
							$value		= "'".$maxNo."', '".$brd_no['BRDATA_ID']."', '".$brd_no['BRDATA_BID']."', '".$new_file_name."', '".$fileRow['BRDFILE_NAME']."', '".$fileRow['BRDFILE_SIZE']."', '".date("Y")."', 0, '".site_client_ip."', '".site_regdate."'";
							$coreClass -> insertQuery(tbl_board_file, $item, $value);



						}
					}

					////확장 필드 저장
					/*$fWhere		= "WHERE BRDATA_ID = '".$row['BRDATA_ID']."'";// AND file_tno = '".$board_data['no']."'
					$rsFile2			= $coreClass -> selectQueryCount(tbl_board_data_extend, $fWhere);

					if($rsFile2 > 0) {
						$rs5 = $coreClass -> selectQuery(tbl_board_data_extend, $fWhere, "", "", "");
						while($rowf = $coreClass -> selectFetchArray($rs5)) {


							$maxNoe	= $coreClass -> selectQueryMax(tbl_board_data_extend, "EXTEND_NO");
							$maxNoe++;
							$item			= "EXTEND_NO, BRDATA_ID, BRDATA_BID, BRDATA_EXT_01, BRDATA_EXT_02, BRDATA_EXT_03, BRDATA_EXT_04, BRDATA_EXT_05, BRDATA_EXT_06, BRDATA_EXT_07, BRDATA_EXT_08, BRDATA_EXT_09, BRDATA_EXT_10, BRDATA_EXT_11, BRDATA_EXT_12, BRDATA_EXT_13, BRDATA_EXT_14, BRDATA_EXT_15, BRDATA_EXT_16, BRDATA_EXT_17, BRDATA_EXT_18, BRDATA_EXT_19, BRDATA_EXT_20 ";
							$value			= "'".$maxNoe."', '".$brd_no['BRDATA_ID']."', '".$brd_no['BRDATA_BID']."', '".$row['BRDATA_EXT_01']."', '".$row['BRDATA_EXT_02']."', '".$row['BRDATA_EXT_03']."', '".$row['BRDATA_EXT_04']."', '".$row['BRDATA_EXT_05']."', '".$row['BRDATA_EXT_06']."', '".$row['BRDATA_EXT_07']."', '".$row['BRDATA_EXT_08']."', '".$row['BRDATA_EXT_09']."', '".$row['BRDATA_EXT_10']."', '".$row['BRDATA_EXT_11']."', '".$row['BRDATA_EXT_12']."', '".$row['BRDATA_EXT_13']."', '".$row['BRDATA_EXT_14']."', '".$row['BRDATA_EXT_15']."', '".$row['BRDATA_EXT_16']."', '".$row['BRDATA_EXT_17']."', '".$row['BRDATA_EXT_18']."', '".$row['BRDATA_EXT_19']."', '".$row['BRDATA_EXT_20']."'";
							$coreClass -> insertQuery(tbl_board_data_extend, $item, $value);

						}
					}*/
					///////////////////////////////////////////////////////////////


				
				/////////////
				// 게시글 로그생성
				$type			= "복사";
				$bid			= $row['BRDATA_BID'];
				$did			= $row['BRDATA_ID'];
				$bsubject		= $row['BRDATA_SUBJECT'];			
				require_once $dir3."board_process_log.php";
				///////////////////////////////////////////////////////////////

				
				}//while

			//}

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey.$listVar);
			break;





		case "bbscopychk" : //******************** 게시글 선택정상 ****************************************//
			if(S_mb_level > site_config_level) $coreClass -> msg_back("글을 복사처리할 권한이 없습니다.");
			$coreClass -> begin();
			//echo count($chk);
			$chk = explode(":",$_POST['datasSid']);
			//echo $act;


			for($i = 0; $i < sizeof($chk)-1; $i++) {
				echo $where	= "WHERE BRDATA_NO = '".$chk[$i]."'";

				$rs			= $coreClass -> selectQueryCount($tbl1, $where);
				if(!$rs) $coreClass -> msg_back("오류(1)가 발생하였습니다");
			}

			for($i = 0; $i < sizeof($chk)-1; $i++) {
				
				$where	= "WHERE BRDATA_NO = '".$chk[$i]."'";
				if($copyReply == "Y"){
					$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "","");
					$where .= " or brdata_grp_no = '".$row['BRDATA_GRP_NO']."'";
				}
				$orderby = "ORDER BY brdata_grp_no desc, brdata_seq_no asc, brdata_regdate asc";

				$rst		= $coreClass -> selectQuery($tbl1, $where, $orderby, "","");
				while($row=mysql_fetch_array($rst)){
				
					$grp_no = $coreClass -> selectQueryMax($tbl1, "brdata_grp_no");
					$grp_no = !$grp_no ? 1 : $grp_no + 1;

					if($copyReply == "Y"){
						$seq_no = $row['brdata_seq_no'];
						$level_no = $row['brdata_level_no'];
					}else{
						$seq_no = 0;
						$level_no = 0;
					}

					$maxNo	= $coreClass -> selectQueryMax(tbl_board_data, "brdata_no");
					$maxNo++;
					$id			= str_pad($maxNo, 8, "0", STR_PAD_LEFT);


					$con_data = $row['BRDATA_CONTENT'];

					// 게시글 등록
					$item	= "brdata_no, brdata_grp_no, brdata_seq_no, brdata_level_no, brdata_category, brdata_id, brdata_bid, brdata_uid, brdata_type, brdata_name, brdata_dep, brdata_depsub, brdata_depuser, brdata_pass, brdata_email, brdata_hp, brdata_subject, brdata_content, brdata_notice, brdata_privacy, brdata_deleted, brdata_deltype,  brdata_sdate, brdata_edate, brdata_sexposure, brdata_eexposure, brdata_thumbnail, brdata_authtype, brdata_authkey, brdata_regip, brdata_modip, brdata_regdate, brdata_moddate";
					$value	= "'".$maxNo."', '".$grp_no."', ".$seq_no.", ".$level_no.", '".$row['BRDATA_CATEGORY']."', '".$row['BRDATA_ID']."', '".$fld."', '".$row['BRDATA_UID']."', '".$row['BRDATA_TYPE']."', '".$row['BRDATA_NAME']."', '".$row['BRDATA_DEP']."', '".$row['BRDATA_DEPSUB']."', '".$row['BRDATA_DEPUSER']."', '".$row['BRDATA_PASS']."', '".$row['BRDATA_EMAIL']."', '".$row['BRDATA_HP']."', '".$row['BRDATA_SUBJECT']."',  EMPTY_CLOB(), '".$row['BRDATA_NOTICE']."', '".$row['BRDATA_PRIVACY']."', 'N', '1', '".$row['BRDATA_SDATE']."', '".$row['BRDATA_EDATE']."', '".$row['BRDATA_SEXPOSURE']."', '".$row['BRDATA_EEXPOSURE']."', '".$row['BRDATA_THUMBNAIL']."', '".$row['BRDATA_AUTHTYPE']."', '".$row['BRDATA_AUTHKEY']."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
					//$row[coreClass -> insertQuery($tbl1, $item, $value);

					$clob		= "brdata_content";
					$coreClass -> insertQueryClob(tbl_board_data, $item, $value, $clob, $con_data);
			


					///복사 전 게시판 정보
					$where2 = " where board_id = '".$row['BRDATA_BID']."'";
					$rs3		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
					$rowp=mysql_fetch_array($rs3);

					///복사 후 게시판 정보
					$where2 = " where board_id = '".$fld."'";
					$rs4		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
					$rown=mysql_fetch_array($rs4);


					$where		= "WHERE brdata_bid = '".$fld."' AND brdata_grp_no = '".$grp_no."'";
					$brd_no		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

					// 첨부파일 여부
					$save_path	= dir_public."/upload/bbs/".$fld."/".date("Y")."/";
					$fileUpload	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/";

					$fWhere		= "WHERE BRDFILE_DID = '".$row['BRDATA_ID']."'";// AND file_tno = '".$board_data['no']."'
					$rsFile			= $coreClass -> selectQueryCount(tbl_board_file, $fWhere);

					if($rsFile > 0) {
						$rs6 = $coreClass -> selectQuery(tbl_board_file, $fWhere, "", "", "");
						while($fileRow = mysql_fetch_array($rs6)) {

							// 저장파일명
							// 파일이름을 배열로
							$file_arr = explode(".", $fileRow['BRDFILE_SNAME']);
							$num = count($file_arr);
							
							//파일 확장자 분리
							$ext = strtolower($file_arr[$num-1]);
							$time = time();
							$new_file_name = $time.$row['BRDATA_NO'].".".$ext;

							//파일 복사로직추가
							// 폴더 체크
							if(!file_exists($save_path)) @mkdir($save_path, 0707);	
							if(!file_exists($save_path."thumnail/")) @mkdir($save_path."thumnail/", 0707);	
							if(!copy($fileUpload."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'], $save_path."/".$new_file_name)) {
								$coreClass -> rollback();
								$coreClass -> msg_back("파일을 지정한 디렉토리에 복사하는데 실패했습니다.");
							}else{
								@copy($fileUpload."/".$fileRow['BRDFILE_YEAR']."/thumnail/".$fileRow['BRDFILE_SNAME'], $save_path."/thumnail/".$new_file_name);
							}


							$item		= "brdfile_did, brdfile_bid, brdfile_sname, brdfile_name, brdfile_size, brdfile_year, brdfile_hit, brdfile_regip, brdfile_regdate";
							$value		= "'".$brd_no['BRDATA_ID']."', '".$brd_no['BRDATA_BID']."', '".$fileRow['BRDFILE_SNAME']."', '".$fileRow['BRDFILE_NAME']."', '".$fileRow['BRDFILE_SIZE']."', '".date("Y")."', 0, '".site_client_ip."', '".site_regdate."'";
							$coreClass -> insertQuery(tbl_board_file, $item, $value);


						}
					}

					////확장 필드 저장
					/*$fWhere		= "WHERE BRDATA_ID = '".$row['BRDATA_ID']."'";// AND file_tno = '".$board_data['no']."'
					$rsFile2			= $coreClass -> selectQueryCount(tbl_board_data_extend, $fWhere);

					if($rsFile2 > 0) {
						$rs5 = $coreClass -> selectQuery(tbl_board_data_extend, $fWhere, "", "", "");
						while($rowf = mysql_fetch_array($rs5)) {


							$maxNoe	= $coreClass -> selectQueryMax(tbl_board_data_extend, "EXTEND_NO");
							$maxNoe++;
							$item			= "EXTEND_NO, BRDATA_ID, BRDATA_BID, BRDATA_EXT_01, BRDATA_EXT_02, BRDATA_EXT_03, BRDATA_EXT_04, BRDATA_EXT_05, BRDATA_EXT_06, BRDATA_EXT_07, BRDATA_EXT_08, BRDATA_EXT_09, BRDATA_EXT_10, BRDATA_EXT_11, BRDATA_EXT_12, BRDATA_EXT_13, BRDATA_EXT_14, BRDATA_EXT_15, BRDATA_EXT_16, BRDATA_EXT_17, BRDATA_EXT_18, BRDATA_EXT_19, BRDATA_EXT_20 ";
							$value			= "'".$maxNoe."', '".$brd_no['BRDATA_ID']."', '".$brd_no['BRDATA_BID']."', '".$row['BRDATA_EXT_01']."', '".$row['BRDATA_EXT_02']."', '".$row['BRDATA_EXT_03']."', '".$row['BRDATA_EXT_04']."', '".$row['BRDATA_EXT_05']."', '".$row['BRDATA_EXT_06']."', '".$row['BRDATA_EXT_07']."', '".$row['BRDATA_EXT_08']."', '".$row['BRDATA_EXT_09']."', '".$row['BRDATA_EXT_10']."', '".$row['BRDATA_EXT_11']."', '".$row['BRDATA_EXT_12']."', '".$row['BRDATA_EXT_13']."', '".$row['BRDATA_EXT_14']."', '".$row['BRDATA_EXT_15']."', '".$row['BRDATA_EXT_16']."', '".$row['BRDATA_EXT_17']."', '".$row['BRDATA_EXT_18']."', '".$row['BRDATA_EXT_19']."', '".$row['BRDATA_EXT_20']."'";
							$coreClass -> insertQuery(tbl_board_data_extend, $item, $value);

						}
					}*/
					///////////////////////////////////////////////////////////////


				
				/////////////
				// 게시글 로그생성
				$type			= "복사";
				$bid			= $row['BRDATA_BID'];
				$did			= $row['BRDATA_ID'];
				$bsubject		= $row['BRDATA_SUBJECT'];			
				require_once $dir3."board_process_log.php";
				///////////////////////////////////////////////////////////////

				}

			}

			//$coreClass -> commit();
			//$coreClass -> go("sub.php?menukey=".$menukey.$listVar);
			break;



			
		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>
