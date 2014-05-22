<?php include $this -> plugin_base() . DS . 'includes' . DS . 'shipping' . DS . 'fedex.php'; ?>

<p><?php _e('Please choose your preferred shipping method below for this order.', $this -> plugin_name); ?></p>

<?php if (empty($ajaxquote)) : ?>
<form action="<?php echo $wpcoHtml -> fedex_url(); ?>" method="post">
<?php endif; ?>
	<input type="hidden" name="cp_savemethod" value="1" />

	<?php if (!empty($prices)) : ?>        
		<table class="<?php echo $this -> pre; ?>">
        	<thead>
            	<tr>
                	<th></th>
                	<th><?php _e('Shipping Method', $this -> plugin_name); ?></th>
                    <th><?php _e('Rate/Price', $this -> plugin_name); ?></th>
                    <th><?php _e('Delivery', $this -> plugin_name); ?></th>
                </tr>
            </thead>
            <tfoot>
            	<tr>
                	<th></th>
                	<th><?php _e('Shipping Method', $this -> plugin_name); ?></th>
                    <th><?php _e('Rate/Price', $this -> plugin_name); ?></th>
                    <th><?php _e('Delivery', $this -> plugin_name); ?></th>
                </tr>
            </tfoot>
        	<tbody>
            	<?php $class = null; ?>
            	<?php foreach ($prices as $price) : ?>
                	<?php if (!empty($price -> RatedShipmentDetails[0] -> ShipmentRateDetail -> TotalNetCharge -> Amount)) : ?>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <td>
                            	<input <?php echo (!empty($order -> cu_shipmethod) && $order -> cu_shipmethod == $price -> ServiceType) ? 'checked="checked"' : ''; ?> type="radio" name="cu_shipmethod" value="<?php echo esc_attr(stripslashes($price -> ServiceType)); ?>" id="cu_shippingmethod_<?php echo $price -> ServiceType; ?>" />
                                <input type="hidden" name="cu_prices[<?php echo esc_attr(stripslashes($price -> ServiceType)); ?>]" value="<?php echo $price -> RatedShipmentDetails[0] -> ShipmentRateDetail -> TotalNetCharge -> Amount; ?>" />
                            </td>
                            <td><label for="cu_shippingmethod_<?php echo $price -> ServiceType; ?>"><?php echo $fedexService[$price -> ServiceType]; ?></label></td>
                            <td><label for="cu_shippingmethod_<?php echo $price -> ServiceType; ?>"><?php echo $wpcoHtml -> currency_price($price -> RatedShipmentDetails[0] -> ShipmentRateDetail -> TotalNetCharge -> Amount, true, true); ?></label></td>
                            <td>
                            	<label for="cu_shippingmethod_<?php echo $price -> ServiceType; ?>">
		                        	<?php
		                        	
		                        	if (array_key_exists('DeliveryTimestamp', $price)) {
							        	$deliveryDate = date("Y-m-d H:i:s", strtotime($price -> DeliveryTimestamp));
							        } elseif (array_key_exists('TransitTime', $price)) {
							        	$deliveryDate = $fedexTransitTime[$price -> TransitTime];
							        } else {
								        $deliveryDate = '';
							        }
							        
							        echo $deliveryDate;
		                        	
		                        	?>
                            	</label>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
	<?php else : ?>
		<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available, please return.', $this -> plugin_name); ?></p>
		
		<?php if (!empty($errormessages)) : ?>
			<ul>
			<?php foreach ($errormessages as $errormessage) : ?>
				<li><?php echo '<strong>' . $errormessage -> service . ':</strong> ' . stripslashes($errormessage -> description); ?></li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>

	<?php if (empty($ajaxquote)) : ?>
	<p>
		<?php /*<a href="<?php echo $wpcoHtml -> ship_url(); ?>" class="button"><?php _e('&laquo; Back', $this -> plugin_name); ?></a>*/ ?>
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
		<input type="submit" class="<?php echo $this -> pre; ?>button" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
	</p>
</form>
<?php endif; ?>