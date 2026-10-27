<?php if(S_mb_login == true && S_mb_level <= 9) $coreClass->go("main.php"); ?>

<div class="board_w">

<form id="registFrm" name="registFrm" method="post" action="sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data">
	<input type="hidden" id="mod" name="mod" value="process" />
	<input type="hidden" id="act" name="act" value="login" />
	<input type="hidden" name="mb_scode" value="<?php echo site_config_code?>" /> 
	<input type="hidden" name="token" value="<?php echo site_config_token?>" /> 
	
	<h3 class="icon_h3 pb_20">로그인</h3> 

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
					<input type="text" name="mb_uid" id="mb_uid" value="" style="width:30%;" />
				</td>
			</tr>
			<tr>
				<th scope="row">비밀번호 *</th>
				<td>
					<input type="password" name="mb_pass" id="mb_pass" style="width:30%;" /> 
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="sb_btn_w">	
		<div class="sb_btn">
			<button title="글쓰기" class="b_btn_on" type="submit"><span>로그인</span></button>
			<p class="b_btn_off"><a href="sub.php?menukey=548&mod=join">회원가입</a></p>
			<p class="b_btn_off"><a href="sub.php?menukey=553&mod=find">아이디/비밀번호 찾기</a></p>
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