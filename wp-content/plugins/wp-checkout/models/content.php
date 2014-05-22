<?php

class wpcoContent extends wpCheckoutPlugin {

	var $model = 'wpcoContent';
	var $controller = 'contents';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'content'			=>	"LONGTEXT NOT NULL",
		'product_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'title'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'content'			=>	array("LONGTEXT", "NOT NULL"),
		'product_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	var $data = array();
	var $errors = array();
	
	function wpcoContent($data = array()) {
		global $wpcoDb, $Product;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
				
				switch ($dkey) {
					case 'product_id'		:
						if (!empty($dval)) {
							$wpcoDb -> model = $Product -> model;
							//$this -> product = $wpcoDb -> find(array('id' => $dval));
						}
						break;
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'product_id'		=>	0,
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
			if (empty($content)) { $this -> errors['content'] = __('Please fill in content', $this -> plugin_name); }
			if (empty($product_id)) { $this -> errors['product_id'] = __('Please specify a product', $this -> plugin_name); }
		} else {
			$this -> errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
}

?>