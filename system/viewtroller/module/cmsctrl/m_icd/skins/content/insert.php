
<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>" onsubmit="return $.frmValidation();">
	<input type="hidden" id="mod" name="mod" value="process" />
	<input type="hidden" id="act" name="act" value="insert" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
    <input type="hidden" name="_filter" value="Y">

	<div id="cenCont_in">	
	    <div class="brdlist_content">
	        <table class="tbl_view1" border="1" cellspacing="0" summary="콘텐츠 등록">
	        <caption>콘텐츠 등록</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	        	<col style="width: 80%;" />
	        </colgroup>
	        
	        <tbody>
			<tr>
	        	<th scope="row"><label for="icd_title">콘텐츠명</label></th>
	            <td>
					<div style="width:100%; display:block;">
						<input type="text" id="icd_title" name="icd_title" class="inpline" style="width: 620px;" />
						<input type="text" id="scodevar" name="scodevar" class="inpline" style="width: 160px;" />
	            	</div>
					<div style="width:100%; display:block;float:left; ">
						<div style="float:left; margin:10px 5px 5px 0;">
							&bull;&nbsp;사이트 선택<br />
							<select id="menu1" size="9" style="width:180px;"></select>      		
						</div>
						<div style="float:left; margin:10px 5px 5px 0;">
							&bull;&nbsp;1차메뉴 선택<br />
							<select id="menu2" size="9" style="width:140px;"></select>      		
						</div>
						<div style="float:left; margin:10px 5px 5px 0;">
							&bull;&nbsp;2차메뉴 선택<br />
							<select id="menu3" size="9" style="width:140px;"></select>
						</div>
						<div style="float:left; margin:10px 5px 5px 0;">
							&bull;&nbsp;3차메뉴 선택<br />
							<select id="menu4" size="9" style="width:140px;"></select>
						</div>	
	            	</div>
					<div style="width:100%; display:block;">
						<div style="float:left; margin:10px 5px 5px 0;">
							&bull;&nbsp;5차메뉴 선택<br />
							<select id="menu5" size="9" style="width:140px;"></select>
						</div>	
						<div style="float:left; margin:10px 5px 5px 0;">
							&bull;&nbsp;6차메뉴 선택<br />
							<select id="menu6" size="9" style="width:140px;"></select>
						</div>	
	            	</div>				 
				</td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="icd_fld1">지도사용</label></th>
       		    <td colspan="3">
					<div>
						<input type="checkbox" id="icd_fld3" name="icd_fld3" value="Y" <?php if($row['ICD_FLD3']=="Y"){echo "checked";}?> /> 지도 사용
					</div>
					<div style="margin-top:10px;">
						&bull;&nbsp;언&nbsp;&nbsp;어
						<select name="icd_fld7">
							<option value="kr">국문</option>
							<option value="en">영문</option>
							<option value="ch">중문</option>
							<option value="jp">일문</option>
						</select>
					</div>
					<div style="margin-top:10px;">
						&bull;&nbsp;위&nbsp;&nbsp;도 <input type="text" id="icd_fld1" name="icd_fld1" class="inpline" style="width: 120px;" value="<?php echo $row['ICD_FLD1']?>" />
						&bull;&nbsp;경&nbsp;&nbsp;도 <input type="text" id="icd_fld2" name="icd_fld2" class="inpline" style="width: 120px;" value="<?php echo $row['ICD_FLD2']?>" />
					</div>
					<div style="margin-top:10px;">
						<p>
							&bull;&nbsp;타이틀 <input type="text" id="icd_fld4" name="icd_fld4" class="inpline" style="width: 50%;" value="<?php echo $row['ICD_FLD4']?>" />
						</p>
						<p style="margin-top:10px;">
							&bull;&nbsp;주&nbsp;&nbsp;소 <input type="text" id="icd_fld6" name="icd_fld6" class="inpline" style="width: 50%;" value="<?php echo $row['ICD_FLD6']?>" />
						</p>
						<p style="margin-top:10px;">
							&bull;&nbsp;내&nbsp;&nbsp;용 <textarea name="icd_txt1" id="icd_txt1" class="inpline" style="width:90%; height:120px;"></textarea>
						</p>
					</div>  
       			</td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="icd_fld5">xss 필터링</label></th>
       		    <td colspan="3">
					<select name="icd_fld5" id="icd_fld5" class="inpline" style="height:28px;">
						<option value="Y" selected>사용</option>
						<option value="N">비사용</option>
					</select>      	
       			</td>
	        </tr>		
	        <tr>
	            <th scope="row"><label for="icd_content">내용</label></th>
       		    <td colspan="3">
					<?php $coreClass -> getEditor(2, "icd_content", "100%", "400px", ""); ?>
       		    	<!--<textarea id="icd_content" name="icd_content" style="width:100%; height:400px;"></textarea>-->
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