<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Order Suppliers', $this -> plugin_name); ?></h2>
	<div style="float:none;" class="subsubsub"><?php echo $wpcoHtml -> link(__('&larr; Back to Suppliers', $this -> plugin_name), $this -> url); ?></div>
	<p>
		<?php _e('Drag and drop the suppliers below to order them accordingly.', $this -> plugin_name); ?><br/>
        <?php echo sprintf(__('Use the %s shortcode to display suppliers.', $this -> plugin_name), '<code>[wpcosuppliers]</code>'); ?>
    </p>
	
	<?php if (!empty($suppliers)) : ?>
		<div style="display:none; width:30.8%;" class="updated fade" id="ordermessage"></div>
		<div>
			<ul id="suppliers">
				<?php foreach ($suppliers as $supplier) : ?>
					<li class="<?php echo $this -> pre; ?>lineitem" id="supplier_<?php echo $supplier -> id; ?>">
						<?php echo __($supplier -> name); ?>
						<span class="link"><?php echo $wpcoHtml -> link(__('Order Products', $this -> plugin_name), '?page=' . $this -> sections -> products . '&amp;method=order&amp;supplier_id=' . $supplier -> id); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
			
			<script type="text/javascript">
			var request_suppliers = false;
			jQuery(document).ready(function() {
				jQuery('#suppliers').sortable({
            	placeholder: 'wpco-placeholder',
            	revert: 100,
            	distance: 5,
				start: function(event, ui) {
					if (request_suppliers) { request_suppliers.abort(); }
					jQuery('#ordermessage').slideUp();
				},
				update: function(event, ui) {
					request_suppliers = jQuery.post(ajaxurl + '?action=ordersuppliers', jQuery('ul#suppliers').sortable('serialize'), function(response) {
						jQuery('#ordermessage').html('<p>' + response + '</p>').fadeIn();
					});
				}
			});
			});
			</script>
		</div>
	<?php else : ?>
		<p class="<?php echo $this -> pre; ?>error"><?php _e('No suppliers are available.', $this -> plugin_name); ?></p>
	<?php endif; ?>
</div>