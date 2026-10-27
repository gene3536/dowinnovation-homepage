<?php

	$tbl1				= tbl_board_skin;
	$dir1				= dir_module.'/board/m_board_skin/';
	$brdskin_id		= $coreClass -> dataModel(1, "brdskin_id", null);
	$brdskin_name	= $coreClass -> dataModel(1, "brdskin_name", "제목없음");

	switch ($mod) {
		case "list" :
			require_once $dir1.'list.php';
			break;
		case "insert" :
			require_once $dir1.'insert.php';
			break;
		case "modify" :
			require_once $dir1.'modify.php';
			break;
		case "process" :
			require_once $dir1.'process.php';
			break;
		default :
			require_once $dir1.'list.php';
			break;		
	}
?>