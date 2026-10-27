<?php
	class fileClass extends coreClass {

		/**
		 * 첨부파일 삭제
		 */
		function fileDeleteType1($bid, $did) {
	 		$where	= "WHERE cms_file_bid = '".$bid."' AND cms_file_did = '".$did."'";
			$rsCnt		= $this -> selectQueryCount(tbl_cms_file, $where);					
			if($rsCnt > 0){
				$this -> begin();				
				$fileRs		= $this -> selectQuery(tbl_cms_file, $where, "", "", "");
				
				while($row = $this -> selectFetchArray($fileRs)) {
					$path		= dir_public."/upload/content/".$bid."/".$row['CMS_FILE_YEAR'];
					$name	= $path."/".$row['CMS_FILE_SNAME'];
					$sname	= $path."/thumbnail/thumbnail_".$row['CMS_FILE_SNAME'];
										
					if(is_file($name)) @unlink($name);
					if(is_file($sname)) @unlink($sname);
				}

				$this -> deleteQuery(tbl_cms_file, $where);
				$this -> commit();
			}
		}
		
		/**
		 * 첨부파일 삭제
		 */
		function fileDeleteType2($no, $bid, $did) {
			$where	= "WHERE cms_file_no = '".$no."' AND cms_file_bid = '".$bid."' AND cms_file_did = '".$did."'";
			$rsCnt		= $this -> selectQueryCount(tbl_cms_file, $where);					

			if($rsCnt > 0){
				$this -> begin();	
				$row		= $this -> selectQueryArray(tbl_cms_file, $where, "", "", "");
				$path		= dir_public."/upload/content/".$bid."/".$row['CMS_FILE_YEAR'];
					
				$name	= $path."/".$row['CMS_FILE_SNAME'];
				$sname	= $path."/thumbnail/thumbnail_".$row['CMS_FILE_SNAME'];
									
				if(is_file($name)) @unlink($name);
				if(is_file($sname)) @unlink($sname);
				
				$this -> deleteQuery(tbl_cms_file, $where);
				$this -> commit();
			}
		}
		
		/**
		 * 게시판 첨부파일 삭제
		 */
		function fileDeleteType3($bid, $did) {
	 		$where	= "WHERE brdfile_bid = '".$bid."' AND brdfile_did = '".$did."'";
			$rsCnt		= $this -> selectQueryCount(tbl_board_file, $where);					
			if($rsCnt > 0){
				$this -> begin();				
				$fileRs		= $this -> selectQuery(tbl_board_file, $where, "", "", "");
				
				while($row = $this -> selectFetchArray($fileRs)) {
					$path		= dir_public."/upload/bbs/".$bid."/".$row['BRDFILE_YEAR'];
					$name	= $path."/".$row['BRDFILE_SNAME'];
					$sname	= $path."/thumbnail/thumbnail_".$row['BRDFILE_SNAME'];
										
					if(is_file($name)) @unlink($name);
					if(is_file($sname)) @unlink($sname);
				}

				$this -> deleteQuery(tbl_board_file, $where);
				$this -> commit();
			}
		}
		
		/**
		 * 게시판 첨부파일 삭제
		 */
		function fileDeleteType4($no, $bid, $did) {
			$where	= "WHERE brdfile_no = '".$no."' AND brdfile_bid = '".$bid."' AND brdfile_did = '".$did."'";
			$rsCnt		= $this -> selectQueryCount(tbl_board_file, $where);					

			if($rsCnt > 0){
				$this -> begin();	
				$row		= $this -> selectQueryArray(tbl_board_file, $where, "", "", "");
				$path		= dir_public."/upload/bbs/".$bid."/".$row['BRDFILE_YEAR'];
					
				$name	= $path."/".$row['BRDFILE_SNAME'];
				$sname	= $path."/thumbnail/thumbnail_".$row['BRDFILE_SNAME'];
									
				if(is_file($name)) @unlink($name);
				if(is_file($sname)) @unlink($sname);
				
				$this -> deleteQuery(tbl_board_file, $where);
				$this -> commit();
			}
		}

		/**
		 * 사이트콘텐츠 첨부파일 삭제
		 */		
		function fileDeleteType5($pid, $did) {
			$where	= "WHERE icd_pid = '".$pid."' AND icd_did = '".$did."'";
			$rsCnt		= $this -> selectQueryCount(tbl_cms_icd_file, $where);
			if($rsCnt > 0){
				$fileRs		= $this -> selectQuery(tbl_cms_icd_file, $where, "", "", "");
				while($row = $this -> selectFetchArray($fileRs)) {
					$path		= dir_public."/upload/scd/".$pid."/".$row['ICD_YEAR'];
					$name	= $path."/".$row['ICD_SNAME'];
					$sname	= $path."/thumbnail/thumbnail_".$row['ICD_SNAME'];
		
					if(is_file($name)) @unlink($name);
					if(is_file($sname)) @unlink($sname);
				}
		
				$this -> deleteQuery(tbl_cms_icd_file, $where);
				$this -> commit();
			}
		}
		
		/**
		 * 사이트콘텐츠 첨부파일 삭제
		 */
		function fileDeleteType6($no, $pid, $did) {
			$where	= "WHERE icd_no = '".$no."' AND icd_pid = '".$pid."' AND icd_did = '".$did."'";
			$rsCnt		= $this -> selectQueryCount(tbl_cms_icd_file, $where);

			if($rsCnt > 0){
				$row		= $this -> selectQueryArray(tbl_cms_icd_file, $where, "", "", "");
				$path		= dir_public."/upload/scd/".$pid."/".$row['ICD_YEAR'];
					
				$name	= $path."/".$row['ICD_SNAME'];
				$sname	= $path."/thumbnail/thumbnail_".$row['ICD_SNAME'];
					
				if(is_file($name)) @unlink($name);
				if(is_file($sname)) @unlink($sname);
		
				$this -> deleteQuery(tbl_cms_icd_file, $where);
				$this -> commit();
			}
		}

		/**
		 * 첨부파일 삭제
		 */
		function fileDeleteType7($no) {
	 		$where	= "WHERE data_no = '".$no."'";
			$rsCnt		= $this -> selectQueryCount(tbl_achive_data, $where);					
			if($rsCnt > 0){
				$this -> begin();				
				$fileRs		= $this -> selectQuery(tbl_achive_data, $where, "", "", "");
				
				while($row = $this -> selectFetchArray($fileRs)) {
					$path	= dir_public."/upload/achive/".$row['DATA_FILEYEAR'];
					$name	= $path."/".$row['DATA_SFILENAME'];
					$sname	= $path."/thumbnail/thumbnail_".$row['DATA_SFILENAME'];
										
					if(is_file($name)) @unlink($name);
					if(is_file($sname)) @unlink($sname);

					$where	= "WHERE data_pno = '".$no."'";
					$rsCnt2	= $this -> selectQueryCount(tbl_achive_data_log, $where);				

					if($rsCnt2 > 0){

						$fileRs2 = $this -> selectQuery(tbl_achive_data, $where, "", "", "");					
						while($row2 = $this -> selectFetchArray($fileRs2)) {

							$path	= dir_public."/upload/achive/bak/".date("ymd",strtotime($row2['DATA_LOGDATE']));
							$name	= $path."/".$row2['DATA_SFILENAME'];
							$sname	= $path."/thumbnail/thumbnail_".$row2['DATA_SFILENAME'];
												
							if(is_file($name)) @unlink($name);
							if(is_file($sname)) @unlink($sname);

						}

					}
				}

				$this -> deleteQuery(tbl_achive_data, $where);
				$this -> commit();
			}
		}
		
		/**
		 * 첨부파일 삭제
		 */
		function fileDeleteTypeComm($path, $filename) {
			if(is_dir($path)){		
				$name	= $path."/".$filename;
				$sname	= $path."/thumbnail/thumbnail_".$filename;
				
				if(is_file($name)) @unlink($name);
				if(is_file($sname)) @unlink($sname);
			}
		}
		
	}
?>