<?php /** 2014.05.13 */ ?>

<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" name="mod" value="process" />
	<input type="hidden" name="act" value="insert" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
 
	<div id="cenCont_in">
	    <div class="brdlist_content">
	        <table class="tbl_view1" border="1" cellspacing="0" summary="통합콘텐츠 등록">
	        <caption>통합콘텐츠 등록</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	            <col style="width: 80%;" />
	        </colgroup>
			<tbody>
				<tr>
		            <th scope="row"><label for="icd_title">제목</label></th>
		            <td><input type="text" id="icd_title" name="icd_title" class="inpline" style="width:320px;" /></td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_skins">스킨명</label></th>
		            <td><input type="text" id="icd_skins" name="icd_skins" class="inpline" style="width:320px;" /></td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_visible">활성여부</label></th>
		            <td>
		            <select id="icd_visible" name="icd_visible" class="selline" style="width:120px">
		                <option value="Y">활성</option>
		                <option value="N">비활성</option>
		            </select>
		            </td>
				</tr>
			</tbody>
			</table>
		</div>
	
	    <div class="brdlist_footer">
		    <div class="bt">
	            <button type="submit" class="btn_big"><strong>등록</strong></button>
			    <a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>    
	</div>
</form>