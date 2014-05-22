<div>
	<?php
		
	include $this -> plugin_base() . DS . 'vendors' . DS . 'ofc' . DS . 'open_flash_chart_object.php';
	open_flash_chart_object("100%", 200, admin_url('admin-ajax.php') . '?action=wpcochart', true, plugins_url() . '/wp-checkout/');
	
	?>
</div>
<br class="clear" />

<?php

$wpcoDb -> model = $Order -> model;
$orders = $wpcoDb -> find_all(false, false, array('modified', "DESC"), 4);

?>

<div class="table table_content">
	<p class="sub"><?php _e('Latest Orders', $this -> plugin_name); ?></p>
	<?php if (!empty($orders)) : ?>
		<table>
			<tbody>
				<?php foreach ($orders as $order) : ?>
					<tr>
						<td class="first b b-ad">
							<?php echo sprintf(__('Order #%s', $this -> plugin_name), $order -> id); ?>
							(<strong><?php echo $wpcoHtml -> currency_price($order -> total); ?></strong>)
						</td>
						<td class="t ad">
							<a class="button button-small" href="<?php echo admin_url('admin.php?page=' . $this -> sections -> orders . '&method=view&id=' . $order -> id); ?>"><?php _e('View', $this -> plugin_name); ?></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<p><?php echo sprintf(__('No orders are available yet, please %s.', $this -> plugin_name), '<a href="' . admin_url('admin.php?page=' . $this -> sections -> orders . '&amp;method=save') . '">' . __('create one', $this -> plugin_name) . '</a>'); ?></p>
	<?php endif; ?>
</div>

<?php

$wpcoDb -> model = $Product -> model;
$products_count = $wpcoDb -> count();
$wpcoDb -> model = $Category -> model;
$categories_count = $wpcoDb -> count();
$wpcoDb -> model = $Supplier -> model;
$suppliers_count = $wpcoDb -> count();
$wpcoDb -> model = $Order -> model;
$orders_count = $wpcoDb -> count();

?>

<div class="table table_discussion">
	<p class="sub"><?php _e('Overview', $this -> plugin_name); ?></p> 
	<table> 
		<tbody>
			<tr class="first">
				<td class="b b-comments">
					<a href="admin.php?page=<?php echo $this -> sections -> products; ?>"><span class="total-count"><?php echo $products_count; ?></span></a>
				</td>
				<td class="last t comments">
					<a href="admin.php?page=<?php echo $this -> sections -> products; ?>"><?php _e('Products', $this -> plugin_name); ?></a>
				</td>
			</tr>
			<tr>
				<td class="b b_approved">
					<a href="admin.php?page=<?php echo $this -> sections -> categories; ?>"><span class="approved-count"><?php echo $categories_count; ?></span></a>
				</td>
				<td class="last t">
					<a href="admin.php?page=<?php echo $this -> sections -> categories; ?>"><?php _e('Categories', $this -> plugin_name); ?></a>
				</td>
			</tr>
			<tr>
				<td class="b b-waiting">
					<a href="admin.php?page=<?php echo $this -> sections -> suppliers; ?>"><span class="pending-count"><?php echo $suppliers_count; ?></span></a>
				</td>
				<td class="last t">
					<a href="admin.php?page=<?php echo $this -> sections -> suppliers; ?>"><?php _e('Suppliers', $this -> plugin_name); ?></a>
				</td>
			</tr>
			<tr>
				<td class="b b-spam">
					<a href="admin.php?page=<?php echo $this -> sections -> orders; ?>"><span class="spam-count"><?php echo $orders_count; ?></span></a>
				</td>
				<td class="last t">
					<a href="admin.php?page=<?php echo $this -> sections -> orders; ?>"><?php _e('Orders', $this -> plugin_name); ?></a>
				</td>
			</tr> 
		</tbody>
	</table>
</div>

<br class="clear" />