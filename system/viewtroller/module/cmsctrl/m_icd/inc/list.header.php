<?php

	$where = "WHERE icd_pid = '".$pid."'";
	if(!empty($search) && $search == 1) {
		$where .= " AND icd_title LIKE '%".$kwd."%'";
	}
	if(!empty($scode)) {
		$where .= " AND icd_scode = '".$scode."'";
	}
	
	$page			= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY icd_regdate DESC";
	$snum			= $paging['startofrecord'];
	$rnum			= $paging['numofrecord'];
	$rs				= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);
?>
