<?php $theorder = $order; ?>
<?php _e('Good day', $this -> plugin_name); ?> <?php echo $order -> first_name; ?> <?php echo $order -> last_name; ?>,

<?php _e('Thank you for placing your order', $this -> plugin_name); ?>.
<?php _e('Below are the full details of your order', $this -> plugin_name); ?>.
<?php if (!empty($touser) && $touser == true) : ?><?php _e('Alternatively, you can view the full details of this order online', $this -> plugin_name); ?> : <?php echo $wpcoHtml -> link(__("Order", $this -> plugin_name) . ' ' . $order -> id, get_option('home') . '?' . $this -> pre . 'method=order&amp;id=' . $order -> id); ?><?php endif; ?>

<table>
	<tbody>
    	<tr>
        	<th><?php _e('Invoice #', $this -> plugin_name); ?> :</th>
            <td><?php echo $order -> id; ?></td>
        </tr>
        <tr>
        	<th><?php _e('Customer Email', $this -> plugin_name); ?> :</th>
            <td><?php echo $order -> bill_email; ?></td>
        </tr>
    </tbody>
</table>

<?php if ($this -> get_option('shippingdetails') == "Y") : ?>
	<h3><?php _e('Shipping Details', $this -> plugin_name); ?></h3>
	
	<table>
		<tbody>
			<tr>
				<th><?php _e('First Name', $this -> plugin_name); ?> :</th>
				<td><?php echo $order -> ship_fname; ?></td>
			</tr>
			<tr>
				<th><?php _e('Last Name', $this -> plugin_name); ?> :</th>
				<td><?php echo $order -> ship_lname; ?></td>
			</tr>
            <?php if (!empty($order -> ship_company)) : ?>
            	<tr>
                	<th><?php _e('Company Name', $this -> plugin_name); ?> :</th>
                    <td><?php echo $order -> ship_company; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
            	<th><?php _e('Phone Number', $this -> plugin_name); ?> :</th>
                <td><?php echo $order -> ship_phone; ?></td>
            </tr>
            <?php if (!empty($order -> ship_fax)) : ?>
            	<tr>
                	<th><?php _e('Fax Number', $this -> plugin_name); ?> :</th>
                    <td><?php echo $order -> ship_fax; ?></td>
                </tr>
            <?php endif; ?>
			<tr>
				<th><?php _e('Address', $this -> plugin_name); ?> :</th>
				<td><?php echo $order -> ship_address; ?></td>
			</tr>
            <?php if (!empty($order -> ship_address2)) : ?>
            	<tr>
                	<th><?php _e('Address (continued)', $this -> plugin_name); ?> :</th>
                    <td><?php echo $order -> ship_address2; ?></td>
                </tr>
            <?php endif; ?>
			<tr>
				<th><?php _e('City', $this -> plugin_name); ?> :</th>
				<td><?php echo $order -> ship_city; ?></td>
			</tr>
			<tr>
				<th><?php _e('State', $this -> plugin_name); ?> :</th>
				<td><?php echo $order -> ship_state; ?></td>
			</tr>
			<tr>
				<th><?php _e('Country', $this -> plugin_name); ?> :</th>
				<td>
					<?php $wpcoDb -> model = $Country -> model; ?>
					<?php echo $wpcoDb -> field('value', array('id' => $order -> ship_country)); ?>
				</td>
			</tr>
			<tr>
				<th><?php _e('Zip Code', $this -> plugin_name); ?> :</th>
				<td><?php echo $order -> ship_zipcode; ?></td>
			</tr>
		</tbody>
	</table>
<?php endif; ?>

<h3><?php _e('Billing Details', $this -> plugin_name); ?></h3>
<table>
	<tbody>
		<tr>
			<th><?php _e('Payment Method', $this -> plugin_name); ?></th>
			<td><?php echo $wpcoHtml -> pmethod($order -> pmethod); ?></td>
		</tr>
		<?php if (!empty($order -> pmethod) && $order -> pmethod == "cc") : ?>
			<tr>
				<th style="width:40%;"><?php _e('Name on Card', $this -> plugin_name); ?></th>
				<td><?php echo $order -> cc_name; ?></td>
			</tr>
			<tr>
				<th><?php _e('Card Type', $this -> plugin_name); ?></th>
				<td>
					<?php $cctypes = $this -> get_option('cctypes'); ?>
					<?php echo $cctypes[$order -> cc_type]; ?>
				</td>
			</tr>
			<tr>
				<th><?php _e('Card Number', $this -> plugin_name); ?></th>
				<td>
					<?php $cardnumber = $wpcoHtml -> cardnumber($order -> cc_number); ?>
					<?php echo $cardnumber[2]; ?>
				</td>
			</tr>
			<tr>
				<th><?php _e('Expiry Date', $this -> plugin_name); ?></th>
				<td><?php echo $order -> cc_exp_m; ?>/<?php echo $order -> cc_exp_y; ?> (<?php _e('mm/yy', $this -> plugin_name); ?>)</td>
			</tr>
			<?php if (!empty($order -> cc_cvv) && $this -> get_option('billcvv') == "Y") : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Security Code (CVV)', $this -> plugin_name); ?></th>
					<td><?php echo $order -> cc_cvv; ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>
		<tr>
			<th><?php _e('First Name', $this -> plugin_name); ?> :</th>
			<td><?php echo $order -> bill_fname; ?></td>
		</tr>
		<tr>
			<th><?php _e('Last Name', $this -> plugin_name); ?> :</th>
			<td><?php echo $order -> bill_lname; ?></td>
		</tr>
        <?php if (!empty($order -> bill_company)) : ?>
            	<tr>
                	<th><?php _e('Company Name', $this -> plugin_name); ?> :</th>
                    <td><?php echo $order -> bill_company; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
            	<th><?php _e('Phone Number', $this -> plugin_name); ?> :</th>
                <td><?php echo $order -> bill_phone; ?></td>
            </tr>
            <?php if (!empty($order -> bill_fax)) : ?>
            	<tr>
                	<th><?php _e('Fax Number', $this -> plugin_name); ?> :</th>
                    <td><?php echo $order -> bill_fax; ?></td>
                </tr>
            <?php endif; ?>
		<tr>
			<th><?php _e('Address', $this -> plugin_name); ?> :</th>
			<td><?php echo $order -> bill_address; ?></td>
		</tr>
        <?php if (!empty($order -> bill_address2)) : ?>
            <tr>
                <th><?php _e('Address (continued)', $this -> plugin_name); ?> :</th>
                <td><?php echo $order -> bill_address2; ?></td>
            </tr>
        <?php endif; ?>
		<tr>
			<th><?php _e('City', $this -> plugin_name); ?> :</th>
			<td><?php echo $order -> bill_city; ?></td>
		</tr>
		<tr>
			<th><?php _e('State', $this -> plugin_name); ?> :</th>
			<td><?php echo $order -> bill_state; ?></td>
		</tr>
		<tr>
			<th><?php _e('Country', $this -> plugin_name); ?> :</th>
			<td>
				<?php $wpcoDb -> model = $Country -> model; ?>
				<?php echo $wpcoDb -> field('value', array('id' => $order -> bill_country)); ?>
			</td>
		</tr>
		<tr>
			<th><?php _e('Zip Code', $this -> plugin_name); ?> :</th>
			<td><?php echo $order -> bill_zipcode; ?></td>
		</tr>
	</tbody>
</table>

<?php if (!empty($order -> pmethod) && $order -> pmethod == "cu") : ?>
    <?php if ($cu_fields = maybe_unserialize($this -> get_option('cu_fields'))) : ?>
    	<h3><?php _e('Custom Fields', $this -> plugin_name); ?></h3>
        
        <table>
        	<thead>
            	<?php foreach ($cu_fields as $cu_field_id) : ?>
                	<?php $wpcoDb -> model = $wpcoField -> model; ?>
                    <?php if ($cu_field = $wpcoDb -> find(array('id' => $cu_field_id))) : ?>
                        <tr>
                            <th><?php echo $cu_field -> title; ?>: </th>
                            <td>
                            	<?php echo esc_attr(stripslashes($_POST['Item']['fields'][$cu_field_id])); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </thead>
        </table>
    <?php endif; ?>
<?php endif; ?>

<?php if (!empty($items)) : ?>
	<h3><?php _e('Order Items', $this -> plugin_name); ?></h3>
	
	<table>
		<thead>
			<tr>
				<th><?php _e('Product', $this -> plugin_name); ?></th>
				<th><?php _e('Options', $this -> plugin_name); ?></th>
				<th><?php _e('Price', $this -> plugin_name); ?></th>
				<th><?php _e('Qty', $this -> plugin_name); ?></th>
				<th><?php _e('Total', $this -> plugin_name); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php $qties = 0; ?>
			<?php $ptotal = 0; ?>
			<?php foreach ($items as $item) : ?>
			<tr>
				<td><?php echo apply_filters($this -> pre . '_product_title', $item -> product -> title); ?></td>
				<td>
					<?php if (!empty($item -> styles) || !empty($item -> product -> cfields)) : ?>
						<table>
							<tbody>
								<?php if ($styles = maybe_unserialize($item -> styles)) : ?>
									<?php foreach ($styles as $style_id => $option_id) : ?>
										<?php $wpcoDb -> model = $Style -> model; $style = $wpcoDb -> find(array('id' => $style_id)); ?>
										<?php $wpcoDb -> model = $Option -> model; $option = $wpcoDb -> find(array('id' => $option_id)); ?>
										<tr>
											<th><?php echo $style -> title; ?></th>
											<td><?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y" && !empty($option -> price)) ? ' (' . $wpcoHtml -> currency_price($option -> price) . ')' : ''; ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								
								<?php if (!empty($item -> product -> cfields)) : ?>
									<?php foreach ($item -> product -> cfields as $field_id) : ?>
										<?php $wpcoDb -> model = 'wpcoField'; ?>
										<?php if ($field = $wpcoDb -> find(array('id' => $field_id))) : ?>
											<?php if (!empty($item -> {$field -> slug})) : ?>
											<tr>
												<th><?php echo $field -> title; ?><?php echo (!empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) ? ' (' . $wpcoHtml -> currency_price($field -> price) . ')' : ''; ?></th>
												<td><?php echo $wpcoField -> get_value($field_id, $item -> {$field -> slug}); ?></td>
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
				<td><?php echo $wpcoHtml -> currency_price($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true)); ?></td>
				<td><?php echo $item -> count; ?></td>
				<td><?php echo $wpcoHtml -> currency_price(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count)); ?></td>
			</tr>
				<?php $qties += $item -> count; ?>
				<?php $ptotal += $Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true); ?>
			<?php endforeach; ?>
			
			<?php $order_id = $order -> id; ?>
			<?php $items_count = $Item -> item_count($order_id, 'items'); ?>
			<?php $units_count = $Item -> item_count($order_id, 'units'); ?>
			<?php $subtotal = number_format($Order -> total($order_id, false, false, true, true, false, false), 2, '.', ''); ?>
			<?php $tax_total = $Order -> tax_total($order_id); ?>
			<?php $discount = number_format($Discount -> total($order_id), 2, '.', ''); ?>
			<?php $shipping_total = number_format($Order -> shipping_total($subtotal, $order_id), 2, '.', ''); ?>
			<?php $total_price = number_format($Order -> total($order_id, true, true), 2, '.', ''); ?>
			
			<?php
			
			global $subtotal;
			$subtotal = false;
			$wpcoDb -> model = $wpcoShipmethod -> model;
			$shipmethod = $wpcoDb -> find(array('id' => $theorder -> shipmethod_id));
			
			?>

			<?php if (!empty($shipping_total)) : ?>				
				<?php if ($this -> get_option('shippingcalc') == "Y") : ?>
					<?php $wpcoHtml -> subtotal($order_id, $order_email = true); ?>	
					<?php if ($this -> get_option('shippingcalc') == "Y" && !empty($shipping_total) && $shipping_total != 0) : ?>
						<tr class="total">
							<td>
								<?php _e('Shipping', $this -> plugin_name); ?><br/>
								<small>(<?php echo $shipmethod -> name; ?>)</small>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td><?php echo $wpcoHtml -> currency_price($shipping_total); ?></td>
							<td></td>
						</tr>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
				
			<?php if ($this -> get_option('enablecoupons') == "Y") : ?>
				<?php if (!empty($discount)) : ?>
					<?php $wpcoHtml -> subtotal(); ?>
                    <tr class="total">
                        <td><?php _e('Discount', $this -> plugin_name); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td nowrap="nowrap">- <?php echo $wpcoHtml -> currency_price($discount); ?></td>
                        <td></td>
                    </tr>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ($this -> get_option('tax_calculate') == "Y" && !empty($tax_total)) : ?>
				<tr class="total">
					<td><?php echo $this -> get_option('tax_name'); ?> (<?php echo $wpcoTax -> get_tax_percentage($Order -> do_shipping($order_id)); ?>&#37;)</td>
					<td></td>
					<td></td>
					<td></td>
					<td><?php echo $wpcoHtml -> currency_price($tax_total); ?></td>
					<td></td>
				</tr>
			<?php endif; ?>	
			<tr class="total">
				<td><?php _e('Total', $this -> plugin_name); ?></td>
				<td></td>
				<td><?php /*echo $wpcoHtml -> currency(); ?><?php echo number_format($ptotal, 2, '.', '');*/ ?></td>
				<td><?php echo $qties; ?></td>
				<td><?php echo $wpcoHtml -> currency_price($total_price); ?></td>
				<td></td>
			</tr>
		</tbody>
	</table>
<?php endif; ?>

<?php _e('All the best', $this -> plugin_name); ?>,
<?php echo get_option('blogname'); ?> <?php _e('Management', $this -> plugin_name); ?>