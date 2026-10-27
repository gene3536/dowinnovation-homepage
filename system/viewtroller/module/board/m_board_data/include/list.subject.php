<?php
	if(isset($row['BRDATA_DELETED']) && $row['BRDATA_DELETED'] == "Y") {
		$title1 = $coreClass -> getSub2Str($board_data['BOARD_SUBJECT_LEN'], "해당게시글이 삭제 되었습니다.");
		$title2 = $coreClass -> getSub2Str($board_data['BOARD_SUBJECT_LEN'], "관리자에 의해 삭제 되었습니다.");
		$title3 = $coreClass -> getSub2Str($board_data['BOARD_SUBJECT_LEN'], "작성자에 의해 삭제 되었습니다.");

		if(S_mb_level <= bbs_config_level) {
			if($row['BRDATA_DELTYPE'] == 2) {
				$listData .= "<a href=\"sub.php?menukey=".$menukey."&amp;mod=view&amp;no=".$row['BRDATA_NO'].$listVar."\">".$title2."</a>";
			} else if($row['BRDATA_DELTYPE'] == 3) {
				$listData .= "<a href=\"sub.php?menukey=".$menukey."&amp;mod=view&amp;no=".$row['BRDATA_NO'].$listVar."\">".$title3."</a>";
			} else {
				$listData .= "<a href=\"sub.php?menukey=".$menukey."&amp;mod=view&amp;no=".$row['BRDATA_NO'].$listVar."\">".$title1."</a>";
			}
		} else {
			if($row['BRDATA_DELTYPE'] == 2) {
				$listData .= "".$title1."";
			} else if($row['BRDATA_DELTYPE'] == 3) {
				$listData .= "".$title2."";
			} else {
				$listData .= "".$title3."";
			}						
		}
	} else { 
		$answer = "";
		if($board_data['BOARD_OTO'] == 'Y') {
			$asWhere = "WHERE brdata_grp_no = '".$row['BRDATA_NO']."' AND brdata_level_no = '1'";  
			$asCount = $coreClass->selectQueryCount(tbl_board_data,$asWhere);
			$answer = ($asCount > 0)? " <strong>[답변완료]</strong>" : ""; 
		}

		if(isset($row['BRDATA_PRIVACY']) && $row['BRDATA_PRIVACY'] == "N") {
			$listData .= $re.'<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].$listVar.'">'.$answer.' '.$subject.'</a>'.$cmntValue.' '.$new.' '.$privacy;
			$goLink = 'sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].$listVar;

		} else if($row['BRDATA_PRIVACY'] == "Y" && S_mb_level <= bbs_config_level) {
			$listData .= $re.'<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].$listVar.'">'.$answer.' '.$subject.'</a>'.$cmntValue.' '.$new.' '.$privacy;
			$goLink = 'sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].$listVar;
		} else if($row['BRDATA_PRIVACY'] =="Y" && (S_mb_id == $row['BRDATA_UID'] && S_mb_level <= site_config_alevel)) {
			$listData .= $re.'<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].$listVar.'">'.$answer.' '.$subject.'</a>'.$cmntValue.' '.$new.' '.$privacy;
			$goLink = 'sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].$listVar;
		} else if($row['BRDATA_PRIVACY'] =="Y" && strtolower($row['BRDATA_UID']) == "guest" && ($_SESSION['view'.$row['BRDATA_GRP_NO']] != 1 )) {
			$listData .= $re.'<a href="sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=view&amp;no='.$row['BRDATA_NO'].$listVar.'">비밀글 입니다.</a>'.$cmntValue.' '.$new.' '.$privacy;
			$goLink = 'sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=view&amp;no='.$row['BRDATA_NO'].$listVar;
		} else {
			if($row['BRDATA_SEQ_NO'] > 0 && $row['BRDATA_PRIVACY'] == "Y"){
				$where2	= "WHERE brdata_bid = '".$bid."' AND brdata_grp_no = '".$row['BRDATA_GRP_NO']."' and brdata_level_no = '0'";
				$row2		= $coreClass -> selectQueryArray(tbl_board_data, $where2, "", "","");
				if((S_mb_id == $row['BRDATA_UID'] || S_mb_id == $row2['BRDATA_UID'])) {
					if($_SESSION['view'.$row['BRDATA_GRP_NO']] == 1){
						$listData .= $re.'<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].$listVar.'">'.$answer.' '.$subject.'</a>'.$cmntValue.' '.$new.' '.$privacy;
						$goLink = 'sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].$listVar;
					}else{
						$listData .= $re.'<a href="sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=view&amp;no='.$row['BRDATA_NO'].$listVar.'">비밀글 입니다.</a>'.$cmntValue.' '.$new.' '.$privacy;
						$goLink = 'sub.php?menukey='.$menukey.'&amp;mod=passchk&amp;rtnmod=view&amp;no='.$row['BRDATA_NO'].$listVar;
					}
				} else if(S_mb_login == true){
					$listData .= $re."<a href=\"#\" onclick=\"alert('비밀글 입니다.1')\";>".$answer.' '.$subject."</a>".$cmntValue." ".$new." ".$privacy;
					$goLink = "#";
				}else{
					$listData .= $re."<a href=\"#\" onclick=\"alert('비밀글 입니다.2')\";>비밀글 입니다.".$answer.' '.$subject.'</a>'.$cmntValue.' '.$new.' '.$privacy;
					$goLink = "#";
				}
			} else {
				if(S_mb_login == true){
					$listData .= $re."<a href=\"#\" onclick=\"alert('비밀글 입니다.3')\";>".$answer.' '.$subject."</a>".$cmntValue." ".$new." ".$privacy;
					$goLink = "#";
				}else{
					if($_SESSION['view'.$row['BRDATA_GRP_NO']] == 1 ){
						$listData .= $re.'<a href="sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].$listVar.'">'.$answer.' '.$subject.'</a>'.$cmntValue.' '.$new.' '.$privacy;
						$goLink = 'sub.php?menukey='.$menukey.'&amp;mod=view&amp;no='.$row['BRDATA_NO'].$listVar;
					}else{
						$listData .= $re."<a href=\"#\" onclick=\"alert('비밀글 입니다.4')\";>비밀글 입니다.</a>".$cmntValue.' '.$new.' '.$privacy;
						$goLink = "#";
					}
				}
			}
		}
	}
?>