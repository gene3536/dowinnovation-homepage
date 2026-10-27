<?php

	$where = "LEFT JOIN ".$tbl2." ON board_id = brdlog_bid WHERE 1=1";

	if($search == 1) $where .= " AND brdlog_subject LIKE '%".$kwd."%'";
	else if($search == 3) $where .= " AND brdlog_name LIKE '%".$kwd."%'";
	switch($code1) {
		case "2":
			$where .= " AND (brdlog_type = '등록' OR brdlog_type = '수정' OR brdlog_type = '답글')";
			break;
		case "3":
			$where .= " AND (brdlog_type = '삭제' OR brdlog_type = '완전삭제' OR brdlog_type = '복구')";
			break;
		case "4":
			$where .= " AND (brdlog_type = '이동' OR brdlog_type = '복사')";
			break;
	}
	
	$page			= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY brdlog_regdate DESC";
	$snum			= $paging['startofrecord'];
	$rnum			= $paging['numofrecord'];
	$rs				= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);	
?>

<div id="cenCont_in">
	<div class="brdlist_head">
		<?php echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>
		
		<div class="searchBoxType1 clearfix" style="margin-top: 5px;">
			<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?></b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
	        <div class="fr">
	        	<form id="searchBox" name="searchBox" method="get" action="sub.php">
	        		<input type="hidden" id="menukey" name="menukey" value="<?php echo $menukey?>" />
	        		<input type="hidden" id="mod" name="mod" value="<?php echo $mod?>" />
	        		<select id="code1" name="code1" class="selline" title="검색조건" style="width:160px" onchange="submit();">
		        		<option value="1" <?php if($code1 == '1') { echo "selected=\"selected\""; }?>>전체</option>
		        		<option value="2" <?php if($code1 == '2') { echo "selected=\"selected\""; }?>>등록+수정+답글</option>
		        		<option value="3" <?php if($code1 == '3') { echo "selected=\"selected\""; }?>>삭제+완전삭제+복구</option>
		        		<option value="4" <?php if($code1 == '4') { echo "selected=\"selected\""; }?>>이동+복사</option>
		        	</select>    		
		            <?php echo $coreClass -> searchBoxType4_3($menukey, $mod, $scode, $search, $kwd, $code1, $code2)?>
				</form>
	        </div>
		</div>
	</div>
	
    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="게시글로그 목록">
        <caption>게시글로그 목록</caption>
        <colgroup>
        	<col width="6%" />
            <col />
            <col width="8%" />
        	<col width="14%" />
            <col width="8%" />
            <col width="10%" />
        	<col width="12%" />
        </colgroup>
        <thead>
        	<tr>
				<th><b>번호</b></th>
				<th><b>제목</b></th>		
				<th><b>작성자</b></th>
				<th><b>게시판명</b></th>
				<th><b>액션</b></th>
				<th><b>등록아이피</b></th>
				<th><b>등록일</b></th>
            </tr>
        </thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr><td colspan="7">정보가 없습니다</td></tr>
			<?php
				} else {
					$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
					while($row = $coreClass -> selectFetchArray($rs)) {
			?>
                <tr>
   	                <td class="num"><?php echo $num?></td>
   	                <td class="title"><b><?php echo $row['BRDLOG_SUBJECT']?></b></td>
   	                <td><?php echo $row['BRDLOG_NAME']?></td>
   	                <td class="date"><?php echo $row['BOARD_NAME']?></td>
   	                <td class="date">
   	                	<?php
   	                		if($row['BRDLOG_TYPE'] == "등록" || $row['BRDLOG_TYPE'] == "수정" || $row['BRDLOG_TYPE'] == "답글") {
   	                			echo '<span style="color:#00f">'.$row['BRDLOG_TYPE'].'</span>';
   	                		} else if($row['BRDLOG_TYPE'] == "삭제" || $row['BRDLOG_TYPE'] == "완전삭제" || $row['BRDLOG_TYPE'] == "복구") {
   	                			echo '<span style="color:#f00">'.$row['BRDLOG_TYPE'].'</span>';
							} else {
								echo '<span>'.$row['BRDLOG_TYPE'].'</span>';
							}
   	                	?>
   	                </td>
   	                <td class="date"><?php echo $row['BRDLOG_REGIP']?></td>
					<td class="date"><?php echo date("Y/m/d H:i:s",strtotime($row['BRDLOG_REGDATE']))?></td>
				</tr>
			<?php
					$num--;
					}
				}
			?>
        </tbody>
		</table>
	</div>
    
	<div class="brdlist_footer">
        <div class="bt">
            <?php if(!empty($search)){ ?>
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=list" class="btn_big"><span>전체목록</span></a>
            <?php } ?>
        </div>
       	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3, $codes)?>
    </div>
</div>    