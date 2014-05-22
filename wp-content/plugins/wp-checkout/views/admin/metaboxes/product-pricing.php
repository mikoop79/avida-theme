<?php $lengthmeasurement = ($wpcoHtml -> field_value('Product.lengthmeasurement') == "") ? __('*length measurement*', $this -> plugin_name) : $wpcoHtml -> field_value('Product.lengthmeasurement'); ?>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="Product.buynow"><?php _e('Purchase Type', $this -> plugin_name); ?></label></th>
            <td>
            	<?php $buynow = array('N' => __('Add to Basket (recommended)', $this -> plugin_name), 'Y' => __('Buy Now Mode', $this -> plugin_name)); ?>
                <?php echo $wpcoForm -> radio('Product.buynow', $buynow, array('default' => "N", 'separator' => false)); ?>
            	<span class="howto"><?php _e('Specify whether this product will be added to the basket or take a customer directly to pay for this individual item.', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="Product.price_typefixed"><?php _e('Price Type', $this -> plugin_name); ?></label></th>
			<td>
				<?php $price_types = array('fixed' => __('Fixed Price', $this -> plugin_name), 'tiers' => __('Price Tiers', $this -> plugin_name), 'donate' => __('Donation', $this -> plugin_name), 'square' => __('Per Square', $this -> plugin_name) . ' ' . $lengthmeasurement); ?>
				<?php echo $wpcoForm -> radio('Product.price_type', $price_types, array('separator' => false, 'default' => "fixed", 'onclick' => "change_price_type(this.value);")); ?>
				
				<script type="text/javascript">
				function change_price_type(price_type) {
					jQuery('[id^=pricetypediv]').hide();
					jQuery('#pricetypediv_' + price_type).show();
					
					if (price_type != "donate") {
						jQuery('#rwpricesdiv').show();
					} else {
						jQuery('#rwpricesdiv').hide();
					}
				}
				</script>
			</td>
		</tr>
	</tbody>
</table>

<div id="pricetypediv_square" style="display:<?php echo ($wpcoHtml -> field_value('Product.price_type') == "square") ? 'block' : 'none'; ?>;">
	<table class="form-table">
    	<tbody>
        	<tr>
            	<th><label for="Product.square_price_text"><?php _e('Text to Display', $this -> plugin_name); ?></label></th>
                <td>
                	<?php echo $wpcoForm -> text('Product.square_price_text'); ?>
                	<span class="howto"><?php _e('Text to display for price eg. "$10 per square meter".', $this -> plugin_name); ?></span>
                </td>
            </tr>
        	<tr>
            	<th><label for="Product.square_price"><?php _e('Price Per Square', $this -> plugin_name); ?> <?php echo $lengthmeasurement; ?></label></th>
                <td>
                	<?php echo $wpcoHtml -> currency_html('<input style="width:65px;" class="widefat" type="text" name="Product[square_price]" value="' . esc_attr(stripslashes($wpcoHtml -> field_value('Product.square_price'))) . '" id="Product.square_price" />'); ?>
                </td>
            </tr>
            <tr>
            	<th><label for="Product.sq_w_min"><?php _e('Min/Max', $this -> plugin_name); ?> <?php echo $lengthmeasurement; ?> <?php _e('Values', $this -> plugin_name); ?></label></th>
                <td>
                	<?php _e('Width Min:', $this -> plugin_name); ?> <?php echo $wpcoForm -> text('Product.sq_w_min', array('width' => "45px")); ?>
                    <?php _e('Width Max:', $this -> plugin_name); ?> <?php echo $wpcoForm -> text('Product.sq_w_max', array('width' => "45px")); ?>
                    <?php _e('Length Min:', $this -> plugin_name); ?> <?php echo $wpcoForm -> text('Product.sq_l_min', array('width' => "45px")); ?>
                    <?php _e('Length Max:', $this -> plugin_name); ?> <?php echo $wpcoForm -> text('Product.sq_l_max', array('width' => "45px")); ?>
                	<span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('You can specify min/max values allowed to be input by users for the width/length.', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div id="pricetypediv_donate" style="display:<?php echo ($wpcoHtml -> field_value('Product.price_type') == "donate") ? 'block' : 'none'; ?>;">
	<table class="form-table">
    	<tbody>
    		<tr>
    			<th><label for="Product.donate_min"><?php _e('Minimum Amount', $this -> plugin_name); ?></label></th>
    			<td>
    				<?php echo $wpcoHtml -> currency_html('<input type="text" name="Product[donate_min]" value="' . esc_attr(stripslashes($wpcoHtml -> field_value('Product.donate_min'))) . '" id="Product.donate_min" class="widefat" style="width:65px;" />'); ?>
    				<span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('Minimum amount allowed for donation', $this -> plugin_name); ?></span>
    			</td>
    		</tr>
        	<tr>
            	<th><label for="Product.donate_caption"><?php _e('Donate Caption', $this -> plugin_name); ?></label></th>
                <td>                
                	<?php echo $wpcoForm -> text('Product.donate_caption'); ?>
                	<span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('Description/caption to show to your customers below the donate price field.', $this -> plugin_name); ?></span>
                </td>
            </tr>
            <tr>
            	<th><label for="Product.inhonorof"><?php _e('In Honor Of', $this -> plugin_name); ?></label></th>
                <td>
                	<?php $inhonorof = array('Y' => __('Enabled', $this -> plugin_name), 'N' => __('Disabled', $this -> plugin_name)); ?>
                    <?php echo $wpcoForm -> radio('Product.inhonorof', $inhonorof, array('separator' => false, 'default' => "N", 'onclick' => "if (this.value == 'Y') { jQuery('#inhonorofdiv').show(); } else { jQuery('#inhonorofdiv').hide(); }")); ?>
                    <span class="howto"><?php _e('Turning In Honor Of will display donor and beneficiary fields on the product page and send an email to the beneficiary.', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div id="inhonorofdiv" style="display:<?php echo ($wpcoHtml -> field_value('Product.inhonorof') == "Y") ? 'block' : 'none'; ?>;">
    	<table class="form-table">
        	<tbody>
            	<tr>
                	<th><label for="Product.inhonorofreqN"><?php _e('Make Fields Required?', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php $inhonorofreq = array('Y' => __('Yes', $this -> plugin_name), 'N' => __('No', $this -> plugin_name)); ?>
                        <?php echo $wpcoForm -> radio('Product.inhonorofreq', $inhonorofreq, array('separator' => false, 'default' => "N")); ?>
                        <span class="howto"><?php _e('Should the in honor of fields be mandatory to the donor?', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div id="pricetypediv_fixed" style="display:<?php echo ($wpcoHtml -> field_value('Product.price_type') == "" || $wpcoHtml -> field_value('Product.price_type') == "fixed") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="Product.price_fixed"><?php _e('Fixed Price', $this -> plugin_name); ?></label></th>
				<td><?php echo $wpcoHtml -> currency_html($wpcoForm -> text('Product.price_fixed', array('width' => '65px'))); ?></td>
			</tr>
		</tbody>
	</table>
</div>

<div id="pricetypediv_tiers" style="display:<?php echo ($wpcoHtml -> field_value('Product.price_type') == "tiers") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><?php _e('Price Tiers', $this -> plugin_name); ?></th>
				<td>
					<table class="<?php echo $this -> pre; ?>" style="width:auto !important;" id="pricetiers">
						<tbody>
							<?php if (empty($Product -> data -> price_tiers)) : ?>
								<tr>
									<td><input class="widefat" style="width:45px;" type="text" id="Product.price_tiers.1.min" name="Product[price_tiers][1][min]" value="1" /></td>
									<td>to</td>
									<td><input class="widefat" style="width:45px;" type="text" id="Product.price_tiers.1.max" name="Product[price_tiers][1][max]" value="2" /> <?php _e('units', $this -> plugin_name); ?></td>
									<td>=</td>
									<td><?php echo $wpcoHtml -> currency_html('<input class="widefat" style="width:65px;" type="text" id="Product.price_tiers.1.price" name="Product[price_tiers][1][price]" value="0.00" />'); ?></td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
					
					<input onclick="add_tier('','','');" type="button" name="addtier" value="<?php _e('Add Tier', $this -> plugin_name); ?>" class="button-secondary" />
					
					<script type="text/javascript">
					var tierscount = 1;
					
					function add_tier(min, max, price) {						
						if (tierscount == 0 || tierscount == "" || tierscount == undefined) {
							tierscount = 1;	
						}
						
						if (maxobj = document.getElementById('Product.price_tiers.' + tierscount + '.max')) {
							var oldmax = maxobj.value;
						} else {
							var oldmax = 0;
						}
							
						if (min == "") { min = (parseFloat(oldmax) + 1);  }
						if (max == "") { max = (parseFloat(min) + 1); }
						if (price == "") { price = "0.00"; }
					
						tierscount++;
													
						var tier = '<tr id="tierrow' + tierscount + '">';
						tier += '<td><input class="widefat" style="width:45px;" type="text" id="Product.price_tiers.' + tierscount + '.min" name="Product[price_tiers][' + tierscount + '][min]" value="' + min + '" /></td>';
						tier += '<td>to</td>';
						tier += '<td><input class="widefat" style="width:45px;" type="text" id="Product.price_tiers.' + tierscount + '.max" name="Product[price_tiers][' + tierscount + '][max]" value="' + max + '" /> <?php echo _e('units', $this -> plugin_name); ?></td>';
						tier += '<td>=</td>';
						tier += '<td><?php echo $wpcoHtml -> currency_html('<input class="widefat" style="width:65px;" type="text" id="Product.price_tiers.\' + tierscount + \'.price" name="Product[price_tiers][\' + tierscount + \'][price]" value="\' + price + \'" />'); ?></td>';
						tier += '<td><a class="delete" onclick="if (!confirm(\'<?php _e('Are you sure you wish to remove this tier?', $this -> plugin_name); ?>\')) { return false; }" href="javascript:del_tier(' + tierscount + ');" title="<?php _e('Remove this price tier', $this -> plugin_name); ?>"><?php _e('remove', $this -> plugin_name); ?></a></td>';
						tier += '</tr>';
						
						//new Insertion.Bottom('pricetiers', tier);
						jQuery("#pricetiers").append(tier);
					}
					
					function del_tier(rowid) {
						//Element.remove('tierrow' + rowid);
						jQuery("#tierrow" + rowid).remove();
						tierscount--;
					}
					</script>
					
					<?php if (!empty($Product -> data -> price_tiers)) : ?>
						<?php foreach ($Product -> data -> price_tiers as $tier) : ?>
							<script type="text/javascript">
								add_tier('<?php echo $tier['min']; ?>','<?php echo $tier['max']; ?>','<?php echo $tier['price']; ?>');
							</script>
						<?php endforeach; ?>
					<?php endif; ?>
					
					<?php echo $wpcoHtml -> field_error('Product.price_tiers'); ?>
					<span class="howto"><?php _e('the last tier automatically goes to infinite unit count', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="Product.price_displayhigh"><?php _e('Price Display', $this -> plugin_name); ?></label></th>
				<td>
					<?php $price_display = array('high' => __('Highest Price', $this -> plugin_name), 'low' => __('Lowest Price', $this -> plugin_name)); ?>
					<?php echo $wpcoForm -> radio('Product.price_display', $price_display, array('separator' => false, 'default' => "high")); ?>
					<span class="howto"><?php _e('Should the highest or lowest price in the tiers be displayed on the category, supplier and product pages?', $this -> plugin_name); ?></span>		
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div id="rwpricesdiv" style="display:<?php echo ($wpcoHtml -> field_value('Product.price_type') != "donate") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th></th>
				<td>
					<label><input <?php echo (!empty($Product -> data -> taxincluded) && $Product -> data -> taxincluded == 1) ? 'checked="checked"' : ''; ?> type="checkbox" name="Product[taxincluded]" value="1" id="Product_taxincluded" /> <?php _e('Tax is included in the product price.', $this -> plugin_name); ?></label>
					<?php echo $wpcoHtml -> help(__('The tax would usually calculate on top of the product price.', $this -> plugin_name)); ?>
				</td>
			</tr>
			<tr>
				<th><label for="Product.sprice"><?php _e('Retail/Suggested Price', $this -> plugin_name); ?></label></th>
				<td>
					<?php echo $wpcoHtml -> currency_html($wpcoForm -> text('Product.sprice', array('width' => "65px"))); ?>
					<span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('Actual price after mark-down or suggested manufacturer retail price', $this -> plugin_name); ?></span>
				</td>
			</tr>
	        <tr>
	        	<th><label for="Product.wholesale"><?php _e('Wholesale Price', $this -> plugin_name); ?></label></th>
	            <td>
	            	<?php echo $wpcoHtml -> currency_html($wpcoForm -> text('Product.wholesale', array('width' => "65px"))); ?>
	                <span class="howto"><?php _e('Wholesale price per unit of this product.', $this -> plugin_name); ?></span>
	            </td>
	        </tr>
		</tbody>
	</table>
</div>

<table class="form-table">
	<tbody>
        <?php $taxexempt = $wpcoHtml -> field_value('Product.taxexempt'); ?>
        <tr>
        	<th><label for=""><?php _e('Tax Exempt', $this -> plugin_name); ?></label></th>
            <td>
            	<?php echo $wpcoForm -> radio('Product.taxexempt', array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)), array('separator' => false, 'default' => "N", 'onclick' => "if (this.value == 'N') { jQuery('#taxexemptdiv').show(); } else { jQuery('#taxexemptdiv').hide(); }")); ?>
            	<span class="howto"><?php _e('Set to Yes to exclude this product from tax calculation completely.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>

<div id="taxexemptdiv" style="display:<?php echo (empty($taxexempt) || $taxexempt == "N") ? 'block' : 'none'; ?>;">
	<table class="form-table">
    	<tbody>
        	<?php $taxoverride = $wpcoHtml -> field_value('Product.taxoverride'); ?>
        	<tr>
            	<th><label for="taxoverrideN"><?php _e('Override Global Tax Rates', $this -> plugin_name); ?></label></th>
                <td>
                	<label><input onclick="jQuery('#taxoverridediv').show();" <?php echo ($taxoverride == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="Product[taxoverride]" value="Y" id="taxoverrideY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                    <label><input onclick="jQuery('#taxoverridediv').hide();" <?php echo (empty($taxoverride) || $taxoverride == "N") ? 'checked="checked"' : ''; ?> type="radio" name="Product[taxoverride]" value="N" id="taxoverrideN" /> <?php _e('No', $this -> plugin_name); ?></label>
                    <span class="howto"><?php _e('You can override the global tax rates defined under Configuration for this product.', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div id="taxoverridediv" style="display:<?php echo (!empty($taxoverride) && $taxoverride == "Y") ? 'block' : 'none'; ?>;">
    	<table class="form-table">
        	<tbody>
            	<tr>
                	<th><label for="Product.taxrate"><?php _e('Product Tax Rate', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php echo $wpcoForm -> text('Product.taxrate', array('width' => "45px")); ?>&#37;
                        <span class="howto"><?php _e('Override the global tax rate defined under Configuration for this product.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            	<tr>
                	<th><label for=""><?php _e('Additional Tax Rates', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php
						
						global $wpdb, $wpcoTax;
						$taxratesquery = "SELECT * FROM " . $wpdb -> prefix . $wpcoTax -> table . "";
						
						if ($taxrates = $wpdb -> get_results($taxratesquery)) {
							
							$producttaxrates = @unserialize($wpcoHtml -> field_value('Product.taxrates'));
							
							?>
                            
                            <table>
                            	<tbody>
                            
								<?php
                                
                                foreach ($taxrates as $taxrate) {
									$t = $taxrate -> id;
									
                                    ?>
                                    
                                    <tr>
                                    	<td>
                                        	<input type="text" class="widefat" style="width:45px;" name="Product[taxrates][<?php echo $t; ?>][percentage]" value="<?php echo esc_attr(stripslashes($producttaxrates[$t]['percentage'])); ?>" />&#37;
                                        </td>
                                        <td>
											<?php echo $Country -> value_by_id($taxrate -> country_id); ?>
                                            <input type="hidden" name="Product[taxrates][<?php echo $t; ?>][country_id]" value="<?php echo $taxrate -> country_id; ?>" />
                                        </td>
                                        <td>
											<?php echo (!empty($taxrate -> state) && $taxrate -> state != "undefined") ? $taxrate -> state : __('All States/Provinces', $this -> plugin_name); ?>
                                            <input type="hidden" name="Product[taxrates][<?php echo $t; ?>][state]" value="<?php echo $taxrate -> state; ?>" />
                                        </td>
                                    </tr>
                                    
                                    <?php
                                }
                                
                                ?>
                            
                            	</tbody>
                            </table>
                            
                            <?php
						}
						
						?>
                        
                        <span class="howto"><?php _e('Override additional tax rates defined under Configuration for this product.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="Product.typetangible"><?php _e('Product Type', $this -> plugin_name); ?></label></th>
			<td>
				<?php $product_types = array('digital' => __('Digital', $this -> plugin_name), 'tangible' => __('Tangible', $this -> plugin_name)); ?>
				<?php echo $wpcoForm -> radio('Product.type', $product_types, array('separator' => false, 'default' => $this -> get_option('product_defaulttype'), 'onclick' => "if (this.value == 'tangible') { jQuery('#typediv').show(); } else { jQuery('#typediv').hide(); }")); ?>
                <span class="howto"><?php _e('Tangible products are physical, shippable products.', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>

<div id="typediv" style="display:<?php echo (($wpcoHtml -> field_value('Product.type') != "" && $wpcoHtml -> field_value('Product.type') == "tangible") || ($wpcoHtml -> field_value('Product.type') == "" && $this -> get_option('product_defaulttype') == "tangible")) ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="Product.weight"><?php _e('Unit Weight', $this -> plugin_name); ?></label></th>
				<td>
					<?php echo $wpcoForm -> text('Product.weight', array('width' => "65px")); ?> <?php echo $this -> get_option('weightm'); ?>
					<span class="howto"><?php _e('optional. the weight for a single unit/item of this product', $this -> plugin_name); ?></span>
				</td>
			</tr>
            <tr>
            	<th><label for="Product.lengthmeasurement"><?php _e('Length Measurement', $this -> plugin_name); ?></label></th>
                <td>
                	<?php global $lengthmeasurements; require_once $this -> plugin_base() . DS . 'includes' . DS . 'variables.php'; ?>
                    <?php echo $wpcoForm -> select('Product.lengthmeasurement', $lengthmeasurements); ?>
                	<span class="howto"><?php _e('Length unit to measure the width, length and height of this product.', $this -> plugin_name); ?></span>
                </td>
            </tr>
            <tr>
            	<th><label for="Product.width"><?php _e('Unit Width', $this -> plugin_name); ?></label></th>
                <td>
                	<?php echo $wpcoForm -> text('Product.width', array('width' => "65px")); ?> <?php echo $lengthmeasurement; ?>
                    <span class="howto"><?php _e('optional. the width of a single unit of this product', $this -> plugin_name); ?></span>
                </td>
            </tr>
            <tr>
            	<th><label for="Product.length"><?php _e('Unit Length', $this -> plugin_name); ?></label></th>
                <td>
                	<?php echo $wpcoForm -> text('Product.length', array('width' => "65px")); ?> <?php echo $lengthmeasurement; ?>
                    <span class="howto"><?php _e('optional. the length of a single unit of this product', $this -> plugin_name); ?></span>
                </td>
            </tr>
            <tr>
            	<th><label for="Product.height"><?php _e('Unit Height', $this -> plugin_name); ?></label></th>
                <td>
                	<?php echo $wpcoForm -> text('Product.height', array('width' => "65px")); ?> <?php echo $lengthmeasurement; ?>
                    <span class="howto"><?php _e('optional. the height of a single unit of this product', $this -> plugin_name); ?></span>
                </td>
            </tr>
			<tr>
				<th></th>
				<td>
					<label><input <?php echo ($wpcoHtml -> field_value('Product.excludeglobal') == "Y") ? 'checked="checked"' : ''; ?> type="checkbox" name="Product[excludeglobal]" value="Y" id="excludeglobal" /> <?php _e('Exclude from global shipping calculation', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('check this checkbox to exclude quantity, amount &amp; weight of this product from the global shipping calculation', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="Product.shippingN"><?php _e('Additional Shipping Cost', $this -> plugin_name); ?></label></th>
				<td>
					<?php $shipping = array("Y" => __('Yes, add shipping cost', $this -> plugin_name), "N" => __('No, no additional shipping cost', $this -> plugin_name)); ?>
					<?php echo $wpcoForm -> radio('Product.shipping', $shipping, array('default' => "N", 'onclick' => "if (this.value == 'Y') { jQuery('#shippingdiv').show(); } else { jQuery('#shippingdiv').hide(); }")); ?>
					
					<?php if ($this -> get_option('shippingcalc') == "N") : ?>
						<span class="<?php echo $this -> pre; ?>error">
							<?php _e('shipping calculation is turned off in the "Configuration" section', $this -> plugin_name); ?>
						</span>
					<?php endif; ?>
                    
                    <span class="howto"><?php _e('by turning this On, additional shipping will be calculated on top of the global shipping total.', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>

	<div id="shippingdiv" style="display:<?php echo ($wpcoHtml -> field_value('Product.shipping') == "Y") ? 'block' : 'none'; ?>;">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Product.shiptypefixed"><?php _e('Shipping Type', $this -> plugin_name); ?></label></th>
					<td>
						<?php $shiptypes = array("fixed" => __('Fixed', $this -> plugin_name), "percentage" => __('Percentage', $this -> plugin_name), "tiers" => __('Tiers', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Product.shiptype', $shiptypes, array('default' => "fixed", 'onclick' => "jQuery('#shiptype_percentage').hide(); if (this.value == 'fixed') { jQuery('#shipfixeddiv').show(); jQuery('#shiptiersdiv').hide(); jQuery('#shippercentagediv').hide(); } else if (this.value == 'percentage') { jQuery('#shipfixeddiv').hide(); jQuery('#shiptiersdiv').hide(); jQuery('#shippercentagediv').show(); jQuery('#shiptype_percentage').show(); } else { jQuery('#shiptiersdiv').show(); jQuery('#shippercentagediv').hide(); jQuery('#shipfixeddiv').hide(); }")); ?>
					</td>
				</tr>
			</tbody>
		</table>
        
        <div id="shiptype_percentage" style="display:<?php echo ($wpcoHtml -> field_value('Product.shiptype') == "percentage") ? 'block' : 'none'; ?>;">
        	<table class="form-table">
            	<tbody>
                	<tr>
                    	<th><label for="Product.shippercmethodfixed"><?php _e("Calculate on product's", $this -> plugin_name); ?></label></th>
                        <td>
                        	<?php $shippercoptions = array("fixed" => __('Fixed/Tiers Price', $this -> plugin_name), "wholesale" => __('Wholesale price', $this -> plugin_name)); ?>
                            <?php echo $wpcoForm -> radio('Product.shippercmethod', $shippercoptions, array('default' => "fixed")); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div id="shippercentagediv" style="display:<?php echo ($wpcoHtml -> field_value('Product.shiptype') == "percentage") ? 'block' : 'none'; ?>;">
        	<table class="form-table">
            	<tbody>
                	<tr>
                    	<th><label for=""><?php _e('Product Shipping', $this -> plugin_name); ?></label></th>
                        <td>
                        	<?php $shippercentage = $wpcoHtml -> field_value('Product.shippercentage'); ?>						
							<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
							<?php if ($shipmethods = $wpcoDb -> find_all()) : ?>
								<table>
									<tbody>
										<?php foreach ($shipmethods as $shipmethod) : ?>
											<tr>
												<th><label for="Product.shippercentage_<?php echo $shipmethod -> id; ?>"><?php echo $shipmethod -> name; ?></label></th>
												<td>
													<?php echo '<input type="text" name="Product[shippercentage][' . $shipmethod -> id . ']" value="' . ((!empty($shippercentage[$shipmethod -> id])) ? number_format($shippercentage[$shipmethod -> id], 2, '.', '') : "0.00") . '" id="Product.shippercentage_' . $shipmethod -> id . '" style="width:65px;" /> &#37;'; ?>
												</td>
											</tr>
										<?php endforeach; ?>	
									</tbody>
								</table>
								<span class="howto"><?php _e('additional shipping cost for this product calculated by percentage.', $this -> plugin_name); ?></span>
							<?php else : ?>
								<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available', $this -> plugin_name); ?></p>
							<?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
		
		<div id="shipfixeddiv" style="display:<?php echo ($wpcoHtml -> field_value('Product.shiptype') == "fixed" || $wpcoHtml -> field_value('Product.shiptype') == "") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Product.shipfixed"><?php _e('Product Shipping', $this -> plugin_name); ?></label></th>
						<td>
							<?php $shipfixed = $wpcoHtml -> field_value('Product.shipfixed'); ?>
						
							<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
							<?php if ($shipmethods = $wpcoDb -> find_all()) : ?>
								<table>
									<tbody>
										<?php foreach ($shipmethods as $shipmethod) : ?>
											<tr>
												<th><label for="Product.shipfixed_<?php echo $shipmethod -> id; ?>"><?php echo $shipmethod -> name; ?></label></th>
												<td>
													<?php echo $wpcoHtml -> currency_html('<input type="text" name="Product[shipfixed][' . $shipmethod -> id . ']" value="' . ((!empty($shipfixed[$shipmethod -> id])) ? number_format($shipfixed[$shipmethod -> id], 2, '.', '') : "0.00") . '" id="Product.shipfixed_' . $shipmethod -> id . '" style="width:65px;" />'); ?>
												</td>
											</tr>
										<?php endforeach; ?>	
									</tbody>
								</table>
								<span class="howto"><?php _e('additional shipping cost for this product', $this -> plugin_name); ?></span>
							<?php else : ?>
								<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available', $this -> plugin_name); ?></p>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div id="shiptiersdiv" style="display:<?php echo ($wpcoHtml -> field_value('Product.shiptype') == "tiers") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Product.shiptiers"><?php _e('Product Shipping', $this -> plugin_name); ?></label></th>
						<td>
							<?php $measurement = ($wpcoHtml -> field_value('Product.measurement') == "") ? __('Units', $this -> plugin_name) : $wpcoHtml -> field_value('Product.measurement'); ?> 
							<?php $wpcoDb -> model = $wpcoShipmethod -> model; ?>
							<?php if ($shipmethods = $wpcoDb -> find_all()) : ?>
								<?php $shiptiers = $wpcoHtml -> field_value('Product.shiptiers'); ?>
								<?php $tierscount = 0; ?>
								<table class="<?php echo $this -> pre; ?>" style="width:auto;" id="shiptiers">
									<tbody>
										<tr>
											<th colspan="6"></th>
											<?php foreach ($shipmethods as $shipmethod) : ?>
												<th><?php echo $shipmethod -> name; ?></th>
											<?php endforeach; ?>
										</tr>
										<?php if (empty($shiptiers) || !is_array($shiptiers)) : ?>
											<tr>
												<td><?php _e('Total of', $this -> plugin_name); ?></td>
												<td nowrap="nowrap"><input type="text" class="widefat" style="width:40px;" name="Product[shiptiers][0][min]" value="1" /></td>
												<td><?php _e('to', $this -> plugin_name); ?></td>
												<td nowrap="nowrap"><input type="text" class="widefat" style="width:40px;" name="Product[shiptiers][0][max]" value="100" /></td>
												<td><?php echo $measurement; ?></td>
												<td>=</td>
												<?php foreach ($shipmethods as $shipmethod) : ?>
													<td nowrap="nowrap"><?php echo $wpcoHtml -> currency_html('<input type="text" class="widefat" style="width:40px;" name="Product[shiptiers][0][price][' . $shipmethod -> id . ']" value="10" />'); ?></td>
												<?php endforeach; ?>
												<td><?php _e('shipping charge', $this -> plugin_name); ?></td>
											</tr>
										<?php else : ?>
											<?php foreach ($shiptiers as $shiptier) : ?>
												<tr id="tierrow<?php echo $tierscount; ?>">
													<td></td>
													<td nowrap="nowrap"><input type="text" class="widefat" style="width:40px;" name="Product[shiptiers][<?php echo $tierscount; ?>][min]" id="" value="<?php echo $shiptier['min']; ?>" /></td>
													<td><?php _e('to', $this -> plugin_name); ?></td>
													<td nowrap="nowrap"><input type="text" class="widefat" style="width:40px;" name="Product[shiptiers][<?php echo $tierscount; ?>][max]" id="" value="<?php echo $shiptier['max']; ?>" /></td>
													<td><?php echo $measurement; ?></td>
													<td>=</td>
													<?php foreach ($shipmethods as $shipmethod) : ?>
														<td nowrap="nowrap"><?php echo $wpcoHtml -> currency_html('<input type="text" class="widefat" style="width:40px;" name="Product[shiptiers][' . $tierscount . '][price][' . $shipmethod -> id . ']" id="" value="' . number_format($shiptier['price'][$shipmethod -> id], 2, '.', '') . '" />'); ?></td>
													<?php endforeach; ?>
													<td><a href="javascript:del_shipping_tier('<?php echo $tierscount; ?>');" onclick="if (!confirm('<?php _e('Are you sure you wish to remove this tier?', $this -> plugin_name); ?>')) { return false; }"><?php _e('remove', $this -> plugin_name); ?></a></td>
												</tr>
												<?php $tierscount++; ?>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table>
								
								<p class="submit">
									<input class="button-secondary" onclick="add_shipping_tier('','','');" type="button" name="" value="<?php _e('Add Shipping Tier', $this -> plugin_name); ?>" />
								</p>
								
								<script type="text/javascript">
								var tierscount = "<?php echo $tierscount; ?>";
								
								function add_shipping_tier(min, max, price) {												
									tierscount++;
									
									var tier = '';								
									tier += '<tr id="tierrow' + tierscount + '">';
									tier += '<td></td>';
									tier += '<td nowrap="nowrap"><input type="text" class="widefat" style="width:40px;" name="Product[shiptiers][' + tierscount + '][min]" value="' + min + '" /></td>';
									tier += '<td><?php _e('to', $this -> plugin_name); ?></td>';
									tier += '<td nowrap="nowrap"><input type="text" class="widefat" style="width:40px;" name="Product[shiptiers][' + tierscount + '][max]" value="' + max + '" /></td>';
									tier += '<td><?php echo $measurement; ?></td>';
									tier += '<td>=</td>';
									
									<?php foreach ($shipmethods as $shipmethod) : ?>
										tier += '<td nowrap="nowrap"><?php echo $wpcoHtml -> currency_html('<input type="text" class="widefat" style="width:40px;" name="Product[shiptiers][\' + tierscount + \'][price][' . $shipmethod -> id . ']" value="\' + price + \'" />'); ?></td>';
									<?php endforeach; ?>
									
									tier += '<td><a href="javascript:del_shipping_tier(\'' + tierscount + '\');" onclick="if (!confirm(\'<?php _e('Are you sure you wish to remove this tier?', $this -> plugin_name); ?>\')) { return false; }"><?php _e('remove', $this -> plugin_name); ?></a></td>';
									tier += '</tr>';
									
									//new Insertion.Bottom('shippingtiers', tier);
									jQuery("#shiptiers").append(tier);
								}
								
								function del_shipping_tier(tierid) {
									//Element.remove('tierrow' + tierid + '');
									jQuery("#tierrow" + tierid + "").remove();
									tierscount--;
								}
								</script>
								
								<span class="howto">
									<?php _e('additional shipping price will be added for each ' . $measurement . ' purchased.', $this -> plugin_name); ?><br/>
									<?php _e('the last tier automatically goes to infinite order total.', $this -> plugin_name); ?>
								</span>
							<?php else : ?>
								<p class="<?php echo $this -> pre; ?>error"><?php _e('No shipping methods are available', $this -> plugin_name); ?>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
    
    <table class="form-table">
    	<tbody>
        	<tr>
            	<th><label for="Product.cp_readytoshipN"><?php _e('Ready To Ship', $this -> plugin_name); ?></label></th>
                <td>
                	<?php $readytoship = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
                    <?php echo $wpcoForm -> radio('Product.readytoship', $readytoship, array('default' => "N", 'separator' => false)); ?>
                    
                    <span class="howto"><?php _e('This currently applies to Canada Post only. Setting to Yes indicates that the product has been boxed already and you will not be using the Canada Post packaging for it.', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>