<?php 

	$where = "LEFT JOIN ".$tbl2." ON cms_info_code = cms_manage_scode LEFT JOIN ".$tbl3." ON mb_uid = cms_manage_uid WHERE 1=1";	
	
	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY cms_manage_regdate DESC, cms_manage_no DESC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);
?>

	<div id="cenCont_in">
		<div class="brdlist_head">
			<div class="searchBoxType1 clearfix">
				<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?></b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
			</div>
		</div>
	
	    <div class="brdlist_content">
			<table class="tbl_list1" summary="목록">
	        <caption>목록</caption>
	        <colgroup>
	        	<col style="width: 10%" />
	        	<col />
	        	<col style="width: 20%" />
	        	<col style="width: 20%" />
	        	<col style="width: 12%" />
	        	<col style="width: 10%" />
	        </colgroup>
	        
	        <thead>
	        	<tr>
					<th scope="col"><b>번호</b></th>
					<th scope="col"><b>사이트명</b></th>
					<th scope="col"><b>관리자명</b></th>
					<th scope="col"><b>관리자아이디</b></th>
					<th scope="col"><b>등록일</b></th>
					<th scope="col"><b>처리</b></th>
	            </tr>
	        </thead>
	        
	        <tbody>
				<?php
					if($paging_result < 1) {
						echo '<tr><td colspan="6">출력할 데이터가 없습니다.</td></tr>';
					} else {
						$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
						while($row = $coreClass -> selectFetchArray($rs)) {
				?>
	            <tr>
		            <td class="num"><?php echo $num?></td>
					<td class="title"><a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['CMS_MANAGE_NO']?><?php echo $listVar?>"><b><?php echo $row['CMS_INFO_TITLE']?></b></a></td>
					<td><?php echo $row['MB_NAME']?></td>
					<td><?php echo $row['MB_UID']?></td>
					<td class="date"><?php echo date("Y/m/d H:i:s", strtotime($row['CMS_MANAGE_REGDATE']))?></td>
					<td>
    					<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['CMS_MANAGE_NO']?><?php echo $listVar?>">수정</a> | 
                        <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['CMS_MANAGE_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('계정을 삭제합니까?\n\n계정정보를 삭제합니다.')) location.href=this.href; return false">삭제</a>
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
	            <?php if(!empty($search)){ ?>
	                <a href="sub.php?menukey=<?php echo $menukey?>" class="btn_big"><span>전체목록</span></a>
	            <?php } ?>
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=insert<?php echo $listVar?>" class="btn_big"><strong>등록</strong></a>
	        </div>
	       	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
	    </div>
	    
	</div>
