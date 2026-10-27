<?

header("Content-Type: text/html; charset=utf-8");
include_once("../../../../../system/config/config_lite.php"); 

?>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?

/************************************************************************************/

/*

-	sample 페이지에서 요청 시 쿠키에 저장한 Reqnum값을 가져와서 IV값에 셋팅
-	쿠키 만료시간 경과 후 결과처리 못함

*/

/************************************************************************************/

//	01. 쿠키값 확인

$iv	= "";

if($_SESSION["REQNUM"])	{
	
	$iv	= $_SESSION["REQNUM"];
	
	//	쿠키 삭제
	//$_SESSION["REQNUM"]	= "";
	
} else	{
	
?>

	<script language='javascript'>
	
		alert("세션이 만료되었습니다.!!");
		
	</script>
	
<?

	return;
	
}


//	파라메터로 받은 요청결과
$enc_retInfo	= $_REQUEST["retInfo"];

$enc_retInfo	= $enc_retInfo	= iconv("utf-8","euc-kr", $enc_retInfo);

//echo "enc_retInfo:".$enc_retInfo;
//echo "<BR><BR>";

//	02. 요청결과 복호화
//	2014.02.07 KISA 권고사항
//	위 변조 및, 불법 시도 차단을 위하여 아래 패턴에 해당하는 문자열만 허용
	
if(preg_match('~[^0-9a-zA-Z+/=^]~', $iv, $matches) || preg_match('~[^0-9a-zA-Z+/=^]~', $enc_retInfo, $matches))	{
	
	echo "입력 값 확인이 필요합니다.(res-1)";
	
	exit;
	
}

$dec_retInfo	= exec(dir_public."/base/php/_realname/seoul/SciSecuX SEED 2 0 $iv $enc_retInfo ");			//	암호화모듈 설치시 생성된 SciSecuX 파일이 있는 리눅스 경로를 설정해주세요.
//echo "iv : $iv <br> ";
//echo "enc_retInfo : $enc_retInfo <br>";
?>

<?

/*echo $dec_retInfo;
//echo "<BR><BR>";
echo "dec_retInfo:";
print_r($dec_retInfo);
echo "<BR><BR>";*/

//	데이터 조합 : "본인확인1차암호화값/위변조검증값/암복화확장변수"
$totInfo	= split("\\^", $dec_retInfo);

$encPara	= $totInfo[0];			//	본인확인1차암호화값
$encMsg	= $totInfo[1];			//	암호화된 통합 파라미터의 위변조검증값

//	03. 위변조검증값 생성
//	2014.02.07 KISA 권고사항
//	위 변조 및, 불법 시도 차단을 위하여 아래 패턴에 해당하는 문자열만 허용

if(preg_match('~[^0-9a-zA-Z+/=^]~', $encPara, $matches))	{
	
	$fp_arr	= fopen(dir_common."/data/ydgugak/tmp/logs/sci_errorlog.txt","a+");
	
	$_str		= "".$_SERVER['HTTP_USER_AGENT']."\n".$iv."-".$_SESSION["REQNUM"]."\nenc_retInfo=>".$enc_retInfo."\ndec_retInfo=>".$dec_retInfo."\nencPara=>".$encPara."\nmatches0=>".$matches[0]."\nmatches1=>".$matches[1]."\n\n";
		
	fwrite($fp_arr,$_str);
	fclose($fp_arr);

	echo "입력 값 확인이 필요합니다.(res-2)"; 
	exit;
	
}

$hmac_str	= exec(dir_public."/base/php/_realname/seoul/SciSecuX HMAC 1 0 $encPara ");

if($hmac_str != $encMsg)	{
	
?>

	<script language=javascript>

		alert("비정상적인 접근입니다.!!");

	</script>
		
<?

	exit;
	
}


//	04. 본인확인1차암호화값 복호화
//	2014.02.07 KISA 권고사항
//	위 변조 및, 불법 시도 차단을 위하여 아래 패턴에 해당하는 문자열만 허용
	
if(preg_match('~[^0-9a-zA-Z+/=^]~', $iv, $matches)||preg_match('~[^0-9a-zA-Z+/=^]~', $encPara, $matches))	{
	
	echo "입력 값 확인이 필요합니다.(res-3)";
	exit;
	
}

$decPara	= exec(dir_public."/base/php/_realname/seoul/SciSecuX SEED 2 0 $iv $encPara ");

	
//	05. 파라미터 분리
$split_dec_retInfo	= split("\\^", $decPara);	
	
//$name			= urldecode($split_dec_retInfo[0]);			//	성명
$name			= $split_dec_retInfo[0];							//	성명
$birYMD		= $split_dec_retInfo[1];							//	생년월일
$sex				= $split_dec_retInfo[2];							//	성별
$fgnGbn			= $split_dec_retInfo[3];							//	내외국인 구분값
$di				= $split_dec_retInfo[4];							//	DI
$ci1				= $split_dec_retInfo[5];							//	CI1
$ci2				= $split_dec_retInfo[6];							//	CI2	
$civersion		= $split_dec_retInfo[7];							//	CI Version
$reqNum		= $split_dec_retInfo[8];							//	요청번호
$result			= $split_dec_retInfo[9];							//	본인확인 결과 (Y/N)
$certGb			= $split_dec_retInfo[10];						//	인증수단
$cellNo			= $split_dec_retInfo[11];						//	핸드폰 번호
$cellCorp		= $split_dec_retInfo[12];						//	이동통신사
$certDate		= $split_dec_retInfo[13];						//	검증시간
$addVar			= $split_dec_retInfo[14];						//	추가 파라메터

/*
$ext1		= $split_dec_retInfo[15];
$ext2		= $split_dec_retInfo[16];
$ext3		= $split_dec_retInfo[17];
$ext4		= $split_dec_retInfo[18];
$ext5		= $split_dec_retInfo[19];
*/

	
if($result == 'Y')	{ 

	$_SESSION["memberLogin"]	    = true;
	$_SESSION["memberLevel"]	    = 9;
	$_SESSION["memberId"]			= $di;
	$_SESSION["memberName"]			= iconv("euc-kr","utf-8",$name);
	$_SESSION["memberAuthtype"]		= 1;	
	$_SESSION["memberScode"]		= "00000002";
				
	// 로그인정보 등록
	$item		= "mb_log_scode, mb_log_uid, mb_log_uname, mb_log_browser, mb_log_regip, mb_log_regdate";
	$value		= "'".site_config_code."', '".$_SESSION["memberId"]."', '".$_SESSION["memberName"]."', '".site_client_browser."', '".site_client_ip."', '".site_regdate."'";
	$coreClass -> insertQuery(tbl_member_login, $item, $value);	
	$coreClass -> commit();

	$return_url	= base64_decode($_GET["return_url"]);
	
	if(!$return_url)	$return_url	= $_SESSION['SESS_RETURN_URL'];
	if(!$return_url)	$return_url	= "/home/main.php";
		
	echo "<script type='text/javascript'>
	
		//alert('실명인증이 정상적으로 처리 되었습니다.');
		//opener.location.href='".$return_url."';
		//self.close();
				
		window.opener.location.href='".$return_url."';
		window.open('','_self').close();				
				
	</script>";


	exit;

} else	{
	
	echo "<script type='text/javascript'>
	
		alert('본인인증이 실패하였습니다.');
		window.open('','_self').close();	
		
	</script>";
	
	exit;
	
}

?>