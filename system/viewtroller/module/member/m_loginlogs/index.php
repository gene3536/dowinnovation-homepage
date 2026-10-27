<?php
	// 로그인 내역관리
	$tbl1			= tbl_member;
	$tbl2			= tbl_member_login;
	$tbl3			= tbl_member_loginx;
	$tbl4			= tbl_member_loginxcnt;
	$code1		= $code1 ? $code1 : 1;
	
	switch ($mod) {
		case "list"	:
			if($code1 == 1) {
			 	require_once 'list1.php';
			} else if($code1 == 2) {
				require_once 'list2.php';
			} else if($code1 == 3) {
				require_once 'list3.php';
			} 
		 	break;
		case "process" :
			require_once 'process.php';
			break;
		default :
			require_once 'list1.php';
			break;		
	}
?>