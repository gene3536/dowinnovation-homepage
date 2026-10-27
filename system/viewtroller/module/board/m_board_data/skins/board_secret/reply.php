<?php
	/** 140624 */
	require_once $dir2.'reply.header.php';
	require_once $dir2.'lib.default.php';
?>
<form name="reply" method="post" action="sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data" onsubmit="return $.brdValidation();">
	<input type="hidden" name="mod" value="process">
	<input type="hidden" name="act" value="reply">
	<input type="hidden" name="tbl_id" value="<?php echo $bid?>">
	<input type="hidden" name="no" value="<?php echo $row['BRDATA_NO']?>">
	<input type="hidden" name="page" value="<?php echo $page?>">
    <input type="hidden" name="search" value="<?php echo $search?>">
    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
    <input type="hidden" name="cate" value="<?php echo $cate?>">
    <input type="hidden" name="code1" value="<?php echo $code1?>" />
    <input type="hidden" name="code2" value="<?php echo $code2?>" />
    <input type="hidden" name="token" value="<?php echo site_config_token?>" />
    
<div class="board_w mt_40">
	<div class="sb_form">
		<table class="sv_table" summary="<?php echo site_menu_locTitle ?> 게시판의 제목, 구분, 작성자, 이메일, 연락처, 공지여부, 비밀글여부, 첨부파일, 내용, 인증번호, 비밀번호 등의 정보를 목록으로 제공하고 있다.">
        <caption><?php echo site_menu_locTitle ?> 글답변</caption>
			<tr>
            	<th class="w20" id="write_tit" scope="row"><label for="brdata_subject">제목</label></th>
	            <td class="w80" headers="write_tit"><input type="text" id="brdata_subject" name="brdata_subject" class="input_w95" value="<?php echo $row['BRDATA_SUBJECT']?>" /></td>
    	    </tr>
			<?php if($board_data['BOARD_CATEGORY']=="Y") { ?>
				<tr>
			    	<th>구분</th>
		        	<td>
					<?php
						if($row['BRDATA_CATEGORY'] == 0) {
							echo "일반";
						} else {
							echo $coreClass -> getCatid2Name($row['BRDATA_CATEGORY'], $bid);
						}
					?>
					<input type="hidden" name="brdata_category" value="<?php echo $row['BRDATA_CATEGORY']?>">
					</td>
				</tr>
			<?php } ?>
    	    <tr>
        	    <?php if(S_mb_level <= site_config_level) { ?>
                	<th scope="row"><label for="brdata_name">작성자</label></th>
              		<td><input type="text" id="brdata_name" name="brdata_name" class="input_w20" value="<?php echo S_mb_name?>" /></td>
                <?php } else { ?>
                	<th scope="row">작성자</th>
                	<td><?php echo $row['BRDATA_NAME']?></td>
	            <?php } ?>
	        </tr>
			<tr>
				<th scope="row"><label for="brdata_email">이메일</label></th>
				<td><input type="text" id="brdata_email" name="brdata_email" class="input_w95" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_hp">연락처</label></th>
				<td><input type="text" id="brdata_hp" name="brdata_hp" value="<?php echo $row['BRDATA_HP']?>" class="input_w95" /></td>
			</tr>
			<?php
				if($board_data['BOARD_PRIVACY'] == "Y") {
					if($row['BRDATA_PRIVACY'] == "Y") {
						echo '<input type="hidden" name="brdata_privacy" value="Y" />';
	    			} else {
	    	?>
	    		<tr>
        		    <th scope="row"><label for="brdata_privacy">비밀글여부</label></th>
		            <td>
        			    <label><input type="checkbox" id="brdata_privacy" name="brdata_privacy" value="Y" <?php if($row['BRDATA_PRIVACY']=="Y") { echo "checked"; }?>> 비밀글을 사용하시려면 체크해주세요.</label>
		            </td>
        		</tr>	
			<?php } } ?>
			<tr>
	       	    <td colspan="2">
	       	    	<?php $coreClass -> getEditor(site_config_editor, "brdata_content", "100%", "200px", "<br /><br />=========================== 원글 =============================<br />".$row['BRDATA_CONTENT']); ?>
	       		</td>
			</tr>
	        <tr>
	            <th scope="row"><label for="uploadFile1">첨부파일</label></th>
            	<td><?php echo $updForm ?></td>
			</tr>
			<?php if(S_mb_level >= site_config_glevel) { ?>
    	    <tr>
    	        <th scope="row"><label for="brdata_passchg">비밀번호</label></th>
        	    <td>
        	    	<input type="password" id="brdata_passchg" name="brdata_passchg" class="input_w20" maxlength="8" value="" />
                    <div style="padding:5px">
        	    		&bull;&nbsp;변경할 경우에만 입력해주세요.
                    </div>
        	    </td>
	        </tr>          
            <?php } ?>
	</table>

	<?php require_once($dir2.'lib.btn.php'); ?>	   
	
	</div>
</div>
</form>