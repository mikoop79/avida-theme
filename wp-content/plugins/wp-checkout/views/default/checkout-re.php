<?php

$merchantid = $this -> get_option('re_merchantid');
$secret = $this -> get_option('re_secret');
$account = $this -> get_option('re_account');
$timestamp = strftime("%Y%m%d%H%M%S");
mt_srand((double)microtime()*1000000);
$orderid = $timestamp."-". $order -> id;
$curr = $this -> get_option('currency');
$amount = preg_replace("/(\.*)/si", "", number_format($Order -> total($order -> id, true, true), 2, '.', ''));
$tmp = "$timestamp.$merchantid.$orderid.$amount.$curr";
$md5hash = md5($tmp);
$tmp = "$md5hash.$secret";
$md5hash = md5($tmp);

?>

<p><img src="<?php echo $this -> url(); ?>/images/gateways/realex.jpg" alt="realex" border="0" style="border:none;" /></p>

<form id="realex-form" action=https://epage.payandshop.com/epage.cgi method=post>
	<input type="hidden" name="<?php echo $this -> pre; ?>method" value="realexreturn" />
	<input type="hidden" name="<?php echo $this -> pre; ?>user_id" value="<?php echo $user -> ID; ?>" />
	<input type="hidden" name="<?php echo $this -> pre; ?>order_id" value="<?php echo $order -> id; ?>" />

	<input type=hidden name="MERCHANT_ID" value="<?php echo $merchantid; ?>">
	<?php if (!empty($account)) : ?><input type="hidden" name="ACCOUNT" value="<?php echo $account; ?><?php echo ($this -> get_option('re_test') == "Y") ? 'test' : ''; ?>" /><?php endif; ?>
	<input type=hidden name="ORDER_ID" value="<?php echo $orderid; ?>">
	<input type=hidden name="CURRENCY" value="<?php echo $curr; ?>">
	<input type=hidden name="AMOUNT" value="<?php echo $amount; ?>">
	<input type=hidden name="TIMESTAMP" value="<?php echo $timestamp; ?>">
	<input type=hidden name="MD5HASH" value="<?php echo $md5hash; ?>">
	<input type=hidden name="AUTO_SETTLE_FLAG" value="1">
	
	<p class="submit">
        <input class="<?php echo $this -> pre; ?>button" type="button" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
		<input class="<?php echo $this -> pre; ?>button" type="submit" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#realex-form').submit();
});
</script>