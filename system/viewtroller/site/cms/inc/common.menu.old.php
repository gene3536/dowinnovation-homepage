<?php	
	$where		= "WHERE menu_depth = 1 AND menu_visible = 'Y' AND menu_access = 'Y' AND menu_scode = '".site_config_code."'";
	$order		= "ORDER BY menu_root";
	$rs				= $coreClass -> selectQuery(tbl_menu, $where, $order, "", "");
	$menuData	= "";
	
	if(!empty($menukey)) {
		$where			= "WHERE menu_menukey = '".$menukey."'";
		$currentRow		= $coreClass -> selectQueryArray(tbl_menu, $where, "", "", "");
		$currentMenu	= $currentRow['MENU_REF'];
	}

	while($cMenu = $coreClass -> selectFetchArray($rs)) {
		$menuChk = false;

		// 관리자 여부 체크
		if($cMenu['MENU_LEVEL'] >= S_mb_level) {
			$menuChk = true;
		} else {
			$where = "LEFT JOIN ".tbl_menu_manage." ON menu_manage_menukey = menu_menukey WHERE menu_scode = '".site_config_code."' AND menu_root = '".$cMenu['MENU_ROOT']."' AND (menu_manage_uid = '".S_mb_id."' OR menu_level >= '".S_mb_level."')";
			$rsCnt = $coreClass -> selectQueryCount(tbl_menu, $where);
			if($rsCnt > 0) {
				$menuChk = true;
			}
		}
				
		// 관리자 여부 체크에 따른 메뉴값 추출
		if($menuChk == true) {					
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
			
			if(!empty($cMenuKey)) {
				$menuData .= "<li><a ";
				if((isset($cMenu['MENU_MENUKEY']) && $cMenu['MENU_MENUKEY'] == $menukey) || (isset($cMenu['MENU_MENUKEY']) && $cMenu['MENU_MENUKEY'] == $currentMenu)) {
					$menuData .= "class=\"on\" ";
				}
				$menuData .= "href=\"sub.php?menukey=".$cMenuKey."\"><span>".$cMenuTitle."</span></a></li>";
			} else {
				$menuData .= "<li><a href=\"#\"><span>".$cMenu['MENU_TITLE']."</span></a></li>";
			}
		}
	
	}
?>

<div id="lnb">
	<ul class="clearfix">
		<?php echo $menuData ?>
	</ul>
</div>
<div class="clrBoth"></div>