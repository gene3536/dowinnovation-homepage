<?php
	// 댓글 페이징 처리
	$whereC			= "WHERE BRDCMNT_bid = '".$bid."' AND BRDCMNT_bno = '".$row['BRDATA_NO']."'";
	// 페이징
	$pageC				= $pageC ? $pageC : 1;
	$numofrecord	= 20;
	$paging_resultc	= $coreClass -> selectQueryCount(tbl_board_comment, $whereC);
	$pagingc			= $coreClass -> pagingCore($paging_resultc, $numofrecord, $pageC);


	$where	= "WHERE BRDCMNT_bid='$bid' AND (BRDCMNT_BNO = '".$row['BRDATA_NO']."' or BRDCMNT_DID ='".$row['BRDATA_ID']."')";
	$order	= "ORDER BY BRDCMNT_no DESC";
	$rs_cnt	= $coreClass -> selectQueryCount(tbl_board_comment, $where);
	$rs_c	= $coreClass -> selectQuery(tbl_board_comment, $where, $order, $pagingc["startofrecord"], $pagingc["numofrecord"]);

	$where2 = "WHERE brdcmnt_no = '".$cno."'"; 
	$dataRow = $coreClass->selectQueryArray(tbl_board_comment,$where2,"","",""); 

	
	$SpamKey = floor(rand(100000,999999));
	
	$d[0] = substr($SpamKey,0,1);
	$d[1] = substr($SpamKey,1,1);
	$d[2] = substr($SpamKey,2,1);
	$d[3] = substr($SpamKey,3,1);
	$d[4] = substr($SpamKey,4,1);
	$d[5] = substr($SpamKey,5,1);


?>



<script type="text/javascript">
function submitCmt()
{
	var frm = document.getElementById('commentForm');
	if(frm.commentcontents.value == ""){
		alert('내용을 입력해주세요.');
		frm.commentusrwd.focus();
		return false;
	<?php if(S_mb_level == site_config_glevel && $board_data['BOARD_LV_COMMENT'] == site_config_glevel) { ?>
	}else if(frm.commentusr.value == ""){
		alert('이름을 입력해주세요.');
		frm.commentusrwd.focus();
		return false;
	}else if(frm.spamKey.value == ""){
		alert('인증번호를 입력해주세요.');
		frm.spamKey.focus();
		return false;	
	}else if(frm.commentusrwd.value == ""){
		alert('비밀번호를 입력해주세요.');
		frm.commentusrwd.focus();
		return false;	
	<?php } ?> 
	}else {
		frm.submit();
	}
}

</script>


<?php if(S_mb_level <= $board_data['BOARD_LV_COMMENT']) { ?>
<form name="commentForm" id="commentForm" method="post" action="<?php echo site_ssl_https?>/sub.php?menukey=<?php echo $menukey?>" onsubmit="">
	<input type="hidden" name="mod" value="process" />
	<?php if(!empty($cno) && !empty($mod2)){ ?>
	<input type="hidden" name="cno" value="<?php echo $cno?>" />
	<input type="hidden" name="act" value="<?php echo $mod2?>" />	
	<?php }else{ ?>
	<input type="hidden" name="act" value="comment" />
	<?php } ?>
    <input type="hidden" name="bid" value="<?php echo $bid?>" />
	<input type="hidden" name="bno" value="<?php echo $row['BRDATA_NO']?>" />
	<input type="hidden" name="bdid" value="<?php echo $row['BRDATA_ID']?>" />
	<input type="hidden" name="pageC" value="<?php echo $pageC?>" />
	<input type="hidden" name="page" value="<?php echo $page?>" />
    <input type="hidden" name="search" value="<?php echo $search?>" />
    <input type="hidden" name="kwd" value="<?php echo $kwd?>" />
    <input type="hidden" name="cate" value="<?php echo $cate?>" />    
	<input type="hidden" name="chkKey" id="chkKey" value="<?php echo $SpamKey?>" />
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
<?php } ?>  
	<div class="sbc">
		<!-- 댓글 등록 -->
		<div class="sbcw_w">
			<div class="sbcw_top">
				<span class="txt01">댓글달기</span>
				<span class="txt02">500자 이내로 작성하여 주십시오.</span>
			</div>
			
			<div class="sbcw_bot">
			<? if(S_mb_level == site_config_glevel && $board_data['BOARD_LV_COMMENT'] == site_config_glevel) { ?>
				<p class="txt_a">
	            	&bull;&nbsp;<label for="commentusr">이름</label>
	    	        <input type="text" name="commentusr" id="commentusr" required class="inpline" style="width:120px;" value="<?php echo S_mb_name?>">
					&nbsp;&bull;&nbsp;<label for="commentusrwd">비밀번호</label>
	            	<input type="password" name="commentusrwd" id="commentusrwd" required class="inpline" style="width:120px;" maxlength="8">
					<?php if(!S_mb_login){ ?>
		    		&bull;&nbsp;<label for="spamKey">인증번호</label>
					<img src="/base/imgs/spamkey/no_<?php echo $d[0]?>.gif" style="vertical-align:middle"><img src="/base/imgs/spamkey/no_<?php echo $d[1]?>.gif" style="vertical-align:middle"><img src="/base/imgs/spamkey/no_<?php echo $d[2]?>.gif" style="vertical-align:middle"><img src="/base/imgs/spamkey/no_<?php echo $d[3]?>.gif" style="vertical-align:middle"><img src="/base/imgs/spamkey/no_<?php echo $d[4]?>.gif" style="vertical-align:middle"><img src="/base/imgs/spamkey/no_<?php echo $d[5]?>.gif" style="vertical-align:middle">
					<input type="text" id="spamKey" name="spamKey" required class="inpline" style="width:120px" maxlength="6"> ※ 옆의 인증번호를 입력해주세요
					<?php } ?>
					<textarea id="commentcontents" name="contents" class="textarea1" required><?php echo $dataRow['BRDCMNT_CONTENT']?></textarea>
				</p>
				<p class="btn"><a href="#dsubmit" onclick="submitCmt();">등록하기</a></p>
			<? } else if(S_mb_level == site_config_alevel && S_mb_level <= $board_data['BOARD_LV_COMMENT']) { ?>
				<p class="txt_a">
					<textarea id="commentcontents" name="contents" class="textarea1" required><?php echo $dataRow['BRDCMNT_CONTENT']?></textarea>
				</p>
				<p class="btn"><a href="#dsubmit" onclick="submitCmt();">등록하기</a></p>
			<? } else if(S_mb_level <= site_config_level) { ?>
				<p class="txt_a">
					<textarea id="commentcontents" name="contents" class="textarea1" required><?php echo $dataRow['BRDCMNT_CONTENT']?></textarea>
				</p>
				<p class="btn"><a href="#dsubmit" onclick="submitCmt();">등록하기</a></p>
			<? } else if(S_mb_level > $board_data['BOARD_LV_COMMENT'] and $board_data['BOARD_LV_COMMENT'] > site_config_level){?>
				로그인 후 댓글을 남기실 수 있습니다.
			<?php } ?>
			</div>
			
		</div>
		<!--// 댓글 등록 //-->

<?php if(S_mb_level <= $board_data['BOARD_LV_COMMENT']) { ?>
	</form>
<?php } ?>

<?php
	if($rs_cnt > 0) {
?>          
		<!-- 댓글 리스트 -->
		<div class="sbcv_w">
			<div class="sbcv_top">전체댓글수 <span class="fc_blue"><?php echo $rs_cnt?></span>건</div>

			<?php while( $row_c = $coreClass -> selectFetchArray($rs_c) ){ ?>
			<div class="sbcv_list_w">
				<div class="sbcv_list_top">
					<span class="txt01"><img src="images/board/icon_comm.gif" alt="" class="align_m mr_5"><?php echo $row_c['BRDCMNT_NAME']?> | <?php echo $row_c['BRDCMNT_REGDATE']?></span>
					<span class="txt02">
						<? if(S_mb_level <= bbs_config_level || (S_mb_id == $row_c['BRDCMNT_UID'] && S_mb_level <= site_config_alevel)) { ?>
						<a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $no?>&amp;cno=<?php echo $row_c['BRDCMNT_NO']?>&amp;mod2=comment_mod">수정│</a>
						<a href="<?php echo site_ssl_https?>/sub.php?menukey=<?php echo $menukey?>&amp;mod=process&amp;act=comment_del&amp;bno=<?php echo $no?>&amp;cno=<?php echo $row_c['BRDCMNT_NO']?><?php echo $brdVar?>&amp;token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?')) location.href=this.href; return false">삭제</a>
						<? } else if(S_mb_id == $row_c['BRDCMNT_UID']) { ?>
						<a href="sub.php?menukey=<?php echo $menukey?>&amp;mod=view&amp;no=<?php echo $no?>&amp;cno=<?php echo $row_c['BRDCMNT_NO']?>&amp;mod2=comment_mod">수정│</a>
						<a href="<?php echo site_ssl_https?>/sub.php?menukey=<?php echo $menukey?>&amp;mod=passchk&amp;rtnmod=process&amp;rtnact=comment_del&amp;bno=<?php echo $no?>&amp;cno=<?php echo $row_c['BRDCMNT_NO']?><?php echo $brdVar?>&amp;token=<?php echo site_config_token?>">삭제</a>
						<? } ?>
					</span>
				</div>
				<div class="sbcv_list_bot">
				<?php 			
					if($row_c['BRDCMNT_CONTENT'] != ""){
						echo nl2br($row_c['BRDCMNT_CONTENT']);
					}
				?>
				</div>
			</div>
			<? } ?>
		</div>
		<!--// 댓글 리스트 //-->

	</div>
	
<? } ?>