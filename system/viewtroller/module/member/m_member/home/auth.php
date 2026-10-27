
<?php $return_url = !empty($_REQUEST['return_url'])? $_REQUEST['return_url'] : "http://".$_SERVER['HTTP_HOST']; ?>


								<div class="sc11">
									<div class="sc_w">
										<div class="login_box">
											<p class="fs_24 fc_222 fw_b">본인확인</p>
											<ul class="icon_ul02_ ml_10 mt_10">
												<li>충북여성재단은 원활한 홈페이지서비스이용과 익명의 사용자로인한 피해를 방지하고자 본인확인제도를 시행하고 있습니다.</li>
												<li>아래 본인(휴대폰)인증 또는 공공 I-PIN인증 중 하나를 선택하여 본인확인을 해 주시기 바랍니다.</li>
											</ul>
										</div>
										<div class="login_box2 mt_10">
											<div class="l_box01">
												<form name="request_auth" method="post" action="<?php echo site_auth_path?>/requestAuth.php">
												<input type="hidden" name="rqst_caus_cd" value="00">
												<input type="hidden" name="in_tp_bit" value="0">
												<input type="hidden" name="return_url" value="<?php echo $return_url?>">
												</form>

												<!-- 본인확인 처리결과 정보 -->
												<form name="kcbResultForm" method="post" >
													<input type="hidden" name="mem_id" 					value="" 	/>
													<input type="hidden" name="svc_tx_seqno"			value=""	/>
													<input type="hidden" name="rqst_caus_cd"			value="" 	/>
													<input type="hidden" name="result_cd" 				value="" 	/>
													<input type="hidden" name="result_msg" 				value="" 	/>
													<input type="hidden" name="cert_dt_tm" 				value="" 	/>
													<input type="hidden" name="di" 						value="" 	/>
													<input type="hidden" name="ci" 						value="" 	/>
													<input type="hidden" name="name" 					value="" 	/>
													<input type="hidden" name="birthday" 				value="" 	/>
													<input type="hidden" name="sex" 					value="" 	/>
													<input type="hidden" name="nation" 					value="" 	/>
													<input type="hidden" name="tel_com_cd" 				value="" 	/>
													<input type="hidden" name="tel_no" 					value="" 	/>
													<input type="hidden" name="return_msg" 				value="" 	/>
												</form>  

												<div class="l_box_top">
													<p class="l_icon"><img src="images/sub/icon_login01.gif" alt="아이콘"></p>
													<p class="txt01"><span class="fc_gold">휴대폰 </span>본인인증</p>
													<p class="txt02">생년월일, 성명, 내/외국인, 휴대폰번호, 통신사를 입력하여 본인확인을 받습니다.</p>
												</div>

												<div class="l_box_bot">
													<p class="l_bot_btn"><a href="#popup" title="휴대폰 실명인증 새창열림" onclick="callAuthPopup();return false;" onkeypress="">휴대폰 인증</a></p>
												</div>
											</div>
											<div class="l_box02">
												<form name="request_auth2" method="post" action="<?php echo site_ipin_path?>/requestAuth.php">
												<input type="hidden" name="return_url" value="<?php echo $return_url?>">
												</form>

												<!-- 본인확인 처리결과 정보 -->
												<form name="kcbOutForm" method="post">
													<input type="hidden" name="encPsnlInfo" />
													<input type="hidden" name="virtualno" />
													<input type="hidden" name="dupinfo" />
													<input type="hidden" name="realname" />
													<input type="hidden" name="cprequestnumber" />
													<input type="hidden" name="age" />
													<input type="hidden" name="sex" />
													<input type="hidden" name="nationalinfo" />
													<input type="hidden" name="birthdate" />
													<input type="hidden" name="coinfo1" />
													<input type="hidden" name="coinfo2" />
													<input type="hidden" name="ciupdate" />
													<input type="hidden" name="cpcode" />
													<input type="hidden" name="authinfo" />
												</form>
												<div class="l_box_top">
													<p class="l_icon"><img src="images/sub/icon_login02.gif" alt="아이콘"></p>
													<p class="txt01"><span class="fc_gold">공공 I-PIN </span>인증</p>
													<p class="txt02">공공 아이핀(i-PIN)은 행정안전부에서 주관하는 주민등록번호대체수단으로 회원님의 주민등록번호 대신 식별ID를 행정안전부로부터 발급받아 본인확인을 하는 서비스입니다.</p>
												</div>

												<div class="l_box_bot">
													<p class="l_bot_btn"><a href="#popup" title="아이핀 실명인증 새창열림" onclick="callAuthIpinPopup();return false;">공공 I-PIN 인증</a></p>
													<!-- <p class="l_bot_btn"><a href="#null" onclick="alert('준비중입니다.');">공공 I-PIN 인증</a></p> -->
												</div>
											</div>
										</div>
										<div class="login_box mt_10">
											휴대폰인증을 통하여 본인확인이 안되는 경우에는 실명인증기관에 고객님의 정보가 없는경우이므로, 아래 실명인증기관을 통해 고객님의 실명정보를 등록해 주셔야 합니다.실명인증기관에 등록하신 후 24시간(영업일 기준)이 지나면 정상적으로 실명확인이 가능합니다. <br><b>내국인, 기업 실명등록 문의 : 서울신용평가정보(주) (☎1577-1006)</b>
										</div>

										<h5 class="icon_h5_ mt_20">충북여성재단은 개인정보 보호를 위해 최선의 노력을 기울이고 있습니다. </h5>
										 

									</div>
								</div>


