<footer class="footer">
		<a class="footer-top" href="#top">맨 위로 가기</a>

		<!-- Quick : S //-->
		<div class="quick">
			<ul class="quick-list" data-aos="fade-left" >
				<li class="quick-item nth-1">
					<a href="#none"><span><em>온라인</em><br />문의</span></a>
				</li>
			</ul>
		</div>
		<!--// Quick : E -->

		

		<div class="footer__menu">
			<ul class="footer__menu-wrap">
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
					
					<li class="footer__menu-item">
						<a href="<?=$menuLink1['href']?>" title="<?=$menuTitle1?>"><span><?php echo $menuTitle1; ?></span></a>
					</li>
					<?php 
						};
					} 
					?>
					<li class="footer__menu-item">
						<a href="sub.php?menukey=384" title="이메일무단수집거부"><span>이메일무단수집거부</span></a>
					</li>
			</ul>
		</div>

		<div class="inner">
			<h1 class="footer-logo"><a href="#none">DOW BEAM</a></h1>
		</div>

		<div class="footer-bottom inner">
			<address>
				<p class="footer-item">
					<span><em>(27673) 충청북도 음성군 대소읍 산내로 60-40 ㈜다우이노베이션</em></span><br />
					<span>대표이사 : 김정환</span>
					<span>전화 : 043-877-1645/6</span>
					<span>팩스 : 043-877-1647</span>
					<span>e-mail : dwiz@dwinno.com</span>
				</p>
			</address>
			<p class="footer-copy">Copyright ⓒ DWI Co., Ltd. All Rights Reserved.</p>
		</div>
	</footer>