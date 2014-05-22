<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Order Shipping Methods', $this -> plugin_name); ?><?php echo (!empty($category)) ? ': ' . __($category -> title) : ''; ?><?php echo (!empty($supplier)) ? ': ' . __($supplier -> name) : ''; ?></h2>
	<div class="subsubsub" style="float:none;"><?php echo $wpcoHtml -> link(__('&larr; Back to Shipping Methods', $this -> plugin_name), $this -> url); ?></div>
	<p><?php _e('Click and drag the shipping methods below in the order they should appear to customers in the shop.', $this -> plugin_name); ?></p>
	<?php if (!empty($shipmethods)) : ?>
		<div id="message" class="updated fade" style="width:30.8%; display:none;"></div>
		<div class="wpco_shipmethods_list">
			<ul id="shipmethods">
				<?php foreach ($shipmethods as $shipmethod) : ?>
						<li id="shipmethod_<?php echo $shipmethod -> id; ?>" class="<?php echo $this -> pre; ?>lineitem">
							<?php echo __($shipmethod -> name); ?>
							<span class="link"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=' . $this -> sections -> shipmethods . '&amp;method=save&amp;id=' . $shipmethod -> id); ?></span>
						</li>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<script type="text/javascript">
		var request_shipmethods = false;		
		jQuery(document).ready(function() {
			jQuery("ul#shipmethods").sortable({
				placeholder: "wpco-placeholder",
				revert: 100,
				distance: 5,
				start: function(event, ui) {
					if (request_shipmethods) { request_shipmethods.abort(); }
					jQuery('#message').slideUp();	
				},
				update: function(event, ui) {
					request_shipmethods = jQuery.post(ajaxurl + "?action=shipmethodsorder", jQuery('ul#shipmethods').sortable('serialize'), function(response) {
						jQuery('#message').html('<p>' + response + '</p>').fadeIn();
					});
				}
			});
		});
		</script>
	<?php else : ?>
		<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available.', $this -> plugin_name); ?></p>
	<?php endif; ?>
</div>

<?php /*<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Order/Sort Shipping Methods', $this -> plugin_name); ?></h2>
	<div class="subsubsub" style="float:none;"><?php echo $wpcoHtml -> link(__('&larr; Back to Shipping Methods', $this -> plugin_name), $this -> url); ?></div>
	<p><?php _e('Click and drag the shipping methods below in the order they should appear to customers in the shop.', $this -> plugin_name); ?></p>
    
    <?php if (!empty($shipmethods)) : ?>
    	<div id="message" class="updated fade" style="width:30.8%; display:none;"></div>
    	<div>
        	<ul id="shipmethods">
            	<?php foreach ($shipmethods as $shipmethod) : ?>
                	<li id="shipmethod_<?php echo $shipmethod -> id; ?>" class="<?php echo $this -> pre; ?>lineitem">
                		<?php echo $shipmethod -> name; ?>
                		<span class="link"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=' . $this -> sections -> shipmethods . '&amp;method=save&amp;id=' . $shipmethod -> id); ?></span>
                	</li>
                <?php endforeach; ?>
            </ul>
        </div>
		
		<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("ul#shipmethods").sortable({
				placeholder: "wpco-placeholder",
				revert: 100,
				distance: 5,
				start: function(event, ui) {
					if (request_shipmethods) { request_shipmethods.abort(); }
					jQuery('#message').slideUp();	
				},
				update: function(event, ui) {
					request_shipmethods = jQuery.post(ajaxurl + "?action=shipmethodsorder", jQuery('ul#shipmethods').sortable('serialize'), function(response) {
						jQuery('#message').html('<p>' + response + '</p>').fadeIn();
					});
				}
			});
		});
		</script>
	<?php else : ?>
		<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available', $this -> plugin_name); ?></p>
	<?php endif; ?>
</div>*/ ?>