<?php
	class boardClass extends coreClass {
		// 게시글 로그 등록
		function insertBoardLogData($bid, $id, $type, $subject, $uid, $uname) {
			$item = "brdlog_bid, brdlog_did, brdlog_type, brdlog_subject, brdlog_uid, brdlog_name, brdlog_regip, brdlog_regdate";
			$value = "'".$bid."', '".$id."', '".$type."', '".$subject."', '".$uid."', '".$uname."', '".site_client_ip."', '".site_regdate."'";
			$this -> insertQuery(tbl_board_log, $item, $value);
		}
		
		// 게시판스킨명 불러오기
		function getBoardSkinName($bid) {
			$where = "WHERE brdskin_id = '".$bid."'";
			$row = $this -> selectQueryArray(tbl_board_skin, $where, "", "", "");
			return $row['BRDSKIN_NAME'];
		}
		
		// 최근게시글 가져오기 [공통]
		function getLatestBrd($bid, $num, $menukey, $length) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return '<li class="list_tit"><a href="sub.php?menukey='.$menukey.'">최근게시글이 없습니다.</a></li>';
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$data	= "";
				$p_new	= 3; $idx = 0;
				while($row = $this -> selectFetchArray($rs)) {
					$new				= "";
					$subject			= $this -> getSub2Str($length, $row['BRDATA_SUBJECT']);
					$content            = $this -> getSub2Str(50, strip_tags($row['BRDATA_CONTENT']));
					$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
					if($after72hours > mktime()) {
						$new = '&nbsp;<img src="/base/imgs/icon/icon_new.gif" alt="새글" style="vertical-align:middle;" />';
					}
					
					$data .= '<li class="list_tit"><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$subject.$new.'</a><span class="date">'.date("m.d", strtotime($row['BRDATA_REGDATE'])).'</span>';
					if($idx == 0){
						$data .= '<span class="text">'.$content.'</span>';
					}
					$data .= '</li>';
					$idx ++;
				}
				return $data;
			}
		}
		
		// 최근게시글 가져오기 
		function getLatestBrdNew($bid, $num, $length=50) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt	= $this -> selectQueryCount(tbl_board_data, $where);

			$order	= "ORDER BY brdata_regdate DESC";
			$rs		= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
			
			$data	= array();
			$p_new	= 3; $idx = 0;
			while($row = $this -> selectFetchArray($rs)) {
				$new				= "";
				$subject			= $this -> getSub2Str($length, $row['BRDATA_SUBJECT']);
				$content            = $this -> getSub2Str(50, strip_tags($row['BRDATA_CONTENT']));
				$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
				if($after72hours > mktime()) {
					$new = '&nbsp;<img src="/base/imgs/icon/icon_new.gif" alt="새글" style="vertical-align:middle;" />';
				}

				if($row['BRDATA_THUMBNAIL'] != ""){

					$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$row['BRDATA_THUMBYEAR']."/".$row['BRDATA_THUMBNAIL'];
					$img_path1 = "/upload/bbs/".$row['BRDATA_BID']."/".$row['BRDATA_THUMBYEAR']."/".$row['BRDATA_THUMBNAIL'];
					
					if(is_file($filepath1)) {
						$imgPath = $img_path1;
					} 
					$data[$idx]['imgTh']	   = $imgPath;

				}else{
					$where		= "WHERE brdfile_bid = '".$row['BRDATA_BID']."' AND brdfile_did = '".$row['BRDATA_ID']."'";
					$order		= "ORDER BY brdfile_no DESC";
					$rows		= $this -> selectQueryArray(tbl_board_file, $where, $order, 0, 1);
					$img_path	= "";
					$file_arr		= explode(".", $rows['BRDFILE_SNAME']);
					$ext			= strtolower($file_arr[1]);
		
					if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png"){
						$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$rows['BRDFILE_YEAR']."/thumbnail/thumbnail_".$rows['BRDFILE_SNAME'];
						$filepath2	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
						$img_path1 = "/upload/bbs/".$row['BRDATA_BID']."/".$rows['BRDFILE_YEAR']."/thumbnail/thumbnail_".$rows['BRDFILE_SNAME'];
						
						if(is_file($filepath1) || is_file($filepath2)) {
							$imgPath = $img_path1;
						}
						
						$data[$idx]['img']	   = $imgPath;
					}else{
						$data[$idx]['img']	   = "";
					}

				}
				
				$data[$idx]['no']	   = $row['BRDATA_NO'];
				$data[$idx]['subject'] = $subject;
				$data[$idx]['content'] = $content;
				$data[$idx]['date']    = date("Y-m-d", strtotime($row['BRDATA_REGDATE']));
				$data[$idx]['hit']     = $row['BRDATA_HIT'];

				$idx ++;
			}

			return $data;

		}
		
		// 최근게시글 가져오기 [모바일]
		function getLatestBrdMobile($bid, $num, $menukey) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return '<li><a href="sub.php?menukey='.$menukey.'">최근게시글이 없습니다.</a></li>';
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				while($row = $this -> selectFetchArray($rs)) {
					$data .= '<li><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$row['BRDATA_SUBJECT'].'</a></li>';
				}
				return $data;
			}
		}
		
		// 최근게시글 가져오기 [갤러리 인포존]
		function getLatestBrdGallery($bid, $num, $menukey) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt > 0) {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$return	= "";
				$new	= "";
				$p_new	= 3;
				$cnt	= 1;
		
				while($row = $this -> selectFetchArray($rs)) {
					$subject		= $this -> getSub2Str(14, $row['BRDATA_SUBJECT']);
					$imgPath        = "images/board/sc52_video.gif";

					if($row['BRDATA_THUMBNAIL'] != ""){

						$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$row['BRDATA_THUMBYEAR']."/".$row['BRDATA_THUMBNAIL'];
						$img_path1 = "/upload/bbs/".$row['BRDATA_BID']."/".$row['BRDATA_THUMBYEAR']."/".$row['BRDATA_THUMBNAIL'];
						
						if(is_file($filepath1)) {
							$imgPath = $img_path1;
						} 

						$return .= '<li class="swiper-slide"><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'"><img src="'.$imgPath.'" width="195" height="124" alt="'.$row['BRDATA_SUBJECT'].'" /><p>'.$subject.'</p></a></li>';

					}else{
						$where		= "WHERE brdfile_bid = '".$row['BRDATA_BID']."' AND brdfile_did = '".$row['BRDATA_ID']."'";
						$order		= "ORDER BY brdfile_no DESC";
						$rows			= $this -> selectQueryArray(tbl_board_file, $where, $order, 0, 1);
						$img_path	= "";
						$file_arr		= explode(".", $rows['BRDFILE_SNAME']);
						$ext			= strtolower($file_arr[1]);
			
						if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png"){
							$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$rows['BRDFILE_YEAR']."/thumbnail/thumbnail_".$rows['BRDFILE_SNAME'];
							$filepath2	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
							$img_path1 = "/upload/bbs/".$row['BRDATA_BID']."/".$rows['BRDFILE_YEAR']."/thumbnail/thumbnail_".$rows['BRDFILE_SNAME'];
							
							if(is_file($filepath1) || is_file($filepath2)) {
								$imgPath = $img_path1;
							}

							$return .= '<li class="swiper-slide"><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'"><img src="'.$imgPath.'" width="195" height="124" alt="'.$row['BRDATA_SUBJECT'].'" /><p>'.$subject.'</p></a></li>';
						}else{
							$return .= '<li class="swiper-slide"><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'"><img src="'.$imgPath.'" width="195" height="124" alt="'.$row['BRDATA_SUBJECT'].'" /><p>'.$subject.'</p></a></li>';
						}

					}
				}

				return $return;
			}else{
				$return .= '<li style="text-align:center;">등록된 내용이 없습니다.</li>';
				return $return;

			}
		}
		
		/**
		 * 메인페이지 최근게시글 가져오기
		 */
		function getLatestBrd2($bid, $num, $menukey, $str, $type) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return "<li>&nbsp;&nbsp;&nbsp;최근게시글이 없습니다.</li>";
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$return	= "";
				$p_new	= 3;
				while($row = $this -> selectFetchArray($rs)) {
					$new				= "";
					$subject			= $this -> getSub2Str($str, $row['BRDATA_SUBJECT']);
					$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
					if($after72hours > mktime()) $new = "&nbsp;<img src=\"/base/imgs/icon/icon_new.gif\" alt=\"새글\" style=\"vertical-align:middle;\" />";
						
					$return .="
						<li><a href=\"sub.php?menukey=".$menukey."&amp;mod=view&amp;no=".$row['BRDATA_NO']."\">".$subject.$new."</a>";
					if($type==2){
						$return .="<span>".date("[m.d]", strtotime($row['BRDATA_REGDATE']))."</span>";
					}
					$return .="</li>";
				}
				return $return;
			}
		}
		
		/**
		 * 메인페이지 최근게시글 가져오기
		 */
		function getLatestIntendBrd2($bid, $num, $menukey) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return "<li>&nbsp;&nbsp;&nbsp;최근게시글이 없습니다.</li>";
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$return	= "";
				$p_new	= 3;
				while($row = $this -> selectFetchArray($rs)) {
					$new				= "";
					$subject			= $this -> getSub2Str(55, $row['BRDATA_SUBJECT']);
					$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
					if($after72hours > mktime()) $new = "&nbsp;<img src=\"/base/imgs/icon/icon_new.gif\" alt=\"새글\" style=\"vertical-align:middle;\" />";
		
					$return .= '<li><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$subject.$new.'</a><span>['.date("m.d", strtotime($row['BRDATA_REGDATE'])).']</span></li>';
				}
				return $return;
			}
		}
		
		/**
		 * 부서홈페이지 메인페이지 최근게시글 가져오기
		 */
		function getLatestDeptBrd($bid, $num, $menukey, $type) {
			$typeWhere = "WHERE cms_info_code = '".site_config_type2."'";
			$typeRow = $this -> selectQueryArray(tbl_cms_info, $typeWhere, "", "", "");
			if($type == "1") $typeId = $typeRow['CMS_INFO_SCHEDULECATE'];
			else if($type == "2") $typeId = $typeRow['CMS_INFO_DATACATE'];
			else if($type == "3") $typeId = $typeRow['CMS_INFO_QNACATE'];
			else if(empty($type)) $typeId = "";
			
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			if(!empty($typeId)) $where .= " AND brdata_category = '".$typeId."'";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return "<li>&nbsp;&nbsp;&nbsp;최근게시글이 없습니다.</li>";
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$return	= "";
				$p_new	= 3;
				while($row = $this -> selectFetchArray($rs)) {
					$new				= "";
					$subject			= $this -> getSub2Str(35, $row['BRDATA_SUBJECT']);
					$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
					if($after72hours > mktime()) $new = "&nbsp;<img src=\"/base/imgs/icon/icon_new.gif\" alt=\"새글\" style=\"vertical-align:middle;\" />";
		
					$return .= '<li><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$subject.$new.'</a><span>'.date("Y.m.d", strtotime($row['BRDATA_REGDATE'])).'</span></li>';
				}
				return $return;
			}
		}

		/**
		 * 부서홈페이지 메인페이지 최근게시글 가져오기 (청렴봉사행정 전용)
		 */
		function getLatestDeptBrd2($bid, $num, $menukey, $len) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return "<li>&nbsp;&nbsp;&nbsp;최근게시글이 없습니다.</li>";
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$return	= "";
				$p_new	= 3;
				while($row = $this -> selectFetchArray($rs)) {
					$new				= "";
					$subject			= $this -> getSub2Str($len, $row['BRDATA_SUBJECT']);
					$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
					if($after72hours > mktime()) $new = "&nbsp;<img src=\"/base/imgs/icon/icon_new.gif\" alt=\"새글\" style=\"vertical-align:middle;\" />";
		
					$return .= '<li><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$subject.$new.'</a><span>'.date("Y.m.d", strtotime($row['BRDATA_REGDATE'])).'</span></li>';
				}
				return $return;
			}
		}
		
		/**
		 * 부서홈페이지 메인페이지 최근게시글 가져오기 (제목만(짧게 : width-300px))
		 */
		function getLatestDeptShortBrd($bid, $num, $menukey, $type) {

			$typeWhere = "WHERE cms_info_code = '".site_config_type2."'";
			$typeRow = $this -> selectQueryArray(tbl_cms_info, $typeWhere, "", "", "");
			if($type == "1") $typeId = $typeRow['CMS_INFO_SCHEDULECATE'];
			else if($type == "2") $typeId = $typeRow['CMS_INFO_DATACATE'];
			else if($type == "3") $typeId = $typeRow['CMS_INFO_QNACATE'];
			
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0 AND brdata_category = '".$typeId."'";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return "<li>&nbsp;&nbsp;&nbsp;최근게시글이 없습니다.</li>";
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$return	= "";
				$p_new	= 3;
				while($row = $this -> selectFetchArray($rs)) {
					$new				= "";
					if($type == "1") $subject = $this -> getSub2Str(25, $row['BRDATA_SUBJECT']);
					else if($type == "3") $subject = $this -> getSub2Str(28, $row['BRDATA_SUBJECT']);
					$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
					if($after72hours > mktime()) $new = "&nbsp;<img src=\"/base/imgs/icon/icon_new.gif\" alt=\"새글\" style=\"vertical-align:middle;\" />";
		
					//$return .= '<li><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$subject.$new.'</a></li>';
					$return .= '<li><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$subject.'</a></li>';
				}
				return $return;
			}
		}
		
		/**
		 * 열린교육감실 메인페이지 사진자료실 최근게시글 가져오기
		 */
		function getLatestIntendBrd($bid, $num, $menukey) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt	= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				$return = '<ul class="list">';
				$return .= '	<li><img src="imgs/main/noimg.jpg" alt="이미지없음" style="width:504px; height:282px;" /></li>';
				$return .= '</ul>';
				$return .= '<div class="photo_in">';
				$return .= '	<div id="bTxt1"><h2>최근게시글이 없습니다.</h2></div>';
				$return .= '</div>';
				return $return;
			} else {
				$order		= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$return1	= "";
				$return2	= "";
				$return3	= "";
				$p_new		= 3;
				$countChk	= 1;
				while($row = $this -> selectFetchArray($rs)) {
					// 첨부파일 검사
					$fileWhere = "WHERE brdfile_bid = '".$bid."' AND brdfile_did = '".$row['BRDATA_ID']."'";
					$fileOrder = "ORDER BY brdfile_no ASC";
					$fileRs = $this -> selectQuery(tbl_board_file, $fileWhere, $fileOrder, "", "");
					$sfileName = "";
					while($fileRow = $this -> selectFetchArray($fileRs)) {
						$sfileExt = $this -> getExtension($fileRow['BRDFILE_SNAME']);
						if($sfileExt == "jpg" || $sfileExt == "jpeg" || $sfileExt == "png" || $sfileExt == "gif" || $sfileExt == "bmp") {
							$sfileName = $fileRow['BRDFILE_SNAME'];
							break;
						}
					}
		
					$new			= "";
					$subject		= $this -> getSub2Str(35, $row['BRDATA_SUBJECT']);
					$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
					if($after72hours > mktime()) $new = "&nbsp;<img src=\"/base/imgs/icon/icon_new.gif\" alt=\"새글\" style=\"vertical-align:middle;\" />";
		
					if($countChk > 1) {
						$style1 = ' display:none';
						$style2 = ' style="display:none"';
					} else {
						$style1 = '';
						$style2 = '';
					}
		
					if($countChk == 1) {
						$return1 .= '<ul class="list">';
					}
					if(!empty($sfileName)) {
						$path1 			= "/upload/bbs/".$fileRow['BRDFILE_BID']."/".$fileRow['BRDFILE_YEAR']."/".$sfileName;
						$path2 			= "/upload/bbs/".$fileRow['BRDFILE_BID']."/".$sfileName;
						$pathExplode	= explode("/", $fileRow['BRDFILE_PATH']);
						$path3			= "/resource/attach/".$bid."/";
						$path3			= $path3.$pathExplode[count($pathExplode)-1];
						
						if(is_file(dir_public.$path1)) {
							$return1 .= '	<li><img src="'.$path1.'" alt="'.$fileRow['BRDFILE_NAME'].'" id="bImg'.$countChk.'"';
						} else 	if(is_file(dir_public.$path2)) {
							$return1 .= '	<li><img src="'.$path2.'" alt="'.$fileRow['BRDFILE_NAME'].'" id="bImg'.$countChk.'"';
						} else if(is_file(dir_public.$path3)) {
							$return1 .= '	<li><img src="'.$path3.'" alt="'.$fileRow['BRDFILE_NAME'].'" id="bImg'.$countChk.'"';
						} else {
							$return1 .= '	<li><img src="imgs/main/noimg.jpg" alt="'.$fileRow['BRDFILE_NAME'].'" id="bImg'.$countChk.'"';
						}
					} else {
						$return1 .= '	<li><img src="imgs/main/noimg.jpg" alt="'.$fileRow['BRDFILE_NAME'].'" id="bImg'.$countChk.'"';
					}
					$return1 .= ' style="width:504px; height:282px; '.$style1.'" /></li>';
					if($num == $countChk) {
						$return1 .= '</ul>';
					}
		
					if($countChk == 1) {
						$return2 .= '<div class="photo_in">';
					}
					$return2 .= '	<div id="bTxt'.$countChk.'"';
					$return2 .= $style2.'>';
					$return2 .= '		<div>';
					$return2 .= '			<h2>'.$this -> getSub2Str(30, $row['BRDATA_SUBJECT']).'</h2>';
					$return2 .= '		</div>';
					$return2 .= '		<p class="text">';
					$return2 .= '			<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$this -> getSub2Str(170, strip_tags($row['BRDATA_CONTENT'] -> load())).'</a>';
					$return2 .= '		</p>';
					$return2 .= '		<span class="more">';
					$return2 .= '			<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">';
					$return2 .= '				<img src="imgs/main/photo_more.gif" alt="자세히보기" />';
					$return2 .= '			</a>';
					$return2 .= '		</span>';
					$return2 .= '	</div>';
						
					if($countChk == 1) {
						$return3 .= '	<ul class="control clearfix">';
						$bannerOnOff = "on";
					} else {
						$bannerOnOff = "off";
					}
					$return3 .= '		 <li><a href="#"><img src="imgs/main/bannerBtn_'.$bannerOnOff.'.gif" alt="배너'.$countChk.'" id="bBtn'.$countChk.'" onclick="javascript:bannerChange(\''.$countChk.'\');" /></a></li>';
					if($num == $countChk) {
						$return3 .= '	</ul>';
						$return3 .= '</div>';
					}
					$countChk++;
				}
				return $return1.$return2.$return3;
			}
		}
		
		/**
		 * 학교시설예약홈페이지 메인페이지 최근게시글 가져오기 : 알림마당 (제목만(짧게 : width:251px))
		 */
		function getLatestReserveShortBrd($bid, $num, $menukey) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return "<li>&nbsp;&nbsp;&nbsp;최근게시글이 없습니다.</li>";
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$return	= "";
				$p_new	= 3;
				while($row = $this -> selectFetchArray($rs)) {
					$new				= "";
					$subject			= $this -> getSub2Str(35, $row['BRDATA_SUBJECT']);
					$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
					if($after72hours > mktime()) $new = "&nbsp;<img src=\"/base/imgs/icon/icon_new.gif\" alt=\"새글\" style=\"vertical-align:middle;\" />";
		
					$return .= '<li><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$subject.$new.'</a></li>';
				}
				return $return;
			}
		}

		//법무행정시스템 최신글 가져오기
		function getLatestBrdLaw($bid, $num, $menukey, $str, $type) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return "<li>&nbsp;&nbsp;&nbsp;최근게시글이 없습니다.</li>";
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$return	= "";
				$p_new	= 3;
				while($row = $this -> selectFetchArray($rs)) {
					$new				= "";
					$subject			= $this -> getSub2Str($str, $row['BRDATA_SUBJECT']);
					$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
					if($after72hours > mktime()) $new = "&nbsp;<img src=\"/base/imgs/icon/icon_new.gif\" alt=\"새글\" style=\"vertical-align:middle;\" />";
						
					$return .="
						<li><a href=\"sub.php?menukey=".$menukey."&amp;mod=view&amp;no=".$row['BRDATA_NO']."\">".$subject.$new."</a>";
					if($type==2){
						$return .="<span>".date("Y.m.d", strtotime($row['BRDATA_REGDATE']))."</span>";
					}
					$return .="</li>";
				}
				return $return;
			}
		}
		
		/**
		 * 메인페이지 갤러리게시글 가져오기
		 */
		function getLatestGBrd($bid, $num, $menukey) {
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return "<li style=\"background:none\">&nbsp;&bull;&nbsp;최근게시글이 없습니다.</li>";
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
		
				$return	= "";
				$new		= "";
				$p_new	= 3;
				$cnt		= 1;
		
				while($row = $this -> selectFetchArray($rs)) {
					$subject		= $this -> getSub2Str(18, $row['BRDATA_SUBJECT']);
					$where		= "WHERE brdfile_bid = '".$row['BRDATA_BID']."' AND brdfile_did = '".$row['BRDATA_ID']."'";
					$order		= "ORDER BY brdfile_no DESC";
					$rows			= $this -> selectQueryArray(tbl_board_file, $where, $order, 0, 1);
					$img_path	= "";
					$file_arr		= explode(".", $rows['BRDFILE_SNAME']);
					$ext			= strtolower($file_arr[1]);
						
					if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png"){
						$filepath	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$rows['BRDFILE_YEAR']."/thumbnail/thumbnail_".$rows['BRDFILE_SNAME'];
						if(is_file($filepath)) {
							$img_path = "/upload/bbs/".$row['BRDATA_BID']."/".$rows['BRDFILE_YEAR']."/thumbnail/thumbnail_".$rows['BRDFILE_SNAME'];
						} else {
							$filepath	= mb_convert_encoding($filepath, "EUC-KR", "UTF-8");
							if(is_file($filepath)) {
								$img_path = "/upload/bbs/".$row['BRDATA_BID']."/".$rows['BRDFILE_YEAR']."/thumbnail/thumbnail_".$rows['BRDFILE_SNAME'];
							}
						}
						if($cnt == 1) {
							$return .= '<li class="first">';
						} else {
							$return .= '<li>';
						}
						$return .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'"><img src="'.$img_path.'" alt="'.$row['BRDATA_SUBJECT'].'" style="width:95px; height:61px;" /></a>
							<br /><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$subject.'</a></li>';
					}
				}
				return $return;
			}
		}
		//메인페이지 갤러리 최신글
		function getLatestGBrd2($bid, $num, $menukey, $width, $height, $cls, $str, $type, $first) {
		
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				return "<div style=\"background:none\">&nbsp;&bull;&nbsp;최근게시글이 없습니다.</div>";
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
		
				$return	= "";
				$new		= "";
				$p_new	= 3;
				$cnt		= 1;
		
				while($row = $this -> selectFetchArray($rs)) {
					$subject		= $this -> getSub2Str($str, $row['BRDATA_SUBJECT']);
					$where		= "WHERE brdfile_bid = '".$row['BRDATA_BID']."' AND brdfile_did = '".$row['BRDATA_ID']."'";
					$order		= "ORDER BY brdfile_no DESC";
					$rows			= $this -> selectQueryArray(tbl_board_file, $where, $order, 0, 1);
					$img_path	= "";
					$file_arr		= explode(".", $rows['BRDFILE_SNAME']);
					$ext			= strtolower($file_arr[1]);
						
					if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png"){
						$filepath	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$rows['BRDFILE_YEAR']."/thumbnail/thumbnail_".$rows['BRDFILE_SNAME'];
						if(is_file($filepath)) {
							$img_path = "/upload/bbs/".$row['BRDATA_BID']."/".$rows['BRDFILE_YEAR']."/thumbnail/thumbnail_".$rows['BRDFILE_SNAME'];
						} else {
							$filepath	= mb_convert_encoding($filepath, "EUC-KR", "UTF-8");
							if(is_file($filepath)) {
								$img_path = "/upload/bbs/".$row['BRDATA_BID']."/".$rows['BRDFILE_YEAR']."/thumbnail/thumbnail_".$rows['BRDFILE_SNAME'];
							}
						}
						if($cnt == 1 and $first == 1) {
							$return .= '<li class="first">';
						} else {
							$return .= '<li>';
						}
						$return .= '<a '.$cls.' href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'"><img src="'.$img_path.'" alt="'.$row['BRDATA_SUBJECT'].'" style="width:'.$width.'px; height:'.$height.'px;" /><br /><a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'">'.$subject.'</a>';

							if($type=="1"){
								$return .= '<br/>'.date("Y.m.d", strtotime($row['BRDATA_REGDATE'])).'';
							}
							
						$return .= '</li>';

					}
					$cnt++;
				}
				return $return;
			}
		}

		function getCategoryName($bid, $id)
		{			
			if(!empty($bid)&&!empty($id)){
				$where = "WHERE brdcat_bid = '".$bid."' AND brdcat_id = '".$id."'"; 
				$this -> selectQueryCountChk(tbl_board_category, $where);
				$rs   = $this -> selectQuery(tbl_board_category, $where, "", "", "");
				$res  = $this -> selectFetchArray($rs);
				return $res['BRDCAT_NAME'];
			}else 
				return false;
		}

		function getNotice_one($bid,$menukey,$lang='kor'){
			$where	= "WHERE brdata_bid = '".$bid."' AND brdata_deleted = 'N' AND brdata_privacy = 'N' AND brdata_seq_no = 0";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
		
			if($cnt < 1) {
				$none = "등록 된 게시물이 없습니다.";
				if($lang == 'eng'){
					$none = "There is no posts.";
				}else if($lang == 'chn'){
					$none = "没有帖子";
				}else{
					$none = "投稿はありません";
				}
				return "<a href=\"#none\"><h3>".date('Y-m')."<br /><em>".date('d')."</em></h3>
									<p class=\"text\">".$none."</p></a>";
			} else {
				$order	= "ORDER BY brdata_regdate DESC";
				$rs			= $this -> selectQuery(tbl_board_data, $where, $order, 0, $num);
				$return	= "";
				$p_new	= 3;
				while($row = $this -> selectFetchArray($rs)) {
					$new				= "";
					$subject			= $this -> getSub2Str('125', $row['BRDATA_SUBJECT']);
					$after72hours	= (strtotime($row['BRDATA_REGDATE'])+86400) + (86400 * $p_new);
					if($after72hours > mktime()) $new = "&nbsp;<img src=\"/base/imgs/icon/icon_new.gif\" alt=\"새글\" style=\"vertical-align:middle;\" />";
						
					$return .="<a href=\"sub.php?menukey=".$menukey."&amp;mod=view&amp;no=".$row['BRDATA_NO']."\">
						<h3>".date("Y-m", strtotime($row['BRDATA_REGDATE']))."<br /><em>".date("d", strtotime($row['BRDATA_REGDATE']))."</em></h3>
									<p class=\"text\">".$subject."</p></a>";
					break;
					
				}
				return $return;
			}
		}

		function grp_no_ck($grpno){
			$where = "WHERE BRDATA_GRP_NO='".$grpno."'";
			$cnt		= $this -> selectQueryCount(tbl_board_data, $where);
			return $cnt;
		}
	}
?>