<table class="form-table">
	<tbody>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>cart_addajax"><?php _e('Add to cart Ajax', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#addajaxdiv').show();" id="<?php echo $this -> pre; ?>cart_addajax" <?php echo (!$this -> get_option('cart_addajax') || $this -> get_option('cart_addajax') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="cart_addajax" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#addajaxdiv').hide();" <?php echo ($this -> get_option('cart_addajax') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="cart_addajax" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Ensure that you have the shopping cart widget active under Appearance > Widgets.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>

<div id="addajaxdiv" style="display:<?php echo ($this -> get_option('cart_addajax') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="cart_summary_overlay_Y"><?php _e('Order Summary Popup', $this -> plugin_name); ?></label></th>
				<td>
					<label><input onclick="jQuery('#cartsummarydiv').show();" <?php echo ($this -> get_option('cart_summary_overlay') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="cart_summary_overlay" value="Y" id="cart_summary_overlay_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
					<label><input onclick="jQuery('#cartsummarydiv').hide();" <?php echo ($this -> get_option('cart_summary_overlay') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="cart_summary_overlay" value="N" id="cart_summary_overlay_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('Turn this on to display a summary of the cart/order when a product is added to the cart.', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div id="cartsummarydiv" style="display:<?php echo ($this -> get_option('cart_summary_overlay') == "Y") ? 'block' : 'none'; ?>;">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="cart_summary_error_N"><?php _e('Show on Error', $this -> plugin_name); ?></label></th>
					<td>
						<label><input <?php echo ($this -> get_option('cart_summary_error') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="cart_summary_error" value="Y" id="cart_summary_error_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
						<label><input <?php echo ($this -> get_option('cart_summary_error') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="cart_summary_error" value="N" id="cart_summary_error_N" /> <?php _e('No', $this -> plugin_name); ?></label>
						<span class="howto"><?php _e('Should the popup be shown on error as well, displaying the error messages and current order summary?', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="cart_scrollajax_Y"><?php _e('Scroll to Widget', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($this -> get_option('cart_scrollajax') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="cart_scrollajax" value="Y" id="cart_scrollajax_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
					<label><input <?php echo ($this -> get_option('cart_scrollajax') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="cart_scrollajax" value="N" id="cart_scrollajax_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('Scroll to the shopping cart widget as product(s) are added?', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>cart_continuelink"><?php _e('Continue Shopping Link', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo (!$this -> get_option('cart_continuelink') || $this -> get_option('cart_continuelink') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="cart_continuelink" value="Y" id="<?php echo $this -> pre; ?>cart_continuelink" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('cart_continuelink') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="cart_continuelink" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Shop URL setting will be used for this link.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>