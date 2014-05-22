<?php

class wpcoShortcodeHelper extends wpCheckoutPlugin {

	function wpcoShortcodeHelper() {
		return true;
	}
	
	function raw($atts = array(), $content = null) {
		return do_shortcode($content);
	}
	
	function cartsummary($atts = array(), $content = null) {
		global $wpdb, $wpcoDb, $Order, $wpcoCart, $Item;
		$defaults = array('navigation' => false, $couponform => false);
		extract(shortcode_atts($defaults, $atts));
		$co_id = $Order -> cart_order();
		$wpcoDb -> model = ($co_id['type'] == "order") ? $Order -> model : $wpcoCart -> model;
		$co = $wpcoDb -> find(array('id' => $co_id['id']));
		$wpcoDb -> model = $Item -> model;
		$items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']));
		$output = $this -> render('cart-summary', array('order' => $order, 'items' => $items, 'navigation' => $navigation, 'couponform' => $couponform), false, 'default');
		return $output;
	}
	
	function cart($atts = array(), $content = null) {		
		define('DONOTCACHEPAGE', true);
		define('DONOTCACHEDB', true);
		define('DONOTMINIFY', true);
		define('DONOTCDN', true);
		define('DONOTCACHCEOBJECT', true);
		
		if (!empty($_GET['buynow']) && $_GET['buynow'] == "Y") {
			global $wpcothemedoutput;
			$output = $wpcothemedoutput;
		} else {		
			switch ($_GET[$this -> pre . 'method']) {
				case 'authorize_aim'		:
					global $wpcothemedoutput;
					$output = $wpcothemedoutput;
					break;
				case 'pp_pro'				:
					global $wpcothemedoutput;
					$output = $wpcothemedoutput;
					break;
				case 'payxml'				:
					global $wpcothemedoutput;
					$output = $wpcothemedoutput;
					break;
				case 'payment'				:
					global $wpcothemedoutput;
					$output = $wpcothemedoutput;
					break;
				case 'contacts'				:
					global $wpcoerrors, $wpcoDb, $Order, $wpcoCart, $Item;
					$co_id = $Order -> cart_order();
					$wpcoDb -> model = ($co_id['type'] == "order") ? $Order -> model : $wpcoCart -> model;
					$co = $wpcoDb -> find(array('id' => $co_id['id']));
					$wpcoDb -> model = $Item -> model;
					$items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']));										
					$output = $this -> render('contacts', array('order' => $co, 'items' => $items, 'errors' => $wpcoerrors), false, 'default');
					break;
				case 'shipping'				:
					global $wpcoerrors, $wpcoglobalerrors;	
					switch ($_GET['api']) {
						case 'usps'		:
							global $wpcothemedoutput;
							$output = $wpcothemedoutput;
							break;
						case 'ups'		:
							global $wpcothemedoutput;
							$output = $wpcothemedoutput;
							break;
						case 'auspost'	:
							global $wpcothemedoutput;
							$output = $wpcothemedoutput;
							break;
						default			:
							global $wpdb, $wpcoDb, $Order;
							$order_id = $Order -> current_order_id();
							$wpcoDb -> model = $Order -> model;
							$order = $wpcoDb -> find(array('id' => $order_id));
							$userdata = $this -> userdata();
							$user = (empty($userdata)) ? $order : $userdata;							
							$output = $this -> render('shipping', array('user' => $user, 'errors' => $wpcoerrors, 'globalerrors' => $wpcoglobalerrors), false, 'default');
							break;
					}
					break;
				case 'canadapost'			:
					global $wpcothemedoutput;
					$output = $wpcothemedoutput;
					break;
				case 'fedex'				:
					global $wpcothemedoutput;
					$output = $wpcothemedoutput;
					break;
				case 'billing'				:
					global $wpcoerrors, $wpcothemedoutput, $wpcoglobalerrors;
					if (!empty($wpcothemedoutput)) {
						$output = $wpcothemedoutput;	
					} else {
						global $wpdb, $wpcoDb, $Order;
						$order_id = $Order -> current_order_id();
						$wpcoDb -> model = $Order -> model;
						$order = $wpcoDb -> find(array('id' => $order_id));
						$userdata = $this -> userdata();
						$user = (empty($userdata)) ? $order : $userdata;
						$output = $this -> render('billing', array('user' => $user, 'errors' => $wpcoerrors, 'globalerrors' => $wpcoglobalerrors), false, 'default');
					}
					break;
				case 'cosuccess'			:
					global $wpcothemedoutput;
					$output = $wpcothemedoutput;
					break;
				case 'cofailed'				:
					global $wpcothemedoutput;
					$output = $wpcothemedoutput;
					break;
				case 'coreturn'				:
					global $wpcothemedoutput;
					$output = $wpcothemedoutput;
					break;
				default						:
					global $wpdb, $wpcoDb, $wpcoCart, $Order, $Item, $Discount, $wpcoerrors, $wpcoglobalerrors;
					$co_id = $Order -> cart_order();
					
					if ($co_id['type'] == "order") { $wpcoDb -> model = $Order -> model; } 
					elseif ($co_id['type'] == "cart") { $wpcoDb -> model = $wpcoCart -> model; }
					$co = $wpcoDb -> find(array('id' => $co_id['id']));
					
					//if ($co_id['type'] == "order") { $coquery = "SELECT * FROM `" . $wpdb -> prefix . $Order -> table . "` WHERE `id` = '" . $co_id['id'] . "'"; }
					//elseif ($co_id['type'] == "cart") { $coquery = "SELECT * FROM `" . $wpdb -> prefix . $wpcoCart -> table . "` WHERE `id` = '" . $co_id['id'] . "'"; }
					//$co = $wpdb -> get_row($coquery);
					$wpcoDb -> model = $Item -> model;
					$items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']));
					$wpcoDb -> model = $Discount -> model;
					$discounts = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']));
					$output = $this -> render('cart', array('order' => $co, 'items' => $items, 'discounts' => $discounts, 'errors' => $wpcoerrors, 'globalerrors' => $wpcoglobalerrors), false, 'default');
					break;
			}
		}
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return apply_filters($this -> pre . '_cart_shortcode', $output);
	}
	
	function account($atts = array(), $content = null) {
		global $user_ID, $Order;
		
		define('DONOTCACHEPAGE', true);
		define('DONOTCACHEDB', true);
		define('DONOTMINIFY', true);
		define('DONOTCDN', true);
		define('DONOTCACHCEOBJECT', true);
		
		$defaults = array('id' => null);
		extract(shortcode_atts($defaults, $atts));	
		
		switch ($_GET[$this -> pre . 'method']) {
			case 'order'				:			
				echo wpCheckoutViews::order($_GET['id']);
				break;
			case 'downloads'			:
				echo wpCheckoutViews::downloads();
				break;
			case 'favorites'			:
				echo wpCheckoutViews::favorites();
				break;
			default						:
				if ($user_ID) {
					$conditions = array('user_id' => $user_ID, 'completed' => "Y");
					$orders_data = $this -> paginate($Order -> model, '*', '&amp;' . $this -> pre . 'method=history', $conditions, false, 10);
				}
				
				$output = $this -> render('account', array('orders_data' => $orders_data), false, 'default');
				break;
		}
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return $output;
	}
	
	function search($atts = array(), $content = null) {
		$output = $this -> render('search', false, false, 'default');
	
		if (!empty($_REQUEST)) {
			$output .= $this -> products($atts, false);
		}
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return $output;
	}
	
	function product($atts = array(), $content = null) {
		global $wpcoDb, $Product, $Image;
		$output = "";
		
		if ($this -> is_loggedin()) {
			$defaults = array('id' => null);
			extract(shortcode_atts($defaults, $atts));
			
			if (!empty($id)) {
				$wpcoDb -> model = $Product -> model;
				if ($product = $wpcoDb -> find(array('id' => $id, 'status' => 'active'))) {				
					switch ($_GET[$this -> pre . 'method']) {
						case 'images'		:
							$wpcoDb -> model = $Image -> model;
							$images = $wpcoDb -> find_all(array('product_id' => $id));
							$output = $this -> render('images' . DS . 'loop', array('product' => $product, 'images' => $images), false, 'default');
							break;
						default				:												
							if ((is_search() || is_feed()) && $this -> get_option('shortsearchresults') == "Y") {
								$output = $this -> render('products' . DS . 'search', array('product' => $product), false, 'default');	
							} else {							
								$output = $this -> render('products' . DS . 'view', array('product' => $product), false, 'default');
							}
							break;
					}
				}
			}
			
			if (!empty($_POST['buynow']) && $_POST['buynow'] == "Y") {
				global $wpcothemedoutput;
				if (!empty($wpcothemedoutput)) { $output = $wpcothemedoutput; }
			}
		} else {
			$output = $this -> render('contacts', array('gotoaccount' => true), false, 'default');
		}
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return $output;
	}
	
	function featuredproducts($atts = array(), $content = null) {
		$output = $this -> products(array('featured' => 1));
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return $output;
	}
	
	function products($atts = array(), $content = null) {
		global $wpdb, $wpcoDb, $wpcoHtml, $Javascript, $Product, $wpcoContent, $wpcoTax, $Order;
		
		if ($this -> is_loggedin()) {
			$conditions = false;
			$searchterm = (empty($_REQUEST[$this -> pre . 'searchterm'])) ? false : $_REQUEST[$this -> pre . 'searchterm'];
			
			/* BEG Change View Mode */
			$changeview = false;
			if (!empty($_REQUEST['changeview'])) {
				$changeview = $_REQUEST['changeview'];
				$currentview = $_COOKIE[$this -> pre . 'productsviewmode'];
				
				if (!empty($changeview) && ($changeview == "list" || $changeview == "grid")) {
					if ($changeview != $currentview) {
						$Javascript -> set_cookie($this -> pre . 'productsviewmode', $changeview);
					}
				}
			}
			/* END Change View Mode */
			
			if (!empty($searchterm)) {
				$conditions['(' . $wpdb -> prefix . $Product -> table . '.title'] = "LIKE '%" . strtolower($searchterm) . "%' 
				OR " . $wpdb -> prefix . $Product -> table . ".description LIKE '%" . strtolower($searchterm) . "%' 
				OR " . $wpdb -> prefix . $Product -> table . ".keywords LIKE '%" . strtolower($searchterm) . "%' 
				OR " . $wpdb -> prefix . $wpcoContent -> table . ".title LIKE '%" . strtolower($searchterm) . "%' 
				OR " . $wpdb -> prefix . $wpcoContent -> table . ".content LIKE '%" . strtolower($searchterm) . "%')";
			}
			
			$ordertype = $this -> get_option('loop_ordertype');
			
			$defaults = array(
				'perpage' 			=> 	$this -> get_option('loop_perpage'),
				'featured'			=>	0,
				'ordertype'			=>	((!empty($ordertype)) ? $ordertype : "random"),
				'orderby'			=>	$this -> get_option('loop_orderfield'),
				'order'				=>	strtoupper($this -> get_option('loop_orderdirection')),
			);
				
			extract(shortcode_atts($defaults, $atts));			
			$wpcoHtml -> loopdisplay($changeview);
			
			if (!empty($_REQUEST['min_price'])) { $conditions[$wpdb -> prefix . $Product -> table . '.price'][] = "LE " . $_REQUEST['min_price'] . ""; }
			if (!empty($_REQUEST['max_price'])) { $conditions[$wpdb -> prefix . $Product -> table . '.price'][] = "SE " . $_REQUEST['max_price'] . ""; }
			
			$productsorder = array('order', "ASC");
			if ($ordertype == "random") { $productsorder = "RAND"; }
			elseif ($ordertype == "specific") { $productsorder = array($orderby, $order); }
			$order = (!empty($_REQUEST['sortby']) && !empty($_REQUEST['sort'])) ? array($_REQUEST['sortby'], $_REQUEST['sort']) : $productsorder;
			$conditions[$wpdb -> prefix . $Product -> table . '.status'] = "active";
			if ($featured == 1) { $conditions[$wpdb -> prefix . $Product -> table . '.featured'] = "1"; }
			$conditions = apply_filters($this -> pre . '_products_conditions', $conditions);
			$data = $this -> paginate($Product -> model, "*", "N", $conditions, $searchterm, $perpage, $order);			
			$output = $this -> render('products' . DS . 'loop', array('products' => $data[$Product -> model], 'paginate' => $data['Paginate'], 'searchterm' => $searchterm, 'changeview' => $changeview), false, 'default');
		} else {
			$output = $this -> render('contacts', array('gotoaccount' => true), false, 'default');
		}
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return $output;
	}
	
	function suppliers($atts = array(), $content = null) {
		global $wpcoDb, $Supplier;	
		
		if ($this -> is_loggedin()) {
			$defaults = array('order' => "ASC", 'orderby' => "order");
			extract(shortcode_atts($defaults, $atts));
			
			$wpcoDb -> model = $Supplier -> model;
			if ($suppliers = $wpcoDb -> find_all(false, false, array($orderby, $order))) {
				$output = $this -> render('suppliers' . DS . 'index', array('suppliers' => $suppliers), false, 'default');
			}
		} else {
			$output = $this -> render('contacts', array('gotoaccount' => true), false, 'default');	
		}
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return $output;
	}
	
	function supplier($atts = array(), $content = null) {
		global $wpdb, $wpcoDb, $wpcoHtml, $Javascript, $Supplier, $Product;

		if ($this -> is_loggedin()) {
			$defaults = array('id' => null);
			extract(shortcode_atts($defaults, $atts));
			$output = "";
			
			$wpcoDb -> model = $Supplier -> model;
						
			if ($supplier = $wpcoDb -> find(array('id' => $id))) {	
				$defaults = array(
					'id' 				=>	null,
					'ordertype'			=>	((!empty($supplier -> pordertype)) ? $supplier -> pordertype : "random"),
					'orderby'			=>	$supplier -> porderfield,
					'order'				=>	$supplier -> porderdirection,
				);
				
				extract(shortcode_atts($defaults, $atts));
				$porder = $order;
			
				/* BEG Change View Mode */
				$changeview = false;
				if (!empty($_REQUEST['changeview'])) {
					$changeview = $_REQUEST['changeview'];
					$currentview = $_COOKIE[$this -> pre . 'productsviewmode'];
					
					if (!empty($changeview) && ($changeview == "list" || $changeview == "grid")) {
						if ($changeview != $currentview) {
							$Javascript -> set_cookie($this -> pre . 'productsviewmode', $changeview);
						}
					}
				}
				
				$wpcoHtml -> loopdisplay($changeview);
				/* END Change View Mode */
				
				if (empty($_REQUEST['sort']) || empty($_REQUEST['sortby'])) {
					if ($ordertype == "random") {
						$order = "RAND";
						$sortstring = "RAND()";
					} elseif ($ordertype == "specific") {
						$order = array($wpdb -> prefix . $Product -> table . "." . $orderby, $porder);
						$sortstring = $wpdb -> prefix . $Product -> table . "." . $orderby . " " . $porder;
					} elseif ($ordertype == "custom") {
						$order = array($wpdb -> prefix . $Product -> table . '.supplier_order', "ASC");
						$sortstring = $wpdb -> prefix . $Product -> table . ".supplier_order ASC";
					}
				} else {
					if ($_REQUEST['sortby'] == "price") {
						$order = array($wpdb -> prefix . $Product -> table . ".price", $_REQUEST['sort']);
						$sortstring = "ABS(" . $wpdb -> prefix . $Product -> table . ".price) " . $_REQUEST['sort'];
					} else {
						$order = array($wpdb -> prefix . $Product -> table . "." . $_REQUEST['sortby'], $_REQUEST['sort']);
						$sortstring = $wpdb -> prefix . $Product -> table . "." . $_REQUEST['sortby'] . " " . $_REQUEST['sort'];
					}
				}
			
				$conditions = array('supplier_id' => $supplier -> id, 'status' => 'active');
				$searchterm = false;
				$perpage = $this -> get_option('loop_perpage');
				$data = $this -> paginate($Product -> model, "*", "N", $conditions, $searchterm, $perpage, $order);						
				$output = $this -> render('suppliers' . DS . 'view', array('supplier' => $supplier, 'products' => $data[$Product -> model], 'paginate' => $data['Paginate'], 'changeview' => $changeview), false, 'default');
			}
		} else {
			$output = $this -> render('contacts', array('gotoaccount' => true), false, 'default');
		}
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return $output;
	}
	
	function categories($atts = array(), $content = null) {
		global $wpcoDb, $Category, $category_hierarchy;
	
		if ($this -> is_loggedin()) {
			$wpcoDb -> model = $Category -> model;
			$defaults = array('type' => "list", 'parentsonly' => "false", 'sortby' => "order", 'sort' => "ASC");
			extract(shortcode_atts($defaults, $atts));
			
			switch ($type) {
				case 'grid'			:
					$output = $this -> categoriesgrid($atts, $content, array($sortby, $sort));
					break;
				default				:
					$category_hierarchy = false;
					$onlymain = (!empty($parentsonly) && $parentsonly == "true") ? true : false;
					
					if ($categories = $Category -> hierarchy(0, true, $onlymain, array($sortby, $sort))) {
						$output = $categories;
					}
					break;
			}
		} else {
			$output = $this -> render('contacts', array('gotoaccount' => true), false, 'default');
		}
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return $output;
	}
	
	function category($atts = array(), $content = null) {
		global $Javascript, $wpdb, $wpcoDb, $wpcoHtml, $Category, $Product, $wpcoCategoriesProduct;
	
		if ($this -> is_loggedin()) {
			$defaults = array(
				'id' 			=> 	null, 
				'suborder' 		=> 	"ASC", 
				'suborderby' 	=> 	"title"
			);
			
			extract(shortcode_atts($defaults, $atts));
			
			if (!empty($id)) {
				$wpcoDb -> model = $Category -> model;				
				if ($category = $wpcoDb -> find(array('id' => $id))) {
				
					$defaults = array(
						'id' 			=> 	null, 
						'suborder' 		=> 	"ASC", 
						'suborderby' 	=> 	"title",
						'ordertype'		=>	((!empty($category -> pordertype)) ? $category -> pordertype : "random"),
						'orderby'		=>	$category -> porderfield,
						'order'			=>	strtoupper($category -> porderdirection),
					);
					
					extract(shortcode_atts($defaults, $atts));
					$porder = $order;
				
					/* BEG Change View Mode */
					$changeview = false;
					if (!empty($_REQUEST['changeview'])) {
						$changeview = $_REQUEST['changeview'];
						$currentview = $_COOKIE[$this -> pre . 'productsviewmode'];
						
						if (!empty($changeview) && ($changeview == "list" || $changeview == "grid")) {
							if ($changeview != $currentview) {
								$Javascript -> set_cookie($this -> pre . 'productsviewmode', $changeview);
							}
						}
					}
					
					$wpcoHtml -> loopdisplay($changeview);
					/* END Change View Mode */
					
					$conditions = array($wpdb -> prefix . $wpcoCategoriesProduct -> table . '.category_id' => $category -> id);
					$searchterm = false;
					$perpage = $this -> get_option('loop_perpage');
					
					if (empty($_REQUEST['sort']) || empty($_REQUEST['sortby'])) {
						if ($ordertype == "random") {
							$order = "RAND";
							$sortstring = "RAND()";
						} elseif ($ordertype == "specific") {
							$order = array($wpdb -> prefix . $Product -> table . "." . $orderby, $porder);
							$sortstring = $wpdb -> prefix . $Product -> table . "." . $orderby . " " . $porder;
						} elseif ($ordertype == "custom") {
							$order = array($wpdb -> prefix . $wpcoCategoriesProduct -> table . '.order', "ASC");
							$sortstring = $wpdb -> prefix . $wpcoCategoriesProduct -> table . ".order ASC";
						}
					} else {
						if ($_REQUEST['sortby'] == "price") {
							$order = array($wpdb -> prefix . $Product -> table . ".price", $_REQUEST['sort']);
							$sortstring = "ABS(" . $wpdb -> prefix . $Product -> table . ".price) " . $_REQUEST['sort'];
						} else {
							$order = array($wpdb -> prefix . $Product -> table . "." . $_REQUEST['sortby'], $_REQUEST['sort']);
							$sortstring = $wpdb -> prefix . $Product -> table . "." . $_REQUEST['sortby'] . " " . $_REQUEST['sort'];
						}
					}
					
					$conditions[$wpdb -> prefix . $Product -> table . '.status'] = "active";
					$data = $this -> paginate($wpcoCategoriesProduct -> model, "*", "N", $conditions, $searchterm, $perpage, $order);
					
					global $paginate;
					$query = "SELECT * FROM `" . $wpdb -> prefix . "" . $wpcoCategoriesProduct -> table . "` LEFT JOIN `" . $wpdb -> prefix . "" . $Product -> table . "` ON " . $wpdb -> prefix . "" . $wpcoCategoriesProduct -> table . ".product_id = " . $wpdb -> prefix . "" . $Product -> table . ".id WHERE " . $wpdb -> prefix . "" . $wpcoCategoriesProduct -> table . ".category_id = '" . $conditions[$wpdb -> prefix . $wpcoCategoriesProduct -> table . '.category_id'] . "' AND " . $wpdb -> prefix  . $Product -> table . ".status = 'active' ORDER BY " . $sortstring . "";
					
					if (empty($_GET['showall'])) {
						$query .= " LIMIT " . $paginate -> begRecord . " , " . $paginate -> per_page . ";";
					}
					
					$qproducts = $wpdb -> get_results($query);
					
					$products = array();
					if (!empty($qproducts)) {					
						foreach ($qproducts as $qproduct) {						
							$wpcoDb -> model = $Product -> model;
							$products[] = $this -> init_class($Product -> model, $qproduct);
						}
					}
					
					$output = $this -> render('categories' . DS . 'view', array('category' => $category, 'suborder' => $suborder, 'suborderby' => $suborderby, 'products' => $products, 'paginate' => $data['Paginate'], 'changeview' => $changeview), false, "default");
				}
			}
		} else {
			$this -> render('contacts', array('gotoaccount' => true), false, 'default');
		}
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return $output;
	}
	
	function categoriesgrid($atts = array(), $content = null, $order = array('order', "ASC")) {		
		$defaults = array('parentsonly' => "false");
		extract(shortcode_atts($defaults, $atts));
		
		global $wpcoDb, $wpcoHtml, $Category;
		$wpcoDb -> model = $Category -> model;
		$conditions = array('useimage' => "Y");
		if (!empty($parentsonly) && $parentsonly == "true") { $conditions['parent_id'] = 0; }
		
		if ($categories = $wpcoDb -> find_all($conditions, false, $order)) {
			ob_start();
			
			?>
			
			<div class="<?php echo $this -> pre; ?>categoriesgrid">
				<ul>
					<?php foreach ($categories as $category) : ?>
						<li>
							<div class="<?php echo $this -> pre; ?>categoryimg">
                                <?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($category -> image_url, $this -> get_option('scatthumbw'), $this -> get_option('scatthumbh'), 100), get_permalink($category -> post_id), array('title' => $category -> title)); ?>
							</div>
							<h4><?php echo $wpcoHtml -> link($category -> title, get_permalink($category -> post_id), array('title' => $category -> title)); ?></h4>
						</li>
					<?php endforeach; ?>
				</ul>
				<br class="<?php echo $this -> pre; ?>cleaner" />
			</div>
			
			<?php
			
			$output = ob_get_clean();
		}
		
		return $output;
	}
}

?>