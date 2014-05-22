<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Order Categories', $this -> plugin_name); ?></h2>
    <div class="subsubsub" style="float:none;"><?php echo $wpcoHtml -> link(__('&larr; Back to Categories', $this -> plugin_name), '?page=' . $this -> sections -> categories); ?></div>
    <p>
		<?php _e('Drag and drop the shop categories below to order them accordingly.', $this -> plugin_name); ?><br/>
        <?php echo sprintf(__('Use the %s shortcode to display categories.', $this -> plugin_name), '<code>[wpcocategories]</code>'); ?>
    </p>
    
    <?php if (!empty($categories)) : ?>
    	<div style="display:none; width:30.8%;" class="updated fade" id="ordermessage"></div>
    	<div>
        	<ul id="categories">
            	<?php foreach ($categories as $category) : ?>
                	<li id="category_<?php echo $category -> id; ?>" class="<?php echo $this -> pre; ?>lineitem">
                		<?php echo $category -> title; ?>
                		<span class="link"><?php echo $wpcoHtml -> link(__('Order Products', $this -> plugin_name), '?page=' . $this -> sections -> products . '&amp;method=order&amp;category_id=' . $category -> id); ?></span>
                	</li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <script type="text/javascript">
        var request_categories = false;
		jQuery(document).ready(function(e) {
            jQuery('#categories').sortable({
            	placeholder: 'wpco-placeholder',
            	revert: 100,
            	distance: 5,
				start: function(event, ui) {
					if (request_categories) { request_categories.abort(); }
					jQuery('#ordermessage').slideUp();
				},
				update: function(event, ui) {
					request_categories = jQuery.post(ajaxurl + '?action=ordershopcategories', jQuery('ul#categories').sortable('serialize'), function(response) {
						jQuery('#ordermessage').html('<p>' + response + '</p>').fadeIn();
					});
				}
			});
        });
		</script>
    <?php else : ?>
    	<p class="<?php echo $this -> pre; ?>error"><?php _e('No categories are available.', $this -> plugin_name); ?></p>
    <?php endif; ?>
</div>