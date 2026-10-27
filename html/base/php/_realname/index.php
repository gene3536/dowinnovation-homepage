<?php

if(!$_GET['site_dvs_cd'])	$site_dvs_cd	= "kr";
if(!$_GET['menu_dvs_cd'])	$menu_dvs_cd	= "0702";

include_once $_SERVER["DOCUMENT_ROOT"]."/_config/config.php";
include_once DOC_DIR."/tmpl/header.php";

//리턴URL 이 있을 경우 세션에 저장처리
$_SESSION['sess_return_url']	= $return_url;

if(!$return_url)	$return_url	= $SESS_RETURN_URL;

$form_mode	= $_GET["mode"];
$_tmpl_url		= "?tmpl=".$tmpl."&linkid=".$linkid;

#공공 I-PIN
include_once DOC_DIR."/_prog/_realname/g-pin/input.php";

#실명인증 모듈
include_once DOC_DIR."/_prog/_realname/".REALNAME."2/input.php";

if(REALNAME == "korea")	$real_call_url	= "https://cert.namecheck.co.kr/certnc_input.asp";
else if(REALNAME == "seoul")	$real_call_url	= "https://name.siren24.com/vname/jsp/vname_j10.jsp";
else if(REALNAME == "nice_check")	$real_call_url	= "";
else if(REALNAME == "nice")	$real_call_url	= "";

include_once "realname_form.php";

include_once DOC_DIR."/tmpl/footer.php";

?>