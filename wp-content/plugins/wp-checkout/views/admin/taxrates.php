<table id="taxrates-table" class="widefat">
    <?php $wpcoDb -> model = $wpcoTax -> model; ?>
    <?php if ($taxrates = $wpcoDb -> find_all()) : ?>
        <thead>
        	<tr>
        		<th style="width:30px;">&nbsp;</th>
            	<th><?php _e('Percentage', $this -> plugin_name); ?></th>
                <th><?php _e('Country', $this -> plugin_name); ?></th>
                <th><?php _e('State/Province', $this -> plugin_name); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($taxrates as $taxrate) : ?>
            	<tr>
            		<td><a class="button" href="#void" title="<?php _e('Remove this tax rate', $this -> plugin_name); ?>" onclick="if (confirm('<?php _e('Are you sure you want to delete this tax rate?', $this -> plugin_name); ?>')) { delete_taxrate('<?php echo $taxrate -> id; ?>'); } return false;">-</a></td>
                	<td><?php echo $taxrate -> percentage; ?>&#37;</td>
                    <td><?php echo $Country -> value_by_id($taxrate -> country_id); ?></td>
                    <td><?php echo (!empty($taxrate -> state) && $taxrate -> state != "undefined") ? $taxrate -> state : __('All States/Provinces', $this -> plugin_name); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <tr>
        	<td>&nbsp;</td>
            <td><input type="text" size="4" name="taxrate[rate]" value="" id="taxrate_rate" />&#37; </td>
            <td>
                <?php if ($countries = $Country -> select($domarkets = true)) : ?>
                    <select style="width:150px;" onchange="tax_states(this, 'taxes-state', 'taxrate[state]', false);" name="taxrate[country_id]" id="taxrate_country_id">
                        <?php foreach ($countries as $country_id => $country_value) : ?>
                            <option value="<?php echo $country_id; ?>"><?php echo $country_value; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else : ?>
                    <p class="error"><?php echo sprintf(__('No countries are available, %s.', $this -> plugin_name), '<a href="?page=' . $this -> sections -> settings . '&amp;method=loadcountries">load them now</a>'); ?></p>
                <?php endif; ?>
            </td>
            <td>
                <span id="taxes-state"></span>
                
                <script type="text/javascript">
				jQuery(document).ready(function() {
					tax_states('#taxrate_country_id', 'taxes-state', 'taxrate[state]', false);
				});
				</script>
            </td>
        </tr>
    </tbody>
</table>

<button id="add-tax-rate" class="button-secondary" type="button" onclick="add_taxrate();">
    <img src="<?php echo $this -> url(); ?>/images/add.png" alt="+" />
    <?php _e('Add Tax Rate', $this -> plugin_name); ?></button>
    
<span id="add-tax-rate-loading" style="display:none;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" border="0" alt="loading" /> <?php _e('loading...', $this -> plugin_name); ?></span>
            

<script type="text/javascript">
function tax_states(country, updatediv, inputname, showinput) {						
	var mytime = new Date().getTime();
	var country_id = jQuery(country).val();
	
	jQuery('#' + updatediv).html('loading...');
	
	jQuery.post(wpcoAjax + "?cmd=get_tax_states&showinput=" + showinput + "&country_id=" + country_id + "&inputname=" + inputname + "&mytime=" + mytime, false, function(response) {
		if (response != "") {
			//alert(response);
			jQuery('#shipping-country-loading').hide();
			jQuery('#' + updatediv).html(response).hide().fadeIn();
		}
	});	
}

function add_taxrate() {
	var mytime = new Date().getTime();
	var rate = jQuery('#taxrate_rate').val();
	var country_id = jQuery('#taxrate_country_id').val();
	var state = jQuery('#taxratestate').val();
	
	jQuery('#add-tax-rate-loading').show();
	
	jQuery.post(wpcoAjax + "?cmd=add_taxrate&rate=" + rate + "&country_id=" + country_id + "&state=" + state + "&mytime=" + mytime, false, function(response) {
		if (response != "") {
			jQuery('#taxrates-div').html(response).hide().fadeIn();
		}
	});	
}

function delete_taxrate(id) {
	var mytime = new Date().getTime();
	
	jQuery.post(wpcoAjax + "?cmd=delete_taxrate&id=" + id + "&mytime=" + mytime, false, function(response) {
		if (response != "") {
			jQuery('#taxrates-div').html(response).hide().fadeIn();	
		}
	});
}
</script>