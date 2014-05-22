<div class="wrap">
	<h2><?php _e('Save an Order Item', $this -> plugin_name); ?></h2>
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post">
		<?php echo $wpcoForm -> hidden('Item.id'); ?>
        <?php echo $wpcoForm -> hidden('Item.edit', array('value' => 1)); ?>
        <?php echo $wpcoForm -> hidden('Item.cart_id', array('value' => "")); ?>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Item.user_id"><?php _e('User ID', $this -> plugin_name); ?></label></th>
					<td>
						<?php echo $wpcoForm -> text('Item.user_id', array('value' => $Item -> data -> user_id, 'width' => "65px")); ?>
						<span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('The ID of the WordPress user if any.', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="Item.product_id"><?php _e('Product ID', $this -> plugin_name); ?></label></th>
					<td>
						<?php echo $wpcoForm -> text('Item.product_id', array('value' => $Item -> data -> product_id, 'width' => "65px")); ?>
						<span class="howto"><?php _e('The ID of the product under Checkout > Products.', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<?php if ($wpcoHtml -> field_value('Item.product_id') != "") : ?>
					<?php $wpcoDb -> model = $Product -> model; ?>
					<?php if ($product = $wpcoDb -> find(array('id' => $wpcoHtml -> field_value('Item.product_id')))) : ?>
						<?php if ($product -> type == "tangible") : ?>
							<tr>
								<th><label for="Item.shippedY"><?php _e('Shipped', $this -> plugin_name); ?></label></th>
								<td>
									<?php $shipped = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
									<?php echo $wpcoForm -> radio('Item.shipped', $shipped, array('separator' => false)); ?>
									<span class="howto"><?php _e('Has this item been shipped to the destination?', $this -> plugin_name); ?></span>
								</td>
							</tr>
						<?php endif; ?>
						<?php if (!empty($product -> cfields)) : ?>
							<?php foreach ($product -> cfields as $field_id) : ?>
								<?php $wpcoDb -> model = $wpcoField -> model; ?>
								<?php if ($field = $wpcoDb -> find(array('id' => $field_id))) : ?>
									<tr>
										<th><label for=""><?php echo __($field -> title); ?></label></th>
										<td>
											<?php echo $this -> render_field($field_id); ?>
											<?php echo $wpcoHtml -> field_error('Item.fields_' . $field_id); ?>
										</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
						<?php if (!empty($product -> styles)) : ?>
							<?php foreach ($product -> styles as $style_id) : ?>
								<?php $wpcoDb -> model = $Style -> model; ?>
								<?php if ($style = $wpcoDb -> find(array('id' => $style_id))) : ?>
									<tr>
										<th><label for=""><?php echo __($style -> title); ?></label></th>
										<td>
											<?php $styles = @unserialize($Item -> data -> styles); ?>
											<?php $_POST['Item']['styles'][$style_id] = $styles[$style_id]; ?>
											<?php echo $this -> render_style($style_id, $product -> options[$style_id], false); ?>
											<?php echo $wpcoHtml -> field_error('Item.styles_' . $style_id); ?>
										</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				<tr>
					<th><label for="Item.order_id"><?php _e('Order ID', $this -> plugin_name); ?></label></th>
					<td>
						<?php echo $wpcoForm -> text('Item.order_id', array('value' => $Item -> data -> order_id, 'width' => "65px")); ?>
						<span class="howto"><?php _e('The ID of the order to add this item/product to.', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="Item.count"><?php _e('Quantity', $this -> plugin_name); ?></label></th>
					<td>
						<?php echo $wpcoForm -> text('Item.count', array('width' => '65px')); ?>
						<span class="howto"><?php _e('Quantity/count for this item/product.', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="Item.completedY"><?php _e('Completed', $this -> plugin_name); ?></label></th>
					<td>
						<?php $completed = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Item.completed', $completed, array('separator' => false)); ?>
						<span class="howto"><?php _e('Has the checkout/agreement of this item/product been completed?', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="Item.paidY"><?php _e('Paid For', $this -> plugin_name); ?></label></th>
					<td>
						<?php $paid = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Item.paid', $paid, array('separator' => false)); ?>
						<span class="howto"><?php _e('Has this item been paid in full?', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
	
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save Order Item', $this -> plugin_name)); ?>
		</p>
	</form>
</div>