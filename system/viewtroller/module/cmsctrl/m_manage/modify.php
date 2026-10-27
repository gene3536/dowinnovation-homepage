<?php 
	$where	= "WHERE cms_manage_no = '".$no."'";
	$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
?>
	
	<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>">
		<input type="hidden" name="mod" value="process" />
		<input type="hidden" name="act" value="modify" />
		<input type="hidden" name="no" value="<?php echo $row['CMS_MANAGE_NO']?>">
	    <input type="hidden" name="token" value="<?php echo site_config_token?>" />
	
		<div id="cenCont_in">
		    <div class="brdlist_content">
		        <table class="tbl_view1" border="1" cellspacing="0" summary="사이트운영자 등록">
		        <caption>사이트운영자 등록</caption>
		        <colgroup>
		        	<col style="width: 20%;" />
		        	<col style="width: 80%;" />
		        </colgroup>
		        
		        <tbody>
		        <tr>
					<th scope="row"><label for="scodevar">사이트명</label></th>
		            <td><?php echo $cmsClass -> getSiteSelect($row['CMS_MANAGE_SCODE'])?></td>
				</tr>
				<tr>
		            <th scope="row"><label for="cms_manage_uid">운영자명</label></th>
		            <td><?php echo $cmsClass -> getSiteMngSelect($row['CMS_MANAGE_UID'])?></td>
	            </tr>
				</tbody>
				</table>
			</div>
			<div class="brdlist_footer">
				<div class="bt">
					<button type="sumbit" class="btn_big"><strong>수정</strong></button>
					<a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" class="btn_big"><span>취소</span></a>
				</div>
			</div>
		</div>
	</form>