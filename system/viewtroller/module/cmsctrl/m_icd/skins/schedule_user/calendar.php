<?php
	
	require_once("header.inc.php");

	$where = "WHERE icd_pid = '".$pid."' AND DATE_FORMAT(icd_sdate,'%Y%m') <= '".date("Ym",strtotime($thisDate))."' AND DATE_FORMAT(icd_edate,'%Y%m') >= '".date("Ym",strtotime($thisDate))."'";
	
	$strParam  = "";
	$strParam .= "&amp;param[WHERE]=".urlencode($where);
	$strParam .= "&amp;param[TABLE]=".$tbl1;
	$strParam .= "&amp;param[ORDER]="."ORDER BY icd_regdate DESC";
	$strParam .= "&amp;param[FILENAME]=".urlencode(date("Y-m")."공연행사일정");
	$strParam .= "&amp;param[DATEMONTH]=".date("Y-m");

?>
	<div class="sc21">
		<div class="sc_cal_w">
			<div class="cal_pc">
				<div class="calendar_top"><a href="sub.php?menukey=<?php echo $menukey ?>&amp;mod=<?php echo $mod ?>&amp;thisDate=<?php echo $p_m?>"><img src="images/content/sc_cal_arr01.png" alt="이전" class="align_m mr_30"></a><?php echo $s_Y?>.<?php echo $s_m?><a href="sub.php?menukey=<?php echo $menukey ?>&amp;mod=<?php echo $mod ?>&amp;thisDate=<?php echo $n_m?>"><img src="images/content/sc_cal_arr02.png" alt="다음" class="align_m ml_30"></a></div>

				<table class="cal_table mt_30">
					<caption>공연 일정</caption>
					<thead>
						<tr>
							<th scope="col" class="col01">일요일</th>
							<th scope="col" class="col02">월요일</th>
							<th scope="col" class="col02">화요일</th>
							<th scope="col" class="col02">수요일</th>
							<th scope="col" class="col02">목요일</th>
							<th scope="col" class="col02">금요일</th>
							<th scope="col" class="col03 line">토요일</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					for($r=0;$r<=$ra;$r++){
						echo "<tr>";
						for($z=1;$z<=7;$z++){
							$rv=7*$r+$z; $ru=$rv-$l; // 칸에 번호를 매겨줍니다. 1일이 되기전 공백들 부터 마이너스 값으로 채운 뒤 ~ 
							if($ru<=0 || $ru>$s_t) {
								echo '<td>&nbsp;</td>';
							} else {
								$d = date("Y-m-d",mktime(0,0,0,$s_m,$ru,$s_Y)); // 현재칸의 날짜
								echo "<td>";

								$holiChk = date("w",mktime(0,0,0,$s_m,$ru,$s_Y));

								if($holiChk == 0) echo "<span class=\"sun\">";
								else if($holiChk == 6) echo "<span class=\"sat\">";

								echo $ru;

								if($d == site_date_s) { //오늘
									echo '<img src="images/content/today.png" alt="Today" class="ml_5">';
								}

								if($holiChk == 0 || $holiChk == 6) echo "</span>";
								
								echo "<ul class=\"icon_01\">";
								$where	= "WHERE icd_pid = '".$pid."' AND (DATE_FORMAT(icd_sdate,'%Y-%m-%d') <= '".$d."' AND DATE_FORMAT(icd_edate,'%Y-%m-%d') >= '".$d."')"; //echo $where;
								if($search == 1) $where .= " AND icd_title LIKE '%".$kwd."%'";
								$dtRs	= $coreClass -> selectQuery($tbl1, $where, "ORDER BY ICD_NO DESC", "", "");
								$cntRs	= $coreClass -> selectQueryCount($tbl1, $where);
								if($cntRs > 0) {
									while($dtRow = $coreClass -> selectFetchArray($dtRs)){
										echo "<li>";
										echo '<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;mod2=calendar&amp;no='.$dtRow['ICD_NO'].'&s='.$d.$listVar.'">';
										echo '&nbsp;'.$dtRow['ICD_TITLE'];	
										echo '</a>';
										echo "</li>";
									}
									echo "</ul>";
								}										
								echo '</td>';
							}
						}
						echo "</tr>";
					}
					?>
					</tbody>
				</table>

				<div class="board_top_w">
					<!-- 검색 -->
					<div class="sb_search">
						<form name="search1" method="post">
							<fieldset>
							<legend class="hiddenTxt">게시물 검색</legend>
								<label for="search1" class="hiddenTxt">게시물 내 검색</label>
								<p class="tit">공연명검색</p>
								<!-- <select id="search1" name="search1" title="검색조건 선택">
									<option value="">전체에서</option>
									<option value="">제목</option>
									<option value="">내용</option>
									<option value="">작성자</option>
								</select> -->
								<input type="text" name="searchWrd" id="search_txt2" class="sbs_ip" title="검색어입력">
								<a href="#" class="sbs_btn">검색</a>
							</fieldset>
						</form>
					</div>
					<!-- //검색// -->
				</div>

				<ul class="btn_r mt_20">
					<li class="btn_gold2"><a href="/base/php/cmn.excel.php?type=perform<?php echo $strParam?>" target="_blank" title="새창에서 열림">공연일정 다운로드<img src="images/content/icon_down.png" alt="" class="align_m ml_7"></a><li>
					<li class="btn_red2"><a href="sub.php?menukey=<?=$menukey?>&amp;mod=list&amp;mod2=<?php echo $mod?>&amp;thisDate=<?php echo $thisDate?>"><img src="images/content/list_icon_f.png" alt="" class="align_m mr_7">리스트로 보기</a><li>
				</ul>
			</div>

<?php

	$where = "WHERE icd_pid = '".$pid."' AND DATE_FORMAT(icd_sdate,'%Y%m') <= '".date("Ym",strtotime($thisDate))."' AND DATE_FORMAT(icd_edate,'%Y%m') >= '".date("Ym",strtotime($thisDate))."'";
	if($search == 1) $where .= " AND icd_title LIKE '%".$kwd."%'"; //echo $where;
	if(!empty($search) && $search == 1) {
		$where .= " AND icd_title LIKE '%".$kwd."%'";
	}
	if(!empty($scode)) {
		//$where .= " AND icd_scode = '".$scode."'";
	}

	// 페이징
	$page			= $page ? $page : 1;
	$numofrecord	= 10;

	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	if($board_data['BOARD_TYPE'] == "board_imglist"){
		$paging		= $coreClass -> pagingCore2($paging_result, $numofrecord, $page);
	}else{
		$paging		= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	}		

	$order			= "ORDER BY icd_regdate DESC";
	$rs = $coreClass -> selectQuery($tbl1, $where, $order, $paging["startofrecord"], $paging["numofrecord"]);	
	

?>

			<div class="cal_tm" style="display: none ;">
				<div class="calendar_top"><a href="sub.php?menukey=<?php echo $menukey ?>&amp;mod=<?php echo $mod ?>&amp;thisDate=<?php echo $p_m?>"><img src="images/content/sc_cal_arr01.png" alt="이전" class="align_m mr_30"></a><?php echo $s_Y?>.<?php echo $s_m?><a href="sub.php?menukey=<?php echo $menukey ?>&amp;mod=<?php echo $mod ?>&amp;thisDate=<?php echo $n_m?>"><img src="images/content/sc_cal_arr02.png" alt="다음" class="align_m ml_30"></a></div>
				<div class="board_w">
					<!-- 리스트 -->
					<div class="sb_list mt_30">
						<ul class="web_zine_w4">
							<?php if($paging_result < 1) { ?>
							<li>출력할 데이터가 없습니다.</li>
							<?php
								} else {
									$num = $paging["total_record"] - ($paging["page"]-1) * $paging["numofrecord"];
									while($row = $coreClass -> selectFetchArray($rs)) {
							?>
							<li>
								<div class="no_w"><?php echo $num?></div>
								<!-- <div class="video">
									<p class="wz_img"><img alt="이미지" src="images/content/board_img.jpg"></p>
								</div> -->
								<dl>
									<dt><a href="sub.php?menukey=<?php echo $menukey?>&mod=view&amp;mod2=list&no=<?php echo $row['ICD_NO']?><?php echo $var?>"><?php echo $row['ICD_TITLE']?> (<?php echo date("Y.m.d",strtotime($row['ICD_SDATE']))?> ~ <?php echo date("Y.m.d",strtotime($row['ICD_EDATE']))?>)</a></dt>
									<dd class="con"><a href="sub.php?menukey=<?php echo $menukey?>&mod=view&amp;mod2=list&no=<?php echo $row['ICD_NO']?><?php echo $var?>"><?php echo $row['ICD_CONTENT']?></a></dd>
								</dl>
								<div class="btn_w">
									<p class="btn"><a href="sub.php?menukey=<?php echo $menukey?>&mod=view&amp;mod2=list&no=<?php echo $row['ICD_NO']?><?php echo $var?>">자세히보기<img alt="이미지" src="images/content/btn_more.png" class="ml_8 align_m"></a></p>
								</div>
							</li>
							<?php
										$num--;
									}
								}
							?>
						</ul>
					</div>
					<!-- //리스트// -->
				</div>

				<div class="board_top_w">
					<!-- 검색 -->
					<div class="sb_search">
						<form name="search1" method="post">
							<fieldset>
							<legend class="hiddenTxt">게시물 검색</legend>
								<label for="search1" class="hiddenTxt">게시물 내 검색</label>
								<p class="tit">공연명검색</p>
								<!-- <select id="search1" name="search1" title="검색조건 선택">
									<option value="">전체에서</option>
									<option value="">제목</option>
									<option value="">내용</option>
									<option value="">작성자</option>
								</select> -->
								<input type="text" name="searchWrd" id="search_txt2" class="sbs_ip" title="검색어입력">
								<a href="#" class="sbs_btn">검색</a>
							</fieldset>
						</form>
					</div>
					<!-- //검색// -->
				</div>

				<ul class="btn_r mt_20">
					<li class="btn_gold2"><a href="/base/php/cmn.excel.php?type=perform<?php echo $strParam?>" target="_blank" title="새창에서 열림">공연일정 다운로드<img src="images/content/icon_down.png" alt="" class="align_m ml_7"></a><li>
					<li class="btn_red2 tm_none"><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=calendar&amp;mod2=<?php echo $mod?>&amp;thisDate=<?php echo $thisDate?>"><img src="images/content/cal_icon_f.png" alt="" class="align_m mr_7">달력으로 보기</a><li>
				</ul>
			</div>

		</div>


	</div>


<script type="text/javascript">
$(window).load(function(){
	if($(window).width() >= 990) $(".sc_cal_w .cal_tm").hide();
	else $(".sc_cal_w .cal_tm").show();
});

$(window).resize(function(){
	if($(window).width() >= 990) $(".sc_cal_w .cal_tm").hide();
	else $(".sc_cal_w .cal_tm").show();
});
</script>
