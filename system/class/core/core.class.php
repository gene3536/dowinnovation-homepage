<?php
	/**
	 * CoreClass : 쿼리처리담당 클래스
	 */
	class coreClass extends searchClass {

		// selectQuery - 130913
		function selectQuery($tbl, $where, $order, $snum, $rnum) {
			$query = "SELECT * FROM ".$tbl." ".$where." ".$order;
			if(isset($snum) && !empty($rnum)) {
				if($this -> DB_Type == 1) {
					$rnum = $snum + $rnum;
					$query = "SELECT * FROM (SELECT ROWNUM AS RNUM, Z.* FROM (".$query.") Z WHERE ROWNUM <= ".$rnum.") WHERE RNUM > ".$snum;				
				} else if($this -> DB_Type == 2) {
					$query = $query." LIMIT ".$snum.", ".$rnum;
				}
			}

			$rs = $this -> executeQuery($query);
			return $rs;
		}

		// selectQuery
		function selectQueryCustomize($tbl, $value, $where, $order, $snum, $rnum) {
			$query = "SELECT ".$value." FROM ".$tbl." ".$where." ".$order;
			if(isset($snum) && !empty($rnum)) {
				if($this -> DB_Type == 1) {
					$rnum = $snum + $rnum;
					$query = "SELECT ".$value." FROM (SELECT ROWNUM AS RNUM, Z.* FROM (".$query.") Z WHERE ROWNUM <= ".$rnum.") WHERE RNUM > ".$snum;				
				} else if($this -> DB_Type == 2) {
					$query = $query." LIMIT ".$snum.", ".$rnum;
				}
			}

			$rs = $this -> executeQuery($query);
			return $rs;
		}
		
		// selectQueryDistinct
		function selectQueryDistinct($tbl, $where, $value) {
			$query	= "SELECT DISTINCT ".$value." FROM ".$tbl." ".$where;
			$rs			= $this -> executeQuery($query);

			return $rs;
		}

		/**
		 * selectQueryCount
		 */
		function selectQueryDistinctCount($tbl, $where, $value) {

			$query	= "SELECT COUNT(DISTINCT ".$value.") FROM ".$tbl." ".$where;
			$rs			= $this -> executeQuery($query);
			
			if($this -> DB_Type == 1) {
				oci_fetch($rs);
				return ociresult($rs, 1);
			} else if($this -> DB_Type == 2) {
				return mysql_result($rs, 0, 0);
			}
		}
		
		// selectQueryArray
		function selectQueryArray($tbl, $where, $order, $snum, $rnum) {
			$query = "SELECT * FROM ".$tbl." ".$where." ".$order;
			if(isset($snum) && !empty($rnum)) {
				if($this -> DB_Type == 1) {
					$snum++;
					$query = "SELECT * FROM (SELECT ROWNUM AS RNUM, Z.* FROM (".$query.") Z WHERE ROWNUM <= ".$rnum.") WHERE RNUM >= ".$snum;				
				} else if($this -> DB_Type == 2) {
					$query = $query." LIMIT ".$snum.", ".$rnum;
				}
			}
			$rs = $this -> executeQuery($query);
			if($this -> DB_Type == 1) {
				return oci_fetch_array($rs);
			} else if($this -> DB_Type == 2) {
				return mysql_fetch_array($rs);
			}
		}
		
		function selectQueryArrayfile($files, $tbl, $where, $order, $snum, $rnum) {
			$query = "SELECT ".$files." FROM ".$tbl." ".$where." ".$order;
			if(isset($snum) && !empty($rnum)) {
				if($this -> DB_Type == 1) {
					$snum++;
					$query = "SELECT * FROM (SELECT ROWNUM AS RNUM, Z.* FROM (".$query.") Z WHERE ROWNUM <= ".$rnum.") WHERE RNUM >= ".$snum;				
				} else if($this -> DB_Type == 2) {
					$query = $query." LIMIT ".$snum.", ".$rnum;
				}
			}
			$rs = $this -> executeQuery($query);
			if($this -> DB_Type == 1) {
				return oci_fetch_array($rs);
			} else if($this -> DB_Type == 2) {
				return mysql_fetch_array($rs);
			}
		}

		/**
		 * selectFetchArray
		 */
		function selectFetchArray($obj) {
			if($this -> DB_Type == 1) {
				return oci_fetch_array($obj);
			} else if($this -> DB_Type == 2) {
				return mysql_fetch_array($obj);
			}			
		}

		/** selectQueryCount */
		function selectQueryCount($tbl, $where) {
			$query	= "SELECT COUNT(*) FROM ".$tbl." ".$where;
			$rs			= $this -> executeQuery($query);
			
			if($this -> DB_Type == 1) {
				oci_fetch($rs);
				return ociresult($rs, 1);
			} else if($this -> DB_Type == 2) {
				return mysql_result($rs, 0, 0);
			}
		}
		
		/** executeQueryCoun */
		function executeQueryCount($query) {
			$rs = $this -> executeQuery($query);
				
			if($this -> DB_Type == 1) {
				oci_fetch($rs);
				return ociresult($rs, 1);
			} else if($this -> DB_Type == 2) {
				return mysql_result($rs, 0, 0);
			}
		}
		
		/** executeQuerySelect */
		function executeQuerySelect($query, $snum, $rnum) {
			if(isset($snum) && !empty($rnum)) {
				if($this -> DB_Type == 1) {
					$rnum = $snum + $rnum;
					$query = "SELECT * FROM (SELECT ROWNUM AS RNUM, Z.* FROM (".$query.") Z WHERE ROWNUM <= ".$rnum.") WHERE RNUM > ".$snum;
				} else if($this -> DB_Type == 2) {
					$query = $query." LIMIT ".$snum.", ".$rnum;
				}
			}
		
			$rs = $this -> executeQuery($query);
			return $rs;
		}

		/**
		 * selectQueryCountChk
		 */
		// selectQueryCountChk - 121120
		function selectQueryCountChk($tbl, $where) {
			$query	= "SELECT COUNT(*) FROM ".$tbl." ".$where;
			$rs			= $this -> executeQuery($query);	
			
			if($this -> DB_Type == 1) {
				oci_fetch($rs);
				if(!ociresult($rs, 1)) {
					$this -> rollback();
					$this -> msg_back("데이터가 존재 하지 않습니다.");
				}
			} else if($this -> DB_Type == 2) {
				if(!mysql_result($rs, 0, 0)) {
					$this -> rollback();
					$this -> msg_back("데이터가 존재 하지 않습니다.");
				}
			}
		}
		
		/**
		 * selectQueryCountDistinct
		 */
		function selectQueryCountDistinct($tbl, $where, $value) {
			$query	= "SELECT COUNT(DISTINCT ".$value.") FROM ".$tbl." ".$where;
			$rs			= $this -> executeQuery($query);
			
			if($this -> DB_Type == 1) {
				oci_fetch($rs);
				return ociresult($rs, 1);
			} else if($this -> DB_Type == 2) {
				return mysql_result($rs, 0, 0);
			}
		}
		
		/**
		 * selectQuerySum
		 */
		function selectQuerySum($tbl, $where, $value) {
			$query	= "SELECT SUM(".$value.") FROM ".$tbl." ".$where;
			$rs			= $this -> executeQuery($query);
			
			if($this -> DB_Type == 1) {
				oci_fetch($rs);
				return ociresult($rs, 1);
			} else if($this -> DB_Type == 2) {
				return mysql_result($rs, 0, 0);
			}
		}
		
		/**
		 * selectQueryMax
		 */
		function selectQueryMax($tbl, $value) {
			$query	= "SELECT IFNULL(MAX(".$value."), 0) FROM ".$tbl;
			$rs			= $this -> executeQuery($query);
			
			if($this -> DB_Type == 1) {
				oci_fetch($rs);
				return ociresult($rs, 1);
			} else if($this -> DB_Type == 2) {
				return mysql_result($rs, 0, 0);
			}
		}

		/**
		 * selectQueryMaxWhere
		 */
		function selectQueryMaxWhere($tbl, $value, $where) {
			$query	= "SELECT MAX(".$value.") FROM ".$tbl." ".$where;
			$rs		= $this -> executeQuery($query);
			
			if($this -> DB_Type == 1) {
				oci_fetch($rs);
				return ociresult($rs, 1);
			} else if($this -> DB_Type == 2) {
				return mysql_result($rs, 0, 0);
			}
		}
		
		/*
		function selectQueryFilds($files, $tbl, $where, $order, $limit) {
			$query	= "SELECT ".$files." FROM ".$tbl." ".$where." ".$order." ".$limit;
			$rs			= $this -> executeQuery($query);
			return mysql_fetch_array($rs);
		}
		*/

		// SelectQuery
		function selectQueryFilds($files,$tbl, $where, $order, $snum, $rnum) {
			$query = "SELECT ".$files." FROM ".$tbl." ".$where." ".$order." ".$limit;
			if(isset($snum) && !empty($rnum)) {
				if($this -> DB_Type == 1) {
					$rnum = $snum + $rnum;
					$query = "SELECT * FROM (SELECT ROWNUM AS RNUM, Z.* FROM (".$query.") Z WHERE ROWNUM <= ".$rnum.") WHERE RNUM > ".$snum;				
				} else if($this -> DB_Type == 2) {
					$query = $query." LIMIT ".$snum.", ".$rnum;
				}
			}

			$rs = $this -> executeQuery($query);
			return $rs;
		}

		
		/**
		 * insertQuery
		 */
		function insertQuery($tbl, $item, $value) {
			$query	= "INSERT INTO ".$tbl." (".$item.") VALUES(".$value.")"; 
			$rs			= $this -> executeQuery($query);
			return $rs;
		}
		
		// insertQueryClob
		function insertQueryClob($tbl, $item, $value, $clob, $data) {
			$rid		= ":CONTB";
			$query	= "returning ".$clob." into :CONTB ";
			$query	= "INSERT INTO ".$tbl." (".$item.") VALUES(".$value.") ".$query;			
			
			$clob		= oci_new_descriptor($this -> conn, OCI_D_LOB);			
			$stmt		= oci_parse($this -> conn, $query);			
			ocibindbyname($stmt, $rid, $clob, -1, OCI_B_CLOB);
			$rs			= oci_execute($stmt, OCI_DEFAULT);		
			
			if(empty($stmt) || empty($rs)) $this -> dbQueryError();
			$clob -> save($data);
			@OCIFreeDesc($clob);
			
			return $rs;
		}
		
		/**
		 * updateQuery
		 */
		function updateQuery($tbl, $set, $where) {
			$query	= "UPDATE ".$tbl." ".$set." ".$where;
			$rs			= $this -> executeQuery($query);
			return $rs;
		}
		
		// updateQueryClob
		function updateQueryClob($tbl, $set, $where, $clob, $data) {
			$rid	= ":CONTB";
			$query	= "returning ".$clob." into :CONTB ";
			$query	= "UPDATE ".$tbl." ".$set." ".$where." ".$query;
			$clob		= ocinewdescriptor($this -> conn, OCI_D_LOB);
			$stmt		= oci_parse($this -> conn, $query);
			
			ocibindbyname($stmt, $rid, $clob, -1, OCI_B_CLOB);
			$rs			= oci_execute($stmt, OCI_DEFAULT);		
			
			if(empty($stmt) || empty($rs)) $this -> dbQueryError();
			$clob -> save($data);
			@OCIFreeDesc($clob);
			
			return $rs;
		}
		
		
		function deleteQuery($tbl, $where) {
			$query	= "DELETE FROM ".$tbl." ".$where;
			$rs			= $this -> executeQuery($query);
			return $rs;
		}

		function affected() {
			return mysql_affected_rows($this -> conn);
		}
	}
?>