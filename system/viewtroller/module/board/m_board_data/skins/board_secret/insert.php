<?php
	require_once $dir2.'insert.header.php';
	require_once $dir2.'lib.default.php';
?>

<?php if(!empty($board_data['BOARD_HEADER'])){ echo $board_data['BOARD_HEADER']; } ?>

<form name="insert" id="registFrm" method="post" action="<?php echo site_ssl_https?>/sub.php?menukey=<?php echo $menukey?>" enctype="multipart/form-data" onsubmit="return $.brdValidation();">
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

<div class="board_w mt_40">
	<div class="sb_form">
		<table class="sv_table" summary="<?php echo site_menu_locTitle ?> 게시판의 제목, 구분, 작성자, 이메일, 연락처, 공지여부, 비밀글여부, 첨부파일, 내용, 인증번호, 비밀번호 등의 정보를 목록으로 제공하고 있다.">
	        <caption><?php echo site_menu_locTitle ?> 게시글 등록</caption>
			<tr>
				<th class="w20" id="write_tit" scope="row"><label for="brdata_subject">제목</label></th>
				<td class="w80" headers="write_tit"><input type="text" id="brdata_subject" name="brdata_subject" class="input_w95" /></td>
			</tr>
			<?php if($board_data['BOARD_CATEGORY'] == "Y") { ?>
				<tr>
					<th scope="row"><label for="brdata_category">구분</label></th>
					<td>
						<?php echo $cateList2?>
					</td>
				</tr>
			<?php } ?>
			
			<tr>
				<?php if(S_mb_level <= site_config_level) { ?>
					<th scope="row"><label for="brdata_name">작성자</label></th>
					<td><input type="text" id="brdata_name" name="brdata_name" class="input_w20" value="<?php echo S_mb_name?>" /></td>
				<?php } else { ?>
					<th scope="row">작성자</th>
					<td><?php echo S_mb_name?></td>
				<?php } ?>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_email">이메일</label></th>
				<td><input type="text" id="brdata_email" name="brdata_email" class="input_w95" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_hp">연락처</label></th>
				<td><input type="text" id="brdata_hp" name="brdata_hp" class="input_w95" /></td>
			</tr>
			<?php if(S_mb_level <= $board_data['BOARD_LV_NOTICE']) { ?>
				<tr>
					<th scope="row"><label for="brdata_notice">공지여부</label></th>
					<td>
						<input type="checkbox" id="brdata_notice" name="brdata_notice" value="Y" style="vertical-align:middle" /> 공지글인 경우 기간을 설정해 주세요.<br />
						<input type="text" id="brdata_sdate" name="brdata_sdate" value="<?php echo $toDay?>" class="input_w20" title="공지시작일" />
						-
						<input type="text" id="brdata_edate" name="brdata_edate" value="<?php echo $nextDay?>" class="input_w20" title="공지종료일" />					
					</td>
				</tr>
			<?php } ?>
				<tr>
					<th scope="row"><label for="brdata_privacy">비밀글여부</label></th>
					<td>
						<input type="checkbox" id="brdata_privacy" name="brdata_privacy2" value="Y" title="비밀글" style="vertical-align:middle" checked disabled />
						<input type="hidden" name="brdata_privacy" value="Y" style="vertical-align:middle" /> <label for="brdata_privacy">비밀글 (*신청내용은 비밀글로 작성됩니다.)</label>
					</td>
				</tr>
			<!-- <tr>
				<th scope="row"><label for="thumbFile">목록이미지</label></th>
				<td><?php echo $thumbForm ?></td>
			</tr> -->

			<tr>
				<td colspan="2">
					<?php $coreClass -> getEditor(site_config_editor, "brdata_content", "100%", "200px", ""); ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="uploadFile1">첨부파일</label></th>
				<td><?php echo $updForm ?></td>
			</tr>
			<?php if(S_mb_level >= site_config_glevel) { ?>
			<tr>
				<th scope="row"><label for="spamKey">인증번호</label></th>
				<td>
					<input type="text" id="spamKey" name="spamKey" class="input_w20" maxlength="6">
					<img src="/base/imgs/spamkey/no_<?php echo $d[0]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[0]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[1]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[1]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[2]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[2]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[3]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[3]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[4]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[4]?>"><img src="/base/imgs/spamkey/no_<?php echo $d[5]?>.gif" style="vertical-align:middle; width:18px;" alt="<?php echo $d[5]?>">
					 ※ 옆의 인증번호를 입력해주세요
				</td>
			</tr>
			<?php } ?>
			<?php if(S_mb_level >= site_config_glevel) { ?>
			<tr>
				<th scope="row"><label for="usrwd">비밀번호</label></th>
				<td><input type="password" id="brdata_wd" name="usrwd" class="input_w20" maxlength="8" /></td>
			</tr>
			<?php } ?>
		</table>
		
	<?php require_once $dir2.'lib.btn.php'; ?>

	</div>
</div>
</form>

<?php if(!empty($board_data['BOARD_FOOTER'])){ echo $board_data['BOARD_FOOTER']; } ?>