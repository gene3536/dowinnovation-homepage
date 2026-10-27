<?php
	if(S_mb_id != $row['BRDATA_UID'] || S_mb_level == site_config_glevel) {
		$set		= "SET brdata_hit = brdata_hit + 1";
		$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_no = '".$no."'";
		$coreClass -> updateQuery($tbl2, $set, $where);
		$coreClass -> commit();
	}
?>