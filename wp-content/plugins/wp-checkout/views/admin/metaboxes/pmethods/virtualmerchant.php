<!-- Virtual Merchant Settings -->
<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="virtualmerchant_title"><?php _e('Payment Method Name', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" style="width:150px;" type="text" name="virtualmerchant_title" value="<?php echo esc_attr(stripslashes($this -> get_option('virtualmerchant_title'))); ?>" id="virtualmerchant_title" />
            	<span class="howto"><?php _e('The name/title to display to customers on the billing page of checkout.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="virtualmerchant_showform_Y"><?php _e('Payment Type', $this -> plugin_name); ?></label></th>
        	<td>
        		<label><input <?php echo ($this -> get_option('virtualmerchant_showform') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="virtualmerchant_showform" value="Y" id="virtualmerchant_showform_Y" /> <?php _e('Virtual Merchant secure payment page', $this -> plugin_name); ?></label>
        		<label><input <?php echo ($this -> get_option('virtualmerchant_showform') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="virtualmerchant_showform" value="N" id="virtualmerchant_showform_N" /> <?php _e('Own payment form on site (SSL required)', $this -> plugin_name); ?></label>
        		<span class="howto"><?php _e('Should customers checkout and pay on the Virtual Merchant secure payment page or directly on your site?', $this -> plugin_name); ?></span>
        	</td>
        </tr>
    	<tr>
        	<th><label for="virtualmerchant_accountid"><?php _e('Account ID', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" style="width:100px;" type="text" name="virtualmerchant_accountid" value="<?php echo esc_attr(stripslashes($this -> get_option('virtualmerchant_accountid'))); ?>" id="virtualmerchant_accountid" />
            	<span class="howto"><?php _e('Your Virtual Merchant account ID', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="virtualmerchant_userid"><?php _e('User ID', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" style="width:100px;" type="text" name="virtualmerchant_userid" value="<?php echo esc_attr(stripslashes($this -> get_option('virtualmerchant_userid'))); ?>" id="virtualmerchant_userid" />
                <span class="howto"><?php _e('The Virtual Merchant user ID of the user to use', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="virtualmerchant_userpin"><?php _e('User PIN', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" style="width:100px;" type="text" name="virtualmerchant_userpin" value="<?php echo esc_attr(stripslashes($this -> get_option('virtualmerchant_userpin'))); ?>" id="virtualmerchant_userpin" />
            	<span class="howto"><?php _e('PIN which you can obtain/change in your Virtual Merchant account', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="virtualmerchant_demo_N"><?php _e('Demo Account', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('virtualmerchant_demo') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="virtualmerchant_demo" value="Y" id="virtualmerchant_demo_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('virtualmerchant_demo') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="virtualmerchant_demo" value="N" id="virtualmerchant_demo_N" /> <?php _e('No', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('If you are using a Virtual Merchant DEMO account, set this to Yes', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="virtualmerchant_testmode_N"><?php _e('Test Mode', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('virtualmerchant_testmode') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="virtualmerchant_testmode" value="Y" id="virtualmerchant_testmode_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('virtualmerchant_testmode') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="virtualmerchant_testmode" value="N" id="virtualmerchant_testmode_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Turning this On will cause Virtual Merchant to always APPROVE transactions, no matter what. Turn this off for a production site.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>