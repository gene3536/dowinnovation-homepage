<?
//$return_url = $_GET[return_url];
?>
<script type="text/javascript">

	// --------------------------------
    // 서비스 함수들
	// --------------------------------
	
	function GpinAuth() {

		//alert('<?=$return_url?>');
	    wWidth = 360;
	    wHight = 120;
	    
	    wX = (window.screen.width - wWidth) / 2;
	    wY = (window.screen.height - wHight) / 2;
	    
	    // Request Page Call
	    var w = window.open("/base/php/_realname/g-pin/AuthRequest.php?return_url=<?php echo $return_url?>", "gPinLoginWin", "directories=no,toolbar=no,left="+wX+",top="+wY+",width="+wWidth+",height="+wHight);
	}
	
	function testSiteUserConfirm() {
			wWidth = 350;
			wHight = 120;
			wX = (window.screen.width - wWidth) / 2;
			wY = (window.screen.height - wHight) / 2;
			
			attr = "GPIN_AQ_SERVICE_SITE_USER_CONFIRM";
	
			requrl = "Sample-SiteUserConfirmRequest.php?Attr="+attr+"&amp;vidn=" + vidn.value + "|" + siteuserid.value; // vidn 값에 vidn + siteuserid 값을 붙여 보낸다.
			
			var w = window.open(requrl, "_blank", "directories=no,toolbar=no,left="+wX+",top="+wY+",width="+wWidth+",height="+wHight);
	}
	
	function testUserSync() {
	    alert("이 테스트는 G-PIN센터에서 시작됩니다.");
	}
	
	function testUserDupValue() {
			wWidth = 850;
			wHight = 520;
			wX = (window.screen.width - wWidth) / 2;
			wY = (window.screen.height - wHight) / 2;
	
			requrl = "./Sample-UserDuplicationValue.php?regNo=" + regNo.value + "&amp;siteId=" + siteId.value;
	
			var w = window.open(requrl, "_blank", "directories=no,toolbar=no,left="+wX+",top="+wY+",width="+wWidth+",height="+wHight);
	}	
	

</script>