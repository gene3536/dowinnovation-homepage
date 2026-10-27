<?php

	$where = "where 1=1";
	if(S_mb_level <= site_config_level) {
		$tbl_join = $tbl1." b left join ".$tbl3." a on b.brdata_bid = a.board_id ";

	} else {
		
		$tbl_join = $tbl1." b left join ".$tbl3." a on b.brdata_bid = a.board_id ";

		if($btype == "board") {
			// 일반게시글 - 운영자
			$tbl_join .= "LEFT JOIN ".tbl_board_manage." m ON m.brdmng_bid = b.brdata_bid and m.brdmng_uid='".S_mb_id."'";
			//$where = " WHERE b.brdata_type = '".$btype."'";
			$where .= " AND ((m.brdmng_uid = '".S_mb_id."' AND a.board_lv_manage < '".S_mb_level."')";
			$where .= " OR (a.board_lv_manage >= '".S_mb_level."'))";
		}  else if($btype == "board_gallery") {
			// 갤러리게시글 - 운영자
			$tbl_join .= "LEFT JOIN ".tbl_board_manage." m ON m.brdmng_bid = b.brdata_bid and m.brdmng_uid='".S_mb_id."' LEFT JOIN ".$tbl5." ON brdrep_bid = brdata_bid AND brdrep_did = brdata_id";
			//$where = " WHERE b.brdata_type = '".$btype."'";
			$where .= " AND ((m.brdmng_uid = '".S_mb_id."' AND a.board_lv_manage < '".S_mb_level."')";
			$where .= " OR (a.board_lv_manage >= '".S_mb_level."'))";
		}		
	}

	if(!empty($code3)) $where .= " AND b.brdata_type = '".$code3."'";
	if(!empty($code4)) $where .= " AND b.brdata_bid = '".$code4."'";
	//if($search == 1 && !empty($kwd)) $where .= " AND b.brdata_subject LIKE '%".$kwd."%'";
	if($search == 1 && !empty($kwd)) $where .= " AND contains(b.brdata_subject, '".$kwd."') >0";
	if($search == 2 && !empty($kwd)) $where .= " AND a.BOARD_NAME LIKE '%".$kwd."%'";
	if($search == 3 && !empty($kwd)) $where .= " AND b.brdata_name LIKE '%".$kwd."%'";
	
	if(site_acc_lvl <= S_mb_level){
		$scode = S_mb_scode;
	}

	if(!empty($scode)) {
		$bwhere .= " AND board_scode = '".$scode."'";
		$where .= " AND a.board_scode = '".$scode."'";
	}

	$page				= $page ? $page : 1;
	$numofrecord	= 20;// echo $tbl_join." ".$where;
	$paging_result	= $coreClass -> selectQueryCount($tbl_join, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);

	$order			= "ORDER BY b.brdata_grp_no desc, b.brdata_seq_no asc, b.brdata_regdate desc";
	$snum			= $paging['startofrecord']; 
	$rnum				= $paging['numofrecord'];	

	//$rs					= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);
	$rs					= $coreClass -> selectQuery($tbl_join, $where, $order, $snum, $rnum);
?>