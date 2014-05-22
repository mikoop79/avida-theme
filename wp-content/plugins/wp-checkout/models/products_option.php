<?php

class wpcoProductsOption extends wpCheckoutPlugin {

	var $model = 'ProductsOption';
	var $controller = 'productsoptions';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'product_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'option_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'inventory'			=>	"INT(11) NOT NULL DEFAULT '-1'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'product_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'option_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'inventory'			=>	array("INT(11)", "NOT NULL DEFAULT '-1'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoProductsOption($data = array()) {
		global $wpcoDb;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = $dval;
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function find($conditions = array(), $fields = false) {
		global $wpdb;
		
		if (!empty($conditions)) {
			$fields = (empty($fields)) ? "*" : implode(", ", $fields);
			$query = "SELECT " . $fields . " FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				$query .= " `" . $ckey . "` = '" . $cval . "'";
				
				if ($c < count($conditions)) {
					$query .= " AND";
				}
				
				$c++;
			}
			
			$query .= " LIMIT 1";
			
			if ($productsoption = $wpdb -> get_row($query)) {
				if (!empty($productsoption)) {
					$this -> data = $this -> init_class($this -> model, $productsoption);
					
					return $this -> data;
				}
			}
		}
			
		return false;
	}
	
	function find_all($conditions = array(), $fields = false, $order = array('modified', 'DESC'), $limit = false) {
		global $wpdb;
		
		$fields = (empty($fields)) ? "*" : implode($fields);
		$query = "SELECT " . $fields . " FROM `" . $wpdb -> prefix . "" . $this -> table . "`";
		
		if (!empty($conditions) && is_array($conditions)) {
			$query .= " WHERE";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				$query .= " `" . $ckey . "` = '" . $cval . "'";
				
				if ($c < count($conditions)) {
					$query .= " AND";
				}
				
				$c++;
			}
		}
		
		list($ofield, $oorder) = $order;
		$query .= " ORDER BY `" . $ofield . "` " . $oorder . "";
		
		if ($productsoptions = $wpdb -> get_results($query)) {
			if (!empty($productsoptions)) {
				$this -> data = array();
				
				foreach ($productsoptions as $po) {
					$this -> data[] = $this -> init_class($this -> model, $po);
				}
				
				return $this -> data;
			}
		}
		
		return false;
	}
	
	function save($data = array(), $validate = true) {
		global $wpdb, $wpcoDb, $wpcoHtml;
		
		$defaults = array('created' => $wpcoHtml -> gen_date(), 'modified' => $wpcoHtml -> gen_date(), 'inventory' => "-1");
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		$r = wp_parse_args($data, $defaults);
		$this -> data = $wpcoHtml -> array_to_object($r);
		extract($r, EXTR_SKIP);
		
		if ($validate == true) {
			if (empty($product_id)) { $this -> errors['product_id'] = __('No product was specified', $this -> plugin_name); }
			if (empty($option_id)) { $this -> errors['option_id'] = __('No option was specified', $this -> plugin_name); }
		}
		
		if (empty($this -> errors)) {
			if (!$this -> find(array('product_id' => $product_id, 'option_id' => $option_id))) {
				$wpcoDb -> model = $this -> model;
				$query = (empty($id)) ? $wpcoDb -> insert_query($this -> model) : $wpcoDb -> update_query($this -> model);
				
				if ($wpdb -> query($query)) {
					$this -> insertid = $wpdb -> insert_id;
					return true;
				}
			}
		}
		
		return false;
	}
	
	function delete_all($conditions = array()) {
		global $wpdb;
		
		if (!empty($conditions)) {
			$query = "DELETE FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				$query .= " `" . $ckey . "` = '" . $cval . "'";
				
				if ($c < count($conditions)) {
					$query .= " AND";
				}
				
				$c++;
			}
			
			if ($wpdb -> query($query)) {
				return true;
			}
		}
		
		return false;
	}
}

?>