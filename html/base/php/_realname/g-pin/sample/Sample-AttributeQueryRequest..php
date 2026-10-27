<?php
header("Content-Type: text/html; charset=ks_c_5601-1987");
header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
header("Cache-Control:no-cache");
header("Pragma:no-cache");
session_start();

?>

<?

	include("gpin_func.php");


	$_SESSION["gpinAuthRetPage"]= "Sample-AttributeQueryResponse.php";

	$attributes = split(";", $_REQUEST["Attr"]);

	$ret = makeAttributeRequest($_REQUEST["vidn"], $attributes);

	// 에러인 경우 메세지표시 후 종료함.		
	GPIN_ERROR_CHECK(TRUE);


	echo $ret;

?>