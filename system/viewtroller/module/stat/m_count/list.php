
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
			<li <?php if($code1 == 4) { ?> class="on" <?php } ?>>
				<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=4&amp;scode=<?php echo $scode?>">시간별기록</a>  
			</li>  
		</ul>
	</div>
	
	<?php
    	switch ($code1) {
			case 1 :
	?>
		<div style="padding:10px; margin:10px 0; text-align:center; border:1px solid #ccc; background-color:#eee;">
			<form name="count" method="post" action="sub.php?menukey=<?php echo $menukey?>">
				<input type="hidden" name="code1" value="<?php echo $code1?>" />
				<input type="hidden" name="scode" value="<?php echo $scode?>" />
				
				<select name="year" id="year" class="selline" title="연도선택">
					<?php for($y = $endYear; $y >= $startYear; $y--) { ?>
						<option value="<?php echo $y?>" <?php if($thisYear == $y) { ?> selected="selected" <?php } ?>><?php echo $y?>년</option>
					<?php } ?>
				</select>
				<select name="month" id="month" class="selline" title="월선택">
					<?php for($m = 1; $m <= 12; $m++) { ?>
						<option value="<?php echo $m?>" <?php if($thisMonth == $m) { ?> selected="selected" <?php } ?>><?php echo $m?>월</option>
					<?php } ?>
				</select>
				<input type="image" src="imgs/btn/btn_search.gif" alt="검색" style="vertical-align:middle" />
			</form>
		</div>		
		<?php require_once $dir.'statChartDate.php';?>
        <div class="space20"></div>
        <div class="brdlist_content">
            <table class="tbl_list1" summary="일별기록">
            <caption>일별기록</caption>
            <colgroup>
                <col width="12%" />
                <col />
                <col width="15%" />
            </colgroup>
            <thead>    
                <tr>
                    <th scope="row"><strong>날짜</strong></th>
                    <th scope="row"></th>
                    <th scope="row"><strong>방문기록</strong></th>
                </tr>
            </thead>
            <tbody>
            	<tr>
                	<td><?php echo $thisYear."/".$thisMonth?></td>
                    <td></td>
                    <td><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($monthCount)?></strong> 명</span></span></td>
                </tr>
                <?php
                    
                    for($i = 1; $i <= $endDay; $i++) {
						$todayCount = $statClass -> getStatCountSum($scode, 2, $thisYear, $thisMonth, $i, "", "", "");
                        
                        if(!empty($todayCount)) {
                        	$todayPercent	= round(($todayCount / $monthCount * 100), 2);
                        } else {
                        	$todayCount		= 0;
                        	$todayPercent	= 0;
                        }
                ?>
                        <tr>
                            <td><?php echo $i?> 일</td>
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
                            <td><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($todayCount)?></strong> 명</span></span></td>
                        </tr>
                <?php } ?>
            </tbody>  
            </table>
        </div>
        <div class="space20"></div>
    <?php
    	break;
		case 2 :
	?>
		<div style="padding:10px; margin:10px 0; text-align:center; border:1px solid #ccc; background-color:#eee;">
			<form name="count" method="post" action="sub.php?menukey=<?php echo $menukey?>">
				<input type="hidden" name="code1" value="<?php echo $code1?>" />
				<input type="hidden" name="scode" value="<?php echo $scode?>" />
					
				<select name="year" id="year" class="selline" title="연도선택">
					<?php for($y = $endYear; $y >= $startYear; $y--) { ?>
						<option value="<?php echo $y?>" <?php if($thisYear == $y) { ?> selected="selected" <?php } ?>><?php echo $y?>년</option>
					<?php } ?>
				</select>
				<input type="image" src="imgs/btn/btn_search.gif" alt="검색" style="vertical-align:middle" />
			</form>
		</div>		
		<?php require_once $dir.'statChartMonth.php'; ?>
        <div class="space20"></div>
        <div class="brdlist_content">
            <table class="tbl_list1" summary="월별기록">
            <caption>월별기록</caption>
            <colgroup>
                <col width="12%" />
                <col />
                <col width="15%" />
            </colgroup>
            <thead>    
                <tr>
                    <th scope="row"><strong>날짜</strong></th>
                    <th scope="row"></th>
                    <th scope="row"><strong>방문기록</strong></th>
                </tr>
            </thead>
            <tbody>
            	<tr>
                	<td><?php echo $thisYear?>년</td>
                    <td></td>
                    <td><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($yearCount)?></strong> 명</span></span></td>
                </tr>
                <?
                    for($i = 1; $i <= 12; $i++) {
						$monthCount	= $statClass -> getStatCountSum($scode, 3, $thisYear, $i, "", "", "", "");
                        $monthPercent	= 0;
                        if(!empty($monthCount)) {
                        	$monthPercent = round(($monthCount / $yearCount * 100), 2);
                        } else {
                        	$monthCount = 0;
                        }
                ?>
                        <tr>
                            <td><?php echo $i?> 월</td>
                            <td style="text-align:left">
							<span class="i_graph">  
								<span class="g_bar">  
									<span style="width:<?php echo $monthPercent?>%" class="g_action"></span>  
								</span>  
								<span class="g_percent">  
									<strong><?php echo $monthPercent?></strong>%
                                </span>
                            </span>
                            </td>
                            <td><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($monthCount)?></strong> 명</span></span></td>
                        </tr>
                <?php } ?>
            </tbody>  
            </table>
        </div>
        <div class="space20"></div>   
    <?php
		break;
		case 3 :
			require_once $dir.'statChartYear.php';				
	?>
    	<div class="space20"></div>
          <div class="brdlist_content">
            <table class="tbl_list1" summary="연도별기록">
            <caption>연도별기록</caption>
            <colgroup>
                <col width="12%" />
                <col />
                <col width="15%" />
            </colgroup>
            <thead>    
                <tr>
                    <th scope="row"><strong>날짜</strong></th>
                    <th scope="row"></th>
                    <th scope="row"><strong>방문기록</strong></th>
                </tr>
            </thead>
            <tbody>
            	<tr>
                	<td>전체</td>
                    <td></td>
                    <td><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($totalCount)?></strong> 명</span></span></td>
                </tr>
                <?php
                    for($i = $startYear; $i <= $thisYear; $i++) {
                        $yearCount = $statClass -> getStatCountSum($scode, 4, $i, "", "", "", "", "");
                        
                        if(!empty($yearCount)) {
                        	$yearPercent		= round(($yearCount / $totalCount * 100), 2);
                        } else {
                        	$yearCount		= 0;
                        	$yearPercent		= 0;
                        }
                ?>
                        <tr>
                            <td><?php echo $i?> 년</td>
                            <td style="text-align:left">
							<span class="i_graph">  
								<span class="g_bar">  
									<span style="width:<?php echo $yearPercent?>%" class="g_action"></span>  
								</span>  
								<span class="g_percent">  
									<strong><?php echo $yearPercent?></strong>%
                                </span>
                            </span>
                            </td>
                            <td><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($yearCount)?></strong> 명</span></span></td>
                        </tr>
                <?php } ?>
            </tbody>  
            </table>
        </div>
        <div class="space20"></div>
    <?php
    	break;
		case 4 :
	?>
		<div style="padding:10px; margin:10px 0; text-align:center; border:1px solid #ccc; background-color:#eee;">
			<form name="count" method="post" action="sub.php?menukey=<?php echo $menukey?>">
				<input type="hidden" name="code1" value="<?php echo $code1?>" />
				<input type="hidden" name="scode" value="<?php echo $scode?>" />
				
				<select name="year" id="year" class="selline" title="연도선택">
					<?php for($y = $endYear; $y >= $startYear; $y--) { ?>
						<option value="<?php echo $y?>" <?php if($thisYear == $y) { ?> selected="selected" <?php } ?>><?php echo $y?>년</option>
					<?php } ?>
				</select>
				<select name="month" id="month" class="selline" title="월선택">
					<?php for($m = 1; $m <= 12; $m++) { ?>
						<option value="<?php echo $m?>" <?php if($thisMonth == $m) { ?> selected="selected" <?php } ?>><?php echo $m?>월</option>
					<?php } ?>
				</select>
				<select name="day" id="day" class="selline" title="일선택">
					<?php for($d = 1; $d <= $endDay; $d++) { ?>
						<option value="<?php echo $d?>" <?php if($thisDay == $d) { ?> selected="selected" <?php } ?>><?php echo $d?>일</option>
					<?php } ?>
				</select>
				<input type="image" src="imgs/btn/btn_search.gif" alt="검색" style="vertical-align:middle" />
			</form>
		</div>
		<?php require_once $dir.'statChartHour.php'; ?>
        
        <div class="space20"></div>
        <div class="brdlist_content">
            <table class="tbl_list1" summary="시간별기록">
            <caption>시간별기록</caption>
            <colgroup>
                <col width="12%" />
                <col />
                <col width="15%" />
            </colgroup>
            <thead>    
                <tr>
                    <th scope="row"><strong>시간</strong></th>
                    <th scope="row"></th>
                    <th scope="row"><strong>방문기록</strong></th>
                </tr>
            </thead>
            <tbody>
            	<tr>
                	<td><?php echo $thisYear."/".$thisMonth."/".$thisDay?></td>
                    <td></td>
                    <td><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($dayCount)?></strong> 명</span></span></td>
                </tr>
                <?
                    for($i = 0; $i <= 23; $i++) {
                    	$hourCount = $statClass -> getStatCountSum($scode, 5, $thisYear, $thisMonth, $thisDay, $i, "", "");
                    	
                    	if(!empty($hourCount)) {
                    		$hourPercent		= round(($hourCount / $dayCount * 100), 2);
                    	} else {
                    		$hourCount			= 0;
                    		$hourPercent		= 0;
                    	}
                ?>
                            <tr>
                                <td><?php echo $i?> 시</td>
                                <td style="text-align:left">
								<span class="i_graph">  
									<span class="g_bar">  
										<span style="width:<?php echo $hourPercent?>%" class="g_action">  
										</span>  
									</span>  
									<span class="g_percent">  
										<strong><?php echo $hourPercent?></strong>%
                                    </span>
                                 </span>
                                </td>
                                <td><span class="i_graph"><span class="g_percent"><strong><?php echo number_format($hourCount)?></strong> 명</span></span></td>
                            </tr>
                <?php } ?>
            </tbody>  
            </table>
        </div>
        <div class="space20"></div>   
    <?php
		break;
		}
	?>    
</div>