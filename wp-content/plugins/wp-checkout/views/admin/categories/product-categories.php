<?php if (!empty($message)) : ?>
	<?php $this -> render_msg($message); ?>
<?php endif; ?>

<?php if ($categories = $Category -> select()) : ?>
    <div><label class="selectit" style="font-weight:bold;"><input type="checkbox" id="checkboxall" name="checkboxall" value="checkboxall" /> <?php _e('Check All', $this -> plugin_name); ?></label></div>
    <div><label class="selectit" style="font-weight:bold;"><input type="checkbox" id="checkinvert" name="checkinvert" value="checkinvert" /> <?php _e('Inverse Selection', $this -> plugin_name); ?></label></div>
    <div class="scroll-list scroll-list-short">        
        <?php
		
		$wpcoDb -> model = $Product -> model;
		if ($product = $wpcoDb -> find(array('id' => $product_id))) {
			$cats = $wpcoHtml -> field_value('Product.categories');
		}
		
		?>
        
        <?php foreach ($categories as $id => $title) : ?>
            <div><label class="selectit"><input type="checkbox" <?php echo ((!empty($cats) && is_array($cats) && in_array($id, $cats)) || (!empty($insertid) && $insertid == $id)) ? 'checked="checked"' : ''; ?> name="Product[categories][]" id="checklist<?php echo $id; ?>" value="<?php echo $id; ?>" /> <?php echo $wpcoHtml -> truncate($title, 30); ?><?php if (!$this -> is_supplier() || ($this -> is_supplier() && $this -> get_option('suppliercategories') == "Y")) : ?> <a class="wpco_deletecategory" href="#void" title="<?php _e('Delete Category', $this -> plugin_name); ?>" onclick="if (confirm('<?php _e('Are you sure you want to delete this category?', $this -> plugin_name); ?>')) { wpco_category_delete('<?php echo $product -> id; ?>', '<?php echo $id; ?>'); }">Delete Category</a><?php endif; ?></label></div>
        <?php endforeach; ?>
    </div>
    <?php echo $wpcoHtml -> field_error('Product.categories', "p"); ?>
<?php else : ?>
    <p class="<?php echo $this -> pre; ?>error"><?php _e('Categories needed to save a product', $this -> plugin_name); ?></p>
<?php endif; ?>

<?php if (!$this -> is_supplier() || ($this -> is_supplier() && $this -> get_option('suppliercategories') == "Y")) : ?>
    <div id="category-adder">
        <div><a class="button button-secondary" onclick="jQuery('#category-add').toggle(); jQuery('#category_title').focus(); return false;" id="category-add-toggle" href=""><?php _e('Add New Category', $this -> plugin_name); ?></a></div>
        <div id="category-add" style="display:none;">
            <p>
                <label>
                    <?php _e('Category Name:', $this -> plugin_name); ?><br/>
                    <input class="form-required widefat" onkeydown="if (event.keyCode == 13) { wpco_category_add('<?php echo $product -> id; ?>'); return false; }" type="text" name="category_title" value="" id="category_title" />
                </label>
            </p>
            <p>
                <label>
                    <?php _e('Category Parent:', $this -> plugin_name); ?><br/>
                    <select class="postform widefat" name="category_parent" id="category_parent">
                        <option value=""><?php _e('- Select -', $this -> plugin_name); ?></option>
                        <?php if ($categories = $Category -> select()) : ?>
                            <?php foreach ($categories as $id => $title) : ?>
                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </label>
            </p>
            <input class="button button-secondary" type="button" onclick="wpco_category_add('<?php echo $product -> id; ?>');" name="add" value="<?php _e('Save Category', $this -> plugin_name); ?>" />
            <span id="category-add-loading" style="display:none;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" /></span>
        </div>
    </div>
<?php endif; ?>