<?php
	header("Content-Type: text/html; charset=UTF-8");
	require_once("../../../../../system/config/config_lite.php");
	
    /*
     * [최종결제요청 페이지(STEP2-2)]
     *
     * LG유플러스으로 부터 내려받은 LGD_PAYKEY(인증Key)를 가지고 최종 결제요청.(파라미터 전달시 POST를 사용하세요)
     */

	$configPath = $_SERVER['DOCUMENT_ROOT']."/base/php/pg/lgu/lgdacom"; //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf,/conf/mall.conf") 위치 지정. 

    /*
     *************************************************
     * 1.최종결제 요청 - BEGIN
     *  (단, 최종 금액체크를 원하시는 경우 금액체크 부분 주석을 제거 하시면 됩니다.)
     *************************************************
     */
    $CST_PLATFORM               = $_POST["CST_PLATFORM"];
    $CST_MID                    = $_POST["CST_MID"];
    $LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
    $LGD_PAYKEY                 = $_POST["LGD_PAYKEY"];

    require_once("./lgdacom/XPayClient.php");
    $xpay = &new XPayClient($configPath, $CST_PLATFORM);
    $xpay->Init_TX($LGD_MID);    
    
    $xpay->Set("LGD_TXNAME", "PaymentByKey");
    $xpay->Set("LGD_PAYKEY", $LGD_PAYKEY);
    
    //금액을 체크하시기 원하는 경우 아래 주석을 풀어서 이용하십시요.
	//$DB_AMOUNT = "DB나 세션에서 가져온 금액"; //반드시 위변조가 불가능한 곳(DB나 세션)에서 금액을 가져오십시요.
	//$xpay->Set("LGD_AMOUNTCHECKYN", "Y");
	//$xpay->Set("LGD_AMOUNT", $DB_AMOUNT);
	    
    /*
     *************************************************
     * 1.최종결제 요청(수정하지 마세요) - END
     *************************************************
     */

    /*
     * 2. 최종결제 요청 결과처리
     *
     * 최종 결제요청 결과 리턴 파라미터는 연동메뉴얼을 참고하시기 바랍니다.
     */
    if ($xpay->TX()) {
        //1)결제결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)
        /*echo "결제요청이 완료되었습니다.  <br>";
        echo "TX 통신 응답코드 = " . $xpay->Response_Code() . "<br>";		//통신 응답코드("0000" 일 때 통신 성공)
        echo "TX 통신 응답메시지 = " . $xpay->Response_Msg() . "<p>";
            
        echo "거래번호 : " . $xpay->Response("LGD_TID",0) . "<br>";
        echo "상점아이디 : " . $xpay->Response("LGD_MID",0) . "<br>";
        echo "상점주문번호 : " . $xpay->Response("LGD_OID",0) . "<br>";
        echo "결제금액 : " . $xpay->Response("LGD_AMOUNT",0) . "<br>";
        echo "결과코드 : " . $xpay->Response("LGD_RESPCODE",0) . "<br>";	//LGD_RESPCODE 가 반드시 "0000" 일때만 결제 성공, 그 외는 모두 실패
        echo "결과메세지 : " . $xpay->Response("LGD_RESPMSG",0) . "<p>";
            
        $keys = $xpay->Response_Names();
        foreach($keys as $name) {
            echo $name . " = " . $xpay->Response($name, 0) . "<br>";
        } 
          
        echo "<p>";*/
           
        if( "0000" == $xpay->Response_Code() ) { 
			//통신상의 문제가 없을시
         	//최종결제요청 결과 성공 DB처리(LGD_RESPCODE 값에 따라 결제가 성공인지, 실패인지 DB처리)
           	//echo "최종결제요청 결과 성공 DB처리하시기 바랍니다.<br>";

            //최종결제요청 결과를 DB처리합니다. (결제성공 또는 실패 모두 DB처리 가능)
			//상점내 DB에 어떠한 이유로 처리를 하지 못한경우 false로 변경해 주세요.
          	$isDBOK = true;  

          	if( !$isDBOK ) {
           		echo "<p>";
           		$xpay->Rollback("상점 DB처리 실패로 인하여 Rollback 처리 [TID:" . $xpay->Response("LGD_TID",0) . ",MID:" . $xpay->Response("LGD_MID",0) . ",OID:" . $xpay->Response("LGD_OID",0) . "]");            		            		
            		
                echo "TX Rollback Response_code = " . $xpay->Response_Code() . "<br>";
                echo "TX Rollback Response_msg = " . $xpay->Response_Msg() . "<p>";

				$resFAIL['Response']['TID']  = $xpay->Response("LGD_TID",0);
				$resFAIL['Response']['MID']  = $xpay->Response("LGD_MID",0);
				$resFAIL['Response']['code'] = $xpay->Response_Code();
				$resFAIL['Response']['msg']  = $xpay->Response_Msg();
            		
                if( "0000" == $xpay->Response_Code() ) {	
				
					//결제취소완료 상태 변경 
					$orderClass-> setStep($xpay->Response("LGD_OID",0),24);

					//전자결제 취소 완료 처리 
					$set   = "SET 
						data_tid_cancel     = 'Y', 
						data_refundtype2    = '2', 
						data_refundpaytype  = '1', 
						data_adminmemo      = '전자결제실패 자동취소요청' 
						";
					$where = "WHERE data_orderno='".$_POST["LGD_OID"]."'";
					$coreClass->updateQuery(tbl_booking_data, $set, $where);
					$coreClass->commit();	

					$resFAIL['msg'] = "자동취소가 정상적으로 완료 되었습니다.";
                  	echo "자동취소가 정상적으로 완료 되었습니다.<br>";
                }else{	
				
					//결제취소요청 상태 변경 
					$orderClass-> setStep($xpay->Response("LGD_OID",0),22);

					//거래번호 저장 (전자결제 취소 요청시 필요)
					$set   = "SET 
						data_tid            = '".$xpay->Response("LGD_TID",0)."', 
						data_tid_cancel     = 'N', 
						data_refundtype2    = '2', 
						data_refundpaytype  = '2', 
						data_adminmemo      = '전자결제실패 취소요청 처리 요망' 
						";
					$where = "WHERE data_orderno='".$_POST["LGD_OID"]."'";
					$coreClass->updateQuery(tbl_booking_data, $set, $where);
					$coreClass->commit();	

					$resFAIL['msg'] = "자동취소가 정상적으로 처리되지 않았습니다. 관리자에게 문의하세요.";
          			echo "자동취소가 정상적으로 처리되지 않았습니다. 관리자에게 문의하세요.<br>";
                }		

				echo ("
				<script>
					alert('결제에 실패하였습니다.1');
					parent.location.href = 'http://".site_config_host."/home/sub.php?menukey=".$_POST["menukey"]."&mod=orderResFAIL&Pres=1&orderno=".$_POST["LGD_OID"]."&resFAIL[]=".$resFAIL."';
				</script>
				");
          	} else {

				//결제완료 상태 변경 
				//$orderClass-> setStep($xpay->Response("LGD_OID",0),20);
				$orderClass-> setStep($_POST["LGD_OID"],20);

				//거래번호 저장 (전자결제 취소 요청시 필요)
				$set   = "SET data_tid='".$xpay->Response("LGD_TID",0)."', data_tid_cancel='N'";
				$where = "WHERE data_orderno='".$_POST["LGD_OID"]."'";
				$coreClass->updateQuery(tbl_booking_data, $set, $where);
				$coreClass->commit();	

				//결제완료 문자전송
				$smsClass->send_mireene_sms($_POST["data_tel"], "", $_smsMASAGES[10], 100, urldecode($_POST['data_name']), $_POST["LGD_OID"]);

				echo "<script>parent.location.href = 'http://".site_config_host."/home/sub.php?menukey=".$_POST["menukey"]."&mod=orderResOK&orderno=".$_POST["LGD_OID"]."';</script>";
			}
        }else{
          	//통신상의 문제 발생(최종결제요청 결과 실패 DB처리)
         	//echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br>"; 

			$resFAIL['Response']['code'] = $xpay->Response_Code();
			$resFAIL['Response']['msg']  = $xpay->Response_Msg();
			$resFAIL['msg'] = "통신상의 문제가 발생 하였습니다.";
			
			//결제취소완료 상태 변경 
			$orderClass-> setStep($_POST["LGD_OID"],24);
			
			echo ("
			<script>
				alert('결제에 실패하였습니다.2');
				parent.location.href = 'http://".site_config_host."/home/sub.php?menukey=".$_POST["menukey"]."&mod=orderResFAIL&Pres=2&orderno=".$_POST["LGD_OID"]."&resFAIL[]=".$resFAIL."';
			</script>
			");
        }
    }else {
        //2)API 요청실패 화면처리
        /*echo "결제요청이 실패하였습니다.  <br>";
        echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
        echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";*/
            
        //최종결제요청 결과 실패 DB처리
        //echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br>";    
		
		//결제취소완료 상태 변경 
		$orderClass-> setStep($_POST["LGD_OID"],24);

		$resFAIL['Response']['code'] = $xpay->Response_Code();
		$resFAIL['Response']['msg']  = $xpay->Response_Msg();
		$resFAIL['msg'] = "API 요청실패 하였습니다.";
		
		echo ("
		<script>
			alert('결제에 실패하였습니다.3');
			parent.location.href = 'http://".site_config_host."/home/sub.php?menukey=".$_POST["menukey"]."&mod=orderResFAIL&Pres=3&orderno=".$_POST["LGD_OID"]."&resFAIL[]=".$resFAIL."';
		</script>
		");
    }
?>
