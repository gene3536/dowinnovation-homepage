
    <div id="gnb-wrapp">
		<h2 class="blind">전체메뉴</h2>
		<ul class="gnb1">
			<?php 
			$i=1; ## 1차메뉴
			foreach($menuClass->sitemenuArr[1] as $var1){
				if($var1['MENU_VISIBLE'] == "Y"){
					$menuLink1  = $menuClass->get_menu_link($var1);
					$onoffClass = ($var1['MENU_ROOT'] == $menuClass->subP['MENU_ROOT'])? "on" : "off";
					if($var1['MENU_TYPE'] == 5){
						$menuHref1   = $menuLink1['href'];
						$menuTarget1 = $menuLink1['target'];
						$menuTitle1  = "새창에서 열림";
					}else{
						$menuHref1   = "#menu2nd";
						$menuTarget1 = "_self";
						$menuTitle1  = "";
					}
			?>
			<li class="subdepth<?php echo $?>">
				<h3><a href="<?php echo $menuHref1?>" target="<?php echo $menuTarget1?>" title="<?php echo $menuTitle1?>"><?php echo $var1['MENU_TITLE']; ?></a></h3>
				<!-- 2차메뉴 -->	
					<?php $idx2 = 1;	 							
					foreach($menuClass->sitemenuArr[2] as $var2){
						if($var2['MENU_REF'] == $var1['MENU_MENUKEY'] && $var2['MENU_VISIBLE'] == "Y"){
							$menuLink2 = $menuClass->get_menu_link($var2);
							$onoffClass2 = ($var2['MENU_MENUKEY'] == $menuClass->subPArray[2][0]['MENU_MENUKEY'])? "on" : "off";
							if($idx2 == 1){
								echo "<ul class=\"depth2\"";
								//if($onoffClass2 == "off") echo " style='display:none;'";
								echo ">";
							}
					?>
					<li>
						<h4><a href="<?=$menuLink2['href']?>" target="<?=$menuLink2['target']?>" title="<?=$var2['MENU_TITLE']?>"><?php echo $var2['MENU_TITLE']; ?></a></h4>
						<!-- 3차메뉴 -->											
							<?php $idx3 = 1;							
							foreach($menuClass->sitemenuArr[3] as $var3){
								if($var3['MENU_REF'] == $var2['MENU_MENUKEY'] && $var3['MENU_VISIBLE'] == "Y"){	
									//if($idx3 == 1) echo "<ul class=\"sm_3d\">";
									$menuLink3   = $menuClass->get_menu_link($var3);
									$onoffClass3 = ($var3['MENU_MENUKEY'] == $menuClass->subPArray[3][0]['MENU_MENUKEY'])? "on" : "off";
									if($idx3 == 1){
										echo "<ul class=\"depth3\"";
										//if($onoffClass2 == "off") echo " style='display:none;'";
										echo ">";
									}
							?>
							<li><a href="<?=$menuLink3['href']?>" target="<?=$menuLink3['target']?>"><?php echo $var3['MENU_TITLE']?></a></li>
							<?php
									$idx3++;
								}														
							}//end while 3
							if($idx3 > 1) echo "</ul>";
							?>
						
						<!-- 3차메뉴 -->
					</li>
					<?php 
							$idx2++;
						}
					} 
					if($idx2 > 1) echo "</ul>";
					?>
			</li>
			<?php
				} 
				$i++;
			}
			?>
		</ul>
        <div class="shadow_bg"></div>
    </div>

<noscript>스크립트 환경에서 지원됩니다.</noscript>