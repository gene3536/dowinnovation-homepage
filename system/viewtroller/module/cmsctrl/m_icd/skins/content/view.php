<?php
	$where			= "LEFT JOIN ".tbl_cms_info." ON cms_info_code = icd_scode WHERE icd_no = '".$no."'";
	$row				= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

	// Logview
	$where			= "WHERE icd_id = '".$row['ICD_ID']."'";
	$pageC			= $pageC ? $pageC : 1;
	$paging_result	= $coreClass -> selectQueryCount($tbl2, $where);
	$numofrecord	= 20;
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $pageC);
	
	$order			= "ORDER BY icd_logdate DESC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl2, $where, $order, $snum, $rnum);
?>

<div id="cenCont_in">
    <div class="brdlist_content">
    	<table class="tbl_view1" border="1" cellspacing="0" summary="게시물 상세보기">
        <caption>상세보기</caption>
        <colgroup>
        	<col style="width: 20%;" />
            <col style="width: 80%;" />
        </colgroup>  
        <tbody>
		<tr>
			<th scope="row">사이트명</th>
            <td><?php echo $row['CMS_INFO_TITLE']?></td>
		</tr>
		<tr>
            <th scope="row">콘텐츠명</th>
            <td><?php echo $row['ICD_TITLE']?></td>
		</tr>
		<tr>
            <th scope="row">생성일 / 수정일</th>
            <td><?php echo $row['ICD_REGDATE']?> / <?php echo $row['ICD_MODDATE']?></td>
		</tr>
		<tr>
            <th scope="row">내용</th>
            <td style="padding: 10px">
                <div style="overflow:auto"><?php echo $row['ICD_CONTENT'] ?></div>
            </td>
		</tr>
        </tbody>
		</table>
	</div>
    
	<div class="brdlist_footer">
        <div class="bt">
            <a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['icd_NO']?><?php echo $listVar?>" class="btn_big"><strong>수정</strong></a>
            <a href="sub.php?menukey=<?php echo $menukey?><?php echo $listVar?>" class="btn_big"><span>목록</span></a>
        </div>
    </div>
    
    <div class="brdlist_head">
	   	<div class="fl">총 <?php echo $paging['total_record']?>건 [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
    </div>

    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="백업목록">
        <caption>백업목록</caption>
        <colgroup>
        	<col width="10%" />
            <col />
        	<col width="12%" />
        	<col width="12%" />
        	<col width="12%" />
        	<col width="12%" />
        </colgroup>
        
        <thead>
        	<tr>
				<th width="10%"><b>번호</b></th>
				<th><b>백업콘텐츠명</b></th>
				<th width="10%"><b>등록일</b></th>
				<th width="10%"><b>수정일</b></th>
				<th width="10%"><b>백업일</b></th>
				<th width="10%"><b>삭제</b></th>
            </tr>
        </thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr><td colspan="6">정보가 없습니다</td></tr>
			<?php
				} else {
					$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
					while($crow = $coreClass -> selectFetchArray($rs)) {
			?>
                <tr>
   	                <td class="num"><?php echo $num?></td>
					<td class="title"><a href="sub.php?menukey=<?php echo $menukey?>&mod=logview&no=<?php echo $row['ICD_NO']?>&logno=<?php echo $crow['ICD_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>"><strong><?php echo $crow['ICD_TITLE']?></strong></a></td>
					<td class="date"><?php echo date("Y/m/d H:i:s",strtotime($crow['ICD_REGDATE']))?></td>
					<td class="date"><?php echo date("Y/m/d H:i:s",strtotime($crow['ICD_MODDATE']))?></td>
					<td class="date"><?php echo date("Y/m/d H:i:s",strtotime($crow['ICD_LOGDATE']))?></td>
					<td>
			            <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=restore&no=<?php echo $row['ICD_NO']?>&logno=<?php echo $crow['ICD_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>">복구</a> | 
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=logdelete&no=<?php echo $row['ICD_NO']?>&logno=<?php echo $crow['ICD_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('삭제합니까?\n\n정보가 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
					</td>
				</tr>
			<?php
					$num--;
					}
				}
			?>
        </tbody>
		</table>
	</div>
</div> 