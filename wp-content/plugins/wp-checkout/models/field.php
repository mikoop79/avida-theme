<?php

class wpcoField extends wpCheckoutPlugin {

	var $model = 'wpcoField';
	var $controller = 'fields';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'slug'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'type'				=>	"VARCHAR(50) NOT NULL DEFAULT 'text'",
		'fieldoptions'		=>	"TEXT NOT NULL",
		'mindate'			=>	"TEXT NOT NULL",
		'mindateop'			=>	"TEXT NOT NULL",
		'maxdate'			=>	"TEXT NOT NULL",
		'maxdateop'			=>	"TEXT NOT NULL",
		'activedays'		=>	"VARCHAR(20) NOT NULL DEFAULT '1,2,3,4,5,6,0'",
		'required'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'error'				=>	"TEXT NOT NULL",
		'addprice'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'price'				=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'globalf'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'globalp'			=>	"ENUM('cart','ship','bill') NOT NULL DEFAULT 'cart'",
		'order'				=>	"INT(11) NOT NULL DEFAULT '999'",
		'caption'			=>	"TEXT NOT NULL",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'title'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'slug'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'type'				=>	array("VARCHAR(50)", "NOT NULL DEFAULT 'text'"),
		'fieldoptions'		=>	array("TEXT", "NOT NULL"),
		'mindate'			=>	array("TEXT", "NOT NULL"),
		'mindateop'			=>	array("TEXT", "NOT NULL"),
		'maxdate'			=>	array("TEXT", "NOT NULL"),
		'maxdateop'			=>	array("TEXT", "NOT NULL"),
		'activedays'		=>	array("VARCHAR(20)", "NOT NULL DEFAULT '1,2,3,4,5,6,0'"),
		'required'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'error'				=>	array("TEXT", "NOT NULL"),
		'addprice'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'price'				=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'globalf'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'globalp'			=>	array("ENUM('cart','ship','bill')", "NOT NULL DEFAULT 'cart'"),
		'order'				=>	array("INT(11)", "NOT NULL DEFAULT '999'"),
		'caption'			=>	array("TEXT", "NOT NULL"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",				
	);
	
	function wpcoField($data = array()) {
		global $wpcoDb;
		$this -> table = $this -> pre . $this -> controller;
	
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
				
				switch ($dkey) {
					case 'error'		:
						if (empty($dval)) {
							$this -> error = __('Please fill in', $this -> plugin_name) . ' ' . $this -> title;
						}
						break;
				}
			}
			
			$this -> products = array();
			$wpcoDb -> model = 'wpcoFieldsProduct';
			if ($fieldsproducts = $wpcoDb -> find_all(array('field_id' => $this -> id))) {
				foreach ($fieldsproducts as $fp) {
					$this -> products[] = $fp -> product_id;
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function globalfields($position = false) {
		global $wpcoDb;
		$conditions = array('globalf' => "Y");
		if (!empty($position) && $position != false) { $conditions['globalp'] = "cart"; }
		
		$wpcoDb -> model = $this -> model;
		$globalfields = $wpcoDb -> find_all($conditions);
		
		return $globalfields;
	}
	
	function get_value($field_id = null, $value = null, $onlyurl = false) {
		if (!empty($field_id)) {
			if (!empty($value) || $value == "0") {
				global $wpcoDb, $wpcoHtml;
				$wpcoDb -> model = $this -> model;
			
				if ($field = $wpcoDb -> find(array('id' => $field_id))) {
					if ($field -> type == "select" || $field -> type == "checkbox" || $field -> type == "radio" || $field -> type == "file") {
						$fieldoptions = maybe_unserialize($field -> fieldoptions);
					
						switch ($field -> type) {
							case 'select'			:
								return $fieldoptions[($value - 1)];
								break;
							case 'checkbox'			:
								if (($checkboxes = maybe_unserialize($value)) !== false) {
									$return = '';
									$c = 1;
								
									foreach ($checkboxes as $checkbox) {
										$return .= '&raquo; ' . $fieldoptions[($checkbox - 1)];
										
										if ($c < count($checkboxes)) {
											$return .= "<br/>";
										}
									}
									
									return $return;
								} else {
									return $value;
								}
								break;
							case 'radio'			:
								return $fieldoptions[($value - 1)];
								break;
							case 'file'				:
								return $wpcoHtml -> file_custom_field($value, false, false, $onlyurl);
								break;
						}
					} else {
						return stripslashes_deep($value);
					}
				}
			}
		}
		
		return __('none', $this -> plugin_name);
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'type'				=>	"text",
			'required'			=>	"N",
			'globalf'			=>	"N",
			'globalp'			=>	"cart",
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
	
		if (!empty($data)) {		
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			extract($data, EXTR_SKIP);
			
			if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', $this -> plugin_name); }
			
			if (empty($type)) { $this -> errors['type'] = __('Please select a field type', $this -> plugin_name); }
			elseif (($type == "select" || $type == "checkbox" || $type == "radio") && empty($fieldoptions)) { $this -> errors['options'] = __('Please type some options for this field', $this -> plugin_name); }
			
			if (empty($required)) { $this -> errors['required'] = __('Please select a required status', $this -> plugin_name); }
			elseif ($required == "Y" && empty($error)) { $this -> errors['error'] = __('Please fill in an error message', $this -> plugin_name); }
		} else {
			$this -> errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
}

?>