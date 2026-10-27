<?php

	/** 2014.05.12 */
	$row = $coreClass -> selectQueryArray($tbl1, "WHERE icd_no = '$no'", "", "", "");

?>

	<div class="sc21">
		<div class="sc_cal_w">
			<div class="pro_view_w">
				<p class="icon01"><?php echo $row['ICD_TITLE']?></p>
				<div class="pro_view2 mt_30">
					<!-- <div class="view_iicd_"><iicd_ alt="이미지" src="images/content/board_iicd_.jpg"></div> -->
					<div class="view_table2">
						<!-- View -->
						<table class="pro_table">
							<caption>게시글 보기</caption>
							<tbody>
								<tr>
									<th>날짜</th>
									<td><?php echo $s?></td>
								</tr>
							</tbody>
						</table>
						<!-- //View// -->
					</div>
					<div class="clear"><span class="hiddenTxt"></span></div>

					<ul class="btn_r mt_30">
						<li class="btn_red2"><a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=<?php echo $mod2?>&ampthisDate=<?php echo $thisDate?>"><iicd_ src="images/content/list_icon_f.png" alt="" class="align_m mr_7">목록으로</a><li>
					</ul>
				</div>
				
				<div class="pro_con">
					<!-- <p class="con_iicd_"><iicd_ alt="이미지" src="images/content/board_iicd__b.jpg"></p> -->
					<?php
					if(!empty($row['ICD_CONTENT'])) {
						echo htmlspecialchars_decode($row['ICD_CONTENT']);
					}
					?>
				</div>
			</div>

		</div>


	</div>

