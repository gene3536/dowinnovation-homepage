<?php
	/** 2014.06.02 */
	$where	= "WHERE cms_info_no = '".$no."'";
	$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
?>

	<div id="cenCont_in">

		<form name="modify" method="post" action="sub.php?menukey=<?php echo$menukey?>">
			<input type="hidden" name="mod" value="process" />
			<input type="hidden" name="act" value="modify" />
			<input type="hidden" name="no" value="<?php echo $row['CMS_INFO_NO']?>" />
			<input type="hidden" name="token" value="<?php echo site_config_token?>" />

			<div class="brdlist_content">
				<table class="tbl_view1" summary="정보수정">
				<caption>정보수정</caption>
				<colgroup>
					<col style="width:20%;" />
					<col style="width:80%;" />
				</colgroup>

				<tbody>
					<tr>
						<th scope="row"><label for="siteTitle">사이트구분</label></th>
						<td>
							<select id="siteType" name="siteType" class="selline" style="width: 120px">
								<option value="1"<?php if($row['CMS_INFO_TYPE'] == "1") echo " selected=\"selected\""; ?>>메인형</option>
								<option value="2"<?php if($row['CMS_INFO_TYPE'] == "2") echo " selected=\"selected\""; ?>>가상형</option>
								<option value="3"<?php if($row['CMS_INFO_TYPE'] == "3") echo " selected=\"selected\""; ?>>부속형</option>
								<option value="4"<?php if($row['CMS_INFO_TYPE'] == "4") echo " selected=\"selected\""; ?>>부서형</option>
								<option value="5"<?php if($row['CMS_INFO_TYPE'] == "5") echo " selected=\"selected\""; ?>>기타형</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteTitle">사이트명</label></th>
						<td>
							<input type="text" id="siteTitle" name="siteTitle" class="inpline" style="width:200px;" value="<?php echo $row['CMS_INFO_TITLE']?>">
							&nbsp;&bull;&nbsp;변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteCode">사이트코드</label></th>
						<td>
							<input type="text" id="siteCode" name="siteCode" class="inpline" style="width:200px;" value="<?php echo $row['CMS_INFO_CODE']?>">
							&nbsp;&bull;&nbsp;변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteUrl1">사이트URL1</label></th>
						<td>
							<input type="text" id="siteUrl1" name="siteUrl1" class="inpline" style="width:200px;" value="<?php echo $row['CMS_INFO_URL1']?>">
							&nbsp;&bull;&nbsp;변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteUrl2">사이트URL2</label></th>
						<td>
							<input type="text" id="siteUrl2" name="siteUrl2" class="inpline" style="width:200px;" value="<?php echo $row['CMS_INFO_URL2']?>">
							&nbsp;&bull;&nbsp;변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="sitePath">사이트PATH</label></th>
						<td>
							<input type="text" id="sitePath" name="sitePath" class="inpline" style="width:200px;" value="<?php echo $row['CMS_INFO_PATH']?>">
							&nbsp;&bull;&nbsp;변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteCopyright">카피라이트</label></th>
						<td>
						  <textarea id="siteCopyright" name="siteCopyright" class="inpline" style="width:600px; height:100px"><?php echo $row['CMS_INFO_COPYRIGHT']?></textarea>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteLevel">관리자레벨</label></th>
						<td>
							<input type="text" id="siteLevel" name="siteLevel" class="inpline" style="width: 120px;" value="<?php echo $row['CMS_INFO_LEVEL']?>" />
							&nbsp;&bull;&nbsp;슈퍼관리자 레벨, 변경하지 마세요!!
	                </td>
					</tr>
					<tr>
						<th scope="row"><label for="siteLevel">부서관리자레벨</label></th>
						<td>
							<input type="text" id="siteLevel" name="siteSLevel" class="inpline" style="width: 120px;" value="<?php echo $row['CMS_INFO_SLEVEL']?>" />
							&nbsp;&bull;&nbsp;관리자 페이지 접속레벨, 변경하지 마세요!!
	                </td>
					</tr>
					<tr>
						<th scope="row"><label for="siteALevel">사용자레벨</label></th>
						<td>
							<input type="text" id="siteALevel" name="siteALevel" class="inpline" style="width: 120px;" value="<?php echo $row['CMS_INFO_ALEVEL']?>" />
							&nbsp;&bull;&nbsp;실명인증, 공공아이핀 로그인레벨, 변경하지 마세요!!
	                </td>
					</tr>
					<tr>
						<th scope="row"><label for="siteGLevel">손님레벨</label></th>
						<td>
							<input type="text" id="siteGLevel" name="siteGLevel" class="inpline" style="width: 120px;" value="<?php echo $row['CMS_INFO_GLEVEL']?>" />
							&nbsp;&bull;&nbsp;비로그인 레벨, 변경하지 마세요!!
	                </td>
					</tr>
					<tr>
						<th scope="row"><label for="siteAccess1">접근제어여부</label></th>
						<td>
							<input type="radio" id="siteAccess1" name="siteAccess" value="Y" <?php if($row['CMS_INFO_ACCESS'] == 'Y') { echo "checked=\"checked\"";}?> /> <label for="siteAccess1">사용</label>&nbsp;
							<input type="radio" id="siteAccess2" name="siteAccess" value="N" <?php if($row['CMS_INFO_ACCESS'] == 'N') { echo "checked=\"checked\"";}?> /> <label for="siteAccess2">비사용</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteSSL1">SSL사용여부</label></th>
						<td>
							<input type="radio" id="siteSSL1" name="siteSSL" value="Y" <?php if($row['CMS_INFO_SSL'] == 'Y') { echo "checked=\"checked\"";}?> /> <label for="siteSSL1">사용</label>&nbsp;
							<input type="radio" id="siteSSL2" name="siteSSL" value="N" <?php if($row['CMS_INFO_SSL'] == 'N') { echo "checked=\"checked\"";}?> /> <label for="siteSSL2">비사용</label>
						</td>
					</tr> 
					<tr>
						<th scope="row"><label for="siteMapType1">지도타입</label></th>
						<td>
							<input type="radio" id="siteMapType1" name="siteMapType" value="google" class="inpline" <?php if($row['CMS_INFO_MAPTYPE']=="google"){echo "checked"; }?> /><label for="siteMapType1">구글</label>
							<input type="radio" id="siteMapType2" name="siteMapType" value="daum" class="inpline" <?php if($row['CMS_INFO_MAPTYPE']=="daum"){echo "checked"; }?> /><label for="siteMapType2">다음</label>
							<input type="radio" id="siteMapType3" name="siteMapType" value="naver" class="inpline" <?php if($row['CMS_INFO_MAPTYPE']=="naver"){echo "checked"; }?> /><label for="siteMapType3">네이버</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteMap">지도키</label></th>
						<td>
							<input type="text" id="siteMap" name="siteMap" class="inpline" style="width:420px;" value="<?php echo $row['CMS_INFO_MAP']?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="sitePagelog">페이지로그 사용여부</label></th>
						<td>
							<input type="radio" id="sitePagelog1" name="sitePagelog" value="Y" <?php if($row['CMS_INFO_PAGELOG'] == 'Y') { echo "checked=\"checked\"";}?> /> <label for="sitePagelog1">사용</label>&nbsp;
							<input type="radio" id="sitePagelog2" name="sitePagelog" value="N" <?php if($row['CMS_INFO_PAGELOG'] == 'N') { echo "checked=\"checked\"";}?> /> <label for="sitePagelog2">비사용</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteEditor">에디터 선택</label></th>
						<td>
							<input type="radio" id="siteEditor1" name="siteEditor" value="1" <?php if($row['CMS_INFO_EDITOR'] == '1') { echo "checked=\"checked\"";}?> /> <label for="siteEditor1">SmartEditor 2.3.3</label>&nbsp;
							<input type="radio" id="siteEditor2" name="siteEditor" value="2" <?php if($row['CMS_INFO_EDITOR'] == '2') { echo "checked=\"checked\"";}?> /> <label for="siteEditor2">CKEditor 4.1.1</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteUname">담당자</label></th>
						<td>
							<input type="text" id="siteUname" name="siteUname" class="inpline" style="width:200px;" value="<?php echo $row['CMS_INFO_UNAME']?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteTel">연락처</label></th>
						<td>
							<input type="text" id="siteTel" name="siteTel" class="inpline" style="width:200px;" value="<?php echo $row['CMS_INFO_TEL']?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteSummary">주요정보</label></th>
						<td>
       		    			<?php $coreClass -> getEditor(site_config_editor, "siteSummary", "100%", "200px", $row['CMS_INFO_SUMMARY']); ?>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="inquiryHeader">문의헤더</label></th>
						<td>
       		    			<?php $coreClass -> getEditor(site_config_editor, "inquiryHeader", "100%", "200px", $row['CMS_INQUIRY_HEADER']); ?>
						</td>
					</tr>
				</tbody>
				</table>
			</div>
			
			<div class="brdlist_footer">	
				<div class="bt">
					<button type="submit" class="btn_big"><strong>수정</strong></button>
					<a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" onclick="history.back(); return false;" class="btn_big"><span>목록</span></a>
				</div>
			</div>
		</form>
	</div>
