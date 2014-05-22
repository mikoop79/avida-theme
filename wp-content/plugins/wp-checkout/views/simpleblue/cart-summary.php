<!-- Cart Summary -->
<div class="<?php echo $this -> pre; ?>ordersummarybox">	
	<?php
	
	$co_id = $Order -> cart_order();
	$items_count = $Item -> item_count($co_id, 'items');
	$units_count = $Item -> item_count($co_id, 'units');
	$subtotal = $Order -> total($co_id, false, false, true, true, false, false);
	$discount = $Discount -> total($co_id);
	$tax_total = $Order -> tax_total($co_id);
	$shipping_total = $Order -> shipping_total($subtotal, $co_id);
	$total_price = $Order -> total($co_id, true, true, true, true, true, true);
	
	do_action($this -> pre . '_cart_summary_top', $co_id, $subtotal, $total_price);
	
	?>
	
	<?php if (!empty($errors)) : ?>
		<h3><?php _e('Errors', $this -> plugin_name); ?></h3>
		<?php $this -> render('errors', array('errors' => $errors), true, 'default'); ?>
	
		<p class="wpcosubmit">
			<?php echo $wpcoHtml -> link(__('Ok, close this', $this -> plugin_name), '', array('class' => "wpcobutton", 'onclick' => "jQuery.colorbox.close(); return false;")); ?>
		</p>
	<?php else : ?>
	
		<?php if (!empty($order) && !empty($items)) : ?>
			<h3><?php _e('Order Summary', $this -> plugin_name); ?></h3>
			
			<?php if (!empty($message)) : ?>
				<p class="wpcosuccessmsg"><?php echo $message; ?></p>
			<?php endif; ?>
			
			<table class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>cart">
				<thead>
					<tr>
						<th><?php _e('Product', $this -> plugin_name); ?></th>
						<th><?php _e('Price', $this -> plugin_name); ?></th>
						<th><?php _e('Qty', $this -> plugin_name); ?></th>
						<th><?php _e('Total', $this -> plugin_name); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($items as $item) : ?>
						<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
							<td class="wpco_columntitle">
								<?php echo apply_filters($this -> pre . '_product_title', $item -> product -> title); ?>
		                    </td>
							<td class="wpco_columnprice"><?php echo $wpcoHtml -> currency_price($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true), true, true); ?></td>
							<td class="wpco_columnqty"><?php echo $item -> count; ?></td>
							<td class="wpco_columntotal"><?php echo $wpcoHtml -> currency_price(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count), true, true); ?></td>
						</tr>
					<?php endforeach; ?>
					<tr class="total">
						<th class="<?php echo $this -> pre; ?>_totaltext" colspan="3"><?php _e('Subtotal', $this -> plugin_name); ?></td>
						<td><?php echo $wpcoHtml -> currency_price($subtotal, true, true); ?></td>
					</tr>
					<?php if (!empty($shipping_total) && $shipping_total > 0) : ?>				
						<tr class="total">
							<th class="wpco_totaltext" colspan="3"><?php _e('Shipping &amp; Handling', $this -> plugin_name); ?></td>
							<td><?php echo $wpcoHtml -> currency_price($shipping_total, true, true); ?></td>
						</tr>
					<?php endif; ?>
					<?php do_action($this -> pre . '_cart_summary_below_shipping', $co_id); ?>
					<?php if ($this -> get_option('enablecoupons') == "Y" && $discount > 0) : ?>
						<tr class="total">
							<th class="<?php echo $this -> pre; ?>_totaltext" colspan="3"><?php _e('Discount', $this -> plugin_name); ?></th>
							<td><?php echo $wpcoHtml -> currency_price($discount, true, true); ?></td>
						</tr>
					<?php endif; ?>
					<?php if ($this -> get_option('tax_calculate') == "Y" && $tax_total > 0) : ?>
						<tr class="total">
							<th class="<?php echo $this -> pre; ?>_totaltext" colspan="3"><?php echo $this -> get_option('tax_name'); ?> (<?php echo $wpcoTax -> get_tax_percentage($Order -> do_shipping($co_id)); ?>&#37;)</td>
							<td><?php echo $wpcoHtml -> currency_price($tax_total, true, true); ?></td>
						</tr>
					<?php endif; ?>
					<tr class="total">
						<th class="<?php echo $this -> pre; ?>_totaltext" colspan="3"><?php _e('Total', $this -> plugin_name); ?></td>
						<td><?php echo $wpcoHtml -> currency_price($total_price, true, true); ?></td>
					</tr>
				</tbody>
			</table>
			
			<?php if ($navigation) : ?>
		    	<p class="<?php echo $this -> pre; ?>submit">
		    		<?php echo $wpcoHtml -> link(__('Continue Shopping', $this -> plugin_name), '', array('onclick' => "jQuery.colorbox.close(); return false;", 'class' => $this -> pre . "button")); ?>
		    		<?php echo $wpcoHtml -> link(__('View Shopping Cart &raquo;', $this -> plugin_name), $wpcoHtml -> cart_url(), array('class' => $this -> pre . "button")); ?>
		    	</p>
		    	
		    	<script type="text/javascript">
		    	jQuery(document).ready(function() {
		    		jQuery('.wpcobutton').button();
		    	});
		    	</script>
		    <?php endif; ?>
			
			<?php if ($couponform !== false) : ?>
				<!-- Coupon Form -->
			    <?php $wpcoDb -> model = $Coupon -> model; ?>
			    <?php $couponscount = $wpcoDb -> count(); ?>
			    <?php if ($this -> get_option('enablecoupons') == "Y" && !empty($couponscount)) : ?>
			        <br/>
			        <?php $wpcoDb -> model = $Discount -> model; ?>
			        <?php $dcount = $wpcoDb -> count(array('order_id' => $order_id)); ?>
			        <?php if ($this -> get_option('multicoupon') == "Y" || (empty($dcount) && $this -> get_option('multicoupon') == "N")) : ?>
			            <?php $this -> render('couponform', false, true, 'default'); ?>
			        <?php endif; ?>
			    <?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
</div>