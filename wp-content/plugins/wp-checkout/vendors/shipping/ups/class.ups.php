<?php

class wpcoups extends wpCheckoutPlugin {

	var $version				= '1.0';
	var $debug 					= true;
	var $ups_access_key			= UPS_ACCESSKEY;
	var $ups_user_id			= UPS_USERID;
	var $ups_password			= UPS_PASSWORD;
	var $default_rate;
	var $pickup_type			= '01';
	var $package_type 			= '02';
	var $request_type;
	var $weight_type			= 'LBS';	
	var $from_state;
	var $from_zip;
	var $from_country			= 'US';
	var $ship_state;        
	var $ship_zip;
	var $ship_country			= 'US';
	var $currency_type			= '$';
	var $form_name 				= 'shipping_methods';
	var $select_class			= '';
	var $pickup					= true;
	var $pickup_cost			= '0.00';
	var $service 				= '';
	var $residential 			= true;
	var $weight 				= 1;
	var $subtotal 				= 1.00;
	var $rates					= array();
	
	function wpcoups() {
		return true;	
	}
	
	function savemethod($cu_prices = null, $cu_shipmethod = null) {
		global $Order, $wpdb, $wpcoDb, $wpcoShipmethod, $user_ID, $wpcoHtml;
	
		if (!empty($cu_shipmethod)) {							
			if ($order_id = $Order -> current_order_id()) {
				$wpcoDb -> model = $Order -> model;
				if ($order = $wpcoDb -> find(array('id' => $order_id))) {
					$wpcoDb -> model = $wpcoShipmethod -> model;
					if ($shipmethod = $wpcoDb -> find(array('id' => $order -> shipmethod_id))) {	
						$wpcoDb -> model = $Order -> model;
						$wpcoDb -> save_field('cu_shipmethod', $cu_shipmethod, array('id' => $order_id));
						if ($user_ID) { update_user_meta($user_ID, 'cu_shipmethod', $cu_shipmethod); }						
						$shipping = $cu_prices[$cu_shipmethod];
						$shipmethod_name = $wpcoHtml -> shipmethod_name($shipmethod -> id, $order_id);						
						$wpcoDb -> model = $Order -> model;	 $wpcoDb -> save_field('api_shipping', $shipping, array('id' => $order_id));	
						$wpcoDb -> model = $Order -> model;	 $wpcoDb -> save_field('shipmethod_name', $shipmethod_name, array('id' => $order_id));							
						$cp_saved = true;							
						return $shipping;
					}
				}
			}
		}
		
		return false;
	}
	
	function shipmethod($shipmethod = null) {
		global $user_ID, $wpdb, $wpcoHtml, $wpcoDb, $Order, $Country, $Item, $wpcoShipmethod;							
		if ($order_id = $Order -> current_order_id()) {
			$wpcoDb -> model = $Order -> model;			
			if ($order = $wpcoDb -> find(array('id' => $order_id))) {
				$wpcoDb -> model = $wpcoShipmethod -> model;				
				if (!empty($shipmethod)) {
					$weight = $Order -> weight($order_id);
					if ($weight < 1) { $weight = 1; }
					$api_options = maybe_unserialize($shipmethod -> api_options);					
					$this -> ups_access_key = $api_options['ups_accesskey'];
					$this -> ups_user_id = $api_options['ups_userid'];
					$this -> ups_password = $api_options['ups_password'];
					$this -> pickup_type = $api_options['ups_pickuptype'];
					$this -> weight_type = $api_options['ups_weighttype'];
					$this -> weight = $weight;
					$this -> from_state = $api_options['ups_fromstate'];
					$this -> from_zip = $api_options['ups_fromzip'];
					$this -> from_country = $api_options['ups_fromcountry'];
					$this -> ship_zip = $order -> ship_zipcode;
					$this -> ship_country = $order -> ship_countrycode;					
					$this -> residential = true;
					$this -> services($api_options);
					$ups_options = $this -> fetch_rates();
					$ups_error = $this -> get_errors();
					
					$this -> render('shipping' . DS . 'ups', array('order' => $order, 'ups_error' => $ups_error, 'prices' => $ups_options, 'ajaxquote' => true), true, 'default');
				}
			}
		}
	}
	
	function check_settings() {
		// Checking UPS Account Information
		if ($this -> ups_access_key == NULL && $this -> ups_access_key == '') $error_msg = 'You did not specify a UPS Access Key<br>';
		if ($this -> ups_user_id == NULL && $this -> ups_user_id == '') $error_msg .= 'You did not specify a UPS User ID<br>';
		if ($this -> ups_password == NULL && $this->ups_password == '') $error_msg .= 'You did not specify a UPS Access Key<br>';
		
		// Checking Ship From & Ship To Information
		if ($this -> from_state == NULL && $this -> from_state == '') $error_msg .= 'You did not enter a ship from state location<br>';
		if ($this -> from_zip == NULL && $this->from_zip == '') $error_msg .= 'You did not enter a ship from zip location<br>';
		if ($this -> from_country == NULL && $this->from_country == '') $error_msg .= 'You did not enter a ship from country location<br>';
		
		if ($this -> ship_zip == NULL && $this->ship_zip == '') $error_msg .= 'You did not enter a ship to zip location<br>';
		if ($this -> ship_country == NULL && $this->ship_country == '') $error_msg .= 'You did not enter a ship to country location<br>';
		
		// If you have the above variable $debug = true, then the script will halt on any errors and display what error occured, you can switch off this option if you want by setting $debug to false.
		if ($this -> debug == true && $error_msg != NULL) exit('<strong>UPS Rates - Version '.$this->version.'</strong><br><br>' . $error_msg);
	
	}
	
	function get_errors() {
		$error = $this -> check_settings();
		return $error;	
	}
	
	function services($api_options = null) {
		if (!empty($api_options['ups_services'])) {
			$this -> services = $api_options['ups_services'];
			return $api_options['ups_services'];
		}
		
		return false;
	}
	
	function service_codes($code = null, $all = false) {		
		$service_codes = array(
			'14' 	=>  __('Next Day Air Early AM', $this -> plugin_name),
			'01' 	=> 	__('Next Day Air', $this -> plugin_name),
			'13' 	=> 	__('Next Day Air Saver', $this -> plugin_name),
			'59' 	=> 	__('2nd Day Air AM', $this -> plugin_name),
			'02' 	=> 	__('2nd Day Air', $this -> plugin_name),
			'12' 	=> 	__('3 Day Select', $this -> plugin_name),
			'03' 	=> 	__('Ground', $this -> plugin_name),
			'11' 	=> 	__('Standard', $this -> plugin_name),
			'07' 	=> 	__('Worldwide Express', $this -> plugin_name),
			'54' 	=> 	__('Worldwide Express Plus', $this -> plugin_name),
			'08' 	=> 	__('Worldwide Expedited', $this -> plugin_name),
			'65' 	=> 	__('Saver', $this -> plugin_name),
			'82' 	=> 	__('UPS Today Standard', $this -> plugin_name),
			'83' 	=> 	__('UPS Today Dedicated Courier', $this -> plugin_name),
			'84' 	=> 	__('UPS Today Intercity', $this -> plugin_name),
			'85' 	=> 	__('UPS Today Express', $this -> plugin_name),
			'86' 	=> 	__('UPS Today Express Saver', $this -> plugin_name),
			'TDCB' 	=> 	__('Trade Direct Cross Border', $this -> plugin_name),
			'TDA' 	=>	__('Trade Direct Air', $this -> plugin_name),
			'TDO' 	=>	__('Trade Direct Ocean', $this -> plugin_name),
		);
			
		if (!empty($code)) {					
			return $service_codes[$code];
		}
		
		if ($all == true) {
			return $service_codes;
		}
		
		return false;
	}
	
	function fetch_rates() {
		$this -> check_settings();
		
		if ($this -> residential == true) $residential_address = '1';
		
		// Attach UPS XML
		require_once($this -> plugin_base() . DS . 'vendors' . DS . 'shipping' . DS . 'ups' . DS . 'rates.php');
		$url = 'https://onlinetools.ups.com/ups.app/xml/Rate';
		
		$ch = curl_init(); 
    	curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
	    curl_setopt ($ch, CURLOPT_POST, 1);
    	curl_setopt ($ch, CURLOPT_POSTFIELDS, $xml_data);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    	curl_setopt ($ch, CURLOPT_TIMEOUT, 10); 
        $data = curl_exec ($ch);
	    curl_close ($ch);
    	
    	$xml = simplexml_load_string($data);
    	$status = $xml -> Response -> ResponseStatusCode;
		$options = array();
    	
    	if ($status == '1') {    	
    		$service_rates = array();
    	
    		foreach ($xml -> RatedShipment as $rate) {
	    		if (empty($this -> services) || (!empty($this -> services) && in_array($rate -> Service -> Code, $this -> services))) {
	    			$service_code = strval($rate -> Service -> Code);
	    			$service_cost = strval($rate -> TotalCharges -> MonetaryValue);
	    			$service_desc = $this -> service_codes($service_code);
	    		
		    		$service_rates[] = array(
		    			'code'			=>	$service_code,
		    			'cost'			=>	$service_cost,
		    			'description'	=>	$service_desc,
		    		);
	    		}
    		}
    		
    		$this -> rates = $service_rates;    	
    		return $this -> rates;
    	} else {
    		if ($this -> debug == true) exit('UPS returned this error: "<strong>'.$xml->Response->Error->ErrorDescription.'</strong>"');
    	}
	}
}

?>