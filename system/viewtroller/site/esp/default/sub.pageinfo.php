<?php if($depuser) { ?>
<div class="foot_tel clearfix" style="margin-bottom: 40px;">
    <h4><img src="imgs/template/foot_tel_title.gif" alt="정보 담당자" /></h4>
	<dl class="title_1 clearfix">
	    <dt><?php echo $dep ?></dt>	    
	    <dd>
	    	<?php if($depsub) { ?><span> > </span><?php echo $depsub ?><?php } ?>
	    	<?php if($depuser) { ?><span> > </span><?php echo $depuser ?><?php } ?>
	    </dd>
    </dl>
	<dl class="title_2 clearfix">
	    <dt><img src="imgs/template/foot_tel_img.gif" alt="전화번호" /></dt>
	    <dd><?php if($deptel) { ?><?php echo $deptel ?><?php } ?></dd>
		<dt><img src="imgs/template/foot_email_img.gif" alt="이메일" /></dt>
		<dd><?php if($depemail) { ?> <?php echo $depemail ?><?php } ?></dd>
    </dl>
</div>
<?php } ?>