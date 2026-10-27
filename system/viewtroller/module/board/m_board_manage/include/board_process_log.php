<?php
	$maxNolog	= $coreClass -> selectQueryMax(tbl_board_log, "brdlog_no");
	$maxNolog++;

	$item			= "brdlog_no, brdlog_bid, brdlog_did, brdlog_type, brdlog_subject, brdlog_uid, brdlog_name, brdlog_regip, brdlog_regdate";
	$value			= "'".$maxNolog."', '".$bid."', '".$did."', '".$type."', '".$bsubject."', '".S_mb_id."', '".S_mb_name."', '".site_client_ip."', '".site_regdate."'";
	$coreClass -> insertQuery(tbl_board_log, $item, $value);
?>