<?php

$url = ($this -> get_option('worldpay_testMode') == "Y") ? 
"https://select-test.worldpay.com/wcc/purchase" : 
"https://secure.worldpay.com/wcc/purchase";

$testMode = ($this -> get_option('worldpay_testMode') == "Y") ? true : false;
$instId = $this -> get_option('worldpay_instId');
$cartId = $order -> id;
$amount = $Order -> total($order -> id, true, true, true, true, true);
$currency = $this -> get_option('currency');
$desc = get_bloginfo('name') . ' ' . __('shopping cart', $this -> plugin_name);
$name = $order -> bill_fname . ' ' . $order -> bill_lname;
$address = $order -> bill_address;
$address .= (!empty($order -> bill_address2)) ? ', ' . $order -> bill_address2 : '';
$postcode = $order -> bill_zipcode;
$country = $order -> bill_countrycode;
$tel = $order -> bill_phone;
$email = $order -> bill_email;
$callback_url = $wpcoHtml -> retainquery($this -> pre . 'method=coreturn&type=worldpay&order_id=' . $order -> id, $wpcoHtml -> cart_url());
$return_url = $wpcoHtml -> retainquery($this -> pre . 'method=cosuccess&order_id=' . $order -> id, $wpcoHtml -> cart_url()); 

?>

<p><img src="<?php echo $this -> url(); ?>/images/gateways/worldpay.gif" alt="worldpay" /></p>

<form action="<?php echo $url; ?>" method="post" id="worldpay">
	<?php if ($testMode == true) : ?><input type="hidden" name="testMode" value="100" id="testMode" /><?php endif; ?>
    <input type="hidden" name="instId" value="<?php echo $instId; ?>" />
    <input type="hidden" name="cartId" value="<?php echo $cartId; ?>" />
    <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
    <input type="hidden" name="currency" value="<?php echo $currency; ?>" />
    <input type="hidden" name="desc" value="<?php echo $desc; ?>" />
    <input type="hidden" name="hideCurrency" value="1" />
    <input type="hidden" name="fixContact" value="1" />
    <input type="hidden" name="hideContact" value="1" />
    
    <input type="hidden" name="name" value="<?php echo $name; ?>" />
    <input type="hidden" name="address" value="<?php echo $address; ?>" />
    <input type="hidden" name="postcode" value="<?php echo $postcode; ?>" />
    <input type="hidden" name="country" value="<?php echo $country; ?>" />
    <input type="hidden" name="tel" value="<?php echo $tel; ?>" />
    <input type="hidden" name="email" value="<?php echo $email; ?>" />
    
    <input type="hidden" name="MC_callback" value="<?php echo $callback_url; ?>" />
    
    <input class="<?php echo $this -> pre; ?>button" type="button" onclick="history.go(-1);" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" />
	<input type="submit" name="continue" class="<?php echo $this -> pre; ?>button" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
</form>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#worldpay').submit();	
});
</script>