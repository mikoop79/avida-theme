<?php if (!empty($orders)) : ?>
	<form action="?page=checkout-orders&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected orders? Please note that with some actions, all order items are affected!', $this -> plugin_name); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft">
            	<input type="submit" name="export" value="<?php _e('Export Orders', $this -> plugin_name); ?>" class="button" />
				<select name="action">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
                    <option value="completed"><?php _e('Mark as Completed', $this -> plugin_name); ?></option>
                    <option value="notcompleted"><?php _e('Mark as NOT Completed', $this -> plugin_name); ?></option>
					<option value="paid"><?php _e('Set as paid for', $this -> plugin_name); ?></option>
					<option value="notpaid"><?php _e('Set as NOT paid for', $this -> plugin_name); ?></option>
					<option value="shipped"><?php _e('Mark as shipped', $this -> plugin_name); ?></option>
					<option value="notshipped"><?php _e('Mark as NOT shipped', $this -> plugin_name); ?></option>
				</select>
				<input class="button-secondary delete" type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" />
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
					<th class="column-id <?php echo ($orderby == "id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=id&order=' . (($orderby == "id") ? $otherorder : "asc")); ?>">
							<span><?php _e('Order', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-bill_email <?php echo ($orderby == "bill_email") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=bill_email&order=' . (($orderby == "bill_email") ? $otherorder : "asc")); ?>">
							<span><?php _e('User', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Items', $this -> plugin_name); ?></th>
					<th class="column-total <?php echo ($orderby == "total") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=total&order=' . (($orderby == "total") ? $otherorder : "asc")); ?>">
							<span><?php _e('Total', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-pmethod <?php echo ($orderby == "pmethod") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=pmethod&order=' . (($orderby == "pmethod") ? $otherorder : "asc")); ?>">
							<span><?php _e('Payment Method', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
                    <th class="column-completed <?php echo ($orderby == "completed") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=completed&order=' . (($orderby == "completed") ? $otherorder : "asc")); ?>">
							<span><?php _e('Completed', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Paid', $this -> plugin_name); ?></th>
					<th><?php _e('Shipped', $this -> plugin_name); ?></th>
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
					<th class="column-id <?php echo ($orderby == "id") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=id&order=' . (($orderby == "id") ? $otherorder : "asc")); ?>">
							<span><?php _e('Order', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-bill_email <?php echo ($orderby == "bill_email") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=bill_email&order=' . (($orderby == "bill_email") ? $otherorder : "asc")); ?>">
							<span><?php _e('User', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Items', $this -> plugin_name); ?></th>
					<th class="column-total <?php echo ($orderby == "total") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=total&order=' . (($orderby == "total") ? $otherorder : "asc")); ?>">
							<span><?php _e('Total', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th class="column-pmethod <?php echo ($orderby == "pmethod") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=pmethod&order=' . (($orderby == "pmethod") ? $otherorder : "asc")); ?>">
							<span><?php _e('Payment Method', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
                    <th class="column-completed <?php echo ($orderby == "completed") ? 'sorted ' . $order : 'sortable desc'; ?>">
						<a href="<?php echo $wpcoHtml -> retainquery('orderby=completed&order=' . (($orderby == "completed") ? $otherorder : "asc")); ?>">
							<span><?php _e('Completed', $this -> plugin_name); ?></span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
					<th><?php _e('Paid', $this -> plugin_name); ?></th>
					<th><?php _e('Shipped', $this -> plugin_name); ?></th>
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
				<?php foreach ($orders as $order) : ?>
					<?php if (!empty($order -> user_id)) { $user = $this -> userdata($order -> user_id); } ?>
					<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
						<th class="check-column"><input type="checkbox" name="Order[checklist][]" value="<?php echo $order -> id; ?>" id="checklist<?php echo $order -> id; ?>" /></th>
						<td>
							<strong><?php echo $wpcoHtml -> link(__('Order &#35;', $this -> plugin_name) . $order -> id, '?page=' . $this -> sections -> orders . '&amp;method=view&amp;id=' . $order -> id, array('class' => "row-title")); ?></strong>
							<div class="row-actions">
								<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), '?page=' . $this -> sections -> orders . '&amp;method=save&amp;id=' . $order -> id, array('class' => 'edit')); ?> |</span>
								<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), '?page=' . $this -> sections -> orders . '&amp;method=delete&amp;id=' . $order -> id, array('class' => 'submitdelete', 'onclick' => "if (!confirm('" . __('Are you sure you wish to remove this order and all its items?', $this -> plugin_name) . "')) { return false; };")); ?> |</span>
                                <?php if (!empty($order -> pmethod) && $order -> pmethod == "cc") : ?>
                                    <span class="delete"><?php echo $wpcoHtml -> link(__('Delete CC Details', $this -> plugin_name), '?page=' . $this -> sections -> orders . '&amp;method=delete-cc&amp;id=' . $order -> id . '&amp;user_id=' . $order -> user_id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you wish to remove all credit card details for this customer globally? It will affect billing details stored for other orders by this customer as well.', $this -> plugin_name) . "')) { return false; }")); ?> |</span>
                                <?php endif; ?>
								<span class="view"><?php echo $wpcoHtml -> link(__('View', $this -> plugin_name), '?page=' . $this -> sections -> orders . '&amp;method=view&amp;id=' . $order -> id, array('class' => 'edit')); ?> |</span>
                                <span class="view"><?php echo $wpcoHtml -> link(__('Send Invoice', $this -> plugin_name), "?page=" . $this -> sections -> orders . "&amp;method=invoice&amp;id=" . $order -> id, array('onclick' => "if (!confirm('" . __('Are you sure you want to send this customer an invoice via email?', $this -> plugin_name) . "')) { return false; }")); ?> |</span>
                                <span class="view"><?php echo $wpcoHtml -> link(__('Save PDF', $this -> plugin_name), home_url() . '/?' . $this -> pre . 'method=pdfinvoice&amp;id=' . $order -> id); ?></span>
							</div>
						</td>
						<td>
							<?php echo $order -> bill_fname . ' ' . $order -> bill_lname; ?>
                            <small>(<?php echo $wpcoHtml -> link(((empty($order -> bill_email)) ? $user -> user_email : $order -> bill_email), 'mailto:' . $order -> bill_email . '?subject=' . get_bloginfo('name') . ': ' . __('Order &#35;', $this -> plugin_name) . '' . $order -> id); ?>)</small>
                        </td>
						<td>
							<?php $wpcoDb -> model = $Item -> model; ?>
							<?php echo $wpcoDb -> count(array('order_id' => $order -> id)); ?>
						</td>
						<td><b><?php echo $wpcoHtml -> currency_price($order -> total); ?></b></td>
						<td><?php echo $wpcoHtml -> pmethod($order -> pmethod); ?></td>
                        <td>
                        	<?php echo ($order -> completed == "Y") ? '<span style="color:green;">' . __('Yes', $this -> plugin_name) . '</span>' : '<span style="color:red;">' . __('No', $this -> plugin_name) . '</span>'; ?>
                        </td>
						<td>
							<?php echo (!empty($order -> paid) && $order -> paid == "Y") ? '<span style="font-weight:bold; color:green;">' . __('Yes', $this -> plugin_name) : '<span style="font-weight:bold; color:red;">' . __('No', $this -> plugin_name); ?></span>
							<?php
							
							if (!empty($order -> pmethod) && $order -> pmethod == "pp_pro") {
								if (empty($order -> paid) || $order -> paid == "N") {
									if (!empty($order -> transstatus) && $order -> transstatus == "authorized") {
										$pp_pro_paymenttype = $this -> get_option('pp_pro_paymenttype');
										if (!empty($pp_pro_paymenttype) && $pp_pro_paymenttype == "authcapture") {
											?>(<a href="?page=<?php echo $this -> sections -> orders; ?>&amp;method=capture&amp;id=<?php echo $order -> id; ?>" onclick="if (!confirm('<?php _e('Are you sure you want to charge/capture this previously authorized payment right now?', $this -> plugin_name); ?>')) { return false; }"><?php _e('Charge/Capture Now', $this -> plugin_name); ?></a>)<?php
										}
									}
								}
							}
							
							?>
						</td>
						<td>
                        	<?php if ($order -> shipped == "N/A") : ?>
                            	<?php echo $order -> shipped; ?>
                            <?php else : ?>
								<?php echo (!empty($order -> shipped) && $order -> shipped == "Y") ? '<span style="color:green;">' . __('Yes', $this -> plugin_name) : '<span style="color:red;">' . __('No', $this -> plugin_name); ?></span>
                            <?php endif; ?>
                        </td>
						<td><abbr title="<?php echo $order -> modified; ?>"><?php echo date("Y-m-d", strtotime($order -> modified)); ?></abbr></td>
					</tr>
					<?php $user = false; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="tablenav">
			<div class="alignleft">
				<select name="perpage" onchange="change_perpage(this.value);">
					<option value="">- <?php _e('Per Page', $this -> plugin_name); ?> -</option>
					<?php $p = 10; ?>
					<?php while ($p < 500) : ?>
						<option <?php echo (isset($_COOKIE[$this -> pre . 'ordersperpage']) && $_COOKIE[$this -> pre . 'ordersperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('orders', $this -> plugin_name); ?></option>
						<?php $p += 10; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>ordersperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> GMT; path=/";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate), true, 'admin'); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No orders are available', $this -> plugin_name); ?></p>
<?php endif; ?>