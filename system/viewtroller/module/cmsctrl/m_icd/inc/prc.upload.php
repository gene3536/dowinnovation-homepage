<?php
	for($i = 1; $i <= 2; $i++) {
		if(isset(${"uploadFile".$i}) && ${"uploadFile".$i."_name"}){
			${"sfilename".$i}	= $coreClass -> uploadFile(${"uploadFile".$i}, ${"uploadFile".$i."_name"}, ${"uploadFile".$i."_size"}, $save_path, $i, 100, 180, 120);
			${"filename".$i}	= ${"uploadFile".$i."_name"};
			${"filesize".$i}		= ${"uploadFile".$i."_size"};
		
			$maxNo	= $coreClass -> selectQueryMax($tbl3, "icd_no");
			$maxNo++;
					
			$item		= "icd_no, icd_did, icd_pid, icd_sname, icd_name, icd_size, icd_year, icd_hit, icd_regip, icd_regdate";
			$value		= "'".$maxNo."', '".$id."', '".$pid."', '".${"sfilename".$i}."', '".${"filename".$i}."', '".${"filesize".$i}."', '".site_year."', 0, '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl3, $item, $value);
		}
	}
?>