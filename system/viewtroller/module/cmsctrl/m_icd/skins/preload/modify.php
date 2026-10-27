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
						<th scope="row"><label for="scodevar">사이트선택</label></th>
						<td><?php echo $cmsClass -> getSiteSelect($row['ICD_SCODE'])?></td>
					</tr>			
					<tr>
						<th scope="row"><label for="icd_category">분류</label></th>
						<td>
						<select id="icd_category" name="icd_category" class="selline" style="width:120px">
							<option value="00000001">일반</option>
						</select>
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
						<th scope="row"><label for="icd_title">제목</label></th>
						<td>
							<input type="text" id="icd_title" name="icd_title" class="inpline" style="width:240px;" value="<?php echo $row['ICD_TITLE']?>">              
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="icd_fld1">색상코드</label></th>
						<td>
							<input type="text" id="icd_fld1" name="icd_fld1" class="inpline" style="width:240px;" value="<?php echo $row['ICD_FLD1']?>">              
						</td>
					</tr>
					<tr>
						<th><label for="thumbFile">첨부이미지</label></th>
						<td>
							<input type="file" id="thumbFile" name="thumbFile" class="fileline" />
							<div style="margin-top:5px;">             		
								&bull;&nbsp;이미지를 변경할 경우에만 등록해 주세요.<br />
								<?php if(!empty($row['ICD_SFILENAME'])) { ?>
									<img src="<?php echo $imgPath.$row['ICD_FILEYEAR']."/".$row['ICD_SFILENAME']?>" alt="<?php echo $row['ICD_TITLE']?>" style="max-width:600px;" />
								<?php } ?>
							</div>
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