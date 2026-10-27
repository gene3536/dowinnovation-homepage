<?php 
	$where	= "WHERE organ_no = '".$no."'";
	$row		= $coreClass -> selectQueryArray(tbl_organization, $where, "", "", "");
?>

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>">    
    <input type="hidden" name="mod" value="process" />
    <input type="hidden" name="act" value="modify" />
    <input type="hidden" name="no" value="<?php echo $no?>" />
    <input type="hidden" name="code1" value="<?php echo $code1?>" />
    <input type="hidden" name="code2" value="<?php echo $code2?>" />
    <input type="hidden" name="token" value="<?php echo site_config_token?>">

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" border="1" cellspacing="0" summary="부서정보 수정">
	        <caption>부서정보 수정</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	        	<col style="width: 80%;" />
	        </colgroup>
	        
	        <tbody>
	        <tr>
	            <th scope="row"><label for="organ_name">부서명</label></th>
	            <td>
	              <input type="text" id="organ_name" name="organ_name" class="inpline" style="width:180px;" value="<?php echo $row['ORGAN_NAME']?>">
	            </td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="organ_step">부서순서</label></th>
	            <td>
	              <input type="text" id="organ_step" name="organ_step" class="inpline" style="width:180px;" value="<?php echo $row['ORGAN_STEP']?>">
	            </td>
	        </tr>
		<?php if($row['ORGAN_DEPTH'] == "1") { ?>
	        <tr>
	            <th scope="row"><label for="organ_extension">업무분장 담당자</label></th>
	            <td>
	              <input type="text" id="organ_extension" name="organ_extension" class="inpline" style="width:180px;" value="<?php echo $row['ORGAN_EXTENSION']?>">
	            </td>
	        </tr>
		<?php } ?>
	        <tr>
	        	<th scope="row"><label for="organ_uid">부서관리자</label></th>
	        	<td>
	        		<select id="organ_uid" name="organ_uid" class="selline" style="width:240px;">
	        			<option value="">없음</option>
	                	<?php
	                		$where	= "WHERE mb_level < 6";
	                		$order	= "ORDER BY mb_name ASC";
							$rs			= $coreClass -> selectQuery(tbl_member, $where, $order, "");
							while($rowm = $coreClass -> selectFetchArray($rs)) {
						?>                
	    	            	<option value="<?php echo $rowm['MB_UID']?>"<?php if($row['ORGAN_UID'] == $rowm['MB_UID']) echo ' selected="selected"';?>><?php echo $rowm['MB_NAME']?> (<?php echo $rowm['MB_UID']?>)</option>
	                	<?php } ?>
	                </select>
				</td>
			</tr>
	        <tr>
	            <th scope="row"><label for="organ_visible1">활성여부</label></th>
	            <td>
	            	<label><input type="radio" id="organ_visible1" name="organ_visible" value="Y" <?php if($row['ORGAN_VISIBLE'] == "Y") { ?> checked="checked" <?php } ?> /> 활성</label>
	                <label><input type="radio" id="organ_visible2" name="organ_visible" value="N" <?php if($row['ORGAN_VISIBLE'] == "N") { ?> checked="checked" <?php } ?> /> 비활성</label>                
	            </td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="organ_content">부서소개</label></th>
	            <td>
	            	<?php $coreClass -> getEditor(site_config_editor, "organ_content", "100%", "240px", $row['ORGAN_CONTENT']); ?>
	            </td>
	        </tr>
		    </tbody>
	 	</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	            <button type="submit" class="btn_big" onclick="submitContents('organ_mb_content');"><strong>수정</strong></button>
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list&code1=<?php echo $code1?>&code2=<?php echo $code2?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>
	</div>
</form>