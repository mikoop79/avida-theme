<?php if (!empty($fields)) : ?>
	<form action="?page=checkout-fields&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected custom fields?', $this -> plugin_name); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft actions">
				<a href="<?php echo $this -> url; ?>&amp;method=order" title="<?php _e('Order/Sort Custom Fields', $this -> plugin_name); ?>" class="button"><?php _e('Order Fields', $this -> plugin_name); ?></a>
			</div>
			<div class="alignleft actions">
				<select name="action" onchange="change_action(this.value);">
					<option value="">- <?php _e('Bulk Action', $this -> plugin_name); ?> -</option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
					<option value="required"><?php _e('Set as Required', $this -> plugin_name); ?></option>
					<option value="notrequired"><?php _e('Set as NOT Required', $this -> plugin_name); ?></option>
					<option value="globalf"><?php _e('Set as Global', $this -> plugin_name); ?></option>
					<option value="notglobalf"><?php _e('Set as NOT Global', $this -> plugin_name); ?></option>
				</select>
                
                <span id="globalfdiv" style="display:none;">
                	<?php global $globalpoptions; require_once $this -> plugin_base() . DS . 'includes' . DS . 'variables.php'; ?>
                    <label>
                    	<?php _e('Show On:', $this -> plugin_name); ?>
						<?php echo $wpcoForm -> select('wpcoField.globalp', $globalpoptions); ?>
                    </label>
                </span>
                
                <script type="text/javascript">
				function change_action(value) {
					jQuery('#globalfdiv').hide();
					
					if (value == "globalf") {
						jQuery('#globalfdiv').show();	
					}
				}
				</script>
                
				<input type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" class="button" />
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
					<th class="column-required <?php echo ($orderby == "required") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=required&order=' . (($orderby == "required") ? $otherorder : "asc")); ?>">
							<span><?php _e('Required', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-price <?php echo ($orderby == "price") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=price&order=' . (($orderby == "price") ? $otherorder : "asc")); ?>">
							<span><?php _e('Price', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-globalf <?php echo ($orderby == "globalf") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=globalf&order=' . (($orderby == "globalf") ? $otherorder : "asc")); ?>">
							<span><?php _e('Global', $this -> plugin_name); ?></span>
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
					<th class="column-required <?php echo ($orderby == "required") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=required&order=' . (($orderby == "required") ? $otherorder : "asc")); ?>">
							<span><?php _e('Required', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-price <?php echo ($orderby == "price") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=price&order=' . (($orderby == "price") ? $otherorder : "asc")); ?>">
							<span><?php _e('Price', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-globalf <?php echo ($orderby == "globalf") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=globalf&order=' . (($orderby == "globalf") ? $otherorder : "asc")); ?>">
							<span><?php _e('Global', $this -> plugin_name); ?></span>
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
				<?php $fieldtypes = $this -> get_option('fieldtypes'); ?>
				<?php $class = ''; ?>
				<?php foreach ($fields as $field) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th class="check-column"><input type="checkbox" name="wpcoField[checklist][]" value="<?php echo $field -> id; ?>" id="checklist<?php echo $field ->id; ?>" /></th>
						<td>
							<?php echo $wpcoHtml -> link($field -> title, '?page=checkout-fields&amp;method=save&amp;id=' . $field -> id . '', array('class' => "row-title", 'title' => $field -> title)); ?>
							<div class="row-actions">
								<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), "?page=checkout-fields&amp;method=save&amp;id=" . $field -> id); ?> |</span>
								<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), "?page=checkout-fields&amp;method=delete&amp;id=" . $field -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you wish to delete this custom field?', $this -> plugin_name) . "')) { return false; }")); ?></span>
							</div>
						</td>
						<td><label for="checklist<?php echo $field -> id; ?>"><?php echo $fieldtypes[$field -> type]; ?></label></td>
						<td><label for="checklist<?php echo $field -> id; ?>"><?php echo (!empty($field -> required) && $field -> required == "Y") ? '<span style="color:red;">' . __('Yes', $this -> plugin_name) : '<span style="color:green;">' . __('No', $this -> plugin_name); ?></span></label></td>
						<td><label for="checklist<?php echo $field -> id; ?>"><?php echo (!empty($field -> addprice) && $field -> addprice == "Y") ? '<span style="color:red;">' . __('Yes', $this -> plugin_name) : '<span style="color:green;">' . __('No', $this -> plugin_name); ?></span></label></td>
						<td>
                        	<label for="checklist<?php echo $field -> id; ?>"><?php echo (!empty($field -> globalf) && $field -> globalf == "Y") ? '<span style="color:green;">' . __('Yes', $this -> plugin_name) : '<span style="color:red;">' . __('No', $this -> plugin_name); ?></span></label>
                            <?php if (!empty($field -> globalf) && $field -> globalf == "Y") : ?><small>(<?php global $globalpoptions; require_once $this -> plugin_base() . DS . 'includes' . DS . 'variables.php'; echo $globalpoptions[$field -> globalp]; ?>)</small><?php endif; ?>
                        </td>
						<td><?php $wpcoDb -> model = 'wpcoFieldsProduct'; ?><?php echo $wpcoDb -> count(array('field_id' => $field -> id)); ?></td>
						<td><abbr title="<?php echo $field -> modified; ?>"><?php echo $wpcoHtml -> gen_date("Y-m-d", strtotime($field -> modified)); ?></abbr></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="tablenav">
			<div class="alignleft actions">
				<select class="action" name="perpage" onchange="change_perpage(this.value);">
					<option value="">- <?php _e('Per Page', $this -> plugin_name); ?> -</option>
					<?php $p = 5; ?>
					<?php while ($p < 100) : ?>
						<option <?php echo (isset($_COOKIE[$this -> pre . 'fieldsperpage']) && $_COOKIE[$this -> pre . 'fieldsperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('fields', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>fieldsperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> GMT; path=/";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No custom fields are available.', $this -> plugin_name); ?></p>
<?php endif; ?>