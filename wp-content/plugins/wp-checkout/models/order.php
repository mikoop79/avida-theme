<?php

class wpcoOrder extends wpCheckoutPlugin {

	var $model = 'Order';
	var $controller = 'orders';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",				//passthru, creation on demand with $insertid
		'user'				=>	"VARCHAR(50) NOT NULL DEFAULT ''",				//passthru
		'user_id'			=>	"INT(11) NOT NULL DEFAULT '0'",					//selection
		'fromcontacts'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'completed'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",			//selection
		'pmethod'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",				//selection
		'shipmethod_id'		=>	"INT(11) NOT NULL DEFAULT '0'",					//selection
		'cp_shipmethod'		=>	"INT(11) NOT NULL DEFAULT '0'",					//passthru
		'cu_shipmethod'		=>	"TEXT NOT NULL",								//passthru
		'shiptrack'			=>	"TEXT NOT NULL",								//input
		'buynow'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",			//passthru
		'gc_order_id'		=>	"VARCHAR(30) NOT NULL DEFAULT ''",				//passthru
		'transid'			=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'transstatus'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'fname'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",				//convert passthru, comes from "first_name"
		'lname'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",				//convert passthru, comes from "last_name"
		'email'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",				//convert passthru, comes from "user_email"
		'euvatnumber'		=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'ship_fname'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",				
		'ship_lname'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'ship_email'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'ship_company'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'ship_phone'		=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'ship_fax'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'ship_address'		=>	"TEXT NOT NULL",
		'ship_address2'		=>	"TEXT NOT NULL",
		'ship_city'			=>	"TEXT NOT NULL",
		'ship_state'		=>	"TEXT NOT NULL",
		'ship_country'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'ship_zipcode'		=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'bill_fname'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'bill_lname'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'bill_email'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'bill_company'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'bill_phone'		=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'bill_fax'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'bill_address'		=>	"TEXT NOT NULL",
		'bill_address2'		=>	"TEXT NOT NULL",
		'bill_city'			=>	"TEXT NOT NULL",
		'bill_state'		=>	"TEXT NOT NULL",
		'bill_country'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'bill_zipcode'		=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'cc_name'			=>	"VARCHAR(255) NOT NULL DEFAULT ''",
		'cc_type'			=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'cc_number'			=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'cc_exp_m'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'cc_exp_y'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'cc_cvv'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'billsameasship'	=>	"ENUM('Y','N') NOT NULL DEFAULT 'Y'",
		'api_shipping'		=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'shipping'			=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'shipmethod_name'	=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'discount'			=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'tax'				=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'tax_percentage'	=>	"VARCHAR(10) NOT NULL DEFAULT ''",
		'subtotal'			=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'total'				=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'status'			=>	"VARCHAR(100) NOT NULL DEFAULT 'uncompleted'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'completed_date'	=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'user'				=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'user_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'fromcontacts'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'completed'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'pmethod'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'shipmethod_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'cp_shipmethod'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'cu_shipmethod'		=>	array("TEXT", "NOT NULL"),
		'shiptrack'			=>	array("TEXT", "NOT NULL"),
		'buynow'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'gc_order_id'		=>	array("VARCHAR(30)", "NOT NULL DEFAULT ''"),
		'transid'			=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'transstatus'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'fname'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'lname'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'email'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'euvatnumber'		=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'ship_fname'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'ship_lname'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'ship_email'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'ship_company'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'ship_phone'		=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'ship_fax'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'ship_address'		=>	array("TEXT", "NOT NULL"),
		'ship_address2'		=>	array("TEXT", "NOT NULL"),
		'ship_city'			=>	array("TEXT", "NOT NULL"),
		'ship_state'		=>	array("TEXT", "NOT NULL"),
		'ship_country'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'ship_zipcode'		=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'bill_fname'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'bill_lname'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'bill_email'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'bill_company'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'bill_phone'		=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'bill_fax'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'bill_address'		=>	array("TEXT", "NOT NULL"),
		'bill_address2'		=>	array("TEXT", "NOT NULL"),
		'bill_city'			=>	array("TEXT", "NOT NULL"),
		'bill_state'		=>	array("TEXT", "NOT NULL"),
		'bill_country'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'bill_zipcode'		=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'cc_name'			=>	array("VARCHAR(255)", "NOT NULL DEFAULT ''"),
		'cc_type'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'cc_number'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'cc_exp_m'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'cc_exp_y'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'cc_cvv'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'billsameasship'	=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'Y'"),
		'api_shipping'		=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'shipping'			=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'shipmethod_name'	=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'discount'			=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'tax'				=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'tax_percentage'	=>	array("VARCHAR(10)", "NOT NULL DEFAULT ''"),
		'subtotal'			=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'total'				=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'status'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT 'uncompleted'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'completed_date'	=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	var $paid = "N";
	var $shipped = "N/A";
	
	function wpcoOrder($data = array()) {
		global $wpdb, $Country, $wpcoDb, $wpcoField, $wpcoFieldsOrder, $Item;
		$this -> table = $this -> pre . $this -> controller;
	
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = $dval;
				
				switch ($dkey) {
					case 'ship_country'			:
						$countrycodequery = "SELECT `code`, `isocode`, `value` FROM " . $wpdb -> prefix . $Country -> table . " WHERE `id` = '" . $dval . "'";
						if ($countrycodes = $wpdb -> get_row($countrycodequery)) {
							$this -> ship_countrycode = $countrycodes -> code;
							$this -> ship_isocountrycode = $countrycodes -> isocode;
							$this -> ship_countryname = $countrycodes -> value;
						}
						break;
					case 'bill_country'			:
						$countrycodequery = "SELECT `code`, `isocode`, `value` FROM " . $wpdb -> prefix . $Country -> table . " WHERE `id` = '" . $dval . "'";
						if ($countrycodes = $wpdb -> get_row($countrycodequery)) {
							$this -> bill_countrycode = $countrycodes -> code;
							$this -> bill_isocountrycode = $countrycodes -> isocode;
							$this -> bill_countryname = $countrycodes -> value;
						}
						break;
				}
			}
			
			$this -> paid = "N";
			
			if (!empty($this -> id)) {
				$wpcoDb -> model = $Item -> model;
				$items_count = $wpcoDb -> count(array('order_id' => $this -> id));
				$paid = 0;
				
				if ($items = $wpcoDb -> find_all(array('order_id' => $this -> id))) {
					foreach ($items as $item) {
						if (!empty($item -> paid) && $item -> paid == "Y") {
							$paid++;
							continue;
						}
					}
					
					if (!empty($paid) && $paid >= $items_count) {
						$this -> paid = "Y";
					}
				}
			}
			
			$this -> fields = array();
			$this -> cfields = array();
			
			$wpcoDb -> model = $wpcoFieldsOrder -> model;
			if ($fieldsorders = $wpcoDb -> find_all(array('order_id' => $this -> id))) {			
				foreach ($fieldsorders as $fieldorder) {
					$this -> fields[] = $fieldorder;
					$this -> cfields[] = $fieldorder;
				}
			}
			
			/* Shipped status */
			$this -> shipped = __("N/A", $this -> plugin_name);
			$this -> hastangible = "N";
			
			if (!empty($this -> id)) {
				$wpcoDb -> model = $Item -> model;				
				$items_count = $wpcoDb -> count(array('order_id' => $this -> id));
				
				if ($this -> has_tangible($this -> id)) {
					$this -> hastangible = "Y";
					
					if ($items = $wpcoDb -> find_all(array('order_id' => $this -> id))) {
						$tangible = 0;
						$shipped = 0;
					
						foreach ($items as $item) {
							if ($item -> product -> type == "tangible") {
								$tangible++;
							
								if ($item -> shipped == "Y") {
									$shipped++;
								}
							} else {
								$items_count--;
							}
						}
						
						if ($shipped >= $items_count) {
							$this -> shipped = "Y";
						} else {
							$this -> shipped = "N";
						}
					}
				} else {
					$this -> hastangible = "N";	
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return;
	}
	
	function has_tangible($order_id = null) {
		$hastangible = false;
		
		if (!empty($order_id)) {
			global $wpcoDb, $Item;
			$wpcoDb -> model = $Item -> model;
			
			if ($items = $wpcoDb -> find_all(array('order_id' => $order_id), array("id", "tangible"))) {
				foreach ($items as $item) {
					if ($item -> product -> type == "tangible") {
						$hastangible = true;
						break 1;	
					}
				}
			}
		}
		
		return $hastangible;	
	}
	
	function select($conditions = array()) {
		global $wpcoDb, $Item;
		$select = array();
		$wpcoDb -> model = $this -> model;
		
		if ($orders = $wpcoDb -> find_all($conditions, false, array('modified', "DESC"))) {
			foreach ($orders as $order) {
				if ($user = $this -> userdata($order -> user_id)) {
					$select[$order -> id] = $order -> id;
					
					if (!empty($user -> first_name) && !empty($user -> last_name)) {
						$select[$order -> id] .= ' (' . $user -> first_name . ' ' . $user -> last_name . ')';
					} else {
						$select[$order -> id] .= ' (' . $user -> user_login . ')';
					}
					
					$select[$order -> id] .= ($order -> completed == "Y") ? ' (completed)' : ' (not completed)';
					
					$wpcoDb -> model = $Item -> model;
					$itemscount = $wpcoDb -> count(array('order_id' => $order -> id));
					if (!empty($itemscount)) { $select[$order -> id] .= ' (' . $itemscount . ' ' . __('items', $this -> plugin_name) . ')'; }
				}
			}
		}
		
		return $select;
	}
	
	function cart_order() {
		global $wpcoAuth, $wpcoDb, $wpcoCart;
		$oldmodel = $wpcoDb -> model;
		$user = $wpcoAuth -> check_user();
		$co_id = false;
	
		if ($order_id = $this -> current_order_id(false)) {
			$co_id = array('type' => 'order', 'id' => $order_id);
		} else {
			$cart_id = $wpcoCart -> current_cart_id($user, true);		
			$co_id = array('type' => 'cart', 'id' => $cart_id);
		}
		
		$wpcoDb -> model = $oldmodel;
		return $co_id;
	}
	
	function current_order_id($autocreate = false) {	
		global $wpdb, $wpcoDb, $wpcoAuth, $user_ID;
		$order_id = false;
        $user = $wpcoAuth -> check_user();
		$wpcoDb -> model = $this -> model;
		
		$query2 = "SELECT `id` FROM `" . $wpdb -> prefix . $this -> table . "` WHERE `user` = '" . $user . "' AND `completed` = 'N'";
		
		global ${'order_id_' . $user};
		if (!empty(${'order_id_' . $user})) {
			return ${'order_id_' . $user};
		}
		
		if (false && $user_ID) {			
			if ($order = $wpdb -> get_row($query1)) {
				if (!empty($order)) {
					$order_id = $order -> id;
				}
			} elseif ($order = $wpdb -> get_row($query2)) {
				$wpcoDb -> model = $this -> model;
				$wpcoDb -> save_field('user_id', $user_ID, array('id' => $order -> id));
				
				if (!empty($order)) {
					$order_id = $order -> id;	
				}
			} else {			
				if ($autocreate == true) {
					$order = array(
						'user_id'		=>	$user_ID,
					);
					
					$wpcoDb -> save($order, true);
					$order_id = $this -> insertid;
				}
			}
		} else {			
			if ($order = $wpdb -> get_row($query2)) {				
				if (!empty($order)) {
					$order_id = $order -> id;
				}
			} else {
				if ($autocreate == true) {
					$order = array(
						'user'			=>	$user,
					);
					
					$wpcoDb -> save($order, true);
					$order_id = $this -> insertid;
				}
			}
		}
		
		${'order_id_' . $user} = $order_id;
		return $order_id;
	}
	
	function update_totals($o_id = null) {
		global $wpdb, $Discount, $wpcoTax;
		$order_id = (empty($o_id)) ? $this -> current_order_id() : $o_id;
	
		if (!empty($order_id)) {
			$co_id = array('type' => "order", 'id' => $order_id);
			$subtotal = $this -> total($co_id, false, false, true, true, false);
			$total = $this -> total($co_id, true, true, true, true, true);
			$shipping = $this -> shipping_total($subtotal, $co_id);
			$discount = $Discount -> total($co_id);
			$tax = $this -> tax_total($co_id);
			$tax_percentage = $wpcoTax -> get_tax_percentage($this -> do_shipping($co_id));
			
			$query = "UPDATE `" . $wpdb -> prefix . $this -> table . "` SET 
			`shipping` = '" . $shipping . "', 
			`discount` = '" . $discount . "', 
			`tax` = '" . $tax . "', 
			`tax_percentage` = '" . $tax_percentage . "', 
			`subtotal` = '" . $subtotal . "', 
			`total` = '" . $total . "' 
			WHERE `id` = '" . $order_id . "'";
			
			if ($wpdb -> query($query)) {
				return true;
			}
		}
		
		return false;
	}
	
	function alltotal() {
		global $wpdb, $wpcoDb, $Item;
		$wpcoDb -> model = $this -> model;
		$total = 0;
		$totalquery = "SELECT SUM(orders.total) FROM " . $wpdb -> prefix . $this -> table . " orders WHERE orders.id IN (SELECT order_id FROM " . $wpdb -> prefix . $Item -> table . " WHERE paid = 'Y') AND orders.completed = 'Y'";
		$total = $wpdb -> get_var($totalquery);		
		return $total;		
	}
	
	function shipping_alltotal() {
		global $wpdb, $Item;
		$total = 0;
		$totalquery = "SELECT SUM(orders.shipping) FROM " . $wpdb -> prefix . $this -> table . " orders WHERE orders.id IN (SELECT order_id FROM " . $wpdb -> prefix . $Item -> table . " WHERE paid = 'Y') AND orders.completed = 'Y'";
		$total = $wpdb -> get_var($totalquery);
		return $total;
	}
	
	function tax_alltotal() {
		global $wpdb, $Item;
		$total = 0;
		$totalquery = "SELECT SUM(orders.tax) FROM " . $wpdb -> prefix . $this -> table . " orders WHERE orders.id IN (SELECT order_id FROM " . $wpdb -> prefix . $Item -> table . " WHERE paid = 'Y') AND orders.completed = 'Y'";
		$total = $wpdb -> get_var($totalquery);
		return $total;
	}
	
	function tax_total($co_id = null) {
		global $wpdb, $Product, $Item, $wpcoTax;
		if (!is_array($co_id)) { $co_id = array('type' => "order", 'id' => $co_id); }
		
		$tax = 0;
		$includeshipping = ($this -> get_option('tax_includeshipping') == "Y") ? true : false;
		$includediscount = ($this -> get_option('couponsaffectts') == "Y") ? true : false;
		$total = $this -> total($co_id, $includeshipping, $includediscount, true, true, false);
		$taxoverrideproducts = array();
		
		/* BEG Tax Exempt Products */
		$taxexemptproductsquery = 
		"SELECT " . $wpdb -> prefix . $Product -> table . ".id, " . 
		$wpdb -> prefix . $Product -> table . ".taxoverride, " . 
		$wpdb -> prefix . $Product -> table . ".taxrate, " .
		$wpdb -> prefix . $Product -> table . ".taxrates, " .
		$wpdb -> prefix . $Item -> table . ".count, " . 
		$wpdb -> prefix . $Item -> table . ".id as `item_id` FROM `" . 
		$wpdb -> prefix . $Product -> table . "` " . 
		"LEFT JOIN " . $wpdb -> prefix . $Item -> table . 
		" ON " . $wpdb -> prefix . $Product -> table . ".id = " . $wpdb -> prefix . $Item -> table . ".product_id " .
		"WHERE (" . $wpdb -> prefix . $Product -> table . ".taxexempt = 'Y' OR " . $wpdb -> prefix . $Product -> table . ".taxoverride = 'Y') AND " .
		$wpdb -> prefix . $Item -> table . "." . $co_id['type'] . "_id = '" . $co_id['id'] . "'";
		
		if ($taxexemptproducts = $wpdb -> get_results($taxexemptproductsquery)) {			
			foreach ($taxexemptproducts as $taxexemptproduct) {
				$taxexemptproductprice = $Product -> unit_price($taxexemptproduct -> id, $taxexemptproduct -> count, $taxexemptproduct -> item_id, true, true, false);
				$total -= ($taxexemptproductprice * $taxexemptproduct -> count);
				
				if (!empty($taxexemptproduct -> taxoverride) && $taxexemptproduct -> taxoverride == "Y") {
					$taxexemptproduct -> productprice = $taxexemptproductprice;
					$taxoverrideproducts[] = $taxexemptproduct;
				}
			}
		}
		/* END Tax Exempt Products */
		
		/* Calculated on the global tax percentage */
		if ($this -> get_option('tax_calculate') == "Y") {
			if ($percentage = $wpcoTax -> get_tax_percentage($this -> do_shipping($co_id))) {			
				if ($total > 0) {
					$tax = (($total * $percentage) / 100);
				}
			}
		}
		
		/* BEG Tax Override Products */
		if (!empty($taxoverrideproducts)) {			
			foreach ($taxoverrideproducts as $taxoverrideproduct) {
				$taxoverrideproducttax = 0;
				$taxoverrideproducttax = $wpcoTax -> product_tax($taxoverrideproduct -> id, $taxoverrideproduct -> productprice);
				$tax += $taxoverrideproducttax;
			}
		}
		/* END Tax Override Products */
		
		if ($tax < 0) { $tax = 0; }
		return apply_filters($this -> pre . '_tax_total', $tax, $co_id['id']);
	}
	
	function surcharge($pmethod = 'pp', $total = null) {
		global $wpcoHtml;
		$surcharge = 0;
		
		if (!empty($pmethod) && !empty($total)) {
			switch ($pmethod) {
				case 'pp'				:
					if ($this -> get_option('pp_surcharge') == "Y") {
						$surcharge_amount = $this -> get_option('pp_surcharge_amount');
						$surcharge_percentage = $this -> get_option('pp_surcharge_percentage');
						
						if (!empty($surcharge_amount) && $surcharge_amount != "0.00") {
							$surcharge += $surcharge_amount;
						}
						
						if (!empty($surcharge_percentage) && $pp_surcharge_percentage != "0.00") {
							$surcharge += (($total * $surcharge_percentage) / 100);
						}
						
						$surcharge = $surcharge;	
					}
					break;
			}
		}
		
		return str_replace(",", ".", $surcharge);
	}
	
	function total($co_id = null, $shipping = false, $applydiscount = true, $styles = true, $fields = true, $tax_calculate = true, $handling = true) {
		global $wpdb, $wpcoDb, $wpcoCart, $Order, $Item, $Product, $Coupon, $Discount, $Style, $Option, $wpcoField, 
		$wpcoFieldsOrder;
		
		if (!is_array($co_id)) {
			$co_id = array('type' => "order", 'id' => $co_id);
		}
	
		$total = 0;
		$wpcoDb -> model = ($co_id['type'] == "order") ? $Order -> model : $wpcoCart -> model;
		
		$carts_table = $wpdb -> prefix . $wpcoCart -> table;
		$orders_table = $wpdb -> prefix . $this -> table;
		$fieldsorder_table = $wpdb -> prefix . $wpcoFieldsOrder -> table;
		
		if ($co_id['type'] == "order") { $query = "SELECT `id` FROM `" . $orders_table . "` WHERE `id` = '" . $co_id['id'] . "'"; }
		elseif ($co_id['type'] = "cart") { $query = "SELECT `id` FROM `" . $carts_table . "` WHERE `id` = '" . $co_id['id'] . "'"; }

		
		if (!empty($co_id['id']) && $co = $wpdb -> get_row($query)) {
			$wpcoDb -> model = $Item -> model;
		
			if ($items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']))) {
				if (!empty($items)) {
					foreach ($items as $item) {
						$producttotal = ($Product -> unit_price($item -> product_id, $item -> count, $item -> id, false, false, false, false) * $item -> count);
						$total += $producttotal;

						//calculate styles
						if ($styles == true) {						
							if (!empty($item -> styles)) {
								if (($ustyles = @unserialize($item -> styles)) !== false) {
									foreach ($ustyles as $ustyle => $uoption) {
										if (!empty($uoption) && is_array($uoption)) {
											$uoptions = $uoption;
										
											foreach ($uoptions as $uoid) {
												$optionprice = ($Option -> price($uoid, false, $producttotal) * $item -> count);
												
												if (!empty($item -> product -> taxincluded) && $item -> product -> taxincluded == 1) {
													global $wpcoTax;
													$percentage = $wpcoTax -> get_taxpercentage_final($item -> product);
													$option_tax = ($optionprice - ($optionprice / ((100 + $percentage) / 100)));
													$optionprice = ($optionprice - $option_tax);
												}
											
												$total += $optionprice;
											}
										} else {
											$optionprice = ($Option -> price($uoption, $ustyles, $producttotal) * $item -> count);
											
											if (!empty($item -> product -> taxincluded) && $item -> product -> taxincluded == 1) {
												global $wpcoTax;
												$percentage = $wpcoTax -> get_taxpercentage_final($item -> product);
												$option_tax = ($optionprice - ($optionprice / ((100 + $percentage) / 100)));
												$optionprice = ($optionprice - $option_tax);
											}
										
											$total += $optionprice;
										}
									}
								}
							}
						}
						
						//calculate fields
						if ($fields = true) {
							if (!empty($item -> product -> cfields)) {
								foreach ($item -> product -> cfields as $field_id) {
									$wpcoDb -> model = 'wpcoField';
									
									if ($field = $wpcoDb -> find(array('id' => $field_id))) {
										if (!empty($field -> addprice) && $field -> addprice == "Y") {
											if (!empty($field -> price)) {
												if (!empty($item -> {$field -> slug}) || $item -> {$field -> slug} == "0") {
													$fieldprice = ($field -> price * $item -> count);
													
													if (!empty($item -> product -> taxincluded) && $item -> product -> taxincluded == 1) {
														global $wpcoTax;
														$percentage = $wpcoTax -> get_taxpercentage_final($item -> product);
														$field_tax = ($fieldprice - ($fieldprice / ((100 + $percentage) / 100)));
														$fieldprice = ($fieldprice - $field_tax);
													}
												
													$total += $fieldprice;
												}
											}
										}
									}
								}
							}
						}
					}
					
					/* Global Custom Fields */
					if ($fields == true) {
						$fieldsquery = "SELECT `field_id` FROM `" . $fieldsorder_table . "` WHERE `" . $co_id['type'] . "_id` = '" . $co_id['id'] . "'";
						$order -> fields = $wpdb -> get_results($fieldsquery);
						
						if (!empty($order -> fields)) {
							foreach ($order -> fields as $ofield) {							
								$wpcoDb -> model = $wpcoField -> model;
								if ($field = $wpcoDb -> find(array('id' => $ofield -> field_id))) {								
									if (!empty($field -> addprice) && $field -> addprice == "Y") {									
										if (!empty($field -> price)) {
											if ($field -> globalf == "Y" && $field -> globalp != "ship") {
												$total += ($field -> price);
											} else {
												if ($field -> globalp == "ship") {
													if ($this -> do_shipping()) {
														$total += ($field -> price);
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					/* Discount */
					if ($this -> get_option('enablecoupons') == "Y" && $applydiscount == true) {
						$wpcoDb -> model = $Discount -> model;
						$currtotal = $total;
						$discount_total = 0;
					
						if ($discounts = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']))) {
							foreach ($discounts as $discount) {
								if ($discount -> coupon -> discount_type == "fixed") {
									$dc = $discount -> coupon -> discount;
									//$total -= $dc;
									$discount_total += $dc;
								} elseif ($discount -> coupon -> discount_type == "percentage") {
									$dc = (($discount -> coupon -> discount / 100) * $currtotal);
									$discount_total += $dc;
								}
							}
						}
					
						$discount_total = apply_filters($this -> pre . '_discount_total', $discount_total, $co_id);	
						$total = ($total - $discount_total);
					}
					
					/* Shipping */
					if ($shipping == true) {
						$total += $this -> shipping_total($total, $co_id);
					}
					
					//tax calculation
					if (!empty($tax_calculate) && $tax_calculate == true) {
						$tax_total = $this -> tax_total($co_id);
						$total += $tax_total;
					}
					
					if ($handling == true) { $total += $this -> handling($co_id); }
				}
			}
		}
		
		return $total;
	}
	
	function handling($co_id = null) {
		global $wpdb, $Category, $wpcoCategoriesProduct, $Item;
		$handling = 0;
	
		/* Handling/Surcharge Calculate */
		if ($this -> get_option('handling') == "Y") {
			if ($amount = $this -> get_option('handling_amount')) {
				if ($calculation = $this -> get_option('handling_calculation')) {
					switch ($calculation) {
						case 'always'			:
							$handling = $amount;
							break;
						case 'categories'		:
							if (!empty($co_id)) {
								if ($categories = maybe_unserialize($this -> get_option('handling_categories'))) {
									$query = "SELECT * FROM " . $wpdb -> prefix . $Item -> table . " AS i LEFT JOIN " . $wpdb -> prefix . $wpcoCategoriesProduct -> table . " AS cp ON i.product_id = cp.product_id WHERE i." . $co_id['type'] . "_id = '" . $co_id['id'] . "' AND cp.category_id IN (" . implode(",", $categories) . ")";
									
									if ($items = $wpdb -> get_results($query)) {									
										if (!empty($items)) {
											$handling = $amount;
										}
									}
								}
							}
							break;
					}			
				}
			}
		}
		
		return $handling;
	}
	
	function do_shipping($co_id = null) {
		global $wpdb, $wpcoDb, $wpcoShipmethod, $Item;
		
		if (!is_array($co_id)) {
			$co_id = array('type' => "order", 'id' => $co_id);
		}
	
		if ($this -> get_option('shippingcalc') == "Y") {
			$shipmethodsquery = "SELECT `id` FROM `" . $wpdb -> prefix . $wpcoShipmethod -> table . "`";
		
			if ($shipmethods = $wpdb -> get_results($shipmethodsquery)) {			
				if (!empty($co_id['id'])) {				
					$wpcoDb -> model = $Item -> model;
				
					if ($items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']))) {					
						foreach ($items as $item) {							
							if (!empty($item -> product -> type)) {								
								if ($item -> product -> type == "tangible") {									
									return true;
								}
							}
						}	
					}
				}
			}
		}
		
		return false;
	}
	
	function order_units($co_id = null) {
		global $wpdb, $wpcoDb, $Order, $Item;
		$units = 0;
		
		if (!is_array($co_id)) { $co_id = array('type' => "order", 'id' => $co_id); }
	
		if (!empty($co_id['id'])) {
			$query = "SELECT SUM(`count`) FROM `" . $wpdb -> prefix . "" . $Item -> table . "` WHERE `" . $co_id['type'] . "_id` = '" . $co_id['id'] . "'";
		
			if ($sum = $wpdb -> get_var($query)) {
				$units = $sum;
			}
		}
		
		return $units;
	}
	
	function weight($co_id = null) {
		$weight = 0;
		
		if (!is_array($co_id)) {
			$co_id = array('type' => "order", 'id' => $co_id);
		}
	
		if (!empty($co_id['id'])) {
			global $wpcoDb, $Item;
			$wpcoDb -> model = $Item -> model;
			
			if ($items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']))) {
				foreach ($items as $item) {					
					if (!empty($item -> product -> weight)) {
						if (!empty($item -> product -> excludeglobal) && $item -> product -> excludeglobal != "Y") {
							$weight += abs(($item -> product -> weight * $item -> count));
						}
					}
				}
			}
		}
		
		return $weight;
	}
	
	function globalf_total($co_id = null) {
		global $wpcoDb, $Order, $wpcoField;
		if (!is_array($co_id)) { $co_id = array('type' => "order", 'id' => $co_id); }
		$total = 0;
		
		if (!empty($co_id['id'])) {
			$wpcoDb -> model = $Order -> model;			
			if ($order = $wpcoDb -> find(array('id' => $co_id['id']))) {
				if (!empty($order -> fields)) {
					foreach ($order -> fields as $ofield) {
						$wpcoDb -> model = $wpcoField -> model;
						if ($field = $wpcoDb -> find(array('id' => $ofield -> field_id))) {
							if (!empty($field -> addprice) && $field -> addprice == "Y") {
								if (!empty($field -> price)) {
									$total += ($field -> price);
								}
							}
						}
					}
				}
			}
		}
		
		return $total;
	}
	
	function shipping_total($total = null, $co_id = null) {
		//global variables
		global $wpcoDb, $wpcoCart, $Order, $wpcoHtml, $Item, $wpcoShipmethod, $wpcoShiprate;
		if (!is_array($co_id)) { $co_id = array('type' => "order", 'id' => $co_id); }
	
		//start off with a 0.00 shipping total
		$shipping = 0;
		$baseshipping = 0;
		$productsshipping = 0;
		$didbase = false;
		$wpcoDb -> model = $this -> model;
		$hastangible = false;
		
		
		/* Should discount be applied before shipping is? */
		if ($this -> get_option('couponsaffectts') == "Y") {
			$total = $Order -> total($co_id, false, true, true, true, false);
			$wpcoDb -> model = $this -> model;	
		}
		
		$wpcoDb -> model = ($co_id['type'] == "order") ? $Order -> model : $wpcoCart -> model;
	
		if (!empty($total) && (!empty($co_id['id']) && $co = $wpcoDb -> find(array('id' => $co_id['id'])))) {		
			//check the shipmethod_id
			if (empty($co -> shipmethod_id)) {
				if ($shippingtype = $this -> get_option('shippingtype')) {
					if ($shipping_default = $this -> get_option('shipping' . $shippingtype . '_default')) {						
						if (!empty($shipping_default)) {
							$wpcoDb -> model = $this -> model;
							$wpcoDb -> save_field('shipmethod_id', $shipping_default, array('id' => $co_id['id']));
							$co -> shipmethod_id = $shipping_default;		
						}
					}
				}
			}
			
			//weight of the order
			$weight = $this -> weight($co_id);
			
			/* Get the order items */
			$wpcoDb -> model = $Item -> model;
			$items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']));
			
			$wpcoDb -> model = $wpcoShipmethod -> model;
			if (!empty($co -> shipmethod_id) && $shipmethod = $wpcoDb -> find(array('id' => $co -> shipmethod_id))) {				
				if ($this -> do_shipping($co_id)) {
					$wpcoDb -> model = $Item -> model;
					
					switch ($shipmethod -> api) {
						case 'auspost'				:
						case 'usps'					:				
						case 'ups'					:
						case 'fedex'				:							
						case 'canadapost'			:							
						case 'echo'					:
						case 'upsfreight'			:
							$baseshipping = $co -> api_shipping;							
							$productsshipping = $this -> products_shipping_total($total, $co_id, $co, $items, $shipmethod);							
							$hastangible = true;
							break;
						default						:
							if (!empty($items)) {					
								foreach ($items as $item) {						
									if ($item -> product -> type == "tangible" && $item -> product -> excludeglobal == "N") {
										$hastangible = true;
										
										if ($this -> get_option('shippingtype') == "fixed") {
											if (empty($didbase) || $didbase == false) {
												//$baseshipping = $this -> get_option('shippingprice');
												if (!empty($shipmethod -> fixed)) {
													$baseshipping += $shipmethod -> fixed;
												}
												
												$didbase = true;
											}
										} elseif ($this -> get_option('shippingtype') == "tiers") {
											$shippingtiers = $this -> get_option('shippingtiers');
											
											if ($this -> get_option('shiptierstype') == "units") {
												$order_units = $this -> order_units($co_id);
											
												if (!empty($shippingtiers) && is_array($shippingtiers)) {
													if (empty($didbase) || $didbase == false) {
														$s = 1;
														
														foreach ($shippingtiers as $tier) {
															if (($order_units >= $tier['min'] && $order_units <= $tier['max']) || $s == count($shippingtiers)) {
																$baseshipping = $tier['price'][$shipmethod -> id];
																break 1;
															}
															
															$s++;
														}
														
														$didbase = true;
													}
												}
											} elseif ($this -> get_option('shiptierstype') == "price") {
												if (!empty($shippingtiers) && is_array($shippingtiers)) {
													if (empty($didbase) || $didbase == false) {
														$s = 1;
														
														foreach ($shippingtiers as $tier) {
															if (($total >= $tier['min'] && $total <= $tier['max']) || $s == count($shippingtiers)) {
																$baseshipping = $tier['price'][$shipmethod -> id];
																break 1;
															}
															
															$s++;
														}
														
														$didbase = true;
													}
												}	
											} elseif ($this -> get_option('shiptierstype') == "weight") {																				
												if (!empty($shippingtiers) && is_array($shippingtiers)) {
													if (empty($didbase) || $didbase == false) {
														$s = 1;
														
														foreach ($shippingtiers as $tier) {
															if (($weight >= $tier['min'] && $weight <= $tier['max']) || $s == count($shippingtiers)) {
																$baseshipping = $tier['price'][$shipmethod -> id];
																break 1;
															}
															
															$s++;
														}
														
														$didbase = true;
													}
												}
											}
										}
									}
								}
								
								$productsshipping = $this -> products_shipping_total($total, $co_id, $co, $items, $shipmethod);
							}
							break;
					}
				}
			}
		}
		
		// Regional shipping rates
		if ($regionalshipping = $wpcoShiprate -> shipping($co -> id)) {
			$rate = 0;
			$type = $wpcoShiprate -> type($co -> id);
			
			switch ($type) {
				case 'perc'		:
					$rate = (($total * $regionalshipping) / 100);
					break;
				case 'curr'		:
				default 		:
					$rate = $regionalshipping;
					break;
			}
		
			if ($this -> get_option('shipping_appendshiprate') == "Y") {
				$baseshipping += $rate;	
			} else {
				$baseshipping = $rate;
			}
		}
		
		$shipping += (float) $baseshipping;
		$shipping += (float) $productsshipping;
		
		/* Global Shipping Minimum */
		if (!empty($hastangible) && $hastangible == true) {		
			if ($this -> get_option('shipping_globalminimum') == "Y") {							
				if ($shipping_minimum = $this -> get_option('shipping_minimum')) {				
					if (!empty($shipping_minimum) && ($shipping < $shipping_minimum)) {
						$shipping = $shipping_minimum;
					}
				}
			}
		}
		
		return apply_filters($this -> pre . '_shipping_total', $shipping, $co_id);
	}
	
	function products_shipping_total($total = null, $co_id = null, $order = null, $items = array(), $shipmethod = null) {
		global $wpcoDb, $Order, $Item, $Product, $wpcoShipmethod;
		$productsshipping = 0;
		
		if (!is_array($co_id)) {
			$co_id = array('type' => "order", 'id' => $co_id);
		}
		
		if (!empty($co_id['id'])) {			
			if (!empty($order)) {				
				if (!empty($shipmethod)) {				
					if (!empty($items)) {						
						foreach ($items as $item) {
							if (!empty($item -> product -> type) && $item -> product -> type == "tangible") {
								//BEG additional product shipping cost
								if (!empty($item -> product -> shipping) && $item -> product -> shipping == "Y") {
									if (!empty($item -> product -> shiptype)) {
										switch ($item -> product -> shiptype) {
											case 'tiers'			:
												if (!empty($item -> product -> shiptiers) && is_array($item -> product -> shiptiers)) {
													$s = 1;
													
													foreach ($item -> product -> shiptiers as $tier) {													
														if (($item -> count >= $tier['min'] && $item -> count <= $tier['max']) || $s == count($item -> product -> shiptiers)) {
															$productsshipping += ($tier['price'][$order -> shipmethod_id] * $item -> count);
															break 1;
														}
														
														$s++;
													}
												}
												break ;
											case 'percentage'		:
												global $Product;
											
												if (!empty($item -> product -> shippercentage) && is_array($item -> product -> shippercentage)) {
													if (!empty($item -> product -> shippercmethod)) {
														if ($item -> product -> shippercmethod == "wholesale" && !empty($item -> product -> wholesale)) {
															$newproductshipping = ((($item -> product -> wholesale * $item -> product -> shippercentage[$shipmethod -> id]) / 100) * $item -> count);
														} elseif ($item -> product -> shippercmethod == "fixed") {
															$newproductshipping = ((($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> product -> shippercentage[$shipmethod -> id]) / 100) * $item -> count);
														}
														
														if (!empty($newproductshipping)) {
															$productsshipping += $newproductshipping;	
														}
													}
												}
												break;
											default					:
												if (!empty($item -> product -> shipfixed) && is_array($item -> product -> shipfixed)) {
													$productsshipping += ($item -> product -> shipfixed[$shipmethod -> id] * $item -> count);
												}
												break ;
										}
									}
								}
								//END additional product shipping cost	
							}
						}
					}
				}
			}
		}
		
		return $productsshipping;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
		
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		extract($data, EXTR_SKIP);
		
		if (empty($user_id) && empty($user)) { $this -> errors['user_id'] = __('No user was specified', $this -> plugin_name); }
		
		return $this -> errors;
	}
	
	function defaults() {
		global $wpcoHtml, $wpcoAuth;
	
		$defaults = array(
			'user'				=>	$wpcoAuth -> check_user(),
			'pmethod'			=>	"PayPal",
			'completed'			=>	"N",
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date(),
			'completed_date'	=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
}

?>