<?php

class wpcoGoogleCheckout extends wpCheckoutPlugin {

	var $url = '';
	var $merchant_id = '';
	var $merchant_key = '';
	var $auth_headers = array();
	var $post_args = '';
	var $enter = "\r\n";
	var $denter = "\r\n\r\n";

	function wpcoGoogleCheckout() {		
		$this -> merchant_id = $this -> get_option('gc_merchant_id');
		$this -> merchant_key = $this -> get_option('gc_merchant_key');
		
		$this -> url = ($this -> get_option('gc_sandbox') && $this -> get_option('gc_sandbox') == "Y") ? $this -> get_option('gcsss') : $this -> get_option('gcssl');
		$this -> url .= $this -> merchant_id;
	
		return true;
	}
	
	function auth_headers() {
		$this -> auth_headers = array();
	
		$this -> auth_headers[] = "Authorization: Basic " . base64_encode($this -> merchant_id . ':' . $this -> merchant_key) . "";
		$this -> auth_headers[] = "Content-Type: application/xml; charset=UTF-8";
		$this -> auth_headers[] = "Accept: application/xml; charset=UTF-8";
		
		return $this -> auth_headers;
	}
	
	function send_request() {
		//initialize CURL handle.
		$ch = curl_init($this -> url);
		
		curl_setopt($ch, CURLOPT_URL, $this -> url);
		
		$auth_headers = $this -> auth_headers();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $auth_headers);
		
		curl_setopt($ch, CURLOPT_POST, true);
		
		$post_args = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		$post_args .= $this -> post_args;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_args);
		
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$this -> response = curl_exec($ch);
		return $this -> response;	
	}
	
	function parse_headers($message = '') {	
		$head_end = strpos($message, $this -> denter);
		$headers = $this -> get_headers_x(substr($message, 0, $head_end + strlen($this -> denter)));
		
		if(!is_array($headers) || empty($headers)){
			return null;
		}
		
		if(!preg_match('%[HTTP/\d\.\d] (\d\d\d)%', $headers[0], $status_code)) {
			return null;
		}
		
		switch($status_code[1]) {
			case '200':
				$parsed = $this->parse_headers(substr($message, $head_end + strlen($this -> denter)));
				return is_null($parsed) ? $headers : $parsed;
				break;
			default:
				return $headers;
				break;
		}
	}
	
	function get_headers_x($heads, $format=0) {
	$fp = explode($this -> enter, $heads);
	foreach($fp as $header){
	if($header == "") {
	$eoheader = true;
	break;
	} else {
	$header = trim($header);
	}
	
	if($format == 1) {
	$key = array_shift(explode(':',$header));
	if($key == $header) {
	$headers[] = $header;
	} else {
	$headers[$key]=substr($header,strlen($key)+2);
	}
	unset($key);
	} else {
	$headers[] = $header;
	}
	}
	return $headers;
	}
	
	function get_body_x($heads = ''){
		$fp = explode($this -> denter, $heads, 2);
		return $fp[1];
	}
}

?>