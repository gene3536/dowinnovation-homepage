<?php 
	require_once("../../../system/config/config_lite.php");
	if(!empty($_REQUEST['thisID'])){
		$coreClass->msg($msg);
		echo "<script>self.close();</script>";
		exit;
	}
?>
<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $_REQUEST['thisID']?>" frameborder="0" allowfullscreen></iframe>