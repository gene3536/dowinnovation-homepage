<?php
	$mquery = "
		SELECT * FROM (
			SELECT
				(SELECT menu_ref FROM m_menu b WHERE menu_menukey = ".$menukey.") AS MENU_CURRENT,
				(SELECT COUNT(*) FROM m_menu c LEFT JOIN m_menu_manage ON menu_manage_menukey = menu_menukey 
						WHERE menu_scode = '".site_config_code."' AND c.menu_root = a.menu_root AND (menu_manage_uid = '".S_mb_id."' OR menu_level >= ".S_mb_level.")) AS MENU_CNT,
				a.MENU_MENUKEY, a.MENU_TITLE, a.MENU_LEVEL, a.MENU_TYPE
			FROM m_menu a
			WHERE menu_depth = 1 AND menu_visible = 'Y' AND menu_access = 'Y' AND menu_scode = '".site_config_code."' ORDER BY menu_root
		) AS d WHERE d.menu_cnt > 0";

	$mrs = $coreClass -> executeQuery($mquery);
	$mdata	= "";

	while($cMenu = $coreClass -> selectFetchArray($mrs)) {
		// 관리자권한 체크
		if($cMenu['MENU_LEVEL'] >= S_mb_level || $cMenu['MENU_CNT'] > 0) {
			// 관리자권한에 따른 메뉴값 추출
			if(isset($cMenu['MENU_TYPE']) && $cMenu['MENU_TYPE'] == 1) {
				$commonWhere	= "LEFT JOIN ".tbl_menu_manage." ON menu_manage_menukey = menu_menukey WHERE menu_scode = '".site_config_code."' AND menu_ref = '".$cMenu['MENU_MENUKEY']."' AND menu_depth = '2' AND (menu_manage_uid = '".S_mb_id."' OR menu_level >= '".S_mb_level."')";
				$commonOrder	= "ORDER BY menu_step";
				$cMenuChk		= $coreClass -> selectQueryArray(tbl_menu, $commonWhere, $commonOrder, "", "");
				$cMenuKey		= $cMenuChk['MENU_MENUKEY'];
				$cMenuTitle		= $cMenu['MENU_TITLE'];
			} else {
				$cMenuKey		= $cMenu['MENU_MENUKEY'];
				$cMenuTitle		= $cMenu['MENU_TITLE'];
			}

			// 하위메뉴 체크
			if(!empty($cMenuKey)) {
				// 롤오버 체크
				if((isset($cMenu['MENU_MENUKEY']) && $cMenu['MENU_MENUKEY'] == $menukey) || (isset($cMenu['MENU_MENUKEY']) && $cMenu['MENU_MENUKEY'] == $cMenu['MENU_CURRENT'])) {
					$cls = ' class="on"';
				} else {
					$cls = '';
				}
				$mdata .= '<li '.$cls.'><a href="sub.php?menukey='.$cMenuKey.'"><span>'.$cMenuTitle.'</span></a></li>';
			}
		}
	}
?>

<div id="lnb"><ul class="clearfix"><?php echo $mdata ?></ul></div>
<div class="clrBoth"></div>