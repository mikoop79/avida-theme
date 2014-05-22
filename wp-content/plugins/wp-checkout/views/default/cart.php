<?php if (!empty($order) && !empty($items)) : ?>
	<?php $theorder = $order; ?>
	
	<?php do_action($this -> pre . '_cart_top', $order, $items); ?>
	
	<?php $this -> render('errors', array('errors' => $errors), true, 'default'); ?>
	
	<form id="wpco_cartform" <?php if ($this -> is_plugin_active('euvatex')) : ?>onsubmit="jQuery.Watermark.HideAll();"<?php endif; ?> class="<?php echo $this -> pre; ?>" action="<?php echo $wpcoHtml -> cart_url(); ?>" method="post">	
		<?php $co_id = $Order -> cart_order(); ?>
		<?php $weight = $Order -> weight($co_id); ?>
		<?php if (($this -> get_option('shiptierstype') == "weight" || !empty($shipmethod -> api) || true) && !empty($weight)) : ?>
			<div class="shippingmessageholder"><p class="shippingmessage"><?php _e('Your order has a total calculated weight of', $this -> plugin_name); ?> <strong><?php echo $weight; ?><?php echo $this -> get_option('weightm'); ?></strong></p></div>
		<?php endif; ?> 
	
		<table class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>cart">
			<thead>
				<tr>
					<th colspan="2"><?php _e('Product', $this -> plugin_name); ?></th>
					<th><?php _e('Options', $this -> plugin_name); ?></th>
					<th><?php _e('Price', $this -> plugin_name); ?></th>
					<th><?php _e('Qty', $this -> plugin_name); ?></th>
					<th><?php _e('Total', $this -> plugin_name); ?></th>
					<th><?php _e('Remove', $this -> plugin_name); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php $class = 'erow'; ?>
				<?php $qties = 0; ?>
				<?php $ptotal = 0; ?>
				<?php foreach ($items as $item) : ?>
					<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
						<td class="wpco_columnimage" width="50"><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($item -> product -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($item -> product -> image -> name), array('class' => 'colorbox', 'title' => apply_filters($this -> pre . '_product_title', $item -> product -> title), 'rel' => 'cart-images')); ?></td>
						<td class="wpco_columntitle">
							<?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $item -> product -> title), get_permalink($item -> product -> post_id)); ?>
                        </td>
						<td class="wpco_columnvariations">                                			
							<?php if (!empty($item -> styles) || !empty($item -> product -> cfields) || (!empty($item -> product -> inhonorof) && $item -> product -> inhonorof == "Y") || (!empty($item -> width) && !empty($item -> length))) : ?>
								<table class="wpco_tablevariations">
									<tbody>
                                    	<?php if (!empty($item -> product -> inhonorof) && $item -> product -> inhonorof == "Y") : ?>
                                        	<?php if (!empty($item -> iof_name)) : ?>
                                                <tr>
                                                    <th><?php _e('Your Name', $this -> plugin_name); ?></th>
                                                    <td><?php echo stripslashes($item -> iof_name); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php if (!empty($item -> iof_benname)) : ?>
                                                <tr>
                                                    <th><?php _e('Beneficiary Name', $this -> plugin_name); ?></th>
                                                    <td><?php echo stripslashes($item -> iof_benname); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    	<?php if (!empty($item -> width) && !empty($item -> length)) : ?>
                                        	<tr>
                                            	<th><?php _e('Width', $this -> plugin_name); ?></th>
                                                <td><?php echo $item -> width; ?><?php echo $item -> product -> lengthmeasurement; ?>
                                            </tr>
                                            <tr>
                                            	<th><?php _e('Length', $this -> plugin_name); ?></th>
                                                <td><?php echo $item -> length; ?><?php echo $item -> product -> lengthmeasurement; ?>
                                            </tr>
                                        <?php endif; ?>
										<?php if ($styles = maybe_unserialize($item -> styles)) : ?>
											<?php foreach ($styles as $style_id => $option_id) : ?>
												<?php $wpcoDb -> model = $Style -> model; ?>
												<?php if ($style = $wpcoDb -> find(array('id' => $style_id), array('id', 'title'))) : ?>
													<?php if (!empty($option_id) && is_array($option_id)) : ?>
														<?php $option_ids = $option_id; ?>
														<tr>
															<th><?php echo $style -> title; ?></th>
															<td>
																<?php $o = 1; ?>
																<?php foreach ($option_ids as $option_id) : ?>
																	<?php $wpcoDb -> model = $Option -> model; ?>																
																	<?php if ($option = $wpcoDb -> find(array('id' => $option_id), array('id', 'title', 'addprice', 'price', 'operator', 'symbol'), array('id', "DESC"), true)) : ?>
																		<?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($option -> price, true, true, $option -> operator) . ')' : ''; ?>
																		<?php echo ($o < count($option_ids)) ? ', ' : ''; ?>
																	<?php endif; ?>
																	<?php $o++; ?>
																<?php endforeach; ?>
															</td>
														</tr>
													<?php else : ?>
														<?php $wpcoDb -> model = $Option -> model; ?>
														<?php $option = $wpcoDb -> find(array('id' => $option_id), false, array('id', "DESC"), true, array('otheroptions' => $styles)); ?>
														<tr>
															<th><?php echo $style -> title; ?></th>
															<td><?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y" && !empty($option -> price)) ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($option -> price, true, true, $option -> operator) . ')' : ''; ?></td>
														</tr>
													<?php endif; ?>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
										<?php if (!empty($item -> product -> cfields)) : ?>
											<?php foreach ($item -> product -> cfields as $field_id) : ?>
												<?php $wpcoDb -> model = $wpcoField -> model; ?>
												<?php if ($field = $wpcoDb -> find(array('id' => $field_id))) : ?>
													<?php if (!empty($item -> {$field -> slug})) : ?>
														<tr>
															<th><?php echo $field -> title; ?><?php echo (!empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($field -> price, true, true) . ')' : ''; ?></th>
															<td>
																<?php if ($field -> type == "file") : ?>
																	<?php echo $wpcoHtml -> file_custom_field($item -> {$field -> slug}); ?>
																<?php else : ?>
																	<?php echo $wpcoField -> get_value($field_id, $item -> {$field -> slug}); ?>
																<?php endif; ?>
															</td>
														</tr>
													<?php endif; ?>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table>
							<?php else : ?>
								<?php _e('none', $this -> plugin_name); ?>
							<?php endif; ?>
						</td>
						<td class="wpco_columnprice"><?php echo $wpcoHtml -> currency_price($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true), true, true); ?></td>
						<td class="wpco_columnqty"><input class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>quantity" type="text" name="Item[count][<?php echo $item -> id; ?>]" style="width:25px;" value="<?php echo $item -> count; ?>" /></td>
						<td class="wpco_columntotal"><?php echo $wpcoHtml -> currency_price(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count), true, true); ?></td>
						<td class="wpco_columnremove"><a href="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=deleteitem&item_id=' . $item -> id); ?>" onclick="if (!confirm('<?php _e('Are you sure you want to remove this item from your shopping cart?', $this -> plugin_name); ?>')) { return false; }" class="removeproduct"><?php _e('Remove Product', $this -> plugin_name); ?></a></td>
					</tr>
					<?php $qties += $item -> count; ?>
					<?php $ptotal += $Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true); ?>
				<?php endforeach; ?>
				
				<?php $co_id = $Order -> cart_order(); ?>
				<?php $items_count = $Item -> item_count($co_id, 'items'); ?>
				<?php $units_count = $Item -> item_count($co_id, 'units'); ?>
				<?php $subtotal = $Order -> total($co_id, false, false, true, true, false, false); ?>
				<?php $discount = $Discount -> total($co_id); ?>
				<?php $tax_total = $Order -> tax_total($co_id); ?>
				<?php $shipping_total = $Order -> shipping_total($subtotal, $co_id); ?>
				<?php $total_price = $Order -> total($co_id, true, true, true, true, true, true); ?>
				
				<?php
				
				global $subtotal;
				$subtotal = false;
				$wpcoDb -> model = $wpcoShipmethod -> model;
				$shipmethod = $wpcoDb -> find(array('id' => $theorder -> shipmethod_id));
				
				?>

				<?php if (!empty($shipping_total)) : ?>				
					<?php if ($this -> get_option('shippingcalc') == "Y") : ?>
						<?php $wpcoHtml -> subtotal($co_id); ?>	
						<?php if ($this -> get_option('shippingcalc') == "Y" && !empty($shipping_total) && $shipping_total != 0) : ?>
							<tr class="total">
								<td class="wpco_totaltext" colspan="5">
									<?php _e('Shipping &amp; Handling', $this -> plugin_name); ?>
									<?php $shipmethod_name = $wpcoHtml -> shipmethod_name($theorder -> shipmethod_id, $theorder -> id); ?>
									<?php if (!empty($shipmethod_name)) : ?>
										<br/>
										<small>(<?php echo $shipmethod_name; ?>)</small>
									<?php endif; ?>
								</td>
								<td><?php echo $wpcoHtml -> currency_price($shipping_total, true, true); ?></td>
								<td>&nbsp;</td>
							</tr>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
					
				<?php if ($this -> get_option('enablecoupons') == "Y") : ?>
					<?php $wpcoHtml -> subtotal($co_id); ?>
					<?php if (!empty($discounts)) : ?>
						<?php foreach ($discounts as $discount) : ?>
							<tr class="total">
								<td class="wpco_totaltext" colspan="5"><?php echo $discount -> coupon -> title; ?> <?php echo $wpcoHtml -> link('<img src="' . $this -> url() . '/views/' . $this -> get_option('theme_folder') . '/img/delete.png" border="0" alt="delete" />', $wpcoHtml -> retainquery($this -> pre . "method=deletecoupon&amp;id=" . $discount -> id, $wpcoHtml -> cart_url()), array('onclick' => "if (!confirm('" . __('Are you sure you want to remove this discount coupon?', $this -> plugin_name) . "')) { return false; }", 'title' => __('Remove discount coupon', $this -> plugin_name))); ?></td>
								<?php /*<td nowrap="nowrap"><?php echo apply_filters($this -> pre . '_coupon_discount', (($discount -> coupon -> discount_type == "fixed") ? '-' . $wpcoHtml -> currency_price($discount -> coupon -> discount, true, true) : '-' . $discount -> coupon -> discount . '&#37;'), $discount -> coupon, $co_id, $total_price); ?></td>*/ ?>
								<td>
									<?php 
									
									$discount = $Coupon -> discount($discount -> coupon -> id, $co_id); 
									
									if (is_numeric($discount)) {
										echo '-' . $wpcoHtml -> currency_price($discount, true, true);
									} else {
										echo $discount;
									}
									
									?>
								</td>
								<td>&nbsp;</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php if ($this -> get_option('tax_calculate') == "Y" && !empty($tax_total) && $tax_total != "0.00") : ?>
                	<?php $wpcoHtml -> subtotal($co_id); ?>	
					<tr class="total">
						<td class="wpco_totaltext" colspan="5"><?php echo $this -> get_option('tax_name'); ?> (<?php echo $wpcoTax -> get_tax_percentage($Order -> do_shipping($co_id)); ?>&#37;)</td>
						<td><?php echo $wpcoHtml -> currency_price($tax_total, true, true); ?></td>
						<td>&nbsp;</td>
					</tr>
				<?php endif; ?>
				<tr class="total">
					<td class="wpco_totaltext" colspan="5"><?php _e('Total', $this -> plugin_name); ?></td>
					<td><?php echo $wpcoHtml -> currency_price($total_price, true, true); ?></td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
		
		<?php $this -> render('fields' . DS . 'global', array('order_id' => $co_id['id'], 'globalp' => "cart", 'globalerrors' => $globalerrors), true, 'default'); ?>
		<?php do_action($this -> pre . '_cart_after_global', $co_id['id']); ?>
	
		<p class="<?php echo $this -> pre; ?>submit">
			<input type="hidden" name="<?php echo $this -> pre; ?>method" value="updatecart" />			
			<input class="<?php echo $this -> pre; ?>button" style="cursor:pointer;" type="submit" name="update" value="<?php _e('Update Cart', $this -> plugin_name); ?>" onclick="if (!confirm('<?php _e('Are you sure you want to update the quantities?', $this -> plugin_name); ?>')) { return false; }" />
			<input class="<?php echo $this -> pre; ?>button" style="cursor:pointer;" type="submit" name="checkout" value="<?php _e('Checkout', $this -> plugin_name); ?> &raquo;" />
            
			<?php $tempmethod = ($this -> get_option('shippingdetails') == "Y") ? 'shipping' : 'billing'; ?>
			<?php global $user_ID; ?>
			<?php $method = ($user_ID) ? $tempmethod : 'contacts'; ?>
		</p>
	</form>
	
	<p>
		<ul class="wpco_list">
			<?php if ($this -> get_option('cart_continuelink') == "Y") : ?>
				<li><?php echo $wpcoHtml -> link(__('Continue Shopping', $this -> plugin_name) . ' &raquo;', $this -> get_option('shopurl')); ?></li>
			<?php endif; ?>
			<li><?php echo $wpcoHtml -> link(__('Empty Shopping Cart', $this -> plugin_name) . ' &raquo;', $wpcoHtml -> retainquery("wpcomethod=cart&empty=1", $wpcoHtml -> cart_url()), array('onclick' => "if (!confirm('" . __('Are you sure you wish to empty your shopping cart?', $this -> plugin_name) . "')) { return false; }")); ?></li>
		</ul>
	</p>
	
	<?php $wpcoDb -> model = $Coupon -> model; ?>
	<?php $couponscount = $wpcoDb -> count(); ?>
	<?php if ($this -> get_option('enablecoupons') == "Y" && !empty($couponscount)) : ?>
		<?php $wpcoDb -> model = $Discount -> model; ?>
		<?php $dcount = $wpcoDb -> count(array($co_id['type'] . '_id' => $co_id['id'])); ?>
		<?php if ($this -> get_option('multicoupon') == "Y" || (empty($dcount) && $this -> get_option('multicoupon') == "N")) : ?>
			<?php $this -> render('couponform', false, true, 'default'); ?>
		<?php endif; ?>
	<?php endif; ?>
<?php else : ?>
	<div class="<?php echo $this -> pre; ?>error"><?php _e('There are no items in your shopping cart, please add some.', $this -> plugin_name); ?></div>
	<?php $empty = true; ?>
<?php endif; ?>

<?php global $user_ID; ?>
<?php if ($user_ID) : ?>
	<?php $wpcoDb -> model = $Order -> model; ?>
	<?php $orderscount = $wpcoDb -> count(array('completed' => "Y", 'user_id' => $user_ID)); ?>
	<?php $hasorders = (!empty($orderscount)) ? true : false; ?>
<?php endif; ?>

<?php if ($this -> has_downloads() || $hasorders == true) : ?>
	<br/>
	<ul class="wpco_list">
		<?php if ($empty) : ?>
			<li><?php echo $wpcoHtml -> link(__('Continue Shopping', $this -> plugin_name) . ' &raquo;', $this -> get_option('shopurl')); ?></li>
		<?php endif; ?>
		<?php if ($this -> has_downloads()) : ?>
			<li><a href="<?php echo $wpcoHtml -> downloads_url(); ?>" title="<?php _e('View all your downloads', $this -> plugin_name); ?>"><?php _e('Downloads Management', $this -> plugin_name); ?></a></li>
		<?php endif; ?>
		<?php if ($hasorders == true) : ?>
			<li><a href="<?php echo $wpcoHtml -> account_url(); ?>" title="<?php _e('View your complete orders history', $this -> plugin_name); ?>"><?php _e('Orders History', $this -> plugin_name); ?></a></li>
		<?php endif; ?>
	</ul>
<?php endif; ?>