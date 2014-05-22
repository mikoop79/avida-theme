<table class="form-table">
	<tbody>
		<tr>
			<th><label for="affiliatecode"><?php _e('Affiliate Code', $this -> plugin_name); ?></label></th>
			<td>
				<label><textarea name="affiliatecode" id="affiliatecode" rows="8" class="widefat"><?php echo esc_attr(stripslashes($this -> get_option('affiliatecode'))); ?></textarea></label>
			</td>
		</tr>
		<tr>
			<th><label for="affiliatesalecode"><?php _e('Affiliate Sale Code', $this -> plugin_name); ?></label></th>
			<td>
				<label><textarea name="affiliatesalecode" id="affiliatesalecode" rows="8" class="widefat"><?php echo esc_attr(stripslashes($this -> get_option('affiliatesalecode'))); ?></textarea></label>
			</td>
		</tr>
	</tbody>
</table>