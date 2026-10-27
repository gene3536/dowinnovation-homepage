<?php
$rssms = $coreClass -> selectQuery(tbl_board_manage_sms, $wheres, "", "", "");
while($rowsms = $coreClass -> selectFetchArray($rssms)) {
	//$rowsms['BRDMNGS_NAME'] //이름 
	if($rowsms['BRDMNGS_UID'] != ""){
		$where2	= "where MB_UID = '".$rowsms['BRDMNGS_UID']."'";
		$rs2			= $coreClass -> selectQuery(tbl_member, $where2, "", "", "");
		$rowm = $coreClass -> selectFetchArray($rs2);
		$sms_hp = $coreClass -> decrypt_md5($rowm['MB_TEL'], site_config_mbkey);
	}else{
		$sms_hp = $coreClass -> decrypt_md5($rowsms['BRDMNGS_HP'], site_config_mbkey);
	}


	$sms_msg = "[".site_config_title."]".$board_row['BOARD_NAME']."에 신규글이 등록되었습니다.";

	//$sms_msg = mb_convert_encoding($sms_msg, "euc-kr","utf-8");
	//$dbsms = $coreClass -> getConnection_sms();

	$tran_status = 1;
	$tran_callback = "0432902527";

	//$sms_insert_sql = "insert into emma_db.em_tran ( tran_phone, tran_callback, tran_status, tran_date, tran_msg) values ( ";
	//$sms_insert_sql .= "'".$sms_hp."', '".$tran_callback."', '".$tran_status."', NOW(), '".$sms_msg."' ) ";
	//$dbsms->query($sms_insert_sql);

	$item  = "TRAN_PR, TRAN_STATUS, TRAN_PHONE, TRAN_CALLBACK, TRAN_DATE, TRAN_MSG, TRAN_TYPE";
	$value = "cbe_sms.MSG_DATA_SEQ.nextval, '".$tran_status."', '".$sms_hp."', '".$tran_callback."', sysdate, '".$sms_msg."', '4'";
	//echo $query	= "INSERT INTO ".tbl_sms_em_tran." (".$item.") VALUES(".$value.")";
	$coreClass -> insertQuery(tbl_sms_em_tran, $item, $value);

}
?>