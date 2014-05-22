<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Order/Sort Variations', $this -> plugin_name); ?></h2>
	<div class="subsubsub" style="float:none;"><?php echo $wpcoHtml -> link(__('&larr; Back to Variations', $this -> plugin_name), $this -> url); ?></div>
	<p><?php _e('Drag and drop the product variations below to order them according to how they should appear to customers.', $this -> plugin_name); ?></p>
	
	<?php if (!empty($style))  : ?>
		<div id="message" class="updated fade" style="width:30.8%; display:none;"></div>
		<div style="">
			<ul id="styles">
				<?php foreach ($style as $styles) : ?>
					<li id="item_<?php echo $styles -> id; ?>" class="<?php echo $this -> pre; ?>lineitem">
						<?php echo $styles -> title; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<script type="text/javascript">
		var request_variations = false;		
		jQuery(document).ready(function() {
			jQuery("ul#styles").sortable({
				placeholder: "wpco-placeholder",
				revert: 100,
				distance: 5,
				start: function(event, ui) {
					jQuery('#message').slideUp();
				},
				update: function(event, ui) {
					if (request_variations) { request_variations.abort(); }									
					request_variations = jQuery.post(wpcoAjax + '?cmd=styles_order', jQuery('ul#styles').sortable('serialize'), function(response) {
						jQuery('#message').html('<p>' + response + '</p>').show();
					});
				}
			});
		});
		</script>
	<?php else : ?>
		<p class="<?php echo $this -> pre; ?>error"><?php _e('No variations are available', $this -> plugin_name); ?></p>
	<?php endif; ?>
</div>