<?php

	$where	= "WHERE BRDCAT_bid = '".$brdcat_bid."'";
	$order	= "ORDER BY BRDCAT_no";
	$result	= $coreClass -> selectQuery(tbl_board_category, $where, $order, "", "");			
	$rsCnt		= $coreClass -> selectQueryCount(tbl_board_category, $where);			
?>

<div id="cenCont_in">
    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="카테고리목록">
        <caption>카테고리목록</caption>
        <colgroup>
        	<col style="width: 15%" />
        	<col style="width: 25%" />
        	<col style="width: 10%" />
        	<col style="width: 30%" />
        	<col style="width: 20%" />
        </colgroup>
        
        <thead>  
            <tr>
                <th>No.</th>
                <th>분류명</th>
                <th>정렬</th>
                <th>게시판ID</th>
                <th>처리</th>
            </tr>
			<?php if($rsCnt < 0) { ?>
				<tr>
                	<td colspan="4">카테고리 정보가 없습니다</td></tr>
			<?php
				} else {
					while($row = $coreClass -> selectFetchArray($result)) {
			?>
            <tr>
                <td><?php echo $row['BRDCAT_NO']?></td>
                <td><?php echo $row['BRDCAT_NAME']?></td>
                <td><?php echo $row['BRDCAT_SEQ']?></td>
                <td><?php echo $row['BRDCAT_BID']?></td>
                <td>
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=category_modify&brdcat_bid=<?php echo $row['BRDCAT_BID']?>&brdcat_no=<?php echo $row['BRDCAT_NO']?>&scode=<?php echo $scode?>">수정</a> | 
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=cdelete&brdcat_bid=<?php echo $row['BRDCAT_BID']?>&brdcat_no=<?php echo $row['BRDCAT_NO']?>&token=<?php echo site_config_token?>&scode=<?php echo $scode?>" onClick="if(confirm('데이터가 모두 삭제됩니다.\n정말 삭제하시겠습니까?')) location.href=this.href; return false">삭제</a>
                </td>
            </tr>
	    <?
				}
			}
		?>
		</table>
	</div>
 
    <div class="brdlist_footer">
        <div class="bt">
	        <a href="sub.php?menukey=<?php echo $menukey?>&mod=category_insert&brdcat_bid=<?php echo $brdcat_bid?>&scode=<?php echo $scode?>" class="btn_big"><strong>추가</strong></a>
	        <a href="sub.php?menukey=<?php echo $menukey?>&mod=list&scode=<?php echo $scode?>" class="btn_big"><span>게시판목록</span></a>
        </div>
	</div>      
</div>