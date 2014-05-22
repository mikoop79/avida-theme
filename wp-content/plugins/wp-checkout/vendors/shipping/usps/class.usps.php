<?php

require_once(dirname(__FILE__) . DS . 'xmlparser.php');

class wpcousps extends wpCheckoutPlugin {

    var $server = "";
    var $user = "";
    var $pass = "";
    var $service = "EXPRESS";
    var $dest_zip;
    var $orig_zip;
    var $pounds;
    var $ounces;
    var $container = "None";
    var $size = "REGULAR";
    var $machinable;
    var $country = "USA";
	var $international = false;
	var $services;
	
	function wpcousps() {
		return false;	
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
		global $wpdb, $Order, $wpcoDb, $Item, $wpcoShipmethod;	
		if ($order_id = $Order -> current_order_id()) {
			$wpcoDb -> model = $Order -> model;
			if ($order = $wpcoDb -> find(array('id' => $order_id))) {
				$wpcoDb -> model = $Item -> model;
				$items = $wpcoDb -> find_all(array('order_id' => $order_id));
				
				if (!empty($shipmethod)) {
					$api_options = maybe_unserialize($shipmethod -> api_options);
					$server = ($api_options['usps_test'] == "Y") ? $this -> get_option('usps_testgatewayurl') : $this -> get_option('usps_prodgatewayurl');
					$weight = $Order -> weight($order_id);												
					$pound = floor($weight);
					$ounce = (($weight - $pound) * 16);
					
					$prices = array();
					$usps_services = array();
					
					if (empty($api_options['usps_services'])) {
						$usps_services[0] = "All";	
					} else {
						$usps_services = $api_options['usps_services'];	
					}
					
					if (!empty($usps_services)) {														
						foreach ($usps_services as $usps_servicecode) {																																																										
							$this -> setServer($server);
							$this -> setUserName($api_options['usps_username']);
							$this -> setPass($api_options['usps_password']);
							$this -> setService($usps_servicecode);
							$this -> setDestZip($order -> ship_zipcode);
							$this -> setOrigZip($api_options['usps_originzip']);
							
							if ($api_options['usps_test'] == "N") {
								$this -> setWeight($pound, $ounce);
							} else {
								$this -> setWeight(10, 5);
							}
							
							$this -> firstclassmailtype = $api_options['usps_firstclassmailtype'];
							$this -> setContainer("");
							$this -> setCountry($order -> ship_countryname);
							$this -> setMachinable("true");
							$this -> setSize("REGULAR");
							$this -> getPrice($items);	//get the price for this service
						}
					}
					
					$usps_error = $this -> errors;
					ob_start();
					
					if (!empty($usps_error)) {
						echo '<ul>';
						foreach ($usps_error as $errorkey => $error) {
							echo '<li><span class="' . $this -> pre . 'error">' . $errorkey . ' - ' . stripslashes($error -> description) . '</span></li>';
						}
						echo '</ul>';
					}
					
					$usps_error = ob_get_clean();
					
					$this -> render('usps', array('order' => $order, 'usps_error' => $usps_error, 'international' => $this -> international, 'prices' => $this -> pricelist, 'api_options' => $api_options, 'ajaxquote' => true), true, 'default');
				}
			}
		}
	}
    
    function setServer($server) {
        $this -> server = $server;
    }

    function setUserName($user) {
        $this -> user = $user;
    }

    function setPass($pass) {
        $this -> pass = $pass;
    }

    function setService($service) {
        /* Must be: Express, Priority, or Parcel */
        $this -> service = $service;
    }
    
    function setDestZip($sending_zip) {
        /* Must be 5 digit zip (No extension) */
        $this -> dest_zip = $sending_zip;
    }

    function setOrigZip($orig_zip) {
        $this -> orig_zip = $orig_zip;
    }

    function setWeight($pounds = "0", $ounces = "0") {
        /* Must weight less than 70 lbs. */
        $this -> pounds = $pounds;
        $this -> ounces = $ounces;
    }

    function setContainer($cont) {
        $this -> container = $cont;
    }

    function setSize($size) {
        $this -> size = $size;
    }

    function setMachinable($mach) {
        /* Required for Parcel Post only, set to True or False */
        $this -> machinable = $mach;
    }
    
    function setCountry($country) {
        $this -> country = $country;
    }
    
    function getPrice($items = null) {
    	global $wpdb, $wpcoDb, $Product, $Order, $Item;
    	
    	$order_id = $Order -> current_order_id();
    
        if ($this -> country == "USA" || $this -> country == "United States"){
			$this -> international = false;
						
            // may need to urlencode xml portion
            $str = $this -> server. "?API=RateV4&XML=";
			$str .= "<RateV4Request%20USERID=\"";
            $str .= $this -> user . "\"%20PASSWORD=\"" . $this -> pass . "\">";
			
			//if (!empty($items)) {
				$p = 0;
				
				//foreach ($items as $item) {
					$str .= '<Package%20ID="' . $p . '">';
					$str .= "<Service>" . urlencode($this -> service) . "</Service>";
					
					if (!empty($this -> service) && 
						$this -> service == "FIRST CLASS" ||
						$this -> service == "FIRST CLASS COMMERCIAL" ||
						$this -> service == "FIRST CLASS HFP COMMERCIAL") {
						$str .= "<FirstClassMailType>" . $this -> firstclassmailtype . "</FirstClassMailType>";	
					}
					
					$str .= "<ZipOrigination>" . $this -> orig_zip . "</ZipOrigination>";
					$str .= "<ZipDestination>" . $this -> dest_zip . "</ZipDestination>";					
					$str .= "<Pounds>" . urlencode($this -> pounds) . "</Pounds>";
					$str .= "<Ounces>" . urlencode($this -> ounces) . "</Ounces>";
					$str .= "<Container>" . urlencode($this -> container) . "</Container>";
					$str .= "<Size>" . $this -> size . "</Size>";
					//if (!empty($item[0] -> product -> width)) { $str .= '<Width>' . $item[0] -> product -> width . '</Width>'; }
					//if (!empty($item[0] -> product -> length)) { $str .= '<Length>' . $item[0] -> product -> length . '</Length>'; }
					//if (!empty($item[0] -> product -> height)) { $str .= '<Height>' . $item[0] -> product -> height . '</Height>'; }
					$str .= "<Machinable>" . $this -> machinable . "</Machinable>";
					$str .= "</Package>";
					
					$p++;
				//}
			//}
			
			$str .= "</RateV4Request>";
        } else {
			$this -> international = true;
			
            $str = $this -> server. "?API=IntlRateV2&XML=<IntlRateV2Request%20USERID=\"";
            $str .= $this -> user . "\"%20PASSWORD=\"" . $this -> pass . "\">";
            $str .= '<Revision>2</Revision>';
            
            $p = 0;
            
            //foreach ($items as $item) {
            	//$weight = $item -> product -> weight;
            	//$weight = $Order -> 
            	//$pound = floor($weight);
				//$ounce = (($weight - $pound) * 16);
				//$mailtype = (empty($item -> product -> usps_mailtype)) ? 'Package' : $item -> product -> usps_mailtype;
				$mailtype = 'Package';
				//$valueofcontents = ($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count);
				$valueofcontents = $Order -> total($order_id, true, true);
				//$width = round($item -> product -> width);
				//$length = round($item -> product -> length);
				//$height = round($item -> product -> height);
				//$girth = round($item -> product -> width);
				$width = 0;
				$length = 0;
				$height = 0;
				$girth = 0;
            
            	$str .= '<Package%20ID="' . urlencode($p) . '">';
            	$str .= '<Pounds>' . urlencode($this -> pounds) . '</Pounds>';
            	$str .= '<Ounces>' . urlencode($this -> ounces) . '</Ounces>';
            	$str .= '<Machinable>true</Machinable>';
            	$str .= '<MailType>' . urlencode($mailtype) . '</MailType>';
            	$str .= '<ValueOfContents>' . urlencode($valueofcontents) . '</ValueOfContents>';
            	$str .= '<Country>' . urlencode($this -> country) . '</Country>';
            	$str .= '<Container></Container>';
            	$str .= '<Size>REGULAR</Size>';
            	$str .= '<Width>' . urlencode($width) . '</Width>';
            	$str .= '<Length>' . urlencode($length) . '</Length>';
            	$str .= '<Height>' . urlencode($height) . '</Height>';
            	$str .= '<Girth>' . urlencode($girth) . '</Girth>';
            	$str .= '<OriginZip>' . urlencode($this -> orig_zip) . '</OriginZip>';
            	$str .= '<CommercialFlag>N</CommercialFlag>';
            	$str .= '</Package>';
            	
            	$p++;
            //}
            
			$str .= "</IntlRateV2Request>";
        }
        
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $str);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // grab URL and pass it to the browser
        $ats = curl_exec($ch);

        // close curl resource, and free up system resources
        curl_close($ch);
        $xmlParser = new usps_xmlparser();
        $array = $xmlParser -> GetXMLTree($ats);
		
        if(count($array['ERROR'])) { // If it is error
            $error = new error();
            $error -> number = $array['ERROR'][0]['NUMBER'][0]['VALUE'];
            $error -> source = $array['ERROR'][0]['SOURCE'][0]['VALUE'];
            $error -> description = $array['ERROR'][0]['DESCRIPTION'][0]['VALUE'];
            $error -> helpcontext = $array['ERROR'][0]['HELPCONTEXT'][0]['VALUE'];
            $error -> helpfile = $array['ERROR'][0]['HELPFILE'][0]['VALUE'];
            $this -> error = $error;
			$this -> errors[$this -> service] = $error;
        } else if(count($array['RATEV4RESPONSE'][0]['PACKAGE'][0]['ERROR'])) {
            $error = new error();
            $error -> number = $array['RATEV4RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['NUMBER'][0]['VALUE'];
            $error -> source = $array['RATEV4RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['SOURCE'][0]['VALUE'];
            $error -> description = $array['RATEV4RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['DESCRIPTION'][0]['VALUE'];
            $error -> helpcontext = $array['RATEV4RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['HELPCONTEXT'][0]['VALUE'];
            $error -> helpfile = $array['RATEV4RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['HELPFILE'][0]['VALUE'];
            $this -> error = $error;
			$this -> errors[$this -> service] = $error;        
        } else if(count($array['INTLRATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'])){ //if it is international shipping error
            $error = new error($array['INTLRATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR']);
            $error -> number = $array['INTLRATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['NUMBER'][0]['VALUE'];
            $error -> source = $array['INTLRATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['SOURCE'][0]['VALUE'];
            $error -> description = $array['INTLRATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['DESCRIPTION'][0]['VALUE'];
            $error -> helpcontext = $array['INTLRATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['HELPCONTEXT'][0]['VALUE'];
            $error -> helpfile = $array['INTLRATEV2RESPONSE'][0]['PACKAGE'][0]['ERROR'][0]['HELPFILE'][0]['VALUE'];
            $this -> error = $error;
			$this -> errors[$this -> service] = $error;
        } else if(count($array['RATEV4RESPONSE'])){ // if everything OK
            //print_r($array['RATEV4RESPONSE']);
            $this -> zone = $array['RATEV4RESPONSE'][0]['PACKAGE'][0]['ZONE'][0]['VALUE'];
            foreach ($array['RATEV4RESPONSE'][0]['PACKAGE'][0]['POSTAGE'] as $value){
                $price = new price();
                $price -> mailservice = $value['MAILSERVICE'][0]['VALUE'];
                $price -> rate = $value['RATE'][0]['VALUE'];
                $this -> pricelist[] = $price;
            }
        } else if (count($array['INTLRATEV2RESPONSE'][0]['PACKAGE'][0]['SERVICE'])) { // if it is international shipping and it is OK
            foreach($array['INTLRATEV2RESPONSE'][0]['PACKAGE'][0]['SERVICE'] as $value) {
                $price = new intPrice();
                $price -> id = $value['ATTRIBUTES']['ID'];
                $price -> pounds = $value['POUNDS'][0]['VALUE'];
                $price -> ounces = $value['OUNCES'][0]['VALUE'];
                $price -> mailtype = $value['MAILTYPE'][0]['VALUE'];
                $price -> country = $value['COUNTRY'][0]['VALUE'];
                $price -> rate = $value['POSTAGE'][0]['VALUE'];
                $price -> svccommitments = $value['SVCCOMMITMENTS'][0]['VALUE'];
                $price -> svcdescription = $value['SVCDESCRIPTION'][0]['VALUE'];
                $price -> maxdimensions = $value['MAXDIMENSIONS'][0]['VALUE'];
                $price -> maxweight = $value['MAXWEIGHT'][0]['VALUE'];
                $this -> pricelist[] = $price;
            }
        }
        
        return $this;
    }
}

class error {
    var $number;
    var $source;
    var $description;
    var $helpcontext;
    var $helpfile;
}

class price {
    var $mailservice;
    var $rate;
}

class intPrice {
    var $id;
    var $rate;
}

?>