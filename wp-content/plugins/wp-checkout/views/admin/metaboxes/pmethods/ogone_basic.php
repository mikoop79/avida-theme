<h4><?php _e('Technical Information', $this -> plugin_name); ?></h4>

<table class="form-table">
	<tbody>
		<tr>
        	<th><label for="ogone_basic_caption"><?php _e('Title/Caption', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="ogone_basic_caption" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_caption'))); ?>" id="ogone_basic_caption" />
                <span class="howto"><?php _e('The name/title to display to customers on the billing page of checkout.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    	<tr>
        	<th><label for="ogone_basic_pspid"><?php _e('PSPID', $this -> plugin_name); ?></label></th>
            <td><input class="widefat" type="text" name="ogone_basic_pspid" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_pspid'))); ?>" id="ogone_basic_pspid" /></td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_sha1"><?php _e('SHA-1-IN', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="ogone_basic_sha1" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_sha1'))); ?>" id="ogone_basic_sha1" />
                <span class="howto"><?php _e('you can set this value in your Ogone account under Technical Information > Data &amp; Origin Verification', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_sha1out"><?php _e('SHA-1-OUT', $this -> plugin_name); ?></label>
            <td>
            	<input class="widefat" type="text" name="ogone_basic_sha1out" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_sha1out'))); ?>" id="ogone_basic_sha1out" />
            	<span class="howto"><?php _e('you can set this value in your Ogone account under Technical Information > Transaction Feedback', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_mode"><?php _e('Mode', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('ogone_basic_mode') == "test") ? 'checked="checked"' : ''; ?> type="radio" name="ogone_basic_mode" value="test" id="ogone_basic_mode" /> <?php _e('Test', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('ogone_basic_mode') == "prod") ? 'checked="checked"' : ''; ?> type="radio" name="ogone_basic_mode" value="prod" id="ogone_basic_mode" /> <?php _e('Production', $this -> plugin_name); ?></label>
                
                <span class="howto"><?php _e('set to Production for a live shop with real orders', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e('Look and Feel of the Payment Page', $this -> plugin_name); ?></h4>

<p><?php _e('The colours can be specified by their hexadecimal code (#FFFFFF) or their name (white).', $this -> plugin_name); ?></p>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="ogone_basic_title"><?php _e('Title', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="ogone_basic_title" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_title'))); ?>" id="ogone_basic_title" />
            </td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_bgcolor"><?php _e('Background Color', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="ogone_basic_bgcolor" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_bgcolor'))); ?>" id="ogone_basic_bgcolor" />
            </td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_txtcolor"><?php _e('Text Color', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="ogone_basic_txtcolor" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_txtcolor'))); ?>" id="ogone_basic_txtcolor" />
            </td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_tblbgcolor"><?php _e('Table Background Color', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="ogone_basic_tblbgcolor" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_tblbgcolor'))); ?>" id="ogone_basic_tblbgcolor" />
            </td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_tbltxtcolor"><?php _e('Table Text Color', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="ogone_basic_tbltxtcolor" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_tbltxtcolor'))); ?>" id="ogone_basic_tbltxtcolor" />
            </td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_buttonbgcolor"><?php _e('Button Background Color', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="ogone_basic_buttonbgcolor" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_buttonbgcolor'))); ?>" id="ogone_basic_buttonbgcolor" />
            </td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_buttontxtcolor"><?php _e('Button Text Color', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="ogone_basic_buttontxtcolor" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_buttontxtcolor'))); ?>" id="ogone_basic_buttontxtcolor" />
            </td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_fonttype"><?php _e('Font Family', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="ogone_basic_fonttype" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_fonttype'))); ?>" id="ogone_basic_fonttype" />
                <span class="howto"><?php _e('font type to use eg. Verdana', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="ogone_basic_logo"><?php _e('Logo URL', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="ogone_basic_logo" value="<?php echo esc_attr(stripslashes($this -> get_option('ogone_basic_logo'))); ?>" id="ogone_basic_logo" />
                <span class="howto"><?php _e('URL/Link to the logo image. It is recommended that you host this on SSL (https://) in your Ogone control panel.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>