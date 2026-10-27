<?php
$where = "WHERE mb_level_lv = '".$no."'";
$row   = $coreClass->selectQueryArray($tbl4, $where, "", "", ""); 
?>

<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" name="mod" value="process" />
	<input type="hidden" name="act" value="levelModify" />
	<input type="hidden" name="no" value="<?php echo $no?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
 
	<div id="cenCont_in">
	    <div class="brdlist_content">
	        <table class="tbl_view1" border="1" cellspacing="0" summary="통합콘텐츠데이터 등록">
	        <caption>통합콘텐츠데이터 등록</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	            <col style="width: 80%;" />
	        </colgroup>
			<tbody>			
				<tr>
		            <th scope="row"><label for="mb_level_title">등급명</label></th>
		            <td>
		              <input type="text" id="mb_level_title" name="mb_level_title" value="<?php echo $row['MB_LEVEL_TITLE']?>" class="inpline" style="width:320px;" />		              
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="mb_level_visible">활성여부</label></th>
		            <td>
		            <select id="icd_visible" name="mb_level_visible" class="selline" style="width:120px">
		                <option value="Y" <?php if($row['MB_LEVEL_VISIBLE'] == "Y") echo "selected"; ?>>활성</option>
		                <option value="N" <?php if($row['MB_LEVEL_VISIBLE'] == "N") echo "selected"; ?>>비활성</option>
		            </select>
		            </td>
				</tr>
			</tbody>
			</table>
		</div>
	
	    <div class="brdlist_footer">
		    <div class="bt">
	            <button type="submit" class="btn_big"><strong>등록</strong></button>
			    <a href="sub.php?menukey=<?php echo $menukey?>&mod=levelList<?php echo $listVar?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>    
	</div>
</form>