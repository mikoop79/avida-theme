<?php $auspost = $this -> vendor('auspost', 'shipping' . DS); ?>

<p><?php _e('Please choose your preferred shipping method below for this order.', $this -> plugin_name); ?></p>

<?php if (!empty($prices)) : ?>
	<?php if (empty($ajaxquote)) : ?>
	<form action="<?php echo $wpcoHtml -> auspost_url(); ?>" method="post">
	<?php endif; ?>
		<input type="hidden" name="cp_savemethod" value="1" />
	
		<table class="<?php echo $this -> pre; ?> auspost">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th><?php _e('Service', $this -> plugin_name); ?></th>
					<th><?php _e('Days to Delivery', $this -> plugin_name); ?></th>
					<th><?php _e('Price', $this -> plugin_name); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>&nbsp;</th>
					<th><?php _e('Service', $this -> plugin_name); ?></th>
					<th><?php _e('Days to Delivery', $this -> plugin_name); ?></th>
					<th><?php _e('Price', $this -> plugin_name); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($prices as $servicetype => $service) : ?>
					<?php if ($service['err_msg'] == "OK") : ?>
						<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
							<td>
								<input type="hidden" name="cu_prices[<?php echo $servicetype; ?>]" value="<?php echo $service['price']; ?>" />
								<input type="hidden" name="shipmethodnames[<?php echo $servicetype; ?>]" value="<?php echo $auspost -> servicetypes[$servicetype]; ?>" />
								<input type="radio" name="cu_shipmethod" value="<?php echo esc_attr(stripslashes($servicetype)); ?>" id="cu_shipmethod_<?php echo $servicetype; ?>" />
							</td>
							<td><label for="cu_shipmethod_<?php echo $servicetype; ?>"><?php echo $auspost -> servicetypes[$servicetype]; ?></label></td>
							<td><label for="cu_shipmethod_<?php echo $servicetype; ?>"><?php echo (empty($service['days'])) ? __('N/A', $this -> plugin_name) : $service['days']; ?></label></td>
							<td><label for="cu_shipmethod_<?php echo $servicetype; ?>"><?php echo $wpcoHtml -> currency_price($service['price'], true, true); ?></label></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		
	<?php if (empty($ajaxquote)) : ?>
		<p>
            <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
            <input type="submit" class="<?php echo $this -> pre; ?>button" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
        </p>
	</form>
	<?php endif; ?>
<?php else : ?>
	<p class="wpcoerror"><?php _e('No shipping services are available, please try again.', $this -> plugin_name); ?></p>
	<?php if (empty($ajaxquote)) : ?>
    <p>
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
    </p>
   	<?php endif; ?>
<?php endif; ?>

<!-- Australia Post debugging -->
<?php if (!empty($api_options['auspost_debug']) && $api_options['auspost_debug'] == "Y") : ?>
	<h3><?php _e('Australia Post Errors', $this -> plugin_name); ?></h3>
	<?php if (!empty($errors)) : ?>
		<ul class="<?php echo $this -> pre; ?>error">
			<?php foreach ($errors as $service => $error) : ?>
				<li><?php echo $auspost -> servicetypes[$service]; ?> - <?php echo $error; ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
<?php endif; ?>