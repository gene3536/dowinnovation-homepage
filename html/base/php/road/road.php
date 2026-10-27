<?php
	require_once("../../../../system/config/config_lite.php");
	$search1 = $coreClass -> dataModel(2, "search1", "");
	$roadNm = $coreClass -> dataModel(2, "roadNm", "");
	$code1 = $coreClass -> dataModel(2, "code1", "");
	$code2 = $coreClass -> dataModel(2, "code2", "");
	$chk = $coreClass -> dataModel(2, "chk", "");
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
				document.location.href = "./road.php?type=<?php echo $type?>";
			} else if(mode =="jibun") {
				document.location.href = "./jibun.php?type=<?php echo $type?>"
			} else if(mode=="sangho") {
				document.location.href = "./sangho.php?type=<?php echo $type?>"
			}
		}

		function ok() { 
			var f = document.road; 
			f.submit(); 
		}

		function addressTrans(zip1, zip2, addr1, addr2) {
			opener.apply.eduapply_company_zipcode1.value = zip1;
			opener.apply.eduapply_company_zipcode2.value = zip2;
			opener.apply.eduapply_company_addr1.value = addr1;
			opener.apply.eduapply_company_addr2.value = addr2;
			window.close();
		}
	</script>
</head>

<?php
	$city = $search1;

	if($roadNm) {
		$rs2 = simplexml_load_file("http://www.juso.go.kr/link/search.do?extend=false&mode=road_search&searchType=location_newaddr&topTab=1&engineCtpNm=".$city."&engineSigNm=".$county_text."&engineRdNm=".$roadNm."&engineBdMaSn=".$code1."&engineBdSbSn=".$code2."&currentPage=");
	}
?>

<body>
	<div id="wrapper">
		<div id="header">
			<h1>
				<img src="/base/php/road/imgs/h1.jpg" alt="도로명주소찾기(우편번호)" />
			</h1>
		</div>
		<div id="container">
			<div id="content">
				<ul class="tab">
					<li><a href="#n" onclick="selectSearch('road');return false;"><img src="/base/php/road/imgs/tab1.gif" alt="도로명주소"/></a></li>
					<li><a href="#n" onclick="selectSearch('jibun');return false;"><img src="/base/php/road/imgs/tab2_off.gif" alt="지번"/></a></li>
				</ul>
				<form id="road" name="road" method="post" action="/base/php/road/road.php?type=<?php echo $type?>">
					<input type="hidden" id="city_text" name="city_text" value="" />
					<input type="hidden" id="county_text" name="county_text" value="" />
					<input type="hidden" id="chk" name="chk" value="1" />
					<div class="form" id="formbox">
						<fieldset>
							<legend>정보 입력</legend>
							<div class="group">
								<table>
									<tr>
										<td class="SearchTd1"><label for="search1"><strong>시&nbsp;&nbsp;&nbsp;&nbsp;도</strong></label></td>
										<td class="SearchTd2">
											<select id="search1" name="search1" title="검색조건" class="selline" style="width:120px;">
												<option value="">전체</option>
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
										<td class="SearchTd1">
											<label for="st_name"><strong>도&nbsp;로&nbsp;명</strong></label>
										</td>
										<td class="SearchTd2">
											<input type="text" name="roadNm" title="도로명 입력" class="inpline" style="width:120px;" maxlength="20"  value="<?echo $roadNm?>"/>
										</td>
									</tr>
									<tr>
										<td class="SearchTd1">
											<label for="bd_number1"><strong>건물번호</strong></label>
										</td>
										<td>
											<input type="text" name="code1" title="건물번호1 입력" class="inpline" style="width:70px;" maxlength="20" value="<?echo $code1?>" /> - 
											<input type="text" name="code2" title="건물번호2 입력" class="inpline" style="width:70px;" maxlength="20" value="<?echo $code2?>" />
										</td>
									</tr>
								</table>
							</div>

							<div class="btn">
								<a href="javascript:ok();"><img src="/base/php/road/imgs/btn_search.gif" alt="검색" /></a>
							</div>

							<?php if($chk == 1) { ?>
							<br /><br />
							<?php
								if($rs2) {
									for($i = 0; $i < count($rs2 -> siNm); $i++) {
										$siNm = $rs2 -> siNm[$i]; 
										$sggNm =  $rs2 -> sggNm[$i];  
										$emdNm = $rs2 -> emdNm[$i];
										$liNm = $rs2 -> liNm[$i];
										$rn = $rs2 -> rn[$i];
										$buldMnnm = $rs2 -> buldMnnm[$i];
										$buldSlno = $rs2 -> buldSlno[$i];
										$zipCl = $rs2 -> zipCl[$i];

										$zipcode = explode("-",$zipCl);
										$zipcode1 = $zipcode[0];
										$zipcode2 = $zipcode[1];

										$addr1   = $siNm." ".$sggNm;
										$addr2   = $rn." ".$buldMnnm."-".$buldSlno;
								?>
								<table>
									<tr>
										<td>
											<a href="#" onclick="javascript:addressTrans('<?php echo $zipcode1?>', '<?php echo $zipcode2?>', '<?php echo $addr1?>', '<?php echo $addr2?>');">
												우편번호: <?php echo $zipCl;?>&nbsp;&nbsp;<?php echo $siNm." ".$sggNm." ".$liNm." ".$rn." ".$buldMnnm."-".$buldSlno."";?>
											</a><br />
										</td>
									</tr>
								</table>
								<?php
									}
								} else {
									echo ("검색된 내용이 없습니다.");
								}
								?>
								<br /><br />
							<?php } ?>

							<div>
								<input type="image" src="/base/php/road/imgs/test.gif" alt="" width="380px" />
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
