<iframe width="100%" height="500" style="height:600px;" frameborder="0" scrolling="no" class="widefat" style="width:100%; height:400px; margin:15px 0 0 0;" src="<?php echo home_url(); ?>/?<?php echo $this -> pre; ?>method=mb_iframe&order_id=<?php echo $order -> id; ?>">
	<p><?php _e('Your browser does not support IFRAME.', $this -> plugin_name); ?></p>
</iframe>