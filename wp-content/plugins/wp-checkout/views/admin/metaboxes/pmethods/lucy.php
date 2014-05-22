<?php $lucy = $this -> get_option('lucy'); ?>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="lucy_title"><?php _e('Title/Caption', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="lucy[title]" value="<?php echo esc_attr(stripslashes($lucy['title'])); ?>" id="lucy_title" />
            	<span class="howto"><?php _e('Title/caption to show to customers on the shop front.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    	<tr>
        	<th><label for="lucy_username"><?php _e('LUCY Username', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="lucy[username]" value="<?php echo esc_attr(stripslashes($lucy['username'])); ?>" id="lucy_username" />
                <span class="howto"><?php _e('Your LUCY Gateway username provided by LUCY.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="lucy_password"><?php _e('LUCY Password', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="lucy[password]" value="<?php echo esc_attr(stripslashes($lucy['password'])); ?>" id="lucy_password" />
            	<span class="howto"><?php _e('Your LUCY Gateway password provided by LUCY.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="lucy_server_staging"><?php _e('LUCY Server', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo (!empty($lucy['server']) && $lucy['server'] == "live") ? 'checked="checked"' : ''; ?> type="radio" name="lucy[server]" value="live" id="lucy_server_live" /> <?php _e('Live', $this -> plugin_name); ?></label>
                <label><input <?php echo (empty($lucy['server']) || (!empty($lucy['server']) && $lucy['server'] == "staging")) ? 'checked="checked"' : ''; ?> type="radio" name="lucy[server]" value="staging" id="lucy_server_staging" /> <?php _e('Staging/Develop', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Use the LUCY Gateway staging server when using a developer/test account.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>