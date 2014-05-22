<?php

class wpcofedex extends wpCheckoutPlugin {
	
	function wpcofedex() {
		return;
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
		global $wpdb, $wpcoDb, $wpcoShipmethod, $Order, $Item;
		$order_id = $Order -> current_order_id();
		
		if (!empty($shipmethod)) {
			$wpcoDb -> model = $Order -> model;		
			if ($order = $wpcoDb -> find(array('id' => $order_id))) {
				$this -> order = $order;
				$api_options = maybe_unserialize($shipmethod -> api_options);
				$this -> api_options = $api_options;
				
				if (empty($api_options['FedExServer']) || (!empty($api_options['FedExServer']) && $api_options['FedExServer'] == "beta")) {
					$path_to_wsdl = $this -> plugin_base() . DS . 'vendors' . DS . 'shipping' . DS . 'fedex' . DS . 'RateService_v10.wsdl';
				} else {
					$path_to_wsdl = $this -> plugin_base() . DS . 'vendors' . DS . 'shipping' . DS . 'fedex' . DS . 'RateService_v10_live.wsdl';
				}
					
				ini_set("soap.wsdl_cache_enabled", "0");
				$client = new SoapClient($path_to_wsdl, array('trace' => 1));				
				$request = array();
				$request['WebAuthenticationDetail'] = array('UserCredential' => array('Key' => $api_options['fedex_key'], 'Password' => $api_options['fedex_password']));
				$request['ClientDetail'] = array('AccountNumber' => $api_options['fedex_account'], 'MeterNumber' => $api_options['fedex_meter']);
				$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request v10 using PHP ***');
				$request['Version'] = array('ServiceId' => 'crs', 'Major' => '10', 'Intermediate' => '0', 'Minor' => '0');
				$request['ReturnTransitAndCommit'] = true;
				$request['RequestedShipment']['DropoffType'] = $api_options['fedex_dropofftype'];
				$request['RequestedShipment']['ShipTimestamp'] = date('c');
				//$request['RequestedShipment']['ServiceType'] = 'INTERNATIONAL_PRIORITY';
				//$request['RequestedShipment']['PackagingType'] = $api_options['fedex_packagingtype'];
				$request['RequestedShipment']['TotalInsuredValue'] = array('Amount' => $Order -> total($order_id), 'Currency' => $this -> get_option('currency'));
				$request['RequestedShipment']['Shipper'] = $this -> addShipper();
				$request['RequestedShipment']['Recipient'] = $this -> addRecipient();
				$request['RequestedShipment']['ShippingChargesPayment'] = $this -> addShippingChargesPayment();
				$request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
				$request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
				$request['RequestedShipment']['PackageCount'] = '1';
				//$request['RequestedShipment']['RequestedPackageLineItems'] = $this -> addPackageLineItem();
				
				$requestitems = array();
				$wpcoDb -> model = $Item -> model;
				$items = $wpcoDb -> find_all(array('order_id' => $order_id));
				
				if (!empty($items)) {
					foreach ($items as $item) {
						$requestitems[] = $this -> addPackageLineItem($item);
					}
				}
				
				$request['RequestedShipment']['RequestedPackageLineItems'] = $requestitems;
				
				try {
					if ($this -> setEndpoint('changeEndpoint')) {
						$newLocation = $client -> __setLocation($this -> setEndpoint('endpoint'));
					}
				
					$response = $client -> getRates($request);
				
					if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR') {  	
				    	$rateReply = $response -> RateReplyDetails;

						if (!empty($api_options['Service'])) {				    	
					    	foreach ($rateReply as $rate_key => $rate) {
						    	if (!in_array($rate -> ServiceType, $api_options['Service'])) {
							    	unset($rateReply[$rate_key]);
						    	}
					    	}
					    }
					    
					    $prices = $rateReply;
					    $this -> render('fedex', array('order' => $order, 'prices' => $prices, 'ajaxquote' => true), true, 'default');
				    } else {
					   $this -> printError($client, $response); 
				    }
				} catch (SoapFault $exception) {
					$this -> printFault($exception, $client);        
				}
			}
		}
	}
	
	function printSuccess($client, $response) {
	    echo '<h2>Transaction Successful</h2>';  
	    echo "\n";
	    $this -> printRequestResponse($client);
	}
	
	function printRequestResponse($client){
		return;
	
		echo '<h2>Request</h2>' . "\n";
		echo '<pre>' . htmlspecialchars($client -> __getLastRequest()). '</pre>';  
		echo "\n";
	   
		echo '<h2>Response</h2>'. "\n";
		echo '<pre>' . htmlspecialchars($client -> __getLastResponse()). '</pre>';
		echo "\n";
	}
	
	function printNotifications($notes){
		foreach($notes as $noteKey => $note){
			if(is_string($note)){    
	            echo $noteKey . ': ' . $note . '<br/>';;
	        }
	        else{
	        	$this -> printNotifications($note);
	        }
		}
		echo '<br/>';
	}
	
	function printError($client, $response){
	    echo '<h2>Error returned in processing transaction</h2>';
		echo "\n";
		$this -> printNotifications($response -> Notifications);
	    $this -> printRequestResponse($client, $response);
	}
	
	function printFault($exception, $client) {	    
	    echo '<h3>' . __('An error occurred', $this -> plugin_name) . '</h3>';
	    echo '<p>' . $exception -> faultstring . ' (' . $exception -> faultcode . ')</p>';
	}
	
	function setEndpoint($var){
		if($var == 'changeEndpoint') Return false;
		if($var == 'endpoint') Return '';
	}
	
	function addShipper() {
		$shipper = array(
			'Contact' 		=> 	array(
				'PersonName' 			=> 	$this -> order -> ship_fname . ' ' . $this -> order -> bill_lname,
				'CompanyName' 			=> 	get_bloginfo('name'),
			),
			'Address' 		=> 	array(
				'StateOrProvinceCode' 	=> $this -> api_options['orig_StateOrProvinceCode'],
				'PostalCode' 			=> $this -> api_options['orig_PostalCode'],
				'CountryCode' 			=> $this -> api_options['orig_CountryCode'],
			)
		);
		
		return $shipper;
	}
	
	function addRecipient(){
		$recipient = array(
			'Contact' 		=> array(
				'PersonName' 			=> $this -> order -> ship_fname . ' ' . $this -> order -> ship_lname,
				'CompanyName' 			=> $this -> order -> ship_company,
				'PhoneNumber' 			=> $this -> order -> ship_phone
			),
			'Address' => array(
				'StreetLines' => array($this -> order -> ship_address, $this -> order -> ship_address2),
				'City' => $this -> order -> ship_city,
				//'StateOrProvinceCode' => 'BC',
				'PostalCode' => $this -> order -> ship_zipcode,
				'CountryCode' => $this -> order -> ship_countrycode,
				'Residential' => true)
		);
		return $recipient;	                                    
	}
	
	function addShippingChargesPayment(){
		$shippingChargesPayment = array(
			'PaymentType' => 'SENDER',
			'Payor' => array(
				'AccountNumber' => $this -> api_options['fedex_account'],
				'CountryCode' => $this -> api_options['orig_CountryCode'])
		);
		return $shippingChargesPayment;
	}
	
	function addPackageLineItem($item = null){
		if (!empty($item)) {
			$packageLineItem = array(
				'SequenceNumber'				=>	1,
				'GroupPackageCount'				=>	1,
				'Weight' 			=> 	array(
					'Value' 			=> 	($item -> product -> weight * $item -> count),
					'Units' 			=> 	strtoupper($this -> get_option('weightm')),
				)
			);
			
			if (!empty($item -> product -> length)) { $packageLineItem['Dimensions']['Length'] = $item -> product -> length; }
			if (!empty($item -> product -> width)) { $packageLineItem['Dimensions']['Width'] = $item -> product -> width; }
			if (!empty($item -> product -> height)) { $packageLineItem['Dimensions']['Height'] = $item -> product -> height; }
			if (!empty($item -> product -> lengthmeasurement)) { $packageLineItem['Dimensions']['Units'] = strtoupper($item -> product -> lengthmeasurement); }
			
			return $packageLineItem;
		}
	}
}

?>