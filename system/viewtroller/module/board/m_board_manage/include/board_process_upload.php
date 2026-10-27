<?php
	$save_path	= dir_public."/upload/bbs/".$bid."/";
	$existThumb = 0;

	for($i = 1; $i <= 2; $i++) {
		if(isset(${"uploadFile".$i}) && ${"uploadFile".$i."_name"}){
			${"sfilename".$i}	= $coreClass -> uploadFile(${"uploadFile".$i}, ${"uploadFile".$i."_name"}, ${"uploadFile".$i."_size"}, $save_path, $i, 10, 180, 120);
			${"filename".$i}	= ${"uploadFile".$i."_name"};
			${"filesize".$i}		= ${"uploadFile".$i."_size"};
		
			$maxNo	= $coreClass -> selectQueryMax(tbl_board_file, "brdfile_no");
			$maxNo++;

			$item		= "brdfile_no, brdfile_did, brdfile_bid, brdfile_sname, brdfile_name, brdfile_size, brdfile_year, brdfile_hit, brdfile_regip, brdfile_regdate";
			$value		= "'".$maxNo."', '".$id."', '".$bid."', '".${"sfilename".$i}."', '".${"filename".$i}."', '".${"filesize".$i}."', '".date("Y")."', 0, '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_board_file, $item, $value);
			
			//첫번째 이미지 첨부 파일 썸네일 저장 
			if($existThumb == 0 && $coreClass->file_type(${"sfilename".$i})=="image"){
				$set		= " SET brdata_thumbnail = '".${"sfilename".$i}."', brdata_thumbyear = '".site_year."'";
				$where      = " WHERE brdata_no = '".$id."'";
				$coreClass -> updateQuery($tbl1, $set, $where);	
				$existThumb ++;
			}			
		}
	}
?>