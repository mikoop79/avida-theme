<div style="width:auto; margin:auto; font-family:Arial, Helvetica, sans-serif;">
    <h1 style="text-align:right;"><?php _e('Order Receipt', $this -> plugin_name); ?></h1>
    <p>
        <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
            <tbody>
                <tr>
                    <td valign="top">
                    	<?php if ($this -> get_option('invoice_logotype') == "image") : ?>
                    		<?php if (!empty($pdf) && $pdf == true) : ?>
                        		<img src="<?php echo WP_CONTENT_DIR . DS . 'uploads' . DS . basename($this -> get_option('invoice_companylogo')); ?>" alt="logo" />
                        	<?php else : ?>
                        		<img src="<?php echo WP_CONTENT_URL . '/uploads/' . basename($this -> get_option('invoice_companylogo')); ?>" alt="logo" />
                        	<?php endif; ?>
                        <?php else : ?>
                        	<h1><?php echo $this -> get_option('invoice_companyname'); ?></h1>
                        <?php endif; ?>
                    </td>
                    <td valign="top" style="text-align:right; width:50%;">
                        <p><strong><?php echo $this -> get_option('invoice_companyname'); ?></strong></p>
                        
                        <?php echo wpautop($this -> get_option('invoice_companyaddress')); ?>
                        
                        <p>
                            <?php _e('Tel.', $this -> plugin_name); ?> <?php echo $this -> get_option('invoice_companytel'); ?>
                            <?php if ($this -> get_option('invoice_companyfax') != "") : ?>
                            	<br/><?php _e('Fax.', $this -> plugin_name); ?> <?php echo $this -> get_option('invoice_companyfax'); ?>
                            <?php endif; ?>
                            <?php if ($this -> get_option('invoice_companyweb') != "") : ?>
                            	<br/><?php echo $this -> get_option('invoice_companyweb'); ?>
                            <?php endif; ?>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </p>
    
    <br/>
    
    <p>
        <table style="width:100%;" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td valign="top">
                        <table style="width:100%;" border="1" cellpadding="4" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width:50%;">
                                        <h3><?php _e('Bill To:', $this -> plugin_name); ?></h3>
                                        
                                        <p>
                                            <?php echo $order -> bill_fname; ?> <?php echo $order -> bill_lname; ?>
                                            <?php if (!empty($order -> bill_company)) : ?>
                                            	<br/><strong><?php echo $order -> bill_company; ?></strong>
                                            <?php endif; ?>
                                            <?php if (!empty($order -> bill_phone)) : ?>
                                            	<br/><?php _e('Tel.', $this -> plugin_name); ?> <?php echo $order -> bill_phone; ?>
                                            <?php endif; ?>
                                        </p>
                                        
                                        <p>
                                            <?php echo $order -> bill_address; ?>
                                            <?php if (!empty($order -> bill_address2)) : ?>
                                            	<br/><?php echo $order -> bill_address2; ?>
                                            <?php endif; ?>
                                            <br/><?php echo $order -> bill_city; ?>, <?php echo $order -> bill_state; ?>
                                            <?php $wpcoDb -> model = $Country -> model; ?>
											<br/><?php echo $wpcoDb -> field('value', array('id' => $order -> bill_country)); ?>, <?php echo $order -> bill_zipcode; ?>                              
                                        </p>
                                    </td>
                                
									<?php if(!empty($order -> ship_address)) : ?>
                                        <td style="width:50%;">
                                            <h3><?php _e('Ship To:', $this -> plugin_name); ?></h3>
                                            
                                            <p>
                                                <?php echo $order -> ship_fname; ?> <?php echo $order -> ship_lname; ?>
                                                <?php if (!empty($order -> ship_company)) : ?>
                                                    <br/><strong><?php echo $order -> ship_company; ?></strong>
                                                <?php endif; ?>
                                                <?php if (!empty($order -> ship_phone)) : ?>
                                                	<br/><?php _e('Tel.', $this -> plugin_name); ?> <?php echo $order -> ship_phone; ?>
                                                <?php endif; ?>
                                            </p>
                                            
                                            <p>
                                                <?php echo $order -> ship_address; ?>
                                                <?php if (!empty($order -> ship_address2)) : ?>
                                                    <br/><?php echo $order -> ship_address2; ?>
                                                <?php endif; ?>
                                                <br/><?php echo $order -> ship_city; ?>, <?php echo $order -> ship_state; ?>
                                                <?php $wpcoDb -> model = $Country -> model; ?>
                                                <br/><?php echo $wpcoDb -> field('value', array('id' => $order -> ship_country)); ?>, <?php echo $order -> ship_zipcode; ?>                              
                                            </p>
                                            
                                            <?php if (!empty($order -> shiptrack)) : ?>
                                            	<p><?php _e('Tracking Number:', $this -> plugin_name); ?> <strong><?php echo $order -> shiptrack; ?></strong></p>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="width:15px;"></td>
                    <td valign="top" style="text-align:right;">
                        <table style="width:100%;" border="1" cellpadding="4" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td><strong><?php _e('Invoice Number', $this -> plugin_name); ?></strong></td>
                                    <td><?php echo $order -> id; ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php _e('Date Issued', $this -> plugin_name); ?></strong></td>
                                    <td><?php echo date('j M, Y', time()); ?></td>
                                </tr>
                                <tr>
                                	<td><strong><?php _e('Payment Method', $this -> plugin_name); ?></strong></td>
                                    <td>
										<?php echo $wpcoHtml -> pmethod($order -> pmethod); ?>
                                        <?php if ($order -> pmethod == "cc") : ?>
                                        	<br/>
                                        	<?php $cctypes = $this -> get_option('cctypes'); ?>
											<?php $cardnumber = $wpcoHtml -> cardnumber($order -> cc_number); ?>
											<small><?php echo $order -> cc_name; ?></small><br/>
											<small><?php echo $cctypes[$order -> cc_type]; ?> <?php echo $cardnumber[2]; ?><?php echo (!empty($order -> cc_cvv)) ? ' (' . $order -> cc_cvv . ')' : ''; ?></small><br/>
											<small><?php echo $order -> cc_exp_m; ?>/<?php echo $order -> cc_exp_y; ?></small>
										<?php endif; ?>
                                    </td>
                                </tr>
                                <?php if ($this -> get_option('invoice_paidstatus') == "Y") : ?>
                                    <tr>
                                        <td><strong><?php _e('Paid in Full', $this -> plugin_name); ?></strong></td>
                                        <td>
                                            <?php echo (empty($order -> paid) || $order -> paid == "N") ? __('No', $this -> plugin_name) : __('Yes', $this -> plugin_name); ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
								<?php if (!empty($order -> fields)) : ?>
                                    <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">			
                                        <td><strong><?php _e('Options', $this -> plugin_name); ?></strong></td>
                                        <td>
                                            <?php foreach ($order -> fields as $ofield) : ?>
                                                <?php $wpcoDb -> model = $wpcoField -> model; ?>
                                                <?php if ($field = $wpcoDb -> find(array('id' => $ofield -> field_id))) : ?>
                                                    <div><strong><?php echo $field -> title; ?><?php echo (!empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) ? ' (' . $wpcoHtml -> currency_price($field -> price) . ')' : ''; ?>:</strong> <?php echo $wpcoField -> get_value($field -> id, $ofield -> value); ?></div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
								<?php endif; ?>
                                <tr>
                                	<td><strong><?php _e('Customer Email', $this -> plugin_name); ?></strong></td>
                                    <td><?php echo $order -> bill_email; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </p>
    
    <br/>
    
    <?php if (!empty($items)) : ?>
        <p>
        	<?php $order_id = $order -> id; ?>
			<?php $items_count = $Item -> item_count($order_id, 'items'); ?>
            <?php $units_count = $Item -> item_count($order_id, 'units'); ?>
            <?php $subtotal = $order -> subtotal; ?>
            <?php $discount = $order -> discount; ?>
            <?php $tax_total = $order -> tax; ?>
            <?php $shipping_total = $order -> shipping; ?>
            <?php $total_price = $order -> total; ?>
            
            <?php
			
			global $subtotaldone;
			$subtotaldone = false;
			
			?>
        
            <table style="width:100%;" border="1" cellpadding="4" cellspacing="0">
                <thead>
                    <tr>
                    	<?php if ($this -> get_option('invoice_productcode') == "Y") : ?><td><strong><?php _e('Code', $this -> plugin_name); ?></strong></td><?php endif; ?>
                        <td><strong><?php _e('Description', $this -> plugin_name); ?></strong></td>
						<?php if (empty($pdf) || (!empty($pdf) && $pdf == true && $this -> get_option('invoice_pdfshowfields') == "Y")) : ?><td><strong><?php _e('Options', $this -> plugin_name); ?></strong></td><?php endif; ?>
                        <td><strong><?php _e('Quantity', $this -> plugin_name); ?></strong></td>
                        <td><strong><?php _e('Price', $this -> plugin_name); ?></strong></td>
                        <td><strong><?php _e('Total', $this -> plugin_name); ?></strong></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                    	<tr>
                        	<?php if ($this -> get_option('invoice_productcode') == "Y") : ?><td style="width:auto;"><?php echo (!empty($item -> product -> code)) ? $item -> product -> code : ''; ?></td><?php endif; ?>
                        	<td><?php echo apply_filters($this -> pre . '_product_title', $item -> product -> title); ?></td>
                            <?php if (empty($pdf) || (!empty($pdf) && $pdf == true && $this -> get_option('invoice_pdfshowfields') == "Y")) : ?>
                                <td nowrap="nowrap">
                                    <?php if (!empty($item -> styles) || !empty($item -> product -> cfields) || (!empty($item -> product -> inhonorof) && $item -> product -> inhonorof == "Y") || (!empty($item -> width) && !empty($item -> length))) : ?>
                                        <table>
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
                                                                    <td><?php echo $style -> title; ?></td>
                                                                    <td>
                                                                        <?php $o = 1; ?>
                                                                        <?php foreach ($option_ids as $option_id) : ?>
                                                                            <?php $wpcoDb -> model = $Option -> model; ?>																
                                                                            <?php if ($option = $wpcoDb -> find($conditions = array('id' => $option_id), $fields = array('id', 'title', 'addprice', 'price', 'operator', 'symbol'), array('id', "DESC"), $assign = true)) : ?>
                                                                                <?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($option -> price, true, false, $option -> operator) . ')' : ''; ?>
                                                                                <?php echo ($o < count($option_ids)) ? ', ' : ''; ?>
                                                                            <?php endif; ?>
                                                                            <?php $o++; ?>
                                                                        <?php endforeach; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php else : ?>
                                                                <?php $wpcoDb -> model = $Option -> model; ?>
                                                                <?php $option = $wpcoDb -> find(array('id' => $option_id), false, array('id', "DESC"), $assign = true, $atts = array('otheroptions' => $styles)); ?>
                                                                <tr>
                                                                    <td><?php echo $style -> title; ?></td>
                                                                    <td>
                                                                        <?php echo $option -> title; ?>
                                                                        <?php $optionprice = $wpcoHtml -> currency_price($option -> price, true, false, $option -> operator); ?>
                                                                        <?php echo (!empty($option -> addprice) && $option -> addprice == "Y" && !empty($option -> price)) ? ' (' . $option -> symbol . $optionprice . ')' : ''; ?>
                                                                    </td>
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
                                                                <td><?php echo $field -> title; ?><?php echo (!empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($field -> price) . ')' : ''; ?></td>
                                                                <td><?php echo $wpcoField -> get_value($field_id, $item -> {$field -> slug}); ?></td>
                                                            </tr>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    <?php else : ?>
                                        <?php echo __('None', $this -> plugin_name); ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                            <td><?php echo $item -> count; ?></td>
                            <td><?php echo $wpcoHtml -> currency_price($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true)); ?></td>
                            <td><?php echo $wpcoHtml -> currency_price(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </p>    
         
        <p>
        	<table style="width:100%;" cellpadding="4" cellspacing="0" border="0">
            	<tbody>				
                	<?php if (!empty($shipping_total) && $shipping_total > 0) : ?>				
						<?php if ($this -> get_option('shippingcalc') == "Y" && !empty($shipping_total)) : ?>
                            <?php $wpcoHtml -> invoice_subtotal($order_id); ?>	
                            <?php if ($this -> get_option('shippingcalc') == "Y" && !empty($shipping_total) && $shipping_total != 0) : ?>
                                <tr class="total">
                                    <td style="text-align:right;">
										<?php _e('Shipping', $this -> plugin_name); ?> 
                                    	<?php if (!empty($order -> shipmethod_name)) : ?><small>(<?php echo $order -> shipmethod_name; ?>)</small><?php endif; ?>
                                    </td>
                                    <td style="text-align:right; font-weight:bold;"><?php echo $wpcoHtml -> currency_price($shipping_total); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                        
                    <?php if ($this -> get_option('enablecoupons') == "Y") : ?>
                        <?php if (!empty($discount) && $discount > 0) : ?>
                            <?php $wpcoHtml -> invoice_subtotal($order_id); ?>
                            <?php if (!empty($discount) && $discount != 0 && $discount != "0.00") : ?>
                                <tr class="total">
                                    <td style="text-align:right;"><?php _e('Discount', $this -> plugin_name); ?></td>
                                    <td style="text-align:right; font-weight:bold;">- <?php echo $wpcoHtml -> currency_price($discount); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php $wpcoHtml -> invoice_subtotal($order -> id); ?>
                    
                    <?php if (!empty($order -> tax) && $order -> tax > 0 && !empty($order -> tax_percentage) && $order -> tax_percentage > 0) : ?>
                        <tr class="total">
                            <td style="text-align:right;"><?php echo $this -> get_option('tax_name'); ?> (<?php echo $order -> tax_percentage; ?>&#37;)</td>
                            <td style="text-align:right; font-weight:bold;"><?php echo $wpcoHtml -> currency_price($order -> tax); ?></td>
                        </tr>
                    <?php endif; ?>	
                    <tr class="total">
                        <td style="text-align:right;"><?php _e('Total', $this -> plugin_name); ?></td>
                        <td style="text-align:right; font-weight:bold;"><?php echo $wpcoHtml -> currency_price($total_price); ?></td>
                    </tr>
                </tbody>
            </table>
        </p>
    <?php endif; ?>
    
    <?php $invoice_comments = $this -> get_option('invoice_comments'); ?>
    <?php if (!empty($invoice_comments)) : ?>
        <p align="center" style="text-align:center; font-size: 11px;">
        	<?php echo wpautop($invoice_comments); ?>
        </p>
    <?php endif; ?>
</div>