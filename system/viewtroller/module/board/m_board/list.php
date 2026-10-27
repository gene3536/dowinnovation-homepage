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
	else if($search == 3 && !empty($kwd)) $where .= " AND BOARD_TYPE LIKE '%".$kwd."%'";

	if(!empty($scode)) {
		$where .= " AND board_scode = '".$scode."'";
	}
	
	$page				= $page ? $page : 1;
	$numofrecord	= 20;
	$paging_result	= $coreClass -> selectQueryCount($tbl1, $where);
	$paging			= $coreClass -> pagingCore($paging_result, $numofrecord, $page);
	
	$order			= "ORDER BY board_no ASC";
	$snum			= $paging['startofrecord'];
	$rnum				= $paging['numofrecord'];
	$rs					= $coreClass -> selectQuery($tbl1, $where, $order, $snum, $rnum);
?>

<div id="cenCont_in">

	<div class="brdlist_head">
		<?php echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>
		<div style="padding:10px; text-align:left">
			* 처리 부분의 <font style="color:#900">[게시판 추가]</font>버튼을 클릭하시면 게시판을 생성 합니다.<br />
			* 처리 부분의 <font style="color:#900">[수정]</font>은 게시판 환경정보 수정을  <font style="color:#900">[삭제]</font>는 게시판삭제를 합니다.<br />
			* 단, 게시판 추가와 삭제 후에는 프로그램상 링크를 수정 삭제 해 주어야 합니다. 제작 업체에 문의해 주세요.<br />
			* table ID를 누르시면 해당 게시판으로 직접 링크합니다.<br />
			* 카테고리와 비밀글, 댓글은 사용 여부를 설정합니다.<br />
			* 공지, 접근, 보기, 쓰기, 댓글, 다운로드는 사용가능 등급을 설정합니다.<br />
		</div>

		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">&bull;&nbsp;전체 <b><?php echo $paging['total_record']?>건</b> - [<?php echo $page?>/<?php echo $paging['realendofpage']?>] 페이지</div>			
			<div class="fr">
				<form id="searchBox" name="searchBox" method="get" action="sub.php">
					<input type="hidden" id="menukey" name="menukey" value="<?php echo $menukey?>" />
					<input type="hidden" id="mod" name="mod" value="<?php echo $mod?>" />
					<input type="hidden" id="scode" name="scode" value="<?php echo $scode?>" />

		        	<select id="code1" name="code1" class="selline" title="검색조건" style="width:160px" onchange="submit(); return false;">
						<option value="">전체</option>
						<option value="1" <?php if($code1=="1") echo "selected";?>>일반게시판</option>
						<option value="2" <?php if($code1=="2") echo "selected";?>>민원게시판</option>
						<option value="3" <?php if($code1=="3") echo "selected";?>>갤러리게시판</option>
						<option value="4" <?php if($code1=="4") echo "selected";?>>기타게시판</option>
					</select>
					
					<select name="search" class="selline" title="검색조건" style="width:120px">
						<option value="1"<?php if($search == 1) " selected=\"selected\""?>>제목</option>
						<option value="2"<?php if($search == 2) " selected=\"selected\""?>>게시판ID</option>
						<option value="3"<?php if($search == 3) " selected=\"selected\""?>>게시판스킨</option>
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


    <div class="brdlist_content">
		<table class="tbl_list1" border="1" cellspacing="0">
        <colgroup>
        	<col width="6%" />
        	<col />
        	<col width="6%" />

			<col width="10%" />
        	<col width="8%" />
        	<col width="6%" />
        	<col width="6%" />
        	<col width="6%" />
        	<col width="6%" />
        	<col width="10%" />
        </colgroup>
        
        <thead>    
            <tr>
                <th>No.</th>
                <th>게시판명</th>
                <th>게시글수</th>

				<th>게시판타입</th>
                <th>분류</th>
                <th>비밀글</th>
                <th>댓글</th>
                <th>에디터</th>
                <th>1:1여부</th>
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
						$rsCnt	= $coreClass -> selectQueryCount($tbl2, $where);
			?>
            <tr>
                <td><?php echo $row['BOARD_NO']?></td>
                <td class="title">
                	<a href="sub.php?menukey=<?php echo $menukey?>&mod=view&scode=<?php echo $scode?>&no=<?php echo $row['BOARD_NO']?>"><strong><?php echo $row['BOARD_NAME']?></strong></a><br />
                	<a href="sub.php?menukey=33&code1=<?php echo $row['BOARD_ID']?>&code3=<?php echo $row['BOARD_TYPE']?>&scode=<?php echo $row['BOARD_SCODE']?>">[게시글보기]</a>&nbsp;<?php echo $row['BOARD_ID']?>
                </td>
				<td><?php echo $rsCnt?></td>
                <td><?php echo $boardClass -> getBoardSkinName($row['BOARD_TYPE'])?>
					<!--<? for($i=0;$i<count($arr_bbs_skin);$i++){
					 if($row['BOARD_TYPE']==$arr_bbs_skin[$i][1]) {
						 echo $arr_bbs_skin[$i][2];
						 continue;
					 }
					}?>-->

                </td>
                <td>
                	<?php echo $row['BOARD_CATEGORY']?> 
                    <?php if($row['BOARD_CATEGORY'] == "Y"){ ?>
                    	<a href="sub.php?menukey=<?php echo $menukey?>&mod=category_list&brdcat_bid=<?php echo $row['BOARD_ID']?>&scode=<?php echo $scode?>">[보기]</a>
		            <?php } ?>
                </td>
                <td><?php echo $row['BOARD_PRIVACY']?></td>
                <td><?php echo $row['BOARD_COMMENT']?></td>
                <td><?php echo $row['BOARD_EDITOR']?></td>
                <td><?php echo $row['BOARD_OTO']?></td>
                <td>
                	<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&scode=<?php echo $scode?>&no=<?php echo $row['BOARD_NO']?>">[수정]</a>
                	<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&scode=<?php echo $scode?>&act=delete&no=<?php echo $row['BOARD_NO']?>&token=<?php echo site_config_token?>" onClick="if(confirm('해당 게시판의 데이터가 모두 삭제됩니다.\n정말 삭제하시겠습니까?')) location.href=this.href; return false">[삭제]</a>
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
	        <a href="sub.php?menukey=<?php echo $menukey?>&mod=insert&scode=<?php echo $scode?>" class="btn_big"><strong>추가</strong></a>
        </div>
        <?php echo $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, $no, $id, $scode, $codes)?>
	</div>    
</div>