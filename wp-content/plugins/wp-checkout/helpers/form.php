<?php

class wpcoFormHelper extends wpCheckoutPlugin {

	var $name = 'Form';
	
	function wpcoFormHelper() {
		return true;
	}
	
	function hidden($name = null, $args = array()) {
		global $wpcoHtml;
		
		$defaults = array(
			'value' 		=> 	(empty($args['value'])) ? $wpcoHtml -> field_value($name) : $args['value'],
		);
		
		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);
		
		ob_start();
		
		?><input type="hidden" name="<?php echo $wpcoHtml -> field_name($name); ?>" value="<?php echo esc_attr(stripslashes($value)); ?>" id="<?php echo $name; ?>" /><?php
		
		$hidden = ob_get_clean();
		return $hidden;
	}
	
	function file($name = null, $args = array()) {
		global $wpcoHtml;
		
		$defaults = array('error' => true);
		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);
		
		ob_start();
		
		?>
		
		<div><input style="width:auto;" class="widefat" id="<?php echo $name; ?>" type="file" name="<?php echo $wpcoHtml -> field_name($name); ?>" /></div>
		
		<?php
		
		if ($error == true) {
			echo $wpcoHtml -> field_error($name);
		}
		
		$file = ob_get_clean();
		return $file;
	}
	
	function checkbox($name = null, $buttons = array(), $args = array()) {
		global $wpcoHtml;
		
		$defaults = array(
			'error'			=>	true,
			'onclick'		=>	'return;',
			'separator'		=>	'<br/>',
		);
		
		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);
		
		ob_start();
		
		?>
		
		<?php foreach ($buttons as $bkey => $bval) : ?>
			<label><input onclick="<?php echo $onclick; ?>" <?php echo ($wpcoHtml -> field_value($name) == $bkey || ($wpcoHtml -> field_value($name) == "" && !empty($default) && $default == $bkey)) ? 'checked="checked"' : ''; ?> type="checkbox" name="<?php echo $wpcoHtml -> field_name($name); ?>[]" value="<?php echo $bkey; ?>" id="<?php echo $name; ?><?php echo $bkey; ?>" /> <?php echo $bval; ?></label><?php echo $separator; ?>
		<?php endforeach; ?>
		
		<?php
		
		if ($error == true) {
			echo $wpcoHtml -> field_error($name);
		}
		
		$radio = ob_get_clean();
		return $radio;
	}
	
	function radio($name = null, $buttons = array(), $args = array()) {
		global $wpcoHtml;
		
		$defaults = array(
			'error'			=>	true,
			'onclick'		=>	'return;',
			'separator'		=>	'<br/>',
		);
		
		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);
		
		ob_start();
		
		?>
		
		<?php foreach ($buttons as $bkey => $bval) : ?>
			<label><input onclick="<?php echo $onclick; ?>" <?php echo ($wpcoHtml -> field_value($name) == $bkey || ($wpcoHtml -> field_value($name) == "" && !empty($default) && $default == $bkey)) ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $wpcoHtml -> field_name($name); ?>" value="<?php echo $bkey; ?>" id="<?php echo $name; ?><?php echo $bkey; ?>" /> <?php echo $bval; ?></label><?php echo $separator; ?>
		<?php endforeach; ?>
		
		<?php
		
		if ($error == true) {
			echo $wpcoHtml -> field_error($name);
		}
		
		$radio = ob_get_clean();
		return $radio;
	}
	
	function text($name = null, $args = array()) {
		global $wpcoHtml;
	
		$defaults = array(
			'id'			=>	(empty($args['id'])) ? $name : $args['id'],
			'width'			=>	'100%',
			'class'			=>	"widefat",
			'error'			=>	true,
			'value'			=>	(empty($args['value']) && $args['value'] != "0") ? $wpcoHtml -> field_value($name) : $args['value'],
			'default'		=>	"",
			'autocomplete'	=>	"on",
			'onkeyup'		=>	"",
		);
		
		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);
		
		if (empty($value) && $value != "0") {
			$value = $default;	
		}
		
		ob_start();
		
		?><input <?php if (!empty($onkeyup)) : ?>onkeyup="<?php echo $onkeyup; ?>"<?php endif; ?> class="<?php echo $class; ?>" <?php echo (!empty($disabled)) ? 'disabled="disabled"' : ''; ?> type="text" autocomplete="<?php echo $autocomplete; ?>" style="width:<?php echo $width; ?>;" name="<?php echo $wpcoHtml -> field_name($name); ?>" value="<?php echo esc_attr(stripslashes($value)); ?>" id="<?php echo $id; ?>" /><?php
		
		if ($error == true) {
			echo $wpcoHtml -> field_error($name);
		}
		
		$text = ob_get_clean();
		return $text;
	}
	
	function textarea($name = null, $args = array()) {
		global $wpcoHtml;
		
		$defaults = array(
			'error'			=>	true,
			'width'			=>	'100%',
			'class'			=>	"widefat",
			'rows'			=>	4,
			'cols'			=>	"100%",
		);
		
		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);
		
		ob_start();
		
		?><textarea class="<?php echo $class; ?>" name="<?php echo $wpcoHtml -> field_name($name); ?>" rows="<?php echo $rows; ?>" style="width:<?php echo $width; ?>;" cols="<?php echo $cols; ?>" id="<?php echo $name; ?>"><?php echo esc_attr(stripslashes($wpcoHtml -> field_value($name))); ?></textarea><?php
		
		if ($error == true) {
			echo $wpcoHtml -> field_error($name);
		}
		
		$textarea = ob_get_clean();
		return $textarea;
	}
	
	function select($name = null, $options = array(), $args = array()) {
		global $wpcoHtml, $wpcoDb;
		
		$defaults = array(
			'error'			=>	true,
			'onchange'		=>	"return;",
			'width'			=>	"auto",
			'class'			=>	"widefat",
		);
		
		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);
		
		ob_start();
		
		?>
		
		<select style="width:<?php echo $width; ?>;" class="<?php echo $class; ?>" onchange="<?php echo $onchange; ?>" id="<?php echo $name; ?>" name="<?php echo $wpcoHtml -> field_name($name); ?>">
			<option value="">- <?php _e('Select', $this -> plugin_name); ?> -</option>	
			<?php if (!empty($options)) : ?>
				<?php foreach ($options as $okey => $oval) : ?>
					<?php
					
					switch ($name) {
						case 'Category.parent_id'	:
							$wpcoDb -> model = 'Category';
							$oval .= ' (' . $wpcoDb -> count(array('parent_id' => $okey)) . ' ' . __('subcategories', $this -> plugin_name) . ')';
							break;
						case 'Product.category_id'	:
							$wpcoDb -> model = 'Product';
							$oval .= ' (' . $wpcoDb -> count(array('category_id' => $okey)) . ' ' . __('products', $this -> plugin_name) . ')';
							break;
						case 'File.product_id'		:
							$wpcoDb -> model = 'File';
							$oval .= ' (' . $wpcoDb -> count(array('product_id' => $okey)) . ' ' . __('files', $this -> plugin_name) . ')';
							break;
						case 'Image.product_id'		:
							$wpcoDb -> model = 'Image';
							$oval .= ' (' . $wpcoDb -> count(array('product_id' => $okey)) . ' ' . __('images', $this -> plugin_name) . ')';
							break;
						case 'Option.style_id'		:
							$wpcoDb -> model = 'Option';
							$oval .= ' (' . $wpcoDb -> count(array('style_id' => $okey)) . ' ' . __('options', $this -> plugin_name) . ')';
							break;
					}
					
					?>
				
					<option <?php echo ($wpcoHtml -> field_value($name) == $okey) ? 'selected="selected"' : ''; ?> value="<?php echo $okey; ?>"><?php echo $oval; ?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
		
		<?php
		
		if ($error == true) {
			echo $wpcoHtml -> field_error($name);
		}
		
		$select = ob_get_clean();
		return $select;
	}
	
	function submit($name = null, $args = array()) {
		global $wpcoHtml;
		
		$defaults = array('class' => "button-primary");
		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);
		
		ob_start();
		
		?><input class="<?php echo $class; ?>" type="submit" name="<?php echo $wpcoHtml -> sanitize($name); ?>" value="<?php echo $name; ?>" /><?php
		
		$submit = ob_get_clean();
		return $submit;
	}
}

?>