<?php
	$toDay		= date("Y-m-d");
	$nextDay		= date("Y-m-d", strtotime($toDay."+14 day"));
	$SpamKey	= floor(rand(100000,999999));
	
	$d[0] = substr($SpamKey,0,1);
	$d[1] = substr($SpamKey,1,1);
	$d[2] = substr($SpamKey,2,1);
	$d[3] = substr($SpamKey,3,1);
	$d[4] = substr($SpamKey,4,1);
	$d[5] = substr($SpamKey,5,1);
	
	// 카테고리 옵션
	if($board_data['BOARD_CATEGORY'] == "Y"){
		$cWhere	= "WHERE brdcat_bid = '".$bid."'";
		$cOrder	= "ORDER BY brdcat_seq asc, brdcat_no ASC";
		$cateRs	= $coreClass -> selectQuery(tbl_board_category, $cWhere, $cOrder, "", "");
		
		$cateList .= '<select name="brdata_category" class="selline" title="카테고리선택" style="width:120px">';
		$cateList .= '<option value="">일반</option>';
		while($row_c = $coreClass -> selectFetchArray($cateRs)) {
			if($cate == $row_c['BRDCAT_ID']) {
				$sel = ' selected="selected"';
			} else {
				$sel = '';
			}
			$cateList .= '<option value="'.$row_c['BRDCAT_ID'].'"'.$sel.'>'.$row_c['BRDCAT_NAME'].'</option>';
		}
		$cateList .= '</select>';
	}
?>

<?php if(S_mb_level <= $board_data['BOARD_LV_NOTICE']) { ?>
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