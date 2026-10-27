<?php
	require_once $dir3."bbs.list.header.php";
?>

<script type="text/javascript">
/*$(function(){
	$("#chkDel button").on("click",function(e){
		e.preventDefault();
		var vaildCount = 0;
		$("input.delNo").each(function(){
			if($(this).is(":chcked") == true){
				vaildCount ++;
			}
		});
		if($(this).hasClass("selectDelete") || $(this).hasClass("selectAdelete")){
			if(vaildCount == 0){
				alert("삭제한 내역이 없습니다.");
				return false;
			}
			$("#chkDel #act").val($(this).attr("class"));
			$("#chkDel").submit();
		}	
	});
});*/
</script>

<div id="cenCont_in">
	<?php echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>
	<div class="brdlist_head">
		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">&bull;&nbsp;총 게시글 <b><?php echo $paging['total_record']?>건</b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
	        <div class="fr">
	        	<form id="searchBox" name="searchBox" method="get" action="sub.php">
	        		<input type="hidden" id="menukey" name="menukey" value="<?php echo $menukey?>" />
	        		<input type="hidden" id="mod" name="mod" value="<?php echo $mod?>" />    		
	        		<input type="hidden" id="scode" name="scode" value="<?php echo $scode?>" />
	        		<select id="code3" name="code3" class="selline" title="검색조건" style="width:160px" onchange="submit(); return false;">
		        		<option value="">전체유형</option>
		        		<?php
		        			while($trow = $coreClass -> selectFetchArray($trs)) {
		        				echo "<option value=\"".$trow['BRDSKIN_ID']."\"";
								if($trow['BRDSKIN_ID'] == $code3) {
									echo "selected=\"selected\"";
								}		        				
		        				echo ">".$trow['BRDSKIN_NAME']."</option>";
							}
						?>
					</select>  		
		        	<select id="code4" name="code4" class="selline" title="검색조건" style="width:180px" onchange="submit(); return false;">
		        		<option value="">전체게시판</option>
		        		<?php
		        			while($brow = $coreClass -> selectFetchArray($brs)) {
		        				$bcwhere		= "WHERE brdata_bid = '".$brow['BOARD_ID']."'";
								$bcnt			= $coreClass -> selectQueryCount(tbl_board_data, $bcwhere);	
		        				echo "<option value=\"".$brow['BOARD_ID']."\"";
								if($brow['BOARD_ID'] == $code4) {
									echo "selected=\"selected\"";
								}		        				
		        				echo ">".$brow['BOARD_NAME']." [".$bcnt."]</option>";
							}
						?>
					</select>
		            <?php echo $coreClass -> searchBoxType4_3($menukey, $mod, $scode, $search, $kwd)?>
				</form>
	        </div>
		</div>
	</div>

    <div class="brdlist_content">
	<?php if(S_mb_level <= site_config_level) { ?>
   	<form id="chkDel" name="chkDel" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	    <input type="hidden" name="mod" value="process">
        <input type="hidden" name="act" id="act" value="">
	    <input type="hidden" name="search" value="<?php echo $search?>">
	    <input type="hidden" name="kwd" value="<?php echo $kwd?>">
	    <input type="hidden" name="scode" value="<?php echo $scode?>">
	<?php } ?>
		<table class="tbl_list1" border="1" cellspacing="0" summary="게시글 목록">
        <caption>게시글 목록</caption>
        <colgroup>
        	<?php if(S_mb_level <= bbs_config_level && !empty($scode)) { ?><col width="5%" /><?php } ?>
        	<col width="6%" />
            <col />
            <col width="8%" />
            <col width="5%" />
            <col width="7%" />
            <col width="5%" />
        	<col width="12%" />
        	<col width="12%" />
        </colgroup>
        <thead>
        	<tr>
				<?php if(S_mb_level <= bbs_config_level && !empty($scode)) { ?><th><input type="checkbox" name="checkAll" value="1" class="checkAll"></th><?php } ?>
				<th><b>번호</b></th>
				<th><b>제목/게시판명</b></th>
				<th><b>작성자</b></th>
				<th><b>조회수</b></th>
				<th><b>상태</b></th>
				<th><b>파일</b></th>
				<th><b>등록일</b></th>
				<th><b>처리</b></th>
            </tr>
        </thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<?php if(S_mb_level <= bbs_config_level && !empty($scode)) { ?>
				<tr><td colspan="9">정보가 없습니다</td></tr>
				<?php }else{ ?>
				<tr><td colspan="8">정보가 없습니다</td></tr>
				<?php } ?>
			<?php
				} else {
					$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
					while($row = $coreClass -> selectFetchArray($rs)) {
						$space	= "";
						$re		= "";
						$file		= "";
						for($i = 1; $i < $row['BRDATA_LEVEL_NO']; $i++) {
							$space .= "&nbsp;&nbsp;";
						}
						if($row['BRDATA_LEVEL_NO'] > 0){
							$re = $space."&nbsp;&nbsp;<img src=\"/base/imgs/icon/icon_reply.gif\" alt=\"답글\" style=\"vertical-align:middle\" />&nbsp;";
						}
						
						// 게시판명
						$brdTitle	= "WHERE BOARD_ID = '".$row['BRDATA_BID']."'";
						$brdTitle	= $coreClass -> selectQueryArray($tbl3, $brdTitle, "", "" ,"");

						// 첨부파일 여부
						//include $dir3."lib.default.php";						
			?>
                <tr>
					<?php if(S_mb_level <= bbs_config_level && !empty($scode)) { ?>
					<td><input type="checkbox" name="seq[]" value="'.$row['BRDATA_NO'].'" class="delNo"></td>
					<?php } ?>
   	                <td class="num"><?php echo $num?><?php if(S_mb_level <= site_config_level) { ?><!--input type="checkbox" name="chk[]" value="<?php echo $row['BRDATA_NO']?>" /--><?}?></td>
   	                <td class="title">
   	                	<?php echo $re?><a href="sub.php?menukey=<?php echo $menukey?>&mod=view&no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>"><b><?php echo $row['BRDATA_SUBJECT']?></b></a>
   	                	<br /><?php echo $brdTitle['BOARD_NAME']?>
   	                </td>
   	                <td><?php echo $row['BRDATA_NAME']?></td>
   	                <td><?php echo $row['BRDATA_HIT']?></td>
   	                <td class="date">
   	                	<?php	
   	                		if($row['BRDATA_DELETED'] == 'N') {
   	                			echo "<span style=\"color:#00f;\">활성</span>";
							} else if($row['BRDATA_DELETED'] == 'Y') {
								if($row['BRDATA_DELTYPE'] == '1') {
   	                				echo "<span style=\"color:#f00;\">삭제</span>";
								} else if($row['BRDATA_DELTYPE'] == '2') {
   	                				echo "<span style=\"color:#f00;\">관리자삭제</span>";
								} else if($row['BRDATA_DELTYPE'] == '3') {
									echo "<span style=\"color:#f00;\">사용자삭제</span>";
								}
							}
   	                	?>
   	                </td>
   	                <td><?php echo $file ?></td>
					<td class="date"><?php echo date("Y/m/d H:i:s",strtotime($row['BRDATA_REGDATE']))?></td>
					<td>
						<?php if($row['BRDATA_DELETED'] == 'N') { ?>
		                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>">[수정]</a>&nbsp; 
							<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['BRDATA_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('삭제합니까?\n\n내용이 모두 삭제됩니다.')) location.href=this.href; return false">[삭제]</a>
						<?php } else if($row['BRDATA_DELETED'] == 'Y') { ?>
		                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=restore&no=<?php echo $row['BRDATA_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>">[복구]</a>&nbsp; 
							<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=adelete&no=<?php echo $row['BRDATA_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('완전삭제합니까?\n\n내용이 모두 완전삭제됩니다.')) location.href=this.href; return false">[완전삭제]</a>
						<?php } ?>							
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
			<div style="float:left; width:50%; text-align:left;">
			<?php if(S_mb_level <= bbs_config_level && !empty($scode)) { ?>
				<button type="button" class="btn_big selectDelete"><strong>선택삭제</strong></button>
				<button type="button" class="btn_big selectAdelete"><strong>선택완전삭제</strong></button>
			<?php } ?>
			</div>
			<div style="float:left; width:50%;">
				<?php if(!empty($search)){ ?>
					<a href="sub.php?menukey=<?php echo $menukey?>&mod=list&scode=<?=$scode?>" class="btn_big"><span>전체목록</span></a>
				<?php } ?>
				<a href="sub.php?menukey=<?php echo $menukey?>&mod=insert<?php echo $listVar?>" class="btn_big"><strong>등록</strong></a>
			</div>
        </div>

    </div>

	<?php if(S_mb_level <= site_config_level) { ?>
	</form>
	<?php } ?>

	 <?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
</div>    