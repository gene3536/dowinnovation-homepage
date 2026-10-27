<?php

	$where	= "WHERE icd_no = '".$no."' AND icd_pid = '".$pid."'";
	$coreClass -> selectQueryCountChk($tbl1, $where);
	$row		= $coreClass -> selectQueryArray($tbl1, $where, "", "", "");
?>