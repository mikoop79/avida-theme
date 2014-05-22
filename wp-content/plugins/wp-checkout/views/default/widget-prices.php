<?php echo $args['before_title']; ?><?php echo $options['title']; ?><?php echo $args['after_title']; ?>

<ul>
	<li><?php echo $wpcoHtml -> link($wpcoHtml -> currency_html('1') . ' ' . __('to', $this -> plugin_name) . ' ' . $wpcoHtml -> currency_html('49'), $wpcoHtml -> retainquery('min_price=1&amp;max_price=49', get_permalink($this -> get_option('allproductsppid')))); ?></li>
	<li><?php echo $wpcoHtml -> link($wpcoHtml -> currency_html('50') . ' ' . __('to', $this -> plugin_name) . ' ' . $wpcoHtml -> currency_html('199'), $wpcoHtml -> retainquery('min_price=50&amp;max_price=199', get_permalink($this -> get_option('allproductsppid')))); ?></li>
	<li><?php echo $wpcoHtml -> link($wpcoHtml -> currency_html('200') . ' ' . __('to', $this -> plugin_name) . ' ' . $wpcoHtml -> currency_html('499'), $wpcoHtml -> retainquery('min_price=200&amp;max_price=499', get_permalink($this -> get_option('allproductsppid')))); ?></li>
	<li><?php echo $wpcoHtml -> link($wpcoHtml -> currency_html('500') . ' ' . __('and up', $this -> plugin_name), $wpcoHtml -> retainquery('min_price=500', get_permalink($this -> get_option('allproductsppid')))); ?></li>
</ul>