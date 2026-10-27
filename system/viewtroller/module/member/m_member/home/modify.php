<?php 
if(S_mb_login == false || S_mb_level > 9) $coreClass->msg_back("로그인 후 이용하세요."); 

$where = "WHERE mb_uid='".S_mb_id."' AND mb_del='N'";
$row   = $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
?>

<div class="board_w">

<form id="registFrm" name="registFrm" method="post" action="sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data">
	<input type="hidden" id="mod" name="mod" value="process" />
	<input type="hidden" id="act" name="act" value="modify" />
	<input type="hidden" name="no" value="<?php echo $row['MB_NO']?>" />
	<input type="hidden" name="mb_scode" value="<?php echo site_config_code?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
	
	<h3 class="icon_h3 pb_20">회원정보</h3> 

	<div class="sb_form">
		<table class="sv_table" summary="<?php echo site_menu_locTitle ?> 게시판의 제목, 구분, 작성자, 이메일, 연락처, 공지여부, 비밀글여부, 첨부파일, 내용, 인증번호, 비밀번호 등의 정보를 목록으로 제공하고 있다.">
			<colgroup>
			<col width="23%">
			<col width="77%">
			</colgroup>
			<tbody>
			<tr>
				<th scope="row">이름 *</th>
				<td><input type="text" name="mb_name" id="mb_name" value="<?php echo $row['MB_NAME']?>" style="width:30%;" /></td>
			</tr>
			<tr>
				<th scope="row">아이디 *</th>
				<td>
					<?php echo $row['MB_UID']?>
					<input type="hidden" name="mb_uid" value="<?php echo $row['MB_UID']?>">
				</td>
			</tr>
			<tr>
				<th scope="row">현재 비밀번호 *</th>
				<td>
					<input type="password" name="mb_pass" id="mb_pass" value="" style="width:30%;" /> 
				</td>
			</tr>
			<tr>
				<th scope="row">변경할 비밀번호 *</th>
				<td>
					<input type="password" name="mb_pass1" id="mb_pass1" value="" style="width:30%;" /> <span>비밀번호를 변경할 경우만 입력</span>
				</td>
			</tr>
			<tr>
				<th scope="row">변경할 비밀번호 확인 *</th>
				<td><input type="password" name="mb_pass2" id="mb_pass2" value="" style="width:30%;" /></td>
			</tr>
			<tr>
				<th scope="row">이메일 *</th>
				<td>
					<input type="text" name="mb_email" id="mb_email" value="<?php echo $coreClass->decrypt_md5($row['MB_EMAIL'], site_config_mbkey)?>" style="width:60%;" />
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="sb_btn_w">	
		<div class="sb_btn">
			<button title="글쓰기" class="b_btn_on" type="submit"><span>확인</span></button>
			<p class="b_btn_off"><a href="<?=site_config_path?>/main.php">취소</a></p>
		</div>
	</div>

</form>

</div>

<script>
$(document).ready(function(){
	$("#registFrm").validate({
		rules : {
			mb_name :{required:true},
			mb_pass :{required:true},
			mb_pass1 :{minlength:8, regex:/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@@#$]).*$/},
			mb_pass2 :{equalTo:"#mb_pass1"},
			mb_email :{required:true, email:true}
		},
		messages : {
			mb_name :{required:"이름을 입력하세요."},
			mb_pass :{required:"비밀번호를 입력하세요."},
			mb_pass1 :{minlength:"최소 8자 이상 입력하세요.", regex:"비밀번호를 영문, 숫자, 특수문자 조합 8자 이상 20자 이하로 입력하세요."},
			mb_pass2 :{equalTo:"비밀번호가 일치하지 않습니다."},
			mb_email :{required:"이메일을 입력하세요.", email:"이메일 형식을 바르게 입력하세요."}
		},
		submitHandler: function (frm, e){ 
			e.preventDefault();
			var p1 = $("#mb_pass1").val(), p2 = $("#mb_pass2").val();
			if(p1 != "" || p2 != ""){
				if(p1.trim() != p2.trim()){
					alert("비밀번호가 일치하지 않습니다.2");
					$("#mb_pass1").focus();
				}else{
					frm.submit();
				}
			}else{
				frm.submit();
			}
			return false;
		},
		success: function(e){
			//
		}
	});
});


</script>