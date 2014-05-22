<?php

class wpcoCategory extends wpCheckoutPlugin {

	var $model = 'Category';
	var $controller = 'categories';
	
	var $id = '';
	var $title = '';
	var $useimage = "N";
	var $image = '';
	var $name = '';
	var $description = '';
	var $keywords = '';
	var $parent_id = 0;
	var $created = '0000-00-00 00:00:00';
	var $modified = '0000-00-00 00:00:00';
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'title'				=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'useimage'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'image'				=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'name'				=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'description'		=>	"LONGTEXT NOT NULL",
		'keywords'			=>	"LONGTEXT NOT NULL",
		'parent_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'post_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'page_template'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'post_category'		=>	"TEXT NOT NULL",
		'wpcat_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'wpcat_parent'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'supplier_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'order'				=>	"INT(11) NOT NULL DEFAULT '0'",
		'pordertype'		=>	"VARCHAR(50) NOT NULL DEFAULT 'specific'",
		'porderfield'		=>	"VARCHAR(50) NOT NULL DEFAULT 'modified'",
		'porderdirection'	=>	"VARCHAR(50) NOT NULL DEFAULT 'DESC'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'title'				=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'useimage'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'image'				=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'name'				=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'description'		=>	array("LONGTEXT", "NOT NULL"),
		'keywords'			=>	array("LONGTEXT", "NOT NULL"),
		'parent_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'post_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'page_template'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'post_category'		=>	array("TEXT", "NOT NULL"),
		'wpcat_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'wpcat_parent'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'supplier_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'order'				=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'pordertype'		=>	array("VARCHAR(50)", "NOT NULL DEFAULT 'specific'"),
		'porderfield'		=>	array("VARCHAR(50)", "NOT NULL DEFAULT 'modified'"),
		'porderdirection'	=>	array("VARCHAR(50)", "NOT NULL DEFAULT 'DESC'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",					   
	);
	
	function wpcoCategory($data = array()) {
		global $wpcoDb, $wpcoHtml;
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
				
				switch ($dkey) {
					case 'post_category'		:
						$this -> post_category = unserialize($dval);
						break;
					case 'image'			:
						if (!empty($data -> useimage) && $data -> useimage == "Y") {
							$this -> image = array('name' => $dval);
							$this -> image = (object) $this -> image;
							
							if (empty($this -> image -> name)) {
								$this -> image_url = 'wp-content/plugins/' . $this -> plugin_name . '/images/noimage.jpg';
								$this -> noimage = true;
							} else {
								$this -> image_url = 'wp-content/uploads/' . $this -> plugin_name . '/catimages/' . $dval;
							}
						}
						break;
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
	}
	
	function hierarchy($parent_id = 0, $withul = true, $onlymain = false, $order = array('title', "ASC"), $productcount = "N") {
		global $wpdb, $Product, $Category, $wpcoCategoriesProduct, $wpcoDb, $category_hierarchy, $wpcoHtml;
		
		$wpcoDb -> model = $this -> model;
		if ($categories = $wpcoDb -> find_all(array('parent_id' => $parent_id), false, $order)) {
			if (!empty($categories)) {
				if ($withul) { $category_hierarchy .= '<ul id="' . $this -> pre . 'categories">'; }
			
				foreach ($categories as $category) {
					$countstring = '';
					if (!empty($productcount) && $productcount == "Y") {							
						$countquery = "SELECT COUNT(" . $wpdb -> prefix . $Product -> table . ".id) FROM " . $wpdb -> prefix . $Product -> table . 
						" LEFT JOIN " . $wpdb -> prefix . $wpcoCategoriesProduct -> table . 
						" ON " . $wpdb -> prefix . $Product -> table . ".id = " . $wpdb -> prefix . $wpcoCategoriesProduct -> table . ".product_id" . 
						" WHERE " . $wpdb -> prefix . $Product -> table . ".status = 'active' AND " . $wpdb -> prefix . $wpcoCategoriesProduct -> table . ".category_id = '" . $category -> id . "'";
						
						if ($count = $wpdb -> get_var($countquery)) {
							$countstring = ' (' . $count . ')';
						}
					}
				
					$category_hierarchy .= '<li>';
					$category_hierarchy .= $wpcoHtml -> link($category -> title, get_permalink($category -> post_id)) . $countstring;
					
					if (empty($onlymain) || $onlymain == false) {
						$this -> hierarchy($category -> id, $withul, $onlymain, $order);
					}
					
					$category_hierarchy .= '</li>';
				}
				
				if ($withul) { $category_hierarchy .= '</ul>'; }
			}
		}
		
		return $category_hierarchy;
	}
	
	function select($parent_id = 0, $mains = false, $order = array('title', "ASC")) {
		global $wpcoDb, $category_select, $select_pre;
		$wpcoDb -> model = $this -> model;
	
		if ($categories = $wpcoDb -> find_all(array('parent_id' => $parent_id), false, $order)) {
			if (!empty($categories)) {
				foreach ($categories as $category) {
					$category_select[$category -> id] = $select_pre . $category -> title;
					
					if ($mains == false) { 
						$select_pre .= '-';
						$this -> select($category -> id, $mains, $order); 
						$select_pre = substr($select_pre, 0, -1);
					}
				}
			}
		}
		
		return $category_select;
	}
	
	function field($name = null, $conditions = array()) {
		global $wpdb;
		
		if (!empty($name)) {
			if (!empty($conditions) && is_array($conditions)) {
				$query = "SELECT `" . $name . "` FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE";
				$c = 1;
				
				foreach ($conditions as $ckey => $cval) {
					if ($cval != "") {
						$query .= " `" . $ckey . "` = '" . $cval . "'";
					
						if ($c < count($conditions)) {
							$query .= ", ";
						}
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
	
	function get($category_id = null) {
		global $wpdb;
		
		if (!empty($category_id)) {
			$query = "SELECT * FROM `" . $wpdb -> prefix . $this -> pre . $this -> controller . "` WHERE `id` = '" . $category_id . "' LIMIT 1";
			
			if ($category = $wpdb -> get_row($query)) {
				$this -> data = $this -> init_class($this -> model, $category);
				
				return $this -> data;
			}
		}
	
		return false;
	}
	
	function find($conditions = array(), $fields = false, $order = array('title', "ASC"), $assign = false) {
		global $wpdb;
		
		$fields = "*";
		$query = "SELECT " . $fields . " FROM `" . $wpdb -> prefix . "" . $this -> table . "`";
		
		if (!empty($conditions)) {
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
		
		$order = (empty($order)) ? array('title', "ASC") : $order;
		list($ofield, $odir) = $order;
		$query .= " ORDER BY `" . $ofield . "` " . $odir . "";
		$query .= " LIMIT 1";
		
		if ($category = $wpdb -> get_row($query)) {
			if (!empty($category)) {
				$data = $this -> init_class($this -> model, $category);
				
				if ($assign == true) {
					$this -> data = $data;
				}
				
				return $data;
			}
		}
		
		return false;
	}
	
	function find_all($conditions = array(), $fields = false, $order = array('title' => "ASC"), $limit = false) {
		global $wpdb;
		
		$newfields = "*";
		if (!empty($fields)) { $newfields = $fields; }
		$query = "SELECT " . $newfields . " FROM `" . $wpdb -> prefix . $this -> pre . $this -> controller . "`";
		
		if (!empty($conditions)) {
			$query .= " WHERE";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				$query .= "`" . $ckey . "` = '" . $cval . "'";
				
				if ($c < count($conditions)) {
					$query .= ", ";
				}
				
				$c++;
			}
		}
		
		if ($categories = $wpdb -> get_results($query)) {
			if (!empty($categories)) {
				$data = array();
				
				foreach ($categories as $category) {
					$data[] = $this -> init_class($this -> model, $category);
				}
				
				return $data;
			}
		}
		
		return false;
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'useimage'			=>	"N",
			'parent_id'			=>	0,
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=>	$wpcoHtml -> gen_date()
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
			
			if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', $this -> plugin_name); }
		} else {
			$this -> errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
	
	function save($data = array(), $validate = true, $savepp = true) {
		global $wpdb, $wpcoDb, $wpcoHtml;
		$wpcoDb -> model = $this -> model;
		
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		$data['image'] = $wpcoHtml -> image_data('Category.image', $_FILES);
		$defaults = $this -> defaults();		
		$r = wp_parse_args($data, $defaults);
		$this -> data = $wpcoHtml -> array_to_object($r);
		extract($r, EXTR_SKIP);
		$dest_path = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'catimages' . DS;
		
		if ($validate == true) {
			if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', $this -> plugin_name); }
			if (empty($description)) { $this -> errors['description'] = __('Please fill in a description', $this -> plugin_name); }
			if (empty($keywords)) { $this -> errors['keywords'] = __('Please fill in some keywords', $this -> plugin_name); }
			
			if ($useimage == "Y") {
				$imagepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'catimages' . DS;
				$imagefull = $imagepath . $image -> name;
	
				if (!empty($oldimage) && empty($image -> name)) {
					$this -> data -> image -> name = $oldimage;
					$imagefull = $imagepath . $oldimage;
				} else {	
					$cropcatthumb = ($this -> get_option('cropcatthumbs') == "Y") ? true : false;
				
					if (empty($image -> name)) { $this -> errors['image'] = __('No image was chosen for uploading', $this -> plugin_name); }
					elseif (!is_uploaded_file($image -> tmp_name)) { $this -> errors['image'] = __('Image was not uploaded', $this -> plugin_name); }
					elseif (!move_uploaded_file($image -> tmp_name, $imagefull)) { $this -> errors['image'] = __('Image could not be moved', $this -> plugin_name); }
				}
			} else {
				$this -> data -> image = '';
			}
		}
		
		if (empty($this -> errors)) {
			if ($useimage == "Y") {
				$this -> data -> image = $this -> data -> image -> name;				
				@chmod($imagefull, 0777);
			}
		
			$this -> data -> post_category = (!empty($post_category) && is_array($post_category)) ? serialize($post_category) : '';
			$query = (empty($id)) ? $wpcoDb -> insert_query($this -> model) : $wpcoDb -> update_query($this -> model, true);
			
			if ($wpdb -> query($query)) {
				$this -> insertid = (empty($id)) ? $wpdb -> insert_id : $id;

				if ($this -> get_option('createpages') == "Y" && $savepp == true) {				
					$post_parent = (empty($parent_id)) ? $this -> get_option('pagesparent') : $this -> field('post_id', array('id' => $parent_id));
					$post_query = "SELECT `ID` FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $post_id . "'";
					$post_type = $this -> get_option('post_type');
					$category_post_type = ($post_type == "custom") ? 'product-category' : $post_type;
					
					//WordPress Categories
					if (!empty($parent_id)) {
						$wpcoDb -> model = $this -> model;
						$catparent = $wpcoDb -> find(array('id' => $parent_id));
						$parentpostid = $catparent -> post_id;
					} else {
						$parentpostid = false;
					}
					
					//WordPress Post/Page
					$page = array(
						'ID'				=>	($wpdb -> get_var($post_query)) ? $post_id : false,
						'post_status'		=>	'publish',
						'post_title'		=>	$title,
						'post_type'			=>	$category_post_type,
						'post_parent'		=>	(empty($parent_id)) ? $this -> get_option('pagesparent') : $parentpostid,
						'post_category'		=>	(empty($catarr['category_parent'])) ? array($this -> get_option('categoriesparent')) : array($catarr['category_parent']),
						'post_content'		=>	'[' . $this -> pre . 'category id=' . $this -> insertid . ']',
						'tags_input'		=>	$keywords,
					);
					
					if ($this -> get_option('pp_updatecontent') == "N" && !empty($post_id)) {
						if ($cur_page = $wpdb -> get_row("SELECT * FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $post_id . "' AND `post_status` = 'publish'")) {
							$page['post_content'] = $cur_page -> post_content;	
						}
					}
					
					if ($post_id = wp_insert_post($page)) {
						$wpcoDb -> model = $this -> model;
						$wpcoDb -> save_field('post_id', $post_id, array('id' => $this -> insertid));
						
						/* Page Template */
						if ($post_type == "page" || $post_type == "custom") {
							update_post_meta($post_id, '_wp_page_template', $page_template);	
						}
					}
				}
				
				return true;
			}
		}
		
		return false;
	}
	
	function delete($category_id = null) {
		global $wpdb, $Product;
	
		if (!empty($category_id)) {
			$query = "DELETE FROM `" . $wpdb -> prefix . $this -> table . "` WHERE `id` = '" . $category_id . "' LIMIT 1";
			
			if ($wpdb -> query($query)) {
				$Product -> delete_all(array('category_id' => $category_id));
			
				return true;
			}
		}
		
		return false;
	}
}

?>