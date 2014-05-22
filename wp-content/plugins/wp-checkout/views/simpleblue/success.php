<?php $this -> render('steps', array('step' => 'finished', 'order' => $order), true, 'default'); ?>

<p><?php _e('Thank you for placing your order. Please allow a few minutes for processing.', $this -> plugin_name); ?><br/>
<?php _e('Your payment has been received and your products are being prepared.', $this -> plugin_name); ?></p>

<?php if ($this -> get_option('guestcheckout') != "Y") : ?>
	<h3><?php _e('Useful Links', $this -> plugin_name); ?></h3>
	<ul>
		<li><?php echo $wpcoHtml -> link(__('Orders History', $this -> plugin_name), $wpcoHtml -> account_url(), array('title' => __('Full Orders History', $this -> plugin_name))); ?></li>
		<?php if ($this -> has_downloads()) : ?>
			<li><?php echo $wpcoHtml -> link(__('Downloads Management', $this -> plugin_name), $wpcoHtml -> downloads_url(), array('title' => __('Downloads management area', $this -> plugin_name))); ?></li>
		<?php endif; ?>
		<li><?php echo $wpcoHtml -> link(__('Continue Shopping', $this -> plugin_name), $this -> get_option('shopurl'), array('title' => __('Return to the online shop', $this -> plugin_name))); ?></li>
	</ul>
<?php endif; ?>

<?php $this -> render('orders' . DS . 'view', array('order' => $order, 'items' => $items, 'user' => $user, 'confirmation' => true), true, 'default'); ?>

<?php

if ($this -> is_plugin_active('affiliates')) {
	if ($affiliates = $this -> extension_vendor('affiliates')) {
		$affiliates -> salestracking($order, $items, $user);	
	}
}

?>