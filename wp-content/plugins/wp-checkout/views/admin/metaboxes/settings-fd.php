<table class="form-table">
	<tbody>
		<tr>
			<th><label for="fd_title"><?php _e('Payment Method Name', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="fd_title" value="<?php echo esc_attr($this -> get_option('fd_title')); ?>" id="fd_title" />
				<span class="howto"><?php _e('name presented to customers during checkout', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="fd_store"><?php _e('Store Number', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="fd_store" value="<?php echo esc_attr($this -> get_option('fd_store')); ?>" id="fd_store" />
                <span class="howto"><?php _e('Store name/number provided to you by First Data.', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="fd_secret"><?php _e('Shared Secret', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="fd_secret" id="fd_secret" value="<?php echo esc_attr(stripslashes($this -> get_option('fd_secret'))); ?>" />
            	<span class="howto"><?php _e('Shared secret generated in the First Data account under Connect 2.0 Setup.', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="fd_test_N"><?php _e('Test Account', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('fd_test') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="fd_test" value="Y" id="fd_test_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('fd_test') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="fd_test" value="N" id="fd_test_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('turn off for a production site', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="fd_timezone"><?php _e('Timezone', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" style="width:45px;" name="fd_timezone" id="fd_timezone" value="<?php echo esc_attr(stripslashes($this -> get_option('fd_timezone'))); ?>" />
            	<span class="howto"><?php _e('Timezone of your server, valid values are GMT, EST, CST, MST, PST.', $this -> plugin_name); ?></span>
            </td>
        </tr>
	</tbody>
</table>