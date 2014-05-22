<div class="wrap">
	<h2><?php _e('View Category:', $this -> plugin_name); ?> <?php echo __($category -> title); ?></h2>	
	
	<div style="float:none;" class="subsubsub"><?php echo $wpcoHtml -> link(__('&larr; Back to Categories', $this -> plugin_name), $this -> url); ?></div>
	
	<div class="tablenav">
		<div class="alignleft">
			<a class="button" href="?page=<?php echo $this -> sections -> products; ?>&amp;method=order&amp;category_id=<?php echo $category -> id; ?>"><?php _e('Order Products', $this -> plugin_name); ?></a>
			<a class="button" href="<?php echo $this -> url; ?>&amp;method=save&amp;id=<?php echo $category -> id; ?>" title="<?php _e('Change the details of this category', $this -> plugin_name); ?>"><?php _e('Change', $this -> plugin_name); ?></a>
			<a class="button button-highlighted" href="<?php echo $this -> url; ?>&amp;method=delete&amp;id=<?php echo $category -> id; ?>" onclick="if (!confirm('<?php _e('Are you sure you wish to remove this category?', $this -> plugin_name); ?>')) { return false; }" title="<?php _e('Remove this category and all products', $this -> plugin_name); ?>"><?php _e('Delete', $this -> plugin_name); ?></a>
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
				<th><?php _e('Title', $this -> plugin_name); ?></th>
				<td><?php echo __($category -> title); ?></td>
			</tr>
			<?php if ($category -> useimage == "Y") : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th><?php _e('Category Image', $this -> plugin_name); ?></th>
					<td>
						<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($category -> image_url, 100, 100, 100), $wpcoHtml -> image_url($category -> image -> name, 'catimages'), array('class' => 'colorbox', 'title' => __($category -> title))); ?>
						<br/><small><?php _e('click to enlarge', $this -> plugin_name); ?></small>
					</td>
				</tr>
			<?php endif; ?>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Products', $this -> plugin_name); ?></th>
				<td>
					<?php $wpcoDb -> model = $wpcoCategoriesProduct -> model; ?>
					<?php echo $wpcoDb -> count(array('category_id' => $category -> id)); ?>
				</td>
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Post/Page', $this -> plugin_name); ?></th>
				<td><a href="<?php echo get_permalink($category -> post_id); ?>" target="_blank" title="<?php echo __($category -> title); ?>"><?php echo __($category -> title); ?></a></td>
			</tr>
			<?php if (!empty($category -> parent_id) && $category -> parent_id != 0) : ?>
				<?php $wpcoDb -> model = $Category -> model; ?>
				<?php if ($parent = $wpcoDb -> find(array('id' => $category -> parent_id))) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th><?php _e('Parent Category', $this -> plugin_name); ?></th>
						<td><?php echo $wpcoHtml -> link($parent -> title, $this -> url . '&amp;method=view&amp;id=' . $parent -> id); ?></td>
					</tr>
				<?php endif; ?>
			<?php endif; ?>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Created', $this -> plugin_name); ?></th>
				<td><?php echo $category -> created; ?></td>
			</tr>
			<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
				<th><?php _e('Modified', $this -> plugin_name); ?></th>
				<td><?php echo $category -> modified; ?></td>
			</tr>
		</tbody>
	</table>
	
	<h3><?php _e('Products', $this -> plugin_name); ?></h3>
	<?php $this -> render('products' . DS . 'loop', array('products' => $products, 'paginate' => $paginate), true, 'admin'); ?>
</div>