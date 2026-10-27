<?php

	$where	= "LEFT JOIN ".$tbl4." ON menu_board = board_id  WHERE 1=1";	
	if(!empty($scode)) {
		$where .= " AND board_scode = '".$scode."'";
	}
	if(!empty($kwd)) {
		$where .= " AND board_name LIKE '%".$kwd."%'";
	}

	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl2, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY board_scode ASC, board_name ASC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl2, $where, $order, $snum, $rnum);
	
	if($paging_result < 1) {
		$data_list .= '<tr><td colspan="5">출력할 데이터가 없습니다.</td></tr>';
	} else {
		$num = $paging_result;
		while($row = $coreClass -> selectFetchArray($rs)){
			// 메뉴명
			if($row['MENU_VISIBLE'] == 'Y') {
				$menu_visible = '<span style="color:#00f;">활성</span>';
			} else {
				$menu_visible = '<span style="color:#f00;">비활성</span>';
			}
			
			// 게시글수
			$where = "WHERE brdata_bid = '".$row['BOARD_ID']."'";
			$rsCnt	= $coreClass -> selectQueryCount($tbl3, $where);
	           
			$data_list .= '
				<tr>
	                <td>'.$num.'</td>
	                <td>'.$row['BOARD_ID'].'</td>
	                <td class="title"><strong>'.$row['BOARD_NAME'].'</strong></td>
					<td>'.$rsCnt.'</td>
	                <td>'.$row['MENU_TITLE'].'</td>
              		<td>'.$menu_visible.'</td>
	            </tr>';
			$num--;
		}
	}
?>

<div id="cenCont_in">

	<div class="brdlist_head">
		<?php echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>
		
		<div class="searchBoxType1 clearfix" style="margin-top: 5px;">
			<div class="fr">
				<form id="searchBox" name="searchBox" method="get" action="sub.php">
					<input type="hidden" id="menukey" name="menukey" value="<?php echo $menukey?>" />
					<input type="hidden" id="mod" name="mod" value="<?php echo $mod?>" />
					<input type="hidden" id="scode" name="scode" value="<?php echo $scode?>" />
					<input type="text" name="kwd" title="검색어입력" class="inpline" maxlength="20" value="<?php echo $kwd?>" />					
					<button type="submit" class="btn_big"><span>검색</span></button>
				</form>
			</div>
		</div>
	</div>

    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="게시판목록">
        <caption>게시판목록</caption>
        <colgroup>
        	<col style="width: 6%" />
        	<col style="width: 10%" />
        	<col />
        	<col style="width: 6%" />
        	<col style="width: 16%" />
        	<col style="width: 10%" />
        </colgroup>
        
        <thead>    
            <tr>
                <th>No.</th>
                <th>게시판ID</th>
                <th>게시판명</th>
                <th>게시글수</th>
                <th>메뉴명</th>
                <th>활성여부</th>
            </tr>
		</thead>        
        <tbody><?php echo $data_list?></tbody>
		</table>
	</div>
    <div class="brdlist_footer">
        <?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
	</div>    
</div>