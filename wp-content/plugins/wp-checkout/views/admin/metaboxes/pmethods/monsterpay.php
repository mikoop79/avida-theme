<p><?php _e('Please note that MonsterPay requires PHP5 with CURL and SimpleXML installed.', $this -> plugin_name); ?></p>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="monsterpay_title"><?php _e('Title/Caption', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="monsterpay_title" value="<?php echo esc_attr(stripslashes($this -> get_option('monsterpay_title'))); ?>" id="monsterpay_title" />
            	<span class="howto"><?php _e('Title/caption to show for this payment method to your customers.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="monsterpay_MerchantIdentifier"><?php _e('Merchant Identifier', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="monsterpay_MerchantIdentifier" value="<?php echo esc_attr(stripslashes($this -> get_option('monsterpay_MerchantIdentifier'))); ?>" id="monsterpay_MerchantIdentifier" />
            	<span class="howto"><?php _e('Merchant Identifier provided by MonsterPay.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="monsterpay_Usrname"><?php _e('MonsterPay Username', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="monsterpay_Usrname" value="<?php echo esc_attr(stripslashes($this -> get_option('monsterpay_Usrname'))); ?>" id="monsterpay_Usrname" />
            	<span class="howto"><?php _e('Username (usually email address) provided by MonsterPay.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="monsterpay_Pwd"><?php _e('MonsterPay Password', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="monsterpay_Pwd" value="<?php echo esc_attr(stripslashes($this -> get_option('monsterpay_Pwd'))); ?>" id="monsterpay_Pwd" />
            	<span class="howto"><?php _e('Password (for username above) provided by MonsterPay.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="monsterpay_TemplateID"><?php _e('Custom Payment Page ID', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="monsterpay_TemplateID" value="<?php echo esc_attr(stripslashes($this -> get_option('monsterpay_TemplateID'))); ?>" id="monsterpay_TemplateID" />
            	<span class="howto"><?php _e('ID of custom payment page. Leave blank to use the default.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>