<table class="form-table">
	<tr>
		<th><label for="<?php echo $this -> pre; ?>gc_merchant_id"><?php _e('Merchant ID', $this -> plugin_name); ?></label></th>
		<td><input type="text" id="<?php echo $this -> pre; ?>gc_merchant_id" class="widefat" name="gc_merchant_id" value="<?php echo $this -> get_option('gc_merchant_id'); ?>" /></td>
	</tr>
	<tr>
		<th><label for="<?php echo $this -> pre; ?>gc_merchant_key"><?php _e('Merchant Key', $this -> plugin_name); ?></label></th>
		<td><input type="text" id="<?php echo $this -> pre; ?>gc_merchant_key" class="widefat" name="gc_merchant_key" value="<?php echo $this -> get_option('gc_merchant_key'); ?>" /></td>
	</tr>
	<tr>
		<th><label for="<?php echo $this -> pre; ?>gc_sandboxN"><?php _e('Use Sandbox', $this -> plugin_name); ?></label></th>
		<td>
			<label><input <?php echo ($this -> get_option('gc_sandbox') && $this -> get_option('gc_sandbox') == "Y") ? 'checked="checked"' : ''; ?> id="<?php echo $this -> pre; ?>gc_sandboxY" type="radio" name="gc_sandbox" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
			<label><input <?php echo ($this -> get_option('gc_sandbox') && $this -> get_option('gc_sandbox') == "N") ? 'checked="checked"' : ''; ?> id="<?php echo $this -> pre; ?>gc_sandboxN" type="radio" name="gc_sandbox" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
			<span class="howto"><?php _e('turn on for testing purposes', $this -> plugin_name); ?></span>
		</td>
	</tr>
</table>