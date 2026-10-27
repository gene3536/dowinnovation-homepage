    <div id="accessibility"><a href="#container">콘텐츠로 바로가기</a></div>
    <!-- mobile_menu -->
	<?php require_once dir_site."/home/default/cmn.lnbTM.php"; ?>
    <!-- /mobile_menu --> 
    <!-- header -->
    <div id="header" class="clearfix">
        <div class="header_in wrap">
            <h1><a href="/index.php"><img src="../home/images/common/logo.png" alt="충북여성재단" /></a></h1>
            <div class="right"> 
                <!-- search -->
                <div class="search">
                    <h2 class="skip">통합검색</h2>
                    <form name="totalSearchForm" id="totalSearchForm" method="get" action="sub.php">
						<input type="hidden" name="menukey" id="menukey" value="530">
                        <fieldset>
                            <legend>통합검색</legend>
                            <input type="text" name="kwd" id="kwd" title="검색어를 입력하세요" placeholder="검색어를 입력하세요" />
                            <input type="submit" name="" value="검색" />
                        </fieldset>
                    </form>
                </div>

				<script type="text/javascript">
				var passForm = false;
				$(function(){
					$("#totalSearchForm").submit(function(e){
						if(passForm == false){
							e.preventDefault();
							if($("#kwd").val() == ""){
								alert("검색어를 입력하세요.");
								$("#kwd").focus();
								return false;
							}else{
								passForm = true;
								$(this).submit();
							}
						}
					});
				});
				</script>

                <!-- //search -->
                <div class="sns">
                    <ul>
                        <li><a href="#facebook" onclick="alert('준비중입니다.');return false;" class="facebook">페이스북</a></li>
                        <li><a href="https://story.kakao.com/ch/cbwf0217" target="_blank" title="새창열림" class="kakao">카카오스토리</a></li>
                    </ul>
                </div>
                <div id="gnb">
                    <ul>
						<?php if(S_mb_login){ ?>
                        <li><a href="sub.php?menukey=540" class="logout">로그아웃</a></li>
						<?php }else{ ?>
                        <li><a href="sub.php?menukey=524" class="login">로그인</a></li>
						<?php } ?>
                        <li><a href="sub.php?menukey=534" class="all_menu">전체메뉴</a></li>
                    </ul>
                </div>
            <div id="m_gnb"><a href="sub.php?menukey=534" class="btn_sitemap">전체메뉴</a></div>	
            </div>
        </div>
        <!-- lnb -->
		<?php require_once dir_site."/home/default/cmn.lnb.php"; ?>
        <!-- //lnb --> 
    </div>
    <!-- //header --> 