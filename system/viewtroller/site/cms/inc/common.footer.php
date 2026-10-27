<?php
	echo site_config_copyright;
	$timeChk	= explode(" ", microtime());
	$endTime	= $timeChk[1].substr($timeChk[0], 1);
	$timePhp	= round(($endTime - $startTime), 4);
	echo " (".$timePhp.")";
?>