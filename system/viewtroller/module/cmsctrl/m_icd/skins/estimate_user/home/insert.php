<?php
	$toDay		= date("Y-m-d");
	$nextDay	= date("Y-m-d", strtotime($toDay."+14 day"));
	$SpamKey	= floor(rand(100000,999999));
	
	$d[0] = substr($SpamKey,0,1);
	$d[1] = substr($SpamKey,1,1);
	$d[2] = substr($SpamKey,2,1);
	$d[3] = substr($SpamKey,3,1);
	$d[4] = substr($SpamKey,4,1);
	$d[5] = substr($SpamKey,5,1);
?>
<style>
	.cke_sc_def {
		margin: 0 0 5px;
		padding: 10px;
		text-align: center;
	}
	.cke_sc_def dl {
		margin: 0 0 5px;
		text-align: left;
		zoom: 1;
	}
	.cke_sc_def dt {
		width: 50%;
		font-weight: bold;
	}
	.cke_sc_def dd {
		width: 50%;
	}
	.cke_sc_def dt, .cke_sc_def dd {
		float: left;
		margin: 0;
		padding: 5px 0;
		border-bottom: 1px solid #e9e9e9;
	}
</style>
<script>
	$(document).ready(function(){
		
		$('input[name="btn_keys"]').click(function(){
			var status = $(this).attr('class');
			if(status=='open'){
				$('div.cke_sc_def').show('down');
				$(this).attr('value','단축키 일람 닫기');	
				$(this).attr('class','close');
			}else{
				$('div.cke_sc_def').hide('up');
				$(this).attr('value','단축키 일람');	
				$(this).attr('class','open');
			}
		});

		$("#insertForm").validate({
			rules : {
				icd_name :{required:true},
				icd_title :{required:true},
				icd_fld3 :{required:true},
				icd_fld2 :{required:true},
				icd_content :{required:true},
				spamKey : {required:true},
				chkagree : {required:true},
				icd_fld1 : {required:true}
			},
			messages : {
				icd_name :{required:"이름을 입력하세요."},
				icd_title :{required:"회사명을 입력하세요."},
				icd_fld3 :{required:"연락처를 입력하세요."},
				icd_fld2 :{required:"이메일을 입력하세요."},
				icd_content :{required:"문의내용을 입력하세요."},
				spamKey : {required:"인증문자를 입력하세요."},
				chkagree : {required:"약관에 동의 하세요."},
				icd_fld1 : {required:"직책을 입력하세요."}
			},
			submitHandler: function (frm){
				frm.submit();   //유효성 검사를 통과시 전송
				return false;
			},
			success: function(e){
				//
			}
		});
	});
	
</script>
<!--★★★★★ Board start ★★★★★//-->
<div class="inner newBoard inquery">

	<!-- 제품문의 상단영역 : S //-->
	<div class="inquery-header">
		<?=$menuClass->get_inquiry_header();?>
	</div>
	<!--// 제품문의 상단영역 : E -->
	<!-- Board Wite : S //-->
	<div class="newBoard__write">

		<!-- newBoard Write 상단 : S //-->
		<div class="newBoard__write-header" data-aos="fade-up">
			<p class="required"><span>표시는 필수 입력 항목입니다.</span></p>
		</div>
		<!--// newBoard Write 상단 : E -->
		<form name="insertForm" id="insertForm" method="post" enctype="multipart/form-data" action="sub.php?menukey=<?php echo $menukey?>" onsubmit="return $.brdValidation();">
			<input type="hidden" name="mod" value="process" />
			<input type="hidden" name="act" value="insert" />
			<input type="hidden" name="token" value="<?php echo site_config_token?>" />
			<input type="hidden" name="chkKey" id="chkKey" value="<?php echo $SpamKey?>">
			<input type="hidden" name="rtMod" value="insert" />
			<input type="hidden" name="rtMsg" value="<?php echo base64_encode("정상적으로 등록되었습니다.") ?>" />
			<input type="hidden" name="scodevar" value="<?echo site_config_code?>" />
			<input type="hidden" name="sendMail" value="y" />
	 
			<!-- newBoard Write 내용 : S //-->
				<div class="newBoard__write-contents">

					<!-- Write Table : S //-->
					<div class="newBoard__write-table" data-aos="fade-up">	
						<table cellpadding="0" cellspacing="0" summary="문의 유형, 이름, 이메일, 전화번호, 회사, 직책, 문의내용, 첨부파일을 입력할 수 있는 문의하기 표입니다.">
							<caption>문의하기</caption>
							<colgroup>
								<col width="15%">
								<col width="35%"> 
								<col width="15%">
								<col width="35%">
							</colgroup>
							<tbody>
								<tr>
									<th scope="row" class="required"><label for="icd_name">이름</label></th>
									<td>
										<p class="base__form-item">
											<input type="text" name="icd_name" id="icd_name" aria-required="true" placeholder="" required>
										</p>
									</td>
									<th scope="row" class="required"><label for="icd_title">회사</label></th>
									<td>
										<p class="base__form-item">
											<input type="text" name="icd_title" id="icd_title" aria-required="true" placeholder="" required>
										</p>
									</td>
								</tr>

								<tr>
									<th scope="row" class="required"><label for="icd_fld3">전화번호</label></th>
									<td>
										<p class="base__form-item">
											<input type="text" name="icd_fld3" id="icd_fld3" aria-required="true" placeholder="" required>
										</p>
									</td>
									<th scope="row" class="required"><label for="icd_fld1">직책</label></th>
									<td>
										<p class="base__form-item">
											<input type="text" name="icd_fld1" id="icd_fld1" aria-required="true" placeholder="">
										</p>
									</td>
								</tr>

								<tr>
									<th scope="row" class="required"><label for="icd_fld2">이메일</label></th>
									<td colspan="3">
										<p class="base__form-item">
											<input type="text" name="icd_fld2" id="icd_fld2" aria-required="true" placeholder="" required>
										</p>
									</td>
								</tr>
								<tr>
									<th scope="col" class="required th-type1" colspan="4"><label for="icd_content">문의내용</label></th>
								</tr>
								<tr>
									<td class="td-type1" colspan="4">
										<input type="button" name="btn_keys" class="open" value="단축키 일람" />
										<div class="cke_sc_def" style="display:none;">
										<dl>
											<dt>CTRL+B</dt>
											<dd>글자 굵게</dd>
											<dt>CTRL+U</dt>
											<dd>글자 밑줄</dd>
											<dt>CTRL+I</dt>
											<dd>글자 기울임</dd>
											<dt>CTRL+D</dt>
											<dd>글자 취소선</dd>
											<dt>TAB</dt>
											<dd>들여쓰기</dd>
											<dt>SHIFT+TAB</dt>
											<dd>내어쓰기</dd>
											<dt>CTRL+K</dt>
											<dd>링크 걸기</dd>
											<dt>CTRL+F</dt>
											<dd>단어 찾기</dd>
											<dt>CTRL+H</dt>
											<dd>단어 바꾸기</dd>
											<dt>CTRL+A</dt>
											<dd>전체 선택</dd>
										</dl>
										</div>
										<?php $coreClass -> getEditor(site_config_editor, "icd_content", "100%", "300px", ""); ?>
									</td>
								</tr>
								<tr>
									<th class="th-type2">첨부파일</th>
									<td colspan="3">
										<p class="base__fileup">
											<label class="base__fileup-wrap" data-value="찾아보기">
												<input type="file" name="uploadFile1" id="" class="base__fileup-file" title="첨부파일1" />
											</label>
											<input type="text" name="" class="base__fileup-name" readonly="readonly" title="첨부파일이름(읽기전용)" />
										</p>
										<p class="base__fileup">
											<label class="base__fileup-wrap" data-value="찾아보기">
												<input type="file" name="uploadFile2" id="" class="base__fileup-file" title="첨부파일2" />
											</label>
											<input type="text" name="" class="base__fileup-name" readonly="readonly" title="첨부파일이름(읽기전용)" />
										</p>
										<p class="base__form-text">※ 업로드 가능 용량은 20MB입니다.</p>
									</td>
								</tr>
								<tr>
									<th class="required"><label for="spamKey">인증번호</label></th>
									<td colspan="3" class="spamkey">
										<p class="spamkey-img">
											<img src="images/common/board/no_<?php echo $d[0]?>.png" alt="number" />
											<img src="images/common/board/no_<?php echo $d[1]?>.png" alt="number" />
											<img src="images/common/board/no_<?php echo $d[2]?>.png" alt="number" />
											<img src="images/common/board/no_<?php echo $d[3]?>.png" alt="number" />
											<img src="images/common/board/no_<?php echo $d[4]?>.png" alt="number" />
											<img src="images/common/board/no_<?php echo $d[5]?>.png" alt="number" />
										</p>
										<p class="base__form-item">
											<input type="text" id="spamKey" name="spamKey" required aria-required="true" maxlength="6" />
										</p>
										<p class="base__form-text">옆의 인증번호를 입력해 주세요!</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!--// Write Table : E -->


					<!-- 개인정보처리방침 : S //-->
					<div class="privacy">
						<h3 class="privacy-tit" data-aos="fade-up">개인정보 수집 및 이용 동의</h3>
						<div class="privacy-wrap" data-aos="fade-up">
							<div class="privacy-header" data-aos="fade-up">
								DOW INNOVATION CO., LTD. (이하 '회사')은 이용자의 개인정보를 중요시하며, "정보통신망 이용촉진 및 정보보호"에 관한 법률과 개인정보보호법 등을 준수하고 있습니다. 회사는 개인정보처리방침을 통하여 이용자님께서 제공하시는 개인정보가 어떠한 용도와 방식으로 이용되고 있으며, 개인정보보호를 위해 어떠한 조치가 취해지고 있는지 알려 드립니다. 회사는 개인정보처리방침을 개정하는 경우 웹사이트 공지사항(또는 개별공지)을 통하여 공지할 것입니다. 회사의 개인정보처리방침은 다음과 같은 내용을 담고 있습니다.
							</div>
							<div class="privacy-inner">
								<p>1. 수집하는 개인정보 및 수집방법</p>
								<p>2. 개인정보의 수집 및 이용목적</p>
								<p>3. 수집한 개인정보의 공유 및 제공</p>
								<p>4. 개인정보처리 위탁</p>
								<p>5. 수집한 개인정보의 보유 및 이용기간</p>
								<p>6. 개인정보의 파기절차 및 방법</p>
								<p>7. 개인정보의 안전성 확보 조치</p>
								<p>8. 이용자 및 법정대리인의 권리와 그 행사방법</p>
								<p>9. 개인정보 자동 수집 장치의 설치 • 운영 및 그 거부에 관한 사항</p>
								<p>10.개인정보 관리책임자 및 개인정보담당 부서</p>
								<p>11. 고지의 의무</p>
								<p class="MAT-XS">본 방침은 2020년 01월 01일부터 시행됩니다.</p>
							</div>



							<h4>1. 수집하는 개인정보 및 수집방법</h4>
							<div class="privacy-inner">
								<p>1) 수집항목회사는 회사관련 문의, 서비스/상품 문의, 채용 문의, 홈페이지 문의, 부정제보, 보안제보 등에 대한 관리를 위하여 아래와 같은 개인정보를 수집하고 있습니다.</p>
								<div class="privacy-inner">
									<p>- 필수정보 : 이름, 회사명, 이메일, 연락처</p>
									<p>- 동의를 거부할 권리 및 동의 거부에 따른 불이익</p>
									<p>• 필수 정보 수집에 대한 동의를 거부할 권리가 있습니다.</p>
									<p>• 필수 정보 외, 선택 정보 수집에 대한 동의를 거부할 권리가 있습니다. </p>
									<p>단, 동의를 거부할 경우 문의에 대한 응대가 불가능할 수 있습니다.</p>
								</div>

							<p class="MAT-S">2) 수집방법회사는 다음과 같은 방법으로 개인정보를 수집합니다.</p>
								<div class="privacy-inner">
									<p>- 홈페이지 '견적문의' 메뉴</p>
								</div>

							</div>


							<h4>2. 개인정보의 수집 및 이용목적</h4>
							<div class="privacy-inner">
								<p>회사는 수집한 개인정보를 다음의 목적을 위해 활용합니다.</p>
								<div class="privacy-inner">
									<p>- 회사관련 문의, 서비스/상품 문의, 홈페이지 문의 등의 고객 문의에 대한 피드백 제공 및 관리</p>
								</div>
							</div>

							<h4>3. 수집한 개인정보의 공유 및 제공</h4>
							<div class="privacy-inner">
								<p>회사는 이용자의 개인정보를 원칙적으로 외부에 제공하지 않습니다. 다만, 아래의 경우에는 예외로 합니다.</p>
								<div class="privacy-inner">
									<p>- 이용자들이 사전에 동의한 경우</p>
									<p>- 법령의 규정에 의거하거나, 수사 목적으로 법령에 정해진 절차와 방법에 따라 수사기관의 요구가 있는 경우</p>
								</div>
							</div>

							<h4>4. 개인정보처리 위탁</h4>
							<div class="privacy-inner">
								<p>회사는 이용자의 개인정보를 원칙적으로 외부에 처리 위탁하지 않습니다. 다만, 아래의 경우에는 예외로 합니다.</p>
								<div class="privacy-inner">
									<p>- 이용자들이 사전에 동의한 경우</p>
									<p>- 법령의 규정에 의거하거나, 수사 목적으로 법령에 정해진 절차와 방법에 따라 수사기관의 요구가 있는 경우</p>
								</div>
							</div>

							<h4>5. 수집한 개인정보의 보유 및 이용기간</h4>
							<div class="privacy-inner">
								<p>회사관련 문의, 서비스/상품 문의, 홈페이지 문의 등의 고객 문의에 대한 피드백이 제공되는 시점에 해당 정보를 지체 없이 파기합니다.</p>
							</div>

							<h4>6. 개인정보의 파기절차 및 방법</h4>
							<div class="privacy-inner">
								<p>회사는 원칙적으로 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 파기절차 및 방법은 다음과 같습니다.</p>
								<div class="privacy-inner">
									<p>1) 파기절차고객이 입력하신 정보는 목적이 달성된 후 내부 방침에 의한 정보보호 사유에 따라(보유 및 이용 기간 참조) 일정기간 저장된 후 파기되어 집니다.동 개인정보는 법률에 의한 경우가 아니고서는 보유되어지는 이외의 다른 목적으로 이용 되지 않습니다.</p>
									<p>2) 파기방법종이에 출력된 개인정보는 분쇄기로 분쇄하거나 소각을 통하여 파기하고전자적 파일형태로 저장된 개인정보는 기록을 재생할 수 없는 기술적 방법을 사용하여 삭제합니다.</p>
								</div>
							</div>

							<h4>7. 개인정보의 안전성 확보 조치</h4>
							<div class="privacy-inner">
								<p>회사는 다음과 같이 안전성 확보에 필요한 기술적, 관리적, 물리적 조치를 하고 있습니다.</p>
								<div class="privacy-inner">
									<p>1) 내부관리계획의 수립 및 시행회사의 내부관리계획 수립하여 개인정보 보호를 위해 실행합니다.</p>
									<p>2) 개인정보 처리 담당자의 최소화 및 교육개인정보를 처리하는 데이터베이스시스템에 대한 접근권한의 부여, 변경, 말소를 통하여 개인정보에 대한 접근통제를 위하여 필요한 조치를 하고 있으며 침입차단시스템을 이용하여 외부로부터의 무단 접근을 통제하고 있습니다.</p>
									<p>3) 접속기록의 보관 및 위변조 방지개인정보처리시스템에 접속한 기록(웹 로그, 요약정보 등)을 최소 6개월 이상 보관, 관리하고 있으며, 접속 기록이 위변조 및 도난, 분실되지 않도록 보안기능을 사용하고 있습니다.</p>
									<p>4) 해킹 등에 대비한 기술적 대책 및 비인가자에 대한 출입 통제회사는 해킹이나 컴퓨터 바이러스 등에 의한 개인정보 유출 및 훼손을 막기 위하여 보안프로그램을 설치하고 주기적인 갱신•점검을 하며 외부로부터 접근이 통제된 구역에 시스템을 설치하고 기술적/물리적으로 감시 및 차단하고 있습니다. 또한 네트워크 트래픽의 통제(Monitoring)는 물론 불법적으로 정보를 변경하는 등의 시도를 탐지하고 있습니다.</p>
								</div>
							</div>

							<h4>8. 이용자 및 법정대리인의 권리와 그 행사방법</h4>
							<div class="privacy-inner">
								<p>이용자 및 법정대리인은 언제든지 등록되어 있는 이용자의 개인정보를 열람하거나 정정하실 수 있습니다. 개인정보의 열람, 정정 및 삭제 등의 요청은 개인정보관리책임자에게 전화 혹은 e-mail로 요청하시면 본인 확인 절차를 거친 후 지체없이 조치하겠습니다. <br />이용자가 개인정보의 오류에 대한 정정을 요청하신 경우에는 정정을 완료하기 전까지 당해 개인정보를 이용 또는 제공하지 않습니다. 또한 잘못된 개인정보를 제3자에게 이미 제공한경우에는 정정 처리결과를 제3자에게 지체없이 통지하여 정정이 이루어지도록 하겠습니다.<br />회사는 이용자 혹은 법정 대리인의 요청에 의해 해지 또는 삭제된 개인정보는 "회사가 수집하는 개인정보의 보유 및 이용기간"에 명시된 바에 따라 처리하고 그 외의 용도로 열람 또는 이용할 수 없도록 처리하고 있습니다.</p>
							</div>

							<h4>9. 개인정보 자동 수집 장치의 설치 • 운영 및 그 거부에 관한 사항</h4>
							<div class="privacy-inner">
								<p>쿠키 등 인터넷 서비스 이용 시 자동 생성되는 개인정보를 수집하는 장치를 운영하지 않습니다.</p>
							</div>

							<h4>10. 개인정보관리책임자 및 개인정보담당 부서</h4>
							<div class="privacy-inner">
								<!--
								<p>회사는 이용자의 개인정보를 보호하고 개인정보와 관련한 불만을 처리하기 위하여 아래와 같이 관련 부서 및 개인정보관리책임자를 지정하고 있습니다.</p>
								<div class="privacy-inner">
									<p>1) 개인정보관리 소관부서</p>
									<div class="privacy-inner">
										<p>부서 : TEST</p>
										<p>전화번호 : 02-000-0000</p>
										<p>이메일 : test@test.test</p>
									</div>
									<p class="MAT-XS">2) 개인정보관리 책임자</p>
									<div class="privacy-inner">
										<p>성명 : 테스트</p>
										<p>전화번호 : 02-000-0000</p>
										<p>이메일 : test@test.test</p>
									</div>
								</div>
								<p class="MAT-S">이용자께서는 회사의 서비스를 이용하시며 발생하는 모든 개인정보보호 관련 민원을 개인정보관리책임자 혹은 담당부서로 신고하실 수 있습니다. 회사는 이용자들의 신고사항에 대해 신속하게 충분한 답변을 드릴 것입니다. 기타 개인정보침해에 대한 신고나 상담이 필요하신 경우에는 아래 기관에 문의하시기 바랍니다.</p>
								-->
								<p class="MAT-S">1. 개인정보분쟁조정위원회(<a href="http://www.kopico.go.kr" target="_blank">www.kopico.go.kr</a>) : 02-2100-2499</p>
								<p>2. 대검찰청 사이버범죄수사단 : 02-3480-3571 (<a href="http://www.spo.go.kr/" target="_blank">http://www.spo.go.kr/</a>)</p>
								<p>3. 경찰청 사이버안전국 : (국번없이) 182 (<a href="http://cyberbureau.police.go.kr/" target="_blank">http://cyberbureau.police.go.kr/</a>)</p>
								<p class="MAT-S">「개인정보보호법」제35조(개인정보의 열람), 제36조(개인정보의 정정·삭제), 제37조(개인정보의 처리정지 등)의 규정에 의한 요구에 대 하여 공공기관의 장이 행한 처분 또는 부작위로 인하여 권리 또는 이익의 침해를 받은 자는 행정심판법이 정하는 바에 따라 행정심판을 청구할 수 있습니다.</p>
								
								<p class="MAT-S">※ 행정심판에 대해 자세한 사항은 법제처 (<a href="http://www.moleg.go.kr" target="_blank">http://www.moleg.go.kr</a>) 홈페이지를 참고하시기 바랍니다.</p>
							</div>

							<h4>11. 고지의 의무</h4>
							<div class="privacy-inner">
								<p>현 개인정보처리방침 내용 추가, 삭제 및 수정이 있을 시에는 개정 최소 7일전부터 홈페이지의 '공지사항'을 통해 고지할 것입니다.</p>
							</div>
						</div>
					</div>
					<!--// 개인정보처리방침 : E -->

					<!-- 동의 Check : S //-->
					<div class="privacy-check">
						<span class="form-check_item">
							<label class="checkbox-label"><input type="checkbox" name="chkagree" id="chkagree" class="checkbox-obj" value="Y" required="required" aria-required="true"><em class="checkbox-text">글 등록을 위한 [개인정보 수집 및 이용 동의]에 동의합니다.</em></label>
						</span>
					</div>

					<!--// 동의 Check : E -->



				</div>
				<!--// newBoard Write 내용 : E -->
						

					
				<!-- 버튼 : S //-->
				<div class="newBoard__btn" data-aos="fade-up">
					<div class="newBoard__btn-wrap">
						<button class="btn type1" type="submit"><span class="ico write">문의</span></button>
					</div>
				</div>
				<!--// 버튼 : E -->

			</form>
		</div>
		<!--// newBoard Write : E -->



	</div>
	<!--//★★★★★ Board end ★★★★★-->





