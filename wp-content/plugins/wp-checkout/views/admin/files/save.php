<div class="wrap">
	<h2><?php _e('Save a File', $this -> plugin_name); ?></h2>
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post" id="fileform" enctype="multipart/form-data">
		<?php echo $wpcoForm -> hidden('File.id'); ?>
	
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="File.title"><?php _e('Title', $this -> plugin_name); ?></label></th>
					<td><?php echo $wpcoForm -> text('File.title'); ?></td>
				</tr>
				<tr>
					<th><label for="File.product_id"><?php _e('Product', $this -> plugin_name); ?></label></th>
					<td>
						<?php $products = $Product -> select(); ?>
						<?php echo $wpcoForm -> select('File.product_id', $products); ?>
						<span class="howto"><?php _e('file will be available for download when this product is ordered and paid for', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="File.typefile"><?php _e('Type', $this -> plugin_name); ?></label></th>
					<td>
						<?php $types = array('file' => __('File Upload', $this -> plugin_name), 'link' => __('Download Link/URL', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('File.type', $types, array('separator' => false, 'default' => "file", 'onclick' => "change_type(this.value);")); ?>
						
						<script type="text/javascript">
						function change_type(type) {
							jQuery('#<?php echo $this -> pre; ?>linkdiv').hide();
							jQuery('#<?php echo $this -> pre; ?>filediv').hide();
							
							if (type != "") {
								jQuery('#<?php echo $this -> pre; ?>' + type + 'div').show();
								
								if (type == "file") {
									jQuery('#fileform').attr('enctype', 'multipart/form-data');
								} else if (type == "link") {
									jQuery('#fileform').removeAttr('enctype');
								}
							}
						}
						</script>
						
						<span class="howto"><?php _e('upload a file or specify a file url/link', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="<?php echo $this -> pre; ?>linkdiv" style="display:<?php echo ($wpcoHtml -> field_value('File.type') == "link") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="File.url"><?php _e('File URL', $this -> plugin_name); ?></label></th>
						<td>
							<?php echo $wpcoForm -> text('File.url'); ?>
							<span class="howto"><?php _e('customers will be provided with this link to download their file', $this -> plugin_name); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div id="<?php echo $this -> pre; ?>filediv" style="display:<?php echo ($wpcoHtml -> field_value('File.type') == "" || $wpcoHtml -> field_value('File.type') == "file") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="File.file"><?php _e('Choose File', $this -> plugin_name); ?></label></th>
						<td>
							<?php echo $wpcoForm -> file('File.file'); ?>
							<span class="howto"><?php _e('files will be securely and discreetly pushed to the customers browser', $this -> plugin_name); ?></span>
							
							<?php if (!empty($File -> data -> filename) && empty($File -> errors['file'])) : ?>
								<br/>
								<b><?php _e('Current File'); ?> :</b><br/>
								<?php echo $wpcoHtml -> link($File -> data -> filename, get_option('siteurl') . '/wp-content/uploads/' . $this -> plugin_name . '/downloads/' . $File -> data -> filename, array('target' => '_blank')); ?>
								<span class="howto"><?php _e('leave blank for no changes', $this -> plugin_name); ?></span>
								
								<?php echo $wpcoForm -> hidden('File.oldfile', array('value' => $File -> data -> filename)); ?>
								<?php echo $wpcoForm -> hidden('File.oldsize', array('value' => $File -> data -> filesize)); ?>
								<?php echo $wpcoForm -> hidden('File.oldtype', array('value' => $File -> data -> filetype)); ?>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save File', $this -> plugin_name)); ?>
		</p>
	</form>
</div>