<?php 
	$where = "WHERE 1=1";
	
	// 검색분류
	if($search == 1) {
		$where .= " AND mb_level_title like '%".$kwd."%'";
	}

	$page			= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl4, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY mb_level_lv DESC";
	$snum			= $paging['startofrecord'];
	$rnum			= $paging['numofrecord'];
	$rs				= $coreClass -> selectQuery($tbl4, $where, $order, $snum, $rnum);
?>
<div id="cenCont_in">

	<div class="brdlist_head">
		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?></b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
	        <div class="fr">
	            <?php echo $coreClass -> searchBoxType3($menukey, $mod, $scode, $search, $kwd)?>        
	        </div>
		</div>
	</div>
	
    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="통합콘텐츠데이터 목록">
        <caption>통합콘텐츠데이터 목록</caption>
        <colgroup>
        	<col width="6%" />
            <col />
        	<col width="6%" />
        	<col width="15%" />
        	<col width="15%" />
        	<col width="15%" />
        </colgroup>
        <thead>
        	<tr>
				<th><b>번호</b></th>
				<th><b>등급명</b></th>
				<th><b>활성여부</b></th>
				<th><b>등록IP / 수정IP</b></th>
				<th><b>등록일 / 수정일</b></th>
				<th><b>처리</b></th>
            </tr>
        </thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr><td colspan="6">출력할 데이터가 없습니다.</td></tr>
			<?php
				} else {
					$num = $paging["total_record"] - ($paging["page"]-1) * $paging["numofrecord"];
					while($row = $coreClass -> selectFetchArray($rs)) {
			?>
                <tr>
   	                <td class="num"><?php echo $num?></td>
					<td class="title">
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=levelModify&no=<?php echo $row['MB_LEVEL_LV']?><?php echo $var?>"><b><?php echo $row['MB_LEVEL_TITLE']?></b></a>
					</td>
					<td>
						<?php if($row['MB_LEVEL_VISIBLE'] == "Y") {
								echo "<span style=\"color:#00f\">[활성]</span>";
							} else { 
								echo "<span style=\"color:red;\">[비활성]</span>";
							}
						?>
                    </td>
					<td class="date">
						<?php echo $row['MB_LEVEL_REGIP']?><br />
						<?php echo $row['MB_LEVEL_MODIP']?>
					</td>
					<td class="date">
						<?php echo date("Y/m/d H:i:s",strtotime($row['MB_LEVEL_REGDATE']))?><br />
						<?php echo date("Y/m/d H:i:s",strtotime($row['MB_LEVEL_MODDATE']))?>
					</td>
					<td>
                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=levelModify&no=<?php echo $row['MB_LEVEL_LV']?>">수정</a> | 
					<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=levelDelete&no=<?php echo $row['MB_LEVEL_LV']?>&token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?\n\n내용이 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a></td>
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
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=levelList" class="btn_big"><span>전체목록</span></a>
            <?php } ?>
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=levelInsert<?php echo $listVar?>" class="btn_big strong"><strong>등록</strong></a>
        </div>
       	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
    </div>
</div>    