<div class="wrap <?php echo $this -> pre; ?> <?php echo $this -> sections -> products; ?>">
	<h2><?php _e('Manage Products', $this -> plugin_name); ?> <?php echo $wpcoHtml -> link(__('Add New', $this -> plugin_name), '?page=checkout-products-save', array('class' => "button add-new-h2")); ?></h2>
    <form id="posts-filter" action="<?php echo $this -> url; ?>" method="post">
        <?php if (!empty($products)) : ?>
            <ul class="subsubsub">
                <?php if (!empty($products)) : ?>
                    <li><?php echo $wpcoHtml -> link(__('Delete All', $this -> plugin_name), '?page=checkout-products&amp;method=purge', array('class' => "delete", 'onclick' => "if (!confirm('" . __('Are you sure you wish to permanently remove all products in the database?', $this -> plugin_name) . "')) { return false; }")); ?> |</li>
                <?php endif; ?>
                <li><?php echo $paginate -> allcount; ?> <?php _e('products', $this -> plugin_name); ?></li>
            </ul>
        <?php endif; ?>
        <p class="search-box">
            <input type="text" name="searchterm" class="search-input" id="post-search-input" value="<?php echo (empty($_POST['searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : $_POST['searchterm']; ?>" />
            <input type="submit" name="search" value="<?php _e('Search Products', $this -> plugin_name); ?>" class="button" />
        </p>
    </form>
    
    <?php if (!$this -> is_supplier()) : ?>
    	<br class="clear" />
        <form id="posts-filters" action="" method="post">
            <div class="alignleft">
                <?php _e('Filters:', $this -> plugin_name); ?>
                
                <!-- Status -->
                <select name="status" onchange="change_filter('status', jQuery(this).val());">
                    <option value=""><?php _e('All Status', $this -> plugin_name); ?></option>
                    <option <?php echo (!empty($filters['status']) && $filters['status'] == "active") ? 'selected="selected"' : ''; ?> value="active"><?php _e('Active Products', $this -> plugin_name); ?></option>
                    <option <?php echo (!empty($filters['status']) && $filters['status'] == "inactive") ? 'selected="selected"' : ''; ?> value="inactive"><?php _e('Inactive Products', $this -> plugin_name); ?></option>
                </select>
                
                <!-- Type -->
                <select name="type" onchange="change_filter('type', jQuery(this).val());">
                    <option value=""><?php _e('All Types', $this -> plugin_name); ?></option>
                    <option <?php echo (!empty($filters['type']) && $filters['type'] == "digital") ? 'selected="selected"' : ''; ?> value="digital"><?php _e('Digital Products', $this -> plugin_name); ?></option>
                    <option <?php echo (!empty($filters['type']) && $filters['type'] == "tangible") ? 'selected="selected"' : ''; ?> value="tangible"><?php _e('Tangible Products', $this -> plugin_name); ?></option>
                </select>
                
                <!-- Price Type -->
                <select name="price_type" onchange="change_filter('price_type', jQuery(this).val());">
                    <option value=""><?php _e('All Price Types', $this -> plugin_name); ?></option>
                    <option <?php echo (!empty($filters['price_type']) && $filters['price_type'] == "fixed") ? 'selected="selected"' : ''; ?> value="fixed"><?php _e('Fixed Price Products', $this -> plugin_name); ?></option>
                    <option <?php echo (!empty($filters['price_type']) && $filters['price_type'] == "tiers") ? 'selected="selected"' : ''; ?> value="tiers"><?php _e('Tiered Price Products', $this -> plugin_name); ?></option>
                </select>
                
                <!-- Post/Page Type -->
                <select name="p_type" onchange="change_filter('p_type', jQuery(this).val());">
                    <option value=""><?php _e('All Post/Page Types', $this -> plugin_name); ?></option>
                    <option <?php echo (!empty($filters['p_type']) && $filters['p_type'] == "post") ? 'selected="selected"' : ''; ?> value="post"><?php _e('Post Products', $this -> plugin_name); ?></option>
                    <option <?php echo (!empty($filters['p_type']) && $filters['p_type'] == "page") ? 'selected="selected"' : ''; ?> value="page"><?php _e('Page Products', $this -> plugin_name); ?></option>
                </select> 
                
                <input type="submit" name="filter" value="<?php _e('Filter', $this -> plugin_name); ?>" class="button-secondary" />
            </div>
        </form>
    <?php endif; ?>
    
    <br class="clear" />
    
    <script type="text/javascript">
    function change_filter(filtername, filtervalue) {			
        if (filtername != "") {
            document.cookie = "<?php echo $this -> pre; ?>filter_" + filtername + "=" + filtervalue + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> UTC; path=/";
        }
    }
    </script>
	<?php $this -> render('products' . DS . 'loop', array('products' => $products, 'paginate' => $paginate)); ?>
</div>