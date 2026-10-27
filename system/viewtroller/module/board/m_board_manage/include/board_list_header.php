<?php
	if(S_mb_level <= site_config_level) {
		$bwhere	= "WHERE 1=1";
	} else {
		if($btype == "board") {
			// 일반게시글 - 운영자
			$where = "LEFT JOIN ".tbl_board_manage." ON brdmng_bid = brdata_bid LEFT JOIN ".tbl_board." ON board_id = brdata_bid";
			$where .= " WHERE brdata_type = '".$btype."'";
			$where .= " AND ((brdmng_uid = '".S_mb_id."' AND board_lv_manage < '".S_mb_level."')";
			$where .= " OR (board_lv_manage >= '".S_mb_level."'))";
		}else if($btype == "board_gallery") {
			// 갤러리게시글 - 운영자
			$where = "LEFT JOIN ".tbl_board_manage." ON brdmng_bid = brdata_bid LEFT JOIN ".tbl_board." ON board_id = brdata_bid LEFT JOIN ".$tbl5." ON brdrep_bid = brdata_bid AND brdrep_did = brdata_id";
			$where .= " WHERE brdata_type = '".$btype."'";
			$where .= " AND ((brdmng_uid = '".S_mb_id."' AND board_lv_manage < '".S_mb_level."')";
			$where .= " OR (board_lv_manage >= '".S_mb_level."'))";
		}		
		$bwhere	= "LEFT JOIN ".tbl_board_manage." ON brdmng_bid = board_id";
		$bwhere .= " WHERE board_type = '".$btype."'";
		$bwhere .= " AND ((brdmng_uid = '".S_mb_id."' AND board_lv_manage < '".S_mb_level."')";
		$bwhere .= " OR (board_lv_manage >= '".S_mb_level."'))";
	}

	if(!empty($code1)) $where .= " AND brdata_bid = '".$code1."'";
	if($search == 1 && !empty($kwd)) $where .= " AND brdata_subject LIKE '%".$kwd."%'";
	if($search == 3 && !empty($kwd)) $where .= " AND brdata_name LIKE '%".$kwd."%'";
	
	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);

	$order			= "ORDER BY brdata_grp_no desc, brdata_seq_no asc, brdata_regdate desc";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	

	$rs					= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);

	if(!empty($scode)) {
		$bwhere .= " AND board_scode = '".$scode."'";
	}

	$border			= "ORDER BY board_name ASC";
	$brs				= $coreClass -> selectQuery($tbl3, $bwhere, $border, "", "");
?>