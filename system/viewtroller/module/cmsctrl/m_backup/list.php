<?php
	$where = "WHERE 1=1";
	if($search == 1) $where .= " AND bak_title LIKE '%".$kwd."%'";
	
	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where, "", "");
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY bak_regdate DESC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);
?>

<div id="cenCont_in">
    <div class="brdlist_head">
		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">
				&bull;&nbsp;전체 <b><?php echo $paging['total_record']?></b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지
				&bull;&nbsp;용량이 큰 관계로 약 1분정도 시간 소요 (백업되는 동안 사이트는 접속에 장애가 발생 할 수 있습니다.)
			</div>
		</div>
	</div>
	
    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="데이터백업 목록">
        <caption>데이터백업 목록</caption>
        <colgroup>
        	<col width="8%" />
            <col />
        	<col width="8%" />
        	<col width="8%" />
        	<col width="20%" />
        	<col width="10%" />
        	<col width="14%" />
        	<col width="10%" />
        </colgroup>
        
        <thead>
        	<tr>
				<th scope="row"><b>번호</b></th>
				<th scope="row"><b>백업내용</b></th>
				<th scope="row"><b>백업유형</b></th>
				<th scope="row"><b>파일여부</b></th>
				<th scope="row"><b>파일명</b></th>
				<th scope="row"><b>파일크기</b></th>
				<th scope="row"><b>백업일</b></th>
				<th scope="row"><b>처리</b></th>
            </tr>
		</thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr>
                	<td colspan="8">데이터백업 정보가 없습니다</td>
                </tr>
			<?php
				} else {
					$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
					while($row = $coreClass -> selectFetchArray($rs)){
			?>
                <tr>
   	                <td class="num"><?php echo $num?></td>
					<td><strong><?php echo date("Y/m/d", strtotime($row['BAK_YEAR']."-".$row['BAK_MONTH']."-".$row['BAK_DAY']))." 데이터 백업"?></strong></td>
					<td>
						<?php 
							if($row['BAK_TYPE'] == 1) {
								echo "웹";
							} else {
								echo "DB";
							}
						?>
					</td>
					<td>
						<?php 
							if(is_file($save_path.$row['BAK_FILENAME'])) {
								echo "<span style=\"color:#00f\">있음</span>";
							} else {
								echo "<span style=\"color:#f00\">없음</span>";
							}						
						?>
					</td>
					<td><?php echo $row['BAK_FILENAME']?></td>
					<td><?php echo number_format($row['BAK_FILESIZE'])?> KB</td>
					<td class="date">
						<?php echo date("Y-m-d H:i:s",strtotime($row['BAK_REGDATE']))?>
					</td>
					<td>
						<a href="/base/download/backup.php?no=<?php echo $row['BAK_NO']?>">[다운]</a>
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['BAK_NO']?>&token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?\n\n해당내용이 모두 삭제됩니다.')) location.href=this.href; return false">[삭제]</a>
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
        <div class="bt">
        	<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=wbak&token=<?php echo site_config_token?>" class="btn_pack medium"><button>웹소스백업</button></a>
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=dbak&token=<?php echo site_config_token?>" class="btn_pack medium"><button>DB백업</button></a>
        </div>
		<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
    </div>
</div>