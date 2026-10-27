<?php
	class pagingClass extends utilClass {

		// Common PagingVar
		function pagingVar($page, $search, $kwd, $cate, $no, $id, $scode, $codes) {
			Global $mod;
			$kwd	= urlencode($kwd);
			$var	= "";
			if($mod != "list" && !empty($mod) && !empty($no)) $var .= "&amp;no=".$no;
			if($mod != "list" && !empty($mod) && !empty($id)) $var .= "&amp;id=".$id;
			
			if(!empty($page))	$var .= "&amp;page=".$page;
			if(!empty($search))	$var .= "&amp;search=".$search;
			if(!empty($kwd))	$var .= "&amp;kwd=".$kwd;
			if(!empty($cate))		$var .= "&amp;cate=".$cate;
			if(!empty($scode))	$var .= "&scode=".$scode;

			$codes = explode("^", $codes);
			$codes_cnt = count($codes);
			for($i = 1; $i <= $codes_cnt; $i++) {
				if(!empty($codes[$i-1])) $var .= "&amp;code".$i."=".$codes[$i-1];
			}
			return $var;
		}
		
		function pagingVar_search($page, $search, $kwd, $cate, $no, $id, $code1, $code2, $codes) {
			Global $mod;
			$kwd	= urlencode($kwd);
			$var	= "";
			if($mod != "list" && !empty($mod) && !empty($no)) $var .= "&amp;no=".$no;
			if($mod != "list" && !empty($mod) && !empty($id)) $var .= "&amp;id=".$id;
			
			if(!empty($page))	$var .= "&amp;page=".$page;
			if(!empty($search))	$var .= "&amp;search=".$search;
			if(!empty($kwd))	$var .= "&amp;kwd=".$kwd;
			if(!empty($cate))		$var .= "&amp;cate=".$cate;
			if(!empty($code1))	$var .= "&amp;searchKwd=".$code1;
			if(!empty($code2))	$var .= "&amp;searchTyp=".$code2;

			$codes = explode("^", $codes);
			$codes_cnt = count($codes);
			for($i = 1; $i <= $codes_cnt; $i++) {
				if(!empty($codes[$i-1])) $var .= "&amp;code".$i."=".$codes[$i-1];
			}
			return $var;
		}

		// comment PagingVar
		function pagingVarC($pageC, $search, $kwd, $cate, $no, $id, $scode, $codes, $page) {
			$kwd	= urlencode($kwd);
			$var	= "";
			//if($mod != "list" && !empty($mod) && !empty($no)) $var .= "&amp;no=".$no;
			$var .= "&amp;no=".$no;
			if($mod != "list" && !empty($mod) && !empty($id)) $var .= "&amp;id=".$id;
			if(!empty($page))	$var .= "&amp;page=".$page;
			if(!empty($search))	$var .= "&amp;search=".$search;
			if(!empty($kwd))	$var .= "&amp;kwd=".$kwd;
			if(!empty($cate))		$var .= "&amp;cate=".$cate;
			if(!empty($scode))	$var .= "&amp;scode=".$scode;
			if(!empty($pageC))	$var .= "&amp;pageC=".$pageC;

			$codes = explode("^", $codes);
			$codes_cnt = count($codes);
			for($i = 1; $i <= $codes_cnt; $i++) {
				if(!empty($codes[$i-1])) $var .= "&amp;code".$i."=".$codes[$i-1];
			}
			return $var;
		}


		function pagingVarType2($page, $search, $kwd, $cate, $code1, $code2, $code3) {
			$kwd	= urlencode($kwd);
			$var	= !empty($page) ? "&amp;page=".$page : "&amp;page=1";
			if(!empty($search))	$var	.= "&amp;search=".$search;
			if(!empty($kwd))		$var	.= "&amp;kwd=".$kwd;
			if(!empty($cate))		$var	.= "&amp;cate=".$cate;
			if(!empty($code1))	$var	.= "&amp;code1=".$code1;
			if(!empty($code2))	$var	.= "&amp;code2=".$code2;
			if(!empty($code3))	$var	.= "&amp;code3=".$code3;
			
			return $var;
		}
		
		/**
		 * Common PagingCore
		 */
		function pagingCore($paging_result, $numofrecord, $page, $numofpage=10) {
			$paging[] = array();
			$paging['page']				= $page;
			$paging['total_record']		= $paging_result;						// 총레코드수
			$paging['numofrecord']	= $numofrecord ? $numofrecord : 10;		// 한페이지에 표시될 게시물 수
			$paging['numofpage']		= $numofpage;									// 페이지번호가 표시될 페이지 수
			$paging['startofrecord']	= $numofrecord * ($paging['page'] - 1);	// 첫번째레코드 포인터
			
			if(($page % $paging['numofpage']) == 0) {
				$startofpage = $paging['page'] - 1;
				$startofpage = floor($startofpage/$paging['numofpage']) * $paging['numofpage'] + 1;
			} else {				
				$startofpage = floor($paging['page'] / $paging['numofpage']) * $paging['numofpage'] + 1;	
			}
			
			$paging['startofpage']		= $startofpage;												// 페이지시작번호
			$paging['endofpage']		= $startofpage + $paging['numofpage'];				// 페이지끝번호
			$paging['realendofpage']	= ceil($paging['total_record'] / $paging['numofrecord']);	// 총레코드수에 의한 실제페이지끝번호
			
			return $paging;
		}

		function pagingCore2($paging_result, $numofrecord, $page) {
			$paging[] = array();
			$paging['page']				= $page;
			$paging['total_record']		= $paging_result;						// 총레코드수
			$paging['numofrecord']	= $numofrecord ? $numofrecord : 10;		// 한페이지에 표시될 게시물 수
			$paging['numofpage']		= 1;									// 페이지번호가 표시될 페이지 수
			$paging['startofrecord']	= $numofrecord * ($paging['page'] - 1);	// 첫번째레코드 포인터
			
			if(($page % $paging['numofpage']) == 0) {
				$startofpage = $paging['page'] - 1;
				$startofpage = floor($startofpage/$paging['numofpage']) * $paging['numofpage'] + 1;
			} else {				
				$startofpage = floor($paging['page'] / $paging['numofpage']) * $paging['numofpage'] + 1;	
			}
			
			$paging['startofpage']		= $startofpage;												// 페이지시작번호
			$paging['endofpage']		= $startofpage + $paging['numofpage'];				// 페이지끝번호
			$paging['realendofpage']	= ceil($paging['total_record'] / $paging['numofrecord']);	// 총레코드수에 의한 실제페이지끝번호
			
			return $paging;
		}

		
		// Common PagingUi
		function pagingUi($type, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes) {
			$rtn	= "";
			$id		= "";

			if($type == 1) {
				$rtn	.= '<div class="paginate1" style="clear:both;">';
				if($paging['startofpage'] > $paging['numofpage']) {
					$pagingvar = $this -> pagingVar(1, $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="bt_start"><em>처음페이지</em></a>';
				} else {
					$rtn .= '<span class="bt_start"><em>처음페이지</em></span>';
				}
			
				if($paging['startofpage'] > 1) {
					$pagingvar = $this -> pagingVar($paging['startofpage']-10, $search, $kwd, $cate, $no, $id, $scode, $codes);
			   		$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="bt_prev"><em>이전페이지</em></a>';
				} else {
					$rtn .= '<span class="bt_prev"><em>이전페이지</em></span>';
				}
			
				for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
					if($i == $paging['page']) {
						$rtn .= "<strong><a>".$i."</a></strong>";
					} else {
						$pagingvar = $this -> pagingVar($i, $search, $kwd, $cate, $no, $id, $scode, $codes);
						$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'">'.$i.'</a>';
					}
					if($i >= $paging['realendofpage']) break;
				}
			
				if($paging['endofpage'] <= $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['endofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
			   		$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="bt_next"><em>다음페이지</em></a>';
				} else {
					$rtn .= '<span class="bt_next"><em>다음페이지</em></span>';
				}
			
				if($paging['endofpage'] <= $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['realendofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
			   		$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="bt_end"><em>마지막페이지</em></a>';
				} else {
					$rtn .= '<span class="bt_end"><em>마지막페이지</em></span>';
				}
				$rtn	.= '</div>';
			} else if($type == 2) {
				$rtn	.= '<div class="paginate2">';
				if($paging['startofpage'] > 1) {
					$pagingvar = $this -> pagingVar($paging['startofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="pre">이전</a>';
				} else {
					$rtn .= '<span class="pres">이전</span>';
				}
			
				for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
					$pagingvar = $this -> pagingVar($i, $search, $kwd, $cate, $no, $id, $scode, $codes);
					if($i == $paging['page']) {
						$rtn .= "<strong>".$i."</strong>";
					} else {					
						$rtn .= "<a href=\"?menukey=".$menukey."&amp;mod=".$mod.$pagingvar."\">".$i."</a>";
					}
					if($i >= $paging['realendofpage']) break;
				}
			
				if($paging['endofpage'] <= $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['endofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="next">다음</a>';
				} else {
					$rtn .= '<a class="nexts" href="#">다음</a>';
				}
				$rtn	.= '</div>';

			// pagination (Bootstrap Type)
			} else if($type == 3) {
				if(!empty($menukey)) $var .= "menukey=".$menukey;
				if(!empty($mod)) $var .= "&mod=".$mod;
				
				$rtn	.= '<div class="pagination pagination-centered"><ul>';
				if($paging['startofpage'] > $paging['numofpage']) {
					$pagingvar = $this -> pagingVar(1, $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<li><a href="?'.$var.$pagingvar.'" title="처음페이지" class="Bootstrap_arrow">&laquo;</a></li>';
				} else {
					$rtn .= '<li class="disabled"><span class="Bootstrap_arrow">&laquo;</span></li>';
				}
						
					if($paging['startofpage'] > 1) {
						$pagingvar = $this -> pagingVar($paging['startofpage']-10, $search, $kwd, $cate, $no, $id, $scode, $codes);
						$rtn .= '<li><a href="?'.$var.$pagingvar.'" title="이전페이지" class="Bootstrap_arrow">&lsaquo;</a></li>';
					} else {
						$rtn .= '<li class="disabled"><span class="Bootstrap_arrow">&lsaquo;</span></li>';
					}
						
					for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
						if($i == $paging['page']) {
							$rtn .= '<li class="active"><span>'.$i.'</span></li>';
						} else {
							$pagingvar = $this -> pagingVar($i, $search, $kwd, $cate, $no, $id, $scode, $codes);
							$rtn .= '<li><a href="?'.$var.$pagingvar.'">'.$i.'</a></li>';
						}
						if($i >= $paging['realendofpage']) break;
					}
						
					if($paging['endofpage'] <= $paging['realendofpage']) {
						$pagingvar = $this -> pagingVar($paging['endofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
						$rtn .= '<li><a href="?'.$var.$pagingvar.'" title="다음페이지" class="Bootstrap_arrow">&rsaquo;</a></li>';
					} else {
						$rtn .= '<li class="disabled"><span class="Bootstrap_arrow">&rsaquo;</span></li>';
					}
						
					if($paging['endofpage'] <= $paging['realendofpage']) {
						$pagingvar = $this -> pagingVar($paging['realendofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
						$rtn .= '<li><a href="?'.$var.$pagingvar.'" title="마지막페이지" class="Bootstrap_arrow">&raquo;</a></li>';
					} else {
						$rtn .= '<li class="disabled"><span class="Bootstrap_arrow">&raquo</span></li>';
					}
					$rtn	.= '</ul></div>';

			//국악체험촌
			} else if($type == 4) {
				if(!empty($menukey)) $var .= "menukey=".$menukey;
				if(!empty($mod)) $var .= "&mod=".$mod;

				$rtn  = "<div class=\"sb_page\">";
				
				$rtn .= '<span class="bnt">';
				if($paging['startofpage'] > $paging['numofpage']) {
					$pagingvar = $this -> pagingVar(1, $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="처음페이지"><img src="/home/images/board/l2_off.gif" alt="게시물 처음페이지"></a>';
				} else {
					$rtn .= '<a href="#l2"><img src="/home/images/board/l2_off.gif" alt="게시물 처음페이지"></a>';
				}
				$rtn .= "</span>\r\n";

				$rtn .= '<span class="bnt">';						
				if($paging['startofpage'] > 1) {
					$pagingvar = $this -> pagingVar($paging['startofpage']-10, $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="이전페이지" class="Bootstrap_arrow"><img src="/home/images/board/l1_on.gif" alt="게시물 이전페이지"></a>';
				} else {
					$rtn .= '<a href="#l1"><img src="/home/images/board/l1_off.gif" alt="게시물 이전페이지"></a>';
				}
				$rtn .= "</span>\r\n";
					
				for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
					if($i == $paging['page']) {
						$rtn .= '<span class="no_on"><a href="#pp'.$i.'">'.$i."</a></span>\r\n";
					} else {
						$pagingvar = $this -> pagingVar($i, $search, $kwd, $cate, $no, $id, $scode, $codes);
						$rtn .= '<span class="no_off"><a href="?'.$var.$pagingvar.'">'.$i."</a></span>\r\n";
					}
					if($i >= $paging['realendofpage']) break;
				}
				
				$rtn .= '<span class="bnt">';
				if($paging['endofpage'] <= $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['endofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="다음페이지" class="Bootstrap_arrow"><img src="/home/images/board/r1_off.gif" alt="게시물 다음페이지"></a>';
				} else {
					$rtn .= '<a href="#r1"><img src="/home/images/board/r1_off.gif" alt="게시물 다음페이지"></a>';
				}
				$rtn .= "</span>\r\n";
				
				$rtn .= '<span class="bnt">';
				if($paging['endofpage'] <= $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['realendofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="마지막페이지" class="Bootstrap_arrow"><img src="/home/images/board/r2_off.gif" alt="게시물 마지막페이지"></a>';
				} else {
					$rtn .= '<a href="#r2"><img src="/home/images/board/r2_off.gif" alt="게시물 마지막페이지"></a>';
				}
				$rtn .= "</span>\r\n";

				$rtn .= "</div>";


				//모바일 페이징
				$rtn .= '<div class="m_sb_page"><ul>';
				$rtn .= '<li class="prev">';
					if($paging['page'] > 1) {
						$pagingvar = $this -> pagingVar($paging['page']-1, $search, $kwd, $cate, $no, $id, $scode, $codes);
						$rtn .= '<a href="?'.$var.$pagingvar.'">PREV</a></li>';
					} else {
						$rtn .= '<a href="#pre">PREV</a>';
					}				
				$rtn .= '</li>';
				$rtn .= '<li><strong title="현재페이지">'.$paging['page'].'</strong> / '.$paging['realendofpage'].'</li>';
				$rtn .= '<li class="next">';
					if($paging['page'] < $paging['realendofpage']) {
						$pagingvar = $this -> pagingVar($paging['page']+1, $search, $kwd, $cate, $no, $id, $scode, $codes);
						$rtn .= '<a href="?'.$var.$pagingvar.'">NEXT</a>';
					} else {
						$rtn .= '<a href="#nexx">NEXT</a>';
					}				
				$rtn .= '</li>';
				$rtn .= "</ul></div>";
			} else if($type == 5) { //new
				if(!empty($menukey)) $var .= "menukey=".$menukey;
				if(!empty($mod)) $var .= "&mod=".$mod;

				$rtn  = "<div class=\"bbs_paging\">";
				
				$rtn .= '<span class="page_prev">';
				if($paging['page'] > 1) {
					$pagingvar = $this -> pagingVar(1, $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="처음페이지" class="prev_end">게시물 처음페이지</a>';
				} else {
					$rtn .= '<a href="#l1" class="prev_end">게시물 처음페이지</a>';
				}
				if($paging['page'] > 1) {
					$pagingvar = $this -> pagingVar($paging['page']-1, $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="이전페이지" class="prev">이전페이지</a>';
				} else {
					$rtn .= '<a href="#l2" class="prev">게시물 이전페이지</a>';
				}

				$rtn .= "</span>";
				
				$rtn .= '<span class="page_num">';
				for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
					if($i == $paging['page']) {
						$rtn .= '<strong class="current">'.$i."</strong>";
					} else {
						$pagingvar = $this -> pagingVar($i, $search, $kwd, $cate, $no, $id, $scode, $codes);
						$rtn .= '<a href="?'.$var.$pagingvar.'">'.$i."</a>";
					}
					if($i >= $paging['realendofpage']) break;
				}
				$rtn .= "</span>";
				
				$rtn .= '<span class="page_next">';
				if($paging['page'] < $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['page']+1, $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="다음페이지" class="next">게시물 다음페이지</a>';
				} else {
					$rtn .= '<a href="#r1" class="next">게시물 다음페이지</a>';
				}
				//$rtn .= "</span>";
				
				//$rtn .= '<span class="bnt">';
				if($paging['page'] < $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['realendofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="마지막페이지" class="next_end">게시물 마지막페이지</a>';
				} else {
					$rtn .= '<a href="#r2" class="next_end">게시물 마지막페이지</a>';
				}
				$rtn .= "</span>";

				$rtn .= "</div>";
			} else if($type == 6) { //new2021
				if(!empty($menukey)) $var .= "menukey=".$menukey;
				if(!empty($mod)) $var .= "&mod=".$mod;

				$rtn  = "<div class=\"board-bottom\" data-aos=\"fade-up\">";
				
				$rtn .= '<div class="board-page-btn">';
				if($paging['page'] > 1) {
					$pagingvar = $this -> pagingVar(1, $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="처음페이지" class="prev_end"><img src="images/common/board/board-front.png" alt="처음으로"></a>';
				} else {
					$rtn .= '<a href="#l1" class="prev_end"><img src="images/common/board/board-front.png" alt="처음으로"></a>';
				}
				if($paging['page'] > 1) {
					$pagingvar = $this -> pagingVar($paging['page']-1, $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="이전페이지" class="prev"><img src="images/common/board/board-prev.png" alt="이전"></a>';
				} else {
					$rtn .= '<a href="#l2" class="prev"><img src="images/common/board/board-prev.png" alt="이전"></a>';
				}

				$rtn .= "</div>";
				
				$rtn .= '<ul class="board-pagelist">';
				for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
					if($i == $paging['page']) {
						$rtn .= '<li class="on"><a href="#none">'.$i."</a></li>";
					} else {
						$pagingvar = $this -> pagingVar($i, $search, $kwd, $cate, $no, $id, $scode, $codes);
						$rtn .= '<li><a href="?'.$var.$pagingvar.'">'.$i."</a></li>";
					}
					if($i >= $paging['realendofpage']) break;
				}
				$rtn .= "</ul>";
				
				$rtn .= '<div class="board-page-btn">';
				if($paging['page'] < $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['page']+1, $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="다음페이지" class="next"><img src="images/common/board/board-next.png" alt="다음"></a>';
				} else {
					$rtn .= '<a href="#r1" class="next"><img src="images/common/board/board-next.png" alt="다음"></a>';
				}
				if($paging['page'] < $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['realendofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
					$rtn .= '<a href="?'.$var.$pagingvar.'" title="마지막페이지" class="next_end"><img src="images/common/board/board-end.png" alt="끝으로"></a>';
				} else {
					$rtn .= '<a href="#r2" class="next_end"><img src="images/common/board/board-end.png" alt="끝으로"></a>';
				}
				$rtn .= "</div>";

				$rtn .= "</div>";
			}
			return $rtn;			
		}

		/**
		 * Common PagingUi Type 2
		 */
		function pagingBrdUi2($paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3) {
			$rtn	= "";
			$id		= "";
			
			if($paging['startofpage'] > $paging['numofpage']) {
				$pagingvar = $this -> pagingVar(1, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3);
				$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="bt_start"><img alt="처음페이지" src="/base/imgs/board/page_first.gif" /></a>&nbsp;';
			} else {
				$rtn .= '<img alt="처음페이지" src="/base/imgs/board/page_first.gif" />&nbsp;';
			}
		
			if($paging['startofpage'] > 1) {
				$pagingvar = $this -> pagingVar($paging['startofpage']-10, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3);
				$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="bt_prev"><img alt="이전페이지" src="/base/imgs/board/page_prev.gif" /></a>&nbsp;';
			} else {
				$rtn .= '<img alt="이전페이지" src="/base/imgs/board/page_prev.gif" />&nbsp;';
			}
		
			for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
				$pagingvar = $this -> pagingVar($i, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3);
				if($i == $paging['page']) {
					$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="page_a"><strong>'.$i.'</strong></a>';
				} else {					
					$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="page_a">'.$i.'</a>';
				}
				if($i >= $paging['realendofpage']) break;
			}
		
			if($paging['endofpage'] <= $paging['realendofpage']) {
				$pagingvar = $this -> pagingVar($paging['endofpage'], $search, $kwd, $cate, $no, $id, $code1, $code2, $code3);
				$rtn .= '&nbsp;<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'"><img alt="다음페이지" src="/base/imgs/board/page_next.gif" /></a>';
			} else {
				$rtn .= '&nbsp;<img alt="다음페이지" src="/base/imgs/board/page_next.gif" />';
			}
		
			if($paging['endofpage'] <= $paging['realendofpage']) {
				$pagingvar = $this -> pagingVar($paging['realendofpage'], $search, $kwd, $cate, $no, $id, $code1, $code2, $code3);
				$rtn .= '&nbsp;<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'"><img alt="마지막페이지" src="/base/imgs/board/page_last.gif" /></a>';
			} else {
				$rtn .= '&nbsp;<img alt="마지막페이지" src="/base/imgs/board/page_last.gif" />';
			}

			return $rtn;			
		}

		//네이버 검색 페이징
		function pagingUi_search($paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3) {
			$rtn	= "";
			$id		= "";
			
			if($paging['startofpage'] > $paging['numofpage']) {
				$pagingvar = $this -> pagingVar_search(1, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3);
				$rtn .= '<li><a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'"  data-ajax="false" ><img alt="처음페이지" src="/base/imgs/board/page_first.gif" /></a></li>&nbsp;';
			} else {
				$rtn .= '<li><a href="#this"><img alt="처음페이지" src="/base/imgs/board/page_first.gif" /></a></li>&nbsp;';
			}
		
			if($paging['startofpage'] > 1) {
				$pagingvar = $this -> pagingVar_search($paging['startofpage']-10, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3);
				$rtn .= '<li><a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" data-ajax="false" ><img alt="이전페이지" src="/base/imgs/board/page_prev.gif" /></a></li>&nbsp;';
			} else {
				$rtn .= '<li><img alt="이전페이지" src="/base/imgs/board/page_prev.gif" /></li>&nbsp;';
			}
		
			for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
				$pagingvar = $this -> pagingVar_search($i, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3);
				if($i == $paging['page']) {
					$rtn .= '<li><a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="page_a" data-ajax="false"><strong>'.$i.'</strong></a></li>';
				} else {					
					$rtn .= '<li><a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="page_a" data-ajax="false">'.$i.'</a></li>';
				}
				if($i >= $paging['realendofpage']) break;
			}
		
			if($paging['endofpage'] <= $paging['realendofpage']) {
				$pagingvar = $this -> pagingVar_search($paging['endofpage'], $search, $kwd, $cate, $no, $id, $code1, $code2, $code3);
				$rtn .= '&nbsp;<li><a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" data-ajax="false"><img alt="다음페이지" src="/base/imgs/board/page_next.gif" /></a></li>';
			} else {
				$rtn .= '&nbsp;<li><img alt="다음페이지" src="/base/imgs/board/page_next.gif" /></li>';
			}
		
			if($paging['endofpage'] <= $paging['realendofpage']) {
				$pagingvar = $this -> pagingVar_search($paging['realendofpage'], $search, $kwd, $cate, $no, $id, $code1, $code2, $code3);
				$rtn .= '&nbsp;<li><a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" data-ajax="false"><img alt="마지막페이지" src="/base/imgs/board/page_last.gif" /></a></li>';
			} else {
				$rtn .= '&nbsp;<li><a href="#this"><img alt="마지막페이지" src="/base/imgs/board/page_last.gif" /></a></li>';
			}

			return $rtn;			
		}

		/**
		 * comment PagingUi
		 */
		function pagingCommentUi($paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3, $pagep) {
			$rtn	= "";
			$id		= "";
			
			if($paging['startofpage'] > $paging['numofpage']) {
				$pagingvar = $this -> pagingVarC(1, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3, $pagep);
				$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="bt_start"><img alt="처음페이지" src="/base/imgs/board/page_first.gif" /></a>&nbsp;';
			} else {
				$rtn .= '<img alt="처음페이지" src="/base/imgs/board/page_first.gif" />&nbsp;';
			}
		
			if($paging['startofpage'] > 1) {
				$pagingvar = $this -> pagingVarC($paging['startofpage']-10, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3, $pagep);
				$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="bt_prev"><img alt="이전페이지" src="/base/imgs/board/page_prev.gif" /></a>&nbsp;';
			} else {
				$rtn .= '<img alt="이전페이지" src="/base/imgs/board/page_prev.gif" />&nbsp;';
			}
		
			for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
				$pagingvar = $this -> pagingVarC($i, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3, $pagep);
				if($i == $paging['page']) {
					$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="page_a"><strong>'.$i.'</strong></a>';
				} else {					
					$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="page_a">'.$i.'</a>';
				}
				if($i >= $paging['realendofpage']) break;
			}
		
			if($paging['endofpage'] <= $paging['realendofpage']) {
				$pagingvar = $this -> pagingVarC($paging['endofpage'], $search, $kwd, $cate, $no, $id, $code1, $code2, $code3, $pagep);
				$rtn .= '&nbsp;<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'"><img alt="다음페이지" src="/base/imgs/board/page_next.gif" /></a>';
			} else {
				$rtn .= '&nbsp;<img alt="다음페이지" src="/base/imgs/board/page_next.gif" />';
			}
		
			if($paging['endofpage'] <= $paging['realendofpage']) {
				$pagingvar = $this -> pagingVarC($paging['realendofpage'], $search, $kwd, $cate, $no, $id, $code1, $code2, $code3, $pagep);
				$rtn .= '&nbsp;<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'"><img alt="마지막페이지" src="/base/imgs/board/page_last.gif" /></a>';
			} else {
				$rtn .= '&nbsp;<img alt="마지막페이지" src="/base/imgs/board/page_last.gif" />';
			}

			return $rtn;			
		}



		// Common PagingUi
		function pagingUi_np($type, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes) {
			$rtn	= "";
			$id		= "";

			if($type == 1) {
			

				if($paging['startofpage'] > 1) {
					$pagingvar = $this -> pagingVar($paging['startofpage']-1, $search, $kwd, $cate, $no, $id, $scode, $codes);
			   		$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="bt1"><img src="imgs/contents/04_bt1.gif" alt="왼쪽으로 넘김" /></a>';
				} else {
					$rtn .= '<a href="#" class="bt1"><img src="imgs/contents/04_bt1.gif" alt="왼쪽으로 넘김" /></a>';
				}
			
				/*
				for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
					if($i == $paging['page']) {
						$rtn .= "<strong><a>".$i."</a></strong>";
					} else {
						$pagingvar = $this -> pagingVar($i, $search, $kwd, $cate, $no, $id, $scode, $codes);
						$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'">'.$i.'</a>';
					}
					if($i >= $paging['realendofpage']) break;
				}
				*/
			
				if($paging['endofpage'] <= $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['endofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
			   		$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" ><img src="imgs/contents/04_bt2.gif" alt="오른쪽으로넘김" /></a>';
				} else {
					$rtn .= '<a href="#"><img src="imgs/contents/04_bt2.gif" alt="오른쪽으로넘김" /></a>';
				}
			
				/*
				if($paging['endofpage'] <= $paging['realendofpage']) {
					$pagingvar = $this -> pagingVar($paging['realendofpage'], $search, $kwd, $cate, $no, $id, $scode, $codes);
			   		$rtn .= '<a href="?menukey='.$menukey.'&amp;mod='.$mod.$pagingvar.'" class="bt_end"><em>마지막페이지</em></a>';
				} else {
					$rtn .= '<span class="bt_end"><em>마지막페이지</em></span>';
				}
				$rtn	.= '</div>';
				*/

			}

			return $rtn;			
		}




	}
?>