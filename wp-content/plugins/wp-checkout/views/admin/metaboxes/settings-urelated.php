<?php

global $wp_roles;
$registercaptcha = $this -> get_option('registercaptcha');
$registercaptcha_publickey = $this -> get_option('registercaptcha_publickey');
$registercaptcha_privatekey = $this -> get_option('registercaptcha_privatekey');
$registercaptcha_theme = $this -> get_option('registercaptcha_theme');

?>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="guestcheckout_N"><?php _e('Guest Checkout', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo (!$this -> is_plugin_active('guest')) ? 'disabled="disabled"' : ''; ?> onclick="if (!confirm('<?php _e('Are you sure you want to turn on the guest checkout feature globally for all customers?\n\nCustomers will not be registering or logging in so there will be no account page with orders history, invoices, downloads or favorites for them to view. If you are using digital products this is not recommended as customers will not be able to download.\n\nPlease confirm that you would like to continue.', $this -> plugin_name); ?>')) { return false; } jQuery('#guestcheckout_div').hide();" <?php echo ($this -> get_option('guestcheckout') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="guestcheckout" value="Y" id="guestcheckout_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
				<label><input <?php echo (!$this -> is_plugin_active('guest')) ? 'disabled="disabled"' : ''; ?> onclick="jQuery('#guestcheckout_div').show();" <?php echo ($this -> get_option('guestcheckout') == "N" || !$this -> is_plugin_active('guest')) ? 'checked="checked"' : ''; ?> type="radio" name="guestcheckout" value="N" id="guestcheckout_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Turn this on to allow users to purchase without having to register.', $this -> plugin_name); ?></span>
				<?php if (!$this -> is_plugin_active('guest')) : ?>
					<div class="<?php echo $this -> pre; ?>error"><?php _e('Please install and activate the Guest Checkout extension plugin to use this.', $this -> plugin_name); ?></div>
					<input type="hidden" name="guestcheckout" value="N" />
				<?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>

<div id="guestcheckout_div" style="display:<?php echo ($this -> get_option('guestcheckout') == "N" || !$this -> is_plugin_active('guest')) ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="<?php echo $this -> pre; ?>loggedinonly"><?php _e('Content access to logged in users only', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($this -> get_option('loggedinonly') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="loggedinonly" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
					<label><input id="<?php echo $this -> pre; ?>loggedinonly" <?php echo ($this -> get_option('loggedinonly') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="loggedinonly" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('Should categories, suppliers,products, etc. only be shown to logged in WordPress users?', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="registercaptcha_Y"><?php _e('Security Captcha Image', $this -> plugin_name); ?></label></th>
				<td>
					<label><input onclick="jQuery('#registercaptcha_div').show();" <?php echo (!empty($registercaptcha) && $registercaptcha == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="registercaptcha" value="Y" id="registercaptcha_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
					<label><input onclick="jQuery('#registercaptcha_div').hide();" <?php echo (!empty($registercaptcha) && $registercaptcha == "N") ? 'checked="checked"' : ''; ?> type="radio" name="registercaptcha" value="N" id="registercaptcha_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div id="registercaptcha_div" style="display:<?php echo (!empty($registercaptcha) && $registercaptcha == "Y") ? 'block' : 'none'; ?>;">
		<h4><?php _e('reCAPTCHA Security Captcha Image Settings', $this -> plugin_name); ?></h4>
		<p>
			<?php _e('The security captcha image uses reCAPTCHA to display a random set of numbers/letters to the user to verify.', $this -> plugin_name); ?><br/>
			<?php echo sprintf(__('Obtain a public and private key from the %sreCAPTCHA site%s and fill them in below.', $this -> plugin_name), '<a href="https://www.google.com/recaptcha/admin/create" target="_blank">', '</a>'); ?>
		</p>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="registercaptcha_publickey"><?php _e('reCAPTCHA Public Key', $this -> plugin_name); ?></label></th>
					<td>
						<input type="text" name="registercaptcha_publickey" value="<?php echo esc_attr(stripslashes($registercaptcha_publickey)); ?>" id="registercaptcha_publickey" class="widefat" />
					</td>
				</tr>
				<tr>
					<th><label for="registercaptcha_privatekey"><?php _e('reCAPTCHA Private Key', $this -> plugin_name); ?></label></th>
					<td>
						<input type="text" name="registercaptcha_privatekey" value="<?php echo esc_attr(stripslashes($registercaptcha_privatekey)); ?>" id="registercaptcha_privatekey" class="widefat" />
					</td>
				</tr>
				<tr>
					<th><label for=""><?php _e('reCAPTCHA Theme', $this -> plugin_name); ?></label></th>
					<td>
						<?php $themes = array('red' => "Red", 'white' => "White", "blackglass" => "Black", 'clean' => "Clean"); ?>
						<select name="registercaptcha_theme" id="registercaptcha_theme">
							<?php foreach ($themes as $theme_slug => $theme_title) : ?>
								<option <?php echo (!empty($registercaptcha_theme) && $registercaptcha_theme == $theme_slug) ? 'selected="selected"' : ''; ?> value="<?php echo $theme_slug; ?>"><?php echo $theme_title; ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="newuserrole"><?php _e('New User Role', $this -> plugin_name); ?></label></th>
				<td>
					<?php if (!empty($wp_roles)) : ?>
						<?php $newuserrole = $this -> get_option('newuserrole'); ?>
						<select name="newuserrole" id="newuserrole">
							<?php foreach ($wp_roles -> role_names as $role_key => $role_name) : ?>
								<option <?php echo (!empty($newuserrole) && $role_key == $newuserrole) ? 'selected="selected"' : ''; ?> value="<?php echo $role_key; ?>"><?php echo $role_name; ?></option>
							<?php endforeach; ?>
						</select>
					<?php endif; ?>
					<span class="howto"><?php _e('The role to register new customers as.', $this -> plugin_name); ?>
				</td>
			</tr>
	        <tr>
	        	<th><label for="usernamepreference_N"><?php _e('Username Preference', $this -> plugin_name); ?></label></th>
	            <td>
	            	<label><input <?php echo ($this -> get_option('usernamepreference') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="usernamepreference" value="Y" id="usernamepreference_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
	                <label><input <?php echo ($this -> get_option('usernamepreference') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="usernamepreference" value="N" id="usernamepreference_N" /> <?php _e('No', $this -> plugin_name); ?></label>
	                <span class="howto"><?php _e('Setting this to No will use the customer email address as the WordPress username', $this -> plugin_name); ?></span>
	            </td>
	        </tr>
			<tr>
				<th><label for="choosepassword_Y"><?php _e('Password Preference', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($this -> get_option('choosepassword') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="choosepassword" value="Y" id="choosepassword_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
					<label><input <?php echo ($this -> get_option('choosepassword') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="choosepassword" value="N" id="choosepassword_N" /> <?php _e('No', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('Allow new customers to type their own password on the Contacts page during checkout', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="newusernotification_Y"><?php _e('New User Notification', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($this -> get_option('newusernotification') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="newusernotification" value="Y" id="newusernotification_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
					<label><input <?php echo ($this -> get_option('newusernotification') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="newusernotification" value="N" id="newusernotification_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('Turn On to send the customer a notification with a username and password.', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="cookieduration"><?php _e('Cookie Duration', $this -> plugin_name); ?></label></th>
			<td>
				<?php $cookieduration = $this -> get_option('cookieduration'); ?>
				<select id="cookieduration" class="widefat" style="width:auto;" name="cookieduration">
					<?php for ($i = 1; $i < 15; $i++) : ?>
						<option <?php echo ($cookieduration == $i) ? 'selected="selected"' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?> <?php _e('days', $this -> plugin_name); ?></option>
					<?php endfor; ?>
				</select>
				<span class="howto"><?php _e('The number of days to store the shop cookie in users browsers.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>shippingdetails"><?php _e('Capture Shipping Details', $this -> plugin_name); ?></label></th>
			<td>
				<label><input id="<?php echo $this -> pre; ?>shippingdetails" <?php echo (!$this -> get_option('shippingdetails') || $this -> get_option('shippingdetails') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="shippingdetails" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('shippingdetails') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="shippingdetails" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Set to NO in order to hide shipping details during checkout and on profile pages.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="defcountry"><?php _e('Default Country', $this -> plugin_name); ?></label></th>
			<td>
				<?php if ($countries = $Country -> select()) : ?>
					<select class="widefat" style="width:auto;" name="defcountry" id="defcountry">
						<option value="">- <?php _e('Select', $this -> plugin_name); ?> -</option>
						<?php foreach ($countries as $cid => $ctitle) : ?>
							<option <?php echo ($this -> get_option('defcountry') == $cid) ? 'selected="selected"' : ''; ?> value="<?php echo $cid; ?>"><?php echo $ctitle; ?></option>
						<?php endforeach; ?>
					</select>
				<?php else : ?>
					<p class="error"><?php echo sprintf(__('No countries are available, %s.', $this -> plugin_name), '<a href="?page=' . $this -> sections -> settings . '&amp;method=loadcountries">load them now</a>'); ?></p>
				<?php endif; ?>
				<span class="howto"><?php _e('The default country to be selected during the checkout procedure', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>