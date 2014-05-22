<div class="wrap">
	<h2><?php _e('Save an Image', $this -> plugin_name); ?></h2>
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post" enctype="multipart/form-data">
		<?php echo $wpcoForm -> hidden('Image.id'); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Image.title"><?php _e('Title', $this -> plugin_name); ?></label></th>
					<td><?php echo $wpcoForm -> text('Image.title'); ?></td>
				</tr>
				<tr>
					<th>
						<label for="Image.file"><?php _e('Image File', $this -> plugin_name); ?></label>
					</th>
					<td>
						<?php echo $wpcoForm -> file('Image.file'); ?>
                        <?php /*
						<span class="howto">
							<?php _e('IMPORTANT: larger than', $this -> plugin_name); ?> <strong><?php echo $this -> get_option('thumbw'); ?></strong> by <strong><?php echo $this -> get_option('thumbh'); ?>px</strong><br/>
                            <?php _e('Supported types are GIF, PNG and JPEG', $this -> plugin_name); ?>
						</span>
						*/ ?>
						
						<?php if (!empty($Image -> data -> file -> name) && empty($Image -> errors['file'])) : ?>
							<br/>
							<b><?php _e('Current Image', $this -> plugin_name); ?></b><br/>
							<span class="howto"><?php _e('leave empty for no changes', $this -> plugin_name); ?></span>
							<?php $info = $wpcoHtml -> image_pathinfo($Image -> data -> file -> name); ?>
							<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($Image -> data -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($Image -> data -> file -> name), array('class' => 'colorbox', 'title' => $wpcoHtml -> field_value('Image.title'))); ?>
							<?php echo $wpcoForm -> hidden('Image.oldfile', array('value' => $Image -> data -> file -> name)); ?>
							<?php echo $wpcoForm -> hidden('Image.oldsize', array('value' => $Image -> data -> file -> size)); ?>
							<?php echo $wpcoForm -> hidden('Image.oldtype', array('value' => $Image -> data -> file -> type)); ?>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th><label for="Image.product_id"><?php _e('Product', $this -> plugin_name); ?></label></th>
					<td>
						<?php $products = $Product -> select(); ?>
						<?php echo $wpcoForm -> select('Image.product_id', $products); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save Image', $this -> plugin_name)); ?>
		</p>
	</form>
</div>