<?php
	$where	= "WHERE icd_no = '".$logno."'";
	$row		= $coreClass -> selectQueryArray($tbl2, $where, "", "", "");
?>

<div id="cenCont_in">
    <div class="brdlist_content">
    	<table class="tbl_view1" border="1" cellspacing="0" summary="콘텐츠로그 상세보기">
        <caption>콘텐츠로그 상세보기</caption>
        <colgroup>
        	<col style="width: 20%;" />
        	<col style="width: 80%;" />
        </colgroup>
        
        <tbody>
		<tr>
            <th scope="row">콘텐츠명</th>
            <td><?php echo $row['ICD_TITLE']?></td>
		</tr>   
        <tr>
            <th scope="row">생성일 / 수정일</th>
            <td><?php echo $row['ICD_REGDATE']?> / <?php echo $row['ICD_MODDATE']?>
            </td>
        </tr>
		<tr>
            <th scope="row">백업일</th>
            <td><?php echo $row['ICD_LOGDATE']?></td>
		</tr>
        <tr>
            <th scope="row">내용</th>
            <td style="padding:10px">
                <div style="overflow:auto">
                    <?php echo $row['ICD_CONTENT'] ?>
                </div>
            </td>
        </tr>
        </tbody>
		</table>
	</div>

	<div class="brdlist_footer">
        <div class="bt">
            <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=restore&no=<?php echo $no?>&logno=<?php echo $row['ICD_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" class="btn_big"><strong>복구</strong></a>
            <a href="sub.php?menukey=<?php echo $menukey?>&mod=view&no=<?php echo $no?><?php echo $listVar?>" class="btn_big"><span>뒤로</span></a>
        </div>
    </div>    
</div> 