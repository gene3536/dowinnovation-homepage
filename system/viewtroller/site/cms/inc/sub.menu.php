<?php
	
	// 메뉴 타이틀 추출
	$where			= "WHERE MENU_SCODE = '".site_config_code."' AND menu_root = '".site_config_rootkey."' AND menu_depth = '1'";
	$currentRow		= $coreClass -> selectQueryArray(tbl_menu, $where, "", "", "");
	$currentTitle		= $currentRow['MENU_TITLE'];
	
	// 1차 서브 메뉴 추출
	$query = "
		SELECT
			(SELECT COUNT(*) FROM m_menu_manage WHERE menu_manage_uid = '".S_mb_id."' AND menu_manage_menukey = menu_menukey) AS MNG_CNT
			,MENU_LEVEL ,MENU_LEVEL ,MENU_TITLE, MENU_TYPE, MENU_MENUKEY
		FROM m_menu
		WHERE menu_depth = '2' AND menu_root = '".site_config_rootkey."' AND menu_visible = 'Y' AND menu_access = 'Y' AND menu_scode = '".site_config_code."'
		ORDER BY menu_step ASC";
	$rs = $coreClass -> executeQuery($query);
			
	while($sub1Menu = $coreClass -> selectFetchArray($rs)) {
		// 관리자 여부 체크
		if(($sub1Menu['MNG_CNT'] > 0) || ($sub1Menu['MENU_LEVEL'] >= S_mb_level)) {
			$cls = "";				
			if((isset($sub1Menu['MENU_MENUKEY']) && $sub1Menu['MENU_MENUKEY'] == $menukey) || (isset($sub1Menu['MENU_MENUKEY']) && $sub1Menu['MENU_MENUKEY'] == $currentMenu)) {
				$cls = ' class="on"';
			}
			if($sub1Menu['MENU_TYPE'] == 1) {
				$smenu_data .= "<li".$cls."><a href=\"sub.php?menukey=".$sub1Menu['MENU_MENUKEY']."\">".$sub1Menu['MENU_TITLE']."</a></li>";
       		} else if(($sub1Menu['MENU_TYPE'] >= 2 && $sub1Menu['MENU_TYPE'] <= 4)) {
				$smenu_data .= "<li".$cls."><a href=\"sub.php?menukey=".$sub1Menu['MENU_MENUKEY']."\">".$sub1Menu['MENU_TITLE']."</a></li>";
			} else if($sub1Menu['MENU_TYPE'] == 5) {
				$smenu_data .= "<li><a href=\"".$sub1Menu['MENU_URL']."\" target=\"_blank\">".$sub1Menu['MENU_TITLE']." [새창]</a></li>";
			} else if($sub1Menu['MENU_TYPE'] == 6) {
				$smenu_data .= "<li><a href=\"#\" onclick=\"".$sub1Menu['MENU_URL']."\">".$sub1Menu['MENU_TITLE']." [새창]</a></li>";
			}
		}
	}
?>

<div id="subMenu">
	<h2 class="depth1"><span><?php echo $currentTitle?></span></h2>
	<ul><?php echo $smenu_data?></ul>
</div>