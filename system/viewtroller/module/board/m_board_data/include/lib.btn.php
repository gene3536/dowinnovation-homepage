<?php
	
	$return_url    = urlencode($_SERVER["REQUEST_URI"]);
	$login_menukey = site_config_code == "00000002" ? "524" : "528";
	
	if($mod == "view") {
		// 이동/복사
		if(S_mb_level <= bbs_config_level) {
			//$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=movecopy&amp;no='.$row['BRDATA_NO'].$listVar.'">이동/복사</a></p>';
		}
		
		// 삭제
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			// 완전삭제
			if(S_mb_level <= bbs_config_level) {
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=adelete&amp;no='.$no.'&amp;token='.site_config_token.$listVar.'" onclick="if(confirm(\'정말로 완전삭제 하시겠습니까?\n삭제된 내용은 복구 할 수 없습니다.\')) location.href=this.href; return false">완전삭제</a></p>';
			}		
			// 삭제
			if(S_mb_level <= bbs_config_level || (S_mb_id == $row['BRDATA_UID'] && S_mb_level <= site_config_alevel) || ($row['BRDATA_AUTHKEY'] != NULL && $row['BRDATA_AUTHKEY'] != "" && S_mb_authkey == $row['BRDATA_AUTHKEY'] && S_mb_level <= site_config_alevel) || ( isset($_SESSION['modify'.$row['BRDATA_NO']]) && $_SESSION['modify'.$row['BRDATA_NO']] == 1 )) {
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=delete&amp;no='.$no.'&amp;token='.site_config_token.$listVar.'" onclick="if(confirm(\'정말로 삭제 하시겠습니까?\')) location.href=this.href; return false">삭제</a></p>';
			} else if(S_mb_level >= site_config_glevel && S_mb_id == $row['BRDATA_UID']) {
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=process&amp;rtnact=delete&amp;no='.$no.$listVar.'">삭제</a></p>';
			}
		}

		
// 답글버튼
		if(S_mb_level <= $board_data['BOARD_LV_REPLY']) { 
			if($board_data['BOARD_TYPE'] == "board" || 	$board_data['BOARD_TYPE'] == "board_counsel" || $board_data['BOARD_TYPE'] == "board_manage"){
				// 1:1 게시판 
				if($board_data['BOARD_OTO'] == 'Y') {
					$asWhere = "WHERE brdata_grp_no = '".$row['BRDATA_NO']."' AND brdata_seq_no = '1'"; 
					$asCount = $coreClass->selectQueryCount(tbl_board_data,$asWhere);

					if($asCount <= 0){
						if(S_mb_login){	
							$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=reply&amp;no='.$no.$listVar.'">답글</a></p>';
						}else{
							$btnData .= '<p class="b_btn_off"><a href="#null" onclick="alert(\'등록 권한이 없습니다.\'); return false;">답글</a></p>';
						}
					}
				}else{
					if(S_mb_login){	
						$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=reply&amp;no='.$no.$listVar.'">답글</a></p>';
					}else{
						$btnData .= '<p class="b_btn_off"><a href="#null" onclick="alert(\'등록 권한이 없습니다.\'); return false;">답글</a></p>';
					}
				}
			}

		}

		// 수정버튼
		
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			
			if(S_mb_level <= bbs_config_level || (S_mb_id == $row['BRDATA_UID'] && S_mb_level <= site_config_alevel) || ($row['BRDATA_AUTHKEY'] != NULL && $row['BRDATA_AUTHKEY'] != "" && S_mb_authkey == $row['BRDATA_AUTHKEY'] && S_mb_level <= site_config_alevel) || ( isset($_SESSION['modify'.$row['BRDATA_NO']]) && $_SESSION['modify'.$row['BRDATA_NO']] == 1 )) {
				
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=modify&amp;no='.$no.$listVar.'">수정</a></p>';
			} else if(S_mb_level >= site_config_glevel && S_mb_id == $row['BRDATA_UID']) {
				
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=modify&amp;no='.$no.$listVar.'">수정</a></p>';
			}
		}

		
		// 복구버튼
		
		if(S_mb_level <= bbs_config_level && $row['BRDATA_DELETED'] == "Y") {
			$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=process&amp;act=restore&amp;no='.$no.'&amp;token='.site_config_token.$listVar.'">복구</a></p>';
		}		
	
	}
	
	if(empty($mod) || $mod == "list") {
		if(S_mb_level <= bbs_config_level) {
			//if($board_data['BOARD_TYPE']=="board" || $board_data['BOARD_TYPE']=="board_secret"){
				$btnData .= '<button title="선택삭제" class="btn_gray" type="submit"><span>선택삭제</span></button>';
			//}
		}
	}


	// 전체목록
	if(!empty($search) && ($mod == "list" || empty($mod))) {
		$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=list">전체목록</a></p>';
	}
	
	// 등록버튼
	
	if(($mod == "list") || ($mod == "view") || empty($mod)) {
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			
			$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=insert'.$listVar.'">등록</a></p>';
		} else {
			if(S_mb_login){			
				$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=insert'.$listVar.'">등록</a></p>';
			}else{		
				$btnData .= '<p class="b_btn_off"><a href="#null" onclick="alert(\'등록 권한이 없습니다.\'); return false;">등록</a></p>';
			}
		}
		if(($mod == "list") || empty($mod)) {
			//$btnData .= '<p class="b_btn_off"><a href="/base/xml/bbsList.php?'.$strParam.'" target="_blank" title="새창에서 열림">RSS</a></p>';
		}
	} else if(($mod == "insert") || ($mod == "modify") || ($mod == "reply") || ($mod == "status1") || ($mod == "status2")) {
		if(S_mb_level <= $board_data['BOARD_LV_INSERT'] || $brdmngCnt > 0) {
			
			$btnData .= '<button title="글쓰기" class="btn_gray" type="submit"><span>등록</span></button>';
			//$btnData .= '<button class=""><strong>등록</strong></button>&nbsp;';
		}
	}
	
	// 목록버튼
	if(($mod == "view") || ($mod == "insert") || ($mod == "modify") || ($mod == "reply") || ($mod == "status1") || ($mod == "status2")) {
		
		$btnData .= '<p class="b_btn_off"><a href="sub.php?menukey='.$menukey.'&amp;mod=list'.$listVar.'">목록</a></p>';
	}

?><div class="sb_btn_w">	<div class="sb_btn"><?php echo $btnData ?>
	</div>
</div>