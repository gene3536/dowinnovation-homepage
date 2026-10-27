<?php
	/** 게시글 목록 - 140617 */
	require_once $dir2."list.header.php";
?>

	<div id="cenCont_in">

		<div class="brdlist_head">
			<div class="searchBoxType1 clearfix">
				<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?></b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
		        <div class="fr">
		        	<select name="cate" id="cate" class="selline" style="width:120px;" onchange="submit(); return false;">
		        		<option value="9">전체</option>
						<option value="1">제목</option>
						<option value="3">작성자</option>
			        </select>
		            <?php echo $coreClass -> searchBoxType2($search, $kwd)?>        
		        </div>
			</div>
		</div>

		<!-- 리스트 -->
		<form name="listForm" id="listForm" method="post" action="sub.php" onsubmit="return listDelCheck(this);">
		<input type="hidden" name="menukey" value="<?php echo $menukey?>">
		<input type="hidden" name="mod" value="process">
		<input type="hidden" name="act" value="adelete">
		<input type="hidden" name="token" value="<?php echo site_config_token?>" />

		<div class="brdlist_content">
			<table class="tbl_list1" summary="게시판 목록">
				<caption><?php echo site_menu_locTitle ?> 게시판 목록</caption>
				<colgroup>
					<?php if(S_mb_level <= bbs_config_level) { ?>
					<col width="5%">
					<?php } ?>
					<?php if($category_is == "Y") { ?>
					<col width="5%">
					<col width="15%">
					<col width="40%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
					<?php } else { ?>
					<col width="10%">
					<col width="50%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
					<?php } ?>
				</colgroup>
				<thead>					
					<tr>
						<?php if(S_mb_level <= bbs_config_level) { ?>
						<th scope="col" class="w5"><input type="checkbox" name="checkAll" value="1" class="checkAll"></th>
						<?php } ?>
						<?php if($category_is == "Y") { ?>
						<th scope="col" class="w5">번호</th>
						<th scope="col" class="w15">분류</th>
						<th scope="col" class="w40">제목</th>
						<th scope="col" class="w15">작성자</th>
						<th scope="col" class="w15">작성일</th>
						<th scope="col" class="w10">조회</th>
						<?php } else { ?>
						<th scope="col" class="w10">번호</th>
						<th scope="col" class="w50">제목</th>
						<th scope="col" class="w15">작성자</th>
						<th scope="col" class="w15">작성일</th>
						<th scope="col" class="w10">조회</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
				<?php
					if(!$paging["total_record"]) {
						if($board_data['BOARD_OTO'] == "Y") {
							$listMsg = '비공개 게시판이므로 본인이 작성한 글만 열람하실 수 있습니다.';
						} else {
							$listMsg = '게시물이 없습니다.';
						}
						if(S_mb_login == true && S_mb_level < site_config_glevel) {			
							$listData .= '<tr class="t_c"><td colspan="'.$colspanc.'">게시물이 없습니다.</td></tr>';
						} else {
							$listData .= '<tr class="t_c"><td colspan="'.$colspanc.'">'.$listMsg.'</td></tr>';
						}
					} else {
						// 공지글 목록
						while($row = $coreClass -> selectFetchArray($noticeRs)) {
							$notice_date = strtotime(date("Y-m-d"));
							if((!strtotime($row['BRDATA_SDATE']) && !strtotime($row['BRDATA_EDATE'])) || (strtotime($row['BRDATA_SDATE']) <= $notice_date && strtotime($row['BRDATA_EDATE']) >= $notice_date)) {	
								require $dir2."lib.default.php";
								$listData .= '<tr>';
								if(S_mb_level <= bbs_config_level) {
									$listData .= '<td class="t_c"><input type="checkbox" name="seq[]" value="'.$row['BRDATA_NO'].'" class="delNo"></td>';
								}
								$listData .= '<td class="t_c"><span class="fw_b fc_000">공지</span></td>';
								if($category_is == "Y") {
									$listData .= '<td class="t_c">';
									if( $row['BRDATA_CATEGORY'] != "" and $row['BRDATA_CATEGORY'] == true) {
										$listData .= $coreClass -> getCatid2Name($row['BRDATA_CATEGORY'], $bid);
									} else {
										$listData .= "일반";
									}
									$listData .= '</td>';
								}
								$listData .= '<td>';
								require $dir2."list.subject.php";
								$listData .= '</td>';
								$listData .= '
								<td class="t_c">'.$name.'</td>
								<td class="t_c">'.date("Y. m. d",strtotime($row['BRDATA_REGDATE'])).'</td>
								<td class="t_c">'.$hit.'</td>
								</tr>';
								$no--;
							}
						}
				
						// 일반글 목록		
						$no = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
						while($row = $coreClass -> selectFetchArray($boardRs)) {
							require $dir2."lib.default.php";
							$listData .= '<tr>';
							if(S_mb_level <= bbs_config_level) {
								$listData .= '<tr><td class="t_c"><input type="checkbox" name="seq[]" value="'.$row['BRDATA_NO'].'" class="delNo"></td>';
							}
							
							$listData .= '<td class="t_c">'.$no.'</td>';
							if($category_is == "Y") {
								$listData .= '<td class="t_c">';
								if( $row['BRDATA_CATEGORY'] != "" and $row['BRDATA_CATEGORY'] == true) {
									$listData .= $coreClass -> getCatid2Name($row['BRDATA_CATEGORY'], $bid);
								} else {
									$listData .= "일반";
								}
								$listData .= '</td>';
							}
							$listData .= '<td>';
							require $dir2."list.subject.php";
							$listData .= '</td>';
							$listData .= '
								<td class="t_c">'.$name.'</td>
								<td class="t_c">'.date("Y. m. d",strtotime($row['BRDATA_REGDATE'])).'</td>
								<td class="t_c">'.$hit.'</td>
								</tr>';
							$no--;
						}
					}
					echo $listData;
				?>
				</tbody>
			</table>
		</div>
		<!-- //리스트// -->		
		
		<!-- 버튼 페이징  -->
		<?php
			require_once ($dir2."lib.btn3.php");
			echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes);
			/*if(!empty($board_data['BOARD_FOOTER'])) {
				echo '<div class="board_note"><div class="noteIn">'.$board_data['BOARD_FOOTER'].'</div></div>';
			}*/
		?>

		</form>

		<!-- //버튼 페이징// -->
	</div>

