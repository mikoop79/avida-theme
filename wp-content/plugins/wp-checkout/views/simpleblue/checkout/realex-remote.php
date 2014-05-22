<?php $class = false; ?>
<?php global $errors; ?>

<p><img src="<?php echo $this -> url(); ?>/views/<?php echo $this -> get_option('theme_folder'); ?>/img/creditcards.png" /></p>

<?php if (!empty($errors)) : ?>
	<?php foreach ($errors as $error) : ?>
		<span class="<?php echo $this -> pre; ?>error">&raquo; <?php echo $error; ?></span><br/>
	<?php endforeach; ?>
	<br/>
<?php endif; ?>

<form action="<?php echo $wpcoHtml -> retainquery($this -> pre . "method=payment", $wpcoHtml -> cart_url()); ?>" method="post" id="re_remote">
	<input type="hidden" name="<?php echo $this -> pre; ?>method" value="payment" />
    <input type="hidden" name="pmethod" value="re_remote" />
    
    <table class="<?php echo $this -> pre; ?>">
    	<tbody>
        	<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="re_remote_cname"><?php _e('Card Holder Name', $this -> plugin_name); ?></label></th>
                <td>
                	<?php if (empty($_POST['re_remote']['cname'])) { $_POST['re_remote']['cname'] = $order -> bill_fname . ' ' . $order -> bill_lname; }; ?>
                	<input type="text" name="re_remote[card_chname]" value="<?php echo esc_attr(stripslashes($_POST['re_remote']['card_chname'])); ?>" id="re_remote_cname" />
                </td>
            </tr>
            <tr>
            	<th><label for="re_remote_card_type"><?php _e('Card Type', $this -> plugin_name); ?></label></th>
                <td>
                	<select name="re_remote[card_type]" id="re_remote_card_type">
                    	<option value=""><?php _e('- Select Card Type -', $this -> plugin_name); ?></option>
                        <?php $re_cards_use = maybe_unserialize($this -> get_option('re_cards_use')); ?>
                        <?php foreach ($re_cards_use as $cardkey => $cardvalue) : ?>
                        	<option <?php echo (!empty($_POST['re_remote']['card_type']) && $_POST['re_remote']['card_type'] == $cardkey) ? 'selected="selected"' : ''; ?> value="<?php echo $cardkey; ?>"><?php echo $cardvalue; ?></option>
                        <?php endforeach; ?>
					</select>
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="re_remote_cc"><?php _e('Card Number', $this -> plugin_name); ?></label></th>
                <td>
                	<input type="text" name="re_remote[card_number]" value="<?php echo esc_attr(stripslashes($_POST['re_remote']['card_number'])); ?>" id="re_remote_cc" />
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="re_remote_card_expdate_m"><?php _e('Expiry Date', $this -> plugin_name); ?></label></th>
                <td>
                	<select name="re_remote[card_expdate_m]" size="1" id="re_remote_card_expdate_m">
                    	<option value=""><?php _e('MM', $this -> plugin_name); ?></option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "01") ? 'selected="selected"' : ''; ?> value="01">01</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "02") ? 'selected="selected"' : ''; ?> value="02">02</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "03") ? 'selected="selected"' : ''; ?> value="03">03</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "04") ? 'selected="selected"' : ''; ?> value="04">04</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "05") ? 'selected="selected"' : ''; ?> value="05">05</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "06") ? 'selected="selected"' : ''; ?> value="06">06</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "07") ? 'selected="selected"' : ''; ?> value="07">07</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "08") ? 'selected="selected"' : ''; ?> value="08">08</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "09") ? 'selected="selected"' : ''; ?> value="09">09</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "10") ? 'selected="selected"' : ''; ?> value="10">10</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "11") ? 'selected="selected"' : ''; ?> value="11">11</option>
						<option <?php echo (!empty($_POST['re_remote']['card_expdate_m']) && $_POST['re_remote']['card_expdate_m'] == "12") ? 'selected="selected"' : ''; ?> value="12">12</option>
					</select> /
					<select name="re_remote[card_expdate_y]" size="1" id="re_remote_card_expdate_y">
                    	<option value=""><?php _e('YYYY', $this -> plugin_name); ?></option>
                    	<?php for ($y = 12; $y <= 23; $y++) : ?>
                    		<option <?php echo (!empty($_POST['re_remote']['card_expdate_y']) && $_POST['re_remote']['card_expdate_y'] == "20" . $y) ? 'selected="selected"' : ''; ?> value="20<?php echo $y; ?>">20<?php echo $y; ?></option>
                    	<?php endfor; ?>
					</select>
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="re_remote_cvv"><?php _e('Security Code (CVN)', $this -> plugin_name); ?></label></th>
                <td>
                	<input type="text" name="re_remote[card_cvn_number]" value="<?php echo esc_attr(stripslashes($_POST['re_remote']['card_cvn_number'])); ?>" id="re_remote_cvv" />
                </td>
            </tr>
        </tbody>
    </table>
    
    <p class="submit">
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
        <input class="<?php echo $this -> pre; ?>button" type="submit" name="continue" value="<?php _e('Finish &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>