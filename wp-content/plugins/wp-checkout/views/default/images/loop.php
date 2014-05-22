<p><?php echo $wpcoHtml -> link(__('&laquo; Back', $this -> plugin_name), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title))); ?></p>

<?php if (!empty($images)) : ?>
	<div class="<?php echo $this -> pre; ?>imglist wpcoimglistfull">
		<ul>
        	<li><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($product -> image_url, $this -> get_option('ithumbw'), $this -> get_option('ithumbh'), 100), $wpcoHtml -> image_url($product -> image -> name), array('class' => 'colorbox', 'title' => apply_filters($this -> pre . '_product_title', $product -> title), 'rel' => $wpcoHtml -> sanitize(apply_filters($this -> pre . '_product_title', $product -> title)) . '-images')); ?></li>
			<?php foreach ($images as $image) : ?>
				<li><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($image -> image_url, $this -> get_option('ithumbw'), $this -> get_option('ithumbh'), 100), $wpcoHtml -> image_url($image -> filename), array('class' => 'colorbox', 'title' => $image -> title, 'rel' => $wpcoHtml -> sanitize(apply_filters($this -> pre . '_product_title', $product -> title)) . '-images')); ?></li>
			<?php endforeach; ?>
		</ul>
		<br class="<?php echo $this -> pre; ?>cleaner" />
	</div>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No images are available', $this -> plugin_name); ?></p>
<?php endif; ?>