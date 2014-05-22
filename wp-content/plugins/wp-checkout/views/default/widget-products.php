<?php

$wpcoDb -> model = $Product -> model;

if ($products = $wpcoDb -> find_all(array('status' => 'active'), array('id', 'title', 'image', 'post_id'), array('modified', "DESC"), (empty($options['count'])) ? false : $options['count'])) {
	if (!empty($options['dropdown']) && $options['dropdown'] == "Y") { ?>
		<?php echo $args['before_title']; ?><?php echo $options['title']; ?><?php echo $args['after_title']; ?>
        <select style="width:100%; overflow:auto;" onchange="if (this.value != '') { window.location = this.value; }" name="products<?php echo $number; ?>">
        	<option value=""><?php _e('- Select Product -', $this -> plugin_name); ?></option>
            <?php foreach ($products as $product) : ?>
            	<option value="<?php echo get_permalink($product -> post_id); ?>"><?php echo apply_filters($this -> pre . '_product_title', $product -> title); ?></option>
            <?php endforeach; ?>
        </select>
	<?php } else {
		?>
		
		<?php echo $args['before_title']; ?><?php echo $options['title']; ?><?php echo $args['after_title']; ?>
		<ul class="<?php echo $this -> pre; ?>widgetproducts">
		
		<?php	

		foreach ($products as $product) {
			?>
			
			<li>
				<?php if (!empty($options['thumbs']) && $options['thumbs'] == "Y") : ?>
					<span class="<?php echo $this -> pre; ?>widgetthumb"><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($product -> image_url, 50, 50, 100), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => $this -> pre . "widgetthumblink")); ?></span>
				<?php endif; ?>
				<?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title))); ?>
			</li>
			
			<?php
		}
		
		?>
		
		</ul>
		<br class="<?php echo $this -> pre; ?>cleaner" />
		
		<?php
	}
}

?>