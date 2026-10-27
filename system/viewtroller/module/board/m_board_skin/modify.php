<?php
	$where = "WHERE brdskin_no = '".$no."'";
	$row = $coreClass -> selectQueryArray($tbl1, $where, "", "", "");				
?>

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" name="mod" value="process" />
	<input type="hidden" name="act" value="modify" />
	<input type="hidden" name="no" value="<?php echo $row['BRDSKIN_NO']?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" border="1" cellspacing="0" summary="데이터 수정">
		        <caption>데이터 수정</caption>
		        <colgroup>
		        	<col style="width: 20%;" />
		        	<col style="width: 80%;" />
		        </colgroup>

		        <tbody>
		            <tr>
		                <th scope="row">게시판 아이디명</th>
		                <td><?php echo $row['BRDSKIN_ID']?></td>
					</tr>
					<tr>
		            	<th scope="row"><label for="brdskin_name">게시판 스킨명</label></th>
			            <td><input type="text" name="brdskin_name" id="brdskin_name" class="inpline" style="width: 256px;" value="<?php echo $row['BRDSKIN_NAME']?>" /></td>
					</tr>
				</tbody>
			</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	            <button type="submit" class="btn_big"><strong>수정</strong></button>
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list" onclick="history.back(); return false;" class="btn_big"><span>취소</span></a>
	        </div>
		</div>    
	</div>
</form>