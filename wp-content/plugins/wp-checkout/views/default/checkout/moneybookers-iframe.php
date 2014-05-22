<form action="https://www.moneybookers.com/app/payment.pl" method="post" id="mbform">
	<input type="hidden" name="pay_to_email" value="<?php echo $this -> get_option('mb_email'); ?>" />
	<input type="hidden" name="recipient_description" value="<?php echo get_option('blogname'); ?>" />
    <input type="hidden" name="hide_login" value="1" />
    <input type="hidden" name="payment_methods" value="ACC," />	
	<input type="hidden" name="return_url" value="<?php echo $wpcoHtml -> retainquery('order_id=' . $order -> id, $wpcoHtml -> success_url()); ?>" />
    <input type="hidden" name="return_url_text" value="<?php _e('Finish Your Order', $this -> plugin_name); ?>" />
	<input type="hidden" name="cancel_url" value="<?php echo $wpcoHtml -> fail_url(); ?>" />
    <input type="hidden" name="status_url" value="<?php echo $wpcoHtml -> retainquery('type=mb&order_id=' . $order -> id, $wpcoHtml -> return_url()); ?>" />
	<input type="hidden" name="language" value="EN" />
	<input type="hidden" name="merchant_fields" value="platform, order_id, user_id, buynow" />
	<INPUT type="hidden" name="platform" value="22859004">
	<input type="hidden" name="order_id" value="<?php echo $order -> id; ?>" />
	<input type="hidden" name="user_id" value="<?php echo $user -> ID; ?>" />
	<input type="hidden" name="amount" value="<?php echo $Order -> total($order -> id, true, true); ?>" />
	<input type="hidden" name="currency" value="<?php echo $this -> get_option('currency'); ?>" />
	<input type="hidden" name="firstname" value="<?php echo $order -> bill_fname; ?>" />
	<input type="hidden" name="lastname" value="<?php echo $order -> bill_lname; ?>" />
    <input type="hidden" name="phone_number" value="<?php echo $order -> bill_phone; ?>" />
    <input type="hidden" name="pay_from_email" value="<?php echo $order -> bill_email; ?>" />
	<input type="hidden" name="address" value="<?php echo $order -> bill_address; ?>" />
    <input type="hidden" name="address2" value="<?php echo $order -> bill_address2; ?>" />
	<input type="hidden" name="postal_code" value="<?php echo $order -> bill_zipcode; ?>" />
	<input type="hidden" name="city" value="<?php echo $order -> bill_city; ?>" />
	<input type="hidden" name="state" value="<?php echo $order -> bill_state; ?>" />
	<?php $wpcoDb -> model = $Country -> model; ?>
	<?php $country = $wpcoDb -> field('isocode', array('id' => $order -> bill_country)); ?>
	<input type="hidden" name="country" value="<?php echo stripslashes($country); ?>" />
	<input type="hidden" name="detail1_description" value="<?php echo stripslashes(get_option('blogname')); ?>" />
	<input type="hidden" name="detail1_text" value="<?php _e('Shopping Cart', $this -> plugin_name); ?>" />
	
	<?php if (!empty($params['buynow']) && $params['buynow'] == true) : ?>
		<input type="hidden" name="buynow" value="Y" />
	<?php else : ?>
		<input type="hidden" name="buynow" value="N" />
	<?php endif; ?>
	
    <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
	<input class="<?php echo $this -> pre; ?>button" type="submit" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
</form>

<script type="text/javascript">
window.onload = function() {
	var form = document.getElementById('mbform');
	form.submit();
};
</script>