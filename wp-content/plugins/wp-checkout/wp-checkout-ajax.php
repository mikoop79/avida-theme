<?php

define('DONOTCACHEPAGE', true);
define('DONOTCACHEDB', true);
define('DONOTMINIFY', true);
define('DONOTCDN', true);
define('DONOTCACHCEOBJECT', true);

if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }

$root = __FILE__;
for ($i = 0; $i < 4; $i++) $root = dirname($root);
require_once($root . DS . 'wp-config.php');
require_once(ABSPATH . 'wp-admin' . DS . 'includes' . DS . 'admin.php');

class wpcoAjax extends wpCheckoutPlugin {

	var $safecommands = array(
		'product_price',
		'add_to_cart',
		'empty_cart',
		'get_states_by_country',
		'add_favorite',
		'delete_favorite',
	);

	function wpcoAjax($cmd) {	
		if (!empty($cmd)) {
			if (in_array($cmd, $this -> safecommands) || current_user_can('checkout_welcome') || $this -> is_supplier()) {	
				$this -> register_plugin('wp-checkout', __FILE__);
			
				if (method_exists($this, $cmd)) {
					$this -> $cmd();
				}
			}
		}
	}
	
	function add_taxrate() {
		global $wpdb, $wpcoDb, $wpcoTax;
		
		if (!empty($_REQUEST['rate']) && !empty($_REQUEST['country_id'])) {
			if (!empty($_REQUEST['state']) && $_REQUEST['state'] == "undefined") {
				unset($_REQUEST['state']);	
			}
			
			$data = array('percentage' => $_REQUEST['rate'], 'country_id' => $_REQUEST['country_id'], 'state' => $_REQUEST['state']);			
			$wpcoDb -> model = $wpcoTax -> model;
			
			if (!$wpcoDb -> find(array('country_id' => $_REQUEST['country_id'], 'state' => $_REQUEST['state']))) {				
				$wpcoDb -> model = $wpcoTax -> model;
				if ($wpcoDb -> save($data, true)) {
					$this -> render_msg(__('Tax rate has been saved', $this -> plugin_name));	
				} else {
					$this -> render_err(__('Tax rate could not be saved', $this -> plugin_name));	
				}
			} else {
				$this -> render_err(__('A tax rate for this country and state already exists', $this -> plugin_name));	
			}
		} else {
			$this -> render_err(__('Please fill in all the tax rate fields', $this -> plugin_name));	
		}
		
		$this -> render('taxrates', false, true, 'admin');
	}
	
	function delete_taxrate() {
		global $wpcoDb, $wpcoTax;
		
		if (!empty($_GET['id'])) {
			$wpcoDb -> model = $wpcoTax -> model;
			
			if ($wpcoDb -> delete($_GET['id'])) {
				$this -> render_msg(__('Tax rate has been deleted', $this -> plugin_name));
			} else {
				$this -> render_err(__('Tax rate could not be deleted', $this -> plugin_name));	
			}
		}
		
		$this -> render('taxrates', false, true, 'admin');
	}
	
	function get_states_by_country($country_id = null, $inputname = null, $user_id = null) {
		global $wpdb, $wpcoHtml, $wpcoDb, $Country, $wpcoState;
		if (!empty($country_id)) { $_REQUEST['country_id'] = $country_id; }
		if (!empty($inputname)) { $_REQUEST['inputname'] = $inputname; }
		if (!empty($user_id)) { $_REQUEST['user_id'] = $user_id; }
		
		if (!empty($_REQUEST['inputname'])) {
			if (empty($_REQUEST['user_id']) && !is_admin()) {
				global $user_ID;
				$user = $this -> userdata($user_ID);
			} else {
				$user = $this -> userdata($_REQUEST['user_id']);
			}
			
			if (!empty($_REQUEST['country_id'])) {
				$conditions = array('country_id' => $_REQUEST['country_id']);	
			}
			
			$wpcoDb -> model = $wpcoState -> model;			
			if ($states = $wpcoDb -> find_all($conditions, false, array('name', "ASC"))) {
				?>
                
                <select name="<?php echo $_REQUEST['inputname']; ?>" class="state" id="<?php echo $wpcoHtml -> sanitize($_REQUEST['inputname']); ?>">
                	<option value=""><?php _e('- Select -', $this -> plugin_name); ?></option>
                	<?php foreach ($states as $state) : ?>
                    	<option <?php echo (!empty($user -> ship_state) && $user -> ship_state == $state -> name) ? 'selected="selected"' : ''; ?> value="<?php echo $state -> name; ?>"><?php echo $state -> name; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <?php
			} else {				
				if (empty($_REQUEST['showinput']) || $_REQUEST['showinput'] == "true") {
					?><input type="text" name="<?php echo $_REQUEST['inputname']; ?>" value="<?php echo esc_attr(stripslashes($user -> ship_state)); ?>" id="" /><?php
				}
			}
		}
	}
	
	function get_tax_states() {
		global $wpdb, $wpcoHtml, $wpcoDb, $Country, $wpcoState;
		
		if (!empty($_REQUEST['country_id']) && !empty($_REQUEST['inputname'])) {			
			$wpcoDb -> model = $wpcoState -> model;	
					
			if ($states = $wpcoDb -> find_all(array('country_id' => $_REQUEST['country_id']), false, array('name', "ASC"))) {
				?>
                
                <select style="width:150px;" name="<?php echo $_REQUEST['inputname']; ?>" id="<?php echo $wpcoHtml -> sanitize($_REQUEST['inputname']); ?>">
                	<option value=""><?php _e('- All States/Provinces -', $this -> plugin_name); ?></option>
                	<?php foreach ($states as $state) : ?>
                    	<option value="<?php echo $state -> name; ?>"><?php echo $state -> name; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <?php
			} else {
				_e('All States/Provinces', $this -> plugin_name);	
			}
		}
	}
	
	function image_delete() {
		global $wpdb, $wpcoDb, $Image;
		
		if (!empty($_REQUEST['image_id'])) {
			$wpcoDb -> model = $Image -> model;
			
			if ($wpcoDb -> delete($_REQUEST['image_id'])) {
				$this -> render_msg(__('Image has been removed', $this -> plugin_name));	
			}
		}
		
		$wpcoDb -> model = $Image -> model;
		$images = $wpcoDb -> find_all(array('product_id' => $_REQUEST['product_id']));
		$this -> render('images' . DS . 'product-images', array('images' => $images), true, 'admin');
		
		return true;
	}
	
	function products_by_cat() {
		global $wpdb, $wpcoDb, $Category, $Product, $wpcoCategoriesProduct;
		
		$products = array();
		$products_menu = '<option value="0">- ' . __('Display Category (All Products)', $this -> plugin_name) . ' -</option>';
	
		if (!empty($_GET['cat_id'])) {
			$query = "SELECT * FROM `" . $wpdb -> prefix . "" . $wpcoCategoriesProduct -> table . "` LEFT JOIN `" . $wpdb -> prefix . "" . $Product -> table . "` ON " . $wpdb -> prefix . "" . $wpcoCategoriesProduct -> table . ".product_id = " . $wpdb -> prefix . "" . $Product -> table . ".id WHERE " . $wpdb -> prefix . "" . $wpcoCategoriesProduct -> table . ".category_id = '" . $_GET['cat_id'] . "' ORDER BY " . $wpdb -> prefix . "" . $Product -> table . ".title ASC;";
			$qproducts = $wpdb -> get_results($query);
			
			if (!empty($qproducts)) {					
				foreach ($qproducts as $qproduct) {						
					$wpcoDb -> model = $Product -> model;
					if ($wpcoDb -> find(array('id' => $qproduct -> id), "`id`")) {
						$products[] = $this -> init_class($Product -> model, $qproduct);
					}
				}
			}
		} else {
			$wpcoDb -> model = $Product -> model;
			if ($qproducts = $wpcoDb -> find_all(null, null, array('title', "ASC"))) {
				foreach ($qproducts as $qproduct) {
					$wpcoDb -> model = $Product -> model;
					if ($wpcoDb -> find(array('id' => $qproduct -> id), "`id`")) {
						$products[] = $this -> init_class($Product -> model, $qproduct);
					}
				}
			}
		}
		
		if (!empty($products)) {
			foreach ($products as $product) {
				$products_menu .= '<option value="' . $product -> id . '">' . apply_filters($this -> pre . '_product_title', $product -> title) . '</option>';
			}
		}
		
		print $products_menu;
	}
	
	function fields_order() {
		global $wpcoDb, $wpcoField;
	
		if (!empty($_REQUEST['item'])) {
			foreach ($_REQUEST['item'] as $field_order => $field_id) {
				$wpcoDb -> model = $wpcoField -> model;
				$wpcoDb -> save_field('order', $field_order, array('id' => $field_id));
			}
			
			_e('Custom fields have been ordered', $this -> plugin_name);
		}
	
		return false;
	}

	function styles_order() {
		global $wpcoDb, $Style, $ProductsStyle;
		$prod = $_REQUEST['product_id'];
		
		if (!empty($_REQUEST['item'])) {
			foreach ($_REQUEST['item'] as $style_order => $style_id) {					
				$wpcoDb -> model = $Style -> model;
				$wpcoDb -> save_field('order', $style_order, array('id' => $style_id));
				$wpcoDb -> model = $ProductsStyle -> model;
				$wpcoDb -> save_field('order', $style_order, array('style_id' => $style_id, 'product_id' => $prod));
			}
			
			_e('Product variations have been ordered/sorted.', $this -> plugin_name);
		}
	
		return false;
	}
	
	function varoptions_order() {
		global $wpcoDb, $Style, $Option;
		
		if (!empty($_REQUEST['item']) && !empty($_REQUEST['style_id'])) {
			foreach ($_REQUEST['item'] as $option_order => $option_id) {
				$wpcoDb -> model = $Option -> model;
				$wpcoDb -> save_field('order', ($option_order + 1), array('id' => $option_id));
			}
			
			_e('Variation options have been ordered accordingly', $this -> plugin_name);
		}
		return false;	
	}
	
	function gen_coupon_code() {
		global $Coupon;
		$code = strtoupper(substr(md5(rand(0, 999)), 0, 12));
		$Coupon -> data -> code = $code;
		$this -> render('coupons' . DS . 'save-code');
	}
	
	function add_to_cart() {
		header('Content-Type: text/xml; charset=utf-8');
		
		global $user_ID, $Order, $wpcoCart, $wpdb, $wpcoDb, $wpcoField, $wpcoAuth, $Product, $Item, $Style, $Option, $ProductsOption, $Javascript;
		$errors = false;
		$co_id = $Order -> cart_order();
	
		if (!empty($_POST)) {			
			if (!empty($_POST['Item']['product_id'])) {
				$wpcoDb -> model = $Product -> model;
			
				if ($product = $wpcoDb -> find(array('id' => $_POST['Item']['product_id']))) {
					$stylesvalidate = true;
					
					/* Product Inventory */
					$countgood = true;
					if (!empty($product -> inventory) && $product -> inventory > 0) {
						if (!empty($_POST['Item']['count'])) {
							if ($_POST['Item']['count'] <= $product -> inventory) {
								//check all items of the order for this product
								$wpcoDb -> model = $Item -> model;
								if ($otheritems = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id'], 'product_id' => $product -> id))) {
									$count = $_POST['Item']['count'];
									
									foreach ($otheritems as $otheritem) {
										if (!empty($otheritem -> count)) {
											$count += $otheritem -> count;
										}
									}
									
									if ($count >= $product -> inventory) {
										$countgood = false;
										$errors['count'] = __('The total number of units in the inventory is', $this -> plugin_name) . ' <b>' . $product -> inventory . '</b>';
									}
								}
								
								$Item -> id = false;
								$Item -> data -> id = false;
							} else {
								$countgood = false;
								$errors['count'] = __('The total number of units in the inventory is', $this -> plugin_name) . ' <b>' . $product -> inventory . '</b>';
							}
						} else {
							$countgood = false;
							$errors['count'] = __('Please choose how many you want', $this -> plugin_name);
						}
					}
									
					if (!empty($product -> styles)) {
						foreach ($product -> styles as $style_id) {
							$wpcoDb -> model = $Style -> model;
						
							if ($style = $wpcoDb -> find(array('id' => $style_id))) {
								if (empty($_POST['Item']['styles'][$style_id])) {
									$stylesvalidate = false;
									$errors['styles_' . $style_id] = __('Please select', $this -> plugin_name) . ' ' . $style -> title;
								} else {
									//check stock on this…
									$itemoption = $_POST['Item']['styles'][$style_id];
									
									$itemsquery = "SELECT * FROM `" . $wpdb -> prefix . $Item -> table . "` WHERE `product_id` = '" . $product -> id . "' AND `" . $co_id['type'] . "_id` = '" . $co_id['id'] . "'";
									$allitems = $wpdb -> get_results($itemsquery);
									
									if (!empty($itemoption)) {
										if (is_array($itemoption)) {
											//checkboxes...
											foreach ($itemoption as $io) {
												$optionquery = 
												"SELECT " . $wpdb -> prefix . $Option -> table . ".id, 
												" . $wpdb -> prefix . $Option -> table . ".title, 
												" . $wpdb -> prefix . $ProductsOption -> table . ".inventory FROM " . $wpdb -> prefix . $Option -> table . 
												" LEFT JOIN " . $wpdb -> prefix . $ProductsOption -> table . 
												" ON " . $wpdb -> prefix . $Option -> table . ".id = 
												" . $wpdb -> prefix . $ProductsOption -> table . ".option_id WHERE 
												" . $wpdb -> prefix . $Option -> table . ".id = '" . $io . "' AND 
												" . $wpdb -> prefix . $ProductsOption -> table . ".product_id = '" . $product -> id . "'";
												
												if ($option = $wpdb -> get_row($optionquery)) {
													if ($option -> inventory >= 0) {
														if ($_POST['Item']['count'] <= $option -> inventory) {
															if (!empty($allitems)) {
																$otheritemcount = 0;
															
																foreach ($allitems as $allitem) {
																	$allitem_styles = maybe_unserialize($allitem -> styles);
																	
																	if (!empty($allitem_styles[$style_id])) {
																		if (in_array($option -> id, $allitem_styles[$style_id])) {
																			$otheritemcount += $allitem -> count;
																		}
																	}
																}
																
																$count = ($_POST['Item']['count'] + $otheritemcount);																
																if ($count > $option -> inventory) {
																	$errors['styles_' . $style_id] = sprintf(__('Stock for %s - %s is %d', $this -> plugin_name), $style -> title, $option -> title, $option -> inventory);
																	$countgood = false;
																}
															} else {
																$countgood = true;
															}
														} else {
															$errors['styles_' . $style_id] = sprintf(__('Stock for %s - %s is %d', $this -> plugin_name), $style -> title, $option -> title, $option -> inventory);
															$countgood = false;
														}
													}
												}
											}
										} else {
											$optionquery = "SELECT * FROM `" . $wpdb -> prefix . $Option -> table . "` WHERE `id` = '" . $itemoption . "'";
											$option = $wpdb -> get_row($optionquery);
											$productsoptionquery = "SELECT * FROM `" . $wpdb -> prefix . $ProductsOption -> table . "` WHERE `option_id` = '" . $itemoption . "' AND `product_id` = '" . $product -> id . "'";
											if ($productsoption = $wpdb -> get_row($productsoptionquery)) {
												if ($productsoption -> inventory >= 0) {
													if ($_POST['Item']['count'] <= $productsoption -> inventory) {
														if (!empty($allitems)) {
															$otheritemcount = 0;
														
															foreach ($allitems as $allitem) {
																$allitem_styles = maybe_unserialize($allitem -> styles);																
																if (!empty($allitem_styles[$style_id]) && $allitem_styles[$style_id] == $productsoption -> option_id) {
																	$otheritemcount += $allitem -> count;
																}
															}
															
															$count = ($_POST['Item']['count'] + $otheritemcount);															
															if ($count > $productsoption -> inventory) {
																$errors['styles_' . $style_id] = sprintf(__('Stock for %s - %s is %d', $this -> plugin_name), $style -> title, $option -> title, $productsoption -> inventory);
																$countgood = false;
															}
														} else {
															$countgood = true;
														}
													} else {
														$errors['styles_' . $style_id] = sprintf(__('Stock for %s - %s is %d', $this -> plugin_name), $style -> title, $option -> title, $productsoption -> inventory);
														$countgood = false;
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
					/* Check the minimum order on the product */
					if (!empty($product -> min_order) && $product -> min_order > 1) {
						if ($_POST['Item']['count'] < $product -> min_order) {
							$countgood = false;
							$errors['count'] = __('Minimum order is:', $this -> plugin_name) . ' <strong>' . $product -> min_order . '</strong>';
						}
					}
					
					$fieldsvalidate = true;
					if (!empty($product -> cfields)) {						
						foreach ($product -> cfields as $field_id) {
							$value = "";
							$wpcoDb -> model = $wpcoField -> model;
							
							if ($field = $wpcoDb -> find(array('id' => $field_id))) {
								if (!empty($field -> required) && $field -> required == "Y") {
									if (empty($_POST['Item']['fields'][$field -> id]) && $_POST['Item']['fields'][$field -> id] != "0") {
										$errors['fields_' . $field_id] = (empty($field -> error)) ? __('Please fill in', $this -> plugin_name) . ' ' . $field -> title : $field -> error;
										$fieldsvalidate = false;
									}
								}
								
								if (!empty($_POST['Item']['fields'][$field -> id])) {
									$value = $_POST['Item']['fields'][$field -> id];
												
									if (is_array($value) || is_object($value)) {
										$value = serialize($value);
									}
									
									$_POST['Item'][$field -> slug] = $value;
								}
							}
						}
					}
			
					if (($stylesvalidate == true && $fieldsvalidate == true && $countgood == true)) {		
						$wpcoDb -> model = $Item -> model;
						
						if (!$wpcoDb -> save($_POST, true)) {
							$errors = array_merge((array) $errors, (array) $Item -> errors);
						} else {
							$successmsg = __('Product added', $this -> plugin_name);
						}
					}
				} else {
					$errors[] = __('Product cannot be read', $this -> plugin_name);
				}
			} else {
				$errors[] = __('No product was specified', $this -> plugin_name);
			}
		} else {
			$errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		$number = $this -> widget_active('cart');
		$intnumber = preg_replace("/[^0-9]/si", "", $number);
		$alloptions = $this -> get_option('-widget');
		$options = $alloptions[$intnumber];
		
		$wpcoDb -> model = ($co_id['type'] == "order") ? $Order -> model : $wpcoCart -> model;
		$co = $wpcoDb -> find(array('id' => $co_id['id']));
		$wpcoDb -> model = $Item -> model;
		$items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']));
		
		if (empty($errors)) {
			global $wp_registered_sidebars, $wp_registered_widgets;
			if (!empty($wp_registered_sidebars)) {
				foreach ($wp_registered_sidebars as $skey => $sidebar) {
					$args = $sidebar;
					break 1;
				}
			}
			
			?>
            <result>
            	<success>Y</success>
                <message><![CDATA[<?php _e('Product added', $this -> plugin_name); ?>]]></message>
                <html><![CDATA[<?php $this -> render('widget-cart', array('number' => $number, 'args' => $args, 'options' => $options, 'errors' => $errors, 'successmsg' => $successmsg, 'isajax' => true), true, 'default'); ?>]]></html>
                <?php if ($this -> get_option('cart_addajax') == "Y" && $this -> get_option('cart_summary_overlay') == "Y") : ?>
                	<summary><![CDATA[<?php $this -> render('cart-summary', array('order' => $co, 'items' => $items, 'navigation' => true, 'couponform' => false, 'message' => $successmsg), true, 'default'); ?>]]></summary>
                <?php endif; ?>
            </result>
            <?php
		} else {			
			?>
            <result>
            	<success>N</success>
                <message><![CDATA[<?php _e('Product not added', $this -> plugin_name); ?>]]></message>
            	<html><![CDATA[<?php $this -> render('widget-cart', array('errors' => $errors, 'args' => $args, 'options' => $options, 'number' => $number, 'isajax' => true), true, 'default'); ?>]]></html>
            	<?php if ($this -> get_option('cart_addajax') == "Y" && $this -> get_option('cart_summary_error') == "Y") : ?>
            		<summary><![CDATA[<?php $this -> render('cart-summary', array('order' => $co, 'items' => $items, 'errors' => $errors), true, 'default'); ?>]]></summary>
            	<?php endif; ?>
            </result>
            <?php
		}
	}
	
	function supplier_add() {
		global $wpcoDb, $Supplier, $Product;
		$wpcoDb -> model = $Supplier -> model;
		$supplier_data = array('name' => $_REQUEST['name']);
		
		if (!$wpcoDb -> save($supplier_data, true)) {
			$errors = $Supplier -> errors;
		} else {
			$supplier_insertid = $Supplier -> insertid;	
		}
		
		$this -> render('suppliers' . DS . 'product-suppliers', array('errors' => $errors, 'supplier_id' => $supplier_insertid, 'supplier_add_name' => $_REQUEST['name']), true, 'admin');
	}
	
	function filter_content($content = '') {
		if (!empty($content)) {
			if (preg_match("/\{" . $this -> pre . "\_(.*?)\}/i", $content, $matches)) {
				$content = preg_replace_callback("/\{" . $this -> pre . "\_(.*?)\}/i", array($this, 'replace_tags'), $content);
			}
		}
	
		return $content;
	}
	
	function category_add() {
		header('Content-Type: text/xml; charset=utf-8');
		global $Category;
		
		$category_data = array(
			'title'				=>	$_REQUEST['title'],
			'description'		=>	$_REQUEST['title'],
			'keywords'			=>	$_REQUEST['title'],
			'parent_id'			=>	$_REQUEST['parent'],
		);
		
		if ($supplier = $this -> is_supplier()) {
			$category_data['supplier_id'] = $supplier -> id;	
		}
		
		$success = "N";
		$message = "";
		$html = "";
		
		if (!$Category -> save($category_data)) {
			$success = "N";
			$insertid = false;
			$message = __('Category could not be saved', $this -> plugin_name);
		} else {
			$insertid = $Category -> insertid;
			$success = "Y";
			$message = __('Category has been saved', $this -> plugin_name); 
		}
		
		$html = $this -> render('categories' . DS . 'product-categories', array('message' => $message, 'product_id' => $_REQUEST['product_id'], 'insertid' => $insertid), false, 'admin');
		
		?>
        <response>
        	<success><?php echo $success; ?></success>
            <message><![CDATA[<?php echo $message; ?>]]></message>
            <html><![CDATA[<?php echo $html; ?>]]></html>
        </response>
        <?php
	}
	
	function category_delete() {
		header('Content-Type: text/xml; charset=utf-8');
		global $wpcoDb, $Category;
		$wpcoDb -> model = $Category -> model;
		$category = $wpcoDb -> find(array('id' => $_REQUEST['category_id']));
		$supplier = $this -> is_supplier();
		
		$success = "N";
		$message = "";
		$html = "";
		
		$wpcoDb -> model = $Category -> model;
		if (!$supplier || ($supplier && $supplier -> id == $category -> supplier_id)) {
			if (!$wpcoDb -> delete($_REQUEST['category_id'])) {
				$success = "N";
				$message = __('Category cannot be removed', $this -> plugin_name);
			} else {
				$success = "Y";
				$message = __('Category has been removed', $this -> plugin_name); 
			}
		} else {
			$success = "N";
			$message = __('Category not added by you', $this -> plugin_name);	
		}
		
		$html = $this -> render('categories' . DS . 'product-categories', array('message' => $message, 'product_id' => $_REQUEST['product_id']), false, 'admin');
		
		?>
        <response>
        	<success><?php echo $success; ?></success>
            <message><![CDATA[<?php echo $message; ?>]]></message>
            <html><![CDATA[<?php echo $html; ?>]]></html>
        </response>
        <?php
	}
	
	function empty_cart() {
		global $wpcoDb, $Product, $Order, $wpcoCart, $wpcoFieldsOrder, $wpcoAuth, $user_ID, $Item;
		
		$errors = false;
		$co_id = $Order -> cart_order();
		
		if (!empty($co_id['id'])) {
			$wpcoDb -> model = $Item -> model;
			if ($wpcoDb -> delete_all(array($co_id['type'] . '_id' => $co_id['id']))) {
				$wpcoDb -> model = $wpcoFieldsOrder -> model;
				$wpcoDb -> delete_all(array($co_id['type'] . '_id' => $co_id['id']));
				if ($co_id['type'] == "order") {
					$wpcoDb -> model = $Order -> model;
					$wpcoDb -> delete($co_id['id']);
				} else {
					$wpcoDb -> model = $wpcoCart -> model;
					$wpcoDb -> delete($co_id['id']);
				}
				$wpcoAuth -> delete_cookie();			
				$successmsg = __('All items removed', $this -> plugin_name);
			}
		}
		
		global $wp_registered_sidebars;
		if (!empty($wp_registered_sidebars)) {
			foreach ($wp_registered_sidebars as $skey => $sidebar) {
				$args = $sidebar;
				break 1;
			}
		}
		
		$number = $this -> widget_active('cart');
		$intnumber = preg_replace("/[^0-9]/si", "", $number);
		$alloptions = $this -> get_option('-widget');
		$options = $alloptions[$intnumber];
		
		if ($number == $this -> widget_active('cart')) {
			$options['title'] = $this -> get_option('cart_hardcodedtitle');
		}
		
		$this -> render('widget-cart', array('args' => $args, 'number' => $number, 'isajax' => true, 'options' => $options, 'errors' => $errors, 'successmsg' => $successmsg), true, 'default');
	}
	
	function product_price() {		
		global $Product, $wpcoHtml;						
		$price = $Product -> product_price($_REQUEST);
		
		if (!empty($price) && $price > 0) {
			$price = $wpcoHtml -> currency_price($price, false, false);
		} else {
			$price = $this -> get_option('product_zerotext');
		}
		
		echo $price;
		
		exit(); die();
	}
	
	function invoice_iframe() {		
		$order = array(
			'id'				=>	"123",
			'pmethod'			=>	"pp",
			'bill_fname'		=>	"First",
			'bill_lname'		=>	"Last",
			'bill_company'		=>	"Company Name",
			'bill_address'		=>	"123 Long St",
			'bill_city'			=>	"My City",
			'bill_state'		=>	"My State",
			'bill_country'		=>	"199",
			'bill_zipcode'		=>	"12345",
			'ship_fname'		=>	"First",
			'ship_lname'		=>	"Last",
			'ship_company'		=>	"Company Name",
			'ship_address'		=>	"123 Long St",
			'ship_city'			=>	"My City",
			'ship_state'		=>	"My State",
			'ship_country'		=>	"199",
			'ship_zipcode'		=>	"12345",
		);
		
		$user = array(
			'bill_email'		=>	'email@domain.com',
		);
		
		$this -> render('invoice', array('order' => (object) $order, 'user' => (object) $user), true, 'email');
	}

	function add_favorite() {
		global $user_ID, $wpcoDb, $wpcoHtml, $wpcoFavorite;		

		if(!empty($_REQUEST)) {
			$favorite_data = array(
				'product_id'	=>	$_REQUEST['product'],
				'user_id'		=>	$user_ID,			
			);

			$wpcoDb -> model = $wpcoFavorite -> model;
			if (!$wpcoDb -> find($favorite_data)) {
				$wpcoDb -> model = $wpcoFavorite -> model;
				if (!$wpcoDb -> save($favorite_data, true)) {
					echo '<span class="favoritefail">'. __('Favorite could not be added', $this -> plugin_name) .'</span>';
				} else {
					echo  '<span class="favoriteadded">'.__('Favorite has been added to your', $this -> plugin_name) . " " . $wpcoHtml -> link(__('account page', $this -> plugin_name), $wpcoHtml -> account_url()).'</span>';;
				}
			} else {
				echo '<span class="favoritefail">'.__('Already a favorite!', $this -> plugin_name).'</span>';;	
			}
		}
	}
	
	function delete_favorite() {
		global $user_ID, $wpcoDb, $wpcoFavorite;
		$errors = array();
		
		if (!empty($_REQUEST['favorite_id'])) {
			$wpcoDb -> model = $wpcoFavorite -> model;
			if ($favorite = $wpcoDb -> find(array('id' => $_REQUEST['favorite_id']))) {
				if ($favorite -> user_id == $user_ID) {
					$wpcoDb -> model = $wpcoFavorite -> model;
					if ($wpcoDb -> delete($_REQUEST['favorite_id'])) {
						//do nothing...
					} else {
						$errors[] = __('Favorite could not be removed', $this -> plugin_name);	
					}
				} else {
					$errors[] = __('Favorite belongs to a different user', $this -> plugin_name);	
				}
			} else {
				$errors[] = __('Favorite could not be found', $this -> plugin_name);	
			}
		} else {
			$errors[] = __('No favorite was specified', $this -> plugin_name);	
		}
		
		$conditions = array('user_id' => $user_ID);
		$favorite_data = $this -> paginate($wpcoFavorite -> model, '*', '&amp;' . $this -> pre . 'method=history', $conditions, false, 10);
		$this -> render('favorite', array('errors' => $errors, 'favorites' => $favorite_data[$wpcoFavorite -> model], 'paginate' => $favorite_data['Paginate']), true, 'default');
	}
}

$cmd = $_GET['cmd'];
$wpcoAjax = new wpcoAjax($cmd);

?>