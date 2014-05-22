<?php do_action($this -> pre . '_tax_settings_outside_before'); ?>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="tax_calculate_Y"><?php _e('Calculate Tax', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#tax_calculate_div').show();" <?php echo ($this -> get_option('tax_calculate') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="tax_calculate" value="Y" id="tax_calculate_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#tax_calculate_div').hide();" <?php echo ($this -> get_option('tax_calculate') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="tax_calculate" value="N" id="tax_calculate_N" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
	</tbody>
</table>

<div id="tax_calculate_div" style="display:<?php echo ($this -> get_option('tax_calculate') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<?php do_action($this -> pre . '_tax_settings_inside_before'); ?>
			<tr>
				<th><label for="tax_name"><?php _e('Tax Name', $this -> plugin_name); ?></label></th>
				<td>
					<input type="text" id="tax_name" name="tax_name" value="<?php echo esc_attr(stripslashes($this -> get_option('tax_name'))); ?>" />
					<span class="howto"><?php _e('descriptive title eg. TAX, VAT, GST, IVA', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="tax_percentage"><?php _e('Global Tax Percentage', $this -> plugin_name); ?></label></th>
				<td>
					<input type="text" style="width:45px;" class="widefat" id="tax_percentage" name="tax_percentage" value="<?php echo ($this -> get_option('tax_percentage')) ? esc_attr(stripslashes($this -> get_option('tax_percentage'))) : "0"; ?>" /> &#37;
                    <span class="howto"><?php _e('this is a global tax percentage which can be overwritten below for specific countries and states/provinces.', $this -> plugin_name); ?></span>
				</td>
			</tr>
            <tr>
            	<th><label for="tax_includeinproductprice_Y"><?php _e('Product Price Display', $this -> plugin_name); ?></label></th>
                <td>
                	<label><input <?php echo ($this -> get_option('tax_includeinproductprice') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="tax_includeinproductprice" value="Y" id="tax_includeinproductprice_Y" /> <?php _e('Incl. TAX', $this -> plugin_name); ?></label>
                    <label><input <?php echo ($this -> get_option('tax_includeinproductprice') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="tax_includeinproductprice" value="N" id="tax_includeinproductprice_N" /> <?php _e('Excl. TAX', $this -> plugin_name); ?></label>
                    <span class="howto"><?php _e('Should product prices be shown Incl. or Excl. TAX to customers?', $this -> plugin_name); ?></span>
                </td>
            </tr>
            <tr>
            	<th><label for="tax_includeshipping_N"><?php _e('Include Shipping', $this -> plugin_name); ?></label></th>
                <td>
                	<label><input <?php echo ($this -> get_option('tax_includeshipping') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="tax_includeshipping" value="Y" id="tax_includeshipping_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                    <label><input <?php echo ($this -> get_option('tax_includeshipping') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="tax_includeshipping" value="N" id="tax_includeshipping_N" /> <?php _e('No (recommended)', $this -> plugin_name); ?></label>
                	<span class="howto"><?php _e('should the shipping price be included in the total from which tax is calculated', $this -> plugin_name); ?></span>
                </td>
            </tr>
            <tr>
            	<th><?php _e('Additional Tax Rates', $this -> plugin_name); ?></th>
                <td>
                	<div id="taxrates-div">
						<?php $this -> render('taxrates', false, true, 'admin'); ?>
                    </div>
                </td>	
            </tr>
            <?php do_action($this -> pre . '_tax_settings_inside_after'); ?>
		</tbody>
	</table>
</div>

<?php do_action($this -> pre . '_tax_settings_outside_after'); ?>