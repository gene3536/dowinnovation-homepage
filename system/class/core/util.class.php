<?php		
	class utilClass extends encryptClass {
		/**
		 * This function loads the requested class.
		 */
		function LoaderClass($data) {
			$data		= trim($data);
			$filename	= dir_system."/class/library/".$data.".class.php";
			if(is_file($filename)) {
				require_once ($filename);
			}
		}
		
		// 데이터 필터 (XSS필터 포함)
		function dataEscape($data) {
			$data = trim($data);
			$filter = new HTMLFilter();
			$data = $filter->parse($data);
			$data = str_replace("\'", "&#39;", $data);
			$data = str_replace("\"", "&quot;", $data);
				
			// ON일 경우 magic_quotes_gpc/magic_quotes_sybase 효과 제거
			if(get_magic_quotes_gpc()) {
				$data = stripslashes($data);
			}
			if($this -> DB_Type == 2) {
				$data = mysql_real_escape_string($data);
			}
			
			return $data;
		}
		
		// 데이터 필터
		function dataEscapeNoXss($data) {
			$data = trim($data);
			$filter = new HTMLFilter();
			$data = $filter->parse($data);
			
			// ON일 경우 magic_quotes_gpc/magic_quotes_sybase 효과 제거
			if(get_magic_quotes_gpc()) {
				$data = stripslashes($data);
			}
			if($this -> DB_Type == 2) {
				$data = mysql_real_escape_string($data);
			}
		
			return $data;
		}
		
		// 데이터 필터
		function dataEscapeNoXss2($data) {
			$data = trim($data);

			$data = str_replace("/\r\n|\r|\n/",'<br>',$data);
			$data = $this->htmlsan($data);
			
			// ON일 경우 magic_quotes_gpc/magic_quotes_sybase 효과 제거
			if(get_magic_quotes_gpc()) {
				$data = stripslashes($data);
			}
			if($this -> DB_Type == 2) {
				$data = mysql_real_escape_string($data);
			}
		
			return $data;
		}

		// 데이터필터 (암복호화)
		function dataEscapeEncrypt($data) {
			//$data = str_replace("\'", "&#39;", $data);
			//$data = str_replace("\"", "&quot;", $data);
		
			return $data;
		}
		
		// 데이터 모델 (Type2 -> get,post || Type1 -> post)
		function dataModel($type, $data, $return) {
			$data1 = !empty($_GET[$data]) ? $_GET[$data] : "";
			$data2 = !empty($_POST[$data]) ? $_POST[$data] : "";
			$data3 = $return;
			
			if(!empty($data1)) $data1 = $this -> dataEscape($data1);
			if(!empty($data2)) $data2 = $this -> dataEscape($data2);
			if(!empty($data3)) $data3 = $this -> dataEscape($return);
				
			if($type == 1) {
				$data = (isset($data2) && $data2 != "") ? $data2 : $data3;
			} else if($type == 2) {
				$data = (isset($data1) && $data1 != "") ? $data1 : ((isset($data2) && $data2 != "") ? $data2 : $data3);
			}
			
			return $data;
		}
		
		// 데이터 모델 (Type2 -> get,post || Type1 -> post)
		function dataModelNoXss($type, $data, $return) {
			$data1 = !empty($_GET[$data]) ? $_GET[$data] : "";
			$data2 = !empty($_POST[$data]) ? $_POST[$data] : "";
			$data3 = $return;
				
			if(!empty($data1)) $data1 = $this -> dataEscapeNoXss($data1);
			if(!empty($data2)) $data2 = $this -> dataEscapeNoXss($data2);
			if(!empty($data3)) $data3 = $this -> dataEscapeNoXss($return);
			
			if($type == 1) {
				$data = (isset($data2) && $data2 != "") ? $data2 : $data3;
			} else if($type == 2) {
				$data = (isset($data1) && $data1 != "") ? $data1 : ((isset($data2) && $data2 != "") ? $data2 : $data3);
			}
			return $data;
		}
		
		// 데이터 모델 (Type2 -> get,post || Type1 -> post)
		function dataModelNoXss2($type, $data, $return) {
			$data1 = !empty($_GET[$data]) ? $_GET[$data] : "";
			$data2 = !empty($_POST[$data]) ? $_POST[$data] : "";
			$data3 = $return;
				
			if(!empty($data1)) $data1 = $this -> dataEscapeNoXss2($data1);
			if(!empty($data2)) $data2 = $this -> dataEscapeNoXss2($data2);
			if(!empty($data3)) $data3 = $this -> dataEscapeNoXss2($return);
			
			if($type == 1) {
				$data = (isset($data2) && $data2 != "") ? $data2 : $data3;
			} else if($type == 2) {
				$data = (isset($data1) && $data1 != "") ? $data1 : ((isset($data2) && $data2 != "") ? $data2 : $data3);
			}
			return $data;
		}

		// 데이터 모델 (Type2 -> get,post || Type1 -> post)
		function dataModelEncrypt($type, $data, $return) {
			$data1 = !empty($_GET[$data]) ? $_GET[$data] : "";
			$data2 = !empty($_POST[$data]) ? $_POST[$data] : "";
			$data3 = $return;
			if(!empty($data1)) $data1 = $this -> dataEscapeEncrypt($data1);
			if(!empty($data2)) $data2 = $this -> dataEscapeEncrypt($data2);
			if(!empty($data3)) $data3 = $this -> dataEscapeEncrypt($return);
			
			if($type == 1) {
				$data = (isset($data2) && $data2 != "") ? $data2 : $data3;
			} else if($type == 2) {
				$data = (isset($data1) && $data1 != "") ? $data1 : ((isset($data2) && $data2 != "") ? $data2 : $data3);
			}
			return $data;
		}
		
		// XSS Clean
		function cleanXssTags($val){
			$xss_tags = array(
					'@<script[^>]*?>.*?</script>@si',    // script
					'@<style[^>]*?>.*?</style>@siU',    // style tags properly
					'@<iframe[^>]*?>.*?</iframe>@si',    // iframe
					'@<meta[^>]*?>.*?>@si',                // meta tags
					'@<form[^>]*?>.*?>@si',                // form tags
					'@]script[^>]*?>.*?]/script>@si',    // [\xC0][\xBC]script>[code][\xC0][\xBC]/script>
					'/:*?expression(.*?\)/si',            // expression style tags
					'/:*?binding:(.*?)url\(.*?\)/si',    // binding style tags
					'/javascript:[^\"\']*/si',            // javascript tags
					'/vbscript:[^\"\']*/si',            // vbscript tags
					'/livescript:[^\"\']*/si',            // livescript tags
					'@<![\s\S]*?--[ \t\n\r]*>@'            // multi-line comments including CDATA
					);
		
			$event_tags = array(
				'dynsrc','datasrc','frameset','ilayer','layer','applet',
				'onabort','onactivate','onafterprint','onsubmit','onunload',
				'onafterupdate','onbeforeactivate','onbeforecopy','onbeforecut',
				'onbeforedeactivate','onbeforeeditfocus','onbeforepaste','onbeforeprint',
				'onbeforeunload','onbeforeupdate','onblur','onbounce','oncellchange',
				'onchange','onclick','oncontextmenu','oncontrolselect','oncopy','oncut',
				'ondataavaible','ondatasetchanged','ondatasetcomplete','ondblclick',
				'ondeactivate','ondrag','ondragdrop','ondragend','ondragenter',
				'ondragleave','ondragover','ondragstart','ondrop','onerror','onerrorupdate',
				'onfilterupdate','onfinish','onfocus','onfocusin','onfocusout','onhelp',
				'onkeydown','onkeypress','onkeyup','onlayoutcomplete','onload','onlosecapture',
				'onmousedown','onmouseenter','onmouseleave','onmousemove','onmoveout',
				'onmouseover','onmouseup','onmousewheel','onmove','onmoveend','onmovestart',
				'onpaste','onpropertychange','onreadystatechange','onreset','onresize',
				'onresizeend','onresizestart','onrowexit','onrowsdelete','onrowsinserted',
				'onscroll','onselect','onselectionchange','onselectstart','onstart','onstop'
			);
		
			$val = str_ireplace($event_tags, "_badtags", $val);
			$val = ereg_replace($xss_tags, "", $val);
			return $val;
		}
		
		/**
		 * 디스크 정보 가져오기
		 */
		function getDiskSpace() {
			$total_disk			= @disk_total_space("/");
			$total_disk			= @intval($total_disk/1024/1024/1024);
			$FreeDiskSpace		= @DiskFreespace("/");
			$FreeDiskSpace		= @intval($FreeDiskSpace/1024/1024/1024);
			$NoFreeDiskSpace	= $total_disk - $FreeDiskSpace;
				
			return "Total ".$total_disk."GB / Used ".$NoFreeDiskSpace."GB / Free ".$FreeDiskSpace."GB";
		}
		
		/**
		 * 운영체제 정보 가져오기
		 */
		function getOperationName() {
			return php_uname('s')." ".php_uname('r')." ".php_uname('m');
		}
		
		/**
		 * 브라우저버전 체크
		 */
		function getBrowser() {
			$user_agent			= $_SERVER['HTTP_USER_AGENT'];
			$user_referer		= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
			$browser_name		= "Unknown";
			$browser_version	= "";
			$platform			= "Unknown";
			$serach_engine		= "Url";
			$ub					= "";
			
			
			// 운영체제 체크
			if (preg_match('/linux/i', $user_agent)) {
				$platform = 'linux';
			} else if (preg_match('/macintosh|mac os x/i', $user_agent)) {
				$platform = 'mac';
			} else if (preg_match('/windows|win32/i', $user_agent)) {
				$platform = 'windows';
			}
			
			// 유입검색엔진 체크
			if(isset($user_referer)) {
				if(preg_match('/naver.com/i',$user_referer)) {
					$search_engine = "Naver";
				} else if (preg_match('/daum.net/i',$user_referer)) {
					$search_engine = "Daum";
				} else if (preg_match('/zum.com/i',$user_referer)) {
					$search_engine = "Zum";
				} else if (preg_match('/nate.com/i',$user_referer)) {
					$search_engine = "Nate";
				} else if (preg_match('/paran.com/i',$user_referer)) {
					$search_engine = "Paran";
				} else if (preg_match('/google.co.kr/i',$user_referer) || preg_match('/google.com/i',$user_referer)) {
					$search_engine = "Google";
				} else if (preg_match('/yahoo.co.kr/i',$user_referer) || preg_match('/yahoo.com/i',$user_referer)) {
					$search_engine = "Yahoo";
				} else {
					$search_engine = "Etc";
				}
			}
			
			// 브라우저 타입 체크
			if(preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent)) {
				$browser_name = 'Internet Explorer';
				$ub = "MSIE";
			} else if (preg_match('/Edge/i',$user_agent)) {
				$browser_name = 'MSIE Edge';
				$ub = "MSIE Edge";
			} else if (preg_match('/Trident/i',$user_agent)) {
				$browser_name = 'MSIE 11';
				$ub = "MSIE 11";
			} else if (preg_match('/Firefox/i',$user_agent)) {
				$browser_name = 'Mozilla Firefox';
				$ub = "Firefox";
			} else if (preg_match('/Chrome/i',$user_agent)) {
				$browser_name = 'Google Chrome';
				$ub = "Chrome";
			} else if (preg_match('/Safari/i',$user_agent)) {
				$browser_name = 'Apple Safari';
				$ub = "Safari";
			} else if (preg_match('/Opera/i',$user_agent)) {
				$browser_name = 'Opera';
				$ub = "Opera";
			} else if (preg_match('/Netscape/i',$user_agent)) {
				$browser_name = 'Netscape';
				$ub = "Netscape";
			} else {
				$browser_name = 'Others';
				$ub = "Others";
			}
			
			// finally get the correct version number			
			$known = array('Version', $ub, 'other');
			$pattern = '#(?<browser>'.join('|', $known).')[\/]+(?<version>[0-9.|a-zA-Z.]*)#';
			if (!preg_match_all("/{$pattern}/", $user_agent, $matches)) {
				// we have no matching number just continue
			}
			
		    // see how many we have
		    $i = count($matches['browser']);
		    if ($i != 1) {
		    	// we will have two since we are not using 'other' argument yet
		    	// see if version is before or after the name
		    	if (strripos($user_agent,"Version") < strripos($user_agent,$ub)){
		    		$browser_version= $matches['version'][0];
		    	} else {
		    		$browser_version= $matches['version'][1];
		    	}
		    } else {
		    	$browser_version= $matches['version'][0];
		    }

		    // check if we have a number
		    if ($browser_version==null || $browser_version=="") {
		    	$browser_version="?";
		    }
		    return array('userAgent'=>$user_agent, 'name'=>$ub, 'version'=>$ub." ".$browser_version, 'platform'=>$platform, 'userReferer'=>$user_referer, 'search_engine'=>$search_engine);
		}
		
		/**
		 * 관리자 페이지 메뉴타입
		 */
		function getMenuType($type) {
			if($type == 1) {
				$type = "-";
			} else if($type == 2) {
				$type = "파일링크";
			} else if($type == 3) {
				$type = "콘텐츠";
			} else if($type == 4) {
				$type = "게시판";
			} else if($type == 5) {
				$type = "새창링크";
			} else if($type == 6) {
				$type = "스크립트";
			}
			return $type;
		}

		/**
		 * 관리자 페이지 메뉴활성여부
		 */
		function getMenuVisible($visible) {
			if($visible == "Y") {
				$visible = "활성";
			} else if($visible == "N") {
				$visible = "비활성";
			}
			return $visible;
		}
		
		/**
		 * 사용자 비밀번호 추출
		 */
		function getId2Pass($uid) {
			$where	= "WHERE MB_UID = '".$uid."'";
			$row		= $this -> selectQueryArray(tbl_member, $where, "", "", "");
			return $row['MB_PASS'];
		}
		
		/**
		 * 사용자 레벨 추출
		 */
		function getLevelName($lvl) {
			$where	= "WHERE MB_LEVEL_LV = '".$lvl."'";
			$row		= $this -> selectQueryArray(tbl_member_level, $where, "", "", "");
			return $row['MB_LEVEL_TITLE'];
		}

		/**
		 * 문자열자르기
		 */
		function getSub2Str($length, $str) {
			$str = mb_strimwidth($str, '0', $length, '...', 'utf-8');
			return $str;
		}

		/**
		 * 문자열자르기
		 */
		function getSub2StrName($length, $str, $str2) {
			if(!$str2) $str2 = "**";
			//$str = mb_strimwidth($str, '0', $length, $str2, 'utf-8');
			$str = mb_substr($str, 0, 1,"utf-8").$str2; 
			return $str;
		}

		
		/**
		 * 카테고리값가져오기
		 */
		function getCatno2Name($no, $bid) {
			$where	= "WHERE brdcat_bid = '".$bid."' AND brdcat_no = '".$no."'";
			$row		= $this -> selectQueryArray(tbl_board_category, $where, "", "", "");
			return $row['BRDCAT_NAME'];
		}
			
		/**
		 * 카테고리값가져오기
		 */
		function getCatid2Name($id, $bid) {
			$where	= "WHERE brdcat_bid = '".$bid."' AND brdcat_id = '".$id."'";
			$row		= $this -> selectQueryArray(tbl_board_category, $where, "", "", "");
			return $row['BRDCAT_NAME'];
		}
			
							
		/**
         * 플래시삽
         */
        function importFlash($url, $width, $height, $img, $base, $flashvars) {    
            $flash = "
					<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0\" width=\"$width\" height=\"$height\">
                    <param name=\"movie\" value=\"".$url."\" />
                    <param name=\"flashvars\" value=\"".$flashvars."\"/>
                    <param name=\"quality\" value=\"high\" />
                    <param name=\"wmode\" value=\"transparent\" />
                    <param name=\"base\" value=\"".$base."\"/>
                    <param name=\"menu\" value=\"false\"/>
                    <param name=\"allowScriptAccess\" value=\"always\"/>                    
					<div><img src=\"".$img."\" alt=\"\" /></div>
                    </object>";
            return $flash;
        }
		
        /**
         * 플래시삽
         */
        function importFlash2($url, $width, $height, $img, $base, $flashvars) {    
            $flash = "
					<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0\" width=\"$width\" height=\"$height\">
                    <param name=\"movie\" value=\"".$url."\" />
                    <param name=\"flashvars\" value=\"".$flashvars."\"/>
                    <param name=\"quality\" value=\"high\" />
                    <param name=\"wmode\" value=\"transparent\" />
                    <param name=\"base\" value=\"".$base."\"/>
                    <param name=\"menu\" value=\"false\"/>
                    <param name=\"allowScriptAccess\" value=\"always\"/>                    
                    <!--[if !IE]>-->
                    <object type=\"application/x-shockwave-flash\" data=\"".$url."\" width=\"".$width."\" height=\"".$height."\" />
					<!--<![endif]-->
                    <param name=\"movie\" value=\"".$url."\" />
                    <param name=\"flashvars\" value=\"".$flashvars."\"/>
                    <param name=\"quality\" value=\"high\" />
                    <param name=\"wmode\" value=\"transparent\" />
                    <param name=\"base\" value=\"".$base."\"/>
                    <param name=\"menu\" value=\"false\"/>
                    <param name=\"allowScriptAccess\" value=\"always\"/>                    
					<div><img src=\"".$img."\" alt=\"\" /></div>
                    <!--[if !IE]>-->
					</object>
					<!--<![endif]-->
                    </object>";
    
            return $flash;
        }

		/**
		 * 파일 업로드
		 */
		/**
		 * 파일 업로드
		 */
		function uploadFile($uploadFile, $uploadFile_name, $uploadFile_size, $save_path, $file_type, $file_size, $thumb_width, $thumb_height) {
			
			global $serverChar;
			$maxsize			= $file_size ? $file_size : 50;
			$thumb_width	= $thumb_width ? $thumb_width : 180;
			$thumb_height	= $thumb_height ? $thumb_height : 120;
			
			// 파일이름을 배열로
			$file_arr = explode(".", $uploadFile_name);
			$num = count($file_arr);
			
			//파일 확장자 분리
			$ext = strtolower($file_arr[$num-1]);
	
			// 업로드 불가 파일 확장자 체크
			if( ($ext != "jpg") && ($ext != "gif") && ($ext != "png")  && ($ext != "bmp") && ($ext != "hwp") && ($ext != "xdf") && ($ext != "wmv") && ($ext != "avi") && ($ext != "mp3") && ($ext != "mp4") &&
			    ($ext != "doc") && ($ext != "swf") && ($ext != "xls") && ($ext != "xlsx") && ($ext != "ppt") && ($ext != "pptx") && ($ext != "zip") && ($ext != "pdf")  && ($ext != "csv") ) {
					$this -> rollback(); 
			    	$this -> msg_back("요청하신 파일은 업로드 하실수 없습니다");
			}
			
			// 저장파일명
			$time = time();
			$new_file_name = $time.$file_type.".".$ext;
			
			// 파일 용량 체크
			$maxsize = $maxsize * 1024 * 1024;
			if($uploadFile_size >= $maxsize) {
				$this -> rollback();
				$this -> msg_back($file_size."첨부파일 용량이 초과되었습니다");
			}
			
			// 폴더 체크
			if(!is_dir($save_path)) mkdir($save_path, 0707);
			
			$save_path = $save_path.date("Y");
			@mkdir($save_path, 0707);
			@chmod($save_path, 0777);
			
			@mkdir($save_path."/thumbnail/", 0707);	
			@chmod($save_path."/thumbnail/", 0777); 
			
			copy($uploadFile, $save_path."/".$new_file_name); 

			if(!copy($uploadFile, $save_path."/".$new_file_name)) {
				$this -> rollback();
				$this -> msg_back($save_path."/".$new_file_name.">>>>>파일을 지정한 디렉토리에 복사하는데 실패했습니다.");
			}
			
			if(($ext == "jpg") || ($ext == "gif") || ($ext == "png")) {
				list($width_orig, $height_orig) = getimagesize($save_path."/".$new_file_name);
		
				if(!strcmp($ext, "jpg")) {
					$thum_img	= imagecreatefromjpeg($save_path."/".$new_file_name);
					$new_img	= imagecreatetruecolor($thumb_width, $thumb_height);
					imagecopyresampled($new_img, $thum_img, 0,0,0,0, $thumb_width, $thumb_height, $width_orig, $height_orig);
						
					$thumFile_name = "thumbnail_".$new_file_name;
					imagejpeg($new_img, $save_path."/thumbnail/".$thumFile_name);
				} else if(!strcmp($ext, "gif")) {
					$thum_img	= imagecreatefromgif($save_path."/".$new_file_name);
					$new_img	= imagecreatetruecolor($thumb_width, $thumb_height);
					imagecopyresampled($new_img, $thum_img, 0,0,0,0, $thumb_width, $thumb_height, $width_orig, $height_orig);
						
					$thumFile_name = "thumbnail_".$new_file_name;
					imagegif($new_img, $save_path."/thumbnail/".$thumFile_name);				
				} else if(!strcmp($ext, "png")) {
					$thum_img	= imagecreatefrompng($save_path."/".$new_file_name);
					$new_img	= imagecreatetruecolor($thumb_width, $thumb_height);
					imagecopyresampled($new_img, $thum_img, 0,0,0,0, $thumb_width, $thumb_height, $width_orig, $height_orig);
						
					$thumFile_name = "thumbnail_".$new_file_name;
					imagegif($new_img, $save_path."/thumbnail/".$thumFile_name);				
				}
			}
			
			if(!unlink($uploadFile)) {
				$this -> rollback();
				$this -> msg("임시파일을 삭제하는데 실패했습니다.");
			}
	
			return $new_file_name;
		}



		function uploadFile2($uploadFile, $uploadFile_name, $uploadFile_size, $save_path, $file_type, $file_size, $thumb_width, $thumb_height) {
			
			global $serverChar;
			$maxsize			= $file_size ? $file_size : 50;
			$thumb_width	= $thumb_width ? $thumb_width : 180;
			$thumb_height	= $thumb_height ? $thumb_height : 120;
			
			// 파일이름을 배열로
			$file_arr = explode(".", $uploadFile_name);
			$num = count($file_arr);
			
			//파일 확장자 분리
			$ext = strtolower($file_arr[$num-1]);
	
			// 업로드 불가 파일 확장자 체크
			if( ($ext != "jpg") && ($ext != "gif") && ($ext != "png")  && ($ext != "bmp") && ($ext != "hwp") && ($ext != "xdf") && ($ext != "wmv") && ($ext != "avi") && ($ext != "mp4") &&
			    ($ext != "doc") && ($ext != "swf") && ($ext != "xls") && ($ext != "xlsx") && ($ext != "ppt") && ($ext != "pptx") && ($ext != "zip") && ($ext != "pdf")  && ($ext != "csv") ) {
					$this -> rollback(); 
			    	$this -> msg_back("요청하신 파일은 업로드 하실수 없습니다");
			}
			
			// 저장파일명
			$time = time();
			$new_file_name = $time.$file_type.".".$ext;
			
			// 파일 용량 체크
			$maxsize = $maxsize * 1024 * 1024;
			if($uploadFile_size >= $maxsize) {
				$this -> rollback();
				$this -> msg_back($file_size."첨부파일 용량이 초과되었습니다");
			}
			
			// 폴더 체크
			if(!file_exists($save_path)) mkdir($save_path, 0707);
			
			$save_path = $save_path."/";
			if(!file_exists($save_path)) mkdir($save_path, 0707);
			
			if(!file_exists($save_path."thumbnail/")) mkdir($save_path."thumbnail/", 0707);	
			if(!copy($uploadFile, $save_path."/".$new_file_name)) {
				$this -> rollback();
				$this -> msg_back("파일을 지정한 디렉토리에 복사하는데 실패했습니다.");
			}
			
			if(($ext == "jpg") || ($ext == "gif")) {
				list($width_orig, $height_orig) = getimagesize($save_path."/".$new_file_name);
		
				if(!strcmp($ext, "jpg")) {
					$thum_img	= imagecreatefromjpeg($save_path."/".$new_file_name);
					$new_img	= imagecreatetruecolor($thumb_width, $thumb_height);
					imagecopyresampled($new_img, $thum_img, 0,0,0,0, $thumb_width, $thumb_height, $width_orig, $height_orig);
						
					$thumFile_name = "thumbnail_".$new_file_name;
					imagejpeg($new_img, $save_path."/thumbnail/".$thumFile_name);
				} else if(!strcmp($ext, "gif")) {
					$thum_img	= imagecreatefromgif($save_path."/".$new_file_name);
					$new_img	= imagecreatetruecolor($thumb_width, $thumb_height);
					imagecopyresampled($new_img, $thum_img, 0,0,0,0, $thumb_width, $thumb_height, $width_orig, $height_orig);
						
					$thumFile_name = "thumbnail_".$new_file_name;
					imagegif($new_img, $save_path."/thumbnail/".$thumFile_name);				
				}
			}
			
			if(!unlink($uploadFile)) {
				$this -> rollback();
				$this -> msg("임시파일을 삭제하는데 실패했습니다.");
			}
	
			return $new_file_name;
		}

		/**
		 * 파일 업로드 - 난수추가
		 */
		function uploadFileRandom($uploadFile, $uploadFile_name, $uploadFile_size, $save_path, $file_type, $file_size, $thumb_width, $thumb_height) {
			
			global $serverChar;
			$maxsize			= $file_size ? $file_size : 50;
			$thumb_width	= $thumb_width ? $thumb_width : 180;
			$thumb_height	= $thumb_height ? $thumb_height : 120;
			
			// 파일이름을 배열로
			$file_arr = explode(".", $uploadFile_name);
			$num = count($file_arr);
			
			//파일 확장자 분리
			$ext = strtolower($file_arr[$num-1]);
	
			// 업로드 불가 파일 확장자 체크
			if( ($ext != "jpg") && ($ext != "gif") && ($ext != "png")  && ($ext != "bmp") && ($ext != "hwp") && ($ext != "xdf") && ($ext != "wmv") && ($ext != "avi") && ($ext != "mp4") &&
			    ($ext != "doc") && ($ext != "swf") && ($ext != "xls") && ($ext != "xlsx") && ($ext != "ppt") && ($ext != "pptx") && ($ext != "zip") && ($ext != "pdf")  && ($ext != "csv") ) {
					$this -> rollback(); 
			    	$this -> msg_back("요청하신 파일은 업로드 하실수 없습니다");
			}
			
			// 저장파일명
			$time = time();
			$random = mt_rand(0001, 9999);
			$new_file_name = $time.$random.$file_type.".".$ext;
			
			// 파일 용량 체크
			$maxsize = $maxsize * 1024 * 1024;
			if($uploadFile_size >= $maxsize) {
				$this -> rollback();
				$this -> msg_back($file_size."첨부파일 용량이 초과되었습니다");
			}
			
			// 폴더 체크
			if(!file_exists($save_path)) mkdir($save_path, 0707);
			
			$save_path = $save_path.date("Y")."/";
			if(!file_exists($save_path)) mkdir($save_path, 0707);
			
			if(!file_exists($save_path."thumbnail/")) mkdir($save_path."thumbnail/", 0707);	
			if(!copy($uploadFile, $save_path."/".$new_file_name)) {
				$this -> rollback();
				$this -> msg_back("파일을 지정한 디렉토리에 복사하는데 실패했습니다.");
			}
			
			if(($ext == "jpg") || ($ext == "gif")) {
				list($width_orig, $height_orig) = getimagesize($save_path."/".$new_file_name);
		
				if(!strcmp($ext, "jpg")) {
					$thum_img	= imagecreatefromjpeg($save_path."/".$new_file_name);
					$new_img	= imagecreatetruecolor($thumb_width, $thumb_height);
					imagecopyresampled($new_img, $thum_img, 0,0,0,0, $thumb_width, $thumb_height, $width_orig, $height_orig);
						
					$thumFile_name = "thumbnail_".$new_file_name;
					imagejpeg($new_img, $save_path."/thumbnail/".$thumFile_name);
				} else if(!strcmp($ext, "gif")) {
					$thum_img	= imagecreatefromgif($save_path."/".$new_file_name);
					$new_img	= imagecreatetruecolor($thumb_width, $thumb_height);
					imagecopyresampled($new_img, $thum_img, 0,0,0,0, $thumb_width, $thumb_height, $width_orig, $height_orig);
						
					$thumFile_name = "thumbnail_".$new_file_name;
					imagegif($new_img, $save_path."/thumbnail/".$thumFile_name);				
				}
			}
			
			if(!unlink($uploadFile)) {
				$this -> rollback();
				$this -> msg("임시파일을 삭제하는데 실패했습니다.");
			}
	
			return $new_file_name;
		}


		function copyFile($uploadFile_name, $pno, $save_path, $copy_path) {
			
			global $serverChar;
			
			// 파일이름을 배열로
			$file_arr = explode(".", $uploadFile_name);
			$num = count($file_arr);
			
			//파일 확장자 분리
			$ext = strtolower($file_arr[$num-1]);

			// 원본파일명
			$uploadFile = $copy_path.$uploadFile_name;
			
			// 폴더 체크
			if(!file_exists($save_path)) mkdir($save_path, 0707);
			
			$save_path = $save_path.$pno."/".date("ymd");
			if(!file_exists($save_path)) mkdir($save_path, 0707);			
			
			// 원본파일 백업 폴더 복사
			if(!copy($uploadFile, $save_path."/".$uploadFile_name)) {
				$this -> rollback();
				$this -> msg_back("파일을 지정한 디렉토리에 복사하는데 실패했습니다.");
			}

			if(($ext == "jpg") || ($ext == "gif")) {

				// 썸네일파일명
				$thumFile_name  = $copy_path."thumbnail/thumbnail_".$uploadFile_name;

				if(!file_exists($save_path."thumbnail/")) mkdir($save_path."thumbnail/", 0707);	
				if(!copy($thumFile_name, $save_path."thumbnail/"."thumbnail_".$uploadFile_name)) {
					$this -> rollback();
					$this -> msg_back("파일을 지정한 디렉토리에 복사하는데 실패했습니다.");
				}
			}
			
			if(!unlink($uploadFile)) {
				$this -> rollback();
				$this -> msg("임시파일을 삭제하는데 실패했습니다.");
			}
	
			return $new_file_name;
		}

		/**
		 * 에디터 출력
		 * SE 2.3.10
		 */
		function getEditor($type, $name, $width, $height, $data) {
			if($type == 1) {
				$return = '
					<textarea name="'.$name.'" id="'.$name.'" style="width:'.$width.'; height:'.$height.';" title="글내용">'.$data.'</textarea>
					<script type="text/javascript">
						var oEditors = [];
						nhn.husky.EZCreator.createInIFrame({
	    					oAppRef: oEditors,
	    					elPlaceHolder: "'.$name.'",
	    					sSkinURI: "/base/editor/SE2/SmartEditor2Skin.html",
	    					fCreator: "createSEditor2",
	    					htParams: { fOnBeforeUnload : function(){
	    					}} 
						});
						$.submitContent = function() {
							oEditors.getById["'.$name.'"].exec("UPDATE_CONTENTS_FIELD", []);							
						}
					</script>';
			} else if($type == 2) {
				$return = '
					<textarea id="'.$name.'" name="'.$name.'" style="width:'.$width.'; height:'.$height.';" title="글내용">'.$data.'</textarea>
					<script type="text/javascript">CKEDITOR.replace("'.$name.'");</script>
					<script type="text/javascript">
						$.submitContent = function() {}
					</script>';
			}
			echo $return;
		}

		/**
		 * 파일 확장자 추출
		 */
		function getExtension($name) {
			$fileArray = explode(".", $name);
			$return = $fileArray[count($fileArray) - 1];
			return $return;
		}


		function sendmail($fname, $fmail, $to, $subject, $content) {
			ini_set("sendmail_from", $fmail);
			ini_set("smtp_port", "25");

		    $fname	= "=?UTF-8?B?" . base64_encode($fname) . "?=";
		    $subject	= "=?UTF-8?B?" . base64_encode($subject) . "?=";
    	    $content	= stripslashes($content);
		    
			$header	= "Return-Path: <$fmail>\n";
			$header	.= "From: $fname <$fmail>\n";
			$header	.= "Reply-To: <$fmail>\n";
			$header	.= "MIME-Version: 1.0\n";
	        $header	.= "Content-Type: TEXT/html; charset=UTF-8\n";
			$header	.= "Content-Transfer-Encoding: BASE64\n\n";
		    $header	.= chunk_split(base64_encode($content)) . "\n";

			$mail_from = "";


		    $rs = mail($to, $subject, "", $header);//, '-f'.$mail_from
			
			return $rs;
		}

		function htmlsan($htmlsanitize){
			return $htmlsanitize = htmlspecialchars($htmlsanitize, ENT_QUOTES, 'UTF-8');
		}


		function file_type($filename) 
		{ 
			$tmp = explode(".", $filename); 
			$ext = trim($tmp[count($tmp)-1]); 
			//$ext = strtolower($ext);

			$type_image		= "jpg|jpeg|gif|bmp|pcx|png"; 
			$type_compress	= "zip|alz|gz|tar|z|rar|ace|bz|bz2"; 
			$type_text		= "txt|text|rtf|2b"; 
			$type_html		= "htm|html"; 
			$type_hwp		= "hwp|h30"; 
			$type_exe		= "exe"; 
			$type_font		= "ttf"; 
			$type_movie		= "avi|mpg|mpeg|mqv|asf|wmv|mov|mp4"; 
			$type_sound		= "wav|mp3|mid|wma"; 

			if(preg_match("/($type_image)/i",$ext)) 
				$file_type = 'image'; 
			else if(preg_match("/($type_compress)/i",$ext)) 
				$file_type = 'compress'; 
			else if(preg_match("/($type_text)/i",$ext)) 
				$file_type = 'text'; 
			else if(preg_match("/($type_html)/i",$ext)) 
				$file_type = 'html'; 
			else if(preg_match("/($type_hwp)/i",$ext)) 
				$file_type = 'hwp'; 
			else if(preg_match("/($type_exe)/i",$ext)) 
				$file_type = 'exe'; 
			else if(preg_match("/($type_font)/i",$ext)) 
				$file_type = 'font'; 
			else if(preg_match("/($type_movie)/i",$ext)) 
				$file_type = 'movie'; 
			else if(preg_match("/($type_sound)/i",$ext)) 
				$file_type = 'sound'; 
			else 
				$file_type = 'unknown'; 

			return $file_type; 
		}  


		function filePreview($file)
		{ 
			if(!is_file($file)) return false;

			$res = 0; $home = dir_doc_viewer; $respath = dir_doc_viewer_output;
			$result = exec("timeout 20 $home/sn3hcv_exe -mod_path $home/modules -t $home/template $file $respath", $output, $res);	

			if($res != 0){ 
				$return = ""; 
			}else{
				$newFile = basename($file).".htm";
				$return  = "&nbsp;<a href=\"http://".site_config_host."/upload/viewer/result/".$newFile."\" target=\"_blank\" title=\"새창에서 열림\"><img src=\"/base/imgs/board/ys_see_btn.gif\" alt=\"미리보기\"></a>&nbsp;";
			}

			return $return;
		}
 
		function smsLog($rec, $name="", $message, $result, $orderno="")
		{
			$name    = $this->dataEscape($name);
			$message = $this->dataEscapeNoXss($message); 
			$rec     = str_replace("-","",$rec);
			
			//결과 저장
			$item		= " sms_tel, sms_name, sms_content, sms_result, sms_orderno, sms_regdate ";
			$value		= "'".$rec."', '".$name."', '".$message."', '".$result."', '".$orderno."', '".date("Y-m-d H:s:i")."'";
			$this -> insertQuery(tbl_sms_log, $item, $value); 
			$this -> commit();
		}

		function generate_state() {
			$mt = microtime();
			$rand = mt_rand();
			return md5($mt . $rand);
		}

		function check_cer_file($file, $filename){
			$file_info		= getimagesize($file);
			$file_width		= $file_info[0]; //이미지 가로 사이즈
			$file_height	= $file_info[1]; //이미지 세로 사이즈
			$file_type		= $_FILES['upload_file']['type'];
			
			$check_ext		= array('jpg','jpeg','png','gif'); //확장자 체크를 위한 선언부	
			$file_ext		= array_pop(explode('.',$filename)); //확장자 추출 (array_pop : 배열의 마지막 원소를 빼내어 반환)
			

			if (!in_array($file_ext, $check_ext)){
				$this -> msg_back("허용되지 않는 확장자입니다.");
				return false;
			}		
			
			if($file_width >= $file_height){
				$this -> msg_back("세로형 이미지만 업로드 가능합니다.");
				return false;
			}

			return true;
		}
	}
?>