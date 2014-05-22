<?php if (!empty($suppliers)) : ?>
	<form action="?page=checkout-suppliers&amp;method=mass" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected suppliers?', $this -> plugin_name); ?>')) { return false; }" method="post">
		<div class="tablenav">
			<div class="alignleft">
				<a class="button" href="?page=<?php echo $this -> sections -> suppliers; ?>&amp;method=order"><?php _e('Order Suppliers', $this -> plugin_name); ?></a>
				<select class="widefat" style="width:auto;" name="action">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
				</select>
				<input type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" class="button-secondary delete" />
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
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
					<th class="column-name <?php echo ($orderby == "name") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=name&order=' . (($orderby == "name") ? $otherorder : "asc")); ?>">
							<span><?php _e('Name', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-image <?php echo ($orderby == "image") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=image&order=' . (($orderby == "image") ? $otherorder : "asc")); ?>">
							<span><?php _e('Image', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-notify <?php echo ($orderby == "notify") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=notify&order=' . (($orderby == "notify") ? $otherorder : "asc")); ?>">
							<span><?php _e('Notify', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Products', $this -> plugin_name); ?></th>
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
					<th class="column-name <?php echo ($orderby == "name") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=name&order=' . (($orderby == "name") ? $otherorder : "asc")); ?>">
							<span><?php _e('Name', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-image <?php echo ($orderby == "image") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=image&order=' . (($orderby == "image") ? $otherorder : "asc")); ?>">
							<span><?php _e('Image', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-notify <?php echo ($orderby == "notify") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=notify&order=' . (($orderby == "notify") ? $otherorder : "asc")); ?>">
							<span><?php _e('Notify', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Products', $this -> plugin_name); ?></th>
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
				<?php foreach ($suppliers as $supplier) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th class="check-column"><input type="checkbox" name="Supplier[checklist][]" value="<?php echo $supplier -> id; ?>" id="checklist<?php echo $supplier -> id; ?>" /></th>
					<td>
						<strong><?php echo $wpcoHtml -> link($supplier -> name, "?page=checkout-suppliers&amp;method=view&amp;id=" . $supplier -> id, array('class' => "row-title", 'title' => $supplier -> name)); ?></strong>
						<div class="row-actions">
							<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=checkout-suppliers&amp;method=save&amp;id=' . $supplier -> id); ?> |</span>
							<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), '?page=checkout-suppliers&amp;method=delete&amp;id=' . $supplier -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you want to delete this supplier?', $this -> plugin_name) . "')) { return false; }")); ?> |</span>
							<span class="view"><?php echo $wpcoHtml -> link(__('View', $this -> plugin_name), '?page=' . $this -> sections -> suppliers . '&amp;method=view&amp;id=' . $supplier -> id); ?> |</span>
							<span class="edit"><?php echo $wpcoHtml -> link(__('Order Products', $this -> plugin_name), '?page=' . $this -> sections -> products . '&amp;method=order&amp;supplier_id=' . $supplier -> id); ?></span>
						</div>
					</td>
					<td>
						<?php if (!empty($supplier -> image) && $supplier -> image == "Y") : ?> 
                        	<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($supplier -> image_url, 45, 45, 100), $wpcoHtml -> image_url($supplier -> imagename, 'suppliers'), array('class' => 'colorbox', 'title' => $supplier -> name)); ?>
                        <?php else : ?>
                        	<?php echo __('No Image', $this -> plugin_name); ?>
                        <?php endif; ?>
                    </td>
					<td><label for="checklist<?php echo $supplier -> id; ?>"><?php echo (!empty($supplier -> notify) && $supplier -> notify == "Y") ? __('Yes', $this -> plugin_name) : __('No', $this -> plugin_name); ?></label></td>
					<td><label for="checklist<?php echo $supplier -> id; ?>"><?php $wpcoDb -> model = $Product -> model; ?><?php echo $wpcoDb -> count(array('supplier_id' => $supplier -> id)); ?></label></td>
					<td><abbr title="<?php echo $supplier -> modified; ?>"><?php echo date("Y-m-d", strtotime($supplier -> modified)); ?></abbr></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="tablenav">
			<div class="alignleft">
				<select class="widefat" style="width:auto;" name="perpage" onchange="change_perpage(this.value);">
					<option value="">- <?php _e('Per Page', $this -> plugin_name); ?> -</option>
					<?php $p = 5; ?>
					<?php while ($p < 100) : ?>
						<option <?php echo (isset($_COOKIE[$this -> pre . 'suppliersperpage']) && $_COOKIE[$this -> pre . 'suppliersperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('suppliers', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>suppliersperpage=" + perpage + "; expires=<?php echo date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> UTC; path=/";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
					
					return false;
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No suppliers are available', $this -> plugin_name); ?></p>
<?php endif; ?>