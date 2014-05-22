<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="mb_title"><?php _e('Title/Caption', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="mb_title" value="<?php echo esc_attr(stripslashes($this -> get_option('mb_title'))); ?>" id="mb_title" />
                <span class="howto"><?php _e('The title/caption to show for this payment method to your customers during checkout.', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>mb_email"><?php _e('Pay to Email Address', $this -> plugin_name); ?></label></th>
			<td><input type="text" class="widefat" name="mb_email" value="<?php echo $this -> get_option('mb_email'); ?>" id="<?php echo $this -> pre; ?>mb_email" /></td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>mb_secret"><?php _e('Secret String', $this -> plugin_name); ?></label></th>
			<td>
				<input class="widefat" type="text" name="mb_secret" value="<?php echo $this -> get_option('mb_secret'); ?>" id="<?php echo $this -> pre; ?>mb_secret" />
				<span class="howto"><?php _e('used for md5 hash encryption security measurement', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>