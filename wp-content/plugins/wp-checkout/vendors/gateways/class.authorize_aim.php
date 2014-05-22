<?php

class wpcoauthorize_aim extends wpCheckoutPlugin {
	var $transaction = array();
	var $message = "";
	var $settings = array();
	var $Response = false;
	var $cards = array("Visa", "MasterCard", "American Express", "Discover", "JCB", "Diner's Club", "EnRoute");

	function wpcoauthorize_aim($order = null) {	
		if (!empty($order)) {
			$this -> build($order);
		}
		
		return false;
	}
	
	function process () {
		$this -> Response = $this -> send();
		if ($this -> Response -> code == 1) return true;
		else return false;
	}
	
	function transactionid () {
		if (!empty($this -> Response)) return $this -> Response -> transactionid;
	}
	
	function error() {
		if (!empty($this -> Response)) 
			return new ShoppError($this -> Response -> reason, 'authorize_net_error', SHOPP_TRXN_ERR,
				array('code' => $this -> Response -> reasoncode));
	}
	
	function build($order = null) {
		//global variables
		global $wpcoDb, $Country, $Product, $Order, $Item;
		
		//user data
		if (!empty($order -> user_id)) { $user = $this -> userdata($order -> user_id); }
		$wpcoDb -> model = $Country -> model;
		$bill_country = $wpcoDb -> field('value', array('id' => $order -> bill_country));
		$ship_country = $wpcoDb -> field('value', array('id' => $order -> ship_country));
		
		//order data Array
		$_ = array();

		// Options
		$_['x_test_request']		= ($this -> get_option('authorize_aim_test') == "Y") ? "TRUE" : "FALSE"; // Set "TRUE" while testing
		$_['x_login'] 				= $this -> get_option('authorize_aim_login');
		$_['x_tran_key'] 			= $this -> get_option('authorize_aim_trankey');
		$_['x_delim_data'] 			= "TRUE"; 
		$_['x_delim_char'] 			= "|"; 
		$_['x_encap_char'] 			= ""; 
		$_['x_version'] 			= "3.1";
		$_['x_relay_response']		= "FALSE";
		$_['x_type'] 				= "AUTH_CAPTURE";
		$_['x_method']				= "CC";
		$_['x_email_customer']		= "FALSE";
		$_['x_merchant_email']		= $this -> get_option('merchantemail');
		
		// Required Fields
		$_['x_trans_id']			= $order -> id;
		$_['x_invoice_num']			= $order -> id;
		$_['x_description']			= get_bloginfo('name');
		$_['x_amount']				= $Order -> total($order -> id, true, true, true, true);
		$_['x_customer_ip']			= $_SERVER["REMOTE_ADDR"];
		//$_['x_fp_sequence']			= $Order->Cart;
		$_['x_fp_timestamp']		= time();
		// $_['x_fp_hash']				= hash_hmac("md5","{$_['x_login']}^{$_['x_fp_sequence']}^{$_['x_fp_timestamp']}^{$_['x_amount']}",$_['x_password']);
		
		// Customer Contact
		$_['x_cust_id']				= (!empty($user) ? $user -> ID : 1);
		$_['x_first_name']			= $order -> bill_fname;
		$_['x_last_name']			= $order -> bill_lname;
		$_['x_email']				= $order -> bill_email;
		$_['x_phone']				= $order -> bill_phone;
		
		// Billing
		$_['x_card_num']			= $order -> cc_number;
		//$_['x_exp_date']			= date("mY", strtotime($order -> cc_exp_m . $order -> cc_exp_y));
		$_['x_exp_date']			= $order -> cc_exp_m . "" . $order -> cc_exp_y;
		$_['x_card_code']			= $order -> cc_cvv;
		$_['x_address']				= $order -> bill_address;
		$_['x_city']				= $order -> bill_city;
		$_['x_state']				= $order -> bill_state;
		$_['x_zip']					= $order -> bill_zipcode;
		$_['x_country']				= $bill_country;
		
		// Shipping
		$_['x_ship_to_first_name']  = $order -> ship_fname;
		$_['x_ship_to_last_name']	= $order -> ship_lname;
		$_['x_ship_to_address']		= $order -> ship_address;
		$_['x_ship_to_city']		= $order -> ship_city;
		$_['x_ship_to_state']		= $order -> ship_state;
		$_['x_ship_to_zip']			= $order -> ship_zipcode;
		$_['x_ship_to_country']		= $ship_country;
		
		// Line Items
		$wpcoDb -> model = $Item -> model;
		if ($items = $wpcoDb -> find_all(array('order_id' => $order -> id, 'completed' => "Y"))) {		
			$i = 1;
			foreach($items as $item) {
				$_['x_line_item'][] = $item -> id . "<|>" . substr(apply_filters($this -> pre . '_product_title', $item -> product -> title), 0, 31) . "<|>" . substr(strip_tags($item -> product -> description), 0, 255) . "<|>" . number_format($item -> count, 2) . "<|>" . number_format(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true, false, true) * $item -> count), 2, '.', '') . "<|>FALSE";
			}
		}

		$this -> transaction = "";
		foreach($_ as $key => $value) {
			if (is_array($value)) {
				foreach($value as $vitem) {
					if (strlen($this -> transaction) > 0) { $this -> transaction .= "&"; }
					$this -> transaction .= $key . "=" . urlencode($vitem);
				}
			} else {
				if (strlen($this -> transaction) > 0) { $this -> transaction .= "&"; }
				$this -> transaction .= $key . "=" . urlencode($value);
			}
		}
	}
	
	function send() {
		$url = ($this -> get_option('authorize_aim_test') == "Y") ?
		"https://test.authorize.net/gateway/transact.dll" :
		"https://secure.authorize.net/gateway/transact.dll";
	
		$connection = curl_init();
		curl_setopt($connection, CURLOPT_URL, $url);
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($connection, CURLOPT_NOPROGRESS, 1); 
		curl_setopt($connection, CURLOPT_VERBOSE, 1); 
		curl_setopt($connection, CURLOPT_FOLLOWLOCATION,0); 
		curl_setopt($connection, CURLOPT_POST, 1); 
		curl_setopt($connection, CURLOPT_POSTFIELDS, $this -> transaction); 
		curl_setopt($connection, CURLOPT_TIMEOUT, 60); 
		curl_setopt($connection, CURLOPT_USERAGENT, SHOPP_GATEWAY_USERAGENT); 
		curl_setopt($connection, CURLOPT_REFERER, "https://" . $_SERVER['SERVER_NAME']); 
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
		$buffer = curl_exec($connection);
		curl_close($connection);

		$response = $this -> response($buffer);
		return $response;
	}
	
	function response($buffer = null) {
		$_ = new stdClass();

		list($_ -> code,
			 $_ -> subcode,
			 $_ -> reasoncode,
			 $_ -> reasontext,
			 $_ -> authcode,
			 $_ -> avs,
			 $_ -> trans_id,
			 $_ -> invoice_num,
			 $_ -> description,
			 $_ -> amount,
			 $_ -> method,
			 $_ -> type,
			 $_ -> customerid,
			 $_ -> firstname,
			 $_ -> lastname,
			 $_ -> company,
			 $_ -> address,
			 $_ -> city,
			 $_ -> state,
			 $_ -> zip,
			 $_ -> country,
			 $_ -> phone,
			 $_ -> fax,
			 $_ -> email,
			 $_ -> ship_to_first_name,
			 $_ -> ship_to_last_name,
			 $_ -> ship_to_company,
			 $_ -> ship_to_address,
			 $_ -> ship_to_city,
			 $_ -> ship_to_state,
			 $_ -> ship_to_zip,
			 $_ -> ship_to_country,
			 $_ -> tax,
			 $_ -> duty,
			 $_ -> freight,
			 $_ -> taxexempt,
			 $_ -> ponum,
			 $_ -> md5hash,
			 $_ -> cvv2code,
			 $_ -> cvv2response) = explode("|", $buffer);
		return $_;
	}
}

?>