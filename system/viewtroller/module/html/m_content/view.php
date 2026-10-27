<?php
	if($content['ICD_FLD5'] == "N"){
		echo htmlspecialchars_decode($content_data, ENT_QUOTES);
	}else{ 
		if(empty($content_data)){
			echo "<div style='width:100%; text-align:center;'><img src=\"/base/imgs/board/con_tt.gif\" alt=\"이미지 준비 중입니다.\" width=\"100%\" /></div>";
		}else{
			echo $content_data;
		}
	}

	/*if(site_menu_type == 3 && !empty($pageInfo['MENU_CONTENT']) && S_mb_level <= site_config_slevel) {
		echo '
		<div class="text_right margin_t_10 padding_t_10" style="border-top:1px solid #eee;" id="contentModArea">
			<a href="sub.php?menukey='.$menukey.'&amp;mod=modify" class="btn_big"><span>수정</span></a>
		</div>';
	}*/
?>