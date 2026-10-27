<?php
	header("Content-Type: text/html; charset=UTF-8");
	require_once("../../../../../system/config/config_lite.php"); 

	if(!empty($_FILES['attachFile']['name'])) {	
		$save_path = dir_public."/upload/order/";

		$attachFile			= $_FILES['attachFile']['tmp_name'];
		$attachFile_name	= $_FILES['attachFile']['name'];
		$attachFile_size	= $_FILES['attachFile']['size'];

		$t_attachFile_name  = explode(".",$attachFile_name);
		if($t_attachFile_name[count($t_attachFile_name)-1] == "xls" || $t_attachFile_name[count($t_attachFile_name)-1] == "xlsx"){
		}else{
			 $coreClass->msg("엑셀 파일만 등록할 수 있습니다.");
			 exit;
		}

	}

	$where = "WHERE data_orderno='".$_POST['ori_orderno']."'";
	$existOrder = $coreClass->selectQueryCount(tbl_booking_data,$where);
	
	if($existOrder>0){	
		
		//예약중 변경 
		$orderClass-> setStep($_POST['ori_orderno'],0);

	}else{	

		$isValid = $orderClass->isValidDate($_POST['data_date'], $_POST['data_staytype']);
		switch($isValid){
			case 1 : 
				$coreClass->msg_go("선택한 날짜는 휴관일입니다.","sub.php?menukey=$menukey&mod=list&data_program=$data_program");
				break;
			case 2 :
				$coreClass->msg_go("선택한 날짜 중 휴관일이 포함 되어있습니다.","sub.php?menukey=$menukey&mod=list&data_program=$data_program");
				break;
			case -1 :
				$coreClass->msg_go("예약 정보가 정확하지 않습니다.","sub.php?menukey=$menukey&mod=list&data_program=$data_program");
				break;
			default : 
				break;
		}
		
		foreach($_POST['opt_fcltno'] as $v){
			if(!$orderClass->checkRoom($v,$_POST['data_sdate'],$_POST['data_edate'])){
				 $coreClass->msg("선택한 객실의 예약이 만료되었습니다.");
				 exit;
			}
		}

		//주문정보 저장
		$data_orderno   = $orderClass->getordno();
		//$data_orderno   = $_POST["LGD_OID"];
		$data_tel       = $coreClass->dataEscape($_POST['data_tel'][0])."-".$coreClass->dataEscape($_POST['data_tel'][1])."-".$coreClass->dataEscape($_POST['data_tel'][2]);
		$data_tel2      = $coreClass->dataEscape($_POST['data_tel2'][0])."-".$coreClass->dataEscape($_POST['data_tel2'][1])."-".$coreClass->dataEscape($_POST['data_tel2'][2]);
		$data_memo      = $coreClass->dataEscapeNoXss($_POST['data_memo']) ;
		$data_pass		= $coreClass->dataEscape($_POST['data_pass']);
		$data_pass      = $coreClass->crypt_sha256($data_pass);	
		$data_payaccount= $_POST['data_paytype']=="bank"? $_POST['data_payaccount'] : "";

		$tmp			= explode("-",$_POST['data_edate']);
		$newEdate		= date("Y-m-d",mktime(0,0,0,$tmp[1],($tmp[2]-1),$tmp[0]));
		$data_edate     = $newEdate;

		$item			= "data_orderno, data_step, data_date, data_sdate, data_edate, data_program, data_staytype, data_name, data_tel, data_tel2, data_memo, data_id, data_pass, data_paytype, data_payaccount, data_price, data_payprice, data_regdate, data_deleted";
		$value			= "'".$data_orderno."', 0, '".$_POST['data_date']."', '".$_POST['data_sdate']."', '".$data_edate."', '".$_POST['data_program']."', '".$_POST['data_staytype']."', '".$_POST['data_name']."', '".$data_tel."', '".$data_tel2."', '".$data_memo."', '".S_mb_id."', '".$data_pass."', '".$_POST['data_paytype']."', '".$data_payaccount."', '".$_POST["LGD_AMOUNT"]."', '".$_POST["LGD_AMOUNT"]."', '".site_regdate."', 'N'";
		$coreClass -> insertQuery(tbl_booking_data, $item, $value);
		
		//객실 정보 저장 
		foreach($_POST['opt_fcltno'] as $v){
			$opt1  = !empty($_POST['opt_fcltspec'][$v]) ? $_POST['opt_fcltspec'][$v]  : 0;
			$opt2  = !empty($_POST['opt_fcltprice'][$v])? $_POST['opt_fcltprice'][$v] : 0;
			$opt3  = !empty($_POST['opt_prgmprice'][$v])? $_POST['opt_prgmprice'][$v] : 0;
			$opt4  = !empty($_POST['opt_count'][$v])    ? $_POST['opt_count'][$v]     : 0;
			$opt5  = !empty($_POST['opt_count2'][$v])   ? $_POST['opt_count2'][$v]    : 0;
			$opt6  = !empty($_POST['opt_total'][$v])    ? $_POST['opt_total'][$v]	  : 0;

			$item			= " opt_orderno, opt_fcltno, opt_fcltspec, opt_fcltprice, opt_prgmtitle, opt_prgmprice, opt_count, opt_count2, opt_total";
			$value			= "'".$data_orderno."', '".$v."', '".$opt1."', '".$opt2."', '".$_POST['opt_prgmtitle'][$v]."', '".$opt3."', '".$opt4."', '".$opt5."', '".$opt6."'";
			$coreClass -> insertQuery(tbl_booking_data_opt, $item, $value);
		}

		// 참석자 첨부파일 업로드

		if(!empty($_FILES['attachFile']['name'])) {	

			$sfilename	= "";
			$filename	= "";
			$filesize	= 0;			
			if(isset($attachFile) && $attachFile_name){
				$sfilename	= $coreClass -> uploadFile($attachFile, $attachFile_name, $attachFile_size, $save_path, 0, 5, 180, 120);
				$filename		= $thumbFile_name;
				$filesize		= $thumbFile_size;
			}

			$set   = "SET data_fileyear = '".date("Y")."', data_sfilename = '".$sfilename."', data_filename = '".$filename."'";
			$where = "WHERE data_orderno = '".$data_orderno."'";
			$coreClass->updateQuery(tbl_booking_data, $set, $where);
		}
		
		//참석자 등록
		for($i=1; $i<=count($_POST['pp_name']); $i++){
			if(!empty($_POST['pp_name'][$i])){
				$pp_data1 = $coreClass->dataEscape($_POST['pp_name'][$i]);
				$pp_data2 = $coreClass->dataEscape($_POST['pp_relation'][$i]);
				$pp_data3 = $coreClass->dataEscape($_POST['pp_gender'][$i]);
				$pp_data4 = $coreClass->dataEscape($_POST['pp_age'][$i]);
				$pp_data5 = $coreClass->dataEscape($_POST['pp_room'][$i]);
				$item			= " pp_orderno, pp_data1, pp_data2, pp_data3, pp_data4, pp_data5, pp_data6, pp_data7, pp_data8, pp_data9, pp_data10";
				$value			= "'".$data_orderno."', '".$pp_data1."', '".$pp_data2."', '".$pp_data3."', '".$pp_data4."', '".$pp_data5."', '".$pp_data6."', '".$pp_data7."', '".$pp_data8."', '".$pp_data9."', '".$pp_data10."'";
				$coreClass -> insertQuery(tbl_booking_data_people, $item, $value);
			}
		}

		$coreClass -> commit();	

		$_SESSION['SS_ORDERNO_'.$data_orderno] = 1;

	}	
	

	// 무통장입금
	if($_POST['data_paytype'] == "bank"){

		//입금대기 상태 변경 
		$orderClass-> setStep($data_orderno,30);

		//입금대기 문자전송
		$where = "WHERE conf_no='".$data_payaccount."'";
		$arow  = $coreClass->selectQueryArray(tbl_booking_conf_account,$where,"","","");
		$_smsMASSAGES_ADD = "[영동국악체험촌](".$arow['CONF_BANK'].") ".$arow['CONF_ACCOUNT']." ".$arow['CONF_NAME'];

		$smsClass->send_mireene_sms($data_tel, "", $_smsMASAGES[11], 100, $_POST['data_name'], $data_orderno);
		$smsClass->send_mireene_sms($data_tel, "", $_smsMASSAGES_ADD, 100, $_POST['data_name'], $data_orderno);

		echo ("
		<script type='text/javascript'>			
			parent.location.href = 'http://".site_config_host."/home/sub.php?menukey=".$_POST["menukey"]."&mod=orderResOK&orderno=".$data_orderno."';
		</script>
		");
		exit;

	}else{

		//&&&&PARAMETER EDIT START&&&&
		$CST_PLATFORM               = $_POST["CST_PLATFORM"];                        //LG유플러스 결제 서비스 선택(test:테스트, service:서비스)
		$CST_MID                    = $_POST["CST_MID"];                             //상점아이디(LG유플러스으로 부터 발급받으신 상점아이디를 입력하세요)
																					 //테스트 아이디는 't'를 반드시 제외하고 입력하세요.
		$LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;   //상점아이디(자동생성)
		//$LGD_OID                    = $_POST["LGD_OID"];                             //주문번호(상점정의 유니크한 주문번호를 입력하세요)
		$LGD_OID                    = $data_orderno;								//주문번호(상점정의 유니크한 주문번호를 입력하세요)
		$LGD_AMOUNT                 = $_POST["LGD_AMOUNT"];                          //결제금액("," 를 제외한 결제금액을 입력하세요)
		$LGD_BUYER                  = $_POST["LGD_BUYER"];                           //구매자명
		$LGD_PRODUCTINFO            = $_POST["LGD_PRODUCTINFO"];                     //상품명
		$LGD_BUYEREMAIL             = $_POST["LGD_BUYEREMAIL"];                      //구매자 이메일
		$LGD_TIMESTAMP              = date(YmdHis);                                  //타임스탬프
		$LGD_CUSTOM_USABLEPAY       = $_POST["LGD_CUSTOM_USABLEPAY"];        	     //디폴트 결제수단 (해당 필드를 보내지 않으면 결제수단 선택 UI 가 노출됩니다.)	
		//$LGD_ACTIVEXYN			= "N";											 //계좌이체 결제시 사용, ActiveX 사용 여부로 "N" 이외의 값: ActiveX 환경에서 계좌이체 결제 진행(IE)
		$LGD_CUSTOM_SKIN            = "red";                                         //상점정의 결제창 스킨
		$LGD_WINDOW_VER		        = "2.5";										 //결제창 버젼정보
		
		// 가상계좌(무통장) 결제 연동을 하시는 경우 아래 LGD_CASNOTEURL 을 설정하여 주시기 바랍니다. 
		//$LGD_CASNOTEURL				= "http://".site_config_host.site_pg_dir."/cas_noteurl.php";    
		$LGD_CASNOTEURL				= "https://".site_config_host.site_pg_dir."/cas_noteurl.php";   

		// LGD_RETURNURL 을 설정하여 주시기 바랍니다. 반드시 현재 페이지와 동일한 프로트콜 및  호스트이어야 합니다. 아래 부분을 반드시 수정하십시요.     
		//$LGD_RETURNURL				= "http://".site_config_host.site_pg_dir."/returnurl.php";  
		$LGD_RETURNURL				= "https://".site_config_host.site_pg_dir."/returnurl.php";  

		$configPath                 = $_SERVER['DOCUMENT_ROOT'].site_pg_dir."/lgdacom";                                  //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정.     
		//&&&&PARAMETER EDIT END&&&&
		


		$LGD_CUSTOM_SWITCHINGTYPE   = $_POST["LGD_CUSTOM_SWITCHINGTYPE"];            //신용카드 카드사 인증 페이지 연동 방식 (수정불가)
		$LGD_WINDOW_TYPE            = $_POST["LGD_WINDOW_TYPE"];					 //결제창 호출방식 (수정불가)
		$LGD_OSTYPE_CHECK           = "P";                                           //값 P: XPay 실행(PC 결제 모듈): PC용과 모바일용 모듈은 파라미터 및 프로세스가 다르므로 PC용은 PC 웹브라우저에서 실행 필요. 
																					 //"P", "M" 외의 문자(Null, "" 포함)는 모바일 또는 PC 여부를 체크하지 않음
		$LGD_CUSTOM_PROCESSTYPE     = "TWOTR";                                       //수정불가

		/*
		 *************************************************
		 * 2. MD5 해쉬암호화 (수정하지 마세요) - BEGIN
		 * 
		 * MD5 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
		 *************************************************
		 *
		 * 해쉬 암호화 적용( LGD_MID + LGD_OID + LGD_AMOUNT + LGD_TIMESTAMP + LGD_MERTKEY )
		 * LGD_MID          : 상점아이디
		 * LGD_OID          : 주문번호
		 * LGD_AMOUNT       : 금액
		 * LGD_TIMESTAMP    : 타임스탬프
		 * LGD_MERTKEY      : 상점MertKey (mertkey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실수 있습니다)
		 *
		 * MD5 해쉬데이터 암호화 검증을 위해
		 * LG유플러스에서 발급한 상점키(MertKey)를 환경설정 파일(lgdacom/conf/mall.conf)에 반드시 입력하여 주시기 바랍니다.
		 */ 

		require_once("./lgdacom/XPayClient.php"); 
		$xpay = &new XPayClient($configPath, $CST_PLATFORM); 
		$xpay->Init_TX($LGD_MID);
		$LGD_HASHDATA = md5($LGD_MID.$LGD_OID.$LGD_AMOUNT.$LGD_TIMESTAMP.$xpay->config[$LGD_MID]);
		
		/*
		 *************************************************
		 * 2. MD5 해쉬암호화 (수정하지 마세요) - END
		 *************************************************
		 */

		$payReqMap['CST_PLATFORM']           = $CST_PLATFORM;				// 테스트, 서비스 구분
		$payReqMap['LGD_WINDOW_TYPE']        = $LGD_WINDOW_TYPE;			// 수정불가
		$payReqMap['CST_MID']                = $CST_MID;					// 상점아이디
		$payReqMap['LGD_MID']                = $LGD_MID;					// 상점아이디
		$payReqMap['LGD_OID']                = $LGD_OID;					// 주문번호
		$payReqMap['LGD_BUYER']              = $LGD_BUYER;					// 구매자
		$payReqMap['LGD_PRODUCTINFO']        = $LGD_PRODUCTINFO;			// 상품정보
		$payReqMap['LGD_AMOUNT']             = $LGD_AMOUNT;					// 결제금액
		$payReqMap['LGD_BUYEREMAIL']         = $LGD_BUYEREMAIL;				// 구매자 이메일
		$payReqMap['LGD_CUSTOM_SKIN']        = $LGD_CUSTOM_SKIN;			// 결제창 SKIN
		$payReqMap['LGD_CUSTOM_PROCESSTYPE'] = $LGD_CUSTOM_PROCESSTYPE;		// 트랜잭션 처리방식
		$payReqMap['LGD_TIMESTAMP']          = $LGD_TIMESTAMP;				// 타임스탬프
		$payReqMap['LGD_HASHDATA']           = $LGD_HASHDATA;				// MD5 해쉬암호값
		$payReqMap['LGD_RETURNURL']   		 = $LGD_RETURNURL;				// 응답수신페이지
		$payReqMap['LGD_VERSION']         	 = "PHP_Non-ActiveX_Standard";	// 버전정보 (삭제하지 마세요)
		$payReqMap['LGD_CUSTOM_USABLEPAY']  	= $LGD_CUSTOM_USABLEPAY;	// 디폴트 결제수단
		$payReqMap['LGD_CUSTOM_SWITCHINGTYPE']  = $LGD_CUSTOM_SWITCHINGTYPE;// 신용카드 카드사 인증 페이지 연동 방식
		$payReqMap['LGD_OSTYPE_CHECK']          = $LGD_OSTYPE_CHECK;        // 값 P: XPay 실행(PC용 결제 모듈), PC, 모바일 에서 선택적으로 결제가능 
		//$payReqMap['LGD_ACTIVEXYN']			= $LGD_ACTIVEXYN;			// 계좌이체 결제시 사용,ActiveX 사용 여부
		$payReqMap['LGD_WINDOW_VER'] 			= $LGD_WINDOW_VER;
		$payReqMap['LGD_ENCODING'] 			= "UTF-8";
		
		
		// 가상계좌(무통장) 결제연동을 하시는 경우  할당/입금 결과를 통보받기 위해 반드시 LGD_CASNOTEURL 정보를 LG 유플러스에 전송해야 합니다 .
		$payReqMap['LGD_CASNOTEURL'] = $LGD_CASNOTEURL;               // 가상계좌 NOTEURL

		//Return URL에서 인증 결과 수신 시 셋팅될 파라미터 입니다.*/
		$payReqMap['LGD_RESPCODE']           = "";
		$payReqMap['LGD_RESPMSG']            = "";
		$payReqMap['LGD_PAYKEY']             = "";
		
		$payReqMap['menukey']                = $_POST["menukey"];
		$payReqMap['data_tel']               = $data_tel;
		$payReqMap['data_name']              = urlencode($data_name);


		$_SESSION['PAYREQ_MAP'] = $payReqMap;

		foreach ($payReqMap as $key => $value) {
			echo ("
			<script type='text/javascript'>
				parent.addEelement('".$key."','".$value."');
			</script>
			");
		}
		
		echo ("
		<script type='text/javascript'>
			parent.launchCrossPlatform();	
		</script>
		");
		exit;

	}

?>

