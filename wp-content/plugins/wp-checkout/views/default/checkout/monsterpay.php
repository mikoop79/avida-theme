<?php

$ButtonAction = "checkout";
$MerchantIdentifier = $this -> get_option('monsterpay_MerchantIdentifier');
$CurrencyAlphaCode = $this -> get_option('currency');
$MerchCustom = $order -> id;
$KeepShopping = $this -> get_option('shopurl');
$TemplateID = $this -> get_option('monsterpay_TemplateID');
$Redirect = $wpcoHtml -> retainquery($this -> pre . 'method=cosuccess&order_id=' . $order -> id, $wpcoHtml -> cart_url());
$BuyerInformation = "1";
$FirstName = $order -> bill_fname;
$LastName = $order -> bill_lname;
$Email = $order -> bill_email;
$MobileNumber = $order -> bill_phone;
$Address1 = $order -> bill_address;
$Address2 = $order -> bill_address2;
$City = $order -> bill_city;
$State = $order -> bill_state;
$PostalCode = $order -> bill_zipcode;
$Country = $order -> bill_countrycode;
$LIDSKU = $order -> id;
$LIDDesc = get_bloginfo('name') . ' ' . __('Shopping Cart', $this -> plugin_name);
$LIDPrice = $Order -> total($order -> id, true, true, true, true, true);
$LIDQty = "1";

?>

<p><img src="<?php echo $this -> url(); ?>/images/gateways/monsterpay.png" alt="monsterpay" /></p>

<form action="https://www.monsterpay.com/secure/" method="post" id="monsterpay">
	<input type="hidden" name="ButtonAction" value="<?php echo $ButtonAction; ?>" />
    <input type="hidden" name="MerchantIdentifier" value="<?php echo $MerchantIdentifier; ?>" />
    <input type="hidden" name="CurrencyAlphaCode" value="<?php echo $CurrencyAlphaCode; ?>" />
    <input type="hidden" name="MerchCustom" value="<?php echo $MerchCustom; ?>" />
    <input type="hidden" name="KeepShopping" value="<?php echo $KeepShopping; ?>" />
    <input type="hidden" name="TemplateID" value="<?php echo $TemplateID; ?>" />
    <input type="hidden" name="Redirect" value="<?php echo $Redirect; ?>" />
    <input type="hidden" name="BuyerInformation" value="<?php echo $BuyerInformation; ?>" />
    <input type="hidden" name="FirstName" value="<?php echo $FirstName; ?>" />
    <input type="hidden" name="LastName" value="<?php echo $LastName; ?>" />
    <input type="hidden" name="MobileNumber" value="<?php echo $MobileNumber; ?>" />
    <input type="hidden" name="Email" value="<?php echo $Email; ?>" />
    <input type="hidden" name="Address1" value="<?php echo $Address1; ?>" />
    <input type="hidden" name="Address2" value="<?php echo $Address2; ?>" />
    <input type="hidden" name="City" value="<?php echo $City; ?>" />
    <input type="hidden" name="State" value="<?php echo $State; ?>" />
    <input type="hidden" name="PostalCode" value="<?php echo $PostalCode; ?>" />
    <input type="hidden" name="Country" value="<?php echo $Country; ?>" />
    <input type="hidden" name="LIDSKU" value="<?php echo $LIDSKU; ?>" />
    <input type="hidden" name="LIDDesc" value="<?php echo $LIDDesc; ?>" />
    <input type="hidden" name="LIDPrice" value="<?php echo $LIDPrice; ?>" />
    <input type="hidden" name="LIDQty" value="<?php echo $LIDQty; ?>" />

	<input class="<?php echo $this -> pre; ?>button" type="button" onclick="history.go(-1);" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" />
	<input type="submit" name="continue" class="<?php echo $this -> pre; ?>button" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
</form>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#monsterpay').submit();	
});
</script>