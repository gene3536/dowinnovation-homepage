<?php

    if(site_menu_access == 'Y' && (site_menu_level >= S_mb_level || site_menu_manage == 1)) { 
        switch (site_menu_type) {
            case 2 : 
            	require_once(dir_module.$pageInfo['MENU_URL']);
                break;
            case 3 :
            	require_once(dir_module."/html/m_content/index.php");
            	break;
            case 4 :
            	require_once(dir_module."/board/m_board_data/index.php");
                break;
            default :
                require_once(dir_site."/_common/cmn.error.php");
                break;
        }
    } else {
        require_once(dir_site."/_common/cmn.error.php");
    }
?>