<?php
	// 회원사 엑셀출력 - 140613
	require_once("../../../system/config/config_lite.php");	

	if(!isset($_GET['type'])) $coreClass->msg_close("문서 정보가 정확하지 않습니다.");
	
	$type  = $coreClass->dataModel(2, "type", null);	
	foreach($_GET as $k => $v)	{
		if(isset($$k)) continue;
		//$$k = $v;
		$$k = $coreClass->dataModel(2, $v, null);		
	}

	switch($type)
	{
		case "msg" :
			require_once("inc/excel_msg.php");
			break; 
		case "app" :
			require_once("inc/excel_edu_app.php");
			break;
		case "appData" :
			require_once("inc/excel_edu_appData.php");
			break;
		case "completion" :
			require_once("inc/excel_edu_completion.php");
		case "teacher" :
			require_once("inc/excel_edu_teacher.php");
			break;
		default :
			$coreClass->msg("타입을 선택하세요.");
			break;

	} 

?>
