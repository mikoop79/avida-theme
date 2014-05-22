<?php $re_remote = maybe_unserialize($this -> get_option('re_remote')); ?>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="re_remote_title"><?php _e('Title/Caption', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="re_remote[title]" value="<?php echo esc_attr(stripslashes($re_remote['title'])); ?>" id="re_remote_title" />
            	<span class="howto"><?php _e('The title/caption to show for this payment method to your customers during checkout.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    	<tr>
        	<th><label for="re_remote_merchantid"><?php _e('Merchant ID', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="re_remote[merchantid]" value="<?php echo esc_attr(stripslashes($re_remote['merchantid'])); ?>" id="re_remote_account" />
            	<span class="howto"><?php _e('Merchant ID provided to you by Realex Payments.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="re_remote_account"><?php _e('Account', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="re_remote[account]" value="<?php echo esc_attr(stripslashes($re_remote['account'])); ?>" id="re_remote_account" />
            	<span class="howto"><?php _e('Account/subaccount name, this will most likely be "internet".', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="re_remote_secret"><?php _e('Secret', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="re_remote[secret]" value="<?php echo esc_attr(stripslashes($re_remote['secret'])); ?>" id="re_remote_secret" />
            	<span class="howto"><?php _e('Account secret provided by Realex Payments.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>