<table class="form-table">
	<tbody>
		<tr>
			<th><label for="cu_title"><?php _e('Title', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" class="widefat" name="cu_title" value="<?php echo esc_attr($this -> get_option('cu_title')); ?>" id="cu_title" />
				<span class="howto"><?php _e('title/name of the custom/manual checkout as it will appear to your customers', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="cu_message"><?php _e('Custom Message/Instructions', $this -> plugin_name); ?></label></th>
			<td>			
				<textarea class="widefat" rows="4" name="cu_message" id="cu_message"><?php echo stripslashes($this -> get_option('cu_message')); ?></textarea>
				<span class="howto"><?php _e('your customers will be presented with this message upon checkout', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="cu_zerototal_Y"><?php _e('Zero Total Orders', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('cu_zerototal') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="cu_zerototal" value="Y" id="cu_zerototal_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('cu_zerototal') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="cu_zerototal" value="N" id="cu_zerototal_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Zero (0.00) orders will automatically go through this payment method if turned On.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="cu_markpaid_N"><?php _e('Mark as Paid', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('cu_markpaid') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="cu_markpaid" value="Y" id="cu_markpaid_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('cu_markpaid') == "N") ? 'checked="checked"' : ''; ?>type="radio" name="cu_markpaid" value="N" id="cu_markpaid_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Should orders through the custom/manual payment method automatically be marked as paid?', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>