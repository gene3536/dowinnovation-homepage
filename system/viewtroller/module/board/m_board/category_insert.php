
<form name="cateinsert" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	<input type="hidden" name="mod" value="process">
	<input type="hidden" name="act" value="cinsert">
	<input type="hidden" name="brdcat_bid" value="<?php echo $brdcat_bid?>">
	<input type="hidden" name="token" value="<?php echo site_config_token?>" />
	<input type="hidden" name="scode" value="<?php echo $scode?>" />
	
	<div id="cenCont_in">
	    <div class="brdlist_content">
	        <table class="tbl_view1" border="1" cellspacing="0" summary="분류 등록">
	        <caption>분류 등록</caption>
	        <colgroup>
	        	<col style="width: 20%;" />
	        	<col style="width: 80%;" />
	        </colgroup>
	       
	        <tbody>
	        	<tr>
	            	<th scope="row">게시판 ID</th>
		            <td><?php echo $brdcat_bid?></td>
				</tr>
	        	<tr>
	            	<th scope="row"><label for="brdcat_name">카테고리명</label></th>
		            <td>
	    				<input type="text" name="brdcat_name" id="brdcat_name" class="inpline" style="width:160px" />
					</td>
				</tr>
	        	<tr>
	            	<th scope="row"><label for="brdcat_seq">순위</label></th>
		            <td><input type="text" name="brdcat_seq" id="brdcat_seq" class="inpline" style="width:160px"></td>
				</tr>
	        </tbody>
			</table>
		</div>
	
	    <div class="brdlist_footer">
		    <div class="bt">
	            <button type="submit" class="btn_big"><strong>등록</strong></button>
			    <a href="sub.php?menukey=<?php echo $menukey?>&mod=catelist&category_bid=<?php echo $category_bid?>&scode=<?php echo $scode?>" class="btn_big"><span>취소</span></a>
	        </div>
		</div>     
	</div>
</form>