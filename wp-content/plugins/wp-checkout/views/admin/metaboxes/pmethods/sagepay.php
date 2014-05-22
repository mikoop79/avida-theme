
<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="sagepay_vendor"><?php _e('Vendor Name', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="sagepay_vendor" value="<?php echo esc_attr(stripslashes($this -> get_option('sagepay_vendor'))); ?>" id="sagepay_vendor" class="widefat" />
            	<span class="howto"><?php _e('Vendor name supplied by Sage Pay.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>