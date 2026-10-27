				<?php 
				$locateArr = $menuClass->getRefMenu($menukey,2); //echo "<pre>"; var_dump($locateArr); echo "</pre>";
				for($i=1; $i<=count($locateArr); $i++){ 
					$subLink2    = $menuClass->get_menu_link($locateArr[$i][0]);
				?>
					<li>
					<?php if($locateArr[$i][0]['MENU_DEPTH']>=2){ ?>
						<a href="#" class="item" id="sub_list"><?=$locateArr[$i][0]['MENU_TITLE']?></a>
						<ul class="breadcrumb_submu">
						<?php
						foreach($menuClass->submenuArr[2] as $subVar2){ 
							if($subVar2['MENU_VISIBLE'] == "Y"){
								$onoffClass = ($subVar2['MENU_MENUKEY'] == $menuClass->subPArray[2][0]['MENU_MENUKEY'])? " class='active'" : "";
								$subLink2    = $menuClass->get_menu_link($subVar2);
								$menu2Dep    = $subVar2['MENU_MENUKEY'];
						?>
							<li<?php echo $onoffClass?>><a href="<?=$subLink2['href']?>" target="<?=$subLink2['target']?>" title="<?=$subVar2['MENU_TITLE']?>"><?=$subVar2['MENU_TITLE']?></a></li>
						<?php 
							}
						}
						?>							
						</ul>
					<?php }else{ ?>
						<a href="<?=$subLink2['href']?>" target="<?=$subLink2['target']?>" class="item"><?=$locateArr[$i][0]['MENU_TITLE']?></a>
					<?php }	?>
					</li>
				<?php }	?>