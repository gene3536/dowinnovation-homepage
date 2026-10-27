<?php
	header("Content-Type: text/html; charset=UTF-8");
	require_once("../../../../../system/config/config_lite.php");

	if(empty($_POST["orderno"])){
		$coreClass->msg("요청정보가 올바르지 않습니다.");
		die;
	}

	$where = "WHERE data_orderno='".$_POST["orderno"]."'"; 
	if($coreClass->selectQueryCount(tbl_booking_data, $where)>0){
		$row     = $coreClass->selectQueryArray(tbl_booking_data, $where, $order, $snum, $rnum);
		$chkAuto = true;

		if(!empty($row["DATA_PENALTYPRICE"]) && $row["DATA_PENALTYPRICE"]>0){
			$chkAuto = false;
		}else{
			$Penalty = $orderClass->getPenalty($_POST["orderno"],$row["DATA_CANCELCATEG"]);
			$chkAuto = ($Penalty != false && $Penalty['price']>0)? false : true;
		}

		//위약금 있을때 부분취소 (수동) 처리 해야함.
		if($chkAuto == false){

			if($row['DATA_REFUNDPAYTYPE'] != 2){
				$set   = "SET data_refundpaytype = '2' "; 
				$coreClass -> updateQuery(tbl_booking_data, $set, $where);			
				$coreClass -> commit();
			}

			if($row['DATA_TID_CANCEL'] == "N"){
				if($_POST['step'] == 91){
					$strMsg = "[필수] 위약금 ".number_format($Penalty['price'])."원이 있습니다. 상점관리자 페이지에서 전자결제 부분취소 하시기 바랍니다.";
				}else if($_POST['step'] == 92){
					$strMsg = "[필수] 위약금 ".number_format($Penalty['price'])."원이 있습니다. 상점관리자 페이지에서 전자결제 부분취소 하시기 바랍니다.";
				}

				echo ("
				<script>
					alert('".$strMsg."');
				</script>
				");
			}

			echo ("
			<script>
				parent.location.href = 'http://".site_config_host."/mgcms/sub.php?menukey=".$_POST["menukey"]."&mod=process&act=update&Pstep=".$_POST["step"]."&token=".$_POST["token"]."&orderno=".$_POST["orderno"]."';
			</script>
			");
			die;
		}
	}else{
		$coreClass->msg("요청정보가 올바르지 않습니다.");
		die;
	}
	
	//전자결제 취소전만 처리 
	if($row['DATA_TID_CANCEL'] == "N" && !empty($row['DATA_TID'])){

		/*
		 * [결제취소 요청 페이지]
		 *
		 * LG유플러스으로 부터 내려받은 거래번호(LGD_TID)를 가지고 취소 요청을 합니다.(파라미터 전달시 POST를 사용하세요)
		 * (승인시 LG유플러스으로 부터 내려받은 PAYKEY와 혼동하지 마세요.)
		 */
		$CST_PLATFORM               = $_POST["CST_PLATFORM"];       //LG유플러스 결제 서비스 선택(test:테스트, service:서비스)
		$CST_MID                    = $_POST["CST_MID"];            //상점아이디(LG유플러스으로 부터 발급받으신 상점아이디를 입력하세요)
																			 //테스트 아이디는 't'를 반드시 제외하고 입력하세요.
		$LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;  //상점아이디(자동생성)    
		//$LGD_TID                	= $_POST["LGD_TID"];			 //LG유플러스으로 부터 내려받은 거래번호(LGD_TID)
		$LGD_TID                	= $row['DATA_TID'];			 //LG유플러스으로 부터 내려받은 거래번호(LGD_TID)
		
		$configPath 				= $_SERVER['DOCUMENT_ROOT'].site_pg_dir."/lgdacom"; 	 //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정.   
		
		require_once("./lgdacom/XPayClient.php");
		$xpay = &new XPayClient($configPath, $CST_PLATFORM);
		$xpay->Init_TX($LGD_MID);

		$xpay->Set("LGD_TXNAME", "Cancel");
		$xpay->Set("LGD_TID", $LGD_TID);
		
		/*
		 * 1. 결제취소 요청 결과처리
		 *
		 * 취소결과 리턴 파라미터는 연동메뉴얼을 참고하시기 바랍니다.
		 */
		if ($xpay->TX()) {
			//1)결제취소결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)
			/*echo "결제 취소요청이 완료되었습니다.  <br>";
			echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
			echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";*/

			//전자결제 취소처리 
			$set   = "SET data_tid_cancel='Y', data_refundpaytype='1'";
			$where = "WHERE data_orderno='".$_POST["orderno"]."'";
			$coreClass->updateQuery(tbl_booking_data, $set, $where);
			$coreClass->commit();	

			echo ("
			<script>
				alert('결제 취소요청이 완료되었습니다.');
				parent.location.href = 'http://".site_config_host."/mgcms/sub.php?menukey=".$_POST["menukey"]."&mod=process&act=update&Pstep=".$_POST["step"]."&token=".$_POST["token"]."&orderno=".$_POST["orderno"]."';
			</script>
			");
		}else {
			//2)API 요청 실패 화면처리
			/*echo "결제 취소요청이 실패하였습니다.  <br>";
			echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
			echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";*/
			$resFAIL['Response']['code'] = $xpay->Response_Code();
			$resFAIL['Response']['msg']  = $xpay->Response_Msg();
			echo ("
			<script>
				alert('결제 취소요청이 실패하였습니다.');
				parent.location.href = 'http://".site_config_host."/mgcms/sub.php?menukey=".$_POST["menukey"]."&resFAIL[]=".$resFAIL."';
			</script>
			");

		}

	}

	die;
?>
