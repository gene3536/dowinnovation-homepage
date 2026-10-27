<?php 	$where2 = "WHERE menu_menukey = '".$mkey."'";
	$row = $coreClass -> selectQueryArray($tbl1, $where2, "", "", "");
	// 서브메뉴 정보
	if(!empty($row['MENU_TITLE'])) {
		$locWhere	= "WHERE menu_scode = '".$row['MENU_SCODE']."' AND menu_root='".$row['MENU_ROOT']."' AND menu_depth = '1'";
		$locRow1		= $coreClass -> selectQueryArray($tbl1, $locWhere, "", "", "");
		$locTitle		= $row['MENU_TITLE'];
	
		if($row['MENU_DEPTH'] == 5) {
			$locWhere   	= "WHERE menu_scode = '".$row['MENU_SCODE']."' AND menu_menukey='".$row['MENU_REF']."' AND menu_depth = '4'";
			$locRow4  	= $coreClass -> selectQueryArray($tbl1, $locWhere, "", "", "");
			
			$locWhere   	= "WHERE menu_scode = '".$row['MENU_SCODE']."' AND menu_menukey='".$locRow4['MENU_REF']."' AND menu_depth = '3'";
			$locRow3  	= $coreClass -> selectQueryArray($tbl1, $locWhere, "", "", "");
				
			$locWhere   	= "WHERE menu_scode = '".$row['MENU_SCODE']."' AND menu_menukey='".$locRow3['MENU_REF']."' AND menu_depth = '2'";
			$locRow2  	= $coreClass -> selectQueryArray($tbl1, $locWhere, "", "", "");
				
			$location		= $locRow1['MENU_TITLE']." &gt; ".$locRow2['MENU_TITLE']." &gt; ".$locRow3['MENU_TITLE']." &gt; ".$locRow4['MENU_TITLE']." &gt; <strong>".$locTitle."</strong>";
			$locTitle		= $locRow3['MENU_TITLE'];
			$mid			= $locRow3['MENU_REF'];
			$s2id			= $locRow3['MENU_REF'];
			$s3id			= $locRow4['MENU_REF'];
			$s4id			= $locRow4['MENU_MENUKEY'];
		} else if($row['MENU_DEPTH'] == 4) {
			$locWhere   	= "WHERE menu_scode = '".$row['MENU_SCODE']."' AND menu_menukey='".$row['MENU_REF']."' AND menu_depth = '3'";
			$locRow3  	= $coreClass -> selectQueryArray($tbl1, $locWhere, "", "", "");
				
			$locWhere   	= "WHERE menu_scode = '".$row['MENU_SCODE']."' AND menu_menukey='".$locRow3['MENU_REF']."' AND menu_depth = '2'";
			$locRow2  	= $coreClass -> selectQueryArray($tbl1, $locWhere, "", "", "");
				
			$location		= $locRow1['MENU_TITLE']." &gt; ".$locRow2['MENU_TITLE']." &gt; ".$locRow3['MENU_TITLE']." &gt; <strong>".$locTitle."</strong>";
			$locTitle		= $locRow3['MENU_TITLE'];
			$mid			= $locRow3['MENU_REF'];
			$s2id			= $locRow3['MENU_REF'];
			$s3id			= $locRow3['MENU_MENUKEY'];
			$s4id			= $menukey;				
		} else if($row['MENU_DEPTH'] == 3) {
			$locWhere	= "WHERE menu_scode = '".$row['MENU_SCODE']."' AND menu_menukey='".$row['MENU_REF']."' AND menu_depth = '2'";
			$locRow2  	= $coreClass -> selectQueryArray($tbl1, $locWhere, "", "", "");
			$location		= $locRow1['MENU_TITLE']." &gt; ".$locRow2['MENU_TITLE']." &gt; <strong>".$locTitle."</strong>";
			$mid			= $row['MENU_REF'];
			$s2id			= $row['MENU_MENUKEY'];
			$s3id			= $row['MENU_REF'];
		} else {
			$location		= $locRow1['MENU_TITLE']." &gt; <strong>".$locTitle."</strong>";
			$mid			= $row['MENU_MENUKEY'];
			$s2id			= $row['MENU_MENUKEY'];
		}
	} else {
		$locTitle			= "요청하신 페이지 정보가 없습니다.";
		$location			= "요청하신 페이지 정보가 없습니다.";
	}

	$where	= " where GRD_MENUKEY = '".$mkey."' and GRD_SCODE = '".$row['MENU_SCODE']."'";
	$order	= " ORDER BY GRD_REGDATE DESC";		$rsCnt		= $coreClass -> selectQueryCount($tbl5, $where);	$tcnt = 0; $pcnt = 0;		for($i = 5 ; $i >= 1 ; $i--) {		if($i == 5) $vtitle = "매우만족";		else if($i == 4) $vtitle = "만족";		else if($i == 3) $vtitle = "보통";		else if($i == 2) $vtitle = "불만족";		else if($i == 1) $vtitle = "매우불만족";		$aWhere		= $where."	AND GRD_CNT = '".$i."'";		$aCount		= $coreClass -> selectQueryCount($tbl5, $aWhere);//, "GRD_CNT"		$survey_avg	= 0;		$survey_part	= $aCount;						 		if($rsCnt != 0) {			$survey_avg		= round((float)($aCount / $rsCnt * 100), 2);			$survey_width	= $survey_avg * 3;		}								$tcnt = $tcnt + ($aCount*$i);		$pcnt = $pcnt + $aCount;				$datas1 .= '            <tr>            	<th>'.$i.'</th>            	<td>'.$vtitle.'</td>	           	<td>					<span class="i_graph">  						<span class="g_bar">  							<span style="width:'.$survey_avg.'%" class="g_action"></span>  						</span>  					</span>		            <span class="i_graph"><span class="g_percent"><strong>'.$survey_part.'</strong> 명 / <strong>'.$survey_avg.'</strong> %</span></span>				</td>			</tr>';	} 	if($tcnt > 0 && $pcnt > 0) $avgp = round($tcnt / $pcnt, 2);		$datas2 .='<tr><th colspan="4">※ 기타의견</th></tr>';	$rs = $coreClass -> selectQuery($tbl5, $where, $order, "", "");	while($grow = $coreClass -> selectFetchArray($rs)) {			if($grow['GRD_MEMO']){			$datas2 .='	            <tr>	            	<td colspan="4">&bull;&nbsp;['.$grow['GRD_REGDATE'].'] &nbsp;'.$grow['GRD_MEMO'].'</td>				</tr>';		}	}?><div id="cenCont_in">    <div class="brdlist_content">    	<table class="tbl_view1" summary="메뉴만족도 조사">	        <caption>메뉴만족도 조사</caption>	        <colgroup>	        	<col style="width: 20%;" />
	            <col />
	        </colgroup>
	        <tbody>
	        <tr>
	        	<th scope="row">사이트명</th>
	            <td><?php echo $cmsClass -> getSiteName($row['MENU_SCODE'])?></td>
	        </tr>
	        <tr>
	        	<th scope="row">메뉴명</th>	            <td><?php echo $row['MENU_TITLE']?></td>	        </tr>	        <tr>	            <th scope="row">위치</th>	            <td><?php echo $location?></td>			</tr>			<tr>	            <th scope="row">평점</th>	            <td><strong><?php echo $avgp?></strong></td>			</tr>        </tbody>		</table>	</div>	<div style="height:10px;"></div>	<div class="brdlist_content" style="padding:10px; border:1px solid #CCC">		<div style="margin:10px 0">    	<table class="tbl_view1" summary="만족도 결과">			<caption>만족도 결과</caption>			<colgroup>	        	<col style="width: 8%;" />	        	<col style="width: 30%;" />	        	<col style="width: 62%;" />	        </colgroup> 						<tbody>				<?php echo $datas1?>				<?php echo $datas2?>	        </tbody>			</table>	    </div>    </div>	
    <div class="brdlist_footer">
	    <div class="bt">
		    <a href="sub.php?menukey=<?php echo $menukey?>&mod=list&scode=<?php echo $scode?>" class="btn_big"><span>목록</span></a>
        </div>
	</div>   
</div>