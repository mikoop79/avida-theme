<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Save an Order', $this -> plugin_name); ?></h2>
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post">
		<?php echo $wpcoForm -> hidden('Order.id'); ?>
        <?php echo $wpcoForm -> hidden('Order.user'); ?>
        <?php echo $wpcoForm -> hidden('Order.cp_shipmethod'); ?>
        <?php echo $wpcoForm -> hidden('Order.cu_shipmethod'); ?>
        <?php echo $wpcoForm -> hidden('Order.buynow'); ?>
        <?php echo $wpcoForm -> hidden('Order.gc_order_id'); ?>
        <?php echo $wpcoForm -> hidden('Order.shipmethod_name'); ?>
        <?php echo $wpcoForm -> hidden('Order.subtotal'); ?>
        <?php echo $wpcoForm -> hidden('Order.created'); ?>
		
		<h3><?php _e('General Order Details', $this -> plugin_name); ?></h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Order.user_id"><?php _e('User', $this -> plugin_name); ?></label></th>
					<td>
						<input type="text" class="widefat" style="width:65px;" name="Order[user_id]" value="<?php echo $wpcoHtml -> field_value('Order.user_id'); ?>" id="Order.user_id" />
						<span class="howto"><?php _e('User ID if applicable', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="Order.completedY"><?php _e('Completed', $this -> plugin_name); ?></label></th>
					<td>
						<?php $completed = array('Y' => __('Yes', $this -> plugin_name), 'N' => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Order.completed', $completed, array('separator' => false)); ?>
					</td>
				</tr>
				<tr>
					<th><label for="Order.paidN"><?php _e('Paid', $this -> plugin_name); ?></label></th>
					<td>
						<?php $paid = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Order.paid', $paid, array('separator' => false)); ?>
					</td>
				</tr>
                <tr>
                	<th><label for="Order.shipmethod_id"><?php _e('Shipping Method', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
                    	<?php if ($shipmethods = $wpcoDb -> find_all()) : ?>
                        	<select name="Order[shipmethod_id]" id="Order.shipmethod_id">
                            	<option value=""><?php _e('- None -', $this -> plugin_name); ?></option>
                            	<?php foreach ($shipmethods as $shipmethod) : ?>
                                	<option <?php echo (!empty($Order -> data -> shipmethod_id) && $Order -> data -> shipmethod_id == $shipmethod -> id) ? 'selected="selected"' : ''; ?> value="<?php echo $shipmethod -> id; ?>"><?php echo $shipmethod -> name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                	<th><label for="Order.shiptrack"><?php _e('Shipping Tracking Number', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php echo $wpcoForm -> text('Order.shiptrack', array('width' => "150px")); ?>
                    	<span class="howto"><?php _e('Optional. Fill in a FedEx tracking number into this field for tracking information', $this -> plugin_name); ?></span>
                    </td>
                </tr>
                <tr>
                	<th><label for="Order.shipping"><?php _e('Shipping Price', $this -> plugin_name); ?></label></th>
                    <td>
                    
                    	<?php echo $wpcoHtml -> currency_html($wpcoForm -> text('Order.shipping', array('width' => "100px"))); ?>
                    </td>
                </tr>
				<tr>
					<th><label for="Order.shippedN"><?php _e('Shipped', $this -> plugin_name); ?></label></th>
					<td>
						<?php $shipped = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Order.shipped', $shipped, array('separator' => false)); ?>
					</td>
				</tr>
				<tr>
					<th><label for="Order.pmethod"><?php _e('Payment Method', $this -> plugin_name); ?></label></th>
					<td>
					<?php $paymentmethods = get_option('wpcopaymentmethods'); ?>
						<select style="max-width:200px;" name="Order[pmethod]" id="Order.pmethod">
							<option value=""><?php _e('Select', $this -> plugin_name); ?></option>
						<?php
							foreach($paymentmethods as $v) {
								if($wpcoHtml -> pmethod($Order-> pmethod) == $v || $Order -> data -> pmethod == $v){ 
									echo '<option value="'.$v.'" selected>'.$wpcoHtml -> pmethod($v).'</option>';
								} else {
									echo '<option value="'.$v.'">'.$wpcoHtml -> pmethod($v).'</option>';
								}
							}
						?>
						</select>
						<span class="howto"><?php _e('When editing an existing order, it is recommended that you leave this value intact.', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<?php /*
                <tr>
                	<th><label for="Order.tax_percentage"><?php _e('Tax Percentage', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php echo $wpcoForm -> text('Order.tax_percentage', array('width' => "65px")); ?>&#37;
                    	<span class="howto"><?php _e('Specify tax percentage', $this -> plugin_name); ?></span>
                    </td>
                </tr>
                */ ?>
                <tr>
                	<th><label for="Order.tax"><?php _e('Tax', $this -> plugin_name); ?></label></th>
                	<td>
                		<?php echo $wpcoHtml -> currency_html($wpcoForm -> text('Order.tax', array('width' => "100px"))); ?>
                		<span class="howto"><?php _e('Specify the tax amount.', $this -> plugin_name); ?></span>
                	</td>
                </tr>
                <tr>
                	<th><label for="Order.discount"><?php _e('Discount', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php echo $wpcoHtml -> currency_html($wpcoForm -> text('Order.discount', array('width' => "100px"))); ?>
                    </td>
                </tr>
                <tr>
                	<th><label for="Order.total"><?php _e('Total Price', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php echo $wpcoHtml -> currency_html($wpcoForm -> text('Order.total', array('width' => "100px"))); ?>
                        <span class="howto"><?php _e('Total price for this order as a whole.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            </tbody>
		</table>
		
		<?php if ($paymentfields = $this -> get_option('paymentfields')) : ?>
			<?php if ($Order -> do_shipping($Order -> data -> id)) : ?>
				<h3><?php _e('Shipping Details', $this -> plugin_name); ?></h3>
				<table class="form-table">
					<tbody>
						<?php foreach ($paymentfields['shipping'] as $bkey => $shippingfield) : ?>
							<?php if ($bkey == "country") : ?>
	                            <tr>
	                                <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo __($shippingfield['title']); ?></label></th>
	                                <td>
	                                    <?php $countries = $Country -> select($domarkets = true); ?>
	                                    <select id="<?php echo $this -> pre; ?>country" name="Order[ship_country]">
	                                        <option value=""><?php _e('- Select Country -', $this -> plugin_name); ?></option>
	                                        <?php foreach ($countries as $id => $title) : ?>
	                                            <option <?php echo ((!empty($Order -> data -> ship_country) && $Order -> data -> ship_country == $id) || (empty($Order -> data -> ship_country) && $this -> get_option('defcountry') == $id)) ? 'selected="selected"' : ''; ?> value="<?php echo $id; ?>"><?php echo $title; ?></option>
	                                        <?php endforeach; ?>
	                                    </select>
	                                </td>
	                            </tr>
	                        <?php elseif ($bkey == "state") : ?>
	                            <tr>
	                                <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo __($shippingfield['title']); ?></label></th>
	                                <td>
	                                    <?php echo $wpcoState -> get_states_by_country($Order -> data -> ship_country, 'Order[ship_state]', "true", "ship", false, $Order -> data -> id); ?>
	                                </td>
	                            </tr>
	                        <?php else : ?>
	                            <tr>
	                                <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo __($shippingfield['title']); ?></label></th>
	                                <td>
	                                    <input class="widefat" id="<?php echo $this -> pre; ?><?php echo $bkey; ?>" type="text" name="Order[ship_<?php echo $bkey; ?>]" value="<?php echo $wpcoHtml -> field_value('Order.ship_' . $bkey); ?>" />
	                                </td>
	                            </tr>
	                        <?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		
			<h3><?php _e('Billing Details', $this -> plugin_name); ?></h3>
			<table class="form-table">
				<tbody>
					<?php foreach ($paymentfields['billing'] as $bkey => $billingfield) : ?>
						<?php if ($bkey == "country") : ?>
                            <tr>
                                <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo __($billingfield['title']); ?></label></th>
                                <td>
                                    <?php $countries = $Country -> select($domarkets = true); ?>
                                    <select id="<?php echo $this -> pre; ?>country" name="Order[bill_country]">
                                        <option value=""><?php _e('- Select Country -', $this -> plugin_name); ?></option>
                                        <?php foreach ($countries as $id => $title) : ?>
                                            <option <?php echo ((!empty($Order -> data -> bill_country) && $Order -> data -> bill_country == $id) || (empty($Order -> data -> bill_country) && $this -> get_option('defcountry') == $id)) ? 'selected="selected"' : ''; ?> value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php elseif ($bkey == "state") : ?>
                            <tr>
                                <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo __($billingfield['title']); ?></label></th>
                                <td>
                                    <?php echo $wpcoState -> get_states_by_country($Order -> data -> bill_country, 'Order[bill_state]', "true", "bill", false, $Order -> data -> id); ?>
                                </td>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo __($billingfield['title']); ?></label></th>
                                <td>
                                    <input class="widefat" id="<?php echo $this -> pre; ?><?php echo $bkey; ?>" type="text" name="Order[bill_<?php echo $bkey; ?>]" value="<?php echo $wpcoHtml -> field_value('Order.bill_' . $bkey); ?>" />
                                </td>
                            </tr>
                        <?php endif; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
        
        <h3><?php _e('Notify the Customer', $this -> plugin_name); ?></h3>
        <p><label><input onclick="if (this.checked) { jQuery('#notifycustomerdiv').show(); } else { jQuery('#notifycustomerdiv').hide(); }" type="checkbox" name="Order[notifycustomer]" value="1" id="notifycustomer" /> <?php _e('Notify the customer about changes to this order?', $this -> plugin_name); ?></label></p>
        
        <div id="notifycustomerdiv" style="display:none;">
        	<table class="form-table">
        		<tbody>
        			<tr>
        				<th><label for="notifysubject"><?php _e('Subject', $this -> plugin_name); ?></label></th>
        				<td>
        					<input type="text" class="widefat" name="Order[notifysubject]" value="<?php echo sprintf(__('Order #%s has been changed', $this -> plugin_name), $Order -> data -> id); ?>" id="notifysubject" />
        					<span class="howto"><?php _e('Email subject to the customer.', $this -> plugin_name); ?></span>
        				</td>
        			</tr>
        			<tr>
        				<th><label for="notifycomments"><?php _e('Comment', $this -> plugin_name); ?></label></th>
        				<td>
        					<textarea name="Order[notifycomments]" id="notifycomments" rows="5" cols="100%"></textarea>
        					<span class="howto"><?php _e('Email message to the customer.', $this -> plugin_name); ?></span>
        				</td>
        			</tr>
        		</tbody>
        	</table>            
        </div>
		
		<p class="submit"><?php echo $wpcoForm -> submit(__('Save Order', $this -> plugin_name)); ?></p>
	</form>
</div>