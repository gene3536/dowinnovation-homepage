<?php
	$where = "WHERE icd_pid = '".$pid."' AND icd_sdate <= '".site_date_s."' AND icd_edate >= '".site_date_s."'";
	if($search == 1) $where .= " AND icd_title LIKE '%".$kwd."%'";
	if(!empty($search) && $search == 1) {
		$where .= " AND icd_title LIKE '%".$kwd."%'";
	}
	if(!empty($scode)) {
		$where .= " AND icd_scode = '".$scode."'";
	}
	
	$order			= "ORDER BY icd_regdate DESC";
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$rs					= $coreClass -> selectQuery($tbl1, $where, $order, "", "");
	
		$x=explode("-",site_date_s); // 들어온 날짜를 년,월,일로 분할해 변수로 저장합니다.
		$s_Y=$x[0]; // 지정된 년도 
		$s_m=$x[1]; // 지정된 월
		$s_d=$x[2]; // 지정된 요일

		$s_t=date("t",mktime(0,0,0,$s_m,$s_d,$s_Y)); // 지정된 달은 몇일까지 있을까요?
		$s_n=date("N",mktime(0,0,0,$s_m,1,$s_Y)); // 지정된 달의 첫날은 무슨요일일까요?
		$l=$s_n%7; // 지정된 달 1일 앞의 공백 숫자.
		$ra=($s_t+$l)/7; $ra=ceil($ra); $ra=$ra-1; // 지정된 달은 총 몇주로 라인을 그어야 하나? 

		$n_d= date("Y-m-d",mktime(0,0,0,$s_m,$s_d+1,$s_Y)); // 다음날
		$p_d= date("Y-m-d",mktime(0,0,0,$s_m,$s_d-1,$s_Y)); // 이전날
		$n_m= date("Y-m-d",mktime(0,0,0,$s_m+1,$s_d,$s_Y)); // 다음달
		$p_m= date("Y-m-d",mktime(0,0,0,$s_m-1,$s_d,$s_Y)); // 이전달
		$n_Y= date("Y-m-d",mktime(0,0,0,$s_m,$s_d,$s_Y+1)); // 내년
		$p_Y= date("Y-m-d",mktime(0,0,0,$s_m,$s_d,$s_Y-1)); // 작년
 
		// 변수 $s 에 새로운 값을 넣고 새문서를 만들면, $s 가 들어와 원하는 값을 표시해 줍니다.
		echo ('
			<div id="cenCont_in">
				'.$cmsClass -> getSiteList($menukey, $mod, $scode).'
				<div class="brdlist_head">
					<div class="searchBoxType1 clearfix">
						<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 : <b>'.$paging_result.'</div>
				        <div class="fr">'.$coreClass -> searchBoxType3($menukey, $mod, $scode, $search, $kwd).'</div>
					</div>
				</div>
		');
		
		echo ('
			<div class="brdlist_content">
				<table class="tbl_list1" border="1" cellspacing="0" summary="일정 목록">
		        <caption>일정 목록</caption>
		        <colgroup>
		        	<col />
		        	<col width="14%" />
		        	<col width="14%" />
		        	<col width="14%" />
		        	<col width="14%" />
		        	<col width="14%" />
		        	<col width="15%" />
		        </colgroup>

				<thead>
        		<tr>
					<th colspan="7">
						<div style="float:left; padding:5px 10px;">&bull;&nbsp;'.$s_Y.'년 '.$s_m.'월</div>
						<div style="float:right; margin-right:10px;">
							<a href="sub.php?menukey='.$menukey.'&mod=view&s='.$p_Y.$listVar.'" class="btn_big"><strong>'.date('< Y년', strtotime($p_Y)).'</strong></a> | 
							<a href="sub.php?menukey='.$menukey.'&mod=view&s='.$n_Y.$listVar.'" class="btn_big"><strong>'.date('Y년 >', strtotime($n_Y)).'</strong></a>
							<a href="sub.php?menukey='.$menukey.'&mod=view&s='.$p_m.$listVar.'" class="btn_big"><strong>'.date('< m월', strtotime($p_m)).'</strong></a> | 
							<a href="sub.php?menukey='.$menukey.'&mod=view&s='.$n_m.$listVar.'" class="btn_big"><strong>'.date('m월 >', strtotime($n_m)).'</strong></a>
						</div>
						<div style="clear:both"></div>
					</th>
				</tr>
				<tr>
		            <th>일요일</td>
		            <th>월요일</td>
		            <th>화요일</td>
		            <th>수요일</td>
		            <th>목요일</td>
		            <th>금요일</td>
		            <th>토요일</td>
		        </tr>
		        </thead>
		');
 
		for($r=0;$r<=$ra;$r++){
        	echo "<tr>";
            for($z=1;$z<=7;$z++){
                $rv=7*$r+$z; $ru=$rv-$l; // 칸에 번호를 매겨줍니다. 1일이 되기전 공백들 부터 마이너스 값으로 채운 뒤 ~ 
                if($ru<=0 || $ru>$s_t) {
					echo '<td style="height:50px; text-align:center;">&nbsp;</td>';
                } else {
                    $d = date("Y-m-d",mktime(0,0,0,$s_m,$ru,$s_Y)); // 현재칸의 날짜
                    if($d == site_date_s) {
                    	echo '<td style="height:50px; text-align:center; background-color:#eee;">';
                    } else {
                    	echo '<td style="height:50px; text-align:center;">';
                    }
					echo '<a href="sub.php?menukey='.$menukey.'&mod=view&s='.$d.$listVar.'">';
					echo "$ru";
					$where	= "WHERE icd_pid = '".$pid."' AND icd_sdate <= '".$d."' AND icd_edate >= '".$d."'";
					if($search == 1) $where .= " AND icd_title LIKE '%".$kwd."%'";
					$cntRs		= $coreClass -> selectQueryCount($tbl1, $where);
					if($cntRs > 0) {
						echo '&nbsp;('.$cntRs.'건)';	
					}
					echo '</a>';					
					echo '</td>';
                }
            }
        	echo "</tr>";
    	}
    	echo "</table>";
    	echo "</div>";
    	
    	echo ('
    		<div class="brdlist_footer">
    			<div class="bt">
    				<a href="sub.php?menukey='.$menukey.'&mod=list'.$listVar.'" class="btn_big"><strong>목록보기</strong></a>
    				<a href="sub.php?menukey='.$menukey.'&mod=insert'.$listVar.'" class="btn_big"><strong>등록</strong></a>
    			</div>
    		</div>
		');
    	 
		echo '<div style="height:10px;"></div>';
		echo ('
			<div class="brdlist_content">
			<table class="tbl_list1" border="1" cellspacing="0" summary="일정 목록">
	        <caption>일정 목록</caption>
	        <colgroup>
	            <col width="10%" />
	            <col />
	        	<col width="20%" />
	        	<col width="24%" />
	        	<col width="14%" />
	        </colgroup>
	        <thead>
	        	<tr>
					<th><b>번호</b></th>
					<th><b>일정명</b></th>
					<th><b>사이트</b></th>
					<th><b>게시기간</b></th>
					<th><b>등록일</b></th>
	            </tr>
	        </thead>
		');
		
		echo '<tbody>';
		if($paging_result < 1) {
			echo '<tr><td colspan="5">일정정보가 없습니다</td></tr>';
		} else {
			$num = $paging_result;
			while($row = $coreClass -> selectFetchArray($rs)) {
				echo '<td class="num">'.$num.'</td>';
				echo '<td class="title"><b>'.$row['ICD_TITLE'].'</b></td>';
				echo '<td>';
				if($row['ICD_SCODE'] == "00000000") {
					echo "[전체]";
				} else {
					$where = "WHERE cms_info_code = '".$row['ICD_SCODE']."'";
					$rows = $coreClass -> selectQueryArray(tbl_cms_info, $where, "", "", "");
					echo "[".$rows['CMS_INFO_TITLE']."]";
				}
			echo '</td>';
			echo '<td class="date">';
			if(strtotime($row['ICD_SDATE']) <= mktime() && strtotime($row['ICD_EDATE']) >= mktime()) {
				echo '<span style="color:#00f">';
			} else {
				echo '<span style="color:#f00">';
			}
			echo date("Y/m/d", strtotime($row['ICD_SDATE']))." ~ ".date("Y/m/d", strtotime($row['ICD_EDATE']));
			echo '</span>';
			echo '</td>';
			echo '<td class="date">'.date("Y/m/d H:i:s", strtotime($row['ICD_REGDATE'])).'</td>';
			echo '</tr>';
			$num--;
			}
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>';
		echo '</div>';
?>



