<!-- Checkout Steps -->
<div class="<?php echo $this -> pre; ?>steps">
	<?php global $stepsnumber; $stepsnumber = 1; ?>
	<ul>
		<?php if (!empty($order -> fromcontacts)) : ?>
			<li class="<?php echo (!empty($step) && $step == "contacts") ? 'active' : ''; ?>"><span class="number"><?php echo $stepsnumber; ?></span> <?php _e('Contacts', $this -> plugin_name); ?></li>
			<?php $stepsnumber++; ?>
		<?php endif; ?>
		<?php do_action($this -> pre . '_steps_contacts', $step); ?>
        <?php if (!empty($order -> id)) : ?>
        	<?php $order_id = $order -> id; ?>
        <?php else : ?>
        	<?php $order_id = $Order -> current_order_id(); ?>
        <?php endif; ?>
		<?php if ($Order -> do_shipping($order_id)) : ?>
			<li class="<?php echo (!empty($step) && $step == "shipping") ? 'active' : ''; ?>"><span class="number"><?php echo $stepsnumber; ?></span> <?php _e('Shipping', $this -> plugin_name); ?></li>
			<?php $stepsnumber++; ?>
		<?php endif; ?>
		<?php do_action($this -> pre . '_steps_shipping', $step); ?>
		<li class="<?php echo (!empty($step) && $step == "billing") ? 'active' : ''; ?>"><span class="number"><?php echo $stepsnumber; ?></span> <?php _e('Billing', $this -> plugin_name); ?></li>
		<?php $stepsnumber++; ?>
		<?php do_action($this -> pre . '_steps_billing', $step); ?>
		<li class="<?php echo (!empty($step) && $step == "checkout") ? 'active' : ''; ?>"><span class="number"><?php echo $stepsnumber; ?></span> <?php _e('Payment', $this -> plugin_name); ?></li>
		<?php $stepsnumber++; ?>
		<?php do_action($this -> pre . '_steps_payment', $step); ?>
		<li class="<?php echo (!empty($step) && $step == "finished") ? 'active' : ''; ?>"><span class="number"><?php echo $stepsnumber; ?></span> <?php _e('Finished', $this -> plugin_name); ?></li>
		<?php do_action($this -> pre . '_steps_finished', $step); ?>
	</ul>
	<br class="<?php echo $this -> pre; ?>cleaner" />
</div>