<?php if(S_mb_login == false) $coreClass->msg_back("로그인이 필요합니다.");  ?>

<form name="reqCBAForm" id="reqCBAForm" method="post" action="sub.php">
		<input type="hidden" name="mod" value="leave2" />
		<input type="hidden" name="menukey" value="<?=$menukey?>">
		<input type="hidden" name="token" value="<?php echo site_config_token?>" />



						<div class="sc00">
							<p class="icon01">탈퇴약관관</p>
							<div class="agreeBox">								
								<p>탈퇴 후 동일 아이디로 재가입은 불가능합니다.</p>		
								<p>신중하게 결정해주세요.</p>
							</div>	
							<p class="agree_ck mb_30"><input type="checkbox" name="agreeVar1" id="agreeVar1" value="done1" require="require"><label for="access_box01">동의</label></p>

							<div class="sc00_btn">
								<button title="다음단계" class="b_btn_on" type="submit" onclick="chkForm(); return false;"><span>다음단계로</span></button>
								<a href="/main.php" class="roundBtn btn_bk">탈퇴취소</a>
							</div>
						</div>




</form>

<script>
function chkForm(){
	var frm = document.getElementById("reqCBAForm") || document.reqCBAForm ;
	if(frm.agreeVar1.checked == false){
		alert('약관에 동의하세요.');
		frm.agreeVar1.focus();
		return false;
	}
	frm.submit();
}
</script>