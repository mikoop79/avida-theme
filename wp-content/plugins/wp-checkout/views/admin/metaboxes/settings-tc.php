<table class="form-table">
	<tbody>
		<tr>
        	<th><label for="tc_title"><?php _e('Payment Method Name', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="tc_title" value="<?php echo esc_attr(stripslashes($this -> get_option('tc_title'))); ?>" id="tc_title" />
                <span class="howto"><?php _e('The name/title to display to customers on the billing page of checkout.', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>tc_vendorid"><?php _e('Vendor ID', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="tc_vendorid" value="<?php echo $this -> get_option('tc_vendorid'); ?>" id="<?php echo $this -> pre; ?>tc_vendorid" class="widefat" />
				<span class="howto"><?php _e('Vendor ID provided by 2CheckOut.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>tc_secret"><?php _e('Secret String', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="tc_secret" value="<?php echo $this -> get_option('tc_secret'); ?>" id="<?php echo $this -> pre; ?>tc_secret" class="widefat" />
				<span class="howto"><?php _e('Used for md5 hash encryption security measurement.', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="tc_method_multi"><?php _e('Checkout Method', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('tc_method') == "single") ? 'checked="checked"' : ''; ?> type="radio" name="tc_method" value="single" id="tc_method_single" /> <?php _e('Single', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('tc_method') == "multi") ? 'checked="checked"' : ''; ?> type="radio" name="tc_method" value="multi" id="tc_method_multi" /> <?php _e('Multi (recommended)', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('2CheckOut single- or multipage checkout. Use multipage checkout to enable PayPal payments as well.', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>tc_demo"><?php _e('Demo Purchase', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('tc_demo') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="tc_demo" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo (!$this -> get_option('tc_demo') || $this -> get_option('tc_demo') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="tc_demo" value="N" id="<?php echo $this -> pre; ?>tc_demo" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('For testing purposes when using a test account and no charges are made.'); ?></span>
			</td>
		</tr>
	</tbody>
</table>