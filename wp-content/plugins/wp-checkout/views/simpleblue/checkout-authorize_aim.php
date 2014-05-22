<h3><?php _e('Credit Card Details', $this -> plugin_name); ?></h3>
<p><img src="<?php echo $this -> url(); ?>/views/<?php echo $this -> get_option('theme_folder'); ?>/img/creditcards.png" /></p>

<?php global $errors; ?>
<?php if (!empty($errors)) : ?>
	<?php foreach ($errors as $error) : ?>
		<span class="<?php echo $this -> pre; ?>error">&raquo; <?php echo $error; ?></span><br/>
	<?php endforeach; ?>
	<br/>
<?php endif; ?>

<form action="<?php echo $wpcoHtml -> bill_url(); ?>" method="post" id="authorize_aim">
	<input type="hidden" name="<?php echo $this -> pre; ?>method" value="payment" />
	<input type="hidden" name="pmethod" value="authorize_aim" />
	
	<?php do_action($this -> pre . '_authorizeaim_ccfields_before'); ?>
	
	<div id="authorizeaim_ccfields">
		<p><?php _e('Please fill in your card number, expiry date and CVV to place your order.', $this -> plugin_name); ?></p>
		
		<?php $class = false; ?>
		<table class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>cart">
			<tbody>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<th><label for="cc_number"><?php _e('Card Number', $this -> plugin_name); ?></label></th>
					<td><input class="widefat" style="width:auto;" type="text" name="cc_number" value="<?php echo esc_attr(stripslashes($_POST['cc_number'])); ?>" id="cc_number" /></td>
				</tr>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<th><label for="cc_exp_m"><?php _e('Expiry Date', $this -> plugin_name); ?></label></th>
					<td>
						<select style="width:auto;" class="widefat" name="cc_exp_m" size="1">
	                    	<option value=""><?php _e('MM', $this -> plugin_name); ?></option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "01") ? 'selected="selected"' : ''; ?> value="01">01</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "02") ? 'selected="selected"' : ''; ?> value="02">02</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "03") ? 'selected="selected"' : ''; ?> value="03">03</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "04") ? 'selected="selected"' : ''; ?> value="04">04</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "05") ? 'selected="selected"' : ''; ?> value="05">05</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "06") ? 'selected="selected"' : ''; ?> value="06">06</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "07") ? 'selected="selected"' : ''; ?> value="07">07</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "08") ? 'selected="selected"' : ''; ?> value="08">08</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "09") ? 'selected="selected"' : ''; ?> value="09">09</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "10") ? 'selected="selected"' : ''; ?> value="10">10</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "11") ? 'selected="selected"' : ''; ?> value="11">11</option>
							<option <?php echo (!empty($_POST['cc_exp_m']) && $_POST['cc_exp_m'] == "12") ? 'selected="selected"' : ''; ?> value="12">12</option>
						</select> /
						<select style="width:auto;" class="widefat" name="cc_exp_y" size="1">
	                    	<option value=""><?php _e('YYYY', $this -> plugin_name); ?></option>
	                    	<?php for ($y = 12; $y <= 23; $y++) : ?>
	                    		<option <?php echo (!empty($_POST['cc_exp_y']) && $_POST['cc_exp_y'] == "20" . $y) ? 'selected="selected"' : ''; ?> value="20<?php echo $y; ?>">20<?php echo $y; ?></option>
	                    	<?php endfor; ?>
						</select>
					</td>
				</tr>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<th><label for="cc_cvv"><?php _e('Security Code (CVV)', $this -> plugin_name); ?></label></th>
					<td>
						<input class="widefat" type="text" name="cc_cvv" value="<?php echo esc_attr(stripslashes($_POST['cc_cvv'])); ?>" id="cc_cvv" style="width:45px;" />
					</td>
				</tr>
				<?php do_action($this -> pre . '_authorizeaim_ccfields_row'); ?>
			</tbody>
		</table>
		<?php do_action($this -> pre . '_authorizeaim_ccfields_after'); ?>
	</div>
	
	<p class="submit">
    	<input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
		<input class="<?php echo $this -> pre; ?>button" type="submit" name="continue" value="<?php _e('Finish &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>