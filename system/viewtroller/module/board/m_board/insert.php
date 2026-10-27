
<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>" onsubmit="return $.frmValidation();">
	<input type="hidden" name="mod" value="process">
	<input type="hidden" name="act" value="insert">
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
	<input type="hidden" name="scode" value="<?php echo $scode?>" />

	<div id="cenCont_in">
	    <div class="brdlist_content">
	        <table class="tbl_view1" border="1" cellspacing="0" summary="게시판정보 등록">
	        <caption>게시판정보 등록</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	        	<col style="width: 30%;" />
	        	<col style="width: 20%;" />
	        	<col style="width: 30%;" />
	        </colgroup>
	       
	        <tbody>
				<tr>
		            <th scope="row"><label for="scodevar">사이트선택</label></th>
		            <td colspan="3"><?php echo $cmsClass -> getSiteSelect($scode)?></td>
				</tr>
	        	<tr>
	            	<th scope="row"><label for="board_name">게시판명</label></th>
		            <td colspan="3">
	    				<input type="text" name="board_name" id="board_name" class="inpline" style="width:180px;" />
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_type">게시판유형</label></th>
		            <td colspan="3">
						<select name="board_type" id="board_type" class="selline" style="width:160px">
							<option value="">게시판 유형선택</option>
							<?php
								$border2			= "ORDER BY brdskin_no ASC";
								$brsss				= $coreClass -> selectQuery(tbl_board_skin, "", $border2, "", "");//30
								while($browss = $coreClass -> selectFetchArray($brsss)) {
									echo "<option value=\"".$browss['BRDSKIN_ID']."\"";   				
									echo ">".$browss['BRDSKIN_NAME']."</option>";
								}

							?>
						</select>
	                </td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_category">카테고리사용여부</label></th>
		            <td>
						<select name="board_category" id="board_category" class="selline" style="width:80px">
				            <option value="N">N</option>
	            			<option value="Y">Y</option>
				        </select>
	                </td>
	            	<th scope="row"><label for="board_privacy">비밀글사용여부</label></th>
		            <td>
						<select name="board_privacy" id="board_privacy" class="selline" style="width:80px">
				            <option value="N">N</option>
	            			<option value="Y">Y</option>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_comment">댓글사용여부</label></th>
		            <td>
						<select name="board_comment" id="board_comment" class="selline" style="width:80px">
				            <option value="N">N</option>
	            			<option value="Y">Y</option>
				        </select>
					</td>
	            	<th scope="row"><label for="board_editor">에디터사용여부</label></th>
		            <td>
						<select name="board_editor" id="board_editor" class="selline" style="width:80px">
				            <option value="N">N</option>
	            			<option value="Y">Y</option>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_extend">확장필드사용여부</label></th>
		            <td>
						<select name="board_extend" id="board_extend" class="selline" style="width:80px">
				            <option value="N">N</option>
	            			<option value="Y">Y</option>
				        </select>
					</td>
	            	<th scope="row"><label for="board_thumnail">썸네일사용여부</label></th>
		            <td>
						<select name="board_thumnail" id="board_thumnail" class="selline" style="width:80px">
				            <option value="N">N</option>
	            			<option value="Y">Y</option>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_thumwid">썸네일가로</label></th>
		            <td>
						<input type="text" name="board_thumwid" id="board_thumwid" class="inpline" style="width:80px;" value="0">
					</td>
	            	<th scope="row"><label for="board_thumhei">썸네일세로</label></th>
		            <td>
						<input type="text" name="board_thumhei" id="board_thumhei" class="inpline" style="width:80px;" value="0">
					</td>
				</tr>
				<tr>
	            	<th scope="row"><label for="board_record">목록게시글수</label></th>
		            <td>
	    				<input type="text" name="board_record" id="board_record" class="inpline" style="width:80px;" value="10">
					</td>
	            	<th scope="row"><label for="board_new">NEW 표시일수</label></th>
		            <td>
	    				<input type="text" name="board_new" id="board_new" class="inpline" style="width:80px;" value="3">
					</td>
				</tr>
				<tr>
	            	<th scope="row"><label for="board_hot">HOT 표시히트수</label></th>
		            <td>
	    				<input type="text" name="board_hot" id="board_hot" class="inpline" style="width:80px;" value="100">
					</td>
					<th scope="row"><label for="board_oto">1:1 여부</label></th>
		            <td>
						<select name="board_oto" id="board_oto" class="selline" style="width:80px">
				            <option value="N">N</option>
	            			<option value="Y">Y</option>
				        </select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="board_uploadcount">첨부파일수</label></th>
		            <td>
	    				<input type="text" name="board_uploadcount" id="board_uploadcount" class="inpline" style="width:80px;" value="2">
					</td>
	            	<th scope="row"><label for="board_uploadsize">첨부파일사이즈</label></th>
		            <td>
	    				<input type="text" name="board_uploadsize" id="board_uploadsize" class="inpline" style="width:80px;" value="20"> (MB단위)
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_lv_notice">공지레벨</label></th>
		            <td>
						<select name="board_lv_notice" id="board_lv_notice" class="selline" style="width:160px">
						<?php
							$result = $coreClass -> selectQuery($tbl3, "", "ORDER BY MB_LEVEL_LV DESC", "", "");
							while($row = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $row['MB_LEVEL_LV']?>"><?php echo $row['MB_LEVEL_TITLE']?>(<?php echo $row['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
	            	<th scope="row"><label for="board_lv_access">접근레벨</label></th>
		            <td>
						<select name="board_lv_access" id="board_lv_access" class="selline" style="width:160px">
	            		<?php
							$result = $coreClass -> selectQuery($tbl3, "", "ORDER BY MB_LEVEL_LV DESC", "", "");
							while($row = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $row['MB_LEVEL_LV']?>"><?php echo $row['MB_LEVEL_TITLE']?>(<?php echo $row['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
				</tr>
				<tr>
	            	<th scope="row"><label for="board_lv_manage">관리레벨</label></th>
		            <td>
						<select name="board_lv_manage" id="board_lv_manage" class="selline" style="width:160px">
	            		<?php
							$result = $coreClass -> selectQuery($tbl3, "", "ORDER BY MB_LEVEL_LV DESC", "", "");
							while($row = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $row['MB_LEVEL_LV']?>"><?php echo $row['MB_LEVEL_TITLE']?>(<?php echo $row['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
	            	<th scope="row"><label for="board_lv_view">보기레벨</label></th>
		            <td>
						<select name="board_lv_view" id="board_lv_view" class="selline" style="width:160px">
	            		<?php
							$result = $coreClass -> selectQuery($tbl3, "", "ORDER BY MB_LEVEL_LV DESC", "", "");
							while($row = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $row['MB_LEVEL_LV']?>"><?php echo $row['MB_LEVEL_TITLE']?>(<?php echo $row['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_lv_insert">쓰기레벨</label></th>
		            <td>
						<select name="board_lv_insert" id="board_lv_insert" class="selline" style="width:160px">
	            		<?php
							$result = $coreClass -> selectQuery($tbl3, "", "ORDER BY MB_LEVEL_LV DESC", "", "");
							while($row = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $row['MB_LEVEL_LV']?>"><?php echo $row['MB_LEVEL_TITLE']?>(<?php echo $row['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
	            	<th scope="row"><label for="board_lv_reply">답변레벨</label></th>
		            <td>
						<select name="board_lv_reply" id="board_lv_reply" class="selline" style="width:160px">
	            		<?php
							$result = $coreClass -> selectQuery($tbl3, "", "ORDER BY MB_LEVEL_LV DESC", "", "");
							while($row = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $row['MB_LEVEL_LV']?>"><?php echo $row['MB_LEVEL_TITLE']?>(<?php echo $row['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_lv_comment">댓글레벨</label></th>
		            <td>
						<select name="board_lv_comment" id="board_lv_comment" class="selline" style="width:160px">
	            		<?php
							$result = $coreClass -> selectQuery($tbl3, "", "ORDER BY MB_LEVEL_LV DESC", "", "");
							while($row = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $row['MB_LEVEL_LV']?>"><?php echo $row['MB_LEVEL_TITLE']?>(<?php echo $row['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
	            	<th scope="row"><label for="board_lv_download">다운로드레벨</label></th>
		            <td>
						<select name="board_lv_download" id="board_lv_download" class="selline" style="width:160px">
	            		<?php
							$result = $coreClass -> selectQuery($tbl3, "", "ORDER BY MB_LEVEL_LV DESC", "", "");
							while($row = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $row['MB_LEVEL_LV']?>"><?php echo $row['MB_LEVEL_TITLE']?>(<?php echo $row['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_lv_exposure">노출일자 레벨</label></th>
		            <td>
						<select name="board_lv_exposure" id="board_lv_exposure" class="selline" style="width:160px">
							<option value="0">사용안함</option>
	            		<?php
							$order = "ORDER BY MB_LEVEL_LV DESC";
							$result = $coreClass -> selectQuery(tbl_member_level, "", $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MB_LEVEL_LV']?>"><?php echo $rowc['MB_LEVEL_TITLE']?>(<?php echo $rowc['MB_LEVEL_LV']?>)</option>
						<?php } ?>
				        </select>
					</td>
	            	<th scope="row"><label for="board_sms">답변SMS여부 사용유무</label></th>
		            <td>
						<select name="board_sms" id="board_sms" class="selline" style="width:80px">
				            <option value="N">N</option>
							<option value="Y">Y</option>
				        </select>
					</td>
				</tr>

	            <tr>
	            	<th scope="row"><label for="board_order1">정렬옵션</label></th>
		            <td colspan="3">
				    <?
					$BOARD_ORDER = EXPLODE(" ",$row['BOARD_ORDER']);
					?>
						<select name="board_order1" id="board_order1" class="selline" style="width:160px">
							<option value="" <?php if("" == $BOARD_ORDER[0]) echo "selected";?>>기본 정렬</option>
							<? for($i=0;$i<count($arr_bbs_order);$i++){?>
							<option value="<?=$arr_bbs_order[$i][1]?>" ><?=$arr_bbs_order[$i][2]?></option>
							<?}?>
				        </select>
						<select name="board_order2" id="board_order2" class="selline" style="width:160px">
							<option value="">-</option>
							<option value="asc">오름차순</option>
							<option value="desc">내림차순</option>
				        </select>
					</td>
				</tr>
				<tr>
	            	<th scope="row"><label for="board_subject_len">목록 제목 길이</label></th>
		            <td colspan="3">
	    				<input type="text" name="board_subject_len" id="board_subject_len" class="inpline" style="width:80px;" value="50">
					</td>
				</tr>

	            <tr>
	            	<th scope="row"><label for="board_header">게시판헤더</label></th>
		            <td colspan="3"><?php $coreClass -> getEditor(2, "board_header", "100%", "200px", ""); ?></td>
				</tr>
				<tr>
	            	<th scope="row"><label for="board_footer">게시판헤더</label></th>
		            <td colspan="3"><?php $coreClass -> getEditor(2, "board_footer", "100%", "200px", ""); ?></td>
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