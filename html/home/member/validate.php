<?php 
	require_once("../../../system/config/config_lite.php");

	// 보안서버 체크
	if($info['CMS_INFO_SSL'] == "Y") {
		if(site_client_port <> 443) $coreClass -> go(site_ssl_https."/mgcms/index.php");				
	}

	// IP접근제어 체크
	if($info['CMS_INFO_ACCESS'] == "Y") {
		$cmsClass -> getAccessCheck(site_client_ip);
	}

	$mb_uid = $coreClass->dataModel(1, "mb_uid", null);
	$mb_uid = trim($mb_uid);
	$mb_scode  = $coreClass->dataModel(1, "mb_scode", null);

	$mb_name1	= $coreClass -> dataModel(1, "mb_name1", null);
	$mb_email1	= $coreClass -> dataModel(1, "mb_email1", null);
	$mb_email1	= $coreClass -> crypt_md5($mb_email1, site_config_mbkey);

	$res['res'] = '';
	$res['msg'] = "";

	switch ($mod) {

		case "idchk" : 
			if($mb_uid != null){

				$where = "WHERE mb_uid='".$mb_uid."'";
				$CNT = $coreClass->selectQueryCount(tbl_member, $where);
				
				if($CNT >0 || $memberClass->isDelID($mb_uid) > 0){	
					$res['res'] = 'N';
					$res['msg'] = "사용중인 아이디입니다.";
				}
				else{
					$res['res'] = 'Y';
					$res['msg'] = "사용 가능한 아이디입니다.";
				}
			}else{
				$res['res'] = false;
			}
			
			echo json_encode($res) ;

			break;

		case "findID" :
			if($mb_name1 != null && $mb_email1 != null && $mb_scode != null){

				$where = "WHERE mb_name='".$mb_name1."' AND mb_email='".$mb_email1."'";
				$CNT = $coreClass->selectQueryCount(tbl_member, $where);
				$row = $coreClass->selectQueryArray(tbl_member, $where, "", "", "");
				
				if($CNT >0){	
					$res['msg'] = "";
					$res['res'] = $row['MB_UID'];
				}else{
					$res['msg'] = $where;
					$res['res'] = '';
				}
			}
			
			echo json_encode($res) ;
			break;
		
		default :
			break;

	}

?>

