<?php
	header("Content-Type: text/html; charset=utf-8");
	require_once("../../../system/config/config_lite.php");

	$tbl1		= tbl_cms_icd;
	$tbl2		= tbl_cms_icd_file;
	$no		= $coreClass -> dataModelEncrypt(2, "fno", NULL);
	$no		= $coreClass -> decrypt_md5(urlencode($no), site_config_filekey);
	$pid		= $coreClass -> dataModelEncrypt(2, "pid", NULL);
	$pid		= $coreClass -> decrypt_md5(urlencode($pid), site_config_filekey);
	$did		= $coreClass -> dataModelEncrypt(2, "did", NULL);
	$did		= $coreClass -> decrypt_md5(urlencode($did), site_config_filekey);
	$path		= dir_public."/upload/icd/".$pid."/";
	$HTTP_USER_AGENT = site_client_browser;	

	// 테이블 ID 유무 체크 및 게시판 정보
	if(empty($pid)) {
		$coreClass -> msg_back("파일 정보가 없습니다.");
	} else {
		$where			= "WHERE icd_id = '".$did."' AND icd_pid = '".$pid."' AND icd_visible = 'Y'";
		$coreClass -> selectQueryCountChk($tbl1, $where, "", "", "");
	}
	
	if(!empty($no) && !empty($pid) && !empty($did)) {
		$where	= "WHERE icd_no = '".$no."' AND icd_pid = '".$pid."' AND icd_did = '".$did."'";
		$rs			= $coreClass -> selectQueryCount($tbl2, $where);
		if($rs < 1) {
			$coreClass -> rollback();
			$coreClass -> msg_back("선택한 파일이 없습니다. (1)");
		}
		$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");

		$filename	= $row['ICD_NAME'];
		$filename	= str_replace(";","%3B",$filename);				
		$filename	= mb_convert_encoding($filename ,"EUC-KR", "UTF-8");
		$filepath	= $path.$row['ICD_YEAR']."/".$row['ICD_SNAME'];
		
		if(!is_file($filepath)) {
			$filepath	= mb_convert_encoding($filepath, "EUC-KR", "UTF-8");
			if(!is_file($filepath)) {
				$coreClass -> rollback();
				$coreClass -> msg_back("선택한 파일이 없습니다. (2)");
			}
		}

		$set	= "SET icd_hit = icd_hit + 1";
		$where	= "WHERE icd_no = '".$no."' AND icd_pid = '".$pid."' AND icd_did = '".$did."'";
		$coreClass -> updateQuery($tbl2, $set, $where);
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