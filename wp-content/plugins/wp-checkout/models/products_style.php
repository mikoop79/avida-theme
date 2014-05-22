<?php

class wpcoProductsStyle extends wpCheckoutPlugin {

	var $model = 'ProductsStyle';
	var $controller = 'productsstyles';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'product_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'style_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'defaultoption'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'order'				=>	"INT(11) NOT NULL",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'product_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'style_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'defaultoption'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'order'				=>	array("INT(11)", "NOT NULL"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoProductsStyle($data = array()) {
		global $wpcoDb;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function find($conditions = array()) {
		global $wpdb;
		
		if (!empty($conditions)) {
			$query = "SELECT * FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				if (!empty($cval)) {
					$query .= " `" . $ckey . "` = '" . $cval . "'";
					
					if ($c < count($conditions)) {
						$query .= " AND";
					}
				}
				
				$c++;
			}
			list($orderfield, $orderdirection) = $order;
			$query .= " ORDER BY `" . $orderfield . "` " . $orderdirection . "";
			if ($productsstyle = $wpdb -> get_row($query)) {
				if (!empty($productsstyle)) {
					$this -> data = $this -> init_class($this -> model, $productsstyle);
					
					return $this -> data;
				}
			}
		}
		
		return false;
	}
	
	function find_all($conditions = array(), $fields = array(), $order = array('modified', "DESC"), $limit = false) {
		global $wpdb;
		
		$fields = (empty($fields)) ? "*" : implode(", ", $fields);
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
		list($orderfield, $orderdirection) = $order;
		$query .= " ORDER BY `" . $orderfield . "` " . $orderdirection . "";
		
		if ($productsstyles = $wpdb -> get_results($query)) {
			if (!empty($productsstyles)) {
				$this -> data = array();
				
				foreach ($productsstyles as $ps) {
					$this -> data[] = $this -> init_class($this -> model, $ps);
				}
				
				return $this -> data;
			}
		}
		
		return false;
	}
	
	function save($data = array(), $validate = true) {
		global $wpdb, $wpcoDb, $wpcoHtml;
		
		$defaults = array('created' => $wpcoHtml -> gen_date(), 'modified' => $wpcoHtml -> gen_date());
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		$r = wp_parse_args($data, $defaults);
		$this -> data = $wpcoHtml -> array_to_object($r);
		extract($r, EXTR_SKIP);
		
		if ($validate == true) {
			if (empty($product_id)) { $this -> errors['product_id'] = __('No product was specified', $this -> plugin_name); }
			if (empty($style_id)) { $this -> errors['style_id'] = __('No style was specified', $this -> plugin_name); }
		}
		
		if (empty($this -> errors)) {		
			$wpcoDb -> model = $this -> model;
			if (!$currps = $wpcoDb -> find(array('product_id' => $product_id, 'style_id' => $style_id))) {			
				$wpcoDb -> model = $this -> model;
				$query = (empty($id)) ? $wpcoDb -> insert_query($this -> model) : $wpcoDb -> update_query($this -> model);
				
				if ($wpdb -> query($query)) {
					return true;
				}
			} else {			
				$this -> data = (object) array('id' => $currps -> id, 'order' => $currps -> order, 'modified' => $wpcoHtml -> gen_date(), 'product_id' => $product_id, 'style_id' => $style_id, 'defaultoption' => $defaultoption);
				$query = $wpcoDb -> update_query($this -> model);
				
				if ($wpdb -> query($query)) {
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
				if (!empty($cval)) {
					$query .= " `" . $ckey . "` = '" . $cval . "'";
					
					if ($c < count($conditions)) {
						$query .= " AND";
					}
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