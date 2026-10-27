<?php if($contMAP['USE'] == true && site_map_key != null){ ?> 
<script type="text/javascript">
var _mapUSE = "<?=$contMAP['USE']?>";
var _mapX   = "<?=$contMAP['X']?>";
var _mapY   = "<?=$contMAP['Y']?>";
var _mapTT  = "<?=$contMAP['TT']?>";
var _mapADDR  = "<?=$contMAP['ADDR']?>";
var _mapCONT  = "<?=$contMAP['CONT']?>";
</script>

	<?php if(site_map_type == "daum"){ ?> 
		<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=<?php echo site_map_key?>"></script>
	<?php }else if(site_map_type == "google"){ ?>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=<?php echo site_map_key?>&language=<?php echo $contMAP['LG']?>"></script>
		<style type="text/css">
			#windowContent { width: 280px; height:auto; }
			#firstHeading { font-size:14px; } 
			#bodyContent{ font-size:12px; } 
		</style>
	<?php }else if(site_map_type == "naver"){ ?>
		<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=<?php echo site_map_key?>&submodules=geocoder&callback=initMap"></script>
	<?php } ?>
	<script type="text/javascript" src="/base/js/api/map.<?php echo site_map_type?>.js"></script>

<?php } ?>

<script type="text/javascript" src="/base/js/default/content.js"></script>

<?php
	/** 콘텐츠 출력 */	
	$tbl1			= tbl_cms_icd;
	$tbl2			= tbl_cms_icd_log;
	$icd_content	= $coreClass -> dataModelNoXss(1, "icd_content", NULL);
	
	switch ($mod) {
		case "modify"	:
			if(S_mb_level <= site_config_slevel) {
				require_once 'modify.php';
			} else {
				require_once 'view.php';
			}
			break;
		case "process" :
			if(S_mb_level <= site_config_slevel) {
				require_once 'process.php';
			} else {
				require_once 'view.php';
			}
			break;
		case "view" : require_once 'view.php';break;		
		default : require_once 'view.php';break;
	}
?>