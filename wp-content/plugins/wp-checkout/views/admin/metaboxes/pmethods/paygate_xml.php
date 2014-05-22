<?php $payxml = maybe_unserialize($this -> get_option('payxml')); ?>
<input type="hidden" name="payxml[ver]" value="<?php echo esc_attr(stripslashes($payxml['ver'])); ?>" />

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="payxml_title"><?php _e('Title/Caption', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="payxml[title]" value="<?php echo esc_attr(stripslashes($payxml['title'])); ?>" id="payxml_title" />
            	<span class="howto"><?php _e('Title/caption to show to customers on the shop front.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="payxml_pgid"><?php _e('PayGate ID', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="payxml[pgid]" value="<?php echo esc_attr(stripslashes($payxml['pgid'])); ?>" id="payxml_pgid" />
            	<span class="howto"><?php _e('Your PayGate ID provided by PayGate.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="payxml_pwd"><?php _e('PayGate Password', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="payxml[pwd]" value="<?php echo esc_attr(stripslashes($payxml['pwd'])); ?>" id="payxml_pwd" />
                <span class="howto"><?php _e('PayGate password to be used in conjunction with the ID above.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="payxml_threed_Y"><?php _e('3D Secure', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo (empty($payxml['threed']) || (!empty($payxml['threed']) && $payxml['threed'] == "Y")) ? 'checked="checked"' : ''; ?> type="radio" name="payxml[threed]" value="Y" id="payxml_threed_Y" /> <?php _e('Yes (recommended)', $this -> plugin_name); ?></label>
                <label><input <?php echo (!empty($payxml['threed']) && $payxml['threed'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="payxml[threed]" value="N" id="payxml_threed_N" /> <?php _e('No', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Use 3D Secure with Verified-By-Visa/MasterCard SecureCode for verification.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>