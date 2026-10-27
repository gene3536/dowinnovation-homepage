<?php
	class searchClass extends pagingClass  {

		/** 공통검색박스 */
		 function searchBoxType1($menukey, $mod, $search, $kwd) {
			$searchBox = "";
			$searchBox .= '<form name="search" method="get" action="sub.php">';
			$searchBox .= '		<input type="hidden" name="menukey" title="hidden" value="'.$menukey.'" />';
			$searchBox .= '		<input type="hidden" name="mod" title="hidden" value="'.$mod.'" />';
			$searchBox .= '		<select name="search" class="selline" title="검색조건" style="width:120px">';
			$searchBox .= '			<option value="1"';
				if($search == 1) {
					$searchBox .= ' selected="selected" ';
				} 
			$searchBox .= '			>제목+내용</option>';
			$searchBox .= '			<option value="2"';
				if($search == 2) {
					$searchBox .= ' selected=selected ';
				} 
			$searchBox .= '			>제목</option>';
			$searchBox .= '			<option value="3"';
				if($search == 3) {
					$searchBox .= ' selected=selected ';
				} 
			$searchBox .= '			>이름</option>';
			
			$searchBox .= '		</select>';
			$searchBox .= '		<input type="text" name="kwd" title="검색어입력" class="inpline" maxlength="20" value="'.$kwd.'" />';
			$searchBox .= '		<span class="btnPack mediumB" style="vertical-align:middle">';
			$searchBox .= '			<input value="검색" type="submit" />';
			$searchBox .= '		</span>';
			$searchBox .= '</form>';
			return $searchBox;
		}

		/** 검색박스 */
		function searchBoxType2($search, $kwd) {
			$search = $search ? $search : 1;			
			$searchBox = '
				<input type="hidden" name="search" title="hidden" value="'.$search.'" />
				<input type="text" name="kwd" title="검색어입력" class="inpline" style="width:140px;" maxlength="20" value="'.$kwd.'" />
				<button type="submit" class="btn_big"><span>검색</span></button>';
			return $searchBox;
		}
		
		// 단독유형 검색박스
		function searchBoxType3($menukey, $mod, $scode, $search, $kwd) {
			$search = $search ? $search : 1;						
			$searchBox = '
				<form name="search" method="get" action="sub.php">
					<input type="hidden" name="menukey" title="hidden" value="'.$menukey.'" />
					<input type="hidden" name="mod" title="hidden" value="'.$mod.'" />
					<input type="hidden" name="scode" title="hidden" value="'.$scode.'" />
					<input type="hidden" name="search" title="hidden" value="'.$search.'" />
					<input type="text" name="kwd" title="검색어입력" class="inpline" style="width:140px;" maxlength="20" value="'.$kwd.'" />
					<button type="submit" class="btn_big"><span>검색</span></button>
				</form>';
			return $searchBox;
		}
		
		// 게시판용 서치박스
		function searchBoxType4_1($menukey, $mod, $scode, $search, $kwd, $cateList, $code1, $code2) {
			if($search == 9) $searchSel9 = ' selected="selected" ';
			if($search == 1) $searchSel1 = ' selected="selected" ';
			if($search == 2) $searchSel2 = ' selected="selected" ';
			if($search == 3) $searchSel3 = ' selected="selected" ';
			$searchBox = '
			<form name="search" method="get" action="sub.php">
				<input type="hidden" name="menukey" title="hidden" value="'.$menukey.'" />
				<input type="hidden" name="mod" title="hidden" value="'.$mod.'" />
				<input type="hidden" name="scode" title="hidden" value="'.$scode.'" />
				<input type="hidden" name="code1" title="hidden" value="'.$code1.'" />
				<input type="hidden" name="code2" title="hidden" value="'.$code2.'" />
				'.$cateList.'
				<select name="search" class="selline" title="검색조건" style="width:120px">
					<option value="9"'.$searchSel9.'>전체</option>
					<option value="1"'.$searchSel1.'>제목</option>
					<option value="2"'.$searchSel2.'>내용</option>
					<option value="3"'.$searchSel3.'>작성자</option>
				</select>
				<input type="text" name="kwd" title="검색어입력" class="inpline" style="width:140px;" maxlength="20" value="'.$kwd.'" />
				<button type="submit" class="btn_big"><span>검색</span></button>
			</form>';
			return $searchBox;
		}

		// 게시판용 서치박스 (연도검색)
		function searchBoxType4_2($menukey, $mod, $scode, $search, $kwd, $cateList, $code1, $code2, $syear) {
			for($y = date("Y"); $y > $syear; $y--) {
				if($kwd == $y) {
					$searchSel1 .= '<option value="'.$y.'" selected="selected">'.$y.'년</option>';
				} else {
					$searchSel1 .= '<option value="'.$y.'">'.$y.'년</option>';
				}
			}
		
			$searchBox = '
				<form name="search" method="get" action="sub.php">
					<input type="hidden" name="menukey" title="hidden" value="'.$menukey.'" />
					<input type="hidden" name="mod" title="hidden" value="'.$mod.'" />
					<input type="hidden" name="scode" title="hidden" value="'.$scode.'" />
					<input type="hidden" name="code1" title="hidden" value="'.$code1.'" />
					<input type="hidden" name="code2" title="hidden" value="'.$code2.'" />
					<input type="hidden" name="search" title="hidden" value="5" />
					'.$cateList.'
					<select name="kwd" class="selline" title="검색조건" style="width:120px;" onchange="submit();"><option value="">전체년도</option>'.$searchSel1.'</select>
					<button type="submit" class="btn_big"><span>검색</span></button>
				</form>';
			return $searchBox;
		}

		// 게시판용 서치박스
		function searchBoxType4_3($menukey, $mod, $scode, $search, $kwd, $code1="", $code2="") {
			if($search == 9) $searchSel9 = ' selected="selected" ';
			if($search == 1) $searchSel1 = ' selected="selected" ';
			if($search == 3) $searchSel3 = ' selected="selected" ';
			$searchBox = '
			<form name="search" method="get" action="sub.php">
				<input type="hidden" name="menukey" title="hidden" value="'.$menukey.'" />
				<input type="hidden" name="mod" title="hidden" value="'.$mod.'" />
				<input type="hidden" name="scode" title="hidden" value="'.$scode.'" />
				<input type="hidden" name="code1" title="hidden" value="'.$code1.'" />
				<input type="hidden" name="code2" title="hidden" value="'.$code2.'" />
				'.$cateList.'
				<select name="search" class="selline" title="검색조건" style="width:120px">
					<option value="9"'.$searchSel9.'>전체</option>
					<option value="1"'.$searchSel1.'>제목</option>
					<option value="3"'.$searchSel3.'>작성자</option>
				</select>
				<input type="text" name="kwd" title="검색어입력" class="inpline" style="width:140px;" maxlength="20" value="'.$kwd.'" />
				<button type="submit" class="btn_big"><span>검색</span></button>
			</form>';
			return $searchBox;
		}
		// 게시판용 서치박스 
		function searchBoxType6($menukey, $mod, $scode, $search, $kwd, $code1="", $code2="") {
			if($search == 9) $searchSel9 = ' selected="selected" ';
			if($search == 1) $searchSel1 = ' selected="selected" ';
			if($search == 3) $searchSel3 = ' selected="selected" ';
			$searchBox = "
			<form name=\"search\" id=\"searchForm\" method=\"get\" action=\"sub.php\">
				<fieldset>
					<input type=\"hidden\" name=\"menukey\" title=\"hidden\" value=\"".$menukey."\" />
					<input type=\"hidden\" name=\"mod\" title=\"hidden\" value=\"".$mod."\" />
					<input type=\"hidden\" name=\"scode\" title=\"hidden\" value=\"".$scode."\" />
					<input type=\"hidden\" name=\"code1\" title=\"hidden\" value=\"".$code1."\" />
					<input type=\"hidden\" name=\"code2\" title=\"hidden\" value=\"".$code2."\" />
					".$cateList."	
					<select name=\"search\" title=\"검색조건\">
						<option value=\"9\"".$searchSel9.">전체</option>
						<option value=\"1\"".$searchSel1.">제목</option>
						<option value=\"3\"".$searchSel3.">작성자</option>
					</select>
					<input type=\"text\" name=\"kwd\" title=\"검색어입력\" class=\"sbs_ip\" maxlength=\"20\" value=\"".$kwd."\" />
					<a href=\"#search11\" onclick=\"document.getElementById('searchForm').submit();\" class=\"sbs_btn\">검색</a>
				</fieldset>
			</form>";
			return $searchBox;
		}

		// 게시판용 서치박스 
		function searchBoxType7($menukey, $mod, $scode, $search, $kwd, $code1="", $code2="") {
			if($search == 9) $searchSel9 = ' selected="selected" ';
			if($search == 1) $searchSel1 = ' selected="selected" ';
			if($search == 3) $searchSel3 = ' selected="selected" ';
			$searchBox = "
			<form name=\"search\" id=\"searchForm\" method=\"get\" action=\"sub.php\">
				<fieldset>
					<input type=\"hidden\" name=\"menukey\" title=\"hidden\" value=\"".$menukey."\" />
					<input type=\"hidden\" name=\"mod\" title=\"hidden\" value=\"".$mod."\" />
					<input type=\"hidden\" name=\"scode\" title=\"hidden\" value=\"".$scode."\" />
					<input type=\"hidden\" name=\"code1\" title=\"hidden\" value=\"".$code1."\" />
					<input type=\"hidden\" name=\"code2\" title=\"hidden\" value=\"".$code2."\" />
					".$cateList."	
					<select name=\"search\" title=\"검색조건\">
						<option value=\"9\"".$searchSel9.">Subject+Contents</option>
						<option value=\"1\"".$searchSel1.">Subject</option>
						<option value=\"3\"".$searchSel3.">Written by</option>
					</select>
					<input type=\"text\" name=\"kwd\" title=\"검색어입력\" class=\"sbs_ip\" maxlength=\"20\" value=\"".$kwd."\" />
					<a href=\"#search11\" onclick=\"document.getElementById('searchForm').submit();\" class=\"sbs_btn\">Search</a>
				</fieldset>
			</form>";
			return $searchBox;
		}
		// new 게시판용 서치박스 
		function new_searchBoxType6($menukey, $mod, $scode, $search, $kwd, $code1="", $code2="") {
			if($search == 9) $searchSel9 = ' selected="selected" ';
			if($search == 1) $searchSel1 = ' selected="selected" ';
			if($search == 3) $searchSel3 = ' selected="selected" ';
			switch(site_config_path){
				case "/eng":
					$serc9 = "Total";
					$serc1 = "Title";
					$serc3 = "Writer";
					$placeHolder = "Input search words";
					break;
		
				case "/chn":
					$serc9 = "全体";
					$serc1 = "题目";
					$serc3 = "作成者";
					$placeHolder = "检索语输入";
					break;
		
				default:
					$serc9 = "전체";
					$serc1 = "제목";
					$serc3 = "작성자";
					$placeHolder = "검색어입력";
					break;
			}
			$searchBox = "
			<form name=\"search\" id=\"searchForm\" method=\"get\" action=\"sub.php\">
				<fieldset>
					<input type=\"hidden\" name=\"menukey\" title=\"hidden\" value=\"".$menukey."\" />
					<input type=\"hidden\" name=\"mod\" title=\"hidden\" value=\"".$mod."\" />
					<input type=\"hidden\" name=\"scode\" title=\"hidden\" value=\"".$scode."\" />
					<input type=\"hidden\" name=\"code1\" title=\"hidden\" value=\"".$code1."\" />
					<input type=\"hidden\" name=\"code2\" title=\"hidden\" value=\"".$code2."\" />
					".$cateList."	
					<select name=\"search\" title=\"검색조건\">
						<option value=\"9\"".$searchSel9.">".$serc9."</option>
						<option value=\"1\"".$searchSel1.">".$serc1."</option>
						<option value=\"3\"".$searchSel3.">".$serc3."</option>
					</select>
					<input type=\"text\" name=\"kwd\" title=\"검색어입력\" placeholder=\"".$placeHolder."\" class=\"sbs_ip\" maxlength=\"20\" value=\"".$kwd."\" />
					<!-- <a href=\"#search11\" onclick=\"document.getElementById('searchForm').submit();\" class=\"bbs_searchBtn\">검색</a> -->
					<button class=\"bbs_searchBtn\"><span class=\"skip\"></span></button>
				</fieldset>
			</form>";
			return $searchBox;
		}

		// new 게시판용 서치박스 
		function searchBoxType2021($menukey, $mod, $scode, $search, $kwd, $code1="", $code2="") {
			if($search == 9) $searchSel9 = ' selected="selected" ';
			if($search == 1) $searchSel1 = ' selected="selected" ';
			if($search == 3) $searchSel3 = ' selected="selected" ';
			switch(site_config_path){
				case "/eng":
					$serc9 = "Total";
					$serc1 = "Title";
					$serc3 = "Writer";
					$placeHolder = "Input search words";
					$searchs = "Search";
					break;
		
				case "/chn":
					$serc9 = "全体";
					$serc1 = "题目";
					$serc3 = "作成者";
					$placeHolder = "检索语输入";
					$searchs = "搜寻要求";
					break;

				case "/jpn":
					$serc9 = "全体";
					$serc1 = "题目";
					$serc3 = "作成者";
					$placeHolder = "检索语输入";
					$searchs = "検索条件";
					break;
		
				default:
					$serc9 = "전체";
					$serc1 = "제목";
					$serc3 = "작성자";
					$placeHolder = "검색어입력";
					$searchs = "검색조건";
					break;
			}
			$searchBox = "
			<form name=\"search\" id=\"searchForm\" method=\"get\" action=\"sub.php\">
				<fieldset>
					<input type=\"hidden\" name=\"menukey\" title=\"hidden\" value=\"".$menukey."\" />
					<input type=\"hidden\" name=\"mod\" title=\"hidden\" value=\"".$mod."\" />
					<input type=\"hidden\" name=\"scode\" title=\"hidden\" value=\"".$scode."\" />
					<input type=\"hidden\" name=\"code1\" title=\"hidden\" value=\"".$code1."\" />
					<input type=\"hidden\" name=\"code2\" title=\"hidden\" value=\"".$code2."\" />
					".$cateList."	
					<div class=\"search-select\">
						<label for=\"select\" class=\"select-label\">".$searchs."</label>
						<select name=\"search\" id=\"select\" class=\"base-select\">
							<option value=\"9\"".$searchSel9.">".$serc9."</option>
							<option value=\"1\"".$searchSel1.">".$serc1."</option>
							<option value=\"3\"".$searchSel3.">".$serc3."</option>
						</select>
					</div>
					<div class=\"search-kwd\">
						<label for=\"kwd\">검색어입력</label>
						<input type=\"text\" name=\"kwd\" id=\"kwd\" placeholder=\"".$placeHolder."\" maxlength=\"20\" value=\"".$kwd."\" />
						<button class=\"search-btn\"><img src=\"images/common/board/board-search.png\" alt=\"검색\"></button>
					</div>
				</fieldset>
			</form>";
			return $searchBox;
		}
	}
?>