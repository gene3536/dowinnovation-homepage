<?php 
	$where = "LEFT JOIN ".$tbl4." ON mb_level_lv = mb_level WHERE 1=1";
	
	// 검색분류
	if($search == 1) {
		$where .= " AND (mb_name like '%".$kwd."%'";
		$where .= " OR mb_uid like '%".$kwd."%')";
	}
	
	// 부서분류
	if(!empty($cate)) {
		$where .= " AND mb_level = '".$cate."'";
	}

	// 활동여부
	if($code1 == 2) {
		$where .= " AND mb_del = 'N'";
	} else if($code1 == 3) {
		$where .= " AND mb_del = 'Y'";
	}

	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY mb_regdate DESC, mb_no DESC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);

	// 레벨목록
	$where = "WHERE mb_level_visible ='Y'";
	$order = "ORDER BY mb_level_lv ASC";
	$result = $coreClass -> selectQuery($tbl4, $where, $order, "", "");
	while($rowc = $coreClass -> selectFetchArray($result)) {
		$sel = '';
		if($rowc['MB_LEVEL_LV'] == $cate) $sel = ' selected="selected"';
		$level_data .= '<option value="'.$rowc['MB_LEVEL_LV'].'"'.$sel.'>'.$rowc['MB_LEVEL_TITLE'].'</option>';
	}
?>

<form name="search" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" name="mod" value="<?php echo $mod?>">
	<input type="hidden" name="scode" value="<?php echo $scode?>">

	<div id="cenCont_in">
		<div class="tabs">
			<ul>  
				<li <?php if($code1 == 1) { ?> class="on" <?php } ?>>
					<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=1">전체계정</a>  
				</li>  
				<li <?php if($code1 == 2) { ?> class="on" <?php } ?>>
					<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=2">사용계정</a>  
				</li>
				<li <?php if($code1 == 3) { ?> class="on" <?php } ?>>
					<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=3">정지계정</a>  
				</li>  
			</ul>  
		</div>
		
		<div class="brdlist_head">
			<div class="searchBoxType1 clearfix">
				<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?></b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
		        <div class="fr">
		        	<select name="cate" id="cate" class="selline" style="width:120px;" onchange="submit(); return false;">
		        		<option value="">전체멤버</option>
						<?php echo $level_data?>
			        </select>
		            <?php echo $coreClass -> searchBoxType2($search, $kwd)?>        
		        </div>
			</div>
		</div>
	
	    <div class="brdlist_content">
			<table class="tbl_list1" summary="회원목록">
	        <caption>회원목록</caption>
	        <colgroup>
	        	<col width="6%" />
	        	<col />
	        	<col width="12%" />
	        	<col width="12%" />
	        	<col width="6%" />
	        	<col width="12%" />
	        	<col width="12%" />
	        	<col width="12%" />
	        	<col width="10%" />
	        </colgroup>
	        
	        <thead>
	        	<tr>
					<th scope="col"><b>번호</b></th>
					<th scope="col"><b>이름</b></th>
					<th scope="col"><b>아이디</b></th>
					<th scope="col"><b>레벨</b></th>
					<th scope="col"><b>상태</b></th>
					<th scope="col"><b>최근접속일</b></th>
					<th scope="col"><b>등록일/수정일</b></th>
					<th scope="col"><b>탈퇴일</b></th>
					<th scope="col"><b>처리</b></th>
	            </tr>
	        </thead>
	        
	        <tbody>
				<?php
					if($paging_result < 1) {
						echo '<tr><td colspan="10">멤버정보가 없습니다</td></tr>';
					} else {
						$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
						while($row = $coreClass -> selectFetchArray($rs)) {
								$where	= "WHERE mb_log_uid = '".$row['MB_UID']."'";
								$order	= "ORDER BY mb_log_regdate DESC";
								$lcnt		= $coreClass -> selectQueryCount($tbl2, $where);
								$lrow		= $coreClass -> selectQueryArray($tbl2, $where, $order, 0, 1);
				?>
	            <tr>
		            <td class="num"><?php echo $num?></td>
					<td><a href="sub.php?menukey=<?php echo $menukey?>&mod=view&no=<?php echo $row['MB_NO']?><?php echo $listVar?>"><b><?php echo $row['MB_NAME']?></b></a></td>
					<td><?php echo $row['MB_UID']?></td>
					<td><?php echo $row['MB_LEVEL_TITLE']?></td>
					<td>
						<?php
							if($row['MB_DEL'] == "N"){
								echo "<span style=\"color:#00f\">사용</span>";
							} else if($row['MB_DEL'] == "Y"){
							    echo "<span style=\"color:#f00\">정지</span>";
	                        }
						?>
	                </td>
					<td class="date"><?php if($lcnt > 0) {echo date("Y/m/d H:i:s",strtotime($lrow['MB_LOG_REGDATE']));}?></td>
	                <td class="date"><?php echo date("Y/m/d H:i:s", strtotime($row['MB_REGDATE']))?><br /><?php echo date("Y/m/d H:i:s", strtotime($row['MB_MODDATE']))?></td>
					<td class="date"><?php if($row['MB_DEL'] == 'Y') { echo date("Y/m/d H:i:s",strtotime($row['MB_DELDATE'])); }?></td>
					<td>
	                    <?php if($row['MB_DEL'] == "N"){ ?>
	    					<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['MB_NO']?><?php echo $listVar?>">수정</a> | 
	                        <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=withdraw&no=<?php echo $row['MB_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('계정을 정지합니까?\n\n계정정보를 정지합니다.')) location.href=this.href; return false">정지</a>
	                    <?php } else if($row['MB_DEL'] == 'Y'){ ?>
	                        <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=restore&no=<?php echo $row['MB_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('계정을 복구합니까?\n\n계정정보를 복구합니다.')) location.href=this.href; return false">복구</a>
	                    <?php } ?> |
	                        <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['MB_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('계정을 삭제합니까?\n\n계정정보를 삭제합니다.')) location.href=this.href; return false">삭제</a>
	                </td>
				</tr>
				<?php
						$num--;
						}
					}
				?>
			</tbody>            
			</table>
		</div>
		
	    <div class="brdlist_footer">
	        <div class="bt">
	            <?php if(!empty($search)){ ?>
	                <a href="sub.php?menukey=<?php echo $menukey?>" class="btn_big"><span>전체목록</span></a>
	            <?php } ?>
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=insert<?php echo $listVar?>" class="btn_big"><strong>등록</strong></a>
	        </div>
	       	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
	    </div>
	    
	</div>
</form>