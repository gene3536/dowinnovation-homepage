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
				$(this).attr('value','Close');	
				$(this).attr('class','close');
			}else{
				$('div.cke_sc_def').hide('up');
				$(this).attr('value','Shortcut list');	
				$(this).attr('class','open');
			}
		});

		$("#insertForm").validate({
			rules : {
				icd_name :{required:true},
				icd_fld2 :{required:true},
				icd_title :{required:true},
				icd_fld3 :{required:true},
				icd_content :{required:true},
				spamKey : {required:true},
				chkagree : {required:true}
			},
			messages : {
				icd_name :{required:"Please enter your name."},
				icd_title :{required:"Please enter your company name."},
				icd_fld3 :{required:"Please enter a contact."},
				icd_fld2 :{required:"Please enter your email."},
				icd_content :{required:"Please enter your inquiry."},
				spamKey : {required:"Please enter a verification."},
				chkagree : {required:"Please accept the terms."}
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
			<p class="required"><span>Required input.</span></p>
		</div>
		<!--// newBoard Write 상단 : E -->
		<form name="insertForm" id="insertForm" method="post" enctype="multipart/form-data" action="sub.php?menukey=<?php echo $menukey?>">
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
									<th scope="row" class="required"><label for="icd_name">Name</label></th>
									<td>
										<p class="base__form-item">
											<input type="text" name="icd_name" id="icd_name" aria-required="true" placeholder="" required>
										</p>
									</td>
									<th scope="row" class="required"><label for="icd_title">Your Company</label></th>
									<td>
										<p class="base__form-item">
											<input type="text" name="icd_title" id="icd_title" aria-required="true" placeholder="" required>
										</p>
									</td>
								</tr>

							<tr>
									<th class="required"><label for="icd_fld3">Phone number</label></th>
									<td>
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_fld3" id="icd_fld3" required>
										</span>
									</td>
									<th class="required"><label for="icd_fld1">One's duty</label></th>
									<td>
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_fld1" id="icd_fld1">
										</span>
									</td>
								</tr>

								<tr>
									<th class="required"><label for="icd_fld2">e-mail</label></th>
									<td colspan="3">
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_fld2" id="icd_fld2" required>
										</span>
									</td>
								</tr>

								<tr>
									<th class="required"><label for="icd_content">Inquire content</label></th>
									<td colspan="3" style="text-align:left;">
										<input type="button" name="btn_keys" class="open" value="Shortcut list" />
										<div class="cke_sc_def" style="display:none;">
										<dl>
											<dt>CTRL+B</dt>
											<dd>Text bold</dd>
											<dt>CTRL+U</dt>
											<dd>Underline letters</dd>
											<dt>CTRL+I</dt>
											<dd>Italic</dd>
											<dt>CTRL+D</dt>
											<dd>Character strikethrough</dd>
											<dt>TAB</dt>
											<dd>Indent</dd>
											<dt>SHIFT+TAB</dt>
											<dd>Unindent</dd>
											<dt>CTRL+K</dt>
											<dd>Linking</dd>
											<dt>CTRL+F</dt>
											<dd>Word search</dd>
											<dt>CTRL+H</dt>
											<dd>Replace word</dd>
											<dt>CTRL+A</dt>
											<dd>Select All</dd>
										</dl>
										</div>
										<?php $coreClass -> getEditor(site_config_editor, "icd_content", "100%", "200px", ""); ?>
									</td>
								</tr>
								
								<tr>
									<th class="th-type2">Attachments</th>
									<td colspan="3">
										<p class="base__fileup">
											<label class="base__fileup-wrap" data-value="Search">
												<input type="file" name="uploadFile1" id="" class="base__fileup-file" title="첨부파일1" />
											</label>
											<input type="text" name="" class="base__fileup-name" readonly="readonly" title="첨부파일이름(읽기전용)" />
										</p>
										<p class="base__fileup">
											<label class="base__fileup-wrap" data-value="Search">
												<input type="file" name="uploadFile2" id="" class="base__fileup-file" title="첨부파일2" />
											</label>
											<input type="text" name="" class="base__fileup-name" readonly="readonly" title="첨부파일이름(읽기전용)" />
										</p>
										<p class="base__form-text">※ Uploadable capacity is 20MB.</p>
									</td>
								</tr>
								<tr>
									<th class="required"><label for="spamKey">Authentication number</label></th>
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
										<p class="base__form-text">Please enter the authentication number next to it!</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!--// Write Table : E -->


					<!-- 개인정보처리방침 : S //-->
					<div class="privacy">
						<h3 class="privacy-tit">Agreement for the collection and use of personal information</h3>

						<div class="privacy-wrap">
							<div class="privacy-header">
								DOW INNOVATION CO., LTD. (hereinafter the “Company”) values users’ personal information and complies with the Act on Promotion of Information and Communications Network Utilization and Information Protection, etc., and the Personal Information Protection Act. Through the Privacy Policy, the Company informs users to what degree and for which purposes their personal information that they provide will be used and what actions will be taken to protect the information. In the event that the Privacy Policy is amended, the Company will notify this fact through the Notice section of the website (or by providing an individual notification). The Company’s Privacy Policy contains the following information:
							</div>
							<div class="privacy-inner">
								<p>1. Personal information collected and the method of collection</p>
								<p>2. Purpose of personal information collection and use</p>
								<p>3. Sharing and provision of the collected personal information</p>
								<p>4. Outsourcing of personal information processing</p>
								<p>5. Period of retention and use of the collected personal information</p>
								<p>6. Procedure and method of personal information disposal</p>
								<p>7. Measures to ensure the security of personal information</p>
								<p>8. Rights of users and their legal representatives and how to exercise those rights</p>
								<p>9. Matters relating to the installation and operation of an automatic personal information collection device and rejecting said device installation and operation</p>
								<p>10. Personal information management officer and division in charge of personal information management</p>
								<p>11. Duty of notice</p>
								<p class="MAT-XS">This Privacy Policy is in effect as of January 1, 2020.</p>
							</div>



							<h4>1. Personal information collected and the method of collection</h4>
							<div class="privacy-inner">
								<p>1) Collected Items: The Company collects the personal information listed below in order to process and manage inquiries about the Company, inquiries on services and products, inquiries on employment, inquiries about the website, reports of fraudulent acts, and reports related to security, etc.:</p>
								<div class="privacy-inner">
									<p>- Required Information: Data subject’s name, company name, e-mail address, and contact information</p>
									<p>- Data subject’s right to deny consent and the disadvantages that result from denial of consent</p>
									<p>• Data subjects have the right to deny consent to the collection of required information.</p>
									<p>• Data subjects have the right to deny consent to the collection of optional information, outside the scope of required information.</p>
									<p>If a data subject refuses consent, it may become impossible to respond to the data subject’s inquiries.</p>
								</div>

							<p class="MAT-S">2) Collection Method: The Company collects personal information in the method specified below.</p>
								<div class="privacy-inner">
									<p>- The “Estimates” menu on the website</p>
								</div>

							</div>


							<h4>2. Purpose of personal information collection and use</h4>
							<div class="privacy-inner">
								<p>The Company uses the collected personal information for the purposes outlined below.</p>
								<div class="privacy-inner">
									<p>- To provide feedback to and manage customer inquiries regarding the Company or its services, products, website, etc.</p>
								</div>
							</div>

							<h4>3. Sharing and provision of the collected personal information</h4>
							<div class="privacy-inner">
								<p>In principle, the Company does not provide the users’ personal information to external parties. Exceptions apply, however, as described in the cases below.</p>
								<div class="privacy-inner">
									<p>- If the user gave prior consent</p>
									<p>- If the information is being provided according to the law or is requested by an investigative agency according to the procedure and method set forth in the law.</p>
								</div>
							</div>

							<h4>4. Outsourcing of personal information processing</h4>
							<div class="privacy-inner">
								<p>In principle, the Company does not outsource the processing of the users’ personal information. Exceptions apply, however, to the following cases.</p>
								<div class="privacy-inner">
									<p>- If users gave prior consent</p>
									<p>- If the outsourcing of information processing is carried out according to the law or is requested by an investigative agency according to the procedure and method set forth in the law.</p>
								</div>
							</div>

							<h4>5. Period of retention and use of the collected personal information</h4>
							<div class="privacy-inner">
								<p>Collected personal information is disposed of without delay after an appropriate response has been provided to a user inquiry about the Company or its services, products, website, etc.</p>
							</div>

							<h4>6. Procedure and method of personal information disposal</h4>
							<div class="privacy-inner">
								<p>In principle, the Company disposes of collected personal information after the purposes of collection and use of the information has been fulfilled. The procedure and method of information disposal is specified below.</p>
								<div class="privacy-inner">
									<p>1) Procedure of Disposal: Once the purpose of personal information collection is fulfilled, the information is stored for a set period of time for information protection as set forth in the Company’s internal policies (Refer to “Period of retention and use of the collected personal information.”) and then it is disposed of. The personal information is not used for purposes other than retention unless required otherwise by the law.</p>
									<p>2) Method of Disposal: Personal information stored in a paper form is disposed of by shredding the paper using a shredder or incinerating the paper and personal information in the form of electronic files is destroyed by deleting the file using a technical method that disables the reproduction of the record.</p>
								</div>
							</div>

							<h4>7. Measures to ensure security of personal information</h4>
							<div class="privacy-inner">
								<p>The Company takes the necessary technical, administrative, and physical measures described below to ensure the safety of personal information.</p>
								<div class="privacy-inner">
									<p>1) Establishment and Implementation of an Internal Management Plan: The Company has established and implemented an internal management plan for personal information protection.</p>
									<p>2) Minimization and Training of Persons in Charge of Personal Information Handling: The Company takes the actions necessary to control access to personal information through the assignment, change, and revocation of access authorities for the database system where personal information is processed. The Company also restricts unauthorized access from external sources to the database system by using a firewall system.</p>
									<p>3) Storage of Access Records and Prevention of Forgery and Alteration: The Company stores and manages records of access to the personal information processing system (web log, summary information) for at least six months and uses a security function to prevent forgery, alteration, theft, and loss of access records.</p>
									<p>4) Technical Measures against Hacking, etc. and Unauthorized Access Control: In order to prevent leakage or damage to personal information via attack or computer virus, the Company installs and periodically updates/inspects a security program, installs its database system in an area to which access from the outside is restricted, and it technically and physically monitors the system. In addition, the Company detects attempts to illegally change stored information while it administers network traffic monitoring.</p>
								</div>
							</div>

							<h4>8. Rights of users and their legal representatives and how to exercise those rights</h4>
							<div class="privacy-inner">
								<p>
									Users and their legal representatives can access or correct their registered personal information at any time. When a user requests to have access or for the correction or deletion of his or her personal information from the personal information management officer over the phone or through e-mail, necessary actions will be taken without delay following the user authentication process.<br />
									If a user requests the correction of an error in his or her personal information, the personal information will not be used or provided to a third party until the correction is completed. In addition, if incorrect personal information has already been provided to a third party, the correction processing result will be notified without delay to the third party in order to ensure the correction of the information provided.<br />
									The Company processes personal information that has been canceled or deleted by the request of the respective user or his or her legal representative according to the “Period of retention and use of the collected personal information” and prevents the information from being accessed or used for other purposes.
								</p>
							</div>

							<h4>9. Matters relating to the installation and operation of an automatic personal information collection device and rejecting said device installation and operation</h4>
							<div class="privacy-inner">
								<p>The Company does not install or operate any device that collects personal information, such as cookies, automatically created in the course of using Internet services.</p>
							</div>

							<h4>10. Personal information management officer and division in charge of personal information management</h4>
							<div class="privacy-inner">
							<!--
								<p>The Company has designated a division in charge of personal information management and a personal information management officer as specified below in order to protect users’ personal information and handle personal information-related complaints.</p>
								<div class="privacy-inner">
									<p>1) Division in Charge of Personal Information Management</p>
									<div class="privacy-inner">
										<p>Division : /p>
										<p>Tel. :</p>
										<p>E-mail : </p>
									</div>
									<p class="MAT-XS">2) Personal Information Management Officer</p>
									<div class="privacy-inner">
										<p>Name : Kim Hye-min</p>
										<p>Tel. :</p>
										<p>E-mail : </p>
									</div>
								-->
								</div>
								<p class="MAT-S">Users can file all personal information protection-related complaints generated in the course of using the Company’s services to the personal information management officer or the division in charge of personal information management. The Company will promptly provide users with an appropriate responses to their complaint or report. For other reports regarding consulting services on personal information breach, please contact the organizations listed below.</p>
							
								<p class="MAT-S">1. Personal Information Dispute Mediation Committee (<a href="http://www.kopico.go.kr" target="_blank">www.kopico.go.kr</a>) : +82-2-2100-2499</p>
								<p>2. Cyber Crime Investigation Division of the Supreme Prosecutors’ Office (<a href="http://cyberbureau.police.go.kr/" target="_blank">http://cyberbureau.police.go.kr/</a>) : +82-2-3480-3571</p>
                                <p>3. Cyber Bureau of the Korean National Police Agency (<a href="http://www.spo.go.kr/" target="_blank">http://www.spo.go.kr/</a>) : (No area code) 182</p>
                                <p class="MAT-S">A person whose rights or interest have been infringed by a disposition taken by the head of a public organization or due to nonfeasance in relation to the provisions of Article 35 (Access to Personal Information), Article 36 (Correction and Erasure of Personal Information), or Article 37 (Suspension, etc. of Processing of Personal Information) of the Personal Information Protection Act can request an administrative trial according to the Administrative Appeals Act. </p>
                                
                                <p class="MAT-S">※ For details on administrative trials, refer to the website of the Ministry of Government Legislation (<a href="http://www.moleg.go.kr" target="_blank">http://www.moleg.go.kr</a>).</p>

							<h4>11. Duty of notice</h4>
							<div class="privacy-inner">
								<p>If the content of the current Privacy Policy is amended, deleted, or modified, the changes will be notified through the Notice section of the website at least seven days prior to the amendment.</p>
							</div>
						</div>
					</div>
						
					<!--// 개인정보처리방침 : E -->

					<!-- 동의 Check : S //-->
					<div class="privacy-check">
						<span class="form-check_item">
							<label class="checkbox-label"><input type="checkbox" name="chkagree" id="chkagree" class="checkbox-obj" value="Y" required="required" aria-required="true"><em class="checkbox-text">I agree to "Agreement for the collection and use of personal information" for customer inquiry.</em></label>
						</span>
					</div>

					<!--// 동의 Check : E -->



				</div>
				<!--// newBoard Write 내용 : E -->
						

					
				<!-- 버튼 : S //-->
				<div class="newBoard__btn" data-aos="fade-up">
					<div class="newBoard__btn-wrap">
						<button class="btn type1" type="submit"><span class="ico write">Make inquiries</span></button>
					</div>
				</div>
				<!--// 버튼 : E -->

			</form>
		</div>
		<!--// newBoard Write : E -->



	</div>
	<!--//★★★★★ Board end ★★★★★-->





