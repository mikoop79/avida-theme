<?php global $user_ID; ?>
<?php if($this -> get_option('enablefavorites') == 'Y' && $user_ID) : ?>
	<div class="wpcofavoritewrap">
        <span class="favoritesubmit" id="favoritesubmit<?php echo $product -> id; ?>">
        	<a href="#void" title="<?php _e('Add to favorite', $this -> plugin_name); ?>" onclick="wpco_favorite('<?php echo $product -> id; ?>');" class="favoritesubmitlink" id="favoritesubmitlink<?php echo $product -> id; ?>"><?php _e('Add to Favorites', $this -> plugin_name); ?></a>
		</span>
        <span class="favoritesuccess" id="favoritesuccess<?php echo $product -> id; ?>" style="display:none;">&nbsp;</span>
    </div>
<?php endif;?>