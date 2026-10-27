 <header class="header-wrap">
	<!-- header-inner : S //-->
		<div class="header-inner">
			<h1 class="header-logo"><a href="/chn">DOW BEAM</a></h1>
 	
			<!-- Util : S //-->
			<aside class="top__util">
				<div class="top__util-item language">
					<p><a href="/home" class="language-link"><span>KR</span></a></p>
					<p><a href="/eng" class="language-link"><span>EN</span></a></p>
					<p><a href="/chn" class="language-link"><span>CH</span></a></p>
					<p><a href="/jpn" class="language-link"><span>JP</span></a></p>
				</div>
				<div class="top__util-item allmenu">
					<a href="#none" class="allmenu-link newAllmenu-open">
						<span></span>
						<span></span>
						<span></span>
					</a>
				</div>
			</aside>
			<!--// Util : E -->

			<!-- GNB : S //-->
			<nav id="gnb" class="gnb">
				<div class="gnb-inner-util">
					<div class="util-item language">
						<p><a href="/home" class="top__util-link"><span>KR</span></a></p>
						<p><a href="/eng" class="top__util-link"><span>EN</span></a></p>
						<p><a href="/chn" class="top__util-link"><span>CH</span></a></p>
						<p><a href="/jpn" class="top__util-link"><span>JP</span></a></p>
					</div>
					<p class="gnb-mbtn-close"><span>메뉴닫기</span></p>
				</div>

				<ul class="gnb-wrap">
					<?php 
						$i=1; unset($siteMnArr);
						$siteMnArr = $menuClass->getMenuArray();
						foreach($siteMnArr[1] as $var1){
							if($var1['MENU_VISIBLE'] == "Y"){
								$menuLink1 = $menuClass->get_menu_link($var1);
								$menu1Dep  = $var1['MENU_MENUKEY'];
								$menuTitle1= ($var1['MENU_TYPE'] == 5)? "새창에서 열림" : $var1['MENU_TITLE'];
						?>
						
						<li class="gnb-1dep">
							<a href="<?=$menuLink1['href']?>" class="gnb-1dep__link" title="<?=$menuTitle1?>"><span><?php echo $var1['MENU_TITLE']; ?></span></a>
							<ul class="gnb-2dep">
								<?php 									
								foreach($siteMnArr[2] as $var2){
									if($menu1Dep == $var2['MENU_REF'] && $var2['MENU_VISIBLE'] == "Y"){
										$menuLink2 = $menuClass->get_menu_link($var2);
								?>
								<li>
									<a href="<?=$menuLink2['href']?>" target="<?=$menuLink2['target']?>" title="<?=$var2['MENU_TITLE']?>"><?php echo $var2['MENU_TITLE']; ?></a>
								</li>
								<?php 
									}
								} 
								?>
							</ul>
						</li>
						<?php 
							};
						} 
						?>
				</nav>
			<!--// GNB : E -->

		</div>
		<!--// header-inner : E-->

		<!-- 전체메뉴 : S //-->
		<div class="newAllmenu">
			<div class="newAllmenu-wrap">
				<h3 class="newAllmenu-tit"><img src="images/common/top_logo.png" alt="DOW BEAM" /></h3>
				<div class="newAllmenu-inner">
					<ul class="newAllmenu-nav">
						<?php 
						$i=1; unset($siteMnArr);
						$siteMnArr = $menuClass->getMenuArray();
						foreach($siteMnArr[1] as $var1){
							if($var1['MENU_VISIBLE'] == "Y"){
								$menuLink1 = $menuClass->get_menu_link($var1);
								$menu1Dep  = $var1['MENU_MENUKEY'];
								$menuTitle1= ($var1['MENU_TYPE'] == 5)? "새창에서 열림" : $var1['MENU_TITLE'];

								//그냥 붙이기
								$allmenu_title = preg_replace("/\s+/","",$var1['MENU_TITLE']);
						?>
						<li class="newAllmenu-1dep">
							<a href="<?=$menuLink1['href']?>" title="<?=$menuTitle1?>"><span><?php echo $menuTitle1; ?></span></a>
							<ul class="newAllmenu-2dep">
								<?php 									
								foreach($siteMnArr[2] as $var2){
									if($menu1Dep == $var2['MENU_REF'] && $var2['MENU_VISIBLE'] == "Y"){
										$menuLink2 = $menuClass->get_menu_link($var2);
								?>
								<li>
									<a href="<?=$menuLink2['href']?>" target="<?=$menuLink2['target']?>" title="<?=$var2['MENU_TITLE']?>"><?php echo $var2['MENU_TITLE']; ?></a>
									<?php if(!empty($siteMnArr[3])){
										$ii = 0;
										foreach ( $siteMnArr [3] as $var3 ) {
											
											if ($var2['MENU_MENUKEY'] == $var3 ['MENU_REF'] && $var3 ['MENU_VISIBLE'] == "Y") {
												$menuLink3 = $menuClass->get_menu_link ( $var3 );
												if($ii==0){
											?>
												<ul class="newAllmenu-3dep">
												<?php $ii++; }?>
												<li>
													<a href="<?=$menuLink3['href']?>" target="<?=$menuLink3['target']?>" title="<?=$var3['MENU_TITLE']?>"><?php echo $var3['MENU_TITLE']; ?></a>
												</li>
									
											<?php }
											}?>
										<?php if($ii>0){?></ul><?php $ii=0;}?>
									<?php }
									?>
								</li>
								<?php 
								}
							} 
							?>
						</ul>
					</li>
					<?php 
						};
					} 
					?>
					</ul>
				</div>
				<div class="top__util-item language">
					<p><a href="/home" class="language-link"><span>KR</span></a></p>
					<p><a href="/eng" class="language-link"><span>EN</span></a></p>
					<p><a href="/chn" class="language-link"><span>CH</span></a></p>
					<p><a href="/jpn" class="language-link"><span>JP</span></a></p>
				</div>
			</div>
			<a href="#none" class="newAllmenu-close"><span>CLOSE</span></a>
			<div class="newAllmenu-dimmed"></div>
		</div>
		<div class="gnb-dimmed"></div>
	</header>
	<!--// header : E-->
