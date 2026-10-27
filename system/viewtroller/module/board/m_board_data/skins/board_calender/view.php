<?php
	/** 140617 */
	require_once $dir2.'view.header.php';
	require_once $dir2.'lib.default.php';
?>

<div class="board_w">
	<div class="sb_view">
		<table class="sv_table" summary="<?php echo site_menu_locTitle ?> 게시판의 제목, 제안자, 등록일, 조회수, 첨부파일, 내용 등의 정보를 목록으로 제공하고 있다.">
			<caption><?php echo site_menu_locTitle ?> 게시글 상세보기</caption>
			<colgroup>
				<col width="20%">
				<col width="30%">
				<col width="20%">
				<col width="30%">
			</colgroup>
			<tbody>
			<tr>
				<th scope="row" class="w20">제안과제명</th>
				<td colspan="3" class="w80"><?php echo $row['BRDATA_SUBJECT']?> <?php echo $new?> <?php echo $privacy?></td>
			</tr>
			<tr>
				<th class="w20" scope="row">제안자</th>
				<td class="w30"><?php echo $row['BRDATA_NAME']?></td>
				<th class="w20" scope="row">소속</th>
				<td class="w30"><?php echo $row['BRDATA_ETC4']?></td>
			</tr>
			<tr>
				<th class="w20" scope="row">이메일</th>
				<td class="w30"><?php echo $row['BRDATA_EMAIL']?></td>
				<th class="w20" scope="row">연락처</th>
				<td class="w30"><?php echo $row['BRDATA_HP']?></td>
			</tr>
			<tr>
				<th class="w20" scope="row">주소</th>
				<td class="w30"><?php echo $row['BRDATA_FLD4'] ?></td>
				<th class="w20" scope="row">등록일</th>
				<td class="w30"><?php echo date("Y-m-d",strtotime($row['BRDATA_REGDATE']))?></td>
			</tr>
			<tr>
				<th class="w20" scope="row">연구의 필요성<br>및<br>목적</th>
				<td colspan="3" class="con w80">
					<?php
						if($row['BRDATA_FLD1'] != ""){
							echo $row['BRDATA_FLD1'];
						}
					?>
				</td>
			</tr>
			<tr>
				<th class="w20" scope="row">주요<br>연구내용</th>
				<td colspan="3" class="con w80">
					<?php
						if($row['BRDATA_FLD2'] != ""){
							echo $row['BRDATA_FLD2'];
						}
					?>
				</td>
			</tr>
			<tr>
				<th class="w20" scope="row">기대효과<br>및<br>활용방안</th>
				<td colspan="3" class="con w80">
					<?php
						if($row['BRDATA_FLD3'] != ""){
							echo $row['BRDATA_FLD3'];
						}
					?>
				</td>
			</tr>
			<tr>
				<th scope="row">첨부</th>
				<td colspan="3"><?php echo $updList ?></td>
			</tr>
			</tbody>
		</table>
	</div>

	<?php
		require_once $dir2.'lib.btn.php';
		if(isset($board_data['BOARD_COMMENT']) && $board_data['BOARD_COMMENT'] == "Y") {
			require_once ($dir2.'view.comment.php');
		}
		require_once $dir2.'view.hit.php';
	?>

</div>

