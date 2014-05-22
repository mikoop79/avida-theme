<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="bartercard_title"><?php _e('Title/Caption', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="bartercard_title" value="<?php echo esc_attr(stripslashes($this -> get_option('bartercard_title'))); ?>" id="bartercard_title" />
                <span class="howto"><?php _e('Title/caption to show to your customers on the billing page and throughout.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="bartercard_merchant"><?php _e('Merchant', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="bartercard_merchant" value="<?php echo esc_attr(stripslashes($this -> get_option('bartercard_merchant'))); ?>" id="bartercard_merchant" />
                <span class="howto"><?php _e('Bartercard provided merchant ID.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="bartercard_MerchantType"><?php _e('Merchant Type', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="bartercard_MerchantType" value="<?php echo esc_attr(stripslashes($this -> get_option('bartercard_MerchantType'))); ?>" id="bartercard_MerchantType" />
            	<span class="howto"><?php _e('First digit identifies whether smspos (0) or Internet based Merchant (1), the second two digits cc identify the originating country of the web site (44 for UK) the next four digits identify the web site and are 0001 for Honey PLC and assigned by Bartercard (this will be added in phase 2).', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>