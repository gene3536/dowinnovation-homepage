<?php 
	$where	= "WHERE 1=1";
	if($search == 1 && !empty($kwd)) $where .= " AND brdskin_name LIKE '%".$kwd."%'";	
	
	$page				= $page ? $page : 1;
	$numofrecord	= 25;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY brdskin_no ASC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);
	
	if($paging_result < 1) {
		$list_data .= '<tr><td colspan="6">출력할 데이터가 없습니다.</td></tr>';		
	} else {
		while($row = $coreClass -> selectFetchArray($rs)) {
			$list_data .= '
				<tr>
                	<td>'.$row['BRDSKIN_NO'].'</td>
                	<td class="title"><a href="sub.php?menukey='.$menukey.'&mod=modify&no='.$row['BRDSKIN_NO'].'"><strong>'.$row['BRDSKIN_NAME'].'</strong></a></td>
					<td class="title">'.$row['BRDSKIN_ID'].'</td>
	                <td>'.$row['BRDSKIN_REGDATE'].'</td>
               		<td>'.$row['BRDSKIN_MODDATE'].'</td>
	                <td>
               			<a href="sub.php?menukey='.$menukey.'&mod=modify&no='.$row['BRDSKIN_NO'].'">[수정]</a>
        	        	<a href="sub.php?menukey='.$menukey.'&mod=process&act=delete&no='.$row['BRDSKIN_NO'].'&token='.site_config_token.'" onClick="if(confirm(\'해당 게시판의 데이터가 모두 삭제됩니다.\n정말 삭제하시겠습니까?\')) location.href=this.href; return false">[삭제]</a>
            	    </td>
            	</tr>';
		}		
	}
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
		<table class="tbl_list1" border="1" cellspacing="0" summary="데이터목록">
	        <caption>데이터목록</caption>
	        <colgroup>
	        	<col width="6%" />
	        	<col />
	        	<col width="24%" />
	        	<col width="16%" />
	        	<col width="16%" />
	        	<col width="10%" />
	        </colgroup>
	        
	        <thead>    
	            <tr>
	                <th>No.</th>
	                <th>스킨명</th>
	                <th>스킨아이디</th>
	                <th>등록일</th>
	                <th>수정일</th>
	                <th>처리</th>
	            </tr>
			</thead>
	        
	        <tbody><?php echo $list_data ?></tbody>
		</table>
	</div>
	
    <div class="brdlist_footer">
        <div class="bt">
	        <a href="sub.php?menukey=<?php echo $menukey?>&mod=insert" class="btn_big"><strong>등록</strong></a>
	        <?php if(!empty($search)) { ?>
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=list" class="btn_big"><span>전체목록</span></a>
            <?php } ?>
        </div>
        <?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $code1, $code2, $code3, $codes)?>
	</div>    
</div>