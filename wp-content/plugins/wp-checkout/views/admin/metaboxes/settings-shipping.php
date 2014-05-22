

<table class="form-table">
	<tbody>
		<tr>
			<th><?php _e('Calculate Shipping', $this -> plugin_name); ?></th>
			<td>
				<label><input <?php echo ($this -> get_option('shippingcalc') == "Y") ? 'checked="checked"' : ''; ?> onclick="jQuery('#shippingtypesdiv').show();" type="radio" name="shippingcalc" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('shippingcalc') == "N") ? 'checked="checked"' : ''; ?> onclick="jQuery('#shippingtypesdiv').hide();" type="radio" name="shippingcalc" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<?php if ($this -> get_option('shippingdetails') == "N") : ?>
					<span class="howto" style="color:red;"><?php _e('please note that "Capture Shipping Details" need to be set to Yes for this to work.', $this -> plugin_name); ?></span>
				<?php endif; ?>
                <span class="howto"><?php _e('Shipping is only calculated for orders with tangible items in them.', $this -> plugin_name); ?></span>	
			</td>
		</tr>
	</tbody>
</table>

<div id="shippingtypesdiv" style="display:<?php echo ($this -> get_option('shippingcalc') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="weightm"><?php _e('Weight Measurement', $this -> plugin_name); ?></label></th>
				<td>
					<?php if ($weights = $this -> get_option('weights')) : ?>
						<?php $weightm = $this -> get_option('weightm'); ?>
						<select name="weightm" class="widefat" style="width:auto;">
							<option value="">- <?php _e('Select', $this -> plugin_name); ?> -</option>
							<?php foreach ($weights as $weight) : ?>
								<option <?php echo (!empty($weightm) && $weightm == $weight) ? 'selected="selected"' : ''; ?> value="<?php echo $weight; ?>"><?php echo $weight; ?> (<?php echo $wpcoHtml -> weight_name($weight); ?>)</option>
							<?php endforeach; ?>
						</select>
					<?php else : ?>
						<span class="<?php echo $this -> pre; ?>error"><?php _e('No weights available. Please reset configuration', $this -> plugin_name); ?></span>
					<?php endif; ?>
					<span class="howto"><?php _e('Global weight measurement for all products', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="weight_minimum"><?php _e('Minimum Weight', $this -> plugin_name); ?></label>
				<?php echo $wpcoHtml -> help(__('You may leave this setting empty or on 0 (zero). If you specify a value, it will be the global minimum weight required for all orders in order for customers to proceed to checkout. If the total weight of the order is small then this value, a notification will be displayed to the customer and they cannot proceed.', $this -> plugin_name)); ?></th>
				<td>
					<input type="text" class="widefat" style="width:65px;" name="weight_minimum" value="<?php echo esc_attr(stripslashes($this -> get_option('weight_minimum'))); ?>" id="weight_minimum" /> 
					<span class="howto"><?php _e('Set a minimum required weight on all orders in order for customers to proceed.', $this -> plugin_name); ?>
				</td>
			</tr>
        	<tr>
            	<th><label for="shipping_globalminimum_N"><?php _e('Global Minimum Shipping', $this -> plugin_name); ?></label></th>
                <td>
                	<label><input onclick="jQuery('#shipping_globalminimum_div').show();" <?php echo ($this -> get_option('shipping_globalminimum') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="shipping_globalminimum" value="Y" id="shipping_globalminimum_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
                    <label><input onclick="jQuery('#shipping_globalminimum_div').hide();" <?php echo ($this -> get_option('shipping_globalminimum') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="shipping_globalminimum" value="N" id="shipping_globalminimum_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
                	<span class="howto"><?php _e('Turn this on to apply a shipping total which will be applied automatically if calculated shipping total is less.', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div id="shipping_globalminimum_div" style="display:<?php echo ($this -> get_option('shipping_globalminimum') == "Y") ? 'block' : 'none'; ?>;">
    	<table class="form-table">
        	<tbody>
            	<tr>
                	<th><label for="shipping_minimum"><?php _e('Minimum Shipping Amount', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php echo $wpcoHtml -> currency_html('<input style="width:45px;" type="text" name="shipping_minimum" value="' . esc_attr(stripslashes($this -> get_option('shipping_minimum'))) . '" id="shipping_minimum" />'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <table class="form-table">
    	<tbody>
            <tr>
            	<th><label for="shippingmethodsdisplay_select"><?php _e('Shipping Methods Display', $this -> plugin_name); ?></label></th>
                <td>
                	<label><input <?php echo ($this -> get_option('shippingmethodsdisplay') == "radio") ? 'checked="checked"' : ''; ?> type="radio" name="shippingmethodsdisplay" value="radio" id="shippingmethodsdisplay_radio" /> <?php _e('Radio Buttons', $this -> plugin_name); ?></label>
                    <label><input <?php echo ($this -> get_option('shippingmethodsdisplay') == "select") ? 'checked="checked"' : ''; ?> type="radio" name="shippingmethodsdisplay" value="select" id="shippingmethodsdisplay_select" /> <?php _e('Select Drop Down', $this -> plugin_name); ?></label>
                	<span class="howto"><?php _e('How should shipping methods be displayed on the Shipping step of the checkout procedure?', $this -> plugin_name); ?></span>
                </td>
            </tr>
            <tr>
            	<th><label for="shippingdefault"><?php _e('Default Shipping Method', $this -> plugin_name); ?></label></th>
            	<td>
            		<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
            		<?php $shipmethods = $wpcoDb -> find_all(false, false, array('order', "ASC")); ?>
            		<?php $shippingdefault = $this -> get_option('shippingdefault'); ?>
            		<?php if (!empty($shipmethods)) : ?>
            			<select name="shippingdefault" id="shippingdefault">
            				<?php foreach ($shipmethods as $shipmethod) : ?>
            					<option <?php echo ($shippingdefault == $shipmethod -> id) ? 'selected="selected"' : ''; ?> value="<?php echo $shipmethod -> id; ?>"><?php echo __($shipmethod -> name); ?></option>
            				<?php endforeach; ?>
            			</select>
            			<span class="howto"><?php _e('Choose a default shipping method to use.', $this -> plugin_name); ?></span>
            		<?php else : ?>
            			<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available.', $this -> plugin_name); ?></p>
            		<?php endif; ?>
            	</td>
            </tr>
			<tr>
				<th><?php _e('Shipping Charge Type', $this -> plugin_name); ?></th>
				<td>
					<label><input onclick="jQuery('#shippingfixeddiv').show(); jQuery('#shippingtiersdiv').hide();" <?php echo ($this -> get_option('shippingtype') == "fixed") ? 'checked="checked"' : ''; ?> type="radio" name="shippingtype" value="fixed" /> <?php _e('Fixed Price', $this -> plugin_name); ?></label>
					<label><input onclick="jQuery('#shippingtiersdiv').show(); jQuery('#shippingfixeddiv').hide();" <?php echo ($this -> get_option('shippingtype') == "tiers") ? 'checked="checked"' : ''; ?> type="radio" name="shippingtype" value="tiers" /> <?php _e('Price Tiers', $this -> plugin_name); ?></label>
 					
                    <span class="howto"><?php _e('Please note that shipping methods using an API are not shown below, neither are they affected by these costs.', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div id="shippingfixeddiv" style="display:<?php echo ($this -> get_option('shippingtype') == "fixed") ? 'block' : 'none'; ?>;">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="<?php echo $this -> pre; ?>shippingprice"><?php _e('Shipping Price', $this -> plugin_name); ?></label></th>
					<td>
						<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
						<?php if ($shipmethods = $wpcoDb -> find_all()) : ?>
							<table>
								<tbody>
									<?php foreach ($shipmethods as $shipmethod) : ?>
										<?php if (empty($shipmethod -> api)) : ?>
	                                        <tr>
	                                            <th><label><input <?php echo ($this -> get_option('shippingfixed_default') == $shipmethod -> id) ? 'checked="checked"' : ''; ?> type="radio" name="shippingfixed_default" value="<?php echo $shipmethod -> id; ?>" id="shippingfixed_default_<?php echo $shipmethod -> id; ?>" /> <?php echo $shipmethod -> name; ?></label></th>
	                                            <td>
	                                            	<?php if (empty($shipmethod -> api)) : ?>
	                                                <?php echo $wpcoHtml -> currency_html('<input type="text" name="shipmethods[fixed][' . $shipmethod -> id . ']" value="' . $shipmethod -> fixed . '" id="shipmethods_fixed_' . $shipmethod -> id . '" style="width:65px;" />'); ?>
	                                                <?php endif; ?>
	                                            </td>
	                                        </tr>
	                                    <?php endif; ?>
									<?php endforeach; ?>	
								</tbody>
							</table>
						<?php else : ?>
							<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available. Go and ', $this -> plugin_name); ?><?php echo $wpcoHtml -> link(__('add', $this -> plugin_name), '?page=checkout-shipmethods&amp;method=save'); ?>.</p>
						<?php endif; ?>
						
						<div style="display:none;">
							<?php echo $wpcoHtml -> currency_html('<input type="text" class="widefat" style="width:65px;" id="' . $this -> pre . 'shippingprice" name="shippingprice" value="' . esc_attr(number_format($this -> get_option('shippingprice'), 2, '.', '')) . '" />'); ?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="shippingtiersdiv" style="display:<?php echo ($this -> get_option('shippingtype') == "tiers") ? 'block' : 'none'; ?>;">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="shiptierstype_price"><?php _e('Tiers Type', $this -> plugin_name); ?></th>
					<td>
						<label><input <?php echo (!$this -> get_option('shiptierstype') || $this -> get_option('shiptierstype') == "units") ? 'checked="checked"' : ''; ?> type="radio" name="shiptierstype" value="units" id="shiptierstype_units" /> <?php _e('Based on Quantity/Units', $this -> plugin_name); ?></label><br/>
						<label><input <?php echo ($this -> get_option('shiptierstype') == "price") ? 'checked="checked"' : ''; ?> type="radio" name="shiptierstype" value="price" id="shiptierstype_price" /> <?php _e('Based on Order Total', $this -> plugin_name); ?></label><br/>
						<label><input <?php echo ($this -> get_option('shiptierstype') == "weight") ? 'checked="checked"' : ''; ?> type="radio" name="shiptierstype" value="weight" id="shiptierstype_weight" /> <?php _e('Based on Total Weight', $this -> plugin_name); ?></label>
						
						<span class="howto"><?php _e('The units, price and weight are all calculated for the entire order in total', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><?php _e('Shipping Tiers', $this -> plugin_name); ?></th>
					<td>
						<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
						<?php if ($shipmethods = $wpcoDb -> find_all()) : ?>
							<?php $shippingtiers = $this -> get_option('shippingtiers'); ?>
							<?php $tierscount = 0; ?>
							<table class="<?php echo $this -> pre; ?>" style="width:auto;" id="shippingtiers">
								<tbody>
									<tr>
										<th colspan="5"></th>
										<?php foreach ($shipmethods as $shipmethod) : ?>
                                        	<?php if (empty($shipmethod -> api)) : ?>
                                                <th>
                                                    <label><input title="<?php _e('Default shipping method', $this -> plugin_name); ?>" <?php echo ($this -> get_option('shippingtiers_default') == $shipmethod -> id) ? 'checked="checked"' : ''; ?> type="radio" name="shippingtiers_default" value="<?php echo $shipmethod -> id; ?>" id="shippingtiers_default_<?php echo $shipmethod -> id; ?>" /> <?php echo $shipmethod -> name; ?></label>
                                                </th>
                                            <?php endif; ?>
										<?php endforeach; ?>
									</tr>
									<?php if (empty($shippingtiers) || !is_array($shippingtiers)) : ?>
										<tr>
											<td><?php _e('Order total of', $this -> plugin_name); ?></td>
											<td nowrap="nowrap"><span class="ship_currency"><?php echo $wpcoHtml -> currency(); ?></span><?php echo '<input type="text" class="widefat" style="width:40px;" name="shippingtiers[0][min]" value="1" />'; ?><span class="ship_units"><?php _e('qty', $this -> plugin_name); ?></span><span class="ship_weight"><?php echo $this -> get_option('weightm'); ?></span></td>
											<td><?php _e('to', $this -> plugin_name); ?></td>
											<td nowrap="nowrap"><span class="ship_currency"><?php echo $wpcoHtml -> currency(); ?></span><?php echo '<input type="text" class="widefat" style="width:40px;" name="shippingtiers[0][max]" value="100" />'; ?><span class="ship_units"><?php _e('qty', $this -> plugin_name); ?></span><span class="ship_weight"><?php echo $this -> get_option('weightm'); ?></span></td>
											<td>=</td>
											<?php foreach ($shipmethods as $shipmethod) : ?>
												<td><?php echo $wpcoHtml -> currency_html('<input type="text" class="widefat" style="width:40px;" name="shippingtiers[0][price][' . $shipmethod -> id . ']" value="10" />'); ?></td>
											<?php endforeach; ?>
											<td><?php _e('shipping charge', $this -> plugin_name); ?></td>
										</tr>
									<?php else : ?>
										<?php foreach ($shippingtiers as $shippingtier) : ?>
											<tr id="tierrow<?php echo $tierscount; ?>">
												<td></td>
												<td nowrap="nowrap">
                                                	<span class="ship_currency"><?php echo $wpcoHtml -> currency(); ?></span>
                                                    <?php echo '<input type="text" class="widefat" style="width:40px;" name="shippingtiers[' . $tierscount . '][min]" id="" value="' . $shippingtier['min'] . '" />'; ?>
                                                    <span class="ship_units"><?php _e('qty', $this -> plugin_name); ?></span>
                                                    <span class="ship_weight"><?php echo $this -> get_option('weightm'); ?></span>
                                                </td>
												<td><?php _e('to', $this -> plugin_name); ?></td>
												<td nowrap="nowrap">
                                                	<span class="ship_currency"><?php echo $wpcoHtml -> currency(); ?></span>
                                                    <?php echo '<input type="text" class="widefat" style="width:40px;" name="shippingtiers[' . $tierscount . '][max]" id="" value="' . $shippingtier['max'] . '" />'; ?>
                                                    <span class="ship_units"><?php _e('qty', $this -> plugin_name); ?></span>
                                                    <span class="ship_weight"><?php echo $this -> get_option('weightm'); ?></span>
                                                </td>
												<td>=</td>
												<?php foreach ($shipmethods as $shipmethod) : ?>
                                                	<?php if (empty($shipmethod -> api)) : ?>
														<td><?php echo $wpcoHtml -> currency_html('<input type="text" class="widefat" style="width:40px;" name="shippingtiers[' . $tierscount . '][price][' . $shipmethod -> id . ']" id="" value="' . $shippingtier['price'][$shipmethod -> id] . '" />'); ?></td>
                                                    <?php endif; ?>
												<?php endforeach; ?>
												<td><a href="javascript:del_shipping_tier('<?php echo $tierscount; ?>');" onclick="if (!confirm('<?php _e('Are you sure you wish to remove this tier?', $this -> plugin_name); ?>')) { return false; }"><?php _e('remove', $this -> plugin_name); ?></a></td>
											</tr>
											<?php $tierscount++; ?>
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
							
							<p class="submit"><input class="button-secondary" onclick="add_shipping_tier('','','');" type="button" name="add" value="<?php _e('Add Shipping Tier', $this -> plugin_name); ?>" /></p>
							
							<script type="text/javascript">
							var tierscount = "<?php echo $tierscount; ?>";
							
							function shiptierstype() {
								var tierstype = gettierstype();
							
								if (tierstype == "units") {
									jQuery('span.ship_currency').css('display',"none");
									jQuery('span.ship_units').css('display',"inline");
									jQuery('span.ship_weight').css('display', "none");
								} else if (tierstype == "price") {
									jQuery('span.ship_units').css('display',"none");
									jQuery('span.ship_currency').css('display',"inline");
									jQuery('span.ship_weight').css('display', "none");
								} else if (tierstype == "weight") {
									jQuery('span.ship_units').css('display', "none");
									jQuery('span.ship_currency').css('display', "none");
									jQuery('span.ship_weight').css('display', "inline");
								}
							}
							
							function add_shipping_tier(min, max, price) {												
								tierscount++;
								
								var tier = '';								
								tier += '<tr id="tierrow' + tierscount + '">';
								tier += '<td></td>';
								tier += '<td nowrap="nowrap">';
								tier += '<span class="ship_currency"><?php echo $wpcoHtml -> currency_html('<input type="text" class="widefat" style="width:40px;" name="shippingtiers[\' + tierscount + \'][min]" value="\' + min + \'" />'); ?></span>';
								tier += '<span class="ship_units"><input type="text" class="widefat" style="width:40px;" name="shippingtiers[' + tierscount + '][min]" value="' + min + '" /> qty</span>';
								tier += '<span class="ship_weight"><input type="text" class="widefat" style="width:40px;" name="shippingtiers[' + tierscount + '][min]" value="' + min + '" /> <?php echo $this -> get_option('weightm'); ?></span>';
								tier += '</td>';
								tier += '<td><?php _e('to', $this -> plugin_name); ?></td>';
								tier += '<td nowrap="nowrap">';
								tier += '<span class="ship_currency"><?php echo $wpcoHtml -> currency_html('<input type="text" class="widefat" style="width:40px;" name="shippingtiers[\' + tierscount + \'][max]" value="\' + max + \'" />'); ?></span>';
								tier += '<span class="ship_units"><input type="text" class="widefat" style="width:40px;" name="shippingtiers[' + tierscount + '][max]" value="' + max + '" /> qty</span>';
								tier += '<span class="ship_weight"><input type="text" class="widefat" style="width:40px;" name="shippingtiers[' + tierscount + '][max]" value="' + max + '" /> <?php echo $this -> get_option('weightm'); ?></span>';
								tier += '</td>';
								tier += '<td>=</td>';
								
								<?php foreach ($shipmethods as $shipmethod) : ?>
									<?php if (empty($shipmethod -> api)) : ?>
										tier += '<td><?php echo $wpcoHtml -> currency_html('<input type="text" class="widefat" style="width:40px;" name="shippingtiers[\' + tierscount + \'][price][' . $shipmethod -> id . ']" value="\' + price + \'" />'); ?></td>';
									<?php endif; ?>
								<?php endforeach; ?>
								
								tier += '<td><a href="javascript:del_shipping_tier(\'' + tierscount + '\');" onclick="if (!confirm(\'<?php _e('Are you sure you wish to remove this tier?', $this -> plugin_name); ?>\')) { return false; }"><?php _e('remove', $this -> plugin_name); ?></a></td>';
								tier += '</tr>';
								
								//new Insertion.Bottom('shippingtiers', tier);
								jQuery("#shippingtiers").append(tier);
								shiptierstype();
							}
							
							function del_shipping_tier(tierid) {
								//Element.remove('tierrow' + tierid + '');
								jQuery("#tierrow" + tierid + "").remove();
								tierscount--;
							}
							
							function gettierstype() {
								tierstype = "price";
								var n = jQuery('input[id=shiptierstype_units]:checked').length;
								if (n > 0) { tierstype = "units"; }
								
								if (jQuery('input[id=shiptierstype_weight]:checked').length > 0) { tierstype = "weight"; }
								
								return tierstype;
							}
							
							jQuery(document).ready(function() {
								shiptierstype();
								
								jQuery('input[name=shiptierstype]').click(function() { shiptierstype(); })
							});
							</script>
						<?php else : ?>
							<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available', $this -> plugin_name); ?>
						<?php endif; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<?php $this -> render('shiprates' . DS . 'settings', false, true, 'admin'); ?>
    
    <?php do_action($this -> pre . '_shipping_settings_after'); ?>
</div>