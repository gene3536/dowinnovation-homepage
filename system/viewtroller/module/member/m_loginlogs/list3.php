<?php
	$where = "LEFT JOIN ".$tbl1." ON mb_uid = mb_logx_uid WHERE 1=1";
	
	// 검색분류
	if($search == 1) {
		$where .= " AND (mb_logx_regdate like '%".$kwd."%'";
		$where .= " OR mb_logx_regip like '%".$kwd."%'";
		$where .= " OR mb_logx_uid like '%".$kwd."%'";
		$where .= " OR mb_name like '%".$kwd."%')";
	}
	
	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl4, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);

	$order			= "ORDER BY mb_logx_regdate DESC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl4, $where, $order, $snum, $rnum);	
?>

<form name="search" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" name="mod" value="<?php echo $mod?>">

	<div id="cenCont_in">
		<div class="tabs">
			<ul>  
				<li <?php if($code1 == 1) { ?> class="on" <?php } ?>>
					<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=1">로그인 성공내역</a>  
				</li>  
				<li <?php if($code1 == 2) { ?> class="on" <?php } ?>>
					<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=2">로그인 실패내역</a>  
				</li>
				<li <?php if($code1 == 3) { ?> class="on" <?php } ?>>
					<a href="sub.php?menukey=<?php echo $menukey?>&amp;code1=3">로그인 실패회수</a>  
				</li>
			</ul>  
		</div>
		
		<div class="brdlist_head">
			<div class="searchBoxType1 clearfix">
				<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?></b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
		        <div class="fr"><?php echo $coreClass -> searchBoxType2($search, $kwd)?></div>
			</div>
		</div>
	
	    <div class="brdlist_content">
			<table class="tbl_list1" summary="회원목록">
	        <caption>회원목록</caption>
	        <colgroup>
	        	<col width="8%" />
	        	<col />
	        	<col width="12%" />
	        	<col width="8%" />
	        	<col width="10%" />
	        	<col width="10%" />
	        	<col width="16%" />
	        	<col width="16%" />
	        	<col width="12%" />
        	</colgroup>
	        
	        <thead>
	        	<tr>
					<th scope="col"><b>번호</b></th>
					<th scope="col"><b>이름</b></th>
					<th scope="col"><b>아이디</b></th>
					<th scope="col"><b>레벨</b></th>
					<th scope="col"><b>상태</b></th>
					<th scope="col"><b>실패횟수</b></th>
					<th scope="col"><b>최근접속IP</b></th>
					<th scope="col"><b>최근접속시간</b></th>
					<th scope="col"><b>비고</b></th>
				</tr>
	        </thead>
	        
	        <tbody>
				<?php
					if($paging_result < 1) {
						echo '<tr><td colspan="9">출력할 데이터가 없습니다</td></tr>';
					} else {
						$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
						while($row = $coreClass -> selectFetchArray($rs)) {
				?>
	            <tr>
		            <td class="num"><?php echo $num--?></td>
		            <td><b><?php echo $row['MB_NAME']?></b></td>
					<td><?php echo $row['MB_UID']?></td>
					<td><?php echo $row['MB_LEVEL']?></td>
					<td>
						<?php
							if($row['MB_DEL'] == "N"){
								echo "<span style=\"color:#00f\">사용</span>";
							} else if($row['MB_DEL'] == "Y"){
							    echo "<span style=\"color:#f00\">정지</span>";
	                        }
						?>
	                </td>
					<td><?php echo $row['MB_LOGX_CNT']?></td>
	                <td><?php echo $row['MB_LOGX_REGIP']?></td>
					<td class="date"><?php echo $row['MB_LOGX_REGDATE']?></td>
					<td>
                        <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['MB_LOGX_UID']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('계정을 삭제합니까?\n\n계정정보를 삭제합니다.')) location.href=this.href; return false">[삭제]</a>
	                </td>
				</tr>
				<?php
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
	        </div>
	       	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
		</div>	    
	</div>
</form>