<?php

class wpcoProduct extends wpCheckoutPlugin {
	
	var $model = 'Product';
	var $controller = 'products';
	var $table;
	var $recursive = true;
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'code'				=>	"TEXT NOT NULL",
		'title'				=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'nicetitle'			=>	"VARCHAR(100) NOT NULL DEFAULT ''",
		'description'		=>	"LONGTEXT NOT NULL",
		'keywords'			=>	"LONGTEXT NOT NULL",
		'image'				=>	"VARCHAR(100) NOT NULL DEFAULT 'noimage.jpg'",
		'buttontext'		=>	"TEXT NOT NULL",
		'price'				=>	"TEXT NOT NULL",
		'price_type'		=>	"ENUM('fixed','tiers','donate','square') NOT NULL DEFAULT 'fixed'",
		'donate_caption'	=>	"TEXT NOT NULL",
		'donate_min'		=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'inhonorof'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'inhonorofreq'		=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'square_price'		=>	"TEXT NOT NULL",
		'square_price_text'	=>	"TEXT NOT NULL",
		'sq_w_min'			=>	"TEXT NOT NULL",
		'sq_w_max'			=>	"TEXT NOT NULL",
		'sq_l_min'			=>	"TEXT NOT NULL", 
		'sq_l_max'			=>	"TEXT NOT NULL",
		'price_display'		=>	"ENUM('low','high') NOT NULL DEFAULT 'high'",
		'taxincluded'		=>	"INT(1) NOT NULL DEFAULT '0'",
		'sprice'			=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'wholesale'			=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'taxexempt'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'taxoverride'		=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'taxrate'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'taxrates'			=>	"TEXT NOT NULL",
		'excludeglobal'		=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'shipping'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'shiptype'			=>	"ENUM('fixed','percentage','tiers') NOT NULL DEFAULT 'fixed'",
		'shippercmethod'	=>	"ENUM('fixed','wholesale') NOT NULL DEFAULT 'fixed'",
		'shipprice'			=>	"FLOAT(12,2) NOT NULL DEFAULT '0.00'",
		'shipfixed'			=>	"TEXT NOT NULL",
		'shippercentage'	=>	"TEXT NOT NULL",
		'shiptiers'			=>	"TEXT NOT NULL",
		'type'				=>	"ENUM('digital','tangible') NOT NULL DEFAULT 'tangible'",
		'featured'			=>	"VARCHAR(10) NOT NULL DEFAULT '0'",
		'affiliate'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'affiliateurl'		=>	"TEXT NOT NULL",
		'affiliatewindow'	=>	"ENUM('self','blank') NOT NULL DEFAULT 'blank'",
		'affiliatehits'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'min_order'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'inventory'			=>	"INT(11) NOT NULL DEFAULT '-1'",
		'measurement'		=>	"VARCHAR(50) NOT NULL DEFAULT 'units'",
		'lengthmeasurement'	=>	"VARCHAR(10) NOT NULL DEFAULT 'cm'",
		'weight'			=>	"VARCHAR(50) NOT NULL DEFAULT '0'",
		'width'				=>	"VARCHAR(50) NOT NULL DEFAULT '0'",
		'length'			=>	"VARCHAR(50) NOT NULL DEFAULT '0'",
		'height'			=>	"VARCHAR(50) NOT NULL DEFAULT '0'",
		'category_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'supplier_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'p_type'			=>  "VARCHAR(20) NOT NULL DEFAULT 'custom'",
		'post_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'post_category'		=>	"TEXT NOT NULL",
		'post_password'		=>	"VARCHAR(30) NOT NULL DEFAULT ''",
		'comment_status'	=>	"ENUM('open', 'closed') NOT NULL DEFAULT 'open'",
		'vtax'				=>	"ENUM('Y','N') NOT NULL DEFAULT 'Y'",
		'vtreatasone'		=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'vcalculation'		=>	"ENUM('orig','accum') NOT NULL DEFAULT 'orig'",
		'readytoship'		=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'page_template'		=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'user_id'			=>	"INT(11) NOT NULL DEFAULT '0'",
		'showcase'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'showcasemsg'		=>	"VARCHAR(250) NOT NULL DEFAULT ''",
		'buynow'			=>	"ENUM('Y','N') NOT NULL DEFAULT 'N'",
		'order'				=>	"INT(11) NOT NULL DEFAULT '0'",
		'supplier_order'	=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`)",
		'status'			=>	"ENUM('active','inactive') NOT NULL DEFAULT 'active'",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'code'				=>	array("TEXT", "NOT NULL"),
		'title'				=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'nicetitle'			=>	array("VARCHAR(100)", "NOT NULL DEFAULT ''"),
		'description'		=>	array("LONGTEXT", "NOT NULL"),
		'keywords'			=>	array("LONGTEXT", "NOT NULL"),
		'image'				=>	array("VARCHAR(100)", "NOT NULL DEFAULT 'noimage.jpg'"),
		'buttontext'		=>	array("TEXT", "NOT NULL"),
		'price'				=>	array("TEXT", "NOT NULL"),
		'price_type'		=>	array("ENUM('fixed','tiers','donate','square')", "NOT NULL DEFAULT 'fixed'"),
		'donate_caption'	=>	array("TEXT", "NOT NULL"),
		'donate_min'		=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'inhonorof'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'inhonorofreq'		=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'square_price'		=>	array("TEXT", "NOT NULL"),
		'square_price_text'	=>	array("TEXT", "NOT NULL"),
		'sq_w_min'			=>	array("TEXT", "NOT NULL"),
		'sq_w_max'			=>	array("TEXT", "NOT NULL"),
		'sq_l_min'			=>	array("TEXT", "NOT NULL"), 
		'sq_l_max'			=>	array("TEXT", "NOT NULL"),
		'price_display'		=>	array("ENUM('low','high')", "NOT NULL DEFAULT 'high'"),
		'taxincluded'		=>	array("INT(1)", "NOT NULL DEFAULT '0'"),
		'sprice'			=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'wholesale'			=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'taxexempt'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'taxoverride'		=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'taxrate'			=> 	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'taxrates'			=>	array("TEXT", "NOT NULL"),
		'excludeglobal'		=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'shipping'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'shiptype'			=>	array("ENUM('fixed','tiers','percentage')", "NOT NULL DEFAULT 'fixed'"),
		'shippercmethod'	=>	array("ENUM('fixed','wholesale')", "NOT NULL DEFAULT 'fixed'"),
		'shipprice'			=>	array("FLOAT(12,2)", "NOT NULL DEFAULT '0.00'"),
		'shipfixed'			=>	array("TEXT", "NOT NULL"),
		'shippercentage'	=>	array("TEXT", "NOT NULL"),
		'shiptiers'			=>	array("TEXT", "NOT NULL"),
		'type'				=>	array("ENUM('digital','tangible')", "NOT NULL DEFAULT 'tangible'"),
		'featured'			=>	array("VARCHAR(10)", "NOT NULL DEFAULT '0'"),
		'affiliate'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'affiliateurl'		=>	array("TEXT", "NOT NULL"),
		'affiliatewindow'	=>	array("ENUM('self','blank')", "NOT NULL DEFAULT 'blank'"),
		'affiliatehits'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'min_order'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'inventory'			=>	array("INT(11)", "NOT NULL DEFAULT '-1'"),
		'measurement'		=>	array("VARCHAR(50)", "NOT NULL DEFAULT 'units'"),
		'lengthmeasurement'	=>	array("VARCHAR(10)", "NOT NULL DEFAULT 'cm'"),
		'weight'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT '0'"),
		'width'				=>	array("VARCHAR(50)", "NOT NULL DEFAULT '0'"),
		'length'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT '0'"),
		'height'			=>	array("VARCHAR(50)", "NOT NULL DEFAULT '0'"),
		'category_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'supplier_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'p_type'			=>	array("VARCHAR(20)", "NOT NULL DEFAULT 'custom'"),
		'post_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'post_category'		=>	array("TEXT", "NOT NULL"),
		'post_password'		=>	array("VARCHAR(30)", "NOT NULL DEFAULT ''"),
		'comment_status'	=>	array("ENUM('open', 'closed')", "NOT NULL DEFAULT 'open'"),
		'page_template'		=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'vtax'				=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'Y'"),
		'vtreatasone'		=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'vcalculation'		=>	array("ENUM('orig','accum')", "NOT NULL DEFAULT 'orig'"),
		'readytoship'		=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'user_id'			=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'showcase'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'showcasemsg'		=> 	array("VARCHAR(250)", "NOT NULL DEFAULT ''"),
		'buynow'			=>	array("ENUM('Y','N')", "NOT NULL DEFAULT 'N'"),
		'order'				=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'supplier_order'	=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`)",	
		'status'			=>	array("ENUM('active','inactive')", "NOT NULL DEFAULT 'active'"),
	);
	
	function wpcoProduct($data = array()) {
		global $wpdb, $wpcoHtml, $wpcoKeyword, $Image, $wpcoDb, $wpcoContent, 
		$Category, $wpcoCategoriesProduct, $Supplier, $Option, $ProductsStyle, 
		$wpcoTax, $Order, $ProductsOption, $wpcoProductsProduct;	
		$this -> table = $this -> pre . $this -> controller;
	
		if (!empty($data)) {		
			foreach ($data as $dkey => $val) {
				$this -> {$dkey} = stripslashes_deep($val);
			
				switch ($dkey) {
					case 'inventory'		:
						$this -> oos = false;
						if (empty($val) && ($val != "999" || $val >= 0)) {
							$this -> oos = true;
						} 
						break;
					case 'price'			:
						if ($data -> price_type == "tiers") {
							$val = unserialize($val);
							$this -> price_tiers = $val;
						} else {
							$newval = $val;
							$this -> price_fixed = $newval;
						}
						break;
					case 'image'			:
						$this -> image = array('name' => $val);
						$this -> image = $wpcoHtml -> array_to_object($this -> image);
						
						if (empty($this -> image -> name)) {
							$this -> image_url = 'wp-content/plugins/' . $this -> plugin_name . '/images/noimage.jpg';
							$this -> noimage = true;
						} else {
							$this -> image_url = 'wp-content/uploads/' . $this -> plugin_name . '/images/' . $this -> image -> name;
						} 
						break;
					case 'supplier_id'		:
						if (!empty($val)) {
							if ($this -> recursive == true) {
								$wpcoDb -> model = $Supplier -> model;
								$this -> supplier = $wpcoDb -> find(array('id' => $val));
							}
						}
						break;
					case 'shipfixed'		:
						$this -> shipfixed = maybe_unserialize($val);
						break;
					case 'shippercentage'	:
						$this -> shippercentage = maybe_unserialize($val);
						break;
					case 'shiptiers'		:
						$this -> shiptiers = maybe_unserialize($val);
						break;
					case 'buttontext'		:
						if (empty($this -> buttontext)) {
							$this -> buttontext = stripslashes($this -> get_option('loop_btnlnktext'));	
						}
						break;
				}
			}

			if ($this -> recursive == true) {			
				$product_keywords = true;
				$product_fields = true;
				$product_images = true;
				$product_options = true;
				$product_styles = true;
				$product_inventory = true;
				$product_categories = true;
				$product_contents = true;
				$product_related = true;
			
				if (!is_admin()) {				
					if (wpco_is_category()) {
						global $displaygrid;
						$product_inventory = false;
						
						if ($displaygrid) {
							$product_keywords = false;
							$product_fields = false;
							$product_images = false;
							$product_options = false;
							$product_styles = false;
							$product_categories = false;
							$product_contents = false;
							$product_related = false;
						} else {
							$product_images = false;
							$product_categories = false;
							$product_contents = false;
							$product_related = false;
						}
					} elseif (wpco_is_checkout()) {	
						$product_inventory = false;				
						$product_keywords = false;
						$product_images = false;
						$product_categories = false;
						$product_contents = false;
						$product_related = false;
					}
				}

				/* Product Keywords */
				if ($product_keywords) {
					$this -> kws = array();
					$wpcoDb -> model = $wpcoKeyword -> model;
					if ($kws = $wpcoDb -> find_all(array('product_id' => $this -> id), array('keyword'))) {
						foreach ($kws as $kw) {
							$this -> kws[] = $kw -> keyword;
						}
					}
				}
				
				/* Product Fields */
				if ($product_fields) {
					global $wpcoDb, $wpcoField, $wpcoFieldsProduct;
					$this -> cfields = array();
					
					$fields_table = $wpdb -> prefix . $wpcoField -> table;
					$fieldsproduct_table = $wpdb -> prefix . $wpcoFieldsProduct -> table;
					
					$fieldsproductsquery = "SELECT " . $fieldsproduct_table . ".field_id FROM " . $fieldsproduct_table . " LEFT JOIN " . $fields_table . 
					" ON " . $fields_table . ".id = " . $fieldsproduct_table . ".field_id WHERE " . $fieldsproduct_table . ".product_id = '" . $this -> id . "' ORDER BY " . $fields_table . ".order ASC";
					
					if ($fieldsproducts = $wpdb -> get_results($fieldsproductsquery)) {
						foreach ($fieldsproducts as $fp) {
							$this -> cfields[] = $fp -> field_id;
						}
					}				
				}
				
				/* Product Images */
				if ($product_images) {
					$imagesquery = "SELECT `id`, `title`, `filename` FROM " . $wpdb -> prefix . $Image -> table . " WHERE `product_id` = '" . $data -> id . "'";
					if ($images = $wpdb -> get_results($imagesquery)) {
						if (!empty($images)) {
							$i = 0;
						
							foreach ($images as $image) {
								$image = array(
									'title'					=>	stripslashes($image -> title),
									'filename'				=>	$image -> filename,
								);
								
								$this -> images[$i] = $wpcoHtml -> array_to_object($image);
								$this -> images[$i] -> image_url = 'wp-content/uploads/' . $this -> plugin_name . '/images/' . $image['filename'];
								
								$i++;
							}
						}
					}
				}

				/* Product Options */				
				if ($product_options) {
					$productsoptionsquery = "SELECT `option_id` FROM " . $wpdb -> prefix . $ProductsOption -> table . " WHERE `product_id` = '" . $data -> id . "'";
					if ($productsoptions = $wpdb -> get_results($productsoptionsquery)) {
						$currentoptions = array();					
						foreach ($productsoptions as $po) {
							$currentoptions[] = $po -> option_id;
						}
					}						
				}

				/* Product Styles */
				if ($product_styles) {
					if ($productsstyles = $ProductsStyle -> find_all(array('product_id' => $data -> id), array('style_id', 'defaultoption'), array('order', "ASC"))) {
						foreach ($productsstyles as $ps) {
							$this -> styles[] = $ps -> style_id;
							$this -> styledefault[$ps -> style_id] = $ps -> defaultoption;
							
							$wpcoDb -> model = $Option -> model;
							if ($options = $wpcoDb -> find_all(array('style_id' => $ps -> style_id), false, array('order', "ASC"))) {
								foreach ($options as $option) {
									if (!empty($currentoptions) && is_array($currentoptions) && in_array($option -> id, $currentoptions)) {
										$this -> options[$ps -> style_id][] = $option -> id;
										
										if ($product_inventory) {
											$productsoptionquery = "SELECT `inventory` FROM `" . $wpdb -> prefix . $ProductsOption -> table . "` WHERE `product_id` = '" . $this -> id . "' AND `option_id` = '" . $option -> id . "'";
											$inventory = $wpdb -> get_var($productsoptionquery);
											$this -> optionstock[$option -> id] = (($inventory >= 0) ? $inventory : '-1');
										}
									}
								}
							}
						}
					}
				}
				
				/* Product Categories */
				if ($product_categories) {
					$this -> categories = array();
					$categoriesproductsquery = "SELECT `category_id` FROM " . $wpdb -> prefix . $wpcoCategoriesProduct -> table . " WHERE `product_id` = '" . $this -> id . "'";
					if ($categoriesproducts = $wpdb -> get_results($categoriesproductsquery)) {
						foreach ($categoriesproducts as $cp) {
							$this -> categories[] = $cp -> category_id;
						}
					}
				}
				
				/* Product Contents */
				if ($product_contents) {
					$wpcoDb -> model = $wpcoContent -> model;
					$this -> contents = $wpcoDb -> find_all(array('product_id' => $this -> id), null, array('id', "ASC"));
				}
				
				/* Product Related */
				if ($product_related) {
					$relatedquery = "SELECT pp.related_id FROM " . $wpdb -> prefix . $wpcoProductsProduct -> table . " pp WHERE pp.product_id = '" . $this -> id . "' ORDER BY pp.order ASC";
					$this -> related = $wpdb -> get_results($relatedquery);
				}
			}
		}
		
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function duplicate($product_id = null) {
		global $wpdb, $wpcoHtml, $Category, $wpcoDb, $wpcoCategoriesProduct;
	
		if (!empty($product_id)) {
			$wpcoDb -> model = $this -> model;
			$oldproduct = $wpcoDb -> find(array('id' => $product_id));
		
			$fields = $this -> fields;
			unset($fields['id']);
			unset($fields['key']);
			$query = "INSERT INTO `" . $wpdb -> prefix . $this -> table . "` (";
			$q = 1;			
			foreach ($fields as $field => $attributes) {
				$query .= "`" . $field . "`";
				if ($q < count($fields)) { $query .= ", "; }
				$q++;
			}
			$query .= ")";
			unset($fields['created']); unset($fields['modified']);
			$query .= " SELECT ";
			$p = 1;
			foreach ($fields as $field => $attributes) {
				$query .= "`" . $field . "`";
				if ($p < count($fields)) { $query .= ", "; }
				$p++;
			}
			$query .= ", '" . $wpcoHtml -> gen_date() . "', '" . $wpcoHtml -> gen_date() . "'";
			$query .= " FROM `" . $wpdb -> prefix . $this -> table . "` WHERE `id` = '" . $product_id . "'";
			
			if ($wpdb -> query($query)) {
				$insertid = $wpdb -> insert_id;
				
				$wpcoDb -> model = $this -> model;
				$product = $wpcoDb -> find(array('id' => $insertid));
				
				if (!empty($oldproduct -> categories)) {
					foreach ($oldproduct -> categories as $category_id) {
						$wpcoDb -> model = $wpcoCategoriesProduct -> model;
						$wpcoDb -> save(array('product_id' => $insertid, 'category_id' => $category_id));
					}
				}
			
				//Create the product's post/page as needed
				if ($this -> get_option('createpages') == "Y") {					
					$page = array(
						'ID'				=>	false,
						'post_title'		=>	$oldproduct -> title,
						'post_name'			=>	$wpcoHtml -> sanitize($oldproduct -> title),
						'post_content'		=>	'[' . $this -> pre . 'product id="' . $insertid . '"]',
						'post_parent'		=>	false,
						'post_category'		=>	false,
						'post_status'		=>	"publish",
						'post_type'			=>	"product",
						'tags_input'		=>	$oldproduct -> kws,
					);
					
					if ($post_id = wp_insert_post($page)) {						
						global $wp_rewrite;
						$wp_rewrite -> flush_rules();
					}
					
					$wpdb -> query("UPDATE `" . $wpdb -> prefix . $this -> table . "` SET `status` = 'active', `post_id` = '" . $post_id . "', `p_type` = 'custom' WHERE `id` = '" . $insertid . "'");
				}
			
				return $insertid;
			}
		}
		
		return false;
	}
	
	function mass($action = null, $products = null) {
		if (!empty($action)) {
			if (!empty($products)) {
				global $wpdb;
				
				switch ($action) {
					case 'ptypepost'					:
						foreach ($products as $product_id) {
							$productquery = "UPDATE " . $wpdb -> prefix . $this -> table . " SET p_type = 'post', modified = '" . date("Y-m-d H:i:s", time()) . "' WHERE id = '" . $product_id . "' LIMIT 1";
							$wpdb -> query($productquery);
							$postidquery = "SELECT post_id FROM " . $wpdb -> prefix . $this -> table . " WHERE id = '" . $product_id . "'";
							$post_id = $wpdb -> get_var($postidquery);
							$postquery = "UPDATE " . $wpdb -> posts . " SET post_type = 'post' WHERE `ID` = '" . $post_id . "'";
							$wpdb -> query($postquery);
							wp_set_post_categories($post_id, $_POST['postcategories']);
						}
						
						global $wp_rewrite;
						$wp_rewrite -> flush_rules();
						
						return true;
						break;
					case 'ptypepage'					:
						foreach ($products as $product_id) {
							$productquery = "UPDATE " . $wpdb -> prefix . $this -> table . " SET p_type = 'page', modified = '" . date("Y-m-d H:i:s", time()) . "' WHERE id = '" . $product_id . "' LIMIT 1";
							$wpdb -> query($productquery);
							$postidquery = "SELECT post_id FROM " . $wpdb -> prefix . $this -> table . " WHERE id = '" . $product_id . "'";
							$post_id = $wpdb -> get_var($postidquery);
							$postquery = "UPDATE " . $wpdb -> posts . " SET post_type = 'page' WHERE `ID` = '" . $post_id . "'";
							$wpdb -> query($postquery);
						}
					
						return true;
						break;	
				}
			}
		}
		
		return false;
	}
	
	function select($conditions = false) {
		$select = array();
	
		if ($products = $this -> find_all($conditions, false, array('title', "ASC"), false)) {
			foreach ($products as $product) {
				$select[$product -> id] = apply_filters($this -> pre . '_product_title', $product -> title);
			}
		}
		
		return $select;
	}
	
	function count($conditions = array()) {
		global $wpdb;
		
		$query = "SELECT COUNT(`id`) FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE `status` = 'active'";
		
		if (!empty($conditions)) {
			//$query .= " WHERE";
			$query .= " AND";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				$query .= " `" . $ckey . "` = '" . $cval . "'";
				
				if ($c < count($conditions)) {
					$query .= ", ";
				}
				
				$c++;
			}
			
			if ($count = $wpdb -> get_var($query)) {
				return $count;
			}
		}
		
		return 0;
	}
	
	function get($product_id = null) {
		global $wpcoDb;
		$wpcoDb -> model = $this -> model;
		$product = $wpcoDb -> find(array('id' => $product_id));
		$product = $this -> init_class($this -> model, $product);
		return $product;
	}
	
	function field($field = null, $conditions = array()) {
		global $wpdb;
		
		if (!empty($field)) {
			if (!empty($conditions) && is_array($conditions)) {
				$query = "SELECT `" . $field . "` FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE `status` = 'active' and";
				$c = 1;
				
				foreach ($conditions as $ckey => $cval) {
					$query .= " `" . $ckey . "` = '" . $cval . "'";
					
					if ($c < count($conditions)) {
						$query .= " AND";
					}
					
					$c++;
				}
				
				if ($value = $wpdb -> get_var($query)) {
					return stripslashes($value);
				}
			}
		}
		
		return false;
	}
	
	function find_all($conditions = array(), $fields = false, $order = array('modified', "DESC"), $limit = false) {
		global $wpdb;
		
		$newfields = "*";
		if (!empty($fields)) { $newfields = $fields; }		
		$query = "SELECT " . $newfields . " FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE `status` = 'active'";
		
		if (!empty($conditions) && is_array($conditions)) {
			$query .= " AND";
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
		$query .= (empty($limit)) ? '' : " LIMIT " . $limit . "";
		
		if ($products = $wpdb -> get_results($query)) {
			if (!empty($products)) {
				$this -> data = array();
			
				foreach ($products as $product) {
					$this -> data[] = $this -> init_class($this -> model, $product);
				}
				
				return $this -> data;
			}
		}
		
		return false;
	}
	
	function delete($product_id = null) {
		global $wpdb, $wpcoDb, $wpcoHtml, $ProductsStyle, $ProductsOption, $Item, $File, $Image;
		
		if (!empty($product_id)) {
			$wpcoDb -> model = $this -> model;
		
			if ($product = $wpcoDb -> find(array('id' => $product_id))) {
				$query = "DELETE FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE `id` = '" . $product_id . "'";
				
				if ($wpdb -> query($query)) {
					$ProductsStyle -> delete_all(array('product_id' => $product_id));
					$ProductsOption -> delete_all(array('product_id' => $product_id));
					
					$path = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS;
					$imagefull = $path . $product -> image -> name;
					$thumbfull = $path . $wpcoHtml -> thumb_name($product -> image -> name, 'thumb');
					$smallfull = $path . $wpcoHtml -> thumb_name($product -> image -> name, 'small');
					
					@unlink($imagefull);
					@unlink($thumbfull);
					@unlink($smallfull);
					
					//delete all order items associated with this product
					$wpcoDb -> model = $Item -> model;
					$wpcoDb -> delete_all(array('product_id' => $product_id));
					
					//delete all images associated with this product
					$wpcoDb -> model = $Image -> model;
					if ($images = $wpcoDb -> find_all(array('product_id' => $product_id))) {
						foreach ($images as $image) {
							$wpcoDb -> model = $Image -> model;
							$wpcoDb -> delete($image -> id);
						}
					}
					
					//delete all files associated with this product
					$wpcoDb -> model = $File -> model;
					if ($files = $wpcoDb -> find_all(array('product_id' => $product_id))) {
						foreach ($files as $file) {
							$wpcoDb -> model = $File -> model;
							$wpcoDb -> delete($file -> id);
						}
					}
					
					//remove Wordpress post/page
					if (!empty($product -> post_id)) {
						wp_delete_post($product -> post_id);
					}
				
					return true;
				}
			}
		}
		
		return false;
	}
	
	function product_price($formvalues, $includetax = true) {
		global $wpdb, $wpcoDb, $wpcoHtml, $Option
		, $wpcoTax, $Order;
		$price = "";
		
		if (!empty($formvalues['Item'])) {
			$item = $formvalues['Item'];
			$qty = (empty($item['count'])) ? 1 : $item['count'];
			
			if (!empty($item['product_id'])) {
				$wpcoDb -> model = $this -> model;
				
				if ($product = $wpcoDb -> find(array('id' => $item['product_id']))) {								
					if ($product -> price_type == "fixed") {
						$price = $product -> price;
					} elseif ($product -> price_type == "donate") {					
						if (!empty($formvalues['Item']['donate_price'])) {						
							$donate_price = $formvalues['Item']['donate_price'];
							
							if (is_numeric($donate_price)) {							
								$price = $donate_price;	
							}
						}
					} elseif ($product -> price_type == "square") {
						if (!empty($product -> square_price)) {
							if (!empty($item['width']) && !empty($item['length'])) {
								$ratio = (int) $item['width'] * (int) $item['length'];
								$price = ($product -> square_price * $ratio);	
							}
						}
					} else {
						if ($tiers = @unserialize($product -> price)) {
							$t = 1;
						
							foreach ($tiers as $tier) {						
								$tier['max'] = ($t == count($tiers)) ? 999999 : $tier['max'];
							
								if ($qty <= $tier['max'] && $qty >= $tier['min']) {
									$price = $tier['price'];
									break 1;
								}
								
								$t++;
							}
						}
					}
					
					/* Variations */	
					$variationsprice = 0;		
					if (!empty($item['styles'])) {	
						$total = $price;
										
						foreach ($item['styles'] as $ustyle => $uoption) {
							$optionprice = 0;
							
							if (!empty($uoption) && is_array($uoption)) {
								$uoptions = $uoption;
							
								foreach ($uoptions as $uoid) {
									if (empty($product -> vcalculation) || $product -> vcalculation == "orig") {
										$optionprice += $Option -> price($uoid, $item['styles'], $total);
									} else {
										$optionprice += $Option -> price($uoif, $item['styles'], $price);
									}
								}	
							} else {
								if (empty($product -> vcalculation) || $product -> vcalculation == "orig") {
									$optionprice = $Option -> price($uoption, $item['styles'], $total);
								} else {
									$optionprice = $Option -> price($uoption, $item['styles'], $price);
								}
							}
						
							$price += ($optionprice);
							$variationsprice += ($optionprice);
						}	
					}
					
					/* Custom Fields */
					if (!empty($product -> cfields)) {						
						foreach ($product -> cfields as $field_id) {							
							$wpcoDb -> model = 'wpcoField';
							
							if ($field = $wpcoDb -> find(array('id' => $field_id))) {
								if (!empty($field -> addprice) && $field -> addprice == "Y") {
									if (!empty($field -> price)) {										
										if (!empty($item['fields'][$field -> id]) || $item ['fields'][$field -> id] == "0") {
											$price += ($field -> price);
										}
									}
								}
							}
						}
					}
					
					$wpcoTax -> get_taxpercentage_final($product);
				
					/* BEG Include Tax Into Product price */
					if ($this -> get_option('tax_includeinproductprice') == "Y"
						&& $includetax == true
						&& (empty($product -> taxexempt) || $product -> taxexempt == "N") 
						&& (empty($product -> taxincluded) || $product -> taxincluded == 0)) {										
							$tax = $wpcoTax -> product_tax($product -> id, $price); 
							$price += $tax;	
					} else {								
						if ($this -> get_option('tax_includeinproductprice') == "N" || $includetax == false) {					
							if (!empty($product -> taxincluded) && $product -> taxincluded == 1) {												
								$tax = $wpcoTax -> product_tax($product -> id, $price, true);
								$price -= $tax;
							}
						}
					}
				}
			}
		}
		
		if (!empty($price)) { $price = $wpcoHtml -> number_format_price($price); }
		return $price;
	}
	
	function unit_price($product_id = null, $qty = 1, $item_id = null, $docount = false, $dostyles = false, $purpose = false, $includetax = true) {
		global $wpdb, $wpcoDb, $wpcoHtml, $Option, $Item, $wpcoTax;
		
		$price = 0;
		
		if (!empty($product_id)) {
			$wpcoDb -> model = $Item -> model;
			$item = $wpcoDb -> find(array('id' => $item_id));
			
			if (empty($item -> order_id)) {
				$co_id = array('type' => "cart", 'id' => $item -> cart_id);
			} else {
				$co_id = array('type' => "order", 'id' => $item -> order_id);
			}
			
			$wpcoDb -> model = $this -> model;
		
			if ($product = $wpcoDb -> find(array('id' => $product_id))) {
				/* Fixed price products */
				if ($product -> price_type == "fixed") {
					$price = $product -> price;
				/* Donation price products */
				} elseif ($product -> price_type == "donate") {
					$price = $item -> donate_price;
				/* Per square meter price products */
				} elseif ($product -> price_type == "square") {					
					if (!empty($product -> square_price)) {
						if (!empty($item -> width) && !empty($item -> length)) {							
							$ratio = (int) $item -> width * (int) $item -> length;
							$price = ($product -> square_price * $ratio);
						}
					}
				/* Tiered price products */
				} else {				
					if ($tiers = @unserialize($product -> price)) {
						$t = 1;
						
						if (!empty($product -> vtreatasone) && $product -> vtreatasone == "Y") {
							global $wpcoDb, $Item;
							$wpcoDb -> model = $Item -> model;
							
							$allitems_query = "SELECT SUM(`count`) FROM `" . $wpdb -> prefix . "" . $Item -> table . "` WHERE `product_id` = '" . $product -> id . "' AND `" . $co_id['type'] . "_id` = '" . $co_id['id'] . "';";
							if ($quantity = $wpdb -> get_var($allitems_query)) {
								$qty = $quantity;
							}
						}
					
						foreach ($tiers as $tier) {						
							$tier['max'] = ($t == count($tiers)) ? 999999 : $tier['max'];
						
							if ($qty <= $tier['max'] && $qty >= $tier['min']) {
								$price = $tier['price'];
								break 1;
							}
								
							$t++;
						}

						//pick the lowest or highest from tiers depending upon price display					
						if ($purpose == true) {
							$p = 0;
							$flag = true;
							foreach($tiers as $t) {
								if($product -> price_display == "high") {
									if($p < $t['price']) {
										$p = $t['price'];
									}
								} else {
									if($flag) {
										$p = $t['price'];
										$flag = false;
									}
									
									if($p > $t['price']) {
										$p = $t['price'];
									}
								}
							}
							
							$price = $p;
						}
					}
				}
				
				/* Add product variation pricing? */
				if (!empty($item_id) && $dostyles == true) {
					$wpcoDb -> model = 'Item';
					
					if ($item = $wpcoDb -> find(array('id' => $item_id))) {					
						if (!empty($item -> styles)) {						
							if (($ustyles = @unserialize($item -> styles)) !== false) {							
								foreach ($ustyles as $ustyle => $uoption) {
									$optionprice = 0;
									
									if (!empty($uoption) && is_array($uoption)) {
										$uoptions = $uoption;
									
										foreach ($uoptions as $uoid) {
											$optionprice += $Option -> price($uoid, false, $price);
										}	
									} else {
										$optionprice = $Option -> price($uoption, $ustyles, $price);
									}
								
									if (!empty($docount) && $docount == true) {
										$price += ($optionprice * $item -> count);
									} else {
										$price += $optionprice;
									}
								}
							}
						}
					
						if (!empty($product -> cfields)) {
							foreach ($product -> cfields as $field_id) {
								$wpcoDb -> model = 'wpcoField';
								
								if ($field = $wpcoDb -> find(array('id' => $field_id))) {
									if (!empty($field -> addprice) && $field -> addprice == "Y") {
										if (!empty($field -> price)) {
											if (!empty($item -> {$field -> slug}) || $item -> {$field -> slug} == "0") {
												if (!empty($docount) && $docount == true) {
													$price += ($field -> price * $item -> count);
												} else {
													$price += $field -> price;
												}
											}
										}
									}
								}
							}
						}
					}
				}
				
				$wpcoTax -> get_taxpercentage_final($product);
				
				/* BEG Include Tax Into Product price */
				if ($this -> get_option('tax_includeinproductprice') == "Y"
					&& $includetax == true
					&& (empty($product -> taxexempt) || $product -> taxexempt == "N") 
					&& (empty($product -> taxincluded) || $product -> taxincluded == 0)) {										
						$tax = $wpcoTax -> product_tax($product -> id, $price); 
						$price += $tax;	
				} else {								
					if ($this -> get_option('tax_includeinproductprice') == "N" || $includetax == false) {					
						if (!empty($product -> taxincluded) && $product -> taxincluded == 1) {												
							$tax = $wpcoTax -> product_tax($product -> id, $price, true);
							$price -= $tax;
						}
					}
				}
			}
		}
		
		//return $wpcoHtml -> number_format_price($price);
		return $price;
	}
	
	function delete_all($conditions = array()) {
		global $wpdb;
		
		if (!empty($conditions)) {
			$query = "DELETE FROM `" . $wpdb -> prefix . "" . $this -> table . "` WHERE ";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				$query .= " `" . $ckey . "` = '" . $cval . "'";
				
				if ($c < count($conditions)) {
					$query .= " AND";
				}
			}
						
			
			if ($wpdb -> query($query)) {
				return true;
			}
		}
		
		return false;
	}
	
	function save($data = array(), $validate = true, $imageupload = true, $fromeditor = true, $savepp = true, $clearstylesoptions = true) {
		global $user_ID, $wpdb, $wpcoDb, $Image, $wpcoHtml, $Category, $wpcoContent, $wpcoCategoriesProduct, $ProductsStyle, $ProductsOption;
		
		$highestorderquery = "SELECT `order` FROM `" . $wpdb -> prefix . $this -> table . "` ORDER BY `order` DESC LIMIT 1";
		$highestorder = $wpdb -> get_var($highestorderquery);
		
		$defaults = array(
			'created'		=> 	$wpcoHtml -> gen_date(), 
			'modified' 		=> 	$wpcoHtml -> gen_date(), 
			'type' 			=> 	'tangible', 
			'price'			=>	'0.00',
			'price_fixed'	=>	'0.00',
			'taxincluded'	=>	0,
			'sprice'		=>	'0.00',
			'wholesale'		=>	'0.00',
			'price_type' 	=> 	'fixed',
			'excludeglobal'	=>	"N",
			'page_template'	=> 	"",
			'affiliate'		=>	"N",
			'shipping'		=>	"N",
			'min_order'		=>	0,
			'inventory'		=>	999,
			'measurement'	=>	'units',
			'vtreatasone'	=>	'N',
			'user_id'		=>	$user_ID,
			'status'		=>	"active",
			'showcase'		=>	"N",
			'order'			=>	(empty($highestorder) ? 1 : ($highestorder + 1)),
		);
			
		$dest_path = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS;
		$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
		
		/* Post or Page */
		$createpostpage = false;
		if($data['p_type'] == 'page') {
			if (!empty($_POST['productpage']) && $_POST['productpage'] != "-1") {
				$data['post_id'] = $_POST['productpage'];
			} else {
				$createpostpage = true;	
				$data['post_id'] = false;
			}
		} elseif ($data['p_type'] == "post") {								
			if (!empty($_POST['productpost']) && $_POST['productpost'] != "-1") {
				$data['post_id'] = $_POST['productpost'];
			} else {
				$createpostpage = true;	
				$data['post_id'] = false;
			}
		}

		if (!empty($imageupload) && $imageupload == true) {
			$data['image'] = $wpcoHtml -> image_data('Product.image', $_FILES);
		} else {
			$imagedata = (object) $data['image'];
			$data['image'] = $imagedata;
		}
			
		if (!empty($fromeditor) && $fromeditor == true) {
			$data['description'] = $_POST['content'];
		}
		
		$r = wp_parse_args($data, $defaults);
		$this -> data = $wpcoHtml -> array_to_object($r);
		extract($r, EXTR_SKIP);
		
		if ($validate == true) {
			if (empty($title)) { $this -> errors['title'] = __('Please fill in a title', $this -> plugin_name); }
			else {
				$imagepath = WP_CONTENT_DIR . DS . 'uploads' . DS . 'wp-checkout' . DS . 'images' . DS;
	
				if (!empty($oldimage) && empty($image -> name)) {
					$this -> data -> image -> name = $oldimage;
					$imagefull = $imagepath . $oldimage;
				} else {					
					if (!empty($image -> name)) {					
						$originalimagename = $wpcoHtml -> sanitize(substr($title, 0, 45)) . '-' . time() . '.' . $wpcoHtml -> strip_ext($image -> name);
						$imagefull = $imagepath . $originalimagename;
						$resizepath = $this -> plugin_name . DS . 'images' . DS . $originalimagename;
						
						if (!is_uploaded_file($image -> tmp_name) && $imageupload == true) { $this -> errors['image'] = __('Image was not uploaded', $this -> plugin_name); }
						elseif (!move_uploaded_file($image -> tmp_name, $imagefull) && $imageupload == true) { $this -> errors['image'] = __('Image could not be moved', $this -> plugin_name); }
					} else {
						$originalimagename = false;
					}
					
					$this -> data -> image -> name = $originalimagename;
				}
				
				@chmod($imagefull, 0777);
			}
			
			if (empty($description)) { $this -> errors['description'] = __('Please fill in a description', $this -> plugin_name); }
			if (empty($categories) || !is_array($categories)) { $this -> errors['categories'] = __('Please select a product category', $this -> plugin_name); }
			
			if (empty($price_type)) { $this -> errors['price_type'] = __('Please select a price type', $this -> plugin_name); }
			else {
				if ($price_type == "fixed") {
					//do nothing, the price is fixed...
				} elseif ($price_type == "tiers") {
					if (!empty($price_tiers)) {
						if (!is_array($price_tiers)) { $this -> errors['price_tiers'] = __('Price tiers are incorrect', $this -> plugin_name); }
					} else {
						$this -> errors['price_tiers'] = __('Please fill in the price tiers', $this -> plugin_name);
					}
				} elseif ($price_type == "square") {
					if (empty($square_price)) { $this -> errors['square_price'] = __('Please fill in a price per square meter.', $this -> plugin_name); }	
				}
			}
			
			if (empty($type)) { $this -> errors['type'] = __('Please select a product type', $this -> plugin_name); }
			if (empty($vtreatasone)) { $this -> errors['vtreatasone'] = __('Should different variations be treated as a single product?', $this -> plugin_name); }
		}
		
		if (empty($this -> errors)) {
			//nicetitle
			$this -> data -> nicetitle = $wpcoHtml -> sanitize($this -> data -> title);
		
			$this -> data -> image = $this -> data -> image -> name;
			$this -> data -> price = ($price_type == "fixed") ? $price_fixed : serialize($price_tiers);
			$this -> data -> post_category = (!empty($post_category) && is_array($post_category)) ? serialize($post_category) : '';
			
			if (!empty($this -> data -> shipping)) {
				if ($this -> data -> shipping == "Y") {
					switch ($this -> data -> shiptype) {
						case 'tiers'			:
							$this -> data -> shiptiers = serialize($shiptiers);
							break;
						default					:
							$this -> data -> shipprice = serialize($shipprice);
							break;
					}
				}
			}
			
			@chmod($imagefull, 0777);
			
			$wpcoDb -> model = $this -> model;
			$query = (empty($id)) ? $wpcoDb -> insert_query($this -> model) : $wpcoDb -> update_query($this -> model);
			$this -> data = apply_filters($this -> pre . '_product_before_save', $this -> data);
			
			if ($wpdb -> query($query)) {
				$insertid = $this -> insertid = (empty($id)) ? $wpdb -> insert_id : $id;
				
				$wpcoDb -> model = $wpcoContent -> model;
				$wpcoDb -> delete_all(array('product_id' => $this -> insertid));
				
				/* Extra Images */
				$ffiles = $_FILES;
				
				if (!empty($ffiles['extraimages']['name'])) {
					$_FILES = false;
					
					foreach ($ffiles['extraimages']['name'] as $extraimage_key => $extraimage_name) {
						$_FILES = array(
							'Image'		=>	array(
								'name'			=>	array('file' => $extraimage_name),
								'type'			=>	array('file' => $ffiles['extraimages']['type'][$extraimage_key]),
								'tmp_name'		=>	array('file' => $ffiles['extraimages']['tmp_name'][$extraimage_key]),
								'error'			=>	array('file' => $ffiles['extraimages']['error'][$extraimage_key]),
								'size'			=>	array('file' => $ffiles['extraimages']['size'][$extraimage_key]),
							)
						);
						
						$extraimage_title = $wpcoHtml -> strip_ext($extraimage_name, "name");
						
						$imagedata = array(
							'Image'		=>	array(
								'title'			=>	((empty($extraimage_title)) ? $title : $extraimage_title),
								'product_id'	=>	$insertid,
							)				   
						);
						
						$Image -> save($imagedata, true);
						$Image -> data -> id = false;
						$extraimage_title = "";
					}
				}
					
				if (!empty($contents)) {																	
					foreach ($contents as $content) {
						if (!empty($content['title']) && !empty($content['content'])) {
							$c_data = array(
								'wpcoContent'	=>	array(
									'title'			=>	$content['title'],
									'content'		=>	esc_sql($content['content']),
									'product_id'	=>	$this -> insertid,
								)
							);
							
							$wpcoDb -> model = $wpcoContent -> model;
							$wpcoDb -> save($c_data, true);
							
							$wpcoContent -> id = false;
							$wpcoContent -> insertid = false;
							$wpcoContent -> data = false;
						}
					}
				}
							
				//custom fields
				global $wpcoDb, $wpcoFieldsProduct;
				
				$wpcoDb -> model = $wpcoFieldsProduct -> model;
				$wpcoDb -> delete_all(array('product_id' => $this -> insertid));
				
				if (!empty($fields)) {		
					$f = 1;			
					foreach ($fields as $field_id) {
						$wpcoDb -> model = $wpcoFieldsProduct -> model;
						$wpcoDb -> save(array('product_id' => $this -> insertid, 'field_id' => $field_id, 'order' => $f), true);
						$f++;
					}
				}
				
				if (!empty($categories)) {				
					$cids = array();
				
					foreach ($categories as $c_id) {
						$categoriesproductidquery = "SELECT `id` FROM " . $wpdb -> prefix . $wpcoCategoriesProduct -> table . " WHERE `category_id` = '" . $c_id . "' AND `product_id` = '" . $this -> insertid . "'";
						$categoriesproductid = $wpdb -> get_var($categoriesproductidquery);
						$wpcoDb -> model = $wpcoCategoriesProduct -> model;
						$cp_data = array('id' => $categoriesproductid, 'category_id' => $c_id, 'product_id' => $this -> insertid);
						$wpcoDb -> save($cp_data);
						
						$cids[] = $c_id;
					}

					if (!empty($cids) && is_array($cids)) {					
						$categoriesdeletequery = "DELETE FROM " . $wpdb -> prefix . $wpcoCategoriesProduct -> table . " WHERE category_id NOT IN 
						(" . implode(",", $cids) . ") AND product_id = '" . $this -> insertid . "'";
						
						$wpdb -> query($categoriesdeletequery);
					}
				}
				
				/* WordPress Post/Page creation for this product */
				if (!empty($savepp) && $savepp == true) {						
					if ($this -> get_option('createpages') == "Y") {						
						$productcategory_postid = $Category -> field('post_id', array('id' => $categories[0]));	
						$post_parent = (empty($categories[0])) ? $this -> get_option('pagesparent') : $productcategory_postid;
						$post_query = "SELECT `ID` FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $post_id . "'";
						$product_post_type = ($data['p_type'] == "custom") ? 'product' : $data['p_type'];
						
						$page = array(
							'ID'				=>	($wpdb -> get_var($post_query)) ? $post_id : false,
							'post_title'		=>	$title,
							'post_name'			=>	$wpcoHtml -> sanitize($title),
							'post_content'		=>	((!empty($createpostpage) && $createpostpage == true) ? "[" . $this -> pre . "product id=" . $this -> insertid . "]" : false),
							'post_parent'		=>	$post_parent,
							'post_category'		=>	$post_category,
							'post_status'		=>	"publish",
							'post_type'			=>	$product_post_type,
							'tags_input'		=>	$keywords,
						);
						
						// Was a password filled in ?
						if (!empty($post_password)) {
							$page['post_password'] = $post_password;
						}
						
						if (!empty($comment_status)) {
							$page['comment_status'] = $comment_status;
						}
						
						if ($createpostpage == false || ($this -> get_option('pp_updatecontent') == "N" && !empty($post_id))) {
							if ($cur_page = $wpdb -> get_row("SELECT * FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $post_id . "' AND `post_status` = 'publish'")) {
								$page['post_content'] = $cur_page -> post_content;	
								
								if ($createpostpage == false) {
									//do nothing...
								}
							}
						}
						
						if (empty($page['post_content'])) {
							$page['post_content'] = '[' . $this -> pre . 'product id="' . $this -> insertid . '"]';	
						}
						
						if ($post_id = wp_insert_post($page)) {								
							$this -> db_save_field($this -> model, 'post_id', $post_id, array('id' => $this -> insertid));
							//$this -> db_save_field($this -> model, 'p_type', $_POST['p_type'], array('id' => $this -> insertid));
							
							global $wpcoDb;
							$wpcoDb -> model = $this -> model;
							$wpcoDb -> save_field('p_type', $data['p_type'], array('id' => $this -> insertid));
							
							/* Page Template */
							if (!empty($data['p_type']) && $data['p_type'] == "page") {
								update_post_meta($post_id, '_wp_page_template', $page_template);
							}
							
							global $wp_rewrite;
							$wp_rewrite -> flush_rules();
						}
						
						$this -> data -> post_id = $post_id;
					}
				}
				
				if ($clearstylesoptions == true) {
					//get all styles for product id
					$tmp_arr = $ProductsStyle -> find_all(array('product_id' => $this -> insertid), array('style_id'));
					$del_arr = array();					

					if(!empty($tmp_arr)) {					
						//delete the style not checked
						foreach ($tmp_arr as $k) {
							if (!in_array($k -> style_id, $styles)) {
								$ProductsStyle -> delete_all(array('product_id' => $this -> insertid, 'style_id' => $k -> style_id));
							}
						}											
						
						//have to chk if somthing to add in style
						foreach($styles as $style) {
							//$add_arr = $ProductsStyle -> find_all(array('product_id' => $this -> insertid, 'style_id' => $style), array('style_id'));

							if (empty($add_arr)) {
								$ProductsStyle -> save(array('product_id' => $this -> insertid, 'style_id' => $style, 'defaultoption' => $styledefault[$style]));
							}	
						}
						
					} else {					
						if (!empty($styles)) {				
							foreach ($styles as $style_id) {
								$ProductsStyle -> save(array('product_id' => $this -> insertid, 'style_id' => $style_id, 'defaultoption' => $styledefault[$style_id]));
							}
						}
					}
					
					//Save the new Product Options
					$ProductsOption -> delete_all(array('product_id' => $this -> insertid));
					if (!empty($options)) {				
						foreach ($options as $option_id) {
							$ProductsOption -> save(
								array(
									'product_id' 			=> 	$this -> insertid, 
									'option_id' 			=> 	$option_id,
									'inventory'				=>	(($optionstock >= 0) ? $optionstock[$option_id] : "-1"),
								)
							);
						}
					}
				}
				
				//Global variables
				global $wpcoKeyword, $wpcoDb;
				
				//did the editor fill in product keywords?
				$wpcoDb -> model = $wpcoKeyword -> model;
				$wpcoDb -> delete_all(array('product_id' => $insertid));
				
				if (!empty($keywords)) {				
					if (($kws = explode(",", $keywords)) !== false) {					
						foreach ($kws as $kw) {
							$kw = trim($kw);
							$wpcoDb -> model = $wpcoKeyword -> model;
							$wpcoDb -> save(array('product_id' => $this -> insertid, 'keyword' => $kw));
						}
					}
				}
				
				do_action('checkout_admin_product_saved', $this -> insertid, $this -> data);
				
				//$this -> updatepages($update = false);
				//everything has been saved as intended
				return true;
			}
		}
	
		return false;
	}
}

?>