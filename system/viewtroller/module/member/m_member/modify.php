<?php
    /** 140624 */
	$where	= "WHERE mb_no = '".$no."'";
	$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

	$orgRs	= $coreClass -> selectQuery($tbl3, "", "ORDER BY mb_org_no ASC", "", "");
	$levelRs	= $coreClass -> selectQuery($tbl4, "WHERE mb_level_visible = 'Y'", "ORDER BY mb_level_lv DESC", "", "");
?>

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>">
    <input type="hidden" name="mod" value="process">
    <input type="hidden" name="act" value="modify">
    <input type="hidden" name="no" value="<?php echo $row['MB_NO']?>">
    <input type="hidden" name="search" value="<?php echo $search?>">
    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
    <input type="hidden" name="token" value="<?php echo site_config_token?>">

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" border="1" cellspacing="0" summary="멤버정보 수정">
	        <caption>멤버정보 수정</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	        	<col style="width: 80%;" />
	        </colgroup>
	        
	        <tbody>
	    	<tr>
		        <th scope="row">회원아이디</th>
		        <td><?php echo $row['MB_UID']?></td>
	        </tr>
	        <tr>
		        <th scope="row">회원이름</th>
	            <td><?php echo $row['MB_NAME']?> (<?php echo $row['MB_LEVEL']?>)
					<!-- <input type="text" name="mb_name" id="mb_name" value="<?php echo $row['MB_NAME']?>" class="inpline" style="width:120px;"> -->
				</td>
	        </tr>
	        <tr>
		        <th scope="row"><label for="info3">비밀번호</label></th>
		        <td style="text-align:left">
			        <input type="password" id="info3" name="info3" class="inpline" style="width:140px;" value="" />
	                <label for="info4"><strong>비밀번호 재입력</strong></label>&nbsp;<input type="password" id="info4" name="info4" class="inpline" style="width:140px;" value="" />
		        	<div style="margin:10px 0 0 10px;">* 비밀번호를 변경할 경우에만 입력하세요.</div>
				</td>
			</tr>
	        <tr>
		        <th scope="row"><label for="mb_level">멤버등급</label></th>
		        <td>
                    <select name="mb_level" id="mb_level" class="selline" style="width:160px;">
                        <?php
                            while($rowc = $coreClass -> selectFetchArray($levelRs)) {
                        ?>
                            <option value="<?php echo $rowc['MB_LEVEL_LV']?>" <?php if($rowc['MB_LEVEL_LV'] == $row['MB_LEVEL']) echo "selected";?>><?php echo $rowc['MB_LEVEL_LV']?> Lv (<?php echo $rowc['MB_LEVEL_TITLE']?>)</option>
                        <?php } ?>
                    </select>
	            </td>
			</tr>
			<tr>
	            <th scope="row"><label for="mb_org">멤버유형</label></th>
	            <td>
	                <select name="mb_org" id="mb_org" class="selline" style="width:160px;">
                        <?php
                            while($rowo = $coreClass -> selectFetchArray($orgRs)) {
                        ?>
                            <option value="<?php echo $rowo['MB_ORG_ID']?>" <?php if($rowo['MB_ORG_ID'] == $row['MB_ORG']) echo "selected";?>><?php echo $rowo['MB_ORG_NAME']?></option>
                        <?php } ?>
                    </select>
	            </td>
            </tr>
	        <tr>
				<th scope="row"><label for="mb_tel">연락처</label></th>
	            <td><input type="text" id="mb_tel" name="mb_tel" class="inpline" style="width:180px;" value="<?php echo $coreClass -> decrypt_md5($row['MB_TEL'], site_config_mbkey); ?>" /></td>
			</tr>
	        <tr>
				<th scope="row"><label for="mb_email">이메일</label></th>
	            <td><input type="text" id="mb_email" name="mb_email" class="inpline" style="width:180px;" value="<?php echo $coreClass -> decrypt_md5($row['MB_EMAIL'], site_config_mbkey); ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="scodevar">담당홈페이지</label></th>
	            <td><?php echo $cmsClass -> getSiteSelect($row['MB_SCODE'])?></td>
			</tr>
	        </tbody>
		</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	    		<button type="submit" class="btn_big"><strong>수정</strong></button>
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>
	</div>
</form>