<?php 

#공공 I-PIN
require_once dir_public."/base/php/_realname/g-pin/input.php";

#실명인증 모듈
require_once dir_public."/base/php/_realname/".site_realname."/input.php";

?>

								<div class="sc11">
									<div class="sc_w">
										<div class="login_box">
											<p class="fs_24 fc_222 fw_b"><span class="fc_gold">본인</span>확인</p>
											<ul class="icon_ul6 mt_10">
												<li>영동 국악체험촌은 원활한 홈페이지서비스이용과 익명의 사용자로인한 피해를 방지하고자 본인확인제도를 시행하고 있습니다.</li>
												<li>아래 본인(휴대폰)인증 또는 공공 I-PIN인증 중 하나를 선택하여 본인확인을 해 주시기 바랍니다.</li>
											</ul>
										</div>
										<div class="login_box2 mt_10">
											<div class="l_box01">
												<div class="l_box_top">
													<p class="l_icon"><img src="images/content/l_icon01.png" alt="아이콘"></p>
													<p class="txt01"><span class="fc_gold">휴대폰 </span>인증인증</p>
													<p class="txt02">생년월일, 성명, 내/외국인, 휴대폰번호, 통신사를 입력하여 본인확인을 받습니다.</p>
												</div>

												<div class="l_box_bot">
													<p class="l_bot_btn"><a href="#" target="_blank" title="휴대폰 실명인증 새창열림" onclick="openPCCWindow();return false;" onkeypress="">휴대폰 인증</a></p>
												</div>
											</div>
											<div class="l_box02">
												<div class="l_box_top">
													<p class="l_icon"><img src="images/content/l_icon02.png" alt="아이콘"></p>
													<p class="txt01"><span class="fc_gold">공공 I-PIN </span>인증인증</p>
													<p class="txt02">공공 아이핀(i-PIN)은 행정안전부에서 주관하는 주민등록번호대체수단으로 회원님의 주민등록번호 대신 식별ID를 행정안전부로부터 발급받아 본인확인을 하는 서비스입니다.</p>
												</div>

												<div class="l_box_bot">
													<p class="l_bot_btn"><a href="/base/php/_realname/g-pin/AuthRequest.php?return_url=<?=$return_url?>" target='_blank' onclick="GpinAuth();return false;">공공 I-PIN 인증</a></p>
													<!-- <p class="l_bot_btn"><a href="#null" onclick="alert('준비중입니다.');">공공 I-PIN 인증</a></p> -->
												</div>
											</div>
										</div>
										<div class="login_box mt_10">
											휴대폰인증을 통하여 본인확인이 안되는 경우에는 실명인증기관에 고객님의 정보가 없는경우이므로, 아래 실명인증기관을 통해 고객님의 실명정보를 등록해 주셔야 합니다.실명인증기관에 등록하신 후 24시간(영업일 기준)이 지나면 정상적으로 실명확인이 가능합니다. <br><b>내국인, 기업 실명등록 문의 : 서울신용평가정보(주) (☎1577-1006)</b>
										</div>

										<p class="fs_18 fc_222 ml_30 mt_20 fw_b">영동 국악체험촌은 개인정보 보호를 위해 최선의 노력을 기울이고 있습니다. </p>
										<p class="fs_14 fc_888 ml_30">영동 국악체험촌은 개인정보 보호를 위해 최선의 노력을 기울이고 있습니다. </p>

									</div>
								</div>

