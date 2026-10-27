<?php
	// 게시글 쿼리
	if($btype == "board") {
		$where	= "WHERE brdata_no = '".$no."'";
	} else if($btype == "board_serv") {
		$where	= "WHERE brdata_no = '".$no."'";
	} else if($btype == "board_minwon") {
		$where	= "WHERE brdata_no = '".$no."'";
	} else if($btype == "board_gallery") {
		$where	= "WHERE brdata_no = '".$no."'";
	}

	$coreClass -> selectQueryCountChk(tbl_board_data, $where);
	$row			= $coreClass -> selectQueryArray(tbl_board_data, $where, "", "", "");
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
	if($brow['board_category'] == "Y"){
		if(!empty($cate)) {
			$category = "";
		} else {
			$category = " AND brdata_category = '".$cate."' ";
		}
		
		$cwhere	= "WHERE category_bid = '".$bid."'";
		$corder	= "ORDER BY category_no";
		$cateRs	= $coreClass -> selectQuery(tbl_board_category, $cwhere, $corder, "", "");
	}
	
	//확장필드
	if($brow['BOARD_EXTEND'] == "Y"){
		$Whereex = "where BRDATA_ID ='".$row['BRDATA_ID']."' and BRDATA_BID = '".$row['BRDATA_BID']."'";
		$rsex		= $coreClass -> selectQuery(tbl_board_data_extend, $Whereex, "", "", "");
		$rowext = $coreClass -> selectFetchArray($rsex);
	}


	require_once "board.default.php";
?>

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
	
	    $("#brdata_sdate").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdata_edate").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdcnt_date").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
	    $("#brdcnt_sdate").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdcnt_edate").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdtnd_notify").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdtnd_exdt").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdtnd_redt1").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdtnd_redt2").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
		$("#brdtnd_dt").datepicker({
	        defaultDate: new Date(),
	        showOn: "both", // focus, button, both
	        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
	        showOptions: {direction: 'horizontal'},
	        duration: 200
	    })
	});
	$(document).ready(function() {
		$.getXmlData("#menu1", "", 1);     
		$("#menu1").click( function () {
			$("#menu2 option").remove();
			$.getXmlData("#menu2", $("#menu1 option:selected").val(), 2);
			$("#brdata_dep").val($("#menu1 option:selected").text());
			$("#brdata_depsub").val("");
			$("#brdata_depuser").val("");
		});		
		$("#menu2").click( function () {
			$("#menu3 option").remove();
			$.getXmlData("#menu3", $("#menu2 option:selected").val(), 3);
			$("#brdata_depsub").val($("#menu2 option:selected").text());
			$("#brdata_depuser").val("");
		});
		$("#menu3").click( function () {
			$("#brdata_depuser").val($("#menu3 option:selected").text());
		});

	});
	
	(function($){
		$.getXmlData = function(target, code, type) {
		   $.ajax({   
		       type: "get",   
		       dataType: "xml",
		       url: "/base/xml/siteOrganization.php?code=" + code + "&type=" + type,
		       success: function(xml) {
		    	   if($(xml).find("models").find("model").length > 0) { 
		               $(xml).find("models").find("model").each(function() {   
		                   var organ_id = $(this).find("organ_id").text();   
		                   var organ_name = $(this).find("organ_name").text();   
		                   $(target).append("<option value='"+organ_id+"'>"+organ_name+"</option>");   
		               });   
		           }              
		       },    
		       error: function(xhr, status, error) {   
		           alert(status);   
		           alert(error);    
		       }   
		   });   
		}
		
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