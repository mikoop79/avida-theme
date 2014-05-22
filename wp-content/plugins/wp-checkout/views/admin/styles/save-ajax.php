<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Save a Product Variation', $this -> plugin_name); ?></h2>
	
	<?php $this -> render('errors', array('errors' => $errors), true, 'admin'); ?>
	
	<form action="" id="newvariationoptionform" method="post" onsubmit="save_variationoptions('<?php echo $_GET['product_id']; ?>'); return false;">
		<?php if (!empty($_POST['newvariation']['id'])) : ?>
			<input type="hidden" name="newvariation[id]" value="<?php echo esc_attr(stripslashes($_POST['newvariation']['id'])); ?>" />
		<?php endif; ?>
		
	    <p>
	        <label>
	            <strong><?php _e('Variation Title:', $this -> plugin_name); ?></strong><br/>
	            <input type="text" name="newvariation[title]" value="<?php echo esc_attr(stripslashes($_POST['newvariation']['title'])); ?>" id="newvariation_title" />
	        </label>
	    </p>
	    
	    <p>
	        <label>
	            <strong><?php _e('Variation Type:', $this -> plugin_name); ?></strong><br/>
	            <select name="newvariation[type]" id="newvariation_type">
	                <option value=""><?php _e('- Select Type -', $this -> plugin_name); ?></option>
	                <option <?php echo (!empty($_POST['newvariation']['type']) && $_POST['newvariation']['type'] == "select") ? 'selected="selected"' : ''; ?> value="select"><?php _e('Select Drop Down', $this -> plugin_name); ?></option>
	                <option <?php echo (!empty($_POST['newvariation']['type']) && $_POST['newvariation']['type'] == "radio") ? 'selected="selected"' : ''; ?> value="radio"><?php _e('Radio Buttons', $this -> plugin_name); ?></option>
	                <option <?php echo (!empty($_POST['newvariation']['type']) && $_POST['newvariation']['type'] == "checkbox") ? 'selected="selected"' : ''; ?> value="checkbox"><?php _e('Checkbox List', $this -> plugin_name); ?></option>
	            </select>
	        </label>
	    </p>
	    
	    <p>
	        <label>
	            <strong><?php _e('Variation Caption/Description:', $this -> plugin_name); ?></strong><br/>
	            <textarea name="newvariation[caption]" id="newvariation_caption" rows="2" cols="45"><?php echo esc_attr(stripslashes($_POST['newvariation']['caption'])); ?></textarea>
	            <span class="howto"><?php _e('Optional. Give this variation a descriptive caption/notation for your customers to see.', $this -> plugin_name); ?></span>
	        </label>
	    </p>
	    
	    <p>
	        <span class="howto"><?php _e('You must add options to this product variation below.', $this -> plugin_name); ?></span>
	        <div id="newoptions">
	        	<!-- options go here -->
	        	<?php $optioncount = 1; ?>
	        	<?php if (!empty($_POST['newvariation']['options'])) : ?>
	        		<?php foreach ($_POST['newvariation']['options'] as $option) : ?>
	        			<?php $option = (array) $option; ?>
	        			<input type="hidden" name="newoptions[<?php echo $optioncount; ?>][id]" value="<?php echo $option['id']; ?>" />
	        			<div id="newoption<?php echo $optioncount; ?>">
							<fieldset>
								<legend style="font-weight:bold;"><?php _e('Variation Option', $this -> plugin_name); ?></legend>
								<table>
									<tbody>
										<tr>
											<td>
											<?php _e('Option Title/Name:', $this -> plugin_name); ?><br/>
											<input type="text" name="newoptions[<?php echo $optioncount; ?>][title]" value="<?php echo esc_attr(stripslashes($option['title'])); ?>" id="newoptions_<?php echo $optioncount; ?>_title" />
											</td>
											<td style="width:10px;"></td>
											<td>
											<?php _e('Option Price:', $this -> plugin_name); ?><br/>	
											<select name="newoptions[<?php echo $optioncount; ?>][symbol]">
												<option <?php echo (empty($option['symbol']) || (!empty($option['symbol']) && $option['symbol'] == "+")) ? 'selected="selected"' : ''; ?> value="+">+</option>
												<option <?php echo (!empty($option['symbol']) && $option['symbol'] == "-") ? 'selected="selected"' : ''; ?> value="-">-</option>
											</select>									
											<select name="newoptions[<?php echo $optioncount; ?>][operator]">
												<option <?php echo (!empty($option['operator']) && $option['operator'] == "curr") ? 'selected="selected"' : ''; ?> value="curr"><?php echo $wpcoHtml -> currency(); ?></option>
												<option <?php echo (!empty($option['operator']) && $option['operator'] == "perc") ? 'selected="selected"' : ''; ?> value="perc">&#37;</option>
											</select>
											
											<input type="text" name="newoptions[<?php echo $optioncount; ?>][price]" value="<?php echo esc_attr(stripslashes($option['price'])); ?>" id="newoptions_<?php echo $optioncount; ?>_price" style="width:65px;" />
											</td>
										</tr>
									</tbody>
								</table>
								<a href="" onclick="if (confirm('<?php _e('Are you sure you want to remove this option?', $this -> plugin_name); ?>')) { delete_option('<?php echo $optioncount; ?>', '<?php echo $option['id']; ?>'); } return false;"><?php _e('Remove this option', $this -> plugin_name); ?></a><br/><br/>
							</fieldset>
						</div>
						
						<?php $optioncount++; ?>
	        		<?php endforeach; ?>
	        	<?php endif; ?>
	        </div>
	    
	        <h5><a href="" onclick="add_variationoption('', ''); jQuery.colorbox.resize(); return false;"><?php _e('+ Add an option to this variation', $this -> plugin_name); ?></a></h5>
	        
	        <script type="text/javascript">
			jQuery(document).ready(function() {
				<?php if (!empty($_POST['newoptions'])) : ?>
					<?php foreach ($_POST['newoptions'] as $option) : ?>
						add_variationoption('<?php echo $option['title']; ?>', '<?php echo $option['price']; ?>');
					<?php endforeach; ?>
				<?php endif; ?>
			});
			
			var optioncount = '<?php echo ($optioncount); ?>';
			</script>
	    </p>
	    
	    <p>
	    	<input type="button" class="button-secondary button" onclick="jQuery.colorbox.close();" name="cancel" value="<?php _e('Cancel', $this -> plugin_name); ?>" />
	        <input type="submit" class="button-primary button" name="savevariationoption" value="<?php _e('Save Variation', $this -> plugin_name); ?>" />
	        <span id="variationoptionloading" style="display:none;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" alt="loading" /></span>
	    </p>
	</form>
	
	<style type="text/css">
	#TB_window {
		width: 650px !important;
		height: 550px !important;
		margin-top: 25px !important;	
	}
	</style>
</div>