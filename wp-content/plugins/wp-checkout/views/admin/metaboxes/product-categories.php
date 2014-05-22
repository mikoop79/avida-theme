<div class="submitbox" id="submitpost">						
	<div id="minor-publishing">
		<div id="misc-publishing-actions">
			<div id="categories-div" class="misc-pub-section">
				<?php $this -> render('categories' . DS . 'product-categories', array('product_id' => $Product -> data -> id), true, 'admin'); ?>
			</div>
            <?php if (!$this -> is_supplier()) : ?>
                <div id="categories-div" class="misc-pub-section">
                    <strong><?php _e('Product Status:', $this -> plugin_name); ?></strong>
                    <?php $price_status = array('active' => __('Active', $this -> plugin_name), 'inactive' => __('Inactive', $this -> plugin_name)); ?>
                    <?php echo $wpcoForm -> radio('Product.status', $price_status, array('separator' => false, 'default' => "active")); ?>
                </div>
            <?php endif; ?>
            <div class="misc-pub-section">
            	<strong><?php _e('Showcase Product:', $this -> plugin_name); ?></strong>
                <?php $showcase = array('Y' => __('Yes', $this -> plugin_name), 'N' => __('No', $this -> plugin_name)); ?>
                <?php echo $wpcoForm -> radio('Product.showcase', $showcase, array('separator' => false, 'default' => "N", 'onclick' => "jQuery('#showcasemsgdiv').toggle();")); ?>
                <br/><small><?php _e('A showcase product is NOT for sale.', $this -> plugin_name); ?></small>
            </div>
            <div id="showcasemsgdiv" style="display:<?php echo ($wpcoHtml -> field_value('Product.showcase') == "Y") ? 'block' : 'none'; ?>;" class="misc-pub-section misc-pub-section-last">
            	<strong><?php _e('Showcase Message:', $this -> plugin_name); ?></strong>
                <?php echo $wpcoForm -> text('Product.showcasemsg', array('default' => $this -> get_option('showcasemsg'))); ?>
            </div>
            <div class="misc-pub-section">
            	<label><input <?php echo (!empty($Product -> data -> featured)) ? 'checked="checked"' : ''; ?> type="checkbox" name="Product[featured]" value="1" id="Product_featured" /> <?php _e('Featured product', $this -> plugin_name); ?></label>
            </div>
		</div>
	</div>
	<div id="major-publishing-actions">
		<div id="delete-action">
			<a onclick="if (!confirm('<?php _e('Are you sure you want to delete this product?', $this -> plugin_name); ?>')) { return false; }" class="submitdelete deletion" href="?page=<?php echo $this -> sections -> products; ?>&amp;method=delete&amp;id=<?php echo $_GET['id']; ?>"><?php _e('Delete Product', $this -> plugin_name); ?></a>
		</div>
		<div id="publishing-action">
			<input class="button button-primary button-large" type="submit" name="save" value="<?php _e('Save Product', $this -> plugin_name); ?>" />
		</div>
		<br class="clear" />
		<div style="text-align:right; margin:15px 0 5px 0;">
			<label><input style="min-width:0;" <?php echo (!empty($_REQUEST['continueediting'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="continueediting" value="1" id="continueediting" /> <?php _e('Continue editing?', $this -> plugin_name); ?></label>
		</div>
	</div>
</div>