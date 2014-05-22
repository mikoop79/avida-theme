<?php if ($this -> get_option('guestcheckout') != "Y") : ?>
	<?php echo $wpcoHtml -> link(__('&laquo; Back to your account', $this -> plugin_name), $wpcoHtml -> account_url(), array('title' => __('Return to your account', $this -> plugin_name))); ?><br/><br/>
<?php endif; ?>

<h3><?php _e('View Order #', $this -> plugin_name); ?><?php echo $order -> id; ?></h3>

<?php if (!empty($order) && !empty($items)) : ?>
	<?php if ($this -> get_option('invoice_enabled') == "Y" && $this -> get_option('invoice_enablepdf') == "Y") : ?>
		<p><a href="<?php echo $wpcoHtml -> retainquery($this -> pre . "method=pdfinvoice&amp;id=" . $order -> id, $this -> get_option('shopurl')); ?>" title="<?php _e('Save a PDF invoice for your records', $this -> plugin_name); ?>" class="<?php echo $this -> pre; ?> savepdfinvoicelink"><img border="0" style="border:none;" src="<?php echo $this -> url(); ?>/images/document.png" alt="PDF" /> <?php _e('Save a PDF invoice', $this -> plugin_name); ?></a></p>
    <?php endif; ?>

	<p>
        <table class="<?php echo $this -> pre; ?>">
            <tbody>
                <?php $class = ''; ?>
                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                    <th><?php _e('Items', $this -> plugin_name); ?></th>
                    <td><?php $wpcoDb -> model = $Item -> model; ?><?php echo $wpcoDb -> count(array('order_id' => $order -> id)); ?></td>
                </tr>
                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                    <th><?php _e('Fully Paid', $this -> plugin_name); ?></th>
                    <td><?php echo (!empty($order -> paid) && $order -> paid == "Y") ? __('Yes', $this -> plugin_name) : __('No', $this -> plugin_name); ?></td>
                </tr>
                <?php if (!empty($order -> hastangible) && $order -> hastangible == "Y") : ?>
                    <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                        <th><?php _e('Fully Shipped', $this -> plugin_name); ?></th>
                        <td><?php echo (!empty($order -> shipped) && $order -> shipped == "Y") ? __('Yes', $this -> plugin_name) : __('No', $this -> plugin_name); ?></td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty($order -> shiptrack)) : ?>
                    <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
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
                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                    <th><?php _e('Payment Method', $this -> plugin_name); ?></th>
                    <td><?php echo $wpcoHtml -> pmethod($order -> pmethod); ?></td>
                </tr>
                <?php $discount = $Discount -> total($order -> id); ?>
                <?php if ($this -> get_option('shippingcalc') == "Y" || !empty($discount)) : ?>
                	<?php if (!empty($order -> hastangible) && $order -> hastangible == "Y") : ?>
                    	<?php /*
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><?php _e('Shipped', $this -> plugin_name); ?></th>
                            <td><?php echo (!empty($order -> shipped) && $order -> shipped == "Y") ? __('Yes', $this -> plugin_name) : __('No', $this -> plugin_name); ?></td>
                        </tr>
						*/ ?>
                    <?php endif; ?>
                    <?php
                    
                    $subtotal = $Order -> total($order -> id, false, false, true, true, false, false);
                    $st = $subtotal;
                    
                    if ($globalf = $Order -> globalf_total($order -> id)) {
                        if (!empty($globalf)) {
                            $st = $subtotal - $globalf;
                        }
                    }				
                    
                    ?>
                    <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                        <th><?php _e('Sub Total', $this -> plugin_name); ?></th>
                        <td><?php echo $wpcoHtml -> currency_price($order -> subtotal); ?></td>
                    </tr>
                    <?php if (!empty($globalf) && $globalf != 0 && $globalf != "0.00") : ?>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><?php _e('Order Options', $this -> plugin_name); ?></th>
                            <td><?php echo $wpcoHtml -> currency_price($globalf); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (!empty($order -> discount) && $order -> discount != 0) : ?>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><?php _e('Discount Applied', $this -> plugin_name); ?></th>
                            <td>- <?php echo $wpcoHtml -> currency_price($order -> discount); ?>
                            (<?php echo $Discount -> coupons_by_order($order -> id); ?>)
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($order -> shipped == "Y" || $order -> shipped == "N") : ?>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><?php _e('Shipping Total', $this -> plugin_name); ?></th>
                            <td>
                                <?php echo $wpcoHtml -> currency_price($order -> shipping); ?>
                                <?php if (!empty($order -> shipmethod_name)) : ?>
                                    (<?php echo $order -> shipmethod_name; ?>)
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($order -> tax) && $order -> tax != "0.00" && $order -> tax > 0) : ?>
                    <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                        <th><?php _e('Tax', $this -> plugin_name); ?> (<?php echo $order -> tax_percentage; ?>&#37;)</th>
                        <td><?php echo $wpcoHtml -> currency_price($order -> tax); ?></td>
                    </tr>
                <?php endif; ?>
                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                    <th><?php _e('Total', $this -> plugin_name); ?></th>
                    <td><strong><?php echo $wpcoHtml -> currency_price($order -> total); ?></strong></td>
                </tr>
                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                    <th><?php _e('Created', $this -> plugin_name); ?></th>
                    <td><?php echo $order -> created; ?></td>
                </tr>
                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                    <th><?php _e('Modified', $this -> plugin_name); ?></th>
                    <td><?php echo $order -> modified; ?></td>
                </tr>
            </tbody>
        </table>
   	</p>
    
    <?php if (!empty($order -> cfields)) : ?>
    	<h3><?php _e('Order Options', $this -> plugin_name); ?></h3>
    	<table class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>cart">
        	<tbody>
            	<?php $class = false; ?>
				<?php foreach ($order -> cfields as $ofield) : ?>
                	<?php $wpcoDb -> model = $wpcoField -> model; ?>
					<?php if ($field = $wpcoDb -> find(array('id' => $ofield -> field_id))) : ?>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><?php echo $field -> title; ?><?php echo (!empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) ? ' (' . $wpcoHtml -> currency_price($field -> price) . ')' : ''; ?></th>
                            <td><?php echo $wpcoField -> get_value($field -> id, $ofield -> value); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

	<h3><?php _e('Order Items', $this -> plugin_name); ?></h3>
	<?php $this -> render('paginate', array('paginate' => $paginate), true, 'default'); ?>
	<table class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>cart">
		<thead>
			<tr>
				<th><?php _e('ID', $this -> plugin_name); ?></th>
				<th colspan="2"><?php _e('Product', $this -> plugin_name); ?></th>
				<th><?php _e('Qty', $this -> plugin_name); ?></th>
				<th><?php _e('Paid', $this -> plugin_name); ?></th>
				<th><?php _e('Shipped', $this -> plugin_name); ?></th>
				<th><?php _e('Total', $this -> plugin_name); ?></th>
				<th><?php _e('Date', $this -> plugin_name); ?></th>
			</tr>
		</thead>
        <tfoot>
        	<tr>
				<th><?php _e('ID', $this -> plugin_name); ?></th>
				<th colspan="2"><?php _e('Product', $this -> plugin_name); ?></th>
				<th><?php _e('Qty', $this -> plugin_name); ?></th>
				<th><?php _e('Paid', $this -> plugin_name); ?></th>
				<th><?php _e('Shipped', $this -> plugin_name); ?></th>
				<th><?php _e('Total', $this -> plugin_name); ?></th>
				<th><?php _e('Date', $this -> plugin_name); ?></th>
			</tr>
        </tfoot>
		<tbody>
			<?php $class = ''; ?>
			<?php foreach ($items as $item) : ?>
                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                    <td><?php echo $item -> id; ?></td>
                    <td style="width:50px;"><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($item -> product -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($item -> product -> image -> name), array('class' => 'colorbox', 'rel' => 'order-items', 'title' => apply_filters($this -> pre . '_product_title', $item -> product -> title))); ?></td>
                    <td><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $item -> product -> title), get_permalink($item -> product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $item -> product -> title))); ?></td>
                    <td><?php echo $item -> count; ?></td>
                    <td><?php echo (!empty($item -> paid) && $item -> paid == "Y") ? __('Yes', $this -> plugin_name) : __('No', $this -> plugin_name); ?></td>
                    <td>
                    	<?php if (!empty($item -> product -> type) && $item -> product -> type == "tangible") : ?>
							<?php echo (!empty($item -> shipped) && $item -> shipped == "Y") ? __('Yes', $this -> plugin_name) : __('No', $this -> plugin_name); ?>
                        <?php else : ?>
                        	<?php _e('N/A', $this -> plugin_name); ?>
                        <?php endif; ?>
                    </td>
                    <td><strong><?php echo $wpcoHtml -> currency_price(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count)); ?></strong></td>
                    <td><abbr title="<?php echo $item -> modified; ?>"><?php echo date("Y-m-d", strtotime($item -> modified)); ?></abbr></td>
                </tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php $this -> render('paginate', array('paginate' => $paginate), true, 'default'); ?>
<?php else : ?>
	<div class="<?php echo $this -> pre; ?>error"><?php _e('No order details or items are available', $this -> plugin_name); ?></div>
<?php endif; ?>