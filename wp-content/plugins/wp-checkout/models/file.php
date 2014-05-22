<?php

class wpcoFile extends wpCheckoutPlugin {

	var $model = 'File';
	var $controller = 'files';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'				=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'downloads'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'product_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'type'				=>	"ENUM('file','link') NOT NULL DEFAULT 'file'",
		'url'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'filename'			=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'filesize'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'filetype'			=>	"VARCHAR(50) NOT NULL DEFAULT ''",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'title'				=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'downloads'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'product_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'type'				=>	array("ENUM('file','link')", "NOT NULL DEFAULT 'file'"),
		'url'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'filename'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'filesize'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'filetype'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT ''"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoFile($data = array()) {
		global $wpcoDb, $Product;
	
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = $dval;
				
				switch ($dkey) {
					case 'product_id'		:
						$wpcoDb -> model = $Product -> model;
						$this -> product = $wpcoDb -> find(array('id' => $dval));
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
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
	
	function validate($data = array()) {	
		$this -> errors = array();
		
		$filepath = WP_CONTENT_DIR . '/uploads/' . $this -> plugin_name . '/downloads/';
		$filename = $_FILES['File']['name']['file'];
		$filefull = $filepath . $filename;
		
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		extract($data, EXTR_SKIP);
		
		if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', $this -> plugin_name); }
		if (empty($product_id)) { $this -> errors['product_id'] = __('Please select a product', $this -> plugin_name); }
	
		if (empty($type)) { $this -> errors['type'] = __('Please specify a file type', $this -> plugin_name); }
		else {
			if ($type == "file") {
				if (!empty($oldfile) && empty($_FILES['File']['name']['file'])) {
					$this -> data -> filename = $oldfile;
					$this -> data -> filesize = $oldsize;
					$this -> data -> filetype = $oldtype;
				} else {		
					if (empty($_FILES['File']['name']['file'])) { $this -> errors['file'] = __('No file was chosen for uploading', $this -> plugin_name); }
					elseif (file_exists($filefull)) { $this -> errors['file'] = __('File with this filename already exists', $this -> plugin_name); }
					elseif (!is_uploaded_file($_FILES['File']['tmp_name']['file'])) { $this -> errors['file'] = __('File could not be uploaded', $this -> plugin_name); }
					elseif (!move_uploaded_file($_FILES['File']['tmp_name']['file'], $filefull)) { $this -> errors['file'] = __('File could not be moved', $this -> plugin_name); }
					
					$this -> data -> filename = $_FILES['File']['name']['file'];
					$this -> data -> filesize = $_FILES['File']['size']['file'];
					$this -> data -> filetype = $_FILES['File']['type']['file'];
				}
			} else {
				if (empty($url)) { $this -> errors['url'] = __('Please specify a download link/url', $this -> plugin_name); }
			}
		}
		
		return $this -> errors;
	}
}

?>