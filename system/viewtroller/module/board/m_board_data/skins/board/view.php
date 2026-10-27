<?php
	require_once $dir2.'lang.haeder.php';
	require_once $dir2.'view.header.php';
	require_once $dir2.'lib.default.php';
?>

<!--★★★★★ Board start ★★★★★//-->
<div class="inner newBoard">

	<!-- Board View : S //-->
	<div class="newBoard__view">

		<!-- newBoard View 상단 : S //-->
		<div class="newBoard__view-header" data-aos="fade-up">
			<h3 class="newBoard__view-title">
			<?php if($board_data['BOARD_CATEGORY'] == "Y") { ?>
				<em class="cate"><?=$categoryName?></em>
			<?php }?>
			<?php echo $row['BRDATA_SUBJECT']?></h3>
			<p class="newBoard__view-info">
				<span class="newBoard__view-author"><em>작성자 </em><i><?php echo $row['BRDATA_NAME']?></i></span>
				<span class="newBoard__view-date"><em>등록일 </em><i><?php echo date("Y. m. d", strtotime($row['BRDATA_REGDATE']))?></i></span>
				<span class="newBoard__view-click"><em>조회수 </em><i><?php echo $row['BRDATA_HIT']?></i></span>
			</p>
		</div>
		<!--// newBoard View 상단 : E -->
		<!-- newBoard View 내용 : S //-->
		<div class="newBoard__view-contents" data-aos="fade-up">
			<div class="newBoard__view-contentsbox">
				<!-- Editor 내용 : S-->

				<?php
					echo $view_img;
					if($row['BRDATA_CONTENT'] != ""){
						echo $row['BRDATA_CONTENT'];
					}
				?>
				<!-- Editor 내용 : E-->
			</div>
			<?if($fcnt > 0) {?>
				<!-- 첨부파일 : S //-->
				<div class="newBoard__view-file" data-aos="fade-up">
					<?php echo $updList_new; ?>
					
				</div>
				<!--// 첨부파일 : E -->
			<?}?>


			</div>
			<!--// newBoard View 내용 : E -->
			<!-- newBoard View 하단 : S //-->
			<div class="newBoard__view-footer">
				<div class="inbox" data-aos="fade-in">
					<div class="newBoard__view-link prev <?=$prevnoData?>" data-aos="fade-left">
						<a href="<?=$prevLink?>" class="link" title="이전글">
							<span class="text">PREV</span>
							<span class="title"><?=$prevTitle?></span>
						</a>
					</div>
					<div class="newBoard__view-link next <?=$nextnoData?>" data-aos="fade-right">
						<a href="<?=$nextLink?>" class="link" title="다음글">
							<span class="text">NEXT</span>
							<span class="title"><?=$nextTitle?></span>
						</a>
					</div>
					<div class="newBoard__view-btn">
						<a href="sub.php?menukey=<?=$menukey?>&mod=list<?=$listVar?>" class="newBoard__view-list" title="목록보기">
							<span>목록보기</span>
							<span></span>
							<span></span>
						</a>
					</div>
				</div>
			</div>
			<!--// newBoard View 하단 : E -->

	</div>
	<!-- 버튼 : S //-->
	<div class="newBoard__btn" data-aos="fade-up">
		<div class="newBoard__btn-wrap">
			<?php
			require_once ($dir2."lib.btn_new2021.php");
			?>
		</div>
	</div>
	<!--// 버튼 : E -->
	

	<?php

		if(isset($board_data['BOARD_COMMENT']) && $board_data['BOARD_COMMENT'] == "Y") {
			require_once ($dir2.'view.comment.php');
		}
		require_once $dir2.'view.hit.php';

		if($board_data['BOARD_OTO'] == "Y") {
			require_once ($dir2.'view.answer.php');
		}
	?>

</div>

