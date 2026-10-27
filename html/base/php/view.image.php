<?php

	require_once("../../../system/config/config_lite.php");

	$tbl		= tbl_board_file;
	$no		= $coreClass -> dataModelEncrypt(2, "no", NULL);
	$no		= $coreClass -> decrypt_md5(urlencode($no), site_config_filekey);
	$bid		= $coreClass -> dataModelEncrypt(2, "bid", NULL);
	$bid		= $coreClass -> decrypt_md5(urlencode($bid), site_config_filekey);
	$did		= $coreClass -> dataModelEncrypt(2, "did", NULL);
	$did		= $coreClass -> decrypt_md5(urlencode($did), site_config_filekey);
	$HTTP_USER_AGENT = site_client_browser;	
	
	if(!empty($no) && !empty($bid) && !empty($did)) {
		$where	= "WHERE brdfile_no = '".$no."' AND brdfile_bid = '".$bid."' AND brdfile_did = '".$did."'";
		$rs			= $coreClass -> selectQueryCount($tbl, $where);
		if($rs < 1) {
			$coreClass -> rollback();
			$coreClass -> msg_close("선택한 파일이 없습니다.");
		}
		$row		= $coreClass -> selectQueryArray($tbl, $where, "", "", ""); 

		$filename	= $row['BRDFILE_NAME']; 
		$filename	= str_replace(";","%3B",$filename);
		$file_arr	= explode(".",$filename);
		$ext		= strtolower($file_arr[count($file_arr)-1]);
		if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png") {			
			$filepath1	= dir_public."/upload/bbs/".$row['BRDFILE_BID']."/".$row['BRDFILE_YEAR']."/".$row['BRDFILE_SNAME']; 
			$filepath2	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
			$img_path1 = "/upload/bbs/".$row['BRDFILE_BID']."/".$row['BRDFILE_YEAR']."/".$row['BRDFILE_SNAME'];
			
			if(is_file($filepath1) || is_file($filepath2)) {
				$imgPath = $img_path1;
			} 
		} else {
			$coreClass -> msg_close("7올바른 이미지 파일이 아닙니다");			
		}
	} else {
		$coreClass -> msg_close("선택한 이미지 파일이 없습니다");
	}
?>

<!doctype html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $file_arr[0]?> 이미지보기</title>
</head>
<body style="margin:0; padding:0;">
	<div style="text-align:center">
		<img src="<?php echo $imgPath?>" alt="<?php echo $filename?>" style="border:none" onclick="self.close()" />
	</div>
</body>
</html>