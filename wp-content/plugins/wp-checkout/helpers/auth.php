<?php

class wpcoAuthHelper extends wpCheckoutPlugin {

	var $name = 'Auth';
	var $cookie = '';

	function wpcoAuthHelper() {
		return true;
	}
	
	function check_user() {		
		$this -> cookie = $_COOKIE[$this -> pre . 'auth'];				
		if (empty($this -> cookie)) {
			$this -> set_cookie();
		}
		
		return $this -> cookie;
	}
	
	function gen_value() {
		$value = uniqid($this -> pre, true);
		return $value;
	}
	
	function gen_time() {
		$cookieduration = $this -> get_option('cookieduration');
		return strtotime("+" . $cookieduration . " days");
	}
	
	function delete_cookie() {
		global $wpcoHtml;
		$expires = $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("-14 days")) . " UTC";
	
		if (headers_sent()) {
			?>
			
			<script type="text/javascript">
			document.cookie = "<?php echo $this -> pre; ?>auth=<?php echo $value; ?>; expires=<?php echo $expires; ?>; path=/";
			</script>
			
			<?php
		} else {
			setcookie($this -> pre . 'auth', $value, strtotime("-14 days"), '/');	
		}
		
		return true;
	}
	
	function set_cookie() {
		global $wpcoHtml;
		$value = $this -> cookie = $this -> gen_value();
		$time = $this -> gen_time();
		
		$expires = $wpcoHtml -> gen_date($this -> get_option('cookieformat'), $time);
		
		if (!is_feed()) {
			if (headers_sent()) {
				?>
				
				<script type="text/javascript">
				document.cookie = "<?php echo $this -> pre; ?>auth=<?php echo $value; ?>; expires=<?php echo $expires; ?>; path=/";
				</script>
				
				<?php
			} else {
				setcookie($this -> pre . 'auth', $value, $time, '/');	
			}
		}
		
		return false;
	}
}

?>