<?php

class wpcoDbHelper extends wpCheckoutPlugin {

	var $name = 'Db';
	var $model = '';
	
	function wpcoDbHelper() {
	
		return true;
	}
	
	function count($conditions = array()) {
		if (!empty($this -> model)) {
			global $wpdb, ${$this -> model};
			
			$query = "SELECT COUNT(`id`) FROM `" . $wpdb -> prefix . "" . ${$this -> model} -> table . "`";
			
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
		}
		
		return 0;
	}
	
	function field($field = null, $conditions = array()) {
		if (!empty($this -> model)) {
			global $wpdb, ${$this -> model};

			if (!empty($field)) {			
				if (!empty($conditions) && is_array($conditions)) {
					$query = "SELECT `" . $field . "` FROM `" . $wpdb -> prefix . "" . ${$this -> model} -> table . "` WHERE";
					$c = 1;
					
					foreach ($conditions as $ckey => $cval) {
						if (preg_match("/(LIKE)/si", $cval)) {
							$query .= " `" . $ckey . "` " . $cval . "";
						} else {
							$query .= " `" . $ckey . "` = '" . $cval . "'";
						}
						
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
		}
		
		return false;
	}
	
	function save_field($field = null, $value = null, $conditions = array()) {
		if (!empty($this -> model)) {
			global $wpdb, ${$this -> model};
			
			if (!empty($field)) {
				$query = "UPDATE `" . $wpdb -> prefix . "" . ${$this -> model} -> table . "` SET `" . $field . "` = '" . $value . "'";
				
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
				
				if ($wpdb -> query($query)) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	function save($data = array(), $validate = true) {
		global $wpdb, ${$this -> model}, $wpcoHtml, $wpcoAuth;
		
		$defaults = (method_exists(${$this -> model}, 'defaults')) ? ${$this -> model} -> defaults() : false;
		$data = (empty($data[${$this -> model} -> model])) ? $data : $data[${$this -> model} -> model];
		
		switch ($this -> model) {
			case 'Supplier'			:
				$data['imagefile'] = $wpcoHtml -> image_data('Supplier.imagefile', $_FILES);
				break;
		}
		
		$r = wp_parse_args($data, $defaults);
		${$this -> model} -> data = $wpcoHtml -> array_to_object($r);
		
		if ($validate == true) {
			if (method_exists(${$this -> model}, 'validate')) {
				${$this -> model} -> validate($r);
			}
		}
		
		if (empty(${$this -> model} -> errors)) {
			switch (${$this -> model} -> model) {
				case 'Item'			 				:
					global $Order, $Item, $Product, $wpcoField;
				
					$this -> model = $Item -> model;
					$completed = (empty(${$this -> model} -> data -> completed)) ? "N" : ${$this -> model} -> data -> completed;
					$paid = (empty(${$this -> model} -> data -> paid)) ? "N" : ${$this -> model} -> data -> paid;
					$conditions = array('user_id' => ${$this -> model} -> data -> user_id, 'completed' => $completed, 'paid' => $paid, 'product_id' => ${$this -> model} -> data -> product_id);
					
					$co_id = $Order -> cart_order();
					$conditions[$co_id['type'] . '_id'] = $co_id['id'];
					
					if (!empty(${$this -> model} -> data -> styles)) {
						$conditions['styles'] = serialize(${$this -> model} -> data -> styles);
					}
					
					if (!empty(${$this -> model} -> data -> fields)) {
						$oldmodel = $this -> model;
						$this -> model = $wpcoField -> model;
						
						foreach (${$oldmodel} -> data -> fields as $field_id => $field_val) {
							$this -> model = $wpcoField -> model;

							if ($field = $this -> find(array('id' => $field_id))) {
								if (is_array($field_val) || is_object($field_val)) {
									$field_val = serialize($field_val);
								}
							
								$conditions[$field -> slug] = $field_val;
							}
						}
						
						$this -> model = $oldmodel;
					}
					
					// Not editing an item via admin?
					if (empty(${$this -> model} -> data -> edit)) {					
						$oldmodel = $this -> model;
						$this -> model = $Product -> model;
						$product = $this -> find(array('id' => ${$oldmodel} -> data -> product_id));
						
						if (!empty($product -> price_type) && $product -> price_type == "square") {
							$conditions['width'] = ${$oldmodel} -> data -> width;
							$conditions['length'] = ${$oldmodel} -> data -> length;	
						}
						
						$this -> model = $oldmodel;
															
						if ($item = $this -> find($conditions, false, array('id', "DESC"), false)) {				
							${$this -> model} -> data -> id = $item -> id;
							
							if (empty(${$this -> model} -> data -> edit)) {
								${$this -> model} -> data -> count = $item -> count + $data['count'];
							}
						} else {
							$oldmodel = $this -> model;
							$this -> model = $Product -> model;
							
							if ($product) {
								if (!empty($product -> min_order)) {
									if (${$oldmodel} -> data -> count < $product -> min_order) {
										if (empty(${$oldmodel} -> data -> edit)) {
											${$oldmodel} -> data -> count = $product -> min_order;
										}
									}
								}
							} else {
								$this -> errors['product_id'] = __('Product cannot be read', $this -> plugin_name);
							}
							
							$this -> model = $oldmodel;
						}
					} else {					
						if (!empty($_POST['Item']['fields'])) {
							foreach ($_POST['Item']['fields'] as $field_id => $field_value) {							
								$oldmodel = $this -> model;
								$this -> model = $wpcoField -> model;
								if ($field = $this -> find(array('id' => $field_id))) {
									${$oldmodel} -> data -> {$field -> slug} = $field_value;
								}
								$this -> model = $oldmodel;
							}
						}	
					}
					
					//is this a donation product ?
					if (!empty(${$this -> model} -> data -> donate_price)) { ${$this -> model} -> data -> id = false; }
					if (!empty(${$this -> model} -> data -> width) && !empty(${$this -> model} -> data -> length) && (!empty($item) && $item -> width != ${$this -> model} -> data -> width && $item -> length != ${$this -> model} -> data -> length)) { ${$this -> model} -> data -> id = false; }
					break;
				case 'wpcoField'					:
					${$this -> model} -> data -> slug = $wpcoHtml -> sanitize(${$this -> model} -> data -> title, "_");
				
					if (!empty(${$this -> model} -> data -> fieldoptions)) {
						${$this -> model} -> data -> fieldoptions = serialize(explode("\n", ${$this -> model} -> data -> fieldoptions));
					}
					
					if (!empty(${$this -> model} -> data -> activedays)) {
						${$this -> model} -> data -> activedays = implode(",", ${$this -> model} -> data -> activedays);
					}
					
					if (!empty(${$this -> model} -> data -> id)) {
						$curr_field = $this -> find(array('id' => ${$this -> model} -> data -> id), "*", array('id', "DESC"), false);
					}
					break;
				case 'wpcoFieldsOrder'				:				
					if ($curr_fieldorder = $this -> find(array('field_id' => ${$this -> model} -> data -> field_id, 'order_id' => ${$this -> model} -> data -> order_id))) {						
						${$this -> model} -> data -> id = $curr_fieldorder -> id;
					}				
					break;
				case 'Supplier'						:
					if (!empty(${$this -> model} -> data -> oldimage) && empty(${$this -> model} -> data -> imagefile -> name)) {
						${$this -> model} -> data -> imagename = ${$this -> model} -> data -> oldimage;
					} else {
						${$this -> model} -> data -> imagename = ${$this -> model} -> data -> imagefile -> name;
						${$this -> model} -> data -> imagetype = ${$this -> model} -> data -> imagefile -> type;
						${$this -> model} -> data -> imagesize = ${$this -> model} -> data -> imagefile -> size;
					}
					break;
				case 'wpcoCategoriesProduct'		:
					$oldmodel = $this -> model;
					$this -> model = 'wpcoCategoriesProduct';
				
					if ($cp = $this -> find(array('product_id' => ${$this -> model} -> data -> product_id, 'category_id' => ${$this -> model} -> data -> category_id))) {
						return false;
					}
					
					$this -> model = $oldmodel;
					break;
			}
			
			//the MySQL query
			$query = (empty(${$this -> model} -> data -> id)) ? $this -> insert_query(${$this -> model} -> model) : $this -> update_query(${$this -> model} -> model, true);
			
			if ($wpdb -> query($query)) {		//execute the query, let's hope all goes well!! :)
				${$this -> model} -> insertid = $insertid = (empty(${$this -> model} -> data -> id)) ? $wpdb -> insert_id : ${$this -> model} -> data -> id;
				
				switch ($this -> model) {
					case 'Item'					:
						// Update any totals accordingly...
						$order_id = $Item -> data -> order_id;
						$Order -> update_totals($order_id);
						break;
					case 'Order'				:					
						global $wpcoDb, $Order, $Item;
						$order_data = $Order -> data;
					
						if (!empty($order_data -> shipped)) {
							$wpcoDb -> model = $Item -> model;
							$wpcoDb -> save_field('shipped', $order_data -> shipped, array('order_id' => $insertid));
						}
						
						if (!empty($order_data -> paid)) {						
							$wpcoDb -> model = $Item -> model;
							$wpcoDb -> save_field('paid', $order_data -> paid, array('order_id' => $insertid));
						}
						
						if (!empty($order_data -> completed)) {						
							$wpcoDb -> model = $Item -> model;
							$wpcoDb -> save_field('completed', $order_data -> paid, array('order_id' => $insertid));
						}
						
						$this -> model = 'Order';
						${$this -> model} -> data = $order_data;
						
						if (!empty(${$this -> model} -> data -> notifycustomer)) {
							$to = ${$this -> model} -> data -> bill_email;
							$subject = stripslashes(${$this -> model} -> data -> notifysubject);
							$message = $this -> render('orders' . DS . 'comments', array('order' => ${$this -> model} -> data), false, 'email');
							$this -> send_mail($to, $subject, $message);
						}
						break;
					case 'Option'				:
						global $Option, $wpcoOptionsOption;
						
						$this -> model = $wpcoOptionsOption -> model;
						$this -> delete_all(array('cond_id' => $insertid));
						$this -> model = $Option -> model;
						
						if (!empty(${$this -> model} -> data -> styles)) {						
							foreach (${$this -> model} -> data -> styles as $style_id) {
								if (!empty(${$this -> model} -> data -> options[$style_id])) {
									foreach (${$this -> model} -> data -> options[$style_id] as $option_id) {									
										if (!empty(${$this -> model} -> data -> prices[$option_id])) {										
											$price = ${$this -> model} -> data -> prices[$option_id];
											
											$oo_data = array(
												'cond_id'			=>	$insertid,
												'option_id'			=>	$option_id,
												'price'				=>	$price,
											);
											
											$this -> model = $wpcoOptionsOption -> model;
											$this -> save($oo_data, true);
											$this -> model = $Option -> model;
											
											continue;
										}
									}
								}
							}
						}
						break;
					case 'wpcoField'			:
						global $Item;
					
						if (empty(${$this -> model} -> data -> id)) {
							$this -> add_field($wpdb -> prefix . "" . $Item -> table, $wpcoHtml -> sanitize(${$this -> model} -> data -> title, "_"));
						} else {
							$this -> change_field($wpdb -> prefix . "" . $Item -> table, $wpcoHtml -> sanitize($curr_field -> title, "_"), $wpcoHtml -> sanitize(${$this -> model} -> data -> title, "_"));
						}
					
						if (!empty(${$this -> model} -> data -> products)) {
							$this -> model = 'wpcoFieldsProduct';
							$this -> delete_all(array('field_id' => $insertid));
												
							foreach ($wpcoField -> data -> products as $product_id) {
								$this -> model = 'wpcoFieldsProduct';
								$fpdata = array('field_id' => $insertid, 'product_id' => $product_id);
								$this -> save($fpdata, true);
							}
						} else {
							$this -> model = 'wpcoFieldsProduct';
							$this -> delete_all(array('field_id' => $insertid));
						}
						break;
					case 'Supplier'				:
						$this -> model = 'Supplier';
						
						if ($supplier = $this -> find(array('id' => $insertid))) {
							if (${$this -> model} -> data -> deletepage == "Y") {
								if (!empty($supplier -> post_id)) {
									wp_delete_post($supplier -> post_id);
									$this -> save_field('post_id', "0", array('id' => $insertid));
								}
							}
						
							if ($this -> get_option('supplierpages') == "Y") {
								$query = "SELECT `ID` FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $supplier -> post_id . "'";
								$post_type = $this -> get_option('post_type');
								$supplier_post_type = ($post_type == "custom") ? 'product-supplier' : $post_type;
							
								$page = array(
									'ID'			=>	(!empty($supplier -> post_id) && $wpdb -> get_var($query)) ? $supplier -> post_id : false,
									'post_title'	=>	$supplier -> name,
									'post_content'	=>	'[' . $this -> pre . 'supplier id=' . $insertid . ']',
									'post_parent'	=>	$this -> get_option('pagesparent'),
									'post_category'	=>	array($this -> get_option('categoriesparent')),
									'post_status'	=>	'publish',
									'post_type'		=>	$supplier_post_type,
								);
								
								if ($this -> get_option('pp_updatecontent') == "N" && !empty($supplier -> post_id)) {
									if ($cur_page = $wpdb -> get_row("SELECT * FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $supplier -> post_id . "' AND `post_status` = 'publish'")) {
										$page['post_content'] = $cur_page -> post_content;	
									}
								}
								
								if ($post_id = wp_insert_post($page)) {
									$this -> model = 'Supplier';
									$this -> save_field('post_id', $post_id, array('id' => $insertid));
								
									/* Page Template */
									if ($post_type == "page" || $post_type == "custom") {
										update_post_meta($post_id, "_wp_page_template", $supplier -> page_template);	
									}
								}
							}
						}
						break;
				}
				
				//everything executed successfully
				return true;
			}
		}
		
		return false;
	}
	
	function insert_query($model = null) {	
		if (!empty($model)) {
			global ${$model}, $wpdb;
			
			if (!empty(${$model} -> data)) {
				if (empty(${$model} -> data -> id)) {
					$query1 = "INSERT INTO `" . $wpdb -> prefix . "" . ${$model} -> table . "` (";
					$query2 = "";
					$c = 1;
					unset(${$model} -> fields['key']);
					
					switch ($model) {
						case 'Item'			:
							global $Item;
						
							$oldmodel = $model;
							$this -> model = 'wpcoField';
							
							if ($fields = $this -> find_all()) {
								foreach ($fields as $field) {
									if (!empty(${$oldmodel} -> data -> {$field -> slug}) || ${$oldmodel} -> data -> {$field -> slug} == "0") {
										$Item -> fields[$field -> slug] = "TEXT NOT NULL";
									}
								}
							}
							
							$model = $oldmodel;							
							break;
					}
					
					$fields = apply_filters($this -> pre . '_db_fields', ${$model} -> fields, $model);
					$fieldscount = count($fields);
					
					foreach (array_keys($fields) as $field) {
						//if (!empty(${$model} -> data -> {$field}) || ${$model} -> data -> {$field} == "0") {						
							if (is_array(${$model} -> data -> {$field}) || is_object(${$model} -> data -> {$field})) {
								$value = serialize(${$model} -> data -> {$field});
							} else {
								$value = esc_sql(${$model} -> data -> {$field});
							}
				
							$query1 .= "`" . $field . "`";
							$query2 .= "'" . $value . "'";
							
							if ($c < $fieldscount) {
								$query1 .= ", ";
								$query2 .= ", ";
							}
						//}
						
						$c++;
					}
					
					$query1 .= ") VALUES (";
					$query = $query1 . "" . $query2 . ");";
					return $query;
				} else {
					$query = $this -> update_query($model);
					
					return $query;
				}
			}
		}
	
		return false;
	}
	
	function update_query($model = null, $leaveempty = false) {	
		if (!empty($model)) {
			global ${$model}, $wpdb;
			
			if (!empty(${$model} -> data)) {			
				$query = "UPDATE `" . $wpdb -> prefix . "" . ${$model} -> table . "` SET ";
				$c = 1;
				unset(${$model} -> fields['key']);
				unset(${$model} -> fields['created']);
				
				switch ($model) {
					case 'Item'			:
						global $Item;
					
						$oldmodel = $model;
						$this -> model = 'wpcoField';
						
						if ($fields = $this -> find_all()) {
							foreach ($fields as $field) {
								if (!empty(${$oldmodel} -> data -> {$field -> slug}) || ${$oldmodel} -> data -> {$field -> slug} == "0") {
									$Item -> fields[$field -> slug] = "TEXT NOT NULL";
								}
							}
						}
						
						$model = $oldmodel;							
						break;
				}
				
				$fields = apply_filters($this -> pre . '_db_fields', ${$model} -> fields, $model);
				$fieldscount = count($fields);
				
				foreach (array_keys($fields) as $field) {
					if (empty($leaveempty) || (!empty($leaveempty) && (!empty(${$model} -> data -> {$field}) || ${$model} -> data -> {$field} == "0"))) {
						if (is_array(${$model} -> data -> {$field}) || is_object(${$model} -> data -> {$field})) {
							$value = serialize(${$model} -> data -> {$field});
						} else {
							$value = esc_sql(${$model} -> data -> {$field});
						}
					
						$query .= "`" . $field . "` = '" . $value . "'";
						
						if ($c < $fieldscount) {
							$query .= ", ";
						}
					}
					
					$c++;
				}
				
				$query = rtrim($query, ", ");
				$query .= " WHERE `id` = '" . ${$model} -> data -> id . "' LIMIT 1";
				return $query;
			}
		}
	
		return false;
	}
	
	function find($conditions = array(), $fields = false, $order = array('id', "DESC"), $assign = true, $atts = array()) {
		global $wpdb, ${$this -> model};
		$newfields = "*";
		
		if (!empty($fields)) {
			if (is_array($fields)) {
				$newfields = "";
				$f = 1;
				
				foreach ($fields as $field) {
					$newfields .= "`" . $field . "`";
					
					if ($f < count($fields)) {
						$newfields .= ", ";
					}
					
					$f++;
				}
			} else {
				$newfields = $fields;
			}
		}
		
		$query = "SELECT " . $newfields . " FROM `" . $wpdb -> prefix . "" . ${$this -> model} -> table . "`";
		
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
		
		$order = (empty($order)) ? array('id', "DESC") : $order;
		list($ofield, $odir) = $order;
		$query .= " ORDER BY `" . $ofield . "` " . $odir . "";
		$query .= " LIMIT 1";		
		
		$query_hash = md5($query);
		global ${$query_hash};
		if (!empty(${$query_hash})) {		
			return ${$query_hash};
		}
		
		if ($record = $wpdb -> get_row($query)) {		
			if (!empty($record)) {
				switch ($this -> model) {
					case 'Option'			:														
						if (!empty($atts['otheroptions'])) {
							$record -> otheroptions = $atts['otheroptions'];
						}
						break;
				}
			
				$data = $this -> init_class(${$this -> model} -> model, $record);
				
				if (!empty($record -> otheroptions)) {
					${$this -> model} -> data -> otheroptions = $record -> otheroptions;
				}
				
				if ($assign == true) {
					${$this -> model} -> data = $data;
				}
				
				${$query_hash} = $data;
				return $data;
			}
		}
		
		return false;
	}
	
	function find_all($conditions = array(), $fields = false, $order = array('id', "DESC"), $limit = false, $assign = false, $distinct = false) {
		global $wpdb, ${$this -> model};
		
		$newfields = "*";
		if (!empty($fields) && !is_array($fields)) { $newfields = $fields; }
		$distinct = (!empty($distinct)) ? "DISTINCT " : "";
		
		$query = "SELECT " . $distinct . $newfields . " FROM `" . $wpdb -> prefix . "" . ${$this -> model} -> table . "`";
		
		if (!empty($conditions) && is_array($conditions)) {
			$query .= " WHERE";
			$c = 1;
			
			foreach ($conditions as $ckey => $cval) {
				if (preg_match("/(>=|>|<=|<|OR|AND)/si", $cval)) {
					$query .= " " . $ckey . " " . $cval;
				} else {
					$query .= " `" . $ckey . "` = '" . $cval . "'";
				}
				
				if ($c < count($conditions)) {
					$query .= " AND";
				}
				
				$c++;
			}
		}
		
		$order = (empty($order)) ? array('id', "DESC") : $order;
		list($ofield, $odir) = $order;
		$query .= " ORDER BY `" . $ofield . "` " . $odir . "";
		$query .= (empty($limit)) ? '' : " LIMIT " . $limit . "";
		
		$query_hash = md5($query);
		global ${$query_hash};
		if (!empty(${$query_hash})) {
			return ${$query_hash};
		}
		
		if ($records = $wpdb -> get_results($query)) {
			if (!empty($records)) {
				$data = array();
			
				foreach ($records as $record) {
					$data[] = $this -> init_class(${$this -> model} -> model, $record);
				}
				
				if ($assign == true) {
					${$this -> model} -> data = $data;
				}
				
				${$query_hash} = $data;
				return $data;
			}
		}
		
		return false;
	}
	
	function delete($record_id = null) {
		global $wpdb, ${$this -> model}, $wpcoHtml;
		
		if (!empty($record_id) && $record = $this -> find(array('id' => $record_id))) {
			$query = "DELETE FROM `" . $wpdb -> prefix . "" . ${$this -> model} -> table . "` WHERE `id` = '" . $record_id . "' LIMIT 1";
			
			if ($wpdb -> query($query)) {
				switch (${$this -> model} -> model) {
					case 'wpcoField'			:						
						$this -> model = 'wpcoFieldsProduct';
						$this -> delete_all(array('field_id' => $record_id));
						
						global $wpcoFieldsOrder;
						$this -> model = $wpcoFieldsOrder -> model;
						$this -> delete_all(array('field_id' => $record_id));
						
						global $Item;
						$this -> delete_field($Item -> table, $wpcoHtml -> sanitize($record -> title, "_"));
						break;
					case 'Order'				:
						$this -> model = 'Item';
						if ($items = $this -> find_all(array('order_id' => $record_id))) {
							foreach ($items as $item) {
								$this -> delete($item -> id);
							}
						}
						
						$this -> model = 'Discount';
						if ($discounts = $this -> find_all(array('order_id' => $record_id))) {
							foreach ($discounts as $discount) {
								$this -> delete($discount -> id);
							}
						}
						
						global $wpcoFieldsOrder;
						$this -> model = $wpcoFieldsOrder -> model;
						$this -> delete_all(array('order_id' => $record_id));
						break;
					case 'Item'					:
						//do nothing...
						break;
					case 'Coupon'				:
						$this -> model = 'Discount';
						
						if ($discounts = $this -> find_all(array('coupon_id' => $record_id))) {
							foreach ($discounts as $discount) {
								$this -> model = 'Discount';
								$this -> delete($discount -> id);
							}
						}
						
						break;
					case 'Category'				:
						global $Product, $wpcoKeyword, $wpcoCategoriesProduct;
						$this -> model = $Product -> model;

						if ($record -> useimage == "Y") {						
							if (!empty($record -> image -> name)) {
								$imagepath = WP_CONTENT_DIR . '/uploads/' . $this -> plugin_name . '/catimages/';
								$imagename = $record -> image -> name;
								$imagefull = $imagepath . $imagename;
								
								$thumbname = $wpcoHtml -> thumb_name($record -> image -> name, 'thumb');
								$thumbfull = $imagepath . $thumbname;
								
								$smallname = $wpcoHtml -> thumb_name($record -> image -> name, 'small');
								$smallfull = $imagepath . $smallname;
								
								@unlink($imagefull);
								@unlink($thumbfull);
								@unlink($smallfull);
							}
						}
						
						$this -> model = $wpcoCategoriesProduct -> model;						
						if ($categoriesproducts = $this -> find_all(array('category_id' => $record -> id))) {
							foreach ($categoriesproducts as $cp) {
								$this -> model = $wpcoCategoriesProduct -> model;
								$this -> delete($cp -> id);
							}
						}
					
						if (!empty($record -> post_id)) {
							$this -> wpimporting();
							wp_delete_post($record -> post_id);
						}
						
						if (!empty($record -> wpcat_id)) {
							wp_delete_category($record -> wpcat_id);
						}
						
						$this -> model = $this -> model;
						$this -> delete_all(array('category_id' => $record -> id));
						break;
					case 'Supplier'				:
						if (!empty($record -> post_id)) {
							$this -> wpimporting();
							wp_delete_post($record -> post_id);
						}
						
						global $wpdb, $Product;
						$wpdb -> query("UPDATE `" . $wpdb -> prefix . $Product -> table . "` SET `supplier_id` = '' WHERE `supplier_id` = '" . $record -> id . "'");
						break;
					case 'Product'				:
					
						do_action($this -> pre . '_product_deleted', $record_id);
					
						global $wpcoHtml, $Item, $wpcoKeyword, $wpcoCategoriesProduct, $wpcoProductsProduct;
						
						//unlink all product files
						if (!empty($record -> image -> name)) {
							$filename = $record -> image -> name;
							$filepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS;
							$filefull = $filepath . $filename;
							@unlink($filefull);
						}
					
						$this -> model = $wpcoCategoriesProduct -> model;
						$this -> delete_all(array('product_id' => $record_id));
					
						$this -> model = 'ProductsStyle';
						$this -> delete_all(array('product_id' => $record_id));
						
						$this -> model = 'ProductsOption';
						$this -> delete_all(array('product_id' => $record_id));
						
						$this -> model = 'wpcoProductsCoupon';
						$this -> delete_all(array('product_id' => $record_id));
						
						$this -> model = $Item -> model;
						$this -> delete_all(array('product_id' => $record_id));
						
						$this -> model = $wpcoKeyword -> model;
						$this -> delete_all(array('product_id' => $record_id));
						
						$this -> model = $wpcoProductsProduct -> model;
						$this -> delete_all(array('product_id' => $record_id));
						
						$this -> model = 'File';
						if ($files = $this -> find_all(array('product_id' => $record_id))) {
							foreach ($files as $file) {
								$this -> model = 'File';
								$this -> delete($file -> id);
							}
						}
					
						$this -> model = 'Image';
						if ($images = $this -> find_all(array('product_id' => $record_id))) {
							foreach ($images as $image) {
								$this -> model = 'Image';
								$this -> delete($image -> id);
							}
						}
						
						$this -> model = 'wpcoFieldsProduct';
						$this -> delete_all(array('product_id' => $record_id));
						
						if (!empty($record -> post_id)) {
							//$this -> wpimporting();
							wp_delete_post($record -> post_id);
						}
						break;
					case 'File'					:
						$filepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'downloads' . DS . '';
						$filename = $record -> filename;
						$filefull = $filepath . $filename;
						@unlink($filefull);
						break;
					case 'Image'				:						
						$imagepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS . '';
						@unlink($imagepath . $record -> filename);
						break;
					case 'Style'				:
						global $Option;
					
						$this -> model = $Option -> model;
						$this -> delete_all(array('style_id' => $record_id));
						break;
					case 'Option'				:
						$this -> model = 'ProductsOption';
						$this -> delete_all(array('option_id' => $record_id));
						break;
				}
				
				return true;
			}
		}
		
		return false;
	}
	
	function delete_all($conditions = array()) {
		global $wpdb, ${$this -> model};
		
		if (!empty($conditions)) {
			$query = "DELETE FROM `" . $wpdb -> prefix . "" . ${$this -> model} -> table . "` WHERE";
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
}

?>