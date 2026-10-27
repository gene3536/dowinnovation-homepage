<?



require_once('../lib/sms_send.php');
		$reqTel = str_replace("-", "", trim($send_wr_1));
		$reqTel = str_replace(" ", "", $reqTel);
		$reqTel = "01020184912";
		if($reqTel != ""){

			$msg = date("Y-m-d")." 유지보수 요청되었습니다\n(주)코아아이티";
			sendsms($reqTel, $msg);
		}
	



?>