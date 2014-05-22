<?php

class wpcoDiscount extends wpCheckoutPlugin {

	var $model = 'Discount';
	var $controller = 'discounts';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'user'				=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'user_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'cart_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'order_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'coupon_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'user'				=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'user_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'cart_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'order_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'coupon_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoDiscount($data = array()) {
		global $wpdb, $wpcoDb, $Coupon;
		
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
				
				switch ($dkey) {
					case 'coupon_id'		:
						$wpcoDb -> model = $Coupon -> model;
						$this -> coupon = $wpcoDb -> find(array('id' => $dval));
						break;
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
	}
	
	function alltotal() {
		global $wpdb, $wpcoDb, $Order;
		$wpcoDb -> model = $Order -> model;
		$total = 0;		
		$totalquery = "SELECT SUM(discount) FROM " . $wpdb -> prefix . $Order -> table . " WHERE completed = 'Y'";
		$total = $wpdb -> get_var($totalquery);		
		return $total;
	}
	
	function total($co_id = null) {
		global $wpcoDb, $Order;
		if (!is_array($co_id)) { $co_id = array('type' => "order", 'id' => $co_id); }
		$total = 0;
		
		if ($this -> get_option('enablecoupons') == "Y") {
			if (!empty($co_id['id'])) {
				$ordertotal = $Order -> total($co_id, false, false, true, true, false);				
				$wpcoDb -> model = $this -> model;
			
				if ($discounts = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']))) {
					foreach ($discounts as $discount) {
						if ($discount -> coupon -> discount_type == "fixed") {
							$total += $discount -> coupon -> discount;
						} else {
							$total += (($discount -> coupon -> discount / 100) * $ordertotal);
						}
					}
				}
			}
		}
		
		return apply_filters($this -> pre . '_discount_total', $total, $co_id);
	}
	
	function coupons_by_order($order_id = null) {
		global $wpdb, $Coupon;
		$couponsstring = '';
		
		$couponsquery = "SELECT * FROM " . $wpdb -> prefix . $this -> table . 
		" LEFT JOIN " . $wpdb -> prefix . $Coupon -> table . " ON " . $wpdb -> prefix . $this -> table . ".coupon_id = 
		" . $wpdb -> prefix . $Coupon -> table . ".id WHERE `order_id` = '" . $order_id . "'";
		
		if ($coupons = $wpdb -> get_results($couponsquery)) {
			$i = 1;
			foreach ($coupons as $coupon) {
				$coupon = stripslashes_deep($coupon);
				$couponsstring .= '<strong>' . $coupon -> title . '</strong>: ' . $coupon -> code;
				
				if ($i < count($coupons)) {
					$couponsstring .= '; ';
				}
				
				$i++;
			}
		}
		
		return apply_filters($this -> pre . '_coupons_by_order_string', $couponsstring, $order_id);
	}
	
	function discount($id = null) {
		global $wpcoDb, $Order;
		$wpcoDb -> model = $this -> model;
		$discount = 0;
	
		if (!empty($id)) {
			if ($d = $wpcoDb -> find(array('id' => $id))) {
				if (!empty($d -> order_id)) {
					$order_total = $Order -> total($d -> order_id, false, false, true, true, false);
					
					switch ($d -> coupon -> discount_type) {
						case 'fixed'			:
							$discount = $d -> coupon -> discount;
							break;
						case 'percentage'		:
							$discount = (($d -> coupon -> discount / 100) * $order_total);
							break;	
					}
				}
			}
		}
	
		return $discount;
	}
	
	function defaults() {
		global $wpcoHtml, $wpcoAuth, $Order;
		$co_id = $Order -> cart_order();
	
		$defaults = array(
			$co_id['type'] . '_id'		=>	$co_id['id'],
			'user'						=>	$wpcoAuth -> check_user(),
			'created'					=>	$wpcoHtml -> gen_date(),
			'modified'					=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
		
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		extract($data, EXTR_SKIP);
		
		if (empty($user_id) && empty($user)) { $this -> errors['user_id'] = __('No user was specified', $this -> plugin_name); }
		if (empty($order_id) && empty($cart_id)) { $this -> errors['order_id'] = __('No order was specified', $this -> plugin_name); }
		if (empty($coupon_id)) { $this -> errors['coupon_id'] = __('No coupon was specified', $this -> plugin_name); }
		
		return $this -> errors;
	}
}

?>