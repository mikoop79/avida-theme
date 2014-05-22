<div class="submitbox" id="submitpost">
	<div id="minor-publishing">
		<div id="misc-publishing-actions">
        	<?php if (!empty($_GET['page']) && 
					($_GET['page'] == $this -> sections -> settings ||
					$_GET['page'] == $this -> sections -> settings_products)) : ?>
				<?php if ($this -> get_option('createpages') == "Y") : ?>
                    <div class="misc-pub-section">
                        <a onclick="if (!confirm('<?php echo sprintf(__('Are you sure you wish to update all %s posts/pages for categories, products, suppliers, etc in the database?', $this -> plugin_name), WPCO_CMS_NAME); ?>')) { return false; }" href="?page=checkout-settings&amp;method=updatepages" title="<?php _e('Update all category, product, supplier, etc ' . WPCO_CMS_NAME . ' posts/pages', $this -> plugin_name); ?>"><?php _e('Update all shop posts/taxonomies', $this -> plugin_name); ?></a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="misc-pub-section">
            	<a href="?page=<?php echo $this -> sections -> settings; ?>&amp;method=checkdb"><?php _e('Check/Optimize Database', $this -> plugin_name); ?></a>
            </div>
			<div class="misc-pub-section">
				<a onclick="if (!confirm('<?php _e('Are you sure you wish to reset all configuration values to their defaults? Widgets will be reset as well!', $this -> plugin_name); ?>')) { return false; }" href="?page=checkout-settings&amp;method=reset" title="<?php _e('Reset all settings to their defaults', $this -> plugin_name); ?>" class="delete"><?php _e('Reset to Defaults', $this -> plugin_name); ?></a>
			</div>
		</div>
	</div>
	<div id="major-publishing-actions">
		<div id="publishing-action">
			<input class="button button-primary button-large" type="submit" name="save" value="<?php _e('Save Configuration', $this -> plugin_name); ?>" />
		</div>
		<br class="clear" />
	</div>
</div>