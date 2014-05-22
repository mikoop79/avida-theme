<p><img src="<?php echo $this -> url(); ?>/views/<?php echo $this -> get_option('theme_folder'); ?>/img/creditcards.png" /></p>

<?php $this -> render('errors', array('errors' => $params['errors']), true, 'default'); ?>

<form action="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=payment', $wpcoHtml -> cart_url()); ?>" method="post">
	<input type="hidden" name="<?php echo $this -> pre; ?>method" value="payment" />
    <input type="hidden" name="pmethod" value="lucy" />

	<table class="<?php echo $this -> pre; ?>">
    	<tbody>
        	<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="lucy_nameoncard"><?php _e('Card Holder Name', $this -> plugin_name); ?></label></th>
                <td>
                	<?php $lucy_nameoncard = (empty($_POST['lucy_nameoncard'])) ? $order -> bill_fname . ' ' . $order -> bill_lname : $_POST['lucy_nameoncard']; ?>
                	<input type="text" name="lucy_nameoncard" value="<?php echo esc_attr(stripslashes($lucy_nameoncard)); ?>" id="lucy_nameoncard" />
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="lucy_cardnum"><?php _e('Card Number', $this -> plugin_name); ?></label></th>
                <td>
                	<input type="text" name="lucy_cardnum" value="<?php echo esc_attr(stripslashes($_POST['lucy_cardnum'])); ?>" id="lucy_cardnum" />
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="lucy_expm"><?php _e('Expiry Date', $this -> plugin_name); ?></label></th>
                <td>
                	<select name="lucy_expm" size="1" id="lucy_expm">
                    	<option value=""><?php _e('MM', $this -> plugin_name); ?></option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "01") ? 'selected="selected"' : ''; ?> value="01">01</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "02") ? 'selected="selected"' : ''; ?> value="02">02</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "03") ? 'selected="selected"' : ''; ?> value="03">03</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "04") ? 'selected="selected"' : ''; ?> value="04">04</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "05") ? 'selected="selected"' : ''; ?> value="05">05</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "06") ? 'selected="selected"' : ''; ?> value="06">06</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "07") ? 'selected="selected"' : ''; ?> value="07">07</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "08") ? 'selected="selected"' : ''; ?> value="08">08</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "09") ? 'selected="selected"' : ''; ?> value="09">09</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "10") ? 'selected="selected"' : ''; ?> value="10">10</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "11") ? 'selected="selected"' : ''; ?> value="11">11</option>
						<option <?php echo (!empty($_POST['lucy_expm']) && $_POST['lucy_expm'] == "12") ? 'selected="selected"' : ''; ?> value="12">12</option>
					</select> /
					<select name="lucy_expy" size="1" id="lucy_expy">
                    	<option value=""><?php _e('YYYY', $this -> plugin_name); ?></option>
                    	<?php for ($y = 12; $y <= 23; $y++) : ?>
                    		<option <?php echo (!empty($_POST['lucy_expy']) && $_POST['lucy_expy'] == "20" . $y) ? 'selected="selected"' : ''; ?> value="20<?php echo $y; ?>">20<?php echo $y; ?></option>
                    	<?php endfor; ?>
					</select>
                </td>
            </tr>
            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
            	<th><label for="lucy_cvnum"><?php _e('Security Code (CVV)', $this -> plugin_name); ?></label></th>
                <td>
                	<input type="text" style="width:65px;" name="lucy_cvnum" value="<?php echo esc_attr(stripslashes($_POST['lucy_cvnum'])); ?>" id="lucy_cvnum" />
                </td>
            </tr>
        </tbody>
    </table>
    
    <p class="submit">
    	<?php /*<a href="<?php echo $wpcoHtml -> bill_url(); ?>"><?php _e('&laquo; Back', $this -> plugin_name); ?></a>*/ ?>
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
        <input class="<?php echo $this -> pre; ?>button" type="submit" name="continue" value="<?php _e('Finish &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>