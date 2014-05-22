<div class="submitbox" id="submitpost">
	<div id="misc-publishing-actions">
		<div class="misc-pub-section">
			<p>
				<?php if ($products = $Product -> select()) : ?>
					<?php echo $wpcoForm -> select('wpcoContent.product_id', $products, array('width' => "100%")); ?>
				<?php else : ?>
					<p class="<?php echo $this -> pre; ?>error"><?php _e('No products available', $this -> plugin_name); ?></p>
				<?php endif; ?>
			</p>
		</div>
	</div>
	<div id="major-publishing-actions">
		<?php if (!empty($wpcoContent -> data -> id)) : ?>		
			<div id="delete-action">
				<a class="submitdelete deletion" onclick="if (!confirm('<?php _e('Are you sure you wish to remove this content permanently?', $this -> plugin_name); ?>')) { return false; };" href="<?php echo $this -> url; ?>&amp;method=delete&amp;id=<?php echo $wpcoContent -> data -> id; ?>" title="<?php _e('Remove this content from the system', $this -> plugin_name); ?>"><?php _e('Remove Content', $this -> plugin_name); ?></a>
			</div>
		<?php endif; ?>
		<div id="publishing-action">
			<input class="button button-primary button-large" type="submit" name="save" value="<?php _e('Save Content', $this -> plugin_name); ?>" />
		</div>
		<br class="clear" />
	</div>
</div>