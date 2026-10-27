<?php
	/** 게시글 목록 - 140617 */
	require_once $dir2."list.header.php";
	$where1 = "WHERE BRDCAT_BID = '".$bid."'"; 
	$order1 = "ORDER BY BRDCAT_SEQ ASC";
	$cateRs = $coreClass -> selectQuery(tbl_board_category, $where1, $order1);
	$calender = array();
	$ii = 0;
	while($category = $coreClass -> selectFetchArray($cateRs)) {
		$where2 = "WHERE BRDATA_CATEGORY = '".$category['BRDCAT_ID']."' AND BRDATA_BID = '".$category['BRDCAT_BID']."'";
		$order2 = "ORDER BY BRDATA_NO ASC";
		$dataRs = $coreClass -> selectQuery(tbl_board_data, $where2, $order2);
		$calender[$ii]['title'] = $category['BRDCAT_NAME'];
		$jj = 0;
		while($datas = $coreClass -> selectFetchArray($dataRs)) {
			$calender[$ii]['content'][$jj] = $datas;
			$jj++;
		}
		$ii++;
	}
?>
<div class="board_w"> 
	<ul class="tabs" id="selTab">
		<li id="521">교육사업</li>
		<li id="522" class="active">교육일정</li>
	</ul> 
</div>

	 <div class="esc-wrap">
		<div class="esc__title">
			<div class="esc__title-wrap">
				<h2 class="esc__title-h2">2019년 <strong>교육일정</strong></h2>
			</div>
		</div>
		<div class="esc__con">
			 <!-- Category 01 //-->
			 <?php foreach($calender as $row) {?>
			 <div class="esc__con-wrap">
				 <h3 class="esc__con-h3"><?=$row['title']?></h3>
				 <ul class="esc__con-list">
				 <!-- item 01 //-->
					 <?php 
						$num = '1'; 
						foreach($row['content'] as $con) {?>
						<li class="esc__con-item">
							<div class="esc__con-inner">
								<p class="num"><span><?=sprintf('%02d',$num)?></span></p>
								<p class="title"><span><em><?=$con['BRDATA_SUBJECT']?></em></span></p>
								<?if($con['BRDATA_ETC4']!=''){?><p class="date"><span><?=$con['BRDATA_ETC4']?></span></p><?}?>
								<p class="btn-open"><span>열기</span></p>
							</div>
							<div class="esc__con-box">
								<div class="esc__con-desc">
									<h4 class="esc__con-h4"><?=$con['BRDATA_SUBJECT']?></h4>
									<div class="esc__con-text">
										  <?=$con['BRDATA_FLD1']?>                
									</div>
									<?php 
										$caWhere	= "WHERE dIdx = '".$con['BRDATA_NO']."'";
										$caOrder	= "ORDER BY cOrder asc";
										$calRs	= $coreClass -> selectQuery($tbl6, $caWhere, $caOrder, "", "");
									?>
									<?php 
										$rs	    = $coreClass -> selectQueryCount($tbl6, $caWhere);
											
									if($rs > 0) {?>
										<h4 class="esc__con-h4 mt_30">2019년 교육일정</h4>
										<div class="table_w">
											<table class="table">
												<caption>지역 성별영향평가센터명과 연락처, 홈페이지 정보를 제공합니다.</caption>
												<colgroup>
													<col class="cols1"></col>
													<col class="cols2"></col>
												</colgroup>

												<tbody class="t_l">
													<?php while($row2 = $coreClass -> selectFetchArray($calRs)) {?>
														<tr>
															<th scope="row"><?=$row2['cTitle']?></th>
															<td class="t_c"><?=$row2['cDate']?></td>
														</tr>
													<?
													}?>
												</tbody>
											</table>
										</div>
									<?}?>
								</div>
							</div>
						</li>
					<?
						$num++;
					}?>
					<!--// item 01 -->
				</ul>
			</div>
			 <?}?>

		</div>
	</div>

