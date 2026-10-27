<?php
	if(empty($no)) $coreClass -> msg_back("선택한 게시글이 없습니다.");	
	
	// 카테고리를 사용할 경우
	if($board_data['BOARD_CATEGORY'] == "Y"){
		if(!empty($cate)){
			$category = "";
		} else {
			$category = " AND brdata_category = '$cate' ";
		}
		
		$cWhere	= "WHERE BRDCAT_BID = '".$bid."'";
		$cOrder	= "ORDER BY BRDCAT_NO";
		$cateRs	= $coreClass -> selectQuery(tbl_board_category, $cWhere, $cOrder, "", "");

		$where_info	= "WHERE CMS_INFO_CODE = '".S_mb_scode."'";
		$row_ifno2	= $coreClass -> selectQueryArray(tbl_cms_info, $where_info, "", "", "");
		if($pageInfo['MENU_TITLE'] == "정보마당") {
			$cate = $row_ifno2['CMS_INFO_DATACATE'];
		} else if($pageInfo['MENU_TITLE'] == "주요행사") {
			$cate = $row_ifno2['CMS_INFO_SCHEDULECATE'];
		} else if($pageInfo['MENU_TITLE'] == "묻고답하기") {
			$cate = $row_ifno2['CMS_INFO_QNACATE'];
		}


	}

	// 검색을 위한 where 절
	switch($board_data['BOARD_TYPE']) {
		case "board" :
			$where = "WHERE brdata_bid ='".$bid."' AND brdata_no = '".$no."'";
			break;
		case "board_serv" :
			$where = "WHERE brdata_bid ='".$bid."' AND brdata_no = '".$no."'";
			break;
		case "board_minwon" :
			$where = "LEFT JOIN ".tbl_board_reply." ON brdrep_bid = brdata_bid AND brdrep_did = brdata_id WHERE brdata_bid = '".$bid."' AND brdata_no = '".$no."'";
			break;
		default :
			$where = "WHERE brdata_bid ='".$bid."' AND brdata_no = '".$no."'";
			break;	
	} 
	$coreClass -> selectQueryCountChk(tbl_board_data, $where); 
	$row = $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", ""); 


	//확장필드
	if($board_data['BOARD_EXTEND'] == "Y"){
		$Whereex = "where BRDATA_ID ='".$row['BRDATA_ID']."' and BRDATA_BID = '".$row['BRDATA_BID']."'";
		$rsex		= $coreClass -> selectQuery(tbl_board_data_extend, $Whereex, "", "", "");
		$rowext = $coreClass -> selectFetchArray($rsex);
	}


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

			if(is_file($filepath1) || is_file($filepath2) || is_file($filepath3) || is_file($filepath4)) {				
				/// 첨부파일 이미지 가져오기 - 140623
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
							
				$updList .= '<img src="/home/images/board/file.gif" alt="file" class="file_icon"> <a href="/base/download/bbs.php?fno='.$nokey.'&amp;bid='.$bidkey.'&amp;did='.$didkey.'" class="file">'.$fileRow['BRDFILE_NAME'].'</a>';
				if($mod == "modify") {
					$updList .= "&nbsp;<a href='sub.php?menukey=".$menukey."&mod=process&act=fdelete&no=".$nokey."&amp;bid=".$bidkey."&amp;did=".$didkey."&token=".site_config_token."' onclick=\"if(confirm('이 파일을 삭제하시겠습니까?')){location.href=this.href;}return false;\">[삭제]</a>";
				}
				$updList .= '<span class="down"> ('.number_format($fileRow['BRDFILE_SIZE']).' KB, Download : <b>'.$fileRow['BRDFILE_HIT'].'</b>)</span> ';
				$updList .= '<br>';
			} else {
				$updList .= '<div class="clearfix"><a href="#scrpt" onclick="alert(\'파일이 존재하지 않습니다\')"><img src="/base/imgs/icon/fileicon_cancel.gif" alt="파일없음" style="vertical-align: middle; padding-top: 1px;" />&nbsp;'.$fileRow['BRDFILE_NAME'].'</a></div>';
			}
		}
	}



	// 접근 및 비밀번호 체크
	require_once $dir3.'lib.password.check.php'; 
	
	if(S_mb_level <= $board_data['BOARD_LV_NOTICE']) {
?>
	<script type="text/javascript">
	//<![CDATA[ 
	$.datepicker.setDefaults({
	    monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
	    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
	    showMonthAfterYear:true,
	    dateFormat: 'yy-mm-dd',
	    buttonImageOnly: true,
	    buttonText: "달력",
	    buttonImage: "/base/imgs/btn/btn_calendar.gif"
	});
	$(document).ready(function(){
	
	    $("#brdata_sdate").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdata_edate").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    }) 
	});
	//]]>
	</script>
<?php } ?>


<?php if(S_mb_level <= $board_data['BOARD_LV_EXPOSURE']) { ?>
<script type="text/javascript">
//<![CDATA[ 
	$.datepicker.setDefaults({
	    monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
	    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
	    showMonthAfterYear:true,
	    dateFormat: 'yy-mm-dd',
	    buttonImageOnly: true,
	    buttonText: "달력",
	    buttonImage: "/base/imgs/btn/btn_calendar.gif"
	});
	$(document).ready(function(){
	
	    $("#brdata_sexposure").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdata_eexposure").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    }) 
	});
//]]>
</script>
<?php } ?>
