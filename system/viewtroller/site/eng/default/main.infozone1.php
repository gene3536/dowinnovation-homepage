				<?php
				$where	= "WHERE icd_type = '1' AND icd_sdate <= '".date("Y-m-d H:i:s")."' AND icd_edate >= '".date("Y-m-d H:i:s")."' AND icd_visible = 'Y' AND (icd_scode = '00000000' OR icd_scode = '00000002')";		
				$order	= "ORDER BY icd_regdate DESC";
				$rs		= $coreClass -> selectQuery(tbl_cms_icd, $where, $order, "", "");
				$rsCnt	= $coreClass -> selectQueryCount(tbl_cms_icd, $where, $order, "", "");	
				?>
                <div id="popupzone">
					<p class="pop_ctrl"><span class="pop_count"><span class="count">1</span>/<?php echo $rsCnt?></span>
						<a href="#none" class="pop_btn_Prev"><img src='images/main/btn_prev.png' alt='이전 팝업' /></a>
						<a href="#none" class="pop_btn_Play"><img src='images/main/btn_stop.png' alt='팝업 롤링 정지' /></a>
						<a href="#none" class="pop_btn_Next"><img src='images/main/btn_next.png' alt='다음 팝업' /></a>
					</p>
					<div class="pop_area">
						<ul class="pop_list">							
							<?php 
							if($rsCnt > 0){
								while($row = $coreClass -> selectFetchArray($rs)) { 
							?>
							<li>
								<? if($row['ICD_URL'] == ""){?>
									<a href="#"><img src="/upload/icd/00000003/<?php echo $row['ICD_FILEYEAR']?>/<?php echo $row['ICD_SFILENAME']?>" alt="<?php echo $row['ICD_TITLE']?>" /></a>												
								<?} else{ ?>
									<a href="<?php echo $row['ICD_URL']?>" target="<?php echo $row['ICD_TARGET']?>"><img src="/upload/icd/00000003/<?php echo $row['ICD_FILEYEAR']?>/<?php echo $row['ICD_SFILENAME']?>" alt="<?php echo $row['ICD_TITLE']?>" /></a>
								<? } ?>
							</li>
							<?php 
								}
							}else{
							?>	
							<li><img src="images/main/main1.jpg" alt="" /></li>
							<?php } ?>
						</ul>
					</div>
				</div>