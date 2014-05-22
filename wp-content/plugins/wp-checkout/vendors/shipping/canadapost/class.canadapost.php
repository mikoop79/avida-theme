<?php

class wpcocanadapost extends wpCheckoutPlugin {

	var

		$debug = false ,
		//$server = "206.191.4.228",
		$server = "sellonline.canadapost.ca",
		$port = 30000,
		$merchant_cpcid = "CPC_DEMO_XML",
		$from_postal_code,
		$turn_around_time,
		$error = false,
		$err_msg = "",
		$xml_request = "",
		$xml_response = "",
		$fp,  // socket handle
		$xml_response_tree = array(),
		$shipping_methods = array(),
		$shipping_comment = "" ,
		$to_city = "",
		$to_provState = "",
		$to_country = "",
		$to_postal_code = "";

	function wpcocanadapost() {
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
		global $user_ID, $wpdb, $wpcoHtml, $wpcoDb, $Country, $Order, $Product, $Item, $wpcoShipmethod;

		if ($order_id = $Order -> current_order_id()) {
			$wpcoDb -> model = $Order -> model;
			
			if ($order = $wpcoDb -> find(array('id' => $order_id))) {
				$wpcoDb -> model = $wpcoShipmethod -> model;				
				if (!empty($shipmethod)) {
					$api_options = maybe_unserialize($shipmethod -> api_options);					
					$cp_city = $order -> ship_city;
					$cp_state = $order -> ship_state;
					$cp_country = $wpdb -> get_var("SELECT value FROM " . $wpdb -> prefix . $Country -> table . " WHERE code = '" . $order -> ship_countrycode . "'");
					$cp_zip = $order -> ship_zipcode;
					
					$this -> merchant_cpcid = $api_options['CSCID'];
					$this -> from_postal_code = $api_options['ORIGZIP'];
					$this -> turn_around_time = $api_options['TURNAROUND'];
					$this -> CanadaPost();
					
					$wpcoDb -> model = $Item -> model;
					if ($items = $wpcoDb -> find_all(array('order_id' => $order_id))) {								
						foreach ($items as $item) {
							if ($item -> product -> type == "tangible" && $item -> product -> excludeglobal == "N") {
								$this -> addItem($item -> count, $item -> product -> weight, $item -> product -> width, $item -> product -> length, $item -> product -> height, apply_filters($this -> pre . '_product_title', $item -> product -> title), ((!empty($item -> product -> readytoship) && $item -> product -> readytoship == "Y") ? true : false));
							}
						}
					}
					
					$this -> getQuote($cp_city, $cp_state, $cp_country, $cp_zip);																							
					$this -> render('canadapost', array('order' => $order, 'error' => $this -> error, 'error_msg' => $this -> error_msg, 'cp' => $this, 'shipping_methods' => $this -> shipping_methods, 'ajaxquote' => true), true, 'default');	
				}
			}
		}
		
		return false;	
	}

	function CanadaPost(){
		$this -> _initRequestXML();
	}

	function addItem($quantity = 1, $weight = null, $length = null, $width = null, $height = null, $description = "", $readytoship = false)	{
		$this -> xml_request .= "
		<item>
			<quantity>" . htmlspecialchars($quantity) . "</quantity>";
			
		if (!empty($weight)) { $this -> xml_request .= "<weight>" . htmlspecialchars($weight) . "</weight>"; }
		if (!empty($length)) { $this -> xml_request .= "<length>" . htmlspecialchars($length) . "</length>"; }
		if (!empty($width)) { $this -> xml_request .= "<width>" . htmlspecialchars($width) . "</width>"; }
		if (!empty($height)) { $this -> xml_request .= "<height>" . htmlspecialchars($height) . "</height>"; }
			
		$this -> xml_request .= "<description>" . htmlspecialchars($description) . "</description>";
		if (!empty($readytoship) && $readytoship == true) { $this -> xml_request .= "<readyToShip />"; }
		$this -> xml_request .= "</item>";
	}	

	function getQuote($city, $provstate, $country, $postal_code) {		
		$this -> _shipTo($city, $provstate, $country, $postal_code);
		$this -> _sendRequestXML();
		$this -> _getResponseXML();
		$this -> _xmlToQuote();
	}

	function _initRequestXML(){
		$this -> xml_request = 
		"<?xml version=\"1.0\" ?>
		<eparcel>
			<language>en</language>
			<ratesAndServicesRequest>
				<merchantCPCID>" . $this -> merchant_cpcid . "</merchantCPCID>
				<fromPostalCode>" . $this -> from_postal_code . "</fromPostalCode>
				<turnAroundTime>" . $this -> turn_around_time . "</turnAroundTime>
				<lineItems>" ;
	}

	// if no Postal Code input, Canada Post will return statusCode 5000 and statusMessage "XML parsing error ".
	function _shipTo( $city, $provstate, $country, $postal_code) {
		$this -> to_city = $city ;
		$this -> to_provState = $provstate;
		$this -> to_country = $country ;
		$this -> to_postal_code = $postal_code ;
		$this -> xml_request .= "</lineItems>" .

		(strlen($this -> to_city) > 0  ? "<city>" . htmlspecialchars($this -> to_city) . "</city>\n" : "" ) . 
		(strlen($this -> to_provState) > 0  ? "		<provOrState>" . htmlspecialchars($this -> to_provState) . "</provOrState>\n" : "		<provOrState> </provOrState>\n" ) . 
		(strlen($this -> to_country) > 0  ? "		<country>" . htmlspecialchars($this -> to_country) . "</country>\n" : "" ) . 
		(strlen($this -> to_postal_code) > 0  ? "		<postalCode>" . htmlspecialchars($this -> to_postal_code) . "</postalCode>\n" : "		<postalCode> </postalCode>\n" ) . 

		"</ratesAndServicesRequest></eparcel>";
	}

	function _sendRequestXML() {	
		$this -> fp = fsockopen($this -> server, $this -> port, $errno, $errstr, 10);

		if (!$this -> fp) {
			$this -> error = true ;
			$this -> error_msg = $errstr ;
		} else {
			fwrite($this -> fp, $this -> xml_request);
			stream_set_timeout($this -> fp, 180);
		}	
	}	

	function _getResponseXML(){
		if (!$this -> fp) return;

		while(!feof($this -> fp)) {
			$this -> xml_response .= fgets($this -> fp, 4096);
		}

   		fclose($this -> fp);
	}	

	function _xmlToQuote(){
		require_once(dirname(__FILE__) . DS . 'include.php');
		$startTag = 'eparcel/ratesAndServicesResponse/';
		require_once(dirname(__FILE__) . DS . 'xmlparser.php');
		$xmlParser = new xmlparser();
        $array = $xmlParser -> GetXMLTree($this -> xml_response);
        
        if (!empty($array['EPARCEL'][0]['ERROR'])) {
	        $this -> error = true;
	        $this -> error_msg = $array['EPARCEL'][0]['ERROR'][0]['STATUSMESSAGE'][0]['VALUE'];
        } else {
	        $this -> error = false;
	        $xd = new MiniXMLDoc($this -> xml_response);
	        $startTag = 'eparcel/ratesAndServicesResponse/';
	        $this -> statusCode = fetchValue($xd, $startTag . 'statusCode'); 
	        $this -> statusMessage = fetchValue($xd, $startTag . 'statusMessage');
	        $this -> shipping_comment = fetchValue($xd, $startTag . 'comment') ;
			$shipping_fields = array("name", "rate", "shippingDate", "deliveryDate", "deliveryDayOfWeek",  "nextDayAM", "packingID");
			$this -> shipping_methods = fetchArray($xd, $startTag, 'product', $shipping_fields);
        }
	}
}

?>