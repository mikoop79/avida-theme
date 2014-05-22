<?php

class wpcoImage extends wpCheckoutPlugin {

	var $model = 'Image';
	var $controller = 'images';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'filename'			=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'filesize'			=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'filetype'			=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'product_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'title'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'filename'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'filesize'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'filetype'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'product_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoImage($data = array()) {
		global $wpcoHtml;
	
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
			}
			
			$this -> file = array(
				'name'				=>	$data -> filename,
				'size'				=>	$data -> filesize,
				'type'				=>	$data -> filetype,
			);
			
			$this -> file = $wpcoHtml -> array_to_object($this -> file);
			$this -> image_url = 'wp-content/uploads/' . $this -> plugin_name . '/images/' . $data -> filename;
		}
		
		return true;
	}
	
	function save($data = array(), $validate = true) {
		global $wpdb, $wpcoDb, $wpcoHtml;
		
		$dest_path = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS;
		$defaults = array('created' => $wpcoHtml -> gen_date(), 'modified' => $wpcoHtml -> gen_date());
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		$data['file'] = $wpcoHtml -> image_data('Image.file', $_FILES);
		$r = wp_parse_args($data, $defaults);
		$this -> data = $wpcoHtml -> array_to_object($r);
		extract($r, EXTR_SKIP);
		
		$filepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS;
		$filename = $wpcoHtml -> sanitize($title) . '-' . time() . '.' . $wpcoHtml -> strip_ext($file -> name);
		$filefull = $filepath . $filename;
		
		if (empty($oldfile) && empty($file -> name)) {
			$file -> name = time() . '.' . $wpcoHtml -> strip_ext($file -> name, "ext");	
		}
		
		if ($validate == true) {
			if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', $this -> plugin_name); }
			if (empty($product_id)) { $this -> errors['product_id'] = __('Please select a product', $this -> plugin_name); }	

			if (!empty($oldfile) && empty($file -> name)) {
				$this -> data -> file -> name = $filename = $oldfile;
				$this -> data -> file -> size = $oldsize;
				$this -> data -> file -> type = $oldtype;
				$filefull = $filepath . $oldfile;
			} else {
				@unlink($filepath . $oldfile);
				@unlink($filepath . $wpcoHtml -> strip_ext($oldfile, 'name') . '-small.' . $wpcoHtml -> strip_ext($oldfile, 'ext'));
				@unlink($filepath . $wpcoHtml -> strip_ext($oldfile, 'name') . '-thumb.' . $wpcoHtml -> strip_ext($oldfile, 'ext'));
					
				if (empty($file -> name)) { $this -> errors['file'] = __('No file was chosen for uploading', $this -> plugin_name); }
				elseif (!is_uploaded_file($file -> tmp_name)) { $this -> errors['file'] = __('File could not be uploaded', $this -> plugin_name); }
				elseif (!move_uploaded_file($file -> tmp_name, $filefull)) { $this -> errors['file'] = __('File cannot be moved', $this -> plugin_name); }
				@chmod($filefull, 0777);
			}
		}
		
		if (empty($this -> errors)) {		
			$this -> data -> filename = $filename;
			$this -> data -> filesize = $file -> size;
			$this -> data -> filetype = $file -> type;
		
			$query = (empty($this -> data -> id)) ? $wpcoDb -> insert_query($this -> model) : $wpcoDb -> update_query($this -> model);
			
			if ($wpdb -> query($query)) {
				$this -> insertid = (empty($id)) ? $wpdb -> insert_id : $id;
				return true;
			}
		}
		
		return false;
	}
	
	function get($image_id = '') {
		global $wpdb;
		
		if (!empty($image_id)) {
			$query = "SELECT * FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE `id` = '" . $image_id . "'";
			
			if ($image = $wpdb -> get_row($query)) {
				if (!empty($image)) {
					$this -> data = $this -> init_class($this -> model, $image);
					
					return $this -> data;
				}
			}
		}
		
		return false;
	}
}

?>