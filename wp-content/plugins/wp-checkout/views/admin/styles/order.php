<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Order/Sort Variation Options:', $this -> plugin_name); ?> <?php echo $style -> title; ?></h2>
	<div class="subsubsub" style="float:none;"><?php echo $wpcoHtml -> link(__('&larr; Back to Variations', $this -> plugin_name), $this -> url); ?></div>
	<p><?php _e('Drag and drop the variation options below in the order they should appear within the variation.', $this -> plugin_name); ?></p>
	
	<?php if (!empty($options))  : ?>
		<div id="message" class="updated fade" style="width:30.8%; display:none;"></div>
		<div style="">
			<ul id="options">
				<?php foreach ($options as $option) : ?>
					<li id="item_<?php echo $option -> id; ?>" class="<?php echo $this -> pre; ?>lineitem">
						<?php echo $option -> title; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<script type="text/javascript">
		var request_options = false;
		jQuery(document).ready(function() {
			jQuery('ul#options').sortable({
				placeholder: "wpco-placeholder",
				revert: 100,
				distance: 5,
				start: function(event, ui) {
					jQuery('#message').slideUp();	
				},
				update: function(event, ui) {
					if (request_options) { request_options.abort(); }
					request_options = jQuery.post(wpcoAjax + '?cmd=varoptions_order&style_id=<?php echo $style -> id; ?>', jQuery('ul#options').sortable('serialize'), function(response) {
						jQuery('#message').html('<p>' + response + '</p>').fadeIn();
					});
				}
			});
		});
		</script>
	<?php else : ?>
		<p class="<?php echo $this -> pre; ?>error"><?php _e('No variation options are available', $this -> plugin_name); ?></p>
	<?php endif; ?>
</div>