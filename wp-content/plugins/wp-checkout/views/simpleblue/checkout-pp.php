<?php $ppurl = ($this -> get_option('pp_sandbox') == "Y") ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr'; ?>
<?php $buynow = (!empty($params['buynow']) && $params['buynow'] == true) ? "Y" : "N"; ?>
<?php $custom = urlencode(serialize(array('order_id' => $order -> id, 'buynow' => $buynow, 'user' => $order -> user, 'user_id' => $user -> ID))); ?>
<?php $tax_cart = $Order -> tax_total($order -> id); ?>
<?php $buynowquery = (!empty($order -> buynow) && $order -> buynow == "Y") ? '&buynow=Y' : '';  ?>

<p><img border="0" style="border:none;" src="<?php echo $this -> url(); ?>/images/gateways/pp.jpg" alt="paypal" /></p>

<form action="<?php echo $ppurl; ?>" method="post" id="pp-form">
	<input type="hidden" name="upload" value="1" />
	<input type="hidden" name="cmd" value="_ext-enter" />
	<input type="hidden" name="redirect_cmd" value="_cart" />
	<input type="hidden" name="business" value="<?php echo $this -> get_option('pp_email'); ?>" />
	<input type="hidden" name="receiver_email" value="<?php echo $this -> get_option('pp_email'); ?>" />

	<?php $amount = number_format($Order -> total($order -> id, false, true, true, true, false), 2, '.', ''); ?>
	<?php $discount = $Discount -> total($order -> id); ?>
    <?php $total_price = $Order -> total($order -> id, true, true, true, true, false); ?>
    
	<?php $i = 1; ?>
	<?php foreach ($items as $item) : ?>
		<input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php echo esc_attr(apply_filters($this -> pre . '_product_title', __($item -> product -> title))); ?>" />
		<input type="hidden" name="item_number_<?php echo $i; ?>" value="<?php echo $item -> id; ?>" />
		<input type="hidden" name="amount_<?php echo $i; ?>" value="<?php echo number_format(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true, false, false)), 2, '.', ''); ?>" />
		<input type="hidden" name="quantity_<?php echo $i; ?>" value="<?php echo $item -> count; ?>" />
		<input type="hidden" name="num_cart_items" value="<?php echo $Item -> item_count($order -> id); ?>" />
		<?php $i++; ?>
	<?php endforeach; ?>
    
    <?php
	
	if ($this -> get_option('pp_surcharge') == "Y") {
		$surcharge = $Order -> surcharge("pp", $total_price);
		$surcharge_text = $wpcoHtml -> surcharge_text("pp");
	}
	
	?>
    
    <!-- Surcharge -->
    <?php if ($this -> get_option('pp_surcharge') == "Y" && !empty($surcharge)) : ?>
        <input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php _e('Surcharge', $this -> plugin_name); ?> (<?php echo strip_tags($surcharge_text); ?>)" />
        <input type="hidden" name="amount_<?php echo $i; ?>" value="<?php echo number_format($surcharge, 2, '.', ''); ?>" />
        <input type="hidden" name="quantity_<?php echo $i; ?>" value="1" />
        <?php $i++; ?>
    <?php endif; ?>
    
    <!-- Order Options -->
    <?php if ($globalf = $Order -> globalf_total($order -> id)) : ?>
    	<?php if (!empty($globalf)) : ?>
        	<input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php _e('Order Options', $this -> plugin_name); ?>" />
            <input type="hidden" name="amount_<?php echo $i; ?>" value="<?php echo number_format($globalf, 2, '.', ''); ?>" />
            <input type="hidden" name="quantity_<?php echo $i; ?>" value="1" />
        <?php endif; ?>
    <?php endif; ?>
    
    <!-- Discount -->
    <?php if ($this -> get_option('enablecoupons') == "Y" && $discount > 0) : ?>
    	<input type="hidden" name="discount_amount_cart" value="<?php echo esc_attr(stripslashes($wpcoHtml -> number_format_price($discount))); ?>" />
    <?php endif; ?>
	
    <!-- shipping -->
	<?php if ($this -> get_option('shippingcalc') == "Y") : ?>
		<input type="hidden" name="handling_cart" value="<?php echo number_format($Order -> shipping_total($amount, $order -> id), 2, '.', ''); ?>" />
	<?php endif; ?>
    
    <!-- tax -->
    <?php if ($this -> get_option('tax_calculate') == "Y" && !empty($tax_cart)) : ?>
    	<input type="hidden" name="tax" value="<?php echo number_format($tax_cart, 2, '.', ''); ?>" />
        <input type="hidden" name="tax_rate" value="<?php echo $wpcoTax -> get_tax_percentage($Order -> do_shipping($order -> id)); ?>" />
    	<input type="hidden" name="tax_cart" value="<?php echo number_format($tax_cart, 2, '.', ''); ?>" />
    <?php endif; ?>
	
	<input type="hidden" name="no_note" value="1" />
	<input type="hidden" name="currency_code" value="<?php echo $this -> get_option('currency'); ?>" />
	
	<input type="hidden" name="cancel_return" value="<?php echo $wpcoHtml -> bill_url(); ?>" />
    <input type="hidden" name="notify_url" value="<?php echo $wpcoHtml -> retainquery('type=pp&order_id=' . $order -> id . $buynowquery, $wpcoHtml -> return_url()); ?>" />
	<input type="hidden" name="return" value="<?php echo $wpcoHtml -> retainquery('type=pp&order_id=' . $order -> id . $buynowquery, $wpcoHtml -> success_url()); ?>" />
    <input type="hidden" name="cbt" value="<?php _e('CLICK HERE TO COMPLETE YOUR ORDER NOW', $this -> plugin_name); ?>" />
	
	<input type="hidden" name="rm" value="2" />
	<input type="hidden" name="custom" value="<?php echo $custom; ?>" />
	<input type="hidden" name="invoice" value="<?php echo $this -> get_option('pp_invoiceprefix'); ?><?php echo $order -> id; ?>" />
	
	<?php if ($this -> get_option('pp_addressoverride') == "Y") : ?>
		<input type="hidden" name="address_override" value="1" />
	<?php endif; ?>
	<input type="hidden" name="email" value="<?php echo $order -> bill_email; ?>" />
	<input type="hidden" name="night_phone_a" value="<?php echo $order -> bill_phone; ?>" />
	<input type="hidden" name="first_name" value="<?php echo $order -> bill_fname; ?>" />
	<input type="hidden" name="last_name" value="<?php echo $order -> bill_lname; ?>" />
	<input type="hidden" name="address1" value="<?php echo $order -> bill_address; ?>" />
	<input type="hidden" name="address2" value="<?php echo $order -> bill_address2; ?>" />
	<input type="hidden" name="city" value="<?php echo $order -> bill_city; ?>" />
	<?php if ($order -> bill_countrycode == "US") : ?>
		<?php include $this -> plugin_base() . DS . 'includes' . DS . 'variables.php'; ?>
		<?php $us_states = array_flip($us_states); ?>
		<input type="hidden" name="state" value="<?php echo $us_states[$order -> bill_state]; ?>" />
	<?php else : ?>
		<input type="hidden" name="state" value="<?php echo $order -> bill_state; ?>" />
	<?php endif; ?>
	<input type="hidden" name="zip" value="<?php echo $order -> bill_zipcode; ?>" />
	<input type="hidden" name="country" value="<?php echo $order -> bill_countrycode; ?>" />

    <input class="<?php echo $this -> pre; ?>button" type="button" onclick="history.go(-1);" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" />
	<input class="<?php echo $this -> pre; ?>button" style="cursor:pointer;" type="submit" name="payment" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
</form>

<script type="text/javascript">
jQuery(document).ready(function() {
	var form = document.getElementById('pp-form');
	form.submit();
});
</script>