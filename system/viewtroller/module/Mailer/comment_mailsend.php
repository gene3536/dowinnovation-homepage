<?


	require_once('../lib/sms_send.php');

	
	$reqTel = str_replace("-", "", trim($send_wr1));
	$reqTel = str_replace(" ", "", $reqTel);

	if($reqTel != ""){
		if($send_typeCkeck == "0") $msg = $send_wr_datetime." 등록한 요청이 대기로 변경되었습니다\n(주)코아아이티";
		else if($send_typeCkeck == "1") $msg = $send_wr_datetime." 등록한 요청이 진행중으로 변경되었습니다\n(주)코아아이티";
		else if($send_typeCkeck == "2") $msg = $send_wr_datetime." 등록한 요청이 완료되었습니다\n(주)코아아이티";

		sendsms($reqTel, $msg);

	}


if(trim($send_view_email) != ""){

	require_once('./class.phpmailer.php');

	$mail = new PHPMailer;

	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->IsSMTP();                                      // Set mailer to use SMTP
	$mail->ContentType = "text/html";
	$mail->CharSet = "utf-8";
	$mail->SetFrom("sendonly@coreit.co.kr", "코아아이티");                 //보내는 사람
	$mail->WordWrap = 50; // set word wrap
	$mail->IsHTML(true);                                  // Set email format to HTML  메일을 보낼 때 html 형식으로 메일을 보낼 경우 true


	if($send_typeCkeck == "0") $send_typeCkeck = "[대기]";
	else if($send_typeCkeck == "1") $send_typeCkeck = "[진행중]";
	else if($send_typeCkeck == "2") $send_typeCkeck = "[완료]";

	$mail->Subject = "[댓글등록] - ".$send_view_subject;                //메일 제목

	$comm = "<br><br><br><br><br><br><br><br>================================================================<br>";
	$comm .= "(주)코아아이티<br>";
	$comm .= "주소 : 충북 청원군 오창읍 각리 643-6 소프트웨어지원센터 311호<br>";
	$comm .= "전화 : 043-900-0120, Fax : 043-218-0120<br>";
	$comm .= "홈페이지: www.coreit.co.kr, 유지보수: as.coreit.co.kr<br>";
	$comm .= "================================================================<br>";

	$send_wr_content = "[".$send_view_subject."] 게시글에 댓글이 등록되었습니다<br><br>".$send_typeCkeck." ".$send_wr_content.$comm;

	$mail->Body    = $send_wr_content;  //메일 본문


	$mail->AddAddress(trim($send_view_email));  // Add a recipient 받는 사람 주소, 받는 사람 이름
	if(!$mail->Send()) {
		//echo 'Message could not be sent.';
		//echo 'Mailer Error: ' . $mail->ErrorInfo;         // 메일 전송에 실패 했을 경우 뜨는 에러 메세지
	}else{
		//echo "발송";
	}


}


?>