<?php

	// 게시글 쿼리
	$where		= "WHERE brdata_no = '".$no."'";
	$coreClass -> selectQueryCountChk(tbl_board_data, $where);
	$row			= $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", "");
	$bid			= $row['BRDATA_BID'];

	$bwhere		= "WHERE board_id = '".$bid."'";
	$coreClass -> selectQueryCountChk(tbl_board, $bwhere);
	$brow			= $coreClass -> selectQueryArray(tbl_board, $bwhere, "", "", "");

	// 게시판 관리자 체크
	if(S_mb_level > site_config_level && S_mb_level > $brow['BOARD_LV_MANAGE']) {
		$where		= "WHERE brdmng_bid = '".$bid."' AND brdmng_uid = '".S_mb_id."'";
		$brdmngCnt	= $coreClass -> selectQueryCount(tbl_board_manage, $where);
		
		if($brdmngCnt < 1) $coreClass -> msg_back("보기 권한이 없습니다.");
	}

	// 카테고리를 사용할 경우
	if($brow['BOARD_CATEGORY'] == "Y"){
		$cwhere	= "WHERE brdcat_bid = '".$bid."' AND brdcat_id = '".$row['BRDATA_CATEGORY']."'";
		$cateRow	= $coreClass -> selectQueryArray(tbl_board_category, $cwhere, "", "", "");
	}

	// 썸네일 관련추가
	$view_img	= null;
	if(!empty($row['BRDATA_THUMBNAIL'])) {
		$view_img .= "<img src=\"/upload/bbs/".$bid."/".$row['BRDATA_THUMBNAIL']."\" width=\"640\" alt=\"".$row['BRDATA_SUBJECT']."\"><br /><br />";
	}
	
	// 다음,이전 게시물
	$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no > '".$no."' AND brdata_seq_no = '0' AND brdata_notice='N' AND brdata_privacy='N'";
	$nextCnt	= $coreClass -> selectQueryCount(tbl_board_data, $where);

	if($nextCnt < 1) {
		$nextBrd	= "게시물이 없습니다";
	} else {
		$order	= "ORDER BY brdata_grp_no ASC";
		$next		= $coreClass -> selectQueryArray(tbl_board_data, $where, $order, 0, 1);
		$nextBrd	= "<a href=\"sub.php?menukey=".$menukey."&mod=view&no=".$next['BRDATA_NO'].$listVar."\">".$next['BRDATA_SUBJECT']."</a>";
	}

	$where	= "WHERE brdata_bid = '".$bid."' AND brdata_no < '".$no."' AND brdata_seq_no = '0' AND brdata_notice='N' AND brdata_privacy='N'";
	$prevCnt	= $coreClass -> selectQueryCount(tbl_board_data, $where);

	if($prevCnt < 1) {
		$prevBrd	= "게시물이 없습니다";
	} else {
		$order	= "ORDER BY brdata_grp_no DESC";
		$prev		= $coreClass -> selectQueryArray(tbl_board_data, $where, $order, 0, 1);
		$prevBrd	= "<a href=\"sub.php?menukey=".$menukey."&mod=view&no=".$prev['BRDATA_NO'].$listVar."\">".$prev['BRDATA_SUBJECT']."</a>";
	}

	// 민원/답변글
	if($btype == "board_minwon") {
		$rwhere	= "WHERE brdrep_bid = '".$row['BRDATA_BID']."' AND brdrep_did = '".$row['BRDATA_ID']."'";
		$rrow		= $coreClass -> selectQueryArray($tbl5, $rwhere, "", "", "");	
	}
	
	//확장필드 출력
	if($brow['BOARD_EXTEND'] == "Y"){
		$Whereex = "where BRDATA_ID ='".$row['BRDATA_ID']."' and BRDATA_BID = '".$row['BRDATA_BID']."'";
		$rsex		= $coreClass -> selectQuery(tbl_board_data_extend, $Whereex, "", "", "");
		$rowext = $coreClass -> selectFetchArray($rsex);
	}


	require_once "bbs.lib.default.php";	
?>