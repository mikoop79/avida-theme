<?php if (!empty($items)) : ?>
	<form action="?page=checkout-items&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected order items?', $this -> plugin_name); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft actions">
				<select name="action">
					<option value="">- <?php _e('Bulk Actions', $this -> plugin_name); ?> -</option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
					<option value="paid"><?php _e('Set as Paid', $this -> plugin_name); ?></option>
					<option value="notpaid"><?php _e('Set as NOT Paid', $this -> plugin_name); ?></option>
					<option value="shipped"><?php _e('Mark as Shipped', $this -> plugin_name); ?></option>
					<option value="notshipped"><?php _e('Mark as NOT Shipped', $this -> plugin_name); ?></option>
				</select>
				<input class="button" type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" />
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
		</div>
		<table class="widefat">
			<thead>
				<tr>
					<th class="check-column"><input type="checkbox" name="checkboxall" value="checkboxall" id="checkboxall" /></th>
					<th><?php _e('ID', $this -> plugin_name); ?></th>
					<th colspan="2"><?php _e('Product', $this -> plugin_name); ?></th>
                    <th><?php _e('Options', $this -> plugin_name); ?></th>
					<?php if (empty($_GET['page']) || $_GET['page'] != $this -> sections -> orders) : ?><th><?php _e('Order', $this -> plugin_name); ?></th><?php endif; ?>
					<th><?php _e('Qty', $this -> plugin_name); ?></th>
					<th><?php _e('Total', $this -> plugin_name); ?></th>
					<th><?php _e('Paid', $this -> plugin_name); ?></th>
					<th><?php _e('Shipped', $this -> plugin_name); ?></th>
					<th><?php _e('Modified', $this -> plugin_name); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="check-column"><input type="checkbox" name="checkboxall" value="checkboxall" id="checkboxall" /></th>
					<th><?php _e('ID', $this -> plugin_name); ?></th>
					<th colspan="2"><?php _e('Product', $this -> plugin_name); ?></th>
                    <th><?php _e('Options', $this -> plugin_name); ?></th>
					<?php if (empty($_GET['page']) || $_GET['page'] != $this -> sections -> orders) : ?><th><?php _e('Order', $this -> plugin_name); ?></th><?php endif; ?>
					<th><?php _e('Qty', $this -> plugin_name); ?></th>
					<th><?php _e('Total', $this -> plugin_name); ?></th>
					<th><?php _e('Paid', $this -> plugin_name); ?></th>
					<th><?php _e('Shipped', $this -> plugin_name); ?></th>
					<th><?php _e('Modified', $this -> plugin_name); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php $class = ''; ?>
				<?php foreach ($items as $item) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th class="check-column"><input type="checkbox" name="Item[checklist][]" value="<?php echo $item -> id; ?>" id="checklist<?php echo $item -> id; ?>" /></th>
					<td>
						<label for="checklist<?php echo $item -> id; ?>"><?php echo $item -> id; ?></label>
					</td>
					<td style="width:50px;"><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($item -> product -> image_url, 45, 45, 100), $wpcoHtml -> image_url($item -> product -> image -> name), array('class' => 'colorbox', 'title' => apply_filters($this -> pre . '_product_title', $item -> product -> title))); ?></td>
					<td>
						<strong><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $item -> product -> title), '?page=checkout-products&amp;method=view&amp;id=' . $item -> product_id, array('class' => "row-title", 'title' => apply_filters($this -> pre . '_product_title', $item -> product -> title))); ?></strong>
						<div class="row-actions">
							<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=checkout-items&amp;method=save&amp;id=' . $item -> id, array('class' => 'edit')); ?> |</span>
							<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), '?page=checkout-items&amp;method=delete&amp;id=' . $item -> id, array('onclick' => "if (!confirm('" . __('Are you sure you wish to remove this order item?', $this -> plugin_name) . "')) { return false; }", 'class' => "submitdelete")); ?> |</span>
							<span class="view"><?php echo $wpcoHtml -> link(__('View Details', $this -> plugin_name), '?page=checkout-items&amp;method=view&amp;id=' . $item -> id, array('class' => 'edit')); ?></span>
						</div>
					</td>
                    <td>
                    	<?php if (!empty($item -> styles) || !empty($item -> product -> cfields) || (!empty($item -> product -> inhonorof) && $item -> product -> inhonorof == "Y") || (!empty($item -> width) && !empty($item -> length))) : ?>
                            <table>
                                <tbody>
                                	<?php if (!empty($item -> product -> inhonorof) && $item -> product -> inhonorof == "Y") : ?>
                                    	<?php if (!empty($item -> iof_name)) : ?>
                                            <tr>
                                                <th><?php _e('Donor Name', $this -> plugin_name); ?></th>
                                                <td><?php echo stripslashes($item -> iof_name); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if (!empty($item -> iof_benname)) : ?>
                                            <tr>
                                                <th><?php _e('Beneficiary Name', $this -> plugin_name); ?></th>
                                                <td><?php echo stripslashes($item -> iof_benname); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if (!empty($item -> iof_benemail)) : ?>
                                            <tr>
                                                <th><?php _e('Beneficiary Email', $this -> plugin_name); ?></th>
                                                <td><?php echo stripslashes($item -> iof_benemail); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                	<?php if (!empty($item -> width) && !empty($item -> length)) : ?>
                                    	<tr>
                                        	<th><?php _e('Width', $this -> plugin_name); ?></th>
                                            <td><?php echo $item -> width; ?><?php _e('m', $this -> plugin_name); ?></td>
                                        </tr>
                                        <tr>
                                        	<th><?php _e('Length', $this -> plugin_name); ?></th>
                                            <td><?php echo $item -> length; ?><?php _e('m', $this -> plugin_name); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                
                                    <?php if ($styles = maybe_unserialize($item -> styles)) : ?>
                                        <?php foreach ($styles as $style_id => $option_id) : ?>
                                            <?php $wpcoDb -> model = $Style -> model; ?>
                                            <?php if ($style = $wpcoDb -> find(array('id' => $style_id), array('id', 'title'))) : ?>
                                                <?php if (!empty($option_id) && is_array($option_id)) : ?>
                                                    <?php $option_ids = $option_id; ?>
                                                    <tr>
                                                        <th><?php echo $style -> title; ?></th>
                                                        <td>
                                                            <?php $o = 1; ?>
                                                            <?php foreach ($option_ids as $option_id) : ?>
                                                                <?php $wpcoDb -> model = $Option -> model; ?>																
                                                                <?php if ($option = $wpcoDb -> find(array('id' => $option_id), array('id', 'title', 'addprice', 'price', 'operator', 'symbol'), array('id', "DESC"), true)) : ?>
                                                                    <?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($option -> price, true, false, $option -> operator) . ')' : ''; ?>
                                                                    <?php echo ($o < count($option_ids)) ? ', ' : ''; ?>
                                                                <?php endif; ?>
                                                                <?php $o++; ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                    </tr>
                                                <?php else : ?>
                                                    <?php $wpcoDb -> model = $Option -> model; ?>
                                                    <?php $option = $wpcoDb -> find(array('id' => $option_id), false, array('id', "DESC"), true, array('otheroptions' => $styles)); ?>
                                                    <tr>
                                                        <th><?php echo $style -> title; ?></th>
                                                        <td><?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y" && !empty($option -> price)) ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($option -> price, true, false, $option -> operator) . ')' : ''; ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($item -> product -> cfields)) : ?>
                                        <?php foreach ($item -> product -> cfields as $field_id) : ?>
                                            <?php $wpcoDb -> model = $wpcoField -> model; ?>
                                            <?php if ($field = $wpcoDb -> find(array('id' => $field_id))) : ?>
                                                <?php if (!empty($item -> {$field -> slug})) : ?>
                                                <tr>
                                                    <th><?php echo $field -> title; ?><?php echo (!empty($field -> addprice) && $field -> addprice == "Y" && !empty($field -> price)) ? ' (' . $option -> symbol . $wpcoHtml -> currency_price($field -> price) . ')' : ''; ?></th>
                                                    <td><?php echo $wpcoField -> get_value($field_id, $item -> {$field -> slug}); ?></td>
                                                </tr>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <?php _e('none', $this -> plugin_name); ?>
                        <?php endif; ?>
                    </td>
					<?php if (empty($_GET['page']) || $_GET['page'] != $this -> sections -> orders) : ?><td><a class="row-title" href="?page=checkout-orders&amp;method=view&amp;id=<?php echo $item -> order_id; ?>" title="<?php _e('View the full details of this order', $this -> plugin_name); ?>"><?php _e('Order', $this -> plugin_name); ?> #<?php echo $item -> order_id; ?></a></td><?php endif; ?>
					<td><?php echo $item -> count; ?></td>
					<td><b><?php echo $wpcoHtml -> currency(); ?><?php echo number_format(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id, false, true) * $item -> count), 2, '.', ''); ?></b></td>
					<td><?php echo (!empty($item -> paid) && $item -> paid == "Y") ? '<span style="color:green;">' . __('Yes', $this -> plugin_name) : '<span style="color:red;">' . __('No', $this -> plugin_name); ?></span></td>
					<td>
                    	<?php if ($item -> product -> type == "tangible") : ?>
							<?php echo (!empty($item -> shipped) && $item -> shipped == "Y") ? '<span style="color:green;">' . __('Yes', $this -> plugin_name) : '<span style="color:red;">' . __('No', $this -> plugin_name); ?></span>
                        <?php else : ?>
                        	<?php echo __('N/A', $this -> plugin_name); ?>
                        <?php endif; ?>
                    </td>
					<td><abbr title="<?php echo $item -> modified; ?>"><?php echo date("Y-m-d", strtotime($item -> modified)); ?></abbr></td>
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
						<option <?php echo (isset($_COOKIE[$this -> pre . 'itemsperpage']) && $_COOKIE[$this -> pre . 'itemsperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('items', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>itemsperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> GMT; path=/";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No order items are available', $this -> plugin_name); ?></p>
<?php endif; ?>