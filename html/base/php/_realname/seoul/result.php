<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
	//session_start();
	//header('content-type: text/html; charset: utf-8');
	include_once $_SERVER["DOCUMENT_ROOT"]."/_config/config.php";

?>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<html>
<head>

<?
	/************************************************************************************/
	/* - sample 페이지에서 요청 시 쿠키에 저장한 Reqnum값을 가져와서 IV값에 셋팅   	    */
	/* - 쿠키 만료시간 경과 후 결과처리 못함										    */
 	/************************************************************************************/
	//01. 쿠키값 확인

	$iv = "";
	if($_SESSION["REQNUM"]){
		$iv = $_SESSION["REQNUM"];
		//$_SESSION["REQNUM"]="";
	}else{
		
		echo "
		<script language=javascript>
			alert('세션이 만료되었습니다!!');
		</script>";
		return;
		
	}

	// 파라메터로 받은 요청결과
	$enc_retInfo = $_REQUEST["retInfo"];

	//위 변조 및, 불법 시도 차단을 위하여 아래 패턴에 해당하는 문자열만 허용
	if(preg_match('~[^0-9a-zA-Z+/=^]~', $iv, $matches)||preg_match('~[^0-9a-zA-Z+/=^]~', $enc_retInfo, $matches)){
		echo "입력 값 확인이 필요합니다.(res-1)"; exit;
	}

	//02. 요청결과 복호화

	$module	= "SciSecuX_PCC";
	$function	= "SciSecuX_PCC";

	if (extension_loaded($module)) {
		$dec_retInfo = $function("SEED", 2, 0, $iv, $enc_retInfo);
	} else {
		$dec_retInfo = "Module SciSecuX_PCC is not compiled into PHP";
	}
	
	/*
	echo $iv;
	echo "<BR><BR>";
	echo $enc_retInfo;
	echo "<BR><BR>";
	echo $dec_retInfo;
	exit;
	*/

	/*
	[복호화 하기전 수신값] <br><br>
	retInfo : echo $enc_retInfo
	*/
	
	//print_r($dec_retInfo);
	//echo "<BR><BR>";

	//데이터 조합 : "본인확인1차암호화값/위변조검증값/암복화확장변수"
	$totInfo = split("\\^", $dec_retInfo);
	

	$encPara	= $totInfo[0];		//	본인확인1차암호화값
	$encMsg	= $totInfo[1];		//	암호화된 통합 파라미터의 위변조검증값
	
	//echo "<BR><BR>";

	//위 변조 및, 불법 시도 차단을 위하여 아래 패턴에 해당하는 문자열만 허용
	if(preg_match('~[^0-9a-zA-Z+/=^]~', $encPara, $matches))	{

		//print_r($matches);

		
		$fp_arr	= fopen("/home/htdocs/public_hanbat_bi/LOG/SCI/sci_errorlog.txt","a+");
		
		$_str		= "[".$func->GetUserIP()."]".$_SERVER['HTTP_USER_AGENT']."\n".$iv."-".$_SESSION["REQNUM"]."\nenc_retInfo=>".$enc_retInfo."\ndec_retInfo=>".$dec_retInfo."\nencPara=>".$encPara."\nmatches0=>".$matches[0]."\nmatches1=>".$matches[1]."\n\n";
		
		fwrite($fp_arr,$_str);
		fclose($fp_arr);

		echo "입력 값 확인이 필요합니다.(res-2)"; exit;

	}

	//03. 위변조검증값 생성

	if (extension_loaded($module))	{
		
		$hmac_str	= $function("HMAC", 1, 0, "", $encPara);
		
	} else	{
		
		$hmac_str	= "Module SciSecuX_PCC is not compiled into PHP";
		
	}

	if($hmac_str != $encMsg){
	?>
		<script language=javascript>
			alert("비정상적인 접근입니다.!!");
		</script>
	<?
		exit;
	}

	//위 변조 및, 불법 시도 차단을 위하여 아래 패턴에 해당하는 문자열만 허용
	if(preg_match('~[^0-9a-zA-Z+/=^]~', $iv, $matches)||preg_match('~[^0-9a-zA-Z+/=^]~', $encPara, $matches)){
		echo "입력 값 확인이 필요합니다.(res-3)"; exit;
	}

	//04. 본인확인1차암호화값 복호화
	if (extension_loaded($module)) {
		$decPara = $function("SEED", 2, 0, $iv, $encPara);
	} else {
		$decPara = "Module SciSecuX_PCC is not compiled into PHP";
	}

	//05. 파라미터 분리
	$split_dec_retInfo = split("\\^", $decPara);
/*
	echo "<pre>";
	print_r($split_dec_retInfo);
	echo "</pre>";
*/

	$name		= $split_dec_retInfo[0];			//	성명
	$birYMD	= $split_dec_retInfo[1];			//	성별
	$sex			= $split_dec_retInfo[2];			//	생년월일
	$fgnGbn		= $split_dec_retInfo[3];			//	내외국인 구분값
	$di			= $split_dec_retInfo[4];			//	DI
	$ci1			= $split_dec_retInfo[5];			//	CI1
	$ci2			= $split_dec_retInfo[6];			//	CI2
	$civersion	= $split_dec_retInfo[7];			//	CI Version
	$reqNum	= $split_dec_retInfo[8];			//	요청번호
	$result		= $split_dec_retInfo[9];			//	본인확인 결과 (Y/N)
	$certGb		= $split_dec_retInfo[10];		//	인증수단
	$cellNo		= $split_dec_retInfo[11];		//	핸드폰 번호
	$cellCorp	= $split_dec_retInfo[12];		//	이동통신사
	$certDate	= $split_dec_retInfo[13];		//	검증시간
	$addVar		= $split_dec_retInfo[14];		//	추가 파라메터

	/*
	//예약 필드
	$ext1		= $split_dec_retInfo[15];
	$ext2		= $split_dec_retInfo[16];
	$ext3		= $split_dec_retInfo[17];
	$ext4		= $split_dec_retInfo[18];
	$ext5		= $split_dec_retInfo[19];
	*/


//복호화된 결과
if($result != "Y")	{
	echo "<script>
		alert('실명인증 후에 이용해 주세요');
		location.href='/_prog/_realname/';
		//window.opener.location='/_prog/realname/realname_form.php';
		//window.opener.location ='".$return_url."';
		window.close();
		</script>
		";
	exit;

}
/*
echo "\$name : ".$name;
echo "<br/>";
echo "\$di : ".$di;
echo "<br/>";
echo "\$result : ".$result;
echo "<br/>";
exit;
*/

if($name && $di && $result == 'Y')
{

	////////////////////////////////////////////////////////////
	$_SESSION["sess_user"]["nm"] 						= iconv("euc-kr","UTF-8",$name);															//	이름
	$_SESSION["sess_user"]["rrno"] 						= "";																									//	주민번호
	$_SESSION["sess_user"]["dupe_mbsh_cfm_cd"]	= $di;																								//	중복가입확인코드
	$_SESSION["sess_user"]["group"] 					= 100; 																								//	그룹코드
	$_SESSION["sess_user"]["foreigner"] 				= "";																									//	외국인여부
	$_SESSION["sess_user"]["sex_dvs_cd"] 				= $sex;																								//	성별구분
	$_SESSION["sess_user"]["birth_dt"] 					= substr($birYMD,0,4)."-".substr($birYMD,4,2)."-".substr($birYMD,6,2);			//	생년월일
	$_SESSION["sess_user"]["prsn_cfm_cd"] 			= $di;																								//	개인확인코드(없음)


	//개인식별코드 및 중복확인코드 UPDATE
	//$return_url = base64_decode($_GET["return_url"]);

	$return_url	= base64_decode($addVar);
	
	if(!$return_url)	$return_url	= base64_decode($_SESSION['sess_return_url']);
	if(!$return_url)	$return_url	= "/";

	echo "<script>
			//alert('실명인증이 정상적으로 처리 되었습니다1.');
			//location.href='".$return_url."';
			opener.location.href='".$return_url."';
			window.close();
		</script>
			";
	exit;

}else{

	echo "<script>
			alert('본인확인에 실패했습니다2.');
			//location.href='".$return_url."';
			//opener.location.href='".$return_url."';
			window.close();
		</script>
			";
	exit;
}
?>
</head>
<body>
</body>
</html>