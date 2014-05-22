<?php

class wpcoHtmlHelper extends wpCheckoutPlugin {

	var $name = 'Html'; 
	
	function help($help = null) {
		if (!empty($help)) {
			ob_start();
		
			?>
			
			<span class="<?php echo $this -> pre; ?>help">
				<a href="" onclick="return false;" title="<?php echo esc_attr(stripslashes($help)); ?>">?</a>
			</span>
			
			<?php
			
			$html = ob_get_clean();
			return $html;
		}
	}
	
	function wp_has_current_submenu($submenu = false) {	
		$menu = false;
		if (!empty($submenu)) {
			if (preg_match("/^checkout\-([^-]+)?/si", $submenu, $matches)) {
				$menu = $matches[0];
			}
		}
	
		?>
		
		<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('li#toplevel_page_checkout').attr('class', "wp-has-submenu wp-has-current-submenu wp-menu-open menu-top toplevel_page_checkout menu-top-last");
			jQuery('li#toplevel_page_checkout > a').attr('class', "wp-has-submenu wp-has-current-submenu wp-menu-open menu-top toplevel_page_checkout menu-top-last");
			<?php if (!empty($menu)) : ?>jQuery('li#toplevel_page_checkout ul.wp-submenu li a[href="admin.php?page=<?php echo $menu; ?>"]').attr('class', "current").parent().attr('class', "current");<?php endif; ?>
		});
		</script>
		
		<?php
	}
	
	function loopdisplay($changeview = "grid") {
		global $displaygrid;
		$displaygrid = true;
		$displaygrid = (!$this -> get_option('loop_display') || $this -> get_option('loop_display') == "grid") ? true : false; 
		
		if (!empty($related) && $related == true) {
			$displaygrid = ($this -> get_option('related_display') == "list") ? false : true;	
		}
		
		/* What is the view mode? */
		if (!empty($changeview)) {
			if ($changeview == "list") {
				$displaygrid = false;	
			} else {
				$displaygrid = true;
			}
		} elseif (isset($_COOKIE[$this -> pre . 'productsviewmode'])) {
			$productsviewmode = $_COOKIE[$this -> pre . 'productsviewmode'];
			
			if ($productsviewmode == "list") {
				$displaygrid = false;	
			} else {
				$displaygrid = true;
			}
		}
		
		return $displaygrid;
	}
	
	function link($name = null, $href = '/', $args = array()) {
		$defaults = array(
			'title'			=>	(empty($args['title'])) ? $name : $args['title'],
			'target'		=>	"_self",
			'class' 		=>	"wpco",
			'rel'			=>	"",
			'onclick'		=>	"",
		);
		
		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);
		
		ob_start();
		
		?><a class="<?php echo $class; ?>" rel="<?php echo $rel; ?>" <?php echo (!empty($onclick)) ? 'onclick="' . $onclick . '"' : ''; ?> href="<?php echo $href; ?>" target="<?php echo $target; ?>" title="<?php echo strip_tags($title); ?>"><?php echo $name; ?></a><?php
		
		$link = ob_get_clean();
		return $link;
	}
	
	function current_url() {		
		$currentUrl = (($_SERVER['HTTPS'] != "on") ? 'http://' : 'https://');
		$currentUrl .= $_SERVER['HTTP_HOST'];
		$currentUrl .= $_SERVER['REQUEST_URI'];
		$currentUrl .= (!empty($_SERVER['QUERY_STRING']) && !preg_match("/(\?)/i", $_SERVER['REQUEST_URI'])) ? '?' . $_SERVER['QUERY_STRING'] : '';		
		return $currentUrl;
	}
	
	function section_name($section = null) {
		$name = "";
	
		switch ($section) {
			case 'welcome'					:
				$name = __('Overview', $this -> plugin_name);
				break;
			case 'import'					:
				$name = __('Import Products', $this -> plugin_name);
				break;
			case 'import_csv'				:
				$name = __('Import Products', $this -> plugin_name);
				break;
			case 'categories'				:
				$name = __('Shop Categories', $this -> plugin_name);
				break;
			case 'categories_save'			:
				$name = __('Save Category', $this -> plugin_name);
				break;
			case 'products'					:
				$name = __('Products', $this -> plugin_name);
				break;
			case 'products_save'			:
				$name = __('Save Product', $this -> plugin_name);
				break;
			case 'content'					:
				$name = __('Additional Content', $this -> plugin_name);
				break;
			case 'content_save'				:
				$name = __('Save Content', $this -> plugin_name);
				break;
			case 'files'					:
				$name = __('Digital Files', $this -> plugin_name);
				break;
			case 'images'					:
				$name = __('Product Images', $this -> plugin_name);
				break;
			case 'suppliers'				:
				$name = __('Suppliers', $this -> plugin_name);
				break;
			case 'styles'					:
				$name = __('Product Variations', $this -> plugin_name);
				break;
			case 'options'					:
				$name = __('Variation Options', $this -> plugin_name);
				break;
			case 'fields'					:
				$name = __('Custom Fields', $this -> plugin_name);
				break;
			case 'coupons'					:
				$name = __('Discount Coupons', $this -> plugin_name);
				break;
			case 'orders'					:
				$name = __('Orders', $this -> plugin_name);
				break;
			case 'items'					:
				$name = __('Order Items', $this -> plugin_name);
				break;
			case 'shipmethods'				:
				$name = __('Shipping Methods', $this -> plugin_name);
				break;
			case 'settings'					:
				$name = __('Configuration', $this -> plugin_name);
				break;
			case 'settings_general'			:
				$name = __('Configuration >', $this -> plugin_name) . ' ' . __('General', $this -> plugin_name);
				break;
			case 'settings_invoice'			:
				$name = __('Configuration >', $this -> plugin_name) . ' ' . __('Invoices', $this -> plugin_name);
				break;
			case 'settings_pmethods'		:
				$name = __('Configuration >', $this -> plugin_name) . ' ' . __('Payment Methods', $this -> plugin_name);
				break;
			case 'settings_products'		:
				$name = __('Configuration >', $this -> plugin_name) . ' ' . __('Products &amp; Images', $this -> plugin_name);
				break;
			case 'settings_taxshipping'		:
				$name = __('Configuration >', $this -> plugin_name) . ' ' . __('Calculations ', $this -> plugin_name);
				break;
			case 'settings_paymentfields'	:
				$name = __('Configuration >', $this -> plugin_name) . ' ' . __('Payment Fields', $this -> plugin_name);
				break;
			case 'settings_updates'			:
				$name = __('Updates', $this -> plugin_name);
				break;
			case 'settings_affiliates'		:
				$name = __('Configuration >', $this -> plugin_name) . ' ' . __('Affliliates & Tracking', $this -> plugin_name);
				break;
			case 'extensions'				:
				$name = __('Extensions', $this -> plugin_name);
				break;
			case 'extensions_settings'		:
				$name = __('Extensions Settings', $this -> plugin_name);
				break;
			case 'support'					:
				$name = __('Support &amp; Help', $this -> plugin_name);
				break;
		}
		
		return $name;
	}
	
	function next_scheduled($hook = null) {
		if (!empty($hook) && $schedules = wp_get_schedules()) {		
			if ($hookinterval = wp_get_schedule($this -> pre . '_' . $hook)) {
				if ($hookschedule = wp_next_scheduled($this -> pre . '_' . $hook)) {				
					return $schedules[$hookinterval]['display'] . ' - <strong>' . date("Y-m-d H:i:s", $hookschedule) . '</strong>';
				} else {
					//return __('This task does not have a next schedule.', $this -> plugin_name);	
				}
			} else {
				return __('No schedule has been set for this task.', $this -> plugin_name);	
			}
		} else {
			return __('No cron schedules are available or no task was specified.', $this -> plugin_name);	
		}
		
		return false;
	}
	
	function shiptrack($order = null) {
		if (!empty($order)) {
			
		}
	}
	
	function invoice_subtotal($order_id = null) {
		global $Order, $subtotaldone;
		
		$st = $Order -> total($order_id, false, false, true, true, false, false);
		$globalf = $Order -> globalf_total($order_id);
		
		if (empty($subtotaldone) || $subtotaldone == false) {
			if (!empty($globalf)) {
				$subtotal = ($st - $globalf);	
			} else {
				$subtotal = $st;	
			}
			
			$subtotal = number_format($subtotal, 2, '.', '');
			
			?>
			
			<tr>
				<td style="text-align:right;"><?php _e('Subtotal', $this -> plugin_name); ?></td>
				<td style="text-align:right; font-weight:bold;"><?php echo $this -> currency_price($subtotal); ?></td>
			</tr>
			
			<?php
			
			if (!empty($globalf)) {
				?>
                
                <tr>
                	<td style="text-align:right;"><?php _e('Order Options', $this -> plugin_name); ?></td>
					<td style="text-align:right; font-weight:bold;"><?php echo $this -> currency_price($globalf); ?></td>
                </tr>
                
                <?php	
			}
		}
		
		$subtotaldone = true;
	}
	
	function subtotal($co_id = null, $order_email = false) {
		global $wpcoHtml, $Order, $subtotal;
		if (!is_array($co_id)) { $co_id = array('type' => "order", 'id' => $co_id); }
		ob_start();
		
		$st = $Order -> total($co_id, false, false, true, true, false, false);
		$globalf = $Order -> globalf_total($co_id);
		
		if (empty($subtotal) || $subtotal == false) {
			if (!empty($globalf)) {
				$subtotal = $st - $globalf;
			} else {
				$subtotal = $st;
			}
		
			?>
			
			<tr class="total">
				<td class="wpco_totaltext" <?php if (!$order_email) : ?> colspan="5"<?php endif; ?>>
					<?php _e('Sub Total', $this -> plugin_name); ?>
                	<?php if ($this -> get_option('tax_calculate') == "Y") : ?>
                    	<span class="taxwrap">(<?php _e('Excl.', $this -> plugin_name); ?> <?php echo $this -> get_option('tax_name'); ?>)</span>
                    <?php endif; ?>
                </td>
				<td><?php echo $wpcoHtml -> currency_price($subtotal); ?></td>
				<td></td>
			</tr>	
			
			<?php
			
			if (!empty($globalf)) {
				?>
				
				<tr class="total">
					<td<?php if (!$order_email) : ?> colspan="2"<?php endif; ?>><?php _e('Order Options', $this -> plugin_name); ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?php echo $wpcoHtml -> currency_price($globalf); ?></td>
					<?php /*<td></td>*/ ?>
				</tr>
				
				<?php
			}
			
			if ($this -> get_option('handling') == "Y") {
				if ($handling = $Order -> handling($co_id)) {
					if (!empty($handling) && $handling > 0) {
						?>
						
						<tr class="total">
							<td class="wpco_totaltext" <?php if (!$order_email) : ?> colspan="5"<?php endif; ?>>
								<?php echo __($this -> get_option('handling_title')); ?>
			                </td>
							<td><?php echo $wpcoHtml -> currency_price($handling); ?></td>
							<td></td>
						</tr>	
						
						<?php
					}
				}
			}
		}
		
		$sthtml = ob_get_clean();
		echo apply_filters($this -> pre . '_cart_subtotal', $sthtml, $co_id);
		$subtotal = true;
	}
	
	function shipping_apis() {        
        $apis = array();
		$apis[0] = __('NO', $this -> plugin_name);
		
		if ($this -> vendor('auspost', "shipping" . DS)) {
			$apis['auspost'] = '<img src="' . $this -> url() . '/images/shipping/auspost_sml.png" alt="Australia Post" /> <span>' . __('Australia Post DRC', $this -> plugin_name) . '</span>';	
		}
		
		if ($this -> vendor('canadapost', "shipping" . DS . "canadapost" . DS)) {
			$apis['canadapost'] = '<img src="' . $this -> url() . '/images/shipping/canadapost_sml.jpg" alt="Canada Post" /> <span>' . __('Canada Post', $this -> plugin_name) . '</span>';	
		}
		
		//if ($this -> is_plugin_active('echo') && $this -> extension_vendor('echo')) {
		//	$apis['echo'] = '<img src="' . $this -> url() . '/images/shipping/echo_sml.jpg" alt="echo" /> <span>' . __('Echo', $this -> plugin_name) . '</span>';
		//}
		
		if ($this -> vendor('fedex', "shipping" . DS . "fedex" . DS)) {
			$apis['fedex'] = '<img src="' . $this -> url() . '/images/shipping/fedex_sml.png" alt="FedEx" /> <span>' . __('FedEx (Federal Express)', $this -> plugin_name) . '</span>';	
		}
		
		if ($this -> vendor('usps', "shipping" . DS . "usps" . DS)) {
			$apis['usps'] = '<img src="' . $this -> url() . '/images/shipping/usps_sml.png" /> <span>' . __('USPS (US Postal Service)', $this -> plugin_name) . '</span>';	
		}
		
		if ($this -> vendor('ups', 'shipping' . DS . 'ups' . DS)) {
			$apis['ups'] = '<img src="' . $this -> url() . '/images/shipping/ups_sml.jpg" /> <span>' . __('UPS', $this -> plugin_name) . '</span>';
		}
		
		return $apis;
	}
	
	function shipapi_image($shipapi = null) {
	
		if (!empty($shipapi)) {
			switch ($shipapi) {
				case 'auspost'			:
					$image = $this -> url() . '/images/shipping/auspost_sml.png';
					break;
				case 'canadapost'		:
					$image = $this -> url() . '/images/shipping/canadapost_sml.jpg';
					break;
				case 'fedex'			:
					$image = $this -> url() . '/images/shipping/fedex_sml.png';
					break;
				case 'usps'				:
					$image = $this -> url() . '/images/shipping/usps_sml.png';
					break;
				case 'ups'				:
					$image = $this -> url() . '/images/shipping/ups_sml.jpg';
					break;
			}
		}
		
		$image = apply_filters($this -> pre . '_shipapi_image', $image, $shipapi);		
		return $image;
	}
	
	function account_url() {
		$account_url = $this -> retainquery($this -> pre . "method=history", $this -> get_option('shopurl'));
		
		if ($this -> get_option('cart_layout') == "theme") {
			if ($this -> get_option('account_page_added') == "Y") {
				if ($accountpage_id = $this -> get_option('accountpage_id')) {
					if ($permalink = get_permalink($accountpage_id)) {
						$account_url = $permalink;	
					}
				}
			}
		}
		
		return $account_url;
	}
	
	function downloads_url() {
		$downloads_url = $this -> retainquery($this -> pre . "method=downloads", $this -> get_option('shopurl'));
		
		if ($account_url = $this -> account_url()) {
			$downloads_url = $this -> retainquery($this -> pre . "method=downloads", $account_url);	
		}
	
		return $downloads_url;	
	}
	
	function favorites_url() {
		$favorites_url = "#";
		
		if ($account_url = $this -> account_url()) {
			$favorites_url = $this -> retainquery($this -> pre . "method=favorites", $account_url);
		}
		
		return $favorites_url;
	}
	
	function order_url($order_id = null) {
		$order_url = $this -> retainquery($this -> pre . "method=order&id=" . $order_id, $this -> get_option('shopurl'));
		
		if ($account_url = $this -> account_url()) {
			$order_url = $this -> retainquery($this -> pre . "method=order&id=" . $order_id, $account_url);	
		}
		
		return $order_url;
	}
	
	function cart_url() {	
		global $wpdb;
		$url = $this -> retainquery($this -> pre . 'method=cart', $this -> get_option('shopurl'));
	
		if ($this -> get_option('cart_layout') == "theme") {		
			if ($this -> get_option('cart_page_added') == "Y") {				
				if ($cartpage_id = $this -> get_option('cartpage_id')) {				
					$query = "SELECT `ID` FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $cartpage_id . "'";
				
					if ($page = $wpdb -> get_row($query)) {
						if ($permalink = get_permalink($page -> ID)) {
							$url = $permalink;
						}
					}
				}
			}
		}
		
		return apply_filters($this -> pre . '_cart_url', $url);
	}
	
	function contacts_url($fromcart = true) {
		$method = "contacts";
		if (!empty($fromcart) && $fromcart == true) { $method .= "&amp;fromcart=1"; }
		
		if ($this -> get_option('cart_layout') == "theme") {
			return $this -> retainquery($this -> pre . 'method=' . $method, $this -> cart_url());
		} else {
			return $this -> retainquery($this -> pre . 'method=' . $method, $this -> get_option('shopurl'));
		}
	}
	
	function ship_url() {
		if ($this -> get_option('cart_layout') == "theme") {
			return $this -> retainquery($this -> pre . 'method=shipping', $this -> cart_url());
		} else {
			return $this -> retainquery($this -> pre . 'method=shipping', $this -> get_option('shopurl'));
		}
	}
	
	function canadapost_url() {
		if ($this -> get_option('cart_layout') == "theme") {
			return $this -> retainquery($this -> pre . 'method=canadapost', $this -> cart_url());
		} else {
			return $this -> retainquery($this -> pre . 'method=canadapost', $this -> get_option('shopurl'));
		}
	}
	
	function fedex_url() {
		if ($this -> get_option('cart_layout') == "theme") {
			return $this -> retainquery($this -> pre . 'method=fedex', $this -> cart_url());
		} else {
			return $this -> retainquery($this -> pre . 'method=fedex', $this -> get_option('shopurl'));
		}
	}
	
	function usps_url() {
		if ($this -> get_option('cart_layout') == "theme") {
			return $this -> retainquery('api=usps', $this -> ship_url());
		} else {
			return $this -> retainquery($this -> pre . 'method=shipping&api=usps', $this -> get_option('shopurl'));
		}
	}
	
	function ups_url() {
		return $this -> retainquery('api=ups', $this -> ship_url());	
	}
	
	function auspost_url() {
		return $this -> retainquery('api=auspost', $this -> ship_url());
	}
	
	function bill_url() {
		if ($this -> get_option('cart_layout') == "theme") {
			return $this -> retainquery($this -> pre . 'method=billing', $this -> cart_url());
		} else {
			return $this -> retainquery($this -> pre . 'method=billing', $this -> get_option('shopurl'));
		}
	}
	
	function fail_url() {
		if ($this -> get_option('cart_layout') == "theme") {
			return $this -> retainquery($this -> pre . 'method=cofailed', $this -> cart_url());
		} else {
			return $this -> retainquery($this -> pre . 'method=cofailed', $this -> get_option('shopurl'));
		}
	}
	
	function success_url($order_id = null) {
		if ($this -> get_option('cart_layout') == "theme") {
			$pre = $this -> pre . 'method=cosuccess';
			if (!empty($order_id)) { $pre .= '&order_id=' . $order_id; }
			return $this -> retainquery($pre, $this -> cart_url());
		} else {
			return $this -> retainquery($this -> pre . 'method=cosuccess', $this -> get_option('shopurl'));
		}
	}
	
	function return_url() {
		if ($this -> get_option('cart_layout') == "theme") {
			return $this -> retainquery($this -> pre . 'method=coreturn', $this -> cart_url());
		} else {
			return $this -> retainquery($this -> pre . 'method=coreturn', $this -> get_option('shopurl'));
		}
	}
	
	function caption($main = 'product', $cap = null) {
		if (!empty($main) && !empty($cap)) {
			$wpcocaptions = $this -> get_option('captions');
			
			if (!empty($wpcocaptions[$main][$cap])) {
				return $wpcocaptions[$main][$cap];
			}
		}
		
		return $main . $cap;
	}
	
	function cardnumber($number = null) {
		if (!empty($number)) {
			$f = substr($number, 0, -4) . '****';
			$l = '************' . substr($number, -4);
			
			return array($number, $f, $l);
		}
		
		return false;
	}
	
	function queryString($params, $name = null) {
		$ret = "";
		foreach ($params as $key => $val) {
			if (is_array($val)) {
				if ($name == null) {
					$ret .= queryString($val, $key);
				} else {
					$ret .= queryString($val, $name . "[$key]");   
				}
			} else {
				if ($name != null) {
					$ret .= $name . "[$key]" . "=" . $val . "&";
				} else {
					$ret .= $key . "=" . $val . "&";
				}
			}
		}
		
		return rtrim($ret, "&");   
	} 
	
	function retainquery($add = null, $old_url = null, $endslash = true) {
		$url = (empty($old_url)) ? $_SERVER['REQUEST_URI'] : rtrim($old_url, '&');
		$urls = @explode("?", $url);
		$add = ltrim($add, '&');
		
		$url_parts = @parse_url($url);
		if (!empty($url_parts['query'])) { parse_str($url_parts['query'], $path_parts); }
		$add = str_replace("&amp;", "&", $add);
		parse_str($add, $add_parts);
		
		if (empty($path_parts) || !is_array($path_parts)) {
			$path_parts = array();	
		}
			
		if (!empty($add_parts) && is_array($add_parts)) {
			foreach ($add_parts as $addkey => $addvalue) {
				$path_parts[$addkey] = stripslashes($addvalue);
			}
		}

		$querystring = $this -> queryString($path_parts);
		
		if (!empty($urls[1])) {		
			$urls[1] = preg_replace("/\&?" . $this -> pre . "message\=([0-9a-z-_+]*)/i", "", $urls[1]);
			$urls[1] = preg_replace("/[\&|\?]page\=/si", "", $urls[1]);
		}
		
		$url = $urls[0];
		$url .= '?';
		
		if (!empty($querystring)) {
			$url .= '&' . $querystring;
		}
				
		return preg_replace("/\?(\&)?/si", "?", $url);
	}
	
	function addtocart_action($product_id = null, $loopwithstyles = false, $showerrors = true) {
		global $errors, $wpcoDb, $Product, $displaygrid;
		$wpcoDb -> model = $Product -> model;
	
		if ($product = $wpcoDb -> find(array('id' => $product_id))) {
			$action = "";
		
			if (!empty($product -> affiliate) && $product -> affiliate == "Y") {			
				$action = '<form id="addtocart' . $product_id . '" action="' . $this -> retainquery($this -> pre . 'method=affiliate&amp;id=' . $product -> id) . '" class="' . $this -> pre . ' affiliateform" method="post" target="_' . $product -> affiliatewindow . '">';
			} else {			
				$action = '<form id="addtocart' . $product_id . '" action="' . get_permalink($product -> post_id) . '" class="' . $this -> pre . ' productform" method="post">';
				
				if ($this -> get_option('cart_addajax') == "N" || 
					(!empty($product -> buynow) && $product -> buynow == "Y") || 
					($this -> get_option('cart_addajax') && $loopwithstyles == true)) {
					$action .= '<input type="hidden" name="' . $this -> pre . 'method" value="additem" />';
				}
				
				/* Show Fields? */
				if (($this -> get_option('loop_display') == "list" || $displaygrid === false)
					&& $this -> get_option('loop_showfields') == "Y") {
					$loopwithstyles = false;	//allow Ajax submission
				}
				
				if ((($product -> price_type == "donate") || $product -> price_type != "donate") && 
					($this -> get_option('cart_addajax') == "Y" && 
					$this -> get_option('buynow') == "N" && 
					(empty($product -> buynow) || $product -> buynow == "N") && 
					$loopwithstyles == false)) {
				
					if ($number = $this -> widget_active('cart')) {																														
						$action = '<form id="addtocart'  . $product_id . '" action="' . get_permalink($product -> post_id) . '" onsubmit="wpco_addtocart(jQuery(\'#addtocart' . $product_id . '\'),\'' . $product_id . '\',\'' . $number . '\'); return false;" method="post" class="' . $this -> pre . ' ajaxform">';
					}
				} elseif ($this -> get_option('buynow') == "Y" || (!empty($product -> buynow) && $product -> buynow == "Y")) {				
					$action .= '<input type="hidden" name="' . $this -> pre . 'method" value="additem" />';
				}
			}
			
			$action .= '<input type="hidden" id="submitbuttontext' . $product -> id . '" name="submitbuttontext" value="' . esc_attr(stripslashes($product -> buttontext)) . '" />';
			
			$output = "";
			if ($showerrors) { $output .= $this -> render('errors', array('errors' => $errors), false, 'default'); }
			$output .= $action;
			return $output;
		}
		
		return false;
	}
	
	function alert($message = null) {
		if (!empty($message)) {
			?>
			
			<script type="text/javascript">
				alert('<?php echo $message; ?>');
			</script>
			
			<?php
		}
		
		return false;
	}
	
	function image_pathinfo($image = null) {
		if (!empty($image)) {
			$imagename = $image;
			$imagepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS;
			$imagefull = $imagepath . $imagename;
			
			if (file_exists($imagefull)) {
				if ($info = pathinfo($imagefull)) {
					return $info;
				}
			}
		}
	
		return false;
	}
	
	function image_url($image = null, $folder = 'images') {
		if (empty($image)) {	
			$imagename = 'noimage.jpg';
			$imagepath = plugins_url() . '/' . $this -> plugin_name . '/images/';
		} else {
			$imagename = $image;
			$imagepath = content_url() . '/uploads/' . $this -> plugin_name . '/' . $folder . '/';
		}
			
		$imagefull = $imagepath . $imagename;
		return $imagefull;
	}
	
	function timthumb_image($image = null, $width = null, $height = null, $quality = 100, $class = "wpco", $rel = "") {	
		$tt_image = '<img src="' . $this -> timthumb_url() . '?src=' . $image;
		if (!empty($width)) { $tt_image .= '&w=' . $width; };
		if (!empty($height)) { $tt_image .= '&h=' . $height; };
		$tt_image .= '&q=' . $quality . '"';
		if (!empty($class)) { $tt_image .= ' class="' . $class . '"'; };
		if (!empty($rel)) { $tt_image .= ' rel="' . $rel . '"'; }
		$tt_image .= ' />';
		return $tt_image;
	}
	
	function timthumb_image_src($image = null, $width = null, $height = null, $quality = 100) {	
		$tt_image = $this -> timthumb_url() . '?src=' . $image;
		if (!empty($width)) { $tt_image .= '&w=' . $width; };
		if (!empty($height)) { $tt_image .= '&h=' . $height; };
		$tt_image .= '&q=' . $quality;
		return $tt_image;
	}
	
	function timthumb_url() {
		return plugins_url() . '/' . $this -> plugin_name . '/vendors/timthumb.php';
	}
	
	function strip_ext($filename = null, $return = 'ext') {
		if (!empty($filename)) { 
			$extArray = preg_split("/[\.]/", $filename); 
			
			if ($return == 'ext') {
				$p = count($extArray) - 1; 
				$extension = $extArray[$p]; 
				return strtolower($extension);
			} else {
				$p = count($extArray) - 2;
				$filename = $extArray[$p];
				return $filename;
			}
		}
		
		return false;
	}
	
	function thumb_name($image = null, $append = 'thumb') {
		$name = $this -> strip_ext($image, 'filename');
		$ext = $this -> strip_ext($image);		
		$imagename = $name . '-' . $append . '.' . $ext;		
		return $imagename;
	}
	
	function image($image = null, $args = array(), $orig = null) {
		if (!empty($image)) {
			$defaults = array(
				'folder'		=>	'images',
				'class'			=>	$this -> pre,
				'style'			=>	"",
			);
			
			$r = wp_parse_args($args, $defaults);
			extract($r, EXTR_SKIP);
			
			$imagename = $image;
			$imagefull = $this -> image_url($imagename, $folder);
			
			$path = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . $folder . DS . $imagename;

			if (!file_exists($path)) {
				if (!empty($orig) && file_exists(WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . $folder . DS . $orig)) {
					$imagefull = $this -> image_url($orig, $folder);
				} else {
					$imagefull = $this -> get_option('noimageurl');
				}
			}
		
			ob_start();
			
			?><img class="<?php echo $class; ?>" style="<?php echo $style; ?>" src="<?php echo $imagefull; ?>" alt="<?php echo $this -> sanitize($imagename); ?>" /><?php
			
			$image = ob_get_clean();
			return $image;
		}
		
		return false;
	}
	
	function image_data($name = null, $files = array()) {				
		if (!empty($name) && !empty($files)) {
			if ($mn = $this -> strip_mn($name)) {
				if (!empty($files[$mn[1]])) {
					$image = array();
				
					foreach ($files[$mn[1]] as $fkey => $fval) {
						$image[$fkey] = $fval[$mn[2]];
					}
					
					$image = (object) $image;
					return $image;
				}
			}
		}
		
		return false;
	}
	
	function file_custom_field($value = null, $limit = false, $types = false, $onlyurl = false) {	
		$output = false;
		
		if (!empty($value)) {
			$currentfile = '<div class="' . $this -> pre . 'currentfile">';
			$imagetypes = array('jpg','jpeg','gif','png');
			$imagename = $value;
			$imagepath = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'ajaxupload' . DS . $imagename;
			$imageurl = content_url() . '/uploads/' . $this -> plugin_name . '/ajaxupload/' . $imagename;
			$imageinfo = pathinfo($imagepath);
			$ajaxuploadurl = site_url() . '?' . $this -> pre . 'method=ajaxupload&file=' . urlencode($imagename);
			
			if (!empty($onlyurl) && $onlyurl == true) {
				return $imageurl;
			}
			
			if (false && in_array($imageinfo['extension'], $imagetypes)) {
				if (!is_admin()) { $currentfile .= '<strong>' . __('Uploaded image:', $this -> plugin_name) . '</strong><br/>'; }
				$currentfile .= '<a class="colorbox" href="' . $imageurl . '" target="_blank"><img class="' . $this -> pre . '" src="' . $this -> timthumb_image_src($imageurl, 75, 75, 100) . '" /></a>';
			} else {
				$currentfile .= '<a href="' . $ajaxuploadurl . '" target="_blank">' . __('Uploaded file', $this -> plugin_name) . '</a>';
			}
			
			$currentfile .= '</div>';
			$output .= $currentfile;
		}

		return $output;
	}
	
	function truncate($string = null, $length = 125, $append = '...') {
		if (!empty($string)) {
			if (!empty($length)) {
				$newstring = substr(strip_tags($string), 0, $length);
				
				if (strlen($string) > $length) {
					$newstring .= $append;
				}
				
				return $newstring;
			}
			
			return $string;
		}
		
		return false;
	}
	
	function gen_date($wpcoFormat = "Y-m-d H:i:s", $time = false) {
		$time = (empty($time)) ? time() : $time;
		$date = date($wpcoFormat, $time);
		
		return $date;
	}
	
	function array_to_object($array = array()) {
		if (!empty($array)) {
			$object = false;
		
			foreach ($array as $akey => $aval) {
				$object -> {$akey} = $aval;
			}
			
			return $object;
		}
	
		return false;
	}
	
	function field_name($name = null) {
		if (!empty($name)) {
			if ($mn = $this -> strip_mn($name)) {
				return $mn[1] . '[' . $mn[2] . ']';
			}
		}
	
		return $name;
	}
	
	function field_error($name = null, $el = "p") {
		if (!empty($name)) {
			if ($mn = $this -> strip_mn($name)) {
				global ${$mn[1]};
				
				if (!empty(${$mn[1]} -> errors[$mn[2]])) {
					$error = '<' . $el . ' class="' . $this -> pre . 'error">' . ${$mn[1]} -> errors[$mn[2]] . '</' . $el . '>';
					
					return $error;
				}
			}
		}
		
		return false;
	}
	
	function field_value($name = null) {
		if ($mn = $this -> strip_mn($name)) {
			global ${$mn[1]};
			$value = ${$mn[1]} -> data -> {$mn[2]};
			
			return stripslashes_deep($value);
		}
		
		return false;
	}
	
	function styletype($type = null) {
		switch ($type) {
			case 'select'		:
				$styletype = __('Select Drop Down', $this -> plugin_name);
				break;
			case 'radio'		:
				$styletype = __('Radio Buttons', $this -> plugin_name);
				break;
			case 'checkbox'		:
				$styletype = __('Checkbox List', $this -> plugin_name);
				break;
			default				:
				$styletype = __('none', $this -> plugin_name);
				break;
		}
		
		return $styletype;
	}
	
	function weight_name($weight = null) {
		switch ($weight) {
			case 'lb'			:
				$name = __('Pound', $this -> plugin_name);
				break;
			case 'oz'			:
				$name = __('Ounce', $this -> plugin_name);
				break;
			case 'kg'			:
				$name = __('Kilogram', $this -> plugin_name);
				break;
			case 'g'			:
				$name = __('Gram', $this -> plugin_name);
				break;
			default				:
				$name = __('Kilogram', $this -> plugin_name);
				break;
		}
		
		return $name;
	}
	
	function shipmethod_name($shipmethod_id = null, $order_id = null) {
		global $wpdb, $wpcoDb, $wpcoShipmethod, $Order;
		$shipmethod_name = "";
		
		if (!empty($shipmethod_id)) {			
			$shipmethodquery = "SELECT `name` FROM " . $wpdb -> prefix . $wpcoShipmethod -> table . " WHERE id = '" . $shipmethod_id . "'";
			if ($shipmethod = $wpdb -> get_row($shipmethodquery)) {
				$shipmethod_name = $shipmethod -> name;
				
				if (!empty($order_id)) {
					$orderquery = "SELECT `cu_shipmethod` FROM " . $wpdb -> prefix . $Order -> table . " WHERE id = '" . $order_id . "'";
					if ($order = $wpdb -> get_row($orderquery)) {
						if (!empty($order -> cu_shipmethod)) {
							$shipmethod_name .= ' - ' . $order -> cu_shipmethod;
						}
					}
				}
			}
		}
		
		return $shipmethod_name;
	}
	
	function pmethod($pmethod = null, $return = true) {			
		if (!empty($pmethod)) {
			switch ($pmethod) {
				case 'amazonfps'	:
					if ($this -> is_plugin_active('amazonfps')) {
						$amazonfps = $this -> extension_vendor('amazonfps');
						$method = $amazonfps -> title();
					}
					break;
				case 'pp'			:
					$method = __('PayPal', $this -> plugin_name);
					break;
				case 'pp_pro'			:
					$pp_pro_title = $this -> get_option('pp_pro_title');
					$method = (empty($pp_pro_title)) ? __('PayPal (Pro)', $this -> plugin_name) : $pp_pro_title;				
					break;
				case 'mb'			:
					$mb_title = $this -> get_option('mb_title');
					$method = (empty($mb_title)) ? __('Debit- and Credit Card payment with Skrill (Moneybookers)', $this -> plugin_name) : $mb_title;
					break;
				case 'monsterpay'	:
					$monsterpay_title = $this -> get_option('monsterpay_title');
					$method = (empty($monsterpay_title)) ? __('Credit card payments with MonsterPay', $this -> plugin_name) : $monsterpay_title;
					break;
				case 'netcash'		:
					$netcash = $this -> extension_vendor('netcash');
					$method = $netcash -> title();
					break;
				case 'fdapi'		:
					if ($this -> is_plugin_active('fdapi')) {
						$fdapi = $this -> extension_vendor('fdapi');
						$method = $fdapi -> title();
					}
					break;
				case 'apco'			:
					if ($this -> is_plugin_active('apco')) {
						$apco = $this -> extension_vendor('apco');
						$method = $apco -> title();
					}
					break;
				case 'ipay'			:
					if ($this -> is_plugin_active('ipay')) {
						$ipay = $this -> extension_vendor('ipay');
						$method = $ipay -> title();
					}
					break;
				case 'sagepay'		:
					$sagepay = $this -> extension_vendor('sagepay');
					$method = $sagepay -> title();
					break;
				case 'securetrading'	:
					if ($this -> is_plugin_active('securetrading')) {
						$securetrading = $this -> extension_vendor('securetrading');
						$method = $securetrading -> title();
					}
					break;
				case 'tc'			:
					$cu_title = $this -> get_option('tc_title');
					$method = (empty($cu_title)) ? __('2CheckOut', $this -> plugin_name) : $cu_title;
					break;
				case 'cc'			:
					$method = __('Credit Card (Manual POS)', $this -> plugin_name);
					break;
				case 'cu'			:
					$cu_title = $this -> get_option('cu_title');
					$method = (empty($cu_title)) ? __('Manual Payment', $this -> plugin_name) : $cu_title;
					break;
				case 'bartercard'	:
					$method = __('BarterCard InternetPOS', $this -> plugin_name);
					break;
				case 'bluepay'		:
					$bluepay_title = $this -> get_option('bluepay_title');
					$method = (empty($cu_title)) ? __('Credit and debit card payments with BluePay', $this -> plugin_name) : $cu_title;
					break;
				case 'bw'			:
					$method = __('Bank Wire', $this -> plugin_name);
					break;
				case 'google_checkout'			:
					$method = __('Google Checkout', $this -> plugin_name);
					break;
				case 'fd'			:
					$fd_title = $this -> get_option('fd_title');
					$method = (empty($fd_title)) ? __('FirstData', $this -> plugin_name) : $fd_title;
					break;
				case 're'			:
					$re_title = $this -> get_option('re_title');
					$method = (empty($re_title)) ? __('Realex Payments', $this -> plugin_name) : $re_title;
					break;
				case 're_remote'	:
					$re_remote = maybe_unserialize($this -> get_option('re_remote'));
					$re_remote_title = $re_remote['title'];
					$method = (empty($re_remote_title)) ? __('Credit card payments through Realex Payments', $this -> plugin_name) : $re_remote_title;
					break;
				case 'ematters'		:
					$ematters_title = $this -> get_option('ematters_title');
					$method = (empty($ematters_title)) ? __('eMatters', $this -> plugin_name) : $ematters_title;
					break;
				case 'authorize_aim' :
					$authorize_aim_title = $this -> get_option('authorize_aim_title');
					$method = (empty($authorize_aim_title)) ? __('Authorize.net', $this -> plugin_name) : $authorize_aim_title;
					break;
				case 'eupayment'	:
					$eupayment_title = $this -> get_option('eupayment_name');
					$method = (empty($eupayment_title)) ? __('Euro Payment Services SRL', $this -> plugin_name) : $eupayment_title;
					break;
				case 'ogone_basic'	:
					$ogone_basic_title = $this -> get_option('ogone_basic_caption');
					$method = (empty($ogone_basic_title)) ? __('Credit card payment with Ogone', $this -> plugin_name) : $ogone_basic_title;
					break;
				case 'eway_shared'	:
					$eway_shared_title = $this -> get_option('eway_shared_title');
					$method = (empty($eway_shared_title)) ? __('eWay AU (Shared)', $this -> plugin_name) : $eway_shared_title;
					break;
				case 'virtualmerchant'	:
					$virtualmerchant_title = $this -> get_option('virtualmerchant_title');
					$method = (empty($virtualmerchant_title)) ? __('Virtual Merchant', $this -> plugin_name) : $virtualmerchant_title;
					break;
				case 'worldpay'			:
					$worldpay_title = $this -> get_option('worldpay_title');
					$method = (empty($worldpay_title)) ? __('Credit card payments via WorldPay', $this -> plugin_name) : $worldpay_title;
					break;
				case 'payxml'			:
					$payxml = maybe_unserialize($this -> get_option('payxml'));
					$payxml_title = $payxml['title'];
					$method = (empty($payxml_title)) ? __('PayGate (XML)', $this -> plugin_name) : $payxml_title;
					break;
				case 'lucy'				:
					$lucy = maybe_unserialize($this -> get_option('lucy'));
					$lucy_title = $lucy['title'];
					$method = (empty($lucy['title'])) ? __('Credit card payments with LUCY Gateway', $this -> plugin_name) : $lucy_title;
					break;
				case 'stripe'			:
					if ($this -> is_plugin_active('stripe')) {
						$stripe = $this -> extension_vendor('stripe');
						$method = $stripe -> title();
					}
					break;
				default					:
					$method = $pmethod;
					break;
			}
		}
		
		$method = apply_filters($this -> pre . '_pmethod_title', $method, $pmethod);
		return $method;
	}
	
	function surcharge_text($pmethod = 'pp') {
		$surcharge_text = "";
		
		if (!empty($pmethod)) {
			switch ($pmethod) {
				case 'pp'				:
					if ($this -> get_option('pp_surcharge') == "Y") {
						$surcharge_amount = $this -> get_option('pp_surcharge_amount');
						$surcharge_percentage = $this -> get_option('pp_surcharge_percentage');
						
						if (!empty($surcharge_amount) && $surcharge_amount != "0.00") {
							$surcharge_text = $this -> currency_price($surcharge_amount);
						}
						
						if (!empty($surcharge_percentage) && $surcharge_percentage != "0.00") {
							$surcharge_text .= (!empty($surcharge_amount)) ? ' ' . __('+', $this -> plugin_name) . ' ' : '';
							$surcharge_text .= $surcharge_percentage . '&#37'; 
						}
					}
					break;
			}
		}
		
		return $surcharge_text;
	}
	
	function currency() {
		$currencies = $this -> get_option('currencies');
		$symbol = $currencies[$this -> get_option('currency')]['symbol'];
		
		return $symbol;
	}
	
	function currency_price($price = null, $span = true, $fordisplay = false, $operator = 'curr') {
		$currency_symbol = $this -> currency();
		$currency_price = "";
		$decimal_separator = $this -> get_option('currency_decimalseparator'); 
		$currency_position = $this -> get_option('currency_position');
	
		if (empty($operator) || $operator == "curr") {
			if ($fordisplay == false) {		
				$decimal_separator = ".";
					
				if ($this -> get_option('currency_position') == "after") {
					$currency_price .= ($span == true) ? '<span class="priceinside pricecurrency">' : '';
					$currency_price .= number_format($price, 2, $decimal_separator, '');
					$currency_price .= ($span == true) ? '</span>' : '';
					$currency_price .= '' . $currency_symbol;
				} else {
					$currency_price .= $currency_symbol . '';
					$currency_price .= ($span == true) ? '<span class="priceinside pricecurrency">' : '';
					$currency_price .= number_format($price, 2, $decimal_separator, '');
					$currency_price .= ($span == true) ? '</span>' : '';
				}
			} else {				
				//$currency_price .= $currency_symbol . '';
				if ($currency_position == "before") { $currency_price .= $currency_symbol; }
				$currency_price .= ($span == true) ? '<span class="priceinside pricecurrency">' : '';
				$currency_price .= $this -> number_format_price($price, false);
				$currency_price .= ($span == true) ? '</span>' : '';
				if ($currency_position == "after") { $currency_price .= $currency_symbol; }	
			}
		} else {
			$currency_price = '<span class="priceinside pricepercentage">' . $this -> number_format_price($price) . '&#37;</span>';
		}
		
		return $currency_price;
	}
	
	function number_format_price($price = null, $dot = true, $places = 2) {		
		$decimal_separator = ($this -> get_option('currency_decimalseparator')) ? $this -> get_option('currency_decimalseparator') : '.';	
		if ($dot) { $decimal_separator = "."; }
		return number_format($price, $places, $decimal_separator, '');
	}
	
	function currency_html($html = null) {
		$currency_symbol = $this -> currency();
	
		if ($this -> get_option('currency_position') == "after") {
			$currency_html = $html . ' ' . $currency_symbol;
		} else {
			$currency_html = $currency_symbol . ' ' . $html;
		}
		
		return $currency_html;
	}
	
	function eu_hmac($key, $data) {
	   $blocksize = 64;
	   $hashfunc  = 'md5';
	   
	   if(strlen($key) > $blocksize) {
	     $key = pack('H*', $hashfunc($key));
	   }
	   
	   $key  = str_pad($key, $blocksize, chr(0x00));
	   $ipad = str_repeat(chr(0x36), $blocksize);
	   $opad = str_repeat(chr(0x5c), $blocksize);
	   
	   $hmac = pack('H*', $hashfunc(($key ^ $opad) . pack('H*', $hashfunc(($key ^ $ipad) . $data))));
	   return bin2hex($hmac);
	}
	
	function eu_mac($data, $key)	{
		$str = NULL;
		
		foreach($data as $d) {
			if($d === NULL || strlen($d) == 0)
			$str .= '-'; // valorile nule sunt inlocuite cu -
			else
			$str .= strlen($d) . $d;
		}
		
		$key = pack('H*', $key); // convertim codul secret intr-un string binar		
		return $this -> eu_hmac($key, $str);
	}
	
	function category_url($category_id = '') {
		$category_url = false;
	
		if (!empty($category_id)) {
			global $wpdb, $wpcoDb, $Category;
			$wpcoDb -> model = $Category -> model;
			
			if ($category = $wpcoDb -> find(array('id' => $category_id))) {
				$query = "SELECT `ID` FROM `" . $wpdb -> posts . "` WHERE `ID` = '" . $category -> post_id . "'";
			
				if (!empty($category -> post_id) && $wpdb -> get_var($query)) {
					$category_url = get_permalink($category -> post_id);
				} else {
					$category_url = site_url() . '/?' . $this -> pre . 'method=category&amp;id=' . $category -> id;
				}
			}
		}
		
		return $category_url;
	}
	
	function categories_url() {
		return site_url() . '/wp-admin/admin.php?page=checkout-categories';
	}
	
	function category_save_url($category_id = null) {
		return $this -> retainquery('method=save&amp;id=' . $category_id, $this -> categories_url());
	}
	
	function category_delete_url($category_id = null) {
		return $this -> retainquery('method=delete&amp;id=' . $category_id, $this -> categories_url());
	}
	
	function products_url() {
		return site_url() . '/wp-admin/admin.php?page=checkout-products';
	}
	
	function product_save_url($product_id = '') {
		return site_url() . '/wp-admin/admin.php?page=checkout-products-save&amp;id=' . $product_id;
	}
	
	function product_delete_url($product_id = '') {
		return $this -> retainquery('method=delete&amp;id=' . $product_id, $this -> products_url());
	}
	
	function strip_mn($name = null) {
		if (!empty($name)) {
			if (preg_match("/^(.*?)\.(.*?)$/i", $name, $matches)) {
				return $matches;
			}
		}
	
		return false;
	}
	
	function sanitize($string = null, $sep = '-') {
		if (!empty($string)) {
			if ($sep == "-") {
				return sanitize_title($string);
			}
		
			$string = preg_replace("/[^0-9a-z" . $sep . "]/si", "", strtolower(str_replace(" ", $sep, $string)));
			$string = preg_replace("/" . $sep . "[" . $sep . "]*/i", $sep, $string);
			
			return $string;
		}
	
		return false;
	}
	
	function randomstring() {
		return substr(md5(uniqid(microtime())), 0, 6);	
	}
}

?>