<?php
	//$row['BRDATA_HP'] 원본글에 등록된 핸드폰 번호
	$sms_hp_1 = $row['BRDATA_HP'];
	$sms_hp_t = explode("-",$sms_hp_1);
	$sms_hp  = $sms_hp_t[0].$sms_hp_t[1].$sms_hp_t[2];

	$sms_msg = "[".site_config_title."]".$board_data['BOARD_NAME']."에 올리신 글에 답변이 등록되었습니다.";

	//$sms_msg = mb_convert_encoding($sms_msg, "euc-kr","utf-8");
	//$dbsms = $coreClass -> getConnection_sms();

	$tran_status = 1;
	$tran_callback = "0432902527";

	//$sms_insert_sql = "insert into emma_db.em_tran ( tran_phone, tran_callback, tran_status, tran_date, tran_msg) values ( ";
	//$sms_insert_sql .= "'".$sms_hp."', '".$tran_callback."', '".$tran_status."', NOW(), '".$sms_msg."' ) ";
	//$dbsms->query($sms_insert_sql);
	$item  = "TRAN_PR, TRAN_STATUS, TRAN_PHONE, TRAN_CALLBACK, TRAN_DATE, TRAN_MSG, TRAN_TYPE";
	$value = "cbe_sms.MSG_DATA_SEQ.nextval, '".$tran_status."', '".$sms_hp."', '".$tran_callback."', sysdate, '".$sms_msg."', 4";
	$coreClass -> insertQuery(tbl_sms_em_tran, $item, $value);


?>