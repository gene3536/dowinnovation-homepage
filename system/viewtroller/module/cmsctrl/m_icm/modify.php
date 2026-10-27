<?php
	/** 2014.06.02 */
	$where	= "WHERE icm_no = '".$no."'";
	$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
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
	    	<table class="tbl_view1" summary="통합콘텐츠 수정">
	        <caption>통합콘텐츠 수정</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	            <col style="width: 80%;" />
	        </colgroup>
	        <tbody>
				<tr>
		            <th scope="row"><label for="icm_title">제목</label></th>
		            <td><input type="text" id="icm_title" name="icm_title" class="inpline" style="width:320px;" value="<?php echo $row['ICM_TITLE']?>" /></td>
				</tr>
				<tr>
		            <th scope="row"><label for="icm_pid">PID</label></th>
		            <td><input type="text" id="icm_pid" name="icm_pid" class="inpline" style="width: 172px;" value="<?php echo $row['ICM_PID']?>" /></td>
				</tr>
				<tr>
		            <th scope="row"><label for="icm_skins">스킨명</label></th>
		            <td><input type="text" id="icm_skins" name="icm_skins" class="inpline" style="width: 172px;" value="<?php echo $row['ICM_SKINS']?>" /></td>
				</tr>
				<tr>
		            <th scope="row"><label for="icm_visible">활성여부</label></th>
		            <td>
		            <select id="icm_visible" name="icm_visible" class="selline" style="width: 180px">
						<option value="Y"<?php if($row['ICM_VISIBLE'] == "Y") echo " selected=\"selected\""; ?>>활성</option>
						<option value="N"<?php if($row['ICM_VISIBLE'] == "N") echo " selected=\"selected\""; ?>>비활성</option>
		            </select>
		            </td>
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