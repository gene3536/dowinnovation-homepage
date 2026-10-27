<?php
	
	if($code1 == 3) {
		if(empty($scode)) {
			$where = "WHERE CMS_STAT_PAGELOG_YEAR = '".$thisYear."'";
		} else {
			$where = "WHERE CMS_STAT_PAGELOG_CODE = '".$scode."' AND CMS_STAT_PAGELOG_YEAR = '".$thisYear."'";
		}
	} else if($code1 == 2) {
		if(empty($scode)) {
			$where = "WHERE CMS_STAT_PAGELOG_YEAR = '".$thisYear."' AND CMS_STAT_PAGELOG_MONTH = '".$thisMonth."'";
		} else {
			$where = "WHERE CMS_STAT_PAGELOG_CODE = '".$scode."' AND CMS_STAT_PAGELOG_YEAR = '".$thisYear."' AND CMS_STAT_PAGELOG_MONTH = '".$thisMonth."'";
		}
	} else {
		if(empty($scode)) {
			$where = "WHERE CMS_STAT_PAGELOG_YEAR = '".$thisYear."' AND CMS_STAT_PAGELOG_MONTH = '".$thisMonth."' AND CMS_STAT_PAGELOG_DAY = '".$thisDay."'";
		} else {
			$where = "WHERE CMS_STAT_PAGELOG_CODE = '".$scode."' AND CMS_STAT_PAGELOG_YEAR = '".$thisYear."' AND CMS_STAT_PAGELOG_MONTH = '".$thisMonth."' AND CMS_STAT_PAGELOG_DAY = '".$thisDay."'";
		}
	}
	
	$order = "ORDER BY CMS_STAT_PAGELOG_TOTAL DESC";
	$rs = $coreClass -> selectQuery(tbl_cms_stat_pagelog, $where, $order, "", "");
	$totalCount = $coreClass -> selectQuerySum(tbl_cms_stat_pagelog, $where, "CMS_STAT_PAGELOG_TOTAL");
?>

<div id="cenCont_in">
	<?php echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>
	
	<div class="tabs">
		<ul>  
			<li <?php if($code1 == 1) { ?> class="on" <?php } ?>>
				<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=1&amp;scode=<?php echo $scode?>">일별기록</a>  
			</li>  
			<li <?php if($code1 == 2) { ?> class="on" <?php } ?>>  
				<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=2&amp;scode=<?php echo $scode?>">월별기록</a>  
			</li>  
			<li <?php if($code1 == 3) { ?> class="on" <?php } ?>>
				<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=3&amp;scode=<?php echo $scode?>">연도별기록</a>  
			</li>  
		</ul>
	</div>
	
	<div style="padding:10px; margin:10px 0; text-align:center; border:1px solid #ccc; background-color:#eee;">
		<form name="count" method="post" action="sub.php?menukey=<?php echo $menukey?>">
			<input type="hidden" name="code1" value="<?php echo $code1?>" />
			<input type="hidden" name="scode" value="<?php echo $scode?>" />
				
			<select name="year" id="year" class="selline" title="연도선택" style="width:80px;">
				<?php for($y = $endYear; $y >= $startYear; $y--) { ?>
					<option value="<?php echo $y?>" <?php if($thisYear == $y) { ?> selected="selected" <?php } ?>><?php echo $y?>년</option>
				<?php } ?>
			</select>
			<?php if($code1 < 3) { ?>
				<select name="month" id="month" class="selline" title="월선택" style="width:80px;">
					<?php for($m = 1; $m <= 12; $m++) { ?>
						<option value="<?php echo $m?>" <?php if($thisMonth == $m) { ?> selected="selected" <?php } ?>><?php echo $m?>월</option>
					<?php } ?>
				</select>
			<?php } ?>
			<?php if($code1 < 2) { ?>
				<select name="day" id="day" class="selline" title="일선택" style="width:80px;">
					<?php for($d = 1; $d <= site_date_t; $d++) { ?>
						<option value="<?php echo $d?>" <?php if($thisDay == $d) { ?> selected="selected" <?php } ?>><?php echo $d?>일</option>
					<?php } ?>
				</select>
			<?php } ?>
			<input type="image" src="imgs/btn/btn_search.gif" alt="검색" style="vertical-align:middle" />
		</form>
	</div>

	<div class="brdlist_content">
		<table class="tbl_list1" summary="일별기록">
			<caption>일별기록</caption>
            <colgroup>
                <col width="20%" />
                <col width="15%" />
                <col width="55%" />
            </colgroup>
            <thead>    
                <tr>
                    <th scope="row"><strong>메뉴명</strong></th>
                    <th scope="row"><strong>사이트명</strong></th>
                    <th scope="row"><strong>페이지히트비율</strong></th>
                    <th scope="row"><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($totalCount)?></strong> Hit</span></span></th>
                </tr>
            </thead>
            <tbody>
                <?php                	
                	while($rows = $coreClass -> selectFetchArray($rs)) {
						$todayCount = $rows['CMS_STAT_PAGELOG_TOTAL'];
						if(!empty($todayCount)) {
							$todayPercent	= round(($todayCount / $totalCount * 100), 2);
						} else {
							$todayCount		= 0;
							$todayPercent	= 0;
						}
                ?>
                        <tr>
                            <td style="text-align:left; padding-left:10px;">&bull;&nbsp;<?php echo $rows['CMS_STAT_PAGELOG_TITLE']?></td>

				<?php
							$where = " WHERE cms_info_code = '".$rows['CMS_STAT_PAGELOG_CODE']."'";
							$site_name = $coreClass -> selectQueryArray(tbl_cms_info, $where, "", "", "");
				?>
							<td style="text-align:left; padding-left:10px;"><?php echo $site_name['CMS_INFO_TITLE']?></td>
                            <td style="text-align:left">
								<span class="i_graph">  
									<span class="g_bar">  
										<span style="width:<?php echo $todayPercent?>%" class="g_action"></span>  
									</span>  
									<span class="g_percent">  
										<strong><?php echo $todayPercent?></strong>%
	                                </span>
	                            </span>
                            </td>
                            <td><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($todayCount)?></strong> Hit</span></span></td>
                        </tr>
                <?php } ?>
            </tbody>  
		</table>
	</div>
</div>