<?php

/*
Version: 1.6.8
*/

class wpCheckoutCheckinit {

	function wpCheckoutCheckinit() {
		return true;	
	}
	
	function ci_initialize() {
		if ($this -> ci_serial_valid() || !is_admin()) {
			$this -> ci_initialization();
		} else {
			wp_enqueue_script($this -> plugin_name, WP_PLUGIN_URL . '/' . $this -> plugin_name . '/js/' . $this -> plugin_name . '.js', array('jquery'), '1.0', true);	
			wp_enqueue_script('colorbox', WP_PLUGIN_URL . '/' . $this -> plugin_name . '/js/colorbox.js', array('jquery'), false, true);
			wp_enqueue_style('colorbox', WP_PLUGIN_URL . '/' . $this -> plugin_name . '/css/colorbox.css', false, $this -> version, "all");
			
			$this -> add_action('admin_notices');
			$this -> add_action('init', 'init_getpost', 10, 1);
		}
		
		return false;
	}
	
	function ci_initialization() {
		$this -> updating_plugin();
		
		global $shortcode_tags;
		if (!isset($shortcode_tags['raw'])) {
			add_shortcode('raw', array($wpcoShortcode, 'raw'));
		}
		
		if (is_admin()) {
			$this -> add_action('wp_dashboard_setup');
			$this -> add_action('admin_notices');
			$this -> add_action('delete_user', 'delete_user', 10, 1);
			$this -> add_action('after_plugin_row_' . $this -> plugin_file, 'after_plugin_row', 10, 2);
			$this -> add_action('install_plugins_pre_plugin-information', 'display_changelog', 10, 1);
			$this -> add_action('admin_menu', 'add_menus');
			$this -> add_action('admin_head');
			if ($this -> get_option('tinymcebutton') == "Y") { $this -> add_action('admin_init', 'tinymce'); }
			$this -> add_filter('plugin_action_links', 'plugin_action_links', 10, 4);
			$this -> add_filter('transient_update_plugins', 'check_update', 10, 1);
	        $this -> add_filter('site_transient_update_plugins', 'check_update', 10, 1);
		}
						
		//WordPress action hooks
		$this -> add_action('wp_head');
		$this -> add_action('wp_footer', 'wp_foot', 15, 1);
		$this -> add_action('widgets_init', 'widget_register', 10, 1);
		$this -> add_action('the_content', 'filter_content', 10, 1);
		$this -> add_action('search_template', 'search_template', 10, 1);
		$this -> add_action('delete_post', 'delete_post', 10, 1);
		$this -> add_action('init', 'init', 10, 1);
		$this -> add_action('init', 'init_posttypes', 10, 1);
		$this -> add_action('init', 'init_getpost', 1, 1);
		$this -> add_action('init', 'init_textdomain', 1, 1);
		$this -> add_action('init', 'gzip_compression', 10, 1);
		$this -> add_action('plugins_loaded', 'qtranslate_remove', 10, 1);
		$this -> add_action('show_user_profile');
		$this -> add_action('edit_user_profile');
		$this -> add_action('edit_user_profile_update', 'personal_options_update', 1, 1);
		$this -> add_action('personal_options_update', 'personal_options_update', 1, 1);
		$this -> add_action('profile_update', 'profile_update', 1, 1);
		$this -> add_action('phpmailer_init');
		$this -> add_action($this -> pre . '_orderscleanout', 'orderscleanout', 10, 1);
		$this -> add_action('wp_print_styles', 'print_styles');
		$this -> add_action('admin_print_styles', 'print_styles');
		$this -> add_action('wp_print_scripts', 'print_scripts');
		$this -> add_action('admin_print_scripts', 'print_scripts');
		
		global $wpcoShortcode;
		add_shortcode($this -> pre . 'account', array($wpcoShortcode, 'account'));
		add_shortcode($this -> pre . 'search', array($wpcoShortcode, 'search'));
		add_shortcode($this -> pre . 'cart', array($wpcoShortcode, 'cart'));
		add_shortcode($this -> pre . 'cartsummary', array($wpcoShortcode, 'cartsummary'));
		add_shortcode($this -> pre . 'categories', array($wpcoShortcode, 'categories'));
		add_shortcode($this -> pre . 'category', array($wpcoShortcode, 'category'));
		add_shortcode($this -> pre . 'products', array($wpcoShortcode, 'products'));
		add_shortcode($this -> pre . 'featuredproducts', array($wpcoShortcode, 'featuredproducts'));
		add_shortcode($this -> pre . 'product', array($wpcoShortcode, 'product'));
		add_shortcode($this -> pre . 'suppliers', array($wpcoShortcode, 'suppliers'));
		add_shortcode($this -> pre . 'supplier', array($wpcoShortcode, 'supplier'));
	}
	
	function ci_get_serial() {
		if ($serial = $this -> get_option('serialkey')) {
			return $serial;
		}
		
		return false;
	}
	
	function ci_serial_valid() {
		$host = $_SERVER['HTTP_HOST'];
		
		if (preg_match("/^(www\.)(.*)/si", $host, $matches)) {
			$wwwhost = $host;
			$nonwwwhost = preg_replace("/^(www\.)?/si", "", $wwwhost);
		} else {
			$nonwwwhost = $host;
			$wwwhost = "www." . $host;	
		}
		
		if ($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "localhost:" . $_SERVER['SERVER_PORT']) {
			return true;	
		} else {
			if ($serial = $this -> ci_get_serial()) {			
				if ($serial == strtoupper(md5($_SERVER['HTTP_HOST'] . "wpco" . "mymasesoetkoekiesisfokkenlekker"))) {
					return true;
				} elseif (strtoupper(md5($wwwhost . "wpco" . "mymasesoetkoekiesisfokkenlekker")) == $serial || 
							strtoupper(md5($nonwwwhost . "wpco" . "mymasesoetkoekiesisfokkenlekker")) == $serial) {
					return true;
				}
			}
		}
		
		return false;
	}
}

?>