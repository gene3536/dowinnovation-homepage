<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/_config/config.php";

	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".CHARSET."\" />";
	
	//**********************************************************************************************
	//한국신용평가정보 공공기관용 안심실명확인 서비스
	//작성일 : 2006.12.14
    //**********************************************************************************************

	$enc_data = $_POST[enc_data];

	$cb_decode_path = DOC_DIR."/_prog/_realname/".REALNAME."/SafeNC";	// SafeNC.exe 모듈이 설치된 위치 (사용하기 편하신 곳에 올려주시면 됩니다.)
													// 데이타를 암호화,복호화 하는 모듈입니다.	
	$enc_data 		= $enc_data;					// 암호화한 데이타
	$pRes			= "res";						// 값을 변경하시면 안됩니다.
	
	if ($enc_data != "") {
	
		//**********************************************************************************************
		// ReturnURL로부터 수신된 암호화 데이터(AES_CBC_PAD, SHA256, BASE64 Encoded Data)	
		// SafeNC 파일을 실행하여 복호화된 값을 가져옵니다.
		//**********************************************************************************************
		$dec_data = shell_exec("$cb_decode_path $pRes $enc_data");	 

		
		if ($dec_data == -1){
			$returnMsg  = "암/복호화 시스템 오류";
		}else if ($dec_data == -4){
			$returnMsg  = "복호화 처리 오류";
		}else if ($dec_data == -5){
			$returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
		}else if ($dec_data == -6){
			$returnMsg  = "복호화 데이터 오류";
		}else if ($dec_data == -9){
			$returnMsg  = "입력값 오류";
		}else{ 
			
			// 복호화가 정상적으로 이루어졌을경우 데이타를 파싱합니다.(구분자는 ^ 입니다.)
			$arrData = split("\^",$dec_data);
			$iCount = count($arrData); 
			$returnMsg = "";
				
			if ($iCount >= 5){
			
				// 실명확인처리결과코드^SafeID^이름^생년월일(YYYYMMDD)^성별구분(남:M 여:F 외국인남:A 외국인여:B)^고객사 요청 Sequence^Reserved1^Reserved2^Reserved3
				if ($arrData[0] == "1") {
					$sMsg = "본인맞음";
				}else if ($arrData[0] == "2") {
				   	$sMsg = "본인아님";      
				}else if ($arrData[0] == "3") {		
				   	$sMsg = "자료없음";      
				}else if ($arrData[0] == "4") {	
				   	$sMsg = "시스템오류";      
				}else if ($arrData[0] == "5") {
				   	$sMsg = "체크섬오류";      
				}else if ($arrData[0] == "10") {
				   	$sMsg = "사이트코드오류";      
				}else if ($arrData[0] == "11") {
				   	$sMsg = "중단된사이트";      
				}else if ($arrData[0] == "12") {
				   	$sMsg = "비밀번호오류";      
				}else{
					$sMsg = "리턴코드 : [$arrData[0]] 기타오류입니다.";      
				}

				//복호화된 결과
				if($arrData[0]!=1)
				{
				echo "
				   <SCRIPT LANGUAGE=\"JavaScript\">
				   <!--
					   alert (\"다음[".$sMsg."]과 같은 오류입니다 다시한번 확인해주십시요\");
					   self.close();
				   //-->
				   </SCRIPT>";				   
				   exit;

				}
/*				
			     // 실명확인 처리결과가 1(본인맞음)인 경우는 회원테이블에 데이타를 저장하시면 됩니다.
			     // echo "실명확인 처리결과 = [$arrData[0]] : $sMsg <BR>";   //실명확인 처리결과코드 혹은 오류코드(음수)

			     echo "인증코드 = [$arrData[1]]<BR>";
			     echo "성명 = [$arrData[2]]<BR>";
			     echo "생년월일 = [$arrData[3]]<BR>";
			     echo "성별 = [$arrData[4]]<BR>";
			     echo "REQUEST_SEQ = [$arrData[5]]<BR>";
			     echo "RESERVED1 = [$arrData[6]]<BR>";
			     echo "RESERVED2 = [$arrData[7]]<BR>";
			     echo "RESERVED3 = [$arrData[8]]<BR>";
*/				 


				if($SESS_USERID && !$SESS_REALCODE) {
					include $_SERVER["DOCUMENT_ROOT"]."/conf/lib/db_conn.php"; 
			
					$sql = "update member set realcode='".$arrData[1]."' where userid='".$SESS_USERID."'";
					$db->update($sql);
				}
				
				if(CHARSET == "utf-8") {
					$_SESSION["sess_user"]["nm"] 				= iconv("euc-kr","UTF-8",$arrData[2]);												//이름
				}else{
					$_SESSION["sess_user"]["nm"] 				= $arrData[2];	
				}
				$_SESSION["sess_user"]["rrno"] 				= $arrData[1];																				//주민번호
				$_SESSION["sess_user"]["dupe_mbsh_cfm_cd"] 	= $arrData[1];																		//중복가입확인코드
				$_SESSION["sess_user"]["group"] 			= 100; 																				//그룹코드
				$_SESSION["sess_user"]["foreigner"] 		= "";																				//외국인여부
				$_SESSION["sess_user"]["sex_dvs_cd"] 		= $arrData[4];																			//성별구분
				$_SESSION["sess_user"]["birth_dt"] 			= substr($arrData[3],0,4)."-".substr($arrData[3],4,2)."-".substr($arrData[3],6,2);			//생년월일
				$_SESSION["sess_user"]["prsn_cfm_cd"] 		= $arrData[1];	//개인확인코드
							
							
				$return_url = base64_decode($arrData[6]);

			
				echo "<script>
						alert('실명인증이 정상적으로 처리 되었습니다.');
						opener.location.href='".$return_url."';
						window.close();
					</script>
						";
				exit;
			}else{
				$returnMsg  = "복호화 오류";
			}									
		} 
		
		if ($returnMsg != ""){
			 echo "복호화 처리결과 : $returnMsg";
		}	
	}else{
		 echo "처리할 데이타가 없습니다.";
	}
?>