<?php if ($this -> get_option('tax_calculate') == "Y" && !empty($product -> taxexempt) && $product -> taxexempt == "N") : ?>
	<!-- Show the product price INCLUDING TAX -->
	<?php if ($this -> get_option('tax_includeinproductprice') == "Y") : ?>
    	<span class="producttax">(<?php _e('Incl.', $this -> plugin_name); ?> <?php echo $this -> get_option('tax_name'); ?> <?php echo $Product -> tax_percentage; ?>&#37;)</span>
    <!-- Show the product price EXCLUDING TAX -->
    <?php else : ?>
		<span class="producttax">(<?php _e('Excl.', $this -> plugin_name); ?> <?php echo $this -> get_option('tax_name'); ?>)</span>
    <?php endif; ?>
<?php elseif (!empty($product -> taxexempt) && $product -> taxexempt == "Y") : ?>
	<span class="producttax">(<?php _e('Tax Exempt', $this -> plugin_name); ?>)</span>
<?php endif; ?>