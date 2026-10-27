<?php
	require_once $dir2.'view.header.php';
	require_once $dir2.'lib.default.php';
?>

<table class="board_view margin_t_10" summary="<?php echo $row['BRDATA_SUBJECT']?> - 게시글 상세보기">
	<caption>게시글 상세보기</caption>
	<colgroup>	        
		<col style="width: 14%" />
		<col style="width: 20%" />
		<col style="width: 14%" />
		<col style="width: 20%" />
		<col style="width: 14%" />
		<col style="width: 18%" />
	</colgroup>
	<tbody>
		<tr>
            <th colspan="6" class="last"><?php echo $row['BRDATA_SUBJECT']?> <?php echo $new?> <?php echo $privacy?></th>
		</tr>
		<tr>
			<th scope="row" class="gray">게시판</th>
			<td colspan="5"><?php echo $brow['BOARD_NAME']?></td>
		</tr>
		<tr>
			<th scope="row" class="gray">작성자</th>
			<td><?php echo $row['BRDATA_NAME']?></td>
			<th scope="row" class="gray">등록일</th>
			<td><?php echo date("Y/m/d", strtotime($row['BRDATA_REGDATE']))?></td>
			<th scope="row" class="gray">조회</th>
			<td><?php echo $row['BRDATA_HIT']?></td>
		</tr>
		<tr>
           	<th scope="row" class="gray">IP</th>
			<td><?php echo $row['BRDATA_REGIP']?></td>
   	        <th scope="row" class="gray">이메일</th>
            <td><?php echo $row['BRDATA_EMAIL']?></td>
  	        <th scope="row" class="gray">연락처</th>
            <td><?php echo $row['BRDATA_HP']?></td>
		</tr>
		<?php if(S_mb_level <= $brow['BOARD_LV_EXPOSURE']) { ?>
		<tr>
			<th scope="row" class="gray">노출기간 설정</th>
			<td colspan="5">
				<?php echo $row['BRDATA_SEXPOSURE']?>
				-
				<?php echo $row['BRDATA_EEXPOSURE']?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<th scope="row" class="gray">첨부</th>
			<td colspan="5"><?php echo $updList ?></td>
		</tr>
		<tr>
           	<td colspan="6" class="substance">					
            	<?php
            		echo $view_img;
					if($row['BRDATA_BID'] = '00000006' && $row['BRDATA_NO'] < 22029) {
						echo nl2br($row['BRDATA_CONTENT']);
					} else {	            			
						echo $row['BRDATA_CONTENT'];
					}
            	?>
			</td>
		</tr>
		 <tr>
	        <th scope="row" class="gray"><span class="next_text">다음글</span></th>
        	<td colspan="5" class="txt_left"><?php echo $nextBrd?></td>
        </tr>
		<tr>
	        <th scope="row" class="gray"><span class="prev_text">이전글</span></th>
			<td colspan="5" class="txt_left"><?php echo $prevBrd?></td>
		</tr>
	</tbody>
</table>
<?php
	// 삭제
	if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
		// 완전삭제
		if(S_mb_level <= bbs_config_level) {
			$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=adelete&amp;no='.$no.'&amp;token='.site_config_token.$listVar.'" onclick="if(confirm(\'정말로 완전삭제하시겠습니까?\')) location.href=this.href; return false" class="btn_big"><span>완전삭제</span></a>&nbsp;';
		}
		// 삭제
		if(S_mb_level <= bbs_config_level || (S_mb_id == $row['BRDATA_UID'] && S_mb_level <= site_config_alevel) || ($row['BRDATA_AUTHKEY'] != NULL && $row['BRDATA_AUTHKEY'] != "" && S_mb_authkey == $row['BRDATA_AUTHKEY'] && S_mb_level <= site_config_alevel)) {
			$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=delete&amp;no='.$no.'&amp;token='.site_config_token.$listVar.'" onclick="if(confirm(\'정말로 삭제합니까?\')) location.href=this.href; return false" class="btn_big"><span>삭제</span></a>&nbsp;';
		} else if(S_mb_level >= site_config_glevel && S_mb_id == $row['BRDATA_UID']) {
			$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=process&amp;rtnact=delete&amp;no='.$no.$listVar.'" class="btn_big"><span>삭제</span></a>&nbsp;';
		}
	}
	if(($mod == "view") || ($mod == "insert") || ($mod == "modify") || ($mod == "reply") || ($mod == "status1") || ($mod == "status2")) {
		$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=list'.$listVar.'" class="btn_big"><span>목록</span></a>';
	}
?>