<div class="wrap">
	<h2><?php _e('View Variety', $this -> plugin_name); ?></h2>
	<div class="tablenav">
		<div class="alignleft">
        	<a href="?page=<?php echo $this -> sections -> styles; ?>&amp;method=order&amp;id=<?php echo $style -> id; ?>" title="<?php _e('Order/sort the variation options of this variation', $this -> plugin_name); ?>" class="button"><?php _e('Sort Options', $this -> plugin_name); ?></a>
			<a href="<?php echo $this -> url; ?>&amp;method=save&amp;id=<?php echo $style -> id; ?>" title="<?php _e('Edit the details of this variety', $this -> plugin_name); ?>" class="button"><?php _e('Change', $this -> plugin_name); ?></a>
			<a href="<?php echo $this -> url; ?>&amp;method=delete&amp;id=<?php echo $style -> id; ?>" title="<?php _e('Remove this variety and all its options', $this -> plugin_name); ?>" class="button button-highlighted" onclick="if (!confirm('<?php _e('Are you sure you wish to remove this variety?'); ?>')) { return false; }"><?php _e('Delete', $this -> plugin_name); ?></a>
		</div>
	</div>
	<?php $class = ''; ?>
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
				<th><?php _e('Title', $this -> plugin_name); ?></th>
				<td><?php echo $style -> title; ?></td>
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Options', $this -> plugin_name); ?></th>
				<td><?php echo $Option -> count(array('style_id' => $style -> id)); ?></td>
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Created', $this -> plugin_name); ?></th>
				<td><?php echo $style -> created; ?></td>
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Modified', $this -> plugin_name); ?></th>
				<td><?php echo $style -> modified; ?></td>
			</tr>
		</tbody>
	</table>
	
	<h3><?php _e('Options', $this -> plugin_name); ?></h3>
	<?php $this -> render('options/loop', array('options' => $options, 'paginate' => $paginate)); ?>
</div>