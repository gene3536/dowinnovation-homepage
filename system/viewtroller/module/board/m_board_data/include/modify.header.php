<?php
	if(empty($no)) $coreClass -> msg_back("선택한 게시글이 없습니다.");
	
	$toDay		= date("Y-m-d");
	$nextDay		= date("Y-m-d", strtotime($toDay."+14 day"));
	$SpamKey	= floor(rand(100000,999999));
	
	$d[0] = substr($SpamKey,0,1);
	$d[1] = substr($SpamKey,1,1);
	$d[2] = substr($SpamKey,2,1);
	$d[3] = substr($SpamKey,3,1);
	$d[4] = substr($SpamKey,4,1);
	$d[5] = substr($SpamKey,5,1);

	// 카테고리를 사용할 경우
	if($board_data['BOARD_CATEGORY'] == "Y"){
		if(!empty($cate)){
			$category = "";
		} else {
			$category = " AND brdata_category = '$cate' ";
		}
		
		$cWhere	= "WHERE BRDCAT_BID = '".$bid."'";
		$cOrder	= "ORDER BY BRDCAT_NO";
		$cateRs	= $coreClass -> selectQuery(tbl_board_category, $cWhere, $cOrder, "", "");

		$where_info	= "WHERE CMS_INFO_CODE = '".S_mb_scode."'";
		$row_ifno2	= $coreClass -> selectQueryArray(tbl_cms_info, $where_info, "", "", "");
		if($pageInfo['MENU_TITLE'] == "정보마당") {
			$cate = $row_ifno2['CMS_INFO_DATACATE'];
		} else if($pageInfo['MENU_TITLE'] == "주요행사") {
			$cate = $row_ifno2['CMS_INFO_SCHEDULECATE'];
		} else if($pageInfo['MENU_TITLE'] == "묻고답하기") {
			$cate = $row_ifno2['CMS_INFO_QNACATE'];
		}


	}

	// 검색을 위한 where 절
	switch($board_data['BOARD_TYPE']) {
		case "board" :
			$where = "WHERE brdata_bid ='".$bid."' AND brdata_no = '".$no."'";
			break;
		case "board_serv" :
			$where = "WHERE brdata_bid ='".$bid."' AND brdata_no = '".$no."'";
			break;
		case "board_minwon" :
			$where = "LEFT JOIN ".tbl_board_reply." ON brdrep_bid = brdata_bid AND brdrep_did = brdata_id WHERE brdata_bid = '".$bid."' AND brdata_no = '".$no."'";
			break;
		default :
			$where = "WHERE brdata_bid ='".$bid."' AND brdata_no = '".$no."'";
			break;	
	}
	$coreClass -> selectQueryCountChk(tbl_board_data, $where);
	$row = $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", "");


	//확장필드
	if($board_data['BOARD_EXTEND'] == "Y"){
		$Whereex = "where BRDATA_ID ='".$row['BRDATA_ID']."' and BRDATA_BID = '".$row['BRDATA_BID']."'";
		$rsex		= $coreClass -> selectQuery(tbl_board_data_extend, $Whereex, "", "", "");
		$rowext = $coreClass -> selectFetchArray($rsex);
	}



	// 접근 및 비밀번호 체크
	require_once $dir2.'lib.password.check.php';
	
	if(S_mb_level <= $board_data['BOARD_LV_NOTICE']) {
?>
	<script type="text/javascript">
	//<![CDATA[ 
	$.datepicker.setDefaults({
	    monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
	    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
	    showMonthAfterYear:true,
	    dateFormat: 'yy-mm-dd'
	});
	$(document).ready(function(){
	
	    $("#brdata_sdate").datepicker({
	        defaultDate: new Date(),
	        
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdata_edate").datepicker({
	        defaultDate: new Date(),
	        
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    }) 
	});
//]]>
	</script>
<?php } ?>


<?php if(S_mb_level <= $board_data['BOARD_LV_EXPOSURE']) { ?>
<script type="text/javascript">
//<![CDATA[ 
	$.datepicker.setDefaults({
	    monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
	    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
	    showMonthAfterYear:true,
	    dateFormat: 'yy-mm-dd',
	    buttonImageOnly: true,
	    buttonText: "달력",
	    buttonImage: "/base/imgs/btn/btn_calendar.gif"
	});
	$(document).ready(function(){
	
	    $("#brdata_sexposure").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdata_eexposure").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    }) 
	});
//]]>
</script>
<?php } ?>
