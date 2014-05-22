<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Save a Shipping Method', $this -> plugin_name); ?></h2>

	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post" id="wpcoshipmethod">	
		<?php echo $wpcoForm -> hidden('wpcoShipmethod.id'); ?>
	
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="wpcoShipmethod.name"><?php _e('Name', $this -> plugin_name); ?></label></th>
					<td>
						<?php echo $wpcoForm -> text('wpcoShipmethod.name'); ?>
                        <span class="howto"><?php _e('Shipping method name as it will appear on your store front', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><label for="wpcoShipmethod.fixed"><?php _e('Fixed Price', $this -> plugin_name); ?></label></th>
					<td>
						<?php echo $wpcoHtml -> currency_html($wpcoForm -> text('wpcoShipmethod.fixed', array('class' => "", 'width' => "65px"))); ?>
                        <span class="howto"><?php _e('when using an API below, please set this to zero (0)', $this -> plugin_name); ?></span>
					</td>
				</tr>
                <tr>
                	<th><label for=""><?php _e('Status', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php $statusses = array("active" => __('Active', $this -> plugin_name), "inactive" => __('Inactive', $this -> plugin_name)); ?>
                        <?php echo $wpcoForm -> radio('wpcoShipmethod.status', $statusses, array('separator' => false, 'default' => "active")); ?>
                    	<span class="howto"><?php _e('Set to "Inactive" to hide from the shop front', $this -> plugin_name); ?></span>
                    </td>
                </tr>
				<tr>
					<th><?php _e('Use API', $this -> plugin_name); ?></th>
					<td>
						<?php $apis = $wpcoHtml -> shipping_apis(); ?>
						<?php if (!empty($apis)) : ?>
							<div id="apisdiv">
								<ul>
									<?php foreach ($apis as $api_key => $api_val) : ?>
										<li><label><input <?php echo ($wpcoHtml -> field_value('wpcoShipmethod.api') == $api_key) ? 'checked="checked"' : ''; ?> onclick="change_api(this.value);" type="radio" name="wpcoShipmethod[api]" value="<?php echo $api_key; ?>" id="wpcoShipmethod_api_<?php echo $api_key; ?>" /> <?php echo $api_val; ?></label></li>
									<?php endforeach; ?>
									<?php do_action($this -> pre . '_shipmethod_save_apis', $wpcoHtml -> field_value('wpcoShipmethod.api')); ?>
								</ul>
								<br class="clear" />
							</div>
						<?php endif; ?>
						
						<script type="text/javascript">
						function change_api(api) {
							jQuery('[id^=apidiv_]').hide();
							jQuery('#apidiv_' + api).show();
						}
						</script>
						
						<span class="howto"><?php _e('select the appropriate API for your shipping provider. if not in the list, choose NO', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<span id="apidiv_0" style="display:none;"></span>
		
		<?php $api_options = maybe_unserialize($wpcoHtml -> field_value('wpcoShipmethod.api_options')); ?>
		<?php do_action($this -> pre . '_shipmethod_save_divs', $wpcoHtml -> field_value('wpcoShipmethod.api'), $api_options); ?>
		
		<div id="apidiv_auspost" style="display:<?php echo ($wpcoHtml -> field_value('wpcoShipmethod.api') == "auspost") ? 'block' : 'none'; ?>;">			
			<p><?php _e('The Australian Post DRC API returns shipping based on weight in Australian Dollars. Be sure to set your currency to Australian Dollars.', $this -> plugin_name); ?></p>
		
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Pickup_Postcode"><?php _e('Pickup Postcode', $this -> plugin_name); ?></label></th>
						<td>
							<input type="text" class="widefat" style="width:65px;" name="wpcoShipmethod[api_options][Pickup_Postcode]" value="<?php echo esc_attr($api_options['Pickup_Postcode']); ?>" id="Pickup_Postcode" />
							<span class="howto"><?php _e('postal code from where order is picked up from', $this -> plugin_name); ?></span>
						</td>
					</tr>
					<tr>
						<th><label for="api_options_Service_Type_STANDARD"><?php _e('Service Types', $this -> plugin_name); ?></label></th>
						<td>
							<?php $auspost = $this -> vendor('auspost', 'shipping' . DS); ?>
							<?php $service_types = $auspost -> servicetypes; ?>
							<?php foreach ($service_types as $skey => $sval) : ?>
								<label><input <?php echo (!empty($api_options['auspost_servicetypes']) && in_array($skey, $api_options['auspost_servicetypes'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="wpcoShipmethod[api_options][auspost_servicetypes][]" value="<?php echo $skey; ?>" id="api_options_Service_Type_<?php echo $skey; ?>" /> <?php echo $sval; ?></label><br/>
							<?php endforeach; ?>
							<span class="howto"><?php _e('Tick/check the service types to calculate shipping services/rates for.', $this -> plugin_name); ?></span>
						</td>
					</tr>
					<tr>
                    	<th><label for="auspost_debug_N"><?php _e('Debugging', $this -> plugin_name); ?></label></th>
                        <td>
                        	<label><input <?php echo (!empty($api_options['auspost_debug']) && $api_options['auspost_debug'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoShipmethod[api_options][auspost_debug]" value="Y" id="auspost_debug_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
                            <label><input <?php echo (empty($api_options['auspost_debug']) || $api_options['auspost_debug'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoShipmethod[api_options][auspost_debug]" value="N" id="auspost_debug_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
                        	<span class="howto"><?php _e('Turn this On if you experience problems with Australia Post and turn Off for a live/production site.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
				</tbody>
			</table>
		</div>
        
        <div id="apidiv_usps" style="display:<?php echo ($wpcoHtml -> field_value('wpcoShipmethod.api') == "usps") ? 'block' : 'none'; ?>">            
            <p><?php _e('It is recommended that you use a PRODUCTION account for the USPS shipping API.', $this -> plugin_name); ?><br/>
            <?php _e('Instructions for setting up USPS can be found', $this -> plugin_name); ?> <a href="http://docs.tribulant.com/wordpress-shopping-cart-plugin/3511" target="_blank"><?php _e('here.', $this -> plugin_name); ?></a></p>
        
        	<table class="form-table">
            	<tbody>
                	<tr>
                    	<th><label for="usps_test_N"><?php _e('USPS Account', $this -> plugin_name); ?></label></th>
                        <td>
                        	<label><input <?php echo (empty($api_options['usps_test']) || $api_options['usps_test'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoShipmethod[api_options][usps_test]" value="Y" id="usps_test_Y" /> <?php _e('Test', $this -> plugin_name); ?></label>
                            <label><input <?php echo ($api_options['usps_test'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoShipmethod[api_options][usps_test]" value="N" id="usps_test_N" /> <?php _e('Production (recommended)', $this -> plugin_name); ?></label>
                        </td>
                    </tr>
                	<tr>
                    	<th><label for="usps_username"><?php _e('USPS Username', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][usps_username]" value="<?php echo esc_attr(stripslashes($api_options['usps_username'])); ?>" id="usps_username" />
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="usps_password"><?php _e('USPS Password', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][usps_password]" value="<?php echo esc_attr(stripslashes($api_options['usps_password'])); ?>" id="usps_password" />
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="usps_debug_N"><?php _e('Debugging', $this -> plugin_name); ?></label></th>
                        <td>
                        	<label><input <?php echo (!empty($api_options['usps_debug']) && $api_options['usps_debug'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoShipmethod[api_options][usps_debug]" value="Y" id="usps_debug_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
                            <label><input <?php echo (empty($api_options['usps_debug']) || $api_options['usps_debug'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoShipmethod[api_options][usps_debug]" value="N" id="usps_debug_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
                        	<span class="howto"><?php _e('Turn this On if you experience problems with USPS and turn Off for a live/production site.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod.uspsselectall"><?php _e('Services', $this -> plugin_name); ?></label></th>
                        <td>
                        	<?php if ($usps_services = $this -> get_option('usps_services')) : ?>
                            	<label><input onclick="jqCheckAll(this, 'wpcoshipmethod', 'wpcoShipmethod\\[api_options\\]\\[usps_services\\]');" type="checkbox" name="selectall" value="1" id="wpcoShipmethod.uspsselectall" /> <strong><?php _e('Select All', $this -> plugin_name); ?></strong></label><br/>
                            	<?php foreach ($usps_services as $usps_servicecode => $usps_servicename) : ?>
                                	<label><input <?php echo (!empty($api_options['usps_services']) && in_array($usps_servicecode, $api_options['usps_services'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="wpcoShipmethod[api_options][usps_services][]" value="<?php echo $usps_servicecode; ?>" id="wpcoShipmethod.api_options.usps_services.<?php echo $usps_servicecode; ?>" /> <?php echo $usps_servicename; ?></label><br/>
                                <?php endforeach; ?>
                            <?php else : ?>
                            	<?php _e('No USPS services found, please reset configuration settings.', $this -> plugin_name); ?>
                            <?php endif; ?>
                        	<span class="howto"><?php _e('select the services to fetch rates for.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="usps_firstclassmailtype"><?php _e('First Class Mail Type', $this -> plugin_name); ?></label></th>
                        <td>
                        	<select name="wpcoShipmethod[api_options][usps_firstclassmailtype]" id="usps_firstclassmailtype">
                            	<option <?php echo (!empty($api_options['usps_firstclassmailtype']) && $api_options['usps_firstclassmailtype'] == "FLAT") ? 'selected="selected"' : ''; ?> value="FLAT"><?php _e('Flat', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['usps_firstclassmailtype']) && $api_options['usps_firstclassmailtype'] == "LETTER") ? 'selected="selected"' : ''; ?> value="LETTER"><?php _e('Letter', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['usps_firstclassmailtype']) && $api_options['usps_firstclassmailtype'] == "PARCEL") ? 'selected="selected"' : ''; ?> value="PARCEL"><?php _e('Parcel', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['usps_firstclassmailtype']) && $api_options['usps_firstclassmailtype'] == "POSTCARD") ? 'selected="selected"' : ''; ?> value="POSTCARD"><?php _e('Postcard', $this -> plugin_name); ?></option>
                            </select>
                        	<span class="howto"><?php _e('Applicable to the First Class services only.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>                    
                    <tr>
                    	<th><label for=""><?php _e('Origin/Warehouse Zip Code', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][usps_originzip]" value="<?php echo esc_attr(stripslashes($api_options['usps_originzip'])); ?>" id="" />
                        </td>
                    </tr>                    
                </tbody>
            </table>
        </div>
        
        <!-- Canada Post -->
        <div id="apidiv_canadapost" style="display:<?php echo ($wpcoHtml -> field_value('wpcoShipmethod.api') == "canadapost") ? 'block' : 'none'; ?>;">            
            <p>
            	<strong><?php _e('Please note these important things about Canada Post:', $this -> plugin_name); ?></strong>
            
            	<ul>
                	<li><?php _e('* All product weights must be in Kg (kilogram)', $this -> plugin_name); ?></li>
                    <li><?php _e('* Weight, width, length and height are required for all products', $this -> plugin_name); ?></li>
                    <li><?php _e('* Rates are calculated in Canadian Dollars (CAD)', $this -> plugin_name); ?></li>
                </ul>
                
                <br/>
                <?php _e('Instructions for setting up Canada Post can be found', $this -> plugin_name); ?> <a href="http://docs.tribulant.com/wordpress-shopping-cart-plugin/2884" target="_blank"><?php _e('here.', $this -> plugin_name); ?></a>
            </p>
        
        	<table class="form-table">
            	<tbody>
                	<tr>
                    	<th><label for="wpcoShipmethod.api_options.CSCID"><?php _e('Retailer ID', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input class="widefat" style="width:250px;" type="text" id="wpcoShipmethod.api_options.CSCID" name="wpcoShipmethod[api_options][CSCID]" value="<?php echo esc_attr(stripslashes($api_options['CSCID'])); ?>" />
                            <span class="howto"><?php _e('the retailer ID can be obtained from your Sell Online shipping profile.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod.api_options.ORIGZIP"><?php _e('Origin/Warehouse Postal Code', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input class="widefat" style="width:65px;" type="text" id="wpcoShipmethod.api_options.ORIGZIP" name="wpcoShipmethod[api_options][ORIGZIP]" value="<?php echo esc_attr(stripslashes($api_options['ORIGZIP'])); ?>" />
                        </td>
                    </tr>
                    <tr>
                    	<th><label for=""><?php _e('Turnaround Time', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input class="widefat" style="width:65px;" type="text" id="wpcoShipmethod.api_options.TURNAROUND" name="wpcoShipmethod[api_options][TURNAROUND]" value="<?php echo esc_attr(stripslashes($api_options['TURNAROUND'])); ?>" /> <?php _e('hours', $this -> plugin_name); ?>
                        </td>
                    </tr>
                    <?php /*
                    <tr>
                    	<th><label for="canadapost_debug_N"><?php _e('Debugging', $this -> plugin_name); ?></label></th>
                        <td>
                        	<label><input <?php echo (!empty($api_options['canadapost_debug']) && $api_options['canadapost_debug'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoShipmethod[api_options][canadapost_debug]" value="Y" id="canadapost_debug_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
                            <label><input <?php echo (empty($api_options['canadapost_debug']) || $api_options['canadapost_debug'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoShipmethod[api_options][canadapost_debug]" value="N" id="canadapost_debug_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
                        	<span class="howto"><?php _e('Turn this On if you experience problems with USPS and turn Off for a live/production site.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
					*/ ?>
                </tbody>
            </table>
        </div>
        
        <!-- FedEx -->
        <div id="apidiv_fedex" style="display:<?php echo ($wpcoHtml -> field_value('wpcoShipmethod.api') == "fedex") ? 'block' : 'none'; ?>;">            
            <p><?php _e('Instructions for setting up FedEx can be found', $this -> plugin_name); ?> <a href="http://docs.tribulant.com/wordpress-shopping-cart-plugin/3304" target="_blank"><?php _e('here.', $this -> plugin_name); ?></a></p>
        
        	<table class="form-table">
            	<tbody>
                	<tr>
                    	<th><label for="wpcoShipmethod.api_options.FedExServer.beta"><?php _e('FedEx Server', $this -> plugin_name); ?></label></th>
                        <td>
                        	<label><input <?php echo (!empty($api_options['FedExServer']) && $api_options['FedExServer'] == "live") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoShipmethod[api_options][FedExServer]" value="live" id="wpcoShipmethod.api_options.FedExServer.live" /> <?php _e('Live/Production Gateway', $this -> plugin_name); ?></label>
                            <label><input <?php echo (empty($api_options['FedExServer']) || $api_options['FedExServer'] == "beta") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoShipmethod[api_options][FedExServer]" value="beta" id="wpcoShipmethod.api_options.FedExServer.beta" /> <?php _e('Beta/Development Gateway', $this -> plugin_name); ?></label>
                            <span class="howto"><?php _e('Use the FedEx live/production server for a production account and beta/development server for a development account.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod_api_options_fedex_key"><?php _e('FedEx Key', $this -> plugin_name); ?></label></th>
                    	<td>
                    		<input type="text" name="wpcoShipmethod[api_options][fedex_key]" value="<?php echo esc_attr(stripslashes($api_options['fedex_key'])); ?>" id="wpcoShipmethod_api_options_fedex_key" />
                    		<span class="howto"></span>
                    	</td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod_api_options_fedex_password"><?php _e('FedEx Password', $this -> plugin_name); ?></label></th>
                    	<td>
                    		<input type="text" name="wpcoShipmethod[api_options][fedex_password]" value="<?php echo esc_attr(stripslashes($api_options['fedex_password'])); ?>" id="wpcoShipmethod_api_options_fedex_password" />
                    		<span class="howto"></span>
                    	</td>
                    </tr>
                	<tr>
                    	<th><label for="wpcoShipmethod_api_options_fedex_account"><?php _e('FedEx Account Number', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][fedex_account]" value="<?php echo esc_attr(stripslashes($api_options['fedex_account'])); ?>" id="wpcoShipmethod_api_options_fedex_account" />
                            <span class="howto"><?php _e('FedEx Web Services account number given by FedEx upon registration', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod_api_options_fedex_meter"><?php _e('FedEx Meter Number', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][fedex_meter]" value="<?php echo esc_attr(stripslashes($api_options['fedex_meter'])); ?>" id="wpcoShipmethod_api_options_fedex_meter" />
                            <span class="howto"><?php _e('FedEx Web Services meter number given by FedEx upon registration', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod.api_options.CarrierCode"><?php _e('Carrier Code', $this -> plugin_name); ?></label></th>
                        <td>
                        	<!-- FDXG, FDXE -->
                            <select name="wpcoShipmethod[api_options][CarrierCode]" id="wpcoShipmethod.api_options.CarrierCode">
                            	<option <?php echo (empty($api_options['CarrierCode']) || (!empty($api_options['CarrierCode']) && $api_options['CarrierCode'] == "FDXG")) ? 'selected="selected"' : ''; ?> value="FDXG"><?php _e('FedEx Ground (default)', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['CarrierCode']) && $api_options['CarrierCode'] == "FDXE") ? 'selected="selected"' : ''; ?> value="FDXE"><?php _e('FedEx Express', $this -> plugin_name); ?></option>
                            </select>
                            <span class="howto"><?php _e('FedEx carrier code of your choice', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod.api_options.DropoffType"><?php _e('Dropoff Type', $this -> plugin_name); ?></label></th>
                        <td>
                        	<!-- REGULARPICKUP, REQUESTCOURIER, DROPBOX, BUSINESSSERVICE CENTER, STATION -->
                            <select name="wpcoShipmethod[api_options][fedex_dropofftype]" id="wpcoShipmethod_api_options_fedex_dropofftype">
                            	<!--
                            	BUSINESS_SERVICE_CENTER
                            	DROP_BOX
                            	REGULAR_PICKUP
                            	REQUEST_COURIER
                            	STATION
                            	-->
                            	<option <?php echo (!empty($api_options['DropoffType']) && $api_options['fedex_dropofftype'] == "REGULAR_PICKUP") ? 'selected="selected"' : ''; ?> value="REGULAR_PICKUP"><?php _e('Regular Pickup (default)', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['DropoffType']) && $api_options['fedex_dropofftype'] == "REQUEST_COURIER") ? 'selected="selected"' : ''; ?> value="REQUEST_COURIER"><?php _e('Request Courier', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['DropoffType']) && $api_options['fedex_dropofftype'] == "DROP_BOX") ? 'selected="selected"' : ''; ?> value="DROPBOX"><?php _e('Drop Box', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['DropoffType']) && $api_options['fedex_dropofftype'] == "BUSINESS_SERVICE_CENTER") ? 'selected="selected"' : ''; ?> value="BUSINESS_SERVICE_CENTER"><?php _e('Business Service Center', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['DropoffType']) && $api_options['fedex_dropofftype'] == "STATION") ? 'selected="selected"' : ''; ?> value="STATION"><?php _e('Station', $this -> plugin_name); ?></option>
                            </select>
                            <span class="howto"><?php _e('Only Regular Pickup, Request Courier, and Station are allowed with International freight shipping. This element does not dispatch a courier.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod.selectall"><?php _e('Available Services', $this -> plugin_name); ?></label></th>
                        <td>
                        	<?php if ($fedex_services = $this -> get_option('fedex_services')) : ?>
                            	<label><input onclick="jqCheckAll(this, 'wpcoshipmethod', 'wpcoShipmethod[api_options][Service]');" type="checkbox" name="selectall" value="1" id="wpcoShipmethod.selectall" /> <strong><?php _e('Select All', $this -> plugin_name); ?></strong></label><br/>
                            	<div class="scroll-list">
	                            	<?php foreach ($fedex_services as $fedex_servicecode => $fedex_servicename) : ?>
	                                	<label><input <?php echo (!empty($api_options['Service']) && in_array($fedex_servicecode, $api_options['Service'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="wpcoShipmethod[api_options][Service][]" value="<?php echo $fedex_servicecode; ?>" id="wpcoShipmethod.api_options.Service.<?php echo $fedex_servicecode; ?>" /> <?php echo $fedex_servicename; ?></label><br/>
	                                <?php endforeach; ?>
                            	</div>
                            <?php endif; ?>
                            <span class="howto"><?php _e('it is recommended that you select all of these services since the plugin will automatically eliminate the inapplicable ones during rate calculation.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod_api_options_fedex_packagingtype"><?php _e('Packaging Type', $this -> plugin_name); ?></label></th>
                        <td>
                        	<!-- FEDEX_10KG_BOX FEDEX_25KG_BOX FEDEX_BOX FEDEX_ENVELOPE FEDEX_PAK FEDEX_TUBE YOUR_PACKAGING -->
                            <select name="wpcoShipmethod[api_options][fedex_packagingtype]" id="wpcoShipmethod_api_options_fedex_packagingtype">
                            	<option <?php echo (!empty($api_options['fedex_packagingtype']) && $api_options['fedex_packagingtype'] == "YOUR_PACKAGING") ? 'selected="selected"' : ''; ?> value="YOUR_PACKAGING"><?php _e('Your Own Packaging (default)', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['fedex_packagingtype']) && $api_options['fedex_packagingtype'] == "FEDEX_ENVELOPE") ? 'selected="selected"' : ''; ?> value="FEDEX_ENVELOPE"><?php _e('FedEx Envelope', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['fedex_packagingtype']) && $api_options['fedex_packagingtype'] == "FEDEX_PAK") ? 'selected="selected"' : ''; ?> value="FEDEX_PAK"><?php _e('FedEx Pak', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['fedex_packagingtype']) && $api_options['fedex_packagingtype'] == "FEDEX_BOX") ? 'selected="selected"' : ''; ?> value="FEDEX_BOX"><?php _e('FedEx Box', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['fedex_packagingtype']) && $api_options['fedex_packagingtype'] == "FEDEX_TUBE") ? 'selected="selected"' : ''; ?> value="FEDEX_TUBE"><?php _e('FedEx Tube', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['fedex_packagingtype']) && $api_options['fedex_packagingtype'] == "FEDEX_10KG_BOX") ? 'selected="selected"' : ''; ?> value="FEDEX_10KG_BOX"><?php _e('FedEx 10Kg Box', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['fedex_packagingtype']) && $api_options['fedex_packagingtype'] == "FEDEX_25KG_BOX") ? 'selected="selected"' : ''; ?> value="FEDEX_25KG_BOX"><?php _e('Fedex 25Kg Box', $this -> plugin_name); ?></option>
                            </select>
                            <span class="howto"><?php _e('Select your type of packaging type, the default is Your Own Packaging', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod.api_options.WeightUnits"><?php _e('Weight Units', $this -> plugin_name); ?></label></th>
                        <td>
							<!-- LBS, KGS -->
                            <select name="wpcoShipmethod[api_options][WeightUnits]" id="wpcoShipmethod.api_options.WeightUnits">
                            	<option <?php echo (!empty($api_options['WeightUnits']) && $api_options['WeightUnits'] == "LBS") ? 'selected="selected"' : ''; ?> value="LBS"><?php _e('Pounds (LBS)', $this -> plugin_name); ?></option>
                                <option <?php echo (!empty($api_options['WeightUnits']) && $api_options['WeightUnits'] == "KGS") ? 'selected="selected"' : ''; ?> value="KGS"><?php _e('Kilograms (KGS)', $this -> plugin_name); ?></option>
                            </select>
                            <span class="howto"><?php _e('Weight measurement. Keep this the same as in the Configuration section.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod.api_options.orig_StateOrProvinceCode"><?php _e('Origin State/Province Code', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][orig_StateOrProvinceCode]" value="<?php echo esc_attr(stripslashes($api_options['orig_StateOrProvinceCode'])); ?>" id="wpcoShipmethod.api_options.orig_StateOrProvinceCode" />
                        	<span class="howto"><?php _e('eg. OH, AL, TX, etc. only fill this in when the country below is United States or Canada', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod.api_options.orig_PostalCode"><?php _e('Origin Zip/Postal Code', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][orig_PostalCode]" value="<?php echo esc_attr(stripslashes($api_options['orig_PostalCode'])); ?>" id="wpcoShipmethod.api_options.orig_PostalCode" />
                        	<span class="howto"><?php _e('origin/warehouse zip/postal code', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="wpcoShipmethod.api_options.orig_CountryCode"><?php _e('Origin Country', $this -> plugin_name); ?></label></th>
                        <td>
                        	<?php global $wpdb, $Country; ?>
                        	<?php if ($countries = $wpdb -> get_results("SELECT `id`, `value`, `code` FROM `" . $wpdb -> prefix . "" . $Country -> table . "` ORDER BY `value` ASC")) : ?>
                            	<select name="wpcoShipmethod[api_options][orig_CountryCode]" id="wpcoShipmethod.api_options.orig_CountryCode">
                                	<?php foreach ($countries as $country) : ?>
                                    	<option <?php echo (!empty($api_options['orig_CountryCode']) && $api_options['orig_CountryCode'] == $country -> code) ? 'selected="selected"' : ''; ?> value="<?php echo $country -> code; ?>"><?php echo $country -> value; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                            	<p class="error"><?php echo sprintf(__('No countries are available, %s.', $this -> plugin_name), '<a href="?page=' . $this -> sections -> settings . '&amp;method=loadcountries">load them now</a>'); ?></p>
                            <?php endif; ?>
                        	<span class="howto"><?php _e('origin/warehouse country', $this -> plugin_name); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- UPS API Options -->
        <div id="apidiv_ups" style="display:<?php echo ($wpcoHtml -> field_value('wpcoShipmethod.api') == "ups") ? 'block' : 'none'; ?>;">            
            <table class="form-table">
            	<tbody>
                	<!-- UPS Accesskey -->
                	<tr>
                    	<th><label for="ups_accesskey"><?php _e('UPS Access Key', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][ups_accesskey]" value="<?php echo esc_attr(stripslashes($api_options['ups_accesskey'])); ?>" id="ups_accesskey" />
                        </td>
                    </tr>
                    <!-- UPS User ID -->
                    <tr>
                    	<th><label for="ups_userid"><?php _e('UPS User ID', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][ups_userid]" value="<?php echo esc_attr(stripslashes($api_options['ups_userid'])); ?>" id="ups_userid" />
                        </td>
                    </tr>
                    <!-- UPS Password -->
                    <tr>
                    	<th><label for="ups_password"><?php _e('UPS Password', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][ups_password]" value="<?php echo esc_attr(stripslashes($api_options['ups_password'])); ?>" id="ups_password" />
                        </td>
                    </tr>
                    <!-- UPS Pickup Type -->
                    <tr>
                    	<th><label for="ups_pickuptype"><?php _e('Pickup Type', $this -> plugin_name); ?></label></th>
                        <td>
                        	<?php global $ups_pickuptypes; ?>
                        	<?php require_once $this -> plugin_base() . DS . 'includes' . DS . 'variables.php'; ?>
                        	<select name="wpcoShipmethod[api_options][ups_pickuptype]" id="ups_pickuptype">
                            	<option value=""><?php _e('- Select Pickup Type -', $this -> plugin_name); ?></option>
                                <?php foreach ($ups_pickuptypes as $ups_ptkey => $ups_ptval) : ?>
                                	<option <?php echo ($api_options['ups_pickuptype'] == $ups_ptkey) ? 'selected="selected"' : ''; ?> value="<?php echo $ups_ptkey; ?>"><?php echo $ups_ptval; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <!-- UPS Weight Type -->
                    <tr>
                    	<th><label for="ups_weighttype"><?php _e("Weight Type", $this -> plugin_name); ?></label></th>
                        <td>
                        	<select name="wpcoShipmethod[api_options][ups_weighttype]" id="ups_weighttype">
                            	<option value=""><?php _e('- Select Weight Type', $this -> plugin_name); ?></option>
                                <option <?php echo ($api_options['ups_weighttype'] == "LBS") ? 'selected="selected"' : ''; ?> value="LBS"><?php _e('Pounds (LBS)', $this -> plugin_name); ?></option>
                                <option <?php echo ($api_options['ups_weighttype'] == "KGS") ? 'selected="selected"' : ''; ?> value="KGS"><?php _e('Kilograms (KGS)', $this -> plugin_name); ?></option>
                            </select>
                        </td>
                    </tr>
                    <!-- UPS Services -->
                    <tr>
                    	<th><label for=""><?php _e('Available Services', $this -> plugin_name); ?></label></th>
                    	<td>
                    		<?php
                    		
                    		$ups = $this -> vendor('ups', 'shipping' . DS . 'ups' . DS);
                    		$service_codes = $ups -> service_codes(false, true);
                    		
                    		?>
                    		<?php if (!empty($service_codes)) : ?>
                    			<label style="font-weight:bold;"><input onclick="jqCheckAll(this, false, 'wpcoShipmethod[api_options][ups_services]');" type="checkbox" name="ups_checkboxall" value="1" id="ups_checkboxall" /> <?php _e('Select All', $this -> plugin_name); ?></label>
                    			<div class="scroll-list">
	                    			<?php foreach ($service_codes as $code => $service) : ?>
	                    				<label><input <?php echo (!empty($api_options['ups_services']) && in_array($code, $api_options['ups_services'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="wpcoShipmethod[api_options][ups_services][]" value="<?php echo $code; ?>" id="ups_services_<?php echo $code; ?>" /> <?php _e($service); ?></label><br/>
	                    			<?php endforeach; ?>
                    			</div>
                    		<?php endif; ?>
                    		<span class="howto"><?php _e('Choose the services that you want to allow customers to select from.', $this -> plugin_name); ?></span>
                    	</td>
                    </tr>
                    <!-- UPS State/Province -->
                    <tr>
                    	<th><label for="ups_fromstate"><?php _e('Origin State/Province Code', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][ups_fromstate]" value="<?php echo esc_attr(stripslashes($api_options['ups_fromstate'])); ?>" id="ups_fromstate" />
                        	<span class="howto"><?php _e('eg. OH, AL, TX, etc. only fill this in when the country below is United States or Canada', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <!-- UPS Zip Code -->
                    <tr>
                    	<th><label for="ups_fromzip"><?php _e('Origin Zip/Postal Code', $this -> plugin_name); ?></label></th>
                        <td>
                        	<input type="text" name="wpcoShipmethod[api_options][ups_fromzip]" value="<?php echo esc_attr(stripslashes($api_options['ups_fromzip'])); ?>" id="ups_fromzip" />
                        	<span class="howto"><?php _e('origin/warehouse zip/postal code', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <!-- UPS Country -->
                    <tr>
                    	<th><label for="ups_fromcountry"><?php _e('Origin Country', $this -> plugin_name); ?></label></th>
                        <td>
                        	<?php global $wpdb, $Country; ?>
                        	<?php if ($countries = $wpdb -> get_results("SELECT `id`, `value`, `code` FROM `" . $wpdb -> prefix . "" . $Country -> table . "` ORDER BY `value` ASC")) : ?>
                            	<select name="wpcoShipmethod[api_options][ups_fromcountry]" id="ups_fromcountry">
                                	<?php foreach ($countries as $country) : ?>
                                    	<option <?php echo (!empty($api_options['ups_fromcountry']) && $api_options['ups_fromcountry'] == $country -> code) ? 'selected="selected"' : ''; ?> value="<?php echo $country -> code; ?>"><?php echo $country -> value; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                            	<p class="error"><?php echo sprintf(__('No countries are available, %s.', $this -> plugin_name), '<a href="?page=' . $this -> sections -> settings . '&amp;method=loadcountries">load them now</a>'); ?></p>
                            <?php endif; ?>
                        	<span class="howto"><?php _e('origin/warehouse country', $this -> plugin_name); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
		
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save Shipping Method', $this -> plugin_name)); ?>
		</p>
	</form>
</div>