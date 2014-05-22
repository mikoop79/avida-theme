<p><span class="howto"><?php _e('If you are using a TEST eWay customer ID, ensure that the order amount ends with "00" cents eg. $10.00 to get an approved response code.', $this -> plugin_name); ?></span></p>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="eway_shared_title"><?php _e('Title', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="eway_shared_title" value="<?php echo esc_attr(stripslashes($this -> get_option('eway_shared_title'))); ?>" id="eway_shared_title" />
                <span class="howto"><?php _e('caption to show on billing page of the checkout procedure', $this -> plugin_name); ?></span>
            </td>
        </tr>
    	<tr>
        	<th><label for="eway_shared_customerid"><?php _e('Customer ID', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="eway_shared_customerid" value="<?php echo esc_attr(stripslashes($this -> get_option('eway_shared_customerid'))); ?>" id="eway_shared_customerid" />
                <span class="howto"><?php _e('your eWay customer ID', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="eway_shared_username"><?php _e('Username', $this -> plugin_name); ?></label></th>
        	<td>
        		<input type="text" class="widefat" name="eway_shared_username" value="<?php echo esc_attr(stripslashes($this -> get_option('eway_shared_username'))); ?>" id="eway_shared_username" />
        		<span class="howto"><?php _e('Your eWay Username', $this -> plugin_name); ?></span>
        	</td>
        </tr>
        <tr>
        	<th><label for="eway_shared_invoicedescription"><?php _e('Invoice Description', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="eway_shared_invoicedescription" value="<?php echo esc_attr(stripslashes($this -> get_option('eway_shared_invoicedescription'))); ?>" id="eway_shared_invoicedescription" />
                <span class="howto"><?php _e('invoice description printed by eWay on purchase invoices', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>