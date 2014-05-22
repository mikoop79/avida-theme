<p><?php _e('Please choose your preferred shipping method below for this order.', $this -> plugin_name); ?></p>

<?php if (!empty($prices)) : ?>
    <?php if (empty($ajaxquote)) : ?>
    <form action="<?php echo $wpcoHtml -> usps_url(); ?>" method="post">
    <?php endif; ?>
    	<input type="hidden" name="cp_savemethod" value="1" />
        
        <table class="wpco usps">
        	<thead>
            	<tr>
                	<th>&nbsp;</th>
                    <th><?php _e('Shipping Service', $this -> plugin_name); ?></th>
                    <th><?php _e('Shipping Rate', $this -> plugin_name); ?></th>
                </tr>
            </thead>
            <tfoot>
            	<tr>
                	<th>&nbsp;</th>
                    <th><?php _e('Shipping Service', $this -> plugin_name); ?></th>
                    <th><?php _e('Shipping Rate', $this -> plugin_name); ?></th>
                </tr>
            </tfoot>
        	<tbody>
            	<?php $class = false; ?>
            	<?php foreach ($prices as $pkey => $price) : ?>
                	<?php if (!empty($price -> rate) && $price -> rate != "0.00") : ?>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <?php if (!empty($international) && $international == true) : ?>
                                <td>
                                    <input <?php echo (!empty($order -> cu_shipmethod) && $order -> cu_shipmethod == $wpcoHtml -> sanitize($price -> svcdescription)) ? 'checked="checked"' : ''; ?> type="radio" name="cu_shipmethod" value="<?php echo esc_attr(stripslashes($wpcoHtml -> sanitize($price -> svcdescription))); ?>" id="cu_shipmethod_<?php echo $pkey; ?>" />
                                    <input type="hidden" name="cu_prices[<?php echo esc_attr(stripslashes($wpcoHtml -> sanitize($price -> svcdescription))); ?>]" value="<?php echo $price -> rate; ?>" />
                                </td>
                                <td>
                                    <label for="cu_shipmethod_<?php echo $pkey; ?>"><?php echo html_entity_decode(stripslashes($price -> svcdescription)); ?></label>
                                    <br/><span class="small"><?php echo $price -> svccommitments; ?></span>
                                </td>
                                <td>
                                    <label for="cu_shipmethod_<?php echo $pkey; ?>"><?php echo $wpcoHtml -> currency_price($price -> rate); ?></label>
                                </td>
                            <?php else : ?>
                                <td>
                                    <input <?php echo (!empty($order -> cu_shipmethod) && $order -> cu_shipmethod == $price -> mailservice) ? 'checked="checked"' : ''; ?> type="radio" name="cu_shipmethod" value="<?php echo esc_attr(stripslashes($price -> mailservice)); ?>" id="cu_shipmethod_<?php echo $pkey; ?>" />
                                    <input type="hidden" name="cu_prices[<?php echo esc_attr(stripslashes($price -> mailservice)); ?>]" value="<?php echo $price -> rate; ?>" />
                                </td>
                                <td><label for="cu_shipmethod_<?php echo $pkey; ?>"><?php echo html_entity_decode($price -> mailservice); ?></label></td>
                                <td><label for="cu_shipmethod_<?php echo $pkey; ?>"><?php echo $wpcoHtml -> currency_price($price -> rate); ?></label></td>
                            <?php endif; ?>
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
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No prices were found, please try again.', $this -> plugin_name); ?></p>
	<?php if (empty($ajaxquote)) : ?>
    <p>
    	<?php /*<a href="<?php echo $wpcoHtml -> ship_url(); ?>" class="button"><?php _e('&laquo; Back', $this -> plugin_name); ?></a>*/ ?>
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
    </p>
   	<?php endif; ?>
<?php endif; ?>

<!-- USPS debugging -->
<?php if (!empty($api_options['usps_debug']) && $api_options['usps_debug'] == "Y") : ?>
	<h3><?php _e('USPS Errors', $this -> plugin_name); ?></h3>
	<?php echo stripslashes($usps_error); ?>
<?php endif; ?>