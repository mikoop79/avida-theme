<div class="total">
	<p><?php _e('Tax total to date:', $this -> plugin_name); ?></p>
	<p class="price"><?php echo $wpcoHtml -> currency_price($total); ?></p>
	<p><a href="?page=<?php echo $this -> sections -> orders; ?>" class="button button-primary button-large"><?php _e('View Orders', $this -> plugin_name); ?></a></p>
</div>