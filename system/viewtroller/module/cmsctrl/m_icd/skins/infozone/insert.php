

<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data">
	<input type="hidden" id="mod" name="mod" value="process" />
	<input type="hidden" id="act" name="act" value="insert" />
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
	            <th scope="row"><label for="icd_title">제목</label></th>
	            <td>
	              <input type="text" id="icd_title" name="icd_title" class="inpline" style="width: 320px;" />
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
				  &nbsp;<input type="checkbox" id="datechk" name="datechk" onclick="datebtn('<?php echo date("Y-m-d", strtotime("+14 day"))?>');" /><label for="datechk">&nbsp;기간무제한</label>
	            </td>
	          </tr>
	          <tr>
	            <th scope="row"><label for="icd_type">출력유형</label></th>
	            <td>
	            <select id="icd_type" name="icd_type" class="selline" style="width:120px">
	                <option value="1">A유형</option>
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
	            <th><label for="thumbFile">첨부이미지</label></th>
            	<td>
            		<input type="file" id="thumbFile" name="thumbFile" class="fileline" />
            		<div style="margin-top:5px;">&bull;&nbsp;A유형 : 900px X 360px</div>
            	</td>
			</tr>
			<tr>
				<th scope="row"><label for="icd_alt">이미지정보</label></th>
				<td>
					<textarea id="icd_alt" name="icd_alt" class="inpline" style="width:90%; height:100px;" /></textarea>
		        </td>
			</tr>
	        <tr>
				<th scope="row"><label for="icd_url">링크주소</label></th>
				<td>
					<input type="text" id="icd_url" name="icd_url" class="inpline" style="width:320px;" />
					<div style="margin-top:5px;">&bull;&nbsp;http://는 제외하고 입력하여 주세요. (ex www.domain.co.kr)</div>
		        </td>
			</tr>
			<tr>
	            <th scope="row"><label for="icd_target">링크유형</label></th>
	            <td>
	            <select id="icd_target" name="icd_target" class="selline" style="width:120px">
	                <option value="_blank">새창</option>
	                <option value="_self">현재창</option>
	            </select>
	            </td>
	        </tr>
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