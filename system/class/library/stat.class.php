<?php
	class statClass extends coreClass {
		// 1단계 방문페이지기록 업데이트
		function insertStatPagelog($title, $menukey) {
			$where		= "WHERE cms_stat_pagelog_code = '".site_config_code."' AND cms_stat_pagelog_menukey = '".$menukey."' AND cms_stat_pagelog_year = '".site_year."' AND cms_stat_pagelog_month = '".site_month."' AND cms_stat_pagelog_day = '".site_day."'";
			$statCnt		= $this -> selectQueryCount(tbl_cms_stat_pagelog, $where);
		
			if($statCnt > 0) {
				$where	= "WHERE cms_stat_pagelog_code = '".site_config_code."' AND cms_stat_pagelog_menukey = '".$menukey."' AND cms_stat_pagelog_year = '".site_year."' AND cms_stat_pagelog_month = '".site_month."' AND cms_stat_pagelog_day = '".site_day."'";
				$set		= "SET cms_stat_pagelog_total = cms_stat_pagelog_total + 1, cms_stat_pagelog_hour".date("H")." = cms_stat_pagelog_hour".date("H")." + 1";
				$this -> updateQuery(tbl_cms_stat_pagelog, $set, $where);
			} else {
				$item		= "cms_stat_pagelog_code, cms_stat_pagelog_title, cms_stat_pagelog_menukey, cms_stat_pagelog_year, cms_stat_pagelog_month, cms_stat_pagelog_day, cms_stat_pagelog_total, cms_stat_pagelog_hour".date("H");
				$value		= "'".site_config_code."', '".$title."', '".$menukey."', '".site_year."', '".site_month."', '".site_day."', 1, 1";
				$this -> insertQuery(tbl_cms_stat_pagelog, $item, $value);
			}
			$this -> commit();
		}	
		
		// 1단계 방문기록 정보
		function getStatCountSum($code, $type, $year, $month, $day, $hour, $minute, $second) {
			if($type == 1) {
				// 전체
				$where = "WHERE 1=1";
			} else if($type == 2) {
				// 일별
				$where = "WHERE cms_stat_count_year = '".$year."' AND cms_stat_count_month = '".$month."' AND cms_stat_count_day = '".$day."'";
			} else if($type == 3) {
				// 월별
				$where = "WHERE cms_stat_count_year = '".$year."' AND cms_stat_count_month = '".$month."'";
			} else if($type == 4) {
				// 연도별
				$where = "WHERE cms_stat_count_year = '".$year."'";
			} else if($type == 5) {
				// 시간별
				$where = "WHERE cms_stat_count_year = '".$year."' AND cms_stat_count_month = '".$month."' AND cms_stat_count_day = '".$day."' AND cms_stat_count_hour = '".$hour."'";
			}
			
			if(!empty($code)) {
				$where .= " AND cms_stat_count_code = '".$code."'";
			}
			
			return $this -> selectQuerySum(tbl_cms_stat_count, $where, "cms_stat_count_total");
		}
		
		// 1단계 브라우저기록 목록
		function getStatBrowserList($scode, $year) {
			$where = "WHERE 1=1";
			if(!empty($year)) {
				$where .= " AND cms_stat_browser_year = '".$year."'";
			}
			if(!empty($scode)) {
				$where .= " AND cms_stat_browser_code = '".$scode."'";
			}
			$query = "SELECT * FROM ".tbl_cms_stat_browser." ".$where." GROUP BY cms_stat_browser_version ORDER BY cms_stat_browser_version ASC";
			return $this -> executeQuery($query);
		}
		
		// 1단계 브라우저기록 정보
		function getStatBrowserSum($scode, $type, $year, $month, $day, $hour, $kwd) {
			if($type == 1) {
				// 전체
				$where = "WHERE 1=1";
			} else if($type == 2) {
				// 일별
				$where = "WHERE cms_stat_browser_year = '".$year."' AND cms_stat_browser_month = '".$month."' AND cms_stat_browser_day = '".$day."'";
			} else if($type == 3) {
				// 월별
				$where = "WHERE cms_stat_browser_year = '".$year."' AND cms_stat_browser_month = '".$month."'";
			} else if($type == 4) {
				// 연도별
				$where = "WHERE cms_stat_browser_year = '".$year."'";
			} else if($type == 5) {
				// 시간별
				$where = "WHERE cms_stat_browser_year = '".$year."' AND cms_stat_browser_month = '".$month."' AND cms_stat_browser_day = '".$day."' AND cms_stat_browser_hour = '".$hour."'";
			}
				
			if(!empty($scode)) {
				$where .= " AND cms_stat_browser_code = '".$scode."'";
			}
			if(!empty($kwd)) {
				$where .= " AND cms_stat_browser_version = '".$kwd."'";
			}

			return $this -> selectQuerySum(tbl_cms_stat_browser, $where, "cms_stat_browser_total");
		}
		
		// 1단계 방문기록 업데이트
		function insertStatLog($code, $id, $ip, $os, $browser, $browsert, $browserv, $searchengine, $searchkeyword, $referer) {
			$regdate			= date("Y-m-d H:i:s");
			$info1				= date("Y");
			$info2				= date("m");
			$info3				= date("d");
			$info4				= date("H");
			$info5				= date("i");
			$info6				= date("s");
			
			if(empty($browsert)) {
				$where			= "WHERE cms_stat_temp_code = '".$code."' AND cms_stat_temp_id = '".$id."' AND cms_stat_temp_os = '".$os."' AND cms_stat_temp_ip = '".$ip."' AND cms_stat_temp_year = '".$info1."' AND cms_stat_temp_month = '".$info2."' AND cms_stat_temp_day = '".$info3."'";
			} else {
				$where			= "WHERE cms_stat_temp_code = '".$code."' AND cms_stat_temp_id = '".$id."' AND cms_stat_temp_os = '".$os."' AND cms_stat_temp_browser_type = '".$browsert."' AND cms_stat_temp_ip = '".$ip."' AND cms_stat_temp_year = '".$info1."' AND cms_stat_temp_month = '".$info2."' AND cms_stat_temp_day = '".$info3."'";
			}
			$tempCnt			= $this -> selectQueryCount(tbl_cms_stat_temp, $where);
				
			if($tempCnt < 1) {
				// 방문자임시정보 업데이트
				$item		= "cms_stat_temp_code, cms_stat_temp_id, cms_stat_temp_ip, cms_stat_temp_os, cms_stat_temp_browser_type, cms_stat_temp_regdate, cms_stat_temp_year, cms_stat_temp_month, cms_stat_temp_day";
				$value		= "'".$code."', '".$id."', '".$ip."', '".$os."', '".$browsert."', '".$regdate."', '".$info1."', '".$info2."', '".$info3."'";
				$this -> insertQuery(tbl_cms_stat_temp, $item, $value);
				
				// 방문자접속로그 업데이트
				$item		= "cms_stat_log_code, cms_stat_log_id, cms_stat_log_ip, cms_stat_log_referer, cms_stat_log_os, cms_stat_log_agent, cms_stat_log_browser_type, cms_stat_log_browser_version, cms_stat_log_search_engine, cms_stat_log_search_keyword, cms_stat_log_regdate, cms_stat_log_year, cms_stat_log_month, cms_stat_log_day, cms_stat_log_hour, cms_stat_log_minute, cms_stat_log_second";
				$value		= "'".$code."', '".$id."', '".$ip."', '".$referer."', '".$os."', '".$browser."', '".$browsert."', '".$browserv."', '".$searchengine."', '".$searchkeyword."', '".$regdate."', '".$info1."', '".$info2."', '".$info3."', '".$info4."', '".$info5."', '".$info6."'";
				$this -> insertQuery(tbl_cms_stat_log, $item, $value);
				
				// 2단계 브라우저접속기록 업데이트
				$this -> insertStatBrowser($code, $browsert, $browserv, $info1, $info2, $info3, $info4);

				// 2단계 방문자접속기록 업데이트
				$this -> insertStatCount($code, $info1, $info2, $info3, $info4);
				
				// 방문자 전일기록 삭제
				$regdate		= date("Y-m-d");
				$where		= "WHERE cms_stat_temp_regdate < '".$regdate."'";
				$tempCnt		= $this -> selectQueryCount(tbl_cms_stat_temp, $where);
					
				if($tempCnt > 0) {
					$this -> deleteQuery(tbl_cms_stat_temp, $where);
				}
			}
		}

		// 2단계 방문자접속기록 업데이트 - 2013.09.13
		function insertStatCount($code, $year, $month, $day, $hour) {
			$where		= "WHERE cms_stat_count_code = '".$code."' AND cms_stat_count_year = '".$year."' AND cms_stat_count_month = '".$month."' AND cms_stat_count_day = '".$day."' AND cms_stat_count_hour = '".$hour."'";
			$statCnt		= $this -> selectQueryCount(tbl_cms_stat_count, $where);
		
			if($statCnt > 0) {
				$where	= "WHERE cms_stat_count_code = '".$code."' AND cms_stat_count_year = '".$year."' AND cms_stat_count_month = '".$month."' AND cms_stat_count_day = '".$day."' AND cms_stat_count_hour = '".$hour."'";
				$set		= "SET cms_stat_count_total = cms_stat_count_total + 1";
				$this -> updateQuery(tbl_cms_stat_count, $set, $where);
			} else {
				$item		= "cms_stat_count_code, cms_stat_count_year, cms_stat_count_month, cms_stat_count_day, cms_stat_count_hour, cms_stat_count_total";
				$value		= "'".$code."', '".$year."', '".$month."', '".$day."', '".$hour."', 1";
				$this -> insertQuery(tbl_cms_stat_count, $item, $value);
			}
		}

		// 2단계 브라우저접속기록 업데이트
		function insertStatBrowser($code, $browsert, $browserv, $year, $month, $day, $hour) {			
			$where		= "WHERE cms_stat_browser_code = '".$code."' AND cms_stat_browser_title = '".$browsert."' AND cms_stat_browser_version = '".$browserv."' AND cms_stat_browser_year = '".$year."' AND cms_stat_browser_month = '".$month."' AND cms_stat_browser_day = '".$day."' AND cms_stat_browser_hour = '".$hour."'";
			$browsCnt	= $this -> selectQueryCount(tbl_cms_stat_browser, $where);
			
			if(empty($browsCnt)) {
				$item			= "cms_stat_browser_code, cms_stat_browser_title, cms_stat_browser_version, cms_stat_browser_year, cms_stat_browser_month, cms_stat_browser_day, cms_stat_browser_hour, cms_stat_browser_total";
				$value			= "'".$code."', '".$browsert."', '".$browserv."', '".$year."', '".$month."', '".$day."', '".$hour."', 1";
				$this -> insertQuery(tbl_cms_stat_browser, $item, $value);
			} else {
				$where		= "WHERE cms_stat_browser_code = '".$code."' AND cms_stat_browser_title = '".$browsert."' AND cms_stat_browser_version = '".$browserv."' AND cms_stat_browser_year = '".$year."' AND cms_stat_browser_month = '".$month."' AND cms_stat_browser_day = '".$day."' AND cms_stat_browser_hour = '".$hour."'";
				$set			= "SET cms_stat_browser_total = cms_stat_browser_total + 1";
				$this -> updateQuery(tbl_cms_stat_browser, $set, $where);
			}
		}		
				
		/**
		 * 1단계 : 방문자 접속세션 체크
		 */
		function getSessionCheck() {
			// 시간 체크 후 기존 세션 데이터 삭제
			$chkHour	= 2;
			$chkTime	= mktime(date("H") - $chkHour, date("i"), date("s"), date("m"), date("d"), date("Y"));
			$where		= "WHERE cms_stat_session_time < '".$chkTime."'";
			$rsCnt		= $this -> selectQueryCount(tbl_cms_stat_session, $where);

			if($rsCnt > 0) {
				$rs		= $this -> selectQuery(tbl_cms_stat_session, $where, "", "", "");
				while($row = $this -> selectFetchArray($rs)) {
					@unlink(dir_session."/sess_".$row['session_id']);
				}
				$this -> deleteQuery(tbl_cms_stat_session, $where);
			}
			
			$sessionPath	= session_save_path();
			if (!preg_match("`/$`", $sessionPath)) $sessionPath .= '/';
			$d				= @dir($sessionPath);
		
			while (false !== ($entry = $d->read())) {
				if (substr($entry, 0, 1) != '.' && $entry != 'index.php') {
					$sessionTime = @filemtime($sessionPath.$entry);
					if ($chkTime > $sessionTime) {
						@unlink($sessionPath.$entry);
					}
				}
			}
			$d->close();
		}
		
		// 1단계 방문자 접속세션 저장
		function insertSession($uid, $uip, $sid, $uos, $regdate) {
			if($sid) {
				$where		= "WHERE cms_stat_session_id = '".$sid."'";
				$sessionChk	= $this -> selectQueryCount(tbl_cms_stat_session, $where);
		
				if($sessionChk > 0) {
					$set		= "SET cms_stat_session_uid = '".$uid."', cms_stat_session_uip = '".$uip."', cms_stat_session_uos = '".$uos."', cms_stat_session_time = '".time()."', cms_stat_session_moddate = '".$regdate."'"; 					
					$this -> updateQuery(tbl_cms_stat_session, $set, $where);
				} else {
					$item		= "cms_stat_session_uid, cms_stat_session_uip, cms_stat_session_id, cms_stat_session_uos, cms_stat_session_time, cms_stat_session_moddate, cms_stat_session_regdate";
					$value		= "'".$uid."', '".$uip."', '".$sid."', '".$uos."', '".time()."', '".site_regdate."', '".site_regdate."'";
					$this -> insertQuery(tbl_cms_stat_session, $item, $value);
				}
			}
		}
		
		// 1단계 방문자 접속로그 파일저장
		function setLoging() {
			$weekday		= array("일","월","화","수","목","금","토");
			$tarr			= localtime();
			
			$fileContents 	.= "\n"."1. ".date("Y-m-d H:i:s")." [".$weekday[$tarr[6]]."] | ".site_client_ip." | ".S_mb_id;
			$fileContents 	.= "\n"."2. ".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$fileContents 	.= "\n"."3. ".site_client_referer;
			$fileContents 	.= "\n"."4. ".site_client_browser;
			$fileContents 	.= "\n";

			$year			= date("Y");
			$month		= date("m");
			$day			= date("d");
			
			$fileName		= dir_logs."/".$year."/".$month."/".$year.$month.$day.".log";
			if (!file_exists(dir_logs."/".$year)) mkdir(dir_logs."/".$year,0707);
			if (!file_exists(dir_logs."/".$year."/".$month)) mkdir(dir_logs."/".$year."/".$month,0707);
			
			if(!file_exists($fileName)) {
				$fp = fopen($fileName,"w");
			} else {
				$fp = fopen($fileName,"a");
			}
			flock( $fp, LOCK_EX );
			fwrite($fp, $fileContents);
			flock( $fp, LOCK_UN );
			fclose($fp);
		}
	}
?>