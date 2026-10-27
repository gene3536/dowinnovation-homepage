<?
	include_once("../../../../../system/config/config_lite.php"); 
	
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
	
	$return_url = $_SESSION['sess_return_url'];
	
	//기존세션 초기화 후 생성
	session_unset();

/*	
	$_SESSION["dupInfo"]		= $rets[0];
	$_SESSION["virtualNo"]		 v
	$_SESSION["realName"]		= $rets[2];
	$_SESSION["sex"]			= $rets[3];
	$_SESSION["age"]			= $rets[4];
	$_SESSION["birthDate"]		= $rets[5];
	$_SESSION["nationalInfo"]	= $rets[6];
	$_SESSION["authInfo"]		= $rets[7];
	$_SESSION["GPIN_AQ_SERVICE_SITE_USER_CONFIRM"]	= $rets[8];
*/	
	
	$_SESSION["sess_user"]["nm"] = iconv("euckr","UTF-8",$rets[2]);
	$_SESSION["sess_user"]["rrno"] 				= "";																				//주민등록번호
	$_SESSION["sess_user"]["dupe_mbsh_cfm_cd"] 	= $rets[0];																			//중복가입확인 코드
	$_SESSION["sess_user"]["group"] 			= 100; 																				//실명인증 그룹셋팅
	$_SESSION["sess_user"]["foreigner"] 		= "";																				//내국인.외국인 구분코드
	$_SESSION["sess_user"]["sex_dvs_cd"] 		= $rets[3];																			//주민등록번호로 성별 추출
	$_SESSION["sess_user"]["birth_dt"] 			= substr($rets[5],0,4)."-".substr($rets[5],4,2)."-".substr($rets[5],6,2);			//생년월일
	$_SESSION["sess_user"]["prsn_cfm_cd"] 		= $rets[0];			//개인확인코드
	

	$return_url = base64_decode($return_url);
	if(!basename($return_url)) $return_url = "/";


	
	//개인식별코드 및 중복확인코드 UPDATE
	if($SESS_USER_LOGIN_ID) {

		//비밀번호 5회 오류 체크 후 아이디/비번찾기 페이지로 이동처리
			$dupcode = $_SESSION["sess_user"]["dupe_mbsh_cfm_cd"];

			$sql = "select login_failure_cnt from MEMM01 where dupe_mbsh_cfm_cd='".$dupcode."'";
			$failure_row = $db->select($sql);
			$login_failure_cnt = trim($failure_row[0][0]);

			if($login_failure_cnt == "5") {
				$return_url = base64_encode("/_prog/_member/index.php?mode=P&site_dvs_cd=kr&menu_dvs_cd=070104");
			}


			$sql = "update MEMM01 set login_failure_cnt='0' where dupe_mbsh_cfm_cd='".$dupcode."'";
			$db->update($sql);
	}
	

?>	

<?	if($return_url) { ?>

	<script language="javascript" type="text/javascript">
		window.opener.location.href = '<?=$return_url?>';
		window.close();
	</script>

<? } else { ?>

	<script language="javascript" type="text/javascript">
		window.opener.location.reload();
		window.close();
	</script>			

<? } ?>


<?
	//세션 삭제(반드시 적용하십시오.)
	$_SESSION["gpinAuthRetPage"]=NULL;

?>
