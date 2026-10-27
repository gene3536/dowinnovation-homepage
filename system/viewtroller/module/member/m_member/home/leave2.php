<?php 
	if(!isset($agreeVar1) && $agreeVar1 != "done") $coreClass->go("sub.php?menukey=".$menukey."&mod=leave1");

	$where = "WHERE mb_uid='".S_mb_id."' AND mb_del='N'";
	$row   = $coreClass -> selectQueryArray($tbl1, $where, "", "", ""); 
?>

<div class="board_w">

<form id="registFrm" name="registFrm" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" id="mod" name="mod" value="process" />
	<input type="hidden" id="act" name="act" value="leave" />
	<input type="hidden" name="mb_scode" value="<?php echo site_config_code?>" /> 
	<input type="hidden" name="token" value="<?php echo site_config_token?>" /> 
	<input type="hidden" name="no" value="<?php echo $row['MB_NO']?>" /> 
	
	<h3 class="icon_h3 pb_20">탈퇴확인</h3> 

	<div class="sb_form">
		<table class="sv_table" summary="<?php echo site_menu_locTitle ?> 게시판의 제목, 구분, 작성자, 이메일, 연락처, 공지여부, 비밀글여부, 첨부파일, 내용, 인증번호, 비밀번호 등의 정보를 목록으로 제공하고 있다.">
			<colgroup>
			<col width="23%">
			<col width="77%">
			</colgroup>
			<tbody>
			<tr>
				<th scope="row">아이디 *</th>
				<td>
					<?php echo $row['MB_UID']?>
					<input type="hidden" name="mb_uid" value="<?php echo $row['MB_UID']?>" /> 
				</td>
			</tr>
			<tr>
				<th scope="row">비밀번호 *</th>
				<td>
					<input type="password" name="mb_pass" id="mb_pass" value="" style="width:30%;" /> 
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="sb_btn_w">	
		<div class="sb_btn">
			<a href="<?php echo site_config_path?>/main.php"><span>탈퇴취소</span></a>
			<button title="글쓰기" class="b_btn_on" type="submit"><span>다음단계로</span></button>
		</div>
	</div>

</form>

</div>

<script>
$(document).ready(function(){
	$("#registFrm").validate({
		rules : {
			mb_uid :{required:true},
			mb_pass :{required:true}
		},
		messages : {
			mb_uid :{required:"아이디를 입력하세요."},
			mb_pass :{required:"비밀번호를 입력하세요."}
		},
		submitHandler: function (frm){ 
			frm.submit();   
		}
	});

});
</script>