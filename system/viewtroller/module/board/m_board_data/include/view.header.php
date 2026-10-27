<?php
	if(empty($no)){
		if(site_language == "eng") $coreClass -> msg_back("No post selected.");
		else $coreClass -> msg_back("선택한 게시글이 없습니다.");
	}
	
	// 게시글 정보 쿼리
	if(S_mb_level <= bbs_config_level) {
		$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no = '".$no."'";
	} else {
		$where	= "WHERE brdata_bid = '".$bid."' AND  brdata_deleted = 'N' AND brdata_no = '".$no."'";
	}
	
	// 1:1 글보기 옵션
	if(S_mb_level > bbs_config_level && $board_data['BOARD_OTO'] == 'Y') {
		$where .= " AND brdata_uid = '".S_mb_id."'";
	}	

	$coreClass -> selectQueryCountChk(tbl_board_data, $where);
	$row = $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", "");

	if(S_mb_level > $board_data['BOARD_LV_VIEW'] && $brdmngCnt < 1 && S_mb_id != $row['BRDATA_UID']){
		if(site_language == "eng") $coreClass -> msg_go("No view permission.","/member/member.php?memberkey=1&refcode=1");
		else $coreClass -> msg_go("보기 권한이 없습니다.","/member/member.php?memberkey=1&refcode=1");
	}

	// 답변글
	if($board_data['BOARD_TYPE'] == "board_minwon") {
		$rwhere	= "WHERE brdrep_bid = '".$row['BRDATA_BID']."' AND brdrep_did = '".$row['BRDATA_ID']."'";
		$rrow		= $coreClass -> selectQueryArray(tbl_board_reply, $rwhere, "", "", "");	
	}

	if($row['BRDATA_PRIVACY'] == "Y" && ( isset($_SESSION['view'.$row['BRDATA_GRP_NO']]) && $_SESSION['view'.$row['BRDATA_GRP_NO']] == 1 ) ){
	}else{
	
		// 비밀글 사용시 접근권한
		if($row['BRDATA_PRIVACY'] == "Y" and $board_data['BOARD_TYPE'] == "board_qna" and (S_mb_id != $row['BRDATA_UID'] and S_mb_level >= site_config_alevel)) { //질문답변 게시판 일반회원일때 본인 비밀글만보기 // 
			//
			if(S_mb_level > bbs_config_level && (S_mb_id != $row['BRDATA_UID'] || S_mb_level == site_config_glevel)) {
				// 답글일때에는 원글의 비밀번호 가져와 비교.. 현재글의 비밀번호도 같이 비교..
				if($row['BRDATA_SEQ_NO'] > 0 && $row['BRDATA_PRIVACY'] == "Y"){
					$where2	= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$row['BRDATA_GRP_NO']."' and brdata_level_no = '0'";
					$row2		= $coreClass -> selectQueryArray(tbl_board_data, $where2, "", "","");
					if(S_mb_id != $row['BRDATA_UID'] && S_mb_id != $row2['BRDATA_UID']){
						if(site_language == "eng") $coreClass -> msg_back("No access permission.");					
						else $coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");					
					}
				} else if($row['BRDATA_UID'] != "guest" and (S_mb_id != $row['BRDATA_UID'] and S_mb_level >= site_config_alevel)){
					if(site_language == "eng") $coreClass -> msg_back("No access permission.");	
					else $coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");	
				}else {
					if($brdata_wd != "" &&  $brdata_wd != $row['BRDATA_PASS'] && $brdata_wd2 != $row['BRDATA_PASS']) {
						if(site_language == "eng"){
							$coreClass -> msg_go("Entered wrong passwords.", "sub.php?menukey=".$menukey."&amp;mod=passchk&amp;rtnmod=".$rtnmod."&amp;rtnact=".$rtnact."&amp;no=".$no.$listVar);
						}else{
							$coreClass -> msg_go("비밀번호가 틀렸습니다.", "sub.php?menukey=".$menukey."&amp;mod=passchk&amp;rtnmod=".$rtnmod."&amp;rtnact=".$rtnact."&amp;no=".$no.$listVar);
						}
					}				
					//$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");
				}
			}

		}else if($board_data['BOARD_TYPE'] == "board_qna" and S_mb_id != $row['BRDATA_UID'] and S_mb_level > bbs_config_level and S_mb_level > site_config_level ){ //질답 보인이나 관리자 아닐때 부서체크

			 if(S_mb_id != $row['BRDATA_UID'] and S_mb_level > 5 ){
				if(site_language == "eng") $coreClass -> msg_go("No access permission.", "sub.php?menukey=".$menukey."&amp;mod=list");	
				else  $coreClass -> msg_go("접근 권한이 없습니다.", "sub.php?menukey=".$menukey."&amp;mod=list");	
			}else if(site_config_code == "00000001" and (S_mb_level <= site_config_slevel and S_mb_scode != "00000001" and S_mb_level > 1)) {// 질문답변 당부서 관리자가 아닐때 못보게 처리 

				$where_info	= "WHERE CMS_INFO_CODE = '".S_mb_scode."'";
				$row_ifno2	= $coreClass -> selectQueryArray(tbl_cms_info, $where_info, "", "", "");
				if($row_ifno2['CMS_INFO_QNACATE'] != $row['BRDATA_CATEGORY']){
					if(site_language == "eng") $coreClass -> msg_go("No access permission.", "sub.php?menukey=".$menukey."&amp;mod=list");
					else $coreClass -> msg_go("접근 권한이 없습니다.", "sub.php?menukey=".$menukey."&amp;mod=list");	
				}

			}

		}else if($row['BRDATA_PRIVACY'] == "Y") {
			if(S_mb_level > bbs_config_level &&  S_mb_level > bbs_config_level && (S_mb_id != $row['BRDATA_UID'] || S_mb_level == site_config_glevel)) {
				// 답글일때에는 원글의 비밀번호 가져와 비교.. 현재글의 비밀번호도 같이 비교..
				if($row['BRDATA_SEQ_NO'] > 0 && $row['BRDATA_PRIVACY'] == "Y"){
					$where2	= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$row['BRDATA_GRP_NO']."' and brdata_level_no = '0'";
					$row2		= $coreClass -> selectQueryArray(tbl_board_data, $where2, "", "","");
					if(S_mb_id != $row['BRDATA_UID'] && S_mb_id != $row2['BRDATA_UID']){
						if(site_language == "eng") $coreClass -> msg_back("No access permission.");					
						else $coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");		
					}
				} else if($row['BRDATA_SEQ_NO'] == 0 && $row['BRDATA_PRIVACY'] == "Y" and S_mb_id != $row['BRDATA_UID']){
					if(site_language == "eng") $coreClass -> msg_back("No access permission.");	
					else $coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");	 
				}else {
					if($brdata_wd != $row['BRDATA_PASS'] && $brdata_wd2 != $row['BRDATA_PASS']) {
						if(site_language == "eng") {
							$coreClass -> msg_go("Entered wrong passwords.", "sub.php?menukey=".$menukey."&amp;mod=passchk&amp;rtnmod=".$rtnmod."&amp;rtnact=".$rtnact."&amp;no=".$no.$listVar);
						}else{
							$coreClass -> msg_go("비밀번호가 틀렸습니다.", "sub.php?menukey=".$menukey."&amp;mod=passchk&amp;rtnmod=".$rtnmod."&amp;rtnact=".$rtnact."&amp;no=".$no.$listVar);
						}
					}				
					//$coreClass -> msg_back("접근 권한이 없습니다. 로그인 후 이용하시기 바랍니다.");
				}
			}
		}

	}

	if($row['BRDATA_PRIVACY'] == "Y") {
		if($row['BRDATA_UID'] == S_mb_id) $_SESSION['modify'.$row['BRDATA_NO']] = 1;
		$_SESSION['view'.$row['BRDATA_GRP_NO']] = 1; 
	} 
	
	// 최근 게시물 아이콘
	$p_new			= isset($board_data['BOARD_NEW']) ? $board_data['BOARD_NEW'] : 3;
	$after24hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
	$new = "";
	if($after24hours > site_date) $new = "<img src='/bbs/img/board/icon_new.gif' alt='새글' style='vertical-align:middle'>";
	
	// 비밀글 아이콘
	$privacy = "";
	if($row['BRDATA_PRIVACY'] == "Y") $privacy="<img src='/bbs/img/board/icon_privacy.gif' alt='비밀글' style='vertical-align:middle'>";

	// 이메일 관련
	if($row['BRDATA_EMAIL'] != ""){
		$id		= "<a href=\"mailto:".$row['BRDATA_EMAIL']."\">".$row['BRDATA_UID']."</a>";
		$email	= "<a href=\"mailto:".$row['BRDATA_EMAIL']."\">".$row['BRDATA_EMAIL']."</a>";
	} else {
		$id		= $row['BRDATA_UID'];
		$email	= "";
	}

	// 썸네일 관련추가
	$view_img	= null;
	if(!empty($row['BRDATA_THUMBNAIL']) and $board_data['BOARD_TYPE'] != "board_imglist") {
		//$view_img .= "<img src=\"/upload/bbs/".$bid."/".$row['BRDATA_THUMBNAIL']."\" width=\"640\" alt=\"".$row['BRDATA_SUBJECT']."\"><br /><br />";
	}
	
	$fWhere	= "WHERE brdfile_did = '".$row['BRDATA_ID']."' AND brdfile_bid = '".$bid."'";
	$rsFile		= $coreClass -> selectQueryCount(tbl_board_file, $fWhere);
	if($rsFile > 0) {

		$rs = $coreClass -> selectQuery(tbl_board_file, $fWhere, "", "", "");
		$x = 0;
		while($fileRow = $coreClass -> selectFetchArray($rs)) {
		
			$file_arr	= explode(".", $fileRow['BRDFILE_SNAME']);
			$ext		= strtolower($file_arr[1]);
			$scy		= "no";
	
			if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png"){

				$img	= dir_public."/upload/bbs/".$bid."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
				if(!is_file($img)) $img = mb_convert_encoding($img ,"EUC-KR", "UTF-8");
				if(is_file($img)) {
					
					$size = getImagesize($img);
		
					if($size[0] > 660) {
						$wsize = 660;
						$scy   = "yes";
					}else{
						$wsize = $size[0];
						$scy   = "no";
					}
		
					$win_width = $size[0] + 20;
					$win_height = $size[1] + 20;
		
					$filename = "/upload/bbs/".$bid."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
					$nokey	= "";
					$nokey	= $coreClass -> crypt_md5($fileRow['BRDFILE_NO'], site_config_filekey);
					$bidkey	= "";
					$bidkey	= $coreClass -> crypt_md5($fileRow['BRDFILE_BID'], site_config_filekey);
					$didkey	= "";
					$didkey	= $coreClass -> crypt_md5($row['BRDATA_ID'], site_config_filekey);
					
					$view_img .=
					"<a class=\"aimg\" href=\"/base/php/view.image.php?no=".$nokey."&bid=".$bidkey."&amp;did=".$didkey."\" onclick=\"window.open(this.href,'limg','width=".$win_width.",height=".$win_height.",top=150,left=150,scrollbars=".$scy."'); return false\" target=\"_blank\" title=\"새창에서 열림\">
					<img src=\"".$filename."\" width=\"".$wsize."\" alt=\"".$row['BRDATA_SUBJECT']." [첨부 이미지".($x+1)."]\"
					></a><br /><br />";

					$view_img_arr[$x] = $filename;
					$x++;
				}
			}else if($ext == "wmv" || $ext == "avi" || $ext == "swf" || $ext == "mp4"){

				$imgsrc	= dir_public."/upload/bbs/".$bid."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
				$img	= mb_convert_encoding($imgsrc ,"EUC-KR", "UTF-8");
				

				if(is_file($img)) {

					$filename = "/upload/bbs/".$bid."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
					$view_img .="<object classid=\"clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95\" codebase=\"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715\" width=\"600\" height=\"450\">
					<param name=\"FileName\" value=\"".$filename."\">
					<param name=\"AutoStart\" value=\"true\">
					<param name=\"Volume\" value=\"0\">
					<embed src=\"".$filename."\" pluginspage=\"http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/\" width=\"600\" height=\"450\" autostart=\"true\" VOLUME=\"0\"></embed>
					</object><br /><br />";
				}
			}
		}
	}

	// 다음,이전 게시물/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	 if($board_data['BOARD_EXTEND'] == "Y") {
		 $stext = "b.";
	 }

	$where = "WHERE {$stext}brdata_bid = '".$bid."'";
	
	// 1:1 글보기 옵션
	if(S_mb_level > bbs_config_level && $board_data['BOARD_OTO'] == 'Y' && $brdmngCnt < 1) {
		$where .= " AND {$stext}brdata_uid = '".S_mb_id."' AND {$stext}brdata_uid != 'guest'";
	}
	
	// 삭제 글보기 옵션
	if(S_mb_level > site_config_level) {
		$where .= " AND {$stext}brdata_deleted = 'N'";
	}
	
	if(S_mb_level > site_config_level) {
		$where .= " AND {$stext}brdata_privacy = 'N'";
	}

	if($search && $kwd) {
		switch ($search){
			case 1 : $where .= " AND {$stext}brdata_subject like '%".$kwd."%'";break;
			case 2 : $where .= " AND (contains({$stext}brdata_content,'".$kwd."')  > 0)";break;
			//case 2 : $where .= " AND {$stext}brdata_content like '%".$kwd."%'";break;
			case 3 : $where .= " AND {$stext}brdata_name like '%".$kwd."%'";break;
			default : $where .= " AND {$search} like '%".$kwd."%'";break;
		}
	}

	// 카테고리를 사용할 경우
	if($board_data['BOARD_CATEGORY'] == "Y"){
		if($cate != ""){
			$where .= " AND {$stext}brdata_category = '".$cate."'";
		}
	}

	//게시글 노출 옵션 (본인 작성 글은 무조건 출력, 노출기간 미등록 출력)
	if($board_data['BOARD_LV_EXPOSURE'] != ""){
	$sexposure		= date("Y-m-d");
	$where .= " AND (({$stext}brdata_sexposure <= '".$sexposure."' AND {$stext}brdata_eexposure >= '".$sexposure."') OR ({$stext}brdata_sexposure <= '".$sexposure."' AND {$stext}brdata_eexposure IS NULL) OR ({$stext}brdata_eexposure >= '".$sexposure."' AND {$stext}brdata_sexposure IS NULL) OR ({$stext}brdata_sexposure IS NULL AND {$stext}brdata_eexposure IS NULL) OR ({$stext}BRDATA_UID = '".S_mb_id."'))";
	}

	if($board_data['BOARD_TYPE'] == "board_qna" and $code2 != "") {
		$where .= " AND e.BRDATA_EXT_09 = '".$code2."'";
	}

	if($board_data['BOARD_TYPE'] == "board_qna" and $code3 != "" and $code4 != "") {
		$where .= " AND (substr({$stext}brdata_regdate,0,10) <= '".$code4."' AND substr({$stext}brdata_regdate,0,10) >= '".$code3."')";
	}else if($board_data['BOARD_TYPE'] == "board_qna" and $code3 != "" and $code4 == ""){
		$where .= " AND substr({$stext}brdata_regdate,0,10) >= '".$code3."'";
	}else if($board_data['BOARD_TYPE'] == "board_qna" and $code3 == "" and $code4 != ""){
		$where .= " AND substr({$stext}brdata_regdate,0,10) <= '".$code4."'";
	}



	if($board_data['BOARD_EXTEND'] == "Y") {
		$OLD_TBL = tbl_board_data." b left join ".tbl_board_data_extend." e on b.brdata_id = e.brdata_id";
		$filds = "b.brdata_no, b.brdata_id, b.brdata_category, b.brdata_uid, b.brdata_name, b.brdata_subject, b.brdata_notice, b.brdata_privacy, b.brdata_emailis, b.brdata_smsis, b.brdata_deleted, b.brdata_hit, b.brdata_sdate, b.brdata_edate, b.brdata_regip, b.brdata_regdate ";

		$where2	= $where." AND b.brdata_no > '".$no."' AND b.brdata_seq_no = '0' AND b.brdata_notice='N'";
		$order2	= "ORDER BY b.brdata_grp_no asc";
		$nextRs	= $coreClass -> selectQueryCount($OLD_TBL, $where2);
		
	}else{
		$seq_no = '';
		//해당 grp_no 개수만큼은 이동하고, 후에 다른거로 가도록...
		$grp_no_ck = $boardClass->grp_no_ck($row['BRDATA_GRP_NO']);
		if(($grp_no_ck-1)==$row['BRDATA_SEQ_NO']){
			$seq_no = ' AND brdata_grp_no >= "'.$row['BRDATA_GRP_NO'].'"';
		}else{
			$seq_no = 'AND brdata_seq_no <= "'.$row['BRDATA_SEQ_NO'].'"'; 
		}
		

		//$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no > '".$no."' AND brdata_seq_no = '0' AND brdata_notice='N' AND brdata_privacy='N' AND brdata_deleted = 'N'";
		$where	= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no >= '".$row['BRDATA_GRP_NO']."' AND brdata_deleted = 'N' AND brdata_no != '".$no."'".$seq_no;
		$order	= "ORDER BY brdata_grp_no ASC, brdata_seq_no DESC, brdata_regdate ASC";
		$nextRs	= $coreClass -> selectQueryCount(tbl_board_data, $where);
	}

	$nextnoData = "";
	if(!$nextRs) {
		$nextBrd = "게시물이 없습니다";
		$nextLink = "#none";
		$nextTitle = $bd_lang_none;
		$nextnoData = "no_data";
	} else {
		
		if($board_data['BOARD_EXTEND'] == "Y") {
			$nextrs = $coreClass -> selectQueryFilds($filds, $OLD_TBL, $where2, $order2, 0, 1);
			$next = $coreClass -> selectFetchArray($nextrs);
		}else{
			$next = $coreClass -> selectQueryArray(tbl_board_data, $where, $order, 0, 1);
		}

		$nextBrd = '<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$next['BRDATA_NO'].$viewVar.'">'.$next['BRDATA_SUBJECT'].'</a>';
		$nextLink = 'sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$next['BRDATA_NO'].$viewVar;
		$nextTitle = $next['BRDATA_SUBJECT'];
	}


	if($board_data['BOARD_EXTEND'] == "Y") {
		$OLD_TBL = tbl_board_data." b left join ".tbl_board_data_extend." e on b.brdata_id = e.brdata_id";
		$filds = "b.brdata_no, b.brdata_id, b.brdata_category, b.brdata_uid, b.brdata_name, b.brdata_subject, b.brdata_notice, b.brdata_privacy, b.brdata_emailis, b.brdata_smsis, b.brdata_deleted, b.brdata_hit, b.brdata_sdate, b.brdata_edate, b.brdata_regip, b.brdata_regdate ";

		$where2	= $where." AND b.brdata_no < '".$no."' AND b.brdata_seq_no = '0' AND b.brdata_notice='N'";
		$order2	= "ORDER BY b.brdata_grp_no DESC";
		$prevRs	= $coreClass -> selectQueryCount($OLD_TBL, $where2);

		
	}else{
		$seq_no = '';
		//해당 grp_no 개수만큼은 이동하고, 후에 다른거로 가도록...
		$grp_no_ck = $boardClass->grp_no_ck($row['BRDATA_GRP_NO']);
		if(($grp_no_ck-1)==$row['BRDATA_SEQ_NO']){
			$seq_no = ' AND brdata_grp_no < "'.$row['BRDATA_GRP_NO'].'"';
		}else{
			$seq_no = 'AND brdata_seq_no > "'.$row['BRDATA_SEQ_NO'].'"'; 
		}
		//$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no < '".$no."' AND brdata_seq_no = '0' AND brdata_notice='N' AND brdata_privacy='N' AND brdata_deleted = 'N'";
		$where	= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no <= '".$row['BRDATA_GRP_NO']."' AND brdata_deleted = 'N' AND brdata_no != '".$no."'".$seq_no;
		$order	= "ORDER BY brdata_grp_no DESC, brdata_seq_no ASC, brdata_regdate DESC";
		$prevRs = $coreClass -> selectQueryCount(tbl_board_data, $where);
	}


	$prevnoData = "";

	if(!$prevRs) {
		$prevBrd = "게시물이 없습니다";
		$prevLink = "#none";
		$prevTitle = $bd_lang_none;
		$prevnoData = "no_data";
	} else {

		if($board_data['BOARD_EXTEND'] == "Y") {
			$prevrs = $coreClass -> selectQueryFilds($filds, $OLD_TBL, $where2, $order2, 0, 1);
			$prev = $coreClass -> selectFetchArray($prevrs);
		}else{
			$prev = $coreClass -> selectQueryArray(tbl_board_data, $where, $order, 0, 1);
		}

	
		$prevBrd = '<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$prev['BRDATA_NO'].$viewVar.'">'.$prev['BRDATA_SUBJECT'].'</a>';
		$prevLink = 'sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$prev['BRDATA_NO'].$viewVar;
		$prevTitle = $prev['BRDATA_SUBJECT'];
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	//확장필드 출력
	if($board_data['BOARD_EXTEND'] == "Y"){
		$Whereex = "where BRDATA_ID ='".$row['BRDATA_ID']."' and BRDATA_BID = '".$row['BRDATA_BID']."'";
		$rsex	= $coreClass -> selectQuery(tbl_board_data_extend, $Whereex, "", "", "");
		$rscnt	= $coreClass -> selectQueryCount(tbl_board_data_extend, $Whereex);
		if($rscnt > 0) $rowext = $coreClass -> selectFetchArray($rsex);
	}

	////카테고리 정보3
	if($board_data['BOARD_CATEGORY']=="Y"){

		/*
		$cWhere	= "WHERE BRDCAT_BID = '".$bid."' and BRDCAT_ID = '".$row['BRDATA_CATEGORY']."'";
		$cOrder	= "ORDER BY BRDCAT_NO";
		$cateRs	= $coreClass -> selectQuery(tbl_board_category, $cWhere, $cOrder, "", "");
		$row_c = $coreClass -> selectFetchArray($cateRs);
		$category_name = $row_c['BRDCAT_NAME'];
		*/
		if(!empty($cate)){
			$category = "";
		} else {
			$category = " AND brdata_category = '$cate' ";
		}
		
		$cWhere	= "WHERE BRDCAT_BID = '".$bid."'";
		$cOrder	= "ORDER BY BRDCAT_NO";
		$cateRs	= $coreClass -> selectQuery(tbl_board_category, $cWhere, $cOrder, "", "");
		$cateRow= $coreClass -> selectFetchArray($cateRs);

	}

?>

<script type="text/javascript">

$(window).load(function(){
	if($(".sv_table td.con").length > 0){ 
		$(".sv_table td.con img").each(function(){ 
			if($(".board_w").width() < $(this).outerWidth(true)){ 
				$(this).css({"width":"90%"});
			}
		});			
	}
});

$(window).resize(function(){
	if($(".sv_table td.con").length > 0){ 
		$(".sv_table td.con img").each(function(){ 
			if($(".board_w").width() < $(this).outerWidth(true)){ 
				$(this).css({"width":"90%"});
			}
		});			
	}
});

</script>

