<?php

$sid = $this -> get_option('tc_vendorid');
$demo = $this -> get_option('tc_demo');
$cart_order_id = $order -> id;
$merchant_order_id = $order -> id;
$total = number_format($Order -> total($order -> id, true, true, true, true, true), 2, '.', '');
$return_url = $wpcoHtml -> retainquery('type=tc&order_id=' . $order -> id, $wpcoHtml -> return_url());
$x_receipt_link_url = $return_url;
$card_holder_name = $order -> bill_fname . ' ' . $order -> bill_lname;

?>

<p><img src="<?php echo $this -> url(); ?>/images/gateways/2checkout.jpg" alt="2checkout" /></p>

<?php if ($this -> get_option('tc_method') == "single") : ?>
	<form action="https://www.2checkout.com/checkout/spurchase" method="post" id="tc-form">
<?php else : ?>
	<form action="https://www.2checkout.com/checkout/purchase" method="post" id="tc-form">
<?php endif; ?>
	<input type="hidden" name="sid" value="<?php echo esc_attr(stripslashes($sid)); ?>" />
	<input type="hidden" name="id_type" value="1" />
	<input type="hidden" name="fixed" value="Y" />
	<input type="hidden" name="demo" value="<?php echo esc_attr(stripslashes($demo)); ?>" />
	<input type="hidden" name="cart_order_id" value="<?php echo esc_attr(stripslashes($cart_order_id)); ?>" />
	<input type="hidden" name="total" value="<?php echo esc_attr(stripslashes($total)); ?>" />
	<input type="hidden" name="return_url" value="<?php echo esc_attr(stripslashes($return_url)); ?>" />
	<input type="hidden" name="x_receipt_link_url" value="<?php echo esc_attr(stripslashes($x_receipt_link_url)); ?>" />
	<input type="hidden" name="merchant_order_id" value="<?php echo esc_attr(stripslashes($merchant_order_id)); ?>" />
	<input type="hidden" name="card_holder_name" value="<?php echo esc_attr(stripslashes($card_holder_name)); ?>" />
	<input type="hidden" name="first_name" value="<?php echo $order -> bill_fname; ?>" />
	<input type="hidden" name="last_name" value="<?php echo $order -> bill_lname; ?>" />
    <input type="hidden" name="phone" value="<?php echo $order -> bill_phone; ?>" />
	<input type="hidden" name="pay_method" value="CC" />
	<input type="hidden" name="skip_landing" value="1" />
	<input type="hidden" name="street_address" value="<?php echo $order -> bill_address; ?>" />
	<input type="hidden" name="city" value="<?php echo $order -> bill_city; ?>" />
	<input type="hidden" name="state" value="<?php echo $order -> bill_state; ?>" />
	<input type="hidden" name="zip" value="<?php echo $order -> bill_zipcode; ?>" />
	<input type="hidden" name="country" value="<?php echo $order -> bill_countrycode; ?>" />
	<input type="hidden" name="email" value="<?php echo $order -> bill_email; ?>" />
	<input type="hidden" name="<?php echo $this -> pre; ?>order_id" value="<?php echo $order -> id; ?>" />
	<input type="hidden" name="<?php echo $this -> pre; ?>user_id" value="<?php echo $user -> ID; ?>" />
	
	<?php $i = 1; ?>
	<?php foreach ($items as $item) : ?>
		<input type="hidden" name="c_prod_<?php echo $i; ?>" value="<?php echo $item -> product -> id; ?>,<?php echo $item -> count; ?>" />
		<input type="hidden" name="c_name_<?php echo $i; ?>" value="<?php echo esc_attr(stripslashes(__($item -> product -> title))); ?>" />
		<input type="hidden" name="c_description_<?php echo $i; ?>" value="<?php echo esc_attr(stripslashes(strip_tags($wpcoHtml -> truncate(__($item -> product -> description), 255, false)))); ?>" />
		<input type="hidden" name="c_price_<?php echo $i; ?>" value="<?php echo ($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count); ?>" />
		<?php $i++; ?>
	<?php endforeach; ?>

	<p class="submit">
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
		<input class="<?php echo $this -> pre; ?>button" type="submit" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#tc-form').submit();
});
</script>