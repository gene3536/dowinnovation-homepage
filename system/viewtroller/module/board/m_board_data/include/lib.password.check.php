<?php
	if(S_mb_level > bbs_config_level) {
		if(S_mb_level == site_config_glevel) {
			// 손님레벨일 경우 비밀번호 체크
			if( !isset($_SESSION['modify'.$row['BRDATA_NO']]) && $_SESSION['modify'.$row['BRDATA_NO']] != 1 ){
				if($brdata_wd != $row['BRDATA_PASS'] && $brdata_wd2 != $row['BRDATA_PASS']) {
					$coreClass -> msg_go("비밀번호가 틀렸습니다.", "sub.php?menukey=".$menukey."&amp;mod=passchk&amp;rtnmod=".$rtnmod."&amp;rtnact=".$rtnact."&amp;no=".$no.$listVar);
				}
			}
		} else if((S_mb_level < site_config_glevel && S_mb_id != $row['BRDATA_UID'])) {
			if($row['BRDATA_AUTHKEY'] != NULL && $row['BRDATA_AUTHKEY'] != "") {
				if(S_mb_authkey != $row['BRDATA_AUTHKEY']) {
					$coreClass -> msg_go("게시물에 대한 권한이 없습니다.", "sub.php?menukey=".$menukey."&mod=view&no=".$no.$listVar);
				}
			} else {
				$coreClass -> msg_go("게시물에 대한 권한이 없습니다.", "sub.php?menukey=".$menukey."&mod=view&no=".$no.$listVar);
			}
		}
	}
?>