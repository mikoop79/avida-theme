<?php if (!empty($fields)) : ?>
	<label style="font-weight:bold;"><input onclick="jqCheckAll(this, false, 'Product[fields]');" type="checkbox" name="cfieldsselectall" value="1" id="cfieldsselectall" /> <?php _e('Select All', $this -> plugin_name); ?></label>
	<div class="scroll-list">
		<ul>
			<?php foreach ($fields as $field) : ?>
				<li>
					<label><input <?php echo (!empty($fieldsproducts) && in_array($field -> id, $fieldsproducts)) ? 'checked="checked"' : ''; ?> type="checkbox" name="Product[fields][]" value="<?php echo $field -> id; ?>" id="Product_fields_<?php echo $field -> id; ?>" /> <?php echo $field -> title; ?></label>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No custom fields are available', $this -> plugin_name); ?></p>
<?php endif; ?>