<div class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>search">
	<form role="search" method="get" id="wpcosearchform" action="<?php echo get_permalink($this -> get_option('searchpage_id')); ?>">
		<div>
			<input type="text" value="<?php echo esc_attr(stripslashes($_GET['wpcosearchterm'])); ?>" name="wpcosearchterm" id="wpcosearchterm" />
			<input type="submit" id="wpcosearchsubmit" class="<?php echo $this -> pre; ?>button" value="<?php _e('Search', $this -> plugin_name); ?>" />
		</div>
	</form>
</div>