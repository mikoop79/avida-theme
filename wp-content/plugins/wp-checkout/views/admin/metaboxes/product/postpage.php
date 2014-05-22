<?php if (!$this -> is_supplier()) : ?>
	<?php if ($this -> get_option('createpages') == "Y") : ?>
        <div id="p_type-div" class="misc-pub-section misc-pub-section-last">
            <strong><?php _e('Create Post/Page:', $this -> plugin_name); ?></strong><br/>
            <?php $p_type = array('post' => __('Post', $this -> plugin_name), 'page' => __('Page', $this -> plugin_name), 'custom' => __('Custom Post', $this -> plugin_name)); ?>
            <?php $product_p_type = (!empty($Product -> data -> p_type)) ? $Product -> data -> p_type : $this -> get_option('post_type'); ?>
            <?php echo $wpcoForm -> radio('Product.p_type', $p_type, array('separator' => false, 'default' => $product_p_type, 'onclick' => "selectDd(this.value);")); ?>

            <script type="text/javascript">
            function selectDd(p_type) {
            	jQuery('#pagediv').hide();
            	jQuery('#postdiv').hide();
            
                if (p_type == "post") {
                    jQuery('#postdiv').show();
                } else if (p_type == "page") {
                    jQuery('#pagediv').show();
                }					
            }
            </script>
        </div>
        
        <?php $p_type = $wpcoHtml -> field_value('Product.p_type'); ?>
        <?php if (empty($p_type)) { $p_type = $this -> get_option('post_type'); } ?>
        <!-- Page for this product -->
        <div id="pagediv" class="misc-pub-section misc-pub-section-last" style="display:<?php echo ($p_type == "page") ? 'block' : 'none'; ?>;">
            <p>
                <label for="Product.productpage" style="font-weight:bold;"><?php _e('Page:', $this -> plugin_name); ?></label><br/>
                <?php
                    $select = wp_dropdown_pages(array('depth' => 0, 'child_of' => 0, 'style' => "max-width:260px;", 'selected' => $Product -> data -> post_id, 'echo' => 1, 'name' => "productpage", 'show_option_none' => true, 'show_option_no_change' => __('- Create New Page -', $this -> plugin_name), 'echo' => false));
                    $select = preg_replace("#<select([^>]*)>#", '<select id="Product.productpage" name="productpage" style="max-width:260px;">', $select);
                    echo $select;
                ?>			
            
            <p>
                <label for="Product.page_template" style="font-weight:bold;"><?php _e('Page Template:', $this -> plugin_name); ?></label><br/>
                <?php $default_products_pagetemplate = $this -> get_option('products_pagetemplate'); ?>
                <?php $current_products_pagetemplate = $wpcoHtml -> field_value('Product.page_template'); ?>
                <?php $products_pagetemplate = (empty($current_products_pagetemplate)) ? $default_products_pagetemplate : $current_products_pagetemplate; ?>
                <select name="Product[page_template]" id="Product.page_template">
                    <option value=""><?php _e('Default Template', $this -> plugin_name); ?></option>
                    <?php page_template_dropdown($products_pagetemplate); ?>
                </select>
            </p>
        </div>
        
        <!-- Post for this product -->
        <div id="postdiv" class="misc-pub-section misc-pub-section-last" style="display:<?php echo ($p_type == "post") ? 'block' : 'none'; ?>;">
            <p>
                <label for="Product.productpost" style="font-weight:bold;"><?php _e('Post ID:', $this -> plugin_name); ?></label><br/>
                <?php $post_id = $wpcoHtml -> field_value('Product.post_id'); ?>
                <?php $productpost = (empty($post_id)) ? "-1" : $post_id; ?>
                <input class="widefat" style="width:65px;" type="text" name="productpost" id="Product.productpost" value="<?php echo stripslashes($productpost); ?>" />	
                
                <?php if (!empty($productpost)) : ?>
                    <br/><small><a href="" onclick="if (confirm('<?php _e('Are you sure you want to convert this product post to a page?\nThe page will be refreshed and unsaved data will be lost!', $this -> plugin_name); ?>')) { wpcoConvertPostType('<?php echo $wpcoHtml -> field_value('Product.id'); ?>', '<?php echo $productpost; ?>', 'page'); } return false;" title="<?php _e('Convert to PAGE', $this -> plugin_name); ?>"><?php _e('Convert to PAGE', $this -> plugin_name); ?></a></small>
                    <span id="convertposttopageloading" style="display:none;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" alt="loading" /> <?php _e('loading...', $this -> plugin_name); ?></span>
                <?php endif; ?>
                
                <br/><small><?php _e('Make this value -1 to create a new post.', $this -> plugin_name); ?></small>
            </p>                        
            <p>
                <label for="categoriesselectall" style="font-weight:bold;"><?php _e('Post Categories:', $this -> plugin_name); ?></label>
                <?php if ($categories = get_categories(array('hide_empty' => 0, 'hierarchical' => true))) : ?>
                    <?php $pp_categories = maybe_unserialize($wpcoHtml -> field_value('Product.post_category')); ?>
                    <div>
                        <input type="checkbox" name="categoriesselectall" value="1" id="categoriesselectall" onclick="jqCheckAll(this, '<?php echo $this -> sections -> products_save; ?>', 'Product[post_category]');" />
                        <label for="categoriesselectall"><strong><?php _e('Select All', $this -> plugin_name); ?></strong></label>
                    </div>
                    <div class="scroll-list">
                        <?php foreach ($categories as $category) : ?>
                            <label><input <?php echo (!empty($pp_categories) && in_array($category -> cat_ID, $pp_categories)) ? 'checked="checked"' : ''; ?> type="checkbox" name="Product[post_category][]" value="<?php echo $category -> cat_ID; ?>" id="checklist<?php echo $category -> cat_ID; ?>" /> <?php echo $category -> cat_name; ?></label><br/>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="<?php echo $this -> pre; ?>error"><?php _e('No categories are available.', $this -> plugin_name); ?></div>
                <?php endif; ?>
            </p>
        </div>
        <div class="misc-pub-section">
        	<p>
            	<label>
					<strong><?php _e('Post/Page Password:', $this -> plugin_name); ?></strong>
                	<input type="text" name="Product[post_password]" value="<?php echo esc_attr(stripslashes($wpcoHtml -> field_value('Product.post_password'))); ?>" id="Product.post_password" />
                    <br/><small><?php _e('You can password protect this post/page.', $this -> plugin_name); ?></small>
                </label>
            </p>
        </div>
        <div class="misc-pub-section misc-pub-section-last">
        	<p>
            	<label>
            		<?php $comment_status = $wpcoHtml -> field_value('Product.comment_status'); ?>
					<strong><?php _e('Comment Status:', $this -> plugin_name); ?></strong>
                	<label><input <?php echo (empty($comment_status) || $comment_status == "open") ? 'checked="checked"' : ''; ?> type="radio" name="Product[comment_status]" value="open" id="Product.comment_status.open" /> <?php _e('Open', $this -> plugin_name); ?></label>
                	<label><input <?php echo (!empty($comment_status) && $comment_status == "closed") ? 'checked="checked"' : ''; ?> type="radio" name="Product[comment_status]" value="closed" id="Product.comment_status.open" /> <?php _e('Closed', $this -> plugin_name); ?></label>
                    <br/><small><?php _e('Turn On/Off Comments.', $this -> plugin_name); ?></small>
                </label>
            </p>
        </div>
        <div class="misc-pub-section misc-pub-section-last">
            <small><?php _e('<b>PLEASE NOTE:</b> When choosing an existing post/page, you must manually insert the shortcode into that post/page. Else choose "Create New..." to automatically create a post/page.', $this -> plugin_name); ?></small>
        </div>
    <?php endif; ?>
<?php endif; ?>