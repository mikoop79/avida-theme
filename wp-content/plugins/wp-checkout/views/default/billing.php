<?php global $user_ID; ?>
<?php if ($user_ID || $this -> get_option('guestcheckout') == "Y") : ?>
	<?php 

	global $wpdb;
	$order_id = $Order -> current_order_id(false);
	$order = $wpdb -> get_row("SELECT * FROM " . $wpdb -> prefix . $Order -> table . " WHERE id = '" . $order_id . "'");
	$user -> shipmethod = (empty($user -> shipmethod)) ? $this -> get_option('shippingdefault') : $user -> shipmethod;
	$wpcoDb -> model = $Item -> model;
	$items = $wpcoDb -> find_all(array('order_id' => $order -> id));
	
	$this -> render('steps', array('step' => 'billing', 'order' => $order), true, 'default');
	
	?>
	
	<?php $ordersummarysections = $this -> get_option('ordersummarysections'); ?>
	<?php if (!empty($ordersummarysections) && in_array('billing', $ordersummarysections)) : ?>
		<?php $this -> render('cart-summary', array('order' => $order, 'items' => $items), true, 'default'); ?>
	<?php endif; ?>
	
    <?php 
	
	if (!empty($_GET['pmethod'])) { 
		$user -> bill_pmethod = $_GET['pmethod']; 
	} 
	
	?>
            
    <form <?php if ($this -> is_plugin_active('euvatex')) : ?>onsubmit="jQuery.Watermark.HideAll();"<?php endif; ?> action="<?php echo $wpcoHtml -> bill_url(); ?>" method="post" id="<?php echo $this -> pre; ?>billingform">
        <?php $paymentmethods = $this -> get_option('paymentmethods'); ?>
        
        <?php
		
		if (!empty($order)) {
			if (!empty($order -> pmethod) && !empty($order -> buynow) && $order -> buynow == "Y") {
				$paymentmethods = array($order -> pmethod);	
			}
		}
		
		?>
        
        <?php if (!empty($paymentmethods)) : ?>        
        	<?php if (($order -> total == "0.00" || $order -> total <= 0) && in_array('cu', $paymentmethods) && $this -> get_option('cu_zerototal') == "Y") : ?>
        		<input type="hidden" name="pmethod" value="cu" />
        		
        		<script type="text/javascript">
        		jQuery(document).ready(function() { change_pmethod('cu'); });
        		</script>
            <?php elseif (count($paymentmethods) == 1) : ?>
                <input type="hidden" name="pmethod" value="<?php echo $paymentmethods[0]; ?>" />
                
                <script type="text/javascript">
                jQuery(document).ready(function() {
                    change_pmethod('<?php echo $paymentmethods[0]; ?>');
                });
                </script>
            <?php else : ?>                    
                <h3><?php _e('Payment Method', $this -> plugin_name); ?></h3>
   				<div class="stepsholder">
					<?php foreach ($paymentmethods as $pmethod) : ?>
                        <?php
                        
                        switch ($pmethod) {
                            case 'pp'			:
                                $pp_surcharge = $Order -> surcharge("pp", $total_price);
                                $pp_surcharge_text = $wpcoHtml -> surcharge_text("pp");
                            
                                ?><label><input onclick="change_pmethod(this.value);" <?php echo (!empty($user -> bill_pmethod) && $user -> bill_pmethod == $pmethod) ? 'checked="checked"' : ''; ?> type="radio" name="pmethod" value="pp" /> <?php _e('PayPal', $this -> plugin_name); ?><?php if (!empty($pp_surcharge) && !empty($pp_surcharge_text)) { echo ' (' . __('Additional', $this -> plugin_name) . ' ' . $pp_surcharge_text . ')'; }; ?></label><?php
                                break;
                            case 'bw'			:
                                ?><label><input onclick="change_pmethod(this.value);" <?php echo (!empty($user -> bill_pmethod) && $user -> bill_pmethod == $pmethod) ? 'checked="checked"' : ''; ?> type="radio" name="pmethod" value="bw" /> <?php _e('Bank Wire', $this -> plugin_name); ?></label><?php
                                break;
                            case 'cc'			:
                                ?><label><input onclick="change_pmethod(this.value);" <?php echo (!empty($user -> bill_pmethod) && $user -> bill_pmethod == $pmethod) ? 'checked="checked"' : ''; ?> type="radio" name="pmethod" value="cc" /> <?php _e('Manual POS (Credit Card)', $this -> plugin_name); ?></label><?php
                                break;
                            case 'cu'			:
                                ?><label><input onclick="change_pmethod(this.value);" <?php echo (!empty($user -> bill_pmethod) && $user -> bill_pmethod == $pmethod) ? 'checked="checked"' : ''; ?> type="radio" name="pmethod" value="cu" /> <?php echo $wpcoHtml -> pmethod('cu'); ?></label><?php
                                break;
                            case 'fd'			:
                                ?><label><input onclick="change_pmethod(this.value);" <?php echo (!empty($user -> bill_pmethod) && $user -> bill_pmethod == $pmethod) ? 'checked="checked"' : ''; ?> type="radio" name="pmethod" value="fd" /> <?php echo $wpcoHtml -> pmethod('fd'); ?></label><?php
                                break;
                            default				:
                                ?><label><input onclick="change_pmethod(this.value);" <?php echo (!empty($user -> bill_pmethod) && $user -> bill_pmethod == $pmethod) ? 'checked="checked"' : ''; ?> type="radio" name="pmethod" value="<?php echo $pmethod; ?>" /> <?php echo $wpcoHtml -> pmethod($pmethod); ?></label><?php
                                break;
                        }
                        
                        ?>
                    <?php endforeach; ?>
                </div>
                <?php if (!empty($errors['pmethod'])) { $this -> render('error', array('error' => $errors['pmethod']), true, 'default'); }; ?>
                <br/>
            <?php endif; ?>
                
            <div id="<?php echo $this -> pre; ?>bwdetails" style="display:<?php echo (!empty($user -> bill_pmethod) && $user -> bill_pmethod == "bw") ? 'block' : 'none'; ?>">
                <p>
                    <?php _e('Please use the banking details below to process a bank wire to the merchant for the specified amount', $this -> plugin_name); ?>.
                    <?php _e('Once your payment has been received, your order will be processed accordingly', $this -> plugin_name); ?>.
                </p>
                    
                <h3><?php _e('Banking Details', $this -> plugin_name); ?></h3>
   				<div class="stepsholder">
                    <table class="wpco_billing <?php echo $this -> pre; ?>">
                        <tbody>
                            <?php $bwdetails = $this -> get_option('bwdetails'); ?>
                            <?php $class = ''; ?>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><?php _e('Beneficiary Name', $this -> plugin_name); ?></th>
                                <td><?php echo $bwdetails['beneficiary']; ?></td>
                            </tr>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><?php _e('Bank Name', $this -> plugin_name); ?></th>
                                <td><?php echo $bwdetails['name']; ?></td>
                            </tr>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><?php _e('Bank Phone Number', $this -> plugin_name); ?></th>
                                <td><?php echo $bwdetails['phone']; ?></td>
                            </tr>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><?php _e('Bank Address', $this -> plugin_name); ?></th>
                                <td><?php echo nl2br($bwdetails['address']); ?></td>
                            </tr>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><?php _e('Account Number', $this -> plugin_name); ?></th>
                                <td><?php echo $bwdetails['account']; ?></td>
                            </tr>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><?php _e('Swift Code/Routing Number', $this -> plugin_name); ?></th>
                                <td><?php echo $bwdetails['swift']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="<?php echo $this -> pre; ?>ccdetails" style="display:<?php echo (!empty($user -> bill_pmethod) && $user -> bill_pmethod == "cc") ? 'block' : 'none'; ?>;">				
                <p>
                    <?php _e('Your credit card will be manually processed by the merchant with valid authorization', $this -> plugin_name); ?>.
                    <?php _e('You will be notified via email once your card has been charged and your order has been processed', $this -> plugin_name); ?>.
                </p>
                    
                <h3><?php _e('Credit Card Details', $this -> plugin_name); ?></h3>
   				<div class="stepsholder">
                    <table class="wpco_billing <?php echo $this -> pre; ?>">
                        <tbody>
                            <?php $class = ''; ?>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for="<?php echo $this -> pre; ?>cc_name"><?php _e('Name on Card', $this -> plugin_name); ?></label></th>
                                <td>
                                    <input type="text" name="<?php echo $this -> pre; ?>billing[cc_name]" value="<?php echo $user -> cc_name; ?>" id="<?php echo $this -> pre; ?>cc_name" />
                                    <?php if (!empty($errors['cc_name'])) { $this -> render('error', array('error' => $errors['cc_name']), true, 'default'); }; ?>
                                </td>
                            </tr>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for="<?php echo $this -> pre; ?>cc_type"><?php _e('Card Type', $this -> plugin_name); ?></label></th>
                                <td>
                                    <?php if ($cctypes = $this -> get_option('cctypes')) : ?>
                                        <?php $cctypes_accepted = $this -> get_option('cctypes_accepted'); ?>
                                        <select name="<?php echo $this -> pre; ?>billing[cc_type]" id="<?php echo $this -> pre; ?>cc_type">
                                            <option value="">- <?php _e('Select Type', $this -> plugin_name); ?> -</option>
                                            <?php foreach ($cctypes as $cctype_key => $cctype_val) : ?>
                                                <?php if (!empty($cctypes_accepted) && in_array($cctype_key, $cctypes_accepted)) : ?>
                                                    <option <?php echo (!empty($user -> cc_type) && $user -> cc_type == $cctype_key) ? 'selected="selected"' : ''; ?> value="<?php echo $cctype_key; ?>"><?php echo $cctype_val; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (!empty($errors['cc_type'])) : ?>
                                            <?php $this -> render('error', array('error' => $errors['cc_type']), true, 'default'); ?>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <p class="<?php echo $this -> pre; ?>error"><?php _e('No types are available at this time', $this -> plugin_name); ?></p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for="<?php echo $this -> pre; ?>cc_number"><?php _e('Card Number', $this -> plugin_name); ?></label></th>
                                <td>
                                    <input type="text" name="<?php echo $this -> pre; ?>billing[cc_number]" value="<?php echo $user -> cc_number; ?>" id="<?php echo $this -> pre; ?>cc_number" />
                                    <?php if (!empty($errors['cc_number'])) : ?>
                                        <?php $this -> render('error', array('error' => $errors['cc_number']), true, 'default'); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for=""><?php _e('Expiry Date', $this -> plugin_name); ?></label></th>
                                <td>
                                    <select name="<?php echo $this -> pre; ?>billing[cc_exp_m]" style="width:auto;">
                                        <option value=""><?php _e('MM', $this -> plugin_name); ?></option>
                                        <?php for ($m = 1; $m <= 12; $m++) : ?>
                                            <option <?php echo (!empty($user -> cc_exp_m) && $user -> cc_exp_m == $m) ? 'selected="selected"' : ''; ?> value="<?php echo $m; ?>"><?php echo (strlen($m) == 1) ? '0' : ''; ?><?php echo $m; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <select name="<?php echo $this -> pre; ?>billing[cc_exp_y]" style="width:auto;">
                                        <option value=""><?php _e('YYYY', $this -> plugin_name); ?></option>
                                        <?php for ($y = 12; $y <= 23; $y++) : ?>
                                            <option <?php echo (!empty($user -> cc_exp_y) && $user -> cc_exp_y == $y) ? 'selected="selected"' : ''; ?> value="<?php echo $y; ?>">20<?php echo (strlen($y) == 1) ? '0' : ''; ?><?php echo $y; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    
                                    <?php if (!empty($errors['cc_exp_m'])) { $this -> render('error', array('error' => $errors['cc_exp_m']), true, 'default'); }; ?>
                                    <?php if (!empty($errors['cc_exp_y'])) { $this -> render('error', array('error' => $errors['cc_exp_y']), true, 'default'); }; ?>
                                </td>
                            </tr>
                            <?php if (!$this -> get_option('billcvv') || $this -> get_option('billcvv') == "Y") : ?>
                                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                    <th><label for="<?php echo $this -> pre; ?>cc_cvv"><?php _e('Security Code (CVV)', $this -> plugin_name); ?></label></th>
                                    <td>									
                                        <input type="text" style="width:35px;" name="<?php echo $this -> pre; ?>billing[cc_cvv]" value="<?php echo $user -> cc_cvv; ?>" id="<?php echo $this -> pre; ?>cc_cvv" />
                                        <?php if (!empty($errors['cc_cvv'])) { $this -> render('error', array('error' => $errors['cc_cvv']), true, 'default'); }; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    
        <?php if ($Order -> do_shipping($order_id)) : ?>
            <div><label><input <?php echo (!empty($user -> billingsameshipping) && $user -> billingsameshipping == "Y") ? 'checked="checked"' : ''; ?> onclick="jQuery('#billfields').toggle('slow');" type="checkbox" name="sameasshipping" value="Y" /> <?php _e('Billing Details Same as Shipping Details', $this -> plugin_name); ?></label></div>
            <div id="billfields" style="display:<?php echo (!empty($user -> billingsameshipping) && $user -> billingsameshipping == "Y") ? 'none' : 'block'; ?>;">
        <?php endif; ?>                
            <h3><?php _e('Billing Information', $this -> plugin_name); ?></h3>
   			<div class="stepsholder"> 
                <table class="wpco_billing <?php echo $this -> pre; ?>">
                    <tbody>
                        <?php $class = ''; ?>
                        <?php $paymentfields = $this -> get_option('paymentfields'); ?>
                        <?php $billingfields = $paymentfields['billing']; ?>
                        <?php foreach ($billingfields as $bkey => $billingfield) : ?>
                            <?php if (!empty($billingfield['show'])) : ?>
                                <?php if ($bkey == "country") : ?>
                                    <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                        <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo $billingfield['title']; ?> <?php if (!empty($billingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                        <td>
                                            <?php $countries = $Country -> select($domarkets = true); ?>
                                            <select onchange="jQuery('#<?php echo $this -> pre; ?>billingform').attr('action', '<?php echo $wpcoHtml -> retainquery('updatebilling=1', $wpcoHtml -> bill_url()); ?>').submit();" id="<?php echo $this -> pre; ?>country" class="<?php echo $this -> pre; ?> widefat" name="<?php echo $this -> pre; ?>billing[country]">
                                                <option value="">- <?php _e('Select Country', $this -> plugin_name); ?> -</option>
                                                <?php foreach ($countries as $id => $title) : ?>
                                                    <option <?php echo ((!empty($user -> bill_country) && $user -> bill_country == $id) || (empty($user -> bill_country) && $this -> get_option('defcountry') == $id)) ? 'selected="selected"' : ''; ?> value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if (!empty($errors[$bkey])) { $this -> render('error', array('error' => $errors[$bkey]), true, 'default'); }; ?>
                                        </td>
                                    </tr>
                                <?php elseif ($bkey == "state") : ?>
                                    <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                        <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo $billingfield['title']; ?> <?php if (!empty($billingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                        <td>
                                            <?php echo $wpcoState -> get_states_by_country($user -> bill_country, 'wpcobilling[state]', "true", "bill", false, $order_id); ?>
                                            <?php if (!empty($errors[$bkey])) { $this -> render('error', array('error' => $errors[$bkey]), true, 'default'); }; ?>
                                        </td>
                                    </tr>
                                <?php else : ?>
                                    <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                        <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo $billingfield['title']; ?> <?php if (!empty($billingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                        <td>
                                            <input id="<?php echo $this -> pre; ?><?php echo $bkey; ?>" style="width:95%;" class="<?php echo $this -> pre; ?> widefat" type="text" name="<?php echo $this -> pre; ?>billing[<?php echo $bkey; ?>]" value="<?php echo (empty($user -> {'bill_' . $bkey})) ? '' : $user -> {'bill_' . $bkey}; ?>" />
                                            <?php if (!empty($errors[$bkey])) { $this -> render('error', array('error' => $errors[$bkey]), true, 'default'); }; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php if ($this -> get_option('shippingdetails') == "Y" && $Order -> do_shipping($order_id)) : ?>
            </div>           
        <?php endif; ?>
        
        <?php $order_id = $Order -> current_order_id(); ?>
        <?php $this -> render('fields' . DS . 'global', array('order_id' => $order_id, 'globalp' => "bill", 'globalerrors' => $globalerrors), true, 'default'); ?>
        
        <?php do_action($this -> pre . '_billing_after_global', $order_id, $errors); ?>
    
		<div class="shippingbuttons">
            <?php $location = ($this -> get_option('shippingdetails') == "Y" && $Order -> do_shipping($order_id)) ? $wpcoHtml -> ship_url() : $wpcoHtml -> cart_url(); ?>
            <input type="button" class="<?php echo $this -> pre; ?>button" onclick="history.go(-1);" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" />
            <input class="<?php echo $this -> pre; ?>button" id="<?php echo $this -> pre; ?>continuebutton" style="cursor:pointer;" type="submit" name="continue" value="<?php _e('Continue', $this -> plugin_name); ?> &raquo;" />
        </div>
    </form>
<?php else : ?>
	<div class="<?php echo $this -> pre; ?>error"><?php _e('Please register/login to use this feature', $this -> plugin_name); ?></div>
<?php endif; ?>

<script type="text/javascript">
change_pmethod = function(pmethod) {
	jQuery('#<?php echo $this -> pre; ?>bwdetails').hide();
	jQuery('#<?php echo $this -> pre; ?>ccdetails').hide();
	jQuery('#<?php echo $this -> pre; ?>cudetails').hide();
	
	if (pmethod == "bw") {
		jQuery('#<?php echo $this -> pre; ?>bwdetails').show();
	} else if (pmethod == "cc") {
		jQuery('#<?php echo $this -> pre; ?>ccdetails').show();
	} else if (pmethod == "fd") {
		
	} else if (pmethod == "cu") {
		jQuery('#<?php echo $this -> pre; ?>cudetails').show();	
	} else if (pmethod == "mb") {
		
	}
}
</script>