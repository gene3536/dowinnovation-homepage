<?
//library for php 4
include dirname(__FILE__)."/lib/gabia_xmlrpccommon.php";
include dirname(__FILE__)."/lib/xml_helper.php";

class gabiaSmsApi extends XmlRpcCommon
{
	var $api_host = "sms.gabia.com";
	var $api_curl_url = "http://sms.gabia.com/assets/api_upload.php";
	var $user_id = "softss";
	var $user_pw = "softss12!@";
	var $m_szResultXML = "";
	var $m_oResultDom = null;
	var $m_szResultCode = "";
	var $m_szResultMessage = "";
	var $m_szResult = "";
	var $get_count = 0;

	var $m_nBefore = 0;
	var $m_nAfter = 0;
	
	var $success_cnt = 0;
	var $fail_list;

	var $md5_access_token = "";

	var $RESULT_OK = "0000";
	var $CALL_ERROR = -1;

	function gabiaSmsApi($id, $api_key)
	{
		$this->sms_id = $id;
		$this->api_key = $api_key;

		$nonce = $this->gen_nonce();
		$this->md5_access_token = $nonce.md5($nonce.$this->api_key);
	}

	function de_gabiaSmsApi(){
		unset($this->m_szResultXML);
		unset($this->m_oResultDom);
	}

	/*
	 * nonce 생성
	 */
	function gen_nonce(){
		$nonce = '';
		for($i=0; $i<8; $i++){
			$nonce .= dechex(rand(0, 15));
		}
		return $nonce;
	}

	/*SMS 남은 건수 조회*/
	function getSmsCount(){
		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.getSmscount</method>
<params>
</params>
</request>
DOC_XML;

		$nCount = 0;
		if ($this->xml_do($request_xml) == "0000")
		{
			$nCount = $this->get_count;
		}
		return $nCount;
	}
	
	function sms_send($phone, $callback, $msg, $refkey="", $reserve = "0")
	{
		$msg = $this->escape_xml_str($msg);

		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.send</method>
<params>
	<send_type>sms</send_type>
	<ref_key>{$refkey}</ref_key>
	<subject>{$title}</subject>
	<message>{$msg}</message>
	<callback>{$callback}</callback>
	<phone>{$phone}</phone>
	<reserve>{$reserve}</reserve>
</params>
</request>
DOC_XML;
		return $this->xml_do($request_xml);
	}

	function lms_send($phone, $callback, $title="",$msg, $refkey="", $reserve = "0")
	{
		$msg = $this->escape_xml_str($msg);

		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.send</method>
<params>
		<send_type>lms</send_type>
		<ref_key>{$refkey}</ref_key>
		<subject>{$title}</subject>
		<message>{$msg}</message>
		<callback>{$callback}</callback>
		<phone>{$phone}</phone>
		<reserve>{$reserve}</reserve>
</params>
</request>
DOC_XML;

		return $this->xml_do($request_xml);
	}

	function mms_send($phone, $callback, $file_path, $title="",$msg, $refkey="", $reserve = "0")
	{
		$msg = $this->escape_xml_str($msg);
		$params = '';
		$file_cnt = count($file_path);
		for($i=0; $i< count($file_path); $i++){
			if(filesize($file_path[$i]) > 312600 || filesize($file_path[$i]) == 0){
				$this->RESULT_OK = '';
				$this->m_szResultCode = "E015";
				$this->m_szResult = "FILE SIZE OVER";
				return ;
			}
			$fp = fopen($file_path[$i],"r");
			$fr = fread($fp,filesize($file_path[$i]));
			fclose($fp);
			$file_code = base64_encode($fr);

			$params .= "<file_bin_".$i." xmlns:dt='urn:schemas-microsoft-com:datatypes' dt:dt='bin.base64'>".$file_code."</file_bin_".$i.">";
		}

		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.send</method>
<params>
		<send_type>mms</send_type>
		<ref_key>{$refkey}</ref_key>
		<subject>{$title}</subject>
		<message>{$msg}</message>
		<callback>{$callback}</callback>
		<phone>{$phone}</phone>
		<reserve>{$reserve}</reserve>
		<file_cnt>{$file_cnt}</file_cnt>
		{$params}
</params>
</request>
DOC_XML;

		return $this->xml_do($request_xml);
	}

	function get_status_by_ref($refkey)
	{
		if(is_array($refkey))
		{
			$ref_keys = implode(",", $refkey);
		}else
		{
			$ref_keys = $refkey;
		}
		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.getStatusByRef</method>
<params>
	<ref_key>{$ref_keys}</ref_key>
</params>
</request>
DOC_XML;
		if ($this->xml_do($request_xml) == "0000")
		{
			$r = array();
			$resultXML = $this->api_xml_parser($this->m_szResult);
			foreach($resultXML as $n)
			{
				if((string)$n[0] =="NODATA"){
					return array("CODE" => "NODATA", "MESG" =>"NODATA");
				}
				$szKey = (string)$n["SMS_REFKEY"];
				$szCode = (string)$n["CODE"];
				$szMesg = (string)$n["MESG"];

				$r = array("CODE" => $szCode, "MESG" => $szMesg);
			}
			return $r;
		}
		else false;
	}
	
	function getResultCode()
	{
		return $this->m_szResultCode;
	}

	function getResultMessage()
	{
		return $this->m_szResultMessage;
	}

	function getBefore()
	{
		return $this->m_nBefore;
	}

	function getAfter()
	{
		return $this->m_nAfter;
	}


	function multi_sms_send($phone, $callback, $msg, $refkey, $reserve){
		if(!is_array($phone)){
			$this->m_szResultCode = "NOT ARRAY";
			$this->m_szResult = "NOT ARRAY";
			return ;
		}
		$msg = $this->escape_xml_str($msg);

		$multi_phonenum = $this->make_multi_num($phone);

		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.multi_send</method>
<params>
	<send_type>sms</send_type>
	<ref_key>{$refkey}</ref_key>
	<subject>{$title}</subject>
	<message>{$msg}</message>
	<callback>{$callback}</callback>
	<phone>{$multi_phonenum}</phone>
	<reserve>{$reserve}</reserve>
</params>
</request>
DOC_XML;

		return $this->xml_do($request_xml);
	}

	function multi_lms_send($phone, $callback, $title="", $msg, $refkey="", $reserve = "0")
	{
		if(!is_array($phone)){
			$this->m_szResultCode = "NOT ARRAY";
			$this->m_szResult = "NOT ARRAY";
			return ;
		}
		$msg = $this->escape_xml_str($msg);

		$multi_phonenum = $this->make_multi_num($phone);

		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.multi_send</method>
<params>
		<send_type>lms</send_type>
		<ref_key>{$refkey}</ref_key>
		<subject>{$title}</subject>
		<message>{$msg}</message>
		<callback>{$callback}</callback>
		<phone>{$multi_phonenum}</phone>
		<reserve>{$reserve}</reserve>
</params>
</request>
DOC_XML;

		return $this->xml_do($request_xml);
	}


	function multi_mms_send($phone, $callback, $file_path, $title="", $msg, $refkey="", $reserve = "0")
	{
		$msg = $this->escape_xml_str($msg);
		
		if(!is_array($phone)){
			$this->m_szResultCode = "NOT ARRAY";
			$this->m_szResult = "NOT ARRAY";
			return ;
		}
		$multi_phonenum = $this->make_multi_num($phone);
		for($i=0; $i< count($file_path); $i++){
			if(filesize($file_path[$i]) > 312600 || filesize($file_path[$i]) == 0){
				$this->RESULT_OK = '';
				$this->m_szResultCode = "E015";
				$this->m_szResult = "FILE SIZE OVER";
				return ;
			}
			$fp = fopen($file_path[$i],"r");
			$fr = fread($fp,filesize($file_path[$i]));
			fclose($fp);
			$file_code = base64_encode($fr);

			$params .= "<file_bin_".$i." xmlns:dt='urn:schemas-microsoft-com:datatypes' dt:dt='bin.base64'>".$file_code."</file_bin_".$i.">";
		}
		
		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.multi_send</method>
<params>
		<send_type>mms</send_type>
		<ref_key>{$refkey}</ref_key>
		<subject>{$title}</subject>
		<message>{$msg}</message>
		<callback>{$callback}</callback>
		<phone>{$multi_phonenum}</phone>
		<reserve>{$reserve}</reserve>
		<file_cnt>{$file_cnt}</file_cnt>
		{$params}
</params>
</request>
DOC_XML;

		return $this->xml_do($request_xml);
	}

	function make_multi_num($phone){
		$multi_phonenum = "";
		if(is_array($phone)){
			for($i=0; $i < count($phone);$i++){
				if($i+1 == count($phone))$multi_phonenum .= $phone[$i];
				else $multi_phonenum .= "$phone[$i],";
			}
		}
		return $multi_phonenum;
	}

	function get_status_by_ref_all($ref_key){
		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.getStatusByRef_all</method>
<params>
	<ref_key>{$ref_key}</ref_key>
</params>
</request>
DOC_XML;

		if ($this->xml_do($request_xml) == "0000")
		{
			$r = array();
			$resultXML = $this->api_xml_parser($this->m_szResult);

			for($i=0; $i <count($resultXML) ; $i++){
				$r[$i]["PHONE"] = $resultXML[$i]['PHONENUM'];
				$r[$i]["MESG"] = $resultXML[$i]['MESG'];
			}
			if($r[0]["PHONE"] != null){
				return $r;
			}else{
				return false;
			}
		}else return false;
	}

	function getCallbackNum(){
		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.getCallbackNum</method>
</request>
DOC_XML;

		if ($this->xml_do($request_xml) == "0000")
		{
			$r = array();
			$i = 0;
			$resultXML = $this->api_xml_parser($this->m_szResult);
			for($i=0; $i <count($resultXML) ; $i++){
				$r[$i]["callback"] = $resultXML[$i]['callback'];
			}
			if(count($r)>0){
				return $r;
			}
		}

		return false;		
	}

	function get_success_cnt()
	{
		return $this->success_cnt;
	}

	function get_fail_list()
	{
		return $this->fail_list;
	}

	function reservationCancel($refkey, $send_type, $phonenum='')
	{
		$multi_phonenum = '';
		if(is_array($phonenum)){
			$multi_phonenum = $this->make_multi_num($phonenum);	
		}

		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.reservationCancel</method>
<params>
		<send_type>{$send_type}</send_type>
		<ref_key>{$refkey}</ref_key>
		<phonenum>{$multi_phonenum}</phonenum>
</params>
</request>
DOC_XML;

		if ($this->xml_do($request_xml) == "0000")
		{
			$resultXML = $this->api_xml_parser($this->m_szResult);
			if($resultXML[0]['entry'] == true){
				return true;
			}else{
				$this->m_szResultCode = 'E999';
				$this->m_szResultMessage = '알수없는 에러';
				return false;
			}
		}else{
			return false;
		}
	}

	/*
	 * XMLRPC 발송
	 * $xml_data : 발송정보의 XML 데이터
	 */
	function xml_do($xml_data){
		$this->init($this->api_host, "api", "gabiasms");
		$this->m_szResultXML = $this->call($xml_data);

		if($this->m_szResultXML){
			$this->m_oResultDom = $this->api_xml_parser($this->m_szResultXML);
			if(isset($this->m_oResultDom[0]["code"]))
				$this->m_szResultCode = $this->m_oResultDom[0]["code"];
			if(isset($this->m_oResultDom[0]["code"]))
				$this->m_szResultMessage = $this->m_oResultDom[0]["mesg"];
			if (isset($this->m_oResultDom[0]["result"]))
				$this->m_szResult = base64_decode($this->m_oResultDom[0]["result"]);

			$r = strpos($this->m_szResult, "<?xml");
			if($r == 0 && $r !== FALSE){
				$oCountXML = $this->api_xml_parser($this->m_szResult);

				if(isset($oCountXML[0]["item"]))
					$this->get_count = $oCountXML[0]["item"];
				if (isset($oCountXML[0]["BEFORE_SMS_QTY"]))
					$this->m_nBefore = $oCountXML[0]["BEFORE_SMS_QTY"];
				if (isset($oCountXML[0]["AFTER_SMS_QTY"]))
					$this->m_nAfter = $oCountXML[0]["AFTER_SMS_QTY"];
				if(isset($oCountXML[0]["SUCCESS_CNT"]))
					$this->success_cnt = $oCountXML[0]["SUCCESS_CNT"];
				if(isset($oCountXML[0]["FAIL_LIST"]))
					$this->fail_list = $oCountXML[0]["FAIL_LIST"];
					
				unset($oCountXML);
			}else{
				$this->m_szResultCode = $this->getResultCode();
				$this->m_szResult = $this->getRpcError();
			}
		}
		return $this->m_szResultCode;
	}

	/*
	xml => array 변경
	$xml_data : xml_rpc 통신후 받아온 xml 결과값
	*/
	function api_xml_parser($xml_data){
		$rXml = xml_parser_create();    // xml 파서 생성
        $arXml = array();                           // 파싱된 xml을 저장할 임시 배열
 
        // 대문자로 변경 (기본이 enable이라 disable함)
        xml_parser_set_option($rXml, XML_OPTION_CASE_FOLDING, 0);           
        // 공백값 무시.
        xml_parser_set_option($rXml, XML_OPTION_SKIP_WHITE, 1);           
         //  배열에 XML구조 담기.
        xml_parse_into_struct($rXml, $xml_data, $arXml);          
        xml_parser_free($rXml);
 
        // XML tag 각 배열의 원소에 대한 간단한 좌표 0,1,2,3,..식으로.
        $NodeKey = 0; 
        //담고싶은 것만 골라담기  [내용이 들어있는 태그만 분류하기 위해 switch문 사용]                 
        foreach($arXml as $key => $arNode)
        {
           //$arNode['type']) : 보통 내용이 있고 없고, 그 범위의 타입을 지정한다. 
           // 'open', 'complete', 'close'로 나누어짐.
            switch ($arNode['type']){
				case 'open':
					break;
				case 'complete':
					$arXmlAssoc[$NodeKey][$arNode['tag']] = $arNode['value'];
					break;
				case 'close':
					$NodeKey++;  //2중배열로 돌기 때문에 배열의 좌표를 이동~
					break;
             }
        }
		return $arXmlAssoc;
    }


	function escape_xml_str($message){
		$message = str_replace("&", "&amp;",$message);
		$message = str_replace("<", "&lt;",$message);
		$message = str_replace(">", "&gt;",$message);

		return $message;
	}
}
?>
