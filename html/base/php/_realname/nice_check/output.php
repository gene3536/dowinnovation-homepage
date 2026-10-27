<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/_config/config.php";
	require_once( "./nice.nuguya.oivs.php" );
	
	include("gpin_func.php");

	//#######################################################################################
	//#####
	//#####	개인실명확인 서비스 소스 (실명확인요청)						한국신용정보(주)
	//#####	( PHPScript 처리 )
	//#####
	//#####	================================================================================
	//#####
	//#####	* 본 페이지는 귀사의 서버에 복사해서 관리하십시오.
	//#####	  페이지를 수정하거나 변경하지 마십시오. (서비스 장애의 원인이 됩니다)
	//#####
	//#######################################################################################
	
	//원래 입력한 이름으로 세션 저장처리
	$strNiceId = "Nartdj01";

	/****************************************************************************************
	 *****	▣  NiceCheck.htm 에서 넘겨 받은 SendInfo 값을 복호화 하여 
	 *****		주민번호,성명 등 각각의 값을 세팅한다 ▣
	 ****************************************************************************************/
	$oivsObject->clientData = $_POST['SendInfo'];
	$oivsObject->desClientData();
	
	// 복호화 된 값은 아래 주석을 풀어 확인 가능합니다. 
	// (기존 회원 체크는 이 부분에서 하시면 됩니다.)
/*
	echo "<BR>성명 : " . $oivsObject->userNm ;
	echo "<BR>주민번호/외국인번호 : " . $oivsObject->resIdNo ;
	echo "<BR>조회사유코드 : " . $oivsObject->inqRsn ;
	echo "<BR>내/외국인 구분코드 : " . $oivsObject->foreigner ;
*/

	/****************************************************************************************
	 *****	▣ 회원사 ID 설정 : 계약시에 발급된 회원사 ID를 설정하십시오. ▣
	 ****************************************************************************************/

	if($oivsObject->foreigner=='2')	$strNiceId =$strNiceId;
	else $strNiceId = $strNiceId;

	/****************************************************************************************
	 *****	▣ 실명확인 서비스를 호출한다. ▣
	 ****************************************************************************************/

	$oivsObject->niceId = $strNiceId;
	$oivsObject->callService();
	

	/****************************************************************************************
	 *****	▣ 실명확인 서비스를 응답값을 처리한다. ▣

	 *****	strRetCd 와 strRetDtlCd를 이용하여 작업 하시면 됩니다.
	 *****	단! strRetDtlCd 가 Y,C인 경우는 개인의 설정에 의해 실명확인을 막아놓은 상태이므로 
	 *****	관련스크립트는 수정하지 마시기 바랍니다.
	 ****************************************************************************************/
	 
	//==================================================================================================================
	//				응답에 대한 결과 및 변수들에 대한 설명
	//------------------------------------------------------------------------------------------------------------------
	//
	//	< 한국신용정보 온라인 식별 서비스에서 제공하는 정보 >
	//
	//	oivsObject->message			: 오류 또는 정보성 메시지
	//	oivsObject->retCd			: 결과 코드(메뉴얼 참고) // cf. 한국신용정보 성명 등록 및 정정 페이지 : https://www.nuguya.com
	//	oivsObject->retDtlCd			: 결과 상세 코드(메뉴얼 참고)
	//	oivsObject->minor 			: 성인인증 결과 코드
	//									"1"	: 성인
	//									"2"	: 미성년
	//									"9"	: 확인 불가
	//
	//=================================================================================================================
?>


<?
//echo "==>".$oivsObject->message;
//echo $oivsObject->retCd;
echo "<pre>";
print_r($oivsObject);
echo "</pre>";

exit;
if($oivsObject->retCd == "1") {
	
				$return_url = $_SESSION['sess_return_url'];
				
				session_unset();
				
				if(!$realName) $realName = iconv("UTF-8","euc-kr",$oivsObject->userNm);

				$_SESSION["sess_user"]["nm"] = $realName;
				$_SESSION["sess_user"]["prsn_cfm_cd"] = $oivsObject->resIdNo;
				$_SESSION["sess_user"]["dupe_mbsh_cfm_cd"] = getUserDupValue($oivsObject->resIdNo, "HBEFOR008061");
				$_SESSION["sess_user"]["group"] = 100; //실명인증 그룹셋팅
				$_SESSION["sess_user"]["foreigner"] = $oivsObject->foreigner - 1; //국적 G-PIN 은 0번이 내국인
				
				
				//주민등록번호로 성별 추출
				$gubun = substr($oivsObject->resIdNo,6,1);
				if($gubun=='1' || $gubun=='3' || $gubun=='5' || $gubun=='7') $_SESSION["sess_user"]["sex_dvs_cd"] = "1";
				else $_SESSION["sess_user"]["sex_dvs_cd"] = "2";
				
				//주민등록번호로 생년월일 추출 뒷자리의 첫번째 숫자가 1,2,5,6 : 1900년대, 3,4,7,8 : 2000년대
				if($gubun=='1' || $gubun=='2' || $gubun=='5' || $gubun=='6') $_SESSION["sess_user"]["birth_dt"] = "19".substr($oivsObject->resIdNo,0,2)."-".substr($oivsObject->resIdNo,2,2)."-".substr($oivsObject->resIdNo,4,2);
				else $_SESSION["sess_user"]["birth_dt"] = "20".substr($oivsObject->resIdNo,0,2)."-".substr($oivsObject->resIdNo,2,2)."-".substr($oivsObject->resIdNo,4,2);

				
				$return_url = base64_decode($return_url);
				
				if(!basename($return_url)) $return_url = "/";
				
				
				echo "<script type='text/javascript'>
					alert('실명인증이 정상적으로 처리 되었습니다.');
					opener.location.href='".$return_url."';
					window.close();
				</script>
					";
				exit;
}else{
	echo "<script type='text/javascript'>
			alert('본인이 아니거나 등록된 정보가 없습니다.');
			window.close();
		</script>
			";				
}
?>