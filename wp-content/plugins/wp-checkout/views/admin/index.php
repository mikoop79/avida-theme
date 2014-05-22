<?php

global $ID, $user_ID, $post, $post_ID, $wp_meta_boxes; 

$ID = $this -> get_option('edimagespost');
$post_ID = $this -> get_option('edimagespost');

wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);

?>

<div class="wrap <?php echo $this -> pre; ?>">
	<div class="icon32">
		<img src="<?php echo $this -> url(); ?>/images/icon-36.png" alt="<?php echo $this -> plugin_name; ?>" />
	</div>
	<h2><?php _e('Checkout', $this -> plugin_name); ?> <?php echo $this -> get_option('version'); ?></h2>
	<?php wp_nonce_field($this -> sections -> welcome); ?>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="postbox-container-1" class="postbox-container">
				<?php do_meta_boxes("checkout_page_" . $this -> sections -> welcome, 'side', $post); ?>
			</div>
			<div id="postbox-container-2" class="postbox-container">
				<?php do_meta_boxes("checkout_page_" . $this -> sections -> welcome, 'normal', $post); ?>
                <?php do_meta_boxes("checkout_page_" . $this -> sections -> welcome, 'advanced', $post); ?>
			</div>
		</div>
	</div>
</div>