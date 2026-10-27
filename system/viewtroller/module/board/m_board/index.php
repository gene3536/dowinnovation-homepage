<?php

	$tbl1						= tbl_board;
	$tbl2						= tbl_board_data;
	$tbl3						= tbl_member_level;
	$dir1				= dir_module."/board/m_board/";

	$arr_bbs_order[0][1] = "brdata_subject";
	$arr_bbs_order[1][1] = "b.brdata_subject";
	$arr_bbs_order[2][1] = "e.BRDATA_EXT_01";
	$arr_bbs_order[3][1] = "e.BRDATA_EXT_02";

	$arr_bbs_order[0][2] = "제목필드";
	$arr_bbs_order[1][2] = "제목필드(확장필드사용시)";
	$arr_bbs_order[2][2] = "확장필드1";
	$arr_bbs_order[3][2] = "확장필드2";


	$scodevar				= $coreClass -> dataModel(1, "scodevar", null);
	$board_id				= $coreClass -> dataModel(2, "board_id", null);
	$board_name			= $coreClass -> dataModel(1, "board_name", "게시판명없음");
	
	$board_type				= $coreClass -> dataModel(1, "board_type", null);
	$board_category		= $coreClass -> dataModel(1, "board_category", null);
	$board_privacy			= $coreClass -> dataModel(1, "board_privacy", null);
	$board_comment		= $coreClass -> dataModel(1, "board_comment", null);
	$board_editor			= $coreClass -> dataModel(1, "board_editor", null);
	$board_oto				= $coreClass -> dataModel(1, "board_oto", null);
	
	$board_lv_notice		= $coreClass -> dataModel(1, "board_lv_notice", null);
	$board_lv_access		= $coreClass -> dataModel(1, "board_lv_access", null);
	$board_lv_manage		= $coreClass -> dataModel(1, "board_lv_manage", null);
	$board_lv_view			= $coreClass -> dataModel(1, "board_lv_view", null);
	$board_lv_insert			= $coreClass -> dataModel(1, "board_lv_insert", null);
	$board_lv_reply			= $coreClass -> dataModel(1, "board_lv_reply", null);
	$board_lv_comment		= $coreClass -> dataModel(1, "board_lv_comment", null);
	$board_lv_download	= $coreClass -> dataModel(1, "board_lv_download", null);
	$board_lv_exposure	= $coreClass -> dataModel(1, "board_lv_exposure", 0);
	$board_sms	= $coreClass -> dataModel(1, "board_sms", null);
	
	$board_header			= $coreClass -> dataModelNoXss(1, "board_header", null);
	$board_footer			= $coreClass -> dataModelNoXss(1, "board_footer", null);
	$board_record			= $coreClass -> dataModel(1, "board_record", null);
	$board_new				= $coreClass -> dataModel(1, "board_new", null);
	$board_hot				= $coreClass -> dataModel(1, "board_hot", null);
	$board_uploadcount	= $coreClass -> dataModel(1, "board_uploadcount", null);
	$board_uploadsize		= $coreClass -> dataModel(1, "board_uploadsize", null);

	$board_order1			= $coreClass -> dataModelNoXss(1, "board_order1", null);
	$board_order2			= $coreClass -> dataModelNoXss(1, "board_order2", null);


	$board_extend		= $coreClass -> dataModel(1, "board_extend", null);
	$board_thumnail		= $coreClass -> dataModel(1, "board_thumnail", null);
	$board_thumwid		= $coreClass -> dataModel(1, "board_thumwid", 0);
	$board_thumhei		= $coreClass -> dataModel(1, "board_thumhei", 0);
	$board_subject_len		= $coreClass -> dataModel(1, "board_subject_len", 0);


	$brdcat_no				= $coreClass -> dataModel(2, "brdcat_no", null);
	$brdcat_bid				= $coreClass -> dataModel(2, "brdcat_bid", null);
	$brdcat_name			= $coreClass -> dataModel(2, "brdcat_name", null);
	$brdcat_seq			= $coreClass -> dataModel(2, "brdcat_seq", null);

	$brdmng_no				= $coreClass -> dataModel(2, "brdmng_no", null);
	$brdmng_bid			= $coreClass -> dataModel(2, "brdmng_bid", null);
	
	$brdmng_uid			= $coreClass -> dataModel(2, "brdmng_uid", null);



	$brdmngs_no				= $coreClass -> dataModel(2, "brdmngs_no", null);
	$brdmngs_bid			= $coreClass -> dataModel(2, "brdmngs_bid", null);
	$brdmngs_uid			= $coreClass -> dataModel(2, "brdmngs_uid", null);
	$brdmngs_name			= $coreClass -> dataModel(2, "brdmngs_name", null);
	$brdmngs_hp			= $coreClass -> dataModel(2, "brdmngs_hp", null);

	switch ($mod) {
		case "list"					: require_once $dir1.'list.php';break;
		case "view"				: require_once $dir1.'view.php';break;
		case "insert"				: require_once $dir1.'insert.php';break;
		case "modify"			: require_once $dir1.'modify.php';break;
		case "category_list"		: require_once $dir1.'category_list.php';break;
		case "category_insert"	: require_once $dir1.'category_insert.php';break;
		case "category_modify"	: require_once $dir1.'category_modify.php';break;
		case "process"			: require_once $dir1.'process.php';break;
		default					: require_once $dir1.'list.php';break;		
	}
?>