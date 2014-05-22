<div class="wrap">
	<h2><?php _e('View Order #', $this -> plugin_name); ?><?php echo $order -> id; ?></h2>
	
	<div style="float:none;" class="subsubsub"><?php echo $wpcoHtml -> link(__('&larr; All Orders', $this -> plugin_name), $this -> url); ?></div>

	<?php if (!empty($order)) : ?>	
		<?php $user = $this -> userdata($order -> user_id); ?>
		<div class="tablenav">
			<div class="alignleft actions">
            	<a onclick="if (!confirm('<?php _e('Are you sure you want to send this customer an invoice via email?', $this -> plugin_name); ?>')) { return false; }" href="?page=<?php echo $this -> sections -> orders; ?>&amp;method=invoice&amp;id=<?php echo $order -> id; ?>" title="<?php _e('Send an invoice to the customer', $this -> plugin_name); ?>" class="button"><?php _e('Send Invoice', $this -> plugin_name); ?></a>
                <?php if ($this -> get_option('invoice_enablepdf') == "Y") : ?><a href="<?php echo home_url(); ?>/?<?php echo $this -> pre; ?>method=pdfinvoice&amp;id=<?php echo $order -> id; ?>" title="<?php _e('Save a PDF of this invoice', $this -> plugin_name); ?>" class="button"><?php _e('Save PDF', $this -> plugin_name); ?></a><?php endif; ?>
				<a href="?page=<?php echo $this -> sections -> orders; ?>&amp;method=save&amp;id=<?php echo $order -> id; ?>" title="<?php _e('Change the details of this order', $this -> plugin_name); ?>" class="button"><?php _e('Change', $this -> plugin_name); ?></a>
				<a href="?page=<?php echo $this -> sections -> orders; ?>&amp;method=delete&amp;id=<?php echo $order -> id; ?>" title="<?php _e('Remove this order and all order items', $this -> plugin_name); ?>" class="button button-highlighted" onclick="if (!confirm('<?php _e('Are you sure you wish to remove this order and all order items?', $this -> plugin_name); ?>')) { return false; }"><?php _e('Delete', $this -> plugin_name); ?></a>
			</div>
		</div>		
		<table class="widefat">
			<thead>
				<tr>
					<th><?php _e('Field', $this -> plugin_name); ?></th>
					<th><?php _e('Value', $this -> plugin_name); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php $class = ''; ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th style="width:40%;"><?php _e('User', $this -> plugin_name); ?></th>
					<td>
						<?php if (!empty($order -> user_id)) : ?>
							<?php echo $wpcoHtml -> link($order -> bill_fname . ' ' . $order -> bill_lname, site_url() . "/wp-admin/user-edit.php?user_id=" . $order -> user_id); ?>
						<?php else : ?>
							<?php echo $order -> bill_fname . ' ' . $order -> bill_lname; ?>
						<?php endif; ?>
                        <small>(<?php echo $wpcoHtml -> link(((empty($order -> bill_email)) ? $user -> user_email : $order -> bill_email), 'mailto:' . $order -> bill_email . '?subject=' . get_bloginfo('name') . ': ' . __('Order &#35;', $this -> plugin_name) . $order -> id); ?>)</small>
                    </td>
				</tr>
                <?php if ($this -> get_option('shippingdetails') == "Y" && $order -> shipped != "N/A") : ?>
                    <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
                        <th><?php _e('Shipping Details', $this -> plugin_name); ?></th>
                        <td>
                        	<a href="" onclick="jQuery('#shippingdetails').slideToggle(); return false;"><?php _e('Show/Hide Shipping Details', $this -> plugin_name); ?></a>
                        	<div id="shippingdetails" style="display:none;">
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
                                        <tr>
                                            <th><?php _e('Email Address', $this -> plugin_name); ?> :</th>
                                            <td><?php echo $order -> ship_email; ?></td>
                                        </tr>
                                        <?php if (!empty($user -> ship_company)) : ?>
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
                        	</div>
                        </td>
                    </tr>
				<?php endif; ?>
                <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
                	<th><?php _e('Billing Details', $this -> plugin_name); ?></th>
                    <td>
                    	<a href="" onclick="jQuery('#billingdetails').slideToggle(); return false;"><?php _e('Show/Hide Billing Details', $this -> plugin_name); ?></a>
                    	<div id="billingdetails" style="display:none;">
                            <table>
                                <tbody>
                                    <tr>
                                        <th><?php _e('Payment Method', $this -> plugin_name); ?></th>
                                        <td>
                                            <?php echo $wpcoHtml -> pmethod($order -> pmethod); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php _e('First Name', $this -> plugin_name); ?> :</th>
                                        <td><?php echo $order -> bill_fname; ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _e('Last Name', $this -> plugin_name); ?> :</th>
                                        <td><?php echo $order -> bill_lname; ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php _e('Email Address', $this -> plugin_name); ?> :</th>
                                        <td><?php echo $order -> bill_email; ?></td>
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
                        </div>
                    </td>
                </tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Payment Method', $this -> plugin_name); ?></th>
					<td>
						<?php if (!empty($order -> pmethod)) : ?>
							<?php echo $wpcoHtml -> pmethod($order -> pmethod); ?> <?php echo (!empty($order -> pmethod) && $order -> pmethod == "cc") ? ' (' . $wpcoHtml -> link(__('view credit card details', $this -> plugin_name), "#void", array('onclick' => "jQuery('#wpcocarddetailsdiv').toggle();")) . ')' : ''; ?>
						<?php else : ?>
							<span class="<?php echo $this -> pre; ?>error"><?php _e('No payment method was specified', $this -> plugin_name); ?></span>
						<?php endif; ?>

                        <?php if (!empty($order -> pmethod) && $order -> pmethod == "cc") : ?>
                            <a class="button-secondary button-highlighted" href="<?php echo $this -> url; ?>&amp;method=delete-cc&amp;id=<?php echo $order -> id; ?>&amp;user_id=<?php echo $order -> user_id; ?>" title="<?php _e('Delete credit card details of this customer', $this -> plugin_name); ?>" onclick="if (!confirm('<?php _e('Are you sure you wish to remove all credit card details for this customer globally? It will affect billing details stored for other orders by this customer as well.', $this -> plugin_name); ?>')) { return false; }"><?php _e('Delete CC Details', $this -> plugin_name); ?></a>
                        <?php endif; ?>
					</td>
				</tr>
			</tbody>
		</table>
				
		<?php if (!empty($order -> pmethod) && $order -> pmethod == "cc") : ?>
			<?php $cardnumber = $wpcoHtml -> cardnumber($order -> cc_number); ?>
			
			<div id="<?php echo $this -> pre; ?>carddetailsdiv" style="display:none;">
				<table style="border-top:none; border-bottom:none;" class="widefat">
					<tbody>
						<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
							<th style="width:40%;"><?php _e('Name on Card', $this -> plugin_name); ?></th>
							<td><?php echo $order -> cc_name; ?></td>
						</tr>
						<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
							<th><?php _e('Card Type', $this -> plugin_name); ?></th>
							<td>
								<?php $cctypes = $this -> get_option('cctypes'); ?>
								<?php echo $cctypes[$order -> cc_type]; ?>
							</td>
						</tr>
						<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
							<th><?php _e('Card Number', $this -> plugin_name); ?></th>
							<td>
								<?php echo $cardnumber[1]; ?>
								<small>(<?php _e('the last 4 digits were sent via email', $this -> plugin_name); ?>)</small>
							</td>
						</tr>
						<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
							<th><?php _e('Expiry Date', $this -> plugin_name); ?></th>
							<td><?php echo $order -> cc_exp_m; ?>/<?php echo $order -> cc_exp_y; ?> (<?php _e('mm/yy', $this -> plugin_name); ?>)</td>
						</tr>
						<?php if (!empty($order -> cc_cvv) && $this -> get_option('billcvv') == "Y") : ?>
							<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
								<th><?php _e('Security Code (CVV)', $this -> plugin_name); ?></th>
								<td><?php echo $order -> cc_cvv; ?></td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
				
		<table class="widefat" style="border-top:none;">
			<tfoot>
				<tr>
					<th><?php _e('Field', $this -> plugin_name); ?></th>
					<th><?php _e('Value', $this -> plugin_name); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php if (!empty($order -> cfields)) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th><?php _e('Order Options', $this -> plugin_name); ?></th>
						<td>
							<?php foreach ($order -> cfields as $ofield) : ?>
								<?php $wpcoDb -> model = $wpcoField -> model; ?>
								<?php if ($field = $wpcoDb -> find(array('id' => $ofield -> field_id))) : ?>
									<div><strong><?php echo $field -> title; ?><?php echo (!empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) ? ' (' . $wpcoHtml -> currency_price($field -> price) . ')' : ''; ?>:</strong> <?php echo $wpcoField -> get_value($field -> id, $ofield -> value); ?></div>
								<?php endif; ?>
							<?php endforeach; ?>
						</td>
					</tr>
				<?php endif; ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th style="width:40%;"><?php _e('Completed', $this -> plugin_name); ?></th>
					<td><?php echo (!empty($order -> completed) && $order -> completed == "Y") ? '<span style="color:green;">' . __('Yes', $this -> plugin_name) : '<span style="color:red;">' . __('No', $this -> plugin_name); ?></span></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Paid', $this -> plugin_name); ?></th>
					<td><?php echo (!empty($order -> paid) && $order -> paid == "Y") ? '<span style="font-weight:bold; color:green;">' . __('Yes', $this -> plugin_name) : '<span style="font-weight:bold; color:red;">' . __('No', $this -> plugin_name); ?></span></td>
				</tr>
				<?php if (!empty($order -> shipping) || !empty($order -> discount)) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th><?php _e('Shipped', $this -> plugin_name); ?></th>
						<td>
                        	<?php if (!empty($order -> shipped) && $order -> shipped == "N/A") : ?>
                            	<?php echo $order -> shipped; ?>
                            <?php else : ?>
								<?php echo (!empty($order -> shipped) && $order -> shipped == "Y") ? '<span style="color:green;">' . __('Yes', $this -> plugin_name) : '<span style="color:red;">' . __('No', $this -> plugin_name); ?></span>
                                <?php if (empty($order -> shipped) || $order -> shipped == "N") : ?>
                                    <small>(<?php echo $wpcoHtml -> link(__('Mark as shipped', $this -> plugin_name), '?page=' . $this -> sections -> orders . '&amp;method=markasshipped&amp;order_id=' . $order -> id); ?>)</small>
                                <?php else : ?>
                                    <small>(<?php echo $wpcoHtml -> link(__('Mark as NOT shipped', $this -> plugin_name), '?page=' . $this -> sections -> orders . '&amp;method=markasnotshipped&amp;order_id=' . $order -> id); ?>)</small>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
					</tr>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th><?php _e('Sub Total', $this -> plugin_name); ?></th>
						<td>
                        	<?php $subtotal = $order -> subtotal; ?>
							<?php echo $wpcoHtml -> currency_price($order -> subtotal); ?>
                        </td>
					</tr>
					<?php if (!empty($order -> discount) && $order -> discount != 0 && $order -> discount != "0.00") : ?>
						<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
							<th><?php _e('Discount Applied', $this -> plugin_name); ?></th>
							<td>
								- <?php echo $wpcoHtml -> currency_price($order -> discount); ?>
								(<?php echo $Discount -> coupons_by_order($order -> id); ?>)	
							</td>
						</tr>
					<?php endif; ?>
					<?php if ($order -> shipped == "Y" || $order -> shipped == "N") : ?>
						<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
							<th><?php _e('Shipping Total', $this -> plugin_name); ?></th>
							<td>
								<?php echo $wpcoHtml -> currency_price($order -> shipping); ?>
                                <?php if (!empty($order -> shipmethod_name)) : ?>
                                	(<?php echo $order -> shipmethod_name; ?>)
                                    <?php if (!empty($order -> cu_shipmethod)) : ?><br/><small><?php echo $order -> cu_shipmethod; ?></small><?php endif; ?>
                                <?php endif; ?>
                            </td>
						</tr>
                        
                        <?php if ($cp_shipmethod = $wpcoShipmethod -> get_canadapost_shipmethod($order, $items)) : ?>
							<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
                            	<th><?php _e('Canada Post Shipping Method', $this -> plugin_name); ?></th>
                                <td>
                                	<table>
                                    	<tbody>
                                        	<tr>
                                            	<th><?php _e('Name', $this -> plugin_name); ?></th>
                                                <td><?php echo $cp_shipmethod['name']; ?></td>
                                            </tr>
                                            <tr>
                                            	<th><?php _e('Rate/Price (CAD&#36;)', $this -> plugin_name); ?></th>
                                                <td><?php echo $cp_shipmethod['rate']; ?></td>
                                            </tr>
                                            <tr>
                                            	<th><?php _e('Shipping Date', $this -> plugin_name); ?></th>
                                                <td><?php echo $cp_shipmethod['shippingDate']; ?></td>
                                            </tr>
                                            <tr>
                                            	<th><?php _e('Delivery Date', $this -> plugin_name); ?></th>
                                                <td><?php echo $cp_shipmethod['deliveryDate']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
                
                <?php if (!empty($order -> shiptrack)) : ?>
                	<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
                    	<th><?php _e('Shipping Tracking', $this -> plugin_name); ?></th>
                        <td>                            
                            <?php
							
							$wpcoDb -> model = $wpcoShipmethod -> model;
							if ($shipmethod = $wpcoDb -> find(array('id' => $order -> shipmethod_id))) {
								if (!empty($shipmethod -> api) && $shipmethod -> api == "fedex") {
									$api_options = maybe_unserialize($shipmethod -> api_options);
																	
									$fedex = $this -> vendor("fedex", "shipping" . DS . "fedex" . DS);
									$fedex -> setAccountNumber($api_options['AccountNumber']);
									$fedex -> setMeterNumber($api_options['MeterNumber']);
									$fedex -> setCarrierCode($api_options['CarrierCode']);
									$fedex -> setTrackingCode($order -> shiptrack);
									$tracklinkurl = $fedex -> trackLinkURL();
									
									echo __('Tracking Number:', $this -> plugin_name) . ' <strong><a href="' . $tracklinkurl . '" target="_blank">' . $order -> shiptrack . '</a></strong>';
								} else {
									echo __('Tracking Number:', $this -> plugin_name) . ' <strong>' . $order -> shiptrack . '</strong>';	
								}
							}
							
							?>
                        </td>
                    </tr>
                <?php endif; ?>
				
                <?php if (!empty($order -> tax)) : ?>
                    <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
                    	<th><?php _e('Tax', $this -> plugin_name); ?> (<?php echo $order -> tax_percentage; ?>&#37;)</th>
                        <td>
                        	<?php echo $wpcoHtml -> currency_price($order -> tax); ?>
                        </td>
                    </tr>
                <?php endif; ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Total', $this -> plugin_name); ?></th>
					<td><b><?php echo $wpcoHtml -> currency_price($order -> total); ?></b></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Created', $this -> plugin_name); ?></th>
					<td><?php echo $order -> created; ?></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Modified', $this -> plugin_name); ?></th>
					<td><?php echo $order -> modified; ?></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Completed Date', $this -> plugin_name); ?></th>
					<td><?php echo $order -> completed_date; ?></td>
				</tr>
			</tbody>
		</table>
	<?php endif; ?>
	
	<h3><?php _e('Order Items', $this -> plugin_name); ?> <?php echo $wpcoHtml -> link(__('Add Item', $this -> plugin_name), '?page=' . $this -> sections -> items . '&method=save&order_id=' . $order -> id, array('class' => "button add-new-h2")); ?></h3>
	<?php $this -> render('items' . DS . 'loop', array('items' => $items, 'paginate' => $paginate), true, 'admin'); ?>
</div>