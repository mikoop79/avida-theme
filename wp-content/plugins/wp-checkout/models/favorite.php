<?php

class wpcoFavorite extends wpCheckoutPlugin {

	var $model = 'wpcoFavorite';
	var $controller = 'favorites';
	var $table = '';
	var $recursive = true;
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'product_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'user_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`), KEY `index_product_id` (`product_id`), KEY `index_user_id` (`user_id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'product_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'user_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`), KEY `index_product_id` (`product_id`), KEY `index_user_id` (`user_id`)",					   
	);
	
	var $data = array();
	var $errors = array();
	
	function wpcoFavorite($data = array()) {
		global $wpcoDb, $Product;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
				
				switch ($dkey) {
					case 'product_id'		:
						$wpcoDb -> model = $Product -> model;
						$this -> product = $wpcoDb -> find(array('id' => $dval), array("title", "post_id", "image"));
						break;	
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
		
		if (!empty($data)) {
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			extract($data, EXTR_SKIP);
			
			if (empty($product_id)) $this -> errors['product_id'] = __('No product was specified', $this -> plugin_name);
			if (empty($user_id)) { $this -> errors['user_id'] = __('No user was specified', $this -> plugin_name); }
			
			if (empty($this -> errors)) {
				global $wpcoDb;
				$wpcoDb -> model = $this -> model;
				
				if ($wpcoDb -> find(array('user_id' => $user_id, 'product_id' => $product_id))) {
					$this -> errors[] = __('Favorite already on account', $this -> plugin_name);
				}
			}
		} else {
			$this -> errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=> 	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
}

?>