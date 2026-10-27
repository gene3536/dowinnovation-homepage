<?php
	switch ($act) {
		// 삭제 - 2014.06.02
		case "delete" :
			$where	= "WHERE cms_info_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			$coreClass -> deleteQuery($tbl1, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey.$listVar);
			break;

		// 등록 - 2014.06.02
		case "insert":
			$maxNo	= $coreClass -> selectQueryMax($tbl1, "cms_info_no");
			$maxNo++;

			$item		= "cms_info_no, cms_info_type, cms_info_title, cms_info_code, cms_info_url1, cms_info_url2, cms_info_path, cms_info_copyright, cms_info_level, cms_info_slevel, cms_info_alevel, cms_info_glevel, cms_info_access, cms_info_ssl, cms_info_map, cms_info_regip, cms_info_modip, cms_info_regdate, cms_info_moddate, cms_info_menudb, cms_info_mouse, cms_info_mourl, cms_info_pagelog, cms_info_editor, cms_inquiry_header ";
			$value		= $maxNo.", ".$info_type.", '".$info_title."', '".$info_code."', '".$info_url1."', '".$info_url2."', '".$info_path."', '".$info_copyright."', '".$info_level."', '".$info_slevel."', '".$info_alevel."', '".$info_glevel."', '".$info_access."', '".$info_ssl."', '".$info_map."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."', '".$info_menudb."', '".$info_mouse."', '".$info_mourl."', '".$info_pagelog."', '".$info_editor."', '".$info_inquiry."'";
			$coreClass -> insertQuery(tbl_cms_info, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);			 
			break;
			
		// 수정 - 2014.06.02
		case "modify" :
			$set = "SET 
					cms_info_type = ".$info_type.",
					cms_info_title = '".$info_title."', 
					cms_info_code = '".$info_code."',
					cms_info_url1 = '".$info_url1."',
					cms_info_url2 = '".$info_url2."',
					cms_info_path = '".$info_path."',
					cms_info_copyright = '".$info_copyright."', 
					cms_info_level = '".$info_level."',
					cms_info_slevel = '".$info_slevel."', 
					cms_info_alevel = '".$info_alevel."', 
					cms_info_glevel = '".$info_glevel."',  
					cms_info_access = '".$info_access."',
					cms_info_ssl = '".$info_ssl."',
					cms_info_maptype = '".$info_maptype."',
					cms_info_map = '".$info_map."',
					cms_info_menudb = '".$info_menudb."', 
					cms_info_mouse = '".$info_mouse."', 
					cms_info_mourl = '".$info_mourl."', 
					cms_info_pagelog = '".$info_pagelog."',
					cms_info_editor = '".$info_editor."',
					cms_inquiry_header = '".$info_inquiry."',
					cms_info_modip = '".site_client_ip."',
					cms_info_moddate = '".site_regdate."'";
			$where = "WHERE cms_info_no = '".$no."'";
			$coreClass -> updateQuery(tbl_cms_info, $set, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
			
		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;		
	}
?>
