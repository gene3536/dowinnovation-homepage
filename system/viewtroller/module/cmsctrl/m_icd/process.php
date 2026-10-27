<?php
	switch($act) {
		// 삭제
		case "delete" :
			$where	= "WHERE icd_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

			// 이미지 삭제
			if(!empty($row['ICD_SFILENAME'])) {
				@unlink($save_path.$row['ICD_FILEYEAR']."/thumbnail/thumbnail_".$row['ICD_SFILENAME']);
				@unlink($save_path.$row['ICD_FILEYEAR']."/".$row['ICD_SFILENAME']);
			}

			// 첨부파일 삭제
			$fileClass -> fileDeleteType5($pid, $row['ICD_ID']);

			// 데이터 삭제
			$coreClass -> deleteQuery($tbl1, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 등록
		case "insert" :
			if(S_mb_level >= site_config_glevel && (($chkKey != null && $spamKey != null) && $chkKey != $spamKey)) $coreClass -> msg_back("인증번호 값이 올바르지 않습니다");

			$maxNo	= $coreClass -> selectQueryMax($tbl1, "icd_no");
			$maxNo++;
			$id			= str_pad($maxNo, 8, "0", STR_PAD_LEFT);

			// 첨부파일 업로드
			$sfilename	= "";
			$filename		= "";
			$filesize		= 0;
			if(isset(${"thumbFile"}) && ${"thumbFile_name"}){
				$sfilename	= $coreClass -> uploadFile(${"thumbFile"}, ${"thumbFile_name"}, ${"thumbFile_size"}, $save_path, 0, 5, 180, 120);
				$filename		= $thumbFile_name;
				$filesize		= $thumbFile_size;
			}

			$sdate			= $icd_sdate." ".$icd_shour.":".$icd_sminute;
			$edate		= $icd_edate." ".$icd_ehour.":".$icd_eminute;

			$item			= "icd_no, icd_id, icd_pid, icd_scode, icd_uid, icd_name, icd_title, icd_visible, icd_type, icd_content, icd_alt, icd_url, icd_target, icd_sdate, icd_edate, icd_width, icd_height, icd_sfilename, icd_filename, icd_filesize, icd_fileyear, icd_fld1, icd_fld2, icd_fld3, icd_fld4, icd_fld5, icd_fld6, icd_fld7, icd_fld8, icd_fld9, icd_fld10, icd_txt1, icd_txt2, icd_txt3, icd_regip, icd_modip, icd_regdate, icd_moddate";
			$value			= "'".$maxNo."', '".$id."', '".$pid."', '".$icd_scode."', '".S_mb_id."', '".$icd_name."', '".$icd_title."', '".$icd_visible."', '".$icd_type."', '".$icd_content."', '".$icd_alt."', '".$icd_url."', '".$icd_target."', '".$sdate."', '".$edate."', '".$icd_width."', '".$icd_height."', '".$sfilename."', '".$filename."', ".$filesize.", ".date("Y").", '".$icd_fld1."', '".$icd_fld2."', '".$icd_fld3."', '".$icd_fld4."', '".$icd_fld5."', '".$icd_fld6."', '".$icd_fld7."', '".$icd_fld8."', '".$icd_fld9."', '".$icd_fld10."', '".$icd_txt1."', '".$icd_txt2."', '".$icd_txt3."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl1, $item, $value);

			$item			= "icd_id, icd_pid, icd_scode, icd_uid, icd_name, icd_title, icd_visible, icd_type, icd_content, icd_alt, icd_url, icd_target, icd_sdate, icd_edate, icd_width, icd_height, icd_sfilename, icd_filename, icd_filesize, icd_fileyear, icd_fld1, icd_fld2, icd_fld3, icd_fld4, icd_fld5, icd_fld6, icd_fld7, icd_fld8, icd_fld9, icd_fld10, icd_txt1, icd_txt2, icd_txt3, icd_regip, icd_modip, icd_logip, icd_regdate, icd_moddate, icd_logdate";
			$value			= "'".$id."', '".$pid."', '".$icd_scode."', '".S_mb_id."', '".$icd_name."', '".$icd_title."', '".$icd_visible."', '".$icd_type."', '".$icd_content."', '".$icd_alt."', '".$icd_url."', '".$icd_target."', '".$sdate."', '".$edate."', '".$icd_width."', '".$icd_height."', '".$sfilename."', '".$filename."', ".$filesize.", ".date("Y").", '".$icd_fld1."', '".$icd_fld2."', '".$icd_fld3."', '".$icd_fld4."', '".$icd_fld5."', '".$icd_fld6."', '".$icd_fld7."', '".$icd_fld8."', '".$icd_fld9."', '".$icd_fld10."', '".$icd_txt1."', '".$icd_txt2."', '".$icd_txt3."', '".site_client_ip."', '".site_client_ip."', '".site_client_ip."', '".site_regdate."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl2, $item, $value);

			// 첨부파일 업로드
			require_once $dir2."prc.upload.php";

			$coreClass -> commit();
			if(!empty($sendMail)&&$sendMail=='y'){
				require_once dir_system."/viewtroller/module/Mailer/class.phpmailer.php";

				//$mail = new PHPMailer;
				$mail = new PHPMailer(true);
				$mail->Timeout = 20; // 임시

				/*
				name : 이름
				title : 회사명
				staff : 직책
				email : 이메일
				tel : 전화
				cont : 내용
				*/


				//$mail->IsSMTP(); // Set mailer to use SMTP / IsSendmail 사용으로 인한 주석 261027 JHJ
				$mail->IsSendmail();
				$mail->Sendmail = '/usr/bin/msmtp --account=dwinno';
				// IsSendmail 사용으로 인한 주석 261027 JHJ
				/*$mail->SMTPAuth = true; // turn on SMTP authentication
				$mail->SMTPSecure = "ssl";
				$mail->Host = "smtp.naver.com";
				$mail->Port = 465;
				$mail->Username = "gene3536@naver.com";
				$mail->Password = "EQS3MRFRDEBT";*/
				$mail->ContentType = "text/html";
				$mail->CharSet = "utf-8";
				//$mail->SetFrom($email, $name); //보내는 사람
				$mail->SetFrom("gene3536@naver.com", "DWIZ 홈페이지"); //보내는 사람
				$mail->WordWrap = 50; // set word wrap
				$mail->IsHTML(true); // Set email format to HTML  메일을 보낼 때 html 형식으로 메일을 보낼 경우 true
				$mail->Subject = "[".$icd_title." - ".$icd_name." ".$icd_fld1."] 온라인 문의"; //메일 제목
				$wr_content = "온라인 문의 상세정보<br>";
				$wr_content .= "성명 : ".$icd_name."<br>";
				$wr_content .= "회사명 : ".$icd_title."<br>";
				$wr_content .= "직책 : ".$icd_fld1."<br>";
				$wr_content .= "이메일 : ".$icd_fld2."<br>";
				$wr_content .= "전화번호 : ".$icd_fld3."<br>";
				$wr_content .= "내용 : ".$icd_content;
				$mail->Body    = $wr_content;  //메일 본문
				$mail->AddAddress("dwiz@dwinno.com"); //받는사람
				//$mail->AddAddress("gene35@naver.com");

				switch(site_config_path){
					case "/eng":
						$rtMsg = 'success';
						break;

					case "/chn":
						$rtMsg = '成功';
						break;

					case "/vtn":
						$rtMsg = 'sự thành công';
						break;

					default:
						$rtMsg = '정상적으로 등록되었습니다.';
						break;
				}

				if(!$mail->Send()) {
					$coreClass -> go("sub.php?menukey=".$menukey."&mod=".$rtMod.$listVar);
				}else{
					$coreClass -> msg_go($rtMsg,"sub.php?menukey=".$menukey."&mod=".$rtMod.$listVar);
				}
				break;

			} else {
				$coreClass -> msg_go($rtMsg,"sub.php?menukey=".$menukey.$listVar);

				break;
			}

		// 수정
		case "modify" :
			$where		= "WHERE icd_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			$row = $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

			// 첨부파일 업로드
			$imgquery = "";
			if(isset(${"thumbFile"}) && ${"thumbFile_name"}){
				$sfilename	= $coreClass -> uploadFile(${"thumbFile"}, ${"thumbFile_name"}, ${"thumbFile_size"}, $save_path, 0, 5, 180, 120);
				$filename		= $thumbFile_name;
				$filesize		= $thumbFile_size;
				$imgquery	= ", icd_sfilename = '".$sfilename."', icd_filename = '".$filename."', icd_filesize = ".$filesize.", icd_fileyear = '".date("Y")."'";
				/*
				if(!empty($row['ICD_SFILENAME'])) {
					@unlink($save_path.$row['ICD_FILEYEAR']."/thumbnail/thumbnail_".$row['ICD_SFILENAME']);
					@unlink($save_path.$row['ICD_FILEYEAR']."/".$row['ICD_SFILENAME']);
				}
				*/
			} else {
				$sfilename = $row['ICD_SFILENAME'];
				$filename = $row['ICD_FILENAME'];
				$filesize = $row['ICD_FILESIZE'];
			}

			$sdate			= $icd_sdate." ".$icd_shour.":".$icd_sminute;
			$edate		= $icd_edate." ".$icd_ehour.":".$icd_eminute;

			$set			= "SET
				icd_scode = '".$icd_scode."',
				icd_title = '".$icd_title."',
				icd_visible = '".$icd_visible."',
				icd_type = '".$icd_type."',
				icd_content = '".$icd_content."',
				icd_alt = '".$icd_alt."',
				icd_url = '".$icd_url."',
				icd_target = '".$icd_target."',
				icd_sdate = '".$sdate."',
				icd_edate = '".$edate."',
				icd_width = '".$icd_width."',
				icd_height = '".$icd_height."',
				icd_fld1 = '".$icd_fld1."',
				icd_fld2 = '".$icd_fld2."',
				icd_fld3 = '".$icd_fld3."',
				icd_fld4 = '".$icd_fld4."',
				icd_fld5 = '".$icd_fld5."',
				icd_fld6 = '".$icd_fld6."',
				icd_fld7 = '".$icd_fld7."',
				icd_fld8 = '".$icd_fld8."',
				icd_fld9 = '".$icd_fld9."',
				icd_fld10= '".$icd_fld10."',
				icd_txt1 = '".$icd_txt1."',
				icd_txt2 = '".$icd_txt2."',
				icd_txt3 = '".$icd_txt3."',
				icd_modip = '".site_client_ip."',
				icd_moddate = '".site_regdate."'".$imgquery;
			$where		= "WHERE icd_no = '".$no."'";
			$coreClass -> updateQuery($tbl1, $set, $where);

			// 로그 등록
			$item			= "icd_id, icd_pid, icd_scode, icd_title, icd_visible, icd_type, icd_content, icd_alt, icd_url, icd_target, icd_sdate, icd_edate, icd_width, icd_height, icd_sfilename, icd_filename, icd_filesize, icd_fileyear, icd_fld1, icd_fld2, icd_fld3, icd_fld4, icd_fld5, icd_fld6, icd_fld7, icd_fld8, icd_fld9, icd_fld10, icd_regip, icd_modip, icd_logip, icd_regdate, icd_moddate, icd_logdate";
			$value			= "'".$row['ICD_ID']."', '".$row['ICD_PID']."', '".$icd_scode."', '".$icd_title."', '".$icd_visible."', '".$icd_type."', '".$icd_content."', '".$icd_alt."', '".$icd_url."', '".$icd_target."', '".$sdate."', '".$edate."', '".$icd_width."', '".$icd_height."', '".$sfilename."', '".$filename."', ".$filesize.", ".date("Y").", '".$icd_fld1."', '".$icd_fld2."', '".$icd_fld3."', '".$icd_fld4."', '".$icd_fld5."', '".$icd_fld6."', '".$icd_fld7."', '".$icd_fld8."', '".$icd_fld9."', '".$icd_fld10."', '".$row['ICD_REGIP']."', '".site_client_ip."', '".site_client_ip."', '".$row['ICD_REGDATE']."', '".site_regdate."', '".site_regdate."'";
			$coreClass -> insertQuery($tbl2, $item, $value);

			// 첨부파일 업로드
			$id = $row['ICD_ID'];
			require_once $dir2."prc.upload.php";

			$coreClass -> commit();
			if(!empty($rtMsg)) $coreClass -> msg_go($rtMsg,"sub.php?menukey=".$menukey."&mod=".$rtMod.$listVar);
			else $coreClass -> go("sub.php?menukey=".$menukey."&mod=".$rtMod.$listVar);
			break;

		// 복구
		case "restore" :
			$where	= "WHERE icd_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

			$where	= "WHERE icd_no = '".$logno."' AND icd_id = '".$row['ICD_ID']."'";
			$coreClass -> selectQueryCountChk($tbl2, $where);
			$rows 	= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");

			$set			= "SET
				icd_scode = '".$rows['ICD_SCODE']."',
				icd_title = '".$rows['ICD_TITLE']."',
				icd_visible = '".$rows['ICD_VISIBLE']."',
				icd_type = '".$rows['ICD_TYPE']."',
				icd_content = '".$rows['ICD_CONTENT']."',
				icd_alt = '".$rows['ICD_ALT']."',
				icd_url = '".$rows['ICD_URL']."',
				icd_target = '".$rows['ICD_TARGET']."',
				icd_sdate = '".$rows['ICD_SDATE']."',
				icd_edate = '".$rows['ICD_EDATE']."',
				icd_width = '".$rows['ICD_WIDTH']."',
				icd_height = '".$rows['ICD_HEIGHT']."',
				icd_sfilename = '".$rows['ICD_SFILENAME']."',
				icd_filename = '".$rows['ICD_FILENAME']."',
				icd_filesize = '".$rows['ICD_FILESIZE']."',
				icd_fileyear = ".$rows['ICD_FILEYEAR'].",
				icd_fld1 = '".$rows['ICD_FLD1']."',
				icd_fld2 = '".$rows['ICD_FLD2']."',
				icd_fld3 = '".$rows['ICD_FLD3']."',
				icd_fld4 = '".$rows['ICD_FLD4']."',
				icd_fld5 = '".$rows['ICD_FLD5']."',
				icd_fld6 = '".$rows['ICD_FLD6']."',
				icd_fld7 = '".$rows['ICD_FLD7']."',
				icd_fld8 = '".$rows['ICD_FLD8']."',
				icd_fld9 = '".$rows['ICD_FLD9']."',
				icd_fld10= '".$rows['ICD_FLD10']."',
				icd_txt1 = '".$rows['ICD_TXT1']."',
				icd_txt2 = '".$rows['ICD_TXT2']."',
				icd_txt3 = '".$rows['ICD_TXT3']."',
				icd_modip = '".$rows['ICD_MODIP']."',
				icd_moddate = '".$rows['ICD_MODDATE']."'";
			$where		= "WHERE icd_no = '".$no."'";
			$coreClass -> updateQuery($tbl1, $set, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=view&no=".$no."&logno=".$logno.$listVar);
			break;

		// 활성여부
		case "visible" :
			$where		= "WHERE icd_no = '".$no."'";
			$coreClass -> selectQueryCountChk($tbl1, $where);
			$row			= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

			if($row['ICD_VISIBLE'] == 'Y') {
				$icd_visible = 'N';
			} else {
				$icd_visible = 'Y';
			}

			$set			= "SET icd_visible = '".$icd_visible."', icd_modip = '".site_client_ip."', icd_moddate = '".site_regdate."'";
			$coreClass -> updateQuery($tbl1, $set, $where);

			$coreClass -> commit();
			$coreClass -> go("sub.php?menukey=".$menukey."&mod=list".$listVar);
			break;

		// 파일삭제
		case "fdelete" :
			$fno	= $coreClass -> dataModelEncrypt(2, "fno", NULL);
			$fno	= $coreClass -> decrypt_md5(urlencode($fno), site_config_filekey);
			$pid	= $coreClass -> dataModelEncrypt(2, "pid", NULL);
			$pid	= $coreClass -> decrypt_md5(urlencode($pid), site_config_filekey);
			$did	= $coreClass -> dataModelEncrypt(2, "did", NULL);
			$did	= $coreClass -> decrypt_md5(urlencode($did), site_config_filekey);

			if($fno && $pid && $did) {
				$fileClass -> fileDeleteType6($fno, $pid, $did);
				$coreClass -> back();
			} else {
				$coreClass -> msg_back("삭제할 파일이 없습니다.");
			}
			break;

		default :
			$coreClass -> msg_back("잘못된 접근입니다");
			break;
	}
?>
