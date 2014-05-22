<?php

$url = $this -> get_option('bartercard_url');
$trans = $this -> get_option('bartercard_trans');
$merchant = $this -> get_option('bartercard_merchant');
$amount = number_format($Order -> total($order -> id, $shipping = true, $applydiscount = true, $styles = true, $fields = true, true), 2, '.', '');
$ref = $order -> id;
$cardno = "";
$TRN = $this -> get_option('bartercard_TRN');
$MerchantType = $this -> get_option('bartercard_MerchantType');
$response = $wpcoHtml -> retainquery('type=bartercard&order_id=' . $order -> id, $wpcoHtml -> return_url());

?>

<form action="<?php echo $url; ?>" method="post">
	<input type="hidden" name="trans" value="<?php echo $trans; ?>" />
	<input type="hidden" name="merchant" value="<?php echo $merchant; ?>" />
    <input type="hidden" name="amount" value="<?php echo $amount; ?>" />
    <input type="hidden" name="ref" value="<?php echo $ref; ?>" />
    <input type="hidden" name="TRN" value="<?php echo $TRN; ?>" />
    <input type="hidden" name="MerchantType" value="<?php echo $MerchantType; ?>" />
    <input type="hidden" name="response" value="<?php echo $response; ?>" />
    
    <p>
    	<label>
        	<?php _e('Bartercard Number:', $this -> plugin_name); ?><br/>
        	<input class="<?php echo $this -> pre; ?>bartercardno" type="text" name="cardno" value="<?php echo $cardno; ?>" />
        </label>
    </p>
	
    <p class="submit">
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
		<input class="<?php echo $this -> pre; ?>button" type="submit" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>