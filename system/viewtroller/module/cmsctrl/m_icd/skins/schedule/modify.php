<?php
	require_once $dir2.'modify.header.php';
?>

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>" onsubmit="return $.frmValidation();">
    <input type="hidden" name="mod" value="process">
    <input type="hidden" name="act" value="modify">
    <input type="hidden" name="no" value="<?php echo $no?>">
    <input type="hidden" name="search" value="<?php echo $search?>">
    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
    <input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" summary="일정 수정">
	        <caption>일정 수정</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	            <col style="width: 80%;" />
	        </colgroup>
	        <tbody>
	        	<tr>
		            <th scope="row"><label for="scodevar">사이트선택</label></th>
		            <td><?php echo $cmsClass -> getSiteSelect($row['ICD_SCODE'])?></td>
				</tr>
	        	<tr>
		            <th scope="row"><label for="icd_title">제목</label></th>
		            <td>
		              <input type="text" id="icd_title" name="icd_title" class="inpline" style="width:320px;" value="<?php echo $row['ICD_TITLE']?>">
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_visible">활성여부</label></th>
		            <td>
		            <select id="icd_visible" name="icd_visible" class="selline" style="width:120px;">
		               	<option value="Y"<?php if($row['ICD_VISIBLE'] == "Y") { ?> selected="selected" <? } ?>>활성</option>
		   	            <option value="N"<?php if($row['ICD_VISIBLE'] == "N") { ?> selected="selected" <? } ?>>비활성</option>
		            </select>
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_sdate">게시기간</label></th>
					<td>
						<input type="text" id="icd_sdate" name="icd_sdate" class="inpline" value="<?php echo date("Y-m-d", strtotime($row['ICD_SDATE']))?>" style="width:100px; text-align:center; margin-right:4px" title="게시 시작일" />
						-
						<input type="text" id="icd_edate" name="icd_edate" class="inpline" value="<?php echo date("Y-m-d", strtotime($row['ICD_EDATE']))?>" style="width:100px; text-align:center; margin-right:4px" title="게시 종료일" />
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_content">내용</label></th>
	       		    <td colspan="3">
	       		    	<?php $coreClass -> getEditor(site_config_editor, "icd_content", "100%", "400px", $row['ICD_CONTENT']); ?>
	       			</td>
		        </tr>
	        </tbody>
			</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	            <button type="submit" class="btn_big"><strong>수정</strong></button>
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $var?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>
	</div>
</form>