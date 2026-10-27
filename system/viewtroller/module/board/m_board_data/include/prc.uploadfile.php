<?php
	$existThumb = 0;
	for($i = 1; $i <= $board_data['BOARD_UPLOADCOUNT']; $i++) {
		if(isset(${"uploadFile".$i}) && ${"uploadFile".$i."_name"}){
			
			${"sfilename".$i}	= $coreClass -> uploadFile(${"uploadFile".$i}, ${"uploadFile".$i."_name"}, ${"uploadFile".$i."_size"}, $savePath, $i, $board_data['BOARD_UPLOADSIZE'], $board_data['BOARD_THUM_WID'], $board_data['BOARD_THUM_HEI']);
			${"filename".$i}	= ${"uploadFile".$i."_name"};
			${"filesize".$i}		= ${"uploadFile".$i."_size"};
		
			$maxNo	= $coreClass -> selectQueryMax($tbl3, "brdfile_no");
			$maxNo++;
					
			$item		= "brdfile_no, brdfile_did, brdfile_bid, brdfile_sname, brdfile_name, brdfile_size, brdfile_year, brdfile_hit, brdfile_regip, brdfile_regdate";
			$value		= "'".$maxNo."', '".$id."', '".$bid."', '".${"sfilename".$i}."', '".${"filename".$i}."', '".${"filesize".$i}."', '".site_year."', 0, '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl3, $item, $value);
			
			//첫번째 이미지 첨부 파일 썸네일 저장 
			if($existThumb == 0 && $coreClass->file_type(${"sfilename".$i})=="image"){
				$set		= " SET brdata_thumbnail = '".${"sfilename".$i}."', brdata_thumbyear = '".site_year."'";
				$where      = " WHERE brdata_no = '".$id."'";
				$coreClass -> updateQuery($tbl2, $set, $where);	
				$existThumb ++;
			}			
		}
	}
?>