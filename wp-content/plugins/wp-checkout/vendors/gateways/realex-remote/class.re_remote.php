<?php

class wpcore_remote extends wpCheckoutPlugin {
	
	var $serverurl = "https://epage.payandshop.com/epage-remote.cgi";
	var $dataError;
	var $dataAuth;
	var $dataSecure;
	var $requireRedirect = false;

	function wpcore_remote() {
		return;
	}
	
	function request($re_remote = null, $order = null, $user = null) {
		global $wpcoHtml;

		$amount = $re_remote['amount'];
		$currency = $re_remote['currency'];
		$cardnumber = $re_remote['card_number'];
		$cardname = $re_remote['card_chname'];
		$cardtype = $re_remote['card_type'];
		$expdate = $re_remote['card_expdate'];
		$merchantid = $re_remote['merchantid'];
		$secret = $re_remote['secret'];
		$account = $re_remote['account'];		
		
		//Creates timestamp that is needed to make up orderid
		$timestamp = strftime("%Y%m%d%H%M%S");
		mt_srand((double)microtime() * 1000000);		
		
		//You can use any alphanumeric combination for the orderid.Although each transaction must have a unique orderid.
		$orderid = $timestamp."-".mt_rand(1, 999);
		
		
		// This section of code creates the md5hash that is needed
		$tmp = "$timestamp.$merchantid.$orderid.$amount.$currency.$cardnumber";
		$md5hash = md5($tmp);
		$tmp = "$md5hash.$secret";
		$md5hash = md5($tmp);
		
		//A number of variables are needed to generate the request xml that is send to Realex Payments.
		$request = "<request type='auth' timestamp='$timestamp'>
			<merchantid>$merchantid</merchantid>
			<account>$account</account>
			<orderid>$orderid</orderid>
			<amount currency='$currency'>$amount</amount>
			<card> 
				<number>$cardnumber</number>
				<expdate>$expdate</expdate>
				<type>$cardtype</type> 
				<chname>$cardname</chname> 
			</card> 
			<autosettle flag='1'/>
			<md5hash>$md5hash</md5hash>
			<tssinfo>
				<address type=\"billing\">
					<country>ie</country>
				</address>
			</tssinfo>
		</request>";
		
		if ($ch = curl_init()) {			
			// - then set the cURL options; to ignore SSL invalid certificates; set timeouts etc. 
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
			//curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
			curl_setopt ($ch, CURLOPT_USERAGENT, "payandshop.com php version 0.9");
			//curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "POST");             
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt ($ch, CURLOPT_URL, $this -> serverurl);
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $request);             
			
			// Connect to PayGate PayXML and send data
			$response = curl_exec($ch);			
			$response = eregi_replace("[[:space:]]+", " ", $response);
			$response = eregi_replace("[\n\r]", "", $response);
			
			// Checl for any connection errors and then close the connection.
			$curlerror = curl_errno($ch);
			curl_close($ch);
			
			// If a connection error occurred then quit now.
			if ($curlError) die("cURL Error " . $curlError);
			
			return $response;
		}
		
		return false;
	}
	
	function notify($xml_result = null) {
		$this -> xmlparse = array();
		
		$xmlparser = xml_parser_create();
		//xml_set_element_handler($xmlparser, array($this, "startElement"), array($this, "endElement"));
		//xml_set_character_data_handler($xmlparser, array($this, "char"));
		
		xml_parser_set_option($xmlparser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($xmlparser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($xmlparser, $xml_result, $vals, $index);
		xml_parser_free($xmlparser);
		
		return $this -> buildresult($vals);
	}
	
	function buildresult($vals = null) {
		$resultarray = array();
		
		if (!empty($vals)) {
			foreach ($vals as $val) {
				$resultarray[$val['tag']] = $val['value'];
			}
		}
		
		return $resultarray;
	}
	
	function notify2($rawXML = null) {
		$xml_parser = xml_parser_create();
		xml_set_element_handler($xml_parser, array($this, "startElement"), array($this, "endElement"));
		
		// Read the PayXML response and stop if an unexpected error occurred.
		if (xml_parse($xml_parser, $rawXML)) {
			if ($this -> dataError) {
				return false;
			} elseif ($this -> dataAuth) {
				return true;
			}
		}
		
		// Destroy XML parser
		xml_parser_free($xml_parser);		
		return false;
	}
	
	function startElement($parser, $name, $attrs) {
		global $parentElements;
		global $currentElement;
		global $currentTSSCheck;
		$this -> response[$name] = $attrs;		
		if (empty($parentElements)) { $parentElements = array(); }
		
		array_push($parentElements, $name);
		$currentElement = join("_", $parentElements);
	
		foreach ($attrs as $attr => $value) {
			if ($currentElement == "RESPONSE_TSS_CHECK" and $attr == "ID") {
				$currentTSSCheck = $value;
			}
	
			$attributeName = $currentElement . "_" . $attr;	
			global $$attributeName;
			$$attributeName = $value;
		}	
	}
	
	function cDataHandler($parser, $cdata) {
		global $currentElement;
		global $currentTSSCheck;
		global $TSSChecks;
	
		if ( trim ( $cdata ) ) { 
			if ($currentTSSCheck != 0) {
				$TSSChecks["$currentTSSCheck"] = $cdata;
			}
	
			global $$currentElement;
			$$currentElement .= $cdata;
		}
		
	}
	
	function endElement($parser, $name) {
		global $parentElements;
		global $currentTSSCheck;
	
		$currentTSSCheck = 0;
		array_pop($parentElements);
	}
}

?>