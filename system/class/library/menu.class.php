<?php

class menuClass extends coreClass {

	var $subP, $subPLastDep, $subLocation = array(), $sitemenuArr = array(), $submenuArr = array(), $subPArray = array();
	var $subLocationA = array(), $sitemenuArrA = array(), $submenuArrA = array(), $subPArrayA = array();

	function __construct()
	{
		coreClass::getConnection();		 
		if(defined("site_menu_menukey") && site_menu_menukey != 9999) { 
			$this->subP = $this->getMenu(site_menu_menukey);
			$this->_getRefMenu(site_menu_menukey); 
			$this->_getLeftMenu();
		} 
		$this->_getMenuArray();
	}

	//전체
	function _getMenuArray(){

		$whereD1 = "WHERE menu_scode = '".site_config_code."' AND menu_depth = 1"; 
		$orderD1 = "ORDER BY menu_root ASC";		
		if($this->selectQueryCount(tbl_menu, $whereD1) >0){	
			$menu1Res = $this->selectQuery(tbl_menu, $whereD1, $orderD1, "", "");
			while($menu1Row = $this->selectFetchArray($menu1Res)){

				$this->sitemenuArr[$menu1Row['MENU_DEPTH']][] = $menu1Row;	
				if($menu1Row['MENU_VAR1'] == "achive") $this->sitemenuArrA[$menu1Row['MENU_DEPTH']][] = $menu1Row;	

				$whereD2 = "WHERE menu_scode = '".site_config_code."' AND menu_ref = '".$menu1Row['MENU_MENUKEY']."' AND menu_depth = '2'"; //echo $whereD2."<br>";
				$orderD2 = "ORDER BY menu_step";
				if($this->selectQueryCount(tbl_menu, $whereD2) > 0){ 
					$menu2Res = $this->selectQuery(tbl_menu, $whereD2, $orderD2, "", "");
					while($menu2Row = $this->selectFetchArray($menu2Res)){	
						$this->sitemenuArr[$menu2Row['MENU_DEPTH']][] = $menu2Row; 
						if($menu2Row['MENU_VAR1'] == "achive") $this->sitemenuArrA[$menu2Row['MENU_DEPTH']][] = $menu2Row;	

						$whereD3 = "WHERE menu_scode = '".site_config_code."' AND menu_ref = '".$menu2Row['MENU_MENUKEY']."' AND menu_depth = '3'"; 
						$orderD3 = "ORDER BY menu_step";
						if($this->selectQueryCount(tbl_menu, $whereD3) > 0){ //echo $whereD3."<br>";	
							$menu3Res = $this->selectQuery(tbl_menu, $whereD3, $orderD3, "", "");
							while($menu3Row = $this->selectFetchArray($menu3Res)){
								$this->sitemenuArr[$menu3Row['MENU_DEPTH']][] = $menu3Row;	
								if($menu3Row['MENU_VAR1'] == "achive") $this->sitemenuArrA[$menu3Row['MENU_DEPTH']][] = $menu3Row;	

								$whereD4 = "WHERE menu_scode = '".site_config_code."' AND menu_ref = '".$menu3Row['MENU_MENUKEY']."' AND menu_depth = '4'";
								$orderD4 = "ORDER BY menu_step";
								if($this->selectQueryCount(tbl_menu, $whereD4) > 0){ //echo $menu3Qry."<br>";
									$menu4Res = $this->selectQuery(tbl_menu, $whereD4, $orderD4, "", "");
									while($menu4Row = $this->selectFetchArray($menu4Res)){
										$this->sitemenuArr[$menu4Row['MENU_DEPTH']][] = $menu4Row;	
										if($menu4Row['MENU_VAR1'] == "achive") $this->sitemenuArrA[$menu4Row['MENU_DEPTH']][] = $menu4Row;	

										$whereD5 = "WHERE menu_scode = '".site_config_code."' AND menu_ref = '".$menu4Row['MENU_MENUKEY']."' AND menu_depth = '5'";
										$orderD5 = "ORDER BY menu_step";
										if($this->selectQueryCount(tbl_menu, $whereD5) > 0){ //echo $menu3Qry."<br>";
											$menu5Res = $this->selectQuery(tbl_menu, $whereD5, $orderD5, "", "");
											while($menu5Row = $this->selectFetchArray($menu5Res)){
												$this->sitemenuArr[$menu5Row['MENU_DEPTH']][] = $menu5Row;	
												if($menu5Row['MENU_VAR1'] == "achive") $this->sitemenuArrA[$menu5Row['MENU_DEPTH']][] = $menu5Row;	

											}
											// end while (menu5Res);
										}

									}
									// end while (menu4Res);
								}
							}
							// end while (menu3Res);
						}
					}
					// end while ($menu2Res);
				}
			}
			// end while ($menu1Res);
		}
	}

	function getMenuArray(){
		$return = $this->sitemenuArr;
		return $return;
	}
	
	//왼쪽 메뉴 
	function _getLeftMenu() {
		for($i=1; $i<=$this->subPLastDep; $i++)
		{
			$where = "WHERE menu_root = '".$this->subP['MENU_ROOT']."' AND menu_depth='".$i."' AND menu_scode = '".site_config_code."' "; 
			if($i>1) $where .= " AND menu_ref = '".$this->subPArray[$i-1][0]['MENU_MENUKEY']."'"; 
			$order = "ORDER BY menu_step ASC";

			if($this->selectQueryCount(tbl_menu, $where) > 0){ 
				$res = $this->selectQuery(tbl_menu, $where, $order, "", "");
				while($row = $this->selectFetchArray($res)){
					$this->submenuArr[$i][] = $row; 
				}
				unset($row);
			}
		}
	}
	
	//왼쪽 메뉴 가져오기
	function getLeftMenu() {
		$return = $this->submenuArr;
		return $return;

	}
	
	//왼쪽 메뉴 가져오기2
	function getLeftMenu2() {
		$return = $this->subPArray;
		return $return;

	}

	//메뉴 이력 
	function _getRefMenu($mkey,$f=1) { 
		if($f==1){ 
			$root= $this->subP['MENU_ROOT'];
			$ref = $this->subP['MENU_REF']; 
			$si  = ($this->subP['MENU_DEPTH']-1 <=0) ? $this->subP['MENU_DEPTH'] : $this->subP['MENU_DEPTH']-1;
			$li  = ($this->subP['MENU_DEPTH']+1 >=$this->subPLastDep) ? $this->subP['MENU_DEPTH'] : $this->subP['MENU_DEPTH']+1;  
			$this->subPArray[$this->subP['MENU_DEPTH']][] = $this->subP;
		}else{ 
			$mRow= $this->getMenu($mkey);
			$root= $mRow['MENU_ROOT'];
			$ref = $mRow['MENU_REF'];
			$si  = ($mRow['MENU_DEPTH']-1 <=0) ? $mRow['MENU_DEPTH'] : $mRow['MENU_DEPTH']-1;
			$li  = $mRow['MENU_DEPTH'];
			$rt[$mRow['MENU_DEPTH']][] = $mRow;
		}

		//위
		for($i=$si; $i>=1; $i--)
		{
			$qry  = "WHERE menu_root = '".$root."' AND menu_depth='".$i."' AND menu_scode = '".site_config_code."' "; 
			$qry .= ($i>1)? " AND menu_menukey = '".$ref."'" : ""; 

			if($this->selectQueryCount(tbl_menu, $qry) > 0){ 
				$res = $this->selectQuery(tbl_menu, $qry, "", "", "");
				$row = $this->selectFetchArray($res);
				$this->subPArray[$i][] = $row;
				if($f!=1) $rt[$i][] = $row;
				$ref = $row['MENU_REF'];
				unset($row);
			}
		}
		
		//아래
		for($ii=$li; $ii<=$this->subPLastDep; $ii++)
		{
			$where = "WHERE menu_root = '".$root."' AND menu_depth='".$ii."' AND menu_menukey = '".$ref."' AND menu_scode = '".site_config_code."'"; //echo $where."<br>";
			$order = "ORDER BY menu_step ASC"; 

			if($this->selectQueryCount(tbl_menu, $where) > 0){ 
				$res = $this->selectQuery(tbl_menu, $qry, "", "", "");
				$row = $this->selectFetchArray($res);
				$this->subPArray[$ii][] = $row;
				if($f!=1) $rt[$ii][] = $row;
				$ref = $row['MENU_REF'];
				unset($row);
			}
		}

		if($f!=1) return $rt;
	}
	
	//이력 가져오기 
	function getRefMenu($mkey,$f=1) {
		$this->_getRefMenu($mkey,$f=1);
		$return = $this->subPArray;
		return $return;

	}
	
	//메뉴 정보 가져오기
	function getMenu($m) {

		$qry = "WHERE menu_menukey='{$m}'"; 
		if($this->selectQueryCount(tbl_menu, $qry) > 0){ 
			$row = $this->selectQueryArray(tbl_menu, $qry, "", "", "");

			$where = "WHERE menu_root = '".$row['MENU_ROOT']."' "; 
			$this->subPLastDep = $this->selectQueryMaxWhere(tbl_menu, "menu_depth", $where); 

			return $row;
		}else{
			return false;
		}	
	}
	
	//메뉴 링크
	function get_menu_link($row) { 

		$return = array();
		$return['href']   = "#";
		$return['target'] = "_self";
		$return['onclick'] = "";

		if($row['MENU_TYPE'] == 1){
			$newRow = $this->get_first_menukey($row['MENU_MENUKEY'], $row['MENU_DEPTH']); 
			if($newRow != false){  
				$newRow2 = $this->get_menu_link($newRow);  
				$return  = $newRow2;
			}
		}else{
			if($row['MENU_TYPE'] == 2 || $row['MENU_TYPE'] == 3 || $row['MENU_TYPE'] == 4){
				$return['href'] = "sub.php?menukey=".$row['MENU_MENUKEY'];
			}else if($row['MENU_TYPE'] == 5){ //링크
				$return['href']   = $row['MENU_URL'];
				$return['target'] = $row['MENU_URLMOD'];
			}else if($row['MENU_TYPE'] == 6){ //스크립트
				$return['href']    = $row['MENU_URL'];
				$return['onclick'] = $row['MENU_SURL'];
			}
		}	

		return $return;
	}
	
	//메뉴 비활성일때 첫번째 링크 찾기 
	function get_first_menukey($m, $d) {

		$return = array();
		$dp = $d;

		for($i=1; $i<=5; $i++){
			$dp++;
			$qry = "WHERE menu_ref = '{$m}' AND menu_depth = '{$dp}' AND menu_visible ='Y' "; //echo $qry."<br>";
			if($this->selectQueryCount(tbl_menu, $qry) > 0){
				$row = $this->selectQueryArray(tbl_menu, $qry, "ORDER BY menu_step", 1, "");
				if($row['MENU_TYPE'] == 1){
					$m = $row['MENU_MENUKEY'];
					$d = $row['MENU_DEPTH'] + 1;
				}else{ 				
					$return = $row;
					break;
				}
			}else{
				return false;
			}
		}

		return $return;
	}

	function getMenuLocation($bcode){

		$query_m = "WHERE menu_menukey='".$bcode."' AND menu_scode='".site_config_code."'";
		$mkey    = $this->selectQueryArray(tbl_menu, $query_m, "", "", "");

		$qry = "WHERE menu_root='".$mkey['MENU_ROOT']."' AND menu_depth = 1 AND menu_scode='".site_config_code."'"; 
		$sub1title = $this->selectQueryArray(tbl_menu, $qry, "", "", "");
		$menuLocation['row'] = $sub1title; 

		$subTitle = $mkey["MENU_TITLE"];
		if($row_m["MENU_DEPTH"] == 3) {
			$sub2title_query = "WHERE menu_menukey='".$mkey['MENU_REF']."' AND menu_depth = '2' AND menu_scode='".site_config_code."'";
			$sub2title = $this->selectQueryArray(tbl_menu, $sub2title_query, "", "", "");
			$sub2step  = $sub2title['MENU_STEP'];
			$menuLocation['row'] = $sub2title;

			// 3차일경우 서브 페이지 타이틀
			$sub1title3_query = "WHERE menu_root='".$mkey['MENU_ROOT']."' AND menu_menukey = '".$sub2title['MENU_REF']."' AND menu_scode='".site_config_code."'";
			if(selectQueryCount(tbl_menu, $sub1title3_query)>0){
				$sub1title3 = $this->selectQueryArray(tbl_menu, $sub2title_query, "", "", "");
				$subTitle = $sub1title3['MENU_TITLE'];
				$sub_step = $sub1title3['MENU_STEP'];
				$menuLocation['row'] = $sub1title3;
			}
			
			$menuLocation['str'] = "<li>".$sub1title['MENU_TITLE']."</li><li>".$sub2title['MENU_TITLE']."</li><li>".$subTitle."</li>";	

		} else {
			$menuLocation['row'] = $mkey; 
			$menuLocation['str'] = $sub1title['MENU_TITLE']."</li><li>".$subTitle."</li>";	
		}
		return $menuLocation;
	}

	function get_subtitle($mkey){
		$query = "WHERE menu_menukey='".$mkey."'";
		$mkey    = $this->selectQueryArray(tbl_menu, $query, "", "", "");
		
		if($mkey['MENU_DEPTH']=='1'){
			return $mkey['MENU_SUBTITLE'];
		}else{
			return $this->get_subtitle($mkey['MENU_REF']);
		}
	}
	//2차메뉴 불러오기
	function get_subtitle2($mkey){
		$query = "WHERE menu_menukey='".$mkey."'";
		$mkey    = $this->selectQueryArray(tbl_menu, $query, "", "", "");
		
		if($mkey['MENU_DEPTH']=='2'){
			return $mkey['MENU_TITLE'];
		}else{
			return $this->get_subtitle2($mkey['MENU_REF']);
		}
	}

	function check_parent($mkey){
		$query = "WHERE menu_menukey='".$mkey."'";
		$mkey    = $this->selectQueryArray(tbl_menu, $query, "", "", "");
		
		return $mkey['MENU_REF'];
	}
	
	function get_inquiry_header(){
		$query = "WHERE cms_info_code='".site_config_code."'";
		$info    = $this->selectQueryArray(tbl_cms_info, $query, "", "", "");
		$header = $info['CMS_INQUIRY_HEADER'];
		return $header;

	}
}

?>