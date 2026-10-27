<?php

	if(empty($code1)) {
		$where = "WHERE 1=1";
	} else {
		$where = "WHERE cms_info_type = '".$code1."'";
	}
	
	$page				= $page ? $page : 1;
	$numofrecord	= 40;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY cms_info_no DESC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);
?>

<div id="cenCont_in">
	<div class="brdlist_head">
		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?>건</b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
			<div class="fr">
			<form name="search" method="post" action="sub.php?menukey=<?php echo $menukey?>&mod=<?php echo $mod?>">
				<select name="code1" onchange="submit()" class="selline" style="width:120px;">
					<option value="0"<?php if($code1 == 0) echo " selected=\"selected\"";?>>전체</option>
					<option value="1"<?php if($code1 == 1) echo " selected=\"selected\"";?>>메인형</option>
					<option value="2"<?php if($code1 == 2) echo " selected=\"selected\"";?>>가상형</option>
					<option value="3"<?php if($code1 == 3) echo " selected=\"selected\"";?>>부속형</option>
					<option value="4"<?php if($code1 == 4) echo " selected=\"selected\"";?>>부서형</option>
					<option value="5"<?php if($code1 == 5) echo " selected=\"selected\"";?>>기타</option>
				</select>
			</form>
			</div>
		</div>
	</div>
	
    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="사이트 목록">
        <caption>사이트 목록</caption>
        <colgroup>
        	<col style="width: 6%;" />
        	<col />
        	<col style="width: 6%;" />
        	<col style="width: 14%;" />
        	<col style="width: 14%;" />
        	<col style="width: 8%;" />
        	<col style="width: 8%;" />
        	<col style="width: 10%;" />
        </colgroup>

        <thead>
        	<tr>
				<th><b>번호</b></th>
				<th><b>제목</b></th>
				<th><b>코드</b></th>
				<th><b>URL1</b></th>
				<th><b>URL2</b></th>
				<th><b>PATH</b></th>
				<th><b>유형</b></th>
				<th><b>처리</b></th>
            </tr>
        </thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr><td colspan="8">출력할 정보가 없습니다.</td></tr>
			<?php
				} else {
					$num = $paging["total_record"] - ($paging["page"]-1) * $paging["numofrecord"];
					while($row = $coreClass -> selectFetchArray($rs)) {
			?>
                <tr>
   	                <td class="num"><?php echo $num?></td>
   	                <td class="title">
   	                	<a href="http://<?php echo $row['CMS_INFO_URL1'].$row['CMS_INFO_PATH']?>" target="_blank" style="color:#00f;">[이동]</a>&nbsp;
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['CMS_INFO_NO']?><?php echo $var?>"><b><?php echo $row['CMS_INFO_TITLE']?></b></a>
					</td>
					<td class="date"><?php echo $row['CMS_INFO_CODE']?></td>
					<td class="date"><?php echo $row['CMS_INFO_URL1']?></td>
					<td class="date"><?php echo $row['CMS_INFO_URL2']?></td>
					<td class="date"><?php echo $row['CMS_INFO_PATH']?></td>
					<td>
						<?php 
							if($row['CMS_INFO_TYPE'] == 1) {
								echo "메인형";
							} else if($row['CMS_INFO_TYPE'] == 2) {
								echo "가상형";
							} else if($row['CMS_INFO_TYPE'] == 3) {
								echo "부속형";
							} else if($row['CMS_INFO_TYPE'] == 4) {
								echo "부서형";
							} else if($row['CMS_INFO_TYPE'] == 5) {
								echo "기타형";
							}
						?>
					</td>
					<td>
	                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['CMS_INFO_NO']?><?php echo $listVar?>">수정</a> | 
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['CMS_INFO_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('삭제합니까?\n\n내용이 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
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
    
	<div class="brdlist_footer">
		<div class="bt">
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=insert<?php echo $listVar?>" class="btn_big"><strong>등록</strong></a>
		</div>
       	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
	</div>
</div>    