		<?php
		unset($leftMnArr); unset($siteAllArr);
		$siteAllArr = $menuClass->getMenuArray();
		$leftMnArr  = $menuClass->getLeftMenu();   
		?>		
											
		<div class="lnb">
			<div class="lnb-wrap" data-aos="fade-up" data-aos-easing="ease-out">
				<ul class="lnb-list">
					<li class="lnb-home"><a href="/home">메인으로 돌아가기</a></li>
					<? 
					foreach($leftMnArr[2] as $subVar2){ 
						if($subVar2['MENU_VISIBLE'] == "Y"){
							$onoffClass2 = ($menukey == $subVar2['MENU_MENUKEY'] || $menukey == $subVar2['ref'] || $subVar2['MENU_MENUKEY'] == $menuClass->sub['MENU_REF'])? "is-active" : "";
							
							$subLink2    = $menuClass->get_menu_link($subVar2);
							$menu2Dep    = $subVar2['MENU_MENUKEY'];
							
					?>
						<li class="lnb-item <?=$onoffClass2?>">
							<a href="<?=$subLink2['href']?>" target="<?=$subLink2['target']?>" title="<?=$subVar2['MENU_TITLE']?>" data-id="crumbMenuBtn" class="lnb-link" title="메뉴 열기">
								<span><?=$subVar2['MENU_TITLE']?></span>
							</a>
						</li>
					<? 
						}
					}
					?>
				</ul>
			</div>
		</div>
		<!-- Quick : S //-->
		<div class="quick">
			<ul class="quick-list" data-aos="fade-left" >
				<li class="quick-item nth-1">
					<a href="/home/sub.php?menukey=293"><span><em>온라인</em><br />문의</span></a>
				</li>
			</ul>
		</div>
		<!--// Quick : E -->