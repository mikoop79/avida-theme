<?php

class wpcoOption extends wpCheckoutPlugin {

	var $model = 'Option';
	var $controller = 'options';
	var $table = '';
	var $recursive = true;
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'image'				=>	"TEXT NOT NULL",
		'style_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'addprice'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'price'				=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'operator'			=>	"ENUM('curr','perc') NOT NULL DEFAULT 'curr'",
		'symbol'			=>	"ENUM('+','-') NOT NULL DEFAULT '+'",
		'condprices'		=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'order'				=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'title'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'image'				=>	array("TEXT", "NOT NULL"),
		'style_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'addprice'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'price'				=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'operator'			=>	array("ENUM('curr', 'perc')", "NOT NULL DEFAULT 'curr'"),
		'symbol'			=>	array("ENUM('+','-')", "NOT NULL DEFAULT '+'"),
		'condprices'		=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'order'				=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoOption($data = array()) {
		global $wpdb, $wpcoDb, $wpcoOptionsOption;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);

				if ($this -> recursive == true) {				
					switch ($dkey) {
						case 'price'			:						
							if (!empty($data -> otheroptions)) {								
								$wpcoDb -> model = $wpcoOptionsOption -> model;
							
								if ($optionsoptions = $wpcoDb -> find_all(array('cond_id' => $this -> id))) {
									foreach ($optionsoptions as $oo) {									
										if (in_array($oo -> option_id, $data -> otheroptions)) {
											$this -> price = $oo -> price;
											break;
										}
									}
								}
							}
							break;
						case 'condprices'		:						
							if (!empty($dval) && $dval == "Y") {
								$wpcoDb -> model = $wpcoOptionsOption -> model;
							
								if ($optionsoptions = $wpcoDb -> find_all(array('cond_id' => $this -> id))) {							
									if (!empty($optionsoptions)) {
										$this -> styles = array();
										$this -> condoptions = array();
										$this -> condpricesa = array();
									
										foreach ($optionsoptions as $oo) {										
											$wpcoDb -> model = $this -> model;
											$this -> recursive = $Option -> recursive = false;
											
											$optionquery = "SELECT * FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE `id` = '" . $oo -> option_id . "' LIMIT 1";
											
											if ($option = $wpdb -> get_row($optionquery)) {
												$this -> condoptions[$option -> style_id][] = $option -> id;
												$this -> condpricesa[$option -> id] = $oo -> price;
												$this -> styles[] = $option -> style_id;
											}
										}
									}
								}
							}
							break;
						case 'image'			:
							$this -> image_url = 'wp-content/uploads/' . $this -> plugin_name . '/optionimages/' . $this -> image;
							break;
					}
				}
			}
		}
		$Option = new StdClass;
		$Option -> recursive = $this -> recursive = true;
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function price($option_id = null, $otheroptions = array(), $total = null) {
		global $wpcoDb;
		$price = '0.00';
		
		if (!empty($option_id)) {
			$wpcoDb -> model = $this -> model;
		
			if ($option = $wpcoDb -> find(array('id' => $option_id), false, array('id', "DESC"), true, array('otheroptions' => $otheroptions))) {			
				if (!empty($option -> addprice) && $option -> addprice == "Y") {
					if (!empty($option -> price) && is_numeric($option -> price)) {
						$price = number_format($option -> price, 2, '.', '');
						
						if (!empty($total)) {							
							if (!empty($option -> operator) && $option -> operator == "perc") {
								$newprice = (($total * $option -> price) / 100);
								$price = $newprice;
							} else {
								//do nothing...
							}
						} else {
							if (!empty($option -> operator) && $option -> operator == "perc") {
								return false;
							}
						}
					}
				}
				
				$price = $option -> symbol . $price;
			}
		}
		
		return $price;
	}
	
	function get($option_id = null) {
		global $wpdb;
		
		if (!empty($option_id)) {
			$query = "SELECT * FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE `id` = '" . $option_id . "'";
			
			if ($option = $wpdb -> get_row($query)) {
				if (!empty($option)) {
					$this -> data = $option;
					
					return $this -> data;
				}
			}
		}
		
		return false;
	}
	
	function validate($data = array()) {
		$this -> errors = array();

		if (!empty($data)) {		
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			extract($data, EXTR_SKIP);
			
			if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', $this -> plugin_name); }
			if (empty($style_id)) { $this -> errors['style_id'] = __('Please select a style', $this -> plugin_name); }
			
			if (!empty($addprice) && $addprice == "Y") {
				if (empty($price)) { $this -> errors['price'] = __('Please fill in a price', $this -> plugin_name); }
				elseif (!is_numeric($price)) { $this -> errors['price'] = __('Only (decimal) numbers are allowed', $this -> plugin_name); }
			}
			
			if (!empty($_FILES['optionimage']['name'])) {
				$optionimagename = $_FILES['optionimage']['name'];
				$optionimagepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'optionimages' . DS;
				$optionimagefull = $optionimagepath . $optionimagename;
				
				if (move_uploaded_file($_FILES['optionimage']['tmp_name'], $optionimagefull)) {
					$this -> data -> image = $optionimagename;
				} else {
					$this -> errors['image'] = __('Image could not be moved from TMP, please ask your hosting provider.', $this -> plugin_name);	
				}
			}
		} else {
			$this -> errors[] = __('No data was posted for validation', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
	
	function defaults() {
		global $wpcoHtml;
	
		$defaults = array(
			'condprices'		=>	"N",
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
	
	function save($data = array(), $validate = true) {
		global $wpdb, $wpcoHtml;
		
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		$defaults = array('created' => $wpcoHtml -> gen_date(), 'modified' => $wpcoHtml -> gen_date());
		$r = wp_parse_args($data, $defaults);
		$this -> data = $wpcoHtml -> array_to_object($r);
		extract($r, EXTR_SKIP);
		
		if ($validate == true) {
			if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', $this -> plugin_name); }
			if (empty($style_id)) { $this -> errors['style_id'] = __('Please select a style', $this -> plugin_name); }
		}
		
		if (empty($this -> errors)) {
			$query = $this -> insert_query($this -> model);
			
			if ($wpdb -> query($query)) {
				$this -> insertid = (empty($id)) ? $wpdb -> insert_id : $id;
				
				return true;
			}
		}
		
		return false;
	}
	
	function find_all($conditions = array()) {
		global $wpdb;
		
		$query = "SELECT * FROM `" . $wpdb -> prefix . "" . $this -> table . "`";
		
		if (!empty($conditions) && is_array($conditions)) {
			$query .= " WHERE";
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
			
			if ($options = $wpdb -> get_results($query)) {
				if (!empty($options)) {
					$this -> data = array();
					
					foreach ($options as $option) {
						$this -> data[] = stripslashes_deep($option);
					}
					
					return $this -> data;
				}
			}
		}
		
		return false;
	}
	
	function delete($option_id = '') {
		global $wpdb;
		
		if (!empty($option_id)) {
			$query = "DELETE FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE `id` = '" . $option_id . "'";
			
			if ($wpdb -> query($query)) {
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
	
	function count($conditions = array()) {
		global $wpdb;
		
		$query = "SELECT COUNT(`id`) FROM `" . $wpdb -> prefix . "" . $this -> table . "`";
		
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
		
		if ($count = $wpdb -> get_var($query)) {
			return $count;
		}
		
		return 0;
	}
}

?>