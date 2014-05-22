<?php

global $wpdb;

?>

<?php if (!empty($orders)) : ?>
	<table class="form-table">
		<thead>
			<tr>
				<th style="font-weight:bold;"><?php _e('ID', $this -> plugin_name); ?></th>
				<th style="font-weight:bold;"><?php _e('Items', $this -> plugin_name); ?></th>
				<th style="font-weight:bold;"><?php _e('Total', $this -> plugin_name); ?></th>
				<th style="font-weight:bold;"><?php _e('Paid', $this -> plugin_name); ?></th>
				<?php if ($this -> get_option('shippingcalc') == "Y") : ?>
					<th style="font-weight:bold;"><?php _e('Shipped', $this -> plugin_name); ?></th>
				<?php endif; ?>
				<th style="font-weight:bold;"><?php _e('Date', $this -> plugin_name); ?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php $class = false; ?>
			<?php foreach ($orders as $order) : ?>
				<tr class="<?php echo $class = (empty($class)) ? 'arow' : ''; ?>">
					<td>
						<?php echo $order -> id; ?>
					</td>
					<td>
						<?php echo $wpdb -> get_var("SELECT COUNT(`id`) FROM `" . $wpdb -> prefix . $Item -> table . "` WHERE `order_id` = '" . $order -> id . "'"); ?>
					</td>
					<td>
						<?php echo $wpcoHtml -> currency_price($order -> total); ?>
					</td>
					<td>
						<?php if ($order -> paid == "Y") : ?>
							<span style="color:green;"><?php _e('Yes', $this -> plugin_name); ?></span>
						<?php else : ?>
							<span style="color:red;"><?php _e('No', $this -> plugin_name); ?></span>
						<?php endif; ?>
					</td>
					<td>
						<?php if ($order -> shipped == "Y") : ?>
							<span style="color:green;"><?php _e('Yes', $this -> plugin_name); ?></span>
						<?php elseif ($order -> shipped == "N") : ?>
							<span style="color:red;"><?php _e('No', $this -> plugin_name); ?></span>
						<?php else : ?>
							<?php echo $order -> shipped; ?>
						<?php endif; ?>
					</td>
					<td>
						<abbr title="<?php echo $order -> completed_date; ?>"><?php echo date("M j, Y", strtotime($order -> completed_date)); ?></abbr>
					</td>
					<td>
						<span class="view"><?php echo $wpcoHtml -> link(__('View', $this -> plugin_name), '?page=' . $this -> sections -> orders . '&amp;method=view&amp;id=' . $order -> id); ?></span>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<p class="textright">
		<a href="?page=<?php echo $this -> sections -> orders; ?>" class="button"><?php _e('View All Orders', $this -> plugin_name); ?></a>
	</p>
<?php else : ?>
	<p><?php _e('Recent completed orders will be shown here as soon as there are some.', $this -> plugin_name); ?></p>
<?php endif; ?>