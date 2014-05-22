
<?php 

global $wpdb;
$order_id = $Order -> current_order_id(false);
$order = $wpdb -> get_row("SELECT * FROM " . $wpdb -> prefix . $Order -> table . " WHERE id = '" . $order_id . "'");
$user -> shipmethod = (empty($user -> shipmethod)) ? $this -> get_option('shippingdefault') : $user -> shipmethod;
$wpcoDb -> model = $Item -> model;
$items = $wpcoDb -> find_all(array('order_id' => $order -> id));

$this -> render('steps', array('step' => 'shipping', 'order' => $order), true, 'default');

?>

<?php $weight = $Order -> weight($order_id); ?>
<?php if (!empty($weight)) : ?>
	<div class="shippingmessageholder">
		<p class="shippingmessage">
			<?php _e('Your order has a total calculated weight of', $this -> plugin_name); ?> <strong><?php echo $weight; ?><?php echo $this -> get_option('weightm'); ?></strong>
			<?php if ($this -> get_option('shipping_globalminimum') == "Y") : ?>
				<?php if ($shipping_minimum = $this -> get_option('shipping_minimum')) : ?>
			    	<?php if (!empty($shipping_minimum)) : ?>
			        	<br/><?php _e('We have a minimum shipping of', $this -> plugin_name); ?> <strong><?php echo $wpcoHtml -> currency_price($shipping_minimum, true, true); ?></strong>
			        <?php endif; ?>
			    <?php endif; ?>
			<?php endif; ?>
		</p>
	</div>
<?php endif; ?> 

<?php $ordersummarysections = $this -> get_option('ordersummarysections'); ?>
<?php if (!empty($ordersummarysections) && in_array('shipping', $ordersummarysections)) : ?>
	<?php $this -> render('cart-summary', array('order' => $order, 'items' => $items), true, 'default'); ?>
<?php endif; ?>

<form <?php if ($this -> is_plugin_active('euvatex')) : ?>onsubmit="jQuery.Watermark.HideAll();"<?php endif; ?> action="<?php echo $wpcoHtml -> ship_url(); ?>" method="post" id="<?php echo $this -> pre; ?>shippingform">	
	<h3><?php _e('Shipping Information', $this -> plugin_name); ?></h3>
   	<div class="stepsholder">
        <table class="wpco_shipping <?php echo $this -> pre; ?>">
            <tbody>
                <?php $class = ''; ?>
                <?php $paymentfields = $this -> get_option('paymentfields'); ?>
                <?php $shippingfields = $paymentfields['shipping']; ?>
                <?php foreach ($shippingfields as $skey => $shippingfield) : ?>
                    <?php if (!empty($shippingfield['show'])) : ?>
                        <?php if ($skey == "country") : ?>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for="<?php echo $this -> pre; ?><?php echo $skey; ?>"><?php echo $shippingfield['title']; ?> <?php if (!empty($shippingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                <td>
                                    <?php $countries = $Country -> select($domarkets = true); ?>
                                    <select onchange="jQuery('#<?php echo $this -> pre; ?>shippingform').attr('action', '<?php echo $wpcoHtml -> retainquery('updateshipping=1', $wpcoHtml -> ship_url()); ?>').submit();" id="<?php echo $this -> pre; ?>country" class="<?php echo $this -> pre; ?> widefat" name="<?php echo $this -> pre; ?>shipping[country]">
                                        <option value="">- <?php _e('Select Country', $this -> plugin_name); ?> -</option>
                                        <?php foreach ($countries as $id => $title) : ?>
                                            <option <?php echo ((!empty($user -> ship_country) && $user -> ship_country == $id) || (empty($user -> ship_country) && $this -> get_option('defcountry') == $id)) ? 'selected="selected"' : ''; ?> value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (!empty($errors[$skey])) { $this -> render('error', array('error' => $errors[$skey]), true, 'default'); }; ?>
                                </td>
                            </tr>
                        <?php elseif ($skey == "state") : ?>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for="<?php echo $this -> pre; ?><?php echo $skey; ?>"><?php echo $shippingfield['title']; ?> <?php if (!empty($shippingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                <td>                                
                                    <?php echo $wpcoState -> get_states_by_country($user -> ship_country, 'wpcoshipping[state]', "true", "ship", false, $order_id); ?>
                                    <?php if (!empty($errors[$skey])) { $this -> render('error', array('error' => $errors['state']), true, 'default'); }; ?>
                                </td>
                            </tr>
                        <?php else : ?>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for="<?php echo $this -> pre; ?><?php echo $skey; ?>"><?php echo $shippingfield['title']; ?> <?php if (!empty($shippingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                <td>
                                    <input id="<?php echo $this -> pre; ?><?php echo $skey; ?>" style="width:95%;" class="<?php echo $this -> pre; ?> widefat" type="text" name="<?php echo $this -> pre; ?>shipping[<?php echo $skey; ?>]" value="<?php echo (empty($user -> {'ship_' . $skey})) ? '' : $user -> {'ship_' . $skey}; ?>" />
                                    <?php if (!empty($errors[$skey])) { $this -> render('error', array('error' => $errors[$skey]), true, 'default'); }; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>                
            </tbody>
        </table>
    </div>
	
	<?php if ($this -> get_option('shippingcalc') == "Y" && $Order -> do_shipping($order_id)) : ?>
		<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
		<?php if ($shipmethods = $wpcoDb -> find_all(array('status' => "active"), false, array('order', "ASC"))) : ?>                
            <h3><?php _e('Shipping Method', $this -> plugin_name); ?></h3>
				<div class="stepsholder">
				<?php $weight = $Order -> weight($order_id); ?>
                <?php if ($this -> get_option('shiptierstype') == "weight" && !empty($weight)) : ?>
                    <small><?php _e('Shipping cost is determined by the total weight of your order', $this -> plugin_name); ?>.</small>
                    <small><?php _e('Your order has a total calculated weight of', $this -> plugin_name); ?> <strong><?php echo $weight; ?><?php echo $this -> get_option('weightm'); ?></strong>.</small><br/><br/>
                <?php endif; ?> 
                
                <!-- is there only one shipping method? -->
                <?php
                
                $onlyoneshipmethod = false;
                if (count($shipmethods) == 1) {
                    $onlyoneshipmethod = true;
                }
				
				$shippingmethodsdisplay = $this -> get_option('shippingmethodsdisplay');
            	
            	?>
                
                <!-- Multiple shipping methods -->
                <?php if (empty($onlyoneshipmethod) || $onlyoneshipmethod == false) : ?>
                    <?php if ($shippingmethodsdisplay == "select") : ?>
                    	<select onchange="wpco_shipmethodchange(this.value, true);" class="<?php echo $this -> pre; ?> widefat" id="<?php echo $this -> pre; ?>shipmethod" name="<?php echo $this -> pre; ?>shipmethod">
                    <?php endif; ?>
                    
                    <?php foreach ($shipmethods as $shipmethod) : ?>                        
                        <?php $shipmethodprice = $wpcoShipmethod -> price($shipmethod -> id, $order_id); ?>
                    	<?php if ($shippingmethodsdisplay == "radio") : ?>
                    		<label><input onclick="wpco_shipmethodchange(this.value, true);" <?php echo ($onlyoneshipmethod == true || (!empty($order -> shipmethod_id) && $order -> shipmethod_id == $shipmethod -> id) || (empty($order -> shipmethod_id) && !empty($user -> shipmethod) && $user -> shipmethod == $shipmethod -> id)) ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>shipmethod" value="<?php echo $shipmethod -> id; ?>" id="<?php echo $this -> pre; ?>shipmethod_<?php echo $shipmethod -> id; ?>" /> <?php echo $shipmethod -> name; ?> <?php if (!empty($shipmethodprice) && $shipmethodprice > 0 && $shipmethodprice != "0.00") : ?>(<?php echo $wpcoHtml -> currency_price($shipmethodprice); ?>)<?php endif; ?></label>
                        <?php else : ?>
                        	<option <?php echo ($onlyoneshipmethod == true || (empty($order -> shipmethod_id) && !empty($user -> shipmethod) && $user -> shipmethod == $shipmethod -> id) || (!empty($order -> shipmethod_id) && $order -> shipmethod_id == $shipmethod -> id)) ? 'selected="selected"' : ''; ?> value="<?php echo $shipmethod -> id; ?>"><?php echo $shipmethod -> name; ?> <?php if (!empty($shipmethodprice) && $shipmethodprice != "0.00") : ?>(<?php echo $wpcoHtml -> currency_price($shipmethodprice); ?>)<?php endif; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <?php if ($shippingmethodsdisplay == "select") : ?>
                    	</select>
                    	
                    	<script type="text/javascript">
                    	jQuery(document).ready(function() {
                        	shipmethod_id = jQuery('#<?php echo $this -> pre; ?>shipmethod').val();
                        	wpco_shipmethodchange(shipmethod_id, false);
                        });
                    	</script>
                    <?php else : ?>
                    	<script type="text/javascript">
                    	jQuery(document).ready(function() {
                    		shipmethod_id = jQuery('input[name="<?php echo $this -> pre; ?>shipmethod"]:checked').val();
                    		wpco_shipmethodchange(shipmethod_id, false);
                    	});
                    	</script>
                    <?php endif; ?>
                <!-- Only one shipping method -->
                <?php else : ?>
                	<strong><?php echo $shipmethods[0] -> name; ?></strong>
                	<input type="hidden" name="<?php echo $this -> pre; ?>shipmethod" value="<?php echo $shipmethods[0] -> id; ?>" />
                	
                	<script type="text/javascript">
                	jQuery(document).ready(function() {
                		shipmethod_id = "<?php echo $shipmethods[0] -> id; ?>";
                		wpco_shipmethodchange(shipmethod_id, false);
                	});
                	</script>
                <?php endif; ?>
                
                <script type="text/javascript">  
                var shippingquoterequest = false;
                                      
                function wpco_shipmethodchange(shipmethod_id, scroll) {
                	if (shippingquoterequest) { shippingquoterequest.abort(); }
                
                	if (shipmethod_id != "" && shipmethod_id != undefined && shipmethod_id != "undefined" && shipmethod_id != "0") {
                    	var formvalues = jQuery('#<?php echo $this -> pre; ?>shippingform').serialize();
                    	jQuery('#shippingquote').slideDown('slow');
                    	jQuery('#shippingquoteresults').html('<p><img border="0" style="border:none;" src="<?php echo $this -> url(); ?>/images/loading.gif" /> <?php _e('Calculating a shipping quote, please wait.', $this -> plugin_name); ?></p>');
                    	jQuery('#<?php echo $this -> pre; ?>continuebutton').button('option', 'disabled', true);
                    	
                    	shippingquoterequest = jQuery.post(wpcoajaxurl + 'action=wpcoshipmethodchange', formvalues, function(response) {
                    		jQuery('#shippingquoteresults').html(response);
                    		if (scroll == true) { wpco_scroll(jQuery('#shippingquote')); }
                    		jQuery('#<?php echo $this -> pre; ?>continuebutton').button('option', 'disabled', false);
                    	});
                    }
                }
                </script>
                <a href="" onclick="wpco_shipmethodchange(shipmethod_id, true); return false;" class="<?php echo $this -> pre; ?>button button"><?php _e('Refresh Quote', $this -> plugin_name); ?></a>                
                <?php if (!empty($errors['shipmethod'])) { $this -> render('error', array('error' => $errors['shipmethod']), true, 'default'); }; ?>
   			</div>
		<?php endif; ?>
	<?php endif; ?>
	
	<!-- Shipping Quote -->
	<h3><?php _e('Shipping Quote', $this -> plugin_name); ?></h3>
	<div class="stepsholder" id="shippingquoteresults">
		<!-- results go here -->
	</div>
	
	<?php global $user_ID; ?>
    <?php $order_id = $Order -> current_order_id(); ?>
    <?php $this -> render('fields' . DS . 'global', array('order_id' => $order_id, 'globalp' => "ship", 'globalerrors' => $globalerrors), true, 'default'); ?>
    
    <?php do_action($this -> pre . '_shipping_after_global', $order_id, $errors); ?>
	
	<div class="shippingbuttons">
        <input type="button" class="<?php echo $this -> pre; ?>button" onclick="history.go(-1);" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" />
		<input type="submit" id="<?php echo $this -> pre; ?>continuebutton" class="<?php echo $this -> pre; ?>button" name="continue" value="<?php _e('Continue', $this -> plugin_name); ?> &raquo;" />
	</div>
</form>