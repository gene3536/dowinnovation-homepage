<?php 

	// 멤버목록
	$where	= "WHERE mb_level <= 3";
	$mbRs	= $coreClass -> selectQuery($tbl3, $where, "ORDER BY mb_name ASC", "", "");
	$mbCon	.= '<select name="cms_manage_uid" id="cms_manage_uid" class="selline" style="width:180px;">';
	$mbCon	.= '<option value="">운영자선택</option>';
	while($mb = $coreClass -> selectFetchArray($mbRs)) {
		$mbCon .= '<option value="'.$mb['MB_UID'].'">'.$mb['MB_NAME'].' ('.$mb['MB_UID'].')</option>';
	}
	$mbCon .= '</select>';
?>

<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>" onsubmit="return memberInsertChk(this);">
	<input type="hidden" id="mod" name="mod" value="process" />
	<input type="hidden" id="act" name="act" value="insert" />
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
	            <td><?php echo $cmsClass -> getSiteSelect("")?></td>
			</tr>
			<tr>
	            <th scope="row"><label for="cms_manage_uid">운영자명</label></th>
	            <td><?php echo $mbCon?></td>
            </tr>
			</tbody>
			</table>
		</div>
		<div class="brdlist_footer">
			<div class="bt">
				<button type="sumbit" class="btn_big"><strong>등록</strong></button>
				<a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" class="btn_big"><span>취소</span></a>
			</div>
		</div>
	</div>
</form>