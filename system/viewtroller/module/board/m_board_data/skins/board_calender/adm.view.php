<?php
	/** 140617 */
	require_once $dir2.'view.header.php';
	require_once $dir2.'lib.default.php';
?>

<div id="cenCont_in">
	<div class="brdlist_content">
		<table class="tbl_view1" border="1" cellspacing="0" summary="게시글 상세보기">
			<caption><?php echo site_menu_locTitle ?> 게시글 상세보기</caption>
			<colgroup>
				<col width="20%">
				<col width="30%">
				<col width="20%">
				<col width="30%">
			</colgroup>
			<tbody>
			<tr>
				<th scope="row" class="w20">작성자</th>
				<td colspan="3" class="w80"><?php echo $row['BRDATA_NAME']?></td>
			</tr>
			<tr>
				<th scope="row" class="w20">분야명</th>
				<td colspan="3" class="w80"><?php 
					if(!empty($cateRow['BRDCAT_NAME'])){
						echo "[".$cateRow['BRDCAT_NAME']."]&nbsp;";
					}
					?>
				</td>
			</tr>
			<tr>
				<th scope="row" class="w20">교육명</th>
				<td colspan="3" class="w80"><?php echo $row['BRDATA_SUBJECT']?> <?php echo $new?> <?php echo $privacy?></td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_etc4">기간</label></th>
				<td colspan="3" class="w80"><?php echo $row['BRDATA_ETC4']?></td>
			</tr>
			<tr>
				<th class="w20" scope="row">등록일</th>
				<td class="w30"><?php echo date("Y-m-d",strtotime($row['BRDATA_REGDATE']))?></td>
			</tr>
			<tr>
				<th class="w20" scope="row">교육 설명</th>
				<td colspan="3" class="con w80">
					<?php
						if($row['BRDATA_FLD1'] != ""){
							echo $row['BRDATA_FLD1'];
						}
					?>
				</td>
			</tr>
			<tr>
				<th class="w20" scope="row">교육일정</th>
				<td colspan="3" class="con w80">
					<table>
						<tbody>
						<?php
						while($caRows = $coreClass -> selectFetchArray($calRs)) {?>
							<tr>
								<th><?=$caRows['cTitle']?></th>
								<td><?=$caRows['cDate']?></td>
							</tr>
						<?php }
						?>
						</tbody>
					</table>
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<?php
		require_once $dir2.'lib.btn3.php';
		if(isset($board_data['BOARD_COMMENT']) && $board_data['BOARD_COMMENT'] == "Y") {
			require_once ($dir2.'view.comment.php');
		}
	?>

</div>

