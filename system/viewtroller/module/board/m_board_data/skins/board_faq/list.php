<?php
	/** 게시글 목록 - 140617 */
	require_once $dir2."list.header.php";
?>

	<form name="listForm" id="listForm" method="post" action="sub.php" onsubmit="return listDelCheck(this);">
	<input type="hidden" name="menukey" value="<?php echo $menukey?>">
	<input type="hidden" name="mod" value="process">
	<input type="hidden" name="act" value="adelete">
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />

	<div class="board_w">
		<?php if(!empty($board_data['BOARD_HEADER'])) { echo $board_data['BOARD_HEADER']; } ?>
		<!-- 리스트 -->
		<div class="sb_list">
			<ul class="faq">
				<?php
					if(!$paging["total_record"]) {
						if($board_data['BOARD_OTO'] == "Y") {
							$listMsg = '비공개 게시판이므로 본인이 작성한 글만 열람하실 수 있습니다.';
						} else {
							$listMsg = '게시물이 없습니다.';
						}
						if(S_mb_login == true && S_mb_level < site_config_glevel) {												
							$listData .= '<li class="none">게시물이 없습니다.</li>	';
						} else {
							$listData .= '<li class="none">'.$listMsg.'</li>';
						}
					} else {
						// 공지글 목록
						$thisCnt = 0;
						while($row = $coreClass -> selectFetchArray($noticeRs)) {
							$notice_date = strtotime(date("Y-m-d"));
							if((!strtotime($row['BRDATA_SDATE']) && !strtotime($row['BRDATA_EDATE'])) || (strtotime($row['BRDATA_SDATE']) <= $notice_date && strtotime($row['BRDATA_EDATE']) >= $notice_date)) {				
								require $dir2."lib.default.php";
								$listData .= '<li><p class="faq_q">[공지]';
								if(S_mb_level <= bbs_config_level) { $listData .= "<input type=\"checkbox\" name=\"seq[]\" value=\"".$row['BRDATA_NO']."\" class=\"delNo\">&nbsp;"; }
								
								if($category_is == "Y") {
									$listData .= '[';
									if( $row['BRDATA_CATEGORY'] != "" and $row['BRDATA_CATEGORY'] == true) {
										$listData .= $coreClass -> getCatid2Name($row['BRDATA_CATEGORY'], $bid);
									} else {
										$listData .= "일반";
									}
									$listData .= ']';
								}
								if($board_data['BOARD_LV_MANAGE']>=S_mb_level || site_config_level>=S_mb_level){
									require $dir2."list.subject.php";
								}else{
									$listData .= "<a href=\"#question\">".$row['BRDATA_SUBJECT']."</a>";
								}
								$listData .= '</p>';
								$listData .= '
									<div class="faq_a" style="display:none;">
										<div class="icon">';
								if(!empty($row['BRDATA_CONTENT'])){
									echo $row['BRDATA_CONTENT'];
								}
								
								$listData .= '
										</div>
									</div>
								</li>';
								$no--;
								$thisCnt++;
							}
						}
				
						// 일반글 목록		
						$no = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord']; $thisCnt = 0;
						while($row = $coreClass -> selectFetchArray($boardRs)) {
							require $dir2."lib.default.php";
							$listData .= '<li><p class="faq_q">';
							if(S_mb_level <= bbs_config_level) { $listData .= "<input type=\"checkbox\" name=\"seq[]\" value=\"".$row['BRDATA_NO']."\" class=\"delNo\">&nbsp;"; }
							if($category_is == "Y") {
								$listData .= '[';
								if( $row['BRDATA_CATEGORY'] != "" and $row['BRDATA_CATEGORY'] == true) {
									$listData .= $coreClass -> getCatid2Name($row['BRDATA_CATEGORY'], $bid);
								} else {
									$listData .= "일반";
								}
								$listData .= ']';
							}
							if($board_data['BOARD_LV_MANAGE']>=S_mb_level || site_config_level>=S_mb_level){
								require $dir2."list.subject.php";	
							}else{
								$listData .= "<a href=\"#question\">".$row['BRDATA_SUBJECT']."</a>";
							}
							//require $dir2."list.subject.php";
							$listData .= '</p>';
							$thisClass = ($thisCnt>0)? "style='display:none;'" : "";
							$listData .= '
								<div class="faq_a" '.$thisClass.'>
									<div class="icon">';
							if(!empty($row['BRDATA_CONTENT'])){
								$listData .= $row['BRDATA_CONTENT'];
							}
							
							$listData .= '
									</div>
								</div>
							</li>';
							$no--;
							$thisCnt++;
						}
					}
					echo $listData;
				?>
			</ul>
		</div>
		<!-- //리스트// -->

		<?php
			require_once ($dir2."lib.btn.php");
			echo $coreClass -> pagingUi(4, $paging, $menukey, $mod, $page, $search, $kwd, $cate, "", "", $scode, $codes);
			if(!empty($board_data['BOARD_FOOTER'])) {
				echo '<div class="board_note"><div class="noteIn">'.$board_data['BOARD_FOOTER'].'</div></div>';
			}
		?>
	</div>

	</form>

<script type="text/javascript">
$(document).ready(function(){
	$(".faq_q").on("click","a",function(e){ 
		e.preventDefault();
		obj = $(this); 
		if(obj.attr("href") == "#question"){
			$(".faq_a").hide(100);
			obj.parent().parent().find(".faq_a").show(150);
		}else{
			$(location).attr("href",obj.attr("href"));
		}
	});
});
</script>