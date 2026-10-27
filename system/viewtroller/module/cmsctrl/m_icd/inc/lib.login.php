<?php 
	if(S_mb_level > 9) {
		if($mod == "insert" || $mod == "modify" || $mod == "view") {
			$coreClass -> msg_back("이용권한이 없습니다.");
		}
	} else if(S_mb_level > 2) {
		if($mod == "modify" || $mod == "view") {
			if($row['ICD_FLD1'] <> S_mb_id) {
				$coreClass -> msg_back("접근권한이 없습니다.");
			}
		}
	} else {
		if($mod == "modify") {
			if($row['ICD_FLD1'] <> S_mb_id) {
				$coreClass -> msg_back("수정권한이 없습니다.");
			}
		}		
	}
?>