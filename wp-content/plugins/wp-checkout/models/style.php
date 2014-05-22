<?php

class wpcoStyle extends wpCheckoutPlugin {

	var $model = 'Style';
	var $controller = 'styles';
	var $table = '';
	var $insertid = '';
	var $data = array();
	
	var $id = '';
	var $title = '';
	var $created = '0000-00-00 00:00:00';
	var $modified = '0000-00-00 00:00:00';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'type'				=>	"ENUM('select','radio','checkbox') NOT NULL DEFAULT 'select'",
		'caption'			=>	"TEXT NOT NULL",
		'order'				=>	"INT(11) NOT NULL",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'title'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'type'				=>	array("ENUM('select','radio','checkbox')", "NOT NULL DEFAULT 'select'"),
		'caption'			=>	array("TEXT", "NOT NULL"),
		'order'				=>	array("INT(11)", "NOT NULL"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);

	function wpcoStyle($data = array()) {
		global $wpcoDb, $Option;	
		$this -> table = $this -> pre . $this -> controller;
	
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
			}
			
			$wpcoDb -> model = $Option -> model;
			if ($options = $wpcoDb -> find_all(array('style_id' => $this -> id), false, array('order', "ASC"))) {
				foreach ($options as $option) {
					$this -> options[] = $option;
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
	}
	
	function get($style_id = null) {
		global $wpdb;
		
		if (!empty($style_id)) {
			$query = "SELECT * FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE `id` = '" . $style_id . "'";
			
			if ($style = $wpdb -> get_row($query)) {
				if (!empty($style)) {
					$this -> data = $this -> init_class($this -> model, $style);					
					return $this -> data;
				}
			}
		}
		
		return false;
	}
	
	function select() {
		$select = array();
	
		if ($styles = $this -> find_all()) {
			foreach ($styles as $style) {
				$select[$style -> id] = $style -> title;
			}
		}
		
		return $select;
	}
	
	function field($name = null, $conditions = array()) {
		global $wpdb;
		
		if (!empty($name)) {
			if (!empty($conditions) && is_array($conditions)) {
				$query = "SELECT `" . $name . "` FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE";
				$c = 1;
				
				foreach ($conditions as $ckey => $cval) {
					$query .= " `" . $ckey . "` = '" . $cval . "'";
					
					if ($c < count($conditions)) {
						$query .= " AND";
					}
					
					$c++;
				}
				
				$query .= " LIMIT 1";
				
				if ($field = $wpdb -> get_var($query)) {
					return $field;
				}
			}
		}
	
		return false;
	}
	
	function find_all($conditions = array(), $fields = array(), $order = array('modified' => "DESC"), $limit = false) {
		global $wpdb;
		
		$fields = (empty($fields)) ? "*" : implode(", ", $fields);
		$query = "SELECT " . $fields . " FROM `" . $wpdb -> prefix . "" . $this -> table . "`";
		
		if ($styles = $wpdb -> get_results($query)) {
			if (!empty($styles)) {		
				$this -> data = array();
				
				foreach ($styles as $style) {
					$this -> data[] = $style;
				}
				
				return $this -> data;
			}
		}
		
		return false;
	}
	
	function save($data = array(), $validate = true) {
		global $wpdb, $wpcoHtml, $wpcoDb;
		
		$defaults = array('paid' => "N", 'created' => $wpcoHtml -> gen_date(), 'modified' => $wpcoHtml -> gen_date());
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		$r = wp_parse_args($data, $defaults);
		$this -> data = $wpcoHtml -> array_to_object($r);
		extract($r, EXTR_SKIP);
		
		if ($validate == true) {
			if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', $this -> plugin_name); }
			if (empty($type)) { $this -> errors['type'] = __('Please specify a field type', $this -> plugin_name); }
		}
		
		if (empty($this -> errors)) {
			$query = (empty($id)) ? $wpcoDb -> insert_query($this -> model) : $wpcoDb -> update_query($this -> model);
			
			if ($wpdb -> query($query)) {
				$this -> insertid = (empty($id)) ? $wpdb -> insert_id : $id;
				return true;
			}
		}
		
		return false;
	}
	
	function delete($style_id = '') {
		global $wpdb, $Option;
		
		if (!empty($style_id)) {
			$query = "DELETE FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE `id` = '" . $style_id . "' LIMIT 1";
			
			if ($wpdb -> query($query)) {
				$Option -> delete_all(array('style_id' => $style_id));
				
				return true;
			}
		}
		
		return false;
	}
	
	function delete_all($conditions = array()) {
		global $wpdb;
		
		if (!empty($conditions) && is_array($conditions)) {
			$query = "DELETE FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				$query .= " `" . $ckey . "` = '" . $cval . "'";
				
				if ($c < count($conditions)) {
					$query .= ", ";
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