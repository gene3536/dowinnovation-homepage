<?php

	$where	= "LEFT JOIN ".$tbl3." ON mb_org_id = mb_org LEFT JOIN ".tbl_cms_info." ON cms_info_code = mb_scode WHERE mb_no = '".$no."'";
	$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");

	$where	= "WHERE mb_log_uid = '".$row['MB_UID']."'";
	$order	= "ORDER BY mb_log_regdate DESC";
	$rs			= $coreClass -> selectQuery($tbl2, $where, $order, 0, 10);
	while($rows = $coreClass -> selectFetchArray($rs)) {
		$logs .= "&bull;&nbsp;".$rows['MB_LOG_REGDATE']." - ".$rows['MB_LOG_REGIP']."<br />";
	}
?>

<div id="cenCont_in">
    <div class="brdlist_content">
    	<table class="tbl_view1" border="1" cellspacing="0" summary="멤버정보 상세보기">
        <caption>멤버정보 상세보기</caption>
        <colgroup>
        	<col style="width: 20%;" />
        	<col style="width: 30%;" />
        	<col style="width: 20%;" />
        	<col style="width: 30%;" />
        </colgroup>  

        <tbody>  
        <tr>
            <th scope="row">이름</th>
            <td><b><?php echo $row['MB_NAME']?></b></td>
            <th scope="row">아이디</th>
            <td><b><?php echo $row['MB_UID']?></b></td>
        </tr>
        <tr>
            <th scope="row">멤버레벨</th>
            <td>
			<?php
				$levelWhere = "WHERE mb_level_lv = ".$row['MB_LEVEL'];
				$levelRow = $coreClass -> selectQueryArray($tbl4, $levelWhere, "", "", "");
				echo $levelRow['MB_LEVEL_TITLE']." (".$row['MB_LEVEL'].")";
			?>
			</td>
            <th scope="row">멤버분류</th>
            <td><?php echo $row['MB_ORG_NAME']?></td>
        </tr>
        <tr>
            <th scope="row">연락처</th>
            <td><?php echo $coreClass -> decrypt_md5($row['MB_TEL'], site_config_mbkey); ?></td>
            <th scope="row">이메일</th>
            <td><?php echo $coreClass -> decrypt_md5($row['MB_EMAIL'], site_config_mbkey); ?></td>
        </tr>
        <tr>
            <th scope="row">EPKI 인증값</th>
            <td><?php echo $coreClass -> decrypt_md5($row['MB_EPKI'], site_config_mbkey); ?></td>
            <th scope="row">담당홈페이지</th>
            <td><?php echo $row['CMS_INFO_TITLE'] ?></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
            <th scope="row">가입일</th>
            <td><?php echo $row['MB_REGDATE']?></td>
            <th scope="row">탈퇴일</th>
            <td><?php echo $row['MB_DELDATE']?></td>
		</tr>
		<tr>
            <th scope="row">최근접속시간</th>
            <td colspan="3"><?php echo $logs?></td>
		</tr>
		</tbody>
	</table>
	</div>
    
	<div class="brdlist_footer">
    	<div class="bt">
            <a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['MB_NO']?><?php echo $listVar?>" class="btn_big"><strong>수정</strong></a>
            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" class="btn_big"><span>목록</span></a>
        </div>
	</div>
</div> 