<table class="form-table">
	<tbody>
		<tr>
			<th><label for="authorize_aim_title"><?php _e('Payment Method Name', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="authorize_aim_title" value="<?php echo esc_attr(stripslashes($this -> get_option('authorize_aim_title'))); ?>" id="authorize_aim_title" />
			</td>
		</tr>
		<tr>
			<th><label for="authorize_aim_login"><?php _e('API Login ID', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="authorize_aim_login" value="<?php echo esc_attr(stripslashes($this -> get_option('authorize_aim_login'))); ?>" id="authorize_aim_login" />
				<span class="howto"><?php _e('obtain this from your Authorize.net merchant account.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for=""><?php _e('Transaction Key', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="authorize_aim_trankey" value="<?php echo esc_attr(stripslashes($this -> get_option('authorize_aim_trankey'))); ?>" id="authorize_aim_trankey" />
				<span class="howto"><?php _e('obtain this from your Authorize.net merchant account.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="authorize_aim_test_N"><?php _e('Test Mode', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('authorize_aim_test') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="authorize_aim_test" value="Y" id="authorize_aim_test_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('authorize_aim_test') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="authorize_aim_test" value="N" id="authorize_aim_test_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('turn this off for live transactions on a production site.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>