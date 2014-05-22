<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="worldpay_title"><?php _e('Title/Caption', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="worldpay_title" value="<?php echo esc_attr(stripslashes($this -> get_option('worldpay_title'))); ?>" id="worldpay_title" />
            	<span class="howto"><?php _e('Title/caption to show for this payment method to your customers.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="worldpay_instId"><?php _e('Installation ID', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="worldpay_instId" value="<?php echo esc_attr(stripslashes($this -> get_option('worldpay_instId'))); ?>" id="worldpay_instId" />
                <span class="howto"><?php _e('Your WorldPay Installation ID provided by WorldPay.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="worldpay_testMode_Y"><?php _e('Test Mode', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('worldpay_testMode') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="worldpay_testMode" value="Y" id="worldpay_testMode_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('worldpay_testMode') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="worldpay_testMode" value="N" id="worldpay_testMode_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Turn OFF test mode if you are using a live/production account.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>