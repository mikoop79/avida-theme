<h3><?php _e('Orders History', $this -> plugin_name); ?></h3>

<?php $actions_colspan = ($this -> get_option('invoice_enabled') == "N" || $this -> get_option('invoice_enablepdf') == "N") ? 1 : 2; ?>

<?php if (!empty($orders)) : ?>
	<?php $this -> render('paginate', array('paginate' => $paginate), true, 'default'); ?>
	<table class="<?php echo $this -> pre; ?>">
		<thead>
			<tr>
				<th><?php _e('ID', $this -> plugin_name); ?></th>
				<th><?php _e('Items', $this -> plugin_name); ?></th>
				<th><?php _e('Total', $this -> plugin_name); ?></th>
				<th><?php _e('Paid', $this -> plugin_name); ?></th>
				<th><?php _e('Shipped', $this -> plugin_name); ?></th>
				<th><?php _e('Date', $this -> plugin_name); ?></th>
				<th colspan="<?php echo $actions_colspan; ?>"><?php _e('Actions', $this -> plugin_name); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th><?php _e('ID', $this -> plugin_name); ?></th>
				<th><?php _e('Items', $this -> plugin_name); ?></th>
				<th><?php _e('Total', $this -> plugin_name); ?></th>
				<th><?php _e('Paid', $this -> plugin_name); ?></th>
				<th><?php _e('Shipped', $this -> plugin_name); ?></th>
				<th><?php _e('Date', $this -> plugin_name); ?></th>
				<th colspan="<?php echo $actions_colspan; ?>"><?php _e('Actions', $this -> plugin_name); ?></th>
			</tr>
		</tfoot>
		<tbody>
			<?php $class = ''; ?>
			<?php foreach ($orders as $order) : ?>
				<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
					<td><?php echo $order -> id; ?></td>
					<td><?php $wpcoDb -> model = $Item -> model; ?><?php echo $wpcoDb -> count(array('order_id' => $order -> id)); ?></td>
					<td><strong><?php echo $wpcoHtml -> currency_price($order -> total); ?></strong></td>
					<td><?php echo (!empty($order -> paid) && $order -> paid == "Y") ? '<span style="font-weight:bold; color:green;">' . __('Yes', $this -> plugin_name) : '<span style="font-weight:bold; color:red;">' . __('No', $this -> plugin_name); ?></span></td>
					<td>
                    	<?php if (!empty($order -> hastangible) && $order -> hastangible == "Y") : ?>
							<?php echo (!empty($order -> shipped) && $order -> shipped == "Y") ? __('Yes', $this -> plugin_name) : __('No', $this -> plugin_name); ?>
                        <?php else : ?>
                        	<?php echo $order -> shipped; ?>
                        <?php endif; ?>
                    </td>
					<td><abbr title="<?php echo $order -> modified; ?>"><?php echo date("Y-m-d", strtotime($order -> modified)); ?></abbr></td>
					<td><?php echo $wpcoHtml -> link('<img src="' . $this -> url() . '/images/view.png" style="border:none;" alt="view" />', $wpcoHtml -> order_url($order -> id), array('title' => __('View the full details of this order', $this -> plugin_name))); ?></td>
                    <?php if ($this -> get_option('invoice_enabled') == "Y" && $this -> get_option('invoice_enablepdf') == "Y") : ?><td><a href="<?php echo $wpcoHtml -> retainquery($this -> pre . "method=pdfinvoice&amp;id=" . $order -> id, $this -> get_option('shopurl')); ?>" title="<?php _e('Save a PDF invoice for your records', $this -> plugin_name); ?>" class="<?php echo $this -> pre; ?>"><img border="0" style="border:none;" src="<?php echo $this -> url(); ?>/images/document.png" alt="PDF" /></a></td><?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php $this -> render('paginate', array('paginate' => $paginate), true, 'default'); ?>
<?php else : ?>
	<div class="<?php echo $this -> pre; ?>error"><?php _e('No orders are available', $this -> plugin_name); ?></div>
<?php endif; ?>

<br class="<?php echo $this -> pre; ?>cleaner" />
<p><?php echo $wpcoHtml -> link(__('Return to the shop &raquo;', $this -> plugin_name), $this -> get_option('shopurl')); ?></p>