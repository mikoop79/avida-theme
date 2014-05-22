<p><img src="<?php echo $this -> url(); ?>/views/<?php echo $this -> get_option('theme_folder'); ?>/img/creditcards.png" /></p>

<?php global $errors; ?>

<?php if (!empty($errors)) : ?>
	<?php foreach ($errors as $error) : ?>
		<span class="<?php echo $this -> pre; ?>error">&raquo; <?php echo $error; ?></span><br/>
	<?php endforeach; ?>
	<br/>
<?php endif; 
$paymentType = 'Sale';

?>

<form method="post" action="<?php echo $wpcoHtml -> retainquery($this -> pre . "method=payment&pmethod=pp_pro", $wpcoHtml -> cart_url()); ?>">
	<input type="hidden" name="paymentType" value="<?php echo $paymentType; ?>" />
    
    <?php $class = ''; ?>
    <table class="<?php echo $this -> pre; ?>">
    	<tbody>
        	<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<td><label for="creditCardType"><?php _e('Card Type:', $this -> plugin_name); ?></label></td>
                <td>
                	<select class="widefat" style="width:auto;" name="creditCardType" id="creditCardType">
                    	<option value=""><?php _e('- Select Card Type -', $this -> plugin_name); ?></option>
                        <option <?php echo (!empty($_POST['creditCardType']) && $_POST['creditCardType'] == "Visa") ? 'selected="selected"' : ''; ?> value="Visa"><?php _e('Visa', $this -> plugin_name); ?></option>
                        <option <?php echo (!empty($_POST['creditCardType']) && $_POST['creditCardType'] == "MasterCard") ? 'selected="selected"' : ''; ?> value="MasterCard"><?php _e('MasterCard', $this -> plugin_name); ?></option>
                        <option <?php echo (!empty($_POST['creditCardType']) && $_POST['creditCardType'] == "Discover") ? 'selected="selected"' : ''; ?> value="Discover"><?php _e('Discover', $this -> plugin_name); ?></option>
                        <option <?php echo (!empty($_POST['creditCardType']) && $_POST['creditCardType'] == "Amex") ? 'selected="selected"' : ''; ?> value="Amex"><?php _e('American Express', $this -> plugin_name); ?></option>
                    </select>
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<td><label for="creditCardNumber"><?php _e('Card Number:', $this -> plugin_name); ?></label></td>
                <td>
                	<input class="widefat" style="width:auto;" type="text" name="creditCardNumber" id="creditCardNumber" value="<?php echo esc_attr(stripslashes($_POST['creditCardNumber'])); ?>" />
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<td><label for="expDateMonth"><?php _e('Expiration Date:', $this -> plugin_name); ?></label></td>
                <td>
                	<select class="widefat" style="width:auto;" name="expDateMonth" size="1" id="expDateMonth">
                    	<option value=""><?php _e('MM', $this -> plugin_name); ?></option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "01") ? 'selected="selected"' : ''; ?> value="01">01</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "02") ? 'selected="selected"' : ''; ?> value="02">02</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "03") ? 'selected="selected"' : ''; ?> value="03">03</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "04") ? 'selected="selected"' : ''; ?> value="04">04</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "05") ? 'selected="selected"' : ''; ?> value="05">05</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "06") ? 'selected="selected"' : ''; ?> value="06">06</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "07") ? 'selected="selected"' : ''; ?> value="07">07</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "08") ? 'selected="selected"' : ''; ?> value="08">08</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "09") ? 'selected="selected"' : ''; ?> value="09">09</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "10") ? 'selected="selected"' : ''; ?> value="10">10</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "11") ? 'selected="selected"' : ''; ?> value="11">11</option>
						<option <?php echo (!empty($_POST['expDateMonth']) && $_POST['expDateMonth'] == "12") ? 'selected="selected"' : ''; ?> value="12">12</option>
					</select> /
					<select class="widefat" style="width:auto;" name="expDateYear" size="1">
                    	<option value=""><?php _e('YYYY', $this -> plugin_name); ?></option>
                    	<?php for ($y = 12; $y <= 23; $y++) : ?>
                    		<option <?php echo (!empty($_POST['expDateYear']) && $_POST['expDateYear'] == "20" . $y) ? 'selected="selected"' : ''; ?> value="20<?php echo $y; ?>">20<?php echo $y; ?></option>
                    	<?php endfor; ?>
					</select>
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<td><label for="cvv2Number"><?php _e('Card Verification Number:', $this -> plugin_name); ?></label></td>
                <td>
                	<input class="widefat" style="width:45px;" type="text" name="cvv2Number" value="<?php echo esc_attr(stripslashes($_POST['cvv2Number'])); ?>" id="cvv2Number" />
                </td>
            </tr>
        </tbody>
    </table>

	<p class="submit">
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
		<input class="<?php echo $this -> pre; ?>button" type="submit" name="continue" value="<?php _e('Finish &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>