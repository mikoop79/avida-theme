<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="mail_from"><?php _e('From Email', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="mail_from" value="<?php echo esc_attr(stripslashes($this -> get_option('mail_from'))); ?>" id="mail_from" class="widefat" />
            	<span class="howto"><?php _e('Email address to send emails from.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="mail_name"><?php _e('From Name', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="mail_name" value="<?php echo esc_attr(stripslashes($this -> get_option('mail_name'))); ?>" id="mail_name" class="widefat" />
            	<span class="howto"><?php _e('Name to send emails from.', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>mail_type"><?php _e('Mail Type', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#smtpdiv').show();" <?php echo ($this -> get_option('mail_type') == "smtp") ? 'checked="checked"' : ''; ?> type="radio" name="mail_type" value="smtp" /> <?php _e('SMTP Server', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#smtpdiv').hide();" id="<?php echo $this -> pre; ?>mail_type" <?php echo ($this -> get_option('mail_type') == "mail") ? 'checked="checked"' : ''; ?> type="radio" name="mail_type" value="mail" /> <?php _e('WP Mail (recommended)', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('Choose the way emails are sent out through the plugin.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>

<div id="smtpdiv" style="display:<?php echo ($this -> get_option('mail_type') == "smtp") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="<?php echo $this -> pre; ?>smtp_host"><?php _e('SMTP Host Name', $this -> plugin_name); ?></label></th>
				<td><input type="text" name="smtp_host" value="<?php echo $this -> get_option('smtp_host'); ?>" id="<?php echo $this -> pre; ?>smtp_host" class="widefat" /></td>
			</tr>
			<tr>
				<th><label for="<?php echo $this -> pre; ?>smtp_auth"><?php _e('SMTP Authentication', $this -> plugin_name); ?></label></th>
				<td>
					<label><input onclick="jQuery('#smtpauthdiv').show();" <?php echo ($this -> get_option('smtp_auth') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="smtp_auth" value="Y" id="<?php echo $this -> pre; ?>smtp_auth" /> <?php _e('Yes', $this -> plugin_name); ?></label>
					<label><input onclick="jQuery('#smtpauthdiv').hide();" <?php echo ($this -> get_option('smtp_auth') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="smtp_auth" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div id="smtpauthdiv" style="display:<?php echo ($this -> get_option('smtp_auth') == "Y") ? 'block' : 'none'; ?>;">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="<?php echo $this -> pre; ?>smtp_user"><?php _e('SMTP Username', $this -> plugin_name); ?></label></th>
					<td><input type="text" name="smtp_user" value="<?php echo $this -> get_option('smtp_user'); ?>" id="<?php echo $this -> pre; ?>smtp_user" class="widefat" /></td>
				</tr>
				<tr>
					<th><label for="<?php echo $this -> pre; ?>smtp_pass"><?php _e('SMTP Password', $this -> plugin_name); ?></label></th>
					<td><input type="password" name="smtp_pass" value="<?php echo $this -> get_option('smtp_pass'); ?>" id="<?php echo $this -> pre; ?>smtp_pass" class="widefat" /></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<table class="form-table">
	<tbody>
		<th>&nbsp;</th>
		<td>
			<a id="testsettings" class="button-primary" onclick="testsettings(); return false;" href="?page=<?php echo $this -> sections -> settings; ?>" title="<?php _e('Test your email settings', $this -> plugin_name); ?>"><?php _e('Test Email Settings', $this -> plugin_name); ?></a>
			<span id="testsettingsloading" style="display:none;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" alt="loading" border="0" style="border:none;" /></span>
		</td>
	</tbody>
</table>

<script type="text/javascript">
function testsettings() {
	jQuery('#testsettingsloading').show();
	jQuery('#testsettings').attr('disabled', "disabled");
	var formvalues = jQuery('#checkout-settings').serialize();
	
	jQuery.post(wpcoajaxurl + '?action=<?php echo $this -> pre; ?>testsettings&init=1', formvalues, function(response) {
		jQuery.colorbox({html:response});
		jQuery('#testsettingsloading').hide();
		jQuery('#testsettings').removeAttr('disabled');
	});
}
</script>