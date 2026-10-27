<?php // 2014.05.09	

	if($code1 == 1) {
		// 월별기록
		$getStatBrowserList = $statClass -> getStatBrowserList($scode, $thisYear);
		while($rows = $coreClass -> selectFetchArray($getStatBrowserList)) {                		
			$titleA = $rows['CMS_STAT_BROWSER_VERSION'];
			$titleB = empty($titleA) ? "이름없음" : $rows['CMS_STAT_BROWSER_TITLE'];
			$tcount = 0;
			$datas1 .= '<tr>';
			$datas1 .= '<td class="title">&nbsp;<b>'.$titleB.'</b></td>';
			for($i = 1; $i <= 12; $i++) {
				$bcount = 0;
				$bcount = $statClass -> getStatBrowserSum($scode, 3, $thisYear, $i, "", "", $titleA);
				$bcount = empty($bcount) ? 0 : $bcount;
				$datas1 .= '<td><span class="i_graph"><span class="g_percent">'.$bcount.'</span></span></td>';
				$tcount = $bcount + $tcount;
			}
			$datas1 .= '<td><span class="i_graph"><span class="g_percent"><strong>'.$tcount.'</strong></span></span></td>';
			$datas1 .= '</tr>';
		}
	} if($code1 == 2) {
		// 연도별기록
		$getStatBrowserList = $statClass -> getStatBrowserList($scode, "");
		while($rows = $coreClass -> selectFetchArray($getStatBrowserList)) {
			$titleA = $rows['CMS_STAT_BROWSER_VERSION'];
			$titleB = empty($titleA) ? "이름없음" : $rows['CMS_STAT_BROWSER_TITLE'];
			$tcount = 0;
			$datas2 .= '<tr>';
			$datas2 .= '<td class="title">&nbsp;<b>'.$titleB.'</b></td>';
			for($i = $startYear; $i <= $endYear; $i++) {
				$bcount = 0;
				$bcount = $statClass -> getStatBrowserSum($scode, 4, $i, "", "", "", $titleA);
				$bcount = empty($bcount) ? 0 : $bcount;
				$datas2 .= '<td><span class="i_graph"><span class="g_percent">'.$bcount.'</span></span></td>';
				$tcount = $bcount + $tcount;
			}
			$datas2 .= '<td><span class="i_graph"><span class="g_percent"><strong>'.$tcount.'</strong></span></span></td>';
			$datas2 .= '</tr>';
		}
	}
?>

<div id="cenCont_in">
	<?php echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>

	<div class="tabs">
		<ul>  
			<li <?php if($code1 == 1) { ?> class="on" <?php } ?>>
				<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=1&amp;scode=<?php echo $scode?>">월별기록</a>  
			</li>
			<li <?php if($code1 == 2) { ?> class="on" <?php } ?>>  
				<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=2&amp;scode=<?php echo $scode?>">연도별기록</a>  
			</li>  
		</ul>  
	</div>  

	<?php if($code1 == 1) { ?>
		<div style="padding:10px; margin:10px 0; text-align:center; border:1px solid #ccc; background-color:#eee;">
			<form name="count" method="post" action="sub.php?menukey=<?php echo $menukey?>&amp;cntTyp=<?php echo $cntTyp?>">
				<select name="year" id="year" class="selline" title="연도선택" style="width:80px;">
					<?php for($y = $endYear; $y >= $startYear; $y--) { ?>
						<option value="<?php echo $y?>" <?php if($thisYear == $y) { ?> selected="selected" <?php } ?>><?php echo $y?>년</option>
					<?php } ?>
				</select>
				<input type="image" src="imgs/btn/btn_search.gif" alt="검색" style="vertical-align:middle" />
			</form>
		</div>
        <div class="brdlist_content">
            <table class="tbl_list1" summary="월별기록">
            <caption>월별기록</caption>
            <colgroup>                
                <col />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 6%;" />
                <col style="width: 10%;" />
            </colgroup>
            <thead>    
                <tr>
                	<th><?php echo $thisYear?>년</th>
					<?php for($i = 1; $i <= 12; $i++) {?>
                    	<th><b><?php echo $i?>월</b></th>
                    <?php }?>
                    <th>총계</th>
                </tr>
            </thead>
            <tbody>
				<?php echo $datas1?>
            </tbody>  
            </table>
        </div>
        <div class="space20"></div>
	<?php } else if($code1 == 2) { ?>
        <div class="space10"></div>
		<div class="brdlist_content">
			<table class="tbl_list1" summary="연도별기록">
				<caption>연도별기록</caption>
				<colgroup>
					<col />
					<?php for($i = $startYear; $i <= $thisYear; $i++) {?>
						<col style="width: 10%;" />
					<?php } ?>
					<col style="width: 14%;" />
				</colgroup>
				
				<thead>    
					<tr>						
						<th>&nbsp;</th>
						<?php for($i = $startYear; $i <= $thisYear; $i++) {?>
                           	<th><?php echo $i?>년</th>
                        <?php } ?>
	                    <th>총계</th>
					</tr>
				</thead>
				<tbody>
				<?php echo $datas2?>
				</tbody>  
			</table>
		</div>
		<div class="space20"></div>        
	<?php } ?>
</div>