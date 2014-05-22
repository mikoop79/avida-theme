<div class="tribulant_plugin_tabs">
	<ul>
    	<?php if (current_user_can('checkout_extensions')) : ?><li <?php echo ($_GET['page'] == $this -> sections -> extensions) ? 'class="active"' : ''; ?>><span class="border-left"></span><a href="?page=<?php echo $this -> sections -> extensions; ?>" title="<?php _e('Manage', $this -> plugin_name); ?>"><?php _e('Manage', $this -> plugin_name); ?></a><span class="border-right"></span></li><?php endif; ?>
        <?php if (current_user_can('checkout_extensions_settings')) : ?><li <?php echo ($_GET['page'] == $this -> sections -> extensions_settings) ? 'class="active"' : ''; ?>><span class="border-left"></span><a href="?page=<?php echo $this -> sections -> extensions_settings; ?>" title="<?php _e('Settings', $this -> plugin_name); ?>"><?php _e('Settings', $this -> plugin_name); ?></a><span class="border-right"></span></li><?php endif; ?>
    </ul>
    
    <br style="display:block; width:100%; clear:both; visibility:hidden;" />
</div>