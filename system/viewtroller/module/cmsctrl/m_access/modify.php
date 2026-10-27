<?php	
	$where	= "WHERE acs_no = '".$no."'";
	$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "","");
?>

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>">
    <input type="hidden" name="mod" value="process">
    <input type="hidden" name="act" value="modify">
    <input type="hidden" name="no" value="<?php echo $no?>">
    <input type="hidden" name="search" value="<?php echo $search?>">
    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
    <input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" summary="접근IP 수정">
	        <caption>접근IP 수정</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	            <col style="width: 80%;" />
	        </colgroup>
	        <tbody>
	        	<tr>
		            <th scope="row"><label for="acs_title">내용</label></th>
		            <td>
						<input type="text" id="acs_title" name="acs_title" class="inpline" style="width:240px;" value="<?php echo $row['ACS_TITLE']?>">
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="acs_ip">IP</label></th>
		            <td>
						<input type="text" id="acs_ip" name="acs_ip" class="inpline" style="width:240px;" value="<?php echo $row['ACS_IP']?>">
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="acs_visible">활성여부</label></th>
		            <td>
		            <select id="acs_visible" name="acs_visible" class="selline" style="width:120px;">
		               	<option value="Y"<?php if($row['ACS_VISIBLE'] == "Y") { ?> selected="selected" <? } ?>>활성</option>
		   	            <option value="N"<?php if($row['ACS_VISIBLE'] == "N") { ?> selected="selected" <? } ?>>비활성</option>
		            </select>
		            </td>
				</tr>
	        </tbody>
			</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	            <input type="image" src="/base/imgs/btn/btn_confirm.gif" alt="확인" style="vertical-align:middle" />
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $var?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>
	</div>
</form>