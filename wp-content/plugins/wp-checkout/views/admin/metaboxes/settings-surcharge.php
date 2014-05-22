<!-- Handling & Surcharge Settings -->
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="handling_N"><?php _e('Handling/Surcharge', $this -> plugin_name); ?></label>
			<?php echo $wpcoHtml -> help(__('Add a handling/surcharge fee to each order automatically.', $this -> plugin_name)); ?></th>
			<td>
				<label><input onclick="jQuery('#handling_div').show();" <?php echo ($this -> get_option('handling') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="handling" value="Y" id="handling_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#handling_div').hide();" <?php echo ($this -> get_option('handling') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="handling" value="N" id="handling_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Turn On/Off the handling/surchage fee on orders with this setting.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>

<div id="handling_div" style="display:<?php echo ($this -> get_option('handling') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="handling_title"><?php _e('Title/Caption', $this -> plugin_name); ?></label></th>
				<td>
					<input type="text" name="handling_title" value="<?php echo esc_attr(stripslashes($this -> get_option('handling_title'))); ?>" id="handling_title" class="widefat" />
					<span class="howto"><?php _e('Choose the title/caption to display to your customers as the description of the charge.', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="handling_amount"><?php _e('Amount', $this -> plugin_name); ?></label>
				<?php echo $wpcoHtml -> help(__('This is the amount which will be added to the order as handling/surcharge.', $this -> plugin_name)); ?></th>
				<td>
					<?php echo $wpcoHtml -> currency_html('<input class="widefat" style="width:65px;" type="text" name="handling_amount" value="' . esc_attr(stripslashes($this -> get_option('handling_amount'))) . '" id="handling_amount" />'); ?>
					<span class="howto"><?php _e('The amount for the handling/surcharge to be applied to the order.', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="handling_calculation_always"><?php _e('Calculation', $this -> plugin_name); ?></label>
				<?php echo $wpcoHtml -> help(__('When exactly and how should the calculation be done? Should it always apply, only for products from certain categories or certain products overall? Choose what suits your needs the best.', $this -> plugin_name)); ?></th>
				<td>
					<label><input <?php echo ($this -> get_option('handling_calculation') == "always") ? 'checked="checked"' : ''; ?> onclick="change_handling_calculation(this.value);" type="radio" name="handling_calculation" value="always" id="handling_calculation_always" /> <?php _e('Always', $this -> plugin_name); ?></label>
					<label><input <?php echo ($this -> get_option('handling_calculation') == "categories") ? 'checked="checked"' : ''; ?> onclick="change_handling_calculation(this.value);" type="radio" name="handling_calculation" value="categories" id="handling_calculation_categories" /> <?php _e('By Categories', $this -> plugin_name); ?></label>
					<?php /*<label><input <?php echo ($this -> get_option('handling_calculation') == "products") ? 'checked="checked"' : ''; ?> onclick="change_handling_calculation(this.value);" type="radio" name="handling_calculation" value="products" id="handling_calculation_products" /> <?php _e('By Products', $this -> plugin_name); ?></label>*/ ?>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div id="handling_calculation_categories_div" style="display:<?php echo ($this -> get_option('handling_calculation') == "categories") ? 'block' : 'none'; ?>;">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="categoryautocomplete"><?php _e('Categories', $this -> plugin_name); ?></label>
					<?php echo $wpcoHtml -> help(__('Specify categories to which the handling/surcharge will apply. When a customer has any product(s) from any of the chosen categories in the shopping cart, the handling/surcharge will be applied. Start typing a category title and a dropdown will appear with results so you can choose/select.', $this -> plugin_name)); ?></th>
					<td>
						<input type="text" name="category" value="" id="categoryautocomplete" />
						
						<?php $categories = maybe_unserialize($this -> get_option('handling_categories')); ?>
						<div id="categoriestaglist" style="display:<?php echo (!empty($categories)) ? 'block' : 'none'; ?>;">
							<ul class="taglist">
								<?php if ($categories) : ?>
									<?php foreach ($categories as $category) : ?>
										<li class="button">
											<span class="hidden"><input type="hidden" name="handling_categories[]" value="<?php echo $category; ?>" /></span>
											<span class="label"><?php echo __($Category -> field('title', array('id' => $category))); ?></span>
											<span class="delete"></span>
										</li>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="handling_calculation_products_div" style="display:<?php echo ($this -> get_option('handling_calculation') == "products") ? 'block' : 'none'; ?>;">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for=""><?php _e('Products', $this -> plugin_name); ?></label></th>
					<td>
						<input type="text" name="product" value="" id="productautocomplete" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#categoryautocomplete').autocomplete({
		autoFocus: true,
		source: wpcoajaxurl + "?action=wpcoautocompletecategories",
		select: function (event, ui) {
			var li_item = '<li class="button">';
			li_item += '<span class="hidden"><input type="hidden" name="handling_categories[]" value="' + ui.item.value + '" /></span>';
			li_item += '<span class="label">' + ui.item.label + '</span>';
			li_item += '<span class="delete"></span>';
			li_item += '</li>';
			jQuery('#categoriestaglist').show().find('ul').append(li_item);
			this.value = ui.item.label;
			return false;
		}
	}).Watermark('<?php _e('Start typing category...', $this -> plugin_name); ?>');
	
	jQuery('ul.taglist li span.delete').live('click', function() {
		jQuery(this).parent().remove();
	});
	
	jQuery('#categoriestaglist ul').sortable();
});

function change_handling_calculation(calculation) {
	jQuery('div[id^="handling_calculation_"]').hide();
	jQuery('div#handling_calculation_' + calculation + '_div').show();
}
</script>