<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Import Products', $this -> plugin_name); ?></h2>
	
	<?php if (!empty($errors) && is_array($errors)) : ?>
		<?php foreach ($errors as $err) : ?>
			<span style="color:red;"><?php echo $err; ?></span><br/>
		<?php endforeach; ?>
	<?php endif; ?>
	
	<form action="?page=<?php echo $this -> sections -> import_csv; ?>" enctype="multipart/form-data" method="post" id="<?php echo $this -> sections -> import_csv; ?>">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="source_csv"><?php _e('Source', $this -> plugin_name); ?></label></th>
					<td>
						<label><input <?php echo (!empty($_POST['source']) && $_POST['source'] == "oscommerce") ? 'checked="checked"' : ''; ?> onclick="jQuery('#csvfile_div').hide(); jQuery('#oscommerce_div').show();" type="radio" name="source" value="oscommerce" id="source_oscommerce" /> <?php _e('osCommerce Database', $this -> plugin_name); ?></label><br/>
						<label><input <?php echo (!empty($_POST['source']) && $_POST['source'] == "csvfile") ? 'checked="checked"' : ''; ?> onclick="jQuery('#oscommerce_div').hide(); jQuery('#csvfile_div').show();" type="radio" name="source" value="csvfile" id="source_csv" /> <?php _e('CSV File', $this -> plugin_name); ?></label>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="oscommerce_div" style="display:<?php echo (!empty($_POST['source']) && $_POST['source'] == "oscommerce") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="oscommerce_imagesurl"><?php _e('URL to osCommerce images', $this -> plugin_name); ?></label></th>
						<td>
							<input type="text" style="width:300px;" name="oscommerce[imagesurl]" value="<?php echo esc_attr(stripslashes($_POST['oscommerce']['imagesurl'])); ?>" id="oscommerce_imagesurl" />
							<span class="howto"><?php _e('eg. http://domain.com/images/', $this -> plugin_name); ?></span>
						</td>
					</tr>
					<tr>
						<th><label for="oscommerce_host"><?php _e('Database Host', $this -> plugin_name); ?></label></th>
						<td>
							<input type="text" name="oscommerce[host]" value="<?php echo esc_attr(stripslashes($_POST['oscommerce']['host'])); ?>" id="oscommerce_host" />
							<span class="howto"><?php _e('this will most likely be: localhost', $this -> plugin_name); ?></span>
						</td>
					</tr>
					<tr>
						<th><label for="oscommerce_db"><?php _e('Database Name', $this -> plugin_name); ?></label></th>
						<td>
							<input type="text" name="oscommerce[db]" value="<?php echo esc_attr(stripslashes($_POST['oscommerce']['db'])); ?>" id="oscommerce_db" />
						</td>
					</tr>
					<tr>
						<th><label for="oscommerce_user"><?php _e('Database Username', $this -> plugin_name); ?></label></th>
						<td>
							<input type="text" name="oscommerce[user]" value="<?php echo esc_attr(stripslashes($_POST['oscommerce']['user'])); ?>" id="oscommerce_user" />
						</td>
					</tr>
					<tr>
						<th><label for="oscommerce_pass"><?php _e('Database Password', $this -> plugin_name); ?></label></th>
						<td>
							<input type="text" name="oscommerce[pass]" value="<?php echo esc_attr(stripslashes($_POST['oscommerce']['pass'])); ?>" id="oscommerce_pass" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="csvfile_div" style="display:<?php echo (!empty($_POST['source']) && $_POST['source'] == "csvfile") ? 'block' : 'none'; ?>;">	
			<p>
				<strong><?php _e('Download the sample file:', $this -> plugin_name); ?></strong> <a href="<?php echo $this -> url(); ?>/includes/products.csv">products.csv</a>
			</p>
		
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="csv"><?php _e('CSV File', $this -> plugin_name); ?></label></th>
						<td>
							<input id="csv" type="file" name="csv" value="" />
							<span class="howto"><?php _e('Comma separated values file.', $this -> plugin_name); ?></span>	
						</td>
					</tr>
					<tr>
						<th><label for="delimiter_1"><?php _e('Delimiter', $this -> plugin_name); ?></label></th>
						<td>
							<label><input checked="checked" type="radio" name="delimiter" value="," id="delimiter_1" /> ,</label><br/>
							<label><input type="radio" name="delimiter" value=";" id="delimiter_2" /> ;</label><br/>
							<label><input type="radio" name="delimiter" value="|" id="delimiter_3" /> |</label>
							<span class="howto"><?php _e('Open your CSV file as a text file to see with what the fields/values are delimited.', $this -> plugin_name); ?></span>
						</td>
					</tr>
					<?php /*
					<tr>
						<th><label for="csvheadings_N"><?php _e('CSV Headings', $this -> plugin_name); ?></label></th>
						<td>
							<label><input <?php echo (!empty($_POST['csvheadings']) && $_POST['csvheadings'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="csvheadings" value="Y" id="csvheadings_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
							<label><input <?php echo (empty($_POST['csvheadings']) || (!empty($_POST['csvheadings']) && $_POST['csvheadings'] == "N")) ? 'checked="checked"' : ''; ?> type="radio" name="csvheadings" value="N" id="csvheadings_N" /> <?php _e('No', $this -> plugin_name); ?></label>
							<span class="howto"><?php _e('Is the first row/record of the CSV headings?', $this -> plugin_name); ?></span>
						</td>
					</tr>
					*/ ?>
					<tr>
						<th><label for=""><?php _e('Fields', $this -> plugin_name); ?></label></th>
						<td>
							<p class="howto">
								<?php _e('Tick/check the fields which are available in your CSV file that you are uploading.', $this -> plugin_name); ?><br/>
								<?php _e('Fill in only column numbers (no letters), where "1" is the first column in your CSV file.', $this -> plugin_name); ?>
							</p>
							
							<div class="scroll-list">
								<table class="form-table" style="width:100%;">
									<tbody>
										<?php
										
										include $this -> plugin_base() . DS . 'includes' . DS . 'variables.php';
									
										if (empty($_POST)) {
											$p = 1;
										
											foreach ($import_fields as $field_slug => $field) {
												$_POST['fields'][$field_slug] = true;
												$_POST['columns'][$field_slug] = $p;
												$p++;
											}
										}
									
										?>
										<?php if (!empty($import_fields)) : ?>
											<?php foreach ($import_fields as $field_slug => $field) : ?>
												<tr>
													<th style="width:50%;">
														<label><input <?php echo (!empty($_POST['fields'][$field_slug])) ? 'checked="checked"' : ''; ?> onclick="jQuery('#columns_<?php echo $field_slug; ?>_span').toggle();" type="checkbox" name="fields[<?php echo $field_slug; ?>]" value="1" id="fields_<?php echo $field_slug; ?>" /> <?php echo $field['title']; ?> <?php echo (!empty($field['required'])) ? '<sup style="color:red;">' . __('required', $this -> plugin_name) . '</sup>' : ''; ?></label>
														<?php if (!empty($field['description'])) : ?><small class="howto"><?php echo $field['description']; ?></small><?php endif; ?>
													</th>
													<td>
														<span id="columns_<?php echo $field_slug; ?>_span" style="display:<?php echo (!empty($_POST['fields'][$field_slug])) ? 'block' : 'none'; ?>;">
															<label><strong><?php _e('Column Number:', $this -> plugin_name); ?></strong> <input type="text" style="width:45px;" name="columns[<?php echo $field_slug; ?>]" value="<?php echo esc_attr(stripslashes($_POST['columns'][$field_slug])); ?>" id="columns_<?php echo $field_slug; ?>" /></label>
															<?php if ($field_slug == "image") : ?>
																<br/>
																<br/>
																
																<div id="extraimages"></div>
																
																<p><a class="button-secondary" href="" onclick="import_add_image(); return false;"><?php _e('Add Another Image', $this -> plugin_name); ?></a></p>
																
																<label>
																	<strong><?php _e('Image Prepend URL:', $this -> plugin_name); ?></strong>
																	<input type="text" name="imageprependurl" value="<?php echo esc_attr(stripslashes($_POST['imageprependurl'])); ?>" id="imageprependurl" />
																</label>
																<small class="howto"><?php _e('If your sheet only contains image names and not full URLs, you can use this to prepend all image names.', $this -> plugin_name); ?></small>
															<?php endif; ?>
														</span>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<p class="submit">
			<input class="button-primary" type="submit" name="submit" value="<?php _e('Import Products', $this -> plugin_name); ?>" />
		</p>
	</form>
</div>

<script type="text/javascript">
var imagecount = 1;

function import_add_image() {
	html = '<p id="pextraimage' + imagecount + '"><?php _e('Extra Image', $this -> plugin_name); ?> ' + imagecount + ' <small>(<a href="" onclick="if (confirm(\'<?php _e('Are you sure you want to remove this extra image?', $this -> plugin_name); ?>\')) { import_remove_image(\'' + imagecount + '\'); } return false;">remove</a>)</small><br/><label><strong><?php _e('Column Number:', $this -> plugin_name); ?></strong> <input type="text" name="extraimages[' + imagecount + ']" value="" id="extraimages' + imagecount + '" /></label></p>';
	
	jQuery('#extraimages').append(html);
	imagecount++;
}

function import_remove_image(image) {
	jQuery('#pextraimage' + image).remove();
}
</script>
