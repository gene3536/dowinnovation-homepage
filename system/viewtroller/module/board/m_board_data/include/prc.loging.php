<?php
	$item			= "brdlog_bid, brdlog_did, brdlog_type, brdlog_subject, brdlog_content, brdlog_uid, brdlog_name, brdlog_regip, brdlog_regdate";
	$value			= "'".$bid."', '".$did."', '".$type."', '".$bsubject."', '".$bcontent."', '".S_mb_id."', '".S_mb_name."', '".site_client_ip."', '".site_regdate."'";
	$coreClass -> insertQuery($tbl4, $item, $value);
?>