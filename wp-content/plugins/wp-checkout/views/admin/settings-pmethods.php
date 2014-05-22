<?php

global $ID, $user_ID, $post, $post_ID, $wp_meta_boxes; 

$ID = $this -> get_option('edimagespost');
$post_ID = $this -> get_option('edimagespost');

wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);

?>

<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Configure Payment Methods', $this -> plugin_name); ?></h2>
    
    <?php $this -> render('settings-navigation', false, true, 'admin'); ?>
	
	<form action="<?php echo $this -> url; ?>" method="post" enctype="multipart/form-data" id="<?php echo $this -> sections -> settings_pmethods; ?>">
		<?php wp_nonce_field($this -> sections -> settings_pmethods); ?>
	
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="postbox-container-1" class="postbox-container">
					<?php do_meta_boxes("admin_page_" . $this -> sections -> settings_pmethods, 'side', $post); ?>
				</div>
				<div id="postbox-container-2" class="postbox-container">
					<?php do_meta_boxes("admin_page_" . $this -> sections -> settings_pmethods, 'normal', $post); ?>
                    <?php do_meta_boxes("admin_page_" . $this -> sections -> settings_pmethods, 'advanced', $post); ?>
				</div>
			</div>
		</div>
	</form>
</div>