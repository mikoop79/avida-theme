<table class="form-table">
	<tbody>
		<tr>
			<th><label for=""><?php _e('Payment Method Name', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="ematters_title" value="<?php echo esc_attr(stripslashes($this -> get_option('ematters_title'))); ?>" id="ematters_title" />
			</td>
		</tr>
		<tr>
			<th><label for="ematters_merchantid"><?php _e('Merchant ID', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="ematters_merchantid" value="<?php echo esc_attr(stripslashes($this -> get_option('ematters_merchantid'))); ?>" id="ematters_merchantid" />
			</td>
		</tr>
		<tr>
			<th><label for="ematters_bank"><?php _e('Bank', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="ematters_bank" value="<?php echo esc_attr(stripslashes($this -> get_option('ematters_bank'))); ?>" id="ematters_bank" />
			</td>
		</tr>
		<tr>
			<th><label for="ematters_readers"><?php _e('Readers', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="ematters_readers" value="<?php echo esc_attr(stripslashes($this -> get_option('ematters_readers'))); ?>" id="ematters_readers" />
			</td>
		</tr>
		<tr>
			<th><label for="ematters_bracket_N"><?php _e('Block Bracket', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('ematters_bracket') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="ematters_bracket" value="Y" id="ematters_bracket_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('ematters_bracket') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="ematters_bracket" value="N" id="ematters_bracket_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('some eMatters accounts require an opening block bracket prepended to the return URL.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>