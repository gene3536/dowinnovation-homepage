<?php
	if($mod=="view"){
?>
	<div class="brdlist_footer">
	   	<div class="bt">

			<!--<span class="btn_pack medium" style="vertical-align:middle">
				<input value="복사" type="submit" onclick="selectData('C');return false;">
			</span>-->
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=movecopy&no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>" class="btn_big"><strong>이동/복사</strong></a> 


			<!--span class="btn_pack medium" style="vertical-align:middle">
				<input value="이동" type="submit" onclick="selectData('M');return false;">
			</span-->


			<?php if($row['BRDATA_DELETED'] == 'N') { ?>
				<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&no=<?php echo $row['BRDATA_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('삭제합니까?\n\n내용이 모두 삭제됩니다.')) location.href=this.href; return false" class="btn_big"><strong>삭제</strong></a>
				<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=adelete&no=<?php echo $row['BRDATA_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('완전삭제합니까?\n\n내용이 모두 완전삭제됩니다.')) location.href=this.href; return false" class="btn_big"><strong>완전삭제</strong></a>
			<?php } else if($row['BRDATA_DELETED'] == 'Y') { ?>
				<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=restore&no=<?php echo $row['BRDATA_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" class="btn_big"><strong>복구</strong></a>
				<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=adelete&no=<?php echo $row['BRDATA_NO']?>&token=<?php echo site_config_token?><?php echo $listVar?>" onClick="if(confirm('완전삭제합니까?\n\n내용이 모두 완전삭제됩니다.')) location.href=this.href; return false" class="btn_big"><strong>완전삭제</strong></a>
			<?php } ?>			
	   		<a href="sub.php?menukey=<?php echo $menukey?>&mod=reply&no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>" class="btn_big"><strong>답글</strong></a>
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&no=<?php echo $row['BRDATA_NO']?><?php echo $listVar?>" class="btn_big"><strong>수정</strong></a> 
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" class="btn_big"><span>목록</span></a>
       </div>
	</div> 

<?}else if($mod=="modify"){?>


	<div class="brdlist_footer">
		<div class="bt">
			<input type="image" src="/base/imgs/btn/btn_confirm.gif" alt="확인" style="vertical-align:middle" />
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=list<?php echo $listVar?>" class="btn_big"><span>취소</span></a>
		</div>
	</div>

<?}?>