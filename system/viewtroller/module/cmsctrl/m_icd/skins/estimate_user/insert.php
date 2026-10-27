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

<script>
	$(document).ready(function(){
		$("#insertForm").validate({
			rules : {
				icd_name :{required:true},
				icd_fld2 :{required:true},
				icd_title :{required:true},
				icd_fld3 :{required:true},
				icd_content :{required:true},
				spamKey : {requried:true},
				chkagree : {requried:true}
			},
			messages : {
				icd_name :{required:"이름을 입력하세요."},
				icd_fld2 :{required:"이메일을 입력하세요."},
				icd_title :{required:"단체/회사명을 입력하세요."},
				icd_fld3 :{required:"연락처를 입력하세요."},
				icd_content :{required:"문의내용을 입력하세요."},
				spamKey : {requried:"인증문자를 입력하세요."},
				chkagree : {requried:"약관에 동의 하세요."}
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

<?=$menuClass->get_inquiry_header();?>

<form name="insertForm" id="insertForm" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" name="mod" value="process" />
	<input type="hidden" name="act" value="insert" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
	<input type="hidden" name="chkKey" id="chkKey" value="<?php echo $SpamKey?>">
	<input type="hidden" name="rtMod" value="insert" />
	<input type="hidden" name="rtMsg" value="<?php echo base64_encode("정상적으로 등록되었습니다.") ?>" />
 
				<div class="news_contents_txt margint30">		
					<div class="news_contents_list">
						<table class="tbl-type02">
							<tbody>
								<tr>
									<td class="col_01">이름 *</td>
									<td class="col_02"><input type="text" class="name" name="icd_name" id="icd_name" required></td>
								</tr>

								<tr>
									<td class="col_01">직책</td>
									<td class="col_02"><input type="text" class="name" name="icd_fld1" id="icd_fld1"></td>
								</tr>

								<tr>
									<td class="col_01">이메일 *</td>
									<td class="col_02"><input type="text" class="name" name="icd_fld2" id="icd_fld2" required></td>
								</tr>

								<tr>
									<td class="col_01">단체/회사명 *</td>
									<td class="col_02"><input type="text" class="name" name="icd_title" id="icd_title" required></td>
								</tr>

								<tr>
									<td class="col_01">연락처 *</td>
									<td class="col_02"><input type="text" class="name" name="icd_fld3" id="icd_fld3" required></td>
								</tr>

								<tr>
									<td class="col_01">문의내용 *</td>
									<td class="col_02">
										<textarea id="icd_content" name="icd_content" cols="30" rows="10" class="left" required></textarea>
									</td>
								</tr>
								<tr>
									<td class="col_01">인증번호 *</td>
									<td class="col_02">
										<input type="text" id="spamKey" name="spamKey" class="name" maxlength="6" required>
										<img src="/base/imgs/spamkey/no_<?php echo $d[0]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[0]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[1]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[1]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[2]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[2]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[3]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[3]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[4]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[4]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[5]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[5]?>">
										 ※ 옆의 인증번호를 입력해주세요
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<!-- 개인정보수집항목 -->
				<div class="contents_box margint50">
					<div>
						<h2 class="sub-content-tit type2 text-center fc-fff">개인정보 수집 및 이용 동의</h2>
						<div class="padding25">
							<div class="pre-paragraph">
								<h2 class="sub-content-subject fc-fff">수집하는 개인정보 항목</h2>
								<p class='fc-fff'>회사는 회원가입, 상담, Contact Us, 서비스 신청 등등을 위해 아래와 같은 개인정보를 수집하고 있습니다.</p>
								<div class="news_contents-box">
									<p class='fc-fff'>수집항목 : 이름, 직책, 이메일, 단체/회사명, 연락처, 문의내용 등</p>
									<p class='fc-fff'>개인정보 수집방법 : 홈페이지(sonicwall.coreit.co.kr)</p>
								</div>
							</div>

							<div class="pre-paragraph">
								<h2 class="sub-content-subject fc-fff paddingt30">개인정보의 수집 및 이용목적</h2>
								<p class='fc-fff'>회사는 수집한 개인정보를 다음의 목적을 위해 활용합니다.</p>
								<div class="news_contents-box">
									<p class='fc-fff'>기타 고객의 제품문의에 대한 답변 및 제품자료 안내합니다.</p>
								</div>
							</div>

							<div class="pre-paragraph">
								<h2 class="sub-content-subject fc-fff paddingt40">개인정보의 보유 및 이용기간</h2>
								<p class='fc-fff' style="line-height:35px">원칙적으로, 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다. 단, 다음의 정보에 대해서는 아래의 이유로 명시한 기간 동안 보존합니다.<br />
									보존 항목 : 이름, 직책, 이메일, 단체/회사명, 연락처, 문의내용 등<br />
									보존 근거 : 사이트 운영 기간내 내용 확인을 위한 보존<br />
									보존 기간 : 본사이트 운영기간내<br />
								</p>
							</div>
								
							<div class="chk-wrap right paddingt30">
								<input type="checkbox" name="chkagree" id="chkagree" class="vcen5" value="Y" required /> <label for="chkagree2018-07-10" class="f17 b">고객 문의를 위한 [개인정보 수집 및 이용 동의]에 동의합니다.</label>
							</div>
						</div>
					</div>
				</div>
				<!--// 개인정보수집항목 -->

				<!-- 버튼 -->
				<div class="news_contents_btn">
					<div class="news_contents_btn_box">
						<!--a href="" class="left cancel">취소</a-->
						<input type="submit" value="확인" class="left ok">
					</div>
				</div>


</form>

