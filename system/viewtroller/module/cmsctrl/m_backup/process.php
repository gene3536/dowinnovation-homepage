<?php
	 
	switch ($act) {
		case "delete"	:
			$where	= "WHERE bak_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);	
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
			if(!empty($row['BAK_FILENAME']) && is_file($save_path.$row['BAK_FILENAME'])) {
				@unlink($save_path.$row['BAK_FILENAME']);		
			}	
			$coreClass -> deleteQuery($tbl1, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list");
			break;
		
		case "dbak" :
			$where	= "WHERE bak_type = '2' AND bak_year = '".date("Y")."' AND bak_month = '".date("m")."' AND bak_day = '".date("d")."'";
			$rs			= $coreClass -> selectQueryCount($tbl1, $where, "", "", "");
			
			if($rs > 2) {
				$coreClass -> msg_back("금일엔 더이상 DB를 백업하실 수 없습니다.");
			} else {
				$filename	= date("Ymd")."_".mktime().".sql";
				$url		= $save_path."/".$filename;
				@exec("mysqldump -u".$coreClass -> DB_User." -p".$coreClass -> DB_PassWd." --default-character-set=utf8  ".$coreClass -> DB_Name." > ".$url);
				
				$filesize	= filesize($url);			
				$item		= "bak_type, bak_regip, bak_regdate, bak_year, bak_month, bak_day, bak_filename, bak_filesize";
				$value		= "'2', '".site_client_ip."', '".site_regdate."', '".date("Y")."', '".date("m")."', '".date("d")."', '".$filename."', '".$filesize."'";
				$coreClass -> insertQuery($tbl1, $item, $value);
			}
			
			$coreClass -> commit();			
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list");
			break;
		case "wbak" :
				$where	= "WHERE bak_type = '1' AND bak_year = '".date("Y")."' AND bak_month = '".date("m")."' AND bak_day = '".date("d")."'";
				$rs			= $coreClass -> selectQueryCount($tbl1, $where, "", "", "");
					
				if($rs > 2) {
					$coreClass -> msg_back("금일엔 더이상 웹소스를 백업하실 수 없습니다.");
				} else {
					$filename	= date("Ymd")."_".mktime().".tar";
					$url		= $save_path."/".$filename;
					@exec("tar cvfp ".$url." ".dir_common." --exclude ".dir_common."/tmp --exclude ".dir_common."/uploads");
						
					$maxNo	= $coreClass -> selectQueryMax($tbl1, "bak_no");
					$maxNo++;
						
					$filesize	= filesize($url);
					$item		= "bak_no, bak_type, bak_regip, bak_regdate, bak_year, bak_month, bak_day, bak_filename, bak_filesize";
					$value		= "'".$maxNo."', '1', '".site_client_ip."', '".site_regdate."', '".date("Y")."', '".date("m")."', '".date("d")."', '".$filename."', '".$filesize."'";
					$coreClass -> insertQuery($tbl1, $item, $value);
				}
	
				$coreClass -> commit();
				$coreClass -> go("sub.php?menukey=".$menukey."&mod=list");
				break;
					
		default		:
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}	
?>
