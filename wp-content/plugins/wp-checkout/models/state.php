<?php

class wpcoState extends wpCheckoutPlugin {

	var $model = 'wpcoState';
	var $controller = 'states';
	var $table = '';
	var $recursive = true;
	
	var $fields = array(
		'id'				=>	"INT(11) NOT NULL AUTO_INCREMENT",
		'name'				=>	"VARCHAR(150) NOT NULL DEFAULT ''",
		'country_id'		=>	"INT(11) NOT NULL DEFAULT '0'",
		'created'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'modified'			=>	"DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'",
		'key'				=>	"PRIMARY KEY (`id`), KEY `index_name` (`name`), KEY `index_country_id` (`country_id`)",
	);
	
	var $fields_tv = array(
		'id'				=>	array("INT(11)", "NOT NULL AUTO_INCREMENT"),
		'name'				=>	array("VARCHAR(150)", "NOT NULL DEFAULT ''"),
		'country_id'		=>	array("INT(11)", "NOT NULL DEFAULT '0'"),
		'created'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'modified'			=>	array("DATETIME", "NOT NULL DEFAULT '0000-00-00 00:00:00'"),
		'key'				=>	"PRIMARY KEY (`id`), KEY `index_name` (`name`), KEY `index_country_id` (`country_id`)",					   
	);
	
	var $data = array();
	var $errors = array();
	
	function wpcoState($data = array()) {
		$this -> table = $this -> pre . $this -> controller;
		
		if (!empty($data)) {
			foreach ($data as $dkey => $dval) {
				$this -> {$dkey} = stripslashes_deep($dval);
			}
		}
		$wpcoDb = new StdClass;
		$wpcoDb -> model = $this -> model;
		return true;
	}
	
	function validate($data = array()) {
		$this -> errors = array();
		
		if (!empty($data)) {
			$data = (empty($data[$this -> model])) ? $data : $data[$this -> model];
			extract($data, EXTR_SKIP);
			
			if (empty($name)) $this -> errors['name'] = __('Please fill in a state name', $this -> plugin_name);
			if (empty($country_id)) { $this -> errors['country_id'] = __('No country was specified for this state', $this -> plugin_name); }
		} else {
			$this -> errors[] = __('No data was posted', $this -> plugin_name);
		}
		
		return $this -> errors;
	}
	
	function defaults() {
		global $wpcoHtml;
		
		$defaults = array(
			'created'			=>	$wpcoHtml -> gen_date(),
			'modified'			=> 	$wpcoHtml -> gen_date(),
		);
		
		return $defaults;
	}
	
	function get_states_by_country($country_id = null, $inputname = null, $showinput = "true", $sp = "ship", $user_id = null, $order_id = null) {
		global $wpdb, $Order, $wpcoHtml, $wpcoDb, $Country, $wpcoState;
		if (!empty($country_id)) { $_REQUEST['country_id'] = $country_id; }
		if (!empty($inputname)) { $_REQUEST['inputname'] = $inputname; }
		if (!empty($showinput)) { $_REQUEST['showinput'] = $showinput; }
		if (!empty($user_id)) { $_REQUEST['user_id'] = $user_id; }
		
		if (!empty($_REQUEST['inputname'])) {
			if (empty($_REQUEST['user_id'])) {
				global $user_ID;
				if ($user_ID && !is_admin()) {
					$user = $this -> userdata($user_ID);
				} elseif (!empty($order_id)) {
					$orderquery = "SELECT * FROM " . $wpdb -> prefix . $Order -> table . " WHERE `id` = '" . $order_id . "' LIMIT 1";
					$user = $wpdb -> get_row($orderquery);
				}
			} else {
				$user = $this -> userdata($_REQUEST['user_id']);
			}
			
			if (empty($_REQUEST['country_id'])) {
				if ($defcountry = $this -> get_option('defcountry')) {
					$_REQUEST['country_id'] = $defcountry;	
				}
			}
			
			if (!empty($_REQUEST['country_id'])) {
				$conditions = array('country_id' => $_REQUEST['country_id']);	
			}
			
			$wpcoDb -> model = $wpcoState -> model;			
			if (!empty($_REQUEST['country_id']) && $states = $wpcoDb -> find_all($conditions, false, array('name', "ASC"))) {
				?>
                
                <select name="<?php echo $_REQUEST['inputname']; ?>" id="<?php echo $wpcoHtml -> sanitize($_REQUEST['inputname']); ?>" class="<?php echo $this -> pre; ?> widefat">
                	<option value=""><?php _e('- Select -', $this -> plugin_name); ?></option>
                	<?php foreach ($states as $state) : ?>
                    	<option <?php echo (!empty($user -> {$sp . '_state'}) && $user -> {$sp . '_state'} == $state -> name) ? 'selected="selected"' : ''; ?> value="<?php echo $state -> name; ?>"><?php echo $state -> name; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <?php
			} else {				
				if (empty($_REQUEST['showinput']) || $_REQUEST['showinput'] == "true") {
					?><input type="text" name="<?php echo $_REQUEST['inputname']; ?>" value="<?php echo esc_attr(stripslashes($user -> {$sp . '_state'})); ?>" id="" class="<?php echo $this -> pre; ?> widefat" /><?php
				}
			}
		}
	}
}

?>