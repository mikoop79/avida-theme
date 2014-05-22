<p>Good day Administrator,</p>

<p>A supplier named <strong><?php echo $supplier -> name; ?></strong> saved a product on your <strong><?php echo get_bloginfo('name'); ?></strong> website.</p>
<p>The product is titled <strong><?php echo apply_filters($this -> pre . '_product_title', $product -> title); ?></strong>. You need to review and activate the product in order to publish it to your shop.</p>
<p><a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=<?php echo $this -> sections -> products_save; ?>&amp;id=<?php echo $product -> id; ?>"><?php _e('Click to review and publish this product now', $this -> plugin_name); ?></a></p>

<p>
All the best,<br/>
<?php echo get_bloginfo('name'); ?>
</p>