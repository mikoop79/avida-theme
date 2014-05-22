<p><?php _e('Please choose your preferred shipping method below for this order.', $this -> plugin_name); ?></p>

<?php if (empty($ups_error)) : ?>
	<?php if (empty($ajaxquote)) : ?>
    <form action="<?php echo $wpcoHtml -> ups_url(); ?>" method="post">
    <?php endif; ?>
    	<input type="hidden" name="cp_savemethod" value="1" />
        
        <table class="wpco ups">
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
                	<?php $price = (object) $price; ?>
                	<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                    	<td>
                        	<input type="hidden" name="cu_prices[<?php echo $price -> description; ?>]" value="<?php echo $price -> cost; ?>" id="cu_prices_<?php echo $price -> code; ?>" />
                            <input type="hidden" name="shipmethodnames[<?php echo $price -> code; ?>]" value="<?php echo esc_attr(stripslashes($price -> description)); ?>" />
                            <input <?php echo (!empty($order -> cu_shipmethod) && $order -> cu_shipmethod == $price -> description) ? 'checked="checked"' : ''; ?> type="radio" name="cu_shipmethod" value="<?php echo esc_attr(stripslashes($price -> description)); ?>" id="cu_shipmethod_<?php echo $price -> code; ?>" />
                        </td>
                        <td>
                        	<label for="cu_shipmethod_<?php echo $price -> code; ?>"><?php echo stripslashes($price -> description); ?></label>
                        </td>
                        <td>
                        	<label for="cu_shipmethod_<?php echo $price -> code; ?>"><?php echo $wpcoHtml -> currency_price($price -> cost); ?></label>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php if (empty($ajaxquote)) : ?>
        <p>
            <?php /*<a href="<?php echo $wpcoHtml -> ship_url(); ?>" class="button"><?php _e('&laquo; Back', $this -> plugin_name); ?></a>*/ ?>
            <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
            <input type="submit" class="<?php echo $this -> pre; ?>button" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />
        </p>
    </form>
   	<?php endif; ?>
<?php else : ?>
	<p class="wpcoerror"><?php echo $usp_error; ?></p>
	<?php if (empty($ajaxquote)) : ?>
    <p>
    	<?php /*<a href="<?php echo $wpcoHtml -> ship_url(); ?>" class="button"><?php _e('&laquo; Back', $this -> plugin_name); ?></a>*/ ?>
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
    </p>
    <?php endif; ?>
<?php endif; ?>