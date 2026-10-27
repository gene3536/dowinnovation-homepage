<?php require_once $dir3."bbs.insert.header.php";
?>

<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data" onsubmit="return $.frmValidation();">
    <input type="hidden" name="mod" value="process">
    <input type="hidden" name="act" value="insert">
    <input type="hidden" name="no" value="<?php echo $no?>">
    <input type="hidden" name="search" value="<?php echo $search?>">
    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
    <input type="hidden" name="scode" value="<?php echo $scode?>">
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
	
	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" summary="게시글 수정">
	        <caption>게시글 수정</caption>
	        <colgroup>
	        	<col style="width:20%;" />
	            <col style="width:30%;" />
	            <col style="width:20%;" />
	            <col style="width:30%;" />
	        </colgroup>
	        <tbody>
	        	<tr>
	        		<th scope="row" class="title"><label for="brdata_bid">게시판</label></th>
	        		<td colspan="3">
	        			<select id="brdata_bid" name="brdata_bid" class="selline" title="검색조건" style="width:160px">
		        		<?php
		        			
							while($brow = $coreClass -> selectFetchArray($brs)) {
		        				$bcwhere		= "WHERE brdata_bid = '".$brow['BOARD_ID']."'";
								$bcnt			= $coreClass -> selectQueryCount(tbl_board_data, $bcwhere);	
		        				echo "<option value=\"".$brow['BOARD_ID']."\"";
								if($brow['BOARD_ID'] == $code4) {
									echo "selected=\"selected\"";
								}		        				
		        				echo ">[".$bcnt."] ".$brow['BOARD_NAME']."</option>";
							}
						?>
					</select>
	        		</td>     		
	        	</tr>
				<tr>
					<th scope="row"><label for="brdata_subject">제목</label></th>
					<td colspan="3"><input type="text" id="brdata_subject" name="brdata_subject" class="inpline" style="width:420px" /></td>
				</tr>
				<tr>	            
                	<th scope="row">작성자</th>
                	<td><?php echo S_mb_name?></td>
	    	        <th scope="row"><label for="brdata_info4">비밀번호</label></th>
	        	    <td><input type="password" id="brdata_info4" name="brdata_info4" class="inpline" style="width:160px;" maxlength="8" value="" /></td>
		        </tr>	        	
		        <tr>
	    	        <th scope="row"><label for="brdata_email">이메일</label></th>
	        	    <td><input type="text" id="brdata_email" name="brdata_email" class="inpline" style="width:160px" /></td>
		        	<th scope="row"><label for="brdata_hp">연락처</label></th>
	    	        <td><input type="text" id="brdata_hp" name="brdata_hp" class="inpline" style="width:160px" /></td>
		        </tr>
				<?php if(S_mb_level <= site_config_level) { ?>
  				<tr>
		            <th scope="row"><label for="brdata_notice">공지여부</label></th>
        		    <td colspan="3">
			            <input type="checkbox" id="brdata_notice" name="brdata_notice" value="Y" style="vertical-align:middle" /> 공지글인 경우 기간을 설정해 주세요.<br />
	        			<input type="text" id="brdata_sdate" name="brdata_sdate" class="inpline" style="width:100px;margin-right:4px" title="공지시작일" />
			            -
	        			<input type="text" id="brdata_edate" name="brdata_edate" class="inpline" style="width:100px;margin-right:4px" title="공지종료일" />
                    </td>
				</tr>
				<?php } ?>
		
	            <?php if(S_mb_level <= $brow['BOARD_LV_EXPOSURE']) { ?>
	  				<tr>
			            <th scope="row" class="gray"><label for="brdata_sexposure">노출기간 설정</label></th>
	        		    <td colspan="3">
	        			<input type="text" id="brdata_sexposure" name="brdata_sexposure" value="" class="inpline" style="width:100px;margin-right:4px" title="노출시작일" />
			            -
	        			<input type="text" id="brdata_eexposure" name="brdata_eexposure" value="" class="inpline" style="width:100px;margin-right:4px" title="노출종료일" />
	                    
	                    </td>
					</tr>
				<?php } ?>				
				<?php if($brow['board_privacy']=="Y"){ ?>
			        <tr>
	        		    <th scope="row"><label for="brdata_privacy">비밀글여부</label></th>
			            <td colspan="3">
	        			    <label><input type="checkbox" id="brdata_privacy" name="brdata_privacy" value="Y" /> 비밀글을 사용하시려면 체크해주세요.</label>
			            </td>
	        		</tr>
				<?php } ?>
				<tr>
		            <th scope="row"><label for="brdata_content">내용</label></th>
	       		    <td colspan="3">
	       		    	<?php $coreClass -> getEditor(site_config_editor, "brdata_content", "100%", "400px", ""); ?>
	       			</td>
		        </tr>
				<tr>
		            <th scope="row"><label for="uploadFile1">첨부파일</label></th>
	            	<td colspan="3">
                		<input type="file" id="uploadFile1" name="uploadFile1" class="fileline" title="첨부파일 등록폼" /><br />
                		<input type="file" id="uploadFile2" name="uploadFile2" class="fileline" title="첨부파일 등록폼" />
	                	<div>&nbsp;&bull;&nbsp;업로드 가능용량은 10MB 입니다.</div>
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