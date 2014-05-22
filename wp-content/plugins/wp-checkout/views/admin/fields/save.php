<?php

if ($this -> is_plugin_active('qtranslate')) {
	global $q_config;
	$el = qtrans_getSortedLanguages();
}

?>

<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Save a Field', $this -> plugin_name); ?></h2>	
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post">
		<?php echo $wpcoForm -> hidden('wpcoField.id'); ?>
	
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="wpcoField.title"><?php _e('Title', $this -> plugin_name); ?></label></th>
					<td>
						<?php if (false && $this -> is_plugin_active('qtranslate')) : ?>
							<div id="tabs_title">
								<ul>
									<?php $tabs_title = 1; ?>
									<?php foreach ($el as $language) : ?>
										<li>
											<a href="#tabs_title_<?php echo $tabs_title; ?>"><img src="<?php echo content_url(); ?>/<?php echo $q_config['flag_location']; ?>/<?php echo $q_config['flag'][$language]; ?>" alt="<?php echo esc_attr($language); ?>" /></a>
										</li>
										<?php $tabs_title++; ?>
									<?php endforeach; ?>
								</ul>
								
								<?php $tabs_title = 1; ?>
								<?php foreach ($el as $language) : ?>
									<div id="tabs_title_<?php echo $tabs_title; ?>">
										<input <?php echo ($tabs_title == 1) ? 'onkeyup="wpml_titletoslug(this.value);"' : ''; ?> type="text" class="widefat" name="wpcoField[title][<?php echo $language; ?>]" value="<?php echo esc_attr(stripslashes($wpcoHtml -> field_value('Field[title]', $language))); ?>" id="Field_title_<?php echo $language; ?>" />
									</div>
									<?php $tabs_title++; ?>
								<?php endforeach; ?>
							</div>
						<?php else : ?>
							<?php echo $wpcoForm -> text('wpcoField.title'); ?>
						<?php endif; ?>
                        <span class="howto"><?php _e('Keep this title as short as possible, use the caption below to add description.', $this -> plugin_name); ?></span>
                    </td>
				</tr>
                <tr>
                	<th><label for="wpcoField.caption"><?php _e('Caption/Description', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php echo $wpcoForm -> textarea('wpcoField.caption', array('rows' => 2)); ?>
                    	<span class="howto"><?php _e('Optional. Give this field a descriptive caption/notation for your customers to see.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
				<tr>
					<th><label for="wpcoField.type"><?php _e('Type', $this -> plugin_name); ?></label></th>
					<td>
						<?php $types = $this -> get_option('fieldtypes'); ?>
						<?php echo $wpcoForm -> select('wpcoField.type', $types, array('onchange' => "change_type(this.value);")); ?>
						
						<script type="text/javascript">
						function change_type(type) {
							jQuery('#<?php echo $this -> pre; ?>optionsdiv').hide();
							jQuery('#datepickeroptionsdiv').hide();
							jQuery('#filediv').hide();
							
							if (type == "select" || type == "checkbox" || type == "radio") {
								jQuery('#<?php echo $this -> pre; ?>optionsdiv').show();
							}
							
							if (type == "file") {
								jQuery('#filediv').show();
							}
							
							if (type == "pre_date") {
								jQuery('#datepickeroptionsdiv').show();
							}
						}
						</script>
					</td>
				</tr>
			</tbody>
		</table>
		
		<?php $type = $wpcoHtml -> field_value('wpcoField.type'); ?>
		<div id="<?php echo $this -> pre; ?>optionsdiv" style="display:<?php echo (!empty($type) && ($type == "select" || $type == "checkbox" || $type == "radio")) ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="wpcoField.fieldoptions"><?php _e('Options', $this -> plugin_name); ?></label></th>
						<td>
							<?php $fieldoptions = ''; ?>
							<?php if ($options = $wpcoHtml -> field_value('wpcoField.fieldoptions')) : ?>
								<?php if (!empty($options) && ($newoptions = @unserialize($options)) !== false) : ?>
									<?php $o = 1; ?>
										<?php foreach ($newoptions as $option) : ?>
											<?php $fieldoptions .= $option; ?>
											<?php $fieldoptions .= ($o < count($newoptions)) ? "\n" : ""; ?>
											<?php $o++; ?>
										<?php endforeach; ?>
								<?php endif; ?>
							<?php endif; ?>
							<?php $wpcoField -> data -> fieldoptions = $fieldoptions; ?>
							<?php echo $wpcoForm -> textarea('wpcoField.fieldoptions'); ?>
							<span class="howto"><?php _e('Type each option on a newline', $this -> plugin_name); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div id="filediv" style="display:<?php echo (!empty($type) && $type == "file") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for=""></label></th>
						<td>
						
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div id="datepickeroptionsdiv" style="display:<?php echo (!empty($type) && $type == "pre_date") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="wpcoField.mindate"><?php _e('Min Date', $this -> plugin_name); ?></label></th>
						<td>
							<?php $mindateop = $wpcoHtml -> field_value('wpcoField.mindateop'); ?>
							<select onchange="mindateop_change(this.value);" name="wpcoField[mindateop]">
								<option <?php echo (!empty($mindateop) && $mindateop == "fixed") ? 'selected="selected"' : ''; ?> value="fixed"><?php _e('Fixed', $this -> plugin_name); ?></option>
								<option <?php echo (!empty($mindateop) && $mindateop == "neg") ? 'selected="selected"' : ''; ?> value="neg">-</option>
								<option <?php echo (!empty($mindateop) && $mindateop == "pos") ? 'selected="selected"' : ''; ?> value="pos">+</option>
							</select>
							<?php echo $wpcoForm -> text('wpcoField.mindate', array('width' => "85px")); ?>
							<span style="display:<?php echo (empty($wpcoField -> data -> mindateop) || $wpcoField -> data -> mindateop != "fixed") ? 'inline' : 'none'; ?>;" id="mindateopdays"><?php _e('days', $this -> plugin_name); ?><span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('Smallest allowed date in days from the current date.', $this -> plugin_name); ?></span></span>
							<span style="display:<?php echo (!empty($wpcoField -> data -> mindateop) && $wpcoField -> data -> mindateop == "fixed") ? 'inline' : 'none'; ?>;" id="mindateopformat" style="display:none;"><span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('Fixed date as the minimum in the format mm/dd/yyy eg. 12/31/2012', $this -> plugin_name); ?></span></span>
							
							<script type="text/javascript">
							function mindateop_change(dateop) {
								if (dateop == "fixed") {
									jQuery('#mindateopdays').hide();
									jQuery('#mindateopformat').show();
								} else {
									jQuery('#mindateopdays').show();
									jQuery('#mindateopformat').hide();
								}
							}
							</script>
						</td>
					</tr>
					<tr>
						<th><label for="wpcoField.maxdate"><?php _e('Max Date', $this -> plugin_name); ?></label></th>
						<td>
							<?php $maxdateop = $wpcoHtml -> field_value('wpcoField.maxdateop'); ?>
							<select onchange="maxdateop_change(this.value);" name="wpcoField[maxdateop]">
								<option <?php echo (!empty($maxdateop) && $maxdateop == "fixed") ? 'selected="selected"' : ''; ?> value="fixed"><?php _e('Fixed', $this -> plugin_name); ?></option>
								<option <?php echo (!empty($maxdateop) && $maxdateop == "pos") ? 'selected="selected"' : ''; ?> value="pos">+</option>
								<option <?php echo (!empty($maxdateop) && $maxdateop == "neg") ? 'selected="selected"' : ''; ?> value="neg">-</option>
							</select>
							<?php echo $wpcoForm -> text('wpcoField.maxdate', array('width' => "85px")); ?>
							<span style="display:<?php echo (empty($wpcoField -> data -> maxdateop) || $wpcoField -> data -> maxdateop != "fixed") ? 'inline' : 'none'; ?>;" id="maxdateopdays"><?php _e('days', $this -> plugin_name); ?><span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('Largest allowed date in days from the current date.', $this -> plugin_name); ?></span></span>
							<span style="display:<?php echo (!empty($wpcoField -> data -> maxdateop) && $wpcoField -> data -> maxdateop == "fixed") ? 'inline' : 'none'; ?>;" id="maxdateopformat" style="display:none;"><span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('Fixed date as the maximum in the format mm/dd/yyy eg. 12/31/2012', $this -> plugin_name); ?></span></span>
							
							<script type="text/javascript">
							function maxdateop_change(dateop) {
								if (dateop == "fixed") {
									jQuery('#maxdateopdays').hide();
									jQuery('#maxdateopformat').show();
								} else {
									jQuery('#maxdateopdays').show();
									jQuery('#maxdateopformat').hide();
								}
							}
							</script>
						</td>
					</tr>
					<tr>
						<th><label for=""><?php _e('Active Days', $this -> plugin_name); ?></label></th>
						<td>						
							<?php include $this -> plugin_base() . DS . 'includes' . DS . 'variables.php'; ?>
							<?php foreach ($daysoftheweek as $day_key => $day) : ?>
								<label><input <?php echo (!empty($wpcoField -> data -> activedays) && in_array($day_key, explode(",", $wpcoField -> data -> activedays))) ? 'checked="checked"' : ''; ?> type="checkbox" name="wpcoField[activedays][]" value="<?php echo $day_key; ?>" id="" /> <?php echo $day['full']; ?></label>
							<?php endforeach; ?>
							<span class="howto"><?php _e('Active days to allow on the calendar selection.', $this -> plugin_name); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="wpcoField.requiredN"><?php _e('Required', $this -> plugin_name); ?></label></th>
					<td>
						<?php $required = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('wpcoField.required', $required, array('onclick' => "change_required(this.value);", 'separator' => false, 'default' => "N")); ?>
						
						<script type="text/javascript">
						function change_required(required) {
							if (required == "Y") {
								jQuery("#<?php echo $this -> pre; ?>errordiv").show();
							} else {
								jQuery("#<?php echo $this -> pre; ?>errordiv").hide();
							}
						}
						</script>
                        
                        <span class="howto"><?php _e('Should this field be mandatory to customers to fill in?', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<?php $requiredstatus = $wpcoHtml -> field_value('wpcoField.required'); ?>
		<div id="<?php echo $this -> pre; ?>errordiv" style="display:<?php echo (!empty($requiredstatus) && $requiredstatus == "Y") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="wpcoField.error"><?php _e('Error Message', $this -> plugin_name); ?></label></th>
						<td>
							<?php echo $wpcoForm -> text('wpcoField.error'); ?>
							<span class="howto"><?php _e('message which will be shown to user when empty on submission', $this -> plugin_name); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="wpcoField.addpriceN"><?php _e('Add Price', $this -> plugin_name); ?></label></th>
					<td>
						<?php $addprice = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('wpcoField.addprice', $addprice, array('separator' => false, 'default' => "N", 'onclick' => "change_addprice(this.value);")); ?>
						
						<script type="text/javascript">
						function change_addprice(addprice) {
							jQuery('#pricediv').hide();
							
							if (addprice == "Y") {
								jQuery("#pricediv").show();
							}
						}
						</script>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="pricediv" style="display:<?php echo ($wpcoHtml -> field_value('wpcoField.addprice') == "Y") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="wpcoField.price"><?php _e('Price', $this -> plugin_name); ?></label></th>
						<td><?php echo $wpcoHtml -> currency_html($wpcoForm -> text('wpcoField.price', array('width' => "45px"))); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="globalf_N"><?php _e('Global Option', $this -> plugin_name); ?></label></th>
					<td>
						<?php $globalf = $wpcoHtml -> field_value('wpcoField.globalf'); ?>
						<label><input onclick="jQuery('#globalpdiv').show();" <?php echo (!empty($globalf) && $globalf == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="wpcoField[globalf]" value="Y" id="globalf_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
						<label><input onclick="jQuery('#globalpdiv').hide();" <?php echo ((!empty($globalf) && $globalf == "N") || empty($globalf)) ? 'checked="checked"' : ''; ?> type="radio" name="wpcoField[globalf]" value="N" id="globalf_N" /> <?php _e('No', $this -> plugin_name); ?></label>
						<span class="howto"><?php _e('A global custom field can be placed on the cart, shipping or billing step of checkout.', $this -> plugin_name); ?></span>
					</td>
				</tr>
            </tbody>
        </table>
        
        <div id="globalpdiv" style="display:<?php echo (!empty($globalf) && $globalf == "Y") ? 'block' : 'none'; ?>;">
        	<table class="form-table">
            	<tbody>
                	<tr>
                    	<th><label for="globalp"><?php _e('Global Position', $this -> plugin_name); ?></label></th>
                        <td>
                        	<?php global $globalpoptions; require_once $this -> plugin_base() . DS . 'includes' . DS . 'variables.php'; ?>
                            <?php echo $wpcoForm -> select('wpcoField.globalp', $globalpoptions); ?>
                        	<span class="howto"><?php _e('Should this global custom field show up on the cart, shipping or billing step of checkout?', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <table class="form-table">
        	<tbody>
				<tr>
					<th><?php _e('Add to Products', $this -> plugin_name); ?></th>
					<td>
						<?php /*
						<div id="addtoproductformfields" style="visibility:hidden;">
							<!-- Form fields here -->
							<?php if (!empty($wpcoField -> data -> products)) : ?>
								<?php foreach ($wpcoField -> data -> products as $product_id) : ?>
									<input type="hidden" name="wpcoField[products][]" value="<?php echo $product_id; ?>" />
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
						*/ ?>
								
						<input type="text" onkeyup="live_product_search(this.value); return false;" onkeydown="if (event.keyCode == 13) { live_product_search(this.value); return false; }" name="liveproductsearch" class="widefat" style="width:200px;" value="" id="liveproductsearch" onfocus="" />
						<input type="button" onclick="live_product_search(jQuery('#liveproductsearch').val()); return false;" name="search" value="<?php _e('Search Products', $this -> plugin_name); ?>" class="button button-secondary" />
						<span id="liveproductsearchloading" style="display:none;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" border="0" style="border:none;" alt="loading" /></span>
						
						<br class="<?php echo $this -> pre; ?>cleaner" />
						
						<div style="float:left; width:49%; max-height:400px; overflow:auto;" id="liveproductsearchresults">
							<!-- products search results -->
						</div>
						<div style="float:left; width:2%;"></div>
						<div style="float:left; width:49%; max-height:400px; overflow:auto;" id="addedproducts">
							<h3><?php _e('Current Products', $this -> plugin_name); ?></h3>
							<ul id="addedproductslist">
								<!-- added products -->
								<?php if (!empty($wpcoField -> data -> products)) : ?>
									<?php foreach ($wpcoField -> data -> products as $product_id) : ?>
										<?php $wpcoDb -> model = $Product -> model; ?>
										<?php if ($product = $wpcoDb -> find(array('id' => $product_id))) : ?>
											<li id="addedproducts<?php echo $product -> id; ?>">
												<a href="" onclick="if (confirm('<?php _e('Are you sure you want to remove this product?', $this -> plugin_name); ?>')) { jQuery('#addedproducts<?php echo $product -> id; ?>').remove(); } return false;"><img src="<?php echo $this -> url(); ?>/images/deny.png" alt="delete" /></a>
												<?php echo $wpcoHtml -> timthumb_image($product -> image_url, 50, 50, 100); ?>
												<?php echo apply_filters($this -> pre . '_product_title', $product -> title); ?>
												<input type="hidden" name="wpcoField[products][]" value="<?php echo $product -> id; ?>" />
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</ul>
						</div>
						
						<script type="text/javascript">
						var livesearchrequest = false;
						function live_product_search(term) {
							if (livesearchrequest) { livesearchrequest.abort(); }						
							jQuery('#liveproductsearchloading').show();
							livesearchrequest = jQuery.post(ajaxurl + '?action=wpcoliveproductsearch', {searchterm:term}, function(response) {
								jQuery('#liveproductsearchresults').html(response);
								jQuery('#liveproductsearchloading').hide();
							});
						}
						
						function live_product_add(product_id) {
							jQuery.post(wpcoajaxurl + '?action=wpcoliveproductadd', {product_id:product_id}, function(response) {
								jQuery('#addedproductslist').append(response);
								if (jQuery('#searchedproducts' + product_id)) { jQuery('#searchedproducts' + product_id).remove(); }
							});
						}
						</script>
					</td>
				</tr>
			</tbody>
		</table>
	
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save Field', $this -> plugin_name)); ?>
		</p>
	</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#tabs_title').tabs();
	jQuery('#liveproductsearch').Watermark('<?php _e('Search for products...', $this -> plugin_name); ?>');
});
</script>