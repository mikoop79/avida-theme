<?php if (!empty($styles)) : ?>
	<form action="?page=checkout-styles&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to remove the selected variations?', $this -> plugin_name); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft actions">
				<a href="<?php echo $this -> url; ?>&amp;method=sort" title="<?php _e('Order/Sort Variations', $this -> plugin_name); ?>" class="button"><?php _e('Order Variations', $this -> plugin_name); ?></a>
				<select name="action">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
				</select>
				<input class="button" type="submit" name="apply" value="<?php _e('Apply', $this -> plugin_name); ?>" />
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
		
		<?php
		
		$orderby = (empty($_GET['orderby'])) ? 'modified' : $_GET['orderby'];
		$order = (empty($_GET['order'])) ? 'desc' : strtolower($_GET['order']);
		$otherorder = ($order == "desc") ? 'asc' : 'desc';
		
		?>
		
		<table class="widefat">
			<thead>
				<tr>
					<th class="check-column"><input type="checkbox" id="checkboxall" name="checkboxall" value="checkboxall" /></th>
					<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
							<span><?php _e('Title', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Options', $this -> plugin_name); ?></th>
					<th class="column-type <?php echo ($orderby == "type") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=type&order=' . (($orderby == "type") ? $otherorder : "asc")); ?>">
							<span><?php _e('Type', $this -> plugin_name); ?></span>
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
					<th class="check-column"><input type="checkbox" id="checkboxall" name="checkboxall" value="checkboxall" /></th>
					<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
							<span><?php _e('Title', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Options', $this -> plugin_name); ?></th>
					<th class="column-type <?php echo ($orderby == "type") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=type&order=' . (($orderby == "type") ? $otherorder : "asc")); ?>">
							<span><?php _e('Type', $this -> plugin_name); ?></span>
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
				<?php foreach ($styles as $style) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th class="check-column"><input type="checkbox" id="checklist<?php echo $style -> id; ?>" name="Style[checklist][]" value="<?php echo $style -> id; ?>" /></th>
					<td>
						<strong><?php echo $wpcoHtml -> link($style -> title, '?page=checkout-styles&amp;method=save&amp;id=' . $style -> id, array('class' => 'row-title')); ?></strong>
						<div class="row-actions">
							<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=checkout-styles&amp;method=save&amp;id=' . $style -> id); ?> |</span>
							<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), '?page=checkout-styles&amp;method=delete&amp;id=' . $style -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you want to delete this product style?', $this -> plugin_name) . "')) { return false; }")); ?> |</span>
							<span class="view"><?php echo $wpcoHtml -> link(__('View', $this -> plugin_name), '?page=checkout-styles&amp;method=view&amp;id=' . $style -> id); ?> |</span>
                            <span class="edit"><?php echo $wpcoHtml -> link(__('Sort Options', $this -> plugin_name), '?page=' . $this -> sections -> styles . '&amp;method=order&amp;id=' . $style -> id); ?></span>
						</div>	
					</td>
					<td><a href="?page=checkout-styles&amp;method=view&amp;id=<?php echo $style -> id; ?>"><?php echo $Option -> count(array('style_id' => $style -> id)); ?></a></td>
					<td><label for="checklist<?php echo $style -> id; ?>"><?php echo $wpcoHtml -> styletype($style -> type); ?></label></td>
					<td><abbr title="<?php echo $style -> modified; ?>"><?php echo date("Y-m-d", strtotime($style -> modified)); ?></abbr></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="tablenav">
			<div class="alignleft">
				<select name="perpage" onchange="change_perpage(this.value);">
					<option value="">- <?php _e('Per Page', $this -> plugin_name); ?> -</option>
					<?php $p = 5; ?>
					<?php while ($p < 100) : ?>
						<option <?php echo (isset($_COOKIE[$this -> pre . 'stylesperpage']) && $_COOKIE[$this -> pre . 'stylesperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('styles', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>stylesperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> GMT; path=/";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No variations are available', $this -> plugin_name); ?></p>
<?php endif; ?>