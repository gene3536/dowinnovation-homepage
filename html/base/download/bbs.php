<?php
	header("Content-Type: text/html; charset=utf-8");
	require_once("../../../system/config/config_lite.php");

	$tbl		= tbl_board_file;
	$no		= $coreClass -> dataModelEncrypt(2, "fno", NULL);
	$no		= $coreClass -> decrypt_md5(urlencode($no), site_config_filekey);
	$bid		= $coreClass -> dataModelEncrypt(2, "bid", NULL);
	$bid		= $coreClass -> decrypt_md5(urlencode($bid), site_config_filekey);
	$did		= $coreClass -> dataModelEncrypt(2, "did", NULL);
	$did		= $coreClass -> decrypt_md5(urlencode($did), site_config_filekey);
	$path		= dir_public."/upload/bbs/".$bid."/";

	$HTTP_USER_AGENT = site_client_browser;	

	///메뉴 테이블의 활성화 메뉴에 있는 게시판 인지 체크
	$where = "where menu_board='".$bid."' and menu_access = 'Y'";
	$rs = $coreClass -> selectQueryCount(tbl_menu, $where);
	if($rs < 1) {
		$coreClass -> rollback();
		$coreClass -> msg_back("선택한 게시판 정보가 유효하지 않습니다.");
	}
	
	// 테이블 ID 유무 체크 및 게시판 정보
	if(empty($bid)) {
		$coreClass -> msg_back("테이블ID가 없습니다.");
	} else {
		$where			= "WHERE board_id = '".$bid."'";
		$board_data 	= $coreClass -> selectQueryArray(tbl_board, $where, "", "", "");
	}

	if(!empty($no) && !empty($bid) && !empty($did)) {
		$where	= "WHERE brdfile_no = '".$no."' AND brdfile_bid = '".$bid."' AND brdfile_did = '".$did."'";
		$rs			= $coreClass -> selectQueryCount($tbl, $where);
		if($rs < 1) {
			$coreClass -> rollback();
			$coreClass -> msg_back("선택한 파일이 없습니다.");
		}
		$row		= $coreClass -> selectQueryArray($tbl, $where, "", "", "");
		$row2		= $coreClass -> selectQueryArray(tbl_board_data, "WHERE brdata_no='".$row['BRDFILE_DID']."'", "", "", "");

		$brdata_wd = $brdata_wd2 = $row2['BRDATA_PASS'];

		require_once dir_module.'/board/m_board_data/include/lib.download.check.php';
		
		$filename	= $row['BRDFILE_NAME'];
		$filename	= str_replace(";","%3B",$filename);				
		$filename	= mb_convert_encoding($filename ,"EUC-KR", "UTF-8");
		$filepath	= $path.$row['BRDFILE_YEAR']."/".$row['BRDFILE_SNAME'];
		
		$path2	= dir_public.$row['BRDFILE_PATH'];
		$filepath2	= $path2.$row['BRDFILE_SNAME'];
		
		if(!is_file($filepath)) {
			$filepath	= mb_convert_encoding($filepath, "EUC-KR", "UTF-8");
			if(!is_file($filepath)) {
				if(!is_file($filepath2)) {
					$filepath2	= mb_convert_encoding($filepath2, "EUC-KR", "UTF-8");
					if(!is_file($filepath2)) {
						$coreClass -> rollback();
						$coreClass -> msg_back("선택한 파일이 없습니다.");						
					} else {
						$filepath = $filepath2;
					}
				} else {
					$filepath = $filepath2;
				}
			}
		}

		$set	= "SET brdfile_hit = brdfile_hit + 1";
		$where	= "WHERE brdfile_no = '".$no."' AND brdfile_bid = '".$bid."' AND brdfile_did = '".$did."'";
		$coreClass -> updateQuery($tbl, $set, $where);
		$coreClass -> commit();

		if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT)) { 
			if(strstr($HTTP_USER_AGENT, "MSIE 5.5")) { 
				header("Content-Type: doesn/matter"); 
				header("Content-disposition: filename=".$filename); 
				header("Content-Transfer-Encoding: binary"); 
				header("Pragma: private");
				header("Expires: 0");
			} 
		  
			if(strstr($HTTP_USER_AGENT, "MSIE 5.0")) { 
			   header("Content-type: file/unknown"); 
			   header("Content-Disposition: attachment; filename=".$filename); 
			   header("Content-Description: PHP3 Generated Data"); 
			   header("Pragma: private"); 
			   header("Expires: 0"); 
			}
		  
			if(strstr($HTTP_USER_AGENT, "MSIE 5.1")) { 
			   header("Content-type: file/unknown");
			   header("Content-Disposition: attachment; filename=".$filename);
			   header("Content-Description: PHP3 Generated Data"); 
			   header("Pragma: private"); 
			   header("Expires: 0"); 
			} 
		  
			if(strstr($HTTP_USER_AGENT, "MSIE 6.0")) { 
			   header("Content-type: application/x-msdownload");
			   header("Content-Length: ".(string)(filesize($filepath)));
			   header("Content-Disposition: attachment; filename=".$filename);
			   header("Content-Transfer-Encoding: binary");  
			   header("Pragma: private");  
			   header("Expires: 0");  
			} 
		} else {
			if(eregi("(iPhone|iPod|iPad|Android|Windows CE|Windows Phone)", $HTTP_USER_AGENT)) { 
				//$filename	= $row['BRDFILE_SNAME'];
				$filename = mb_convert_encoding($filename, "UTF-8", "CP949");
			}
			$filename = str_replace(",", "", $filename);
			header("Content-type: file/unknown");    
			header("Content-Length: ".filesize($filepath)); 
			header("Content-Disposition: attachment; filename=".$filename);
			header("Content-Description: PHP3 Generated Data");
			header("Content-Transfer-Encoding: binary "); 
			header("Pragma: private");
			header("Expires: 0"); 
		}
		ob_clean();
		flush();
		
		if (is_file($filepath)) { 
			$fp = fopen($filepath, "rb");		
			if (!fpassthru($fp)) fclose($fp);
		} else {
			$coreClass -> rollback();
			$coreClass -> msg_back("해당 파일이나 경로가 존재하지 않습니다.");
		}		
		$coreClass -> commit();		
	} else {
		$coreClass -> rollback();
		$coreClass -> msg_back("선택한 파일이 없습니다.");
	}
?>