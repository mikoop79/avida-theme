<?php

global $ID, $user_ID, $post, $post_ID, $wp_meta_boxes; 

$ID = $this -> get_option('edimagespost');
$post_ID = $this -> get_option('edimagespost');

wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);

?>

<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Configuration Settings', $this -> plugin_name); ?></h2>
    <?php $this -> render('settings-navigation', false, true, 'admin'); ?>
	<form action="?page=<?php echo $this -> sections -> settings_general; ?>" method="post" id="<?php echo $this -> sections -> settings; ?>">
		<?php wp_nonce_field($this -> sections -> settings); ?>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="postbox-container-1" class="postbox-container">
					<?php do_meta_boxes("checkout_page_" . $this -> sections -> settings, 'side', $post); ?>
				</div>
				<div id="postbox-container-2" class="postbox-container">
					<?php do_meta_boxes("checkout_page_" . $this -> sections -> settings, 'normal', $post); ?>
                    <?php do_meta_boxes("checkout_page_" . $this -> sections -> settings, 'advanced', $post); ?>
				</div>
			</div>
		</div>
	</form>
</div>