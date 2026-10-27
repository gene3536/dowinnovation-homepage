<?php
	require_once $dir2.'modify.header.php';

	require_once $dir2.'lib.downfile.php';

	switch($row['ICD_TYPE']){
		case '3'  : $row['ICD_TYPE'] = '견적문의'; break;
		case '2'  : $row['ICD_TYPE'] = '제품문의'; break;
		default   : $row['ICD_TYPE'] = '일반문의'; break;
	}
?>

	<div id="cenCont_in">
	    <div class="brdlist_content">
	    	<table class="tbl_view1" summary="통합콘텐츠데이터 수정">
	        <caption>통합콘텐츠데이터 수정</caption>
	        <colgroup>
	        	<col style="width:20%;" />
	            <col style="width:80%;" />
	        </colgroup>
	        <tbody>
				<tr>
					<th scope="row">문의유형</th>
					<td><?php echo $row['ICD_TYPE']?></td>
				</tr>
				<?if($row['ICD_TYPE']!='일반문의'){?>
				<tr>
					<th scope="row">제품명</th>
					<td><?php echo $row['ICD_FLD4']?></td>
				</tr>
				<?}?>
				<tr>
		            <th scope="row">이름</th>
					<td><?php echo $row['ICD_NAME']?></td>
				</tr>	
				<tr>
		            <th scope="row">직책</th>
					<td><?php echo $row['ICD_FLD1']?></td>
				</tr>	
				<tr>
		            <th scope="row">이메일</th>
					<td><?php echo $row['ICD_FLD2']?></td>
				</tr>	
				<tr>
		            <th scope="row">단체/회사명</th>
					<td><?php echo $row['ICD_TITLE']?></td>
				</tr>	
				<tr>
		            <th scope="row">연락처</th>
					<td><?php echo $row['ICD_FLD3']?></td>
				</tr>	
				<tr>
		            <th scope="row">문의내용</th>
					<td><?php echo nl2br($row['ICD_CONTENT'])?></td>
				</tr>
				<tr>
		            <th scope="row">첨부파일</th>
					<td><?php echo $updList?></td>
				</tr>
	        </tbody>
			</table>
		</div>
	
		<div class="brdlist_footer">
	    	<div class="bt">
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['ICD_NO']?><?php echo $listVar?>" class="btn_big"><span>수정</span></a>
	            <a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>
	</div>