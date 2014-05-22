<p class="howto">
	To customize template files, scripts, stylesheets, etc. use a child theme.<br/>
	To create a child theme, create a folder named "checkout" in your current, active WordPress theme folder.<br/>
	Simply put folders and files into "checkout" in the same structure as the theme folders to serve these instead.<br/>
	Look at the theme folders under "wp-checkout/views/" where you can copy files from and see the structure.<br/>
</p>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="theme_folder"><?php _e('Select Theme Folder', $this -> plugin_name); ?></label></th>
            <td>
            	<?php if ($themefolders = $this -> get_themefolders()) : ?>
                	<select name="theme_folder" id="theme_folder">
                    	<?php foreach ($themefolders as $themefolder) : ?>
                        	<option <?php echo ($this -> get_option('theme_folder') == $themefolder) ? 'selected="selected"' : ''; ?> name="<?php echo $themefolder; ?>"><?php echo $themefolder; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="howto"><?php _e('Select the folder inside "wp-checkout/views/" to take shop view files from. eg. "default"', $this -> plugin_name); ?>
                <?php else : ?>
                	<p class="<?php echo $this -> pre; ?>error"><?php _e('No theme folders could be found inside the "wp-checkout/views" folder.', $this -> plugin_name); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
        	<th><label for="theme_usestyle_Y"><?php _e('Use Theme Style File?', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('theme_usestyle') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="theme_usestyle" value="Y" id="theme_usestyle_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('theme_usestyle') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="theme_usestyle" value="N" id="theme_usestyle_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('Setting this to "Yes" will load the "style.css" file inside the theme folder.', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="customcssN"><?php _e('Use Custom CSS', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('customcss') == "Y") ? 'checked="checked"' : ''; ?> onclick="jQuery('#customcssdiv').show();" type="radio" name="customcss" value="Y" id="customcssY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('customcss') == "N") ? 'checked="checked"' : ''; ?> onclick="jQuery('#customcssdiv').hide();" type="radio" name="customcss" value="N" id="customcssN" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('Load any additional CSS into the site as needed.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>

<div id="customcssdiv" style="display:<?php echo ($this -> get_option('customcss') == "Y") ? 'block' : 'none'; ?>;">
	<p class="howto"><?php _e('Turning on the custom CSS will load an additional stylesheet to your site to load these styles. Please note that it could affect performance so we recommend that you rather place these styles in your theme stylesheet.', $this -> plugin_name); ?></p>
	<textarea name="customcsscode" id="customcsscode" rows="12" class="widefat"><?php echo htmlentities($this -> get_option('customcsscode')); ?></textarea>
</div>

<h4><?php _e('Load Default Scripts', $this -> plugin_name); ?></h4>

<p class="howto"><?php _e('Turn On/Off the loading of default scripts on the front-end.', $this -> plugin_name); ?></p>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="loadscript_colorbox_Y"><?php _e('Colorbox', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#loadscript_colorbox_div').show();" <?php echo ($this -> get_option('loadscript_colorbox') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="loadscript_colorbox" value="Y" id="loadscript_colorbox_Y" /> <?php _e('Yes, load this script', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#loadscript_colorbox_div').hide();" <?php echo ($this -> get_option('loadscript_colorbox') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="loadscript_colorbox" value="N" id="loadscript_colorbox_N" /> <?php _e('No, I have it loaded already', $this -> plugin_name); ?></label>
				<div id="loadscript_colorbox_div" style="display:<?php echo ($this -> get_option('loadscript_colorbox') == "Y") ? 'block' : 'none'; ?>;"><label><strong><?php _e('Handle:', $this -> plugin_name); ?></strong> <input type="text" name="loadscript_colorbox_handle" value="<?php echo esc_attr(stripslashes($this -> get_option('loadscript_colorbox_handle'))); ?>" id="loadscript_colorbox_handle" class="widefat" style="width:150px;" /></label></div>
				<span class="howto"><?php _e('Load the Colorbox script for the subscriber management section.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="loadscript_jqueryuitabs_Y"><?php _e('jQuery UI Tabs', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#loadscript_jqueryuitabs_div').show();" <?php echo ($this -> get_option('loadscript_jqueryuitabs') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="loadscript_jqueryuitabs" value="Y" id="loadscript_jqueryuitabs_Y" /> <?php _e('Yes, load this script', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#loadscript_jqueryuitabs_div').hide();" <?php echo ($this -> get_option('loadscript_jqueryuitabs') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="loadscript_jqueryuitabs" value="N" id="loadscript_jqueryuitabs_N" /> <?php _e('No, I have it loaded already', $this -> plugin_name); ?></label>
				<div id="loadscript_jqueryuitabs_div" style="display:<?php echo ($this -> get_option('loadscript_jqueryuitabs') == "Y") ? 'block' : 'none'; ?>;"><label><strong><?php _e('Handle:', $this -> plugin_name); ?></strong> <input type="text" name="loadscript_jqueryuitabs_handle" value="<?php echo esc_attr(stripslashes($this -> get_option('loadscript_jqueryuitabs_handle'))); ?>" id="loadscript_jqueryuitabs_handle" class="widefat" style="width:150px;" /></label></div>
				<span class="howto"><?php _e('Load the jQuery UI Tabs script for the subscriber management section.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="loadscript_jqueryuibutton_Y"><?php _e('jQuery UI Button', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#loadscript_jqueryuibutton_div').show();" <?php echo ($this -> get_option('loadscript_jqueryuibutton') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="loadscript_jqueryuibutton" value="Y" id="loadscript_jqueryuibutton_Y" /> <?php _e('Yes, load this script', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#loadscript_jqueryuibutton_div').hide();" <?php echo ($this -> get_option('loadscript_jqueryuibutton') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="loadscript_jqueryuibutton" value="N" id="loadscript_jqueryuibutton_N" /> <?php _e('No, I have it loaded already', $this -> plugin_name); ?></label>
				<div id="loadscript_jqueryuibutton_div" style="display:<?php echo ($this -> get_option('loadscript_jqueryuibutton') == "Y") ? 'block' : 'none'; ?>;"><label><strong><?php _e('Handle:', $this -> plugin_name); ?></strong> <input type="text" name="loadscript_jqueryuibutton_handle" value="<?php echo esc_attr(stripslashes($this -> get_option('loadscript_jqueryuibutton_handle'))); ?>" id="loadscript_jqueryuibutton_handle" class="widefat" style="width:150px;" /></label></div>
				<span class="howto"><?php _e('Load the jQuery UI Button script for all the buttons.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="loadscript_jqueryuidatepicker_Y"><?php _e('jQuery UI Date Picker', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#loadscript_jqueryuidatepicker_div').show();" <?php echo ($this -> get_option('loadscript_jqueryuidatepicker') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="loadscript_jqueryuidatepicker" value="Y" id="loadscript_jqueryuidatepicker_Y" /> <?php _e('Yes, load this script', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#loadscript_jqueryuidatepicker_div').hide();" <?php echo ($this -> get_option('loadscript_jqueryuidatepicker') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="loadscript_jqueryuidatepicker" value="N" id="loadscript_jqueryuidatepicker_N" /> <?php _e('No, I have it loaded already', $this -> plugin_name); ?></label>
				<div id="loadscript_jqueryuidatepicker_div" style="display:<?php echo ($this -> get_option('loadscript_jqueryuidatepicker') == "Y") ? 'block' : 'none'; ?>;"><label><strong><?php _e('Handle:', $this -> plugin_name); ?></strong> <input type="text" name="loadscript_jqueryuidatepicker_handle" value="<?php echo esc_attr(stripslashes($this -> get_option('loadscript_jqueryuidatepicker_handle'))); ?>" id="loadscript_jqueryuidatepicker_handle" class="widefat" style="width:150px;" /></label></div>
				<span class="howto"><?php _e('Load the jQuery UI Date Picker script for field date pickers.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>