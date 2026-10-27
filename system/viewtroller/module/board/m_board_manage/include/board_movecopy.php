<?php

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
	
	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl3, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY board_no ASC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl3, $where, $order, $snum, $rnum);
?>

<div id="cenCont_in">

	<div class="brdlist_head">
		<?php //echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>


		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?>건</b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>	<div class="fr">
				
				<form id="searchBox" name="searchBox" method="get" action="sub.php">
					
				<input type="hidden" id="menukey" name="menukey" value="<?php echo $menukey?>" />
					
				<input type="hidden" id="mod" name="mod" value="<?php echo $mod?>" />
				<input type="hidden" id="scode" name="scode" value="<?php echo $scode?>" />					
				<input type="hidden" id="no" name="no" value="<?php echo $no?>" />					
					<select name="search" class="selline" title="검색조건" style="width:120px">
						<option value="1"<?php if($search == 1) " selected=\"selected\""?>>제목</option>
						<option value="2"<?php if($search == 2) " selected=\"selected\""?>>게시판ID</option>
					</select>
					<input type="text" name="kwd" title="검색어입력" class="inpline" maxlength="20" value="<?php echo $kwd?>" />
					<span class="btn_pack medium icon" style="vertical-align:middle">
						<span class="refresh"></span>
						<input value="검색" type="submit" />
					</span>
				</form>

			</div>

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
	<form name="changeDataForm" method="post" action="sub.php?menukey=<?php echo $menukey?>""><!-- onsubmit="javascript:return checkChangeData(changeDataForm) target="comboaction" -->
		<input type="hidden" name="datasSid">
		<input type="hidden" name="dataStatus">
		
		<input type="hidden" name="mod" value="process">
		<input type="hidden" name="act" id="act" value="">
		<input type="hidden" name="fld" id="fld" value="">
		<input type="hidden" name="token" value="<?php echo site_config_token?>" />


		<div style="padding:10px; text-align:left">
			* 게시판명 : <strong><?php echo $brow['BOARD_NAME'] ?></strong> <br/>
			* 게 시 글 : <strong><?php echo $row['BRDATA_SUBJECT'] ?></strong> <br/>
			* <input type="checkbox" name="copyReply" id="copyReply" value="Y" checked="checked"> <label for="copyReply"><font color="blue">답변글 또는 원본글 포함</font></label><br/>
			* 게시판을 검색 후 이동/복사 합니다.<br />

		</div>

    <div class="brdlist_content">

		


		<table class="tbl_list1" border="1" cellspacing="0" summary="게시판목록">
        <caption>게시판목록</caption>
        <colgroup>
        	<col width="6%" />
        	<col width="14%" />
        	<col />
        	<col width="6%" />

			<col width="14%" />
        	<col width="10%" />
        </colgroup>
        
        <thead>    
            <tr>
                <th>No.</th>
                <th>사이트</th>
                <th>게시판명</th>
                <th>게시글수</th>

				<th>게시판타입</th>
                <th>처리</th>
            </tr>
		</thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr>
                	<td colspan="10">출력할 데이터가 없습니다.</td></tr>
			<?php
				} else {
					while($row = $coreClass -> selectFetchArray($rs)){
						// 게시글 수
						
						$where = "WHERE brdata_bid = '".$row['BOARD_ID']."'";
						
						$rsCnt	= $coreClass -> selectQueryCount($tbl1, $where);

						$ibwhere		= "WHERE cms_info_code = '".$row['BOARD_SCODE']."'";
						$irow			= $coreClass -> selectQueryArray(tbl_cms_info, $ibwhere, "", "", "");

			?>
            <tr>
                <td><?php echo $row['BOARD_NO']?></td>
                <td><?php echo $irow['CMS_INFO_TITLE']?></td>
                <td class="title">
                	<a href="sub.php?menukey=<?php echo $menukey?>&mod=view&scode=<?php echo $scode?>&no=<?php echo $row['BOARD_NO']?>"><strong><?php echo $row['BOARD_NAME']?></strong></a><br />
                </td>
				
				<td><?php echo $rsCnt?></td>
                <td><?php echo $boardClass -> getBoardSkinName($row['BOARD_TYPE'])?></td>

                <td>
                	<span class="btn_pack medium" style="vertical-align:middle">
						<input value="이동" type="button" onclick="checkChangeData('<? echo $row['BOARD_ID']?>', 'M');return false;">
					</span>
                	<span class="btn_pack medium" style="vertical-align:middle">
						<input value="복사" type="button" onclick="checkChangeData('<? echo $row['BOARD_ID']?>', 'C');return false;">
					</span>
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
        <?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
	</div>    
</div>