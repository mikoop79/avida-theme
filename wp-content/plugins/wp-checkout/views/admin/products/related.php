<div class="wrap <?php echo $this -> pre; ?> relatedproducts">
	<h2><?php _e('Related Products: ', $this -> plugin_name); ?><?php echo apply_filters($this -> pre . '_product_title', $product -> title); ?></h2>
	<div style="float:none;" class="subsubsub"><?php echo $wpcoHtml -> link(__('&larr; All Products', $this -> plugin_name), $this -> url); ?></div>
	<p><?php _e('Drag and drop products from right to left to assign related products', $this -> plugin_name); ?></p>
	
	<div id="message" class="updated fade" style="display:none;"></div>

	<div style="float:left; width:49%;">
		<h3><?php _e('Related Products', $this -> plugin_name); ?></h3>
		<div class="scroll-list">
			<ul id="relatedproducts" class="connectedSortable">	
	            <li class="<?php echo $this -> pre; ?>lineitem ui-state-disabled" id="related_r"><?php _e('Drag and drop related products here', $this -> plugin_name); ?></li>
	            <?php $rproducts = array(); ?>
	            <?php if (!empty($related)) : ?>
					<?php foreach ($related as $r) : ?>
	                    <?php $wpcoDb -> model = $Product -> model; ?>
	                    <?php $rproduct = $wpcoDb -> find(array('id' => $r -> related_id)); ?>
	                    <li class="<?php echo $this -> pre; ?>lineitem" id="related_<?php echo $rproduct -> id; ?>">
	                    	<?php /*
	                        <div style="float:left; margin:0 10px 0 0;">
	                            <?php echo $wpcoHtml -> timthumb_image($rproduct -> image_url, 50, 50, 100); ?>
	                        </div>
	                        <h4>*/ ?><?php echo __($rproduct -> title); ?><?php /*</h4>
	                        <br style="clear:both; display:block; height:1px; visibility:hidden;" />*/ ?>
	                    </li>
	                    <?php $rproducts[] = $rproduct -> id; ?>
	                <?php endforeach; ?>
	            <?php endif; ?>
			</ul>
		</div>
	</div>
	
	<div style="float:left; width:2%;">&nbsp;</div>
	
	<div style="float:left; width:49%;">
		<h3><?php _e('All Products', $this -> plugin_name); ?></h3>
		<div class="scroll-list">
			<ul id="allproducts" class="connectedSortable">
			<?php if (!empty($products)) : ?>
					<li class="<?php echo $this -> pre; ?>lineitem ui-state-disabled" id="related_r"><?php _e('Drag and drop products here', $this -> plugin_name); ?></li>
					<?php foreach ($products as $prod) : ?>
						<?php if ($prod -> id != $product -> id) : ?>
							<?php if (empty($rproducts) || (!empty($rproducts) && !in_array($prod -> id, $rproducts))) : ?>
								<li class="<?php echo $this -> pre; ?>lineitem" id="related_<?php echo $prod -> id; ?>">
									<?php /*<div style="float:left; margin:0 10px 0 0;">
	                                    <?php echo $wpcoHtml -> timthumb_image($prod -> image_url, 50, 50, 100); ?>
									</div>
									<h4>*/ ?><?php echo __($prod -> title); ?><?php /*</h4>
									<br style="clear:both; height:1px; display:block; visibility:hidden;" />*/ ?>
								</li>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>					
			<?php else : ?>
				<span class="<?php echo $this -> pre; ?>error"><?php _e('No products were found', $this -> plugin_name); ?></span>
				
			<?php endif; ?>
			</ul>
		</div>
	</div>
	
	<script type="text/javascript">
	var request_products = false;
	jQuery(document).ready(function() {		
		jQuery('ul#relatedproducts, ul#allproducts').sortable({
			dropOnEmpty: true,
			items: "li:not(.ui-state-disabled)",
			connectWith: '.connectedSortable',
			placeholder: "wpco-placeholder",
			revert: 100,
			distance: 5,
			start: function(event, ui) {
				if (request_products) { request_products.abort(); }
				jQuery('#message').slideUp('slow');
			},
			update: function(event, ui) {
				request_products = jQuery.post(ajaxurl + '?action=relatedproducts&product_id=<?php echo $product -> id; ?>', jQuery('ul#relatedproducts').sortable('serialize'), function(response) {
					jQuery('#message').html('<p>' + response + '</p>').fadeIn();
				});
			}
		}).disableSelection();
	});
	</script>
</div>