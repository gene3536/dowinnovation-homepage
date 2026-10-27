<?php
	/** 140624 */	
	$where	= "WHERE (icd_scode = '".site_config_code."' OR icd_scode = '00000000') AND icd_pid = '".$pid."' AND icd_sdate <= '".site_regdate."' AND icd_edate >= '".site_regdate."' AND icd_visible = 'Y'";
	if(!empty($search) && $search == 1) {
		$where .= " AND icd_title LIKE '%".$kwd."%'";
	}
	if(!empty($scode)) {
		$where .= " AND icd_scode = '".$scode."'";
	}
	
	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY icd_regdate DESC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);
?>

<div class="chead">
	<div class="board_info clearfix">
		<ul class="info" style="padding-top:3px;">
			<li><b>전체</b> : <?php echo $paging['total_record']?></li>
			<li><b>페이지</b> : <?php echo $page?>/<?php echo $paging['realendofpage']?></li>
		</ul>
		<div class="part">
            <?php echo $coreClass -> searchBoxType3($menukey, $mod, $scode, $search, $kwd)?>        
        </div>
	</div>
</div>

<div class="cbody">
	<table class="board" summary="인포존 목록">
        <caption>목록</caption>
        <colgroup>
        	<col style="width: 8%" />
        	<col />
        	<col style="width: 40%" />
        	<col style="width: 18%" />
        </colgroup>        
        <thead>
        	<tr>
				<th><b>번호</b></th>
				<th><b>이미지</b></th>
				<th><b>제목</b></th>
				<th class="last"><b>등록일</b></th>
            </tr>
        </thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr><td colspan="5">출력할 데이터가 없습니다.</td></tr>
			<?php
				} else {
					$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
					while($row = $coreClass -> selectFetchArray($rs)) {
			?>
                <tr>
   	                <td class="num"><?php echo $num?></td>
   	                <td>
   	                	<?php if(!empty($row['ICD_SFILENAME'])) { ?>
	                		<a href="http://<?php echo $row['ICD_URL'] ?>" target="<?php echo $row['ICD_TARGET'] ?>"><img src="<?php echo $imgPath.$row['ICD_FILEYEAR']."/".$row['ICD_SFILENAME']?>" alt="<?php echo $row['ICD_TITLE']?>" style="max-width:600px;" /></a>
						<?php } ?>
					</td>
   	                <td class="title"><a href="http://<?php echo $row['ICD_URL'] ?>" target="<?php echo $row['ICD_TARGET'] ?>"><b><?php echo $row['ICD_TITLE']?></b></a></td>
					<td class="date"><?php echo date("Y/m/d",strtotime($row['ICD_REGDATE']))?></td>
				</tr>
			<?php
					$num--;
					}//end of while
				}//end of if
			?>
        </tbody>
	</table>
</div>

<div class="cfoot">
	<div class="board_btn_align">
		<?php if(!empty($search)){ ?>
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=list" class="btn_big"><span>전체목록</span></a>
		<?php } ?>
	</div>
	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, "", "", $scode, $codes)?>
</div>    