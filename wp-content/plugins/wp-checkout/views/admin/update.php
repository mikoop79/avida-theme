<?php if (!empty($update_info) && $update_info['is_valid_key'] == "1") : ?>
	<?php
	
	$plugin_file = "wp-checkout/wp-checkout.php";
	$upgrade_url = wp_nonce_url('update.php?action=upgrade-plugin&amp;plugin=' . urlencode($plugin_file), 'upgrade-plugin_' . $plugin_file);
	
	?>
	
	<div class="error">
		<p><?php echo sprintf(__('Before updating, please backup any custom folders/files under %s as they might be overwritten.', $this -> plugin_name), '"wp-checkout/views/"'); ?></p>
	</div>
	
	<div class="updated">
		<p><?php _e('There is a newer version of the Shopping Cart plugin available.', $this -> plugin_name); ?></p>
		<p><?php _e('You can update to the latest version automatically or download the update and install it manually.', $this -> plugin_name); ?></p>
		<p>
			<a href="<?php echo $upgrade_url; ?>" title="" class="button-primary"><?php _e('Update Automatically', $this -> plugin_name); ?></a>
			<a target="_blank" href="<?php echo $update_info['url']; ?>" title="" class="button-secondary"><?php _e('Download Update', $this -> plugin_name); ?></a>
		</p>
	</div>
<?php else : ?>
	<div class="error">
		<p><?php _e('There is a newer version of the Shopping Cart plugin available.', $this -> plugin_name); ?></p>
		<p><?php _e('Unfortunately your download has expired and you can renew it to gain access to this new version.', $this -> plugin_name); ?></p>
		<p>
			<a style="color:white; text-decoration:none;" href="<?php echo $update_info['url']; ?>" target="_blank" title="" class="button button-primary"><?php _e('Renew Download Now!', $this -> plugin_name); ?></a>
			<a style="color:black; text-decoration:none;" href="?page=<?php echo $this -> sections -> settings_updates; ?>&amp;method=check" class="button button-secondary"><?php _e('Check Again', $this -> plugin_name); ?></a>
		</p>
	</div>
<?php endif; ?>