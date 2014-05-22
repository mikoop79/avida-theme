<?php $Product -> data -> supplier_id = $supplier_id; ?>

<?php if ($suppliers = $Supplier -> select()) : ?>
	<?php echo $wpcoForm -> select('Product.supplier_id', $suppliers); ?>
	<span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('Assign this product to be organized into a specific supplier.', $this -> plugin_name); ?></span>
<?php else : ?>
	<span class="<?php echo $this -> pre; ?>error"><?php _e('No suppliers are available', $this -> plugin_name); ?></span>
<?php endif; ?>

<div><a class="button button-secondary" onclick="jQuery('#supplier-add').toggle(); jQuery('#supplier_name').focus();" href="#void" title="<?php _e('Add New Supplier', $this -> plugin_name); ?>" id="supplier-add-toggle"><?php _e('Add New Supplier', $this -> plugin_name); ?></a></div>

<div id="supplier-add" style="display:none;">
	<?php $this -> render('errors', array('errors' => $errors), true, 'admin'); ?>

	<p>
		<label>
			<?php _e('Supplier Name:', $this -> plugin_name); ?><br/>
			<input style="width:250px;" type="text" onkeydown="if (event.keyCode == 13) { wpco_supplier_add(); return false; }" name="supplier_name" value="<?php echo esc_attr(stripslashes($supplier_add_name)); ?>" id="supplier_name" />
		</label>
	</p>
	<input type="button" class="button" name="button" onclick="wpco_supplier_add();" value="<?php _e('Save Supplier', $this -> plugin_name); ?>" />
    <span id="supplier-add-loading" style="display:none;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" alt="loading" /></span>
</div>