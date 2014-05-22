<?php

class wpcoCoupon extends wpCheckoutPlugin {

	var $model = 'Coupon';
	var $controller = 'coupons';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'				=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'code'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'active'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'Y'",
		'used'				=>	"INT(11) NOT NULL DEFAULT '0'",
		'maxuse'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'expiry'			=>	"DATE NOT NULL DEFAULT '0000-00-00'",
		'discount'			=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'discount_type'		=>	"TEXT NOT NULL",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'title'				=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'code'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'active'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'Y'"),
		'used'				=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'maxuse'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'expiry'			=>	array("DATE", "NOT NULL DEFAULT '0000-00-00'"),
		'discount'			=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'discount_type'		=>	array("TEXT NOT NULL"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoCoupon($data = array()) {
		global $wpcoDb;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
				
				switch ($dkey) {
					case 'used'			:
						$wpcoDb -> model = 'Discount';
						$this -> used = $wpcoDb -> count(array('coupon_id' => $this -> id));
						break;
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
	}
	
	function discount($id = null, $co_id = null) {
		global $wpcoDb, $Order;
		$discount = 0;
		$total = $Order -> total($co_id, true, false, true, true, true);
		
		if (!empty($id) && !empty($total)) {
			$wpcoDb -> model = $this -> model;
			if ($coupon = $wpcoDb -> find(array('id' => $id))) {						
				switch ($coupon -> discount_type) {
					case 'fixed'			:
						$discount = $coupon -> discount;
						break;
					case 'percentage'		:
						$discount = (($coupon -> discount / 100) * $total);
						break;
				}
			}
		}
		
		return apply_filters($this -> pre . '_coupon_discount', $discount, $coupon, $co_id, $total);
	}
	
	function check_expirations() {
		global $wpcoDb;
		
		$wpcoDb -> model = $this -> model;
		if ($coupons = $wpcoDb -> find_all()) {
			foreach ($coupons as $coupon) {
				if (!empty($coupon -> expiry) || $coupon -> expiry != "0000-00-00") {
					if (strtotime($coupon -> expiry) <= time()) {
						$wpcoDb -> model = $this -> model;
						$wpcoDb -> save_field('active', "N", array('id' => $coupon -> id));
					}
				}
			}
		}
		
		return false;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
		
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		extract($data, EXTR_SKIP);
		
		if (empty($title)) { $this -> errors['title'] = __('Please fill in a coupon title', $this -> plugin_name); }
		if (empty($code)) { $this -> errors['code'] = __('Please fill in a coupon code', $this -> plugin_name); }
		if (empty($discount)) { $this -> errors['discount'] = __('Please fill in a discount amount/percentage', $this -> plugin_name); }
		if (empty($discount_type)) { $this -> errors['discount_type'] = __('Please choose a discount type', $this -> plugin_name); }
		if (empty($active)) { $this -> errors['active'] = __('Please select active status', $this -> plugin_name); }
		
		$this -> errors = apply_filters($this -> pre . '_coupon_save_validation', $this -> errors, $data);
		return $this -> errors;
	}
	
	function defaults() {
		global $wpcoHtml;
	
		$defaults = array(
			'active'			=>	"Y",
			'used'				=>	0,
			'maxuse'			=>	0,
			'discount_type'		=>	'fixed',
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
}

?>