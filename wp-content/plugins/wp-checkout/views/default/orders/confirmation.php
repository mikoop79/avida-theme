<?php if (!empty($order) && !empty($items)) : ?>
	<h3><?php _e('Order Summary', $this -> plugin_name); ?></h3>
	<table class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>cart">
		<thead>
			<tr>
				<th colspan="2"><?php _e('Product', $this -> plugin_name); ?></th>
				<th><?php _e('Options', $this -> plugin_name); ?></th>
				<th><?php _e('Price', $this -> plugin_name); ?></th>
				<th><?php _e('Qty', $this -> plugin_name); ?></th>
				<th><?php _e('Total', $this -> plugin_name); ?></th>
			</tr>
		</thead>
        <tfoot>
        	<tr>
				<th colspan="2"><?php _e('Product', $this -> plugin_name); ?></th>
				<th><?php _e('Options', $this -> plugin_name); ?></th>
				<th><?php _e('Price', $this -> plugin_name); ?></th>
				<th><?php _e('Qty', $this -> plugin_name); ?></th>
				<th><?php _e('Total', $this -> plugin_name); ?></th>
			</tr>
       	</tfoot>
		<tbody>
			<?php $class = ''; ?>
			<?php foreach ($items as $item) : ?>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<td style="width:50px;"><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($item -> product -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($item -> product -> image -> name), array('title' => apply_filters($this -> pre . '_product_title', $item -> product -> title), 'class' => 'colorbox', 'rel' => 'order-images')); ?></td>
					<td><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $item -> product -> title), get_permalink($item -> product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $item -> product -> title))); ?></td>
					<td>
						<?php if (!empty($item -> styles) || !empty($item -> product -> cfields) || (!empty($item -> width) && !empty($item -> length))) : ?>
							<table>
								<tbody>
                                	<?php if (!empty($item -> width) && !empty($item -> length)) : ?>
                                    	<tr>
                                        	<th><?php _e('Width', $this -> plugin_name); ?></th>
                                            <td><?php echo $item -> width; ?><?php _e('m', $this -> plugin_name); ?>
                                        </tr>
                                        <tr>
                                        	<th><?php _e('Length', $this -> plugin_name); ?></th>
                                            <td><?php echo $item -> length; ?><?php _e('m', $this -> plugin_name); ?>
                                        </tr>
                                    <?php endif; ?>
                                
									<?php if ($styles = @unserialize($item -> styles)) : ?>
										<?php foreach ($styles as $style_id => $option_id) : ?>
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
																<?php if ($option = $wpcoDb -> find(array('id' => $option_id), array('id', 'title', 'addprice', 'price'))) : ?>
																	<?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $wpcoHtml -> currency() . '' . $option -> price . ')' : ''; ?>
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
														<td><?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y" && !empty($option -> price)) ? ' (' . $wpcoHtml -> currency() . '' . $option -> price . ')' : ''; ?></td>
													</tr>
												<?php endif; ?>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endif; ?>
									<?php if (!empty($item -> product -> cfields)) : ?>
										<?php foreach ($item -> product -> cfields as $field_id) : ?>
											<?php $wpcoDb -> model = 'wpcoField'; ?>
											<?php if ($field = $wpcoDb -> find(array('id' => $field_id))) : ?>
												<?php if (!empty($item -> {$field -> slug})) : ?>
												<tr>
													<th><?php echo $field -> title; ?><?php echo (!empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) ? ' (' . $wpcoHtml -> currency() . '' . $field -> price . ')' : ''; ?></th>
													<td><?php echo $wpcoField -> get_value($field_id, $item -> {$field -> slug}); ?></td>
												</tr>
												<?php endif; ?>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
						<?php else : ?>
							<?php _e('none', $this -> plugin_name); ?>
						<?php endif; ?>
					</td>
					<td><?php echo $wpcoHtml -> currency(); ?><?php echo number_format($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true), 2, '.', ''); ?></td>
					<td><?php echo $item -> count; ?></td>
					<td><?php echo $wpcoHtml -> currency(); ?><?php echo number_format(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count), 2, '.', ''); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>