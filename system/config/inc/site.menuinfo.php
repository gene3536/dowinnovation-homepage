<?php
		// 서브메뉴 정보
		if(!empty($pageInfo['MENU_TITLE'])) {
			$locWhere	= "WHERE menu_scode = '".site_config_code."' AND menu_root='".site_config_rootkey."' AND menu_depth = '1'";
			$locRow1		= $coreClass -> selectQueryArray(tbl_menu, $locWhere, "", "", "");
			$locTitle		= $pageInfo['MENU_TITLE'];
			$locPage		= $pageInfo['MENU_TITLE'];
		
			if($pageInfo['MENU_DEPTH'] == 5) {
				$locWhere   	= "WHERE menu_scode = '".site_config_code."' AND menu_menukey='".$pageInfo['MENU_REF']."' AND menu_depth = '4'";
				$locRow4  	= $coreClass -> selectQueryArray(tbl_menu, $locWhere, "", "", "");
				
				$locWhere   	= "WHERE menu_scode = '".site_config_code."' AND menu_menukey='".$locRow4['MENU_REF']."' AND menu_depth = '3'";
				$locRow3  	= $coreClass -> selectQueryArray(tbl_menu, $locWhere, "", "", "");
					
				$locWhere   	= "WHERE menu_scode = '".site_config_code."' AND menu_menukey='".$locRow3['MENU_REF']."' AND menu_depth = '2'";
				$locRow2  	= $coreClass -> selectQueryArray(tbl_menu, $locWhere, "", "", "");
					
				$location		= "<li>".$locRow1['MENU_TITLE']."<li/><li>".$locRow2['MENU_TITLE']."<li/><li>".$locRow3['MENU_TITLE']."<li/><li>".$locRow4['MENU_TITLE']."<li/><li>".$locTitle."<li/>";
				$locPage		= "<li>".$locRow1['MENU_TITLE']."<li/><li>".$locRow2['MENU_TITLE']."<li/><li>".$locRow3['MENU_TITLE']."<li/><li>".$locRow4['MENU_TITLE']."<li/><li>".$locTitle."<li/>";
				$mid			= $locRow3['MENU_REF'];
				$s2id			= $locRow3['MENU_REF'];
				$s3id			= $locRow4['MENU_REF'];
				$s4id			= $locRow4['MENU_MENUKEY'];
			} else if($pageInfo['MENU_DEPTH'] == 4) {
				$locWhere   	= "WHERE menu_scode = '".site_config_code."' AND menu_menukey='".$pageInfo['MENU_REF']."' AND menu_depth = '3'";
				$locRow3  	= $coreClass -> selectQueryArray(tbl_menu, $locWhere, "", "", "");
					
				$locWhere   	= "WHERE menu_scode = '".site_config_code."' AND menu_menukey='".$locRow3['MENU_REF']."' AND menu_depth = '2'";
				$locRow2  	= $coreClass -> selectQueryArray(tbl_menu, $locWhere, "", "", "");
					
				$location		= "<li>".$locRow1['MENU_TITLE']."<li/><li>".$locRow2['MENU_TITLE']."<li/><li>".$locRow3['MENU_TITLE']."<li/><li>".$locTitle."<li/>";
				$locPage		= "<li>".$locRow1['MENU_TITLE']."<li/><li>".$locRow2['MENU_TITLE']."<li/><li>".$locRow3['MENU_TITLE']."<li/><li>".$locTitle."<li/>";				
				$mid			= $locRow3['MENU_REF'];
				$s2id			= $locRow3['MENU_REF'];
				$s3id			= $locRow3['MENU_MENUKEY'];
				$s4id			= $menukey;				
			} else if($pageInfo['MENU_DEPTH'] == 3) {
				$locWhere	= "WHERE menu_scode = '".site_config_code."' AND menu_menukey='".$pageInfo['MENU_REF']."' AND menu_depth = '2'";
				$locRow2  	= $coreClass -> selectQueryArray(tbl_menu, $locWhere, "", "", "");
				
				$location		= "<li>".$locRow1['MENU_TITLE']."<li/><li>".$locRow2['MENU_TITLE']."<li/><li>".$locTitle."<li/>";
				$locPage		= "<li>".$locRow1['MENU_TITLE']."<li/><li>".$locRow2['MENU_TITLE']."<li/><li>".$locTitle."<li/>";
				$mid			= $pageInfo['MENU_REF'];
				$s2id			= $pageInfo['MENU_MENUKEY'];
				$s3id			= $pageInfo['MENU_REF'];
			} else if($pageInfo['MENU_DEPTH'] == 2){
				$location		= "<li>".$locRow1['MENU_TITLE']."<li/><li>".$locTitle."<li/>";
				$locPage		= "<li>".$locRow1['MENU_TITLE']."<li/><li>".$locTitle."<li/>";
				$mid			= $pageInfo['MENU_MENUKEY'];
				$s2id			= $pageInfo['MENU_MENUKEY'];				
			}else {
				$location		= "<li>".$locRow1['MENU_TITLE']."<li/>";
				$locPage		= "<li>".$locRow1['MENU_TITLE']."<li/>";
				$mid			= $pageInfo['MENU_MENUKEY'];
				$s2id			= $pageInfo['MENU_MENUKEY'];
			}
		} else {
			$locTitle			= "요청하신 페이지 정보가 없습니다.";
			$location			= "요청하신 페이지 정보가 없습니다.";
			$locPage			= "요청하신 페이지 정보가 없습니다.";
		}

		/*$_tmp_location = explode(" &gt; ",$location);
		$_tmp_location[count($_tmp_location)-1] = "<span class=\"fc_333\">".$_tmp_location[count($_tmp_location)-1]."</span>";
		$location = implode("<img src=\"images/sub/sv_tit_arr.png\" alt=\"\" class=\"suv_navi_arr\">",$_tmp_location);*/

		define("site_menu_locTitle", $locTitle);
		define("site_menu_locPage", $locPage);
		define("site_menu_location", $location);
		define("site_menu_locPtitle", $locRow1['MENU_TITLE']);		

?>