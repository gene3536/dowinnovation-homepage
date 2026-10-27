
<div class="board_w">

<div style="width:48%; float:left; display:inline;">
<form id="registFrm1" name="registFrm1" method="post">
	<input type="hidden" name="mod" value="findID" />
	<input type="hidden" name="mb_scode" value="<?php echo site_config_code?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
	
	<h3 class="icon_h3 pb_20">아이디 찾기</h3> 

	<div class="sb_form">
		<table class="sv_table" summary="<?php echo site_menu_locTitle ?> 게시판의 제목, 구분, 작성자, 이메일, 연락처, 공지여부, 비밀글여부, 첨부파일, 내용, 인증번호, 비밀번호 등의 정보를 목록으로 제공하고 있다.">
			<colgroup>
			<col width="23%">
			<col width="77%">
			</colgroup>
			<tbody>
			<tr>
				<th scope="row">이름 *</th>
				<td>
					<input type="text" name="mb_name1" id="mb_name1" value="" style="width:100%;" />
				</td>
			</tr>
			<tr>
				<th scope="row">이메일 *</th>
				<td>
					<input type="text" name="mb_email1" id="mb_email1" value="" style="width:100%;" /> 
				</td>
			</tr>
			</tbody>
		</table>
		<div style="width:100%; height:60px; background:blue; display:none;" class="findResArea">
			<button title="글쓰기" class="b_btn_on" type="button" onclick="location.href='sub.php?menukey=524';return false;"><span>로그인</span></button>
		</div>
	</div>

	<div class="sb_btn_w">	
		<div class="sb_btn">
			<button title="글쓰기" class="b_btn_on" type="submit"><span>찾기</span></button>
		</div>
	</div>

</form>
</div>

<div style="width:48%; float:right; display:inline;">
<form id="registFrm2" name="registFrm2" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" id="mod" name="mod" value="process" />
	<input type="hidden" id="act" name="act" value="findPW" />
	<input type="hidden" name="mb_scode" value="<?php echo site_config_code?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
	
	<h3 class="icon_h3 pb_20">비밀번호 찾기</h3> 

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
					<input type="text" name="mb_uid2" id="mb_uid2" value="" style="width:100%;" />
				</td>
			</tr>
			<tr>
				<th scope="row">이름 *</th>
				<td>
					<input type="text" name="mb_name2" id="mb_name2" value="" style="width:100%;" />
				</td>
			</tr>
			<tr>
				<th scope="row">이메일 *</th>
				<td>
					<input type="text" name="mb_email2" id="mb_email2" value="" style="width:100%;" /> 
				</td>
			</tr>
			</tbody>
		</table>
	</div>

	<div class="sb_btn_w">	
		<div class="sb_btn">
			<button title="글쓰기" class="b_btn_on" type="submit"><span>찾기</span></button>
		</div>
	</div>

</form>
</div>

</div>

<style>
.findRes { width:100%; text-align:center; color:#fff; }
</style>


<script>
$(document).ready(function(){
	$("#registFrm1").validate({
		rules : {
			mb_name1 :{required:true},
			mb_email1 :{required:true}
		},
		messages : {
			mb_name1 :{required:"이름을 입력하세요."},
			mb_email1 :{required:"이메일을 입력하세요."}
		},
		submitHandler: function (frm, event){ 
			event.preventDefault();
			$(".findRes").remove();
			$(".findResArea").hide();
			var param = $("#registFrm1").serialize();
			$.ajax({
				url : "/home/member/validate.php",
				method : "post",
				data : param,
				dataType : "json",
				success : function(res){
					if(res['res'] != ''){
						$(".findResArea").show().append("<span class='findRes'>회원님의 아이디는 "+res['res']+" 입니다.</span>");
					}else{
						alert(res['msg']);
						return ;
					}
				},
				error : function(x, t, e){
				}
			});
		}
	});
	$("#registFrm2").validate({
		rules : {
			mb_name2 :{required:true},
			mb_uid2 :{required:true},
			mb_email2 :{required:true}
		},
		messages : {
			mb_name2 :{required:"이름을 입력하세요."},
			mb_uid2 :{required:"아이디를 입력하세요."},
			mb_email2 :{required:"이메일을 입력하세요."}
		},
		submitHandler: function (frm){ 
			frm.submit();   
		}
	});

	/*$("form button").on("click",function(){ 

	});*/

});
</script>