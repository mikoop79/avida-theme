<?php

global $ID, $user_ID, $post, $post_ID, $wp_meta_boxes; 

$ID = $this -> get_option('edimagespost');
$post_ID = $this -> get_option('edimagespost');

wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);

?>

<div class="wrap">
	<h2><?php _e('Save Content', $this -> plugin_name); ?></h2>
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post">
		<?php echo $wpcoForm -> hidden('wpcoContent.id'); ?>
		
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div id="titlediv">
						<div id="titlewrap">
							<?php echo $wpcoForm -> text('wpcoContent.title', array('id' => "title", 'error' => false)); ?>
						</div>
						<?php echo $wpcoHtml -> field_error('wpcoContent.title'); ?>
					</div>
					<div id="<?php echo ($this -> get_option('format') == "html") ? 'postdivrich' : 'postdiv'; ?>" class="postarea edit-form-section">						
						<!-- The Editor -->
						<?php if (version_compare(get_bloginfo('version'), "3.3") >= 0) : ?>
							<?php wp_editor(stripslashes($wpcoHtml -> field_value('wpcoContent.content')), 'content', array('tabindex' => 2)); ?>
						<?php else : ?>
							<?php the_editor(stripslashes($wpcoHtml -> field_value('wpcoContent.content')), 'content', 'title', true, 2); ?>
						<?php endif; ?>
						
						<table cellspacing="0" id="post-status-info">
							<tbody>
								<tr>
									<td id="wp-word-count"><?php _e('Word count:', $this -> plugin_name); ?> <span class="word-count">0</span></td>
								</tr>
							</tbody>
						</table>
						
						<?php echo $wpcoHtml -> field_error('wpcoContent.content'); ?>
					</div>
				</div>
				<div id="postbox-container-1" class="postbox-container">
					<?php do_action('submitpage_box'); ?>		
					<?php do_meta_boxes("admin_page_" . $this -> sections -> content_save, 'side', $post); ?>
				</div>
				<div id="postbox-container-2" class="postbox-container">
					<?php do_meta_boxes("admin_page_" . $this -> sections -> content_save, 'normal', $post); ?>
				</div>
			</div>
		</div>
        
        <?php add_action('admin_footer', 'wp_tiny_mce_preload_dialogs'); ?>
	</form>
</div>