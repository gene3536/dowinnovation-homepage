                <div class="sub_head">
                    <div class="path">
                        <ul>
                            <li><a href="/" class="home">Home</a></li>
							<?php 
							$locateArr = $menuClass->getRefMenu($menukey,2); 
							for($i=1; $i<=count($locateArr); $i++){ 
								$subLink2    = $menuClass->get_menu_link($locateArr[$i][0]);
								$addClass    = $i==count($locateArr)? " class=\"last\"" : "";
							?>
								<li><a href="<?=$subLink2['href']?>" target="<?=$subLink2['target']?>"<?php echo $addClass?>><?=$locateArr[$i][0]['MENU_TITLE']?></a></li>
							<?php 
							}
							?>
                        </ul>
                    </div>
                    <div class="sub_title">
                        <h1><?php echo site_menu_locTitle ?></h1>
                    </div>
                </div>
								

