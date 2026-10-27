<?php
$img_path = "";
if($row['BRDATA_THUMBNAIL'] != ""){

	$file_arr		= explode(".", $row['BRDATA_THUMBNAIL']);
	$ext			= strtolower($file_arr[1]);
	
	if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png"){
		$img_path = "/upload/bbs/".$bid."/".$row['BRDATA_THUMBYEAR']."/thumbnail/thumbnail_".$row['BRDATA_THUMBNAIL'];
	}

}else{

	$fWhere = "WHERE brdfile_did = '".$row['BRDATA_ID']."' AND brdfile_bid = '".$row['BRDATA_BID']."'";
	$resultChk = $coreClass -> selectQueryCount(tbl_board_file, $fWhere);

	if($resultChk > 0 ) {

		$fileRow		= $coreClass -> selectQueryArray(tbl_board_file, $fWhere, "ORDER BY brdfile_no DESC", 0, 1);
		$img_path		= "";								
		$file_arr		= explode(".", $fileRow['BRDFILE_SNAME']);
		$ext			= strtolower($file_arr[1]);

		$pathExplode	= explode("/", $fileRow['BRDFILE_PATH']);
		$path2			= dir_public."/resource/attach/".$pathExplode[count($pathExplode)-2]."/";//$bid
		$filepath2			= $path2.$pathExplode[count($pathExplode)-1];

		if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png"){
			$filepath	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/thumbnail/".$fileRow['BRDFILE_SNAME'];

			if(is_file($filepath)) {
				$img_path = "/upload/bbs/".$bid."/".$fileRow['BRDFILE_YEAR']."/thumbnail/".$fileRow['BRDFILE_SNAME'];
			} else if(is_file($filepath2)){

				$img_path = "/resource/attach/".$pathExplode[count($pathExplode)-2]."/".$pathExplode[count($pathExplode)-1];

			}else {
				$filepath	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/thumbnail/thumbnail_".$fileRow['BRDFILE_SNAME'];
				//$filepath	= mb_convert_encoding($filepath, "EUC-KR", "UTF-8");
				if(is_file($filepath)) {
					$img_path = "/upload/bbs/".$bid."/".$fileRow['BRDFILE_YEAR']."/thumbnail/thumbnail_".$fileRow['BRDFILE_SNAME'];
				}
			}
		}

	}

}

if($img_path == ""){
	$img_path = "/home/images/board/sc52_video.gif";
}

?>