<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>" onsubmit="return $.frmValidation();">
	<input type="hidden" name="mod" value="process" />
	<input type="hidden" name="act" value="insert" />
	<input type="hidden" name="scode" value="<?php echo $scode?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
 
	<div id="cenCont_in">
	    <div class="brdlist_content">
	        <table class="tbl_view1" border="1" cellspacing="0" summary="팝업 등록">
	        <caption>팝업 등록</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	            <col style="width: 80%;" />
	        </colgroup>
			<tbody>
				<?php if(S_mb_level <= site_config_level){?>
				<tr>
		            <th scope="row"><label for="scodevar">사이트선택</label></th>
		            <td><?php echo $cmsClass -> getSiteSelect($scode)?></td>
				</tr>
				<?}else{?>
				<input type="hidden" name="scodevar" value="<?php echo S_mb_scode?>" />				
				<?}?>

				<tr>
		            <th scope="row"><label for="icd_title">제목</label></th>
		            <td>
		              <input type="text" id="icd_title" name="icd_title" class="inpline" style="width:320px;" />
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_sdate">게시기간</label></th>
		            <td>
		              <input type="text" id="icd_sdate" name="icd_sdate" class="inpline" value="<?php echo site_date_c1?>" style="width:100px; text-align:center; margin-right:4px" title="게시 시작일" />
		              <input type="text" id="icd_shour" name="icd_shour" class="inpline" value="00" style="width:40px; text-align:center;" /> : 
		              <input type="text" id="icd_sminute" name="icd_sminute" class="inpline" value="00" style="width:40px; text-align:center;" />
		              -
		              <input type="text" id="icd_edate" name="icd_edate" class="inpline" value="<?php echo site_date_c2?>" style="width:100px; text-align:center; margin-right:4px" title="게시 종료일" />
		              <input type="text" id="icd_ehour" name="icd_ehour" class="inpline" value="23" style="width:40px; text-align:center;" /> : 
		              <input type="text" id="icd_eminute" name="icd_eminute" class="inpline" value="59" style="width:40px; text-align:center;" />
		            </td>
				</tr>
				<tr>
	            	<th scope="row"><label for="icd_width">팝업크기</label></th>
		            <td>
		            	<input type="text" id="icd_width" name="icd_width" class="inpline" style="width:100px;" title="가로크기" />  x
		            	<input type="text" id="icd_height" name="icd_height" class="inpline" style="width:100px;" title="세로크기" />
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_fld1">팝업위치</label></th>
					<td>
						<input type="text" id="icd_fld1" name="icd_fld1" class="inpline" style="width:100px;" title="가로크기" value="" /><label for="icd_fld1">상단</label>
			            <input type="text" id="icd_fld2" name="icd_fld2" class="inpline" style="width:100px;" title="세로크기" value="" /><label for="icd_fld2">좌측</label>
			        </td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_visible">활성여부</label></th>
		            <td>
		            <select id="visible" name="icd_visible" class="selline" style="width:120px">
		                <option value="Y">활성</option>
		                <option value="N">비활성</option>
		            </select>
		            </td>
				</tr>
				<tr>
		            <th scope="row"><label for="icd_content">내용</label></th>
	       		    <td colspan="3">
	       		    	<?php $coreClass -> getEditor(site_config_editor, "icd_content", "100%", "300px", ""); ?>
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