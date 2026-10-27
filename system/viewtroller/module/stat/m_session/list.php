<?php
	
	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, "");
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY cms_stat_session_regdate DESC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl1, "", $order, $snum, $rnum);	
?>
	
<div id="cenCont_in">
	<div class="brdlist_head">
	   	<div class="fl">전체 <?php echo $paging['total_record']?> [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
    </div>

    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="목록">
        <caption>목록</caption>
        <colgroup>
        	<col style="width:6%;" />
        	<col style="width:26%;" />
        	<col style="width:8%;" />
        	<col style="width:10%;" />
        	<col style="width:10%;" />
        	<col style="width:30%;" />
        	<col style="width:10%;" />
        </colgroup>
        
        <thead>
        	<tr>
				<th scope="row"><b>번호</b></th>
				<th scope="row"><b>세션ID</b></th>
				<th scope="row"><b>유저ID</b></th>
				<th scope="row"><b>유저IP</b></th>
				<th scope="row"><b>브라우저</b></th>
				<th scope="row"><b>접속시간</b></th>
				<th scope="row"><b>처리</b></th>
            </tr>
		</thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr><td colspan="7">출력할 정보가 없습니다.</td></tr>
			<?php
				} else {
					$num = $paging["total_record"] - ($paging["page"]-1) * $paging["numofrecord"];
					while($row = $coreClass -> selectFetchArray($rs)) {
			?>
                <tr>
   	                <td class="num"><?php echo $num?></td>
					<td><strong><?php echo $row['CMS_STAT_SESSION_ID']?></strong></td>
					<td><?php echo $row['CMS_STAT_SESSION_UID']?></td>
					<td><?php echo $row['CMS_STAT_SESSION_UIP']?></td>
					<td><?php echo $row['CMS_STAT_SESSION_UOS']?></td>
					<td class="date"><?php echo $row['CMS_STAT_SESSION_REGDATE']?> ~ <?php echo $row['CMS_STAT_SESSION_MODDATE']?></td>
					<td>
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['CMS_STAT_SESSION_ID']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('삭제합니까?\n\n해당내용이 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
					</td>
				</tr>
			<?php
					$num--;
					}//end of while
				}//end of if
			?>
		</tbody>
		</table>
	</div>

    <div class="brdlist_footer">
       	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
    </div>
    
	<div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="세션파일목록">
	        <caption>세션파일목록</caption>
	        <colgroup>
	        	<col width="5%" />
	        	<col width="60%" />
	            <col />
	        </colgroup>
	        
	        <thead>
	        	<tr>
					<th scope="row"><b>번호</b></th>
					<th scope="row"><b>세션파일명</b></th>
					<th scope="row"><b>생성날짜</b></th>
	            </tr>
			</thead>
			<tbody>
			<?php
				$sessionPath	= session_save_path();
				$count			= 1;
				if (!preg_match("`/$`", $sessionPath)) $sessionPath .= '/'; 
				$d				= dir($sessionPath);
				
				while (false !== ($entry = $d->read())) {
					if (substr($entry, 0, 1) != '.' && $entry != 'index.php') {
						$sessionTime = date("Y.m.d H:i:s", filemtime($sessionPath.$entry));
			?>
						<tr>
							<td class="num"><?php echo $count?></td>
							<td><?php echo $entry?></td>
							<td><?php echo $sessionTime?></td>
						</tr>		
			<?php 
						$count++;
					}
				}
				$d->close();
			?> 
			</tbody>
		</table>
	</div>
</div>

 