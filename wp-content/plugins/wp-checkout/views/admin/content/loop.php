<?php if (!empty($contents)) : ?>
	<form action="?page=checkout-content&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected content?', $this -> plugin_name); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft actions">
				<select name="action" onchange="change_action(this.value);">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
					<option value="setproduct"><?php _e('Assign to Product...', $this -> plugin_name); ?></option>
				</select>
				<span id="productsdiv" style="display:none;">
					<select name="product">
						<option value="">- <?php _e('Select', $this -> plugin_name); ?> -</option>
						<?php if ($products = $Product -> select()) : ?>
							<?php foreach ($products as $pid => $ptitle) : ?>
								<option value="<?php echo $pid; ?>"><?php echo $ptitle; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</span>
				<script type="text/javascript">
				function change_action(action) {
					if (action != "") {
						jQuery("#productsdiv").hide();
						
						if (action == "setproduct") {
							jQuery("#productsdiv").show();
						}
					}
				}
				</script>
				<input type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" class="button-secondary delete" />
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
		</div>
		
		<table class="widefat">
			<thead>
				<tr>
					<th class="check-column"><input type="checkbox" name="checkboxall" value="checkboxall" id="checkboxall" /></th>
					<th><?php _e('Title', $this -> plugin_name); ?></th>
					<th><?php _e('Product', $this -> plugin_name); ?></th>
					<th><?php _e('Date', $this -> plugin_name); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="check-column"><input type="checkbox" name="checkboxall" value="checkboxall" id="checkboxall" /></th>
					<th><?php _e('Title', $this -> plugin_name); ?></th>
					<th><?php _e('Product', $this -> plugin_name); ?></th>
					<th><?php _e('Date', $this -> plugin_name); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php $class = ''; ?>
				<?php foreach ($contents as $content) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th class="check-column"><input type="checkbox" name="wpcoContent[checklist][]" value="<?php echo $content -> id; ?>" id="checklist<?php echo $content -> id; ?>" /></th>
						<td>
							<?php echo $wpcoHtml -> link($content -> title, '?page=checkout-content-save&amp;id=' . $content -> id, array('class' => "row-title", 'title' => $content -> title)); ?>
							<div class="row-actions">
								<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=checkout-content-save&amp;id=' . $content -> id); ?> |</span>
								<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), '?page=checkout-content&amp;method=delete&amp;id=' . $content -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you wish to delete this content?', $this -> plugin_name) . "')) { return false; }")); ?></span>
							</div>	
						</td>
						<td>
							<?php $wpcoDb -> model = $Product -> model; ?>
							<?php if ($product_title = $wpcoDb -> field("title", array('id' => $content -> product_id))) : ?>
								<?php echo $wpcoHtml -> link($product_title, '?page=checkout-products&amp;method=view&amp;id=' . $content -> product_id); ?>
							<?php else : ?><?php _e('none', $this -> plugin_name); ?><?php endif; ?>
						</td>
						<td><label for="checklist<?php echo $content -> id; ?>"><abbr title="<?php echo $content -> modified; ?>"><?php echo date("Y-m-d", strtotime($content -> modified)); ?></abbr></label></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="tablenav">
			<div class="alignleft">
				<select onchange="change_perpage(this.value);" name="perpage">
					<option value="">- <?php _e('Per Page', $this -> plugin_name); ?> -</option>
					<?php $p = 5; ?>
					<?php while ($p < 100) : ?>
						<option <?php echo (isset($_COOKIE[$this -> pre . 'contentsperpage']) && $_COOKIE[$this -> pre . 'contentsperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('contents', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>contentsperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> UTC; path=/";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No content is available', $this -> plugin_name); ?></p>
<?php endif; ?>