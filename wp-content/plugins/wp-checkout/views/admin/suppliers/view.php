<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('View Supplier:', $this -> plugin_name); ?> <?php echo $supplier -> name; ?></h2>
	<div style="float:none;" class="subsubsub"><?php echo $wpcoHtml -> link(__('&larr; Back to Suppliers', $this -> plugin_name), $this -> url); ?></div>
	
	<div class="tablenav">
		<div class="alignleft">
			<a class="button" href="?page=<?php echo $this -> sections -> suppliers; ?>&amp;method=save&amp;id=<?php echo $supplier -> id; ?>" title="<?php _e('Change the details of this supplier.', $this -> plugin_name); ?>"><?php _e('Change', $this -> plugin_name); ?></a>
			<a class="button button-highlighted" href="<?php echo $this -> url; ?>&amp;method=delete&amp;id=<?php echo $supplier -> id; ?>" onclick="if (!confirm('<?php _e('Are you sure you wish to remove this supplier?', $this -> plugin_name); ?>')) { return false; }" title="<?php _e('Remove this supplier and all products', $this -> plugin_name); ?>"><?php _e('Delete', $this -> plugin_name); ?></a>
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
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Name', $this -> plugin_name); ?></th>
				<td><?php echo __($supplier -> name); ?></td>
			</tr>
			<?php if (!empty($supplier -> image) && $supplier -> image == "Y") : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Supplier Image', $this -> plugin_name); ?></th>
					<td>
						<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($supplier -> image_url, 100, 100, 100), $wpcoHtml -> image_url($supplier -> imagename, 'suppliers'), array('class' => 'colorbox', 'title' => $supplier -> name)); ?>
						<br/><small><?php _e('click to enlarge', $this -> plugin_name); ?></small>
					</td>
				</tr>
			<?php endif; ?>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Products', $this -> plugin_name); ?></th>
				<td>
					<?php $wpcoDb -> model = $Product -> model; ?>
					<?php echo $wpcoDb -> count(array('supplier_id' => $supplier -> id)); ?>
				</td>
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Post/Page', $this -> plugin_name); ?></th>
				<td><a href="<?php echo get_permalink($suplier -> post_id); ?>" target="_blank" title="<?php echo __($supplier -> name); ?>"><?php echo __($supplier -> name); ?></a></td>
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Created', $this -> plugin_name); ?></th>
				<td><?php echo $supplier -> created; ?></td>
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Modified', $this -> plugin_name); ?></th>
				<td><?php echo $supplier -> modified; ?></td>
			</tr>
		</tbody>
	</table>
	
	<h3><?php _e('Products', $this -> plugin_name); ?></h3>
	<?php $this -> render('products' . DS . 'loop', array('products' => $products, 'paginate' => $paginate), true, 'admin'); ?>
</div>