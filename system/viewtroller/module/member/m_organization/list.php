<?php
	$where		= "WHERE organ_depth = '1'";
	$organCnt	= $coreClass -> selectQueryCount($tbl1, $where);	
	$orgCnt 		= 1;
	$orgTnt		= $organCnt;
	if(!empty($kwd)) {
		$code2 = 999;
	} else if(empty($kwd) && $code2 == 999) {
		// 전체보기 여부
		$code2 = 999;
	}
	if(!empty($code2) && $code2 <> 999) {
		$orgCnt		= $code2;
		$organCnt	= $code2;
	}

	if(S_mb_level > site_config_level) {
		$where		= "WHERE organ_depth = '1' AND organ_uid = '".S_mb_id."'";
		$orgRow		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
		$code2		= $orgRow['ORGAN_ROOT'];
		$orgCnt		= $code2;
		$organCnt	= $code2;
	}
?>

<div id="cenCont_in">
	<div class="tabs">
		<ul>  
			<li <?php if($code1 == 1) { ?> class="on" <?php } ?>>
				<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=1&amp;code2=<?php echo $code2?>&amp;kwd=<?php echo urlencode($kwd)?>">전체 출력</a>  
			</li>
		</ul>  
	</div>
	
	<div class="brdlist_head">
		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체부서 <b><?php echo $orgTnt?></b></div>
	        <div class="fr">
	        	<form id="orgSearch" name="orgSearch" method="post" action="sub.php?menukey=<?php echo $menukey?>">
					<input type="hidden" name="code1" value="<?php echo $code1?>" />

					<input type="text" id="kwd" name="kwd" class="inpline" style="text-align:center; width:140px;" value="<?php echo $kwd?>" title="이름검색어 박스" />
		        	<select name="code2" id="code2" class="selline" style="width:200px;" onchange="submit();">
		        		<option value="999">전체부서</option>
	            		<?php
	            			$order	= "ORDER BY organ_step ASC";
	            			$where	= "WHERE organ_depth = '1'";
							$result	= $coreClass -> selectQuery($tbl1, $where, $order, "", "");	
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['ORGAN_ROOT']?>" <?php if($rowc['ORGAN_ROOT'] == $code2) echo "selected";?>><?php echo $rowc['ORGAN_NAME']?></option>
						<?php } ?>
			        </select>
			        <button type="submit" class="btn_big"><strong>검색</strong></button>
				</form>
	        </div>
		</div>
	</div>
	
    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="부서관리 목록">
        <caption>부서관리 목록</caption>
        <colgroup>
        	<col />
        	<col width="14%" />
        	<col width="12%" />
        	<col width="16%" />
			<col width="10%" />
        	<col width="5%" />
        	<col width="8%" />
        	<col width="14%" />
        </colgroup>
        
        <thead>      
        	<tr>
				<th><b>부서명 (부서관리자)</b></th>
				<th><b>담당자 (직무대리자)</b></th>
				<th><b>연락처</b></th>
                <th><b>직급</b></th>
				<th><b>활성</b></th>
				<th><b>순서</b></th>
                <th><b>위치</b></th>
				<th><b>처리</b></th>
            </tr>
        </thead>

		<tbody>
	    <?php
	    	// 1차 부서
			for($cnt = $orgCnt; $cnt <= $organCnt; $cnt++) {
				if(S_mb_level <= site_config_level) {
					$where		= "LEFT JOIN ".$tbl3." ON mb_uid = organ_uid WHERE organ_depth = '1' AND organ_root = '".$cnt."'";
				} else {
					$where		= "LEFT JOIN ".$tbl3." ON mb_uid = organ_uid WHERE organ_depth = '1' AND organ_root = '".$cnt."' AND organ_uid = '".S_mb_id."'";
				}
				$organ1Cnt	= $coreClass -> selectQueryCount($tbl1, $where);

				if($organ1Cnt < 1) {
					echo '<tr><td colspan="8">관리가능한 부서정보가 없습니다.</td></tr>';
				} else { 
					$order		= "ORDER BY organ_step ASC";
					$organ1Row	= $coreClass -> selectQueryArray($tbl1, $where, $order, "", "");
		?>
        
            	<tr style="background-color:#eef">
					<td class="title" style="padding-left:5px"><strong>▣ <?php echo $organ1Row['ORGAN_NAME']?></strong> (<?php echo $organ1Row["MB_NAME"]?>)</td>
                    <td></td>
                    <td></td>
                    <td></td>
					<td>
						<?php
							if($organ1Row['ORGAN_VISIBLE'] == "Y") {
								echo "활성";
							} else {
								echo "비활성";
							}
						?>
					</td>
					<td><?php echo $organ1Row['ORGAN_STEP']?></td>
					<td>
	                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=up&no=<?php echo $organ1Row['ORGAN_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>" style="color:#900">▲</a>
    	                <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=down&no=<?php echo $organ1Row['ORGAN_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>" style="color:#900">▼</a>
                    </td>
                    <td>
                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=organ2ins&no=<?php echo $organ1Row['ORGAN_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>">추가</a> |               
                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $organ1Row['ORGAN_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>">수정</a> | 
					<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $organ1Row['ORGAN_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?\n\n정보가 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>

                    </td>
				</tr>
                
				<?php
					if($code1 != 2) {
					// 2차 메뉴
					$organ2Where		= "WHERE organ_depth = '2' AND organ_ref = '".$organ1Row['ORGAN_ID']."'";
					$organ2Cnt			= $coreClass -> selectQueryCount($tbl1, $organ2Where);
										
					if($organ2Cnt > 0) {
						$organ2Order		= "ORDER BY organ_step ASC";
						$organ2Rs			= $coreClass -> selectQuery($tbl1, $organ2Where, $organ2Order, "", "");
						
						while($organ2Row = $coreClass -> selectFetchArray($organ2Rs)) {
							$chk2where	= "LEFT JOIN ".$tbl2." ON organ_mb_pid = organ_id WHERE organ_id = '".$organ2Row['ORGAN_ID']."' AND organ_depth = '2'";
							if(!empty($kwd)) $chk2where .= " AND organ_mb_name LIKE '%".$kwd."%'";
							$chk2Cnt		= $coreClass -> selectQueryCount($tbl1, $chk2where);
							if($chk2Cnt > 0) {
		        ?>
			            	<tr style="background-color:#ffe">
                                <td class="title" style="padding-left:50px"><?php echo $organ2Row['ORGAN_NAME']?></td>
			                    <td></td>
			                    <td></td>
			                    <td></td>
                                <td>
									<?php 
										if($organ2Row['ORGAN_VISIBLE'] == "Y") {
											echo "활성";
										} else {
											echo "비활성";
										}
									?>
								</td>
								<td><?php echo $organ2Row['ORGAN_STEP']?></td>
                                <td>
                                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=up&no=<?php echo $organ2Row['ORGAN_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>">▲</a>
                                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=down&no=<?php echo $organ2Row['ORGAN_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>">▼</a>
                                </td>
                                <td>
	                                <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=organ3ins&no=<?php echo $organ2Row['ORGAN_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>">추가</a> | 
                                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $organ2Row['ORGAN_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>">수정</a> | 
                                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $organ2Row['ORGAN_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?\n\n정보가 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
                                </td>
                            </tr>

							<?php
								 // 3차 메뉴
								if($code1 != 3) {
								$organ3Where		= "LEFT JOIN ".$tbl2." ON organ_id = organ_mb_pid";
								$organ3Where		= $organ3Where." WHERE organ_id = '".$organ2Row['ORGAN_ID']."' AND organ_mb_pid = '".$organ2Row['ORGAN_ID']."'";
								$organ3Cnt			= $coreClass -> selectQueryCount($tbl1, $organ3Where);
								
								if($organ3Cnt > 0) {
									$organ3Order		= "ORDER BY organ_mb_step ASC";
									$organ3Rs			= $coreClass -> selectQuery($tbl1, $organ3Where, $organ3Order, "", "");
									
									while($organ3Row = $coreClass -> selectFetchArray($organ3Rs)) {
										$chk3where	= "LEFT JOIN ".$tbl2." ON organ_mb_pid = organ_id WHERE organ_mb_id = '".$organ3Row['ORGAN_MB_ID']."' AND organ_depth = '2'";
										if(!empty($kwd)) $chk3where .= " AND organ_mb_name LIKE '%".$kwd."%'";
										$chk3Cnt	= $coreClass -> selectQueryCount($tbl1, $chk3where);
										
										if($chk3Cnt > 0) {
							?>
                                        <tr>
                                            <td class="title"></td>
                                            <td><?php echo $organ3Row['ORGAN_MB_NAME'];?> (<?php echo $organ3Row['ORGAN_MB_EXTENSION']?>)</td>
						                    <td><?php echo $organ3Row['ORGAN_MB_TEL']?></td>
						                    <td><?php echo $organ3Row['ORGAN_MB_POSITION']?></td>
			                                <td></td>
			                                <td><?php echo $organ3Row['ORGAN_MB_STEP']?></td>
                                            <td>
			                                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=up2&no=<?php echo $organ3Row['ORGAN_MB_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>" style="color:#00f">▲</a>
			                                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=down2&no=<?php echo $organ3Row['ORGAN_MB_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>" style="color:#00f">▼</a>
                                            </td>
                    					    <td>                        
						                        <a href="sub.php?menukey=<?php echo $menukey?>&mod=update&no=<?php echo $organ3Row['ORGAN_MB_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>">정보수정</a> | 
												<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=organ3del&no=<?php echo $organ3Row['ORGAN_MB_NO']?>&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?\n\n정보가 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
					                        </td>
                    					</tr>
							<?php
										}
									}
								}
								}
							}
						}//end of while
					}//end of if
					}
					}
				?>
		<?php
				}
		?>
        </tbody>
		</table>
	</div>

    <div class="brdlist_footer">
        <div class="bt">
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=organ1ins&code1=<?php echo $code1?>&amp;code2=<?php echo $code2?>&token=<?php echo site_config_token?>" class="btn_big"><strong>부서등록</strong></a>
        </div>
	</div>
</div>