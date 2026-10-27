
<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" name="mod" value="process">
	<input type="hidden" name="act" value="insert">
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	        <table class="tbl_view1" border="1" cellspacing="0" summary="데이터 등록">
		        <caption>데이터 등록</caption>
		        <colgroup>
		        	<col style="width: 20%;" />
		        	<col style="width: 80%;" />
		        </colgroup>
		       
		        <tbody>
		            <tr>
		            	<th scope="row"><label for="brdskin_id">게시판 아이디명</label></th>
			            <td><input type="text" name="brdskin_id" id="brdskin_id" class="inpline" style="width: 256px;" /></td>
					</tr>
		        	<tr>
		            	<th scope="row"><label for="brdskin_name">게시판 스킨명</label></th>
			            <td><input type="text" name="brdskin_name" id="brdskin_name" class="inpline" style="width: 256px;" /></td>
					</tr>
		        </tbody>
			</table>
		</div>
	    
	    <div class="brdlist_footer">
		    <div class="bt">
	            <button type="submit" class="btn_big"><strong>등록</strong></button>
			    <a href="sub.php?menukey=<?php echo $menukey?>&mod=list" onclick="history.back(); return false;" class="btn_big"><span>취소</span></a>
	        </div>
		</div>      
	</div>
</form>