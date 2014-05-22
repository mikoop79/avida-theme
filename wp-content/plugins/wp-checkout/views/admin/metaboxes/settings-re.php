<table class="form-table">
	<tbody>
		<tr>
			<th><label for="re_title"><?php _e('Payment Method Name', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="re_title" value="<?php echo esc_attr(stripslashes($this -> get_option('re_title'))); ?>" id="re_title" />
				<span class="howto"><?php _e('title/caption which will be displayed to customers on the billing page', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="re_merchantid"><?php _e('Merchant ID', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="re_merchantid" value="<?php echo esc_attr(stripslashes($this -> get_option('re_merchantid'))); ?>" id="re_merchantid" />
			</td>
		</tr>
        <tr>
        	<th><label for="re_account"><?php _e('Account', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="re_account" value="<?php echo esc_attr(stripslashes($this -> get_option('re_account'))); ?>" id="re_account" />
            </td>
        </tr>
		<tr>
			<th><label for="re_secret"><?php _e('Secret', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="re_secret" value="<?php echo esc_attr(stripslashes($this -> get_option('re_secret'))); ?>" id="re_secret" />
			</td>
		</tr>
		<tr>
			<th><label for="re_test_N"><?php _e('Test Mode', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('re_test') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="re_test" value="Y" id="re_test_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('re_test') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="re_test" value="N" id="re_test_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('turn On to do test transactions with test card numbers.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>