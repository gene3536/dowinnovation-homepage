<?php
// 업로드목록
	$updList	= "";
	$updList_title = "";
	$fWhere	= "WHERE icd_did = '".$row['ICD_ID']."' AND icd_pid = '".$row['ICD_PID']."'";
	$fcnt		= $coreClass -> selectQueryCount(tbl_cms_icd_file, $fWhere);

	if($fcnt > 0) {
		$frs		= $coreClass -> selectQuery(tbl_cms_icd_file, $fWhere, "", "", "");
		while($fileRow = $coreClass -> selectFetchArray($frs)) {
			$nokey	= "";
			$nokey	= $coreClass -> crypt_md5($fileRow['ICD_NO'], site_config_filekey);
			$bidkey	= "";
			$bidkey	= $coreClass -> crypt_md5($fileRow['ICD_PID'], site_config_filekey);
			$didkey	= "";
			$didkey	= $coreClass -> crypt_md5($row['ICD_ID'], site_config_filekey);	
			$img_path	= "";	
			
			$filepath1	= dir_public."/upload/icd/".$row['ICD_PID']."/".$fileRow['ICD_YEAR']."/".$fileRow['ICD_SNAME'];
			$filepath2	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
			
			$dnbtn1 = '<a href="/base/download/icd.php?fno='.$nokey.'&amp;pid='.$bidkey.'&amp;did='.$didkey.'"><img src="/base/imgs/icon/fileicon_ok3.gif" alt="'.$fileRow['ICD_NAME'].'" style="vertical-align: top; padding-top: 1px;" /></a>';
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
						$file_arr = explode(".", $fileRow['ICD_SNAME']);
						$ext = strtolower($file_arr[1]);
						if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png") {
							$filepath1	= dir_public."/upload/icd/".$row['ICD_PID']."/".$fileRow['ICD_YEAR']."/".$fileRow['ICD_SNAME'];
							$filepath2	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
							$img_path1 = "/upload/icd/".$row['ICD_PID']."/".$fileRow['ICD_YEAR']."/".$fileRow['ICD_SNAME'];
							
							if(is_file($filepath1)) {
								$imgPath = $img_path1;
							}
	
							$nokey	= "";
							$nokey	= $coreClass -> crypt_md5($fileRow['ICD_NO'], site_config_filekey);
							$bidkey	= "";
							$bidkey	= $coreClass -> crypt_md5($fileRow['ICD_PID'], site_config_filekey);
							$didkey	= "";
							$didkey	= $coreClass -> crypt_md5($row['ICD_ID'], site_config_filekey);
							
							$imgView .= '
								<a href="/base/php/view.image.php?no='.$nokey.'&bid='.$bidkey.'&amp;did='.$didkey.'" onclick="window.open(this.href, \'limg\', \'width=1024px, height=820px, top=100px, left=100px, scrollbars=yes\'); return false" target="_blank">	
									<img src="'.$imgPath.'" alt="'.$row['ICD_TITLE'].'" style="width: 720px;">
								</a>';
						}
					}
				
					// 뷰어보기, 다운로드
					// 첨부파일 확장자 체크
					$fileinfo	= pathinfo($fileRow['ICD_SNAME']);
					$ext		= $fileinfo['extension'];

					$previewFile = (is_file($filepath1))? $filepath1 :  (is_file($filepath1))? $filepath1 : ""  ; 
									

					$updList .= '<img src="../home/images/board/file.gif" alt="file" class="file_icon"> <a href="/base/download/icd.php?fno='.$nokey.'&amp;pid='.$bidkey.'&amp;did='.$didkey.'" class="file">'.$fileRow['ICD_NAME'].'</a>';
					if($mod == "modify") {
						$updList .= "&nbsp;<a href='sub.php?menukey=".$menukey."&mod=process&act=fdelete&fno=".$nokey."&amp;bid=".$bidkey."&amp;did=".$didkey."&token=".site_config_token."' onclick=\"if(confirm('이 파일을 삭제하시겠습니까?')){location.href=this.href;}return false;\">[삭제]</a>";
					}
					$updList .= '<span class="down"> ('.number_format($fileRow['ICD_SIZE']).' KB, Download : <b>'.$fileRow['ICD_HIT'].'</b>)</span> ';
					$updList .= '<br>';
				} else {
					$updList .= '<div class="clearfix"><a href="#scrpt" onclick="alert(\'파일이 존재하지 않습니다\')"><img src="/base/imgs/icon/fileicon_cancel.gif" alt="파일없음" style="vertical-align: middle; padding-top: 1px;" />&nbsp;'.$fileRow['ICD_NAME'].'</a></div>';
				}
			}
		}
	}
	?>