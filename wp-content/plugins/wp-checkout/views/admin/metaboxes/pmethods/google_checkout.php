<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="gc_merchant_id"><?php _e('Merchant ID', $this -> plugin_name); ?></label></th>
            <td><input type="text" class="input widefat" name="gc_merchant_id" value="<?php echo esc_attr(stripslashes($this -> get_option('gc_merchant_id'))); ?>" id="gc_merchant_id" /></td>
        </tr>
        <tr>
        	<th><label for="gc_merchant_key"><?php _e('Merchant Key', $this -> plugin_name); ?></label></th>
            <td><input type="text" class="input widefat" name="gc_merchant_key" value="<?php echo esc_attr(stripslashes($this -> get_option('gc_merchant_key'))); ?>" id="gc_merchant_key" /></td>
        </tr>
        <tr>
        	<th><label for="gc_sandbox_N"><?php _e('Sandbox', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('gc_sandbox') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="gc_sandbox" value="Y" id="gc_sandbox_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('gc_sandbox') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="gc_sandbox" value="N" id="gc_sandbox_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('turn this on for testing purposes with the Google Checkout Sandbox', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>