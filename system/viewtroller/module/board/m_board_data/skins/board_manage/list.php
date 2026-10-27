<?php
	require_once $dir2."list.header.php";
?>

<div class="board_info clearfix">
    <ul class="info" style="padding-top:3px;">
        <li>게시글 : <?php echo number_format($paging['total_record'])?>건</li>
        <li>페이지 : <?php echo $page?>/<?php echo $paging['realendofpage']?></li>
    </ul>
   	<div class="part"><?php echo $coreClass -> searchBoxType4_1($menukey, $mod, $scode, $search, $kwd, $cateList, $code1, $code2); ?></div>
</div>
	
<table class="board" summary="게시판 목록">
	<caption>게시판 목록</caption>
	<colgroup>
		<col style="width: 6%" />
		<col />
		<col style="width: 8%" />
		<col style="width: 6%" />
		<col style="width: 6%" />
		<col style="width: 10%" />
		<col style="width: 8%" />
		<col style="width: 12%" />
	</colgroup>

	<thead>
		<tr>
			<th><b>번호</b></th>
			<th><b>제목/게시판명</b></th>
			<th><b>작성자</b></th>
			<th><b>상태</b></th>
			<th><b>조회수</b></th>
			<th><b>파일</b></th>
			<th><b>등록일</b></th>
			<th class="last"><b>처리</b></th>
		</tr>
	</thead>
	<tbody>
			<?php if($paging_result < 1) { ?>
				<tr><td colspan="8">정보가 없습니다</td></tr>
			<?php
				} else {
					$no = $paging['total_record'] - ($paging['page']-1) * $paging['numofrecord'];
					while($row = $coreClass -> selectFetchArray($boardRs)) {
						include $dir2."lib.default.php";
						$listData .= '<tr><td>'.$no.'</td>';
						$listData .= '<td class="title">';
						require $dir2."list.subject.php";
						$listData .= '<br />'.$brdTitle['BOARD_NAME'];
						$listData .= '</td>';
						$listData .= '
			    				<td>'.$name.'</td>
								<td class="date">'.$deleted.'</td>
								<td class="date">'.$hit.'</td>
								<td>'.$updList.'</td>
								<td class="date">'.date("Y/m/d",strtotime($row['BRDATA_REGDATE'])).'</td>
								<td>'.$delBtn.'</td>
							</tr>';
						$no--;
					}
				}
				echo $listData;
			?>
	</tbody>
</table>

<?php
	if(!empty($search) && ($mod == "list" || empty($mod))) {
		$btnData .= '<a href="sub.php?menukey='.$menukey.'&amp;mod=list" class="btn_big"><span>전체목록</span></a>';
	}
	$pageData = $coreClass -> pagingUi(1, $paging, $menukey, $mod, $page, $search, $kwd, $cate, "", "", $scode, $codes);
?>
<div class="clearfix">
	<div style="float:left;"></div>
	<div class="board_btn_align">
		<?php echo $btnData ?>
	</div>
	<?php echo $pageData ?>
</div>