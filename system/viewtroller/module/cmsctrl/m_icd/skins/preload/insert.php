

<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data">
	<input type="hidden" name="mod" value="process" />
	<input type="hidden" name="act" value="insert" />
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
		            <th scope="row"><label for="scodevar">사이트선택</label></th>
		            <td><?php echo $cmsClass -> getSiteSelect($scode)?></td>
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
		            <select id="icd_visible" name="icd_visible" class="selline" style="width:120px">
		                <option value="Y">활성</option>
		                <option value="N">비활성</option>
		            </select>
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_title">제목</label></th>
		            <td>
		              <input type="text" id="icd_title" name="icd_title" class="inpline" style="width:320px;" />		              
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_fld1">색상코드</label></th>
		            <td>
		              <input type="text" id="icd_fld1" name="icd_fld1" class="inpline" style="width:320px;" />		              
		            </td>
				</tr>
		        <tr>
		            <th><label for="thumbFile">첨부이미지</label></th>
	            	<td>
	            		<input type="file" id="thumbFile" name="thumbFile" class="fileline" />
	            		<div style="margin-top:5px;"></div>	            	
	            	</td>
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