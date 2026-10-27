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
				$(this).attr('value','ショートカットを閉じる');	
				$(this).attr('class','close');
			}else{
				$('div.cke_sc_def').hide('up');
				$(this).attr('value','ショートカットキー一覧');	
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
				chkagree : {required:true}
			},
			messages : {
				icd_name :{required:"名前を入力してください。"},
				icd_title :{required:"会社名を入力してください。"},
				icd_fld3 :{required:"連絡先を入力してください。"},
				icd_fld2 :{required:"メールアドレスを入力してください。"},
				icd_content :{required:"お問い合わせ内容を入力してください。"},
				spamKey : {required:"認証文字を入力してください。"},
				chkagree : {required:"規約に同意してください。"}
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
			<p class="required"><span>表示は必須入力項目です。</span></p>
		</div>
		<!--// newBoard Write 상단 : E -->
		<form name="insertForm" id="insertForm" method="post" enctype="multipart/form-data" action="sub.php?menukey=<?php echo $menukey?>" >
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
									<th class="required"><label for="icd_name">名前</label></th>
									<td>
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_name" id="icd_name" required>
										</span>
									</td>
									<th class="required"><label for="icd_title">会社</label></th>
									<td>
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_title" id="icd_title" required>
										</span>
									</td>
								</tr>

								<tr>
									<th class="required"><label for="icd_fld3">電話番号</label></th>
									<td>
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_fld3" id="icd_fld3" required>
										</span>
									</td>
									<th class="required"><label for="icd_fld1">職責</label></th>
									<td>
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_fld1" id="icd_fld1">
										</span>
									</td>
								</tr>

								<tr>
									<th class="required"><label for="icd_fld2">メール</label></th>
									<td colspan="3">
										<span class="default_input">
											<input type="text" class="default_input-text" name="icd_fld2" id="icd_fld2" required>
										</span>
									</td>
								</tr>

								<tr>
									<th class="required"><label for="icd_content">お問い合わせの内容</label></th>
									<td colspan="3" style="text-align:left;">
										<input type="button" name="btn_keys" class="open" value="ショートカットキー一覧" />
										<div class="cke_sc_def" style="display:none;">
										<dl>
											<dt>CTRL+B</dt>
											<dd>文字太字</dd>
											<dt>CTRL+U</dt>
											<dd>文字下線</dd>
											<dt>CTRL+I</dt>
											<dd>文字イタリック</dd>
											<dt>CTRL+D</dt>
											<dd>文字取り消し線</dd>
											<dt>TAB</dt>
											<dd>インデント</dd>
											<dt>SHIFT+TAB</dt>
											<dd>インデント</dd>
											<dt>CTRL+K</dt>
											<dd>リンクをかける</dd>
											<dt>CTRL+F</dt>
											<dd>単語を検索</dd>
											<dt>CTRL+H</dt>
											<dd>単語置換</dd>
											<dt>CTRL+A</dt>
											<dd>全選択</dd>
										</dl>
										</div>
										<?php $coreClass -> getEditor(site_config_editor, "icd_content", "100%", "300px", ""); ?>
									</td>
								</tr>
								<tr>
									<th class="th-type2">添付ファイル</th>
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
										<p class="base__form-text">※ アップロード可能な容量は20MBです。</p>
									</td>
								</tr>
								<tr>
									<th class="required"><label for="spamKey">認証番号</label></th>
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
										<p class="base__form-text">横の認証番号を入力してください</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!--// Write Table : E -->


					<!-- 개인정보처리방침 : S //-->
					<div class="privacy-wrap">
						<h3 class="privacy-tit" data-aos="fade-up">個人情報の収集および使用に関する合意</h3>
						<div class="privacy-wrap" data-aos="fade-up">
							<div class="privacy-header">
								DWIZ CO., LTD.（以下「会社」）は、利用者の個人情報を重要視し、「情報通信網利用促進及び情報保護」に関する法律と個人情報保護法等を遵守しています。会社は、個人情報の処理方針を通じて利用者様が提供する個人情報がどのような用途と方式で利用されており、個人情報保護のためにどのような措置が取られているかどうかお知らせします。会社は、個人情報の処理方針を改定する場合、ウェブサイトのお知らせ（または個別公知）を介して公知します。会社の個人情報の処理方針は、次のような内容を含んでいます。
							</div>
							<div class="privacy-inner">
								<p> 1。収集する個人情報収集方法</p>
<p> 2。個人情報の収集及び利用目的</p>
<p> 3。収集した個人情報の共有及び提供</p>
<p> 4。個人情報の処理委託</p>
<p> 5。収集した個人情報の保有及び利用期間</p>
<p> 6。個人情報の破棄手続き及び方法</p>
<p> 7。個人情報の安全性確保の措置</p>
<p> 8。利用者及び法定代理人の権利とその行使方法</p>
<p> 9。個人情報の自動収集装置の設置•運営及びその拒否に関する事項</p>
<p> 10。個人情報管理責任者及び個人情報担当部署</p>
<p> 11。告知の義務</p>
<p class = "MAT-XS">この方針は、2020年01月01日から施行されます。</p>
							</div>



							<h4>1.収集する個人情報収集の方法</h4>
							<div class="privacy-inner">
								<p>1）収集項目会社は、会社に関するお問い合わせ、サービス/商品のお問い合わせ、採用のお問い合わせ、ホームページお問い合わせは、不正の情報提供、セキュリティ、情報提供などの管理をするために以下のような個人情報を収集しています。</p>
								<div class="privacy-inner">
									
<p>  - 必要な情報：名前、会社名、電子メール、連絡先</p>
<p>  - 同意を拒否する権利と同意を拒否による不利益</p>
<p>•必要な情報の収集に対する同意を拒否する権利があります。</p>
<p>•必須の情報のほか、選択情報収集に対する同意を拒否する権利があります。 </p>
<p>ただし、同意を拒否した場合お問い合わせに対する応対ができないことがあります。</p>
								</div>

							<p class="MAT-S">
2）収集方法会社は、次のような方法で個人情報を収集します。</p>
								<div class="privacy-inner">
									<p>
- ホームページ「見積お問い合わせ」メニュー</p>
								</div>

							</div>


							<h4>
2.個人情報の収集及び利用目的</h4>
							<div class="privacy-inner">
								
<p>会社は収集した個人情報を、以下の目的のために利用します。</p>
<div class = "privacy-inner">
<p>  - 会社に関するお問い合わせ、サービス/商品のお問い合わせ、ホームページお問い合わせなどのお問い合わせへのフィードバックを提供し、管理</p>
								</div>
							</div>

							<h4> 3。収集した個人情報の共有及び提供</h4>
<div class = "privacy-inner">
<p>当社は、利用者の個人情報を、原則として外部に提供しません。ただし、以下の場合は例外とします。</p>
<div class = "privacy-inner">
<p>  - 利用者が事前に同意した場合、</p>
<p>  - 法令の規定に基づき、または捜査目的で法令に定められた手続きと方法により捜査機関の要求がある場合は、</p>
</div>
</div>

							
<h4> 4。個人情報の処理委託</h4>
<div class = "privacy-inner">
<p>当社は、利用者の個人情報を、原則として外部に処理委託していません。ただし、以下の場合は例外とします。</p>
<div class = "privacy-inner">
<p>  - 利用者が事前に同意した場合、</p>
<p>  - 法令の規定に基づき、または捜査目的で法令に定められた手続きと方法により捜査機関の要求がある場合は、</p>
</div>
</div>

							<h4> 5。収集した個人情報の保有及び利用期間</h4>
<div class = "privacy-inner">
<p>会社に関するお問い合わせは、サービス/商品のお問い合わせ、ホームページお問い合わせなどのお問い合わせへのフィードバックが提供される時点で、その情報を遅滞なく破棄します。</p>
</div>

<h4> 6。個人情報の破棄手続き及び方法</h4>
<div class = "privacy-inner">
<p>当社は、原則的に個人情報収集及び利用目的が達成された後は、その情報を遅滞なく破棄します。破棄手続き及び方法は次のとおりです。</p>
<div class = "privacy-inner">
<p> 1）破棄手続きお客様が入力した情報は、目的が達成された後、内部方針による情報保護の事由により、（保有及び利用期間参照）一定期間保存された後、破棄されます。同個人情報は法律による場合ではなくては保有されている以外の他の目的に利用されていません。</p>
<p> 2）破棄の方法、紙に出力された個人情報は、シュレッダーで粉砕したり焼却を通じて破棄し、電子ファイルの形で保存された個人情報は記録を再生することができない技術的方法を使用して削除します。</p>
</div>
</div>

							
<h4> 7。個人情報の安全性確保の措置</h4>
							<div class="privacy-inner">
								
<p>当社は、次のように安全性の確保に必要な技術的、管理的、物理的措置をしています。</p>
								<div class="privacy-inner">
									<p> 1）内部管理計画の策定と実施企業の内部管理計画して個人情報を保護するために実行します。</p>
<p> 2）個人情報の処理担当者の最小化と教育の個人情報を処理するデータベースシステムへのアクセス権の付与、変更、および抹消を通じて個人情報へのアクセス制御のために必要な措置をしており、侵入遮断システムを利用外部からの不正なアクセスを制御しています。</p>
									
<p> 3）接続記録の保管及び偽造・変造防止、個人情報の処理システムに接続した記録（ウェブログ、要約情報など）を、少なくとも6ヶ月以上保管、管理しており、接続記録が偽造・変造、盗難、紛失されないように、セキュリティ機能を使用しています。</p>
<p> 4）ハッキングなどに備えた技術的対策と不正者に対するアクセスコントロール会社はハッキングやコンピュータウイルスなどによる個人情報の流出や毀損を防ぐために、セキュリティプログラムをインストールして、周期的な更新•点検をし、外部からのアクセスが制御された区域にシステムを設置し、技術/物理的に監視および遮断しています。また、ネットワークトラフィックの制御（Monitoring）はもちろん、違法に情報を変更するなどの試みを検出しています。</p>
								</div>
							</div>

							<h4> 8。利用者及び法定代理人の権利とその行使方法</h4>
<div class = "privacy-inner">
<p>利用者と法定代理人はいつでも登録されている利用者の個人情報を閲覧したり訂正することができます。個人情報の閲覧、訂正、削除等の要求は、個人情報の管理責任者に電話、またはe-mailでリクエストすると、本人確認の手続きを経た後、遅滞なく措置します。 <br />利用者が個人情報のエラーの訂正を要求された場合には、訂正を完了するまで、当該個人情報を利用または提供しません。また、誤った個人情報を第三者にすでに提供した場合には、訂正処理の結果を第3者に遅滞なく通​​知して訂正がなされるようにします。<br />会社は、利用者もしくは法定代理人の要請によって解約または削除された個人情報は、「会社が収集する個人情報の保有及び利用期間 "に記載されてところにより処理し、それ以外の用途で閲覧または利用できないように処理しています。</p>
</div>

							
<h4> 9。個人情報の自動収集装置の設置•運営及びその拒否に関する事項</h4>
<div class = "privacy-inner">
<p>クッキーなどのインターネットサービス利用時に自動生成される個人情報を収集する装置を運営していません。</p>
</div>

<h4> 10。個人情報管理責任者及び個人情報担当部署</h4>
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
								<p class = "MAT-S"> 1。個人情報紛争調整委員会（<a href="http://www.kopico.go.kr" target="_blank"> www.kopico.go.kr </a>）：02-2100-2499 </p>
<p> 2。大検察庁サイバー犯罪団：02-3480-3571（<a href="http://www.spo.go.kr/" target="_blank"> http://www.spo.go.kr/</a>）</p>
<p> 3。警察庁サイバー安全局：（局番なし）182（<a href="http://cyberbureau.police.go.kr/" target="_blank"> http://cyberbureau.police.go.kr/ </a> ）</p>
<p class = "MAT-S">「個人情報保護法」第35条（個人情報の閲覧）、第36条（個人情報の訂正・削除）、第37条（個人情報の処理停止など）の規定によるニーズにして公共機関の長が行った処分又は不作為によって権利または利益の侵害を受けた者は、行政審判法で定めるところにより、行政審判を請求することができます。</p>

<p class = "MAT-S">※行政審判についての詳細は法制処（<a href="http://www.moleg.go.kr" target="_blank"> http：//www.moleg .go.kr </a>）ホームページを参照してください。</p>
							</div>

							
<h4> 11。告知の義務</h4>
<div class = "privacy-inner">
<p>現在の個人情報の処理方針の内容の追加、削除、変更がある場合には、改正少なくとも7日前からホームページの「お知らせ」を介して通知することです。</p>
</div>
						</div>
					</div>
					
					<!--// 개인정보처리방침 : E -->

					<!-- 동의 Check : S //-->
					<div class="privacy-check">
						<span class="form-check_item">
							<label class="checkbox-label"><input type="checkbox" name="chkagree" id="chkagree" class="checkbox-obj" value="Y" required="required" aria-required="true"><em class="checkbox-text">製品に関するお問い合わせのための[個人情報の収集および利用に同意]に同意します。</em></label>
						</span>
					</div>

					<!--// 동의 Check : E -->



				</div>
				<!--// newBoard Write 내용 : E -->
						

					
				<!-- 버튼 : S //-->
				<div class="newBoard__btn" data-aos="fade-up">
					<div class="newBoard__btn-wrap">
						<button class="btn type1" type="submit"><span class="ico write">確認</span></button>
					</div>
				</div>
				<!--// 버튼 : E -->

			</form>
		</div>
		<!--// newBoard Write : E -->



	</div>
	<!--//★★★★★ Board end ★★★★★-->





