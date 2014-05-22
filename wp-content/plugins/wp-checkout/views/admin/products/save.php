<?php 

global $ID, $user_ID, $post, $post_ID, $wp_meta_boxes; 

if (!empty($product -> post_id)) {
	$ID = $product -> post_id;
	$post_ID = $product -> post_id;	
} else {
	$ID = $this -> get_option('edimagespost');
	$post_ID = $this -> get_option('edimagespost');
}

wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);

?>

<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Save a Product', $this -> plugin_name); ?></h2>
	<form action="?page=checkout-products-save" method="post" enctype="multipart/form-data">
		<?php wp_nonce_field($this -> sections -> products_save); ?>

		<?php if (!empty($Product -> data -> id)) : ?>
			<?php echo $wpcoForm -> hidden('Product.id'); ?>
			<?php echo $wpcoForm -> hidden('Product.post_id'); ?>
			<?php echo $wpcoForm -> hidden('Product.order'); ?>
			<?php echo $wpcoForm -> hidden('Product.supplier_order'); ?>
		<?php endif; ?>
		
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div id="titlediv">
						<div id="titlewrap">
							<?php echo $wpcoForm -> text('Product.title', array('id' => "title", 'error' => false, 'autocomplete' => "off")); ?>
						</div>
						<div class="inside">
							<?php echo $wpcoHtml -> field_error('Product.title'); ?>
						</div>
					</div>					
					<div id="<?php echo (user_can_richedit()) ? 'postdivrich' : 'postdiv'; ?>" class="postarea edit-form-section">						
						<!-- The Editor -->
						<?php if (version_compare(get_bloginfo('version'), "3.3") >= 0) : ?>
							<?php wp_editor(stripslashes($wpcoHtml -> field_value('Product.description')), 'content', array('tabindex' => 2)); ?>
						<?php else : ?>
							<?php the_editor(stripslashes($wpcoHtml -> field_value('Product.description')), 'content', 'title', true, 2); ?>
						<?php endif; ?>
						
						<table cellspacing="0" id="post-status-info">
							<tbody>
								<tr>
									<td id="wp-word-count"><?php _e('Word count:', $this -> plugin_name); ?> <span class="word-count">0</span></td>
								</tr>
							</tbody>
						</table>
						
						<?php echo $wpcoHtml -> field_error('Product.description'); ?>
					</div>
				</div>
				<div id="postbox-container-1" class="postbox-container">
					<?php do_action('submitpage_box'); ?>		
					<?php do_meta_boxes("admin_page_" . $this -> sections -> products_save, 'side', $post); ?>
				</div>
				<div id="postbox-container-2" class="postbox-container">
					<?php do_meta_boxes("admin_page_" . $this -> sections -> products_save, 'normal', $post); ?>
					<?php do_meta_boxes("admin_page_" . $this -> sections -> products_save, 'advanced', $post); ?>
				</div>
			</div>
			<br class="clear" />
		</div>
	</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#title').Watermark('<?php _e('Enter product title here', $this -> plugin_name); ?>');
});

var warnMessage = "<?php _e('You have unsaved changes on this page! All unsaved changes will be lost and it cannot be undone.', $this -> plugin_name); ?>";

jQuery(document).ready(function() {
    jQuery('input:not(:button,:submit),textarea,select').change(function () {
        window.onbeforeunload = function () {
            if (warnMessage != null) return warnMessage;
        }
    });
    
    jQuery('input:submit').click(function(e) {
        warnMessage = null;
    });
});
</script>