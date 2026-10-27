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
	
	// 게시판명
	$brdTitle	= "WHERE BOARD_ID = '".$row['BRDATA_BID']."'";
	$brdTitle	= $coreClass -> selectQueryArray($tbl3, $brdTitle, "", "" ,"");	
				
	// 답글 아이콘
	if($row['BRDATA_LEVEL_NO']>0) $re = $space."&nbsp;&nbsp;<img src='/base/imgs/icon/icon_reply.gif' alt='답글' style='vertical-align:middle' />&nbsp;";
				
	// 새글 아이콘
	$after24hours = strtotime($row['BRDATA_REGDATE']) + ($board_data['BOARD_NEW'] * 86400);
	if($after24hours > time()) $new = "<span class=\"pl_3\"><img src=\"images/board/new.gif\" alt=\"new\"></span>";
	$new = ($board_data['BOARD_TYPE']=="board_faq")? "" : $new;

	// 비밀글 아이콘
	if($row['BRDATA_PRIVACY'] == "Y") 	$privacy = "<img src='/base/imgs/icon/icon_privacy.gif' alt='비밀글' style='vertical-align:middle' />";
	
	//조횟수 하이라이트
	//if($board_data['BOARD_HOT'] <= $row['BRDATA_HIT']) 	$hit = "<strong>".$row['BRDATA_HIT']."</strong>";
	//else $hit = $row['BRDATA_HIT'];
	$hit = $row['BRDATA_HIT'];
		
	// 제목 문자열 자르기
	$subject = $coreClass -> getSub2Str($board_data['BOARD_SUBJECT_LEN'], $row['BRDATA_SUBJECT']);

	// 작성자
	$name = $row['BRDATA_NAME'];
	if(!empty($row['BRDATA_EMAIL'])) {
		$name = '<a href="mailto:'.$row['BRDATA_EMAIL'].'">'.$name.'</a>';
	} else {
		$name = $name;
	}

	// 실명인증, 공공아이핀 아이콘
	if($row['BRDATA_AUTHTYPE'] == 1) {
		$authicon = '<img src="/base/imgs/icon/icon_auth1.gif" alt="실명인증" style="vertical-align:top;" />';
	} else if ($row['BRDATA_AUTHTYPE'] == 2) {
		$authicon = '<img src="/base/imgs/icon/icon_auth2.gif" alt="공공아이핀" style="vertical-align:top;" />';
	}
				
	// 댓글 숫자
	if($board_data['BOARD_COMMENT'] == "Y") {
		$cmntWhere	= "WHERE brdcmnt_bid = '".$bid."' and brdcmnt_bno = '".$row['BRDATA_NO']."'";
		$cmntRs		= $coreClass -> selectQueryCount(tbl_board_comment, $cmntWhere);
		if($cmntRs > 0 ) $cmntValue = '<span style="color:orange;"><strong>['.$cmntRs.']</strong></span>';
	}
	
	// 삭제관련
	if($row['BRDATA_DELETED'] == 'N') {
		$deleted = '<span style="color:#00f;">활성</span>';
		$delBtn = '<a href="sub.php?menukey='.$menukey.'&mod=process&act=delete&no='.$row['BRDATA_NO'].'&token='.site_config_token.$listVar.'" class="btn_sml" onClick="if(confirm(\'삭제합니까?\n\n내용이 모두 삭제됩니다.\')) location.href=this.href; return false"><span>삭제</span></a>';
	} else if($row['BRDATA_DELETED'] == 'Y') {
		if($row['BRDATA_DELTYPE'] == '1') {
			$deleted = '<span style="color:#f00;">삭제</span>';
		} else if($row['BRDATA_DELTYPE'] == '2') {
			$deleted = '<span style="color:#f00;">관리자삭제</span>';
		} else if($row['BRDATA_DELTYPE'] == '3') {
			$deleted = '<span style="color:#f00;">사용자삭제</span>';
		}
		$delBtn = '<a href="sub.php?menukey='.$menukey.'&mod=process&act=restore&no='.$row['BRDATA_NO'].'&token='.site_config_token.''.$listVar.'" class="btn_sml"><span>복구</span></a>&nbsp;';
		$delBtn .= '<a href="sub.php?menukey='.$menukey.'&mod=process&act=adelete&no='.$row['BRDATA_NO'].'&token='.site_config_token.''.$listVar.'" class="btn_sml" onClick="if(confirm(\'완전삭제합니까?\n\n내용이 모두 완전삭제됩니다.\')) location.href=this.href; return false"><span>완전삭제</span></a>';		
	}
	
	// 업로드폼
	if($mod == "insert" || $mod == "modify" || $mod == "reply") {
		$thumbForm = '<input type="file" id="thumbFile" name="thumbFile" class="fileline" title="썸네일 등록폼" /><br />';
		
		$updForm = "";
		for($uc = 1; $uc <= $board_data['BOARD_UPLOADCOUNT']; $uc++) {
			$updForm .= '<input type="file" id="uploadFile'.$uc.'" name="uploadFile'.$uc.'" class="fileline" title="첨부파일 등록'.$uc.'" /><br />';
		}
		$updForm .= '<div>&nbsp;&bull;&nbsp;업로드 가능용량은 '.$board_data['BOARD_UPLOADSIZE'].'MB 입니다.</div>';
	}
	
	// 업로드목록
	$updList	= "";
	$updList_title = "";
	$fWhere	= "WHERE brdfile_did = '".$row['BRDATA_ID']."' AND brdfile_bid = '".$row['BRDATA_BID']."'";
	$fcnt		= $coreClass -> selectQueryCount(tbl_board_file, $fWhere);

	if($fcnt > 0) {
		$frs		= $coreClass -> selectQuery(tbl_board_file, $fWhere, "", "", "");
		while($fileRow = $coreClass -> selectFetchArray($frs)) {
			$nokey	= "";
			$nokey	= $coreClass -> crypt_md5($fileRow['BRDFILE_NO'], site_config_filekey);
			$bidkey	= "";
			$bidkey	= $coreClass -> crypt_md5($fileRow['BRDFILE_BID'], site_config_filekey);
			$didkey	= "";
			$didkey	= $coreClass -> crypt_md5($row['BRDATA_ID'], site_config_filekey);	
			$img_path	= "";	
			
			$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
			$filepath2	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
			$filepath3	= dir_public.$fileRow['BRDFILE_PATH'].$fileRow['BRDFILE_SNAME'];
			$filepath4	= mb_convert_encoding($filepath3, "EUC-KR", "UTF-8");
			
			$dnbtn1 = '<a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'"><img src="/base/imgs/icon/fileicon_ok3.gif" alt="'.$fileRow['BRDFILE_NAME'].'" style="vertical-align: top; padding-top: 1px;" /></a>';
			$dnbtn2 = '<a href="#scrpt" onclick="alert(\'파일이 존재하지 않습니다\')"><img src="/base/imgs/icon/fileicon_cancel3.gif" alt="파일없음" style="vertical-align: top; padding-top: 1px;" /></a>';

			if($mod == "list" || empty($mod)) {
				if(is_file($filepath1) || is_file($filepath2) || is_file($filepath3) || is_file($filepath4)) {
					$updList .= $dnbtn1;
				} else {
					$updList .= $dnbtn2;
				}
			} else if($mod == "modify" || $mod == "view") {
				if(is_file($filepath1) || is_file($filepath2) || is_file($filepath3) || is_file($filepath4)) {				
					/// 첨부파일 이미지 가져오기 - 140623
					if($mod == "view") {
						$file_arr = explode(".", $fileRow['BRDFILE_SNAME']);
						$ext = strtolower($file_arr[1]);
						if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png") {
							$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
							$filepath2	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
							$img_path1 = "/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
							
							if(is_file($filepath1)) {
								$imgPath = $img_path1;
							}
	
							$nokey	= "";
							$nokey	= $coreClass -> crypt_md5($fileRow['BRDFILE_NO'], site_config_filekey);
							$bidkey	= "";
							$bidkey	= $coreClass -> crypt_md5($fileRow['BRDFILE_BID'], site_config_filekey);
							$didkey	= "";
							$didkey	= $coreClass -> crypt_md5($row['BRDATA_ID'], site_config_filekey);
							
							$imgView .= '
								<a href="/base/php/view.image.php?no='.$nokey.'&bid='.$bidkey.'&amp;did='.$didkey.'" onclick="window.open(this.href, \'limg\', \'width=1024px, height=820px, top=100px, left=100px, scrollbars=yes\'); return false" target="_blank">	
									<img src="'.$imgPath.'" alt="'.$row['BRDATA_SUBJECT'].'" style="width: 720px;">
								</a>';
						}
					}
				
					// 뷰어보기, 다운로드
					// 첨부파일 확장자 체크
					$fileinfo	= pathinfo($fileRow['BRDFILE_SNAME']);
					$ext		= $fileinfo['extension'];

					$previewFile = (is_file($filepath1))? $filepath1 :  (is_file($filepath1))? $filepath1 : ""  ; 
									
					$updList .= '<img src="../home/images/board/file.gif" alt="file" class="file_icon"> <a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'" class="file">'.$fileRow['BRDFILE_NAME'].'</a>';
					if($mod == "modify") {
						$updList .= "&nbsp;<a href='sub.php?menukey=".$menukey."&mod=process&act=fdelete&fno=".$nokey."&amp;bid=".$bidkey."&amp;did=".$didkey."&token=".site_config_token."' onclick=\"if(confirm('이 파일을 삭제하시겠습니까?')){location.href=this.href;}return false;\">[삭제]</a>";
					}
					$updList .= '<span class="down"> ('.number_format($fileRow['BRDFILE_SIZE']).' KB, Download : <b>'.$fileRow['BRDFILE_HIT'].'</b>)</span> ';
					$updList .= '<br>';
				} else {
					$updList .= '<div class="clearfix"><a href="#scrpt" onclick="alert(\'파일이 존재하지 않습니다\')"><img src="/base/imgs/icon/fileicon_cancel.gif" alt="파일없음" style="vertical-align: middle; padding-top: 1px;" />&nbsp;'.$fileRow['BRDFILE_NAME'].'</a></div>';
				}
			}
		}
	}
?>