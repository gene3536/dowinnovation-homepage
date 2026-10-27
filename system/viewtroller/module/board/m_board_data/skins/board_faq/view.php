<?php
	require_once $dir2.'view.header.php';
	require_once $dir2.'lib.default.php';
?>

<div class="board_w">
	<div class="sb_view">
		<table class="sv_table" summary="<?php echo site_menu_locTitle ?> 게시판의 제목, 작성자, 등록일, 조회수, 첨부파일, 내용 등의 정보를 목록으로 제공하고 있다.">
			<tr>
				<th scope="row" class="w20">제목</th>
				<td colspan="3" class="w80"><?php echo $row['BRDATA_SUBJECT']?> <?php echo $new?> <?php echo $privacy?></td>
			</tr>
			<tr>
				<th class="w20" scope="row">작성자</th>
				<td class="w30"><?php echo $row['BRDATA_NAME']?></td>
				<th class="w20" scope="row">조회수</th>
				<td class="w30"><?php echo $row['BRDATA_HIT']?></td>
			</tr>
			<tr>
				<th scope="row">등록일</th>
				<td colspan="3"><?php echo date("Y-m-d", strtotime($row['BRDATA_REGDATE']))?></td>
			</tr>
			<tr>
				<th scope="row">첨부</th>
				<td colspan="3"><?php echo $updList ?></td>
			</tr>
			<tr>
				<td colspan="4" class="con">
					<?php
						echo $view_img;
						if($row['BRDATA_CONTENT'] != ""){
							echo $row['BRDATA_CONTENT'];
						}
					?>
				</td>
			</tr>
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
