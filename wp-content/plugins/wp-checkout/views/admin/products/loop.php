<?php if (!empty($products)) : ?>
	<form action="?page=checkout-products&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected products?', $this -> plugin_name); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft actions">
				<?php if (!empty($_GET['page']) && $_GET['page'] == $this -> sections -> products) : ?>
					<a href="?page=<?php echo $this -> sections -> products; ?>&method=order" class="button"><?php _e('Order Products', $this -> plugin_name); ?></a>
				<?php endif; ?>
			</div>
			<div class="alignleft actions">
				<select onchange="change_action(this.value);" name="action" class="widefat" style="width:auto;">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
                    <?php if (!$this -> is_supplier()) : ?>
						<option value="activate"><?php _e('Activate', $this -> plugin_name); ?></option>
						<option value="deactivate"><?php _e('De-Activate', $this -> plugin_name); ?></option>
                        <option value="ptypepost"><?php _e('Change type to POST', $this -> plugin_name); ?></option>
                        <option value="ptypepage"><?php _e('Change type to PAGE', $this -> plugin_name); ?></option>
                        <option value="buynowY"><?php _e('Change Purchase Type to BUY NOW', $this -> plugin_name); ?></option>
                   	 	<option value="buynowN"><?php _e('Change Purchase Type to ADD TO BASKET', $this -> plugin_name); ?></option>
                        <option value="buttontext"><?php _e('Change Button Text', $this -> plugin_name); ?></option>
                    <?php endif; ?>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
					<option value="inventory"><?php _e('Stock in Inventory...', $this -> plugin_name); ?></option>
					<?php if (!$this -> is_supplier()) : ?><option value="supplier"><?php _e('Set Supplier...', $this -> plugin_name); ?></option><?php endif; ?>
                    <?php if (!$this -> is_supplier()) : ?><option value="minorder"><?php _e('Set Minimum Order...', $this -> plugin_name); ?></option><?php endif; ?>
					<option value="addstyles"><?php _e('Add Variations (appends)...', $this -> plugin_name); ?></option>
					<option value="setstyles"><?php _e('Set Variations (overwrites)...', $this -> plugin_name); ?></option>
					<option value="addcategories"><?php _e('Add Categories (appends)...', $this -> plugin_name); ?></option>
					<option value="setcategories"><?php _e('Set Categories (overwrites)...', $this -> plugin_name); ?></option>
					<option value="typed"><?php _e('Change Type to Digital', $this -> plugin_name); ?></option>
					<option value="typet"><?php _e('Change Type to Tangible', $this -> plugin_name); ?></option>
                    <option value="showcaseY"><?php _e('Set as SHOWCASE product', $this -> plugin_name); ?></option>
                    <option value="showcasemsg"><?php _e('Set showcase message to display', $this -> plugin_name); ?></option>
                    <option value="showcaseN"><?php _e('Set as FOR SALE product', $this -> plugin_name); ?></option>
                    <option value="vtaxprice"><?php _e('Variations Tax Calculation', $this -> plugin_name); ?></option>
                    <option value="price_increase"><?php _e('Price Increase', $this -> plugin_name); ?></option>
                    <option value="price_decrease"><?php _e('Price Decrease', $this -> plugin_name); ?></option>
                    <option value="clear_sprice"><?php _e('Clear Retail/Suggested Prices', $this -> plugin_name); ?></option>
				</select>
				
                <?php if (!$this -> is_supplier()) : ?>
                    <span id="supplierdiv" style="display:none;">
                        <?php if ($suppliers = $Supplier -> select()) : ?>
                            <?php echo $wpcoForm -> select('supplier_id', $suppliers); ?>
                        <?php else : ?>
                            <span class="<?php echo $this -> pre; ?>error"><?php _e('No suppliers available', $this -> plugin_name); ?></span>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
                
                <span id="vtaxpricediv" style="display:none;">
                	<select name="vtax" id="">
                		<option value="Y"><?php _e('Yes, calculate tax/vat on variation options', $this -> plugin_name); ?></option>
                		<option value="N"><?php _e('No, only calculate tax/vat on product base price', $this -> plugin_name); ?></option>
                	</select>
                </span>
                
                <span id="buttontextdiv" style="display:none;">
                	<input type="text" name="Product[buttontext]" value="<?php echo esc_attr(stripslashes($this -> get_option('loop_btnlnktext'))); ?>" />
                </span>
                
                <span id="showcasemsgdiv" style="display:none;">
                	<input type="text" name="Product[showcasemsg]" value="<?php _e('Call for more info', $this -> plugin_name); ?>" id="Product.showcasemsg" />
                </span>
				
				<span id="inventorydiv" style="display:none;">
					<input style="width:45px;" type="text" name="Product[inventory]" value="-1" />
				</span>
                
                <span id="minorderdiv" style="display:none;">
                	<input style="width:45px;" type="text" name="Product[min_order]" value="0" />
                </span>
                
                <span id="price_incdec" style="display:none;">
                	<input style="width:65px;" type="text" name="price_incdec_val" value="<?php echo esc_attr(stripslashes($_POST['price_incdec_val'])); ?>" id="price_incdec_val" />
                    
                    <select name="price_incdec_type">
                        <option value="fixed"><?php _e('Fixed Amount', $this -> plugin_name); ?></option>
                        <option value="percentage"><?php _e('Percent', $this -> plugin_name); ?></option>
                    </select>
                    
                    <label><input type="checkbox" name="price_incdec_sprice" value="1" id="price_incdec_sprice" /> <?php _e('Put old price in retail/suggested price field', $this -> plugin_name); ?></label>
                </span>
                
                <span id="postcategoriesdiv" style="display:none;">
                	<br/>
                	<label for="categoriesselectall" style="font-weight:bold;"><?php _e('Post Categories:', $this -> plugin_name); ?></label>
					<?php if ($categories = get_categories(array('hide_empty' => 0, 'pad_counts' => 1))) : ?>
                        <div>
                            <input type="checkbox" name="categoriesselectall" value="1" id="categoriesselectall" onclick="jqCheckAll(this, '<?php echo $this -> sections -> products_save; ?>', 'postcategories');" />
                            <label for="categoriesselectall"><strong><?php _e('Select All', $this -> plugin_name); ?></strong></label>
                        </div>
                        <div style="max-height:200px; overflow:auto;">
                            <?php foreach ($categories as $category) : ?>
                                <label><input type="checkbox" name="postcategories[]" value="<?php echo $category -> cat_ID; ?>" id="checklist<?php echo $category -> cat_ID; ?>" /> <?php echo $category -> cat_name; ?></label><br/>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="<?php echo $this -> pre; ?>error"><?php _e('No categories are available.', $this -> plugin_name); ?></div>
                    <?php endif; ?>
                </span>
				
				<input type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" class="button-secondary" />
				
				<script type="text/javascript">
					function change_action(val) {
						jQuery('#supplierdiv').hide();
						jQuery('#inventorydiv').hide();
						jQuery('#minorderdiv').hide();
						jQuery('#stylesdiv').hide();
						jQuery('#categoriesdiv').hide();
						jQuery('#price_incdec').hide();
						jQuery('#buttontextdiv').hide();
						jQuery('#postcategoriesdiv').hide();
						jQuery('#vtaxpricediv').hide();
					
						if (val == "supplier") {
							jQuery("#supplierdiv").show();
						} else if (val == "inventory") {
							jQuery("#inventorydiv").show();
						} else if (val == "minorder") {
							jQuery("#minorderdiv").show();
						} else if (val == "addstyles" || val == "setstyles") {
							jQuery("#stylesdiv").show();
						} else if (val == "addcategories" || val == "setcategories") {
							jQuery("#categoriesdiv").show();
						} else if (val == "price_increase" || val == "price_decrease") {
							jQuery("#price_incdec").show();	
						} else if (val == "showcasemsg") {
							jQuery('#showcasemsgdiv').show();	
						} else if (val == "buttontext") {
							jQuery('#buttontextdiv').show();	
						} else if (val == "ptypepost") {
							jQuery('#postcategoriesdiv').show();	
						} else if (val == "vtaxprice") {
							jQuery('#vtaxpricediv').show();
						}
					}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
		
		<span id="stylesdiv" style="display:none;">
			<?php if ($styles = $Style -> find_all()) : ?>
				<p><small><?php _e('choose the styles (and options) below to associate with the selected products', $this -> plugin_name); ?></small></p>

				<div style="max-height:125px; overflow:auto;">			
					<ul class="<?php echo $this -> pre; ?>checklist">
						<?php foreach ($styles as $style) : ?>
							<li>
								<label><input <?php echo (!empty($Product -> data -> styles) && in_array($style -> id, $Product -> data -> styles)) ? 'checked="checked"' : ''; ?> onclick="jQuery('#options<?php echo $style -> id; ?>').toggle();" type="checkbox" name="Product[styles][]" value="<?php echo $style -> id; ?>" /> <?php echo $style -> title; ?></label><br/>
								<?php if ($options = $Option -> find_all(array('style_id' => $style -> id))) : ?>
									<ul id="options<?php echo $style -> id; ?>" style="padding-left:20px; display:<?php echo (!empty($Product -> data -> styles) && in_array($style -> id, $Product -> data -> styles)) ? 'block' : 'none'; ?>;">
										<?php foreach ($options as $option) : ?>
											<li><label><input <?php echo (!empty($Product -> data -> options[$style -> id]) && in_array($option -> id, $Product -> data -> options[$style -> id])) ? 'checked="checked"' : ''; ?> type="checkbox" name="Product[options][<?php echo $style -> id; ?>][]" value="<?php echo $option -> id; ?>" /> <?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $wpcoHtml -> currency_price($option -> price) . ')' : ''; ?></label></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php else : ?>
				<span class="<?php echo $this -> pre; ?>error"><?php _e('No styles are available', $this -> plugin_name); ?></span>
			<?php endif; ?>
		</span>
		
		<span id="categoriesdiv" style="display:none;">
			<?php if ($categories = $Category -> select()) : ?>
				<p><small><?php _e('choose the categories below to associate with the selected products', $this -> plugin_name); ?></small></p>

				<div style="max-height:125px; overflow:auto;">			
					<ul class="<?php echo $this -> pre; ?>checklist">
						<?php foreach ($categories as $cid => $cval) : ?>
							<li><label><input type="checkbox" name="Product[categories][]" value="<?php echo $cid; ?>" id="" /> <?php echo $cval; ?></label></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php else : ?>
				<span class="<?php echo $this -> pre; ?>error"><?php _e('No categories are available', $this -> plugin_name); ?></span>
			<?php endif; ?>
		</span>
		
		<?php
		
		$orderby = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
		$order = (empty($_GET['order'])) ? 'desc' : strtolower($_GET['order']);
		$otherorder = ($order == "desc") ? 'asc' : 'desc';
		
		?>
		
		<table class="widefat">
			<thead>
				<tr>
					<th class="check-column"><input type="checkbox" name="checkboxall" value="checkboxall" id="checkboxall" /></th>
					<th class="column-id <?php echo ($orderby == "id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=id&order=' . (($orderby == "id") ? $otherorder : "asc")); ?>">
							<span><?php _e('ID', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th colspan="<?php echo (!$this -> is_supplier()) ? 3 : 2; ?>" class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
							<span><?php _e('Product', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Categories', $this -> plugin_name); ?></th>
					<th class="column-price <?php echo ($orderby == "price") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=price&order=' . (($orderby == "price") ? $otherorder : "asc")); ?>">
							<span><?php _e('Price', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-type <?php echo ($orderby == "type") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=type&order=' . (($orderby == "type") ? $otherorder : "asc")); ?>">
							<span><?php _e('Type', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
                    <th class="column-status <?php echo ($orderby == "status") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=status&order=' . (($orderby == "status") ? $otherorder : "asc")); ?>">
							<span><?php _e('Status', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-minorder <?php echo ($orderby == "minorder") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=minorder&order=' . (($orderby == "minorder") ? $otherorder : "asc")); ?>">
							<span><?php _e('Min Order', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-modified <?php echo ($orderby == "modified") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=modified&order=' . (($orderby == "modified") ? $otherorder : "asc")); ?>">
							<span><?php _e('Date', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="check-column"><input type="checkbox" name="checkboxall" value="checkboxall" id="checkboxall" /></th>
					<th class="column-id <?php echo ($orderby == "id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=id&order=' . (($orderby == "id") ? $otherorder : "asc")); ?>">
							<span><?php _e('ID', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th colspan="<?php echo (!$this -> is_supplier()) ? 3 : 2; ?>" class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
							<span><?php _e('Product', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Categories', $this -> plugin_name); ?></th>
					<th class="column-price <?php echo ($orderby == "price") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=price&order=' . (($orderby == "price") ? $otherorder : "asc")); ?>">
							<span><?php _e('Price', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-type <?php echo ($orderby == "type") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=type&order=' . (($orderby == "type") ? $otherorder : "asc")); ?>">
							<span><?php _e('Type', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
                    <th class="column-status <?php echo ($orderby == "status") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=status&order=' . (($orderby == "status") ? $otherorder : "asc")); ?>">
							<span><?php _e('Status', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-minorder <?php echo ($orderby == "minorder") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=minorder&order=' . (($orderby == "minorder") ? $otherorder : "asc")); ?>">
							<span><?php _e('Min Order', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-modified <?php echo ($orderby == "modified") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=modified&order=' . (($orderby == "modified") ? $otherorder : "asc")); ?>">
							<span><?php _e('Date', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
				</tr>
			</tfoot>
			<tbody>
				<?php $class = ''; ?>
				<?php foreach ($products as $product) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th class="check-column"><input type="checkbox" name="Product[checklist][]" value="<?php echo $product -> id; ?>" id="checklist<?php echo $product -> id; ?>" /></th>
						<td><label for="checklist<?php echo $product -> id; ?>"><?php echo $product -> id; ?></label></td>
						<?php if (!$this -> is_supplier()) : ?>
							<td>
								<!-- featured -->
								<span class="featuredspan" id="featured<?php echo $product -> id; ?>">
									<?php if ($product -> featured == 1) : ?>
										<a href="" class="featured featured_on" title="<?php _e('Set this product as not featured', $this -> plugin_name); ?>" onclick="wpco_featuredproduct('<?php echo $product -> id; ?>', '0'); return false;"></a>
									<?php else : ?>
										<a href="" class="featured featured_off" title="<?php _e('Set this product as featured', $this -> plugin_name); ?>" onclick="wpco_featuredproduct('<?php echo $product -> id; ?>', '1'); return false;"></a>
									<?php endif; ?>
								</span>
							</td>
						<?php endif; ?>
						<td style="width:75px;"><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($product -> image_url, 45, 45, 80), $wpcoHtml -> image_url($product -> image -> name), array('class' => 'colorbox', 'title' => apply_filters($this -> pre . '_product_title', $product -> title))); ?></td>
						<td>
							<?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), '?page=checkout-products-save&amp;id=' . $product -> id, array('class' => 'row-title')); ?>
							<?php if (empty($product -> inventory) && $product -> inventory == 0) : ?><small class="<?php echo $this -> pre; ?>error">(<?php _e('out of stock', $this -> plugin_name); ?>)</small><?php endif; ?>
	                        <?php if (!empty($product -> inventory) && $product -> inventory > 0) : ?><small>(<?php echo $product -> inventory; ?> <?php _e('units left', $this -> plugin_name); ?>)</small><?php endif; ?>
							<div class="row-actions">
								<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=checkout-products-save&amp;id=' . $product -> id); ?> |</span>
								
								<?php if (!$this -> is_supplier()) : ?>
									<span class="edit"><?php echo $wpcoHtml -> link(__('Related', $this -> plugin_name), '?page=checkout-products&amp;method=related&amp;id=' . $product -> id); ?> |</span>
									<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), '?page=checkout-products&amp;method=delete&amp;id=' . $product -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you wish to delete this product?', $this -> plugin_name) . "')) { return false; }")); ?> |</span>
									<span class="view"><?php echo $wpcoHtml -> link(__('View', $this -> plugin_name), '?page=checkout-products&amp;method=view&amp;id=' . $product -> id); ?> |</span>
									<span class="view"><?php echo $wpcoHtml -> link(__('Copy', $this -> plugin_name), '?page=checkout-products&amp;method=duplicate&amp;product_id=' . $product -> id); ?></span>
								<?php endif; ?>
								
								<?php if (!empty($product -> post_id)) : ?>
									<span class="view">| <?php echo $wpcoHtml -> link(__('View on Front', $this -> plugin_name), get_permalink($product -> post_id), array('target' => "_blank", 'title' => apply_filters($this -> pre . '_product_title', $product -> title))); ?></span>
								<?php endif; ?>
							</div>
						</td>
						<td>
							<?php if (!empty($product -> categories)) : ?>
								<?php $c = 1; ?>
								<?php foreach ($product -> categories as $category_id) : ?>
									<?php $wpcoDb -> model = $Category -> model; ?>
									<?php echo $wpcoHtml -> link(stripslashes($wpcoDb -> field('title', array('id' => $category_id))), '?page=checkout-categories&amp;method=view&amp;id=' . $category_id); ?>
									<?php echo ($c < count($product -> categories)) ? ', ' : ''; ?>
									<?php $c++; ?>
								<?php endforeach; ?>
							<?php else : ?>
								<?php _e('none', $this -> plugin_name); ?>
							<?php endif; ?>
						</td>
						<td>
							<?php if ($product -> price_type == "fixed") : ?>
								<?php echo (!empty($product -> sprice) && is_numeric($product -> sprice) && $product -> sprice != "0.00") ? '<strike>' . $wpcoHtml -> currency_price($product -> sprice) . '</strike><br/>' : ''; ?>
								<b><?php echo $wpcoHtml -> currency_price($product -> price); ?></b>
	                        <?php elseif ($product -> price_type == "donate") : ?>
	                        	<strong><?php _e('Donation', $this -> plugin_name); ?></strong>
	                        <?php elseif ($product -> price_type == "square") : ?>
	                        	<?php if (!empty($product -> square_price_text)) : ?>
	                            	<strong><?php echo stripslashes($product -> square_price_text); ?></strong>
	                            <?php else : ?>
	                        		<strong><?php echo $wpcoHtml -> currency_price($product -> square_price, true, true); ?> <?php _e('Per square', $this -> plugin_name); ?> <?php echo $product -> lengthmeasurement; ?></strong>
	                            <?php endif; ?>
							<?php else : ?>
								<?php $price = unserialize($product -> price); ?>
								<?php sort($price); ?>
								<b><?php echo $wpcoHtml -> currency_price($price[0]['price']); ?></b>
							<?php endif; ?>
	                        
	                        <?php if (!empty($product -> buynow) && $product -> buynow == "Y") : ?>
	                        	(<?php _e('Buy Now Mode', $this -> plugin_name); ?>)
	                        <?php else : ?>
	                        	(<?php _e('Add to Basket', $this -> plugin_name); ?>)
	                        <?php endif; ?>
	                        
	                        <?php if (!empty($product -> taxexempt) && $product -> taxexempt == "Y") : ?>
	                        	<br/><span style="color:red;"><?php _e('Tax Exempt', $this -> plugin_name); ?></span>
	                        <?php endif; ?>
						</td>
						<td><label for="checklist<?php echo $product -> id; ?>"><?php echo (empty($product -> type) || $product -> type == "digital") ? __('Digital', $this -> plugin_name) : __('Tangible', $this -> plugin_name); ?></label></td>
	                    <td>
	                    	<?php if (empty($product -> status) || $product -> status == "active") : ?>
	                        	<span style="color:green;"><?php _e('Active', $this -> plugin_name); ?></span>
	                        <?php else : ?>
	                        	<span style="color:red;"><?php _e('Inactive', $this -> plugin_name); ?></span>
	                        <?php endif; ?>
	                    </td>
						<td><label for="checklist<?php echo $product -> id; ?>"><?php echo (empty($product -> min_order)) ? 'none' : $product -> min_order; ?></label></td>
						<td><label for="checklist<?php echo $product -> id; ?>"><abbr title="<?php echo $product -> modified; ?>"><?php echo date("Y-m-d", strtotime($product -> modified)); ?></abbr></label></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="tablenav">
			<div class="alignleft">
				<select class="widefat" style="width:auto;" name="perpage" onchange="change_perpage(this.value);">
					<option value="">- <?php _e('Per Page', $this -> plugin_name); ?> -</option>
					<?php $p = 20; ?>
					<?php while ($p < 500) : ?>
						<option <?php echo (isset($_COOKIE[$this -> pre . 'productsperpage']) && $_COOKIE[$this -> pre . 'productsperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('products', $this -> plugin_name); ?></option>
						<?php $p += 20; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>productsperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> UTC; path=/";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No products were found', $this -> plugin_name); ?></p>
<?php endif; ?>