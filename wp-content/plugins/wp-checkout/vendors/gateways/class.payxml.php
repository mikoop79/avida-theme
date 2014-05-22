<?php

class wpcopayxml extends wpCheckoutPlugin {
	
	var $serverurl = "https://www.paygate.co.za/payxml/process.trans";
	var $dataError;
	var $dataAuth;
	var $dataSecure;
	var $requireRedirect = false;

	function wpcopayxml() {
		return;
	}
	
	function request($payxml = null, $order = null, $user = null) {
		global $wpcoHtml;
		
		$request = '';
		$request .= '<?xml version="1.0" encoding="UTF-8" ?>';
		$request .= '<!DOCTYPE protocol SYSTEM "https://www.paygate.co.za/payxml/payxml_v4.dtd">';
		$request .= '<protocol ver="' . $payxml['ver'] . '" pgid="' . $payxml['pgid'] . '" pwd="' . $payxml['pwd'] . '">';
		$request .= '<authtx cref="' . $order -> id . '" ';
		$request .= 'cname="' . $payxml['cname'] . '" ';
		$request .= 'cc="' . $payxml['cc'] . '" ';
		$request .= 'exp="' . $payxml['exp'] . '" ';
		$request .= 'budp="0" ';
		$request .= 'amt="' . preg_replace("/[^0-9]+/", "", $payxml['amt']) . '" ';
		$request .= 'cur="' . $payxml['cur'] . '" ';
		$request .= 'cvv="' . $payxml['cvv'] . '" ';
		$request .= 'email="' . $order -> bill_email . '" ';
		
		if (!empty($payxml['threed']) && $payxml['threed'] == true) {
			$request .= 'nurl="' . htmlentities($wpcoHtml -> retainquery("type=payxml", $wpcoHtml -> return_url())) . '" ';
			$request .= 'rurl="' . htmlentities($wpcoHtml -> retainquery("type=payxml&order_id=" . $order -> id, $wpcoHtml -> success_url())) . '"';	
		}
		
		$request .= '/>';
		$request .= '</protocol>';
		
		$header = array();
		$header[] = "Content-Type: text/xml";
		$header[] = "Content-Length: " . strlen($request) . "\r\n";
		$header[] = $request;
		
		if ($ch = curl_init()) {			
			// - then set the cURL options; to ignore SSL invalid certificates; set timeouts etc. 
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
			curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
			curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "POST");             
			curl_setopt ($ch, CURLOPT_URL, $this -> serverurl);
			curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);             
			
			// Connect to PayGate PayXML and send data
			$Response = curl_exec($ch);
			
			// Checl for any connection errors and then close the connection.
			$curlerror = curl_errno($ch);
			curl_close($ch);
			
			// If a connection error occurred then quit now.
			if ($curlError) die("cURL Error " . $curlError);
			
			// Create XML parser and set element handlers
			$xml_parser = xml_parser_create();
			xml_set_element_handler($xml_parser, array($this, "startElement"), array($this, "endElement"));
			
			// Read the PayGate response and stop if an unexpected error occurred.
			if (!xml_parse($xml_parser, $Response)) {
				die(sprintf("XML error: %s at line %d",
							xml_error_string(xml_get_error_code($xml_parser)),
							xml_get_current_line_number($xml_parser)));
			}
			// Destroy XML parser
			xml_parser_free($xml_parser);
			
			if ($this -> dataError) {
				$this -> requireRedirect = false;
			} elseif ($this -> dataAuth) {
				$this -> requireRedirect = false;
			} elseif ($this -> dataSecure) {
				$this -> requireRedirect = true;
			}
		}
		
		return false;
	}
	
	function notify($rawXML = null) {
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
		if ($name == "ERRORRX") { $this -> dataError = $attrs; };
		if ($name == "AUTHRX") { $this -> dataAuth = $attrs; };
		if ($name == "SECURERX") { $this -> dataSecure = $attrs; };
	}
	
	function endElement($parser, $name) {
		
	}
}

?>