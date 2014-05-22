<table class="form-table">
	<tbody>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>pp_email"><?php _e('PayPal Email', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" id="<?php echo $this -> pre; ?>pp_email" name="pp_email" value="<?php echo $this -> get_option('pp_email'); ?>" class="widefat" />
				<span class="howto"><?php _e('Your PRIMARY PayPal email address. This is case sensitive, please ensure it is correct.', $this -> plugin_name); ?></span>	
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>pp_invoiceprefix"><?php _e('Invoice Prefix', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="pp_invoiceprefix" value="<?php echo $this -> get_option('pp_invoiceprefix'); ?>" id="<?php echo $this -> pre; ?>pp_invoiceprefix" />
				<span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('Prefix for invoice numbers sent through to PayPal.', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="pp_surcharge_N"><?php _e('Surcharge', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input onclick="jQuery('#pp_surcharge_div').show();" <?php echo ($this -> get_option('pp_surcharge') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="pp_surcharge" value="Y" id="pp_surcharge_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input onclick="jQuery('#pp_surcharge_div').hide();" <?php echo ($this -> get_option('pp_surcharge') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="pp_surcharge" value="N" id="pp_surcharge_N" /> <?php _e('No', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Additional charge/cost to the order total when this payment method is used by a customer', $this -> plugin_name); ?></span>
            </td>
        </tr>
	</tbody>
</table>

<div id="pp_surcharge_div" style="display:<?php echo ($this -> get_option('pp_surcharge') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
    	<tbody>
        	<tr>
            	<th><label for="pp_surcharge_amount"><?php _e('Fixed Amount', $this -> plugin_name); ?></label></th>
                <td>
                	<?php echo $wpcoHtml -> currency_html('<input class="widefat input" style="width:45px;" type="text" name="pp_surcharge_amount" value="' . esc_attr(stripslashes($this -> get_option('pp_surcharge_amount'))) . '" id="pp_surcharge_amount" />'); ?>
                	<span class="howto"><?php _e('Fixed amount to charge to the order total', $this -> plugin_name); ?></span>
                </td>
            </tr>
            <tr>
            	<th><label for="pp_surcharge_percentage"><?php _e('Percentage of Total', $this -> plugin_name); ?></label></th>
                <td>
                	<input class="widefat input" style="width:45px;" type="text" name="pp_surcharge_percentage" value="<?php echo esc_attr(stripslashes($this -> get_option('pp_surcharge_percentage'))); ?>" id="pp_surcharge_percentage" /> &#37;
                	<span class="howto"><?php _e('Percentage of the order total to be surcharged', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="pp_addressoverride_Y"><?php _e('Address Override', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('pp_addressoverride') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="pp_addressoverride" value="Y" id="pp_addressoverride_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('pp_addressoverride') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="pp_addressoverride" value="N" id="pp_addressoverride_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Override buyer address on PayPal and shipping/billing settings in the PayPal account.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="pp_notiftype_none"><?php _e('Notification Type', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="if (!confirm('<?php echo sprintf(__('IMPORTANT:\n\nPlease ensure that you turn on the PayPal IPN under Profile > My Selling Tools > Instant Payment Notification in your PayPal account in order for PayPal to send notifications to the plugin.\n\nThe URL to enter for the IPN is:\n\n%s\n\nOnce you have done this, click Ok below, else click Cancel.', $this -> plugin_name), ($wpcoHtml -> retainquery('type=pp', $wpcoHtml -> return_url()))); ?>')) { return false; } jQuery('#pp_notiftype_IPN_div').show(); jQuery('#pp_notiftype_none_div').hide();" <?php echo ($this -> get_option('pp_notiftype') == "IPN") ? 'checked="checked"' : ''; ?> type="radio" name="pp_notiftype" value="IPN" id="pp_notiftype_IPN" /> <?php _e('IPN', $this -> plugin_name); ?> <?php _e('(recommended)', $this -> plugin_name); ?></label>
				<label><input onclick="if (!confirm('<?php echo __('IMPORTANT:\n\nWith Regular POST, data will be received from PayPal as the customer returns to your site.\n\nIf your return URL is not SSL (https), a warning will display which could prevent the POST data.\n\nIt is recommended that you use SSL (https) for this setting.', $this -> plugin_name); ?>')) { return false; } jQuery('#pp_notiftype_none_div').show(); jQuery('#pp_notiftype_IPN_div').hide();" <?php echo ($this -> get_option('pp_notiftype') == "none") ? 'checked="checked"' : ''; ?> type="radio" name="pp_notiftype" value="none" id="pp_notiftype_none" /> <?php _e('Regular POST', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Choose your preferred notification type for PayPal payments.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>
        
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>pp_sandbox"><?php _e('PayPal Sandbox', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('pp_sandbox') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="pp_sandbox" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('pp_sandbox') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="pp_sandbox" value="N" id="<?php echo $this -> pre; ?>pp_sandbox" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('For testing purposes', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>