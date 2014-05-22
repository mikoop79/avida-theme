<?php $class = false; ?>
<?php global $errors; ?>

<p><img src="<?php echo $this -> url(); ?>/views/<?php echo $this -> get_option('theme_folder'); ?>/img/creditcards.png" /></p>

<?php if (!empty($errors)) : ?>
	<?php foreach ($errors as $error) : ?>
		<span class="<?php echo $this -> pre; ?>error">&raquo; <?php echo $error; ?></span><br/>
	<?php endforeach; ?>
	<br/>
<?php endif; ?>

<form action="<?php echo $wpcoHtml -> retainquery($this -> pre . "method=payment", $wpcoHtml -> cart_url()); ?>" method="post" id="payxml">
	<input type="hidden" name="<?php echo $this -> pre; ?>method" value="payment" />
    <input type="hidden" name="pmethod" value="payxml" />
    
    <table class="<?php echo $this -> pre; ?>">
    	<tbody>
        	<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="payxml_cname"><?php _e('Card Holder Name', $this -> plugin_name); ?></label></th>
                <td>
                	<?php if (empty($_POST['payxml']['cname'])) { $_POST['payxml']['cname'] = $order -> bill_fname . ' ' . $order -> bill_lname; }; ?>
                	<input type="text" name="payxml[cname]" value="<?php echo esc_attr(stripslashes($_POST['payxml']['cname'])); ?>" id="payxml_cname" />
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="payxml_cc"><?php _e('Card Number', $this -> plugin_name); ?></label></th>
                <td>
                	<input type="text" name="payxml[cc]" value="<?php echo esc_attr(stripslashes($_POST['payxml']['cc'])); ?>" id="payxml_cc" />
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="payxml_exp_m"><?php _e('Expiry Date', $this -> plugin_name); ?></label></th>
                <td>
                	<select name="payxml[exp_m]" size="1" id="payxml_exp_m">
                    	<option value=""><?php _e('MM', $this -> plugin_name); ?></option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "01") ? 'selected="selected"' : ''; ?> value="01">01</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "02") ? 'selected="selected"' : ''; ?> value="02">02</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "03") ? 'selected="selected"' : ''; ?> value="03">03</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "04") ? 'selected="selected"' : ''; ?> value="04">04</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "05") ? 'selected="selected"' : ''; ?> value="05">05</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "06") ? 'selected="selected"' : ''; ?> value="06">06</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "07") ? 'selected="selected"' : ''; ?> value="07">07</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "08") ? 'selected="selected"' : ''; ?> value="08">08</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "09") ? 'selected="selected"' : ''; ?> value="09">09</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "10") ? 'selected="selected"' : ''; ?> value="10">10</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "11") ? 'selected="selected"' : ''; ?> value="11">11</option>
						<option <?php echo (!empty($_POST['payxml']['exp_m']) && $_POST['payxml']['exp_m'] == "12") ? 'selected="selected"' : ''; ?> value="12">12</option>
					</select> /
					<select name="payxml[exp_y]" size="1" id="payxml_exp_y">
                    	<option value=""><?php _e('YYYY', $this -> plugin_name); ?></option>
                    	<?php for ($y = 12; $y <= 23; $y++) : ?>
                    		<option <?php echo (!empty($_POST['payxml']['exp_y']) && $_POST['payxml']['exp_y'] == "20" . $y) ? 'selected="selected"' : ''; ?> value="20<?php echo $y; ?>">20<?php echo $y; ?></option>	
                    	<?php endfor; ?>
					</select>
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="payxml_cvv"><?php _e('Security Code (CVV)', $this -> plugin_name); ?></label></th>
                <td>
                	<input type="text" name="payxml[cvv]" value="<?php echo esc_attr(stripslashes($_POST['payxml']['cvv'])); ?>" id="payxml_cvv" />
                </td>
            </tr>
        </tbody>
    </table>
    
    <p class="submit">
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
        <input class="<?php echo $this -> pre; ?>button" type="submit" name="continue" value="<?php _e('Finish &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>