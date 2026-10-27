<?php if(count($menuClass->submenuArr[4])){ ?>

	<?php if(site_menu_var5 == 2){ ?>

	<div class="tab_5d02_w">
		<ul class="tab5_1d">
			<? 
			foreach($menuClass->submenuArr[4] as $subVar4){ 
				if($subVar4['MENU_VISIBLE'] == "Y"){
					$onoffClass4 = ($subVar4['MENU_MENUKEY'] == $menuClass->subPArray[4][0]['MENU_MENUKEY'])? "on" : "off";
					$subLink4    = $menuClass->get_menu_link($subVar4);
			?>
			<li class="<?php echo $onoffClass4?>"><a href="<?=$subLink4['href']?>" target="<?=$subLink4['target']?>"><?=$subVar4['MENU_TITLE']?></a>
				<?php 
				$where = "WHERE menu_root = '".$subVar4['MENU_ROOT']."' AND menu_depth='5' AND menu_ref = '".$subVar4['MENU_MENUKEY']."' AND menu_scode = '".site_config_code."'";
				$order = "ORDER BY menu_step ASC";
				if($coreClass->selectQueryMaxWhere(tbl_menu, "menu_depth", $where)){ 
				?>
				<ul class="tab5_2d">
					<?php 
					$subMenu5Res = $coreClass->selectQuery(tbl_menu, $where, $order, "", "");
					while($subMenu5Row = $coreClass->selectFetchArray($subMenu5Res)){
						if($subMenu5Row['MENU_VISIBLE'] == "Y"){ 
							$onoffClass5 = ($subMenu5Row['MENU_MENUKEY'] == $menuClass->subPArray[5][0]['MENU_MENUKEY'])? "on" : "off";
							$subLink5 = $menuClass->get_menu_link($subMenu5Row);
					?>
					<li class="list_<?php echo $onoffClass5?>"><a href="<?=$subLink5['href']?>" target="<?=$subLink5['target']?>"><?=$subMenu5Row['MENU_TITLE']?></a>
					<?php 
						}
					}
					?>
				</ul>
				<?php } ?>
			<li>
			<?php 
				}
			}
			?>
		</ul>
	</div>

	<?php }else{ ?>
	
	<div class="sc_tab_w">
		<div class="tab_w">
			<ul class="sc_tab">
				<? 
				foreach($menuClass->submenuArr[4] as $subVar4){ 
					if($subVar4['MENU_VISIBLE'] == "Y"){
						$onoffClass4 = ($subVar4['MENU_MENUKEY'] == $menuClass->subPArray[4][0]['MENU_MENUKEY'])? "on" : "off";
						$subLink4    = $menuClass->get_menu_link($subVar4);
				?>
				<li class="<?php echo $onoffClass4?>"><a href="<?=$subLink4['href']?>" target="<?=$subLink4['target']?>"><?=$subVar4['MENU_TITLE']?></a><li>
				<?php 
					}
				}
				?>
			</ul>
		</div>
	</div>

	<? } ?>

	<div class="mb_30"></div>

<? } ?>