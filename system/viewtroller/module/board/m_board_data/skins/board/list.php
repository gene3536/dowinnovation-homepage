<?php
	require_once $dir2."lang.haeder.php";
	require_once $dir2."list.header.php";
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
			<div class="newBoard__list" data-aos="fade-up">
				<ul class="board-list">
			<?php
				if(!$paging["total_record"]) {
					if($board_data['BOARD_OTO'] == "Y") {
							$listMsg = '비공개 게시판이므로 본인이 작성한 글만 열람하실 수 있습니다.';
						} else {
							$listMsg = $bd_lang_none;
						}
						if(S_mb_login == true && S_mb_level < site_config_glevel) {	?>		
							<li class="board-item nodata">
								<?php echo $bd_lang_none;?>
							</li>
						<?} else {?>
							<li class="board-item nodata">
								<?=$listMsg?>
							</li>
						<?}?>
					
				<?} else {
					// 공지글 목록
					while($row = $coreClass -> selectFetchArray($noticeRs)) {
						$notice_date = strtotime(date("Y-m-d"));
						if((!strtotime($row['BRDATA_SDATE']) && !strtotime($row['BRDATA_EDATE'])) || (strtotime($row['BRDATA_SDATE']) <= $notice_date && strtotime($row['BRDATA_EDATE']) >= $notice_date)) {	
							require $dir2."lib.default.php";
							require $dir2."list.subject.php";
							?>
							<li class="board-item">
								<?if(S_mb_level <= bbs_config_level) {?>
								<p class="admin-check"><input class="delNo" type="checkbox" name="seq[]" value="<?=$row['BRDATA_NO']?>" /></p><!-- 관리자 로그인 시 checkbox-->
								<?}?>
								<p class="num" title="번호"><img src="images/common/board/board-announcement.png" alt="공지" /></p>
								<a href="<?=$goLink?>" class="title <?=$newclass?> <?=$secretclass?> <?=$reClass?>" title="제목"><!-- 새글 :new , 비밀글  : lock, 답글 : reply 클래스 추가-->
									
									<span class="js-dot">
										<?if($category_is == "Y") {
											if( $row['BRDATA_CATEGORY'] != "" and $row['BRDATA_CATEGORY'] == true) {
												echo '<em class="cate">'.$coreClass -> getCatid2Name($row['BRDATA_CATEGORY'], $bid).'</em>';
											} else {
												echo "<em class='cate'>일반</em>";
											}
										}?>
										<?=$row['BRDATA_SUBJECT']?>
									</span>
								</a>
								<p class="board-info <?=$attachclass?>"><!-- 첨부파일이 있을 경우 attach 클래스 추가 -->
									<span class="writer" title="작성자"><?=$name?></span>
									<span class="date" title="등록일"><?=date("Y. m. d",strtotime($row['BRDATA_REGDATE']))?></span>
									<span class="view" title="조회수"><?=$hit?></span>
								</p>
							</li>
								<?
						}
					}
			
					// 일반글 목록		
					$no = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
					while($row = $coreClass -> selectFetchArray($boardRs)) {
						require $dir2."lib.default.php";
						require $dir2."list.subject.php";
						?>
						
						<li class="board-item">
							<?if(S_mb_level <= bbs_config_level) {?>
							<p class="admin-check"><input class="delNo" type="checkbox" name="seq[]" value="<?=$row['BRDATA_NO']?>" /></p><!-- 관리자 로그인 시 checkbox-->
							<?}?>
							<p class="num" title="번호"><?=$no?></p>
							<a href="<?=$goLink?>" class="title <?=$newclass?> <?=$secretclass?> <?=$reClass?>" title="제목" data-reply="reply"><!-- 새글 :new , 비밀글  : lock, 답글 : reply 클래스 추가-->
								<span class="js-dot">
									<?if($category_is == "Y") {
										if( $row['BRDATA_CATEGORY'] != "" and $row['BRDATA_CATEGORY'] == true) {
											echo '<em class="cate">'.$coreClass -> getCatid2Name($row['BRDATA_CATEGORY'], $bid).'</em>';
										} else {
											echo "<em class='cate'>일반</em>";
										}
									}?>
									<?=$row['BRDATA_SUBJECT']?>
								</span>
							</a>
							<p class="board-info <?=$attachclass?>"><!-- 첨부파일이 있을 경우 attach 클래스 추가 -->
								<span class="writer" title="작성자"><?=$name?></span>
								<span class="date" title="등록일"><?=date("Y. m. d",strtotime($row['BRDATA_REGDATE']))?></span>
								<span class="view" title="조회수"><?=$hit?></span>
							</p>
						</li>

					<?
					$no--;
					}
				}
			?>
		</div>
		<!-- //리스트// -->		
		
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

		<!-- //버튼 페이징// -->
	</div>

