<?php
	// 게시판 쿼리
	$bWhere		= "WHERE brdata_no = '".$no."'";
	$coreClass -> selectQueryCountChk(tbl_board_data, $bWhere);
	$row			= $coreClass -> selectQueryArray(tbl_board_data, $bWhere, "", "", "");
	$bid			= $row['BRDATA_BID'];
	
	$bwhere		= "WHERE board_id = '".$bid."'";
	$coreClass -> selectQueryCountChk(tbl_board, $bwhere);
	$brow			= $coreClass -> selectQueryArray(tbl_board, $bwhere, "", "", "");	

	// 게시판 관리자 체크
	if(S_mb_level > site_config_level && S_mb_level > $brow['BOARD_LV_MANAGE']) {
		$where		= "WHERE brdmng_bid = '".$bid."' AND brdmng_uid = '".S_mb_id."'";
		$brdmngCnt	= $coreClass -> selectQueryCount(tbl_board_manage, $where);
		
		if($brdmngCnt < 1) $coreClass -> msg_back("보기 권한이 없습니다.");
	}

	// 카테고리를 사용할 경우
	if($brow['BOARD_CATEGORY'] == "Y"){
		$cWhere	= "WHERE brdcat_bid = '".$bid."'";
		$cOrder	= "ORDER BY brdcat_no";
		$cateRs	= $coreClass -> selectQuery(tbl_board_category, $cWhere, $cOrder, "", "");
	}
?>

<script type="text/javascript">
	//<![CDATA[ 
	(function($){
		$.frmValidation = function() {
			<?php if(site_config_editor == 1) { ?>
				oEditors.getById["brdata_content"].exec("UPDATE_CONTENTS_FIELD", []);
			<?php } ?>
			if($.trim($('#brdata_subject').val()) == ''){
				alert("제목을 입력하세요.");
				$('#brdata_subject').focus();
				return false;
			}
		}
	})(jQuery);
	//-->
</script>

<?php if(S_mb_level <= $brow['BOARD_LV_EXPOSURE']) { ?>
<script type="text/javascript">
//<![CDATA[ 
	$.datepicker.setDefaults({
	    monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
	    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
	    showMonthAfterYear:true,
	    dateFormat: 'yy-mm-dd',
	    buttonImageOnly: true,
	    buttonText: "달력",
	    buttonImage: "/bbs/img/btn/btn_calendar.gif"
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