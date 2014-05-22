<?php

if (!function_exists('wpco_cart_url')) {
	function wpco_cart_url() {
		global $wpcoHtml;
		$cart_url = $wpcoHtml -> cart_url();
		return $cart_url;
	}
}

if (!function_exists('wpco_success_url')) {
	function wpco_success_url() {
		global $wpcoHtml;
		$success_url = $wpcoHtml -> success_url();
		return $success_url;
	}
}

if (!function_exists('wpco_return_url')) {
	function wpco_return_url($query = null) {
		global $wpcoHtml;
		$return_url = $wpcoHtml -> return_url();
		if (!empty($query)) { $return_url = $wpcoHtml -> retainquery($query, $return_url); }
		return $return_url;
	}
}

/**
 *
 */
if (!function_exists('wpco_add_option')) {
	function wpco_add_option($option_name = null, $option_value = null) {
		if (!empty($option_name)) {
			if (add_option('wpco' . $option_name, $option_value)) {
				return true;
			}
		}
		
		return false;
	}
}

/**
 *	Gets an option/setting stored using add_option/update_option
 *
 *	@param $option STRING. The name of the option to fetch/get
 * 	@return MIXED. Returns false if it fails or a string/int/array/etc.
 */
if (!function_exists('wpco_get_option')) {
	function wpco_get_option($option = null) {
		if (!empty($option)) {
			return get_option('wpco' . $option);
		}
		
		return false;
	}
}

/** 
 *
 *
 */
if (!function_exists('wpco_get_products')) {
	function wpco_get_products($conditions = null, $args = null) {
		global $wpdb, $wpcoDb, $Product;
		
		$cdefaults = array('status' => "active");
		$c = wp_parse_args($conditions, $cdefaults);
		
		$defaults = array('fields' => null, 'order' => array('id', "ASC"), 'limit' => false, 'assign' => false, 'distinct' => false);
		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);
		
		$products = $wpcoDb -> find_all($c, $fields, $order, $limit, $assign, $distinct);
		return $products;
	}
}

/**
 *	Checks to see if the current post/page is a product.
 *
 *	@param int $post_id Optional. The ID of the post/page to check. Uses current post/page ID if empty.
 *	@return bool
 */
if (!function_exists('wpco_is_product')) {
	function wpco_is_product($post_id = null) {
		global $wp_query, $wpdb, $wpcoDb, $Product, $post, $wpCheckout;
		
		if (!isset($wp_query)) {
			_doing_it_wrong( __FUNCTION__, __('Conditional tags do not work before the query is run. Before then, they always return false.'), $wpCheckout -> version);
			return false;
		}
		
		if (!empty($post_id)) {
			$posttocheck = get_post($post_id);
		} else {
			$posttocheck = $post;
		}
		
		if (!empty($posttocheck -> ID)) {
			$wpcoDb -> model = $Product -> model;
			if ($product = $wpcoDb -> find(array('post_id' => $posttocheck -> ID))) {
				return true;
			}
		
			/*$productquery = "SELECT `id` FROM `" . $wpdb -> prefix . $Product -> table . "` WHERE `post_id` = '" . $posttocheck -> ID . "'";
			
			if ($product = $wpdb -> get_row($productquery)) {			
				return true;
			}*/
		}
	}
}

if (!function_exists('wpco_is_category')) {
	function wpco_is_category($post_id = null) {
		global $wpdb, $Category;
	
		if (empty($post_id)) {
			global $post;
			$post_id = $post -> ID;
		}
		
		$categoryquery = "SELECT `id` FROM `" . $wpdb -> prefix . $Category -> table . "` WHERE `post_id` = '" . $post_id . "'";
		if ($category = $wpdb -> get_row($categoryquery)) {
			return true;
		}
		
		return false;
	}
}

/**
 *	Checks to see if the site is currently in the checkout procedure.
 *	Either shopping cart, shipping, billing or payment page.
 *
 *	@return bool
 */
if (!function_exists('wpco_is_checkout')) {
	function wpco_is_checkout() {	
		global $wp_query, $post, $wpCheckout;
		
		if (!isset($wp_query)) {
			_doing_it_wrong( __FUNCTION__, __('Conditional tags do not work before the query is run. Before then, they always return false.'), $wpCheckout -> version);
			return false;
		}
		
		$scpage_id = $wpCheckout -> get_option('cartpage_id');
		if (!empty($post -> ID) && $post -> ID == $scpage_id) {
			return true;
		}
		
		return false;
	}
}

/**
 *
 */
if (!function_exists('wpco_get_order')) {
	function wpco_get_order($order_id = null) {
		global $wpcoDb, $Order;
	
		if (!empty($order_id)) {
			$wpcoDb -> model = $Order -> model;
		
			if ($order = $wpcoDb -> find(array('id' => $order_id))) {
				return $order;
			}
		}
		
		return false;
	}
}

/**
 *	Gets the total (including variations, fields, shipping, tax, etc.) of a cart, current order or finished order by ID.
 *
 * @param $order_id INT. The ID of the cart/order to fetch the total for.
 * @return $total FLOAT. The total amount of the order retrieved/calculated.
 */
if (!function_exists('wpco_order_total')) {
	function wpco_order_total($order_id = null) {
		if (!empty($order_id)) {
			global $Order;
			
			if ($total = $Order -> total($order_id, true, true, true, true, true)) {
				return $total;
			}
		}
		
		return false;
	}
}

/**
 * Renders a file inside the plugin or extension plugins
 *
 * @param $file STRING. File path and name of the file to render.
 * @param $params ARRAY. Pass an Array of parameters to include for use in the file.
 * @param $echo BOOL. Set to true to output/echo the file contents and false to return it.
 * @param $folder STRING. 'admin', 'default', etc... for the folder inside 'wp-checkout/views/'. Set to false when rendering custom extension file.
 * @param $extension STRING. If $folder is set to false specify an extension slug like 'myextension' to render the file inside it's folder.
 * 
 * @return $output STRING. It will return the $output (if any) which you can use in a variable.
 */
if (!function_exists('wpco_render')) {
	function wpco_render($file = null, $params = null, $echo = true, $folder = null, $extension = null) {
		global $wpCheckout;
		$output = $wpCheckout -> render($file, $params, $echo, $folder, $extension);
		return $output;
	}
}

/**
 * Fetches an array of coupons currently in the database.
 * 
 * @return $coupons ARRAY. An Array of all the available coupons in the database.
 */
if (!function_exists('wpco_get_coupons')) {
	function wpco_get_coupons($conditions = array()) {
		global $wpcoDb, $Coupon;
		$wpcoDb -> model = $Coupon -> model;
		
		if ($coupons = $wpcoDb -> find_all($conditions)) {
			return $coupons;
		}
		
		return false;
	}
}

if (!function_exists('wpco_get_coupon')) {
	function wpco_get_coupon($coupon_id = null) {
		global $wpcoDb, $Coupon;
		$wpcoDb -> model = $Coupon -> model;
		$coupon = $wpcoDb -> find(array('id' => $coupon_id));
		return $coupon;
	}
}

?>