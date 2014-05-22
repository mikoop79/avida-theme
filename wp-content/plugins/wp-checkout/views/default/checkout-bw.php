<p>
	<?php _e('Thank you for submitting your order', $this -> plugin_name); ?>.<br/>
	<?php _e('Please make a payment of', $this -> plugin_name); ?> <strong><?php echo $wpcoHtml -> currency_price($Order -> total($order -> id, true, true, true, true)); ?></strong> <?php _e('to the given banking details', $this -> plugin_name); ?>.<br/>
	<?php _e('Once your funds have been received, your order will be processed accordingly', $this -> plugin_name); ?>.
</p>

<p>
	<fieldset class="<?php echo $this -> pre; ?>">
		<legend><?php _e('Banking Details', $this -> plugin_name); ?></legend>
		<table class="<?php echo $this -> pre; ?>">
			<tbody>
				<?php $bwdetails = $this -> get_option('bwdetails'); ?>
				<?php $class = ''; ?>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<th><?php _e('Beneficiary Name', $this -> plugin_name); ?></th>
					<td><?php echo $bwdetails['beneficiary']; ?></td>
				</tr>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<th><?php _e('Bank Name', $this -> plugin_name); ?></th>
					<td><?php echo $bwdetails['name']; ?></td>
				</tr>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<th><?php _e('Bank Phone Number', $this -> plugin_name); ?></th>
					<td><?php echo $bwdetails['phone']; ?></td>
				</tr>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<th><?php _e('Bank Address', $this -> plugin_name); ?></th>
					<td><?php echo nl2br($bwdetails['address']); ?></td>
				</tr>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<th><?php _e('Account Number', $this -> plugin_name); ?></th>
					<td><?php echo $bwdetails['account']; ?></td>
				</tr>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<th><?php _e('Swift Code/Routing Number', $this -> plugin_name); ?></th>
					<td><?php echo $bwdetails['swift']; ?></td>
				</tr>
			</tbody>
		</table>
	</fieldset>
</p>

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
