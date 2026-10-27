<?php
	echo $cmsClass -> getSiteList($menukey, $mod, $scode);
	
	// 게시판 목록
	if(S_mb_level <= site_config_level) {
		$bwhere	= "WHERE 1=1";
	} else {
		$bwhere	= "LEFT JOIN ".tbl_board_manage." ON brdmng_bid = board_id and brdmng_uid='".S_mb_id."'";
		$bwhere .= " WHERE 1=1";
		$bwhere .= " AND ((brdmng_uid = '".S_mb_id."' AND board_lv_access < '".S_mb_level."')";
		$bwhere .= " OR (board_lv_access >= '".S_mb_level."'))";
	}
	if(!empty($scode)) {
		$bwhere .= " AND (board_scode = '00000000' OR board_scode = '".$scode."')";
	}
	$border		= "ORDER BY board_name ASC";
	$brs			= $coreClass -> selectQuery($tbl1, $bwhere, $border, "", "");
	
	// 유형 목록
	$torder		= "ORDER BY brdskin_no ASC";
	$trs			= $coreClass -> selectQuery($tbl5, "", $torder, "", "");
?>

<form id="searchBox" name="searchBox" method="get" action="sub.php">
	<input type="hidden" id="menukey" name="menukey" value="<?php echo $menukey?>" />
	<input type="hidden" id="mod" name="mod" value="list" />    		
	<input type="hidden" id="scode" name="scode" value="<?php echo $scode?>" />

	<div class="brdlist_head">
		<div class="searchBoxType1 clearfix">
			<div class="fr">
	        	<select id="code1" name="code1" class="selline" title="검색조건" style="width: 180px" onchange="submit(); return false;">
		       		<option value="">전체유형</option>
		       		<?php
		       			while($trow = $coreClass -> selectFetchArray($trs)) {
		       				echo "<option value=\"".$trow['BRDSKIN_ID']."\"";
							if($trow['BRDSKIN_ID'] == $code1) {
								echo "selected=\"selected\"";
							}		        				
		       				echo ">".$trow['BRDSKIN_NAME']."</option>";
						}
					?>
				</select>  		
		       	<select id="code2" name="code2" class="selline" title="검색조건" style="width: 240px" onchange="submit(); return false;">
		       		<option value="">전체게시판</option>
		       		<?php
		       			while($brow = $coreClass -> selectFetchArray($brs)) {
		       				$bcwhere		= "WHERE brdata_bid = '".$brow['BOARD_ID']."'";
							$bcnt			= $coreClass -> selectQueryCount(tbl_board_data, $bcwhere);	
		       				echo "<option value=\"".$brow['BOARD_ID']."\"";
							if($brow['BOARD_ID'] == $code2) {
								echo "selected=\"selected\"";
							}		        				
		       				echo ">".$brow['BOARD_NAME']." [".$bcnt."]</option>";
						}
					?>
				</select>
	        </div>
		</div>
	</div>
</form>
	