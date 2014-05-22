<?php

class wpcoSupplier extends wpCheckoutPlugin {

	var $model = 'Supplier';
	var $controller = 'suppliers';
	var $table = '';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'name'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'image'				=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'imagename'			=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'imagetype'			=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'imagesize'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'post_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'page_template'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'email'				=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'notify'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'order'				=>	"INT(11) NOT NULL DEFAULT '0'",
		'pordertype'		=>	"VARCHAR(50) NOT NULL DEFAULT 'specific'",
		'porderfield'		=>	"VARCHAR(50) NOT NULL DEFAULT 'modified'",
		'porderdirection'	=>	"VARCHAR(50) NOT NULL DEFAULT 'DESC'",
		'autoapprove'		=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'user_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'name'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'image'				=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'imagename'			=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'imagetype'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'imagesize'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'post_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'page_template'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'email'				=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'notify'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'order'				=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'pordertype'		=>	array("VARCHAR(50)", "NOT NULL DEFAULT 'specific'"),
		'porderfield'		=>	array("VARCHAR(50)", "NOT NULL DEFAULT 'modified'"),
		'porderdirection'	=>	array("VARCHAR(50)", "NOT NULL DEFAULT 'DESC'"),
		'autoapprove'		=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'user_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoSupplier($data = array()) {
		global $wpcoDb, $wpcoHtml;
		
		$this -> table = $this -> pre . $this -> controller;
	
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
				
				switch ($dkey) {
					case 'image'			:
						if (!empty($dval) && $dval == "Y") {
							if (!empty($data -> imagename)) {
								$this -> imagefile = (object) array('name' => $data -> imagename);
								$this -> image_url = 'wp-content/uploads/' . $this -> plugin_name . '/suppliers/' . $data -> imagename;
							}
						}
						break;
					case 'user_id'			:
						if ($userdata = get_userdata($dval)) {
							$this -> userdata = $userdata;
							$this -> username = $userdata -> user_login;
							$this -> wpemail = $userdata -> user_email;	
						}
						break;
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function select() {
		global $wpcoDb, $Product;
		
		$wpcoDb -> model = $this -> model;
		$select = array();
		
		if ($suppliers = $wpcoDb -> find_all(false, array('id', 'name'), array('name', "ASC"))) {
			foreach ($suppliers as $supplier) {
				$select[$supplier -> id] = $supplier -> name;
				
				$wpcoDb -> model = $Product -> model;
				$productscount = $wpcoDb -> count(array('supplier_id' => $supplier -> id));
				if (!empty($productscount)) { $select[$supplier -> id] .= ' (' . $productscount . ' ' . __('products', $this -> plugin_name) . ')'; }
			}
		}
		
		return $select;
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'notify'			=>	"N",
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
	
	function validate($data = array()) {
		global $wpcoHtml;
		$this -> errors = array();
	
		if (!empty($data)) {
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			$data['imagefile'] = $wpcoHtml -> image_data('Supplier.imagefile', $_FILES);			
			extract($data, EXTR_SKIP);
			
			if (empty($name)) { $this -> errors['name'] = __('Please fill in a name', $this -> plugin_name); }
			
			if (!empty($createlogin) && $createlogin == "Y") {
				if (empty($user_id)) {
					if (empty($username)) { $this -> errors['username'] = __('Please fill in a desired username for this supplier', $this -> plugin_name); }
					elseif (username_exists($username)) { $this -> errors['username'] = __('This username is already in use.', $this -> plugin_name); }
					if (empty($wpemail) || !is_email($wpemail)) { $this -> errors['wpemail'] = __('Please fill in a valid email address', $this -> plugin_name); }
					elseif (email_exists($wpemail)) { $this -> errors['wpemail'] = __('This email address is already in use.', $this -> plugin_name); }
				}
			}
			
			if (!empty($image) && $image == "Y") {					
				if (!empty($imagefile -> name)) {
					$imagename = $imagefile -> name;
					$imagepath = ABSPATH . 'wp-content' . DS . 'uploads' . DS . 'wp-checkout' . DS . 'suppliers' . DS;
					$imagefull = $imagepath . $imagename;
					
					//if (file_exists($imagefull)) { $this -> errors['imagefile'] = __('A supplier logo with this file name already exists', $this -> plugin_name); }
					if (!move_uploaded_file($imagefile -> tmp_name, $imagefull)) { $this -> errors['imagefile'] = __('Supplier logo could not be moved from TMP', $this -> plugin_name); }
					@chmod($imagefull, 0777);
				} else {
					if (empty($oldimage)) {
						$this -> errors['imagefile'] = __('Please choose a logo to upload', $this -> plugin_name);
					} else {
						$imagename = $oldimage;	
						$this -> data -> imagefile -> name = $oldimage;
					}
				}
			}
			
			if (!empty($notify) && $notify == "Y") {
				if (empty($email)) { $this -> errors['email'] = __('Please fill in an email address', $this -> plugin_name); }
				elseif (!is_email($email)) { $this -> errors['email'] = __('Please fill in a valid email address', $this -> plugin_name); }
			}
			
			if (empty($this -> errors)) {
				if (!empty($createlogin) && $createlogin == "Y") {
					if (empty($user_id)) {
						$password = wp_generate_password(12, false);
						
						if ($user_id = wp_create_user($username, $password, $wpemail)) {
							$wpuser = new WP_User($user_id);
							$wpuser -> set_role("supplier");
							$this -> data -> user_id = $user_id;
							wp_new_user_notification($user_id, $password);
						}
					} else {
						$newuserdata = array('ID' => $user_id, 'user_email' => $wpemail);
						wp_update_user($newuserdata);	
						$user = new WP_User($user_id);
						$user -> set_role("supplier");
					}
				} else {
					if (!empty($user_id)) {
						wp_delete_user($user_id);	
					}
				}
			}
		} else {
			$this -> errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
}

?>