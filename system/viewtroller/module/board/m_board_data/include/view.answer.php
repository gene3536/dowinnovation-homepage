<?php
	$asWhere = "WHERE brdata_grp_no = '".$row['BRDATA_NO']."' AND brdata_level_no = '1'"; 
	$asCount = $coreClass->selectQueryCount(tbl_board_data,$asWhere);
	
	if($asCount > 0){ 
		$asRow = $coreClass->selectQueryArray(tbl_board_data,$asWhere);
?>


	<div class="sb_view mt_40">
		<table class="sv_table" summary="<?php echo site_menu_locTitle ?> 게시판의 제목, 작성자, 등록일, 조회수, 첨부파일, 내용 등의 정보를 목록으로 제공하고 있다.">
			<caption><?php echo site_menu_locTitle ?> 게시글 상세보기</caption>
			<colgroup>
				<col width="20%">
				<col width="30%">
				<col width="20%">
				<col width="30%">
			</colgroup>
			<tbody>
			<tr>
				<th scope="row" class="w20">답변</th>
				<td colspan="3" class="w80"><?php echo $asRow['BRDATA_SUBJECT']?> <?php echo $new?> <?php echo $privacy?></td>
			</tr>
			<tr>
				<th class="w20" scope="row">작성자</th>
				<td class="w30"><?php echo $asRow['BRDATA_NAME']?></td>
				<th class="w20" scope="row">등록일</th>
				<td class="w30"><?php echo date("Y-m-d", strtotime($asRow['BRDATA_REGDATE']))?></td>
			</tr>
			<tr>
				<th scope="row">첨부</th>
				<td colspan="3"><?php echo $updList ?></td>
			</tr>
			<tr>
				<td colspan="4" class="con">
					<?php
						echo $view_img;
						if($asRow['BRDATA_CONTENT'] != ""){
							echo $asRow['BRDATA_CONTENT'];
						}
					?>
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<?php	
		$btnData = "";
			
		// 삭제
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			// 완전삭제
			if(S_mb_level <= bbs_config_level) {
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=adelete&amp;no='.$asRow['BRDATA_NO'].'&amp;token='.site_config_token.'" onclick="if(confirm(\'정말로 삭제 하시겠습니까?\n삭제된 내용은 복구 할 수 없습니다.\')) location.href=this.href; return false">삭제</a></p>';
			}	
		}

		// 수정버튼		
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			
			if($asRow['BRDATA_UID'] == S_mb_id || site_config_level >= S_mb_level) { 				
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=modify&amp;no='.$asRow['BRDATA_NO'].'">수정</a></p>';
			}
		}
	?>

	<div class="sb_btn_w">	
		<div class="sb_btn">
			<?php echo $btnData ?>
		</div>
	</div>

<?php
	}
?>