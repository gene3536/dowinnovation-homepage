<?php
	// 검색을 위한 where 절
	switch($board_data['BOARD_TYPE']) {
		case "board" :
			$where = "WHERE brdata_bid = '".$bid."'";
			break;
		case "board_manage" :
			$where = "WHERE brdata_bid <> '0'";
			break;
		default :
			$where = "WHERE brdata_bid = '".$bid."'";
			break;	
	}
	
	// 1:1 글보기 옵션
	/*if(S_mb_level > bbs_config_level && $board_data['BOARD_OTO'] == 'Y' && $brdmngCnt < 1) {
		$where .= " AND brdata_uid = '".S_mb_id."' AND brdata_uid != 'guest'";
	}*/

	if(S_mb_level > bbs_config_level && $board_data['BOARD_OTO'] == 'Y') {
		$where .= " AND brdata_uid = '".S_mb_id."' AND brdata_uid != 'guest' AND brdata_level_no = 0";
	}
	
	// 삭제 글보기 옵션
	if(S_mb_level > site_config_level) {
		$where .= " AND brdata_deleted = 'N'";
	} else {
		$where .= " AND brdata_deleted <> '0'";
	}
	
	// 유형별 옵션 
	if(empty($code1)) {
		$where .= " AND brdata_type <> '0'";
	} else {
		$where .= " AND brdata_type = '".$code1."'";
	}
	
	// 사이트별 옵션
	if(empty($scode)) {
		$where .= " AND brdata_scode <> '0'";
	} else {
		$where .= " AND (brdata_scode = '".$scode."' OR brdata_scode = '00000000')";
	}
	
	// 검색 옵션 
	if($search && $kwd) {
		switch ($search){
			case 1 : $where .= " AND brdata_subject like '%".$kwd."%'";break;
			case 2 : $where .= " AND brdata_content like '%".$kwd."%'";break;
			case 3 : $where .= " AND brdata_name like '%".$kwd."%'";break;
			case 4 : $where .= " AND brdata_fld1 like '%".$kwd."%'";break;
			case 5 : $where .= " AND brdata_fld2 like '%".$kwd."%'";break;
			case 9 : $where .= " AND (brdata_subject like '%".$kwd."%' OR brdata_content like '%".$kwd."%' OR brdata_name like '%".$kwd."%')";break;
			default : $where .= " AND brdata_subject like '%".$kwd."%'";break;
		}
	}
	
	// 카테고리 옵션 
	$category		= NULL;
	$cateRs		= NULL;
	if($board_data['BOARD_CATEGORY'] == "Y"){
		if(!$cate){
			$category = "";
		}else{
			$category = " AND brdata_category = '".$cate."'";
		}
		
		$cWhere	= "WHERE brdcat_bid = '".$bid."'";
		$cOrder	= "ORDER BY brdcat_seq asc, brdcat_no ASC";
		$cateRs	= $coreClass -> selectQuery(tbl_board_category, $cWhere, $cOrder, "", "");
		
		$cateList .= '<select name="cate" class="selline" title="카테고리선택" style="width:120px">';
		$cateList .= '<option value="">분류선택</option>';
		$lstCate   = array(); $i = 0;
		while($row_c = $coreClass -> selectFetchArray($cateRs)) {
			if($cate == $row_c['BRDCAT_ID']) {
				$sel = ' selected="selected"';
			} else {
				$sel = '';
			}
			$cateList .= '<option value="'.$row_c['BRDCAT_ID'].'"'.$sel.'>'.$row_c['BRDCAT_NAME'].'</option>';
			$lstCate[$i]['ID'] = $row_c['BRDCAT_ID'];
			$lstCate[$i]['NAME'] = $row_c['BRDCAT_NAME'];
			$i++;
		}
		$cateList .= '</select>';
	}

	//게시글 노출 옵션 (본인 작성 글은 무조건 출력, 노출기간 미등록 출력)
	if(!empty($board_data['BOARD_LV_EXPOSURE'])){
		$sexposure = date("Y-m-d");
		$where .= " AND ((brdata_sexposure <= '".$sexposure."' AND brdata_eexposure >= '".$sexposure."') OR (brdata_sexposure <= '".$sexposure."' AND brdata_eexposure IS NULL) OR (brdata_eexposure >= '".$sexposure."' AND brdata_sexposure IS NULL) OR (brdata_sexposure IS NULL AND brdata_eexposure IS NULL) OR (BRDATA_UID = '".S_mb_id."'))";
	}

	/////////문화공간 where
	if($pageInfo['MENU_TBL'] == "cul1"){
		$where .= " and BRDATA_ETC2 = '상당산성권'";
	}else if($pageInfo['MENU_TBL'] == "cul2"){
		$where .= " and BRDATA_ETC2 = '초정약수권'";
	}else if($pageInfo['MENU_TBL'] == "cul3"){
		$where .= " and BRDATA_ETC2 = '증평 남하/율리권'";
	}
	
	if($pageInfo['MENU_TBL'] == "exp1"){
		$where .= " and BRDATA_ETC1 = '먹거리'";
	}else if($pageInfo['MENU_TBL'] == "exp2"){
		$where .= " and BRDATA_ETC1 = '숙박'";
	}else if($pageInfo['MENU_TBL'] == "exp3"){
		$where .= " and BRDATA_ETC1 = '체험'";
	}

	// 페이징
	$pWhere			= $where.$category;
	$page				= $page ? $page : 1;
	$numofrecord	= $board_data['BOARD_RECORD'];

	$paging_result	= $coreClass -> selectQueryCount(tbl_board_data, $pWhere);
	if($board_data['BOARD_TYPE'] == "board_imglist"){
		$paging			= $coreClass -> pagingCore2($paging_result, $numofrecord, $page);
	}else{
		$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	}
		
	// 공지목록 쿼리
	$nWhere			= $where.$category." AND brdata_notice = 'Y' AND brdata_deleted = 'N'";
	$nOrder			= "ORDER BY brdata_no DESC";
	$noticeRs		= $coreClass -> selectQuery(tbl_board_data, $nWhere, $nOrder, 0, 10);

		
	// 일반목록 쿼리
	if($board_data['BOARD_TYPE'] == "board_imglist"){
		$pOrder = "ORDER BY BRDATA_FLD3 desc, brdata_grp_no DESC, brdata_seq_no ASC, brdata_regdate DESC";
	}else{
		$pOrder = "ORDER BY brdata_grp_no DESC, brdata_seq_no ASC, brdata_regdate DESC";
	}
	$boardRs = $coreClass -> selectQuery(tbl_board_data, $pWhere, $pOrder, $paging["startofrecord"], $paging["numofrecord"]);
	

	//카테고리 사용유무 및 설정
	if(isset($board_data['BOARD_CATEGORY']) && $board_data['BOARD_CATEGORY'] == "Y") {
		$category_is = "Y";
		$colspanc = "7";
	} else {
		$category_is = "N";
		$colspanc = "6";
	}



?>
