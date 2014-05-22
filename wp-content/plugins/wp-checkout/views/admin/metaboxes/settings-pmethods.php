<?php $paymentmethods = $this -> get_option('paymentmethods'); ?>
<?php $class = "alternate"; ?>

<div class="submitbox">
	<div>
    	<div>
        	<div class="misc-pub-section">
            	<p><?php _e('Tick the payment methods to display on the billing page.', $this -> plugin_name); ?></p>
            </div>
        	<div class="misc-pub-section">
        		<div class="scroll-list">
	    			<table class="widefat">
	                    <tbody>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td>
	                                <input type="checkbox" name="pmethodsselectall" value="1" id="pmethodsselectall" onclick="jqCheckAll(this, '<?php echo $this -> sections -> settings; ?>', 'paymentmethods');" />
	                                <label for="pmethodsselectall"><strong><?php _e('Select All', $this -> plugin_name); ?></strong></label>
	                            </td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('tc', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="tc" /> <?php _e('2CheckOut', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <?php if ($this -> is_plugin_active('amazonfps')) : ?>
	                        	<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                        		<td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('amazonfps', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="amazonfps" /> <?php _e('Amazon FPS', $this -> plugin_name); ?></label></td>
	                        	</tr>
	                        <?php endif; ?>
	                        <?php if ($this -> is_plugin_active('apco')) : ?>
	                        	<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                        		<td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('apco', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="apco" /> <?php _e('APCO Limited', $this -> plugin_name); ?></label></td>
	                        	</tr>
	                        <?php endif; ?>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('authorize_aim', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="authorize_aim" /> <?php _e('Authorize.net (AIM)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('bw', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="bw" /> <?php _e('Bank Wire', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('bartercard', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="bartercard" /> <?php _e('BarterCard InternetPOS', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <?php if ($this -> is_plugin_active('bluepay')) : ?>
	                        	<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                        		<td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('bluepay', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="bluepay" /> <?php _e('BluePay 2.0 Redirect', $this -> plugin_name); ?></label></td>
	                        	</tr>
	                        <?php endif; ?>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('cc', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="cc" /> <?php _e('Credit Card (manual POS)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('cu', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="cu" /> <?php _e('Custom/Manual Payment', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('ematters', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="ematters" /> <?php _e('eMatters (HTTP POST)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('eupayment', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="eupayment" /> <?php _e('Euro Payment Services S.R.L.', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('eway_shared', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="eway_shared" /> <?php _e('eWay AU (Shared)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <?php if ($this -> is_plugin_active('fdapi')) : ?>
	                        	<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
			                        <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('fdapi', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="fdapi" /> <?php _e('First Data API', $this -> plugin_name); ?></label></td>
			                    </tr>
	                        <?php endif; ?>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('fd', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="fd" /> <?php _e('First Data Connect 2.0', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('google_checkout', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="google_checkout" /> <?php _e('Google Checkout', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <?php if ($this -> is_plugin_active('ipay')) : ?>
	                        	<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                                <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('ipay', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="ipay" /> <?php _e('iPay88', $this -> plugin_name); ?></label></td>
	                            </tr>
	                        <?php endif; ?>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('lucy', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="lucy" /> <?php _e('LUCY Gateway', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('mb', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="mb" /> <?php _e('Skrill (Moneybookers)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('monsterpay', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="monsterpay" /> <?php _e('MonsterPay', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <?php if ($this -> is_plugin_active('netcash')) : ?>
	                        	<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                                <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('netcash', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="netcash" /> <?php _e('Netcash', $this -> plugin_name); ?></label></td>
	                            </tr>
	                        <?php endif; ?>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('ogone_basic', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="ogone_basic" /> <?php _e('Ogone (Basic e-Commerce)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('pp', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="pp" /> <?php _e('PayPal (Website Payments Standard)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('payxml', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="payxml" id="paymentmethods_payxml" /> <?php _e('PayGate (XML)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('pp_pro', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="pp_pro" /> <?php _e('PayPal (Pro)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <?php if ($this -> is_plugin_active('sagepay')) : ?>
	                            <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                                <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('sagepay', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="sagepay" /> <?php _e('Sage Pay (Form Protocol)', $this -> plugin_name); ?></label></td>
	                            </tr>
	                        <?php endif; ?>
	                        <?php if ($this -> is_plugin_active('securetrading')) : ?>
	                            <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                                <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('securetrading', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="securetrading" /> <?php _e('SecureTrading Payment Pages', $this -> plugin_name); ?></label></td>
	                            </tr>
	                        <?php endif; ?>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('re', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="re" /> <?php _e('Realex Payments (Realauth Redirect)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('re_remote', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="re_remote" /> <?php _e('Realex Payments (Realauth Remote)', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <?php if ($this -> is_plugin_active('stripe')) : ?>
	                        	<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                                <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('stripe', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="stripe" /> <?php _e('Stripe', $this -> plugin_name); ?></label></td>
	                            </tr>
	                        <?php endif; ?>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('virtualmerchant', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="virtualmerchant" /> <?php _e('Virtual Merchant', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
	                            <td><label><input <?php echo (!empty($paymentmethods) && is_array($paymentmethods) && in_array('worldpay', $paymentmethods)) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentmethods[]" value="worldpay" /> <?php _e('WorldPay', $this -> plugin_name); ?></label></td>
	                        </tr>
	                        <?php do_action($this -> pre . '_pmethods_list', $paymentmethods, $class); ?>
	                    </tbody>
	                </table>
	            </div>
   			</div>
            <?php if (empty($_GET['page']) || $_GET['page'] != $this -> sections -> settings_pmethods) : ?>
                <div class="misc-pub-section misc-pub-section-last">
                    <?php echo $wpcoHtml -> link(__('Configure Payment Methods', $this -> plugin_name), '?page=' . $this -> sections -> settings_pmethods); ?>
                </div>
            <?php endif; ?>
    	</div>
    </div>
</div>