<?php	

	$tbl1 = tbl_board_log;
	$tbl2 = tbl_board;
	$tbl3 = tbl_board_data;
	$tbl4 = tbl_menu;
	
	switch ($mod) {
		case "list" : require_once 'list.php';break;
		case "liststat" : require_once 'liststat.php';break;
		default : require_once 'list.php';break;		
	}
?>