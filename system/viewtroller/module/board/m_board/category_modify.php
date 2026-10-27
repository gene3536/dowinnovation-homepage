<?php
	$where	= "WHERE brdcat_bid = '".$brdcat_bid."' AND brdcat_no = '".$brdcat_no."'";
	$row		= $coreClass -> selectQueryArray(tbl_board_category, $where, "", "", "");		
?>

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" name="mod" value="process" />
	<input type="hidden" name="act" value="cmodify" />
	<input type="hidden" name="brdcat_no" value="<?php echo $row['BRDCAT_NO']?>" />
	<input type="hidden" name="brdcat_bid" value="<?php echo $row['BRDCAT_BID']?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
	<input type="hidden" name="scode" value="<?php echo $scode?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" border="1" cellspacing="0" summary="수정">
	        <caption>수정</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	        	<col style="width: 80%;" />
	        </colgroup>
	
	        <tbody>
	        	<tr>
	            	<th scope="row">테이블 ID</th>
		            <td><?php echo $row['BRDCAT_BID']?></td>
				</tr>
	        	<tr>
	            	<th scope="row"><label for="brdcat_name">카테고리명</label></th>
		            <td><input type="text" name="brdcat_name" id="brdcat_name" class="inpline" style="width:160px" value="<?php echo $row['BRDCAT_NAME']?>"></td>
				</tr>
	        	<tr>
	            	<th scope="row"><label for="brdcat_seq">순위</label></th>
		            <td><input type="text" name="brdcat_seq" id="brdcat_seq" class="inpline" style="width:160px" value="<?php echo $row['BRDCAT_SEQ']?>"></td>
				</tr>
	        </tbody>
			</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	            <button type="submit" class="btn_big"><strong>수정</strong></button>
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=catelist&brdcat_bid=<?php echo $row['brdcat_bid']?>&scode=<?php echo $scode?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>      
	</div>
</form>