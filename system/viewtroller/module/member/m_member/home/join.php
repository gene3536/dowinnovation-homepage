<?php 
if(S_mb_login == true && S_mb_level <= 9) $coreClass->go("main.php");
if((!isset($agreeVar1) && $agreeVar1 != "done") && (!isset($agreeVar2) && $agreeVar2 != "done2")) $coreClass->go("sub.php?menukey=".$menukey."&mod=agree"); 
?>

<div class="board_w">

<form id="registFrm" name="registFrm" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" id="mod" name="mod" value="process" />
	<input type="hidden" id="act" name="act" value="insert" />
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
				<td><input type="text" name="mb_name" id="mb_name" value="" style="width:30%;" /></td>
			</tr>
			<tr>
				<th scope="row">아이디 *</th>
				<td>
					<div><input type="text" name="mb_uid" id="mb_uid" value="" style="width:30%;" /></div>
					<div id="moreInfo" style="color:blue;"></div><input type="hidden" name="passId" id="passId" value="N">
				</td>
			</tr>
			<tr>
				<th scope="row">비밀번호 *</th>
				<td>
					<input type="password" name="mb_pass" id="mb_pass" value="" style="width:30%;" /> 
					<p class="pt_10">영문 소문자, 숫자, 특수문자 조합 (최소 8자리 이상 20자리 이하)</p>
				</td>
			</tr>
			<tr>
				<th scope="row">비밀번호 *</th>
				<td><input type="password" name="mb_pass2" id="mb_pass2" value="" style="width:30%;" /></td>
			</tr>
			<tr>
				<th scope="row">이메일 *</th>
				<td>
					<input type="text" name="mb_email" id="mb_email" value="" style="width:60%;" />
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="sb_btn_w">	
		<div class="sb_btn">
			<button title="글쓰기" class="b_btn_on" type="submit"><span>가입하기</span></button>
			<p class="b_btn_off"><a href="<?=site_config_path?>/main.php">취소</a></p>
		</div>
	</div>

</form>

</div>

<script>
$(document).ready(function(){
	$("#registFrm").validate({
		rules : {
			mb_uid :{required:true, minlength:8, maxlength:20, regex:/^(?=.*\d)(?=.*[a-z]).*$/},
			mb_name :{required:true},
			mb_pass :{required:true, minlength:8, maxlength:20, regex:/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/},
			mb_pass2 :{required:true, equalTo:"#mb_pass"},
			mb_email :{required:true, email:true}
		},
		messages : {
			mb_uid :{required:"아이디를 입력하세요.", minlength:"최소 8자 이상 입력하세요.", maxlength:"최대 20자 이하로 입력하세요.", regex:"영문, 숫자  조합 8자 이상 20자 이하로 입력하세요."},
			mb_name :{required:"이름을 입력하세요."},
			mb_pass :{required:"비밀번호를 입력하세요.", minlength:"최소 8자 이상 입력하세요.", maxlength:"최대 20자 이하로 입력하세요.", regex:"비밀번호를 영문, 숫자, 특수문자 조합 8자 이상 20자 이하로 입력하세요."},
			mb_pass2 :{required:"비밀번호를 입력하세요.", equalTo:"비밀번호가 일치하지 않습니다."},
			mb_email :{required:"이메일을 입력하세요.", email:"이메일 형식을 바르게 입력하세요."}
		},
		submitHandler: function (frm){ 
			if($("#passId").val()=="Y") frm.submit();   //유효성 검사를 통과시 전송
			return false;
		},
		success: function(e){
			//
		}
	});

	$("#mb_uid").on("keyup",function(e){ 
		$("#moreInfo").text('');
		$("#passId").val('');

		var uid = $("#mb_uid").val().trim().replace(/\s/gi,"");
		var pr  =  "mb_uid="+uid+"&scode=<?=site_config_code?>&mod=idchk";
		$.ajax({
			url : "/home/member/validate.php",
			method : "post",
			data : pr,
			dataType : "json",
			success : function(res){ //var data = eval('['+res+']');
				if(res['res'] != 'false'){
					$("#moreInfo").text(res['msg']);
					$("#passId").val(res['res']);
					if(res.res == 'N'){
						return false;
					}
				}
			},
			error : function(x, t, e){
			}
		});
	});

});


</script>