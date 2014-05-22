<table class="form-table">
	<tbody>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>merchantemail"><?php _e('Merchant/Admin Email', $this -> plugin_name); ?></label></th>
			<td>
				<input class="widefat" type="text" name="merchantemail" id="<?php echo $this -> pre; ?>merchantemail" value="<?php echo $this -> get_option('merchantemail'); ?>" />
				<span class="howto"><?php _e('Either a single email or multiple, comma separated emails eg. email1@domain.com,email2@domain.com', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>shopurl"><?php _e('Shop URL', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" class="widefat" name="shopurl" value="<?php echo $this -> get_option('shopurl'); ?>" id="<?php echo $this -> pre; ?>shopurl" />
				<span class="howto"><?php _e('Any post or page on this installation, preferrably the Shop page.', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for=""><?php _e('Target Markets', $this -> plugin_name); ?></label></th>
            <td>
            	<?php if ($countries = $Country -> select()) : ?>
                	<div>
                		<input type="checkbox" name="marketsselectall" value="1" id="marketsselectall" onclick="jqCheckAll(this, '<?php echo $this -> sections -> settings; ?>', 'markets');" />
                    	<label for="marketsselectall"><strong><?php _e('Select all Countries', $this -> plugin_name); ?></strong></label>
                    	<br/>
                    	<input type="checkbox" name="marketstatesselectall" value="1" id="marketstatesselectall" onclick="jqCheckAll(this, '<?php echo $this -> sections -> settings; ?>', 'marketstates');" />
                    	<label for="marketstatesselectall"><strong><?php _e('Select all States/Provinces', $this -> plugin_name); ?></strong></label>
                    </div>
                    
                    <?php $markets = $this -> get_option('markets'); ?>
                    <?php $marketstates = $this -> get_option('marketstates'); ?>
                    
                	<div class="multiple-select">
                    	<ul>
                        	<?php $class = ''; ?>
							<?php foreach ($countries as $country_id => $country_value) : ?>
                                <li<?php echo $class = (empty($class)) ? ' class="odd"' : ''; ?>>
                                	<input <?php echo (!empty($markets) && in_array($country_id, $markets)) ? 'checked="checked"' : ''; ?> type="checkbox" name="markets[]" value="<?php echo $country_id; ?>" id="market-<?php echo $country_id; ?>" />
                                    <label for="market-<?php echo $country_id; ?>"><?php echo $country_value; ?></label>
                                    <?php $wpcoDb -> model = $wpcoState -> model; ?>
                                    <?php if ($states = $wpcoDb -> find_all(array('country_id' => $country_id), array('id', 'name'), array('name', "ASC"))) : ?>
                                    	<ul>
                                    		<li>
                                    			<label style="font-weight:bold;"><input onclick="jqCheckAllByClass(this, 'marketstateof<?php echo $country_id; ?>');" type="checkbox" name="marketstatesselectallfor<?php echo $country_id; ?>" value="1" id="marketstatesselectallfor<?php echo $country_id; ?>" /> <?php _e('Select all', $this -> plugin_name); ?></label>
                                    		</li>
                                    		<?php foreach ($states as $state) : ?>
                                    			<li>
                                    				<input <?php echo (!empty($marketstates) && in_array($state -> id, $marketstates)) ? 'checked="checked"' : ''; ?> type="checkbox" name="marketstates[]" value="<?php echo $state -> id; ?>" class="marketstateof<?php echo $country_id; ?>" id="marketstate-<?php echo $state -> id; ?>" />
                                    				<label for="marketstate-<?php echo $state -> id; ?>"><?php echo __($state -> name); ?></label>
                                    			</li>
                                    		<?php endforeach; ?>
                                    	</ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <span class="howto"><?php _e('Select the countries and states/provinces available to customers in the shop.', $this -> plugin_name); ?></span>
                <?php else : ?>
                	<p class="error"><?php echo sprintf(__('No countries are available, %s.', $this -> plugin_name), '<a href="?page=' . $this -> sections -> settings . '&amp;method=loadcountries">load them now</a>'); ?></p>
                <?php endif; ?>
            </td>
        </tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>currency"><?php _e('Currency', $this -> plugin_name); ?></label></th>
			<td>
				<?php $currencies = $this -> get_option('currencies'); ?>
				<select style="width:auto;" class="widefat" id="<?php echo $this -> pre; ?>currency" name="currency">
					<?php foreach ($currencies as $ckey => $curr) : ?>
						<option <?php echo ($this -> get_option('currency') == $ckey) ? 'selected="selected"' : ''; ?> value="<?php echo $ckey; ?>"><?php echo $curr['symbol']; ?> - <?php echo $curr['name']; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="currency_position_before"><?php _e('Currency Symbol Position', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('currency_position') == "before") ? 'checked="checked"' : ''; ?> type="radio" name="currency_position" value="before" id="currency_position_before" /> <?php _e('Before', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('currency_position') == "after") ? 'checked="checked"' : ''; ?> type="radio" name="currency_position" value="after" id="currency_position_after" /> <?php _e('After', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Should the currency symbol be placed before or after the price?', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="currency_decimalseparator"><?php _e('Decimal Separator', $this -> plugin_name); ?></label></th>
            <td>
            	<input style="width:45px;" type="text" name="currency_decimalseparator" value="<?php echo esc_attr(stripslashes($this -> get_option('currency_decimalseparator'))); ?>" id="currency_decimalseparator" />
            	<span class="howto"><?php _e('Decimal separator for prices in the shop for display purposes.', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="showcaseY"><?php _e('Showcase Website', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('showcase') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="showcase" value="Y" id="showcaseY" /> <?php _e('On', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('showcase') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="showcase" value="N" id="showcaseN" /> <?php _e('Off', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Turn this On for a website with showcase products only without any prices or sales.', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="showcasemsg"><?php _e('Global Showcase Message', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" name="showcasemsg" value="<?php echo esc_attr(stripslashes($this -> get_option('showcasemsg'))); ?>" id="showcasemsg" />
                <span class="howto"><?php _e('Message to display for showcase products on category and product pages.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="tinymcebutton_Y"><?php _e('TinyMCE Button', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('tinymcebutton') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="tinymcebutton" value="Y" id="tinymcebutton_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('tinymcebutton') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="tinymcebutton" value="N" id="tinymcebutton_N" /> <?php _e('No', $this -> plugin_name); ?></label>
            </td>
        </tr>
        <tr>
        	<th><label for="gzip_Y"><?php _e('Enable Gzip Compression', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('gzip') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="gzip" value="Y" id="gzip_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('gzip') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="gzip" value="N" id="gzip_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('Performance increase that compresses all content on your WordPress website using the ob_gzhandler() callback', $this -> plugin_name); ?></span>
            </td>
        </tr>
	</tbody>
</table>