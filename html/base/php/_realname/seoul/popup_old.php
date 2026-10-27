<?
	header ("Cache-Control : no-cache");
	header ("Cache-Control : post-check=0 pre-check=0");
	header ("Pragma:no-cache");

	$enc_retInfo =  $_REQUEST["retInfo"];

	$enc_retInfo = iconv("euckr", "utf-8", $enc_retInfo);

	$param = "?retInfo=$enc_retInfo";

	//session_start();
	/*
	echo "enc_retInfo : ".$enc_retInfo;
	exit;
	*/

	
?>

<html>
<head>
<script language="JavaScript">
function end()
{
	//window.opener.location.href = 'http://www.jp.go.kr/_prog/realname/seoul2/result.php' + '<?=$param?>';
	self.location.href = 'http://bi.hanbat.ac.kr/_prog/_realname/seoul2/result.php' + '<?=$param?>';
	//self.close();
}
</script>

</head>
<body onload="javascript:end()">
</body>
</html>