<p>
	<?php _e('Thank you for submitting your order.', $this -> plugin_name); ?><br/>
	<?php _e('The total amount for this order was', $this -> plugin_name); ?> <strong><?php echo $wpcoHtml -> currency_price($Order -> total($order -> id, true, true, true, true)); ?></strong>.<br/>
	<?php _e('Please follow the instructions below.', $this -> plugin_name); ?>
</p>

<?php echo wpautop($this -> get_option('cu_message')); ?>

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