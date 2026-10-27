<?php
	$where	= "WHERE mb_uid = '".S_mb_id."'";
	$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
	
	$where	= "WHERE mb_log_uid = '".S_mb_id."'";
	$order	= "ORDER BY mb_log_regdate DESC";
	$rs			= $coreClass -> selectQuery($tbl2, $where, $order, 0, 5);
	while($rows = $coreClass -> selectFetchArray($rs)) {
		$logs .= "&bull;&nbsp;".$rows['MB_LOG_REGDATE']." - ".$rows['MB_LOG_REGIP']."<br />";
	}
?>

<script type="text/javascript">
	function frmCheck() {
		var obj = document.getElementById("modify");
		var regexp = /^(?=.{6,15})(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-]|.*[0-9]).*$/g;

		if(obj.info3.value != null && obj.info3.value != "") {
			if (!regexp.test(obj.info3.value)) {
				alert("암호는 6~15자 이내로 영문과 숫자(또는 특수문자)로 조합하여 입력해 주세요");
				obj.info3.focus();
				return false;
			} else if (obj.info3.value != obj.info4.value) {
				alert("암호는 서로 같아야 합니다.");
				obj.info3.focus();
				return false;
			} else {
				return true;
			}
		} else {
			return true;			
		}
	}
</script>

<form id="modify" name="modify" method="post" action="sub.php?menukey=<?php echo $menukey?>" onsubmit="return frmCheck();">
    <input type="hidden" name="mod" value="process">
    <input type="hidden" name="act" value="modify">
    <input type="hidden" name="no" value="<?php echo $row['MB_NO']?>">
    <input type="hidden" name="search" value="<?php echo $search?>">
    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
    <input type="hidden" name="token" value="<?php echo site_config_token?>">

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    <table class="tbl_view1" border="1" cellspacing="0" summary="내정보 수정">
	        <caption>내정보 수정</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	        	<col style="width: 80%;" />
	        </colgroup>
	        
	        <tbody>
		    	<tr>
			        <th scope="row">회원아이디</th>
			        <td><?php echo $row['MB_UID']?></td>
		        </tr>
		        <tr>
			        <th scope="row">회원이름</th>
		            <td><?php echo $row['MB_NAME']?> (<?php echo $row['MB_LEVEL']?>)</td>
		        </tr>
		        <tr>
			        <th scope="row"><label for="info3">비밀번호</label></th>
			        <td style="text-align:left">
				        <input type="password" id="info3" name="info3" class="inpline" style="width:100px;" value="" />
		                <label for="info4"><strong>비밀번호 재입력</strong></label>&nbsp;<input type="password" id="info4" name="info4" class="inpline" style="width:100px;" value="" />
			        	<div style="margin:10px 0 0 10px;">* 비밀번호를 변경할 경우에만 입력하세요.</div>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="mb_tel">연락처</label></th>
		            <td><input type="text" id="mb_tel" name="mb_tel" class="inpline" style="width:180px;" value="<?php echo $coreClass -> decrypt_md5($row['MB_TEL'], site_config_mbkey)?>" /></td>
				</tr>
		        <tr>
					<th scope="row"><label for="mb_email">이메일</label></th>
		            <td><input type="text" id="mb_email" name="mb_email" class="inpline" style="width:180px;" value="<?php echo $coreClass -> decrypt_md5($row['MB_EMAIL'], site_config_mbkey)?>" /></td>
				</tr>
				<tr>
					<th scope="row">최근로그인 이력정보</label></th>
					<td><?php echo $logs?></td>
				</tr>
	        </tbody>
		</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	    		&bull;&nbsp;내 정보를 수정할 경우에만 확인버튼을 눌러주세요.&nbsp;
	    		<button type="submit" class="btn_big"><strong>수정</strong></button>
	        </div>
		</div>
	</div>
</form>