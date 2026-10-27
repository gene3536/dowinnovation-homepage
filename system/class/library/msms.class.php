<?
$MireeneSMSInfo		= array();
$MireeneSMSError	= array();

// 기본 정보
$MireeneSMSInfo['sms_userid']	= site_sms_id;	// SMS 사용자 아이디
$MireeneSMSInfo['sms_passwd']	= site_sms_pass;	// SMS 사용자 패스워드
$MireeneSMSInfo['host']		= 'lms.mireene.com';	// 미리내 SMS/LMS 서버 - 변경 금지
$MireeneSMSInfo['port']		= '80';					// 접속할 포트 - 변경 금지
$MireeneSMSInfo['timeout']	= 100;					// 접속 제한 시간

// 에러 코드
$MireeneSMSError['100']	= "SMS Server 연결 실패";
$MireeneSMSError['101']	= "데이터 오류";
$MireeneSMSError['201']	= "회원 인증 실패";
$MireeneSMSError['212']	= "SMS 잔액 부족";
$MireeneSMSError['901']	= "회원정보 오류";
$MireeneSMSError['911']	= "받는 사람 휴대폰 번호 오류";
$MireeneSMSError['912']	= "보내는 사람 휴대폰 번호 오류";
$MireeneSMSError['913']	= "예약날짜 오류";
$MireeneSMSError['914']	= "메시지 제한 글자 초과(80Byte)";

class MireeneSMS extends coreClass
{
	var $server_info = array();

	var $rec_phone;
	var $send_phone = "043-740-5946";
	var $message;
	var $res_time;

	var $socket;
	var $ErrNo = 0;
	var $ErrMsg = "";

	var $ErrCodes = array();

	var $buffer;
	var $postdata;

	// 초기화 함수
	function MireeneSMS()
	{
		Global $MireeneSMSInfo, $MireeneSMSError;

		$this->server_info = $MireeneSMSInfo;
		$this->ErrCodes = $MireeneSMSError;

		$this->ErrNo = 0;
	}

	// SMS 전송 서버 연결
	function MireeneSMS_connect()
	{

		$this->server_info['host']		= 'lms.mireene.com';	// 미리내 SMS/LMS 서버 - 변경 금지
		$this->server_info['port']		= '80';					// 접속할 포트 - 변경 금지
		$this->server_info['timeout']	= 100;					// 접속 제한 시간

		if($this->server_info['host']=="" || $this->server_info['port']=="")
		{
			return false;
		}

		/*if($this->socket = @fsockopen($this->server_info['host'], $this->server_info['port'], $this->ErrNo, $this->ErrMsg, $this->server_info['timeout'])) 
		{
			return true;
		}*/

		$this->socket = @fsockopen($this->server_info['host'], $this->server_info['port'], $ErrNo, $ErrMsg, $this->server_info['timeout']);

		if($this->socket){
			return true;
		}
		
		$this->ErrNo  = $ErrNo;
		$this->ErrMsg = $ErrMsg;

		return false;
	}

	// HTTP 
	function MireeneHTTP()
	{
		$this->server_info['sms_userid']	= 'softss_sms';	// SMS 사용자 아이디
		$this->server_info['sms_passwd']	= 'softss12';	// SMS 사용자 패스워드

		$this->postdata  = "rec_phone=".urlencode($this->rec_phone);
		$this->postdata .= "&send_phone=".urlencode($this->send_phone);
		$this->postdata .= "&message=".urlencode($this->message);
		$this->postdata .= "&res_time=".urlencode($this->res_time);
		$this->postdata .= "&sms_userid=".urlencode($this->server_info['sms_userid']);
		$this->postdata .= "&sms_passwd=".urlencode($this->server_info['sms_passwd']);

		$query = "POST /sender.php HTTP/1.1\r\n";
		$query.= "Accept: */*\r\n";
		$query.= "Accept-Language: ko\r\n";
		$query.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$query.= "Host: ".$this->server_info['host']."\r\n";
		$query.= "Content-Length: ".strlen($this->postdata)."\r\n";
		$query.= "Connection: Keep-Alive\r\n";
		$query.= "\r\n";
		$query.= $this->postdata."\r\n";
		
		if($this->MireeneSMS_connect())
		{
			fputs ($this->socket, $query);
			
			while(!feof($this->socket)) 
			{
				$tmp = fgets($this->socket,1024);
				if(eregi("sms_result", $tmp))
				{
					$tmp2 = explode(":", trim($tmp));
					$this->buffer = trim($tmp2[1]);
					break;
				}
			} 
		} 
		else 
		{
			$this->ErrNo = 100;
			$this->ErrMsg = $this->ErrCodes[$this->ErrNo];
		}
	}

	function reset_value()
	{
		unset($this->server_info);
		unset($this->rec_phone);
		unset($this->send_phone);
		unset($this->message);
		unset($this->res_time);
		unset($this->socket);
		unset($this->ErrNo);
		unset($this->ErrMsg);
		unset($this->ErrCodes);
		unset($this->buffer);
		unset($this->postdata);
	}
	

	function strlen_byte($str)
	{
		$ret = 0; 

		for($i = 0; $i < strlen($str); $i++)
		{
			if(ord($str{$i}) > 127)
			{
				$ret++;
			}
			else
			{
				$ret++;
			}
   		}
      
		return $ret;
	}

	// 넘어온 값 체크
	function check_value()
	{
		$tmp_rec = "";

		for($i=0;$i<strlen($this->rec_phone);$i++)
		{
			$tmp = substr($this->rec_phone, $i, 1);
			if(is_numeric($tmp)) $tmp_rec .= $tmp;
		}
		$this->rec_phone = $tmp_rec;

		// 받는 사람 휴대폰 번호 체크
		if(!eregi("^[0-9]+$", $this->rec_phone)) 
		{
			return "911";
		}
		if(!eregi("^(010|011|016|017|018|019)", $this->rec_phone)) 
		{
			return "911";
		}
		if(strlen($this->rec_phone) < 10 || strlen($this->rec_phone) > 11) 
		{
			return "911";
		}

		// SMS 아이디 길이 체크
		if ($this->strlen_byte($this->server_info['sms_userid']) > 20) 
		{
			return "901";
		}
		// SMS 패스워드 길이 체크
		if ($this->strlen_byte($this->server_info['sms_passwd']) > 20) 
		{
			return "901";
		}
		// 보내는 사람 번호 길이 체크
		if ($this->strlen_byte($this->send_phone) > 15) 
		{
			return "912";
		}
		// 예약 날짜 길이 체크
		if ($this->strlen_byte($this->res_time) > 19) 
		{
			return "913";
		}
		// 메시지 길이 체크
		if ($this->strlen_byte($this->message) > 80) 
		{
			return "914";
		}

		return "0";
	}

	// SMS 발송
	function send_sms()
	{
		// 값 체크
		// 에러값이 있을 경우 에러값 반환 후 종료
		if($return = $this->check_value())
		{
			return $return;
		}
		else
		{
			// 호출
			$this->MireeneHTTP();

			if($this->ErrNo)
			{
				return $this->ErrNo;
			}
			else
			{
				return $this->buffer;
			}
		}

	}

	// 소켓 Destroy
	function destroy()
	{
		if ($this->socket) {

			@fclose($this->socket);
		}

		// 초기화
		$this->reset_value();
	}

	/*
	리턴코드	설명
	0		"성공"
	100		"SMS Server 연결 실패";
	101		"데이터 오류";
	201		"회원 인증 실패";
	212		"SMS 잔액 부족";
	901		"회원정보 오류";
	911		"받는 사람 휴대폰 번호 오류";
	912		"보내는 사람 휴대폰 번호 오류";
	913		"예약날짜 오류";
	914		"메시지 제한 글자 초과(80Byte)";


	function sendSMS($rec_numb, $send_numb, $message, $res_time)
	{
		
		# - 리턴값이 0이면 성공, 그 외의 값이면 에러코드 참조
		# - 예약 날짜 형식 : YYYY-MM-DD H:i:s ex) 2009-10-10 10:10:10
		# - 예약 날짜를 입력하지 않으시면 SMS가 바로 전송됩니다.
		# - UTF-8 인코딩을 사용하시기 바랍니다.

		# send_mireene_sms('받는사람연락처','보내는사람연락처','문자내용','예약날짜');
		

		$msms_rec_phone		= $rec_numb;  //받는사람연락처
		$msms_send_phone	= $send_numb; //보내는사람연락처
		$msms_message		= $message;   //문자내용
		$msms_res_time		= $res_time;  //예약날짜 

		// 성공시 처리할 부분
		if(!$return = send_mireene_sms($msms_rec_phone, $msms_send_phone, $msms_message, $msms_res_time))
		{
			//echo "성공"; 
			return true;
		}
		// 실패시 처리할 부분
		else
		{
			//echo "실패 [ErrorCode : $return]"; 
			return $return;
		}
	}

	*/

	// 미리내 SMS 발송 함수
	function send_mireene_sms($rec, $send="", $message, $time = 0, $name="", $orderno="")
	{	
		$this->rec_phone  = $rec;
		if(!empty($send)) $this->send_phone = $send;
		$this->message    = $message;
		$this->res_time   = $time;

		$result = $this->send_sms();

		$this->destroy();

		if($result=="OK") $result = "0"; 

		coreClass::getConnection();		
		$this->smsLog($rec, $name, $message, $result, $orderno);

		return $result;
	}


}


?>