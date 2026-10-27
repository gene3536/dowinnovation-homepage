<?php
	
	$menuTCnt	= $coreClass -> selectQueryCountDistinct($tbl1, "", "menu_root");
	$menuACnt 	= 1;
	$menuTnt	= $menuTCnt;
	if(!empty($code2)) {
		$menuACnt	= $code2;
		$menuTCnt	= $code2;				
	}
?>

<div id="cenCont_in">
	<div class="brdlist_head">
		<div class="searchBoxType1 clearfix">
			<div class="fl" style="padding-top: 5px;">&bull;&nbsp;총 대메뉴 <b><?php echo $menuTnt?></b></div>
	        <div class="fr">
	        	<form id="menuSearch" name="menuSearch" method="post" action="sub.php?menukey=<?php echo $menukey?>">
		        	<select name="code2" id="code2" class="selline" style="width:120px;" onchange="submit();">
		        		<option value="">전체메뉴</option>
	            		<?php
							$where	= "WHERE menu_depth = '1'";
							$order	= "ORDER BY menu_step ASC";
							$result = $coreClass -> selectQuery($tbl1, $where, $order, "", "");
							while($rowc = $coreClass -> selectFetchArray($result)) {
						?>
							<option value="<?php echo $rowc['MENU_ROOT']?>" <?php if($rowc['MENU_ROOT'] == $code2) echo "selected";?>><?php echo $rowc['MENU_ROOT']?>. <?php echo $rowc['MENU_TITLE']?></option>
						<?php } ?>
			        </select>
			        <span class="btn_pack medium icon" style="vertical-align:middle">
						<span class="refresh"></span>
						<input value="검색" type="submit">
					</span>
				</form>
	        </div>
		</div>
	</div>
	
    <div class="brdlist_content">
		<table class="tbl_list1" summary="메뉴목록">
        <caption>메뉴목록</caption>
        <colgroup>
        	<col width="22%" />
        	<col width="56%" />
        	<col width="12%" />
        	<col width="10%" />
        </colgroup>
        
        <thead>      
        	<tr>
				<th><b>메뉴명</b></th>
				<th><b>만족도결과</b></th>
                <th><b>평가점수/총점수</b></th>
                <th><b>평가인원</b></th>
            </tr>
        </thead>

		<tbody>
	    <?php
	    	// 1차 메뉴
	    	for($cnt = $menuACnt; $cnt <= $menuTCnt; $cnt++) {
				$where = "WHERE menu_root = '".$cnt."' AND menu_depth = '1'";
				$order = "ORDER BY menu_step ASC";
				$menu1Row = $coreClass -> selectQueryArray($tbl1, $where, $order, "", "");
	    		    	
				$satisfaction_where = "WHERE satisfaction_code = '".$scode."' AND satisfaction_menukey = '".$menu1Row['MENU_MENUKEY']."'";
				$satisfaction_result	= $coreClass -> selectQuerySum($tbl2, $satisfaction_where, "satisfaction_value");
				$satisfaction_count	= $coreClass -> selectQueryCount($tbl2, $satisfaction_where);
				
				if(!empty($satisfaction_count)) {
                   	$satisfaction_percent	= round(($satisfaction_result / ($satisfaction_count*5) * 100), 2);
				} else {
					$satisfaction_result	= 0;
					$satisfaction_percent	= 0;
				}
		?>        
            	<tr style="background-color:#d1e1f4;">
					<td class="title" style="padding-left:5px"><strong><a href="sub.php?menukey=<?php echo $menukey?>&mod=view&mkey=<?php echo $menu1Row['MENU_MENUKEY']?>">0<?php echo $menu1Row['MENU_ROOT']?>. <?php echo $menu1Row['MENU_TITLE']?></a></strong></td>
					<td style="text-align:left">
					<?php if($satisfaction_count > 0) { ?>
						<span class="i_graph">  
							<span class="g_bar">  
								<span style="width:<?php echo $satisfaction_percent?>%" class="g_action"></span>  
							</span>  
							<span class="g_percent">  
								<strong><?php echo $satisfaction_percent?></strong>%
                            </span>
                        </span>
					<?php } ?>
					</td>
                    <td><?php echo $satisfaction_result?> / <?php echo $satisfaction_count*5?></td>
                    <td><?php echo $satisfaction_count?></td>
				</tr>
				                
				<?php
					// 2차 메뉴
					$where		= "WHERE menu_root = '".$cnt."' AND menu_ref = '".$menu1Row['MENU_MENUKEY']."' AND menu_depth = '2'";
					$order		= "ORDER BY menu_step";					
					$menu2Rs	= $coreClass -> selectQuery($tbl1, $where, $order, "", "");
					$menu2Cnt	= $coreClass -> selectQueryCount($tbl1, $where);
					if($menu2Cnt > 0) {
			            while($menu2Row = $coreClass -> selectFetchArray($menu2Rs)){
							$satisfaction_where = "WHERE satisfaction_code = '".$scode."' AND satisfaction_menukey = '".$menu2Row['MENU_MENUKEY']."'";
							$satisfaction_result	= $coreClass -> selectQuerySum($tbl2, $satisfaction_where, "satisfaction_value");
							$satisfaction_count		= $coreClass -> selectQueryCount($tbl2, $satisfaction_where);
							if(!empty($satisfaction_count)) {
								$satisfaction_percent	= round(($satisfaction_result / ($satisfaction_count*5) * 100), 2);
							} else {
								$satisfaction_result	= 0;
								$satisfaction_percent	= 0;
							}
				?>
							<tr style="background-color:#f0f0f0;">
								<td class="title" style="padding:5px; padding-left:25px;"><a href="sub.php?menukey=<?php echo $menukey?>&mod=view&mkey=<?php echo $menu2Row['MENU_MENUKEY']?>"><?php echo $menu2Row['MENU_TITLE']?></a></td>
								<td style="text-align:left">
								<?php if($satisfaction_count > 0) { ?>
									<span class="i_graph">  
										<span class="g_bar">  
											<span style="width:<?php echo $satisfaction_percent?>%" class="g_action"></span>  
										</span>  
										<span class="g_percent">  
											<strong><?php echo $satisfaction_percent?></strong>%
										</span>
									</span>
								<?php } ?>
								</td>
								<td><?php echo $satisfaction_result?> / <?php echo $satisfaction_count*5?></td>
								<td><?php echo $satisfaction_count?></td>
							</tr>
		
							<?php
								// 3차 메뉴
								$where		= "WHERE menu_root = '".$cnt."' AND menu_ref = '".$menu2Row['MENU_MENUKEY']."' AND menu_depth = '3'";
								$order		= "ORDER BY menu_step ASC";
								$menu3Rs	= $coreClass -> selectQuery($tbl1, $where, $order, "", "");
								$menu3Cnt	= $coreClass -> selectQueryCount($tbl1, $where);
								
								if($menu3Cnt > 0) {
									while($menu3Row = $coreClass -> selectFetchArray($menu3Rs)){
										$satisfaction_where = "WHERE satisfaction_code = '".$scode."' AND satisfaction_menukey = '".$menu3Row['MENU_MENUKEY']."'";
										$satisfaction_result	= $coreClass -> selectQuerySum($tbl2, $satisfaction_where, "satisfaction_value");
										$satisfaction_count		= $coreClass -> selectQueryCount($tbl2, $satisfaction_where);
										if(!empty($satisfaction_count)) {
											$satisfaction_percent	= round(($satisfaction_result / ($satisfaction_count*5) * 100), 2);
										} else {
											$satisfaction_result	= 0;
											$satisfaction_percent	= 0;
										}

							?>
										<tr style="background-color:#fafae9;">
											<td class="title"  style="padding:5px; padding-left:45px;"><a href="sub.php?menukey=<?php echo $menukey?>&mod=view&mkey=<?php echo $menu3Row['MENU_MENUKEY']?>"><?php echo $menu3Row['MENU_TITLE']?></a></td>
											<td style="text-align:left">
												<span class="i_graph">  
													<span class="g_bar">  
														<span style="width:<?php echo $satisfaction_percent?>%" class="g_action"></span>  
													</span>  
													<span class="g_percent">  
														<strong><?php echo $satisfaction_percent?></strong>%
													</span>
												</span>
											</td>
											<td><?php echo $satisfaction_result?> / <?php echo $satisfaction_count*5?></td>
											<td><?php echo $satisfaction_count?></td>
										</tr>
										
										<?php
											// 4차 메뉴
											$where		= "WHERE menu_root = '".$cnt."' AND menu_ref = '".$menu3Row['MENU_MENUKEY']."' AND menu_depth = '4'";
											$order		= "ORDER BY menu_step ASC";
											$menu4Rs	= $coreClass -> selectQuery($tbl1, $where, $order, "", "");
											$menu4Cnt	= $coreClass -> selectQueryCount($tbl1, $where);
											
											if($menu4Cnt > 0) {
												while($menu4Row = $coreClass -> selectFetchArray($menu4Rs)){
													$satisfaction_where = "WHERE satisfaction_code = '".$scode."' AND satisfaction_menukey = '".$menu4Row['MENU_MENUKEY']."'";
													$satisfaction_result	= $coreClass -> selectQuerySum($tbl2, $satisfaction_where, "satisfaction_value");
													$satisfaction_count		= $coreClass -> selectQueryCount($tbl2, $satisfaction_where);
													if(!empty($satisfaction_count)) {
														$satisfaction_percent	= round(($satisfaction_result / ($satisfaction_count*5) * 100), 2);
													} else {
														$satisfaction_result	= 0;
														$satisfaction_percent	= 0;
													}
										?>
													<tr style="background-color:#ffffff;">
														<td class="title" style="padding:5px; padding-left:65px;"><a href="sub.php?menukey=<?php echo $menukey?>&mod=view&mkey=<?php echo $menu4Row['MENU_MENUKEY']?>"><?php echo $menu4Row['MENU_TITLE']?></a></td>
														<td style="text-align:left">
															<span class="i_graph">  
																<span class="g_bar">  
																	<span style="width:<?php echo $satisfaction_percent?>%" class="g_action"></span>  
																</span>  
																<span class="g_percent">  
																	<strong><?php echo $satisfaction_percent?></strong>%
																</span>
															</span>
														</td>
														<td><?php echo $satisfaction_result?> / <?php echo $satisfaction_count*5?></td>
														<td><?php echo $satisfaction_count?></td>
													</tr>
								        <?php
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
</div>    