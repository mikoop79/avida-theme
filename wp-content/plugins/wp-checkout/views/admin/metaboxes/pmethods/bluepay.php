<table class="form-table">
	<tbody>
		<tr>
			<th><label for="bluepay_title"><?php _e('Title/Caption', $this -> plugin_name); ?></label></th>
			<td>
				<input class="widefat" type="text" name="bluepay_title" value="<?php echo esc_attr(stripslashes($this -> get_option('bluepay_title'))); ?>" id="bluepay_title" />
				<span class="howto"><?php _e('Title/caption to show to your customers on the billing page and throughout.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="bluepay_merchant"><?php _e('Merchant', $this -> plugin_name); ?></label></th>
			<td>
				<input class="widefat" type="text" name="bluepay_merchant" value="<?php echo esc_attr(stripslashes($this -> get_option('bluepay_merchant'))); ?>" id="bluepay_merchant" />
				<span class="howto"><?php _e('Your 12-digit BluePay account ID', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="bluepay_secret"><?php _e('Secret Key', $this -> plugin_name); ?></label></th>
			<td>
				<input class="widefat" type="text" name="bluepay_secret" value="<?php echo esc_attr(stripslashes($this -> get_option('bluepay_secret'))); ?>" id="bluepay_secret" />
				<span class="howto"><?php _e('BluePay secret key found under Administration > Accounts > List > View > Website Integration.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="bluepay_mode_TEST"><?php _e('Mode', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('bluepay_mode') == "LIVE") ? 'checked="checked"' : ''; ?> type="radio" name="bluepay_mode" value="LIVE" id="bluepay_mode_LIVE" /> <?php _e('Live', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('bluepay_mode') == "TEST") ? 'checked="checked"' : ''; ?> type="radio" name="bluepay_mode" value="TEST" id="bluepay_mode_TEST" /> <?php _e('Test', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Set to BluePay live/test mode.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>