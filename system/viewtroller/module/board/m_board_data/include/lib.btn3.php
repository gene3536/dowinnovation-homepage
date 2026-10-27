<?php
	
	
	$return_url = $_SERVER["REQUEST_URI"];	
	
	if($mod == "view") {
		// 이동/복사
		if(S_mb_level <= bbs_config_level) {
			//$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=movecopy&amp;no='.$row['BRDATA_NO'].$listVar.'">이동/복사</a>';
		}
		
		// 삭제
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			// 완전삭제
			if(S_mb_level <= bbs_config_level) {
				$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=adelete&amp;no='.$no.'&amp;token='.site_config_token.$listVar.'" onclick="if(confirm(\'정말로 완전삭제 하시겠습니까?\n삭제된 내용은 복구 할 수 없습니다.\')) location.href=this.href; return false" class="btn_big"><span>완전삭제</span></a>';
			}		
			// 삭제
			if(S_mb_level <= bbs_config_level || (S_mb_id == $row['BRDATA_UID'] && S_mb_level <= site_config_alevel) || ($row['BRDATA_AUTHKEY'] != NULL && $row['BRDATA_AUTHKEY'] != "" && S_mb_authkey == $row['BRDATA_AUTHKEY'] && S_mb_level <= site_config_alevel)) {
				$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=delete&amp;no='.$no.'&amp;token='.site_config_token.$listVar.'" onclick="if(confirm(\'정말로 삭제 하시겠습니까?\')) location.href=this.href; return false" class="btn_big"><span>삭제</span></a>';
			} else if(S_mb_level >= site_config_glevel && S_mb_id == $row['BRDATA_UID']) {
				$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=process&amp;rtnact=delete&amp;no='.$no.$listVar.'" class="btn_big"><span>삭제</span></a>';
			}
		}
		
		// 답글버튼
		if(S_mb_level <= $board_data['BOARD_LV_REPLY']) {
			if($board_data['BOARD_TYPE'] == "board" || $board_data['BOARD_TYPE'] == "board_secret" || $board_data['BOARD_TYPE'] == "eng_board" || $board_data['BOARD_TYPE'] == "eng_board_secret") {
				$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=reply&amp;no='.$no.$listVar.'" class="btn_big"><span>답글</span></a>';
			}
		}

		// 수정버튼
		
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			
			if(S_mb_level <= bbs_config_level || (S_mb_id == $row['BRDATA_UID'] && S_mb_level <= site_config_alevel) || ($row['BRDATA_AUTHKEY'] != NULL && $row['BRDATA_AUTHKEY'] != "" && S_mb_authkey == $row['BRDATA_AUTHKEY'] && S_mb_level <= site_config_alevel)) {
				
				$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=modify&amp;no='.$no.$listVar.'" class="btn_big"><span>수정</span></a>';
			} else if(S_mb_level >= site_config_glevel && S_mb_id == $row['BRDATA_UID']) {
				
				$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=modify&amp;no='.$no.$listVar.'" class="btn_big"><span>수정</span></a>';
			}
		}

		
		// 복구버튼
		
		if(S_mb_level <= bbs_config_level && $row['BRDATA_DELETED'] == "Y") {
			$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=restore&amp;no='.$no.'&amp;token='.site_config_token.$listVar.'" class="btn_big"><span>복구</span></a>';
		}		
	
	}
	
	if(empty($mod) || $mod == "list") {
		if(S_mb_level <= bbs_config_level) {
			if($board_data['BOARD_TYPE']=="board" || $board_data['BOARD_TYPE']=="board_secret"){
				$btnData .= '<button title="선택삭제" class="btn_big" type="submit"><strong>선택삭제</strong></button>';
			}
		}
	}


	// 전체목록
	if(!empty($search) && ($mod == "list" || empty($mod))) {
		$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=list" class="btn_big"><span>전체목록</span></a>';
	}
	
	// 등록버튼
	
	if(($mod == "list") || ($mod == "view") || empty($mod)) {
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			
			$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=insert'.$listVar.'" class="btn_big"><span>등록</span></a>';
		} else {
			$btnData .= '<a href="sub.php?menukey='.$menukey.'&mod=insert'.$listVar.'" class="btn_big"><span>등록</span></a>';
		}
		if(($mod == "list") || empty($mod)) {
			//$btnData .= '<a href="/base/xml/bbsList.php?'.$strParam.'" target="_blank" title="새창에서 열림">RSS</a>';
		}
	} else if(($mod == "insert") || ($mod == "modify") || ($mod == "reply") || ($mod == "status1") || ($mod == "status2")) {
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			
			$btnData .= '<button title="글쓰기" class="btn_big" type="submit"><strong>등록</strong></button>';
			//$btnData .= '<button class=""><strong>등록</strong></button>&nbsp;';
		}
	}
	
	// 목록버튼
	if(($mod == "view") || ($mod == "insert") || ($mod == "modify") || ($mod == "reply") || ($mod == "status1") || ($mod == "status2")) {
		
		$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=list'.$listVar.'" class="btn_big"><span>목록</span></a>';
	}

?>

<div class="brdlist_footer">	
	<div class="bt">
		<?php echo $btnData ?>
	
	</div>

</div>