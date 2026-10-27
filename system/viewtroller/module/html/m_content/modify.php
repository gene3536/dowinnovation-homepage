<form name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>">
    <input type="hidden" name="mod" value="process">
	<input type="hidden" name="act" value="modify" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
	
	<div class="text_right margin_t_10 padding_t_10" style="border-top:1px solid #eee;">
		<textarea id="icd_content" name="icd_content" style="width:100%; height:320px"><?php echo $content_data ?></textarea>
	</div>
	
	<div class="text_right margin_t_10 padding_t_10" style="border-top:1px solid #eee;">
		<button type="submit" class="btn_big"><strong>수정</strong></button>
		<a href="sub.php?menukey=<?php echo $menukey?><?php echo $pageVar?>" class="btn_big"><span>취소</span></a>
	</div>
</form>