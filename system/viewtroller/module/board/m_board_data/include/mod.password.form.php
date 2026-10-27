<!--★★★★★ Board start ★★★★★//-->
<div class="inner newBoard">


	<!-- newBoard Password : S //-->
	<div class="newBoard__pass">
		<form name="passfrm" method="post" action="sub.php?menukey=<?=$menukey?>&amp;mod=<?=$rtnmod?>" onsubmit="return chk_pass(this);">
			<input type="hidden" name="act" value="<?=$rtnact?>">
			<input type="hidden" name="no" value="<?=$no?>">
			<input type="hidden" name="cno" value="<?=$cno?>">
			<input type="hidden" name="page" value="<?=$page?>">
			<input type="hidden" name="search" value="<?=$search?>">
			<input type="hidden" name="kwd" value="<?=$kwd?>">
			<input type="hidden" name="cate" value="<?=$cate?>">
			<input type="hidden" name="rtnmod" value="<?=$rtnmod?>">    
			<input type="hidden" name="rtnact" value="<?=$rtnact?>">  
			<? if($rtnact=="comment_del"){
			$no = $bno;
			?>
			<input type="hidden" name="bid" value="<?php echo $bid?>">
			<input type="hidden" name="bno" value="<?php echo $bno?>">
			<input type="hidden" name="pageC" value="<?php echo $pageC?>">
			<?}?>
			<input type="hidden" name="token" value="<?php echo site_config_token?>" />

			<!-- newBoard Password Header: S //-->
				<?php if(site_language == "eng"){ 
					$passinfo1 = "Please enter your password.";
					$passinfo2 = "Password";						
				}else{
					$passinfo1 = "비밀번호를 입력해주세요.";
					$passinfo2 = "비밀번호";
				}?>
				<div class="newBoard__pass-header" data-aos="fade-up">
					<h3 class="newBoard__pass-title"><?=$passinfo1?></h3>
					<p class="text"><?=$passinfo2?></p>
				</div>
				<!--// newBoard Password Header : E -->

				<div class="newBoard__pass-contents newBoard__write" data-aos="fade-up">
					<input type="password" id="brdata_wd" name="brdata_wd" placeholder="비밀번호를 입력해주세요.">
				</div>

			<div class="board_w">
				<!-- Form -->

				
				
				<!-- 버튼 : S //-->
				<div class="newBoard__btn" data-aos="fade-up">
					<div class="newBoard__btn-wrap">
						<button type="submit" class="btn type1"><span>확인</span></button>
						<a href="sub.php?menukey=<?=$menukey?><?php echo $listVar?>" class="btn type2"><span>취소</span></a>
					</div>
				</div>
				<!--// 버튼 : E -->
				
			</form>
		</div>
	<!--// newBoard Password : E -->



</div>
<!--//★★★★★ Board end ★★★★★-->



