<?php
	/** 140617 */
	require_once $dir2.'insert.header.php';
	require_once $dir2.'lib.default.php';
?>
<script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script type="text/javascript" src="/base/js/home/daum.postcode.js"></script>


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
	<input type="hidden" name="brdata_privacy" value="Y" />

<div class="board_w">
	
	<?php if(!empty($board_data['BOARD_HEADER'])) { echo $board_data['BOARD_HEADER']; } ?>

	<div class="sb_form">
		<table class="sv_table" summary="<?php echo site_menu_locTitle ?> 게시판의 제목, 구분, 작성자, 이메일, 연락처, 공지여부, 비밀글여부, 첨부파일, 내용, 인증번호, 비밀번호 등의 정보를 목록으로 제공하고 있다.">
		<caption><?php echo site_menu_locTitle ?> 게시글 등록</caption>
		<colgroup>
			<col width="23%">
			<col width="77%">
		</colgroup>
		<tbody>
			<tr>
				<th id="write_tit" scope="row"><label for="brdata_subject">제안과제명</label></th>
				<td headers="write_tit"><input type="text" id="brdata_subject" name="brdata_subject" class="input_w95" /></td>
			</tr>
			<?php if($board_data['BOARD_CATEGORY'] == "Y") { ?>
				<tr>
					<th scope="row"><label for="brdata_category">구분</label></th>
					<td>
						<select id="brdata_category" name="brdata_category" title="카테고리선택" style="width:120px;">
							<option value="0" <?php if($cate == 0) { echo "selected"; }?>>일반</option>
							<?php while($row_c = $coreClass -> selectFetchArray($categoryRs2)){?>
								<option value="<?php echo $row_c['BRDCAT_ID']?>" <?php if($cate==$row_c['BRDCAT_ID']) { echo "selected=\"selected\""; }?>><?php echo $row_c['BRDCAT_NAME']?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
			<?php } ?>
			
			<tr>
				<?php if(S_mb_level <= site_config_level) { ?>
					<th scope="row"><label for="brdata_name">제안자</label></th>
					<td><input type="text" id="brdata_name" name="brdata_name" class="input_w95" value="<?php echo S_mb_name?>" /></td>
				<?php } else { ?>
					<th scope="row">제안자</th>
					<td><?php echo S_mb_name?></td>
				<?php } ?>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_etc4">소속</label></th>
				<td><input type="text" id="brdata_etc4" name="brdata_etc4" value="<?php echo $row['BRDATA_ETC4']?>" class="input_w95" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_email1">이메일</label></th>
				<td>
					<input type="text" id="brdata_email1" name="brdata_email1" style="width:20%;" class="inpline" /> @
					<input type="text" id="brdata_email2" name="brdata_email2" style="width:30%;" class="inpline" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_hp1">연락처</label></th>
				<td>
					<input type="text" id="brdata_hp1" name="brdata_hp1" style="width:10%;" class="inpline" maxlength="4" /> -
					<input type="text" id="brdata_hp2" name="brdata_hp2" style="width:10%;" class="inpline" maxlength="4" /> - 
					<input type="text" id="brdata_hp3" name="brdata_hp3" style="width:10%;" class="inpline" maxlength="4" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_fld4">주소</label></th>
				<td>
					<input type="text" id="post1" name="brdata_fld4" class="inpline" style="width:15%;" readonly /> <a href="#popup" target="_blank" onclick="execDaumPostcode();return false;" class="btn_big"><strong>우편번호</strong></a>
					<input type="text" id="addr1" name="brdata_fld5" class="inpline" style="width:90%;" readonly />	
					<input type="text" id="addr2" name="brdata_fld6" class="inpline" style="width:90%;" />	
					<p id="guide"></p>	
				</td>
			</tr>
			<?php if(S_mb_level <= $board_data['BOARD_LV_NOTICE']) { ?>
				<!--<tr>
					<th scope="row"><label for="brdata_notice">공지여부</label></th>
					<td>
						<input type="checkbox" id="brdata_notice" name="brdata_notice" value="Y" style="vertical-align:middle" /> 공지글인 경우 기간을 설정해 주세요.<br />
						<input type="text" id="brdata_sdate" name="brdata_sdate" value="<?php echo $toDay?>" class="input_w20" title="공지시작일" />
						-
						<input type="text" id="brdata_edate" name="brdata_edate" value="<?php echo $nextDay?>" class="input_w20" title="공지종료일" />					
					</td>
				</tr>-->
			<?php } ?>
			<!--<tr>
					<th scope="row"><label for="brdata_privacy">비밀글여부</label></th>
					<td>
						<input type="checkbox" id="brdata_privacy" name="brdata_privacy2" value="Y" title="비밀글" style="vertical-align:middle" checked disabled />
						<input type="hidden" name="brdata_privacy" value="Y" style="vertical-align:middle" /> <label for="brdata_privacy">비밀글 (*제안서는 비밀글로 작성됩니다.)</label>
					</td>
				</tr>-->
			<!-- <tr>
				<th scope="row"><label for="thumbFile">목록이미지</label></th>
				<td><?php echo $thumbForm ?></td>
			</tr> --> 

			<tr>
				<th scope="row"><label for="brdata_privacy">연구의 필요성<br>및<br>목적</label></th>
				<td>
					<textarea name="brdata_fld1" id="brdata_fld1" style="width:100%; height:200px;"></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_fld1">주요<br>연구내용</label></th>
				<td>
					<textarea name="brdata_fld2" id="brdata_fld2" style="width:100%; height:200px;"></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="brdata_fld3">기대효과<br>및<br>활용방안</label></th>
				<td>
					<textarea name="brdata_fld3" id="brdata_fld3" style="width:100%; height:200px;"></textarea>
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
				<td><input type="password" id="brdata_wd" name="brdata_wd" class="input_w95" maxlength="8" /></td>
			</tr>
			<?php } ?>
		</tbody>
		</table>

	</div>
		
	<?php require_once $dir2.'lib.btn.php'; ?>

</div>
</form>