<?php
	// 업로드폼
	if($mod == "insert" || $mod == "modify") {
		$updForm = "";
		for($uc = 1; $uc <= 2; $uc++) {
			$updForm .= '<input type="file" id="uploadFile'.$uc.'" name="uploadFile'.$uc.'" class="fileline" title="첨부파일 등록폼" /><br />';
		}
		$updForm .= '<div>&nbsp;&bull;&nbsp;업로드 가능용량은 20MB 입니다.</div>';
	}
	
	// 업로드목록
	$updList	= "";
	$updList_title = "";
	$fWhere	= "WHERE icd_did = '".$row['ICD_ID']."' AND icd_pid = '".$pid."'";
	$fCnt		= $coreClass -> selectQueryCount($tbl3, $fWhere);

	if($fCnt > 0) {
		$frs		= $coreClass -> selectQuery($tbl3, $fWhere, "", "", "");
		while($fileRow = $coreClass -> selectFetchArray($frs)) {
			$path				= $save_path;
			$filepath			= $path.$fileRow['ICD_YEAR']."/".$fileRow['ICD_SNAME'];
			
			$nokey	= "";
			$nokey	= $coreClass -> crypt_md5($fileRow['ICD_NO'], site_config_filekey);
			$pidkey	= "";
			$pidkey	= $coreClass -> crypt_md5($fileRow['ICD_PID'], site_config_filekey);
			$didkey	= "";
			$didkey	= $coreClass -> crypt_md5($row['ICD_ID'], site_config_filekey);	
			$iicd_path	= "";	
			
			$dnbtn1 = '<a href="/base/download/icd.php?fno='.$nokey.'&amp;pid='.$pidkey.'&amp;did='.$didkey.'"><img src="/base/imgs/icon/fileicon_ok.gif" alt="'.$fileRow['ICD_NAME'].'" style="vertical-align: middle; padding-bottom:2px;" /></a>';
			$dnbtn2 = '<a href="#" onclick="alert(\'파일이 존재하지 않습니다\'); return false;"><img src="/base/imgs/icon/fileicon_cancel.gif" alt="파일없음" style="vertical-align: top; padding-top: 1px;" /></a>';
			
			if($mod == "list" || empty($mod)) {
				if(!is_file($filepath)) {
					$filepath = mb_convert_encoding($filepath, "EUC-KR", "UTF-8");
					if(!is_file($filepath)) {
						$updList .= $dnbtn2;
					} else {
						$updList .= $dnbtn1;
					}
				} else {
					$updList .= $dnbtn1;			
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
					// 첨부파일 확장자 체크
					$fileinfo	= pathinfo($fileRow['ICD_SNAME']);
					$ext		= $fileinfo['extension'];
					
					$updList .= '<div class="clearfix">';
					$updList .= '<a href="/base/download/icd.php?fno='.$nokey.'&amp;pid='.$pidkey.'&amp;did='.$didkey.'"><img src="/base/imgs/icon/fileicon_ok.gif" alt="'.$fileRow['ICD_NAME'].'" style="vertical-align: middle; padding-bottom:2px;" />&nbsp;'.$fileRow['ICD_NAME'].'</a>';
					if($mod == "modify") {
						$updList .= '&nbsp;<a href="sub.php?menukey='.$menukey.'&mod=process&act=fdelete&fno='.$nokey.'&amp;pid='.$pidkey.'&amp;did='.$didkey.'&token='.site_config_token.'">[삭제]</a>';
					}
					$updList .= '</div>';
				} else {
					$updList .= '<div class="clearfix"><a href="javascript:alert(\'파일이 존재하지 않습니다\')"><img src="/base/imgs/icon/fileicon_cancel.gif" alt="파일없음" style="vertical-align: middle; padding-top: 1px;" />&nbsp;'.$fileRow['ICD_NAME'].'</a></div>';
				}
			}
		}
	}
?>
