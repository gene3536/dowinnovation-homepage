<?php

	$where		= "WHERE menu_scode = '".$scode."'";
	$menuTCnt	= $coreClass -> selectQueryCountDistinct($tbl1, $where, "menu_root");
	$menuACnt 	= 1;
	$menuTnt	= $menuTCnt;
	if(!empty($code1) && $code1 < 9999) {
		$menuACnt	= $code1;
		$menuTCnt	= $code1;				
	}
	
	// 전체메뉴 셀렉트목록
	$where	= "WHERE menu_scode = '".$scode."' AND menu_depth = '1'";
	$order	= "ORDER BY menu_root ASC";
	$result = $coreClass -> selectQuery($tbl1, $where, $order, "", "");
	while($rowc = $coreClass -> selectFetchArray($result)) {
		$optCon .= '<option value="'.$rowc['MENU_ROOT'].'"';
		if($rowc['MENU_ROOT'] == $code1) {
			$optCon .= ' selected="selected"';
		}
		$optCon .= '>'.$rowc['MENU_ROOT'].'. '.$rowc['MENU_TITLE'].'</option>';
	}
?>

<div id="cenCont_in">
	<?php echo $cmsClass -> getSiteList($menukey, $mod, $scode); ?>
	
	<div class="brdlist_head">
		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">
				&bull;&nbsp;총 대메뉴 : <b><?php echo $menuTnt?></b>
			</div>
	        <div class="fr">
	        	<form id="menuSearch" name="menuSearch" method="post" action="sub.php?menukey=<?php echo $menukey?>">
	        		<input type="hidden" name="scode" id="scode" value="<?php echo $scode?>" />
		        	<select name="code1" id="code1" class="selline" style="width:160px;" onchange="submit();">
		        		<option value="9999">전체메뉴</option>
		        		<?php echo $optCon?>
			        </select>
			        <button type="button" class="btn_big"><span>검색</span></button>					
				</form>
	        </div>
		</div>
	</div>
	
    <div class="brdlist_content">
		<table class="tbl_list1" summary="메뉴목록">
        <caption>메뉴목록</caption>
        <colgroup>
            <col />
        	<col width="8%" />
        	<col width="5%" />
        	<col width="5%" />
        	<col width="5%" />
        	<col width="5%" />
        	<col width="5%" />
        	<col width="7%" />
        	<col width="7%" />
        	<col width="7%" />
        	<col width="12%" />
        	<col width="7%" />
        </colgroup>
        
        <thead>      
        	<tr>
				<th><b>메뉴명</b></th>
				<th><b>담당자</b></th>
                <th><b>메뉴키</b></th>
                <th><b>순서</b></th>
                <th><b>활성</b></th>
                <th><b>접근</b></th>
                <th><b>레벨</b></th>
                <th><b>타입</b></th>
				<th><b>모드</b></th>
                <th><b>위치</b></th>
				<th><b>처리</b></th>
				<th><b>만족도</b></th>
            </tr>
        </thead>

		<tbody>
	    <?php
	    	// 1차 메뉴
	    	for($cnt = $menuACnt; $cnt <= $menuTCnt; $cnt++) {
				$where = "WHERE menu_scode = '".$scode."' AND menu_root = '".$cnt."' AND menu_depth = '1'";
				$order = "ORDER BY menu_step ASC";
				$menu1Row = $coreClass -> selectQueryArray($tbl1, $where, $order, "", "");
		?>        
            	<tr style="background-color:#d1e1f4">
					<td class="title" style="padding-left:5px"><strong><a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&mkey=<?php echo $menu1Row['MENU_MENUKEY']?><?php echo $listVar?>">0<?php echo $menu1Row['MENU_ROOT']?>. <?php echo strip_tags($menu1Row['MENU_TITLE'])?></a></strong></td>
                    <td>
					<?php
						$mbwhere = "WHERE organ_mb_id = '".$menu1Row['MENU_DEPUSER']."'";
						$mbrow = $coreClass -> selectQueryArray(tbl_organization_member, $mbwhere, "", "", "");
						echo $mbrow['ICD_NAME'];
					?>
					</td>

					<td><?php echo $menu1Row['MENU_MENUKEY']?></td>
                    <td><?php echo $menu1Row['MENU_STEP']?></td>
					<td><?php echo $coreClass -> getMenuVisible($menu1Row['MENU_VISIBLE'])?></td>
					<td><?php echo $coreClass -> getMenuVisible($menu1Row['MENU_ACCESS'])?></td>
					<td><?php echo $menu1Row['MENU_LEVEL']?></td>
                    <td><?php echo $coreClass -> getMenuType($menu1Row['MENU_TYPE'])?></td>
					<td><?php echo $menu1Row['MENU_URLMOD']?></td>
					<td>
	                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=up&mkey=<?php echo $menu1Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>" style="color:#900">▲</a>
    	                <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=down&mkey=<?php echo $menu1Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>" style="color:#900">▼</a>
                    </td>
                    <td>
	                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=menu2ins&mkey=<?php echo $menu1Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">추가</a> |               
	                    <a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&mkey=<?php echo $menu1Row['MENU_MENUKEY']?><?php echo $listVar?>">수정</a> | 
						<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&mkey=<?php echo $menu1Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?\n\n정보가 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
                    </td>
					<td> <a href="sub.php?menukey=<?php echo $menukey?>&mod=gradeview&mkey=<?php echo $menu1Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">만족도</a></td>
				</tr>
				                
				<?php
					// 2차 메뉴
					$where		= "WHERE menu_scode = '".$scode."' AND menu_root = '".$cnt."' AND menu_ref = '".$menu1Row['MENU_MENUKEY']."' AND menu_depth = '2'";
					$order		= "ORDER BY menu_step";					
					$menu2Rs	= $coreClass -> selectQuery($tbl1, $where, $order, "", "");
					$menu2Cnt	= $coreClass -> selectQueryCount($tbl1, $where);
					if($menu2Cnt > 0) {
			            while($menu2Row = $coreClass -> selectFetchArray($menu2Rs)){
		        ?>
							<tr style="background-color:#f0f0f0;">
								<td class="title" style="padding:5px; padding-left:25px;"><a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&mkey=<?php echo $menu2Row['MENU_MENUKEY']?><?php echo $listVar?>"><?php echo strip_tags($menu2Row['MENU_TITLE'])?></a></td>

								<td>

								<?php
									$mbwhere	= "WHERE organ_mb_id = '".$menu2Row['MENU_DEPUSER']."'";
									$mbrow		= $coreClass -> selectQueryArray(tbl_organization_member, $mbwhere, "", "", "");
									echo $mbrow['ICD_NAME'];
								?>

								</td>
								<td style="padding:5px;"><?php echo $menu2Row['MENU_MENUKEY']?></td>
			                    <td style="padding:5px;"><?php echo $menu2Row['MENU_STEP']?></td>
								<td style="padding:5px;"><?php echo $coreClass -> getMenuVisible($menu2Row['MENU_VISIBLE'])?></td>
								<td style="padding:5px;"><?php echo $coreClass -> getMenuVisible($menu2Row['MENU_ACCESS'])?></td>
								<td style="padding:5px;"><?php echo $menu2Row['MENU_LEVEL']?></td>
			                    <td style="padding:5px;"><?php echo $coreClass -> getMenuType($menu2Row['MENU_TYPE'])?></td>
								<td style="padding:5px;"><?php echo $menu2Row['MENU_URLMOD']?></td>
								<td style="padding:5px;">
									<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=up&mkey=<?php echo $menu2Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">▲</a>
									<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=down&mkey=<?php echo $menu2Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">▼</a>
								</td>
								<td style="padding:5px;">
									<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=menu3ins&mkey=<?php echo $menu2Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">추가</a> | 
									<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&mkey=<?php echo $menu2Row['MENU_MENUKEY']?><?php echo $listVar?>">수정</a> | 
									<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&mkey=<?php echo $menu2Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?\n\n정보가 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
								</td>
								<td> <a href="sub.php?menukey=<?php echo $menukey?>&mod=gradeview&mkey=<?php echo $menu2Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">만족도</a></td>
							</tr>
		
							<?php
								// 3차 메뉴
								$where		= "WHERE menu_scode = '".$scode."' AND menu_root = '".$cnt."' AND menu_ref = '".$menu2Row['MENU_MENUKEY']."' AND menu_depth = '3'";
								$order		= "ORDER BY menu_step ASC";
								$menu3Rs	= $coreClass -> selectQuery($tbl1, $where, $order, "", "");
								$menu3Cnt	= $coreClass -> selectQueryCount($tbl1, $where);
								
								if($menu3Cnt > 0) {
									while($menu3Row = $coreClass -> selectFetchArray($menu3Rs)){
							?>
										<tr style="background-color:#fafae9;">
											<td class="title"  style="padding:5px; padding-left:45px;"><a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&mkey=<?php echo $menu3Row['MENU_MENUKEY']?><?php echo $listVar?>"><?php echo strip_tags($menu3Row['MENU_TITLE'])?></a></td>
											<td>
											<?php
												$mbwhere = "WHERE organ_mb_id = '".$menu3Row['MENU_DEPUSER']."'";
												$mbrow = $coreClass -> selectQueryArray(tbl_organization_member, $mbwhere, "", "", "");
												echo $mbrow['ICD_NAME'];
											?>
											</td>
											<td style="padding:5px;"><?php echo $menu3Row['MENU_MENUKEY']?></td>
						                    <td style="padding:5px;"><?php echo $menu3Row['MENU_STEP']?></td>
											<td style="padding:5px;"><?php echo $coreClass -> getMenuVisible($menu3Row['MENU_VISIBLE'])?></td>
											<td style="padding:5px;"><?php echo $coreClass -> getMenuVisible($menu3Row['MENU_ACCESS'])?></td>
											<td style="padding:5px;"><?php echo $menu3Row['MENU_LEVEL']?></td>
						                    <td style="padding:5px;"><?php echo $coreClass -> getMenuType($menu3Row['MENU_TYPE'])?></td>
											<td style="padding:5px;"><?php echo $menu3Row['MENU_URLMOD']?></td>
											<td style="padding:5px;">
												<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=up&mkey=<?php echo $menu3Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">▲</a>
												<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=down&mkey=<?php echo $menu3Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">▼</a>
											</td>
											<td style="padding:5px;">                        
												<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=menu4ins&mkey=<?php echo $menu3Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">추가</a> | 
												<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&mkey=<?php echo $menu3Row['MENU_MENUKEY']?><?php echo $listVar?>">수정</a> | 
												<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&mkey=<?php echo $menu3Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?\n\n정보가 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
											</td>
											<td> <a href="sub.php?menukey=<?php echo $menukey?>&mod=gradeview&mkey=<?php echo $menu3Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">만족도</a></td>
										</tr>
										
										<?php
											// 4차 메뉴
											$where		= "WHERE menu_scode = '".$scode."' AND menu_root = '".$cnt."' AND menu_ref = '".$menu3Row['MENU_MENUKEY']."' AND menu_depth = '4'";
											$order		= "ORDER BY menu_step ASC";
											$menu4Rs	= $coreClass -> selectQuery($tbl1, $where, $order, "", "");
											$menu4Cnt	= $coreClass -> selectQueryCount($tbl1, $where);
											
											if($menu4Cnt > 0) {
												while($menu4Row = $coreClass -> selectFetchArray($menu4Rs)){
										?>
													<tr style="background-color:#ffffff;">
														<td class="title" style="padding:5px; padding-left:65px;"><a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&mkey=<?php echo $menu4Row['MENU_MENUKEY']?><?php echo $listVar?>"><?php echo strip_tags($menu4Row['MENU_TITLE'])?></a></td>
														<td>
														<?php
															$mbwhere = "WHERE organ_mb_id = '".$menu4Row['MENU_DEPUSER']."'";
															$mbrow = $coreClass -> selectQueryArray(tbl_organization_member, $mbwhere, "", "", "");
															echo $mbrow['ICD_NAME'];
														?>
														</td>
														<td style="padding:5px;"><?php echo $menu4Row['MENU_MENUKEY']?></td>
									                    <td style="padding:5px;"><?php echo $menu4Row['MENU_STEP']?></td>
														<td style="padding:5px;"><?php echo $coreClass -> getMenuVisible($menu4Row['MENU_VISIBLE'])?></td>
														<td style="padding:5px;"><?php echo $coreClass -> getMenuVisible($menu4Row['MENU_ACCESS'])?></td>
														<td style="padding:5px;"><?php echo $menu4Row['MENU_LEVEL']?></td>
									                    <td style="padding:5px;"><?php echo $coreClass -> getMenuType($menu4Row['MENU_TYPE'])?></td>
														<td style="padding:5px;"><?php echo $menu4Row['MENU_URLMOD']?></td>
														<td style="padding:5px;">
															<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=up&mkey=<?php echo $menu4Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">▲</a>
															<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=down&mkey=<?php echo $menu4Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">▼</a>
														</td>
														<td style="padding:5px;"> 
															<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=menu5ins&mkey=<?php echo $menu4Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">추가</a> | 														
															<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&mkey=<?php echo $menu4Row['MENU_MENUKEY']?><?php echo $listVar?>">수정</a> | 
															<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&mkey=<?php echo $menu4Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?\n\n정보가 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
														</td>
														<td> <a href="sub.php?menukey=<?php echo $menukey?>&mod=gradeview&mkey=<?php echo $menu4Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">만족도</a></td>
													</tr>


											<?php
												// 5차 메뉴
												$where		= "WHERE menu_scode = '".$scode."' AND menu_root = '".$cnt."' AND menu_ref = '".$menu4Row['MENU_MENUKEY']."' AND menu_depth = '5'";
												$order		= "ORDER BY menu_step ASC";
												$menu5Rs	= $coreClass -> selectQuery($tbl1, $where, $order, "", "");
												$menu5Cnt	= $coreClass -> selectQueryCount($tbl1, $where);
												
												if($menu5Cnt > 0) {
													while($menu5Row = $coreClass -> selectFetchArray($menu5Rs)){
											?>
														<tr style="background-color:#ffffff;">
															<td class="title" style="padding:5px; padding-left:85px;"><a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&mkey=<?php echo $menu5Row['MENU_MENUKEY']?><?php echo $listVar?>">* <?php echo strip_tags($menu5Row['MENU_TITLE'])?></a></td>
															<td>
															<?php
																$mbwhere = "WHERE organ_mb_id = '".$menu5Row['MENU_DEPUSER']."'";
																$mbrow = $coreClass -> selectQueryArray(tbl_organization_member, $mbwhere, "", "", "");
																echo $mbrow['ICD_NAME'];
															?>
															</td>
															<td style="padding:5px;"><?php echo $menu5Row['MENU_MENUKEY']?></td>
															<td style="padding:5px;"><?php echo $menu5Row['MENU_STEP']?></td>
															<td style="padding:5px;"><?php echo $coreClass -> getMenuVisible($menu5Row['MENU_VISIBLE'])?></td>
															<td style="padding:5px;"><?php echo $coreClass -> getMenuVisible($menu5Row['MENU_ACCESS'])?></td>
															<td style="padding:5px;"><?php echo $menu5Row['MENU_LEVEL']?></td>
															<td style="padding:5px;"><?php echo $coreClass -> getMenuType($menu5Row['MENU_TYPE'])?></td>
															<td style="padding:5px;"><?php echo $menu5Row['MENU_URLMOD']?></td>
															<td style="padding:5px;">
																<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=up&mkey=<?php echo $menu5Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">▲</a>
																<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=down&mkey=<?php echo $menu5Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">▼</a>
															</td>
															<td style="padding:5px;">                        
																<a href="sub.php?menukey=<?php echo $menukey?>&mod=modify&mkey=<?php echo $menu5Row['MENU_MENUKEY']?><?php echo $listVar?>">수정</a> | 
																<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=delete&mkey=<?php echo $menu5Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>" onClick="if(confirm('삭제합니까?\n\n정보가 모두 삭제됩니다.')) location.href=this.href; return false">삭제</a>
															</td>
															<td> <a href="sub.php?menukey=<?php echo $menukey?>&mod=gradeview&mkey=<?php echo $menu5Row['MENU_MENUKEY']?><?php echo $listVar?>&token=<?php echo site_config_token?>">만족도</a></td>
														</tr>
											<?php
													}
												}
											?>
										<?
												}
											}
										?>
					        <?php
									}
								}
							?>
				<?php
						}//end of while
					}//end of if
				?>
		<?php
			}
		?>
        </tbody>
		</table>
	</div>
   
    <div class="brdlist_footer">
        <div class="bt">
			<a href="sub.php?menukey=<?php echo $menukey?>&mod=process&act=menu1ins<?php echo $listVar?>&token=<?php echo site_config_token?>" class="btn_big"><span>1차메뉴등록</span></a>
        </div>
	</div>    
</div>    