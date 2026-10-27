<script type="text/javascript">
//<![CDATA[
	$(document).ready(function(){
		$('.banner_zone').motionj_rolling_vertical({
			width : 830,
			height : 45,
			max_view : 1,
			speed : 3000,
			direction : "down"
		});
	});
//]]>
</script>
<div id="line">
<div class="banner">
	<h2><img src="imgs/main/banner_h2.gif" alt="배너모음" /></h2>

    <div class="control">
		<ul class="ba_con clearfix">
			<li><a href="#" onclick="return false;" class="bnr_up"><img src="imgs/main/ba_back.gif" alt="이전배너" /></a></li>
			<li><a href="#" onclick="return false;" class="bnr_down"><img src="imgs/main/ba_next.gif" alt="다음배너" /></a></li>
			<li><a href="#" onclick="return false;" class="bnr_pause"><img src="imgs/main/ba_stop.gif" alt="배너멈춤" /></a></li>
			<li><a href="#" onclick="return false;" class="bnr_play"><img src="imgs/main/ba_play.gif" alt="배너 시작" /></a></li>
		</ul>
    </div>

    <div class="banner_zone">
		<ul style="padding-left: 30px">
			<?php echo $cmsClass -> getBnrList("00000002")?>
        </ul>
    </div>

</div>
</div>