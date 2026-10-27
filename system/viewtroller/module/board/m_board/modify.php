<?php
	$where = "WHERE board_no = '".$no."'";
	$row = $coreClass -> selectQueryArray($tbl1, $where, "", "", "");				
?>

<script type="text/javascript">
	//<![CDATA[ 
	(function($){
		$.frmValidation = function() {
			if($.trim($('#board_name').val()) == ''){
				alert("제목을 입력하세요.");
				$('#board_name').focus();
				return false;
			}
		}
	})(jQuery);
	//-->
</script>

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>" onsubmit="return $.frmValidation();">
	<input type="hidden" name="mod" value="process" />
	<input type="hidden" name="act" value="modify" />
	<input type="hidden" name="no" value="<?php echo $row['BOARD_NO']?>" />
	<input type="hidden" name="scode" value="<?php echo $scode?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" border="1" cellspacing="0" summary="게시판정보 수정">
	        <caption>게시판정보 수정</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	        	<col style="width: 30%;" />
	        	<col style="width: 20%;" />
	        	<col style="width: 30%;" />
	        </colgroup>
	        
	        <tbody>
	        	<tr>
		            <th scope="row"><label for="scodevar">사이트선택</label></th>
		            <td colspan="3"><?php echo $cmsClass -> getSiteSelect($row['BOARD_SCODE'])?></td>
				</tr>
	            <tr>
	                <th scope="row">게시판ID</th>
	                <td>
	                    <?php echo $row['BOARD_ID']?>
	                </td>
	            	<th scope="row"><label for="board_name">게시판명</label></th>
		            <td>
	    				<input type="text" name="board_name" id="board_name" class="inpline" style="width:150px;" value="<?php echo $row['BOARD_NAME']?>" />
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_type">게시판 유형</label></th>
		            <td colspan="3">
						<select name="board_type" id="board_type" class="selline" style="width:160px">
							<option value="">게시판 유형선택</option>
							<?php
								$border2			= "ORDER BY brdskin_no ASC";
								$brsss				= $coreClass -> selectQuery(tbl_board_skin, "", $border2, "", "");//30
								while($browss = $coreClass -> selectFetchArray($brsss)) {
									echo "<option value=\"".$browss['BRDSKIN_ID']."\"";
									if($browss['BRDSKIN_ID'] == $row['BOARD_TYPE']) {
										echo "selected=\"selected\"";
									}		        				
									echo ">".$browss['BRDSKIN_NAME']."</option>";
								}
							?>
						</select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_category">카테고리사용여부</label></th>
		            <td>
						<select name="board_category" id="board_category" class="selline" style="width:160px">
				            <option value="N" <?php if($row['BOARD_CATEGORY']=="N") echo "selected";?>>N</option>
	            			<option value="Y" <?php if($row['BOARD_CATEGORY']=="Y") echo "selected";?>>Y</option>
				        </select>
	                </td>
	            	<th scope="row"><label for="board_privacy">비밀글사용여부</label></th>
		            <td>
						<select name="board_privacy" id="board_privacy" class="selline" style="width:160px">
				            <option value="N"<?php if($row['BOARD_PRIVACY']=="N") echo "selected";?>>N</option>
	            			<option value="Y"<?php if($row['BOARD_PRIVACY']=="Y") echo "selected";?>>Y</option>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_comment">댓글사용여부</label></th>
		            <td>
						<select name="board_comment" id="board_comment" class="selline" style="width:160px">
				            <option value="N"<?php if($row['BOARD_COMMENT']=="N") echo "selected";?>>N</option>
	            			<option value="Y"<?php if($row['BOARD_COMMENT']=="Y") echo "selected";?>>Y</option>
				        </select>
					</td>
	            	<th scope="row"><label for="board_editor">에디터사용여부</label></th>
		            <td>
						<select name="board_editor" id="board_editor" class="selline" style="width:160px">
				            <option value="N"<?php if($row['BOARD_EDITOR']=="N") echo "selected";?>>N</option>
	            			<option value="Y"<?php if($row['BOARD_EDITOR']=="Y") echo "selected";?>>Y</option>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_extend">확장필드사용여부</label></th>
		            <td>
						<select name="board_extend" id="board_extend" class="selline" style="width:80px">
				            <option value="N"<?php if($row['BOARD_EXTEND']=="N") echo "selected";?>>N</option>
	            			<option value="Y"<?php if($row['BOARD_EXTEND']=="Y") echo "selected";?>>Y</option>
				        </select>
					</td>
	            	<th scope="row"><label for="board_thumnail">썸네일사용여부</label></th>
		            <td>
						<select name="board_thumnail" id="board_thumnail" class="selline" style="width:80px">
	            			<option value="Y"<?php if($row['BOARD_THUMNAIL']=="Y") echo "selected";?>>Y</option>
				            <option value="N"<?php if($row['BOARD_THUMNAIL']=="N") echo "selected";?>>N</option>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_thumwid">썸네일가로</label></th>
		            <td>
						<input type="text" name="board_thumwid" id="board_thumwid" class="inpline" style="width:80px;" value="<?=$row['BOARD_THUM_WID']?>">
					</td>
	            	<th scope="row"><label for="board_thumhei">썸네일세로</label></th>
		            <td>
						<input type="text" name="board_thumhei" id="board_thumhei" class="inpline" style="width:80px;" value="<?=$row['BOARD_THUM_HEI']?>">
					</td>
				</tr>
				<tr>
	            	<th scope="row"><label for="board_record">목록게시글수</label></th>
		            <td>
	    				<input type="text" name="board_record" id="board_record" class="inpline" style="width:80px;" value="<?php echo $row['BOARD_RECORD']?>" />
					</td>
	            	<th scope="row"><label for="board_new">NEW 표시일수</label></th>
		            <td>
	    				<input type="text" name="board_new" id="board_new" class="inpline" style="width:80px;" value="<?php echo $row['BOARD_NEW']?>" />
					</td>
				</tr>
				<tr>
	            	<th scope="row"><label for="board_hot">HOT 표시히트수</label></th>
		            <td>
	    				<input type="text" name="board_hot" id="board_hot" class="inpline" style="width:80px;" value="<?php echo $row['BOARD_HOT']?>" />
					</td>
					<th scope="row"><label for="board_oto">1:1 여부</label></th>
		            <td>
						<select name="board_oto" id="board_oto" class="selline" style="width:160px">
	            			<option value="Y"<?php if($row['BOARD_OTO']=="Y") echo "selected";?>>Y</option>
				            <option value="N"<?php if($row['BOARD_OTO']=="N") echo "selected";?>>N</option>
				        </select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="board_uploadcount">첨부파일수</label></th>
		            <td>
	    				<input type="text" name="board_uploadcount" id="board_uploadcount" class="inpline" style="width:80px;" value="<?php echo $row['BOARD_UPLOADCOUNT']?>" />
					</td>
	            	<th scope="row"><label for="board_uploadsize">첨부파일사이즈</label></th>
		            <td>
	    				<input type="text" name="board_uploadsize" id="board_uploadsize" class="inpline" style="width:80px;" value="<?php echo $row['BOARD_UPLOADSIZE']?>" /> MB
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_lv_notice">공지레벨</label></th>
		            <td>
						<select name="board_lv_notice" id="board_lv_notice" class="selline" style="width:160px">
						<?php
							$order = "ORDER BY MB_LEVEL_LV DESC";
							$result = $coreClass -> selectQuery(tbl_member_level, "", $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MB_LEVEL_LV']?>" <?php if($rowc['MB_LEVEL_LV'] == $row['BOARD_LV_NOTICE']) echo "selected";?>><?php echo $rowc['MB_LEVEL_TITLE']?>(<?php echo $rowc['MB_LEVEL_LV']?>)</option>
						<?php } ?>
							<option value="0" <?php if(0 == $row['BOARD_LV_NOTICE']) echo "selected";?>>사용안함</option>
				        </select>
					</td>
	            	<th scope="row"><label for="board_lv_access">접근레벨</label></th>
		            <td>
						<select name="board_lv_access" id="board_lv_access" class="selline" style="width:160px">
	            		<?php
							$order = "ORDER BY MB_LEVEL_LV DESC";
							$result = $coreClass -> selectQuery(tbl_member_level, "", $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MB_LEVEL_LV']?>" <?php if($rowc['MB_LEVEL_LV'] == $row['BOARD_LV_ACCESS']) echo "selected";?>><?php echo $rowc['MB_LEVEL_TITLE']?>(<?php echo $rowc['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
				</tr>
				<tr>
	            	<th scope="row"><label for="board_lv_manage">관리자레벨</label></th>
		            <td>
						<select name="board_lv_manage" id="board_lv_manage" class="selline" style="width:160px">
	            		<?php
							$order = "ORDER BY MB_LEVEL_LV DESC";
							$result = $coreClass -> selectQuery(tbl_member_level, "", $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MB_LEVEL_LV']?>" <?php if($rowc['MB_LEVEL_LV'] == $row['BOARD_LV_MANAGE']) echo "selected";?>><?php echo $rowc['MB_LEVEL_TITLE']?>(<?php echo $rowc['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
	            	<th scope="row"><label for="board_lv_view">보기레벨</label></th>
		            <td>
						<select name="board_lv_view" id="board_lv_view" class="selline" style="width:160px">
	            		<?php
							$order = "ORDER BY MB_LEVEL_LV DESC";
							$result = $coreClass -> selectQuery(tbl_member_level, "", $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MB_LEVEL_LV']?>" <?php if($rowc['MB_LEVEL_LV'] == $row['BOARD_LV_VIEW']) echo "selected";?>><?php echo $rowc['MB_LEVEL_TITLE']?>(<?php echo $rowc['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_lv_insert">쓰기레벨</label></th>
		            <td>
						<select name="board_lv_insert" id="board_lv_insert" class="selline" style="width:160px">
	            		<?php
							$order = "ORDER BY MB_LEVEL_LV DESC";
							$result = $coreClass -> selectQuery(tbl_member_level, "", $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MB_LEVEL_LV']?>" <?php if($rowc['MB_LEVEL_LV'] == $row['BOARD_LV_INSERT']) echo "selected";?>><?php echo $rowc['MB_LEVEL_TITLE']?>(<?php echo $rowc['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
	            	<th scope="row"><label for="board_lv_reply">답변레벨</label></th>
		            <td>
						<select name="board_lv_reply" id="board_lv_reply" class="selline" style="width:160px">
						<?php
							$order = "ORDER BY MB_LEVEL_LV DESC";
							$result = $coreClass -> selectQuery(tbl_member_level, "", $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MB_LEVEL_LV']?>" <?php if($rowc['MB_LEVEL_LV'] == $row['BOARD_LV_REPLY']) echo "selected";?>><?php echo $rowc['MB_LEVEL_TITLE']?>(<?php echo $rowc['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_lv_comment">댓글레벨</label></th>
		            <td>
						<select name="board_lv_comment" id="board_lv_comment" class="selline" style="width:160px">
						<?php
							$order = "ORDER BY MB_LEVEL_LV DESC";
							$result = $coreClass -> selectQuery(tbl_member_level, "", $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MB_LEVEL_LV']?>" <?php if($rowc['MB_LEVEL_LV'] == $row['BOARD_LV_COMMENT']) echo "selected";?>><?php echo $rowc['MB_LEVEL_TITLE']?>(<?php echo $rowc['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
	            	<th scope="row"><label for="board_lv_download">다운레벨</label></th>
		            <td>
						<select name="board_lv_download" id="board_lv_download" class="selline" style="width:160px">
						<?php
							$order = "ORDER BY MB_LEVEL_LV DESC";
							$result = $coreClass -> selectQuery(tbl_member_level, "", $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MB_LEVEL_LV']?>" <?php if($rowc['MB_LEVEL_LV'] == $row['BOARD_LV_DOWNLOAD']) echo "selected";?>><?php echo $rowc['MB_LEVEL_TITLE']?>(<?php echo $rowc['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
				</tr>

	            <tr>
	            	<th scope="row"><label for="board_lv_exposure">노출일자 레벨</label></th>
		            <td>
						<select name="board_lv_exposure" id="board_lv_exposure" class="selline" style="width:160px">
							<option value="0" <?php if(0 == $row['BOARD_LV_EXPOSURE']) echo "selected";?>>사용안함</option>
	            		<?php
							$order = "ORDER BY MB_LEVEL_LV DESC";
							$result = $coreClass -> selectQuery(tbl_member_level, "", $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MB_LEVEL_LV']?>" <?php if($rowc['MB_LEVEL_LV'] == $row['BOARD_LV_EXPOSURE']) echo "selected";?>><?php echo $rowc['MB_LEVEL_TITLE']?>(<?php echo $rowc['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
	            	<th scope="row"><label for="board_sms">답변SMS여부 사용유무</label></th>
		            <td>
						<select name="board_sms" id="board_sms" class="selline" style="width:80px">
	            			<option value="Y"<?php if($row['BOARD_SMS']=="Y") echo "selected";?>>Y</option>
				            <option value="N"<?php if($row['BOARD_SMS']=="N") echo "selected";?>>N</option>
				        </select>
					</td>
				</tr>

	            <tr>
	            	<th scope="row"><label for="board_order1">정렬옵션</label></th>
		            <td colspan="3">
				    <?php 
					$BOARD_ORDER = EXPLODE(" ",$row['BOARD_ORDER']);
					?>
						<select name="board_order1" id="board_order1" class="selline" style="width:160px">
							<option value="" <?php if("" == $BOARD_ORDER[0]) echo "selected";?>>기본 정렬</option>
							<? for($i=0;$i<count($arr_bbs_order);$i++){?>
							<option value="<?=$arr_bbs_order[$i][1]?>" <?php if($BOARD_ORDER[0]==$arr_bbs_order[$i][1]) echo "selected";?>><?=$arr_bbs_order[$i][2]?></option>
							<?}?>
				        </select>
						<select name="board_order2" id="board_order2" class="selline" style="width:160px">
							<option value="" <?php if("" == $BOARD_ORDER[1]) echo "selected";?>>-</option>
							<option value="asc" <?php if("asc" == $BOARD_ORDER[1]) echo "selected";?>>오름차순</option>
							<option value="desc" <?php if("desc" == $BOARD_ORDER[1]) echo "selected";?>>내림차순</option>
				        </select>
					</td>
				</tr>

				<tr>
	            	<th scope="row"><label for="board_subject_len">목록 제목 길이</label></th>
		            <td colspan="3">
	    				<input type="text" name="board_subject_len" id="board_subject_len" class="inpline" style="width:80px;" value="<? echo $row['BOARD_SUBJECT_LEN']?>">
					</td>
				</tr>

	            <tr>
	            	<th scope="row"><label for="board_header">게시판헤더</label></th>
		            <td colspan="3"><?php $coreClass -> getEditor(2, "board_header", "100%", "200px", $row['BOARD_HEADER']); ?></td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_footer">게시판푸터</label></th>
		            <td colspan="3"><?php $coreClass -> getEditor(2, "board_footer", "100%", "200px", $row['BOARD_FOOTER']); ?></td>
				</tr>
			</tbody>
			</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	            <button type="submit" class="btn_big"><strong>수정</strong></button>
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list&scode=<?php echo $scode?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>    
	</div>
</form>

<form name="manageupdate" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" name="brdmng_bid" value="<?php echo $row['BOARD_ID']?>" />
    <input type="hidden" name="mod" value="process" />
    <input type="hidden" name="act" value="manageupdate" />
	<input type="hidden" name="scode" value="<?php echo $scode?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
	
	<div id="cenCont_in">
		<div class="brdlist_content">
			<table class="tbl_view1" summary="관리자 추가">
			<caption>관리자 추가</caption>
			<colgroup>
				<col style="width: 20%;" />
				<col style="width: 80%;" />
	    	</colgroup>

			<tbody>
	        
				<tr>
	 	         
					<th scope="row">
					<label for="brdmng_uid">관리자 추가</label>
					</th>
		         
					<td>
	             	
						<select id="brdmng_uid" name="brdmng_uid" class="selline" style="width:140px;">
	                	
						<?php
	                		
						$order	= "ORDER BY mb_name ASC";
							
						$rs			= $coreClass -> selectQuery(tbl_member, "", $order, "", "");
							
						while($rowm = $coreClass -> selectFetchArray($rs)) {
						
						?>                
	    	            	
						<option value="<?php echo $rowm['MB_UID']?>"><?php echo $rowm['MB_NAME']?></option>
	                	
						<?php } ?>
	                
						</select>
	                
						<a href="#" onclick="manageupdate.submit(); return false;" class="btn_big"><span>등록</span></a><br /><br />
	                
	                
						<?php
	                	
						$where	= "LEFT JOIN ".tbl_member." ON mb_uid = brdmng_uid WHERE brdmng_bid = '".$row['BOARD_ID']."'";
						
						$rs			= $coreClass -> selectQuery(tbl_board_manage, $where, "", "", "");
						
						while($rowu = $coreClass -> selectFetchArray($rs)) {
					
						?>                
	    	            
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=managedelete&brdmng_bid=<?php echo $rowu['BRDMNG_BID']?>&brdmng_no=<?php echo $rowu['BRDMNG_NO']?>&token=<?php echo site_config_token?>&scode=<?php echo $scode?>" class="btn_big"><span><?php echo $rowu['MB_NAME']?> 삭제</span></a>
	                
						<?php } ?>
	             
					</td>
	       
				</tr>
		    
			</tbody>
	 	
			</table>
		
		</div>
	
	</div>	

</form>

<!--
<form name="managesmsupdate" method="post" action="sub.php?menukey=<?php echo $menukey?>">    
<input type="hidden" name="brdmngs_bid" value="<?php echo $row['BOARD_ID']?>" />    
<input type="hidden" name="mod" value="process" />    
<input type="hidden" name="act" value="managesmsupdate" />
<input type="hidden" name="scode" value="<?php echo $scode?>" />
<input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div id="cenCont_in">
		<div class="brdlist_content">
			<table class="tbl_view1" summary="SMS발송자 추가">
			<caption>SMS발송자 추가</caption>
			<colgroup>
			<col style="width: 20%;" />
			<col style="width: 80%;" />
			</colgroup>
	        
			<tbody>
				<tr>
					<th scope="row">
					<label for="brdmngs_uid">SMS발송자 추가</label>
					</th>
		         
					<td>
						<strong>※ 등록 기관 선택 </strong>: 
						<select id="brdmngs_uid" name="brdmngs_uid" class="selline" style="width:140px;">
						<option value="">-선택-</option>
						<?php
						$order	= "ORDER BY mb_name ASC";
						$where	= "where mb_level <= 6 and mb_tel is not null";
						$rs			= $coreClass -> selectQuery(tbl_member, $where, $order, "", "");
						while($rowm = $coreClass -> selectFetchArray($rs)) {
						?>                
	    	            	
						<option value="<?php echo $rowm['MB_UID']?>"><?php echo $rowm['MB_NAME']?></option>
						<?php } ?>
	                
						</select><br/>
						<strong>※ 개별 추가 입력 </strong>: 이름 : <input type="text" name="brdmngs_name" id="brdmngs_name" class="inpline" style="width:100px;" value="" />, 연락처 : <input type="text" name="brdmngs_hp" id="brdmngs_hp" class="inpline" style="width:150px;" value="" />

						<a href="#" onclick="managesmsupdate.submit(); return false;" class="btn_big"><span>등록</span></a><br /><br />
	                
						<?php
						//$where	= "LEFT JOIN ".tbl_member." ON mb_uid = brdmngs_uid WHERE brdmngs_bid = '".$row['BOARD_ID']."'";
						$where	= " WHERE BRDMNGS_BID = '".$row['BOARD_ID']."'";
						$rs			= $coreClass -> selectQuery(tbl_board_manage_sms, $where, "", "", "");
						while($rowu = $coreClass -> selectFetchArray($rs)) {

							if($rowu['BRDMNGS_UID'] != ""){
								$where2	= "where MB_UID = '".$rowu['BRDMNGS_UID']."'";
								$rs2			= $coreClass -> selectQuery(tbl_member, $where2, "", "", "");
								$rowm = $coreClass -> selectFetchArray($rs2);
								$brdmngs_hp = $coreClass -> decrypt_md5($rowm['MB_TEL'], site_config_mbkey);
							}else{
								$brdmngs_hp =  $coreClass -> decrypt_md5($rowu['BRDMNGS_HP'], site_config_mbkey);
							}

						?>                
	    	            
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=managesmsdelete&brdmngs_bid=<?php echo $rowu['BRDMNGS_BID']?>&brdmngs_no=<?php echo $rowu['BRDMNGS_NO']?>&token=<?php echo site_config_token?>&scode=<?php echo $scode?>" class="btn_big"><span><?php echo $rowu['BRDMNGS_NAME']?>(<?=$brdmngs_hp?>) 삭제</span></a>
	                
						<?php } ?>
	             
					</td>
				</tr>
			</tbody>
			</table>
		</div>
	</div>	
</form>
-->