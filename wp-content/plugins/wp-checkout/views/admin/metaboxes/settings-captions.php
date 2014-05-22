<p><?php _e('Each of the settings below has a string in quotes which is the default value shown on the front-end. You can change the text shown by editing the value and saving the configuration settings.', $this -> plugin_name); ?></p>

<h4><?php _e('Products', $this -> plugin_name); ?></h4>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="captions_product_keywords"><?php _e('Product "Keywords"', $this -> plugin_name); ?></label></th>
			<td><input type="text" class="widefat" name="captions[product][keywords]" value="<?php echo $wpcocaptions['product']['keywords']; ?>" id="captions_product_keywords" /></td>
		</tr>
		<tr>
			<th><label for="captions_product_supplier"><?php _e('Product "Supplier"', $this -> plugin_name); ?></label></th>
			<td><input type="text" class="widefat" name="captions[product][supplier]" value="<?php echo $wpcocaptions['product']['supplier']; ?>" id="captions_product_supplier" /></td>
		</tr>
		<tr>
			<th><label for="captions_product_category"><?php _e('Product "Category"', $this -> plugin_name); ?></label></th>
			<td><input type="text" class="widefat" name="captions[product][category]" value="<?php echo $wpcocaptions['product']['category']; ?>" id="captions_product_category" /></td>
		</tr>
		<tr>
			<th><label for="captions_product_categories"><?php _e('Product "Categories"', $this -> plugin_name); ?></label></th>
			<td><input type="text" class="widefat" name="captions[product][categories]" value="<?php echo $wpcocaptions['product']['categories']; ?>" id="captions_product_categories" /></td>
		</tr>
		<tr>
			<th><label for="captions_product_clicktoenlarge"><?php _e('Product "Click to Enlarge"', $this -> plugin_name); ?></label></th>
			<td><input type="text" class="widefat" name="captions[product][clicktoenlarge]" value="<?php echo $wpcocaptions['product']['clicktoenlarge']; ?>" id="captions_product_clicktoenlarge" /></td>
		</tr>
		<tr>
			<th><label for="captions_product_oos"><?php _e('Out of Stock', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" class="widefat" name="captions[product][oos]" value="<?php echo $wpcocaptions['product']['oos']; ?>" id="captions_product_oos" />
			</td>
		</tr>
	</tbody>
</table>