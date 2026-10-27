<script type="text/javascript">
$(document).ready(function(){
	$("#searchSubmit").on("click",function(){
		if($.trim($('#searchKwd').val()) == ''){
			alert("Please enter Searches.");
			$('#searchKwd').focus();
			return ;
		}else{
			$("#searchForm").submit();
		}
	});
});
</script>

<div class="sc01">
	<div class="sc_search_w">
		<!-- 검색 -->
		<div class="sc_st">
			<form name="searchForm" id="searchForm" action="sub.php" method="get">
			<input type="hidden" name="menukey" value="<?php echo $menukey?>">
				<fieldset>
					<legend class="hiddenTxt">Search</legend> 
					<input type="text" name="kwd" id="searchKwd" class="sbs_ip" value="<?php echo $kwd?>" title="검색어입력" placeholder="Please enter Searches.">
					<p><a href="#submit" id="searchSubmit" class="sbs_btn">Search</a></p>
				</fieldset>
			</form>
		</div>
		<!-- //검색// -->

		<!-- 리스트 -->
		<div class="search_list_w">

			<?php
				$numofrecord	= 15;

				// 출력개수
				if(empty($code1)) {
					$snum = 0;
					$rnum = 5;
				} else {
					$snum = 0;
					$rnum = $numofrecord;
				}
				
				// 메뉴명 검색결과
				if(!empty($kwd)) {
					$where3  = "WHERE menu_title LIKE '%".$kwd."%'";
					$where3 .= " AND menu_visible = 'Y' AND menu_access = 'Y' AND menu_level = 10";

					// 페이징 설정
					$rsCnt = $coreClass -> selectQueryCount(tbl_menu, $where3);
					$tCnt = $tCnt + $rsCnt;

					$paging			= $coreClass -> pagingCore($rsCnt, $numofrecord, $code1);
					$snum			= $paging['startofrecord'];
					$rnum			= $paging['numofrecord'];


				}

				echo "<h4>Menu <span>Search Result : ".number_format($rsCnt)."</span></h4>";
				echo "<ul class=\"search_list\">";
					
					if($rsCnt >0) {
						$rs3 = $coreClass -> selectQuery(tbl_menu, $where3, "", $snum, $rnum);
						while($row = $coreClass -> selectFetchArray($rs3)) { 

							$thisLocation = $menuClass->getMenuLocation($row['MENU_MENUKEY']); 
							$thisHref = $menuClass->get_menu_link($thisLocation['row']);

							echo '<li><a href="'.$thisHref['href'].'" target="_blank">Home > '.$thisLocation['str'].'</li>';
						}
					}else{
						echo '<li>No search result.</li>';

						$paging['startofpage'] = 1;
						$paging['endofpage']   = 2;
						$paging['page']        = 1;
					}

				echo "</ul>";

				// 페이징 UI	
				$codes = $code1."^".$code2."^".$code3."^1";				
				echo $coreClass -> pagingUi(4, $paging, $menukey, null, $code1, $search, $kwd, $cate, $no, $id, $scode, $codes);	
				
				// 1. 콘텐츠 검색결과
				if(!empty($kwd)) {
					$where1 = "LEFT JOIN ".tbl_cms_icd." ON icd_id = menu_content WHERE 1=1";
					$where1 .= " AND menu_visible = 'Y' AND menu_access = 'Y' AND menu_level = 10";
					$where1 .= " AND (menu_type = 3)";
					$where1 .= " AND icd_content LIKE '%".$kwd."%'";
							
					// 페이징 설정
					$rsCnt = $coreClass -> selectQueryCount(tbl_menu, $where1);
					$tCnt = $tCnt + $rsCnt;

					$paging	= $coreClass -> pagingCore($rsCnt, $numofrecord, $code2);
					$snum	= $paging['startofrecord'];
					$rnum		= $paging['numofrecord'];


				}

				echo "<h4>Web Page <span>Search Result : ".number_format($rsCnt)."</span></h4>";
				echo "<div class=\"search_list02\">";
					
					if($rsCnt > 0) {
						
						$rs1 = $coreClass -> selectQuery(tbl_menu, $where1, "", $snum, $rnum);
						while($row = $coreClass -> selectFetchArray($rs1)) { 

							$locationStr = "";

							$mQry1 = "WHERE menu_root='".$row['MENU_ROOT']."' AND menu_visible='Y' AND menu_depth='1' AND menu_scode='".site_config_code."' ";
							$mRow1 = $coreClass -> selectQueryArray(tbl_menu, $mQry1, "", "", "");
							$locationStr .= $mRow1['MENU_TITLE']." > ";
							
							if($row['MENU_DEPTH'] == 3){
								$mQry2 = "WHERE menu_menukey='".$row['MENU_REF']."' AND menu_visible='Y' AND menu_depth='2' AND menu_scode='".site_config_code."' ";
								$mRow2 = $coreClass -> selectQueryArray(tbl_menu, $mQry2, "", "", "");
								$locationStr .= $mRow2['MENU_TITLE']." > ".$row['MENU_TITLE'];
							}else{
								$locationStr .= $row['MENU_TITLE'];
							}

							$where = " WHERE cms_info_code = '".$row['MENU_SCODE']."'";		
							$rows = $coreClass -> selectQueryArray(tbl_cms_info, $where, "", "", "");
							if(!empty($row['ICD_CONTENT'])) {
								$contents = $coreClass -> getSub2Str(400, strip_tags($row['ICD_CONTENT']));
							}
							if(!empty($kwd)) {
								$contents = preg_replace('/'.$kwd.'/', '<span style="font-weight:bold; background-color:#ff0;">'.$kwd.'</span>', $contents);
							}
							
							echo '
							<dl>
								<dt><a href="http://'.$rows['CMS_INFO_URL1'].$rows['CMS_INFO_PATH'].'/sub.php?menukey='.$row['MENU_MENUKEY'].'" target="_blank">Home > '.$locationStr.'</a></dt>
								<dd>'.$contents.'</dd>
							</dl>
							';
						}
					}else{
						echo '
							<dl>
								<dt><a href="#null">No search result.</a></dt>
							</dl>
						';

						$paging['startofpage'] = 1;
						$paging['endofpage']   = 2;
						$paging['page']        = 1;
					}

				echo "</div>";

				// 페이징 UI
				$codes = $code1."^".$code2."^".$code3."^2";	
				echo $coreClass -> pagingUi(4, $paging, $menukey, null, $code2, $search, $kwd, $cate, $no, $id, $scode, $codes);
				
				// 2. 게시글 검색결과
				if(!empty($kwd)) {
					$query1 = "SELECT count(*) FROM ".tbl_board_data;
					$query2 = "SELECT BRDATA_NO, BRDATA_BID, BRDATA_SUBJECT, BRDATA_CONTENT, BRDATA_REGDATE, MENU_SCODE, MENU_MENUKEY, MENU_TITLE FROM ".tbl_board_data;
					$query3 .= " LEFT JOIN ".tbl_menu." ON menu_board = brdata_bid LEFT JOIN ".tbl_board." ON board_id = brdata_bid";
					$query3 .= " WHERE menu_visible = 'Y' AND menu_access = 'Y' AND menu_level = 10 AND menu_type = 4";
					$query3 .= " AND brdata_privacy = 'N' AND brdata_deleted = 'N' AND board_lv_view = 10";
					$query3 .= " AND (menu_title LIKE '%".$kwd."%' OR brdata_subject LIKE '%".$kwd."%' OR brdata_content LIKE '%".$kwd."%')";
					$query3 .= " ORDER BY brdata_regdate DESC";

					// 페이징 설정
					$query = $query1.$query3;
					$rsCnt = $coreClass -> executeQueryCount($query);
					$tCnt = $tCnt + $rsCnt;

					$paging			= $coreClass -> pagingCore($rsCnt, $numofrecord, $code3);
					$snum			= $paging['startofrecord'];
					$rnum			= $paging['numofrecord'];

				}

				echo "<h4>Post <span>Search Result : ".number_format($rsCnt)."</span></h4>";
				echo "<div class=\"search_list02\">";
					
					if($rsCnt > 0) { 	
						
						$query = $query2.$query3; 
						$rs2 = $coreClass -> executeQuerySelect($query, $snum, $rnum);
						while($row = $coreClass -> selectFetchArray($rs2)) {
							$where = " WHERE cms_info_code = '".$row['MENU_SCODE']."'";
							$rows = $coreClass -> selectQueryArray(tbl_cms_info, $where, "", "", "");
							if(!empty($row['BRDATA_CONTENT'])) {
								$contents = $coreClass -> getSub2Str(400, strip_tags($row['BRDATA_CONTENT']));
							}
							if(!empty($row['BRDATA_SUBJECT'])) {
								$subject = $coreClass -> getSub2Str(40, strip_tags($row['BRDATA_SUBJECT']));
							}
							if(!empty($kwd)) {
								$contents = preg_replace('/'.$kwd.'/', '<span style="font-weight:bold; background-color:#ff0;">'.$kwd.'</span>', $contents);
								$subject  = preg_replace('/'.$kwd.'/', '<span style="font-weight:bold; background-color:#ff0;">'.$kwd.'</span>', $subject);
							}
							$brdRow  = $coreClass->selectQueryArray(tbl_board, "WHERE board_id='".$row['BRDATA_BID']."'", "", "", ""); 
								
							echo '
							<dl>
								<dt><a href="http://'.$rows['CMS_INFO_URL1'].$rows['CMS_INFO_PATH'].'/sub.php?menukey='.$row['MENU_MENUKEY'].'&amp;mod=view&amp;no='.$row['BRDATA_NO'].'" target="_blank">['.$brdRow['BOARD_NAME'].'] '.$subject.' <span class="date">'.date("Y.m.d",strtotime($row['BRDATA_REGDATE'])).'</span></a></dt>
								<dd>'.$contents.'</dd>
							</dl>
							';
						}
					}else{
						echo '
							<dl>
								<dt><a href="#null">No search result.</a></dt>
							</dl>
						';

						$paging['startofpage'] = 1;
						$paging['endofpage']   = 2;
						$paging['page']        = 1;
					}

				echo "</div>";

				// 페이징 UI
				$codes = $code1."^".$code2."^".$code3."^3";	
				echo $coreClass -> pagingUi(4, $paging, $menukey, null, $code3, $search, $kwd, $cate, $no, $id, $scode, $codes);
					
				// 검색어순위 등록
				/*if(!empty($kwd)) {
					$where = "WHERE search_log_year = '".site_year."' AND search_log_month = '".site_month."' AND search_log_day = '".site_day."' AND search_log_hour = '".site_hour."' AND search_log_kwd = '".$kwd."' AND search_log_regip = '".site_client_ip."'";
					$serChk = $coreClass -> selectQueryCount(tbl_search_log, $where);
					
					if($tCnt > 0 && $serChk < 1) {
						// 검색어로그 등록
						$item			= "search_log_year, search_log_month, search_log_day, search_log_hour, search_log_kwd, search_log_regip, search_log_regdate";
						$value			= "'".site_year."', '".site_month."', '".site_day."', '".site_hour."', '".$kwd."', '".site_client_ip."', '".site_regdate."'";
						$coreClass -> insertQuery(tbl_search_log, $item, $value);
						
						// 검색어순위 등록 - 전체단위
						$where = "WHERE search_rnk_kwd = '".$kwd."'";
						$rnkChk = $coreClass -> selectQueryCount(tbl_search_rank_a, $where);
						
						if(empty($rnkChk)) {
							$item		= "search_rnk_kwd, search_rnk_total";
							$value		= "'".$kwd."', 1";
							$coreClass -> insertQuery(tbl_search_rank_a, $item, $value);
						} else {
							$set		= "SET search_rnk_total = search_rnk_total + 1";
							$where	= "WHERE search_rnk_kwd = '".$kwd."'";
							$coreClass -> updateQuery(tbl_search_rank_a, $set, $where);
						}
						
						// 검색어순위 등록 - 월간단위
						$where = "WHERE search_rnk_year = '".site_year."' AND search_rnk_month = '".site_month."' AND search_rnk_kwd = '".$kwd."'";
						$rnkChk = $coreClass -> selectQueryCount(tbl_search_rank_b, $where);
							
						if(empty($rnkChk)) {
							$item			= "search_rnk_year, search_rnk_month, search_rnk_kwd, search_rnk_total";
							$value			= "'".site_year."', '".site_month."', '".$kwd."', 1";
							$coreClass -> insertQuery(tbl_search_rank_b, $item, $value);
						} else {
							$set			= "SET search_rnk_total = search_rnk_total + 1";
							$where		= "WHERE search_rnk_year = '".site_year."' AND search_rnk_month = '".site_month."' AND search_rnk_kwd = '".$kwd."'";
							$coreClass -> updateQuery(tbl_search_rank_b, $set, $where);
						}
						$coreClass -> commit();		
					}
				}*/
				

			?>

		</div>
		<!-- //리스트// -->

	</div>
</div>