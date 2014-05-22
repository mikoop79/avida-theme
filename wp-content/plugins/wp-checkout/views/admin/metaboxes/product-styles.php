<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="Product_vtreatasone_N"><?php _e('Treat pricing as same product', $this -> plugin_name); ?></label></th>
            <td>
            	<?php $vtreatasone = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
				<?php echo $wpcoForm -> radio('Product.vtreatasone', $vtreatasone, array('separator' => false, 'default' => "N")); ?>
            	<span class="howto"><?php _e('Turning this On (Yes) will group all items of this product in the basket disregarding variations.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="Product_vcalculation_orig"><?php _e('Variation Calculation', $this -> plugin_name); ?></label></th>
        	<td>
        		<?php $vcalculation = array('orig' => __('On original product price', $this -> plugin_name), 'accum' => __('Accumulative on top of one another in order displayed', $this -> plugin_name)); ?>
        		<?php echo $wpcoForm -> radio('Product.vcalculation', $vcalculation, array('separator' => '<br/>', 'default' => "orig")); ?>
        		<span class="howto"><?php _e('How should each variation price be calculated?', $this -> plugin_name); ?></span>
        	</td>
        </tr>
        <tr>
        	<th><label for="Product_vtax_Y"><?php _e('Tax Calculation', $this -> plugin_name); ?></label></th>
        	<td>
        		<?php $vtax = array('Y' => __('Yes, calculate tax on variation option prices.', $this -> plugin_name), 'N' => __('No, only calculate tax on the product base price.', $this -> plugin_name)); ?>
        		<?php echo $wpcoForm -> radio('Product.vtax', $vtax, array('separator' => '<br/>', 'default' => "Y")); ?>
        		<span class="howto"><?php _e('Specify whether tax should be calculated on variation option prices or not.', $this -> plugin_name); ?></span>
        	</td>
        </tr>
		<tr>
			<th><?php _e('Variations', $this -> plugin_name); ?></th>
			<td>
            	<div id="productvariations">
                	<?php $this -> render('styles' . DS . 'product', false, true, 'admin'); ?>
                </div>
                
                <?php if (current_user_can('checkout_styles')) : ?>
                	<div><a class="button button-secondary" href="" onclick="wpco_adminajax('<?php _e('Add a Product Variation', $this -> plugin_name); ?>', 'addproductvariationoption&width=620&height=520&product_id=<?php echo $Product -> data -> id; ?>'); return false;"><?php _e('Add a Product Variation', $this -> plugin_name); ?></a></div>
                <?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>

<script type="text/javascript">
function save_variationoptions(productid) {
	var mytime = new Date().getTime();
	var formdata = jQuery('#newvariationoptionform').serialize();
	jQuery('#variationoptionloading').show();
	
	jQuery.post(wpcoajaxurl + "?action=addproductvariationoption&mytime=" + mytime + "&product_id=" + productid, formdata, function(data) {		
		var success = jQuery("success", data).text();
		var message = jQuery("message", data).text();
		var html = jQuery("html", data).text();
		
		if (success == "Y") {
			parent.jQuery('#productvariations').html(html);
			jQuery.colorbox.close();
		} else {
			jQuery('#cboxLoadedContent').html(html);
		}
	}, 'xml');
}

function add_variationoption(title, price) {
	var optionhtml = "";
	optionhtml += '<div id="newoption' + optioncount + '">';
	optionhtml += '<fieldset>';
	optionhtml += '<legend style="font-weight:bold;"><?php _e('Variation Option', $this -> plugin_name); ?></legend>';
	optionhtml += '<table>';
	optionhtml += '<tbody>';
	optionhtml += '<tr>';
	optionhtml += '<td>';
	optionhtml += '<?php _e('Option Title/Name:', $this -> plugin_name); ?><br/>';
	optionhtml += '<input type="text" name="newoptions[' + optioncount + '][title]" value="' + title + '" id="newoptions_' + optioncount + '_title" />';
	optionhtml += '</td>';
	optionhtml += '<td style="width:10px;"></td>';
	optionhtml += '<td>';
	optionhtml += '<?php _e('Option Price:', $this -> plugin_name); ?><br/>';
	optionhtml += '<select name="newoptions[' + optioncount + '][symbol]">';
	optionhtml += '<option value="+">+</option>';
	optionhtml += '<option value="-">-</option>';
	optionhtml += '</select>';
	optionhtml += '<select name="newoptions[' + optioncount + '][operator]">';
	optionhtml += '<option value="curr"><?php echo $wpcoHtml -> currency(); ?></option>';
	optionhtml += '<option value="perc">&#37;</option>';
	optionhtml += '</select>';
	optionhtml += '<input type="text" name="newoptions[' + optioncount + '][price]" value="' + price + '" id="newoptions_' + optioncount + '_price" style="width:65px;" />';
	optionhtml += '</td>';
	optionhtml += '</tr>';
	optionhtml += '</tbody>';
	optionhtml += '</table>';
	optionhtml += '<a href="" onclick="if (confirm(\'<?php _e('Are you sure you want to remove this option?', $this -> plugin_name); ?>\')) { delete_option(\'' + optioncount + '\', false); } return false;"><?php _e('Remove this option', $this -> plugin_name); ?></a><br/><br/>';
	optionhtml += '</fieldset>';
	optionhtml += '</div>';
	jQuery('#newoptions').append(optionhtml);
	jQuery('#newoptions_' + optioncount + '_title').focus();
	optioncount++;
}

function delete_option(countid, option_id) {
	if (option_id) {
		jQuery.ajax(wpcoajaxurl + '?action=wpcodeleteoption', {
			type: "POST",
			data: {option_id:option_id}
		});
	}

	jQuery('#newoption' + countid).remove();
	jQuery.colorbox.resize();
}
</script>