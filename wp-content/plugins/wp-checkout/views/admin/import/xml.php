<div class="wrap">
	<h2><?php _e('Import XML', $this -> plugin_name); ?></h2>
	
	<?php if (!empty($data['xml'])) : ?>
		<?php $this -> debug($data['xml']); ?>
	<?php endif; ?>
	
	<form action="" method="post" enctype="multipart/form-data">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="xml"><?php _e('XML File URL', $this -> plugin_name); ?></label></th>
					<td>
						<input type="text" class="widefat" name="xml" value="<?php echo esc_attr(stripslashes($_POST['xml'])); ?>" id="xml" />
						<span class="howto"><?php _e('Absolute URL to the XML feed, eg. https://secure.domain.com/zutAfrach4n7cef_download.cfm', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<p class="submit">
			<input class="button-primary" type="submit" name="submit" value="<?php _e('Import XML', $this -> plugin_name); ?>" />
		</p>
	</form>
</div>