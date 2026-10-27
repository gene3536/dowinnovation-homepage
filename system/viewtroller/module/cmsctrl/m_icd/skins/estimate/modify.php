<?php
	require_once $dir2.'modify.header.php';
?>

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data">
    <input type="hidden" name="mod" value="process">
    <input type="hidden" name="act" value="modify">
    <input type="hidden" name="no" value="<?php echo $no?>">
    <input type="hidden" name="search" value="<?php echo $search?>">
    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
    <input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" summary="통합콘텐츠데이터 수정">
	        <caption>통합콘텐츠데이터 수정</caption>
	        <colgroup>
	        	<col style="width:20%;" />
	            <col style="width:80%;" />
	        </colgroup>
	        <tbody>
				<tr>
		            <th scope="row"><label for="idc_name">이름</label></th>
					<td><input type="text" name="idc_fld1" value="<?php echo $row['ICD_NAME']?>" class="inpline" style="width:320px;" /></td>
				</tr>	
				<tr>
		            <th scope="row"><label for="idc_fld1">직책</label></th>
					<td><input type="text" name="idc_fld1" value="<?php echo $row['ICD_FLD1']?>" class="inpline" style="width:320px;" /></td>
				</tr>	
				<tr>
		            <th scope="row"><label for="idc_fld2">이메일</label></th>
					<td><input type="text" name="idc_fld2" value="<?php echo $row['ICD_FLD2']?>" class="inpline" style="width:320px;" /></td>
				</tr>	
				<tr>
		            <th scope="row"><label for="idc_title">단체/회사명</label></th>
					<td><input type="text" name="idc_title" value="<?php echo $row['ICD_TITLE']?>" class="inpline" style="width:320px;" /></td>
				</tr>	
				<tr>
		            <th scope="row"><label for="idc_fld3">연락처</label></th>
					<td><input type="text" name="idc_fld3" value="<?php echo $row['ICD_FLD3']?>" class="inpline" style="width:320px;" /></td>
				</tr>	
				<tr>
		            <th scope="row"><label for="idc_content">문의내용</label></th>
					<td><textarea name="idc_content" class="inpline" style="width:90%; height:200px;"><?php echo $row['ICD_CONTENT']?></textarea></td>
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