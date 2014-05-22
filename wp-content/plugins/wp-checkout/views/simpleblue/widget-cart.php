<?php $co_id = $Order -> cart_order(); ?>
<?php $items_count = $Item -> item_count($co_id, 'items'); ?>
<?php $units_count = $Item -> item_count($co_id, 'units'); ?>
<?php $subtotal = $Order -> total($co_id, false, false, true, true, false, false); ?>
<?php $discount = $Discount -> total($co_id); ?>
<?php $shipping = $Order -> shipping_total($subtotal, $co_id); ?>
<?php $tax_total = $Order -> tax_total($co_id); ?>
<?php $total_price = $Order -> total($co_id, true, true); ?>

<?php if (!empty($options['hide_when_empty']) && $options['hide_when_empty'] == 1 && empty($items_count)) : ?>
	<div id="<?php echo $number; ?>-inside" class="widget-cart" style="display:none;">
		<!-- hidden when empty -->
	</div>
<?php else : ?>
	<?php if (empty($isajax) || $isajax == false) : ?>
        <?php echo $args['before_title']; ?><span class="cart"><?php echo $options['title']; ?></span><?php echo $args['after_title']; ?>
        <div id="<?php echo $number; ?>-inside" class="widget-cart">	
    <?php endif; ?>
    	<?php if (!empty($items_count)) : ?>
    		<?php do_action($this -> pre . '_cart_widget_hasitems_top', $co_id, $subtotal, $total_price); ?>
    	<?php endif; ?>
    
        <?php if (!empty($errors)) : ?>
            <ul>
                <?php foreach ($errors as $err) : ?>
                    <li class="<?php echo $this -> pre; ?>error"><?php echo $err; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        
        <?php if (!empty($successmsg)) : ?>
        	<div id="widget-cart-success">
            	<ul>
                	<li class="<?php echo $this -> pre; ?>successmsg"><?php echo $successmsg; ?></li>
            	</ul>
            </div>
            <br/>
        <?php endif; ?>
        
        <?php if (empty($options['show']) || $options['show'] == "normal") : ?>
            <ul>
            	<?php if (!empty($options['showproducts']) && $options['showproducts'] == "Y") : ?>
            		<?php 
            		
            		$wpcoDb -> model = $Item -> model;
            		$items = $wpcoDb -> find_all(array($co_id['type'] . '_id' => $co_id['id']));
            		
            		?>
            		<?php if (!empty($items)) : ?>
	            		<li style="border:none;">
	            			<ul class="<?php echo $this -> pre; ?>widgetproducts">
	            				<?php foreach ($items as $item) : ?>
	            					<li>
	            						<span class="<?php echo $this -> pre; ?>widgetthumb"><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($item -> product -> image_url, 50, 50, 100), get_permalink($item -> product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $item -> product -> title), 'class' => $this -> pre . "widgetthumblink")); ?></span>
										<?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $item -> product -> title), get_permalink($item -> product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $item -> product -> title))); ?> (<?php echo $item -> count; ?>)
	            					</li>
	            				<?php endforeach; ?>
	            			</ul>
	            		</li>
	            	<?php endif; ?>
	            <?php else : ?>
	            	<li><?php _e('Total Items', $this -> plugin_name); ?>: <strong><?php echo $items_count; ?></strong></li>
                	<li><?php _e('Total Units', $this -> plugin_name); ?>: <strong><?php echo $units_count; ?></strong></li>
            	<?php endif; ?>
                <?php if (!empty($items_count) && $items_count != 0) : ?>
                    <?php if ($this -> get_option('shippingcalc') == "Y" || $this -> get_option('enablecoupons') == "Y") : ?>
                        <li><?php _e('Sub Total', $this -> plugin_name); ?> <?php if ($this -> get_option('tax_calculate') == "Y") : ?><span class="taxwrap">(<?php _e('Excl.', $this -> plugin_name); ?> <?php echo $this -> get_option('tax_name'); ?>)</span><?php endif; ?>: <strong><?php echo $wpcoHtml -> currency_price($subtotal); ?></strong></li>
                        <?php if ($this -> get_option('shippingcalc') == "Y" && !empty($shipping) && $shipping != 0) : ?>
                            <li><?php _e('Shipping', $this -> plugin_name); ?>: <strong><?php echo $wpcoHtml -> currency_price($shipping); ?></strong></li>
                        <?php endif; ?>
                        <?php if ($this -> get_option('enablecoupons') && !empty($discount) && $discount != 0) : ?>
                            <li><?php _e('Discount', $this -> plugin_name); ?>: <strong><?php echo $wpcoHtml -> currency_price($discount); ?></strong></li>
                        <?php endif; ?>
                        <?php do_action($this -> pre . '_cart_widget_below_discount', $co_id); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($this -> get_option('tax_calculate') == "Y" && !empty($tax_total)) : ?>
                    <li><?php echo $this -> get_option('tax_name'); ?> (<?php echo $wpcoTax -> get_tax_percentage($Order -> do_shipping($co_id)); ?>&#37;): <strong><?php echo $wpcoHtml -> currency_price($tax_total); ?></strong></li>
                <?php endif; ?>
                <li><?php _e('Total:', $this -> plugin_name); ?> <strong><?php echo $wpcoHtml -> currency_price($total_price); ?></strong></li>
            </ul>
            <br/>
        <?php else : ?>
            <ul>
                <li><?php _e('Total:', $this -> plugin_name); ?> <strong><?php echo $wpcoHtml -> currency_price($total_price); ?></strong></li>
            </ul>
            <br/>
        <?php endif; ?>
        
        <?php if (!empty($items_count) && $items_count != 0) : ?>	            
            <ul>
                <li><a href="<?php echo $wpcoHtml -> cart_url(); ?>" title="<?php _e('View your shopping cart', $this -> plugin_name); ?>"><?php _e('View Shopping Cart', $this -> plugin_name); ?></a></li>
                <?php $completetext = __('Start Checkout &raquo;', $this -> plugin_name); ?>
                <?php if ($wpcoField -> globalfields('cart')) : ?>
                    <?php $method = 'cart'; ?>
                    <?php $completeurl = $wpcoHtml -> cart_url(); ?>
                    <?php $completetext = __('Start Checkout &raquo;', $this -> plugin_name); ?>
                <?php else : ?>
                    <?php global $user_ID; ?>
                    <?php $tempmethod = ($Order -> do_shipping($co_id)) ? 'shipping' : 'billing'; ?>
                    <?php $method = ($user_ID || $this -> get_option('guestcheckout') == "Y") ? $tempmethod : 'contacts'; ?>
                    <?php
                    
                    $completeurl = $wpcoHtml -> cart_url();
					$completetext = __('Go to Cart &raquo;', $this -> plugin_name);
                    
                    switch ($method) {
                        case 'contacts'			:
                            $completeurl = $wpcoHtml -> contacts_url(true);
							$completetext = __('Start Checkout &raquo;', $this -> plugin_name);
                            break;
                        case 'shipping'			:
                            $completeurl = $wpcoHtml -> ship_url();
							$completetext = __('Start Checkout &raquo;', $this -> plugin_name);
                            break;
                        case 'billing'			:
                            $completeurl = $wpcoHtml -> bill_url();
							$completetext = __('Start Checkout &raquo;', $this -> plugin_name);
                            break;
                        default					:
                            $completeurl = $wpcoHtml -> cart_url();
							$completetext = __('Go to Cart &raquo;', $this -> plugin_name);
                            break;
                    }
                    
                    ?>
                <?php endif; ?>
                <?php if ($this -> get_option('cart_addajax') == "Y") : ?>
                	<li><a href="javascript:void(0);" onclick="if (!confirm('<?php _e('Are you sure you wish to remove all items from your shopping cart?', $this -> plugin_name); ?>')) { return false; } else { wpco_emptycart('<?php echo $this -> widget_active('cart'); ?>'); }" title="<?php _e('Remove all items from your shopping cart', $this -> plugin_name); ?>"><?php _e('Empty Shopping Cart', $this -> plugin_name); ?></a></li>
                <?php else : ?>
                	<li><a href="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=cart&empty=1', $wpcoHtml -> cart_url()); ?>" onclick="if (!confirm('<?php _e('Are you sure you wish to remove all items from your shopping cart?', $this -> plugin_name); ?>')) { return false; }" title="<?php _e('Remove all items from your shopping cart', $this -> plugin_name); ?>"><?php _e('Empty Shopping Cart', $this -> plugin_name); ?></a></li>
                <?php endif; ?>
            </ul>
            
            <p><br/><a class="<?php echo $this -> pre; ?>button" href="<?php echo $completeurl; ?>" title="<?php _e('Complete your order', $this -> plugin_name); ?>"><?php echo $completetext; ?></a></p>
        <?php endif; ?>
        <br class="<?php echo $this -> pre; ?>cleaner" />
		<?php if ($options['enablecoupons'] == "Y") : ?>
				<?php $wpcoDb -> model = $Coupon -> model; ?>
				<?php $couponscount = $wpcoDb -> count(); ?>
				<?php if ($this -> get_option('enablecoupons') == "Y" && !empty($couponscount)) : ?>
					<?php $wpcoDb -> model = $Discount -> model; ?>
					<?php $dcount = $wpcoDb -> count(array($co_id['type'] . '_id' => $co_id['id'])); ?>
					<?php if ($this -> get_option('multicoupon') == "Y" || (empty($dcount) && $this -> get_option('multicoupon') == "N")) : ?>
						<?php $this -> render('couponform', false, true, 'default'); ?>
					<?php endif; ?>
				<?php endif; ?>
		 <?php endif; ?>
        <?php global $user_ID; ?>
        <?php if ($user_ID) : ?>
            <?php $wpcoDb -> model = $Order -> model; ?>
            <?php $orderscount = $wpcoDb -> count(array('completed' => "Y", 'user_id' => $user_ID)); ?>
            <?php $hasorders = (!empty($orderscount)) ? true : false; ?>
        <?php endif; ?>
        
        <?php if ($this -> has_downloads() || $hasorders == true) : ?>
            <br/>
            <ul>
                <?php if ($this -> has_downloads()) : ?>
                    <li><a href="<?php echo $wpcoHtml -> downloads_url(); ?>" title="<?php _e('View all your downloads', $this -> plugin_name); ?>"><?php _e('Downloads Management', $this -> plugin_name); ?></a></li>
                <?php endif; ?>
                <?php if ($hasorders == true) : ?>
                    <li><a href="<?php echo $wpcoHtml -> account_url(); ?>" title="<?php _e('View your complete orders history', $this -> plugin_name); ?>"><?php _e('Orders History', $this -> plugin_name); ?></a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    <?php if (empty($isajax) || $isajax == false) : ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<script type="text/javascript">
jQuery(document).ready(function(e) {
    jQuery('.wpcobutton').button();
});
</script>