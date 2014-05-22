<?php

//the posting URL
$fdurl = ($this -> get_option('fd_test') == "Y") ?
"https://connect.merchanttest.firstdataglobalgateway.com/IPGConnect/gateway/processing" :
"https://connect.firstdataglobalgateway.com/IPGConnect/gateway/processing";

$chargetotal = number_format($Order -> total($order -> id, $shipping = true, $applydiscount = true, $styles = true, $fields = true), 2, '.', '');
$storename = $this -> get_option('fd_store');
$secret = $this -> get_option('fd_secret');
$oid = $order -> id;

//billing details
$bname = $order -> bill_fname . " " . $order -> bill_lname;
$baddr1 = $order -> bill_address;
$bcity = $order -> bill_city;

if ($order -> bill_country == "227") {
	global $us_states;
	require_once $this -> plugin_base() . DS . 'includes' . DS . 'variables.php';

	foreach ($us_states as $us_state_code => $us_state_value) {		
		if ($order -> bill_state == $us_state_value) {
			$bstate = $us_state_code;	
			break 1;
		}
	}
} else {
	$bstate = $order -> bill_state;
}

$bzip = $order -> bill_zipcode;

//shipping details
$sname = $order -> ship_fname . " " . $order -> ship_lname;
$saddr1 = $order -> ship_address;
$scity = $order -> ship_city;
$sstate = $order -> ship_state;
$szip = $order -> ship_zipcode;

$email = $order -> bill_email;
$txnorg = 'eci';
$txntype = 'sale';
$timezonestring = $this -> get_option('fd_timezone');
date_default_timezone_set($timezonestring);
$txntimezone = $timezonestring;
$txndatetime = date("Y:m:d-H:i:s", time());
$subchargetotal = number_format($Order -> total($order -> id, $shipping = false, $applydiscount = true, $styles = true, $fields = true), 2, '.', '');
$shipping = number_format($Order -> shipping_total($subchargetotal, $order -> id), 2, '.', '');
$userid = $user -> ID;
$responseSuccessURL = $wpcoHtml -> retainquery('type=fd', $wpcoHtml -> return_url());
$responseFailURL = $wpcoHtml -> fail_url();
$responseURL = $wpcoHtml -> retainquery('type=fd', $wpcoHtml -> return_url());;
$paymentMethod = 'credit card';
$mode = 'Fullpay';

$str = $storename . $txndatetime . $chargetotal . $secret;

for ($i = 0; $i < strlen($str); $i++){
	$hex_str .= dechex(ord($str[$i]));
}

$hash = hash('sha256', $hex_str);

?>

<p><img src="<?php echo $this -> url(); ?>/images/gateways/first-data.jpg" alt="first-data" /></p>

<form action="<?php echo $fdurl; ?>" method="post" id="fd-form">
	<input type="hidden" name="subtotal" value="<?php echo $chargetotal; ?>" />
	<input type="hidden" name="chargetotal" value="<?php echo $chargetotal; ?>" />
	<input type="hidden" name="storename" value="<?php echo $storename; ?>" />
	<input type="hidden" name="oid" value="<?php echo $oid; ?>" />
	<input type="hidden" name="baddr1" value="<?php echo esc_attr($baddr1); ?>" />
	<input type="hidden" name="bcity" value="<?php echo esc_attr($bcity); ?>" />
    <input type="hidden" name="bstate" value="<?php echo esc_attr($bstate); ?>" />
	<input type="hidden" name="bzip" value="<?php echo $bzip; ?>" />
	<input type="hidden" name="email" value="<?php echo $email; ?>" />
	<input type="hidden" name="txntype" value="<?php echo $txntype; ?>" />
    <input type="hidden" name="txntimezone" value="<?php echo $txntimezone; ?>" />
    <input type="hidden" name="txndatetime" value="<?php echo $txndatetime; ?>" />
    <input type="hidden" name="hash" value="<?php echo $hash; ?>" />
	<input type="hidden" name="bname" value="<?php echo esc_attr($bname); ?>" />
	<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
	<input type="hidden" name="responseSuccessURL" value="<?php echo $responseSuccessURL; ?>" />
	<input type="hidden" name="responseFailURL" value="<?php echo $responseFailURL; ?>" />
	<input type="hidden" name="responseURL" value="<?php echo $responseURL; ?>" />
    <input type="hidden" name="trxOrigin" value="<?php echo $txnorg; ?>" />
    
    <p class="submit">
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
		<input class="<?php echo $this -> pre; ?>button" type="submit" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>

<script type="text/javascript">
jQuery(document).ready(function() {
	var form = document.getElementById('fd-form');
	form.submit();
});
</script>