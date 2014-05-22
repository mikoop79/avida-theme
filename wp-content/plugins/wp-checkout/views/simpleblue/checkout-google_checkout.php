<?php

$action = ($this -> get_option('gc_sandbox') == "N") ?
"https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/" . $this -> get_option('gc_merchant_id') :
"https://sandbox.google.com/checkout/api/checkout/v2/checkoutForm/Merchant/" . $this -> get_option('gc_merchant_id');

$amount = number_format($Order -> total($order -> id, false, true, true, true, false), 2, '.', '');
$discount = $Discount -> total($order -> id);
$tax_cart = $Order -> tax_total($order -> id);	//tax amount
$shipping_cart = number_format($Order -> shipping_total($amount, $order -> id), 2, '.', '');
$total_price = $Order -> total($order -> id, true, true, true, true, false);

?>

<form action="<?php echo $action; ?>" method="post" id="google-checkout-form">
	<!-- Misc -->
    <input type="hidden" name="_charset_" />
    <input type="hidden" name="edit_url" value="<?php echo $wpcoHtml -> cart_url(); ?>" />
    <input type="hidden" name="continue_url" value="<?php echo $wpcoHtml -> retainquery('type=google_checkout&order_id=' . $order -> id, $wpcoHtml -> success_url()); ?>" />
    
    <!-- Custom -->
    <input type="hidden" name="shopping-cart.merchant-private-data" value="<?php echo $order -> id; ?>" />

	<!-- Items -->
	<?php $i = 1; ?>
    <?php foreach ($items as $item) : ?>
    	<input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php echo esc_attr(stripslashes(apply_filters($this -> pre . '_product_title', $item -> product -> title))); ?>" />
        <input type="hidden" name="item_description_<?php echo $i; ?>" value="<?php echo esc_attr(stripslashes($item -> product -> description)); ?>" />
        <input type="hidden" name="item_quantity_<?php echo $i; ?>" value="<?php echo esc_attr(stripslashes($item -> count)); ?>" />
        <input type="hidden" name="item_price_<?php echo $i; ?>" value="<?php echo number_format(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true)), 2, '.', ''); ?>" />
        <input type="hidden" name="item_currency_<?php echo $i; ?>" value="<?php echo $this -> get_option('currency'); ?>" />
        <input type="hidden" name="item_merchant_id_<?php echo $i; ?>" value="<?php echo $item -> id; ?>" />
        <?php $i++; ?>
    <?php endforeach; ?>
    
    <?php if ($this -> get_option('enablecoupons') == "Y" && !empty($discount)) : ?>
    	<input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php _e('Discount', $this -> plugin_name); ?>" />
        <input type="hidden" name="item_description_<?php echo $i; ?>" value="<?php echo esc_attr(stripslashes($wpcoHtml -> currency_price($discount, false))); ?> <?php _e('off your order', $this -> plugin_name); ?>" />
        <input type="hidden" name="item_quantity_<?php echo $i; ?>" value="1" />
        <input type="hidden" name="item_price_<?php echo $i; ?>" value="-<?php echo $discount; ?>" />
        <input type="hidden" name="item_currency_<?php echo $i; ?>" value="<?php echo $this -> get_option('currency'); ?>" />
        <?php $i++; ?>
    <?php endif; ?>
    
    <!-- Tax -->
    <?php if ($this -> get_option('tax_calculate') == "Y" && !empty($tax_cart)) : ?>
    	<input type="hidden" name="tax_rate" value="<?php echo ($wpcoTax -> get_tax_percentage($Order -> do_shipping($order -> id)) / 100); ?>" />
    	<input type="hidden" name="tax_world" value="true" />
    <?php endif; ?>
    
    <!-- Shipping -->
    <?php if ($this -> get_option('shippingcalc') == "Y" && !empty($shipping_cart)) : ?>
    	<input type="hidden" name="ship_method_name_1" value="<?php echo esc_attr(stripslashes($wpcoHtml -> shipmethod_name($order -> shipmethod_id))); ?>" />
        <input type="hidden" name="ship_method_price_1" value="<?php echo $shipping_cart; ?>" />
        <input type="hidden" name="ship_method_currency_1" value="<?php echo $this -> get_option('currency'); ?>" />
        <input type="hidden" name="ship_method_world_1" value="<?php echo $shipping_cart; ?>" />
    <?php endif; ?>
       
   	<p class="submit">
    	<input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
    	<input type="image" name="Google Checkout" alt="Fast checkout through Google" src="http://sandbox.google.com/checkout/buttons/checkout.gif?merchant_id=<?php echo $this -> get_option('gc_merchant_id'); ?>&w=180&h=46&style=white&variant=text&loc=en_US" height="46" width="180">
    </p>
</form>

<script type="text/javascript">
jQuery(document).ready(function() {
	var form = document.getElementById('google-checkout-form');
	form.submit();
});
</script>