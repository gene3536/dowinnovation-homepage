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
	              <input type="text" id="icd_title" name="icd_title" class="inpline" style="width:240px;" value="<?php echo $row['ICD_TITLE']?>">
	            </td>
			</tr>
			<tr>
	            <th scope="row"><label for="icd_sdate">게시기간</label></th>
				<td>
					<input type="text" id="icd_sdate" name="icd_sdate" class="inpline" value="<?php echo date("Y-m-d", strtotime($row['ICD_SDATE']))?>" style="width:100px; text-align:center; margin-right:4px" title="게시 시작일" />
					<input type="text" id="icd_shour" name="icd_shour" class="inpline" value="<?php echo date("H", strtotime($row['ICD_SDATE']))?>" style="width:40px; text-align:center;" /> : 
					<input type="text" id="icd_sminute" name="icd_sminute" class="inpline" value="<?php echo date("i", strtotime($row['ICD_SDATE']))?>" style="width:40px; text-align:center;" />
					-
					<input type="text" id="icd_edate" name="icd_edate" class="inpline" value="<?php echo date("Y-m-d", strtotime($row['ICD_EDATE']))?>" style="width:100px; text-align:center; margin-right:4px" title="게시 종료일" />
					<input type="text" id="icd_ehour" name="icd_ehour" class="inpline" value="<?php echo date("H", strtotime($row['ICD_EDATE']))?>" style="width:40px; text-align:center;" /> : 
					<input type="text" id="icd_eminute" name="icd_eminute" class="inpline" value="<?php echo date("i", strtotime($row['ICD_EDATE']))?>" style="width:40px; text-align:center;" />
					&nbsp;<input type="checkbox" id="datechk" name="datechk" onclick="datebtn('<?php echo date("Y-m-d", strtotime($row['ICD_EDATE']))?>');" /><label for="datechk">&nbsp;기간무제한</label>
	            </td>
			</tr>
			<tr>
	            <th scope="row"><label for="icd_type">출력유형</label></th>
	            <td>
	            <select id="icd_type" name="icd_type" class="selline" style="width:120px;">
	               	<option value="1"<?php if($row['ICD_TYPE'] == "1") { ?> selected="selected" <? } ?>>A유형</option>
	   	            <!--<option value="2"<?php if($row['ICD_TYPE'] == "2") { ?> selected="selected" <? } ?>>B유형</option>
	   	            <option value="3"<?php if($row['ICD_TYPE'] == "3") { ?> selected="selected" <? } ?>>C유형</option>-->
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
				<th><label for="thumbFile">첨부이미지</label></th>
	            <td>
	                <input type="file" id="thumbFile" name="thumbFile" class="fileline" />
	                <!--<div style="margin-top:5px;">&bull;&nbsp;A유형 : 206px X 168px<br />&bull;&nbsp;B유형 : 459px X 257px<br />&bull;&nbsp;C유형 : 정의없음</div>-->
	                <div style="margin-top:5px;">&bull;&nbsp;A유형 : 900px X 360px</div>
	                <div style="margin-top:5px;">             		
	                	&bull;&nbsp;이미지를 변경할 경우에만 등록해 주세요.<br />
	                	<?php if(!empty($row['ICD_SFILENAME'])) { ?>
	                		<img src="<?php echo $imgPath.$row['ICD_FILEYEAR']."/".$row['ICD_SFILENAME']?>" alt="<?php echo $row['ICD_TITLE']?>" style="max-width:600px;" />
						<?php } ?>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="icd_alt">이미지정보</label></th>
				<td>
					<textarea id="icd_alt" name="icd_alt" class="inpline" style="width:90%; height:100px;" /><?php echo $row['ICD_ALT']?></textarea>
		        </td>
			</tr>
	        <tr>
				<th scope="row"><label for="icd_url">링크주소</label></th>
				<td>
					<input type="text" id="icd_url" name="icd_url" class="inpline" style="width:320px;" value="<?php echo $row['ICD_URL']?>" />
					<div style="margin-top:5px;">&bull;&nbsp;http://는 제외하고 입력하여 주세요. (ex www.domain.co.kr)</div>
		        </td>
			</tr>
			<tr>
	            <th scope="row"><label for="icd_target">링크유형</label></th>
	            <td>
	            <select id="icd_target" name="icd_target" class="selline" style="width:120px">
	            	<option value="_blank"<?php if($row['ICD_TARGET'] == "_blank") { ?> selected="selected" <? } ?>>새창</option>
	   	            <option value="_self"<?php if($row['ICD_TARGET'] == "_self") { ?> selected="selected" <? } ?>>현재창</option>
	            </select>
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