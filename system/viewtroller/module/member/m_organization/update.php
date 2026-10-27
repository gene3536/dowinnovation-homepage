<?php // 2014.05.09	
	$where	= "WHERE organ_mb_no = '".$no."'";
	$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
?>

<form name="update" method="post" action="sub.php?menukey=<?php echo $menukey?>">    
    <input type="hidden" name="mod" value="process" />
    <input type="hidden" name="act" value="update" />
    <input type="hidden" name="no" value="<?php echo $no?>" />
    <input type="hidden" name="code1" value="<?php echo $code1?>" />
    <input type="hidden" name="code2" value="<?php echo $code2?>" />
    <input type="hidden" name="token" value="<?php echo site_config_token?>">

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" border="1" cellspacing="0" summary="담당자정보 수정">
	        <caption>담당자정보 수정</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	        	<col style="width: 80%;" />
	        </colgroup>
	        
	        <tbody>
	        <tr>
	            <th scope="row"><label for="organ_mb_position">직위/직급</label></th>
	            <td>
		            <input type="text" id="organ_mb_position" name="organ_mb_position" class="inpline" style="width:180px;" value="<?php echo $row['ORGAN_MB_POSITION']?>">
	            </td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="organ_mb_name">성명</label></th>
	            <td>
	                <input type="text" id="organ_mb_name" name="organ_mb_name" class="inpline" style="width:180px;" value="<?php echo $row['ORGAN_MB_NAME']?>">
	            </td>
	        </tr>
			<tr>
	            <th scope="row"><label for="organ_mb_tel">연락처</label></th>
	            <td>
		            <input type="text" id="organ_mb_tel" name="organ_mb_tel" class="inpline" style="width:180px;" value="<?php echo $row['ORGAN_MB_TEL']?>">
	            </td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="organ_mb_fax">팩스</label></th>
	            <td>
		            <input type="text" id="organ_mb_fax" name="organ_mb_fax" class="inpline" style="width:180px;" value="<?php echo $row['ORGAN_MB_FAX']?>">
	            </td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="organ_mb_email">이메일</label></th>
	            <td>
		            <input type="text" id="organ_mb_email" name="organ_mb_email" class="inpline" style="width:180px;" value="<?php echo $row['ORGAN_MB_EMAIL']?>">
	            </td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="organ_mb_extension">직무대리자</label></th>
	            <td>
		            <input type="text" id="organ_mb_extension" name="organ_mb_extension" class="inpline" style="width:180px;" value="<?php echo $row['ORGAN_MB_EXTENSION']?>">
	            </td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="organ_mb_content">담당업무소개</label></th>
	            <td>
					<?php $coreClass -> getEditor(site_config_editor, "organ_mb_content", "100%", "240px", $row['ORGAN_MB_CONTENT']); ?>
	            </td>
	        </tr>
		    </tbody>
	 	</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	            <button type="submit" class="btn_big" onclick="submitContents('organ_mb_content');"><strong>등록</strong></button>
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list&code1=<?php echo $code1?>&code2=<?php echo $code2?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>
	</div>
</form>