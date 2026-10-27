<?php
	require_once("../../../system/config/config_lite.php");

	$no		= $coreClass -> dataModel(2, "no", null);
	$where	= "WHERE icd_no = '".$no."' AND icd_pid = '00000004' AND icd_sdate <= '".site_regdate."' AND icd_edate >= '".site_regdate."' AND icd_visible = 'Y'";
	$pop		= $coreClass -> selectQueryArray(tbl_cms_icd, $where, "", "", "");
?>

	<div style="width:<?php echo $pop['ICD_WIDTH']?>px; height:<?php echo $pop['ICD_HEIGHT']?>px;"><?php echo $pop['ICD_CONTENT']?></div>
	<div style="padding:5px; background:#ededeb; text-align:center">
      	<a href="javascript:notice_closeWin();">1일간 팝업창 닫기 </a> |
		<a href="javascript:self.close();"> 팝업창 닫기</a>
	</div>