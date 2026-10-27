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

			<!-- 갤러리 게시판 -->
			
			<div class="newBoard__certificate" data-aos="fade-up">

				<ul class="newBoard__certificate-list">

				<?php if($paging_result < 1) { ?>
					<li class="newBoard__certificate-item nodata"><!-- 게시글이 없을 경우  nodata 클래스 추가 -->
								<?=$bd_lang_none?>
					</li>
				<?php
					} else {
						$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord']; $i = 0;
						while($row = $coreClass -> selectFetchArray($boardRs)) {
							$onclickStr = "";

							$fWhere = "WHERE brdfile_did = '".$row['BRDATA_ID']."' AND brdfile_bid = '".$row['BRDATA_BID']."'"; 
							$resultChk = $coreClass -> selectQueryCount(tbl_board_file, $fWhere);
							
							if($row['BRDATA_THUMBNAIL'] != "" ){ 
								

								$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$row['BRDATA_THUMBYEAR']."/thumbnail/thumbnail_".$row['BRDATA_THUMBNAIL'];
								$img_path1 = "/upload/bbs/".$row['BRDATA_BID']."/".$row['BRDATA_THUMBYEAR']."/thumbnail/thumbnail_".$row['BRDATA_THUMBNAIL']; 
								$imgPath = "";
								
								if(is_file($filepath1)) { 
									$imgPath = $img_path1; 
								} else{ 
									$imgPath = "/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME']; 
								}

								$fileRow	= $coreClass -> selectQueryArray(tbl_board_file, $fWhere, "ORDER BY brdfile_no DESC", 0, 1);									
								$file_arr		= explode(".", $fileRow['BRDFILE_SNAME']);
								$ext			= strtolower($file_arr[1]);

								if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png") {
									$filepath2	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
									$filepath3	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
									$img_path2 = "/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
									$imgPath2 = "";
									
									if(is_file($filepath2) || is_file($filepath3)) {
										$imgPath2 = $img_path2;
									} 
								}

								$onclickStr = "onclick=\"layer_open('img".$row['BRDATA_NO']."'); return false;\"";
				?>
				<li class="newBoard__certificate-item">
					<a href="<?php echo $imgPath2?>" data-lightbox="certi-set" data-title="<?php echo $row['BRDATA_SUBJECT']?>" class="zoom-link">
						<p class="thumb">
							<span style="background-image:url('<?php echo $imgPath2?>');"><img src="images/common/board/img_blank02.png" alt="인증서명"></span>
						</p>
					</a>
					<p class="title js-dot">
						<a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>">
						<?=$row['BRDATA_SUBJECT']?>
						</a>
					</p>

					<?php if(S_mb_level <= bbs_config_level) { ?>
							<p class="admin-check"><input type="checkbox" name="seq[]" value="<?=$row['BRDATA_NO']?>" class="delNo"/></p><!-- 관리자 로그인 시 checkbox-->
						<?}?>
					
				</li>
				<?php
							}else{  
								
								if($resultChk > 0 ) { 
									
									$fileRow		= $coreClass -> selectQueryArray(tbl_board_file, $fWhere, "ORDER BY brdfile_no DESC", 0, 1);
									$file_arr		= explode(".", $fileRow['BRDFILE_SNAME']);
									$ext			= strtolower($file_arr[1]);

									if($ext == "gif" || $ext == "jpg" || $ext == "jpeg" || $ext == "bmp" || $ext == "png") {
										$filepath1	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
										$filepath2	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
										$img_path1 = "/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME']; 
										$imgPath = ""; 
										
										if(is_file($filepath1) || is_file($filepath2)) { 
											$imgPath = $img_path1;
										} 

										$filepath2	= dir_public."/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
										$filepath3	= mb_convert_encoding($filepath1, "EUC-KR", "UTF-8");
										$img_path2 = "/upload/bbs/".$row['BRDATA_BID']."/".$fileRow['BRDFILE_YEAR']."/".$fileRow['BRDFILE_SNAME'];
										$imgPath2 = "";
										
										if(is_file($filepath2) || is_file($filepath3)) {
											$imgPath2 = $img_path2;
										} 
									}
									$delis = "";
									if($row['BRDATA_DELETED'] == "Y") {
										$delis = "[삭제]";
									}
																
									$onclickStr = "onclick=\"layer_open('img".$row['BRDATA_NO']."'); return false;\"";
								}else{
									
									$imgPath = "images/board/sc52_video.gif";
									$onclickStr = "onclick=\"alert('이미지 준비중입니다.'); return false;\"";
								}
								if($imgPath2==''){
									$imgPath2='images/board/no_image_cert.jpg';
								}
				?>
				<li class="newBoard__certificate-item">
					<!--dt><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><img src="<?php echo $imgPath?>" alt="<?php echo $row['BRDATA_SUBJECT']?>"></a></dt-->
					<p class="gallery__board-thumb"><a href="<?php echo $imgPath2?>" data-lightbox="performance-set1" data-title="<?php echo $row['BRDATA_SUBJECT']?>"><img src="images/board/no_image_cert.jpg" alt="No image"></a></p>
					<p class="gallery__board-title"><?php if(S_mb_level <= bbs_config_level) { ?><input type="checkbox" name="seq[]" value="<?php echo $row['BRDATA_NO']?>" class="delNo">&nbsp;<?php } ?><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><?php echo $coreClass -> getSub2Str($board_data['BOARD_SUBJECT_LEN'], $row['BRDATA_SUBJECT']).$delis?></a></p>
				</li>
				<?php

							}//if

							$i++;
							$num--;
						}
					}
				?>
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



