<?php
	require_once $dir2.'list.header.php';
?>

<div id="cenCont_in">

	<div class="brdlist_head">
		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?></b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
	        <div class="fr">
	            <?php echo $coreClass -> searchBoxType3($menukey, $mod, $scode, $search, $kwd)?>        
	        </div>
		</div>
	</div>
	
    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="통합콘텐츠데이터 목록">
        <caption>통합콘텐츠데이터 목록</caption>
        <colgroup>
        	<col width="6%" />
        	<col />
            <col width="15%" />
        	<col width="10%" />
        	<col width="15%" />
        	<col width="12%" />
        	<col width="12%" />
        	<col width="10%" />
        </colgroup>
        <thead>
        	<tr>
				<th><b>번호</b></th>
				<th><b>단체/회사명</b></th>
				<th><b>이름</b></th>
				<th><b>직책</b></th>
				<th><b>이메일</b></th>
				<th><b>연락처</b></th>
				<th><b>등록일</b></th>
				<th><b>처리</b></th>
            </tr>
        </thead>
        
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr><td colspan="8">출력할 데이터가 없습니다.</td></tr>
			<?php
				} else {
					$num = $paging["total_record"] - ($paging["page"]-1) * $paging["numofrecord"];
					while($row = $coreClass -> selectFetchArray($rs)) {
			?>
                <tr>
   	                <td class="num"><?php echo $num?></td>
					<td class="title">
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=view&no=<?php echo $row['ICD_NO']?><?php echo $var?>"><b><?php echo $row['ICD_TITLE']?></b></a>
					</td>
   	                <td><?php echo $row['ICD_NAME'] ?></td>
					<td><?php echo $row['ICD_FLD1'] ?></td>
					<td><?php echo $row['ICD_FLD2'] ?></td>
					<td><?php echo $row['ICD_FLD3'] ?></td>
					<td class="date"><?php echo date("Y/m/d H:i:s",strtotime($row['ICD_REGDATE']))?></td>
					<td>
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['ICD_NO']?><?php echo $listVar?>">수정</a> | 
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['ICD_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('삭제합니까?\n\n내용이 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
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
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=list" class="btn_big"><span>전체목록</span></a>
            <?php } ?>
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=insert<?php echo $listVar?>" class="btn_big strong"><strong>등록</strong></a>
        </div>
       	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
    </div>
</div>    