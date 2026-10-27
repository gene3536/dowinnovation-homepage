<?php
	require_once $dir2."list.header.php";
	require_once $dir2."lang.haeder.php";
?>
<!--★★★★★ Board start ★★★★★//-->
	<div class="board-wrap newBoard inner">


		<?php if(!empty($board_data['BOARD_HEADER'])) { echo $board_data['BOARD_HEADER']; } ?>

			<!-- List 상단 : S //-->
			<div class="board-top" data-aos="fade-up">
				<div class="board-search">
					<?php echo $coreClass -> searchBoxType2021($menukey, $mod, $scode, $search, $kwd, $cate, $code1, $code2); ?>
				</div>
				<div class="board-count">
					<div class="text-total">
						<p>Total : </p><p><?php echo $paging['total_record']?></p>
					</div>
					<div class="text-page">
						<p>page : </p><p><span><?=$page?></span> / <?php echo $paging['realendofpage']?></p>
					</div>
				</div>
			</div>
			<!--// List 상단 : E -->
		
		<!-- 리스트 -->
		<form name="listForm" id="listForm" method="post" action="sub.php" onsubmit="return listDelCheck(this);">
			<input type="hidden" name="menukey" value="<?php echo $menukey?>">
			<input type="hidden" name="mod" value="process">
			<input type="hidden" name="act" value="adelete">
			<input type="hidden" name="token" value="<?php echo site_config_token?>" />
			<!-- List : S //-->
			<div class="newBoard__gallery" data-aos="fade-up">
				<ul class="newBoard__gallery-list vod">
								
					<?php if($paging_result < 1) { ?>
						<li class="newBoard__gallery-item nodata">
							<?=$bd_lang_none?>
						</li>
					<?php
						} else {
						// 공지글 목록
						while($row = $coreClass -> selectFetchArray($noticeRs)) {
							$notice_date = strtotime(date("Y-m-d"));
							if((!strtotime($row['BRDATA_SDATE']) && !strtotime($row['BRDATA_EDATE'])) || (strtotime($row['BRDATA_SDATE']) <= $notice_date && strtotime($row['BRDATA_EDATE']) >= $notice_date)) {	
								require $dir2."lib.default.php";
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
									}else{
										if($row['BRDATA_FLD1'] ==''){ 
											$imgPath= "images/board/no_image.jpg";
										}else{ 
											$imgPath = "https://img.youtube.com/vi/".$row['BRDATA_FLD1']."/0.jpg";
										}
									}
								?>
								<li class="newBoard__gallery-item">
									<a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>" class="newBoard__gallery-link <?=$newclass?> <?=$secretclass?> notice">
										<p class="thumb"><span style="background-image: url('<?php echo $imgPath?>');"><img src="images/common/board/img_blank01.png" alt="<?=$row['BRDATA_SUBJECT']?>"></span></p>
										<h3 class="tit js-dot" title="제목">
											<?if($category_is == "Y") {?>
												<em class="cate"><?php echo $category?></em>
											<?}?>
											<?php echo $row['BRDATA_SUBJECT']?>
										</h3>
									</a>
									<p class="board-info">
										<span class="writer" title="작성자"><?=$row['BRDATA_NAME']?></span>
										<span class="date" title="등록일"><?php echo date("Y. m. d",strtotime($row['BRDATA_REGDATE']))?></span>
										<span class="view" title="조회수"><?php echo $row['BRDATA_HIT']?></span>
									</p>
									<?php if(S_mb_level <= bbs_config_level) { ?><p class="admin-check"><input type="checkbox" name="seq[]" value="<?php echo $row['BRDATA_NO']?>" class="delNo"></p><?php } ?>
								</li>
									<?
							}
						}

							$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
							while($row = $coreClass -> selectFetchArray($boardRs)) {
								require $dir2."lib.default.php";
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
					<li class="newBoard__gallery-item">
						<a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>" class="newBoard__gallery-link <?=$newclass?> <?=$secretclass?> <?=$reClass?>">
							<p class="thumb"><span style="background-image: url('<?php echo $imgPath?>');"><img src="images/common/board/img_blank01.png" alt="<?=$row['BRDATA_SUBJECT']?>"></span></p>
							<h3 class="tit js-dot" title="제목">
								<?if($category_is == "Y") {?>
									<em class="cate"><?php echo $category?></em>
								<?}?>
								<?php echo $row['BRDATA_SUBJECT']?>
							</h3>
						</a>
						<p class="board-info">
							<span class="writer" title="작성자"><?=$row['BRDATA_NAME']?></span>
							<span class="date" title="등록일"><?php echo date("Y. m. d",strtotime($row['BRDATA_REGDATE']))?></span>
							<span class="view" title="조회수"><?php echo $row['BRDATA_HIT']?></span>
						</p>
						<?php if(S_mb_level <= bbs_config_level) { ?><p class="admin-check"><input type="checkbox" name="seq[]" value="<?php echo $row['BRDATA_NO']?>" class="delNo"></p><?php } ?>
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
					

					<li class="newBoard__gallery-item">
						<a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>" class="newBoard__gallery-link <?=$newclass?> <?=$secretclass?> <?=$reClass?>">
							<p class="thumb"><span style="background-image: url('<?php if($row['BRDATA_FLD1'] ==''){ echo "images/board/no_image.jpg";}else{ echo "https://img.youtube.com/vi/".$row['BRDATA_FLD1']."/0.jpg"; }?>');"><img src="images/common/board/img_blank01.png" alt="<?=$row['BRDATA_SUBJECT']?>"></span></p>
							<h3 class="tit js-dot" title="제목">
								<?if($category_is == "Y") {?>
									<em class="cate"><?php echo $category?></em>
								<?}?>
								<?php echo $row['BRDATA_SUBJECT']?>
							</h3>
						</a>
						<p class="board-info">
							<span class="writer" title="작성자"><?=$row['BRDATA_NAME']?></span>
							<span class="date" title="등록일"><?php echo date("Y. m. d",strtotime($row['BRDATA_REGDATE']))?></span>
							<span class="view" title="조회수"><?php echo $row['BRDATA_HIT']?></span>
						</p>
						<?php if(S_mb_level <= bbs_config_level) { ?><p class="admin-check"><input type="checkbox" name="seq[]" value="<?php echo $row['BRDATA_NO']?>" class="delNo"></p><?php } ?>
					</li>
					<?php
								}//if
								$num--;
							}
						}
					?>
				</ul>
			</div>
			<!-- //갤러리 게시판// -->
			<!-- Pagination : S //-->
			<?php
			echo $coreClass -> pagingUi(6, $paging, $menukey, $mod, $page, $search, $kwd, $cate, "", "", $scode, $codes);
			?>
			<!--// Pagination : E -->
			<!-- 버튼 : S //-->
			<div class="newBoard__btn" data-aos="fade-up">
				<div class="newBoard__btn-wrap">
					<?php
					require_once ($dir2."lib.btn_new2021.php");
					?>
				</div>
			</div>
			<!--// 버튼 : E -->
		</form>
	</div>