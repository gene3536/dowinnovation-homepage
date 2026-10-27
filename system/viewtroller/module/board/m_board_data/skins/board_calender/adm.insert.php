<?php
	/** 140617 */
	require_once $dir2.'insert.header.php';
	require_once $dir2.'lib.default.php';
?>

<script>
	$(document).ready(function(){
		$('.add_date').click(function(){
			var number = $('table.tbl_view1 > tbody >tr.tr_c > td.td_c > div.calender').length;
			
			$('table.tbl_view1 > tbody >tr.tr_c > td.td_c').append('<div class="calender"><input type="text" name="cTitle[]" value="" style="width:30%;" class="inpline" placeholder="일정명 예 : 1회차(전문가워크숍)"/><input type="text" name="cDate[]" value="" style="width:30%;" class="inpline" placeholder="일정 예 : 11.18"/><input type="hidden" name="cOrder[]" value="'+(number+1)+'"/><input type="button" name="del_date" value="삭제" class="del_date" /></div>');
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
</script>
<form name="insert" id="registFrm" method="post" action="<?php echo site_ssl_http?>/sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data" onsubmit="return $.brdValidation();">
	<input type="hidden" name="mod" value="process">
	<input type="hidden" name="act" value="insert">
    <input type="hidden" name="search" value="<?php echo $search?>">
    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
    <input type="hidden" name="cate" value="<?php echo $cate?>">
    <input type="hidden" name="scode" value="<?php echo $scode?>" />
    <input type="hidden" name="code1" value="<?php echo $code1?>" />
    <input type="hidden" name="code2" value="<?php echo $code2?>" />
	<input type="hidden" name="chkKey" id="chkKey" value="<?php echo $SpamKey?>">
	<input type="hidden" name="token" value="<?php echo site_config_token?>">

<div id="cenCont_in">
	<div class="brdlist_content">
		<table class="tbl_view1" border="1" cellspacing="0" summary="게시글 등록">
		<caption><?php echo site_menu_locTitle ?> 게시글 등록</caption>
		<colgroup>
			<col width="23%">
			<col width="77%">
		</colgroup>
		<tbody>
			<tr>
				<?php if(S_mb_level <= site_config_level) { ?>
					<th scope="row"><label for="brdata_name">작성자</label></th>
					<td><input type="text" id="brdata_name" name="brdata_name" style="width:20%;" value="<?php echo S_mb_name?>" class="inpline" /></td>
				<?php } else { ?>
					<th scope="row">작성자</th>
					<td><?php echo S_mb_name?></td>
				<?php } ?>
			</tr>
			<?php if($board_data['BOARD_CATEGORY'] == "Y") { ?>
				<tr>
					<th scope="row"><label for="brdata_category">분야</label></th>
					<td>
						<?=$cateList?>
					</td>
				</tr>
			<?php } ?>
			
			<tr>
				<th scope="row"><label for="brdata_subject">교육명</label></th>
				<td><input type="text" id="brdata_subject" name="brdata_subject" value="<?php echo $row['BRDATA_SUBJECT']?>" style="width:90%;" class="inpline" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_etc4">기간</label></th>
				<td><input type="text" id="brdata_etc4" name="brdata_etc4" value="<?php echo $row['BRDATA_ETC4']?>" style="width:90%;" class="inpline" placeholder="예 : 11~12월"/></td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_privacy">교육 설명</label></th>
				<td>
					<?php $coreClass -> getEditor(site_config_editor, "brdata_fld1", "100%", "200px", ""); ?>
				</td>
			</tr>
			<tr class="tr_c">
				<th scope="row">
					<label for="cTitle">교육 일정</label>
					<input type="button" name="add_date" class="add_date" value="추가" />
				</th>
				<td class="td_c">
					<div class="calender">
						<input type="text" name="cTitle[]" value="" style="width:30%;" class="inpline" placeholder="일정명 예 : 1회차(전문가워크숍)"/>
						<input type="text" name="cDate[]" value="" style="width:30%;" class="inpline" placeholder="일정 예 : 11.18"/>
						<input type="hidden" name="cOrder[]" value="1"/> 
						<input type="button" name="del_date" class="del_date" value="삭제" />	
					</div>
				</td>
			</tr>
			<?php if(S_mb_level >= site_config_glevel) { ?>
			<tr>
				<th scope="row"><label for="spamKey">인증번호</label></th>
				<td>
					<input type="text" id="spamKey" name="spamKey" class="input_w20" maxlength="6" class="inpline">
					<img src="/base/imgs/spamkey/no_<?php echo $d[0]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[0]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[1]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[1]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[2]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[2]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[3]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[3]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[4]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[4]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[5]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[5]?>">
					 ※ 옆의 인증번호를 입력해주세요
				</td>
			</tr>
			<?php } ?>
			<?php if(S_mb_level >= site_config_glevel) { ?>
			<tr>
				<th scope="row"><label for="usrwd">비밀번호</label></th>
				<td><input type="password" id="brdata_wd" name="brdata_wd" style="width:90%;" maxlength="8" class="inpline" /></td>
			</tr>
			<?php } ?>
		</tbody>
		</table>

	</div>
		
	<?php require_once $dir2.'lib.btn3.php'; ?>

</div>
</form>