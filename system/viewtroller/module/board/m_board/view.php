<?php
	$where = "WHERE board_no = '".$no."'";
	$row = $coreClass -> selectQueryArray($tbl1, $where, "", "", "");				
?>

<div id="cenCont_in">
    <div class="brdlist_content">
    	<table class="tbl_view1" border="1" cellspacing="0" summary="게시판정보 상세보기">
        <caption>게시판정보 상세보기</caption>
		<colgroup>
			<col style="width: 20%;" />
        	<col style="width: 30%;" />
        	<col style="width: 20%;" />
        	<col style="width: 30%;" />
		</colgroup>
			<tbody>
				<tr>
	                <th scope="row">게시판ID</th>
	                <td>
	                    <?php echo $row['BOARD_ID']?>
	                </td>
	            	<th scope="row">게시판명</th>
		            <td><?php echo $row['BOARD_NAME']?></td>
				</tr>
	            <tr>
	            	<th scope="row">게시판타입</th>
		            <td colspan="3">
		            	<?php if($row['BOARD_TYPE']=="board") echo "일반게시판";?>
		            	<?php if($row['BOARD_TYPE']=="gallery") echo "사진게시판";?>
	                </td>
				</tr>
	            <tr>
	            	<th scope="row">카테고리사용여부</th>
		            <td><?php echo $row['BOARD_CATEGORY']?></td>
	            	<th scope="row">비밀글사용여부</th>
		            <td><?php echo $row['BOARD_PRIVACY']?></td>
				</tr>
	            <tr>
	            	<th scope="row">댓글사용여부</th>
		            <td><?php echo $row['BOARD_COMMENT']?></td>
	            	<th scope="row">에디터사용여부</th>
		            <td><?php echo $row['BOARD_EDITOR']?></td>
				</tr>
	            <tr>
	            	<th scope="row">확장필드사용여부</th>
		            <td><?php echo $row['BOARD_EXTEND']?></td>
	            	<th scope="row">썸네일사용여부</th>
		            <td><?php echo $row['BOARD_THUMNAIL']?></td>
				</tr>
	            <tr>
	            	<th scope="row">썸네일가로</th>
		            <td><?php echo $row['BOARD_THUM_WID']?> px</td>
	            	<th scope="row">썸네일세로</th>
		            <td><?php echo $row['BOARD_THUM_HEI']?> px</td>
				</tr>
				<tr>
	            	<th scope="row">목록게시글수</th>
		            <td><?php echo $row['BOARD_RECORD']?></td>
	            	<th scope="row">NEW 표시일수</th>
		            <td><?php echo $row['BOARD_NEW']?></td>
				</tr>
				<tr>
	            	<th scope="row">HOT 표시히트수</th>
		            <td><?php echo $row['BOARD_HOT']?> Hit</td>
		            <th scope="row">1:1 여부</th>
		            <td><?php echo $row['BOARD_OTO']?></td>
				</tr>
				<tr>
	            	<th scope="row">첨부파일수</th>
		            <td><?php echo $row['BOARD_UPLOADCOUNT']?></td>
	            	<th scope="row">첨부파일사이즈</th>
		            <td><?php echo $row['BOARD_UPLOADSIZE']?> MB</td>
				</tr>
	            <tr>
	            	<th scope="row">공지레벨</th>
		            <td><?php echo $row['BOARD_LV_NOTICE']?></td>
	            	<th scope="row">접근레벨</th>
		            <td><?php echo $row['BOARD_LV_ACCESS']?></td>
				</tr>
				<tr>
	            	<th scope="row">관리레벨</th>
		            <td><?php echo $row['BOARD_LV_MANAGE']?></td>
	            	<th scope="row">보기레벨</th>
		            <td><?php echo $row['BOARD_LV_VIEW']?></td>
				</tr>
	            <tr>
	            	<th scope="row">쓰기레벨</th>
		            <td><?php echo $row['BOARD_LV_INSERT']?></td>
	            	<th scope="row">답변레벨</th>
		            <td><?php echo $row['BOARD_LV_REPLY']?></td>
				</tr>
	            <tr>
	            	<th scope="row">댓글레벨</th>
		            <td><?php echo $row['BOARD_LV_COMMENT']?></td>
	            	<th scope="row">다운레벨</th>
		            <td><?php echo $row['BOARD_LV_DOWNLOAD']?></td>
				</tr>
	            <tr>
	            	<th scope="row"><label for="board_lv_exposure">노출일자 레벨</label></th>
		            <td>
						<?php if(0 == $row['BOARD_LV_EXPOSURE']) {?>사용안함<?}else{?><?=$row['BOARD_LV_EXPOSURE']?><?}?>
					</td>
					<th scope="row">답변SMS여부 사용유무</th>
		            <td><?php echo $row['BOARD_SMS']?></td>	
				</tr>	

	            <tr>
	            	<th scope="row"><label for="board_order1">정렬옵션</label></th>
		            <td colspan="3"><?php echo $row['BOARD_ORDER']?></td>
				</tr>


	            <tr>
	            	<th scope="row">게시판헤더</th>
		            <td colspan="3"><?php echo $row['BOARD_HEADER']?></td>
				</tr>
				<tr>
	            	<th scope="row">게시판푸터</th>
		            <td colspan="3"><?php echo $row['BOARD_FOOTER']?></td>
				</tr>
	
			
				<tr>
				    <th scope="row">게시판관리자</th>					
					<td colspan="3">	                
						<?php	                	
						$where = "LEFT JOIN ".tbl_member." ON mb_uid = brdmng_uid WHERE brdmng_bid = '".$row['BOARD_ID']."'";		
						$rsCnt		= $coreClass -> selectQueryCount(tbl_board_manage, $where);
						if($rsCnt > 0){
						$rsm = $coreClass -> selectQuery(tbl_board_manage, $where, "", "", "");	
						while($rowu = $coreClass -> selectFetchArray($rsm)){
			
						?>                						
						<div>&bull;&nbsp;<?php echo $rowu['MB_NAME']?></div>	                
						<?php 
						}
						} ?>	             
					</td>	        
				</tr>

				<tr>
				    <th scope="row">SMS발송자</th>					
					<td colspan="3">	                
						<?php	                	
						$where	= " WHERE BRDMNGS_BID = '".$row['BOARD_ID']."'";
						$rsCnt		= $coreClass -> selectQueryCount(tbl_board_manage_sms, $where);
						if($rsCnt > 0){
						$rsm = $coreClass -> selectQuery(tbl_board_manage_sms, $where, "", "", "");	
						while($rowu = $coreClass -> selectFetchArray($rsm)){
			
						?>                						
						<div>&bull;&nbsp;<?php echo $rowu['BRDMNGS_NAME']?> (<?=$coreClass -> decrypt_md5($rowu['BRDMNGS_HP'], site_config_mbkey)?>)</div>	                
						<?php 
						}
						} ?>	             
					</td>	        
				</tr>

			</tbody>
		</table>
	</div>
	
	<div class="brdlist_footer">
	   	<div class="bt">
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&scode=<?php echo $scode?>&no=<?php echo $row['BOARD_NO']?>" class="btn_big"><strong>수정</strong></a> 
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=list&scode=<?php echo $scode?>" class="btn_big"><span>목록</span></a>
       </div>
	</div>    
</div>
