<?php global $user_ID; ?>
<?php if (!$user_ID) : ?>
	<p><?php _e('You are not currently logged in, please register or login.', $this -> plugin_name); ?></p>
    <?php $this -> render('contacts', array('gotoaccount' => true), true, 'default'); ?>
<?php else : ?>
    <ul>
    	<li><a href="<?php echo site_url(); ?>/wp-admin/profile.php" title="<?php _e('Edit Profile', $this -> plugin_name); ?>"><?php _e('Edit Profile', $this -> plugin_name); ?></a></li>
    	<?php if ($this -> has_downloads($user -> ID)) : ?>
        	<li><a href="<?php echo $wpcoHtml -> downloads_url(); ?>" title="<?php _e('Downloads Management', $this -> plugin_name); ?>"><?php _e('Downloads Management', $this -> plugin_name); ?></a></li>
        <?php endif; ?>
		<?php if ($this -> get_option('enablefavorites') == "Y") : ?>
        	<li><a href="<?php echo $wpcoHtml -> favorites_url(); ?>" title="<?php _e('View Favorite Products', $this -> plugin_name); ?>"><?php _e('View Favorite Products', $this -> plugin_name); ?></a></li>
		<?php endif; ?>
    </ul>

    <?php $this -> render('orders' . DS . 'history', array('orders' => $orders_data[$Order -> model], 'paginate' => $orders_data['Paginate']), true, 'default'); ?>
<?php endif; ?>