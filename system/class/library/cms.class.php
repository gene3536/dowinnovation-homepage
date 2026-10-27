<?php
	class cmsClass extends coreClass {
		// 통합콘텐츠 정보 가져오기
		function getContentInfo($id) {
			$where = "WHERE icm_id = '".$id."'";
			return $this -> selectQueryArray(tbl_cms_icm, $where, "", "", "");
		}
		
		// 메뉴권한 체크
		function menuAuth($type) {
			$rs = true;
			if(site_config_level < S_mb_level) {
				$where = "WHERE menu_manage_menukey = '".site_menu_menukey."' AND menu_manage_uid = '".S_mb_id."'";
				$rsCnt = $this -> selectQueryCount(tbl_menu_manage, $where);
				
				if($rsCnt < 1) $rs = false;
			}
			
			if($type == 1 && $rs == false) $this -> msg_back("사용권한이 없습니다.");
			return $rs;
		}
		
		// 메뉴권한 체크
		function cmsAuth($scode) {
			$rs = true;
			if(site_config_level < S_mb_level) {
				$where = "WHERE cms_manage_scode = '".$scode."' AND cms_manage_uid = '".S_mb_id."'";
				$rsCnt = $this -> selectQueryCount(tbl_cms_manage, $where);
		
				if($rsCnt < 1) $rs = false;
			}
			return $rs;
		}
		
		// 사이트목록 메뉴 불러오기
		function getSiteList($menukey, $mod, $scode) {
			$scodebox1 = "";
			$scodebox2 = "";
			$scodebox3 = "";
			$scodebox4 = "";
			$scodebox5 = "";
			if(empty($scode)) {
				$scodebox6 = '<a href="sub.php?menukey='.$menukey.'&mod='.$mod.'" class="btn_sml" style="color:#00f"><strong>전체</strong></a>';
			} else {
				$scodebox6 = '<a href="sub.php?menukey='.$menukey.'&mod='.$mod.'" class="btn_sml"><strong>전체</strong></a>';
			}
			
			if(site_config_level > S_mb_level) {
				$where	= "WHERE 1=1";
				$order	= "ORDER BY cms_info_no ASC";
				$result	= $this -> selectQuery(tbl_cms_info, $where, $order, "", "");
				
				while($rowc = $this -> selectFetchArray($result)) {
					$cls = "";
					if($rowc['CMS_INFO_CODE'] == $scode) { $cls = ' style="color:#00f"'; }
					${"scodebox".$rowc['CMS_INFO_TYPE']} .= '<a href="sub.php?menukey='.$menukey.'&mod='.$mod.'&scode='.$rowc['CMS_INFO_CODE'].'" class="btn_sml"'.$cls.'><span>'.$rowc['CMS_INFO_TITLE'].'</span></a>';
				}
				
				$scodebox = '
						<div style="border:1px solid #ccc; padding:5px;">
							<div style="margin-bottom:3px;">'.$scodebox6.$scodebox1.'</div>
							<div style="margin-bottom:3px;">'.$scodebox2.'</div>
							<div style="margin-bottom:3px;">'.$scodebox3.'</div>
							<div style="margin-bottom:3px;">'.$scodebox4.'</div>
							<div>'.$scodebox5.'</div>
						</div>';
			} else if(site_acc_lvl > S_mb_level) {
				$where	= "LEFT JOIN ".tbl_cms_manage." ON cms_manage_scode = cms_info_code WHERE cms_manage_uid = '".S_mb_id."'";
				$order	= "ORDER BY cms_info_no ASC";
				$result	= $this -> selectQuery(tbl_cms_info, $where, $order, "", "");

				while($rowc = $this -> selectFetchArray($result)) {
					$cls = "";
					if($rowc['CMS_INFO_CODE'] == $scode) { $cls = ' style="color:#00f"'; }
					${"scodebox".$rowc['CMS_INFO_TYPE']} .= '<a href="sub.php?menukey='.$menukey.'&mod='.$mod.'&scode='.$rowc['CMS_INFO_CODE'].'" class="btn_sml"'.$cls.'><span>'.$rowc['CMS_INFO_TITLE'].'</span></a>';					
				}
				
				$scodebox = '
						<div style="border:1px solid #ccc; padding:5px;">
							<div style="margin-bottom:3px;">'.$scodebox1.'</div>
							<div style="margin-bottom:3px;">'.$scodebox2.'</div>
							<div style="margin-bottom:3px;">'.$scodebox3.'</div>
							<div style="margin-bottom:3px;">'.$scodebox4.'</div>
							<div>'.$scodebox5.'</div>
						</div>';
			} else {
				$scodebox = "";
			}

			return $scodebox;
		}
		
		// 사이트목록 셀렉트박스 불러오기
		function getSiteSelect($scode) {
			$order = "ORDER BY cms_info_no ASC";
			$result = $this -> selectQuery(tbl_cms_info, "", $order, "", "");
			while($rows = $this -> selectFetchArray($result)) {
				$sel = "";
				if($rows['CMS_INFO_CODE'] == $scode) $sel = " selected=\"selected\"";
				$opt .= '<option value="'.$rows['CMS_INFO_CODE'].'"'.$sel.'>'.$rows['CMS_INFO_TITLE'].'</option>';
			}
			
			$datas .= '<select id="scodevar" name="scodevar" class="selline" style="width: 180px">';
			$datas .= '<option value="00000000">전체선택</option>';
			$datas .= $opt;
			$datas .= '</select>';
			
			return $datas;
		}
		
		// 사이트운영자 목록 불러오기
		function getSiteMngSelect($var) {
			$where	= "WHERE mb_level <= 3";
			$order	= "ORDER BY mb_name ASC";
			$result	= $this -> selectQuery(tbl_member, $where, $order, "", "");
			while($row = $this -> selectFetchArray($result)) {
				$sel = "";
				if($row['MB_UID'] == $var) $sel = " selected=\"selected\"";
				$opt .= '<option value="'.$row['MB_UID'].'"'.$sel.'>'.$row['MB_NAME'].' ('.$row['MB_UID'].')</option>';
			}
			
			$datas .= '<select name="uidvar" id="uidvar" class="selline" style="width:180px;">';
			$datas .= '<option value="">운영자 선택</option>';
			$datas .= $opt;
			$datas .= '</select>';
			
			return $datas;
		}
	
		// 사이트 명 불러오기
		function getSiteName($scode) {
			$where	= "WHERE cms_info_code = '".$scode."'";
			$order	= "ORDER BY cms_info_no ASC";
			$row		= $this -> selectQueryArray(tbl_cms_info, $where, $order, "", "");
		
			return $row['CMS_INFO_TITLE'];
		}
		
				
		// 사이트 DB 불러오기
		function getSiteDB($scode) {
			$where	= "WHERE cms_info_code = '".$scode."'";
			$order	= "ORDER BY cms_info_no ASC";
			$row		= $this -> selectQueryArray(tbl_cms_info, $where, $order, "", "");
		
			return $row['CMS_INFO_MENUDB'];
		}
		
		// 사이트 로고 불러오기
		function getSiteLogo($scode) {
			$where	= "WHERE logo_scode = '".$scode."' AND logo_visible = 'Y' AND logo_sdate <= '".site_regdate."' AND logo_edate >= '".site_regdate."'";
			$rsCnt		= $this -> selectQueryCount(tbl_cms_logo, $where);
			if($rsCnt > 0) {
				$row = $this -> selectQueryArray(tbl_cms_logo, $where, "", "", "");
				$logoData = '<div id="logo_event"><h1><a href="/home/main.php"><img src="/upload/content/logo/'.$row['LOGO_FILEYEAR'].'/'.$row['LOGO_SFILENAME'].'" alt="충청북도교육청" /></a></h1></div>';
			} else {
				$logoData = '<div id="logo"><h1><a href="/home/main.php"><img src="imgs/header/logo.gif" alt="충청북도교육청" /></a></h1></div>';
			}
			return $logoData;
		}
		
		// 통합콘텐츠목록 가져오기
		function getIcdList($pid, $type) {
			$where	= "a LEFT JOIN ".tbl_cms_icm." b ON b.icm_id = a.icd_pid WHERE (a.icd_scode = '".site_config_code."' OR a.icd_scode = '00000000') AND a.icd_pid = '".$pid."' AND a.icd_type = '".$type."' AND a.icd_sdate <= '".site_regdate."' AND a.icd_edate >= '".site_regdate."' AND a.icd_visible = 'Y'";
			$order	= "ORDER BY a.icd_regdate DESC";
			$result	= $this -> selectQuery(tbl_cms_icd, $where, $order, "", "");
			while($row = $this -> selectFetchArray($result)) {
				if(empty($row['ICD_URL'])) {
					$data .= '<a href="#" onclick="return false;"><img src="/upload/icd/'.$row["ICD_PID"].'/'.$row['ICD_FILEYEAR'].'/'.$row['ICD_SFILENAME'].'" alt="'.$row['ICD_ALT'].'" /></a>';
				} else {
					$data .= '<a href="http://'.$row['ICD_URL'].'" target="'.$row['ICD_TARGET'].'"><img src="/upload/icd/'.$row['ICD_PID'].'/'.$row['ICD_FILEYEAR'].'/'.$row['ICD_SFILENAME'].'" alt="'.$row['ICD_ALT'].'" /></a>';
				}
			}
			return $data;
		}
		
		// 배너목록 가져오기
		function getBnrList($pid) {
			$where	= "WHERE (icd_scode = '".site_config_code."' OR icd_scode = '00000000') AND icd_pid = '".$pid."' AND icd_visible = 'Y' AND icd_sdate <= '".site_regdate."' AND icd_edate >= '".site_regdate."'";
			$rs			= $this -> selectQuery(tbl_cms_icd, $where, "", "", "");
			$bnrCnt	= $this -> selectQueryCount(tbl_cms_icd, $where);
			$bnrI		= 1;
			$i			= 1;

			while($row = $this -> selectFetchArray($rs)) {
				//if($i == 1) $data .= '';
				$data .= '<li>';
				if(empty($row['ICD_URL'])) {
					$data .= '<a href="#" onclik="return false;"><img src="/upload/icd/'.$pid.'/'.$row['ICD_FILEYEAR'].'/'.$row['ICD_SFILENAME'].'" alt="'.$row['ICD_TITLE'].'" /></a>';
				} else {
					$data .= '<a href="http://'.$row['ICD_URL'].'" target="_blank"><img src="/upload/icd/'.$pid.'/'.$row['ICD_FILEYEAR'].'/'.$row['ICD_SFILENAME'].'" alt="'.$row['ICD_TITLE'].'" /></a>';
				}	
				$data .= '</li>';			
				if($i == 6 || $bnrI == $bnrCnt) {
					//$data .= '</li>';
					$i = 1;
				} else {
					$i++;
				}
				$bnrI++;
			}
			return $data;
		}
				
		/**
		 * 메인페이지 팝업존 가져오기
		 */
		function getPopupzoneData($type) {
			$where	= "WHERE poz_type = '".$type."' AND poz_sdate <= '".date("Y-m-d H:i:s")."' AND poz_edate >= '".date("Y-m-d H:i:s")."' AND poz_visible = 'Y'";		
			$order	= "ORDER BY poz_moddate DESC";
			$rs			= $this -> selectQuery(tbl_cms_popupzone, $where, $order, "");
			return $rs;
		}
		
		/**
		 * 배너목록 가져오기
		 */
		function getBannerList() {
			$where	= "WHERE (bnr_code = '00000000' OR bnr_code = '".site_config_code."') AND bnr_sdate <= '".date("Y-m-d H:i:s")."' AND bnr_edate >= '".date("Y-m-d H:i:s")."' AND bnr_visible = 'Y'";		
			$order	= "ORDER BY bnr_regdate DESC";
			$rs			= $this -> selectQuery(tbl_cms_banner, $where, $order, "", "");
			return $rs;
		}
		
		/**
		 * 배너개수 가져오기
		 */
		function getBannerCount() {
			$where	= "WHERE (bnr_code = '00000000' OR bnr_code = '".site_config_code."') AND bnr_sdate <= '".date("Y-m-d H:i:s")."' AND bnr_edate >= '".date("Y-m-d H:i:s")."' AND bnr_visible = 'Y'";		
			$rs			= $this -> selectQueryCount(tbl_cms_banner, $where);
			return $rs;
		}

		
		/**
		 * 메인페이지 퀵링크 가져오기
		 */
		function getQuickLinkList() {					
			$order	= "ORDER BY qlnk_step ASC, qlnk_moddate DESC";
			$limit		= "LIMIT 0, 10";
			$rs			= $this -> selectQuery(tbl_cms_link_quick, "", $order, $limit);
			return $rs;
		}

		// 콘텐츠 가져오기
		function getContentData($id) {
			$where = "WHERE icd_id = '".$id."' AND icd_pid = '00000001'";
			return $this -> selectQueryArray(tbl_cms_icd, $where, "", "", "");
		}

		/**
		 * 메일발송
		 */
		function setMail($from, $to, $subject, $content) {
			$subject	= "=?utf-8?B?".base64_encode($subject)."?=\n";
			$to			= "=?UTF-8?B?".base64_encode($to)."?="."<" . $to . ">\n";
			$from		= "=?UTF-8?B?".base64_encode(site_config_title)."?="."<" . $from . ">\n";

			$mailHeader = "from:{$from} \n";
        	$mailHeader .= "Return-Path:{$from} \n";
        	$mailHeader .= "Reply-To:{$from} \n";
        	$mailHeader .= "MIME-Version:1.0 \n";
        	$mailHeader .= "Content-Type: text/html;\n \tcharset=utf-8\n";
			
			return mail($to, $subject, $content, $mailHeader);
		}

		// 모바일 사이트 체크
		function getMobile($mouse, $mourl) {
			if($mouse == "Y") {
				if(preg_match('/(iPhone|Android|Opera Mini|SymbianOS|WindowsCE|BlackBerry|Nokia|SonyEricsson|webOS|PalmOS)/i', $_SERVER['HTTP_USER_AGENT'])) {
					$mobile = $this -> dataModel(2, "mobile", null);
					if($mobile != "N") $this -> go("http://".$mourl);
				}
			}
		}
		
		// WWW 사이트 체크
		function getWww($wwwuse) {
			if($wwwuse == "Y") {
				if(substr($_SERVER['HTTP_HOST'],0,3) != "www") {
					$this -> go("http://www.".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				}
			}
		}
		
		/**
		 * 사이트정보 가져오기
		 */
		function getSiteInfo($url, $dir) {
			$where	= "WHERE cms_info_path = '".$dir."'";
			$order	= "ORDER BY cms_info_no ASC";
			$infos	= $this -> selectQueryCount(tbl_cms_info, $where);
			
			if($infos < 1) {
				// 도메인 및 메인형, 가상형의 사이트 정보 추출
				$where	= "WHERE (cms_info_url1 ='".$_SERVER['HTTP_HOST']."' OR cms_info_url2 ='".$_SERVER['HTTP_HOST']."' OR cms_info_url3 ='".$_SERVER['HTTP_HOST']."') AND cms_info_type < 3";
				$infos		= $this -> selectQueryCount(tbl_cms_info, $where);
						
				// 해당 사이트정보가 없을 경우 에러페이지 출력
				if($infos < 1) $this -> go("/base/php/cmn.error.php");
						
				// 사이트정보 추출 후 가상형 및 2차경로가 있을 경우 주소이동
				$info = $this -> selectQueryArray(tbl_cms_info, $where, $order, null, null);
				//$this -> go("http://".$_SERVER['HTTP_HOST'].$info['CMS_INFO_PATH']);
				$this -> go("http://".$info['CMS_INFO_URL1'].$info['CMS_INFO_PATH']);
			} else {
				$info = $this -> selectQueryArray(tbl_cms_info, $where, $order, null, null);

				if($info['CMS_INFO_TYPE'] > 0 && $info['CMS_INFO_TYPE'] < 5) {
					if($info['CMS_INFO_URL1'] != $url && $info['CMS_INFO_URL2'] != $url && $info['CMS_INFO_URL3'] != $url) {
						$this -> go("http://".$info['CMS_INFO_URL1'].$info['CMS_INFO_PATH']);
					}
				} else if($info['CMS_INFO_TYPE'] == 5) {

				} else {
					$this -> go("/base/php/cmn.error.php");
				}
			}
			return $this -> selectQueryArray(tbl_cms_info, $where, $order, null, null);				
		}
		
		/**
		 * 접근IP 체크
		 */
		function getAccessCheck($ip) {
			$where	= "WHERE acs_ip = '".$ip."' AND acs_visible = 'Y'";
			$cnt		= $this -> selectQueryCount(tbl_cms_access, $where);			
			if($cnt < 1) $this -> msg_go("접속가능한 IP가 아닙니다.", "/");
		}

		/**
		 * 사이트 담당자/주요업무 데이터 가져오기
		 */
		function getSiteManager() {
			$where		= "WHERE sm_scode = '".site_config_type2."'";
			$cnt		= $this -> selectQueryCount(tbl_cms_sitemanager, $where);			
			if($cnt > 0) $result = $this -> selectQueryArray(tbl_cms_sitemanager, $where, "", "", "");

			return $result;
		}

		function getShopInfo()
		{
			$info = $this -> selectQueryArray(tbl_booking_conf_info, null, null, null, null);
			return $info;
		}

	}
?>