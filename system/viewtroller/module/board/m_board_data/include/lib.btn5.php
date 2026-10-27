<?php
	
	$return_url    = urlencode($_SERVER["REQUEST_URI"]);
	$login_menukey = site_config_code == "00000002" ? "524" : "528";
	
	$btnData = "";

	if($mod == "view") {
		// 이동/복사
		if(S_mb_level <= bbs_config_level) {
			//$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=movecopy&amp;no='.$row['BRDATA_NO'].'">이동/복사</a></p>';
		}
		
		// 삭제
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			// 완전삭제
			if(S_mb_level <= bbs_config_level) {
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=adelete&amp;no='.$asRow['BRDATA_NO'].'&amp;token='.site_config_token.'" onclick="if(confirm(\'정말로 완전삭제 하시겠습니까?\n삭제된 내용은 복구 할 수 없습니다.\')) location.href=this.href; return false">완전삭제</a></p>';
			}		
			// 삭제
			if(S_mb_level <= bbs_config_level || (S_mb_id == $row['BRDATA_UID'] && S_mb_level <= site_config_alevel) || ($row['BRDATA_AUTHKEY'] != NULL && $row['BRDATA_AUTHKEY'] != "" && S_mb_authkey == $row['BRDATA_AUTHKEY'] && S_mb_level <= site_config_alevel)) {
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=delete&amp;no='.$asRow['BRDATA_NO'].'&amp;token='.site_config_token.'" onclick="if(confirm(\'정말로 삭제 하시겠습니까?\')) location.href=this.href; return false">삭제</a></p>';
			} else if(S_mb_level >= site_config_glevel && S_mb_id == $row['BRDATA_UID']) {
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=process&amp;rtnact=delete&amp;no='.$asRow['BRDATA_NO'].'">삭제</a></p>';
			}
		}

		// 수정버튼
		
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			
			if(S_mb_level <= bbs_config_level || (S_mb_id == $row['BRDATA_UID'] && S_mb_level <= site_config_alevel) || ($row['BRDATA_AUTHKEY'] != NULL && $row['BRDATA_AUTHKEY'] != "" && S_mb_authkey == $row['BRDATA_AUTHKEY'] && S_mb_level <= site_config_alevel)) {
				
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=modify&amp;no='.$asRow['BRDATA_NO'].'">수정</a></p>';
			} else if(S_mb_level >= site_config_glevel && S_mb_id == $row['BRDATA_UID']) {
				
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=modify&amp;no='.$asRow['BRDATA_NO'].'">수정</a></p>';
			}
		}

		
	
	}

	// 등록버튼
	
	if(($mod == "list") || ($mod == "view") || empty($mod)) {
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			
			$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=insert'.'">등록</a></p>';
		} else {
			if(S_mb_login){			
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=insert'.'">등록</a></p>';
			}else{		
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$login_menukey.'&amp;return_url='.$return_url.'" onclick="if(confirm(\'로그인이 필요합니다. 로그인 페이지로 이동하시겠습니까?\')){location.href=this.href;} return false;">등록</a></p>';
			}
		}
		if(($mod == "list") || empty($mod)) {
			//$btnData .= '<p class="b_btn_off"><a href="/base/xml/bbsList.php?'.$strParam.'" target="_blank" title="새창에서 열림">RSS</a></p>';
		}
	} else if(($mod == "insert") || ($mod == "modify") || ($mod == "reply") || ($mod == "status1") || ($mod == "status2")) {
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			
			$btnData .= '<button title="글쓰기" class="b_btn_on" type="submit"><span>등록</span></button>';
			//$btnData .= '<button class=""><strong>등록</strong></button>&nbsp;';
		}
	}
	
	// 목록버튼
	if(($mod == "view") || ($mod == "insert") || ($mod == "modify") || ($mod == "reply") || ($mod == "status1") || ($mod == "status2")) {
		
		$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=list'.'">목록</a></p>';
	}

?><div class="sb_btn_w">	<div class="sb_btn"><?php echo $btnData ?>
	</div>
</div>