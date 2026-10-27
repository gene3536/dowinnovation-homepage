

<div id="cenCont_in">
	<?php echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>
	<div class="space10"></div>
	
	<div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="월별기록">
            <caption>월별기록</caption>
            <colgroup>
                <col width="14%" />
                <col width="6%" />
                <col width="6%" />
                <col width="6%" />
                <col width="6%" />
                <col width="6%" />
                <col width="6%" />
                <col width="6%" />
                <col width="6%" />
                <col width="6%" />
                <col width="6%" />
                <col width="6%" />
                <col width="6%" />
                <col width="14%" />
            </colgroup>
            <thead>    
                <tr>
                    <th scope="row"><strong>연도</strong></th>
                    <th scope="row"><strong>1월</strong></th>
                    <th scope="row"><strong>2월</strong></th>
                    <th scope="row"><strong>3월</strong></th>
                    <th scope="row"><strong>4월</strong></th>
                    <th scope="row"><strong>5월</strong></th>
                    <th scope="row"><strong>6월</strong></th>
                    <th scope="row"><strong>7월</strong></th>
                    <th scope="row"><strong>8월</strong></th>
                    <th scope="row"><strong>9월</strong></th>
                    <th scope="row"><strong>10월</strong></th>
                    <th scope="row"><strong>11월</strong></th>
                    <th scope="row"><strong>12월</strong></th>
                    <th scope="row"><strong>총합</strong></th>
                </tr>
            </thead>
            <tbody>
                <?php
                	$totalCount = 0;
                	for($i = $startYear; $i <= $endYear; $i++) {
				?>
            	<tr>
                	<td><span class="i_graph"><span class="g_percent"><strong><?php echo $i?></strong> 년</span></span></td>
				
				<?php	
    					$yearCount	= 0;
						for($j = 1; $j <= 12; $j++) {
							$monthCount	= 0;
               				$where			= "WHERE cms_stat_count_year = '".$i."' AND cms_stat_count_month = '".$j."'";
               				if(!empty($scode)) {
								$where .= " AND cms_stat_count_code = '".$scode."'";
							}
    						$rs					= $coreClass -> selectQuery($tbl1, $where, "", "", "");
    						
		                	while($row = $coreClass -> selectFetchArray($rs)) {
		                		$monthCount	= $monthCount + $row['CMS_STAT_COUNT_TOTAL'];
		                		$yearCount		= $yearCount + $row['CMS_STAT_COUNT_TOTAL'];
		                	}
                ?>
                	<td><span class="i_graph"><strong><?php echo $monthCount?></strong></span></td>
                <?php
						}
				?>
                
                	<td><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($yearCount)?></strong> 명</span></span></td>                
                </tr>
                <?php } ?>
            </tbody>  
		</table>
	</div>
</div>