 
								<div class="sc11" style="overflow:hidden">
									<div class="sm_box fw_b">
										<?php echo site_config_title?> 홈페이지의 모든 메뉴를 상세하게 제공하고 있습니다. <br>자주 찾으시는 메뉴는 북마크를 이용하시기 바랍니다.
									</div>

									<?php 
									$i=1; 
									foreach($menuClass->sitemenuArr[1] as $var1){
										if($var1['MENU_VISIBLE'] == "Y"){
											$menuLink1 = $menuClass->get_menu_link($var1);
											$menu1Dep  = $var1['MENU_MENUKEY'];
									?>

									<div class="sm_w">
										<h3 class="sm_tit"><?php echo $var1['MENU_TITLE']?></h3>
										<ul class="sitemap_ul1">
										<?php 									
										foreach($menuClass->sitemenuArr[2] as $var2){
											//if($menu1Dep == $var2['MENU_REF'] && $var2['MENU_VISIBLE'] == "Y"){
											if($menu1Dep == $var2['MENU_REF'] && $var2['MENU_ACCESS'] == "Y"){
												$menuLink2 = $menuClass->get_menu_link($var2);
												$menu2Dep  = $var2['MENU_MENUKEY'];
										?>
											<li><a href="<?=$menuLink2['href']?>" target="<?=$menuLink2['target']?>" title="<?=$var2['MENU_TITLE']?>"><?php echo $var2['MENU_TITLE']; ?></a>

																								
												<?php $menu3IDX = 0; 										
												foreach($menuClass->sitemenuArr[3] as $var3){													
													if($menu2Dep == $var3['MENU_REF'] && $var3['MENU_VISIBLE'] == "Y"){
														if($menu3IDX == 0) echo '<ul class="sitemap_ul2">';
														$menuLink3 = $menuClass->get_menu_link($var3);
														$menu3Dep  = $var3['MENU_MENUKEY'];
												?>
													<li><a href="<?=$menuLink2['href']?>" target="<?=$menuLink2['target']?>" title="<?=$var2['MENU_TITLE']?>"><?php echo $var3['MENU_TITLE']; ?></a>

														
														<?php $menu4IDX = 0; 										
														foreach($menuClass->sitemenuArr[4] as $var4){
															if($menu3Dep == $var4['MENU_REF'] && $var4['MENU_VISIBLE'] == "Y"){
																if($menu4IDX == 0) echo '<ul class="sitemap_ul3">';
																$menuLink4 = $menuClass->get_menu_link($var4);
																$menu4Dep  = $var4['MENU_MENUKEY'];
														?>
															<li><a href="<?=$menuLink4['href']?>" target="<?=$menuLink4['target']?>" title="<?=$var4['MENU_TITLE']?>"><?php echo $var4['MENU_TITLE']; ?></a>

																<!-- <?php $menu5IDX = 0; 									
																foreach($menuClass->sitemenuArr[5] as $var5){
																	if($menu4Dep == $var5['MENU_REF'] && $var5['MENU_VISIBLE'] == "Y"){
																		if($menu5IDX == 0) echo '<ul class="sitemap_ul5">';
																		$menuLink5 = $menuClass->get_menu_link($var5);
																?>
																	<li><a href="<?=$menuLink5['href']?>" target="<?=$menuLink5['target']?>" title="<?=$var5['MENU_TITLE']?>"><?php echo $var5['MENU_TITLE']; ?></a></li>
																<?php	
																		$menu5IDX ++;
																	}
																} //end while
																if($menu5IDX >0) echo '</ul>';
																?> -->
																
															</li>

														<?php  
																$menu4IDX ++;
															}
														} //end while 
														if($menu4IDX >0) echo '</ul>';
														?>
													</li>
													

												<?php  
														$menu3IDX ++;
													}
												}  //end while
												if($menu3IDX >0) echo '</ul>';
												?>
												

											</li>
										<?php 
											}
										} //end while 
										?>
										</ul>
									</div>

									<?php if($i == 2 || $i == 4){ ?>
									<div class="sm_clear_m"></div>
									<?php }else if($i == 3){ ?>
									<div class="sm_clear_t"></div>
									<?php } ?>

									<?php 
										} 
										$i++;
									}
									?>

								</div> 