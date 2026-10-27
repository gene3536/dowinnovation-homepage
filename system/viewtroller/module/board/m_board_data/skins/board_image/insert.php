<?php
	require_once $dir2.'insert.header.php';
	require_once $dir2.'lib.default.php';
?>
<!--★★★★★ Board start ★★★★★//-->
	<div class="inner newBoard">

		<?php if(!empty($board_data['BOARD_HEADER'])){ echo $board_data['BOARD_HEADER']; } ?>
		
		<!-- Board Wite : S //-->
		<div class="newBoard__write">

			<!-- newBoard Write 상단 : S //-->
			<div class="newBoard__write-header" data-aos="fade-up">
				<p class="required"><span>표시는 필수 입력 항목입니다.</span></p>
			</div>
			<!--// newBoard Write 상단 : E -->


			<!-- newBoard Write 내용 : S //-->
			<div class="newBoard__write-contents">

				<!-- Write Table : S //-->
				<div class="newBoard__write-table" data-aos="fade-up">

				<form name="insert" id="registFrm" method="post" action="<?php echo site_ssl_http?>/sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data" onsubmit="return $.brdValidation();">
					<input type="hidden" name="mod" value="process">
					<input type="hidden" name="act" value="insert">
					<input type="hidden" name="search" value="<?php echo $search?>">
					<input type="hidden" name="kwd" value="<?php echo $kwd?>">
					<input type="hidden" name="cate" value="<?php echo $cate?>">
					<input type="hidden" name="scode" value="<?php echo $scode?>" />
					<input type="hidden" name="code1" value="<?php echo $code1?>" />
					<input type="hidden" name="code2" value="<?php echo $code2?>" />
					<input type="hidden" name="chkKey" id="chkKey" value="<?php echo $SpamKey?>">
					<input type="hidden" name="token" value="<?php echo site_config_token?>">

					<table cellpadding="0" cellspacing="0" summary="제목, 공지유무, 내용, 첨부파일을 입력할 수 있는 게시글 등록표입니다.">
						<caption>게시글 등록</caption>
						<colgroup>
							<col width="15%">
							<col width="85%"> 
						</colgroup>
						<tbody>
							<?php if($board_data['BOARD_CATEGORY'] == "Y") { ?>
							<tr>
								<th scope="row"><label for="brdata_category">구분</label></th>
								<td><?php echo $cateList2?></td>
							</tr>
							<?php } ?>
							<tr>
								<th id="write_tit" scope="row" class="required"><label for="brdata_subject">제목</label></th>
								<td headers="write_tit"><input type="text" id="brdata_subject" name="brdata_subject" /></td>
							</tr>
							<tr>
								<?php if(S_mb_level <= site_config_level) { ?>
									<th scope="row"><label for="brdata_name">작성자</label></th>
									<td><input type="text" id="brdata_name" name="brdata_name" class="input_w95" value="<?php echo S_mb_name?>" /></td>
								<?php } else { ?>
									<th scope="row">작성자</th>
									<td><?php echo S_mb_name?></td>
								<?php } ?>
							</tr>
							<!-- <tr>
								<th scope="row"><label for="brdata_email">이메일</label></th>
								<td><input type="text" id="brdata_email" name="brdata_email" class="input_w95" /></td>
							</tr>
							<tr>
								<th scope="row"><label for="brdata_hp">연락처</label></th>
								<td><input type="text" id="brdata_hp" name="brdata_hp" class="input_w95" /></td>
							</tr> -->
							<?php if(S_mb_level <= $board_data['BOARD_LV_NOTICE']) { ?>
								<tr>
									<th scope="row"><label for="brdata_notice">공지여부</label></th>
									<td class="calendar">

										<p class="base__form-item">
											<label for="brdata_sdate" class="label-calendar">시작일</label>
											<input type="text" id="brdata_sdate" name="brdata_sdate" value="<?php echo $toDay?>" title="공지시작일">
										</p>
										<p class="base__form-item">
											<label for="brdata_edate" class="label-calendar">종료일</label>
											<input type="text" id="brdata_edate" name="brdata_edate" value="<?php echo $nextDay?>" title="공지종료일" />
										</p>

										<p class="form-check_item">
											<label for="brdata_notice" class="checkbox-label"><input type="checkbox" name="brdata_notice" id="brdata_notice" class="checkbox-obj" value="Y" aria-required="true"><em class="checkbox-text">공지글인 경우 선택 후 기간을 설정해 주세요.</em></label>
										</p>

									</td>
								</tr>
							<?php } ?>
							<?php if($board_data['BOARD_PRIVACY'] == "Y"){ ?>
								<tr>
									<th scope="row"><label for="brdata_privacy">비밀글</label></th>
									<td>
										<p class="form-check_item">
										   <label for="brdata_privacy" class="checkbox-label"><input type="checkbox" name="brdata_privacy" id="brdata_privacy" class="checkbox-obj" value="Y" /><em class="checkbox-text">비밀글을 사용하시려면 체크해주세요.</em></label>
										</p>
									</td>
								</tr>
							<?php } ?>
							<!-- <tr>
								<th scope="row"><label for="thumbFile">목록이미지</label></th>
								<td><?php echo $thumbForm ?></td>
							</tr> -->
							<tr>
								<th scope="col" class="required th-type1" colspan="2"><label for="icd_content">내용</label></th>
							</tr>
							<tr>
								<td class="td-type1" colspan="2">
									<?php $coreClass -> getEditor(site_config_editor, "brdata_content", "100%", "300px", ""); ?>
								</td>
							</tr>
							
							<tr>
								<th scope="row"><label for="uploadFile1">첨부파일</label></th>
								<td>
									<?php echo $updForm2 ?>
									<p class="base__form-text">※ 업로드 가능 용량은 20MB입니다.</p>
								</td>
							</tr>
							<?php if(S_mb_level >= site_config_glevel) { ?>
							<tr>
								<th scope="row"><label for="spamKey">인증번호</label></th>
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
							<?php } ?>
							<?php if(S_mb_level >= site_config_glevel) { ?>
							<tr>
								<th scope="row"><label for="usrwd">비밀번호</label></th>
								<td><input type="password" id="brdata_wd" name="brdata_wd" class="input_w95" maxlength="8" /></td>
							</tr>
							<?php } ?>
						
						</tbody>
					</table>


				</div>
				<!--// Write Table : E -->





			</div>
			<!--// newBoard Write 내용 : E -->
		
			<!-- 버튼 : S //-->
			<div class="newBoard__btn" data-aos="fade-up">
				<div class="newBoard__btn-wrap">
					<?php require_once $dir2.'lib.btn_new2021.php'; ?>
				</div>
			</div>
			<!--// 버튼 : E -->
		</form>

	</div>
	<!--// newBoard Write : E -->


	<?php if(!empty($board_data['BOARD_FOOTER'])){ echo $board_data['BOARD_FOOTER']; } ?>
</div>
<!--//★★★★★ Board end ★★★★★-->
