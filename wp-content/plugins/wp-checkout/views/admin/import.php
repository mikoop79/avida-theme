<div class="wrap">
	<h2><?php _e('Import Products', $this -> plugin_name); ?></h2>
	
	<form action="" method="post" id="importform" enctype="multipart/form-data">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="csv"><?php _e('CSV File', $this -> plugin_name); ?></label></th>
					<td>
						<input style="width:auto;" class="widefat" id="csv" type="file" name="csv" />
					</td>
				</tr>
			</tbody>
		</table>
		
		<p class="submit">
			<input type="submit" name="submit" value="<?php _e('Import CSV', $this -> plugin_name); ?>" class="button-primary" />
		</p>
	</form>
</div>