<?php
	require_once("../../../../system/config/config_lite.php");

	$tbl = "m_zipcode";
	$type			= $coreClass -> dataModel(2, "type", "");
	$search1		= $coreClass -> dataModel(2, "search1", "");
	$county1		= $coreClass -> dataModel(2, "county1", "");
	$town1_oldaddr	= $coreClass -> dataModel(2, "town1_oldaddr", "");
	$ri1_oldaddr	= $coreClass -> dataModel(2, "ri1_oldaddr", "");
	$san			= $coreClass -> dataModel(2, "san", "");
	$bun1			= $coreClass -> dataModel(2, "bun1", "");
	$bun2			= $coreClass -> dataModel(2, "bun2", "");
	$page			= $coreClass -> dataModel(2, "page", "1");

	if($san == "Y") $sanM = "1";
	else $sanM = "0";

	$city = $search1;

	if($search1) {
		$where = "WHERE zp_sido = '".$search1."'";
		$rs1 = $coreClass -> selectQueryDistinct($tbl, $where, "zp_sigungu");
	}

	if($county1) {
		$where = "WHERE zp_sido = '".$search1."' AND zp_sigungu = '".$county1."' AND zp_dong <> ''";
		$rs2 = $coreClass -> selectQueryDistinct($tbl, $where, "zp_dong");
	}

	if($town1_oldaddr) {
		$where = "WHERE zp_sido = '".$search1."' AND zp_sigungu = '".$county1."' AND zp_dong = '".$town1_oldaddr."' AND zp_li <> ''";
		$rs3 = $coreClass -> selectQueryDistinct($tbl, $where, "zp_li");
	}

	if($search == "1") {
		echo $rs = simplexml_load_file("http://www.juso.go.kr/link/search.do?extend=false&mode=jibun_search&searchType=location_jibun&topTab=1&engineCtpNm=".$search1."&engineSigNm=".$county1."&engineEmdNm=".$town1_oldaddr."&engineLiNm=".$ri1_oldaddr."&engineBdMaSn=".$bun1."&engineBdSbSn=".$bun2."&engineMtYn=".$sanM."&currentPage=".$page);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
	<title>::도로명주소검색::</title>
	<link type="text/css" href="/base/php/road/road.css" rel="stylesheet"></link>
	<script type="text/javascript" src="/base/js/jquery/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="/base/js/jquery/jquery-migrate-1.2.1.js"></script>
	<script type="text/javascript">
		function selectSearch(mode) {
			if(mode == "road") {
				document.location.href = "./road.php";
			} else if(mode =="jibun") {
				document.location.href = "./jibun.php"
			} else if(mode=="sangho") {
				document.location.href = "./sangho.php"
			}
		}

		function ok() { 
		  var f = document.road; 
			f.submit(); 
		}

		$(document).ready(function() {
			$("#search1").change( function () {
				document.location.replace = "/base/php/road/jibun.php?search1=" + encodeURI($("#search1").val());
			});
		});

		$(document).ready(function() {
			$("#county1").change( function () {
				document.location.replace = "/base/php/road/jibun.php?search1=" + encodeURI($("#search1").val()) + "&county1=" + encodeURI($("#county1").val());
			});
		});

		$(document).ready(function() {
			$("#town1_oldaddr").change( function () {
				document.location.replace = "/base/php/road/jibun.php?search1=" + encodeURI($("#search1").val()) + "&county1=" + encodeURI($("#county1").val()) + "&town1_oldaddr=" + encodeURI($("#town1_oldaddr").val());
			});
		});

		function addressTrans(zip1, zip2, addr1, addr2) {
			opener.apply.eduapply_company_zipcode1.value = zip1;
			opener.apply.eduapply_company_zipcode2.value = zip2;
			opener.apply.eduapply_company_addr1.value = addr1;
			opener.apply.eduapply_company_addr2.value = addr2;
			window.close();
		}
	</script>
</head>

<body>
	<div id="wrapper">
		<div id="header">
			<h1><img src="/base/php/road/imgs/h1.jpg" alt="도로명주소찾기(우편번호)" /></h1>
		</div>
		<div id="container">
			<div id="content">
				<ul class="tab">
					<li><a href="#n" onclick="selectSearch('road');return false;"><img src="/base/php/road/imgs/tab1_off.gif" alt="도로명주소"/></a></li>
					<li><a href="#n" onclick="selectSearch('jibun');return false;"><img src="/base/php/road/imgs/tab2.gif" alt="지번"/></a></li>
				</ul>

				<form name="check" method="post" action="/base/php/road/jibun.php">
					<input type="hidden" name="search" id="search" value ="1" />

					<div class="form" id="formbox">
					<fieldset>
						<legend>정보 입력</legend>
						<div class="group">
							<table class="SearchTable">
								<tr>
									<td class="SearchTd1"><label for="siCode"><strong>시&nbsp;&nbsp;&nbsp;&nbsp;도</strong></label></td>
									<td class="SearchTd2">
										<select class="SearchSelectbox" title="시/도 선택"  name="search1" id="search1">
											<option value="">::선택::</option>
												<option value="서울특별시" title="서울특별시"<?php if($city == "서울특별시") echo " selected=\"selected\"";?>>서울특별시</option>
												<option value="강원도" title="강원도"<?php if($city == "강원도") echo " selected=\"selected\"";?>>강원도</option>
												<option value="경기도" title="경기도"<?php if($city == "경기도") echo " selected=\"selected\"";?>>경기도</option>
												<option value="경상남도" title="경상남도"<?php if($city == "경상남도") echo " selected=\"selected\"";?>>경상남도</option>
												<option value="경상북도" title="경상북도"<?php if($city == "경상북도") echo " selected=\"selected\"";?>>경상북도</option>
												<option value="전라남도" title="전라남도"<?php if($city == "전라남도") echo " selected=\"selected\"";?>>전라남도</option>
												<option value="전라북도" title="전라북도"<?php if($city == "전라북도") echo " selected=\"selected\"";?>>전라북도</option>
												<option value="충청남도" title="충청남도"<?php if($city == "충청남도") echo " selected=\"selected\"";?>>충청남도</option>
												<option value="충청북도" title="충청북도"<?php if($city == "충청북도") echo " selected=\"selected\"";?>>충청북도</option>
												<option value="광주광역시" title="광주광역시"<?php if($city == "광주광역시") echo " selected=\"selected\"";?>>광주광역시</option>
												<option value="대구광역시" title="대구광역시"<?php if($city == "대구광역시") echo " selected=\"selected\"";?>>대구광역시</option>
												<option value="대전광역시" title="대전광역시"<?php if($city == "대전광역시") echo " selected=\"selected\"";?>>대전광역시</option>
												<option value="부산광역시" title="부산광역시"<?php if($city == "부산광역시") echo " selected=\"selected\"";?>>부산광역시</option>
												<option value="울산광역시" title="울산광역시"<?php if($city == "울산광역시") echo " selected=\"selected\"";?>>울산광역시</option>
												<option value="인천광역시" title="인천광역시"<?php if($city == "인천광역시") echo " selected=\"selected\"";?>>인천광역시</option>
												<option value="세종특별자치시" title="세종특별자치시"<?php if($city == "세종특별자치시") echo " selected=\"selected\"";?>>세종특별자치시</option>
												<option value="제주특별자치도" title="제주특별자치도"<?php if($city == "제주특별자치도") echo " selected=\"selected\"";?>>제주특별자치도</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="SearchTd1"><label for="siCode2"><strong>시&nbsp;군&nbsp;구</strong></label></td>
									<td class="SearchTd2">
										<select class="SearchSelectbox" title="시/군/구 선택"  name="county1" id="county1">
											<option value="">::선택::</option>
										<?php
											if($search1) {
												while($row1 = $coreClass -> selectFetchArray($rs1)) {
										?>
											<option value="<?php echo $row1[0]?>"<?php if($row1[0] == $county1) echo " selected=\"selected\"";?>><?php echo $row1[0]?></option>
										<?php
												}
											}
										?>
										</select>
									</td>
								</tr>
								<tr>
									<td class="SearchTd1"><label for="siCode3"><strong>읍&nbsp;면&nbsp;동</strong></label></td>
									<td class="SearchTd2">
										<select class="SearchSelectbox" id="town1_oldaddr" name="town1_oldaddr" title="지번주소">
											<option value="">::선택::</option>
										<?php
											if($county1) {
												while($row2 = $coreClass -> selectFetchArray($rs2)) {
										?>
											<option value="<?php echo $row2[0]?>"<?php if($row2[0] == $town1_oldaddr) echo " selected=\"selected\"";?>><?php echo $row2[0]?></option>
										<?php
												}
											}
										?>
										</select>
									</td>
								</tr>
								<tr>
									<td class="SearchTd1"><label for="siCode4"><strong>리</strong></label></td>
									<td class="SearchTd2">
										<select id="ri1_oldaddr" name="ri1_oldaddr" title="지번주소"  class="small" style="width:153px">
											<option value="">::선택::</option>
										<?php
											if($town1_oldaddr) {
												echo mysql_num_rows($rs3);
												while($row3 = $coreClass -> selectFetchArray($rs3)) {
										?>
											<option value="<?php echo $row3[0]?>"<?php if($row3[0] == $ri1_oldaddr) echo " selected=\"selected\"";?>><?php echo $row3[0]?></option>
										<?php
												}
											}
										?>
										</select>
										<input type="checkbox"value="Y" id="san" name="san"<?php if($san == "Y") echo " checked=\"checked\"";?> /><label for="san">산</label>
									</td>
								</tr>
								<tr>
									<td class="SearchTd1"><label for="st_name"><strong>번&nbsp;&nbsp;지</strong></label></td>
									<td class="SearchTd2">
										<input type="text" name="bun1" value="" id="bun1" class="text" style="width:85px" onfocus= "javascript:focusItem(this);" onkeydown="checkKeyASearch();"/> -
										<input type="text" name="bun2" value="" id="bun2" class="text" style="width:85px" onfocus= "javascript:focusItem(this);" onkeydown="checkKeyASearch();"/>
									</td>
								</tr>
							</table>
						</div>
						<div class="btn">
							<input type="image" src="/base/php/road/imgs/btn_search.gif" alt="검색" />
						</div>
						<table style="width:100%">
						<?php
							if($rs) {
								for($i = 0; $i < count($rs -> siNm); $i++) {
									$siNm = $rs -> siNm[$i]; 
									$sggNm =  $rs -> sggNm[$i];  
									$emdNm = $rs -> emdNm[$i];
									$liNm = $rs -> liNm[$i];
									$rn = $rs -> rn[$i];
									$buldMnnm = $rs -> buldMnnm[$i];
									$buldSlno = $rs -> buldSlno[$i];
									$zipCl = $rs -> zipCl[$i];

									$zipcode = explode("-",$zipCl);
									$zipcode1 = $zipcode[0];
									$zipcode2 = $zipcode[1];

									$addr1   = $siNm." ".$sggNm;
									$addr2   = $rn." ".$buldMnnm."-".$buldSlno;

									$totalCount = $rs -> totalCount[$i];
						?>
						<tr>
							<td style="text-align:left">
								<a href="#" onclick="javascript:addressTrans('<?php echo $zipcode1?>', '<?php echo $zipcode2?>', '<?php echo $addr1?>', '<?php echo $addr2?>');">
									우편번호: <?php echo $zipCl;?>&nbsp;&nbsp;<?php echo $siNm." ".$sggNm." ".$liNm." ".$rn." ".$buldMnnm."-".$buldSlno."";?>
								</a>
							</td>
						</tr>
						<?php
								}
							}
						?>
						</table>

						<table style="width:100%">
						<tr>
							<td style="text-align:center;">
							<div class="paginate">
							<?php
								if($totalCount > 0) {
									$numofrecord	= 10;
									$paging_result	= $totalCount;

									$paging[] = array();
									$paging['page']				= $page;
									$paging['total_record']		= $paging_result;						// 총레코드수
									$paging['numofrecord']		= $numofrecord ? $numofrecord : 10;		// 한페이지에 표시될 게시물 수
									$paging['numofpage']		= 10;									// 페이지번호가 표시될 페이지 수
									$paging['startofrecord']	= $numofrecord * ($paging['page'] - 1);	// 첫번째레코드 포인터
									
									if(($page % $paging['numofpage']) == 0) {
										$startofpage = $paging['page'] - 1;
										$startofpage = floor($startofpage/$paging['numofpage']) * $paging['numofpage'] + 1;
									} else {				
										$startofpage = floor($paging['page'] / $paging['numofpage']) * $paging['numofpage'] + 1;	
									}
									
									$paging['startofpage']		= $startofpage;												// 페이지시작번호
									$paging['endofpage']		= $startofpage + $paging['numofpage'];				// 페이지끝번호
									$paging['realendofpage']	= ceil($paging['total_record'] / $paging['numofrecord']);	// 총레코드수에 의한 실제페이지끝번호

									$rtn	= "";
									$id		= "";
									
									if($paging['startofpage'] > $paging['numofpage']) {
										$var = "&page=1&search=1&search1=".urlencode($search1)."&county1=".urlencode($county1)."&town1_oldaddr=".urlencode($town1_oldaddr)."&ri1_oldaddr=".urlencode($ri1_oldaddr)."&san=".$san."&bun1=".$bun1."&bun2=".$bun2."";
										$rtn .= '<a href="?type='.$type.$var.'" class="bt_start"><img alt="처음페이지" src="/base/imgs/board/page_first.gif" /></a>&nbsp;';
									} else {
										$rtn .= '<img alt="처음페이지" src="/base/imgs/board/page_first.gif" />&nbsp;';
									}
								
									if($paging['startofpage'] > 1) {
										$var = "&page=".($paging['startofpage']-10)."&search=1&search1=".urlencode($search1)."&county1=".urlencode($county1)."&town1_oldaddr=".urlencode($town1_oldaddr)."&ri1_oldaddr=".urlencode($ri1_oldaddr)."&san=".$san."&bun1=".$bun1."&bun2=".$bun2."";
										$rtn .= '<a href="?type='.$type.$var.'" class="bt_prev"><img alt="이전페이지" src="/base/imgs/board/page_prev.gif" /></a>&nbsp;';
									} else {
										$rtn .= '<img alt="이전페이지" src="/base/imgs/board/page_prev.gif" />&nbsp;';
									}
								
									for($i = $paging['startofpage'] ; $i < $paging['endofpage'] ; $i++) {
										$var = "&page=".$i."&search=1&search1=".urlencode($search1)."&county1=".urlencode($county1)."&town1_oldaddr=".urlencode($town1_oldaddr)."&ri1_oldaddr=".urlencode($ri1_oldaddr)."&san=".$san."&bun1=".$bun1."&bun2=".$bun2."";
										if($i == $paging['page']) {
											$rtn .= '<a href="?type='.$type.$var.'" class="page_a"><strong>'.$i.'</strong></a>';
										} else {					
											$rtn .= '<a href="?type='.$type.$var.'" class="page_a">'.$i.'</a>';
										}
										if($i >= $paging['realendofpage']) break;
									}
								
									if($paging['endofpage'] <= $paging['realendofpage']) {
										$var = "&page=".$paging['endofpage']."&search=1&search1=".urlencode($search1)."&county1=".urlencode($county1)."&town1_oldaddr=".urlencode($town1_oldaddr)."&ri1_oldaddr=".urlencode($ri1_oldaddr)."&san=".$san."&bun1=".$bun1."&bun2=".$bun2."";
										$rtn .= '&nbsp;<a href="?type='.$type.$var.'"><img alt="다음페이지" src="/base/imgs/board/page_next.gif" /></a>';
									} else {
										$rtn .= '&nbsp;<img alt="다음페이지" src="/base/imgs/board/page_next.gif" />';
									}
								
									if($paging['endofpage'] <= $paging['realendofpage']) {
										$var = "&page=".$paging['realendofpage']."&search=1&search1=".urlencode($search1)."&county1=".urlencode($county1)."&town1_oldaddr=".urlencode($town1_oldaddr)."&ri1_oldaddr=".urlencode($ri1_oldaddr)."&san=".$san."&bun1=".$bun1."&bun2=".$bun2."";
										$rtn .= '&nbsp;<a href="?type='.$type.$var.'"><img alt="마지막페이지" src="/base/imgs/board/page_last.gif" /></a>';
									} else {
										$rtn .= '&nbsp;<img alt="마지막페이지" src="/base/imgs/board/page_last.gif" />';
									}

									echo $rtn;
								}
							?>
							</div>
							</td>
						</tr>
						</table>
						<div >
							<img src="/base/php/road/imgs/test.gif" alt="" width="380px" />
							자세한 표기법은   <a href="http://www.juso.go.kr" style="font-size: 10px" target="_blank">도로명주소안내홈페이지</a> 를 참조하세요
						</div>
					</fieldset>
					</div>
				</form>

			</div>
		</div>
	</div>
</body>
</html>
