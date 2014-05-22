<?php

class wpcoeway_shared extends wpCheckoutPlugin {

	var $CustomerID;
	var $UserName;
	var $AccessPaymentCode;

	function fetch_data($string, $start_tag, $end_tag) {
		$position = stripos($string, $start_tag);
		$str = substr($string, $position);
		$str_second = substr($str, strlen($start_tag));
		$second_positon = stripos($str_second, $end_tag);
		$str_third = substr($str_second, 0, $second_positon);
		$fetch_data = trim($str_third);
		return $fetch_data;
	}
	
	function get_result() {
		$querystring = "CustomerID=" . $this -> CustomerID . "&UserName=" . $this -> UserName . "&AccessPaymentCode=" . $this -> AccessPaymentCode;
		$posturl = "https://au.ewaygateway.com/Result/?" . $querystring;
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $posturl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		if (CURL_PROXY_REQUIRED == 'True') {
			$proxy_tunnel_flag = (defined('CURL_PROXY_TUNNEL_FLAG') && strtoupper(CURL_PROXY_TUNNEL_FLAG) == 'FALSE') ? false : true;
			curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, $proxy_tunnel_flag);
			curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
			curl_setopt ($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
		}
		
		$result = array();
	
		$response = curl_exec($ch);
		$result['authecode'] = $this -> fetch_data($response, '<authCode>', '</authCode>');
		$result['responsecode'] = $this -> fetch_data($response, '<responsecode>', '</responsecode>');
		$result['retrunamount'] = $this -> fetch_data($response, '<returnamount>', '</returnamount>');
		$result['trxnnumber'] = $this -> fetch_data($response, '<trxnnumber>', '</trxnnumber>');
		$result['trxnstatus'] = $this -> fetch_data($response, '<trxnstatus>', '</trxnstatus>');
		$result['trxnresponsemessage'] = $this -> fetch_data($response, '<trxnresponsemessage>', '</trxnresponsemessage>');
		$result['merchantreference'] = $this -> fetch_data($response, '<merchantreference>', '</merchantreference>');
		$result['merchantinvoice'] = $this -> fetch_data($response, '<merchantinvoice>', '</merchantinvoice>');
		 
		return $result;
	}
	
	function responsecode($code = null) {
		
		$codes = array(
			'00'	=> 	'Transaction Approved',	
			'01'	=> 	'Refer to Issuer', 	
			'02'	=> 	'Refer to Issuer, special', 	
			'03'	=> 	'No Merchant', 	
			'04'	=> 	'Pick Up Card', 	
			'05'	=> 	'Do Not Honour', 	
			'06'	=> 	'Error', 	
			'07'	=> 	'Pick Up Card, Special', 	
			'08'	=> 	'Honour With Identification', 	
			'09'	=> 	'Request In Progress', 	
			'10'	=> 	'Approved For Partial Amount', 	
			'11'	=> 	'Approved, VIP', 	
			'12'	=> 	'Invalid Transaction', 	
			'13'	=> 	'Invalid Amount', 	
			'14'	=> 	'Invalid Card Number', 	
			'15'	=> 	'No Issuer', 	
			'16'	=> 	'Approved, Update Track 3', 	
			'19'	=> 	'Re-enter Last Transaction', 	
			'21'	=> 	'No Action Taken', 	
			'22'	=> 	'Suspected Malfunction', 	
			'23'	=> 	'Unacceptable Transaction Fee', 	
			'25'	=> 	'Unable to Locate Record On File', 	
			'30'	=> 	'Format Error', 	
			'31'	=> 	'Bank Not Supported By Switch', 	
			'33'	=> 	'Expired Card, Capture', 	
			'34'	=> 	'Suspected Fraud, Retain Card', 	
			'35' 	=>	'Card Acceptor, Contact Acquirer, Retain Card', 	
			'36' 	=>	'Restricted Card, Retain Card', 	
			'37' 	=>	'Contact Acquirer Security Department, Retain Card', 	
			'38' 	=>	'PIN Tries Exceeded, Capture', 	
			'39' 	=>	'No Credit Account', 	
			'40' 	=>	'Function Not Supported', 	
			'41' 	=>	'Lost Card', 	
			'42' 	=>	'No Universal Account', 	
			'43' 	=>	'Stolen Card', 	
			'44' 	=>	'No Investment Account', 	
			'51' 	=>	'Insufficient Funds', 	
			'52' 	=>	'No Cheque Account', 	
			'53' 	=>	'No Savings Account', 	
			'54' 	=>	'Expired Card', 	
			'55' 	=>	'Incorrect PIN', 	
			'56' 	=>	'No Card Record', 	
			'57' 	=>	'Function Not Permitted to Cardholder', 	
			'58' 	=>	'Function Not Permitted to Terminal', 	
			'59' 	=>	'Suspected Fraud', 	
			'60' 	=>	'Acceptor Contact Acquirer', 	
			'61' 	=>	'Exceeds Withdrawal Limit', 	
			'62'	=>	'Restricted Card', 	
			'63' 	=>	'Security Violation', 	
			'64' 	=>	'Original Amount Incorrect', 	
			'66' 	=>	'Acceptor Contact Acquirer, Security', 	
			'67' 	=>	'Capture Card', 	
			'75' 	=>	'PIN Tries Exceeded', 	
			'82' 	=>	'CVV Validation Error', 	
			'90' 	=>	'Cutoff In Progress', 	
			'91' 	=>	'Card Issuer Unavailable', 	
			'92' 	=>	'Unable To Route Transaction',
			'93' 	=>	'Cannot Complete, Violation Of The Law',
			'94' 	=>	'Duplicate Transaction',
			'96' 	=>	'System Error',
		);
		
		return $codes[$code]; 
	}
}

?>