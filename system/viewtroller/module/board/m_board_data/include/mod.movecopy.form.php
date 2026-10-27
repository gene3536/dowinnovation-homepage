<?php
	/**
	 * 게시판관리 목록
	 */
	$where	= "WHERE 1=1";
	if($code1 == 1) {
		$where .= " AND board_type = 'board'";
	} else if($code1 == 2) {
		$where .= " AND board_type = 'board_minwon'";
	} else if($code1 == 3) {
		$where .= " AND board_type = 'board_gallery'";
	} else if($code1 == 4) {
		$where .= " AND board_type != 'board' AND board_type != 'board_minwon' AND board_type != 'board_gallery'";
	}

	if($search == 1 && !empty($kwd)) $where .= " AND board_name LIKE '%".$kwd."%'";
	else if($search == 2 && !empty($kwd)) $where .= " AND board_id LIKE '%".$kwd."%'";

	if(!empty($scode)) {
		$where .= " AND board_scode = '".$scode."'";
	}
	
	$page			= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount(tbl_board, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY board_no ASC";
	$snum			= $paging['startofrecord'];
	$rnum			= $paging['numofrecord'];
	$rs				= $coreClass -> selectQuery(tbl_board, $where, $order, $snum, $rnum);
	//echo "SELECT * FROM ".tbl_board." ".$where." ".$order;
?>

<div id="cenCont_in">


	<div class="board_info clearfix">
		<?php //echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>

		<ul class="info" style="padding-top:3px;">
			<li>게시글 : <?php echo number_format($paging['total_record'])?>건</li>
			<li>페이지 : <?php echo $page?>/<?php echo $paging['realendofpage']?></li>
		</ul>
		<div class="part">
				<form id="searchBox" name="searchBox" method="get" action="sub.php">
					
				<input type="hidden" id="menukey" name="menukey" value="<?php echo $menukey?>" />
					
				<input type="hidden" id="mod" name="mod" value="<?php echo $mod?>" />
				<input type="hidden" id="scode" name="scode" value="<?php echo $scode?>" />					
				<input type="hidden" id="no" name="no" value="<?php echo $no?>" />					
					<select name="search" class="selline" title="검색조건" style="width:120px">
						<option value="1"<?php if($search == 1) " selected=\"selected\""?>>게시판명</option>
						<option value="2"<?php if($search == 2) " selected=\"selected\""?>>게시판ID</option>
					</select>
					<input type="text" name="kwd" title="검색어입력" class="inpline" maxlength="20" value="<?php echo $kwd?>" />
					<span class="btn_pack3 white"><input value="검색" type="submit" /></span>
				</form>

		</div>

	</div>

<script type="text/javascript">

function checkChangeData(aa, status) {
	var f = document.changeDataForm;
    
	f.fld.value  = aa;
	f.datasSid.value  = <?=$no?>;

	if(f.fld.value == "" || f.fld.value == 0) {
		alert("대상 게시판을 선택해 주세요.");
		return;
	}


	var copyReply = "N";
	if(f.copyReply.checked == true){
		copyReply = "Y";
	}
	
	if(status == "C"){
		f.act.value="bbscopy";
	}else{
		f.act.value="bbsmove";
	}
	//alert(f.fld.value);
	//return false;

	f.submit(f.act.value);
	//changeDataStr.changeDataStr(boardSid, dataSid, status, copyReply, "218.151.87.92", ListChangeDataCallback);
}
</script>

	

	<form name="changeDataForm" method="post" action="sub.php?menukey=<?php echo $menukey?>""><!-- onsubmit="javascript:return checkChangeData(changeDataForm) target="comboaction" -->
		<input type="hidden" name="datasSid">
		<input type="hidden" name="dataStatus">
		
		<input type="hidden" name="mod" value="process">
		<input type="hidden" name="act" id="act" value="">
		<input type="hidden" name="fld" id="fld" value="">
		<input type="hidden" name="token" value="<?php echo site_config_token?>" />

<?php

	// 게시글 쿼리
	$where_data	= "WHERE brdata_no = '".$no."'";
	
	$coreClass -> selectQueryCountChk(tbl_board_data, $where_data);
	$row			= $coreClass -> selectQueryArray(tbl_board_data, $where_data, "", "", "");
	$bid			= $row['BRDATA_BID'];

	$bwhere		= "WHERE board_id = '".$bid."'";
	$coreClass -> selectQueryCountChk(tbl_board, $bwhere);
	$brow			= $coreClass -> selectQueryArray(tbl_board, $bwhere, "", "", "");

?>

		<div style="padding:10px; text-align:left">
			* 게시판명 : <strong><?php echo $brow['BOARD_NAME'] ?></strong> <br/>
			* 게 시 글 : <strong><?php echo $row['BRDATA_SUBJECT'] ?></strong> <br/>
			* <input type="checkbox" name="copyReply" id="copyReply" value="Y" checked="checked"> <label for="copyReply"><font color="blue">답변글 또는 원본글 포함</font></label><br/>
			* 게시판을 검색 후 이동/복사 합니다.<br />

		</div>

	<table class="board" border="0" cellspacing="0" summary="게시판목록">
        <caption>게시판목록</caption>
        <colgroup>
        	<col style="width: 6%" />
        	<col style="width: 16%" />
        	<col />
        	<col style="width: 12%" />
        	<col style="width: 12%" />
        	<col style="width: 16%" />
        </colgroup>
        
        <thead>    
            <tr>
                <th>No.</th>
                <th>사이트</th>
                <th>게시판명</th>
                <th>게시글수</th>
				<th>게시판타입</th>
                <th class="last">처리</th>
            </tr>
		</thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr>
                	<td colspan="6">출력할 데이터가 없습니다.</td></tr>
			<?php
				} else {
					if($page == 1) {
						$qnaWhere = "WHERE board_id = '0c8f917e-f21f-459a-ae18-4a34285a3eb6'";
						$qnaRow = $coreClass -> selectQueryArray(tbl_board, $qnaWhere, "", "", "");

						$qnaCntWhere = "WHERE brdata_bid = '".$qnaRow['BOARD_ID']."'";
						$qnaRsCnt	= $coreClass -> selectQueryCount(tbl_board_data, $qnaCntWhere);

						$qnaibwhere		= "WHERE cms_info_code = '".$qnaRow['BOARD_SCODE']."'";
						$qnairow		= $coreClass -> selectQueryArray(tbl_cms_info, $qnaibwhere, "", "", "");
			?>
			<tr>
				<td></td>
                <td><?php echo $qnairow['CMS_INFO_TITLE']?></td>
                <td class="txt_left">
                	<a href="sub.php?menukey=<?php echo $menukey?>&mod=view&scode=<?php echo $scode?>&no=<?php echo $qnaRow['BOARD_NO']?>"><strong><?php echo $qnaRow['BOARD_NAME']?></strong></a><br />
                </td>
				
				<td><?php echo $qnaRsCnt?></td>
                <td><?php echo $boardClass -> getBoardSkinName($qnaRow['BOARD_TYPE'])?></td>
				<td>
                	<span class="btn_pack3 white">
						<input value="이동" type="button" onclick="checkChangeData('<? echo $qnaRow['BOARD_ID']?>', 'M');return false;">
					</span>
                	<span class="btn_pack3 white">
						<input value="복사" type="button" onclick="checkChangeData('<? echo $qnaRow['BOARD_ID']?>', 'C');return false;">
					</span>
                </td>
			</tr>
			<?php
					}

					$cnt = (($paging['page'] - 1) * $paging['numofrecord']) + 1;
					while($row = $coreClass -> selectFetchArray($rs)){
						// 게시글 수
						
						$where = "WHERE brdata_bid = '".$row['BOARD_ID']."'";
						
						$rsCnt	= $coreClass -> selectQueryCount(tbl_board_data, $where);

						$ibwhere		= "WHERE cms_info_code = '".$row['BOARD_SCODE']."'";
						$irow			= $coreClass -> selectQueryArray(tbl_cms_info, $ibwhere, "", "", "");
			?>
            <tr>
                <td><?php echo $cnt?></td>
                <td><?php echo $irow['CMS_INFO_TITLE']?></td>
                <td class="txt_left">
                	<a href="sub.php?menukey=<?php echo $menukey?>&mod=view&scode=<?php echo $scode?>&no=<?php echo $row['BOARD_NO']?>"><strong><?php echo $row['BOARD_NAME']?></strong></a><br />
                </td>
				
				<td><?php echo $rsCnt?></td>
                <td><?php echo $boardClass -> getBoardSkinName($row['BOARD_TYPE'])?></td>

                <td>
                	<span class="btn_pack3 white">
						<input value="이동" type="button" onclick="checkChangeData('<? echo $row['BOARD_ID']?>', 'M');return false;">
					</span>
                	<span class="btn_pack3 white">
						<input value="복사" type="button" onclick="checkChangeData('<? echo $row['BOARD_ID']?>', 'C');return false;">
					</span>
                </td>
            </tr>
	    <?php
						$cnt++;
				}
			}
		?>
        </tbody>
	</table>
	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
</div>