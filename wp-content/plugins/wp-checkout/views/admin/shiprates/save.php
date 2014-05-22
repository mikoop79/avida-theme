<script type="text/javascript">
var wpcoajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Save a Shipping Rate', $this -> plugin_name); ?></h2>
	
	<form action="" method="">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="wpcoShiprate_shipmethod_id"><?php _e('Shipping Method', $this -> plugin_name); ?></label></th>
					<td>
						<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
						<?php if ($shipmethods = $wpcoDb -> find_all(false, false, array('order', "ASC"))) : ?>
							<select name="wpcoShiprate[shipmethod_id]" id="wpcoShiprate_shipmethod_id">
								<?php foreach ($shipmethods as $shipmethod) : ?>
									<option value="<?php echo $shipmethod -> id; ?>"><?php echo __($shipmethod -> name); ?></option>
								<?php endforeach; ?>
							</select>
							<span class="howto"><?php _e('Choose a shipping method to apply this rate to.', $this -> plugin_name); ?></span>
						<?php else : ?>
							<span class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available.', $this -> plugin_name); ?></span>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th><label for=""><?php _e('Shipping Country', $this -> plugin_name); ?></label></th>
					<td>
						<?php if ($countries = $Country -> select(true)) : ?>
							<select name="" id="">
								<?php foreach ($countries as $country_id => $country_name) : ?>
									<option value="<?php echo $country_id; ?>"><?php echo __($country_name); ?></option>
								<?php endforeach; ?>
							</select>
							<span class="howto"><?php _e('Choose the country to which this rate will apply specifically.', $this -> plugin_name); ?></span>
						<?php else : ?>
							<span class="<?php echo $this -> pre; ?>error"><?php _e('No countries are available.', $this -> plugin_name); ?></span>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th><label for=""><?php _e('Shipping State/Province', $this -> plugin_name); ?></label></th>
					<td>
					
					</td>
				</tr>
				<tr>
					<th><label for="wpcoShiprate_price"><?php _e('Shipping Price', $this -> plugin_name); ?></label></th>
					<td>
						<?php echo $wpcoHtml -> currency_html('<input type="text" name="wpcoShiprate[price]" value="" id="wpcoShiprate_price" class="widefat" style="width:65px;" />'); ?>
					</td>
				</tr>
			</tbody>
		</table>
	
		<p class="submit">
			<input type="button" onclick="jQuery.colorbox.close();" name="cancel" value="<?php _e('Cancel', $this -> plugin_name); ?>" class="button button-secondary" />
			<input type="submit" name="save" value="<?php _e('Save Shipping Rate', $this -> plugin_name); ?>" class="button button-primary" />
		</p>
	</form>
</div>