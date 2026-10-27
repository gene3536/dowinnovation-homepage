<?php
	$where = "WHERE 1=1"; 
	if(!empty($search) && $search == 1) {
		$where .= " AND icm_title LIKE '%".$kwd."%'";
	}

	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY icm_regdate DESC, icm_no DESC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);
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
		<table class="tbl_list1" border="1" cellspacing="0" summary="통합콘텐츠 목록">
        <caption>통합콘텐츠 목록</caption>
        <colgroup>
        	<col width="10%" />
            <col />
            <col width="10%" />
            <col width="10%" />
        	<col width="10%" />
        	<col width="10%" />
        	<col width="14%" />
        	<col width="12%" />
        </colgroup>
        <thead>
        	<tr>
				<th><b>번호</b></th>
				<th><b>제목</b></th>
				<th><b>ID</b></th>
				<th><b>PID</b></th>
				<th><b>스킨명</b></th>
				<th><b>활성여부</b></th>
				<th><b>등록일 / 수정일</b></th>
				<th><b>처리</b></th>
            </tr>
        </thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr><td colspan="8">출력할 데이터가 없습니다.</td></tr>
			<?php
				} else {
					$num = $paging["total_record"] - ($paging["page"]-1) * $paging["numofrecord"];
					while($row = $coreClass -> selectFetchArray($rs)) {
			?>
                <tr>
   	                <td class="num"><?php echo $num?></td>
					<td class="title"><a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['ICM_NO']?><?php echo $var?>"><b><?php echo $row['ICM_TITLE']?></b></a></td>
					<td><?php echo $row['ICM_ID']?></td>
					<td><?php echo $row['ICM_PID']?></td>
					<td><?php echo $row['ICM_SKINS']?></td>
					<td>
						<?php if($row['ICM_VISIBLE'] == "Y") {
								echo '<a href="sub.php?menukey='.$menukey.'&mod=process&act=visible&no='.$row['ICM_NO'].'&token='.site_config_token.$listVar.'" style="color:#00f;">[활성]</a>';
							} else { 
								echo '<a href="sub.php?menukey='.$menukey.'&mod=process&act=visible&no='.$row['ICM_NO'].'&token='.site_config_token.$listVar.'" style="color:#f00;">[비활성]</a>';
							}
						?>
                    </td>
					<td class="date">
						<?php echo date("Y/m/d H:i:s",strtotime($row['ICM_REGDATE']))?><br />
						<?php echo date("Y/m/d H:i:s",strtotime($row['ICM_MODDATE']))?>
					</td>
					<td>
                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['ICM_NO']?><?php echo $listVar?>">수정</a> | 
					<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['ICM_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('삭제합니까?\n\n내용이 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a></td>
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
            <?php if(!empty($search)) { ?>
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=list" class="btn_big"><button type="button">전체목록</button></a>
            <?php } ?>
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=insert<?php echo $listVar?>" class="btn_big strong"><button type="button">등록</button></a>
        </div>
       	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
    </div>
</div>    