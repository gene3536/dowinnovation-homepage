<?php

	$where	= "WHERE menu_menukey = '".$mkey."'";
	$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

	$satisfaction_where		= "WHERE satisfaction_code = '".$scode."' AND satisfaction_menukey = '".$mkey."'";
	$satisfaction_order		= "ORDER BY satisfaction_regdate ASC";
	$satisfaction_result		= $coreClass -> selectQuerySum($tbl2, $satisfaction_where, "satisfaction_value");
	$satisfaction_count		= $coreClass -> selectQueryCount($tbl2, $satisfaction_where);
	$satisfaction_rs			= $coreClass -> selectQuery($tbl2, $satisfaction_where, $satisfaction_order, "", "");
	if(!empty($satisfaction_count)) {
		$satisfaction_percent	= round(($satisfaction_result / ($satisfaction_count*5) * 100), 2);
	} else {
		$satisfaction_result		= 0;
		$satisfaction_percent	= 0;
	}
?>
	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" summary="만족도결과 상세보기">
	        <caption>만족도결과 상세보기</caption>
	        <colgroup>
	        	<col style="width:20%;" />
	            <col style="width:80%;" />
	        </colgroup>

	        <tbody>
			<tr>
	            <th scope="row">메뉴명</th>
	            <td><?php echo $row['MENU_TITLE']?></td>
			</tr>
			<tr>
	            <th scope="row">만족도결과</th>
				<td>
					<span class="i_graph">  
						<span class="g_bar">  
							<span style="width:<?php echo $satisfaction_percent?>%" class="g_action"></span>  
						</span>  
						<span class="g_percent">  
							<strong><?php echo $satisfaction_percent?></strong>%
                        </span>
                    </span>
	            </td>
			</tr>
			<tr>
	            <th scope="row">평가점수/총점수</th>
	            <td><?php echo $satisfaction_result?> / <?php echo $satisfaction_count*5?></td>
			</tr>
			<tr>
	            <th scope="row">평가인원</th>
				<td><?php echo $satisfaction_count?>명</td>
			</tr>
			<?php
				for($i = 5; $i > 0; $i--) {
					$satisfaction_where		= "WHERE satisfaction_code = '".$scode."' AND satisfaction_menukey = '".$mkey."' AND satisfaction_value = '".$i."'";
					$satisfaction_count1	= $coreClass -> selectQueryCount($tbl2, $satisfaction_where);
					if(!empty($satisfaction_count)) {
						$satisfaction_percent1	= round(($satisfaction_count1 / $satisfaction_count * 100), 2);
					} else {
						$satisfaction_result1	= 0;
						$satisfaction_percent1	= 0;
					}
			?>
			<tr>
	            <th scope="row">만족도상세결과 - 별<?php echo $i?></th>
				<td>
					<span class="i_graph">  
						<span class="g_bar">  
							<span style="width:<?php echo $satisfaction_percent1?>%" class="g_action"></span>  
						</span>  
						<span class="g_percent">  
							<strong><?php echo $satisfaction_count1?></strong>명
							<strong><?php echo $satisfaction_percent1?></strong>%
                        </span>
                    </span>
	            </td>
			</tr>
			<?php } ?>
			<tr>
	            <th scope="row">만족도 기타의견</th>
				<td>
					<?php
						while($srow = mysql_fetch_array($satisfaction_rs)) {
							echo "&bull;&nbsp;".$srow['SATISFACTION_REGDATE']." - ",$srow['SATISFACTION_TEXT'],"<br />";
						}
					?>
				</td>
			</tr>
	        </tbody>
			</table>
		</div>

		<div class="brdlist_footer">
	    	<div class="bt">
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list" class="btn_big"><span>목록</span></a>
	        </div>
		</div>
	</div>
</form>