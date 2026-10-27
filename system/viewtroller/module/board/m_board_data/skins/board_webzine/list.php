<?php
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

		<!-- 리스트 -->

		<div class="sb_list">
			<ul class="web_zine_w">
			<?php if($paging_result < 1) { ?>
				<li class="t_c none">등록된 내용이 없습니다.</li>
			<?php
				} else {
					$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
					while($row = $coreClass -> selectFetchArray($boardRs)) {

						if($row['BRDATA_THUMBNAIL'] != ""){

							$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$row['BRDATA_THUMBYEAR']."/thumbnail/thumbnail_".$row['BRDATA_THUMBNAIL'];
							$img_path1 = "/upload/bbs/".$row['BRDATA_BID']."/".$row['BRDATA_THUMBYEAR']."/thumbnail/thumbnail_".$row['BRDATA_THUMBNAIL'];
							$imgPath = "";
							
							if(is_file($filepath1)) {
								$imgPath = $img_path1;
							}

			?>
				<li>
					<div class="video">
						<p class="wz_img"><img src="<?php echo $imgPath?>" alt="<?php echo $row['BRDATA_SUBJECT']?>"></p>
					</div>

					<dl>
						<dt><?php if(S_mb_level <= bbs_config_level) { ?><input type="checkbox" name="seq[]" value="<?php echo $row['BRDATA_NO']?>" class="delNo">&nbsp;<?php } ?><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><?php echo $coreClass -> getSub2Str($board_data['BOARD_SUBJECT_LEN'], $row['BRDATA_SUBJECT']).$delis?></a></dt>
						<dd class="con"><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><?php echo $coreClass -> getSub2Str(200, strip_tags($row['BRDATA_CONTENT'])).$delis?></a></dd>
					</dl>
				</li>
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
				<li>
					<div class="video">
						<p class="wz_img"><img alt="<?php echo $row['BRDATA_SUBJECT']?>" src="<?php echo $imgPath?>"></p>
					</div>

					<dl>
						<dt><?php if(S_mb_level <= bbs_config_level) { ?><input type="checkbox" name="seq[]" value="<?php echo $row['BRDATA_NO']?>" class="delNo">&nbsp;<?php } ?><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><?php echo $coreClass -> getSub2Str($board_data['BOARD_SUBJECT_LEN'], $row['BRDATA_SUBJECT']).$delis?></a></dt>
						<dd class="con"><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><?php echo $coreClass -> getSub2Str(200, strip_tags($row['BRDATA_CONTENT'])).$delis?></a></dd>
					</dl>
				</li>
			<?php

						}//if
						$num--;
					}
				}
			?>
			</ul>
		</div>

		<!-- //리스트// -->
				
		<!-- 버튼 -->
		<?php require_once ($dir2."lib.btn.php"); ?>
		<!-- //버튼// -->

		<!-- 페이지 -->
		<?php echo $coreClass -> pagingUi(4, $paging, $menukey, $mod, $page, $search, $kwd, $cate, "", "", $scode, $codes);	?>	
		<!-- //페이지// -->

		</form>
	</div>





