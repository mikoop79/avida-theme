<div class="wrap">
	<h2><?php _e('View Product', $this -> plugin_name); ?>: <?php echo apply_filters($this -> pre . '_product_title', $product -> title); ?></h2>
	
	<div style="float:none;" class="subsubsub"><?php echo $wpcoHtml -> link(__('&larr; All Products', $this -> plugin_name), $this -> url, array('title' => __('Manage all products', $this -> plugin_name))); ?></div>
	
	<div class="tablenav">
		<div class="alignleft">
			<a href="?page=<?php echo $this -> sections -> products_save; ?>&amp;id=<?php echo $product -> id; ?>" title="<?php _e('Change the details of this product', $this -> plugin_name); ?>" class="button"><?php _e('Change', $this -> plugin_name); ?></a>
			<a href="?page=<?php echo $this -> sections -> products; ?>&amp;method=duplicate&amp;product_id=<?php echo $product -> id; ?>" title="<?php _e('Make a copy of this product.', $this -> plugin_name); ?>" class="button"><?php _e('Copy', $this -> plugin_name); ?></a>
			<a href="?page=<?php echo $this -> sections -> products; ?>&amp;method=related&amp;id=<?php echo $product -> id; ?>" title="<?php _e('Assign related products to this product', $this -> plugin_name); ?>" class="button"><?php _e('Related Products', $this -> plugin_name); ?></a>
			<a href="?page=<?php echo $this -> sections -> products; ?>&amp;method=delete&amp;id=<?php echo $product -> id; ?>" title="<?php _e('Remove this product', $this -> plugin_name); ?>" class="button button-highlighted" onclick="if (!confirm('<?php _e('Are you sure you wish to remove this product?'); ?>')) { return false; }"><?php _e('Delete', $this -> plugin_name); ?></a>
		</div>
	</div>
	<table class="widefat">
		<thead>
			<tr>
				<th><?php _e('Field', $this -> plugin_name); ?></th>
				<th><?php _e('Value', $this -> plugin_name); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th><?php _e('Field', $this -> plugin_name); ?></th>
				<th><?php _e('Value', $this -> plugin_name); ?></th>
			</tr>
		</tfoot>
		<tbody>
			<?php $class = ''; ?>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Title', $this -> plugin_name); ?></th>
				<td><?php echo apply_filters($this -> pre . '_product_title', $product -> title); ?></td>
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Image', $this -> plugin_name); ?></th>
				<td>
					<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($product -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($product -> image -> name), array('class' => 'colorbox', 'title' => apply_filters($this -> pre . '_product_title', $product -> title))); ?>
					<br/><small><?php _e('click to enlarge', $this -> plugin_name); ?></small>
				</td>
			</tr>
			<?php if (!empty($product -> images)) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Additional Images', $this -> plugin_name); ?></th>
					<td>
						<div class="<?php echo $this -> pre; ?>imglist">
							<ul>
								<?php foreach ($product -> images as $image) : ?>
								<li><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($image -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($image -> filename), array('class' => 'colorbox', 'title' => $image -> title, 'rel' => $wpcoHtml -> sanitize(apply_filters($this -> pre . '_product_title', $product -> title)) . '-images')); ?></li>
								<?php endforeach; ?>
							</ul>
							<hr/>
						</div>
					</td>
				</tr>
			<?php endif; ?>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Description', $this -> plugin_name); ?></th>
				<td><?php echo apply_filters($this -> pre . '_product_description', wpautop($product -> description)); ?></td>
			</tr>
			<?php if (!empty($product -> kws) && is_array($product -> kws)) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Keywords', $this -> plugin_name); ?></th>
					<td>
						<?php $k = 1; ?>
						<?php foreach ($product -> kws as $kw) : ?>
							<?php echo $kw; ?>
							<?php echo ($k < count($product -> kws)) ? ', ' : ''; ?>
							<?php $k++; ?>
						<?php endforeach; ?>
					</td>
				</tr>
			<?php endif; ?>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Price', $this -> plugin_name); ?></th>
				<td>
					<?php if ($product -> price_type == "fixed") : ?>
						<?php echo (!empty($product -> sprice) && $product -> sprice != "0.00" && is_numeric($product -> sprice)) ? '<strike>' . $wpcoHtml -> currency_price($product -> sprice) . '</strike>' : ''; ?>
						<strong><?php echo $wpcoHtml -> currency_price($product -> price); ?></strong>
                    <?php elseif ($product -> price_type == "donate") : ?>
                    	<strong><?php _e('Donation', $this -> plugin_name); ?></strong>
                    <?php elseif ($product -> price_type == "square") : ?>
                    	<strong><?php echo $wpcoHtml -> currency_price($product -> square_price); ?> <?php _e('per square meter', $this -> plugin_name); ?></strong>
					<?php else : ?>
						<?php $price = unserialize($product -> price); ?>
						<table class="<?php echo $this -> pre; ?>">
							<tbody>
								<?php foreach ($price as $tier) : ?>
								<tr>
									<td><?php echo $tier['min']; ?></td>
									<td><?php _e('to', $this -> plugin_name); ?></td>
									<td><?php echo $tier['max']; ?></td>
									<td>=</td>
									<td><b><?php echo $wpcoHtml -> currency_price($tier['price']); ?></b></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</td>	
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Type', $this -> plugin_name); ?></th>
				<td><?php echo $product -> type; ?></td>
			</tr>
			<?php if (!empty($product -> type) && $product -> type == "tangible") : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Unit Weight', $this -> plugin_name); ?></th>
					<td><?php echo $product -> weight; ?> <?php echo $this -> get_option('weightm'); ?></td>
				</tr>
			<?php endif; ?>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Affiliate Product', $this -> plugin_name); ?></th>
				<td><?php echo (!empty($product -> affiliate) && $product -> affiliate == "Y") ? __('Yes', $this -> plugin_name) : __('No', $this -> plugin_name); ?></td>
			</tr>
			<?php if (!empty($product -> affiliate) && $product -> affiliate == "Y") : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Affiliate/Referral URL', $this -> plugin_name); ?></th>
					<td>
						<?php echo $wpcoHtml -> link($product -> affiliateurl, $product -> affiliateurl, array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'target' => "blank")); ?> (<?php echo (!empty($product -> affiliatewindow) && $product -> affiliatewindow == "self") ? __('Same Window', $this -> plugin_name) : __('New Window', $this -> plugin_name); ?>)
					</td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Affiliate Referrals', $this -> plugin_name); ?></th>
					<td><?php echo $product -> affiliatehits; ?></td>
				</tr>
			<?php endif; ?>
			<?php if (!empty($product -> min_order) && $product -> min_order != 0) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Minimum Order', $this -> plugin_name); ?></th>
					<td><?php echo $product -> min_order; ?></td>
				</tr>
			<?php endif; ?>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Items in Inventory', $this -> plugin_name); ?></th>
				<td><?php echo ($product -> inventory == -1) ? __('Unlimited', $this -> plugin_name) : $product -> inventory; ?></td>
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Categories', $this -> plugin_name); ?></th>
				<td>
					<?php if (!empty($product -> categories)) : ?>
						<?php $c = 1; ?>
						<?php foreach ($product -> categories as $category_id) : ?>
							<?php $wpcoDb -> model = $Category -> model; ?>
							<?php echo $wpcoHtml -> link($wpcoDb -> field('title', array('id' => $category_id)), '?page=checkout-categories&amp;method=view&amp;id=' . $category_id); ?>
							<?php echo ($c < count($product -> categories)) ? ', ' : ''; ?>
							<?php $c++; ?>
						<?php endforeach; ?>
					<?php else : ?>
						<?php _e('none', $this -> plugin_name); ?>
					<?php endif; ?>
				</td>
			</tr>
			
			<?php if ($product -> type == "digital") : ?>
				<?php $wpcoDb -> model = $File -> model; ?>
				<?php if ($files = $wpcoDb -> find_all(array('product_id' => $product -> id))) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th><?php _e('Product Files', $this -> plugin_name); ?></th>
						<td>
							<div style="max-height:150px; overflow:auto;">
								<ul style="margin:0; padding:0 0 0 20px;">
									<?php foreach ($files as $file) : ?>
										<li><?php echo $wpcoHtml -> link($file -> title, get_option('siteurl') . '/wp-content/uploads/' . $this -> plugin_name . '/downloads/' . $file -> filename, array('title' => $file -> title)); ?> (<?php echo number_format((($file -> filesize / 1024) / 1024), 2, '.', ''); ?> <?php _e('Mb', $this -> plugin_name); ?>)</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</td>
					</tr>
				<?php endif; ?>
			<?php endif; ?>
			
			<?php if (!empty($product -> supplier_id)) : ?>
				<?php $wpcoDb -> model = $Supplier -> model; ?>
				<?php if ($supplier = $wpcoDb -> find(array('id' => $product -> supplier_id))) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th><?php _e('Supplier', $this -> plugin_name); ?></th>
						<td><?php echo $supplier -> name; ?></td>
					</tr>
				<?php endif; ?>
			<?php endif; ?>
			<?php if (!empty($product -> post_id)) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Product Page', $this -> plugin_name); ?></th>
					<td><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title))); ?></td>
				</tr>
			<?php endif; ?>
			<?php if (!empty($product -> styles)) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Styles/Options', $this -> plugin_name); ?></th>
					<td>
						<div style="max-height:150px; overflow:auto;">
							<ul style="margin:0; padding:0 0 0 20px;">
								<?php foreach ($product -> styles as $style_id) : ?>
									<?php $wpcoDb -> model = $Style -> model; ?>
									<?php if ($style = $wpcoDb -> find(array('id' => $style_id))) : ?>
										<li>
											<?php echo $style -> title; ?>
											<?php if (!empty($product -> options[$style_id])) : ?>
												<ul style="margin:0; padding:0 0 0 20px;">
													<?php foreach ($product -> options[$style_id] as $option_id) : ?>
														<?php $wpcoDb -> model = $Option -> model; ?>
														<?php if ($option = $wpcoDb -> find(array('id' => $option_id))) : ?>
															<li><?php echo $option -> title; ?></li>		
														<?php endif; ?>
													<?php endforeach; ?>
												</ul>
											<?php endif; ?>
										</li>	
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<div class="tablenav">
		
	</div>
</div>