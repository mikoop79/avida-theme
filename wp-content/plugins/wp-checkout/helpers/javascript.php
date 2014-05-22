<?php

class wpcoJavascriptHelper extends wpCheckoutPlugin {

	var $name = 'Javascript';
	
	function wpcoJavascriptHelper() {
		return true;
	}
	
	function location($url = null) {
		if (!empty($url)) {
			$command = "window.location = '" . $url . "';";
			return $command;
		}
		
		return false;
	}
	
	function set_cookie($name = null, $value = null) {
		global $wpcoHtml;
		
		if (!headers_sent()) {
			setcookie($name, $value, time() + 3600, '/');
		} else {
			?>
            <script type="text/javascript">
            document.cookie = "<?php echo $name; ?>=<?php echo $value; ?>; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> GMT; path=/";
			</script>
            
            <?php
		}
		
		return true;
	}
	
	function reload() {
		?>
        
        <script type="text/javascript">
		window.location.reload(true);
		</script>
        
        <?php	
	}
	
	function alert($message = null, $redirect = false, $addtoalerts = false) {
		global $wpcojsalerts;
		if (empty($wpcojsalerts)) { $wpcojsalerts = array(); }
		$command = "";
		
		if (!empty($message)) { $command .= "alert('" . $message . "'); "; }
		if (!empty($redirect) && $redirect != false) { $command .= $this -> location($redirect); }
		
		if (!empty($command)) {
			if (empty($addtoalerts) || $addtoalerts == false) {
				$this -> output_script($command);
			} else {
				$wpcojsalerts[] = $command;
			}
		}
		
		return false;
	}
	
	function back() {
		return "history.go(-1);";
	}
	
	function output_script($script = null) {
		if (!empty($script)) {
			?>
			
			<script type="text/javascript">			
			<?php echo $script; ?>
			</script>
			
			<?php
		}
		
		return false;
	}
}

?>