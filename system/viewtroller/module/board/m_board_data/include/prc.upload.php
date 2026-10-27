<?php
	for($i = 1; $i <= $board_data['BOARD_UPLOADCOUNT']; $i++) {
		if(isset(${"uploadFile".$i}) && ${"uploadFile".$i."_name"}){
			${"sfilename".$i}	= $coreClass -> uploadFile(${"uploadFile".$i}, ${"uploadFile".$i."_name"}, ${"uploadFile".$i."_size"}, $savePath, $i, $board_data['BOARD_UPLOADSIZE'], 180, 120);
			${"filename".$i}	= ${"uploadFile".$i."_name"};
			${"filesize".$i}		= ${"uploadFile".$i."_size"};
		
			$maxNo	= $coreClass -> selectQueryMax($tbl3, "brdfile_no");
			$maxNo++;
					
			$item		= "brdfile_no, brdfile_did, brdfile_bid, brdfile_sname, brdfile_name, brdfile_size, brdfile_year, brdfile_hit, brdfile_regip, brdfile_regdate";
			$value		= "'".$maxNo."', '".$id."', '".$bid."', '".${"sfilename".$i}."', '".${"filename".$i}."', '".${"filesize".$i}."', '".site_year."', 0, '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl3, $item, $value);
		}
	}
?>