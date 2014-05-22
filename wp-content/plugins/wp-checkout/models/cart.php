<?php

class wpcoCart extends wpCheckoutPlugin {

	var $model = 'wpcoCart';
	var $controller = 'carts';
	var $table;
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'fromcontacts'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'userauth'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'fromcontacts'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'userauth'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	function wpcoCart($data = array()) {
		global $wpdb, $wpcoDb;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
		
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		extract($data, EXTR_SKIP);
		
		if (empty($userauth)) { $this -> errors['userauth'] = __('No user was specified', $this -> plugin_name); }
		
		return $this -> errors;
	}
	
	function defaults() {
		global $wpcoHtml, $wpcoAuth;
	
		$defaults = array(
			'userauth'				=>	$wpcoAuth -> check_user(),
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
	
	function cart_to_order() {
		global $user_ID, $wpdb, $wpcoDb, $wpcoAuth, $Order, $Item, $Discount;
		$userauth = $wpcoAuth -> check_user();
		
		if ($cart_id = $this -> current_cart_id($userauth, false)) {
			$wpcoDb -> model = $this -> model;
			$cart = $wpcoDb -> find(array('id' => $cart_id));
			$order_data = array('user' => $userauth, 'user_id' => $user_ID, 'fromcontacts' => $cart -> fromcontacts);
			$wpcoDb -> model = $Order -> model; 
			
			if ($wpcoDb -> save($order_data, true)) {
				$order_id = $Order -> insertid;
				$wpdb -> query("UPDATE `" . $wpdb -> prefix . $Item -> table . "` SET `cart_id` = '0', `order_id` = '" . $order_id . "' WHERE `cart_id` = '" . $cart_id . "'");
				$wpdb -> query("UPDATE `" . $wpdb -> prefix . $Discount -> table . "` SET `cart_id` = '0', `order_id` = '" . $order_id . "' WHERE `cart_id` = '" . $cart_id . "'");
				$wpdb -> query("DELETE FROM `" . $wpdb -> prefix . $this -> table . "` WHERE `id` = '" . $cart_id . "'");
				$Order -> update_totals();
				return $order_id;
			}
		}
		
		return false;
	}
	
	function current_cart_id($userauth = null, $autocreate = true) {
		global $wpdb, $wpcoDb, $wpcoAuth;	
		$cart_id = false;
		if (empty($userauth)) { $userauth = $wpcoAuth -> check_user(); }
		
		$query = "SELECT `id` FROM `" . $wpdb -> prefix . $this -> table . "` WHERE `userauth` = '" . $userauth . "'";
		
		global ${'cart_id_' . $userauth};
		if (!empty(${'cart_id_' . $userauth})) {
			return ${'cart_id_' . $userauth};
		}
		
		if (!$cart_id = $wpdb -> get_var($query)) {
			if (!empty($autocreate) && $autocreate == true) {
				$cart = array('userauth' => $userauth);
				$wpcoDb -> model = $this -> model;
				if ($wpcoDb -> save($cart)) {
					$cart_id = $this -> insertid;
				}
			}
		}
		
		${'cart_id_' . $userauth} = $cart_id;
		return $cart_id;
	}
}

?>