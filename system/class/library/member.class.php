<?php
	class memberClass extends coreClass {
		
		private $atype0 = "0"; // 운영자
		private $atype1 = "1"; // 실명인증
		private $atype2 = "2"; // 공공아이핀
		
		// 최근접속시간 가져오기
		function getMbLog($uid) {
			$where = "WHERE mb_log_uid='".$uid."'";
			return $this -> selectQueryArray(tbl_member_login, $where, "ORDER BY mb_log_regdate DESC", 1, 2);
		}
				
		// 관리자 로그아웃
		function Logout() {
			session_unset();
			$this -> go("index.php");
		}
		
		// 사용자 로그아웃
		function memberLogout($memberReferer="") {
			session_unset(); 
			$_SESSION["memberReferer"]	= "";	
			
			if(empty($memberReferer)) { 
				$this -> go("http://".$_SERVER['HTTP_HOST']."/");
			} else {
				if(preg_match("((http)://[a-z0-9-]+.[][a-zA-Z0-9:&#@=_~%;?/.+-]+)", $memberReferer)) 
					$this -> go($memberReferer); 
				else 
					$this -> go("http://".$_SERVER['HTTP_HOST'].site_config_path."/".$memberReferer);
			}

		}
		
		// 사용자정보 수정
		function memberModify($mb_email, $mb_tel) {
			$where	= "WHERE mb_uid = '".S_mb_id."'";
			$rs			= $this -> selectQueryCount(tbl_member, $where, "", "");
			if($rs < 1) $this -> msg_back("회원정보가 올바르지 않습니다.");
				
			$set = "SET
				mb_email		='".$mb_email."',
				mb_tel			='".$mb_tel."',
				mb_moddate	='".site_regdate."'";
			$this -> updateQuery(tbl_member, $set, $where);
				
			$this -> commit();
			$this -> msg_go("회원정보가 변경되었습니다.", "member.php?memberkey=5");
		}
		
		function memberPassModify($userPw1, $userPw2, $userPw3) {
			if($userPw1 != $userPw2) {
				$this -> msg_back("신규 비밀번호가 일치하지 않습니다.");
			}
				
			$where	= "WHERE mb_uid = '".S_mb_id."' AND mb_pass = '".$userPw3."'";
			$rs			= $this -> selectQueryCount(tbl_member, $where);
			if($rs < 1) {
				$this -> msg_back("기존 비밀번호가 올바르지 않습니다.");
			}
				
			$set	= "SET mb_pass = '".$userPw1."', mb_moddate = '".site_regdate."'";
			$this -> updateQuery(tbl_member, $set, $where);
				
			$this -> commit();
			$this -> msg_go("비밀번호가 변경 되었습니다.", "member.php?memberkey=6");
		}
		
		// 관리자 로그인 체크
		function LoginCheck($type) {
			$where	= "WHERE mb_uid='".S_mb_id."' AND mb_level <= '".site_config_slevel."'";  
			$rsCnt		= $this -> selectQueryCount(tbl_member, $where);

			switch ($type) {				
				case '1':					
					if($rsCnt < 1) $this -> go("index.php");
					break;				
				case '2':
					if($rsCnt > 0 && S_mb_login == true) $this -> go("main.php");
					break;				
				case '3':
					if($rsCnt < 1) $this -> back();
					break;
				default:					
					$this -> go("index.php");					
					break;			
			}
		}
		
		// 관리자 로그인
		function Login() {
			$where	= "WHERE mb_uid='".S_mb_id."' AND mb_level <= '".site_config_slevel."'";
			
			// 로그인 여부 체크
			$rsCnt		= $this -> selectQueryCount(tbl_member, $where);
			if($rsCnt > 0 && S_mb_login == true) {
				$this -> go("main.php");
			}		

			$userId		= $this -> dataEscape($_POST["usr"]);
			$userPw		= $this -> dataEscape($_POST["usrwd"]);			
			$userPw		= $this -> crypt_sha256($userPw);
			$userPws		= $this -> dataEscape($_POST["usrwd"]);			
			$userPws		= $this -> crypt_imsi($userPws);
			if(empty($userId) || empty($userPw)) {
				$this -> msg_back("아이디 또는 비밀번호를 입력해 주세요.");
			}

			// 30분 로그인 제한 체크
			$where		= "WHERE mb_logx_uid='".$userId."' and mb_logx_cnt >= 5";
			$loginxCnt	= $this -> selectQueryCount(tbl_member_loginxcnt, $where);			
			if($loginxCnt > 0) {
				$loginx	= $this -> selectQueryArray(tbl_member_loginxcnt, $where, "", "", "");
				if(strtotime($loginx['MB_LOGX_REGDATE']) + 1800 >= mktime()) { 
					$this -> msg_back("로그인 실패 5회 입니다. 30분 후 접속하여 주세요.");
				} else {
					$this -> deleteQuery(tbl_member_loginxcnt, $where);
					$this -> commit();
				}
			}
			
			// 관리자 체크
			$where		= "WHERE mb_uid='".$userId."' AND mb_level <= '".site_config_slevel."'";
			$rsCnt			= $this -> selectQueryCount(tbl_member, $where);
			if($rsCnt < 1) $this -> msg_back("관리자만 로그인이 가능합니다1");
			
			// 비밀번호 체크
			$where	= "WHERE mb_uid = '".$userId."' AND (mb_pass = '".$userPw."' OR mb_pass = '".$userPws."') AND mb_level <= '".site_config_slevel."'";
			$rsCnt		= $this -> selectQueryCount(tbl_member, $where); 
			
			if($rsCnt > 0) {
				$row	= $this -> selectQueryArray(tbl_member, $where, "", "", "");			
				$_SESSION["memberLogin"]		= true;
				$_SESSION["memberId"]			= $row['MB_UID'];
				$_SESSION["memberName"]			= $row['MB_NAME'];
				$_SESSION["memberLevel"]		= $row['MB_LEVEL'];
				$_SESSION["memberScode"]		= $row['MB_SCODE'];
				$_SESSION["memberAuthtype"]	= "0";  
				
				// 로그인정보 등록
				$item		= "mb_log_scode, mb_log_uid, mb_log_uname, mb_log_browser, mb_log_regip, mb_log_regdate";
				$value		= "'".site_config_code."', '".$row['MB_UID']."', '".$row['MB_NAME']."', '".site_client_browser."', '".site_client_ip."', '".site_regdate."'";
				$this -> insertQuery(tbl_member_login, $item, $value); 

				// 로그인실패기록 삭제
				
				$where	= "WHERE mb_logx_uid='".$userId."'";
				
				$this -> deleteQuery(tbl_member_loginxcnt, $where);

				
				$this -> commit();

				$this -> go("main.php");
			} else { 
				// 로그인실패로그 등록
				$item		= "mb_logx_scode, mb_logx_uid, mb_logx_browser, mb_logx_regip, mb_logx_regdate";
				$value		= "'".site_config_code."', '".$userId."', '".site_client_browser."', '".site_client_ip."', '".site_regdate."'";
				$this -> insertQuery(tbl_member_loginx, $item, $value);
				
				// 로그인실패기록 체크
				$where	= "WHERE mb_logx_uid = '".$userId."'";
				$rsCnt		= $this -> selectQueryCount(tbl_member_loginxcnt, $where);				

				// 로그인실패기록 등록
				if($rsCnt < 1) {
					$cnt		= 1;
					$item		= "mb_logx_uid, mb_logx_cnt, mb_logx_regip, mb_logx_regdate";
					$value		= "'".$userId."', '".$cnt."', '".site_client_ip."', '".site_regdate."'";
					$this -> insertQuery(tbl_member_loginxcnt, $item, $value);
				} else {
					$rsc		= $this -> selectQueryArray(tbl_member_loginxcnt, $where, "", "", "");
					$cnt		= $rsc['MB_LOGX_CNT'] + 1;
					$set		= "SET mb_logx_cnt = '".$cnt."', mb_logx_regip = '".site_client_ip."', mb_logx_regdate = '".site_regdate."'";
					$this -> updateQuery(tbl_member_loginxcnt, $set, $where);
				}
				$this -> commit();
				$this -> msg_back("정확한 비밀번호가 아닙니다. 5회 이상 실패하면 30분간 로그인이 금지됩니다. [".$cnt."/5]");
			}
			break;
		}
		
		function memberLogin($userId, $userPass, $scode, $memberReferer="") {
			
			if(empty($userId) || empty($userPass)) {
				$this -> msg_back("아이디 패스워드를 입력해 주세요.");
			}
			
			$where = "WHERE mb_uid = '".$userId."' AND mb_pass = '".$userPass."' AND mb_scode = '".$scode."' AND mb_del = 'N'";
			$rsCnt		= $this -> selectQueryCount(tbl_member, $where);
			if($rsCnt <= 0) $this -> msg_back("정보가 일치하지 않습니다.");
			if($rsCnt > 0 && S_mb_login == true) {
				$coreClass -> go("main.php");
			}

			if($rsCnt > 0) {
				$row = $this -> selectQueryArray(tbl_member, $where, "", "", "");
				session_unset();
				$_SESSION["memberLogin"]		= true;
				$_SESSION["memberId"]			= $row['MB_UID'];
				$_SESSION["memberName"]			= $row['MB_NAME'];
				$_SESSION["memberLevel"]		= 9;
				$_SESSION["memberScode"]		= null;
				$_SESSION["memberAuthtype"]		= null;
					
				// 로그인정보 등록
				$item		= "mb_log_scode, mb_log_uid, mb_log_uname, mb_log_browser, mb_log_regip, mb_log_regdate";
				$value		= "'".site_config_code."', '".$row['MB_UID']."', '".$row['MB_NAME']."', '".site_client_browser."', '".site_client_ip."', '".site_regdate."'";
				$this -> insertQuery(tbl_member_login, $item, $value);
					
				$this -> commit();
				if(empty($memberReferer)) {
					$this -> go("/");
				} else {
					$this -> go("http://".$memberReferer);
				}
			} else {
				$this -> commit();
				$this -> msg_back("정확한 비밀번호가 아닙니다.");
			}
		}

		function isDelID($id)
		{
			$where = "WHERE mb_delid_uid = '".$id."'"; 
			$cnt   = $this -> selectQueryCount(tbl_member_delid, $where);

			return $cnt;

		}

		function validMb($t, $v)
		{
			if(empty($t) || empty($v)) return false;

			$return = false;

			if($t == "id"){
				if(preg_match('/^[a-z0-9]{8,20}$/',$v)) $return = true;
			}
			else if($t == "pass"){
				if(preg_match('/^.*(?=^.{8,20}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/',$v)) $return = true;
			}
			else if($t == "email"){
				if(preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $v)) $return = true;
			}

			return $return ;
		}
		
	}
?>