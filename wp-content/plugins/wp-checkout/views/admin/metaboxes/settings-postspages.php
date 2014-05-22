<table class="form-table">
    <tbody>
    	<tr>
    		<th><label for="rawsupportN"><?php _e('RAW Support', $this -> plugin_name); ?></label></th>
    		<td>
    			<label><input <?php echo ($this -> get_option('rawsupport') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="rawsupport" value="Y" id="rawsupportY" /> <?php _e('On', $this -> plugin_name); ?></label>
    			<label><input <?php echo ($this -> get_option('rawsupport') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="rawsupport" value="N" id="rawsupportN" /> <?php _e('Off', $this -> plugin_name); ?></label>
    			<span class="howto"><?php _e('Some themes require the use of [raw] tags around shortcodes. Turn this on if your theme uses [raw] tags.', $this -> plugin_name); ?></span>
    		</td>
    	</tr>
    	<tr>
        	<th><label for="allproductsppid"><?php _e('Shop Front Page', $this -> plugin_name); ?></label></th>
            <td>
            	<!-- allproductsppid -->
            	<?php wp_dropdown_pages(array('depth' => 0, 'child_of' => 0, 'selected' => $this -> get_option('allproductsppid'), 'echo' => 1, 'name' => "allproductsppid", 'show_option_none' => false)); ?>
            	<span class="howto"><?php _e('WordPress page containing <code>[wpcoproducts]</code> in it.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="cartpage_id"><?php _e('Shopping Cart Page', $this -> plugin_name); ?></label></th>
            <td>
            	<!-- cartpage_id -->
            	<?php wp_dropdown_pages(array('depth' => 0, 'child_of' => 0, 'selected' => $this -> get_option('cartpage_id'), 'echo' => 1, 'name' => "cartpage_id", 'show_option_none' => false)); ?>
            	<span class="howto"><?php _e('WordPress page containing <code>[wpcocart]</code> in it.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="accountpage_id"><?php _e('Customer Account Page', $this -> plugin_name); ?></label></th>
            <td>
            	<!-- accountpage_id -->
                <?php wp_dropdown_pages(array('depth' => 0, 'child_of' => 0, 'selected' => $this -> get_option('accountpage_id'), 'echo' => 1, 'name' => "accountpage_id", 'show_option_none' => false)); ?>
                <span class="howto"><?php _e('WordPress page containing <code>[wpcoaccount]</code> in it. This page will show customer account information, orders history and more.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="searchpage_id"><?php _e('Search Page', $this -> plugin_name); ?></label></th>
        	<td>
        		<!-- searchpage_id -->
        		<?php wp_dropdown_pages(array('depth' => 0, 'child_of' => 0, 'selected' => $this -> get_option('searchpage_id'), 'echo' => 1, 'name' => "searchpage_id", 'show_option_none' => false)); ?>
        		<span class="howto"><?php _e('WordPress page containing <code>[wpcosearch]</code> in it. This page is used for searching products.', $this -> plugin_name); ?></span>
        	</td>
        </tr>
        <?php /*
        <tr>
			<th><label for=""><?php _e('Categories Parent', $this -> plugin_name); ?></label></th>
			<td>
				<?php wp_dropdown_categories(array('hide_empty' => 0, 'name' => 'categoriesparent', 'orderby' => 'name', 'selected' => $this -> get_option('categoriesparent'), 'hierarchical' => true, 'show_option_none' => __('None', $this -> plugin_name))); ?>
			</td>
		</tr>
		<tr>
			<th><?php _e('Create Posts/Pages', $this -> plugin_name); ?></th>
			<td>
				<label><input <?php echo ($this -> get_option('createpages') == "Y") ? 'checked="checked"' : ''; ?> onclick="jQuery('#createpages_div').show();" type="radio" name="createpages" value="Y" /> <?php _e('Yes (recommended)', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('createpages') == "N") ? 'checked="checked"' : ''; ?> onclick="jQuery('#createpages_div').hide();" type="radio" name="createpages" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('It is recommended that you leave this turned on.', $this -> plugin_name); ?></span>
				<span class="howto"><?php _e('Click the "Update all shop posts/taxonomies" link to the right after changing &amp; saving.', $this -> plugin_name); ?></span>
			</td>
		</tr>*/ ?>
	</tbody>
</table>

<?php /*<div id="createpages_div" style="display:<?php echo ($this -> get_option('createpages') == "Y") ? 'block' : 'none'; ?>;">*/ ?>
<div id="createpages_div" style="display:block;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="pp_updatecontent_N"><?php _e('Update Content', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($this -> get_option('pp_updatecontent') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="pp_updatecontent" value="Y" id="pp_updatecontent_Y" /> <?php _e('Yes, the actual content as well.', $this -> plugin_name); ?></label><br/>
					<label><input <?php echo ($this -> get_option('pp_updatecontent') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="pp_updatecontent" value="N" id="pp_updatecontent_N" /> <?php _e('No, just the title, parent, etc.', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('by default, the titles, structure and other aspects are automatically updated. should post/page content be updated as well? You may want to turn this off if you put custom content in the posts/pages.', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="post_type_custom"><?php _e('Default Post Type', $this -> plugin_name); ?></label></th>
				<td>
					<label><input onclick="jQuery('#posttype_div').hide();" <?php echo ($this -> get_option('post_type') == "post") ? 'checked="checked"' : ''; ?> type="radio" name="post_type" value="post" /> <?php _e('Post', $this -> plugin_name); ?></label>
					<label><input onclick="jQuery('#posttype_div').show();" <?php echo ($this -> get_option('post_type') == "page") ? 'checked="checked"' : ''; ?> type="radio" name="post_type" value="page" /> <?php _e('Page', $this -> plugin_name); ?></label>
					<label><input onclick="jQuery('#posttype_div').hide();" <?php echo ($this -> get_option('post_type') == "custom") ? 'checked="checked"' : ''; ?> type="radio" name="post_type" value="custom" id="post_type_custom" /> <?php _e('Custom Post', $this -> plugin_name); ?></label>
					<span class="howto">
						<?php _e('For a site with 50+ products, it is recommended that you use "<strong>Post</strong>" (not "Page") for performance', $this -> plugin_name); ?>
						<?php _e('Click the "Update all WP pages" link to the right after changing &amp; saving', $this -> plugin_name); ?>
					</span>
				</td>
			</tr>
		</tbody>
	</table>

	<div id="posttype_div" style="display:<?php echo ($this -> get_option('post_type') == "page") ? 'block' : 'none'; ?>;">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="<?php echo $this -> pre; ?>pagesparent"><?php _e('Pages Parent', $this -> plugin_name); ?></label></th>
					<td>
						<select class="widefat" style="width:auto;" id="<?php echo $this -> pre; ?>pagesparent" name="pagesparent">
							<option value="0">- <?php _e('Main (no parent)', $this -> plugin_name); ?> -</option>
							<?php parent_dropdown($this -> get_option('pagesparent')); ?>
						</select>
						<span class="howto"><?php _e('Click the "Update all WP pages" link to the right after changing &amp; saving', $this -> plugin_name); ?></span>
					</td>
				</tr>
                <tr>
                	<th><label for="products_pagetemplate"><?php _e('Products Page Template', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php $products_pagetemplate = $this -> get_option('products_pagetemplate'); ?>
                        <select name="products_pagetemplate" id="products_pagetemplate">
                        	<option value="default"><?php _e('Default Template', $this -> plugin_name); ?></option>
                    		<?php page_template_dropdown($products_pagetemplate); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                	<th><label for="categories_pagetemplate"><?php _e('Categories Page Template', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php $categories_pagetemplate = $this -> get_option('categories_pagetemplate'); ?>
                        <select name="categories_pagetemplate" id="categories_pagetemplate">
                        	<option value="default"><?php _e('Default Template', $this -> plugin_name); ?></option>
                            <?php page_template_dropdown($categories_pagetemplate); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                	<th><label for="suppliers_pagetemplate"><?php _e('Suppliers Page Template', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php $suppliers_pagetemplate = $this -> get_option('suppliers_pagetemplate'); ?>
						<select name="suppliers_pagetemplate" id="suppliers_pagetemplate">
                        	<option value="default"><?php _e('Default Template', $this -> plugin_name); ?></option>
                            <?php page_template_dropdown($suppliers_pagetemplate); ?>
                        </select>
                    </td>
                </tr>
			</tbody>
		</table>
	</div>
</div>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="edimagespost"><?php _e('Images Post ID', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" name="edimagespost" value="<?php echo esc_attr(stripslashes($this -> get_option('edimagespost'))); ?>" id="edimagespost" style="width:65px;" />
            	<span class="howto"><?php _e('Post ID to save images to through the media uploader.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>