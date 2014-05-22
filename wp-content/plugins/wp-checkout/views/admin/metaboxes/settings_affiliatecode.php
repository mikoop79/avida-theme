ghghghghgh g ghhghg hhg hghg 
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="affiliatecode"><?php _e('Affiliate Code', $this -> plugin_name); ?></label></th>
			<td>
				<label><textarea name="affiliatecode"><?php echo esc_attr(stripslashes($this -> get_option('affiliatecode'))); ?></textarea></label>
			</td>
		</tr>
	</tbody>
</table>