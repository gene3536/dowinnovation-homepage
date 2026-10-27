<?php
	require_once $dir2.'list.header.php';
?>
			
<div id="cenCont_in">
	<?php echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>
	
	<div class="brdlist_head">
		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?></b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>
	        <div class="fr">
	            <?php echo $coreClass -> searchBoxType3($menukey, $mod, $scode, $search, $kwd)?>        
	        </div>
		</div>
	</div>
    
    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0" summary="콘텐츠 목록">
        <caption>콘텐츠 목록</caption>
        <colgroup>
        	<col style="width:8%;" />
        	<col />
        	<col style="width:16%;" />
        	<col style="width:8%;" />
        	<col style="width:12%;" />
        	<col style="width:12%;" />
        </colgroup>
        
        <thead>    
        	<tr>
				<th><b>번호</b></th>
				<th><b>콘텐츠명</b></th>
				<th><b>사이트명</b></th>
				<th><b>등록일</b></th>
				<th><b>최종수정일</b></th>
				<th><b>처리</b></th>
            </tr>
        </thead>
        <tbody>
			<?php if($paging_result < 1) { ?>
				<tr><td colspan="6">출력할 데이터가 없습니다.</td></tr>
			<?php
				} else {
					$num = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
					while($row = $coreClass -> selectFetchArray($rs)){
			?>
                <tr>
   	                <td class="num"><?php echo $num?></td>
					<td class="title"><a href="sub.php?menukey=<?php echo $menukey?>&mod=view&no=<?php echo $row['ICD_NO']?><?php echo $listVar?>"><b><?php echo $row['ICD_TITLE']?></b></a></td>
   	                <td>
						<?php
							if($row['ICD_SCODE'] == "00000000") {
								echo "[전체]";
							} else {
								$where = "WHERE cms_info_code = '".$row['ICD_SCODE']."'";
								$rows = $coreClass -> selectQueryArray(tbl_cms_info, $where, "", "", "");
								echo "[".$rows['CMS_INFO_TITLE']."]";
							}
						?>
                    </td>
					<td class="date"><?php echo date("Y/m/d",strtotime($row['ICD_REGDATE']))?></td>
					<td class="date"><?php echo date("Y/m/d H:i:s",strtotime($row['ICD_MODDATE']))?></td>
					<td>
                    	<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['ICD_NO']?><?php echo $listVar?>">수정</a> |
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['ICD_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('삭제합니까?\n\n정보가 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
					</td>
				</tr>
			<?php
					$num--;
					}//end of while
				}//end of if
			?>
        </tbody>
		</table>
	</div>
    
    <div class="brdlist_footer">    
        <div class="bt">
            <?php if($search){ ?>
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=list" class="btn_big"><span>전체목록</span></a>
            <?php } ?>
                <a href="sub.php?menukey=<?php echo $menukey?>&mod=insert<?php echo $listVar?>" class="btn_big strong"><button type="button">등록</button></a>
        </div>
       	<?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
	</div>
</div>