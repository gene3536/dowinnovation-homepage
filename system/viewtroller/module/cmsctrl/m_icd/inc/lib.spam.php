<?php 

	$toDay		= date("Y-m-d");
	$nextDay	= date("Y-m-d", strtotime($toDay."+14 day"));
	$SpamKey	= floor(rand(100000,999999));
	
	$d[0] = substr($SpamKey,0,1);
	$d[1] = substr($SpamKey,1,1);
	$d[2] = substr($SpamKey,2,1);
	$d[3] = substr($SpamKey,3,1);
	$d[4] = substr($SpamKey,4,1);
	$d[5] = substr($SpamKey,5,1);

?>