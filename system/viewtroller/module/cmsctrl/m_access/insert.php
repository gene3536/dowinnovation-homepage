

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>">
    <input type="hidden" name="mod" value="process">
    <input type="hidden" name="act" value="insert">
    <input type="hidden" name="search" value="<?php echo $search?>">
    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
    <input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" border="1" cellspacing="0" summary="접근IP 등록">
	        <caption>접근IP 등록</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	            <col style="width: 80%;" />
	        </colgroup>
	        
			<tbody>
	        	<tr>
		            <th scope="row"><label for="acs_title">내용</label></th>
		            <td>
						<input type="text" id="acs_title" name="acs_title" class="inpline" style="width: 340px;" />
	            	</td>
				</tr>
				<tr>
					<th scope="row"><label for="acs_ip">접속IP</label></th>
					<td>
						<input type="text" id="acs_ip" name="acs_ip" class="inpline" style="width: 340px;" />
					</td>
				</tr>
			</tbody>
			</table>
		</div>
	
		<div class="brdlist_footer">
		    <div class="bt">
	            <input type="image" src="/base/imgs/btn/btn_confirm.gif" alt="확인" style="vertical-align:middle" />
			    <a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div> 
	</div>
</form>