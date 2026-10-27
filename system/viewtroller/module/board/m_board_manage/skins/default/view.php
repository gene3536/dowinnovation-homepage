<?php require_once $dir3."bbs.view.header.php";
?>

<div id="cenCont_in">
    <div class="brdlist_content">
    	<table class="tbl_view1" border="1" cellspacing="0" summary="게시글 상세보기">
	        <caption>게시글 상세보기</caption>
			<colgroup>
		       	<col style="width: 20%;" />
		       	<col style="width: 30%;" />
		       	<col style="width: 20%;" />
		       	<col style="width: 30%;" />
			</colgroup>
			<tbody>
				<tr>
	       		    <th scope="row">게시판</th>
		            <td colspan="3"><?php echo $brow['BOARD_NAME']?></td>
				</tr>
				<tr>
	       		    <th scope="row">제목</th>
		            <td colspan="3"><?php echo $row['BRDATA_SUBJECT']?></td>
				</tr>
				<tr>
	            	<th scope="row">작성자</th>
					<td><?php echo $row['BRDATA_NAME']?></td>
	            	<th scope="row">IP</th>
					<td><?php echo $row['BRDATA_REGIP']?></td>
				</tr>
				<tr>
	    	        <th scope="row">이메일</th>
	                <td><?php echo $row['BRDATA_EMAIL']?></td>
	    	        <th scope="row">연락처</th>
	                <td><?php echo $row['BRDATA_HP']?></td>
	            </tr>
		        <tr>
		            <th scope="row">등록일</th>
	                <td><?php echo date("Y/m/d H:i:s", strtotime($row['BRDATA_REGDATE']))?></td>
	    	        <th scope="row">조회</th>
	                <td><?php echo $row['BRDATA_HIT']?></td>
	            </tr>
				<?php if(S_mb_level <= $brow['BOARD_LV_EXPOSURE']) { ?>
				<tr>
					<th scope="row">노출기간 설정</th>
					<td colspan="3">
					<?php echo $row['BRDATA_SEXPOSURE']?>
					-
					<?php echo $row['BRDATA_EEXPOSURE']?>
					
					</td>
				</tr>
				<?php } ?>
				<tr>
	                <th scope="row">첨부</th>
	                <td colspan="3"><?php echo $updList ?></td>
				</tr>
				<?php if($brow['BOARD_EXTEND'] == "Y"){ ?>				
				<?php require_once($dir2.'/extend_view.php'); ?>
				<?}?>
				<tr>
	            	<td colspan="4">
		            	<div style="width:100%; overflow:hidden;">
			            	<?php
			            		echo $imgView;
								echo $row['BRDATA_CONTENT'];
							?>
						</div>
		            </td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr>
		            <th>다음글</th>
	                <td colspan="3" style="padding-left:15px"><?php echo $nextBrd?></td>
	            </tr>
	            <tr>
		            <th>이전글</th>
	                <td colspan="3" style="padding-left:15px"><?php echo $prevBrd?></td>
	            </tr>
			</tbody>
		</table>
	</div>
	
    <?php require_once($dir3.'/bbs.lib.btn.php'); ?> 
</div>
