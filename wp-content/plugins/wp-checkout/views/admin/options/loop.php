<?php if (!empty($options)) : ?>
	<form action="?page=checkout-options&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected variation options?', $this -> plugin_name); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft actions">
				<select class="widefat" style="width:auto;" name="action">
					<option value="">- <?php _e('Bulk Actions', $this -> plugin_name); ?> -</option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
				</select>
				<input type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" class="button" />
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
					<th class="column-style_id <?php echo ($orderby == "style_id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=style_id&order=' . (($orderby == "style_id") ? $otherorder : "asc")); ?>">
							<span><?php _e('Variation', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-price <?php echo ($orderby == "price") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=price&order=' . (($orderby == "price") ? $otherorder : "asc")); ?>">
							<span><?php _e('Price', $this -> plugin_name); ?></span>
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
					<th class="column-style_id <?php echo ($orderby == "style_id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=style_id&order=' . (($orderby == "style_id") ? $otherorder : "asc")); ?>">
							<span><?php _e('Variation', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-price <?php echo ($orderby == "price") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=price&order=' . (($orderby == "price") ? $otherorder : "asc")); ?>">
							<span><?php _e('Price', $this -> plugin_name); ?></span>
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
				<?php foreach ($options as $option) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th class="check-column"><input type="checkbox" id="checklist<?php echo $option -> id; ?>" name="Option[checklist][]" value="<?php echo $option -> id; ?>" /></th>
					<td>
                    	<?php if (!empty($option -> image)) : ?>
                        	<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($option -> image_url, 50, 50, 100), $wpcoHtml -> image_url($option -> image, 'optionimages'), array('class' => "colorbox", 'title' => $option -> title)); ?>
                        <?php endif; ?>
						<?php echo $wpcoHtml -> link($option -> title, '?page=checkout-options&amp;method=save&amp;id=' . $option -> id . '', array('class' => 'row-title')); ?>
						<div class="row-actions">
							<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=checkout-options&amp;method=save&amp;id=' . $option -> id); ?> |</span>
							<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), '?page=checkout-options&amp;method=delete&amp;id=' . $option -> id, array('onclick' => "if (!confirm('" . __('Are you sure you want to delete this option?', $this -> plugin_name) . "')) { return false; }", 'class' => "submitdelete")); ?></span>
						</div>	
					</td>
					<td><?php echo $wpcoHtml -> link($Style -> field('title', array('id' => $option -> style_id)), '?page=checkout-styles&amp;method=view&amp;id=' . $option -> style_id); ?></td>
					<td><label for="checklist<?php echo $option -> id; ?>"><?php echo (!empty($option -> addprice) && $option -> addprice == "Y") ? __('Yes', $this -> plugin_name) . ' (' . $wpcoHtml -> currency_price($option -> price) . ')' : __('No', $this -> plugin_name); ?></label></td>
					<td><abbr title="<?php echo $option -> modified; ?>"><?php echo date("Y-m-d", strtotime($option -> modified)); ?></abbr></td>
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
						<option <?php echo (isset($_COOKIE[$this -> pre . 'optionsperpage']) && $_COOKIE[$this -> pre . 'optionsperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('options', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>optionsperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> GMT; path=/;";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No variation options are available', $this -> plugin_name); ?></p>
<?php endif; ?>