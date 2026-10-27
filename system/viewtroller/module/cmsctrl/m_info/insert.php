
	<div id="cenCont_in">
		<form name="insert" method="post" action="sub.php?menukey=<?php echo $menukey?>">
			<input type="hidden" name="mod" value="process" />
			<input type="hidden" name="act" value="insert" />
			<input type="hidden" name="token" value="<?php echo site_config_token?>" />

			<div class="brdlist_content">

				<table class="tbl_view1" summary="사이트정보 등록">
				<caption>사이트정보 등록</caption>
				<colgroup>
					<col style="width: 20%;" />
					<col style="width: 80%;" />
				</colgroup>

				<tbody>
					<tr>
						<th scope="row"><label for="siteTitle">사이트구분</label></th>
						<td>
							<select id="siteType" name="siteType" class="selline" style="width: 120px">
								<option value="1">메인형</option>
								<option value="2">가상형</option>
								<option value="3">부속형</option>
								<option value="4">부서형</option>
								<option value="5">기타형</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteTitle">사이트명</label></th>
						<td><input type="text" id="siteTitle" name="siteTitle" class="inpline" style="width:200px;" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="siteCode">사이트코드</label></th>
						<td>
							<?php
								$maxNo	= $coreClass -> selectQueryMax($tbl1, "cms_info_no");
								$maxNo++;
								$id		= str_pad($maxNo, 8, "0", STR_PAD_LEFT);
							?>
							<input type="text" id="siteCode" name="siteCode" class="inpline" style="width:200px;" value="<?php echo $id?>" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteUrl1">사이트URL1</label></th>
						<td>
							<input type="text" id="siteUrl1" name="siteUrl1" class="inpline" style="width:200px;" />
							&nbsp;&bull;&nbsp;변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteUrl2">사이트URL2</label></th>
						<td>
							<input type="text" id="siteUrl2" name="siteUrl2" class="inpline" style="width:200px;" />
							&nbsp;&bull;&nbsp;변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="sitePath">사이트PATH</label></th>
						<td>
							<input type="text" id="sitePath" name="sitePath" class="inpline" style="width:200px;" />
							&nbsp;&bull;&nbsp;변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteCopyright">카피라이트</label></th>
						<td>
						  <textarea id="siteCopyright" name="siteCopyright" class="inpline" style="width:600px; height:100px"></textarea>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteLevel">관리자레벨</label></th>
						<td>
							<input type="text" id="siteLevel" name="siteLevel" class="inpline" style="width: 120px;" value="2" />
							&nbsp;&bull;&nbsp;슈퍼관리자 레벨, 변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteLevel">부서관리자레벨</label></th>
						<td>
							<input type="text" id="siteLevel" name="siteSLevel" class="inpline" style="width: 120px;" value="8" />
							&nbsp;&bull;&nbsp;관리자 페이지 접속레벨, 변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteALevel">사용자레벨</label></th>
						<td>
							<input type="text" id="siteALevel" name="siteALevel" class="inpline" style="width: 120px;" value="9" />
							&nbsp;&bull;&nbsp;실명인증, 공공아이핀 로그인레벨, 변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteGLevel">손님레벨</label></th>
						<td>
							<input type="text" id="siteGLevel" name="siteGLevel" class="inpline" style="width: 120px;" value="10" />
							&nbsp;&bull;&nbsp;비로그인 레벨, 변경하지 마세요!!
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteAccess1">접근제어여부</label></th>
						<td>
							<input type="radio" id="siteAccess1" name="siteAccess" value="Y" /> <label for="siteAccess1">사용</label>&nbsp;
							<input type="radio" id="siteAccess2" name="siteAccess" value="N" checked="checked" /> <label for="siteAccess2">비사용</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteSSL1">SSL 사용여부</label></th>
						<td>
							<input type="radio" id="siteSSL1" name="siteSSL" value="Y" /> <label for="siteSSL1">사용</label>&nbsp;
							<input type="radio" id="siteSSL2" name="siteSSL" value="N" checked="checked" /> <label for="siteSSL2">비사용</label>
						</td>
					</tr> 
					<tr>
						<th scope="row"><label for="siteMapType1">지도타입</label></th>
						<td>
							<input type="radio" id="siteMapType1" name="siteMapType" value="google" class="inpline" /><label for="siteMapType1">구글</label>
							<input type="radio" id="siteMapType2" name="siteMapType" value="daum" class="inpline" /><label for="siteMapType2">다음</label>
							<input type="radio" id="siteMapType3" name="siteMapType" value="naver" class="inpline" /><label for="siteMapType">네이버</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteMap">지도키</label></th>
						<td>
							<input type="text" id="siteMap" name="siteMap" class="inpline" style="width:420px;" />
						</td>
					</tr>					
					<tr>
						<th scope="row"><label for="siteMenudb">메뉴DB명</label></th>
						<td>
							<input type="text" id="siteMenudb" name="siteMenudb" class="inpline" style="width:420px;" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteMouse1">모바일 사용여부</label></th>
						<td>
							<input type="radio" id="siteMouse1" name="siteMouse" value="Y" /> <label for="siteMouse1">사용</label>&nbsp;
							<input type="radio" id="siteMouse2" name="siteMouse" value="N" checked="checked" /> <label for="siteMouse2">비사용</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteMourl">모바일주소</label></th>
						<td>
							<input type="text" id="siteMourl" name="siteMourl" class="inpline" style="width:420px;" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="sitePagelog">페이지로그 사용여부</label></th>
						<td>
							<input type="radio" id="sitePagelog1" name="sitePagelog" value="Y" /> <label for="sitePagelog1">사용</label>&nbsp;
							<input type="radio" id="sitePagelog2" name="sitePagelog" value="N" checked="checked" /> <label for="sitePagelog2">비사용</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteEditor">에디터 선택</label></th>
						<td>
							<input type="radio" id="siteEditor1" name="siteEditor" value="1" checked="checked" /> <label for="siteEditor1">SmartEditor 2.3.3</label>&nbsp;
							<input type="radio" id="siteEditor2" name="siteEditor" value="2" /> <label for="siteEditor2">CKEditor 4.1.1</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteUname">담당자</label></th>
						<td>
							<input type="text" id="siteUname" name="siteUname" class="inpline" style="width:200px;" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteTel">연락처</label></th>
						<td>
							<input type="text" id="siteTel" name="siteTel" class="inpline" style="width:200px;" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="siteSummary">주요정보</label></th>
						<td>
       		    			<?php $coreClass -> getEditor(1, "siteSummary", "100%", "200px", ""); ?>
						</td>
					</tr>
				</tbody>
				</table>
			
			</div>
			
			<div class="brdlist_footer">	
				<div class="bt">
					<button type="submit" class="btn_big"><strong>등록</strong></button>
					<a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" onclick="history.back(); return false;" class="btn_big"><span>목록</span></a>
				</div>
			</div>
		</form>
	</div>
