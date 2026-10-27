<?php
	require_once $dir2."lang.haeder.php";
	require_once $dir2."list.header.php";
?>
	
	<div class="board_w">
		<?php if(!empty($board_data['BOARD_HEADER'])) { echo $board_data['BOARD_HEADER']; } ?>
		<div class="board_top_w">
			<!-- 검색 -->
			<div class="sb_search">
				<?php echo $coreClass -> searchBoxType6($menukey, $mod, $scode, $search, $kwd, $cate, $code1, $code2); ?>
			</div>
			<!-- //검색// -->
			<p class="text">Total : <span><?php echo $paging['total_record']?></span>&nbsp;&nbsp;&nbsp;&nbsp;Page : <span><?php echo $page?>/<?php echo $paging['realendofpage']?></span></p>
		</div>

		<form name="listForm" id="listForm" method="post" action="sub.php" onsubmit="return listDelCheck(this);">
		<input type="hidden" name="menukey" value="<?php echo $menukey?>">
		<input type="hidden" name="mod" value="process">
		<input type="hidden" name="act" value="adelete">
		<input type="hidden" name="token" value="<?php echo site_config_token?>" />

		<!-- 갤러리 게시판 -->
		<div class="sb_gall">
			<div class="sp_table">
				<?php if($paging_result < 1) { ?>
					<div class="t_c" style="text-align:center; padding:50px 0px; font-size:14px; color:#666;"><?php echo $bd_lang_none;?></div>
				<?php
					} else {
						$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
						while($row = $coreClass -> selectFetchArray($boardRs)) {
							$category = ""; 
							if($board_data['BOARD_CATEGORY'] == "Y"){
								$cWhere	= "WHERE brdcat_id = '".$row['BRDATA_CATEGORY']."'"; 
								$cateRs	= $coreClass -> selectQueryArray(tbl_board_category, $cWhere, "", "", "");
								if($cateRs != null) $category = '<span style="color:blue;">['.$cateRs['BRDCAT_NAME'].']</span> '; 
							}

							if($row['BRDATA_THUMBNAIL'] != ""){

								$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$row['BRDATA_THUMBYEAR']."/thumbnail/thumbnail_".$row['BRDATA_THUMBNAIL'];
								$img_path1 = "/upload/bbs/".$row['BRDATA_BID']."/".$row['BRDATA_THUMBYEAR']."/thumbnail/thumbnail_".$row['BRDATA_THUMBNAIL'];
								$imgPath = "";
								
								if(is_file($filepath1)) {
									$imgPath = $img_path1;
								} 
				?>
				<dl>
					<dt><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><img src="<?php echo $imgPath?>" alt="<?php echo $row['BRDATA_SUBJECT']?>"></a></dt>
					<dd><?php if(S_mb_level <= bbs_config_level) { ?><input type="checkbox" name="seq[]" value="<?php echo $row['BRDATA_NO']?>" class="delNo">&nbsp;<?php } ?><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><?php echo $category.$coreClass -> getSub2Str($board_data['BOARD_SUBJECT_LEN'], $row['BRDATA_SUBJECT']).$delis?></a></dd>
				</dl>
				<?php
							}else{ 

								$fWhere = "WHERE brdfile_did = '".$row['BRDATA_ID']."' AND brdfile_bid = '".$row['BRDATA_BID']."'"; 
								$resultChk = $coreClass -> selectQueryCount(tbl_board_file, $fWhere);
								if($resultChk > 0 ) {
									$fileRow		= $coreClass -> selectQueryArray(tbl_board_file, $fWhere, "ORDER BY brdfile_no DESC", 0, 1);
									$file_arr		= explode(".", $fileRow['BRDFILE_SNAME']);
									$ext			= strtolower($file_arr[1]);

									if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png") {
										$filepath1	= dir_public."/upload/bbs/".$fileRow['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/thumbnail/_thumbnail_".$fileRow['BRDFILE_SNAME'];
										$filepath2	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
										$img_path1 = "/upload/bbs/".$fileRow['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/thumbnail/thumbnail_".$fileRow['BRDFILE_SNAME'];
										$imgPath = "";
										
										if(is_file($filepath1) || is_file($filepath2)) {
											$imgPath = $img_path1;
										} 
									}
									$delis = "";
									if($row['BRDATA_DELETED'] == "Y") {
										$delis = "[삭제]";
									}
								}else{
									$imgPath = "images/board/sc52_video.gif";
								}
				?>
				<dl>
					<dt><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><img src="<?php echo $imgPath?>" alt="<?php echo $row['BRDATA_SUBJECT']?>"></a></dt>
					<dd><?php if(S_mb_level <= bbs_config_level) { ?><input type="checkbox" name="seq[]" value="<?php echo $row['BRDATA_NO']?>" class="delNo">&nbsp;<?php } ?><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><?php echo $category.$coreClass -> getSub2Str($board_data['BOARD_SUBJECT_LEN'], $row['BRDATA_SUBJECT']).$delis?></a></dd>
				</dl>
				<?php

							}//if
							$num--;
						}
					}
				?>
			</div>
		</div>
		<!-- //갤러리 게시판// -->
				
		<?php
			require_once ($dir2."lib.btn.php");
			echo $coreClass -> pagingUi(4, $paging, $menukey, $mod, $page, $search, $kwd, $cate, "", "", $scode, $codes);
			if(!empty($board_data['BOARD_FOOTER'])) {
				echo '<div class="board_note"><div class="noteIn">'.$board_data['BOARD_FOOTER'].'</div></div>';
			}
		?>

		</form>

	</div>



