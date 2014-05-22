<?php echo $args['before_title']; ?><?php echo $options['title']; ?><?php echo $args['after_title']; ?>

<form role="search" method="get" id="wpcosearchform" action="<?php echo get_permalink($this -> get_option('searchpage_id')); ?>">
	<div>
		<input type="text" value="<?php echo esc_attr(stripslashes($_GET['wpcosearchterm'])); ?>" name="wpcosearchterm" id="wpcosearchterm" />
		<input type="submit" id="wpcosearchsubmit" class="ui-button" value="<?php _e('Search', $this -> plugin_name); ?>" />
	</div>
</form>