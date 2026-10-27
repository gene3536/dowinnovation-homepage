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
	$noticeClass = "";
	
	$categoryName = "일반";

	// 카테고리 옵션 
	$cateRs		= NULL;
	if($board_data['BOARD_CATEGORY'] == "Y"){
		
		$cWhere	= "WHERE brdcat_bid = '".$bid."'";
		$cOrder	= "ORDER BY brdcat_seq asc, brdcat_no ASC";
		$cateRs	= $coreClass -> selectQuery(tbl_board_category, $cWhere, $cOrder, "", "");
		
		$cateList2 .= '<div class="search-select"><label for="brdata_category" class="select-label">카테고리 선택</label>
						<select id="brdata_category" name="brdata_category" class="base-select" title="카테고리선택">';
		$cateList2 .= '<option value="">전체</option>';
		$lstCate   = array(); $i = 0;
		while($row_c = $coreClass -> selectFetchArray($cateRs)) {
			if($row['BRDATA_CATEGORY'] == $row_c['BRDCAT_ID']) {
				$sel = ' selected="selected"';
				$categoryName = $row_c['BRDCAT_NAME'];
			} else {
				$sel = '';
			}
			$cateList2 .= '<option value="'.$row_c['BRDCAT_ID'].'"'.$sel.'>'.$row_c['BRDCAT_NAME'].'</option>';
			$lstCate[$i]['ID'] = $row_c['BRDCAT_ID'];
			$lstCate[$i]['NAME'] = $row_c['BRDCAT_NAME'];
			$i++;
		}
		$cateList2 .= '</select></div>';
	}
				
	for($i = 1; $i < $row['BRDATA_LEVEL_NO']; $i++){
		$space.="&nbsp;&nbsp;";
	}
	
	// 게시판명
	$brdTitle	= "WHERE BOARD_ID = '".$row['BRDATA_BID']."'";
	$brdTitle	= $coreClass -> selectQueryArray($tbl1, $brdTitle, "", "" ,"");	
				
	// 답글 아이콘
	$reClass = "";
	if($row['BRDATA_LEVEL_NO']>0) $re = $space."&nbsp;&nbsp;<img src='/base/imgs/icon/icon_reply.gif' alt='답글' style='vertical-align:middle' />&nbsp;";
	if($row['BRDATA_LEVEL_NO']>0) $reClass = "reply";
	
	// 공지 아이콘
	if($row['BRDATA_NOTICE']=='Y'){
		$noticeClass = "notice";
	}else{
		$noticeClass = "";
	}
	// 새글 아이콘
	$newclass = "";
	$after24hours = strtotime($row['BRDATA_REGDATE']) + ($board_data['BOARD_NEW'] * 86400);
	if($after24hours > time()) $new = "<span class=\"pl_3\"><img src=\"images/common/board/board-new.png\" alt=\"new\"></span>";
	if($after24hours > time()) $newclass = "new";
	$new = ($board_data['BOARD_TYPE']=="board_faq")? "" : $new;

	// 비밀글 아이콘
	if($row['BRDATA_PRIVACY'] == "Y") 	$privacy = "<img src='/images/common/board/board-lock.png' alt='비밀글' style='vertical-align:middle' />";
	$secretclass = "";
	if($row['BRDATA_PRIVACY'] == "Y") $secretclass = "lock";
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
		$updForm2 = "";
		for($uc = 1; $uc <= $board_data['BOARD_UPLOADCOUNT']; $uc++) {
			$updForm2 .='<p class="base__fileup">
				<label class="base__fileup-wrap" data-value="찾아보기">
					<input type="file" name="uploadFile'.$uc.'" id="" class="base__fileup-file" title="첨부파일'.$uc.'" />
				</label>
				<input type="text" name="" class="base__fileup-name" readonly="readonly" title="첨부파일이름(읽기전용)" />
			</p>';
			$updForm .= '<input type="file" id="uploadFile'.$uc.'" name="uploadFile'.$uc.'" class="fileline" title="첨부파일 등록'.$uc.'" /><br />';
		}
		$updForm .= '<div>&nbsp;&bull;&nbsp;업로드 가능용량은 '.$board_data['BOARD_UPLOADSIZE'].'MB 입니다.</div>';
	}
	
	// 업로드목록
	$updList	= "";
	$updList_new = "";
	$updList_title = "";
	$fWhere	= "WHERE brdfile_did = '".$row['BRDATA_ID']."' AND brdfile_bid = '".$row['BRDATA_BID']."'";
	$fcnt		= $coreClass -> selectQueryCount(tbl_board_file, $fWhere);

	$attachclass = "";
	if($fcnt > 0) {
		$attachclass = "attach";
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

			$dnbtn1 = '<a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'"><img src="/base/imgs/icon/fileicon_ok.gif" alt="'.$fileRow['BRDFILE_NAME'].'" style="vertical-align: top; padding-top: 1px;" /></a>';
			$dnbtn2 = '<a href="#scrpt" onclick="alert(\'파일이 존재하지 않습니다\')"><img src="/base/imgs/icon/fileicon_cancel.gif" alt="파일없음" style="vertical-align: top; padding-top: 1px;" /></a>';
			
			$fileExists  = false;
			for($i=1; $i<=4; $i++){
				if( is_file( ${"filepath".$i} ) ){
					$fileExists = true;
					break;
				}
			}
			
			$updList_new .= "<p class=\"item\">";

			if($mod == "list" || empty($mod)) {
				if($fileExists) {
					$updList .= $dnbtn1;
					$updList_new .= '<span class="name" data-filetype=".text">'.$fileRow['BRDFILE_NAME'].'</span><a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'" class="link"><span>다운로드</span></a>';
				} else {
					$updList .= $dnbtn2;
					$updList_new .= '<span class="name" data-filetype=".text">파일없음</span><<a href="#scrpt" onclick="alert(\'파일이 존재하지 않습니다\')"><span>다운로드</span></a>';
				}
			} else if($mod == "modify" || $mod == "view") {

				if($fileExists) {
					if($mod == "view") {
						$file_arr = explode(".", $fileRow['BRDFILE_SNAME']);
						$ext = strtolower($file_arr[1]);
						if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png") {
							$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
							$filepath2	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
							$img_path1 = "/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
							
							if(is_file($filepath1) || is_file($filepath2)) {
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
				
					// 다운로드
					// 첨부파일 확장자 체크
					$fileinfo	= pathinfo($fileRow['BRDFILE_SNAME']);
					$ext		= $fileinfo['extension'];
									
					$file_arr2 = explode(".", $fileRow['BRDFILE_NAME']);

					$updList .= '<img src="images/board/file.gif" alt="file" class="file_icon"> <a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'" class="file">'.$fileRow['BRDFILE_NAME'].'</a>';

					$updList_new .= '<span class="name" data-filetype=".'.$ext.'">'.$file_arr2[0].'</span><a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'" class="file"><span>다운로드</span></a>';
					if($mod == "modify") {
						$updList .= "&nbsp;<a href='sub.php?menukey=".$menukey."&mod=process&act=fdelete&fno=".$nokey."&amp;bid=".$bidkey."&amp;did=".$didkey."&token=".site_config_token."' onclick=\"if(confirm('이 파일을 삭제하시겠습니까?')){location.href=this.href;}return false;\">[삭제]</a>";

						$updList_new .= "<a href='sub.php?menukey=".$menukey."&mod=process&act=fdelete&fno=".$nokey."&amp;bid=".$bidkey."&amp;did=".$didkey."&token=".site_config_token."' onclick=\"if(confirm('이 파일을 삭제하시겠습니까?')){location.href=this.href;}return false;\"><span>삭제</span></a>";
					}
					$updList .= '<span class="down"> ('.number_format($fileRow['BRDFILE_SIZE']).' KB, Download : <b>'.$fileRow['BRDFILE_HIT'].'</b>)</span> ';
					$updList .= '<br>';
				} else {
					$updList .= '<div class="clearfix"><a href="#scrpt" onclick="alert(\'파일이 존재하지 않습니다\')"><img src="/base/imgs/icon/fileicon_cancel.gif" alt="파일없음" style="vertical-align: middle; padding-top: 1px;" />&nbsp;'.$fileRow['BRDFILE_NAME'].'</a></div>';
				}

			}
			$updList_new .= "</p>";
		}
	}
?>