<p><?php _e('Please choose your preferred shipping method below for this order.', $this -> plugin_name); ?></p>

<?php if (empty($ajaxquote)) : ?>
<form action="<?php echo $wpcoHtml -> canadapost_url(); ?>" method="post">
<?php endif; ?>
	<input type="hidden" name="cp_savemethod" value="1" />

	<?php if (!empty($shipping_methods)) : ?>	      
		<table class="<?php echo $this -> pre; ?> canadapost">
        	<thead>
            	<tr>
                	<th></th>
                	<th><?php _e('Shipping Method', $this -> plugin_name); ?></th>
                    <th><?php _e('Delivery Date', $this -> plugin_name); ?></th>
                    <th><?php _e('Rate/Price (CAD&#36;)', $this -> plugin_name); ?></th>
                </tr>
            </thead>
            <tfoot>
            	<tr>
                	<th></th>
                	<th><?php _e('Shipping Method', $this -> plugin_name); ?></th>
                    <th><?php _e('Delivery Date', $this -> plugin_name); ?></th>
                    <th><?php _e('Rate/Price (CAD&#36;)', $this -> plugin_name); ?></th>
                </tr>
            </tfoot>
            <tbody>
            	<?php $class = null; ?>
            	<?php foreach ($shipping_methods as $shipping_mkey => $shipping_method) : ?>
                	<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                    	<td>
                        	<input <?php echo (!empty($order -> cu_shipmethod) && $order -> cu_shipmethod == $shipping_method['name']) ? 'checked="checked"' : ''; ?> type="radio" name="cu_shipmethod" value="<?php echo esc_attr(stripslashes($shipping_method['name'])); ?>" id="cu_shippingmethod_<?php echo $shipping_mkey; ?>" />
                            <input type="hidden" name="cu_prices[<?php echo esc_attr(stripslashes($shipping_method['name'])); ?>]" value="<?php echo $shipping_method['rate']; ?>" />
                       	</td>
                    	<td><label for="cu_shippingmethod_<?php echo $shipping_mkey; ?>"><?php echo $shipping_method['name']; ?></label></td>
                        <td><label for="cu_shippingmethod_<?php echo $shipping_mkey; ?>"><?php echo $shipping_method['deliveryDate']; ?></label></td>
                        <td><label for="cu_shippingmethod_<?php echo $shipping_mkey; ?>"><?php echo $wpcoHtml -> currency_price($shipping_method['rate'], true, true); ?></label></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <p>
        	<strong><?php _e('Based on a shipping date of', $this -> plugin_name); ?> <?php echo $shipping_methods[0]['shippingDate']; ?></strong>
            <?php if (!empty($cp -> shipping_comment)) : ?>
            	<br/><?php echo $cp -> shipping_comment; ?>
            <?php endif; ?>
        </p>
	<?php else : ?>
		<?php if ($error) : ?>
			<?php $this -> render('error', array('error' => $error_msg), true, 'default'); ?>
		<?php endif; ?>	
		<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available, please return.', $this -> plugin_name); ?></p>
	<?php endif; ?>

<?php if (empty($ajaxquote)) : ?>
	<p>
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
        <input type="submit" class="<?php echo $this -> pre; ?>button" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
    </p>
</form>
<?php endif; ?>