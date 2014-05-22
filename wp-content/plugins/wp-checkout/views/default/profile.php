<?php if (!empty($_POST['user_id'])) { $userid = $_POST['user_id']; }; ?>
<?php $user = $this -> userdata($userid); ?>
<?php $paymentfields = $this -> get_option('paymentfields'); ?>

<?php 

if (!empty($_POST['wpcoshipping'])) {
	foreach ($_POST['wpcoshipping'] as $skey => $sval) {
		$user -> {'ship_' . $skey} = $sval;
	}
}

if (!empty($_POST['wpcobilling'])) {
	foreach ($_POST['wpcobilling'] as $skey => $sval) {
		$user -> {'bill_' . $skey} = $sval;
	}
}

?>

<div class="<?php echo $this -> pre; ?>">
	<h3><?php _e('Customer Information', $this -> plugin_name); ?></h3>
    <h4><?php _e('Shipping Details', $this -> plugin_name); ?></h4>
    
    <table class="form-table">
        <tbody>
            <?php $class = ''; ?>
            <?php $shippingfields = $paymentfields['shipping']; ?>
            <?php foreach ($shippingfields as $skey => $shippingfield) : ?>
                <?php if (!empty($shippingfield['show'])) : ?>
                    <?php if ($skey == "country") : ?>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><label for="<?php echo $this -> pre; ?><?php echo $skey; ?>"><?php echo $shippingfield['title']; ?> <?php if (!empty($shippingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                            <td>
                                <?php $countries = $Country -> select($domarkets = true); ?>
                                <select onchange="wpcochange_states(this.value, 'shipping', 'shippingstates');" id="<?php echo $this -> pre; ?>country" class="<?php echo $this -> pre; ?> widefat" name="<?php echo $this -> pre; ?>shipping[country]" style="width:100%;">
                                    <option value=""><?php _e('- Select Country -', $this -> plugin_name); ?></option>
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
                            	<span id="shippingstates">                            
                                	<?php echo $wpcoState -> get_states_by_country($user -> ship_country, 'wpcoshipping[state]', "true", "ship", $userid); ?>
                                </span>
                                <?php if (!empty($errors[$skey])) { $this -> render('error', array('error' => $errors['state']), true, 'default'); }; ?>
                            </td>
                        </tr>
                    <?php else : ?>
                        <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                            <th><label for="<?php echo $this -> pre; ?><?php echo $skey; ?>"><?php echo $shippingfield['title']; ?> <?php if (!empty($shippingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                            <td>
                                <input id="<?php echo $this -> pre; ?><?php echo $skey; ?>" style="width:97%;" class="<?php echo $this -> pre; ?> widefat" type="text" name="<?php echo $this -> pre; ?>shipping[<?php echo $skey; ?>]" value="<?php echo (empty($user -> {'ship_' . $skey})) ? '' : $user -> {'ship_' . $skey}; ?>" />
                                <?php if (!empty($errors[$skey])) { $this -> render('error', array('error' => $errors[$skey]), true, 'default'); }; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>                
        </tbody>
    </table>
    
    <h4><?php _e('Billing Details', $this -> plugin_name); ?></h4>
    
    <table class="form-table">
        <tbody>
            <tr>
                <th><label for="billingsameshippingY"><?php _e('Same as Shipping', $this -> plugin_name); ?></label></th>
                <td>
                    <label><input onclick="jQuery('#bssdiv').hide();" <?php echo (empty($user -> billingsameshipping) || $user -> billingsameshipping == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="billingsameshipping" value="Y" id="billingsameshippingY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                    <label><input onclick="jQuery('#bssdiv').show();" <?php echo ($user -> billingsameshipping == "N") ? 'checked="checked"' : ''; ?> type="radio" name="billingsameshipping" value="N" id="billingsameshippingN" /> <?php _e('No', $this -> plugin_name); ?></label>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div id="bssdiv" style="display:<?php echo (!empty($user -> billingsameshipping) && $user -> billingsameshipping == "N") ? 'block' : 'none'; ?>;">
        <table class="form-table">
            <tbody>
                <?php $class = ''; ?>
                <?php $billingfields = $paymentfields['billing']; ?>
                <?php foreach ($billingfields as $bkey => $billingfield) : ?>
                    <?php if (!empty($billingfield['show'])) : ?>
                        <?php if ($bkey == "country") : ?>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo $billingfield['title']; ?> <?php if (!empty($billingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                <td>
                                    <?php $countries = $Country -> select($domarkets = true); ?>
                                    <select onchange="wpcochange_states(this.value, 'billing', 'billingstates');" id="<?php echo $this -> pre; ?>country" class="<?php echo $this -> pre; ?> widefat" name="<?php echo $this -> pre; ?>billing[country]" style="width:100%;">
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
                                	<span id="billingstates">
                                    	<?php echo $wpcoState -> get_states_by_country($user -> bill_country, 'wpcobilling[state]', "true", "bill", $userid); ?>
                                    </span>
                                    <?php if (!empty($errors[$bkey])) { $this -> render('error', array('error' => $errors[$bkey]), true, 'default'); }; ?>
                                </td>
                            </tr>
                        <?php else : ?>
                            <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                                <th><label for="<?php echo $this -> pre; ?><?php echo $bkey; ?>"><?php echo $billingfield['title']; ?> <?php if (!empty($billingfield['required'])) : ?><sup class="error">&#42;</sup><?php endif; ?></label></th>
                                <td>
                                    <input id="<?php echo $this -> pre; ?><?php echo $bkey; ?>" style="width:97%;" class="<?php echo $this -> pre; ?> widefat" type="text" name="<?php echo $this -> pre; ?>billing[<?php echo $bkey; ?>]" value="<?php echo (empty($user -> {'bill_' . $bkey})) ? '' : $user -> {'bill_' . $bkey}; ?>" />
                                    <?php if (!empty($errors[$bkey])) { $this -> render('error', array('error' => $errors[$bkey]), true, 'default'); }; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
function wpcochange_states(country_id, type, updatediv) {
	jQuery('#' + updatediv).html('<?php _e('Loading states, please wait.', $this -> plugin_name); ?>');
	jQuery.post(wpcoAjax + "?cmd=get_states_by_country&country_id=" + country_id + "&inputname=<?php echo $this -> pre; ?>" + type + "[state]&user_id=<?php echo $userid; ?>", false, function(response) {
		jQuery('#' + updatediv).html(response);
	});
}
</script>