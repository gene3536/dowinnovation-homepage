<?php	
	$tbl1					= tbl_board_data;
    $tbl2					= tbl_board_file;
	$tbl3					= tbl_board;
	$tbl4					= tbl_board_skin;

	$btype					= ($code1) ? "individual" : "default";
	$bid					= ($code2) ? $code2 : "";
	$dir1					= dir_system."/viewtroller/module/board/m_board_manage";
	$dir2					= $dir1."/skins/".$btype."/";
	$dir3					= $dir1."/include/";
	$fno					= $coreClass -> dataModel(2, "fno", "");

	$brdata_bid			= $coreClass -> dataModel(1, "brdata_bid", null);
	$brdata_category	= $coreClass -> dataModel(1, "brdata_category", null);
	$brdata_subject		= $coreClass -> dataModel(1, "brdata_subject", null);
	
	$brdata_name		= $coreClass -> dataModel(1, "brdata_info1", null);
	$brdata_pass			= $coreClass -> dataModel(1, "brdata_info2", null);
	$brdata_pass			= $coreClass -> crypt_md5($brdata_pass, site_config_cryptkey);
	$brdata_passwd		= $coreClass -> dataModel(1, "brdata_info3", null);
	$brdata_passwd		= $coreClass -> crypt_md5($brdata_passwd, site_config_cryptkey);
	$brdata_passchg	= $coreClass -> dataModel(1, "brdata_info4", null);
	$brdata_passchg	= $coreClass -> crypt_md5($brdata_passchg, site_config_cryptkey);
	
	$brdata_dep			= $coreClass -> dataModel(1, "brdata_dep", null);
	$brdata_depsub		= $coreClass -> dataModel(1, "brdata_depsub", null);
	$brdata_depuser	= $coreClass -> dataModel(1, "brdata_depuser", null);

	$brdata_content		= $coreClass -> dataModelNoXss(1, "brdata_content", null);
	$brdata_email		= $coreClass -> dataModel(1, "brdata_email", null);
	$brdata_hp			= $coreClass -> dataModel(1, "brdata_hp", null);
		
	$brdata_notice		= $coreClass -> dataModel(1, "brdata_notice", null);
	$brdata_privacy		= $coreClass -> dataModel(1, "brdata_privacy", null);
	$brdata_deleted		= $coreClass -> dataModel(1, "brdata_deleted", null);
	
	$brdata_hit			= $coreClass -> dataModel(1, "brdata_hit", null);
	$brdata_sdate		= $coreClass -> dataModel(1, "brdata_sdate", null);
	$brdata_edate		= $coreClass -> dataModel(1, "brdata_edate", null);
	$brdata_thumbnail	= $coreClass -> dataModel(1, "brdata_thumbnail", null);

	if($btype == "board_minwon") {
		$brdrep_dep			= $coreClass -> dataModel(1, "brdrep_dep", null);
		$brdrep_depsub		= $coreClass -> dataModel(1, "brdrep_depsub", null);
		$brdrep_depuser		= $coreClass -> dataModel(1, "brdrep_depuser", null);
		$brdrep_content		= $coreClass -> dataModel(1, "brdrep_content", null);
	}

	$chk					= isset($_POST['chk']) ? $_POST['chk'] : null;
	$chkKey				= $coreClass -> dataModel(1, "chkKey", null);
	
	$brdata_sexposure		= $coreClass -> dataModel(1, "brdata_sexposure", null);
	$brdata_eexposure		= $coreClass -> dataModel(1, "brdata_eexposure", null);

	$fld		= $coreClass -> dataModel(1, "fld", null);
	$copyReply		= $coreClass -> dataModel(1, "copyReply", null);



	// 썸네일 이미지
	if(isset($_FILES["thumbFile"])) {
		$thumbFile			= $_FILES["thumbFile"]['tmp_name'];
		$thumbFile_name	= $_FILES["thumbFile"]['name'];
		$thumbFile_size		= $_FILES["thumbFile"]['size'];
	}
	
	for($i = 1; $i <= 10; $i++) {
		if(isset($_FILES["uploadFile".$i])) {
			${"uploadFile".$i}			= $_FILES["uploadFile".$i]['tmp_name'];
			${"uploadFile".$i."_name"}	= $_FILES["uploadFile".$i]['name'];
			${"uploadFile".$i."_size"}	= $_FILES["uploadFile".$i]['size'];
		}
	}

	//확장필드
	for($i=1;$i<=20;$i++){
		${"brdata_ext".$i}			= $coreClass -> dataModel(1, "brdata_ext".$i, null);	
	}

	// 테이블 ID 유무 체크 및 게시판 정보
	if(!empty($no)) {
		$where2 = "LEFT JOIN ".$tbl3." ON brdata_bid = board_id WHERE 1=1";
		$where2 .= " AND brdata_no = '".$no."'";
		$order			= "ORDER BY brdata_regdate DESC";
		$board_data					= $coreClass -> selectQueryArray($tbl1, $where2, $order, "", "");	

		$bid   = $board_data['BOARD_ID'];
	}
	
	// 게시판 목록
	if(S_mb_level <= site_config_level) {
		$bwhere	= "WHERE 1=1";
		if(!empty($scode)) {
			$bwhere .= " AND (board_scode = '00000000' OR board_scode = '".$scode."')";
		}	
	} else {
		$bwhere	= "LEFT JOIN ".tbl_board_manage." ON brdmng_bid = board_id and brdmng_uid='".S_mb_id."'";
		$bwhere .= " WHERE 1=1";
		$bwhere .= " AND ((brdmng_uid = '".S_mb_id."' AND board_lv_manage < '".S_mb_level."')";
		$bwhere .= " OR (board_lv_manage >= '".S_mb_level."'))";
		$bwhere .= " AND (board_scode = '00000000' OR board_scode = '".S_mb_scode."')";  
	}
	$border		= "ORDER BY board_name ASC"; //echo $bwhere;
	$brs			= $coreClass -> selectQuery($tbl3, $bwhere, $border, "", "");
	
	// 유형 목록
	$torder		= "ORDER BY brdskin_no ASC";
	$trs			= $coreClass -> selectQuery($tbl4, "", $torder, "", "");
	
	switch ($mod) {
		case "list"		: require_once $dir2.'/list.php';break;
		case "view"	: 
			//$dir2= $dir1."/skins/".$board_data['BOARD_TYPE']; 
			//$dir2= $dir1."/skins/default"; echo $dir2.'/view.php';
			require_once $dir2.'/view.php';break;
		case "reply":
			if($btype == "board") {	
				require_once $dir2.'/reply.php';
				//include $_SERVER["DOCUMENT_ROOT"]."/webfilter/inc/initCheckWebfilter.php";				
			} else {
				require_once $dir2.'/list.php';
			}
			break;
		case "status1":
			if($btype == "board_minwon") {	
				require_once $dir2.'/status1.php';
			} else {
				require_once $dir2.'/list.php';
			}
			break;
		case "status2":
			if($btype == "board_minwon") {	
				require_once $dir2.'/status2.php';
			} else {
				require_once $dir2.'/list.php';
			}
			break;
		case "insert"		: 
			require_once $dir2.'/insert.php';
			//include $_SERVER["DOCUMENT_ROOT"]."/webfilter/inc/initCheckWebfilter.php";			
			break;
		case "modify"	: 
			//$dir2					= $dir1."/skins/".$board_data['BOARD_TYPE'];
			require_once $dir2.'/modify.php';
			//include $_SERVER["DOCUMENT_ROOT"]."/webfilter/inc/initCheckWebfilter.php";			
			break;
		case "process"	: require_once $dir1.'/process.php';break;
		case "movecopy"		: require_once $dir3.'/board_movecopy.php';break;

		default			: require_once $dir2.'/list.php';break;		
	}
?>