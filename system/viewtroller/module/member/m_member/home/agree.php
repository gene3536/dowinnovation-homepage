

<form name="reqCBAForm" id="reqCBAForm" method="post" action="sub.php">
		<input type="hidden" name="mod" value="join" />
		<input type="hidden" name="menukey" value="<?=$menukey?>">
		<input type="hidden" name="token" value="<?php echo site_config_token?>" />



						<div class="sc00">
							<p class="icon01">개인정보보호방침</p>
							<div class="agreeBox">								
								<p>개인정보보호방침</p>
							</div>	
							<p class="agree_ck mb_30"><input type="checkbox" name="agreeVar1" id="agreeVar1" value="done1" require="require"><label for="access_box01">위의 개인정보보호방침에 동의합니다.</label></p>
							
							<p class="icon01">회원약관</p>
							<div class="agreeBox">	
								<p>회원약관</p>
							</div>	
							<p class="agree_ck"><input type="checkbox" name="agreeVar2" id="agreeVar2" value="done2"><label for="access_box02">위의 회원약관에 동의합니다.</label></p>

							<div class="sc00_btn">
								<button title="다음단계" class="b_btn_on" type="submit" onclick="chkForm(); return false;"><span>다음단계로</span></button>
								<a href="/main.php" class="roundBtn btn_bk">취소</a>
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
	if(frm.agreeVar2.checked == false){
		alert('약관에 동의하세요.');
		frm.agreeVar2.focus();
		return false;
	}
	frm.submit();
}
</script>