<?php

$amount = number_format($Order -> total($order -> id, true, true, true, true, true), 2, '.', '');
$key = $this -> get_option('eupayment_key');

$data_all = array(
	'amount'		=>	$amount,
	'curr'			=>	$this -> get_option('currency'),
	'invoice_id'	=>	$order -> id,
	'order_desc'	=>	esc_attr(stripslashes($this -> get_option('eupayment_orderdesc'))),
	'merch_id'		=>	$this -> get_option('eupayment_merchid'),
	'timestamp'		=>	gmdate("YmdHis"),
	'nonce'			=>	md5(microtime() . mt_rand()),
);

$fp_hash = strtoupper($wpcoHtml -> eu_mac($data_all, $key));
$data_all['fp_hash'] = $fp_hash;

?>

<form action="https://www.euplatesc.ro/plati-online/tdsprocess/tranzactd.php" method="post" id="eupayment-form">
	<input type="hidden" name="amount" value="<?php echo $data_all['amount']; ?>" />
	<input type="hidden" name="curr" value="<?php echo $data_all['curr']; ?>" />
	<input type="hidden" name="invoice_id" value="<?php echo $data_all['invoice_id']; ?>" />
	<input type="hidden" name="order_desc" value="<?php echo $data_all['order_desc']; ?>" />
	<input type="hidden" name="merch_id" value="<?php echo $data_all['merch_id']; ?>" />
	<input type="hidden" name="timestamp" value="<?php echo $data_all['timestamp']; ?>" />
	<input type="hidden" name="nonce" value="<?php echo $data_all['nonce']; ?>" />
	<input type="hidden" name="fp_hash" value="<?php echo $data_all['fp_hash']; ?>" />
	
	<input type="hidden" name="fname" value="<?php echo esc_attr(stripslashes($order -> bill_fname)); ?>" />
	<input type="hidden" name="lname" value="<?php echo esc_attr(stripslashes($order -> bill_lname)); ?>" />
	<input type="hidden" name="company" value="<?php echo esc_attr(stripslashes($order -> bill_company)); ?>" />
	<input type="hidden" name="add" value="<?php echo esc_attr(stripslashes($order -> bill_address)); ?>" />
	<input type="hidden" name="city" value="<?php echo esc_attr(stripslashes($order -> bill_city)); ?>" />
	<input type="hidden" name="state" value="<?php echo esc_attr(stripslashes($order -> bill_state)); ?>" />
	<input type="hidden" name="zip" value="<?php echo esc_attr(stripslashes($order -> bill_zipcode)); ?>" />
	<?php $wpcoDb -> model = $Country -> model; ?>
	<?php $country = $wpcoDb -> field('value', array('id' => $order -> bill_country)); ?>	
	<input type="hidden" name="country" value="<?php echo esc_attr(stripslashes($country)); ?>" />
	<input type="hidden" name="phone" value="<?php echo esc_attr(stripslashes($order -> bill_phone)); ?>" />
	<input type="hidden" name="fax" value="<?php echo esc_attr(stripslashes($order -> bill_fax)); ?>" />
	<input type="hidden" name="email" value="<?php echo esc_attr(stripslashes($order -> bill_email)); ?>" />
	
	<input type="hidden" name="sfname" value="<?php echo esc_attr(stripslashes($order -> bill_fname)); ?>" />
	<input type="hidden" name="slname" value="<?php echo esc_attr(stripslashes($order -> bill_lname)); ?>" />
	<input type="hidden" name="scompany" value="<?php echo esc_attr(stripslashes($order -> bill_company)); ?>" />
	<input type="hidden" name="sadd" value="<?php echo esc_attr(stripslashes($order -> bill_address)); ?>" />
	<input type="hidden" name="scity" value="<?php echo esc_attr(stripslashes($order -> bill_city)); ?>" />
	<input type="hidden" name="sstate" value="<?php echo esc_attr(stripslashes($order -> bill_state)); ?>" />
	<input type="hidden" name="szip" value="<?php echo esc_attr(stripslashes($order -> bill_zipcode)); ?>" />
	<?php $wpcoDb -> model = $Country -> model; ?>
	<?php $country = $wpcoDb -> field('value', array('id' => $order -> ship_country)); ?>	
	<input type="hidden" name="scountry" value="<?php echo esc_attr(stripslashes($country)); ?>" />
	<input type="hidden" name="sphone" value="<?php echo esc_attr(stripslashes($order -> bill_phone)); ?>" />
	<input type="hidden" name="sfax" value="<?php echo esc_attr(stripslashes($order -> bill_fax)); ?>" />
	<input type="hidden" name="semail" value="<?php echo esc_attr(stripslashes($order -> bill_email)); ?>" />
	
    <p class="submit">
    	<input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
		<input type="submit" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" class="<?php echo $this -> pre; ?>button" />
    </p>
</form>

<script type="text/javascript">
jQuery(document).ready(function(e) {
	var form = document.getElementById('eupayment-form');
	form.submit();
});
</script>