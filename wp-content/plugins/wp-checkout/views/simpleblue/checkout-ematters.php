<?php

$admin_email = $this -> get_option('merchantemail');

$return_url = ($this -> get_option('ematters_bracket') == "Y") ? "[" : "";
$return_url .= $wpcoHtml -> return_url() . "&type=ematters&";

$merchant_id = $this -> get_option('ematters_merchantid');
$bank = $this -> get_option('ematters_bank');
$mode = "Live";
$readers = $this -> get_option('ematters_readers');
$ip = $_SERVER['REMOTE_ADDR'];
$total_price = $Order -> total($order -> id, true, true, true, true, true);
$order_id = $order -> id;
$cust_name = $order -> bill_fname . " " . $order -> bill_lname;
$cust_email = $order -> bill_email;

?>

<form method="post" action="https://merchant.eMatters.com.au/cmaonline.nsf/ePayForm?OpenForm">
	<input type="hidden" name="<?php echo $this -> pre; ?>method" value="coreturn" />
	<input type="hidden" name="type" value="ematters" />

	<input type="hidden" name="__Click" value="0" />
	<input type="hidden" name="Returnemail" value="<?php echo $admin_email; ?>" />
	<input type="hidden" name="ReturnHTTP" value="<?php echo $return_url ; ?>" />
	<input type="hidden" name="MerchantID" value="<?php echo $merchant_id; ?>" />
	<input type="hidden" name="SendeMail" value="Yes" />
	<input type="hidden" name="Bank" value="<?php echo $bank; ?>" />
	<input type="hidden" name="Platform" value="Std-ASP" />
	<input type="hidden" name="Mode" value="<?php echo $mode; ?>" />
	<input type="hidden" name="readers" value="<?php echo $readers; ?>" />
	<input type="hidden" name="IPAddress" value="<?php echo $ip; ?>" />
	<input type="hidden" name="Principal" value="<?php echo $admin_email; ?>" />
	<input type="hidden" name="FinalPrice" value="<?php echo $total_price; ?>" />
	<input type="hidden" name="UID" value="<?php echo $order_id; ?>" size="20" />
	<input type="hidden" name="Name" value="<?php echo $cust_name; ?>" size="20" maxlength="40" />
	<input type="hidden" name="Email" value="<?php echo $cust_email; ?>" size="25" maxlength="40" />
	
	<table>
		<tbody>
			<tr>
				<th><?php _e('Card Number', $this -> plugin_name); ?></th>
				<td><input name="CreditCardNumber" value="" size="24" maxlength="22" /></td>
			</tr>
			<tr>
				<th><?php _e('CVV', $this -> plugin_name); ?></th>
				<td><input type="text" name="CVV" size="4" value="" /></td>
			</tr>
			<tr>
				<th><?php _e('Expiry Date', $this -> plugin_name); ?></th>
				<td>
					<select name="CreditCardExpiryMonth" size="1">
						<option>01</option>
						<option>02</option>
						<option>03</option>
						<option>04</option>
						<option>05</option>
						<option>06</option>
						<option>07</option>
						<option>08</option>
						<option>09</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
					</select> /
					<select name="CreditCardExpiryYear" size="1">
						<?php for ($y = 12; $y <= 23; $y++) : ?>
							<option value="20<?php echo $y; ?>">20<?php echo $y; ?></option>
						<?php endfor; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th><?php _e('Cardholder Name', $this -> plugin_name); ?></th>
				<td><input name="CreditCardHolderName" size="20" maxlength="40" /></td>
			</tr>
		</tbody>
	</table>
	
    <?php /*
	<br/>

	<a href="<?php echo $wpcoHtml -> bill_url(); ?>" class="button">&laquo; <?php _e('Back', $this -> plugin_name); ?></a>
	<input type="submit" VALUE="SUBMIT" />
	*/ ?>
    
    <p class="submit">
    	<input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
        <input type="submit" name="continue" class="<?php echo $this -> pre; ?>button" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>