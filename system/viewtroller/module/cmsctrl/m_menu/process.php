<?php
	$menu_width = !empty($_REQUEST['menu_width'])?$_REQUEST['menu_width'] : 0;
	
	switch ($act) {
		// 메뉴 업	
		case "up":
			$where	= "WHERE menu_menukey = '".$mkey."' AND menu_scode = '".$scode."'";
			$selm		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
	
			if($selm['MENU_DEPTH'] == 1) {
				if($selm['MENU_ROOT'] == 1) {
					$coreClass -> rollback();
					$coreClass -> msg_back("선택한 메뉴를 위로 올릴 수 없습니다.");
				} else {
					$set		= "SET MENU_ROOT = 0";
					$where	= "WHERE MENU_ROOT = '".$selm['MENU_ROOT']."' - 1 AND menu_scode = '".$scode."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$set		= "SET MENU_ROOT = MENU_ROOT - 1";
					$where	= "WHERE MENU_ROOT = '".$selm['MENU_ROOT']."' AND menu_scode = '".$scode."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
	
					$set		= "SET MENU_ROOT = '".$selm['MENU_ROOT']."', menu_scode = '".$scode."'";
					$where	= "WHERE MENU_ROOT = 0";
					$coreClass -> updateQuery($tbl1, $set, $where);

					$coreClass -> commit();
					$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
				}
			} else {
				if($selm['MENU_STEP'] == 1) {
					$coreClass -> rollback();
					$coreClass -> msg_back("선택한 메뉴를 위로 올릴 수 없습니다.");
				} else {
					$set		= "SET MENU_STEP = MENU_STEP + 1";
					$where	= "WHERE MENU_STEP = '".$selm['MENU_STEP']."' - 1 AND MENU_DEPTH = '".$selm['MENU_DEPTH']."' AND MENU_ROOT = '".$selm['MENU_ROOT']."' AND menu_scode = '".$scode."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$set		= "SET MENU_STEP = MENU_STEP - 1";
					$where	= "WHERE menu_menukey = '".$selm['MENU_MENUKEY']."' AND menu_scode = '".$scode."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$coreClass -> commit();
					$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
				}
			}
			break;	
		
		// 메뉴 다운
		case "down":
			$where	= "WHERE menu_menukey = '".$mkey."' AND menu_scode = '".$scode."'";
			$selm		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
	
			$where	= "WHERE MENU_ROOT = '".$selm['MENU_ROOT']."' AND MENU_DEPTH = '".$selm['MENU_DEPTH']."' AND menu_scode = '".$scode."'";
			$cntm		= $coreClass -> selectQueryCount($tbl1, $where);
			
			$value		= "MENU_ROOT";
			$cntr		= $coreClass -> selectQueryCountDistinct($tbl1, "", $value);
	
			if($selm['MENU_DEPTH'] == 1) {
				if($selm['MENU_ROOT'] >= $cntr) {
					$coreClass -> rollback();
					$coreClass -> msg_back("선택한 메뉴를 아래로 내릴 수 없습니다.");
				} else {
					$set		= "SET MENU_ROOT = 0";
					$where	= "WHERE MENU_ROOT = '".$selm['MENU_ROOT']."' + 1 AND menu_scode = '".$scode."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$set		= "SET MENU_ROOT = MENU_ROOT + 1";
					$where	= "WHERE MENU_ROOT = '".$selm['MENU_ROOT']."' AND menu_scode = '".$scode."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$set		= "SET MENU_ROOT = '".$selm['MENU_ROOT']."', menu_scode = '".$scode."'";
					$where	= "WHERE MENU_ROOT = 0";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$coreClass -> commit();
					$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
				}
			} else {
				if($selm['MENU_STEP'] >= $cntm) {
					$coreClass -> rollback();
					$coreClass -> msg_back("선택한 메뉴를 아래로 내릴 수 없습니다.");
				} else {
					$set		= "SET MENU_STEP = MENU_STEP - 1";
					$where	= "WHERE MENU_STEP = '".$selm['MENU_STEP']."' + 1 AND MENU_DEPTH = '".$selm['MENU_DEPTH']."' AND MENU_ROOT = '".$selm['MENU_ROOT']."' AND menu_scode = '".$scode."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$set		= "SET MENU_STEP = MENU_STEP + 1";
					$where	= "WHERE menu_menukey = '".$selm['MENU_MENUKEY']."' AND menu_scode = '".$scode."'";
					$coreClass -> updateQuery($tbl1, $set, $where);
					
					$coreClass -> commit();
					$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
				}
			}
			break;
	
		// 메뉴수정
		case "modify":
			$where	= "WHERE menu_menukey = '".$mkey."' AND menu_scode = '".$scode."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			
			$set	= "SET menu_title = '".$menu_title."'
						, menu_tbl='".$menu_tbl."'
						, menu_visible = '".$menu_visible."'
						, menu_access = '".$menu_access."'
						, menu_level = '".$menu_level."'
						, menu_type = '".$menu_type."'
						, menu_width = '".$menu_width."'
						, menu_url = '".$menu_url."'
						, menu_surl = '".$menu_surl."'
						, menu_urlmod = '".$menu_urlmod."'
						, menu_content = '".$menu_content."'
						, menu_dep = '".$menu_dep."'
						, menu_depsub = '".$menu_depsub."'
						, menu_depuser = '".$menu_depuser."'
						, menu_board = '".$menu_board."'
						, menu_skins = '".$menu_skins."'
						, menu_var1 = '".$menu_var1."'
						, menu_var2 = '".$menu_var2."'
						, menu_var3 = '".$menu_var3."'
						, menu_var4 = '".$menu_var4."'
						, menu_var5 = '".$menu_var5."'
						, menu_var6 = '".$menu_var6."'
						, menu_var7 = '".$menu_var7."'
						, menu_var8 = '".$menu_var8."'
						, menu_var9 = '".$menu_var9."'
						, menu_var10 = '".$menu_var10."'
						, menu_modip = '".site_client_ip."'
						, menu_moddate = '".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
			
		//  메뉴삭제
		case "delete" :
			$where	= "WHERE menu_menukey = '".$mkey."' AND menu_scode = '".$scode."'";
			$selm		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

			if($selm['MENU_DEPTH'] == 1) {
				$where	= "WHERE MENU_ROOT = '".$selm['MENU_ROOT']."' AND menu_scode = '".$scode."'";
				$coreClass -> deleteQuery($tbl1, $where);
		
				$set		= "SET MENU_ROOT = MENU_ROOT - 1";
				$where	= "WHERE MENU_ROOT > '".$selm['MENU_ROOT']."' AND menu_scode = '".$scode."'";
				$coreClass -> updateQuery($tbl1, $set, $where);
				
				$coreClass -> commit();
				
			} else if($selm['MENU_DEPTH'] == 2) {
				$where	= "WHERE menu_menukey = '".$mkey."' AND MENU_DEPTH = 2 AND menu_scode = '".$scode."'";
				$coreClass -> deleteQuery($tbl1, $where);
				
				$where	= "WHERE menu_ref = '".$mkey."' AND MENU_DEPTH = 3 AND menu_scode = '".$scode."'";
				$rs			= $coreClass -> selectQuery($tbl1, $where, "", "", "");
				$coreClass -> deleteQuery($tbl1, $where);
				
				while($row = $coreClass -> selectFetchArray($rs)) {
					$where	= "WHERE menu_ref = '".$row['MENU_MENUKEY']."' AND MENU_DEPTH = 4 AND menu_scode = '".$scode."'";
					$coreClass -> deleteQuery($tbl1, $where);
				}
					
				$set		= "SET MENU_STEP = MENU_STEP - 1";
				$where	= "WHERE MENU_STEP > '".$selm['MENU_STEP']."' AND MENU_ROOT = '".$selm['MENU_ROOT']."' AND MENU_DEPTH = 2 AND menu_scode = '".$scode."'";
				$coreClass -> updateQuery($tbl1, $set, $where);
					
				$coreClass -> commit();
				
			} else if($selm['MENU_DEPTH'] == 3) {
				$where	= "WHERE menu_menukey = '".$mkey."' AND MENU_DEPTH = 3 AND menu_scode = '".$scode."'";
				$coreClass -> deleteQuery($tbl1, $where);

				$where	= "WHERE menu_ref = '".$mkey."' AND MENU_DEPTH = 4 AND menu_scode = '".$scode."'";
				$coreClass -> deleteQuery($tbl1, $where);

				$set		= "SET MENU_STEP = MENU_STEP - 1";
				$where	= "WHERE MENU_STEP > '".$selm['MENU_STEP']."' AND MENU_ROOT = '".$selm['MENU_ROOT']."' AND MENU_DEPTH = 3 AND menu_scode = '".$scode."'";
				$coreClass -> updateQuery($tbl1, $set, $where);
					
				$coreClass -> commit();
				
			} else if($selm['MENU_DEPTH'] == 4) {
				$where	= "WHERE menu_menukey = '".$mkey."' AND MENU_DEPTH = 4 AND menu_scode = '".$scode."'";
				$coreClass -> deleteQuery($tbl1, $where);

				$set		= "SET MENU_STEP = MENU_STEP - 1";
				$where	= "WHERE MENU_STEP > '".$selm['MENU_STEP']."' AND MENU_ROOT = '".$selm['MENU_ROOT']."' AND MENU_DEPTH = 4 AND menu_scode = '".$scode."'";
				$coreClass -> updateQuery($tbl1, $set, $where);
					
				$coreClass -> commit();
			} else if($selm['MENU_DEPTH'] == 5) {
				$where	= "WHERE menu_menukey = '".$mkey."' AND MENU_DEPTH = 5 AND menu_scode = '".$scode."'";
				$coreClass -> deleteQuery($tbl1, $where);

				$set		= "SET MENU_STEP = MENU_STEP - 1";
				$where	= "WHERE MENU_STEP > '".$selm['MENU_STEP']."' AND MENU_ROOT = '".$selm['MENU_ROOT']."' AND MENU_DEPTH = 5 AND menu_scode = '".$scode."'";
				$coreClass -> updateQuery($tbl1, $set, $where);
					
				$coreClass -> commit();
			}
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 1차 메뉴 생성
		case "menu1ins" :
			echo $depth	= 1;
			$where	= "WHERE menu_scode = '".$scode."'";
			$cntr		= $coreClass -> selectQueryCountDistinct($tbl1, $where, "menu_root");			
			$mkey		= $coreClass -> selectQueryMax($tbl1, "menu_menukey");
			
			$cntr		= $cntr + 1;
			$mkey		= $mkey + 1;
			
			$item		= "menu_menukey, menu_scode, menu_title, menu_root, menu_depth, menu_ref, menu_step, menu_regip, menu_modip, menu_regdate, menu_moddate";
			$value		= "'".$mkey."', '".$scode."', '메뉴명이 없습니다.', '".$cntr."', '".$depth."', '".$mkey."', '".$cntr."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."','".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
	
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
			
		// 2차 메뉴 생성
		case "menu2ins" :
			$depth	= 2;
			$where	= "WHERE menu_menukey = '".$mkey."' AND menu_scode = '".$scode."'";
			$selm		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
	
			$where	= "WHERE MENU_DEPTH = '".$depth."' AND menu_ref = '".$selm['MENU_MENUKEY']."'";
			$value		= "menu_step";
			$stepm	= $coreClass -> selectQueryCountDistinct($tbl1, $where, $value);
			$mkey		= $coreClass -> selectQueryMax($tbl1, "menu_menukey");
			
			$rootm	= $selm['MENU_ROOT'];
			$refm		= $selm['MENU_MENUKEY'];
			$stepm	= $stepm + 1;
			$mkey		= $mkey + 1;

			$item	= "menu_menukey, menu_scode, menu_title, menu_root, menu_depth, menu_ref, menu_step, menu_regip, menu_modip, menu_regdate, menu_moddate";
			$value	= "'".$mkey."', '".$scode."', '메뉴명이 없습니다.', '".$rootm."', '".$depth."', '".$refm."', '".$stepm."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."','".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;
			
		// 3차 메뉴 생성
		case "menu3ins" :
			$depth	= 3;
			$where	= "WHERE menu_menukey = '".$mkey."' AND menu_scode = '".$scode."'";
			$selm		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
	
			$where	= "WHERE menu_depth = '".$depth."' AND menu_ref = '".$selm['MENU_MENUKEY']."'";
			$value		= "menu_step";
			$stepm	= $coreClass -> selectQueryCountDistinct($tbl1, $where, $value);
			$mkey		= $coreClass -> selectQueryMax($tbl1, "menu_menukey");
			
			$rootm	= $selm['MENU_ROOT'];
			$refm		= $selm['MENU_MENUKEY'];
			$stepm	= $stepm + 1;
			$mkey		= $mkey + 1;

			$item	= "menu_menukey, menu_scode, menu_title, menu_root, menu_depth, menu_ref, menu_step, menu_regip, menu_modip, menu_regdate, menu_moddate";
			$value	= "'".$mkey."', '".$scode."', '메뉴명이 없습니다.', '".$rootm."', '".$depth."', '".$refm."', '".$stepm."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."','".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 4차 메뉴 생성
		case "menu4ins" :
			$depth	= 4;
			$where	= "WHERE menu_menukey = '".$mkey."'";
			$selm		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
	
			$where	= "WHERE menu_depth = '".$depth."' AND menu_ref = '".$selm['MENU_MENUKEY']."'";
			$value		= "menu_step";
			$stepm	= $coreClass -> selectQueryCountDistinct($tbl1, $where, $value);
			$mkey		= $coreClass -> selectQueryMax($tbl1, "menu_menukey");
			
			$rootm	= $selm['MENU_ROOT'];
			$refm		= $selm['MENU_MENUKEY'];
			$stepm	= $stepm + 1;
			$mkey		= $mkey + 1;

			$item	= "menu_menukey, menu_scode, menu_title, menu_root, menu_depth, menu_ref, menu_step, menu_regip, menu_modip, menu_regdate, menu_moddate";
			$value	= "'".$mkey."', '".$scode."', '메뉴명이 없습니다.', '".$rootm."', '".$depth."', '".$refm."', '".$stepm."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."','".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;


		// 5차 메뉴 생성
		case "menu5ins" :
			$depth	= 5;
			$where	= "WHERE menu_menukey = '".$mkey."'";
			$selm		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
	
			$where	= "WHERE menu_depth = '".$depth."' AND menu_ref = '".$selm['MENU_MENUKEY']."'";
			$value		= "menu_step";
			$stepm	= $coreClass -> selectQueryCountDistinct($tbl1, $where, $value);
			$mkey		= $coreClass -> selectQueryMax($tbl1, "menu_menukey");
			
			$rootm	= $selm['MENU_ROOT'];
			$refm		= $selm['MENU_MENUKEY'];
			$stepm	= $stepm + 1;
			$mkey		= $mkey + 1;

			$item	= "menu_menukey, menu_scode, menu_title, menu_root, menu_depth, menu_ref, menu_step, menu_regip, menu_modip, menu_regdate, menu_moddate";
			$value	= "'".$mkey."', '".$scode."', '메뉴명이 없습니다.', '".$rootm."', '".$depth."', '".$refm."', '".$stepm."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."','".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);
			
			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;



		// 관리자 추가
		case "manageupdate" :
			$where	= "WHERE menu_menukey = '".$mkey."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);

			$maxNo	= $coreClass -> selectQueryMax(tbl_menu_manage, "menu_manage_no");
			$maxNo++;
						
			$item		= "menu_manage_no, menu_manage_uid, menu_manage_menukey, menu_manage_regip, menu_manage_regdate";
			$value		= "'".$maxNo."', '".$menu_manage_uid."', '".$mkey."', '".site_client_ip."', '".site_regdate."'";
			$coreClass -> insertQuery(tbl_menu_manage, $item, $value);
	
			$coreClass -> commit();
			$coreClass -> back();
			break;
			
		// 관리자 삭제
		case "managedelete" :
			$where	= "WHERE menu_menukey = '".$mkey."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			
			$where	= "WHERE menu_manage_no = '".$menu_manage_no."' AND menu_manage_menukey = '".$mkey."'";
			$coreClass -> selectQueryCountChk(tbl_menu_manage, $where);
			$coreClass -> deleteQuery(tbl_menu_manage, $where);
	
			$coreClass -> commit();
			$coreClass -> back();
			break;			
			
		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;	
			
	}
?>