<?php if (!empty($coupons)) : ?>
	<form action="?page=checkout-coupons&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected coupons?', $this -> plugin_name); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft actions">
            	<a href="?page=<?php echo $this -> sections -> coupons; ?>&amp;method=bulk" class="button"><?php _e('Bulk Generate', $this -> plugin_name); ?></a>
			</div>
			<div class="alignleft actions">
                <input class="button" type="submit" name="export" value="<?php _e('Export', $this -> plugin_name); ?>" />
			</div>
			<div class="alignleft actions">
				<select name="action">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
				</select>
				<input type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" class="button-secondary" />
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
					<th class="column-code <?php echo ($orderby == "code") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=code&order=' . (($orderby == "code") ? $otherorder : "asc")); ?>">
							<span><?php _e('Code', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-active <?php echo ($orderby == "active") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=active&order=' . (($orderby == "active") ? $otherorder : "asc")); ?>">
							<span><?php _e('Active', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-discount <?php echo ($orderby == "discount") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=discount&order=' . (($orderby == "discount") ? $otherorder : "asc")); ?>">
							<span><?php _e('Discount', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-used <?php echo ($orderby == "used") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=used&order=' . (($orderby == "used") ? $otherorder : "asc")); ?>">
							<span><?php _e('Used', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-maxuse <?php echo ($orderby == "maxuse") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=maxuse&order=' . (($orderby == "maxuse") ? $otherorder : "asc")); ?>">
							<span><?php _e('Max Use', $this -> plugin_name); ?></span>
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
					<th class="column-code <?php echo ($orderby == "code") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=code&order=' . (($orderby == "code") ? $otherorder : "asc")); ?>">
							<span><?php _e('Code', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-active <?php echo ($orderby == "active") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=active&order=' . (($orderby == "active") ? $otherorder : "asc")); ?>">
							<span><?php _e('Active', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-discount <?php echo ($orderby == "discount") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=discount&order=' . (($orderby == "discount") ? $otherorder : "asc")); ?>">
							<span><?php _e('Discount', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-used <?php echo ($orderby == "used") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=used&order=' . (($orderby == "used") ? $otherorder : "asc")); ?>">
							<span><?php _e('Used', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-maxuse <?php echo ($orderby == "maxuse") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=maxuse&order=' . (($orderby == "maxuse") ? $otherorder : "asc")); ?>">
							<span><?php _e('Max Use', $this -> plugin_name); ?></span>
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
				<?php foreach ($coupons as $coupon) : ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th class="check-column"><input type="checkbox" id="checklist<?php echo $coupon -> id; ?>" name="Coupon[checklist][]" value="<?php echo $coupon -> id; ?>" /></th>
						<td>
							<?php echo $wpcoHtml -> link($coupon -> title, '?page=checkout-coupons&amp;method=save&amp;id=' . $coupon -> id, array('class' => 'row-title')); ?>
							<div class="row-actions">
								<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), "?page=checkout-coupons&amp;method=save&amp;id=" . $coupon -> id); ?> |</span>
								<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), "?page=checkout-coupons&amp;method=delete&amp;id=" . $coupon -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you wish to delete this discount coupon?', $this -> plugin_name) . "')) { return false; }")); ?></span>
							</div>
						</td>
						<td><strong><?php echo apply_filters($this -> pre . '_coupon_code_text', $coupon -> code, $coupon); ?></strong></td>
						<td>
                        	<?php echo ($coupon -> active == "Y") ? '<span style="color:green;">' . __('Yes', $this -> plugin_name) : '<span style="color:red;">' . __('No', $this -> plugin_name); ?></span>
                        	<?php if (!empty($coupon -> expiry) && $coupon -> expiry != "0000-00-00") : ?>
                            	<small>(
                            	<?php if ($coupon -> expiry <= date("Y-m-d", time())) : ?>
                                	<?php _e('Expired', $this -> plugin_name); ?>
                                <?php else : ?>
                                	<?php _e('Expires:', $this -> plugin_name); ?> <?php echo $coupon -> expiry; ?>
                                <?php endif; ?>
                                )</small>
                            <?php endif; ?>    
                        </td>
						<td>
							<?php echo apply_filters($this -> pre . '_coupon_discount_text', (($coupon -> discount_type == "fixed") ? $wpcoHtml -> currency_price($coupon -> discount) : $coupon -> discount . '&#37;'), $coupon); ?>
						</td>
						<td><?php echo $coupon -> used; ?></td>
						<td><?php echo (empty($coupon -> maxuse)) ? __('unlimited', $this -> plugin_name) : $coupon -> maxuse; ?></td>
						<td><abbr title="<?php echo $coupon -> modified; ?>"><?php echo date("Y-m-d", strtotime($coupon -> modified)); ?></abbr></td>
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
						<option <?php echo (isset($_COOKIE[$this -> pre . 'couponsperpage']) && $_COOKIE[$this -> pre . 'couponsperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('coupons', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>couponsperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> GMT; path=/;";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No coupons are available', $this -> plugin_name); ?></p>
<?php endif; ?>