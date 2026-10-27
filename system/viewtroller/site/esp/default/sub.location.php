				<?php $subMenuArr = $menuClass->getLeftMenu(); ?>				
				
				<section id="visual">
					<div class="s_visual_w">
						<div class="title_w">
							<div class="sv_btn">
								<p class="sv_btn_logo"><img src="./images/sub/sv_btn_logo.png" alt="로고"></p>
								<p class="sv_btn_tit"><?= $subMenuArr[1][0]['MENU_TITLE'] ?></p>
							</div>
							<h3 class="sub_title"><?php echo $subMenu['MENU_TITLE']?></h3>
							<p class="suv_navi">Home
							<?php 
							$locateArr = $menuClass->getRefMenu($menukey,2);
							for($i=1; $i<=count($locateArr); $i++){ 
								$subLink2    = $menuClass->get_menu_link($locateArr[$i][0]);
								$addClass    = $i==count($locateArr)? " class=\"last\"" : "";
							?>
								<img src="./images/sub/sv_tit_arr.png" alt="" class="suv_navi_arr">
								<?if(count($locateArr) == $i){ ?>
								<?=$locateArr[$i][0]['MENU_TITLE']?>
								<?php }else{ ?>
								<span class="fc_333"><?=$locateArr[$i][0]['MENU_TITLE']?></span>
								<?php }	?>
								</a>
							<?php }	?>
							</p>
						</div>

						<div class="visual01"><span class="hiddenTxt">서브 비주얼</span></div>
					</div>
				</section>