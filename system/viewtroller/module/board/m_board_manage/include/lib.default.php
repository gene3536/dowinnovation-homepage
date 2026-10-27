<?php
	$space		= "";
	$re      		= "";
	$new			= "";
	$privacy		= "";
	$file			= "";
	$authicon		= "";
	$cmntValue	= "";
	$viewBox		= "";
	$fileBox		= "";
				
	for($i = 1; $i < $row['BRDATA_LEVEL_NO']; $i++){
		$space.="&nbsp;&nbsp;";
	}
				
	// 답글 아이콘
	if($row['BRDATA_LEVEL_NO']>0) $re = $space."&nbsp;&nbsp;<img src='/base/imgs/icon/icon_reply.gif' alt='답글' style='vertical-align:middle' />&nbsp;";
				
	// 새글 아이콘
	$after24hours = strtotime($row['BRDATA_REGDATE']) + ($board_data['BOARD_NEW'] * 86400);
	if($after24hours > time()) $new = "<img src='/base/imgs/icon/icon_new.gif' alt='새글' style='vertical-align:middle' />";

	// 비밀글 아이콘
	if($row['BRDATA_PRIVACY'] == "Y") 	$privacy = "<img src='/base/imgs/icon/icon_privacy.gif' alt='비밀글' style='vertical-align:middle' />";
	
	//조횟수 하이라이트
	if($board_data['BOARD_HOT'] <= $row['BRDATA_HIT']) 	$hit = "<strong>".$row['BRDATA_HIT']."</strong>";
	else $hit = $row['BRDATA_HIT'];
		
	// 제목 문자열 자르기
	$subject = $coreClass -> getSub2Str($board_data['BOARD_SUBJECT_LEN'], $row['BRDATA_SUBJECT']);

	// qna 게시판이고 비밀글이고 볼수 잇는 권한이 아니고 본인 작성이 아니면 이름 * 처리
	if($board_data['BOARD_TYPE'] == "board_qna" and $row['BRDATA_PRIVACY'] == "Y" and S_mb_level > site_config_slevel and S_mb_id != $row['BRDATA_UID']){
		$name_text = $coreClass -> getSub2StrName(4, $row['BRDATA_NAME'], "**");
	}else if(($board_data['BOARD_TYPE'] == "board_term_teacher" or $board_data['BOARD_TYPE'] == "board_term_job") and S_mb_level > site_config_slevel and S_mb_id != $row['BRDATA_UID'] ){
		$name_text = $coreClass -> getSub2StrName(4, $row['BRDATA_NAME'], "**");
	}else{
		$name_text = $row['BRDATA_NAME'];
	}

	if(!empty($row['BRDATA_EMAIL'])) {
		$name = "<a href=\"mailto:".$row['BRDATA_EMAIL']."\">".$name_text."</a>";
	} else {
		$name = $name_text;
	}

	// 실명인증, 공공아이핀 아이콘
	if($row['BRDATA_AUTHTYPE'] == 1) {
		$authicon = "<img src=\"/base/imgs/icon/icon_auth1.gif\" alt=\"실명인증\" style=\"vertical-align:top;\" />";
	} else if ($row['BRDATA_AUTHTYPE'] == 2) {
		$authicon = "<img src=\"/base/imgs/icon/icon_auth2.gif\" alt=\"공공아이핀\" style=\"vertical-align:top;\" />";
	}
				
	// 댓글 숫자
	if($board_data['BOARD_COMMENT'] == 'Y') {
		$cmntWhere	= "WHERE brdcmnt_bid = '".$bid."' and brdcmnt_bno = '".$row['BRDATA_NO']."'";
		$cmntRs		= $coreClass -> selectQueryCount(tbl_board_comment, $cmntWhere);
		if($cmntRs > 0 ) $cmntValue = "<span style=\"color:orange;\"><strong>[".$cmntRs."]</strong></span>";
	}
	
	// 업로드폼
	$updForm = "";
	for($uc = 1; $uc <= $board_data['BOARD_UPLOADCOUNT']; $uc++) {
		$updForm .= '<input type="file" id="uploadFile'.$uc.'" name="uploadFile'.$uc.'" class="fileline" title="첨부파일 등록폼" /><br />';
	}
	$updForm .= '<div>&nbsp;&bull;&nbsp;업로드 가능용량은 '.$board_data['BOARD_UPLOADSIZE'].'MB 입니다.</div>';
	
	// 업로드목록
	$updList	= "";
	$updList_title = "";
	if(empty($bid)) $bid = $row['BRDATA_BID'];
	$fWhere	= "WHERE brdfile_did = '".$row['BRDATA_ID']."' AND brdfile_bid = '".$bid."'";
	$rsFile		= $coreClass -> selectQueryCount(tbl_board_file, $fWhere);

	if($rsFile > 0) {
		$rs		= $coreClass -> selectQuery(tbl_board_file, $fWhere, "", "", "");
		while($fileRow = $coreClass -> selectFetchArray($rs)) {
			$filepath	= dir_public."/upload/bbs/".$bid."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
			$nokey	= "";			
			$nokey	= $coreClass -> crypt_md5($fileRow['BRDFILE_NO'], site_config_filekey);
			$bidkey	= "";
			$bidkey	= $coreClass -> crypt_md5($fileRow['BRDFILE_BID'], site_config_filekey);
			$didkey	= "";
			$didkey	= $coreClass -> crypt_md5($row['BRDATA_ID'], site_config_filekey);	
			$img_path	= "";	

			if($mod == "list" || empty($mod)) {

				if($menukey == 1010){
					//echo $filepath;
				}
				if(!is_file($filepath)) {

					$filepath	= mb_convert_encoding($filepath, "EUC-KR", "UTF-8");
					if(!is_file($filepath)) {
						$updList = '<a href="javascript:alert(\'파일이 존재하지 않습니다\')"><img src="/base/imgs/icon/fileicon_cancel.gif" alt="파일없음" style="vertical-align: top; padding-top: 1px;" /></a>';
					} else {
						$updList = '<a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'"><img src="/base/imgs/icon/fileicon_ok.gif" alt="'.$fileRow['BRDFILE_NAME'].'" style="vertical-align: top; padding-top: 1px;" /></a>';				
					}

					if($board_data['BOARD_TYPE'] == "board_archive_title"){ //기록관 타이틀형 게시판

						$updList_title = '<a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'">'.$row['BRDATA_SUBJECT'].'</a>';	

					}

				} else {
					$updList = '<a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'"><img src="/base/imgs/icon/fileicon_ok.gif" alt="'.$fileRow['BRDFILE_NAME'].'" style="vertical-align: top; padding-top: 1px;" /></a>';			
						
					///사이트 링크 게시판 일때 이미지 가져오기
					if($board_data['BOARD_TYPE'] == "board_site_link"){
						
						$file_arr		= explode(".", $fileRow['BRDFILE_SNAME']);
						$ext			= strtolower($file_arr[1]);
						if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png"){
							if( $board_data['BOARD_THUM_WID'] != "") $thim_width = $board_data['BOARD_THUM_WID']."px";
							else $thim_width = "100px";

							if( $board_data['BOARD_THUM_HEI'] != "") $thim_height = $board_data['BOARD_THUM_HEI']."px";
							else $thim_height = "100px";

							$filepath	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/thumbnail/".$fileRow['BRDFILE_SNAME'];
							if(is_file($filepath)) {
								$img_path = "<img src=\"/upload/bbs/".$bid."/".$fileRow['BRDFILE_YEAR']."/thumbnail/".$fileRow['BRDFILE_SNAME']."\" width=\"".$thim_width."\" height=\"".$thim_height."\">";
							} else {
								$filepath	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/thumbnail/thumbnail_".$fileRow['BRDFILE_SNAME'];
								//$filepath	= mb_convert_encoding($filepath, "EUC-KR", "UTF-8");
								if(is_file($filepath)) {
									$img_path = "<img src=\"/upload/bbs/".$bid."/".$fileRow['BRDFILE_YEAR']."/thumbnail/thumbnail_".$fileRow['BRDFILE_SNAME']."\" width=\"".$thim_width."\" height=\"".$thim_height."\">";
								}
							}
						}
					}else if($board_data['BOARD_TYPE'] == "board_archive_title"){ //기록관 타이틀형 게시판

						$updList_title = '<a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'">'.$row['BRDATA_SUBJECT'].'</a>';	

					}
				}
			} else if($mod == "modify" || $mod == "view") {
				$valid = false;
				if(is_file($filepath)) {
					$valid = true;
				} else {
					$filepath	= mb_convert_encoding($filepath, "EUC-KR", "UTF-8");
					if(is_file($filepath)) {
						$valid = true;			
					}
				}
				if($valid == true) {
					$updList .= '<div class="clearfix">';
					$updList .= '<a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'"><img src="/base/imgs/icon/fileicon_ok.gif" alt="'.$fileRow['BRDFILE_NAME'].'" style="vertical-align: middle; padding-top: 1px;" />&nbsp;'.$fileRow['BRDFILE_NAME'].'</a>';
					if($mod == "modify") {
						$updList .= '&nbsp;<a href="sub.php?menukey='.$menukey.'&mod=process&act=fdelete&fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'&token='.site_config_token.'">[삭제]</a>';
					}
					$updList .= '
						<div style="position:inline-block; float:right;">
							<a href="/base/php/viewer.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'" target="_blank"><img src="/base/imgs/icon/btn_viewer.gif" alt="뷰어  다운로드" /></a>
							<a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'"><img src="/base/imgs/icon/btn_download.gif" alt="다운로드" /></a>
						</div>';		
					$updList .= '</div>';
				} else {
					$updList .= '<a href="javascript:alert(\'파일이 존재하지 않습니다\')"><img src="/base/imgs/icon/fileicon_cancel.gif" alt="파일없음" style="vertical-align: middle; padding-top: 1px;" />&nbsp;'.$fileRow['BRDFILE_NAME'].'</a>';
				}
				$updList .= '';
			}
		}
	}
?>