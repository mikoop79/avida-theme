<?php if (!empty($files)) : ?>
	<form action="?page=checkout-files&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected files?'); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft actions">
				<select name="action">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
				</select>
				<input class="button" type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" />
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
					<th class="check-column"><input type="checkbox" name="checkboxall" value="checkboxall" id="checkboxall" /></th>
					<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
							<span><?php _e('Title', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-type <?php echo ($orderby == "type") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=type&order=' . (($orderby == "type") ? $otherorder : "asc")); ?>">
							<span><?php _e('Type', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-product_id <?php echo ($orderby == "product_id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=product_id&order=' . (($orderby == "product_id") ? $otherorder : "asc")); ?>">
							<span><?php _e('Product', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-downloads <?php echo ($orderby == "downloads") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=downloads&order=' . (($orderby == "downloads") ? $otherorder : "asc")); ?>">
							<span><?php _e('Downloads', $this -> plugin_name); ?></span>
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
					<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
							<span><?php _e('Title', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-type <?php echo ($orderby == "type") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=type&order=' . (($orderby == "type") ? $otherorder : "asc")); ?>">
							<span><?php _e('Type', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-product_id <?php echo ($orderby == "product_id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=product_id&order=' . (($orderby == "product_id") ? $otherorder : "asc")); ?>">
							<span><?php _e('Product', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-downloads <?php echo ($orderby == "downloads") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=downloads&order=' . (($orderby == "downloads") ? $otherorder : "asc")); ?>">
							<span><?php _e('Downloads', $this -> plugin_name); ?></span>
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
				<?php foreach ($files as $file) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th class="check-column"><input type="checkbox" name="File[checklist][]" value="<?php echo $file -> id; ?>" id="checklist<?php echo $file -> id; ?>" /></th>
					<td>
						<?php echo $wpcoHtml -> link($file -> title, $this -> url . '&amp;method=save&amp;id=' . $file -> id, array('class' => 'row-title')); ?>
						<div class="row-actions">
							<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), "?page=checkout-files&amp;method=save&amp;id=" . $file -> id); ?> |</span>
							<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), "?page=checkout-files&amp;method=delete&amp;id=" . $file -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you want to delete this file?', $this -> plugin_name) . "')) { return false; }")); ?></span>
						</div>
					</td>
					<td><?php echo (empty($file -> type) || $file -> type == "file") ? __('File', $this -> plugin_name) : __('Link/URL', $this -> plugin_name); ?></td>
					<td><?php echo $wpcoHtml -> link($file -> product -> title, '?page=checkout-products&amp;method=view&amp;id=' . $file -> product -> id . '', array('title' => $file -> product -> title)); ?></td>
					<td><?php echo $file -> downloads; ?></td>
					<td><abbr title="<?php echo $file -> modified; ?>"><?php echo date("Y-m-d", strtotime($file -> modified)); ?></abbr></td>
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
						<option <?php echo (isset($_COOKIE[$this -> pre . 'filesperpage']) && $_COOKIE[$this -> pre . 'filesperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('files', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>filesperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> UTC; path=/";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No files are available', $this -> plugin_name); ?></p>
<?php endif; ?>