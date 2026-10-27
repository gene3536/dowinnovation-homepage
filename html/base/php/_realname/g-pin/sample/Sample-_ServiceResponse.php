<?
header("Cache-Control:no-cache");
header("Pragma:no-cache");
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta content="text/html; charset=euc-kr" http-equiv="content-type" />
    <title>GPIN SP 정보 수신중</title>
</head>
<body>
    <p>

    <?
    	
    	//RecvResult.php
	//응답문 수신후 사용자 정보를 수신하여 세션에 담습니다.
  

	include("gpin_func.php");

	$samlResponse=$_POST['SAMLResponse'];


	//요청정보명을 배열에 담음
	$attrNames = array("dupInfo", "virtualNo", "realName", "sex", "age", "birthDate", "nationalInfo", "authInfo", "GPIN_AQ_SERVICE_SITE_USER_CONFIRM");

       
    //GPinProxy을 통해 사용자정보를 G-PIN센터(SPStub)로부터 가져옴.
	$rets = parseSAMLResponse($samlResponse, $attrNames);

	
	// 에러인 경우 메세지표시 후 종료함.	
	GPIN_ERROR_CHECK(TRUE);
		
	
echo	$_SESSION["dupInfo"]		= $rets[0];
echo	$_SESSION["virtualNo"]		= $rets[1];
echo	$_SESSION["realName"]		= $rets[2];
echo	$_SESSION["sex"]			= $rets[3];
echo	$_SESSION["age"]			= $rets[4];
echo	$_SESSION["birthDate"]		= $rets[5];
echo	$_SESSION["nationalInfo"]	= $rets[6];
echo	$_SESSION["authInfo"]		= $rets[7];
echo	$_SESSION["GPIN_AQ_SERVICE_SITE_USER_CONFIRM"]	= $rets[8];

	exit;
    ?>	
	
	<script language="javascript" type="text/javascript">

		window.opener.location.href = '<?=$_SESSION["gpinAuthRetPage"]?>';

		window.close();
	</script>
    <?   
	//세션 삭제(반드시 적용하십시오.)
	$_SESSION["gpinAuthRetPage"]=NULL;
       
    ?>
    </p>
	
</body>
</html>