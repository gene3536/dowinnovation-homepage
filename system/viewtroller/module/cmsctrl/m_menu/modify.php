<?php
	
	$where = "WHERE menu_menukey = '".$mkey."'";
	$row = $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
	
	// 멤버등급
	$levelRs	= $coreClass -> selectQuery($tbl4, "", "ORDER BY mb_level_lv DESC", "", "");
	$levelCon .= '<select name="menu_level" id="menu_level" class="selline" style="width:160px">';
	while($level = $coreClass -> selectFetchArray($levelRs)) {
		if($level['MB_LEVEL_LV'] == $row['MENU_LEVEL']) {
			$levelCon .= '<option value="'.$level['MB_LEVEL_LV'].'" selected="selected">'.$level['MB_LEVEL_LV'].' ('.$level['MB_LEVEL_TITLE'].')</option>';
		} else {
			$levelCon .= '<option value="'.$level['MB_LEVEL_LV'].'">'.$level['MB_LEVEL_LV'].' ('.$level['MB_LEVEL_TITLE'].')</option>';
		}
	}
	$levelCon .= '</select>';

	// 멤버목록
	$order		= "ORDER BY mb_name ASC";
	$memberRs	= $coreClass -> selectQuery(tbl_member, "", $order, "", "");	
	$memberCon .= '<select id="menu_manage_uid" name="menu_manage_uid" class="selline" style="width:140px;">';
	while($rowm = $coreClass -> selectFetchArray($memberRs)) {
		$memberCon .= '<option value="'.$rowm['MB_UID'].'">'.$rowm['MB_NAME'].'</option>';
	}
	$memberCon .= '</select>';
	
	// 메뉴관리자 등록목록
	$where	= "WHERE menu_manage_menukey = '".$row['MENU_MENUKEY']."'";
	$rs		= $coreClass -> selectQuery(tbl_menu_manage, $where, "", "", "");
	while($mng = $coreClass -> selectFetchArray($rs)) {
		$where	= "WHERE mb_uid = '".$mng['MENU_MANAGE_UID']."'";
		$mngRow = $coreClass -> selectQueryArray(tbl_member, $where, "", "", "");
		$mngCon .= '<a href="sub.php?menukey='.$menukey.'&mod=process&act=managedelete&mkey='.$mkey.'&menu_manage_no='.$mng['MENU_MANAGE_NO'].'&token='.site_config_token.'" class="btn_big"><span>'.$mngRow['MB_NAME'].' 삭제</span></a>';
	}

	$Amenu_var4 = json_decode($row['MENU_VAR4']); 
?>

<script type="text/javascript">	
	function dismenu(num) {
		obj = document.forms['modify'];
		obj.menu_url.disabled			= "disabled";
		obj.menu_surl.disabled			= "disabled";
		obj.menu_urlmod.disabled		= "disabled";
		obj.menu_urlmod2.disabled		= "disabled";
		obj.menu_content1.disabled		= "disabled";
		obj.menu_content2.disabled		= "disabled";
		obj.menu_board.disabled 		= "disabled";
		
		obj.menu_url.style.border 		= "1px solid #CCC";
		obj.menu_surl.style.border 		= "1px solid #CCC";
		obj.menu_urlmod.style.border	= "1px solid #CCC";
		obj.menu_urlmod2.style.border	= "1px solid #CCC";
		obj.menu_content1.style.border	= "1px solid #CCC";
		obj.menu_content2.style.border	= "1px solid #CCC";
		obj.menu_board.style.border		= "1px solid #CCC";
		
		if(num == 2) {
			obj.menu_url.disabled = "";
			obj.menu_urlmod.disabled = "";
			obj.menu_url.style.border = "1px solid #F00";
			obj.menu_urlmod.style.border = "1px solid #F00";
			obj.menu_content2.disabled = "";
			obj.menu_content2.style.border = "1px solid #F00";
		} else if(num == 3) {
			obj.menu_content1.disabled = "";
			obj.menu_content1.style.border = "1px solid #F00";
		} else if(num == 4) {
			obj.menu_board.disabled = "";
			obj.menu_board.style.border = "1px solid #F00";
		} else if(num == 5) {
			obj.menu_url.disabled = "";
			obj.menu_url.style.border = "1px solid #F00";
			obj.menu_urlmod2.disabled = "";
			obj.menu_urlmod2.style.border = "1px solid #F00";
		} else if(num == 6) {
			obj.menu_url.disabled = "";
			obj.menu_surl.disabled = "";
			obj.menu_url.style.border = "1px solid #F00";
			obj.menu_surl.style.border = "1px solid #F00";
		}
	}
	
	$(document).ready(function() {
		dismenu(<?php echo $row['MENU_TYPE']?>);

		$.getOrgData("#org1", "", 1);     
		$("#org1").click( function () {
			$("#org2 option").remove();
			$.getOrgData("#org2", $("#org1 option:selected").val(), 2);
			$("#menu_dep").val($("#org1 option:selected").val());
			$("#menu_depsub").val("");
			$("#menu_depuser").val("");
		});		
		$("#org2").click( function () {
			$("#org3 option").remove();
			$.getOrgData("#org3", $("#org2 option:selected").val(), 3);
			$("#menu_depsub").val($("#org2 option:selected").val());
			$("#menu_depuser").val("");
		});
		$("#org3").click( function () {
			$("#menu_depuser").val($("#org3 option:selected").val());
		});

	});
	
	(function($){
		$.getOrgData = function(target, code, type) {
			$.ajax({   
				type: "get",   
				dataType: "xml",
				url: "/base/xml/siteOrganization.php?code=" + code + "&type=" + type,
				success: function(xml) {
					if($(xml).find("models").find("model").length > 0) { 
						$(xml).find("models").find("model").each(function() {   
							var organ_id = $(this).find("organ_id").text();   
							var organ_name = $(this).find("organ_name").text();   
							$(target).append("<option value='"+organ_id+"'>"+organ_name+"</option>");   
						});   
					}              
				},    
				error: function(xhr, status, error) {   
					$(target).append("<option value=''>에러가 발생하였습니다.</option>");
					$(target).append("<option value=''>" + error + "</option>");
				}   
			});   
		}
	})(jQuery);
</script>

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>">
    <input type="hidden" name="mkey" value="<?php echo $mkey?>" />
    <input type="hidden" name="mod" value="process" />
    <input type="hidden" name="act" value="modify" />
    <input type="hidden" name="scode" value="<?php echo $scode?>" />
    <input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" summary="메뉴수정">
	        <caption>메뉴수정</caption>
	        <colgroup>
	        	<col style="width:20%;" />
	            <col />
	        </colgroup>
	        
	        <tbody>
	        <tr>
	            <th scope="row"><label for="menu_title">메뉴명</label></th>
	            <td>
	              <input type="text" id="menu_title" name="menu_title" class="inpline" style="width:180px;" value="<?php echo $row['MENU_TITLE']?>" />
	            </td>
	        </tr>
	        <!--<tr>
	 	         <th scope="row"><label for="menu_tbl">테이블</label></th>
		         <td>
	    	         <input type="text" id="menu_tbl" name="menu_tbl" class="inpline" style="width:180px;" value="<?php echo $row['MENU_TBL']?>" />
	             </td>
	        </tr>-->        
	        <tr>
	            <th scope="row"><label for="menu_visible1">활성여부</label></th>
	            <td>
	            	<label><input type="radio" id="menu_visible1" name="menu_visible" value="Y" <? if($row['MENU_VISIBLE'] == "Y") { ?> checked="checked" <? } ?> /> 활성</label>
	                <label><input type="radio" id="menu_visible2" name="menu_visible" value="N" <? if($row['MENU_VISIBLE'] == "N") { ?> checked="checked" <? } ?> /> 비활성</label>
	                &nbsp;&bull;&nbsp;공통메뉴 및 좌측메뉴에 출력여부.             
	            </td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="menu_access1">접근여부</label></th>
	            <td>
	            	<label><input type="radio" id="menu_access1" name="menu_access" value="Y" <? if($row['MENU_ACCESS'] == "Y") { ?> checked="checked" <? } ?> /> 활성</label>
	                <label><input type="radio" id="menu_access2" name="menu_access" value="N" <? if($row['MENU_ACCESS'] == "N") { ?> checked="checked" <? } ?> /> 비활성</label>
	                &nbsp;&bull;&nbsp;메뉴 및 종속된 콘텐츠에 대한 접근권한.                
	            </td>
	        </tr>
	        <tr>
	        	<th scope="row"><label for="menu_level">접근레벨</label></th>
	            <td><?php echo $levelCon?></td>
	        </tr>
	        <tr>
	            <th scope="row"><label for="menu_type1">콘텐츠타입</label></th>
	            <td>
	            	<label><input type="radio" id="menu_type1" name="menu_type" value="1" <?php if($row['MENU_TYPE'] == 1) { ?> checked="checked" <? } ?> onclick="dismenu(1);"/> 비사용</label>&nbsp;
	                <label><input type="radio" id="menu_type2" name="menu_type" value="2" <?php if($row['MENU_TYPE'] == 2) { ?> checked="checked" <? } ?> onclick="dismenu(2);" /> 파일링크</label>&nbsp;
	                <label><input type="radio" id="menu_type3" name="menu_type" value="3" <?php if($row['MENU_TYPE'] == 3) { ?> checked="checked" <? } ?> onclick="dismenu(3);" /> 콘텐츠</label>&nbsp;
	                <label><input type="radio" id="menu_type4" name="menu_type" value="4" <?php if($row['MENU_TYPE'] == 4) { ?> checked="checked" <? } ?> onclick="dismenu(4);" /> 게시판</label>&nbsp;
	                <label><input type="radio" id="menu_type5" name="menu_type" value="5" <?php if($row['MENU_TYPE'] == 5) { ?> checked="checked" <? } ?> onclick="dismenu(5);" /> 링크</label>&nbsp;
	                <label><input type="radio" id="menu_type6" name="menu_type" value="6" <?php if($row['MENU_TYPE'] == 6) { ?> checked="checked" <? } ?> onclick="dismenu(6);" /> 스크립트링크</label>
	            </td>
	        </tr>
	        <tr>
	 	         <th scope="row"><label for="menu_url">링크</label></th>
		         <td>
	    	         <input type="text" id="menu_url" name="menu_url" class="inpline" style="width:400px;" value="<?php echo $row['MENU_URL']?>" disabled="disabled">
	             </td>
	        </tr>
	        <tr>
	 	         <th scope="row"><label for="menu_url2">타켓</label></th>
		         <td>
	    	         <select id="menu_url2" name="menu_urlmod2" class="selline">
						<option value="_self" <?php if($row['MENU_URLMOD'] == "_self"){echo "selected";}?>>현재창</option>
						<option value="_blank" <?php if($row['MENU_URLMOD'] == "_blank"){echo "selected";}?>>새창</option>
					 </select>
	             </td>
	        </tr>
	        <tr>
	 	         <th scope="row"><label for="menu_surl">스크립트</label></th>
		         <td>
	        	     <input type="text" id="menu_surl" name="menu_surl" class="inpline" style="width:400px;" value="<?php echo $row['MENU_SURL']?>" disabled="disabled">
	             </td>
	        </tr>
	        <tr>
	 	         <th scope="row"><label for="menu_urlmod">파일링크모드</label></th>
		         <td>
	        	     <input type="text" id="menu_urlmod" name="menu_urlmod" class="inpline" style="width:180px;" value="<?php echo $row['MENU_URLMOD']?>" disabled="disabled">
	             </td>
	        </tr>
	        <tr>
	 	         <th scope="row"><label for="menu_width">탭메뉴사이즈</label></th>
		         <td>
	        	     <input type="text" id="menu_width" name="menu_width" class="inpline" style="width:180px;" value="<?php echo $row['MENU_WIDTH']?>" />
	             </td>
	        </tr>
	        <tr>
	 	         <th scope="row"><label for="menu_content1">콘텐츠선택</label></th>
		         <td>
	             	<select id="menu_content1" name="menu_content" class="selline" disabled="disabled" style="width:90%">
	                	<option value="">콘텐츠없음</option>
	    	            <?php
							$rs = $coreClass -> selectQuery(tbl_cms_icd, "WHERE icd_pid = '00000001' AND (icd_scode = '00000000' OR icd_scode = '".$row['MENU_SCODE']."')", "ORDER BY icd_title", "", "");	
							while($rowd = $coreClass -> selectFetchArray($rs)) {
						?>
	    	            	<option value="<?php echo $rowd['ICD_ID']?>" <?php if($row['MENU_CONTENT'] == $rowd['ICD_ID']) { ?> selected="selected" <? } ?>><?php echo $rowd['ICD_TITLE']?></option>
	                	<?php } ?>
	                </select>
	             </td>
	        </tr>
	        <tr>
	 	         <th scope="row"><label for="menu_content2">통합콘텐츠선택</label></th>
		         <td>
	             	<select id="menu_content2" name="menu_content" class="selline" disabled="disabled" style="width:90%">
	                	<option value="">통합콘텐츠없음</option>
	    	            <?php
							$rs = $coreClass -> selectQuery(tbl_cms_icm, "", "ORDER BY icm_title", "", "");	
							while($rowd = $coreClass -> selectFetchArray($rs)) {								
						?>
	    	            	<option value="<?php echo $rowd['ICM_ID']?>" <?php if($rowd['ICM_VISIBLE'] == "N"){?>disabled<?php } ?> <?php if($row['MENU_CONTENT'] == $rowd['ICM_ID']) { ?> selected="selected" <? } ?>><?php echo $rowd['ICM_TITLE']?></option>
	                	<?php
							}
						?>
	                </select>
	             </td>
	        </tr>
	        <tr>
	 	         <th scope="row"><label for="menu_board">게시판선택</label></th>
		         <td>
	             	<select id="menu_board" name="menu_board" class="selline" disabled="disabled" style="width:90%">
	                	<option value="">게시판없음</option>
	                	<?php
							if($scode != "00000001") $where = "WHERE board_scode='".$scode."' OR board_scode = '00000000'";
							else $where = ""; echo $where;
							$order = "ORDER BY board_name";
							$rs = $coreClass -> selectQuery(tbl_board, $where, $order, "", "");
							while($rowe = $coreClass -> selectFetchArray($rs)) {
						?>                
	    	            	<option value="<?php echo $rowe['BOARD_ID']?>" <?php if($row['MENU_BOARD'] == $rowe['BOARD_ID']) { ?> selected="selected" <? } ?>><?php echo $rowe['BOARD_NAME']?></option>
	                	<?php } ?>
	                </select>
	             </td>
	        </tr>
	        <tr>
	 	         <th scope="row"><label for="menu_skins">메뉴 스킨</label></th>
		         <td>
	        	     <input type="text" id="menu_skins" name="menu_skins" class="inpline" style="width:180px;" value="<?php echo $row['MENU_SKINS']?>">
	             </td>
	        </tr>
	        <tr>
	 	         <th scope="row"><label for="menu_var3">공공누리 저작물</label></th>
		         <td>
	    	         <!-- <input type="text" id="menu_var3" name="menu_var3" class="inpline" style="width:400px;" value="<?php echo $row['MENU_VAR3']?>"> -->
					 <input type="radio" id="menu_var31" name="menu_var3" value="1" <?php if($row['MENU_VAR3']=="1"){echo "checked";}?>> <label for="menu_var31">출처표시</label>
					 <input type="radio" id="menu_var32" name="menu_var3" value="2" <?php if($row['MENU_VAR3']=="2"){echo "checked";}?>> <label for="menu_var32">출처표시+상업적이용금지</label>
					 <input type="radio" id="menu_var33" name="menu_var3" value="3" <?php if($row['MENU_VAR3']=="3" || empty($row['MENU_VAR3'])){echo "checked";}?>> <label for="menu_var33">출처표시+변경금지</label>
					 <input type="radio" id="menu_var34" name="menu_var3" value="4" <?php if($row['MENU_VAR3']=="4"){echo "checked";}?>> <label for="menu_var34">출처표시+상업적이용금지+변경금지</label>
					 <!-- <select name="menu_var3" class="selline" style="width:500px">
						<option value="">선택</option>
						<option value="1" <?php if($row['MENU_VAR3'] == "1") { ?> selected="selected" <? } ?>>출처표시</option>
						<option value="2" <?php if($row['MENU_VAR3'] == "2") { ?> selected="selected" <? } ?>>출처표시+상업적이용금지</option>
						<option value="3" <?php if($row['MENU_VAR3'] == "3") { ?> selected="selected" <? } ?>>출처표시+변경금지</option>
						<option value="4" <?php if($row['MENU_VAR3'] == "4") { ?> selected="selected" <? } ?>>출처표시+상업적이용금지+변경금지</option>
					 </select> -->
	             </td>
	        </tr>
	        <!-- <tr>
				<th scope="row"><label for="menu_var31">부서/담당자</label></th>
				<td>
					<div style="float:left; margin:10px 5px 5px 0;">
						&bull;&nbsp;1차부서선택<br />
						<select id="org1" size="7" style="width:140px;"></select>	         		
					</div>
					<div style="float:left; margin:10px 5px 5px 0;">
						<p style="padding-bottom:5px;"><span style="display:inline-block; width:55px;">부서명</span> <input type="text" id="menu_dep" name="menu_dep" class="inpline" style="width:320px;" value="<?php echo $row['MENU_DEP']?>" /></p>
						<p style="padding-bottom:5px;"><span style="display:inline-block; width:55px;">담당자명</span> <input type="text" id="menu_var41" name="menu_var4[0]" class="inpline" style="width:320px;" value="<?php echo $Amenu_var4[0]?>" /></p>
						<p style="padding-bottom:5px;"><span style="display:inline-block; width:55px;">연락처</span> <input type="text" id="menu_var42" name="menu_var4[1]" class="inpline" style="width:320px;" value="<?php echo $Amenu_var4[1]?>" /></p>
						<p style="padding-bottom:5px;"><span style="display:inline-block; width:55px;">담당업무</span> <textarea id="menu_var43" name="menu_var4[2]" class="inpline" style="width:320px; height:90px;"><?php echo $Amenu_var4[2]?></textarea><!-- <input type="text" id="menu_var42" name="menu_var4[]" class="inpline" style="width:120px;" value="<?php echo $Amenu_var4[1]?>" /> </p>-->
					<!-- </div>
				</td>
			</tr> -->
	        <tr>
				<th scope="row"><label for="menu_dep">부서/담당자</label></th>
				<td>
					<div style="float:left; margin:10px 5px 5px 0;">
						&bull;&nbsp;1차부서선택<br />
						<select id="org1" size="7" style="width:140px;"></select>	         		
					</div>
					<div style="float:left; margin:10px 5px 5px 0;">
						&bull;&nbsp;2차부서 선택<br />
						<select id="org2" size="7" style="width:140px;"></select>
					</div>
					<div style="margin:10px 5px 5px 0;">
						&bull;&nbsp;담당자 선택<br />
						<select id="org3" size="7" style="width:140px;"></select>
					</div>
					
					<input type="text" id="menu_dep" name="menu_dep" class="inpline" style="width:120px;" value="<?php echo $row['MENU_DEP']?>" />&nbsp;/
			        <input type="text" id="menu_depsub" name="menu_depsub" class="inpline" style="width:120px;" value="<?php echo $row['MENU_DEPSUB']?>" />&nbsp;/
			        <input type="text" id="menu_depuser" name="menu_depuser" class="inpline" style="width:120px;" value="<?php echo $row['MENU_DEPUSER']?>" />
				</td>
			</tr>
		    </tbody>
	 	</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	    		<button type="submit" class="btn_big"><strong>수정</strong></button>   
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list&code2=<?php echo $code2?>" class="btn_big"><span>목록</span></a>
	        </div>
		</div>
	</div>	
</form>

<form name="manageupdate" method="post" action="sub.php?menukey=<?php echo $menukey?>">
    <input type="hidden" name="mkey" value="<?php echo $mkey?>" />
    <input type="hidden" name="mod" value="process" />
    <input type="hidden" name="act" value="manageupdate" />
    <input type="hidden" name="token" value="<?php echo site_config_token?>" />
    
	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" summary="관리자 추가">
	        <caption>관리자 추가</caption>
	        <colgroup>
	        	<col style="width:20%;" />
	        	<col style="width:80%;" />
	        </colgroup>
	        
	        <tbody>
	        <tr>
				<th scope="row"><label for="menu_manage_uid">관리자 추가</label></th>
				<td>
	             	<?php echo $memberCon?>
	                <a href="#" onclick="manageupdate.submit(); return false;" class="btn_big"><span>등록</span></a><br /><br />
					<?php echo $mngCon?>	                
				</td>
	        </tr>
		    </tbody>
	 	</table>
		</div>
	</div>	
</form>