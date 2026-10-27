<?php
	$listVar = htmlspecialchars_decode($listVar);

	switch ($act) {

		// 삭제
		case "delete" :
			if(S_mb_level > $board_data['BOARD_LV_INSERT'] && $brdmngCnt < 1) {
				$coreClass -> msg_back("해당글에 대한 권한이 없습니다");
			}
			
			if(!is_array($seq)){
				$seq[] = $no;
			}

			for($i=0; $i<count($seq); $i++){

				$no = $seq[$i];

				$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no='".$no."'";
				$coreClass -> selectQueryCountChk($tbl2, $where);
				$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
				
				// 접근 및 비밀번호 체크
				require_once $dir2.'lib.password.check.php';
				
				if($row['BRDATA_UID'] == S_mb_id) {
					$set = "SET brdata_deleted = 'Y', brdata_deltype = '3'";
				} else {
					$set = "SET brdata_deleted = 'Y', brdata_deltype = '2'";
				}
				$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no = '".$no."'";
				$coreClass -> updateQuery($tbl2, $set, $where);
				
				// 게시글 로그생성
				$type			= "삭제";
				$bid			= $row['BRDATA_BID'];
				$did			= $row['BRDATA_ID'];
				$bsubject		= $row['BRDATA_SUBJECT'];
				$bcontent	= $row['BRDATA_CONTENT'];
				require_once $dir2."prc.loging.php";
				
				$coreClass -> commit();
			}

			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 완전삭제
		case "adelete" :
			if(S_mb_level > bbs_config_level) {
				$coreClass -> msg_back("해당글에 대한 권한이 없습니다");
			}
	
			if(!is_array($Nseq)){
				$Nseq[] = $no;
			}

			for($i=0; $i<count($Nseq); $i++){

				if($Nseq[$i]){
					$no = $Nseq[$i];

					$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no='".$no."'";
					$coreClass -> selectQueryCountChk($tbl2, $where);
					$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
					
					$where	= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$row['BRDATA_GRP_NO']."' AND brdata_seq_no > '".$row['BRDATA_SEQ_NO']."' AND brdata_level_no > '".$row['BRDATA_LEVEL_NO']."'";
					$rs			= $coreClass -> selectQueryCount($tbl2, $where);
					
					if($rs > 0) {
						$coreClass -> msg_back("답변글이 있을 경우 완전삭제 하실 수 없습니다.");
					} else {
						$fileClass -> fileDeleteType3($bid, $row['BRDATA_ID']);
						
						// 게시글 삭제
						$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no='".$no."'";
						$coreClass -> deleteQuery($tbl2, $where); 
					}
					
					// 게시글 로그생성
					$type			= "완전삭제";
					$bid			= $row['BRDATA_BID'];
					$did			= $row['BRDATA_ID'];
					$bsubject		= $row['BRDATA_SUBJECT'];
					$bcontent	= $row['BRDATA_CONTENT']; 
					require_once $dir2."prc.loging.php";	
				}

			}
			
			$coreClass -> commit(); 
			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&mod=list".$listVar);
			
			break;
			
		// 복구
		case "restore" :
			if(S_mb_level > bbs_config_level) $coreClass -> msg_back("글을 복구할 권한이 없습니다.");
	
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no='".$no."' AND brdata_deleted = 'Y'";
			$coreClass -> selectQueryCountChk($tbl2, $where);
			$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
			
			$set		= "SET brdata_deleted = 'N', brdata_deltype = '1'";
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no='".$no."' AND brdata_deleted = 'Y'";
			$coreClass -> updateQuery($tbl2, $set, $where);
			
			// 게시글 로그생성
			$type			= "복구";
			$bid			= $row['BRDATA_BID'];
			$did			= $row['BRDATA_ID'];
			$bsubject		= $row['BRDATA_SUBJECT'];
			$bcontent	= $row['BRDATA_CONTENT'];
			require_once $dir2."prc.loging.php";
			
			$coreClass -> commit();
			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&mod=list".$listVar);
			
			break;

		// 등록
		case "insert" :
			if(S_mb_level > $board_data['BOARD_LV_INSERT'] && $brdmngCnt < 1) $coreClass -> msg_back("해당게시판에 대한 권한이 없습니다");
			if(S_mb_level >= site_config_glevel && $chkKey != $spamKey) $coreClass -> msg_back("인증번호 값이 올바르지 않습니다");
			
			$grp_no	= $coreClass -> selectQueryMax($tbl2, "brdata_grp_no");
			$grp_no	= isset($grp_no) ? $grp_no + 1 : 1;
			
			$maxNo	= $coreClass -> selectQueryMax($tbl2, "brdata_no");
			$maxNo++;
			$id		= str_pad($maxNo, 8, "0", STR_PAD_LEFT);
		
			$brdata_subject	= !empty($brdata_subject) ? $brdata_subject : "제목없음";
			$brdata_name	= !empty($brdata_name) ? $brdata_name : S_mb_name;
			$brdata_wd		= !empty($brdata_wd) ? $brdata_wd : $coreClass -> getId2Pass(S_mb_id);

			$brdata_category = !empty($brdata_category) ? $brdata_category : "0";
			if($brdata_notice  != "Y") $brdata_notice  = "N";
			if($brdata_privacy != "Y") $brdata_privacy = "N";

			// 썸네일파일 업로드
			if(!empty($thumbFile)) {
				if($board_data['BOARD_TYPE']=='board_gallery_tech'){
					//인증현황 업로드 시 가로세로 이미지 check.
					$check_cer_img = $coreClass->check_cer_file($thumbFile, $thumbFile_name);
				}
				
				$thumbPath	= dir_public."/upload/bbs/".$bid."/";
				$thumbFile	= $coreClass -> uploadFile($thumbFile, $thumbFile_name, $thumbFile_size, $thumbPath, 3, $board_data['BOARD_UPLOADSIZE'], $board_data['BOARD_THUM_WID'], $board_data['BOARD_THUM_HEI']);
				$thumbYear	= date("Y");
			} else {
				$thumbFile	= null;
				$thumbYear	= null;
			}
			
			// 게시판 타입
			$where		= "WHERE board_id = '".$bid."'";
			$board_row	= $coreClass -> selectQueryArray(tbl_board, $where, "", "", "");
			
			if(isset(${"uploadFile1"}) && ${"uploadFile1_name"}){
				if($board_data['BOARD_TYPE']=='board_gallery_tech'){
					//인증현황 업로드 시 가로세로 첫번째 이미지 check.
					$check_cer_img = $coreClass->check_cer_file(${"uploadFile1"},${"uploadFile1_name"});
				}
			}
			// 게시글 등록
			$item = "brdata_no, brdata_grp_no, brdata_seq_no, brdata_level_no, brdata_category, brdata_scode, brdata_id, brdata_bid, brdata_uid, brdata_type, brdata_name, brdata_pass, brdata_dep, brdata_depsub, brdata_depuser, brdata_email, brdata_hp, brdata_smsis, brdata_subject,  brdata_content, brdata_notice, brdata_privacy, brdata_deleted, brdata_deltype, brdata_sdate, brdata_edate, brdata_sexposure, brdata_eexposure, brdata_thumbnail, brdata_thumbyear, brdata_authtype, brdata_authkey, brdata_regip, brdata_modip, brdata_regdate, brdata_moddate";
			$item .= ", brdata_fld1, brdata_fld2, brdata_fld3, brdata_fld4, brdata_fld5, brdata_fld6"; 
			$item .= ", brdata_etc1, brdata_etc2, brdata_etc3, brdata_etc4, brdata_etc5"; 
			$value = "'".$maxNo."', '".$grp_no."', 0, 0, '".$brdata_category."', '".$board_row['BOARD_SCODE']."', '".$id."', '".$bid."', '".S_mb_id."', '".$board_row['BOARD_TYPE']."', '".$brdata_name."', '".$brdata_wd."', '".$brdata_dep."', '".$brdata_depsub."', '".$brdata_depuser."', '".$brdata_email."', '".$brdata_hp."', '".$brdata_smsis."', '".$brdata_subject."', '".$brdata_content."', '".$brdata_notice."', '".$brdata_privacy."', 'N', '1', '".$brdata_sdate."', '".$brdata_edate."', '".$brdata_sexposure."', '".$brdata_eexposure."', '".$thumbFile."', '".$thumbYear."', '".S_mb_authtype."', '".S_mb_authkey."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			$value .= ", '".$brdata_fld1."', '".$brdata_fld2."', '".$brdata_fld3."', '".$brdata_fld4."', '".$brdata_fld5."', '".$brdata_fld6."'";
			$value .= ", '".$brdata_etc1."', '".$brdata_etc2."', '".$brdata_etc3."', '".$brdata_etc4."', '".$brdata_etc5."'";
			$coreClass -> insertQuery($tbl2, $item, $value);

			// 첨부파일 업로드
			require_once $dir2."prc.uploadfile.php";
			
			///게시판에 관리자 sms 등록시 관리자에게 문자 발송
			$wheres = " WHERE BRDMNGS_BID = '".$bid."'";
			$smscnt = $coreClass -> selectQueryCount(tbl_board_manage_sms, $wheres);
			if($smscnt > 0) {
				require_once $dir2."prc.sms.send.php";
			}
			
			// 확장필드 등록
			if($board_data['BOARD_EXTEND'] == "Y"){
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
			$bcontent	= $brdata_content;
			require_once $dir2."prc.loging.php";

			$coreClass -> commit();
			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&mod=list".$listVar);
			
			break;

		// 답변
		case "reply" :
			if(S_mb_level > $board_data['BOARD_LV_REPLY'] && $brdmngCnt < 1) $coreClass -> msg_back("답변에 대한 권한이 없습니다");
			
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl2, $where);
			$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");

			// seq_no의 부여방식
			// 다른 게시판과는 틀리게 답변이라도 최근글일수록 위로 올라가는 방식을 취했습니다.
			// 곰곰히 생각해보면 답변에 직접적인 영향을 주는 것은 level_no이지 seq_no가 아님을
			// 알 수 있습니다. 과연 3가지 경우를 생각해서 seq_no 결정을 위해 시스템에 그렇게 많은
			// 부하를 줄 필요성이 있는지를 먼저 생각해 봐야겠죠.
			$brdata_grp_no		= $row['BRDATA_GRP_NO'];
			$brdata_seq_no		= $row['BRDATA_SEQ_NO'] + 1;
			$brdata_level_no	= $row['BRDATA_LEVEL_NO'] + 1;
			
			$set			= "SET brdata_seq_no = brdata_seq_no+1";
			$where		= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$brdata_grp_no."' AND brdata_seq_no >= '".$brdata_seq_no."'";
			$coreClass -> updateQuery($tbl2, $set, $where);
		
			$maxNo		= $coreClass -> selectQueryMax($tbl2, "brdata_no");
			$maxNo++;
			$id				= str_pad($maxNo, 8, "0", STR_PAD_LEFT);
			
			$brdata_pass	= !empty($brdata_pass) ? $brdata_pass : $coreClass -> getId2Pass(S_mb_id);

			$brdata_category = isset($brdata_category) ? $brdata_category : "0";
			if($brdata_notice  != "Y") $brdata_notice  = "N";
			if($brdata_privacy != "Y") $brdata_privacy = "N";
			
			// 게시판 타입
			$where		= "WHERE board_id = '".$bid."'";
			$board_row	= $coreClass -> selectQueryArray(tbl_board, $where, "", "", "");
			
			$con_data = $brdata_content;

			// 게시글 등록
			$item			= "brdata_no, brdata_grp_no, brdata_seq_no, brdata_level_no, brdata_category, brdata_scode, brdata_id, brdata_bid, brdata_uid, brdata_type, brdata_name, brdata_pass, brdata_email, brdata_hp, brdata_smsis, brdata_subject, brdata_content, brdata_notice, brdata_privacy, brdata_sdate, brdata_edate, brdata_sexposure, brdata_eexposure, brdata_thumbnail, brdata_thumbyear, brdata_authtype, brdata_authkey, brdata_regip, brdata_modip, brdata_regdate, brdata_moddate";
			$value			=  "'".$maxNo."', '".$brdata_grp_no."', '".$brdata_seq_no."', '".$brdata_level_no."', '".$brdata_category."', '".$board_row['BOARD_SCODE']."',  '".$id."', '".$bid."', '".S_mb_id."', '".$board_row['BOARD_TYPE']."', '".$brdata_name."', '".$brdata_pass."', '".$brdata_email."', '".$brdata_hp."', '".$brdata_smsis."', '".$brdata_subject."', '".$brdata_content."', '".$brdata_notice."', '".$brdata_privacy."', '".$brdata_sdate."', '".$brdata_edate."', '".$brdata_sexposure."', '".$brdata_eexposure."', null, null, '".S_mb_authtype."', '".S_mb_authkey."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl2, $item, $value);
			
			// 첨부파일 업로드
			require_once $dir2."prc.uploadfile.php";
			

			///원본글쓴이가 답변SMS요청시 문자 발송
			if($row['BRDATA_SMSIS'] == "Y") {
				require_once $dir2."reply.sms.send.php";
			}	

			// 게시글 로그생성
			$type			= "답글";
			$bid			= $row['BRDATA_BID'];
			$did			= $row['BRDATA_ID'];
			$bsubject		= $brdata_subject;
			$bcontent	= $brdata_content;				
			require_once $dir2."prc.loging.php";

			$coreClass -> commit();
			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&mod=list".$listVar);
			
			break;

		// 수정
		case "modify" :
			if(S_mb_level > $board_data['BOARD_LV_INSERT'] && $brdmngCnt < 1) $coreClass -> msg_back("해당글에 대한 권한이 없습니다");
			
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl2, $where);
			$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
			$bid		= $row['BRDATA_BID'];
	
			// 접근 및 비밀번호 체크
			require_once $dir2.'lib.password.check.php';
						
			// 최상위글이 아닌 경우 카테고리 불변
			if($board_data['BOARD_CATEGORY'] == "Y" and $board_data['BOARD_TYPE'] != "board_qna"){ //질문답변이 아닐때만 수정.
				// 최상위글이 아닌 경우 카테고리 불변
				if($row['BRDATA_SEQ_NO'] != 0) $category = $row['BRDATA_CATEGORY'];
				// 최상위글이면서 카테고리가 변했을 경우 그룹전체의 카테고리 변화
				if($row['BRDATA_SEQ_NO'] == 0 && $row['BRDATA_CATEGORY'] != $brdata_category){
					$set	= "SET brdata_category = '".$brdata_category."'";
					$where	= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$row['BRDATA_GRP_NO']."'";
					$coreClass -> updateQuery($tbl2, $set, $where);
				}
			}
			
			$brdata_subject	= !empty($brdata_subject) ? $brdata_subject : "제목없음";
			$brdata_name	= !empty($brdata_name) ? $brdata_name : S_mb_name;
			$passQuery		= "";
			if(!empty($brdata_wdchg)) $passQuery = ", brdata_pass = '".$brdata_wdchg."'";
			if($brdata_notice  != "Y") $brdata_notice  = "N";
			if($brdata_privacy != "Y") $brdata_privacy = "N";
			
			// 썸네일파일 업로드
			$thumbQuery = "";
			if(!empty($thumbFile)) {
				$thumbPath	= dir_public."/upload/bbs/".$bid."/";
				$thumbFile		= $coreClass -> uploadFile($thumbFile, $thumbFile_name, $thumbFile_size, $thumbPath, 3, $board_data['BOARD_UPLOADSIZE'], $board_data['BOARD_THUM_WID'], $board_data['BOARD_THUM_HEI']);	
				if(is_file(dir_public."/upload/bbs/".$bid."/".$row['BRDATA_THUMB'])){
					@unlink(dir_public."/upload/bbs/".$bid."/".$row['BRDATA_THUMB']);
					@unlink(dir_public."/upload/bbs/".$bid."/thumbnail/thumbnail_".$row['BRDATA_THUMB']);
				}
				$thumbQuery	= ", brdata_thumbnail = '".$thumbFile."', brdata_thumbyear = '".date("Y")."'";		
			}
			
			// 내용 수정
			$set = "SET
						brdata_email		= '".$brdata_email."', 
						brdata_hp		= '".$brdata_hp."', 
						brdata_smsis		= '".$brdata_smsis."',						
						brdata_subject	= '".$brdata_subject."',
						brdata_name		= '".$brdata_name."', 
						brdata_notice	= '".$brdata_notice."', 
						brdata_privacy	= '".$brdata_privacy."', 
						brdata_content	= '".$brdata_content."',
						brdata_moddate	= '".site_regdate."',
						brdata_modip	= '".site_client_ip."', 
						brdata_sdate		= '".$brdata_sdate."', 
						brdata_edate		= '".$brdata_edate."', 
						brdata_sexposure		= '".$brdata_sexposure."', 
						brdata_eexposure		= '".$brdata_eexposure."',
						brdata_fld1		= '".$brdata_fld1."',
						brdata_fld2		= '".$brdata_fld2."',
						brdata_fld3		= '".$brdata_fld3."',
						brdata_fld4		= '".$brdata_fld4."',
						brdata_fld5		= '".$brdata_fld5."',
						brdata_fld6		= '".$brdata_fld6."',
						brdata_etc1		= '".$brdata_etc1."',
						brdata_etc2		= '".$brdata_etc2."',
						brdata_etc3		= '".$brdata_etc3."',
						brdata_etc4		= '".$brdata_etc4."',
						brdata_etc5		= '".$brdata_etc5."'"
						.$passQuery.$thumbQuery;
			$where	= "WHERE brdata_no = '".$no."'";
			$coreClass -> updateQuery($tbl2, $set, $where);			

			// 첨부파일 업로드
			$id = $row['BRDATA_ID'];
			require_once $dir2."prc.uploadfile.php";
			
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
			$bcontent	= $brdata_content;				
			require_once $dir2."prc.loging.php";
			
			$coreClass -> commit();
			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 파일삭제
		case "fdelete" :
 			if(S_mb_level > $board_data['BOARD_LV_INSERT'] && $brdmngCnt < 1) $coreClass -> msg_back("해당글에 대한 권한이 없습니다");
			$fno	= $coreClass -> dataModelEncrypt(2, "fno", NULL);
			$fno	= $coreClass -> decrypt_md5(urlencode($fno), site_config_filekey);
			$bid	= $coreClass -> dataModelEncrypt(2, "bid", NULL);
			$bid	= $coreClass -> decrypt_md5(urlencode($bid), site_config_filekey);
			$did	= $coreClass -> dataModelEncrypt(2, "did", NULL);
			$did	= $coreClass -> decrypt_md5(urlencode($did), site_config_filekey);			

			if($fno && $bid && $did) {
				$set   = "SET brdata_thumbnail = '', brdata_thumbyear = '' ";
				$where = "WHERE brdata_id = '".$did."'";
				$coreClass -> updateQuery($tbl2, $set, $where);
				$coreClass -> commit();
					
				$fileClass -> fileDeleteType4($fno, $bid, $did);
				$coreClass -> back();
			} else {
				$coreClass -> msg_back("삭제할 파일이 없습니다.");
			}
			break;

		// 부서지정
		case "status1" :			 
 	
			if(S_mb_level > $board_data['BOARD_LV_INSERT'] && $brdmngCnt < 1) $coreClass -> msg_back("해당글에 대한 권한이 없습니다");
		
			$coreClass -> begin();
			$where	= "WHERE brdata_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl2, $where);
			$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "");			
			
			// 답변글
			$where2	= "WHERE brdrep_bid = '".$row['BRDATA_BID']."' AND brdrep_did = '".$row['BRDATA_ID']."'";
			$cnt2		= $coreClass -> selectQueryCount(tbl_board_reply, $where2);
			if($cnt2 > 0) {
				$row2		= $coreClass -> selectQueryArray(tbl_board_reply, $where2, "", "", "");	
				$set = "SET
							brdrep_dep		= '".$brdrep_dep."',
							brdrep_depsub	= '".$brdrep_depsub."',
							brdrep_depuser	= '".$brdrep_depuser."',
							brdrep_status	= '2'";
				$where = "WHERE brdrep_no = '".$row2['BRDREP_NO']."'";
				$coreClass -> updateQuery(tbl_board_reply, $set, $where);
			} else {
				$item		= "brdrep_bid, brdrep_did, brdrep_uid, brdrep_dep, brdrep_depsub, brdrep_depuser, brdrep_status, brdrep_regip, brdrep_regdate";
				$value		= "'".$row['BRDATA_BID']."','".$row['BRDATA_ID']."', '".S_mb_id."', '".$brdrep_dep."', '".$brdrep_depsub."', '".$brdrep_depuser."', '2', '".site_client_ip."', '".site_regdate."'";
				$coreClass -> insertQuery(tbl_board_reply, $item, $value);
			}
			
			// 게시글 로그생성
			$type			= "부서지정";
			$bid			= $row['BRDATA_BID'];
			$did			= $row['BRDATA_ID'];
			$bsubject		= $row['BRDATA_SUBJECT'];			
			require_once $dir2."bbs_process_log.php";

			$coreClass -> commit();
			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&mod=view&no=".$no.$listVar);
			break;

		// 답변등록
		case "status2" :
 			
			if(S_mb_level > $board_data['BOARD_LV_INSERT'] && $brdmngCnt < 1) $coreClass -> msg_back("해당글에 대한 권한이 없습니다");

			$coreClass -> begin();
			$where	= "WHERE brdata_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl2, $where);
			$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "");			
			
			// 답변글
			$where2	= "WHERE brdrep_bid = '".$row['BRDATA_BID']."' AND brdrep_did = '".$row['BRDATA_ID']."' AND (brdrep_status = '2' OR brdrep_status = '3')";
			$row2		= $coreClass -> selectQueryArray(tbl_board_reply, $where2, "", "", "");
			$set = "SET
						brdrep_aid		= '".S_mb_id."',
						brdrep_name	= '".S_mb_name."',
						brdrep_content	= '".$brdrep_content."',
						brdrep_ansip		= '".site_client_ip."',
						brdrep_ansdate	= '".site_regdate."',
						brdrep_status	= '3'";
			$where = "WHERE brdrep_no = '".$row2['BRDREP_NO']."'";
			$coreClass -> updateQuery(tbl_board_reply, $set, $where);
			
			// 게시글 로그생성
			$type			= "민원답변등록";
			$bid			= $row['BRDATA_BID'];
			$did			= $row['BRDATA_ID'];
			$bsubject		= $row['BRDATA_SUBJECT'];
			if(!empty($row['BRDATA_CONTENT'])) $bcontent	= $row['BRDATA_CONTENT'] -> load();
			require_once $dir2."bbs_process_log.php";
			
			$coreClass -> commit();			
			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&mod=view&no=".$no.$listVar);
			break;
			
			
		case "comment" :
			if(S_mb_level > $board_data['BOARD_LV_COMMENT']) $coreClass -> msg_back("댓글에 대한 권한이 없습니다");
			if(S_mb_level > site_config_alevel && $chkKey != $spamKey) $coreClass -> msg_back("인증번호 값이 올바르지 않습니다");
			$coreClass -> begin();
			
			$commentusr	= (!$commentusr) ? S_mb_name : $commentusr;
			$commentpass	= (!$commentpass) ? $coreClass -> crypt_sha256(S_mb_id) : $commentpass;
		
			$maxNo		= $coreClass -> selectQueryMax(tbl_board_comment, "brdcmnt_no");
			$maxNo++;
			$id				= str_pad($maxNo, 8, "0", STR_PAD_LEFT);

			//$contents		= htmlspecialchars($contents,ENT_QUOTES);
			$con_data = $contents;

			$item = "brdcmnt_no, brdcmnt_id, brdcmnt_bid, brdcmnt_did, brdcmnt_bno, brdcmnt_name, brdcmnt_uid, brdcmnt_pass, brdcmnt_content, brdcmnt_phone, brdcmnt_regip, brdcmnt_modip, brdcmnt_regdate, brdcmnt_moddate";
			$value = "'".$maxNo."', '".$id."',  '".$bid."', '".$bdid."', '".$bno."', '".$commentusr."', '".S_mb_id."', '".$commentpass."',  '".$contents."', '".$commhp."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."','".site_regdate."'";
			$coreClass -> insertQuery(tbl_board_comment, $item, $value);

			/*$value = "'".$maxNo."', '".$id."',  '".$bid."', '".$bdid."', '".$bno."', '".$commentusr."', '".S_mb_id."', '".$commentpass."',  EMPTY_CLOB(), '".$commhp."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."','".site_regdate."'";
			$coreClass -> insertQuery(tbl_board_comment, $item, $value);

			$clob		= "brdcmnt_content";
			$coreClass -> insertQueryClob(tbl_board_comment, $item, $value, $clob, $con_data);*/

			if($board_data['BOARD_TYPE'] == "board_qna"){ //질문답변일때만 업데이트.
				$where = "where BRDATA_ID ='".$bdid."' and BRDATA_BID = '".$bid."'";
				$setex = "SET BRDATA_EXT_09	= '답변완료'";
				$coreClass -> updateQuery($tbl2_extend, $setex, $where);

				///원본글쓴이가 답변SMS요청시 문자 발송
				$where2	= "WHERE brdata_bid = '".$bid."' AND brdata_id = '".$bdid."'";
				$coreClass -> selectQueryCountChk($tbl2, $where2);
				$row		= $coreClass -> selectQueryArray($tbl2, $where2, "", "", "");

				if($row['BRDATA_SMSIS'] == "Y"){
					require_once $dir2."bbs.reply.sms.send.php";
				}

			}

			$coreClass -> commit();
			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&amp;mod=view&amp;no=".$bno."&amp;pageC=".$pageC.$listVar);
			break;

		case "comment_mod" :
			$where	= "WHERE brdcmnt_no = '".$cno."'";
			$rs		= $coreClass -> selectQueryCount(tbl_board_comment, $where);
			if(!$rs) $coreClass -> msg_back("서장할 댓글이 없습니다.");
			$row	= $coreClass -> selectQueryArray(tbl_board_comment, $where, "", "", "");
			$commentusrwd = $coreClass->crypt_sha256($commentusrwd);

			if($row['BRDCMNT_PASS'] != $commentusrwd) $coreClass->msg_back("비밀번호가 일치하지 않습니다.");
			
			$set = "SET brdcmnt_content = '".$contents."'";
			$coreClass -> updateQuery(tbl_board_comment, $set, $where);	

			$coreClass -> commit();
			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&amp;mod=view&amp;no=".$bno."&amp;pageC=".$pageC.$listVar);
			break;
			
		case "comment_del" :
			$where	= "WHERE brdcmnt_no = '".$cno."'";
			$rs		= $coreClass -> selectQueryCount(tbl_board_comment, $where);
			if(!$rs) $coreClass -> msg_back("삭제할 댓글이 없습니다.");
			$row	= $coreClass -> selectQueryArray(tbl_board_comment, $where, "", "", "");
	

			// 접근 및 비밀번호 체크
			if(S_mb_level > bbs_config_level) {
				if(S_mb_level == site_config_glevel) {
					if($brdata_wd != $row['BRDCMNT_PASS']) {
						$coreClass -> msg_go("비밀번호가 틀렸습니다", "sub.php?menukey=".$menukey."&amp;mod=passchk&amp;rtnmod=".$mod."&amp;rtnact=".$act."&amp;bno=".$bno."&amp;cno=".$cno.$listVar);
					}
				} else if(S_mb_level <= site_config_glevel && S_mb_id != $row['BRDCMNT_UID']){
					$coreClass -> msg_go("댓글에 대한 권한이 없습니다", "sub.php?menukey=".$menukey."&amp;mod=view&amp;no=".$no."&amp;pageC=".$pageC.$listVar);
				}
			}
						
			$coreClass -> deleteQuery(tbl_board_comment, $where);
			$coreClass -> commit();

			$coreClass -> go(site_ssl_http."/sub.php?menukey=".$menukey."&amp;mod=view&amp;no=".$bno."&amp;pageC=".$pageC.$listVar);
			break;
	
		// 게시글 복사
		case "bbscopy":
			if(S_mb_level > site_config_level) $coreClass -> msg_back("글을 복사처리할 권한이 없습니다.");
			$coreClass -> begin();			
			$chkno = $_POST['datasSid'];
				
			$where	= "WHERE BRDATA_NO = '".$chkno."'";
			if($copyReply == "Y"){
				$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "","");
				$where		.= " or (brdata_grp_no = '".$row['BRDATA_GRP_NO']."' and brdata_bid ='".$row['BRDATA_BID']."')";
			}
			$orderby = "ORDER BY brdata_grp_no desc, brdata_seq_no asc, brdata_regdate asc";

			$rst		= $coreClass -> selectQuery($tbl2, $where, $orderby, "","");
			while($row=$coreClass -> selectFetchArray($rst)){
				if($row['BRDATA_SEQ_NO'] == 0){
					$grp_no = $coreClass -> selectQueryMax($tbl2, "brdata_grp_no");
					$grp_no = !$grp_no ? 1 : $grp_no + 1;
				} else {
					$grp_no = $grp_no;
				}

				if($copyReply == "Y"){
					$seq_no = $row['BRDATA_SEQ_NO'];
					$level_no = $row['BRDATA_LEVEL_NO'];
				} else {
					$seq_no = 0;
					$level_no = 0;
				}

				$maxNo	= $coreClass -> selectQueryMax($tbl2, "brdata_no");
				$maxNo++;
				$id			= str_pad($maxNo, 8, "0", STR_PAD_LEFT);

				// 게시글 등록
				$item	= "brdata_no, brdata_grp_no, brdata_seq_no, brdata_level_no, brdata_category, brdata_id, brdata_bid, brdata_uid, brdata_type, brdata_name, brdata_dep, brdata_depsub, brdata_depuser, brdata_pass, brdata_email, brdata_hp, brdata_subject, brdata_content, brdata_notice, brdata_privacy, brdata_deleted, brdata_deltype,  brdata_sdate, brdata_edate, brdata_sexposure, brdata_eexposure, brdata_thumbnail, brdata_authtype, brdata_authkey, brdata_regip, brdata_modip, brdata_regdate, brdata_moddate";
				$item .= ", brdata_fld1, brdata_fld2, brdata_fld3, brdata_fld4, brdata_fld5, brdata_fld6";
				$value	= "'".$maxNo."', '".$grp_no."', ".$seq_no.", ".$level_no.", '".$row['BRDATA_CATEGORY']."', '".$id."', '".$fld."', '".$row['BRDATA_UID']."', '".$row['BRDATA_TYPE']."', '".$row['BRDATA_NAME']."', '".$row['BRDATA_DEP']."', '".$row['BRDATA_DEPSUB']."', '".$row['BRDATA_DEPUSER']."', '".$row['BRDATA_PASS']."', '".$row['BRDATA_EMAIL']."', '".$row['BRDATA_HP']."', '".$row['BRDATA_SUBJECT']."',  '".$row['BRDATA_CONTENT']."', '".$row['BRDATA_NOTICE']."', '".$row['BRDATA_PRIVACY']."', 'N', '1', '".$row['BRDATA_SDATE']."', '".$row['BRDATA_EDATE']."', '".$row['BRDATA_SEXPOSURE']."', '".$row['BRDATA_EEXPOSURE']."', '".$row['BRDATA_THUMBNAIL']."', '".$row['BRDATA_AUTHTYPE']."', '".$row['BRDATA_AUTHKEY']."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
				$value .= ", '".$row['BRDATA_FLD1']."', '".$row['BRDATA_FLD2']."', '".$row['BRDATA_FLD3']."', '".$row['BRDATA_FLD4']."', '".$row['BRDATA_FLD5']."', '".$row['BRDATA_FLD6']."'";
				$coreClass -> insertQuery($tbl2, $item, $value);

				// 복사 전 게시판 정보
				$where2 = " where board_id = '".$row['BRDATA_BID']."'";
				$rs3		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
				$rowp=$coreClass -> selectFetchArray($rs3);

				// 복사 후 게시판 정보
				$where2 = " where board_id = '".$fld."'";
				$rs4		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
				$rown=$coreClass -> selectFetchArray($rs4);

				$where		= "WHERE brdata_bid = '".$fld."' AND brdata_grp_no = '".$grp_no."'";
				$brd_no		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");

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
				$fWhere		= "WHERE BRDATA_ID = '".$row['BRDATA_BID']."'";// AND file_tno = '".$board_data['no']."'
				$rsFile2			= $coreClass -> selectQueryCount(tbl_board_data_extend, $fWhere);

				// 게시글 로그생성
				$type			= "복사";
				$bid			= $row['BRDATA_BID'];
				$did			= $row['BRDATA_ID'];
				$bsubject		= $row['BRDATA_SUBJECT'];
				$bcontent	= $row['BRDATA_CONTENT'];
				require_once $dir2."prc.loging.php";
			}//while

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey.$listVar);
			break;

		// 게시글 이동
		case "bbsmove":
			if(S_mb_level > site_config_level) $coreClass -> msg_back("글을 이동처리할 권한이 없습니다.");
			$coreClass -> begin();			
			$chkno = $_POST['datasSid'];
			$where	= "WHERE BRDATA_NO = '".$chkno."'";
			if($copyReply == "Y"){
				$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "","");
				$where		.= " or (brdata_grp_no = '".$row['BRDATA_GRP_NO']."' and brdata_bid ='".$row['BRDATA_BID']."')";
			}
			$orderby = "ORDER BY brdata_grp_no desc, brdata_seq_no asc, brdata_regdate asc";

			$rst = $coreClass -> selectQuery($tbl2, $where, $orderby, "","");
			while($row = $coreClass -> selectFetchArray($rst)) {
				if($row['BRDATA_SEQ_NO'] == 0){
					$grp_no = $coreClass -> selectQueryMax($tbl2, "brdata_grp_no");
					$grp_no = !$grp_no ? 1 : $grp_no + 1;
				} else {
					$grp_no = $grp_no;
				}

				if($copyReply == "Y"){
					$seq_no = $row['BRDATA_SEQ_NO'];
					$level_no = $row['BRDATA_LEVEL_NO'];
				} else {
					$seq_no = 0;
					$level_no = 0;
				}

				$maxNo	= $coreClass -> selectQueryMax($tbl2, "brdata_no");
				$maxNo++;
				$id		= str_pad($maxNo, 8, "0", STR_PAD_LEFT);
				
				// 게시글 등록
				$item	= "brdata_no, brdata_grp_no, brdata_seq_no, brdata_level_no, brdata_category, brdata_id, brdata_bid, brdata_uid, brdata_type, brdata_name, brdata_dep, brdata_depsub, brdata_depuser, brdata_pass, brdata_email, brdata_hp, brdata_subject, brdata_content, brdata_notice, brdata_privacy, brdata_deleted, brdata_deltype,  brdata_sdate, brdata_edate, brdata_sexposure, brdata_eexposure, brdata_thumbnail, brdata_authtype, brdata_authkey, brdata_regip, brdata_modip, brdata_regdate, brdata_moddate";
				$item .= ", brdata_fld1, brdata_fld2, brdata_fld3, brdata_fld4, brdata_fld5, brdata_fld6";
				$value	= "'".$maxNo."', '".$grp_no."', ".$seq_no.", ".$level_no.", '".$row['BRDATA_CATEGORY']."', '".$id."', '".$fld."', '".$row['BRDATA_UID']."', '".$row['BRDATA_TYPE']."', '".$row['BRDATA_NAME']."', '".$row['BRDATA_DEP']."', '".$row['BRDATA_DEPSUB']."', '".$row['BRDATA_DEPUSER']."', '".$row['BRDATA_PASS']."', '".$row['BRDATA_EMAIL']."', '".$row['BRDATA_HP']."', '".$row['BRDATA_SUBJECT']."',  '".$row['BRDATA_CONTENT']."', '".$row['BRDATA_NOTICE']."', '".$row['BRDATA_PRIVACY']."', 'N', '1', '".$row['BRDATA_SDATE']."', '".$row['BRDATA_EDATE']."', '".$row['BRDATA_SEXPOSURE']."', '".$row['BRDATA_EEXPOSURE']."', '".$row['BRDATA_THUMBNAIL']."', '".$row['BRDATA_AUTHTYPE']."', '".$row['BRDATA_AUTHKEY']."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
				$value .= ", '".$row['BRDATA_FLD1']."', '".$row['BRDATA_FLD2']."', '".$row['BRDATA_FLD3']."', '".$row['BRDATA_FLD4']."', '".$row['BRDATA_FLD5']."', '".$row['BRDATA_FLD6']."'";
				$coreClass -> insertQuery($tbl2, $item, $value);

				// 이전 게시물 이동처리 업데이트 /////////////////////////////////////////////////
				// 복사 전 게시판 정보
				$where2 = " where board_id = '".$row['BRDATA_BID']."'";
				$rs3		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
				$rowp = $coreClass -> selectFetchArray($rs3);

				// 복사 후 게시판 정보
				$where2 = " where board_id = '".$fld."'";
				$rs4		= $coreClass -> selectQuery(tbl_board, $where2, "", "", "");
				$rown = $coreClass -> selectFetchArray($rs4);

				if($row['BRDATA_CONTENT'] != "") {
					$con_data2 = "본 게시물은 성격상 [".$rowp['BOARD_NAME']."]에서 [".$rown['BOARD_NAME']."] 게시판으로 이동되었습니다.<br />------------원본글-------------<br />";
					$con_data2 .=  $row['BRDATA_CONTENT'];	
				} else {
					$con_data2 = "본 게시물은 성격상 [".$rowp['BOARD_NAME']."]에서 [".$rown['BOARD_NAME']."] 게시판으로 이동되었습니다.";
				}
				$subject2 = "[".$rown['BOARD_NAME']."로 이동] ".$row['BRDATA_SUBJECT'];
				
				$where2	= "WHERE BRDATA_NO = '".$chkno."'";
				$set2 = "SET brdata_content = '".$con_data2."', brdata_subject = '".$subject2."', brdata_privacy = 'Y'";
				$coreClass -> updateQuery($tbl2, $set2, $where2);
				////////////////////////////////////////////////////////////////////////////////////

				$where		= "WHERE brdata_bid = '".$fld."' AND brdata_grp_no = '".$grp_no."'";
				$brd_no		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");

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
							
						// 파일 확장자 분리
						$ext = strtolower($file_arr[$num-1]);
						$time = time();
						$new_file_name = $time.$row['BRDATA_NO'].".".$ext;

						// 파일 복사로직추가
						// 폴더 체크
						if(!file_exists($save_path)) @mkdir($save_path, 0707);	
						if(!file_exists($save_path."thumbnail/")) @mkdir($save_path."thumbnail/", 0707);	
						if(!copy($fileUpload."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'], $save_path."/".$new_file_name)) {
							$coreClass -> rollback();
							$coreClass -> msg_back("파일을 지정한 디렉토리에 복사하는데 실패했습니다.");
						} else {
							@copy($fileUpload."/".$fileRow['BRDFILE_YEAR']."/thumbnail/".$fileRow['BRDFILE_SNAME'], $save_path."/thumbnail/".$new_file_name);
						}

						$maxNo	= $coreClass -> selectQueryMax(tbl_board_file, "brdfile_no");
						$maxNo++;

						$item		= "brdfile_no, brdfile_did, brdfile_bid, brdfile_sname, brdfile_name, brdfile_size, brdfile_year, brdfile_hit, brdfile_regip, brdfile_regdate";
						$value		= "'".$maxNo."', '".$brd_no['BRDATA_ID']."', '".$brd_no['BRDATA_BID']."', '".$new_file_name."', '".$fileRow['BRDFILE_NAME']."', '".$fileRow['BRDFILE_SIZE']."', '".date("Y")."', 0, '".site_client_ip."', '".site_regdate."'";
						$coreClass -> insertQuery(tbl_board_file, $item, $value);
					}
				}

				// 게시글 로그생성
				$type		= "이동";
				$bid		= $row['BRDATA_BID'];
				$did		= $row['BRDATA_ID'];
				$bsubject	= $row['BRDATA_SUBJECT'];
				$bcontent	= $row['BRDATA_CONTENT'];
				require_once $dir2."prc.loging.php";
			} //while

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey.$listVar);
			break;

		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>
