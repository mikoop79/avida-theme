<?php

class wpcoItem extends wpCheckoutPlugin {
	
	var $model = 'Item';
	var $controller = 'items';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'user'				=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'user_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'product_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'donate_price'		=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'iof_name'			=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'iof_benname'		=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'iof_benemail'		=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'width'				=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'length'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'cart_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'order_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'count'				=>	"INT(11) NOT NULL DEFAULT '1'",
		'completed'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'paid'				=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'shipped'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'styles'			=>	"TEXT NOT NULL",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'user'				=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'user_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'product_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'donate_price'		=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'iof_name'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'iof_benname'		=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'iof_benemail'		=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'width'				=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'length'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'cart_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'order_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'count'				=>	array("INT(11)", "NOT NULL DEFAULT '1'"),
		'completed'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'paid'				=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'shipped'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'styles'			=>	array("TEXT", "NOT NULL"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoItem($data = array()) {
		global $wpcoDb, $Product;	
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
				
				switch ($dkey) {
					case 'product_id'			:
						$wpcoDb -> model = $Product -> model;
						$this -> product = $wpcoDb -> find(array('id' => $dval));
						break;
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function item_count($co_id = null, $type = 'items') {
		global $wpdb, $wpcoDb;
		
		if (!is_array($co_id)) {
			$co_id = array('type' => 'order', 'id' => $co_id);
		}
		
		$count = 0;
		$wpcoDb -> model = $this -> model;
	
		if (!empty($co_id['id'])) {
			switch ($type) {
				case 'items'			:
					$query = "SELECT COUNT(id) FROM " . $wpdb -> prefix . "" . $this -> table . " WHERE `" . $co_id['type'] . "_id` = '" . $co_id['id'] . "'";
					return $wpdb -> get_var($query);
					break;
				default					:
					$query = "SELECT SUM(count) FROM " . $wpdb -> prefix . "" . $this -> table . " WHERE `" . $co_id['type'] . "_id` = '" . $co_id['id'] . "'";
					$count = $wpdb -> get_var($query);
					
					if (empty($count)) { return 0; }
					
					return $count;
					break;	
			}
		}
		
		return $count;
	}
	
	function validate($data = array()) {
		global $wpdb, $wpcoHtml, $wpcoDb, $Style, $Product, $wpcoField, $Order;
		$co_id = $Order -> cart_order();
		$order_id = ($co_id['type'] == "order") ? $co_id['id'] : false;
		$cart_id = ($co_id['type'] == "cart") ? $co_id['id'] : false;
		$this -> errors = array();
		
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		extract($data, EXTR_SKIP);
	
		if (empty($user_id) && empty($user)) { $this -> errors['user_id'] = __('No user was specified', $this -> plugin_name); }		
		if (empty($product_id)) { $this -> errors['product_id'] = __('No product was specified', $this -> plugin_name); }
		else {
			$wpcoDb -> model = $Product -> model;
			
			if ($product = $wpcoDb -> find(array('id' => $product_id))) {
				if (!empty($product -> styles)) {
					foreach ($product -> styles as $style_id) {
						$wpcoDb -> model = $Style -> model;
						
						if ($style = $wpcoDb -> find(array('id' => $style_id))) {
							if (empty($styles[$style_id])) { $this -> errors['styles_' . $style_id] = __('Please select', $this -> plugin_name) . ' ' . $style -> title; }
						}
					}
				}
				
				if (!empty($product -> cfields)) {						
					foreach ($product -> cfields as $field_id) {
						$value = "";
						$wpcoDb -> model = $wpcoField -> model;						
						if ($field = $wpcoDb -> find(array('id' => $field_id), array('id', 'title', 'required', 'error'))) {
							if (!empty($field -> required) && $field -> required == "Y") {
								if (empty($_POST['Item']['fields'][$field -> id]) && $_POST['Item']['fields'][$field -> id] != "0") {
									$this -> errors['fields_' . $field_id] = (empty($field -> error)) ? __('Please fill in', $this -> plugin_name) . ' ' . $field -> title : $field -> error;
								}
							}
						}
					}
				}
				
				if ($product -> type == "tangible") {
					if (empty($shipped)) { $this -> errors['shipped'] = __('Please select shipped status', $this -> plugin_name); }
				}
				
				if ($product -> price_type == "donate") {
					if (empty($donate_price)) { $this -> errors['donate_price'] = __('Please fill in a donate price.', $this -> plugin_name); }	
					else {
						if (!empty($product -> donate_min) && $product -> donate_min > 0) {
							if ($donate_price < $product -> donate_min) {
								$this -> errors['donate_price'] = sprintf(__('Minimum donate price is %s', $this -> plugin_name), $product -> donate_min);
							}
						}
					}
					
					if (!empty($product -> inhonorof) && $product -> inhonorof == "Y" && (!empty($_POST['inhonorofreq']) || $product -> inhonorofreq == "Y")) {
						if (empty($iof_name)) { $this -> errors['iof_name'] = __('Please fill in your name.', $this -> plugin_name); }
						if (empty($iof_benname)) { $this -> errors['iof_benname'] = __('Please fill in the beneficiary name.', $this -> plugin_name); }
						if (empty($iof_benemail)) { $this -> errors['iof_benemail'] = __('Please fill in the beneficiary email.', $this -> plugin_name); }	
						elseif (!is_email($iof_benemail)) { $this -> errors['iof_benemail'] = __('Please fill in a valid beneficiary email.', $this -> plugin_name); }
					}
				} elseif ($product -> price_type == "square") {
					if (empty($width)) { $this -> errors['width'] = __('Please fill in a width.', $this -> plugin_name); }
					elseif (!is_numeric($width)) { $this -> errors['width'] = __('Only numeric width.', $this -> plugin_name); }
					if (empty($length)) { $this -> errors['length'] = __('Please fill in a length.', $this -> plugin_name); }	
					elseif (!is_numeric($length)) { $this -> errors['length'] = __('Only numeric length.', $this -> plugin_name); }
					
					if (!empty($width) && !empty($length)) {
						if (!empty($product -> sq_w_min) && $width < $product -> sq_w_min) { $this -> errors[] = __('Minimum width is', $this -> plugin_name) . ' ' . $product -> sq_w_min; }
						if (!empty($product -> sq_w_max) && $width > $product -> sq_w_max) { $this -> errors[] = __('Maximum width is', $this -> plugin_name) . ' ' . $product -> sq_w_max; }
						if (!empty($product -> sq_l_min) && $length < $product -> sq_l_min) { $this -> errors[] = __('Minimum length is', $this -> plugin_name) . ' ' . $product -> sq_l_min;}
						if (!empty($product -> sq_l_max) && $length > $product -> sq_l_max) { $this -> errors[] = __('Maximum length is', $this -> plugin_name) . ' ' . $product -> sq_l_max;}	
					}
				}
			}
		}
		
		if (empty($count)) { $this -> errors['count'] = __('No qty specified', $this -> plugin_name); }
		if (empty($order_id) && empty($cart_id)) { $this -> errors['order_id'] = __('No cart/order was specified', $this -> plugin_name); }
	
		$wpcoDb -> model = $this -> model;
		return $this -> errors;
	}
	
	function defaults() {
		global $Order, $user_ID, $wpcoDb, $wpcoAuth, $wpcoHtml;
		$co_id = $Order -> cart_order();
	
		$defaults = array(
			'shipped'					=>	"N",
			'user'						=>	$wpcoAuth -> check_user(),
			'user_id'					=>	(!$user_ID) ? 0 : $user_ID,
			$co_id['type'] . '_id'		=>	$co_id['id'],
			'count'						=>	1,
			'completed'					=>	"N",
			'paid'						=>	"N",
			'created'					=>	$wpcoHtml -> gen_date(),
			'modified'					=>	$wpcoHtml -> gen_date(),
		);
		
		$wpcoDb -> model = $this -> model;
		return $defaults;
	}
}

?>