<?php
	require_once("../../system/config/config.php");
	
	// 관리자여부 체크
	$coreClass -> LoaderClass("member");
	$memberClass = new memberClass();

	$uid			= $coreClass -> dataModel(2, "uid", "");

	$menuId	= $coreClass -> dataModel(2, "menuId", null);
	switch ($menuId) {
		case "login":
			$memberClass -> Login();
			break;
		case "logout":
			$memberClass -> Logout();
			break;
        case "memberIdChk":
            $memberClass -> memberIdChk($uid);
            break;

        case "memberPwChk":
            $memberClass -> memberPwChk($uid);
            break;
			

		default :
			$msgClass -> msg_back("접근경로가 올바르지 않습니다.");
			break;
	}
?>