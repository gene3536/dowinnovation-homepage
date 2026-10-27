<?php
	if(empty($no)) $coreClass -> msg_back("선택한 게시글이 없습니다.");
	
	// 카테고리를 사용할 경우
	if($board_data['BOARD_CATEGORY'] == "Y"){
		$cWhere	= "WHERE BRDCAT_BID = '".$bid."'";
		$cOrder	= "ORDER BY BRDCAT_NO";
		$cateRs	= $coreClass -> selectQuery(tbl_board_category, $cWhere, $cOrder, "", "");
	}	

	// 게시판 쿼리
	$bWhere		= "WHERE brdata_bid ='".$bid."' AND brdata_no = '".$no."'";
	$coreClass -> selectQueryCountChk(tbl_board_data, $bWhere);
	$row			= $coreClass -> selectQueryArray(tbl_board_data, $bWhere, "", "", "");	
?>

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