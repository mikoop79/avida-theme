<?php

class wpcoupdate extends wpCheckoutPlugin {

	function get_changelog() {	
		$options = array('method' => 'POST', 'timeout' => 20);
        $options['headers'] = array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=' . get_option('blog_charset'),
            'User-Agent' => 'WordPress/' . get_bloginfo("version"),
            'Referer' => get_bloginfo("home")
        );
        
		$request_url = CHECKOUT_MANAGER_URL . 'changelog/10/' . $this -> get_remote_request_params();		
		$raw_response = wp_remote_request($request_url, $options);
		
		if (is_wp_error($raw_response) || 200 != $raw_response['response']['code']) {
            $text = __('Something went wrong!', $this -> plugin_name); 
            $text .= __('Please try again or <a href="http://tribulant.com/support/" target="_blank">contact us</a>.', $this -> plugin_name);
            return $text;
        } else {
            $changelog = $raw_response['body'];
            return stripslashes($changelog);
        }
    }

	function get_version_info($cache = true) {	
		$raw_response = get_transient($this -> pre . 'update_info');
		if (!$cache) { $raw_response = false; }
	
		if (!$raw_response) {		
			$options = array('method' => 'POST', 'timeout' => 20);
	        $options['headers'] = array(
	            'Content-Type' => 'application/x-www-form-urlencoded; charset=' . get_option('blog_charset'),
	            'User-Agent' => 'WordPress/' . get_bloginfo("version"),
	            'Referer' => get_bloginfo("home")
	        );
	        
			$request_url = CHECKOUT_MANAGER_URL . 'updates/10/' . $this -> get_remote_request_params();
			$raw_response = wp_remote_request($request_url, $options);
			
			set_transient($this -> pre . 'update_info', $raw_response, 86400);
		}
		
		if (is_wp_error($raw_response) || 200 != $raw_response['response']['code']) {
            return array("is_valid_key" => "1", "version" => "", "url" => "");
        } else {
        	$array = explode("||", $raw_response['body']);
        	$info = array("is_valid_key" => $array[0], "version" => $array[1], "url" => $array[2]);
			
			if(count($array) == 4) {
				$info["expiration_time"] = $array[3];
			}

            return $info;
        }
	}
	
	function get_remote_request_params(){
        global $wpdb;
        return sprintf("p:%s/key:%s/v:%s/wp:%s/php:%s/mysql:%s", urlencode('1'), urlencode($this -> get_option('serialkey')), urlencode($this -> version), urlencode(get_bloginfo("version")), urlencode(phpversion()), urlencode($wpdb -> db_version()));
    }
}

?>