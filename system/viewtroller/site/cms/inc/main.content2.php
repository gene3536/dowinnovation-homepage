<div class="mainCont1 clearfix">
	<table>
		<thead>
			<tr>
			    <th colspan="2">최근게시글</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$where	= "WHERE 1=1";
				$order	= "ORDER BY brdata_regdate DESC";
				$snum	= 0;
				$rnum		= 10;
				$brdRs	= $coreClass -> selectQuery(tbl_board_data, $where, $order, $snum, $rnum);
				while($rowl = $coreClass -> selectFetchArray($brdRs)) {
			?>
			<tr>
				<th><a href="sub.php?menukey=33&mod=view&no=<?php echo $rowl['BRDATA_NO']?>"><?php echo $coreClass -> getSub2Str(65, $rowl['BRDATA_SUBJECT'])?></a></th>
			    <td class="date"><?php echo $rowl['BRDATA_REGDATE']?></td>
			</tr>
			<?php } ?>
			<tr><td colspan="2" class="tbl_padding"></td></tr>
		</tbody>
	</table>

	<table class="tableLast">
		<thead>
			<tr>
			    <th colspan="2">최근게시글이력</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$where	= "WHERE 1=1";
				$order	= "ORDER BY brdlog_regdate DESC";
				$snum	= 0;
				$rnum		= 10;
				$brdRs	= $coreClass -> selectQuery(tbl_board_log, $where, $order, $snum, $rnum);
				while($rowl = $coreClass -> selectFetchArray($brdRs)) {
			?>
			<tr>
				<th><a href="sub.php?menukey=34"><?php echo $coreClass -> getSub2Str(60, $rowl['BRDLOG_SUBJECT'])?></a></th>
			    <td class="date"><?php echo $rowl['BRDLOG_TYPE']?> : <?php echo $rowl['BRDLOG_REGDATE']?></td>
			</tr>
			<?php } ?>
			<tr><td colspan="2" class="tbl_padding"></td></tr>
		</tbody>
	</table>
</div>