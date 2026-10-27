<?php 
	/** 게시글 수정 - 140617 */
	require_once $dir2.'modify.header.php';
	require_once $dir2.'lib.default.php';

	$attTel   = explode("-",$row['BRDATA_HP']);
	$attEmail = explode("@",$row['BRDATA_EMAIL']); 	
?>
<script>
	$(document).ready(function(){
		$('.add_date').click(function(){
			var number = $('table.tbl_view1 > tbody >tr.tr_c > td.td_c > div.calender').length;
			
			$('table.tbl_view1 > tbody >tr.tr_c > td.td_c').append('<div class="calender"><input type="text" name="cTitle[]" value="" style="width:30%;" class="inpline" placeholder="일정명 예 : 1회차(전문가워크숍)"/><input type="text" name="cDate[]" value="" style="width:30%;" class="inpline" placeholder="일정 예 : 11.18"/><input type="text" name="cOrder[]" value="'+(number+1)+'"/><input type="text" name="caIdx[]" value="" /><input type="button" name="del_date" value="삭제" class="del_date" /></div>');

			var number = 1;
			$('input[name*="cOrder"]').each(function(){
				$(this).val(number);
				number++;
			})

		});
	})
	$(document).on('click','.del_date',function(){
		var number = $('table.tbl_view1 > tbody >tr.tr_c > td.td_c > div.calender').length;
		if(number==1){
			alert('일정은 최소 1개 이상 등록해주셔야 합니다.');
			return false;
		}else{
			$(this).closest('div').remove();
			var number = 1;
			$('input[name*="cOrder"]').each(function(){
				$(this).val(number);
				number++;
			})
		}
		
		
	});

	$(document).on('click','.real_del_date',function(){
		var div	= $(this).closest('div');
		var idx = div.find('input[name*="caIdx"]').val();
		var dIdx = $('input[name="no"]').val();
		var number = $('table.tbl_view1 > tbody >tr.tr_c > td.td_c > div.calender').length;
		if(number==1){
			alert('일정은 최소 1개 이상 등록해주셔야 합니다.');
			return false;
		}else{
			if(confirm('삭제된 일정은 복원되지 않습니다.\n삭제하시겠습니까?')){
				$.ajax({
					url : "/base/php/del_calender.php",
					type : 'post',
					data : {
						'idx' : idx,
						'dIdx' : dIdx
					},
					success : function(data){
						if(data=='success'){
							div.remove();
							var number = 1;
							$('input[name*="cOrder"]').each(function(){
								$(this).val(number);
								number++;
							})
						}else{
							alert('삭제가 정상적으로 이루어지지않았습니다.');
						}	
					}
				})
			}
		}
	})
</script>
<form name="modify" method="post" action="<?php echo site_ssl_http?>/sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data" onsubmit="return $.brdValidation()">
	<input type="hidden" name="mod" value="process">
	<input type="hidden" name="act" value="modify">
	<input type="hidden" name="no" value="<?php echo $row['BRDATA_NO']?>">
	<input type="hidden" name="page" value="<?php echo $page?>">
    <input type="hidden" name="search" value="<?php echo $search?>">
    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
    <input type="hidden" name="cate" value="<?php echo $cate?>">
    <input type="hidden" name="scode" value="<?php echo $scode?>" />
    <input type="hidden" name="code1" value="<?php echo $code1?>" />
    <input type="hidden" name="code2" value="<?php echo $code2?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
    <?php if(S_mb_level > site_config_alevel) { ?>
    	<input type="hidden" name="brdata_wd2" value="<?php echo $brdata_wd?>">
    	<input type="hidden" name="rtnmod" value="modify">
    <?php } ?>
   	
<div id="cenCont_in">
	<div class="brdlist_content">
		<table class="tbl_view1" border="1" cellspacing="0" summary="게시글 수정">
        <caption><?php echo site_menu_locTitle ?> 게시글 수정</caption>
		<colgroup>
			<col width="23%">
			<col width="77%">
		</colgroup>
		<tbody>
	        <tr>
				<th id="write_tit" scope="row"><label for="brdata_subject">교육명</label></th>
				<td headers="write_tit"><input type="text" id="brdata_subject" name="brdata_subject" class="input_w95" value="<?php echo $row['BRDATA_SUBJECT']?>" /></td>
			</tr>
			<?php if($board_data['BOARD_CATEGORY']=="Y"){ ?>
				<tr>
		    		<th scope="row"><label for="brdata_category">분야명</label></th>
	        	    <td>
				        <select id="brdata_category" name="brdata_category" title="카테고리선택" style="width:120px">
							<?php while($row_c = $coreClass -> selectFetchArray($cateRs)){?>
								<option value="<?php echo $row_c['BRDCAT_ID']?>" <?php if($row['BRDATA_CATEGORY']==$row_c['BRDCAT_ID']) { echo "selected=\"selected\""; }?>><?php echo $row_c['BRDCAT_NAME']?></option>
							<?php } ?>
						</select>
    		        </td>
				</tr>
			<?php } ?>
        	<tr>	            
                <?php if(S_mb_level <= site_config_level) { ?>
                	<th scope="row"><label for="brdata_name">제안자</label></th>
              		<td><input type="text" id="brdata_name" name="brdata_name" class="input_w95" value="<?php echo $row['BRDATA_NAME']?>" /></td>
                <?php } else { ?>
                	<th scope="row">제안자</th>
                	<td><?php echo $row['BRDATA_NAME']?></td>
                <?php } ?>
        	</tr>
			<!-- 
	        <?php if(S_mb_level <= $board_data['BOARD_LV_NOTICE'] || $brdmngCnt > 0) { ?>
  				<tr>
		            <th scope="row"><label for="brdata_notice">공지여부</label></th>
        		    <td>
	        			<input type="text" id="brdata_sdate" name="brdata_sdate" value="<?php echo $row['BRDATA_SDATE']?>" class="inpput_w20" title="공지시작일">
			            -
	        			<input type="text" id="brdata_edate" name="brdata_edate" value="<?php echo $row['BRDATA_EDATE']?>" class="inpput_w20" title="공지종료일"><br />
			            <input type="checkbox" id="brdata_notice" name="brdata_notice" value="Y" <?php if($row['BRDATA_NOTICE']=="Y") { echo "checked"; } ?> style="vertical-align:middle" /> <label for="brdata_notice">공지글인 경우 기간을 설정해 주세요.</label>
	        		</td>
				</tr>
			<?php } ?>
		        <tr>
        		    <th scope="row"><label for="brdata_privacy">비밀글여부</label></th>
		            <td>
						<input type="checkbox" id="brdata_privacy" name="brdata_privacy2" value="Y" title="비밀글" style="vertical-align:middle" checked disabled />
						<input type="hidden" name="brdata_privacy" value="Y" style="vertical-align:middle" /> <label for="brdata_privacy">비밀글 (*제안서는 비밀글로 작성됩니다.)</label>
		            </td>
        		</tr>
			<tr>
				<th scope="row"><label for="thumbFile">목록이미지</label></th>
				<td><?php echo $thumbForm ?></td>
			</tr> -->
			<tr>
				<th scope="row"><label for="brdata_etc4">기간</label></th>
				<td><input type="text" id="brdata_etc4" name="brdata_etc4" value="<?php echo $row['BRDATA_ETC4']?>" style="width:90%;" class="inpline" placeholder="예 : 11~12월"/></td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_privacy">교육내용</label></th>
				<td>
					<?php $coreClass -> getEditor(site_config_editor, "brdata_fld1", "100%", "200px", $row['BRDATA_FLD1']); ?>
				</td>
			</tr>
			<tr class="tr_c">
				<th scope="row">
					<label for="cTitle">교육 일정</label>
					<input type="button" name="add_date" class="add_date" value="추가" />
				</th>
				<td class="td_c">
					<?php
						while($caRows = $coreClass -> selectFetchArray($calRs)) {?>
							<div class="calender">
								<input type="text" name="cTitle[]" value="<?=$caRows['cTitle']?>" style="width:30%;" class="inpline" placeholder="일정명 예 : 1회차(전문가워크숍)"/>
								<input type="text" name="cDate[]" value="<?=$caRows['cDate']?>" style="width:30%;" class="inpline" placeholder="일정 예 : 11.18"/>
								<input type="hidden" name="cOrder[]" value="<?=$caRows['cOrder']?>"/> 
								<input type="button" class="real_del_date" value="삭제" />	
								<input type="hidden" name="caIdx[]" value="<?=$caRows['idx']?>" />	
							</div>
					<?php }
					?>
					
				</td>
			</tr>
			
			<?php if(S_mb_level >= site_config_glevel) { ?>
	        <tr>
    	        <th scope="row"><label for="brdata_wdchg">비밀번호</label></th>
        	    <td>
        	    	<input type="password" id="brdata_wdchg" name="brdata_wdchg" class="inpput_w20" maxlength="12" value="" /> &nbsp;&bull;&nbsp;변경할 경우에만 입력해주세요.
        	    </td>
	        </tr>          
            <?php } ?> 
			
			<?php
				if($board_data['BOARD_EXTEND'] == "Y") {				
					require_once($dir1.'extend.php');
				}
			?>
		</tbody>
		</table>

	</div>
    
    <?php require_once($dir2.'lib.btn3.php'); ?> 
</div>
</form>

