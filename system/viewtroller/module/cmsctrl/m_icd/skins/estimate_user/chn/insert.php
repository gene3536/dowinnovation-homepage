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
				$(this).attr('value','关闭捷径');	
				$(this).attr('class','close');
			}else{
				$('div.cke_sc_def').hide('up');
				$(this).attr('value','快捷键');	
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
				icd_name :{required:"姓名输入"},
				icd_title :{required:"公司名称输入"},
				icd_fld3 :{required:"联系方式输入"},
				icd_fld2 :{required:"电子邮箱输入"},
				icd_content :{required:"咨询内容输入"},
				spamKey : {required:"认证号码输入"},
				chkagree : {required:"请同意条款。"}
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
			<p class="required"><span>必填项目。</span></p>
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
									<th class="required"><label for="icd_name">姓名</label></th>
									<td>
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_name" id="icd_name" required>
										</span>
									</td>
									<th class="required"><label for="icd_title">公司</label></th>
									<td>
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_title" id="icd_title" required>
										</span>
									</td>
								</tr>

								<tr>
									<th class="required"><label for="icd_fld3">电话号码</label></th>
									<td>
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_fld3" id="icd_fld3" required>
										</span>
									</td>
									<th class="required"><label for="icd_fld1">职务</label></th>
									<td>
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_fld1" id="icd_fld1">
										</span>
									</td>
								</tr>

								<tr>
									<th class="required"><label for="icd_fld2">电子邮件</label></th>
									<td colspan="3">
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_fld2" id="icd_fld2" required>
										</span>
									</td>
								</tr>

								<tr>
									<th class="required"><label for="icd_content">咨询内容</label></th>
									<td colspan="3" style="text-align:left;">
										<input type="button" name="btn_keys" class="open" value="快捷键" />
										<div class="cke_sc_def" style="display:none;">
										<dl>
											<dt>CTRL+B</dt>
											<dd>粗体字</dd>
											<dt>CTRL+U</dt>
											<dd>下划线字母</dd>
											<dt>CTRL+I</dt>
											<dd>斜体</dd>
											<dt>CTRL+D</dt>
											<dd>角色删除线</dd>
											<dt>TAB</dt>
											<dd>缩进</dd>
											<dt>SHIFT+TAB</dt>
											<dd>缩进</dd>
											<dt>CTRL+K</dt>
											<dd>连结中</dd>
											<dt>CTRL+F</dt>
											<dd>单词搜索</dd>
											<dt>CTRL+H</dt>
											<dd>替换单词</dd>
											<dt>CTRL+A</dt>
											<dd>全选</dd>
										</dl>
										</div>
										<?php $coreClass -> getEditor(site_config_editor, "icd_content", "100%", "200px", ""); ?>
									</td>
								</tr>
								<tr>
									<th class="th-type2">附件</th>
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
										<p class="base__form-text">※ 可上传容量为 20MB。</p>
									</td>
								</tr>
								<tr>
									<th class="required"><label for="spamKey">认证号码</label></th>
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
										<p class="base__form-text">请输入旁边的认证号码。</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!--// Write Table : E -->


					<!-- 개인정보처리방침 : S //-->
					<div class="privacy">
						<h3 class="privacy-tit">收集和使用个人信息的协议</h3>
						<div class="privacy-wrap">
							<div class="privacy-header">
								DOW INNOVATION CO., LTD.（以下简称为“公司”）重视用户的个人信息，遵守《信息通信网使用促进及信息保护》相关法律和《个人信息保护法》等。公司通过个人信息处理方针，告知用户其所提供的个人信息用于何种用途、以什么方式使用，以及为保护个人信息将采取何种措施。公司修订个人信息处理方针时，将通过网站公告事项（或单独通知）进行通知。公司个人信息处理方针的内容如下。
							</div>
							<div class="privacy-inner">
								<p>1.收集的个人信息及收集方法</p>
								<p>2.个人信息的收集及使用目的</p>
								<p>3.所收集个人信息的共享及提供</p>
								<p>4.委托处理个人信息</p>
								<p>5.所收集个人信息的保留及使用期限</p>
								<p>6.个人信息的销毁流程及方法</p>
								<p>7.确保个人信息安全性的措施</p>
								<p>8.用户及法定代理人的权利及其行使方法</p>
								<p>9.个人信息自动收集装置的安装、运营，以及与拒绝相关事项</p>
								<p>10.个人信息管理负责人及个人信息负责部门</p>
								<p>11.告知义务</p>
								<p class="MAT-XS">本方针于2020年01月01日起实施。</p>
							</div>



							<h4>1.收集的个人信息及收集方法</h4>
							<div class="privacy-inner">
								<p>1）收集项目：为管理公司相关咨询、服务和商品咨询、录用咨询、官方网站咨询、违法行为举报、安全问题举报等事宜，公司收集如下个人信息。</p>
								<div class="privacy-inner">
									<p>-必要信息：姓名、公司名称、电子邮箱、联系方式</p>
									<p>-您有权拒绝同意及因拒绝同意而导致的不利后果</p>
									<p>• 您有权拒绝同意收集必要信息。</p>
									<p>• 您有权拒绝同意收集必要信息外的选择性信息。 </p>
									<p>但拒绝同意时，有可能无法就所咨询的事项进行答复。</p>
								</div>

							<p class="MAT-S">2）收集方法：公司通过下列方法收集个人信息。</p>
								<div class="privacy-inner">
									<p>-官方网站“估价咨询”菜单</p>
								</div>

							</div>


							<h4>2.个人信息的收集及使用目的</h4>
							<div class="privacy-inner">
								<p>公司收集的个人信息将用于以下目的。</p>
								<div class="privacy-inner">
									<p>- 提供并管理公司相关咨询、服务和商品咨询、官方网站咨询等与客户咨询相关的反馈</p>
								</div>
							</div>

							<h4>3.所收集个人信息的共享及提供</h4>
							<div class="privacy-inner">
								<p>原则上公司不会将用户的个人信息提供给外部。但以下情况例外。</p>
								<div class="privacy-inner">
									<p>- 用户事先同意时</p>
									<p>- 根据法令规定或基于调查目的，调查机构按照法令规定的流程和方法，请求提供信息时</p>
								</div>
							</div>

							<h4>4.委托处理个人信息</h4>
							<div class="privacy-inner">
								<p>本公司原则上不委托外部处理用户的个人信息。但是，以下情况除外。</p>
								<div class="privacy-inner">
									<p>- 用户事先同意时</p>
									<p>- 根据法令规定或基于调查目的，调查机构按照法令规定的流程和方法，请求提供信息时</p>
								</div>
							</div>

							<h4>5.所收集个人信息的保留及使用期限</h4>
							<div class="privacy-inner">
								<p>提供公司相关咨询、服务和商品咨询、官方网站咨询等与客户咨询相关的反馈后，将立即销毁相关信息。</p>
							</div>

							<h4>6.个人信息的销毁流程及方法</h4>
							<div class="privacy-inner">
								<p>原则上公司达成个人信息收集及使用目的后，将立即销毁相关信息。销毁流程及方法如下所示。</p>
								<div class="privacy-inner">
									<p>1）销毁流程：达成目的后，根据基于内部方针的信息保护事由（参考保留及使用期限），将客户所输入的信息保存一定期间后销毁。若非法律规定的情况，该个人信息不会被用于保留之外的其他目的。</p>
									<p>2）销毁方法：将打印成纸张的个人信息用粉碎机粉碎或通过焚烧进行销毁，保存为电子文件形式的个人信息则使用无法恢复记录的技术性方法进行删除。</p>
								</div>
							</div>

							<h4>7.确保个人信息安全性的措施</h4>
							<div class="privacy-inner">
								<p>公司采取确保安全性所需的技术、管理及物理措施，详细内容如下。</p>
								<div class="privacy-inner">
									<p>1) 制定并实施内部管理计划：为保护个人信息，公司制定并实施内部管理计划。</p>
									<p>2) 个人信息处理负责人的最少化及培训：针对处理个人信息的数据库系统，通过赋予、变更、注销访问权限，采取限制访问个人信息所需的措施，同时使用入侵拦截系统，控制从外部擅自访问。</p>
									<p>3) 保管访问记录及防止伪造和变造：访问个人信息处理系统的记录（网页日志、概要信息等）最少保管并管理六个月以上，同时使用安全功能，以防止访问记录被伪造、变造或遭窃、丢失。</p>
									<p>4)应对黑客入侵等的技术对策及未获得许可者的访问限制：为阻止因黑客入侵或电脑病毒等导致的个人信息泄漏及损毁，公司安装安全程序，定期进行更新和检查，在限制外部访问的区域安装系统，通过技术和物理手段进行监控及拦截。此外，管制（Monitoring）网络通信量，同时探知非法变更信息等尝试。</p>
								</div>
							</div>

							<h4>8.用户及法定代理人的权利及其行使方法</h4>
							<div class="privacy-inner">
								<p>用户及法定代理人可随时阅览或更正已登记的用户个人信息。用户通过电话或邮件，向个人信息管理负责人提出阅览、更正及删除个人信息等请求时，确认为本人后将立即采取措施。
用户就个人信息的错误请求更正时，在完成更正之前，不使用或提供相关个人信息。此外，已向第三方提供错误的个人信息时，应立即告知第三方更正处理结果，以让第三方完成更正。
针对根据用户或法定代理人请求而注销或删除的个人信息，公司将按照“公司收集的个人信息保留及使用期限”中的明确规定进行处理，确保其不能基于其他用途被阅览或使用。</p>
							</div>

							<h4>9.个人信息自动收集装置的安装、运营，以及与拒绝相关事项</h4>
							<div class="privacy-inner">
								<p>针对使用Cookie等网络服务时自动生成的个人信息，不运行收集装置。</p>
							</div>

							<h4>10.个人信息管理负责人及个人信息负责部门</h4>
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
								<p class="MAT-S">1. 个人信息纠纷调解委员会((<a href="http://www.kopico.go.kr" target="_blank">www.kopico.go.kr</a>) : 02-2100-2499</p>
								<p>2. 大检察厅网络犯罪调查团 : 02-3480-3571 (<a href="http://www.spo.go.kr/" target="_blank">http://www.spo.go.kr/</a>)</p>
								<p>3. 警察厅网络安全局 : (无区号) 182 (<a href="http://cyberbureau.police.go.kr/" target="_blank">http://cyberbureau.police.go.kr/</a>)</p>
								<p class="MAT-S">针对根据《个人信息保护法》第三十五条（阅览个人信息）、第三十六条（更正、删除个人信息）、第三十七条（停止处理个人信息等）的规定提出的请求，因公共机关负责人实施的处分或不作为而导致权利或利益受到侵害者，可根据《行政审判法》的规定，请求进行行政审判。</p>
								
								<p class="MAT-S">※行政审判相关详细事项请参考法制处官方网站 (<a href="http://www.moleg.go.kr" target="_blank">http://www.moleg.go.kr</a>) 。</p>
							</div>

							<h4>11.告知义务</h4>
							<div class="privacy-inner">
								<p>当前个人信息处理方针的内容有添加、删除及更正时，应至少于修订7日前起，通过官方网站的“公告事项”进行告知。</p>
							</div>
						</div>
					</div>
					<!--// 개인정보처리방침 : E -->

					<!-- 동의 Check : S //-->
					<div class="privacy-check">
						<span class="form-check_item">
							<label class="checkbox-label"><input type="checkbox" name="chkagree" id="chkagree" class="checkbox-obj" value="Y" required="required" aria-required="true"><em class="checkbox-text">本人同意用于客户咨询的[收集并使用个人信息]条款。</em></label>
						</span>
					</div>

					<!--// 동의 Check : E -->



				</div>
				<!--// newBoard Write 내용 : E -->
						

					
				<!-- 버튼 : S //-->
				<div class="newBoard__btn" data-aos="fade-up">
					<div class="newBoard__btn-wrap">
						<button class="btn type1" type="submit"><span class="ico write">咨询</span></button>
					</div>
				</div>
				<!--// 버튼 : E -->

			</form>
		</div>
		<!--// newBoard Write : E -->



	</div>
	<!--//★★★★★ Board end ★★★★★-->





