<!-- Shipping Rates -->

<?php

$wpcoDb -> model = $wpcoShiprate -> model;
$shiprates = $wpcoDb -> find_all();

?>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="shipping_appendshiprate_N"><?php _e('Shipping Rates Calculation', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('shipping_appendshiprate') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="shipping_appendshiprate" value="Y" id="shipping_appendshiprate_Y" /> <?php _e('Append', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('shipping_appendshiprate') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="shipping_appendshiprate" value="N" id="shipping_appendshiprate_N" /> <?php _e('Override', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Should the shipping rate below be appended to shipping or override shipping completely?', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><?php _e('Shipping Rates', $this -> plugin_name); ?></th>
			<td>
				<table id="shiprates" class="shiprates widefat">
					<thead>
						<tr>
							<th style="width:30px;"><input style="padding:0 8px; margin:0;" type="button" name="addrow" class="button addrow" value="+" /></th>
							<th style="width:150px;"><?php _e('Shipmethod', $this -> plugin_name); ?></th>
							<th style="width:300px;"><?php _e('Country/State', $this -> plugin_name); ?></th>
							<th style="width:75px;"><?php _e('Price', $this -> plugin_name); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr id="sample" style="display:none;">
							<td>
								<input type="button" class="delrow button" value="-" />
							</td>
							<td>
								<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
								<?php if ($shipmethods = $wpcoDb -> find_all(false, false, array('name', "ASC"))) : ?>
									<select name="shiprates[shipmethod][]" id="" class="shipmethod">
										<option value=""><?php _e('- Select -', $this -> plugin_name); ?></option>
										<?php foreach ($shipmethods as $shipmethod) : ?>
											<?php if (empty($shipmethod -> api)) : ?>
												<option value="<?php echo $shipmethod -> id; ?>"><?php echo __($shipmethod -> name); ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								<?php else : ?>
									<span class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available.', $this -> plugin_name); ?></span>
								<?php endif; ?>
							</td>
							<td>
								<?php if ($countries = $Country -> select(true)) : ?>
									<select name="shiprates[country][]" id="" class="country">
										<option value=""><?php _e('- Select -', $this -> plugin_name); ?></option>
										<?php foreach ($countries as $country_id => $country_name) : ?>
											<option value="<?php echo $country_id; ?>"><?php echo __($country_name); ?></option>
										<?php endforeach; ?>
									</select>
									<span class="state">
										
									</span>
								<?php else : ?>
									<span class="<?php echo $this -> pre; ?>error"><?php _e('No countries are available.', $this -> plugin_name); ?></span>
								<?php endif; ?>
							</td>
							<td nowrap="nowrap" style="white-space:nowrap;">
								<select class="pricetype" name="shiprates[pricetype][]" style="width:auto;">
									<option value="curr"><?php echo $wpcoHtml -> currency(); ?></option>
									<option value="perc">&#37;</option>
								</select>
								<input type="text" name="shiprates[price][]" value="" id="" class="price widefat" style="width:65px;" />
							</td>
						</tr>
					</tbody>
				</table>
				<span class="howto"><?php _e('Specify shipping rates by shipping method, country and/or state to override any fixed or tiered shipping price for the shipping method if the user chooses this country or country/state combination on the shipping step of checkout.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#shiprates .addrow').live('click', shiprates_addrow);
	
	jQuery('#shiprates .delrow').live('click', function() {
		jQuery(this).closest('tr').remove(); 
	});
	
	jQuery('#shiprates .country').live('change', function() {
		var column = jQuery(this).closest('td').find('.state');
		var cur_value = jQuery(column).find('.stateinput').attr('value');
		var country_id = jQuery(this).val();
		jQuery(column).html('<img src="<?php echo $this -> url(); ?>/images/loading.gif" />');
		jQuery.post(wpcoAjax + '?cmd=get_states_by_country', {country_id:country_id, showinput:false, inputname:"shiprates[state][]"}, function(response) {
			jQuery(column).html(response);
			if (cur_value != "") { jQuery(column).find('select.state').val(cur_value); }
		});	
	});
	
	<?php if (!empty($shiprates)) : ?>
		<?php foreach ($shiprates as $shiprate) : ?>
			var tr = shiprates_addrow();
			jQuery(tr).find('select.shipmethod').val('<?php echo $shiprate -> shipmethod_id; ?>');
			jQuery(tr).find('span.state').html('<input type="text" name="shiprates[state][]" class="stateinput" value="<?php echo $shiprate -> state; ?>" id="" />');
			jQuery(tr).find('select.country').val('<?php echo $shiprate -> country_id; ?>').trigger('change');
			jQuery(tr).find('input.price').val('<?php echo $shiprate -> price; ?>');
			jQuery(tr).find('select.pricetype').val('<?php echo $shiprate -> pricetype; ?>');
		<?php endforeach; ?>
	<?php endif; ?>
});

function shiprates_addrow() {
	var tr = jQuery('tr#sample').clone().removeAttr('style').removeAttr('id');
	jQuery('table#shiprates tbody').prepend(tr);
	return tr;
}
</script>

