<?php $bwdetails = $this -> get_option('bwdetails', false); ?>							
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>bwdetails_beneficiary"><?php _e('Beneficiary Name', $this -> plugin_name); ?></label></th>
			<td><input type="text" name="bwdetails[beneficiary]" id="<?php echo $this -> pre; ?>bwdetails_beneficiary" class="widefat" value="<?php echo $bwdetails['beneficiary']; ?>" /></td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>bwdetails_name"><?php _e('Bank Name', $this -> plugin_name); ?></label></th>
			<td><input type="text" name="bwdetails[name]" id="<?php echo $this -> pre; ?>bwdetails_name" class="widefat" value="<?php echo $bwdetails['name']; ?>" /></td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>bwdetails_phone"><?php _e('Bank Phone Number', $this -> plugin_name); ?></label></th>
			<td><input type="text" name="bwdetails[phone]" id="<?php echo $this -> pre; ?>bwdetails_phone" class="widefat" value="<?php echo $bwdetails['phone']; ?>" /></td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>bwdetails_address"><?php _e('Bank Address', $this -> plugin_name); ?></label></th>
			<td><textarea name="bwdetails[address]" id="<?php echo $this -> pre; ?>bwdetails_address" class="widefat" rows="5"><?php echo $bwdetails['address']; ?></textarea></td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>bwdetails_account"><?php _e('Bank Account Number', $this -> plugin_name); ?></label></th>
			<td><input type="text" name="bwdetails[account]" id="<?php echo $this -> pre; ?>bwdetails_account" class="widefat" value="<?php echo $bwdetails['account']; ?>" /></td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>bwdetails_swift"><?php _e('Bank SWIFT Code (Routing Number)', $this -> plugin_name); ?></label></th>
			<td><input type="text" name="bwdetails[swift]" id="<?php echo $this -> pre; ?>bwdetails_swift" class="widefat" value="<?php echo $bwdetails['swift']; ?>" /></td>
		</tr>
	</tbody>
</table>