<table class="form-table">
	<tbody>
		<tr>
			<th><label for="eupayment_name"><?php _e('Payment Method Name', $this -> plugin_name); ?></label></th>
			<td><input type="text" class="widefat" name="eupayment_name" value="<?php echo esc_attr(stripslashes($this -> get_option('eupayment_name'))); ?>" id="eupayment_name" /></td>
		</tr>
		<tr>
			<th><label for="eupayment_merchid"><?php _e('Account/Merchant ID', $this -> plugin_name); ?></label></th>
			<td><input type="text" name="eupayment_merchid" value="<?php echo esc_attr(stripslashes($this -> get_option('eupayment_merchid'))); ?>" id="eupayment_merchid" /></td>
		</tr>
		<tr>
			<th><label for="eupayment_key"><?php _e('Key', $this -> plugin_name); ?></label></th>
			<td><input type="text" class="widefat" name="eupayment_key" value="<?php echo esc_attr(stripslashes($this -> get_option('eupayment_key'))); ?>" id="eupayment_key" /></td>
		</tr>
		<tr>
			<th><label for="eupayment_orderdesc"><?php _e('Order Description', $this -> plugin_name); ?></label></th>
			<td><input class="widefat" type="text" name="eupayment_orderdesc" value="<?php echo esc_attr(stripslashes($this -> get_option('eupayment_orderdesc'))); ?>" id="eupayment_orderdesc" /></td>
		</tr>
	</tbody>
</table>