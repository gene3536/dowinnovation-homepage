<?php
	// 멤버유형
	$orgRs	= $coreClass -> selectQuery($tbl3, "", "ORDER BY mb_org_no ASC", "", "");
	$orgCon	.= '<select name="mb_org" id="mb_org" class="selline" style="width:140px;">';
	while($org = $coreClass -> selectFetchArray($orgRs)) {
		$orgCon .= '<option value="'.$org['MB_ORG_ID'].'">'.$org['MB_ORG_NAME'].'</option>';
	}
	$orgCon .= '</select>';
	
	// 멤버등급
	$levelRs	= $coreClass -> selectQuery($tbl4, "WHERE mb_level_visible = 'Y'", "ORDER BY mb_level_lv DESC", "", "");
	$levelCon .= '<select name="mb_level" id="mb_level" class="selline" style="width:140px;">';
	while($level = $coreClass -> selectFetchArray($levelRs)) {
		$levelCon .= '<option value="'.$level['MB_LEVEL_LV'].'">'.$level['MB_LEVEL_LV'].' ('.$level['MB_LEVEL_TITLE'].')</option>';
	}
	$levelCon .= '</select>';
?>

<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>" onsubmit="return memberInsertChk(this);">
	<input type="hidden" id="mod" name="mod" value="process" />
	<input type="hidden" id="act" name="act" value="insert" />
	<input type="hidden" id="ichk" name="ichk" value="false" />    
    <input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	        <table class="tbl_view1" border="1" cellspacing="0" summary="멤버정보 등록">
	        <caption>멤버정보 등록</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	        	<col style="width: 80%;" />
	        </colgroup>
	        
	        <tbody>
			<tr>
				<th scope="row"><label for="scodevar">사이트선택</label></th>
				<td colspan="3"><?php echo $cmsClass -> getSiteSelect($scode)?></td>
			</tr>
	        <tr>
				<th scope="row"><label for="info1">회원이름</label></th>
	            <td><input type="text" id="info1" name="info1" class="inpline" style="width:180px;" /></td>
			</tr>
			<tr>
	            <th scope="row"><label for="info2">회원아이디</label></th>
	            <td>
	              <input type="text" id="info2" name="info2" class="inpline" maxlength="12" style="width:180px;" onkeyup="memberIdChk();" />	
	              &nbsp;<span id="idchk"></span>	
	            </td>	
			</tr>
			<tr>
	 	         <th scope="row"><label for="info3">비밀번호</label></th>
		         <td style="text-align:left">
	    	         <input type="password" id="info3" name="info3" class="inpline" style="width:120px;" />&nbsp;&nbsp;
	                 <label for="info4"><strong>비밀번호 재입력</strong></label>&nbsp;
	                 <input type="password" id="info4" name="info4" class="inpline" style="width:120px;" />
	             </td>
			</tr>
            <tr>
	            <th scope="row"><label for="mb_level">멤버레벨</label></th>
	            <td><?php echo $levelCon?></td>
            </tr>
			<tr>
	            <th scope="row"><label for="mb_org">멤버분류</label></th>
	            <td><?php echo $orgCon?></td>
            </tr>
	        <tr>
				<th scope="row"><label for="mb_tel">연락처</label></th>
	            <td><input type="text" id="mb_tel" name="mb_tel" class="inpline" style="width:180px;" /></td>
			</tr>
	        <tr>
				<th scope="row"><label for="mb_email">이메일</label></th>
	            <td><input type="text" id="mb_email" name="mb_email" class="inpline" style="width:180px;" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="scodevar">담당홈페이지</label></th>
	            <td><?php echo $cmsClass -> getSiteSelect("")?></td>
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