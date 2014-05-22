<div class="wrap">
	<h2><?php _e('View an Order Item', $this -> plugin_name); ?></h2>
	
	<div style="float:none;" class="subsubsub"><?php echo $wpcoHtml -> link(__('&larr; All Order Items', $this -> plugin_name), '?page=' . $this -> sections -> items); ?></div>
	
	<?php if (!empty($item)) : ?>
		<div class="tablenav">
			<div class="alignleft actions">
				<?php if ($item -> product -> type == "tangible") : ?>
					<?php if ($item -> shipped == "Y") : ?>
						<a href="<?php echo $this -> url; ?>&amp;method=notshipped&amp;id=<?php echo $item -> id; ?>" title="<?php _e('Mark this item as NOT shipped', $this -> plugin_name); ?>" class="button"><?php _e('Not Shipped', $this -> plugin_name); ?></a>
					<?php elseif ($item -> shipped == "N") : ?>
						<a href="<?php echo $this -> url; ?>&amp;method=shipped&amp;id=<?php echo $item -> id; ?>" title="<?php _e('Mark this item as shipped', $this -> plugin_name); ?>" class="button"><?php _e('Shipped', $this -> plugin_name); ?></a>
					<?php endif; ?>
				<?php endif; ?>
				<a href="<?php echo $this -> url; ?>&amp;method=save&amp;id=<?php echo $item -> id; ?>" title="<?php _e('Change the details of this item', $this -> plugin_name); ?>" class="button"><?php _e('Change', $this -> plugin_name); ?></a>
				<a href="<?php echo $this -> url; ?>&amp;method=delete&amp;id=<?php echo $item -> id; ?>" title="<?php _e('Remove this item completely', $this -> plugin_name); ?>" class="button button-highlighted" onclick="if (!confirm('<?php _e('Are you sure you wish to remove this order item?', $this -> plugin_name); ?>')) { return false; }"><?php _e('Delete', $this -> plugin_name); ?></a>
			</div>
			<br class="clear" />
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
					<th><?php _e('Product', $this -> plugin_name); ?></th>
					<td><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $item -> product -> title), '?page=' . $this -> sections -> products . '&amp;method=view&amp;id=' . $item -> product -> id); ?></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Quantity', $this -> plugin_name); ?></th>
					<td><?php echo $item -> count; ?></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Price', $this -> plugin_name); ?></th>
					<td><b><?php echo $wpcoHtml -> currency(); ?><?php echo number_format(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count), 2, '.', ''); ?></b> (<?php echo $wpcoHtml -> currency(); ?><?php echo number_format($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true), 2, '.', ''); ?> x <?php echo $item -> count; ?>)</td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Completed', $this -> plugin_name); ?></th>
					<td><span style="color:<?php echo (!empty($item -> completed) && $item -> completed == "Y") ? 'green;">' . __('Yes', $this -> plugin_name) : 'red;">' . __('No', $this -> plugin_name); ?></span></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Paid', $this -> plugin_name); ?></th>
					<td><span style="color:<?php echo (!empty($item -> paid) && $item -> paid == "Y") ? 'green;">' . __('Yes', $this -> plugin_name) : 'red;">' . __('No', $this -> plugin_name); ?></span></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Order', $this -> plugin_name); ?></th>
					<td><b><?php echo $wpcoHtml -> link(__('Order', $this -> plugin_name) . ' #' . $item -> order_id, '?page=checkout-orders&amp;method=view&amp;id=' . $item -> order_id); ?></b></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Variations/Options', $this -> plugin_name); ?></th>
					<td>
						<?php $item -> styles = @unserialize($item -> styles); ?>
						<?php if (!empty($item -> styles) && is_array($item -> styles)) : ?>
							<table style="width:auto !important;" class="<?php echo $this -> pre; ?>">								
								<?php foreach ($item -> styles as $style_id => $option_id) : ?>
									<?php $wpcoDb -> model = $Style -> model; ?>
									<?php if ($style = $wpcoDb -> find(array('id' => $style_id), array('id', 'title'))) : ?>
										<?php if (!empty($option_id) && is_array($option_id)) : ?>
											<?php $option_ids = $option_id; ?>
											<tr>
												<th><?php echo $style -> title; ?></th>
												<td>
													<?php $o = 1; ?>
													<?php foreach ($option_ids as $option_id) : ?>
														<?php $wpcoDb -> model = $Option -> model; ?>
														<?php if ($option = $wpcoDb -> find(array('id' => $option_id), array('id', 'title', 'addprice', 'price', 'operator'))) : ?>
															<?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $wpcoHtml -> currency_price($option -> price, true, false, $option -> operator) . ')' : ''; ?>
															<?php echo ($o < count($option_ids)) ? ', ' : ''; ?>
														<?php endif; ?>
														<?php $o++; ?>
													<?php endforeach; ?>
												</td>
											</tr>
										<?php else : ?>
											<?php $wpcoDb -> model = $Option -> model; $option = $wpcoDb -> find(array('id' => $option_id)); ?>
											<tr>
												<th><?php echo $style -> title; ?></th>
												<td><?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y" && !empty($option -> price)) ? ' (' . $wpcoHtml -> currency_price($option -> price, true, false, $option -> operator) . ')' : ''; ?></td>
											</tr>
										<?php endif; ?>
									<?php endif; ?>
								<?php endforeach; ?>
							</table>
						<?php else : ?>
							<?php _e('none', $this -> plugin_name); ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php if (!empty($item -> product -> cfields)) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th><?php _e('Custom Fields', $this -> plugin_name); ?></th>
						<td>
							<?php $wpcoDb -> model = $wpcoField -> model; ?>
							<?php if ($fields = $wpcoDb -> find_all()) : ?>
								<table style="width:auto !important;" class="<?php echo $this -> pre; ?>">
									<?php foreach ($fields as $field) : ?>
										<?php if (!empty($item -> {$field -> slug}) || $item -> {$field -> slug} == "0") : ?>
											<tr>
												<th><?php echo $field -> title; ?><?php echo (!empty($field -> addprice) && $field -> addprice == "Y") ? ' (' . $wpcoHtml -> currency() . '' . $field -> price . ')' : ''; ?></th>
												<td><?php echo $wpcoField -> get_value($field -> id, $item -> {$field -> slug}); ?></td>
											</tr>
										<?php endif; ?>
									<?php endforeach; ?>
								</table>
							<?php endif; ?>
						</td>
					</tr>
				<?php endif; ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Shipped', $this -> plugin_name); ?></th>
					<td><span style="color:<?php echo (!empty($item -> shipped) && $item -> shipped == "Y") ? 'green;">' . __('Yes', $this -> plugin_name) : 'red;">' . __('No', $this -> plugin_name); ?></span></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Created', $this -> plugin_name); ?></th>
					<td><?php echo $item -> created; ?></td>
				</tr>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Modified', $this -> plugin_name); ?></th>
					<td><?php echo $item -> modified; ?></td>
				</tr>
			</tbody>
		</table>
		<div class="tablenav">
		
			<br class="clear" />
		</div>
		<br class="clear" />
	<?php endif; ?>
</div>