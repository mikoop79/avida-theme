<?php if (!empty($categories)) : ?>
	<form onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action?', $this -> plugin_name); ?>')) { return false; }" action="?page=checkout-categories&amp;method=mass" method="post">
		<div class="tablenav">
			<div class="alignleft actions">
            	<a class="button" href="?page=<?php echo $this -> sections -> categories; ?>&amp;method=order"><?php _e('Order Categories', $this -> plugin_name); ?></a>
			</div>
			<div class="alignleft actions">
				<select class="widefat" style="width:auto;" name="action" onchange="change_action(this.value);">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
					<option value="setparent"><?php _e('Set Parent...', $this -> plugin_name); ?></option>
				</select>
				
				<script type="text/javascript">
				function change_action(action) {
					jQuery('#categoriesdiv').hide();
					
					if (action == "setparent") {
						jQuery('#categoriesdiv').show();
					}
				}
				</script>
				
				<span id="categoriesdiv" style="display:none;">
					<?php $selectcategories = $Category -> select(); ?>
					<?php echo $wpcoForm -> select('parentcategory', $selectcategories); ?>
				</span>
			
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
					<th class="check-column"><input type="checkbox" name="checkboxall" id="Category.checkboxall" value="checkboxall" /></th>
					<th class="column-id <?php echo ($orderby == "id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=id&order=' . (($orderby == "id") ? $otherorder : "asc")); ?>">
							<span><?php _e('ID', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
							<span><?php _e('Title', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-parent_id <?php echo ($orderby == "parent_id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=parent_id&order=' . (($orderby == "parent_id") ? $otherorder : "asc")); ?>">
							<span><?php _e('Parent', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-useimage <?php echo ($orderby == "useimage") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=useimage&order=' . (($orderby == "useimage") ? $otherorder : "asc")); ?>">
							<span><?php _e('Image', $this -> plugin_name); ?></span>
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
					<th class="check-column"><input type="checkbox" name="checkboxall" id="Category.checkboxall" value="checkboxall" /></th>
					<th class="column-id <?php echo ($orderby == "id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=id&order=' . (($orderby == "id") ? $otherorder : "asc")); ?>">
							<span><?php _e('ID', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-title <?php echo ($orderby == "title") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=title&order=' . (($orderby == "title") ? $otherorder : "asc")); ?>">
							<span><?php _e('Title', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-parent_id <?php echo ($orderby == "parent_id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=parent_id&order=' . (($orderby == "parent_id") ? $otherorder : "asc")); ?>">
							<span><?php _e('Parent', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-useimage <?php echo ($orderby == "useimage") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=useimage&order=' . (($orderby == "useimage") ? $otherorder : "asc")); ?>">
							<span><?php _e('Image', $this -> plugin_name); ?></span>
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
				<?php foreach ($categories as $category) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th class="check-column"><input type="checkbox" id="Category.checklist<?php echo $category -> id; ?>" name="Category[checklist][]" value="<?php echo $category -> id; ?>" /></th>
					<td><label for="Category.checklist<?php echo $category -> id; ?>"><?php echo $category -> id; ?></label></td>
					<td>
						<a href="<?php echo $this -> url; ?>&amp;method=view&amp;id=<?php echo $category -> id; ?>" class="row-title" title="<?php echo $category -> title; ?>"><?php echo $category -> title; ?></a>
						<div class="row-actions">
							<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=checkout-categories-save&amp;id=' . $category -> id); ?> |</span>
							<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), '?page=checkout-categories&amp;method=delete&amp;id=' . $category -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you wish to remove this category?', $this -> plugin_name) . "')) { return false; }")); ?> |</span>
							<span class="view"><?php echo $wpcoHtml -> link(__('View', $this -> plugin_name), '?page=checkout-categories&amp;method=view&amp;id=' . $category -> id); ?> |</span>
							<span class="edit"><?php echo $wpcoHtml -> link(__('Order Products', $this -> plugin_name), '?page=checkout-products&amp;method=order&amp;category_id=' . $category -> id); ?></span>
							<?php if (!empty($category -> post_id) && $link = get_permalink($category -> post_id)) : ?>
								<span class="view">| <?php echo $wpcoHtml -> link(__('View on Front', $this -> plugin_name), $link); ?></span>
							<?php endif; ?>
						</div>
					</td>
					<td>
						<?php $wpcoDb -> model = $Category -> model; ?>
						<?php echo ($parent = $wpcoDb -> field('title', array('id' => $category -> parent_id))) ? $wpcoHtml -> link($parent, '?page=checkout-categories&amp;method=view&amp;id=' . $category -> parent_id, array('title' => $parent)) : __('none', $this -> plugin_name); ?></td>
					<td>
						<?php if (empty($category -> useimage) || $category -> useimage == "N") : ?>
							<?php _e('No Image', $this -> plugin_name); ?>
                        <?php else : ?>
                        	<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($category -> image_url, 45, 45, 100), $wpcoHtml -> image_url($category -> image -> name, 'catimages'), array('class' => "colorbox", 'title' => $category -> title)); ?>
                        <?php endif; ?>
                    </td>
					<td><?php $wpcoDb -> model = $wpcoCategoriesProduct -> model; ?><?php echo $wpcoHtml -> link($wpcoDb -> count(array('category_id' => $category -> id)), "?page=checkout-categories&amp;method=view&amp;id=" . $category -> id); ?></td>
					<td><abbr title="<?php echo $category -> modified; ?>"><?php echo $wpcoHtml -> gen_date("Y-m-d", strtotime($category -> modified)); ?></abbr></td>
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
						<option <?php echo (isset($_COOKIE[$this -> pre . 'categoriesperpage']) && $_COOKIE[$this -> pre . 'categoriesperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('categories', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>categoriesperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> GMT; path=/";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No categories were found', $this -> plugin_name); ?></p>
<?php endif; ?>