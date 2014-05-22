<h4><?php _e('Technical Information', $this -> plugin_name); ?>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for=""><?php _e('PSPID', $this -> plugin_name); ?></label></th>
            <td><input type="text" name="ogone_basic_pspid" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_pspid'))); ?>" id="ogone_basic_pspid" /></td>
        </tr>
        <tr>
        	<th><label for=""><?php _e('SHA-1-IN', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="ogone_basic_sha1" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_sha1'))); ?>" id="ogone_basic_sha1" />
                <span class="howto"><?php _e('you can set this value in your Ogone account under Technical Information > Data &amp; Origin Verification', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>