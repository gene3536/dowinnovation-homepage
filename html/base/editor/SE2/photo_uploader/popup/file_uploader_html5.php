<?php ini_set('memory_limit','512M'); 
 	$sFileInfo = '';
	$headers = array();
	 
	foreach($_SERVER as $k => $v) {
		if(substr($k, 0, 9) == "HTTP_FILE") {
			$k = substr(strtolower($k), 5);
			$headers[$k] = $v;
		} 
	}
	
	$file = new stdClass;
	$file->name = str_replace("\0", "", rawurldecode($headers['file_name']));
	$file->size = $headers['file_size'];
	$file->content = file_get_contents("php://input");
	
	$filename_ext = strtolower(array_pop(explode('.',$file->name)));
	$allow_file = array("jpg", "png", "bmp", "gif"); 
	
	if(!in_array($filename_ext, $allow_file)) {
		//echo "NOTALLOW_".$file->name;
		echo "<script>alert('허용되지 않는 파일입니다.');</script>";
	} else {
		$uploadDir = $_SERVER['DOCUMENT_ROOT'].'/upload/SE2/';
		if(!is_dir($uploadDir)){
			mkdir($uploadDir, 0777);
		}

		$new_file_name = str_replace(";","%3B",$file->name);
		$new_file_name = str_replace(" ","_",$new_file_name);
		
		// 기존 파일
		$exist = file_exists($uploadDir.$new_file_name); 
		if($exist) {
			$time = time();
			$new_file_name = $new_file_name."_".$time;
		}

		$file->name = $new_file_name;
		
		$newPath = $uploadDir.iconv("utf-8", "cp949", $file->name);
		
		if(file_put_contents($newPath, $file->content)) {
			$sFileInfo .= "&bNewLine=true";
			$sFileInfo .= "&sFileName=".$file->name;
			$sFileInfo .= "&sFileURL=/upload/SE2/".urlencode(iconv("utf-8", "cp949", $file->name));
		}
		
		echo $sFileInfo;
	}
?>