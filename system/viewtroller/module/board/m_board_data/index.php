
<script type="text/javascript">
	function listDelCheck(form)
	{
		var length = 0;
		$("input.delNo").each(function(){
			if($(this).is(":checked") == true) length++;
		});
		if(length == 0){
			alert("삭제할 게시물을 선택하세요");
			return false;
		}
		if(confirm('선택한 내역을 완전 삭제 하시겠습니까?삭제한 내용은 복구 할 수 없습니다.')){
			return true;
		}else{
			return false;
		}
	}

	$(document).ready(function(){
		$(".checkAll").click(function(){
			if($(this).is(":checked") == true) $("input.delNo").prop("checked",true);
			else  $("input.delNo").prop("checked",false);
		});
	});
</script>

<?php
	$tbl1 = tbl_board;
	$tbl2 = tbl_board_data;
	$tbl3 = tbl_board_file;
	$tbl4 = tbl_board_log;
	$tbl5 = tbl_board_skin;
	
	$code1; // 게시글 유형
	$code2; // 게시판 아이디
	
	// 게시판정보
	$bid = $pageInfo['MENU_BOARD'];
	if(empty($bid)) {
		if(site_language == "eng"){
			$coreClass -> msg_back("No table ID.");
		}else{
			$coreClass -> msg_back("테이블ID가 없습니다.");
		}
	} else {
		$where = "WHERE board_id = '".$bid."'"; 
		$board_data = $coreClass -> selectQueryArray(tbl_board, $where, "", "", ""); 
		$brdcms = $board_data['BOARD_CMS'];

		if($brdcms == "Y") {
			if(empty($code2)) {
				if(!empty($no) && ($mod == "process" || $mod == "view")) {
					$where	= "WHERE brdata_no='".$no."'";
					$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
					$bid = $row['BRDATA_BID'];
				}
			} else {
				$bid = $code2;
			}
			$where = "WHERE board_id = '".$bid."'";
			$board_data = $coreClass -> selectQueryArray(tbl_board, $where, "", "", "");
		} else {
			// 관리자유형이 아닐 경우 게시판정보 SCODE 지정
			$scode = $board_data['BOARD_SCODE'];				
		}		
		$brdtype = $board_data['BOARD_TYPE'];
	}

	// 경로설정
	$dir1	= dir_module."/board/m_board_data/skins/".$brdtype."/";
	$dir2	= dir_module."/board/m_board_data/include/";
	$dir3	= dir_module."/board/m_board_data/";
	
	//$bid = !empty($pageInfo['MENU_BOARD']) ? trim($pageInfo['MENU_BOARD']) : $code1;
	$imgPath = "/upload/bbs/".$bid."/";
	$savePath = dir_public.$imgPath;

	$pageC				= $coreClass -> dataModel(2, "pageC", null);
	$fno					= $coreClass -> dataModel(2, "fno", null);
	$cno					= $coreClass -> dataModel(2, "cno", null);
	$rtnmod				= $coreClass -> dataModel(2, "rtnmod", null);
	$rtnact				= $coreClass -> dataModel(2, "rtnact", null);
	$bdid					= $coreClass -> dataModel(2, "bdid", null); //게시글 id
	
	$brdata_category	= $coreClass -> dataModel(1, "brdata_category", null);
	$brdata_subject		= $coreClass -> dataModel(1, "brdata_subject", "제목없음");
	$brdata_name		= $coreClass -> dataModel(1, "brdata_name", S_mb_name);
	
	$brdata_wd			= $coreClass -> dataModel(1, "brdata_wd", null);
	$brdata_wd			= $coreClass -> crypt_sha256($brdata_wd);	
	$brdata_wd2			= $coreClass -> dataModel(1, "brdata_wd2", null);	
	// 게시글 수정 시 비밀번호 변경
	$brdata_wdchg		= $coreClass -> dataModel(1, "brdata_wdchg", null);
	if(!empty($brdata_wdchg)) {
		$brdata_wdchg		= $coreClass -> crypt_sha256($brdata_wdchg);
	}
	
	$brdata_content		= $coreClass -> dataModelNoXss(1, 'brdata_content', null);
	$brdata_email		= $coreClass -> dataModel(1, "brdata_email", null);
	$brdata_hp			= $coreClass -> dataModel(1, "brdata_hp", null);
	$brdata_smsis		= $coreClass -> dataModel(1, "brdata_smsis", null);
	
	if(!empty($_REQUEST['brdata_email1']) || !empty($_REQUEST['brdata_email2'])){
		$brdata_email		= $coreClass -> dataModel(1, "brdata_email1", null) ."@".$coreClass -> dataModel(1, "brdata_email2", null);
	}
	if(!empty($_REQUEST['brdata_hp1']) || !empty($_REQUEST['brdata_hp2']) || !empty($_REQUEST['brdata_hp3'])){
		$brdata_hp			= $coreClass -> dataModel(1, "brdata_hp1", null)."-".$coreClass -> dataModel(1, "brdata_hp2", null)."-".$coreClass -> dataModel(1, "brdata_hp3", null);
	}
		
	$brdata_notice		= $coreClass -> dataModel(1, "brdata_notice", null);
	$brdata_privacy		= $coreClass -> dataModel(1, "brdata_privacy", null);
	$brdata_deleted		= $coreClass -> dataModel(1, "brdata_deleted", null);
	
	$brdata_dep			= $coreClass -> dataModel(1, "brdata_dep", null);
	$brdata_depsub		= $coreClass -> dataModel(1, "brdata_depsub", null);
	$brdata_depuser	= $coreClass -> dataModel(1, "brdata_depuser", null);
	
	$brdata_hit			= $coreClass -> dataModel(1, "brdata_hit", null);
	$brdata_sdate		= $coreClass -> dataModel(1, "brdata_sdate", null);
	$brdata_edate		= $coreClass -> dataModel(1, "brdata_edate", null);
	
	// board_minwon
	$brdrep_dep			= $coreClass -> dataModel(1, "brdrep_dep", null);
	$brdrep_depsub		= $coreClass -> dataModel(1, "brdrep_depsub", null);
	$brdrep_depuser	= $coreClass -> dataModel(1, "brdrep_depuser", null);
	$brdrep_content		= $coreClass -> dataModel(1, "brdrep_content", null);

	$chk					= $coreClass -> dataModel(1, "chk", null);
	$chkKey				= $coreClass -> dataModel(1, "chkKey", null);
	$spamKey			= $coreClass -> dataModel(1, "spamKey", null);	

	$mod2				= $coreClass -> dataModel(2, "mod2", null);	
	$cno				= $coreClass -> dataModel(2, "cno", null);	

	$brdata_sexposure		= $coreClass -> dataModel(1, "brdata_sexposure", null);
	$brdata_eexposure		= $coreClass -> dataModel(1, "brdata_eexposure", null);
	
	for($i=1;$i<=3;$i++){
		${"brdata_fld".$i}		= $coreClass -> dataModelNoXss(1, "brdata_fld".$i, null);	
	}
	
	for($i=4;$i<=6;$i++){
		${"brdata_fld".$i}		= $coreClass -> dataModel(1, "brdata_fld".$i, null);	
	}

	for($i=1;$i<=5;$i++){
		${"brdata_etc".$i}		= $coreClass -> dataModel(1, "brdata_etc".$i, null);	
	}
	
	if(count($_POST['seq'])>0){
		for($i=0; $i<count($_POST['seq']); $i++){
			$Nseq[] = $_POST['seq'][$i];	
		}
	} 



	$board_authtype	= S_mb_authtype;
	$board_authkey	= S_mb_authkey;


	$bno				= $coreClass -> dataModel(2, "bno", "");
	$commentusr			= isset($_POST['commentusr']) ? trim($_POST['commentusr']) : NULL;
	$commentpass		= isset($_POST['commentusrwd']) ? trim($_POST['commentusrwd']) : NULL;
	$commentpass		= $coreClass -> crypt_sha256($commentpass);	
	//$commentpass		= $coreClass -> crypt_md5($commentpass, site_config_cryptkey);
	//$contents			=  $coreClass -> dataModel(1, "contents", null);
	$contents			= $coreClass -> dataModelNoXss(1, 'contents', null);
	$commhp				= isset($_POST['commhp']) ? trim($_POST['commhp']) : NULL;
	
	
	$fld		= $coreClass -> dataModel(1, "fld", null);
	$copyReply		= $coreClass -> dataModel(1, "copyReply", null);



	/// 관리 레벨 체크 
	if(S_mb_login == true) {
		$wherem = "WHERE brdmng_bid = '".$board_data['BOARD_ID']."' and brdmng_uid = '".S_mb_id."'";		
		$rsCnt		= $coreClass -> selectQueryCount(tbl_board_manage, $wherem);
		if(site_config_auth == true){//사이트 관리자일경우 게시판 관리할수 있도록 처리
			define("bbs_config_level", S_mb_level);
		} else if($rsCnt > 0) {
			define("bbs_config_level", S_mb_level);
		} else {
			define("bbs_config_level", $board_data['BOARD_LV_MANAGE']);
		}
	}else{
		define("bbs_config_level", $board_data['BOARD_LV_MANAGE']);
	}

	// 첨부파일 체크
	for($i = 1; $i <= $board_data['BOARD_UPLOADCOUNT']; $i++) {
		if(isset($_FILES["uploadFile".$i])) {
			${"uploadFile".$i}			= $_FILES["uploadFile".$i]['tmp_name'];
			${"uploadFile".$i."_name"}	= $_FILES["uploadFile".$i]['name'];
			${"uploadFile".$i."_size"}	= $_FILES["uploadFile".$i]['size'];
		}
	}
	
	// 썸네일 체크
	if(!empty($_FILES['thumbFile'])) {	
		$thumbFile			= $_FILES['thumbFile']['tmp_name'];
		$thumbFile_name	= $_FILES['thumbFile']['name'];
		$thumbFile_size	= $_FILES['thumbFile']['size'];
	}
	
	// 접근권한 체크
	if(S_mb_level > $board_data['BOARD_LV_ACCESS']) {
		if(site_language == "eng"){
			$coreClass -> msg_go("No access permission.","sub.php?menukey={$menukey}&amp;mod=list{$listVar}");
		}else{
			$coreClass -> msg_go("접근 권한이 없습니다1.","sub.php?menukey={$menukey}&amp;mod=list{$listVar}");
		}
	}
	
	// 게시판 관리자 체크	
	if(site_config_auth == true) { //사이트 관리자일경우 게시판 관리할수 있도록 처리
		$brdmngCnt = 1;
	} else {
		$where				= "WHERE brdmng_bid = '".$board_data['BOARD_ID']."' AND brdmng_uid = '".S_mb_id."'";
		$brdmngCnt			= $coreClass -> selectQueryCount(tbl_board_manage, $where);		
	}


	
	if($brdcms == "Y") {
		require_once $dir2.'header.php';
	}

	$prfx = (site_config_code == "00000001")? "adm." : ""; 
	//if($bid == "00000017" && empty($mod)) $mod = "insert";

	switch ($mod) {
		case "list"			: 
			if(is_file($dir1.$prfx.'list.php')) require_once $dir1.$prfx.'list.php';
			else require_once $dir1.'list.php';
			break;
		case "view"			:
			if(S_mb_level > $board_data['BOARD_LV_VIEW'] && $brdmngCnt < 1){
				$coreClass -> msg_go("보기 권한이 없습니다.","sub.php?menukey={$menukey}&amp;mod=list{$listVar}");
			}
			//본인글은 볼수있도록 처리하기 위해서 bbs.view.header.php로 이동
			if(is_file($dir1.$prfx.'view.php')) require_once $dir1.$prfx.'view.php';
			else require_once $dir1.'view.php';
			break;
		case "insert"		:
			if(S_mb_level > $board_data['BOARD_LV_INSERT'] && $brdmngCnt < 1){	
				$coreClass -> msg_go("쓰기 권한이 없습니다.","sub.php?menukey={$menukey}&amp;mod=list{$listVar}");
			}
			if(is_file($dir1.$prfx.'insert.php')) require_once $dir1.$prfx.'insert.php';
			else require_once $dir1.'insert.php';
			break;
		case "modify"		:
			if(S_mb_level > $board_data['BOARD_LV_INSERT'] && $brdmngCnt < 1){	
				$coreClass -> msg_go("수정 권한이 없습니다.","sub.php?menukey={$menukey}&amp;mod=list{$listVar}");
			}
			if(is_file($dir1.$prfx.'modify.php')) require_once $dir1.$prfx.'modify.php';
			else require_once $dir1.'modify.php';
			break;
		case "reply"		:
			if(S_mb_level > $board_data['BOARD_LV_REPLY'] && $brdmngCnt < 1){
				$coreClass -> msg_go("답변 권한이 없습니다.","sub.php?menukey={$menukey}&amp;mod=list{$listVar}");
			}
			if(is_file($dir1.$prfx.'reply.php')) require_once $dir1.$prfx.'reply.php';
			else require_once $dir1.'reply.php';
			break;
		case "status1"		:

			if(S_mb_level > 8) $coreClass -> msg_go("부서지정 권한이 없습니다.","sub.php?menukey={$menukey}&amp;mod=list{$listVar}");
			require_once $dir1.'status1.php';
			break;
		case "status2"		:
			if(S_mb_level > 8){		
				$coreClass -> msg_go("답변 권한이 없습니다.","sub.php?menukey={$menukey}&amp;mod=list{$listVar}");
			}
			require_once $dir1.'status2.php';
			break;
		case "passchk":
			require_once $dir2.'mod.password.form.php';
			break;
		case "process"		: 
			require_once $dir3.'process.php';
			break;
		case "movecopy"		: 
			require_once $dir2.'mod.movecopy.form.php';
			break;
		default				: 
			if(is_file($dir1.$prfx.'list.php')) require_once $dir1.$prfx.'list.php';
			else require_once $dir1.'list.php';
			break;		
	}	
?>


