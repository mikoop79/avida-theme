<?php if (!empty($products)) : ?>
	<div class="scroll-list">
		<table class="form-table">
			<thead>
				<tr>
					<th style="font-weight:bold;"><?php _e('Product', $this -> plugin_name); ?></th>
					<th style="font-weight:bold;"><?php _e('Stock', $this -> plugin_name); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php $class = false; ?>
				<?php foreach ($products as $product) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'arow' : ''; ?>">
						<td>
							<?php echo $wpcoHtml -> link(__($product -> title), '?page=' . $this -> sections -> products_save . '&amp;id=' . $product -> id); ?>
						</td>
						<td>
							<?php if (!empty($product -> inventory)) : ?>
								<?php echo sprintf(__('%s units', $this -> plugin_name), $product -> inventory); ?>
							<?php else : ?>
								<span style="color:red;"><?php echo __('Out of Stock', $this -> plugin_name); ?></span>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>successmsg"><?php _e('There are currently no out of stock or low stock products.', $this -> plugin_name); ?></p>
<?php endif; ?>