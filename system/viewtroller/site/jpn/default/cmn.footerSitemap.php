	<div id="sitemap">
		<div class="inner">
			<div class="s_gnb">
				<?php 
				$i=1; unset($siteMnArr);
				$siteMnArr = $menuClass->getMenuArray();
				foreach($siteMnArr[1] as $var1){
					if($var1['MENU_VISIBLE'] == "Y"){
						$menuLink1 = $menuClass->get_menu_link($var1);
						$menu1Dep  = $var1['MENU_MENUKEY'];
						$openImg1  = ($var1['MENU_TYPE'] == 5)?'<img src="images/content/new_icon_off.png" alt="새창" class="_onoff align_m ml_8">':"";
						$menuTitle1= ($var1['MENU_TYPE'] == 5)? "새창에서 열림" : $var1['MENU_TITLE'];
						$lastClass = (count($siteMnArr[1]) == $i)? " class='last'" : "";
				?>
					<div<?php echo $lastClass?>><h2><a href="<?=$menuLink1['href']?>" target="<?=$menuLink1['target']?>" title="<?=$menuTitle1?>" class="menu1stPC" id="menuPC<?=$i?>"><?php echo $var1['MENU_TITLE']; ?><?php echo $openImg1?></h2></a>
						<ul>
							<?									
							foreach($siteMnArr[2] as $var2){
								if($menu1Dep == $var2['MENU_REF'] && $var2['MENU_VISIBLE'] == "Y"){
									$menuLink2 = $menuClass->get_menu_link($var2);
									$openImg2  = ($var2['MENU_TYPE'] == 5)?'<img src="images/content/new_icon_off.png" alt="새창" class="_onoff align_m ml_8">':"";
							?>
							<li><a href="<?=$menuLink2['href']?>" target="<?=$menuLink2['target']?>" title="<?=$var2['MENU_TITLE']?>"><?php echo $var2['MENU_TITLE']; ?><?php echo $openImg2?></a></li>
							<? 
								}
							} 
							?>
						</ul>
					</div>
				<?
					} 
					$i++;
				}
				?>	
			</div>
		</div>
	</div>

