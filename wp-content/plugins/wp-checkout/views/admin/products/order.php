<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Order Products', $this -> plugin_name); ?><?php echo (!empty($category)) ? ': ' . __($category -> title) : ''; ?><?php echo (!empty($supplier)) ? ': ' . __($supplier -> name) : ''; ?></h2>
	
	<?php if (!empty($category)) : ?>
		<div class="subsubsub" style="float:none;"><?php echo $wpcoHtml -> link(__('&larr; Back to Categories', $this -> plugin_name), '?page=' . $this -> sections -> categories); ?></div>
	<?php elseif (!empty($supplier)) : ?>
		<div class="subsubsub" style="float:none;"><?php echo $wpcoHtml -> link(__('&larr; Back to Suppliers', $this -> plugin_name), '?page=' . $this -> sections -> suppliers); ?></div>
	<?php else : ?>
		<div class="subsubsub" style="float:none;"><?php echo $wpcoHtml -> link(__('&larr; Back to Products', $this -> plugin_name), $this -> url); ?></div>
	<?php endif; ?>
	
	<?php
	
	if (!empty($category)) {
		$ordertype = $category -> pordertype;
		$orderfield = $category -> porderfield;
		$orderdirect = $category -> porderdirection;
	} elseif (!empty($supplier)) {
		$ordertype = $supplier -> pordertype;
		$orderfield = $supplier -> porderfield;
		$orderdirect = $supplier -> porderdirection;
	} else {
		$ordertype = $this -> get_option('loop_ordertype');
		$orderfield = $this -> get_option('loop_orderfield');
		$orderdirection = $this -> get_option('loop_orderdirection');
	}
	
	$params = "";
	if (!empty($category)) { $params .= '&category_id=' . $category -> id; }
	if (!empty($supplier)) { $params .= '&supplier_id=' . $supplier -> id; }
	
	?>
	
	<form action="<?php echo $wpcoHtml -> retainquery('method=order' . $params, '?page=' . $this -> sections -> products); ?>" method="post">
		<?php if (!empty($category)) : ?>
			<input type="hidden" name="category_id" value="<?php echo $category -> id; ?>" />
		<?php endif; ?>
		<?php if (!empty($supplier)) : ?>
			<input type="hidden" name="supplier_id" value="<?php echo $supplier -> id; ?>" />
		<?php endif; ?>
	
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="ordertype_custom"><?php _e('Order Type', $this -> plugin_name); ?></label></th>
					<td>
						<label><input <?php echo ($ordertype == "random") ? 'checked="checked"' : ''; ?> type="radio" name="ordertype" value="random" id="ordertype_random" /> <?php _e('Random Order', $this -> plugin_name); ?></label>
						<label><input <?php echo ($ordertype == "specific") ? 'checked="checked"' : ''; ?> type="radio" name="ordertype" value="specific" id="ordertype_specific" /> <?php _e('Specific Order', $this -> plugin_name); ?></label>
						<label><input <?php echo ($ordertype == "custom") ? 'checked="checked"' : ''; ?> type="radio" name="ordertype" value="custom" id="ordertype_custom" /> <?php _e('Custom Order', $this -> plugin_name); ?></label>
						<span class="howto"><?php _e('How should products be ordered?', $this -> plugin_name); ?></span>
						
						<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('input[name="ordertype"]').click(function() {
								jQuery('div[id^="ordertype_"]').hide();
								jQuery('#ordertype_' + this.value + '_div').show();
							});
						});
						</script>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="ordertype_random_div" style="display:<?php echo ($ordertype == "random") ? 'block' : 'none'; ?>;">
			<p class="submit">
				<input class="button button-primary" type="submit" name="save" value="<?php _e('Save Order', $this -> plugin_name); ?>" />
			</p>
		</div>
		
		<div id="ordertype_specific_div" style="display:<?php echo ($ordertype == "specific") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for=""><?php _e('Order Products By', $this -> plugin_name); ?></label></th>
						<td>
							<?php 
							
							$orderfields = array(
								'id'				=>	__('ID', $this -> plugin_name),
								'title'				=>	__('Title', $this -> plugin_name),
								'price'				=>	__('Price', $this -> plugin_name),
								'type'				=>	__('Type (Digital/Tangible)', $this -> plugin_name),
								'min_order'			=>	__('Minimum Order', $this -> plugin_name),
								'inventory'			=>	__('Inventory/Stock', $this -> plugin_name),
								'weight'			=>	__('Weight', $this -> plugin_name),
								'width'				=>	__('Width', $this -> plugin_name),
								'length'			=>	__('Length', $this -> plugin_name),
								'height'			=>	__('Height', $this -> plugin_name),
								'created'			=>	__('Created Date', $this -> plugin_name),
								'modified'			=>	__('Modified Date', $this -> plugin_name),
							);
							
							?>
							<select name="orderfield">
								<?php foreach ($orderfields as $fkey => $fval) : ?>
									<option <?php echo ($orderfield == $fkey) ? 'selected="selected"' : ''; ?> value="<?php echo $fkey; ?>"><?php echo $fval; ?></option>
								<?php endforeach; ?>
							</select>
							<select name="orderdirection">
								<option <?php echo ($orderdirection == "ASC") ? 'selected="selected"' : ''; ?> value="ASC"><?php _e('Ascending (Low to High)', $this -> plugin_name); ?></option>
								<option <?php echo ($orderdirection == "DESC") ? 'selected="selected"' : ''; ?> value="DESC"><?php _e('Descending (High to Low)', $this -> plugin_name); ?></option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		
			<p class="submit">
				<input class="button button-primary" type="submit" name="save" value="<?php _e('Save Order', $this -> plugin_name); ?>" />
			</p>
		</div>
		
		<div id="ordertype_custom_div" style="display:<?php echo ($ordertype == "custom") ? 'block' : 'none'; ?>;">
			<p><?php _e('Drag and drop the products below to order them according to how they should appear to customers.', $this -> plugin_name); ?></p>
			<?php if (!empty($products)) : ?>
				<div id="message" class="updated fade" style="width:30.8%; display:none;"></div>
				<div class="wpco_products_list">
					<span class="wpco_products_convert_list"><a href="#" id="wpco_convert_list"><?php _e('List', $this -> plugin_name); ?></a></span>
					<span class="wpco_products_convert_grid"><a href="#" id="wpco_convert_grid"><?php _e('Grid', $this -> plugin_name); ?></a></span>
					<br class="clear" />
					<ul id="products">
						<?php foreach ($products as $product) : ?>
							<li id="product_<?php echo $product -> id; ?>" class="<?php echo $this -> pre; ?>lineitem">
								<span class="wpco_product_image" style="display:none;"><?php echo $wpcoHtml -> timthumb_image($product -> image_url, 89, 89, 80); ?></span>
								<span class="wpco_product_title"><?php echo __($product -> title); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				
				<script type="text/javascript">
				var request_products = false;		
				jQuery(document).ready(function() {
					jQuery("ul#products").sortable({
						placeholder: "wpco-placeholder",
						revert: 100,
						distance: 5,
						start: function(event, ui) {
							if (request_products) { request_products.abort(); }
							jQuery('#message').slideUp();	
						},
						update: function(event, ui) {
							request_products = jQuery.post(ajaxurl + '?action=productsorder<?php echo (!empty($category)) ? '&category_id=' . $category -> id : ''; ?><?php echo (!empty($supplier)) ? '&supplier_id=' . $supplier -> id : ''; ?>', jQuery('ul#products').sortable('serialize'), function(response) {
								jQuery('#message').html('<p>' + response + '</p>').fadeIn();
							});
						}
					});
					
					jQuery('#wpco_convert_list').click(function() {
						jQuery('.wpco_products_grid').removeClass('wpco_products_grid').addClass('wpco_products_list');
					});
					
					jQuery('#wpco_convert_grid').click(function() {
						jQuery('.wpco_products_list').removeClass('wpco_products_list').addClass('wpco_products_grid');
					});
				});
				</script>
			<?php else : ?>
				<p class="<?php echo $this -> pre; ?>error"><?php _e('No products are available.', $this -> plugin_name); ?></p>
			<?php endif; ?>
		</div>
	</form>
</div>