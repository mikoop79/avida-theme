<?php

class wpCheckoutViews extends wpCheckoutPlugin {

	function downloads() {
		global $wpcoDb, $Item, $user_ID, $File, $Javascript;
		
		if ($user_ID) {
			$files = array();
			$fileids = array();
			
			$wpcoDb -> model = $Item -> model;
			
			if ($items = $wpcoDb -> find_all(array('paid' => "Y", 'user_id' => $user_ID))) {
				foreach ($items as $item) {
					$wpcoDb -> model = $File -> model;
				
					if ($newfiles = $wpcoDb -> find_all(array('product_id' => $item -> product -> id))) {
						foreach ($newfiles as $file) {
							if ((empty($fileids)) || (!empty($fileids) && !in_array($file -> id, $fileids))) {
								$files[] = $file;
								$fileids[] = $file -> id;
							}
						}
					}
				}
			}
			
			$output = $this -> render('downloads', array('files' => $files), false, 'default');
			
			if ($this -> get_option('rawsupport') == "Y") {
				$output = '[raw]' . $output . '[/raw]';
			}
			
			return $output;
		} else {
			$message = __('Please register/login to use this feature', $this -> plugin_name);
			$Javascript -> alert($message);
			$this -> redirect($this -> get_option('shopurl'));
		}
	}
	
	function favorites() {
		global $user_ID, $wpcoFavorite;
		
		if ($user_ID) {
			$conditions = array('user_id' => $user_ID);
			$favorites_data = $this -> paginate($wpcoFavorite -> model, '*', '&' . $this -> pre . 'method=favorites', $conditions, false, 10);
		}
		
		ob_start();
		
		?><div id="favorites-div"><?php
		$this -> render('favorite', array('favorites' => $favorites_data[$wpcoFavorite -> model], 'paginate' => $favorites_data['Paginate']), true, 'default');
		?></div><?php
		
		$output = ob_get_clean();
		
		if ($this -> get_option('rawsupport') == "Y") {
			$output = '[raw]' . $output . '[/raw]';
		}
		
		return $output;
	}
	
	function history() {
		global $user_ID, $Order, $Javascript, $wpcoDb;
		
		if ($user_ID) {
			$conditions = array('user_id' => $user_ID, 'completed' => "Y");
			$data = $this -> paginate($Order -> model, '*', '&' . $this -> pre . 'method=history', $conditions, false, 5);
			$output = $this -> render('orders' . DS . 'history', array('orders' => $data[$Order -> model], 'paginate' => $data['Paginate']), false, 'default');	
			
			if ($this -> get_option('rawsupport') == "Y") {
				$output = '[raw]' . $output . '[/raw]';
			}
			
			return $output;
		} else {
			$message = __('Please register/login to use this feature', $this -> plugin_name);	
			$Javascript -> alert($message);
			$this -> redirect($this -> get_option('shopurl'));
		}
	}
	
	function order($order_id = null) {
		global $user_ID, $wpcoDb, $Order, $Item, $Javascript;
		
		if ($user_ID) {
			if (!empty($_GET['id'])) {
				$wpcoDb -> model = $Order -> model;
				
				if ($order = $wpcoDb -> find(array('id' => $_GET['id']))) {
					if ($order -> user_id == $user_ID) {
						$conditions = array('order_id' => $order -> id);
					
						if ($data = $this -> paginate($Item -> model, "*", "&amp;" . $this -> pre . "method=order&amp;id=" . $order -> id, $conditions, false, 5)) {
							$output = $this -> render('orders' . DS . 'view', array('order' => $order, 'items' => $data[$Item -> model], 'paginate' => $data['Paginate']), false, 'default');
							
							if ($this -> get_option('rawsupport') == "Y") {
								$output = '[raw]' . $output . '[/raw]';
							}
							
							return $output;
						}
					} else {
						$message = __('This order does not belong to you', $this -> plugin_name);
					}
				} else {
					$message = __('Order cannot be read', $this -> plugin_name);
				}
			} else {
				$message = __('No order was specified', $this -> plugin_name);
			}
		} else {
			$message = __('Please register/login to use this feature', $this -> plugin_name);
		}
		
		echo $message;
		
		if (!empty($message)) {
			$Javascript -> alert($message, $this -> get_option('shopurl'));
			//$this -> redirect($this -> get_option('shopurl'));	
		}
	}
}

?>