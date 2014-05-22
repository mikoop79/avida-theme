<table class="form-table">
	<tbody>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>enablecoupons"><?php _e('Enable Coupons', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('enablecoupons') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="enablecoupons" value="Y" onclick="jQuery('#couponsdiv').show();" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input id="<?php echo $this -> pre; ?>enablecoupons" <?php echo (!$this -> get_option('enablecoupons') || $this -> get_option('enablecoupons') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="enablecoupons" value="N" onclick="jQuery('#couponsdiv').hide();" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
	</tbody>
</table>

<div id="couponsdiv" style="display:<?php echo ($this -> get_option('enablecoupons') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="<?php echo $this -> pre; ?>multicoupon"><?php _e('Allow multiple coupons per order', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($this -> get_option('multicoupon') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="multicoupon" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
					<label><input id="<?php echo $this -> pre; ?>multicoupon" <?php echo ($this -> get_option('multicoupon') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="multicoupon" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
				</td>
			</tr>
            <tr>
            	<th><label for="couponsaffectts_N"><?php _e('Affect Tax &amp; Shipping?', $this -> plugin_name); ?></label></th>
                <td>
                	<label><input <?php echo ($this -> get_option('couponsaffectts') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="couponsaffectts" value="Y" id="couponsaffectts_Y" /> <?php _e('Yes, calculate discount before Tax &amp; Shipping', $this -> plugin_name); ?></label><br/>
                    <label><input <?php echo ($this -> get_option('couponsaffectts') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="couponsaffectts" value="N" id="couponsaffectts_N" /> <?php _e('No, do not let discount affect Tax &amp; Shipping', $this -> plugin_name); ?></label>
                	<span class="howto"><?php _e('Should tax and shipping be calculated on top of discount coupon calculation or not, only on the subtotal?', $this -> plugin_name); ?></span>
                </td>
            </tr>
		</tbody>
	</table>
</div>