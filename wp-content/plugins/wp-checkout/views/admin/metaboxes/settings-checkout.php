<table class="form-table">
	<tbody>
		<tr>
			<th><label for="ssl_none"><?php _e('SSL (https://)', $this -> plugin_name); ?></label></th>
			<td>			
				<label><input <?php if (!$this -> is_plugin_active('checkout-ssl/ssl.php')) : ?>disabled="disabled"<?php elseif ($this -> get_option('ssl') == "checkout") : ?>checked="checked"<?php endif; ?> type="radio" name="ssl" value="checkout" id="ssl_checkout" /> <?php _e('On', $this -> plugin_name); ?></label>
				<label><input <?php if (!$this -> is_plugin_active('checkout-ssl/ssl.php')) : ?>disabled="disabled" checked="checked"<?php elseif ($this -> get_option('ssl') == "none") : ?>checked="checked"<?php endif; ?> type="radio" name="ssl" value="none" id="ssl_none" /> <?php _e('Off', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Turn On the SSL to have your checkout procedure run on the SSL (https://) protocol.', $this -> plugin_name); ?></span>
				
				<?php if (!$this -> is_plugin_active('checkout-ssl/ssl.php')) : ?>
                	<div class="<?php echo $this -> pre; ?>error"><?php echo sprintf(__('In order to use SSL, you need to have the %sOne Click SSL%s extension plugin installed and activated.', $this -> plugin_name), '<a href="http://tribulant.com/extensions/view/15/one-click-ssl" target="_blank">', "</a>"); ?></div>
                <?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><label for=""><?php _e('Order Summary', $this -> plugin_name); ?></label></th>
			<td>
				<?php include $this -> plugin_base() . DS . 'includes' . DS . 'variables.php'; ?>
				<?php $ordersummarysections = $this -> get_option('ordersummarysections'); ?>
				<?php foreach ($checkout_sections as $cs_key => $cs_val) : ?>
					<label><input <?php echo (!empty($ordersummarysections) && in_array($cs_key, $ordersummarysections)) ? 'checked="checked"' : ''; ?> type="checkbox" name="ordersummarysections[]" value="<?php echo $cs_key; ?>" id="ordersummarysections_<?php echo $cs_key; ?>" /> <?php echo __($cs_val); ?></label>
				<?php endforeach; ?>
				<span class="howto"><?php _e('Show a table with a summary of the current order during checkout.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>

<p><?php _e('Buy now mode will send a customer to checkout whenever a product is purchased.', $this -> plugin_name); ?><br/>
<?php _e('The shopping cart/basket will not be used if Buy Now mode is turned on.', $this -> plugin_name); ?><br/>
<?php _e('Buy now mode can be turned On/Off for individual products, the global setting below will override all products.', $this -> plugin_name); ?></p>

<table class="form-table">
	<tbody>
    	<tr>
			<th><?php _e('Enable Buy Now Feature', $this -> plugin_name); ?></th>
			<td>
				<label><input <?php echo ($this -> get_option('buynow') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="buynow" value="Y" id="buynowY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('buynow') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="buynow" value="N" id="buynowN" /> <?php _e('No (recommended)', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('When turned on, a customer will be sent to payment gateway for each product', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><?php _e('Buy Now Payment Method', $this -> plugin_name); ?></th>
			<td>
				<?php if ($paymentmethods = $this -> get_option('paymentmethods')) : ?>
					<?php $buynowpmethod = $this -> get_option('buynowpmethod'); ?>
					<select class="widefat" name="buynowpmethod">
						<option value=""><?php _e('- Select -', $this -> plugin_name); ?></option>
						<?php foreach ($paymentmethods as $pmethod) : ?>
							<option <?php echo (!empty($buynowpmethod) && $buynowpmethod == $pmethod) ? 'selected="selected"' : ''; ?> value="<?php echo $pmethod; ?>"><?php echo $wpcoHtml -> pmethod($pmethod); ?></option>
						<?php endforeach; ?>
					</select>
					<span class="howto"><?php _e('The customer will be asked to pay via this method when buying a product', $this -> plugin_name); ?></span>
				<?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>